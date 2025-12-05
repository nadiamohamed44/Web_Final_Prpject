<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\MenuItemController;
use Illuminate\Support\Facades\DB;
use App\Models\MenuItem;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes - كل الـ routes
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

// Test database connection
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Database connection OK! Connected to: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "❌ Database connection failed: " . $e->getMessage();
    }
});
