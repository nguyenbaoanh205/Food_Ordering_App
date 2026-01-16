<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'food']);

        if ($request->has('q') && !empty($request->q)) {
            $q = $request->q;
            $query->where('comment', 'like', "%$q%")
                ->orWhereHas('user', function ($userQuery) use ($q) {
                    $userQuery->where('name', 'like', "%$q%");
                });
        }

        if ($request->has('food_id')) {
            $request->validate(['food_id' => 'integer|exists:foods,id']);
            $query->where('food_id', $request->food_id);
        }

        if ($request->has('user_id')) {
            $request->validate(['user_id' => 'integer|exists:users,id']);
            $query->where('user_id', $request->user_id);
        }

        $reviews = $query->orderByDesc('id')->paginate(10);

        return response()->json($reviews, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'food_id' => 'required|exists:foods,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $exists = Review::where('user_id', $validated['user_id'])
            ->where('order_id', $validated['order_id'])
            ->where('food_id', $validated['food_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Bạn đã đánh giá món này rồi!'], 400);
        }

        $review = Review::create($validated);

        return response()->json([
            'message' => 'Đánh giá thành công!',
            'data' => $review
        ], 201);
    }
}
