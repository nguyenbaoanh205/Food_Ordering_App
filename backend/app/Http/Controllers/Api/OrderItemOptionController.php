<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItemOption;
use Illuminate\Http\Request;

class OrderItemOptionController extends Controller
{
    // 🔹 Lấy danh sách tùy chọn của món trong đơn hàng
    public function index($orderDetailId)
    {
        $options = OrderItemOption::with('option:id,name,extra_price,type')
            ->where('order_detail_id', $orderDetailId)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $options
        ], 200);
    }
}
