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
    return view('welcome');
});

Route::get('/debug-db', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Database connection OK! Connected to: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "❌ Database connection failed: " . $e->getMessage();
    }
});
