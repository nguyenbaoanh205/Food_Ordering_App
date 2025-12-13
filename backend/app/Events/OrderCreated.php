<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;

class OrderCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Tạo event với dữ liệu đơn hàng
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        Log::info('🔥 OrderCreated event fired for order ID: ' . $order->id);
    }

    /**
     * Kênh phát (broadcast)
     */
    public function broadcastOn()
    {
        // public channel (ai cũng nghe được)
        return new Channel('orders');
    }

    /**
     * Tên event khi phát sang frontend
     */
    public function broadcastAs()
    {
        return 'order.created';
    }

    /**
     * Dữ liệu gửi đi
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'total' => $this->order->total,
            'status' => $this->order->status,
            'receiver_name' => $this->order->receiver_name,
            'created_at' => $this->order->created_at->toDateTimeString(),
        ];
    }
}
