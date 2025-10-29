<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItemOption;
use Illuminate\Http\Request;

class CartItemOptionController extends Controller
{
    // 🔹 Lấy tùy chọn trong 1 cart item cụ thể
    public function index($cartItemId)
    {
        $options = CartItemOption::with('option:id,name,extra_price,type')
            ->where('cart_item_id', $cartItemId)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $options
        ], 200);
    }
}
