<?php

namespace App\Console\Commands;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCompleteOrders extends Command
{
    protected $signature = 'orders:auto-complete';
    protected $description = 'Tự động chuyển đơn hàng từ delivered sang completed sau 1 ngày';

    public function handle()
    {
        $orders = Order::where('status', 'delivered')
            ->where('updated_at', '<', Carbon::now()->subMinute())
            ->get();

        foreach ($orders as $order) {
            $order->update(['status' => 'completed']);
            event(new OrderStatusUpdated($order));
        }

        $this->info("✅ Đã cập nhật {$orders->count()} đơn hàng sang completed");
    }
}
