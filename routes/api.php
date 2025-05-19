<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PeminjamanController;

Route::group([], function () {
    Route::get('category', [CategoryController::class, 'listCategory']);

    
    Route::apiResource('peminjaman', PeminjamanController::class);
});
