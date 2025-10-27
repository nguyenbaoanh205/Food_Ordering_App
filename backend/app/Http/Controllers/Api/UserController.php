<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * 📜 Lấy danh sách người dùng (có tìm kiếm, phân trang)
     */
    public function index(Request $request)
    {
        $query = $this->user->newQuery();

        // tìm kiếm theo tên hoặc email
        $search = $request->query('q');
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        // phân trang
        $perPage = (int) $request->query('per_page', 10);
        $users = $query->paginate($perPage);

        return response()->json($users, 200);
    }

    /**
     * ➕ Tạo người dùng mới (đăng ký)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'in:0,1'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = $this->user->create($validated);

        return response()->json(["data" => $user], 201);
    }

    /**
     * 👁️ Xem chi tiết người dùng
     */
    public function show(string $id)
    {
        $user = $this->user->findOrFail($id);
        return response()->json(["data" => $user], 200);
    }

    /**
     * 🧩 Cập nhật thông tin người dùng
     */
    public function update(Request $request, string $id)
    {
        $user = $this->user->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
            'role' => 'sometimes|in:0,1'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json(["data" => $user], 200);
    }

    /**
     * 🗑️ Xóa người dùng
     */
    public function destroy(string $id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
        return response()->json(["message" => "User deleted successfully"], 200);
    }

    public function profile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}
