<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['order_id' => 'required|exists:orders,id']);
        $details = OrderDetail::with('food')
            ->where('order_id', $request->order_id)
            ->get();
        return response()->json(['data' => $details], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $order = Order::findOrFail($validated['order_id']);
            $food = Food::findOrFail($validated['food_id']);

            $detail = OrderDetail::create([
                'order_id' => $order->id,
                'food_id' => $food->id,
                'quantity' => $validated['quantity'],
                'price' => $food->price,
            ]);

            $increment = $food->price * $validated['quantity'];
            $order->update(['total' => $order->total + $increment]);

            return response()->json(['message' => 'Item added', 'data' => $detail->load('food')], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = OrderDetail::with('food')->find($id);
        if (!$detail) {
            return response()->json(['message' => 'Order detail not found'], 404);
        }
        return response()->json(['data' => $detail], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $detail = OrderDetail::find($id);
        if (!$detail) {
            return response()->json(['message' => 'Order detail not found'], 404);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($detail, $validated) {
            $order = Order::findOrFail($detail->order_id);
            $oldTotal = $order->total;
            $oldLine = $detail->price * $detail->quantity;

            $detail->update(['quantity' => $validated['quantity']]);

            $newLine = $detail->price * $detail->quantity;
            $order->update(['total' => $oldTotal - $oldLine + $newLine]);

            return response()->json(['message' => 'Item updated', 'data' => $detail->load('food')], 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = OrderDetail::find($id);
        if (!$detail) {
            return response()->json(['message' => 'Order detail not found'], 404);
        }

        return DB::transaction(function () use ($detail) {
            $order = Order::findOrFail($detail->order_id);
            $decrement = $detail->price * $detail->quantity;
            $detail->delete();
            $order->update(['total' => max(0, $order->total - $decrement)]);
            return response()->json(['message' => 'Item removed'], 200);
        });
    }
}
