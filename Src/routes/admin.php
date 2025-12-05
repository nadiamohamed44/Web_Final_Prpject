<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\MenuItemController;

// كل الـ routes بتاعة الأدمن هنا
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // المنتجات + التصنيفات
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // الطلبات
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // المستخدمين
    Route::resource('users', UserController::class);

    // التقييمات
    Route::resource('reviews', ReviewController::class);

    // عناصر القائمة (المنيو)
    Route::resource('menu-items', MenuItemController::class);
});
