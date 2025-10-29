<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodOption;
use Illuminate\Http\Request;

class FoodOptionController extends Controller
{
    // 🔹 Lấy danh sách tất cả tùy chọn (có thể lọc theo món ăn)
    public function index(Request $request)
    {
        $query = FoodOption::query()->with('food:id,name');

        if ($request->has('food_id')) {
            $query->where('food_id', $request->food_id);
        }

        return response()->json([
            'status' => true,
            'data' => $query->orderBy('food_id')->get()
        ], 200);
    }

    // 🔹 Tạo mới tùy chọn món ăn
    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_id' => 'required|exists:foods,id',
            'name' => 'required|string|max:100',
            'extra_price' => 'nullable|numeric|min:0',
            'type' => 'required|in:size,topping',
        ]);

        $option = FoodOption::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Tạo tùy chọn món ăn thành công!',
            'data' => $option
        ], 201);
    }

    // 🔹 Xem chi tiết 1 option
    public function show($id)
    {
        $option = FoodOption::with('food:id,name')->find($id);

        if (!$option) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy tùy chọn.'], 404);
        }

        return response()->json(['status' => true, 'data' => $option]);
    }

    // 🔹 Cập nhật option
    public function update(Request $request, $id)
    {
        $option = FoodOption::find($id);
        if (!$option) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy tùy chọn.'], 404);
        }

        $validated = $request->validate([
            'food_id' => 'sometimes|exists:foods,id',
            'name' => 'sometimes|string|max:100',
            'extra_price' => 'nullable|numeric|min:0',
            'type' => 'sometimes|in:size,topping',
        ]);

        $option->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công!',
            'data' => $option
        ], 200);
    }

    // 🔹 Xóa option
    public function destroy($id)
    {
        $option = FoodOption::find($id);

        if (!$option) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy tùy chọn.'], 404);
        }

        $option->delete();

        return response()->json(['status' => true, 'message' => 'Đã xóa tùy chọn món ăn.']);
    }
}
