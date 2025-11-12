<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryClientController extends Controller
{
    /**
     * Lấy danh sách tất cả đơn hàng của user hiện tại
     */
    public function index(Request $request)
    {
        $user = $request->user(); // user từ token
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Lấy đơn hàng kèm chi tiết món, options, lịch sử
        $orders = Order::with([
            'user',
            'details.food',
            'details.options.option',
            'history',
            'reviews' // thêm relation reviews
        ])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Gắn thông tin reviewed cho từng món
        $orders->each(function ($order) use ($user) {
            $order->details->each(function ($item) use ($user, $order) {
                $item->reviewed = $order->reviews()
                    ->where('user_id', $user->id)
                    ->where('food_id', $item->food_id)
                    ->exists();
            });
        });

        return response()->json([
            'status' => true,
            'data' => $orders
        ], 200);
    }


    /**
     * Lấy chi tiết 1 đơn hàng của user hiện tại
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $order = Order::with(['details.food', 'details.options.option', 'history'])
            ->where('user_id', $user->id)
            ->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $order
        ], 200);
    }
}
