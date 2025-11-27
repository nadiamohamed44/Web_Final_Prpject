<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

// Public Menu Routes
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/featured', [MenuController::class, 'featured']);
Route::get('/menu/{id}', [MenuController::class, 'show']);

// Test Route
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working!'
    ]);
});