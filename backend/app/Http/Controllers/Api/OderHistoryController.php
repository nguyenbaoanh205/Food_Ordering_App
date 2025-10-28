<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

class OderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderHistory::query();

        // Search theo status hoặc note (tùy chọn)
        $search = $request->query('q');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%");
            });
        }

        // Phân trang, mặc định 10 bản ghi / trang
        $perPage = (int) $request->query('per_page', 10);
        $histories = $query->orderByDesc('id')->paginate($perPage);

        return response()->json([
            'data' => $histories->items(),
            'current_page' => $histories->currentPage(),
            'last_page' => $histories->lastPage(),
            'per_page' => $histories->perPage(),
            'total' => $histories->total(),
        ], 200);
    }


    public function show($id)
    {
        $history = OrderHistory::find($id);

        if (!$history) {
            return response()->json(['message' => 'History not found'], 404);
        }

        return response()->json(['data' => $history], 200);
    }
}
