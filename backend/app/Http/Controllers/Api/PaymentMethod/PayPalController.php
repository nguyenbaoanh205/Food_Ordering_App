<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\OrderItemOption;
use Illuminate\Support\Facades\DB;

class PayPalController extends Controller
{
    private $client;

    public function __construct()
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');

        $environment = config('services.paypal.mode') === 'live'
            ? new ProductionEnvironment($clientId, $clientSecret)
            : new SandboxEnvironment($clientId, $clientSecret);

        $this->client = new PayPalHttpClient($environment);
    }

    // ✅ 1. Tạo đơn thanh toán
    public function createPayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'total' => 'required|numeric',
            'currency' => 'nullable|string',
        ]);

        $orderRequest = new OrdersCreateRequest();
        $orderRequest->prefer('return=representation');

        $orderRequest->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $request->currency ?? 'USD',
                    'value' => number_format($request->total, 2, '.', ''),
                ],
                'description' => 'Thanh toán đơn hàng Food Ordering App',
            ]],
            'application_context' => [
                'return_url' => env('PAYPAL_RETURN_URL'),
                'cancel_url' => env('PAYPAL_CANCEL_URL'),
                'brand_name' => 'Food Ordering App',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW'
            ],
        ];

        try {
            $response = $this->client->execute($orderRequest);

            $approvalUrl = collect($response->result->links)
                ->firstWhere('rel', 'approve')->href ?? null;

            return response()->json([
                'id' => $response->result->id,
                'status' => $response->result->status,
                'approval_url' => $approvalUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ 2. Capture thanh toán (gọi khi người dùng quay lại từ PayPal success)
    public function capturePayment(Request $request)
    {
        $request->validate([
            'token' => 'required', // orderID từ PayPal redirect
            'user_id' => 'required',
        ]);

        try {
            $captureRequest = new OrdersCaptureRequest($request->token);
            $captureRequest->prefer('return=representation');
            $response = $this->client->execute($captureRequest);

            // PayPal trả về trạng thái in hoa, convert xuống thường
            if (strtolower($response->result->status) === 'completed') {
                $order = DB::transaction(function () use ($request) {
                    $order = Order::create([
                        'user_id' => $request->user_id,
                        'receiver_name' => $request->receiver_name ?? '',
                        'receiver_phone' => $request->receiver_phone ?? '',
                        'receiver_address' => $request->receiver_address ?? '',
                        'note' => $request->note ?? '',
                        'total' => $request->total,
                        'payment_method' => 'paypal',
                        'payment_status' => 'paid',       // chữ thường
                        'status' => 'confirmed',          // chữ thường
                    ]);

                    foreach ($request->items as $item) {
                        $orderDetail = OrderDetail::create([
                            'order_id' => $order->id,
                            'food_id' => $item['food_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);

                        if (!empty($item['options'])) {
                            foreach ($item['options'] as $option) {
                                OrderItemOption::create([
                                    'order_detail_id' => $orderDetail->id,
                                    'option_id' => $option['option_id'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }

                    OrderHistory::create([
                        'order_id' => $order->id,
                        'status' => 'confirmed',            // chữ thường
                        'note' => 'Thanh toán PayPal thành công',
                    ]);

                    return $order;
                });

                return response()->json([
                    'message' => 'Thanh toán PayPal thành công',
                    'status' => 'completed'               // chữ thường
                ]);
            }

            return response()->json(['message' => 'Thanh toán thất bại', 'status' => 'failed']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
