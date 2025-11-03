<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    protected $food;

    public function __construct()
    {
        $this->food = new Food();
    }
    public function index(Request $request)
    {
        // List foods with category, support search and pagination
        $query = $this->food->with(['category', 'options']);

        // 🔍 Tìm kiếm theo tên, mô tả, hoặc tên danh mục
        $search = $request->query('q');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        // 🔹 Lọc theo danh mục (tab menu trong Vue)
        $category = $request->query('category');
        if (!empty($category) && strtolower($category) !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($category)]);
            });
        }

        // 🔸 Phân trang
        $perPage = (int) $request->query('per_page', 15);
        $foods = $query->inRandomOrder()->paginate($perPage);

        return response()->json($foods, 200);
    }
}
