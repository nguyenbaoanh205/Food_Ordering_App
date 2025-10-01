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
    public function index()
    {
        return $this->food->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $food = $this->food->create($request->all());
        return response()->json([
            'message' => 'Thực phẩm đã được tạo thành công!',
            'data' => $food
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $food = $this->food->find($id);
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
        if ($food) {
            $food->update($request->all());
            return response()->json(['message' => 'Thực phẩm được cập nhật thanh cong!', $food], 200);
        } else {
            return response()->json(['message' => 'Thực phẩm không tồn tại!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food = $this->food->find($id);
        if ($food) {
            $this->food->destroy($id);
            return response()->json(['message' => 'Thực phẩm đã được xóa thành công!']);
        } else {
            return response()->json(['message' => 'Thực phẩm không tồn tại!'], 404);
        }
    }
}
