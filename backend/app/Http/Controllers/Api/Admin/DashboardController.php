<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail; // cần thêm nếu bạn có model này
use App\Models\User;
use App\Models\Food; // model món ăn
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function statistics()
    {
        // Tổng quan
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');
        $totalUsers = User::count();

        // Doanh thu 6 tháng gần nhất
        $revenueByMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Đơn hàng theo trạng thái
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        // 🥇 Món ăn bán chạy nhất (top 5)
        $topFoods = DB::table('order_details')
            ->join('foods', 'order_details.food_id', '=', 'foods.id')
            ->select('foods.name', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->groupBy('foods.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return response()->json([
            'orders' => $totalOrders,
            'revenue' => $totalRevenue,
            'users' => $totalUsers,
            'revenueByMonth' => $revenueByMonth,
            'ordersByStatus' => $ordersByStatus,
            'topFoods' => $topFoods, // ✅ Thêm dữ liệu món ăn bán chạy
        ]);
    }
}
