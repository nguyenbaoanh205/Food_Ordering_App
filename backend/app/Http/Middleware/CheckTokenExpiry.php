<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Không xác thực.'], 401);
        }

        $token = $user->currentAccessToken();

        if (!$token) {
            return response()->json(['message' => 'Token không hợp lệ.'], 401);
        }

        // ✅ Kiểm tra hết hạn
        if ($token->expires_at && now()->greaterThan($token->expires_at)) {
            $token->delete();
            return response()->json(['message' => 'Phiên đăng nhập đã hết hạn.'], 401);
        }

        // ✅ Nếu còn hạn, gia hạn thêm 2 tiếng (sliding session)
        $token->expires_at = now()->addHours(2);
        $token->save();

        return $next($request);
    }
}
