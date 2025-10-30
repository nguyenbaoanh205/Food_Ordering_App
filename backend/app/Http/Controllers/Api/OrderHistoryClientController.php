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

        // Lấy đơn hàng kèm chi tiết món và options
        $orders = Order::with([
            'user',
            'details.food',
            'details.options.option',
            'history' // lấy ghi chú từ lịch sử nếu cần
        ])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

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
