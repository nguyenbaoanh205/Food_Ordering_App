<?php

namespace App\Http\Controllers\Api\Admin;

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
        // List foods with category, support search and pagination
        $query = $this->food->with(['category', 'options']);

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

        $perPage = (int) $request->query('per_page', 10);
        $foods = $query->orderByDesc('id')->paginate($perPage);

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
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '-' . $image->getClientOriginalName();

            $image->move(public_path('foods'), $imageName);

            $validated['image'] = 'foods/' . $imageName;
        }

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
        $food = Food::with(['category', 'options'])->find($id);
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
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {

            $oldImage = $food->getRawOriginal('image'); // lấy path gốc
            if ($oldImage && file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }

            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = 'foods/' . $fileName;

            $file->move(public_path('foods'), $fileName);

            $validated['image'] = $path;
        }

        $food->update($validated);
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

        // Lấy path gốc của image (foods/xyz.jpg)
        $imagePath = $food->getRawOriginal('image');

        // Xóa file nếu tồn tại
        if ($imagePath && file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }

        // Xóa record trong DB
        $food->delete();

        return response()->json([
            'message' => 'Thực phẩm đã được xóa thành công!'
        ]);
    }
}
