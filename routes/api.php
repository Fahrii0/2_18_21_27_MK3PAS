<?php

use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\UserSwaggerController;
use App\Http\Controllers\Api\BookSwaggerController;
use App\Http\Controllers\Api\PeminjamanSwaggerController;
use App\Http\Controllers\Api\CategorySwaggerController;
use App\Http\Controllers\API\AuthController;

// ----------------------------
// USER Routes
// ----------------------------
Route::apiResource('users', UserController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Swagger-style User routes (optional, if needed separately)
Route::middleware('auth:sanctum')->group(function () {
Route::prefix('users-swagger')->group(function () {
    Route::get('/', [UserSwaggerController::class, 'index']);
    Route::post('/', [UserSwaggerController::class, 'store']);
    Route::get('{id}', [UserSwaggerController::class, 'show']);
    Route::put('{id}', [UserSwaggerController::class, 'update']);
    Route::delete('{id}', [UserSwaggerController::class, 'destroy']);
});

// ----------------------------
// PEMINJAMAN Routes
// ----------------------------
Route::prefix('api')->group(function () {
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [PeminjamanSwaggerController::class, 'index']);
        Route::post('/', [PeminjamanSwaggerController::class, 'store']);
        Route::get('{id}', [PeminjamanSwaggerController::class, 'show']);
        Route::put('{id}', [PeminjamanSwaggerController::class, 'update']);
        Route::delete('{id}', [PeminjamanSwaggerController::class, 'destroy']);
    });
});

Route::apiResource('peminjaman', PeminjamanSwaggerController::class);


// ----------------------------
// BOOK Routes
// ----------------------------
Route::apiResource('books', BookSwaggerController::class);
Route::prefix('books')->group(function () {
    Route::get('/', [BookSwaggerController::class, 'index']);
    Route::post('/', [BookSwaggerController::class, 'store']);
    Route::get('{id}', [BookSwaggerController::class, 'show']);
    Route::put('{id}', [BookSwaggerController::class, 'update']);
    Route::delete('{id}', [BookSwaggerController::class, 'destroy']);
});

// ----------------------------
// CATEGORY Routes
// ----------------------------
Route::apiResource('categories', CategorySwaggerController::class);
Route::prefix('categories')->group(function () {
    Route::get('/', [CategorySwaggerController::class, 'index']);
    Route::post('/', [CategorySwaggerController::class, 'store']);
    Route::put('{id}', [CategorySwaggerController::class, 'update']);
    Route::delete('{id}', [CategorySwaggerController::class, 'destroy']);
});
});

// ----------------------------
// Test Endpoint
// ----------------------------
Route::get('/test', function () {
    return response()->json(['message' => 'API works']);
});
