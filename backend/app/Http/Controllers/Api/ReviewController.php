<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Review::query()->with(['user', 'food']);
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'food_id' => 'required|exists:foods,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($validated);
        return response()->json(['message' => 'Review created', 'data' => $review->load(['user', 'food'])], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::with(['user', 'food'])->find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json(['data' => $review], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $review->update($validated);
        return response()->json(['message' => 'Review updated', 'data' => $review->load(['user', 'food'])], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        $review->delete();
        return response()->json(['message' => 'Review deleted'], 200);
    }
}
