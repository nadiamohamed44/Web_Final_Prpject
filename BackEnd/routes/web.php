<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Test Route in web.php
Route::get('/test-api', function () {
    return response()->json([
        'success' => true,
        'message' => 'Web API is working!',
        'routes' => [
            '/api/menu' => 'Get all products',
            '/api/menu/featured' => 'Get featured products',
            '/api/menu/{id}' => 'Get single product'
        ]
    ]);
});