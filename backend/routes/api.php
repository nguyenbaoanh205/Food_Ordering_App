<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/foods', function () {
    return [
        ['id' => 1, 'name' => 'Pizza', 'price' => 120000],
        ['id' => 2, 'name' => 'Burger', 'price' => 60000],
        ['id' => 3, 'name' => 'Trà sữa', 'price' => 45000],
    ];
});