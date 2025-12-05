<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/api/products', [ProductController::class, 'apiIndex'])->name('api.products');

Route::get('/cart', function () {
    // Placeholder for cart, uses HTML for now or we can make a view
    return view('layouts.app'); // Or create a cart view
})->name('cart');

// Debug route (optional, can be removed)
Route::get('/debug-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Laravel is connected to database: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Could not connect: ' . $e->getMessage();
    }
});
