<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Dùng Now cho realtime ngay lập tức
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // ✅ Channel riêng cho mỗi user
    public function broadcastOn()
    {
        return new Channel('user.'.$this->order->user_id);
    }

    // ✅ Tên event trên frontend
    public function broadcastAs()
    {
        return 'order.status.updated';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'status' => $this->order->status,
            'total' => $this->order->total,
            'receiver_name' => $this->order->receiver_name,
            'updated_at' => $this->order->updated_at->toDateTimeString(),
        ];
    }
}
