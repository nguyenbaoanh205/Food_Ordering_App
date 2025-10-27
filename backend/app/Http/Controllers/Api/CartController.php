<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🧾 Lấy giỏ hàng của 1 user
    public function getCart($userId)
    {
        $cart = Cart::with('items.food')->where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json($cart);
    }

    // 🔼 Cập nhật số lượng sản phẩm
    public function updateQuantity(Request $request, $itemId)
    {
        $item = CartItem::find($itemId);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);

        $item->quantity = $request->quantity;
        $item->save();

        return response()->json(['message' => 'Quantity updated', 'item' => $item]);
    }

    // ❌ Xóa sản phẩm khỏi giỏ
    public function removeItem($itemId)
    {
        $item = CartItem::find($itemId);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);

        $item->delete();

        return response()->json(['message' => 'Item removed']);
    }
}
