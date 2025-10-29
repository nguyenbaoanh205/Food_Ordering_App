<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Lấy danh sách review từ DB (kèm user, food)
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'food']);

        // 🔍 Nếu có keyword (tìm theo comment hoặc tên user)
        if ($request->has('q') && !empty($request->q)) {
            $q = $request->q;
            $query->where('comment', 'like', "%$q%")
                ->orWhereHas('user', function ($userQuery) use ($q) {
                    $userQuery->where('name', 'like', "%$q%");
                });
        }

        // 🧩 Nếu có lọc theo food_id (danh sách review của món ăn cụ thể)
        if ($request->has('food_id')) {
            $request->validate(['food_id' => 'integer|exists:foods,id']);
            $query->where('food_id', $request->food_id);
        }

        // 🧩 Nếu có lọc theo user_id (danh sách review của người dùng cụ thể)
        if ($request->has('user_id')) {
            $request->validate(['user_id' => 'integer|exists:users,id']);
            $query->where('user_id', $request->user_id);
        }

        // 📊 Lấy dữ liệu có phân trang
        $reviews = $query->orderByDesc('id')->paginate(10);

        return response()->json($reviews, 200);
    }
}
