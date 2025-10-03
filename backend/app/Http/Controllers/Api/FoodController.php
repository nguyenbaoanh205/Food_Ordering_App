<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $food;

    public function __construct()
    {
        $this->food = new Food();
    }
    public function index(Request $request)
    {
        // phân trang 5 bản ghi / trang, có kèm category
        $foods = $this->food->with('category')->paginate(5);

        return response()->json($foods, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $food = $this->food->create($validated);

        // load category để Vue dùng ngay
        $food->load('category');

        return response()->json([
            'message' => 'Thực phẩm đã được tạo thành công!',
            'data'    => $food
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $food =  $this->food->with('category')->find($id);
        if ($food) {
            return response()->json(['data' => $food], 200);
        } else {
            return response()->json(['message' => 'Thực phẩm không tồn tại!'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $food = $this->food->find($id);
        if (!$food) {
            return response()->json(['message' => 'Thực phẩm không tồn tại!'], 404);
        }
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $food->update($validated);
        // load category để frontend dùng luôn
        $food->load('category');

        return response()->json([
            'message' => 'Thực phẩm được cập nhật thành công!',
            'data'    => $food
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food = $this->food->findOrFail($id);
        $food->delete();

        return response()->json([
            'message' => 'Thực phẩm đã được xóa thành công!'
        ]);
    }
}
