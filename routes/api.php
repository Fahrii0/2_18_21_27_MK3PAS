<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PeminjamanController;
use App\Http\Controllers\Api\UserController;



Route::group([], function () {
    Route::get('category', [CategoryController::class, 'listCategory']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('peminjaman', PeminjamanController::class);
});
