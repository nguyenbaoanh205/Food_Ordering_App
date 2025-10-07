<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FoodController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\OderController;
use App\Http\Controllers\Api\OderDetailController;
use App\Http\Controllers\Api\OderHistoryController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/foods', [FoodController::class, 'index']);
Route::post('/foods', [FoodController::class, 'store']);
Route::get('/foods/{id}', [FoodController::class, 'show']);
Route::put('/foods/{id}', [FoodController::class, 'update']);
Route::delete('/foods/{id}', [FoodController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Orders
Route::get('/orders', [OderController::class, 'index']);
Route::post('/orders', [OderController::class, 'store']);
Route::get('/orders/{id}', [OderController::class, 'show']);
Route::put('/orders/{id}', [OderController::class, 'update']);
Route::delete('/orders/{id}', [OderController::class, 'destroy']);
Route::get('/orders-stats', [OderController::class, 'stats']);

// Order Details
Route::get('/order-details', [OderDetailController::class, 'index']); // expects order_id
Route::post('/order-details', [OderDetailController::class, 'store']);
Route::get('/order-details/{id}', [OderDetailController::class, 'show']);
Route::put('/order-details/{id}', [OderDetailController::class, 'update']);
Route::delete('/order-details/{id}', [OderDetailController::class, 'destroy']);

// Order History
Route::get('/order-history', [OderHistoryController::class, 'index']); // expects order_id
Route::post('/order-history', [OderHistoryController::class, 'store']);
Route::get('/order-history/{id}', [OderHistoryController::class, 'show']);
Route::put('/order-history/{id}', [OderHistoryController::class, 'update']);
Route::delete('/order-history/{id}', [OderHistoryController::class, 'destroy']);

// Reviews
Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/{id}', [ReviewController::class, 'show']);
Route::put('/reviews/{id}', [ReviewController::class, 'update']);
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);