<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Nếu chưa đăng nhập
        if (!$user) {
            return response()->json(['message' => 'Bạn cần đăng nhập.'], 401);
        }

        // Nếu không phải admin
        if ($user->role !== 1) {
            return response()->json(['message' => 'Không có quyền truy cập.'], 403);
        }

        // Nếu là admin nhưng không ở trong khu vực /admin → chặn
        if (!$request->is('admin/*')) {
            return response()->json(['message' => 'Admin không được truy cập khu vực khách hàng.'], 403);
        }

        // Nếu hợp lệ
        return $next($request);
    }
}
