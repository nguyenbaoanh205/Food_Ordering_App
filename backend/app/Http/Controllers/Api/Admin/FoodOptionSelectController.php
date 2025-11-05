<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodOptionSelectController extends Controller
{
    public function index()
    {
        $foods = Food::orderBy('name')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $foods
        ], 200);
    }
}
