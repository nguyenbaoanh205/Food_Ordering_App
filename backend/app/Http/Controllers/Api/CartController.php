<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemOption;
use App\Models\Food;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🧾 Lấy giỏ hàng của 1 user
    public function getCart($userId)
    {
        $cart = Cart::with(['items.food', 'items.options.option'])->where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json($cart);
    }

    // ➕ Thêm sản phẩm vào giỏ
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'size_option_id' => 'nullable|exists:food_options,id,type,size', // Xác thực size_option_id
            'topping_option_ids' => 'array',
            'topping_option_ids.*' => 'exists:food_options,id,type,topping', // Xác thực topping_option_ids
        ]);


        // 🛒 1️⃣ Lấy hoặc tạo giỏ hàng cho user
        $cart = Cart::firstOrCreate(['user_id' => $request->user_id]);

        // 🔍 2️⃣ Kiểm tra nếu món ăn đã có trong giỏ (cùng food_id và cùng price)
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('food_id', $request->food_id)
            ->where('price', $request->price)
            ->first();

        if ($cartItem) {
            // ✅ Nếu có rồi → cộng thêm số lượng
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // 🆕 Nếu chưa có → tạo item mới
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'food_id' => $request->food_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        }

        // 🔗 3️⃣ Lưu SIZE (nếu có)
        if ($request->filled('size_option_id')) {
            CartItemOption::firstOrCreate([
                'cart_item_id' => $cartItem->id,
                'option_id' => $request->size_option_id
            ]);
        }

        // 🔗 3️⃣ Lưu topping (nếu có)
        if ($request->filled('topping_option_ids')) {
            foreach ($request->topping_option_ids as $optionId) {
                CartItemOption::firstOrCreate([
                    'cart_item_id' => $cartItem->id,
                    'option_id' => $optionId
                ]);
            }
        }

        // ✅ 4️⃣ Trả về response
        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart_item' => $cartItem->load('food', 'options')
        ], 201);
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

    public function clear(Request $request)
    {
        $user = $request->user(); // phải tồn tại

        if (!$user || !$user->cart) {
            return response()->json(['message' => 'No cart found'], 404);
        }

        $user->cart->items()->delete();

        return response()->json(['message' => 'Cart cleared']);
    }
}
