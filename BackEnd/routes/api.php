<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;

// 🔹 Public Product Routes
Route::prefix('menu')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

// 🔹 Admin Product Routes (بدون auth)
Route::prefix('admin')->group(function () {
    Route::prefix('menu')->group(function () {
        Route::get('/', [AdminProductController::class, 'index']);
        Route::post('/', [AdminProductController::class, 'store']);
        Route::put('/{id}', [AdminProductController::class, 'update']);
        Route::delete('/{id}', [AdminProductController::class, 'destroy']);
    });
});