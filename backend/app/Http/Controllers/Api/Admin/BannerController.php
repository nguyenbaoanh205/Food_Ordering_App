<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query cơ bản
        $query = Banner::query();

        // 🔍 Tìm kiếm theo title (hoặc mô tả)
        $search = $request->query('q');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 📦 Lọc theo trạng thái nếu có (status = true/false)
        if ($request->has('status')) {
            $status = filter_var($request->query('status'));
            if (!is_null($status)) {
                $query->where('status', $status);
            }
        }

        // 📄 Phân trang
        $perPage = (int) $request->query('per_page', 10);
        $banners = $query->orderBy('id', 'desc')->paginate($perPage);

        return response()->json($banners, 200);
    }

    // 💾 Thêm mới banner (nếu cần trong admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $banner = Banner::create($validated);
        return response()->json($banner, 201);
    }

    public function show(Banner $id)
    {
        return response()->json($id, 200);
    }
    // ✏️ Cập nhật banner
    public function update(Request $request, Banner $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $id->update($validated);
        return response()->json($id);
    }

    // 🗑️ Xóa banner
    public function destroy(Banner $id)
    {
        $id->delete();
        return response()->json(['message' => 'Banner deleted']);
    }
}
