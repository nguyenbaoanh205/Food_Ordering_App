<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartItemOptionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Admin\FoodController;
use App\Http\Controllers\Api\Admin\BannerController;
use App\Http\Controllers\Api\Admin\FoodOptionSelectController;
use App\Http\Controllers\Api\BannerController as ApiBannerController;
use App\Http\Controllers\Api\FoodController as ApiFoodController;
use App\Http\Controllers\Api\FoodOptionController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\OderDetailController;
use App\Http\Controllers\Api\OderHistoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderHistoryClientController;
use App\Http\Controllers\Api\OrderItemOptionController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'check.token.expiry'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::get('/order-histories', [OrderHistoryClientController::class, 'index']);
    Route::get('/order-histories/{id}', [OrderHistoryClientController::class, 'show']);

    // Carts
    Route::get('/cart-items/{id}/options', [CartItemOptionController::class, 'index']);
    Route::get('/order-details/{id}/options', [OrderItemOptionController::class, 'index']);
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Stripe Payment
Route::post('/stripe/create-checkout-session', [StripeController::class, 'createCheckoutSession']);
Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);

// Foods [Client]
Route::get('/foods-client', [ApiFoodController::class, 'index']);
Route::get('/categories-client', [CategoryController::class, 'getAllClient']);

// Banner [Client]
Route::get('/banners-client', [ApiBannerController::class, 'index']);

// Carts [Client]
Route::get('/users/{id}/cart', [CartController::class, 'getCart']);
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::put('/cart-items/{id}', [CartController::class, 'updateQuantity']);
Route::delete('/cart-items/{id}', [CartController::class, 'removeItem']);

// Reviews [Admin, Client]
Route::get('/reviews', [ReviewController::class, 'index']);


// Categories [Admin, Client]
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Orders [Admin, Client]
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::get('/orders-stats', [OrderController::class, 'stats']);

// Users [Admin]
Route::apiResource('/users', UserController::class);

// Order Details [Admin]
Route::get('/order-details', [OderDetailController::class, 'index']); // expects order_id
Route::post('/order-details', [OderDetailController::class, 'store']);
Route::get('/order-details/{id}', [OderDetailController::class, 'show']);
Route::put('/order-details/{id}', [OderDetailController::class, 'update']);
Route::delete('/order-details/{id}', [OderDetailController::class, 'destroy']);

// Order History [Admin]
Route::get('/order-history', [OderHistoryController::class, 'index']); // expects order_id
Route::get('/order-history/{id}', [OderHistoryController::class, 'show']);

// Dashboard [Admin]
Route::get('/admin/dashboard/statistics', [DashboardController::class, 'statistics']);

// Foods [Admin]
Route::get('/foods', [FoodController::class, 'index']);
Route::post('/foods', [FoodController::class, 'store']);
Route::get('/foods/select', [FoodOptionSelectController::class, 'index']);
Route::get('/foods/{id}', [FoodController::class, 'show']);
Route::put('/foods/{id}', [FoodController::class, 'update']);
Route::delete('/foods/{id}', [FoodController::class, 'destroy']);
Route::apiResource('/food-options', FoodOptionController::class);

// Banners [Admin]
Route::get('/banners', [BannerController::class, 'index']);
Route::post('/banners', [BannerController::class, 'store']);
Route::get('/banners/{id}', [BannerController::class, 'show']);
Route::put('/banners/{id}', [BannerController::class, 'update']);
Route::delete('/banners/{id}', [BannerController::class, 'destroy']);
