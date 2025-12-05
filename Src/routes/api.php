<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AdminProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// API Auth Routes (مهم جدًا يكونوا قبل أي middleware)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ======================
//  Menu/Products API
// ======================

// Public menu routes
Route::prefix('menu')->group(function () {
    Route::get('/', [ProductController::class, 'index']);           // GET /api/menu
    Route::get('/{id}', [ProductController::class, 'show']);       // GET /api/menu/{id}
});

// Admin menu routes (protected)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::prefix('menu')->group(function () {
        Route::post('/', [AdminProductController::class, 'store']);      // POST /api/admin/menu
        Route::put('/{id}', [AdminProductController::class, 'update']);  // PUT /api/admin/menu/{id}
        Route::delete('/{id}', [AdminProductController::class, 'destroy']); // DELETE /api/admin/menu/{id}
    });
});

// ======================
//  Cart API
// ======================

// Public cart count (للـ badge في الهيدر)
Route::get('/cart/count', [CartController::class, 'count']);

// Protected cart routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update/{cartItemId}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
});

// ======================
//  Checkout API
// ======================

// Protected checkout routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/checkout/summary', [CheckoutController::class, 'summary']);
    Route::post('/checkout', [CheckoutController::class, 'process']);
});