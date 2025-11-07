<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'nullable|in:0,1', // 0: user, 1: admin
        ]);

        // Mã hóa mật khẩu
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $validated['role'] ?? 0; // Mặc định là user

        // Tạo user
        $user = User::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Đăng ký thành công, vui lòng đăng nhập để tiếp tục.',
            'user'    => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email hoặc mật khẩu không chính xác.'],
            ]);
        }

        // ✅ Xóa token cũ (nếu muốn chỉ 1 phiên đăng nhập)
        $user->tokens()->delete();

        // ✅ Tạo token mới
        $token = $user->createToken('auth_token')->plainTextToken;

        // ✅ Lấy token vừa tạo (để cập nhật thời gian hết hạn)
        $personalToken = $user->tokens()->latest()->first();
        $personalToken->expires_at = now()->addHours(2); // token sống 2 tiếng
        $personalToken->save();

        // ✅ Kiểm tra vai trò để điều hướng
        $redirect = $user->role == 1 ? 'admin' : 'client';

        return response()->json([
            'status'   => true,
            'message'  => 'Đăng nhập thành công',
            'user'     => $user,
            'token'    => $token,
            'expires_at' => $personalToken->expires_at->toDateTimeString(), // Gửi thời gian hết hạn về FE
            'redirect' => $redirect,
        ], 200);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Đăng xuất thành công',
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'user'   => $request->user(),
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $validated['name'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'user' => $user,
        ]);
    }
}
