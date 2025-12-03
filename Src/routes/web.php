<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Laravel is connected to database: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Could not connect: ' . $e->getMessage();
    }
});
