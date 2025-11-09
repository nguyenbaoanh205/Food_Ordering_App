<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\OrderItemOption;
use Illuminate\Support\Facades\DB;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string|max:255',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Tạo tổng tiền
        $total = collect($request->items)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Tạo order tạm (trạng thái confirmed)
        $order = DB::transaction(function () use ($request, $total) {
            $order = Order::create([
                'user_id' => $request->user_id,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'receiver_address' => $request->receiver_address,
                'note' => $request->note ?? '',
                'total' => $total,
                'status' => 'confirmed',
                'payment_method' => 'stripe',
                'payment_status' => 'paid',
            ]);

            foreach ($request->items as $item) {
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Lưu options nếu có
                if (!empty($item['options'])) {
                    foreach ($item['options'] as $opt) {
                        OrderItemOption::create([
                            'order_detail_id' => $orderDetail->id,
                            'option_id' => $opt['option_id'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => 'confirmed',
                'note' => 'Order created before Stripe payment',
            ]);

            return $order;
        });

        // Tạo Stripe Checkout Session
        $line_items = array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => intval($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }, $request->items);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/order-histories?success=true&order_id=' . $order->id,
            'cancel_url' => env('APP_URL') . '/checkout?order_id=' . $order->id . '&canceled=true',
            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        return response()->json(['url' => $session->url]);
    }

    // Webhook Stripe (tuỳ chọn)
    // public function handleWebhook(Request $request)
    // {   
    //     Nếu có webhook secret
    //     $payload = $request->getContent();
    //     $sigHeader = $request->header('Stripe-Signature');
    //     $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, env('STRIPE_WEBHOOK_SECRET'));

    //     Khi checkout.session.completed
    //     $session = $event->data->object;
    //     Cập nhật order payment_status = paid
    // }
}
