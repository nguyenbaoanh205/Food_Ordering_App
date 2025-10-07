<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with(['user','details.food', 'history'])
            ->orderByDesc('id')
            ->paginate(10);
        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'nullable|in:cash,credit_card,paypal,momo,stripe',
            'items' => 'required|array|min:1',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $total = 0;
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'total' => 0,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'] ?? 'cash',
                'payment_status' => 'unpaid',
            ]);

            foreach ($validated['items'] as $item) {
                $food = Food::findOrFail($item['food_id']);
                $lineTotal = $food->price * $item['quantity'];
                $total += $lineTotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'price' => $food->price,
                ]);
            }

            $order->update(['total' => $total]);

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'note' => 'Order created',
            ]);

            $order->load(['details.food', 'history']);
            return response()->json(['message' => 'Order created', 'data' => $order], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user','details.food', 'history'])->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json(['data' => $order], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,refunded',
            'payment_method' => 'nullable|in:cash,credit_card,paypal,momo,stripe',
        ]);

        $order->update($validated);

        if (isset($validated['status'])) {
            OrderHistory::create([
                'order_id' => $order->id,
                'status' => $validated['status'],
                'note' => 'Status updated',
            ]);
        }

        $order->load(['details.food', 'history']);
        return response()->json(['message' => 'Order updated', 'data' => $order], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted'], 200);
    }

    public function stats()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $customers = Order::distinct('user_id')->count('user_id');

        return response()->json([
            'total_orders' => (int) $totalOrders,
            'total_revenue' => (float) $totalRevenue,
            'customers' => (int) $customers,
        ], 200);
    }
}
