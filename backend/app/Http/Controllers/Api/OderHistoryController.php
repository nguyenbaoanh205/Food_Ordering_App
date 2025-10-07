<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

class OderHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['order_id' => 'required|exists:orders,id']);
        $history = OrderHistory::where('order_id', $request->order_id)
            ->orderBy('id')
            ->get();
        return response()->json(['data' => $history], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'note' => 'nullable|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);
        $history = OrderHistory::create($validated);
        $order->update(['status' => $validated['status']]);

        return response()->json(['message' => 'History added', 'data' => $history], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $history = OrderHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'History not found'], 404);
        }
        return response()->json(['data' => $history], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $history = OrderHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'History not found'], 404);
        }
        $validated = $request->validate([
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'note' => 'nullable|string',
        ]);
        $history->update($validated);
        if (isset($validated['status'])) {
            Order::where('id', $history->order_id)->update(['status' => $validated['status']]);
        }
        return response()->json(['message' => 'History updated', 'data' => $history], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $history = OrderHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'History not found'], 404);
        }
        $history->delete();
        return response()->json(['message' => 'History deleted'], 200);
    }
}
