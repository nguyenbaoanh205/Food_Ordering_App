<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'details.food', 'details.options.option', 'history']);

        // 🔍 Lấy từ khóa tìm kiếm
        $search = $request->query('q');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // Tìm theo mã đơn hàng (ID)
                $q->where('id', 'like', "%{$search}%")
                    // Hoặc theo tên người dùng (quan hệ user)
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 📄 Phân trang, mặc định 15 đơn / trang
        $perPage = (int) $request->query('per_page', 15);
        $orders = $query->orderByDesc('id')->paginate($perPage);

        // ✅ Trả về dữ liệu JSON
        return response()->json([
            'data' => $orders->items(),
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total(),
        ], 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'nullable|in:cash,credit_card,paypal,momo,stripe',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string|max:255',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.options' => 'array'
        ]);

        $order = DB::transaction(function () use ($validated) {
            $total = 0;

            // 🧾 Tạo đơn hàng
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'receiver_name' => $validated['receiver_name'],
                'receiver_phone' => $validated['receiver_phone'],
                'receiver_address' => $validated['receiver_address'],
                'note' => $validated['note'] ?? '',
                'total' => 0,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'] ?? 'cash',
                'payment_status' => 'unpaid',
            ]);

            // 🧩 Tạo chi tiết đơn hàng
            foreach ($validated['items'] as $item) {
                $lineTotal = $item['price'] * $item['quantity'];
                $total += $lineTotal;

                $detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id' => $item['food_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Nếu có tùy chọn (size/topping)
                if (!empty($item['options'])) {
                    foreach ($item['options'] as $opt) {
                        DB::table('order_item_options')->insert([
                            'order_detail_id' => $detail->id,
                            'option_id' => $opt['option_id'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // 🧮 Cập nhật tổng tiền
            $order->update(['total' => $total]);

            // 🕒 Lưu lịch sử đơn hàng
            OrderHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'note' => 'Order created',
            ]);

            // 🧹 Xóa giỏ hàng
            Cart::where('user_id', $validated['user_id'])->delete();

            return $order->load(['details.food', 'history']);
        });

        // 🔔 Gửi event realtime tới admin
        // Log::info('🎯 About to broadcast order: ' . $order->id);
        event(new OrderCreated($order));

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }


    public function show(string $id)
    {
        $order = Order::with(['user', 'details.food', 'details.options.option', 'history'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order], 200);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::with(['user', 'details.food', 'details.options.option', 'history'])->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'nullable|in:pending,confirmed,preparing,shipping,delivered,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,refunded',
            'payment_method' => 'nullable|in:cash,credit_card,paypal,momo,stripe',
        ]);


        if (isset($validated['status'])) {
            $validTransitions = [
                'pending'   => ['confirmed', 'cancelled'],
                'confirmed' => ['preparing', 'cancelled'],
                'preparing' => ['shipping', 'cancelled'],
                'shipping'  => ['delivered', 'cancelled'],
                'delivered' => ['completed'], // auto hoặc admin kích hoạt
                'completed' => [],
                'cancelled' => [],
            ];

            $current = $order->status;
            $newStatus = $validated['status'];

            if (!in_array($newStatus, $validTransitions[$current] ?? [])) {
                return response()->json([
                    'message' => "Không thể chuyển trạng thái từ '$current' sang '$newStatus'."
                ], 400);
            }

            // Tạo lịch sử trạng thái
            OrderHistory::create([
                'order_id' => $order->id,
                'status'   => $newStatus,
                'note'     => "Trạng thái đơn hàng thay đổi từ $current → $newStatus",
            ]);

            // if ($newStatus === 'delivered') {
            //     // Tự động chuyển completed (ví dụ sau 60s)
            //     dispatch(function () use ($order) {
            //         sleep(20); // có thể đổi thành phút nếu cần
            //         if ($order->fresh()->status === 'delivered') {
            //             $order->update(['status' => 'completed']);

            //             OrderHistory::create([
            //                 'order_id' => $order->id,
            //                 'status'   => 'completed',
            //                 'note'     => 'Tự động hoàn tất đơn hàng sau khi giao xong.',
            //             ]);

            //             // Có thể bắn event realtime nếu cần
            //             event(new OrderStatusUpdated($order->fresh()));
            //         }
            //     });
            // }
        }

        $order->update($validated);

        // 🛰️ Bắn event realtime cho client
        event(new OrderStatusUpdated($order));

        return response()->json([
            'message' => 'Order updated',
            'data' => $order->load(['details.food', 'history'])
        ], 200);
    }
}
