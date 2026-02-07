<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\OrderController;

// Auth routes
Route::prefix('/auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum')->name('profile');
});

// Public routes - Table dashboard (guest can view)
Route::get('/tables', [TableController::class, 'index']);
Route::get('/tables/{id}', [TableController::class, 'show']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Food management (Pelayan only)
    Route::middleware('role:pelayan')->group(function () {
        Route::apiResource('foods', FoodController::class);
    });
    
    // Order management
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    
    // Create order and add items (Pelayan only)
    Route::middleware('role:pelayan')->group(function () {
        Route::post('/orders', [OrderController::class, 'store']);
        Route::post('/orders/{id}/items', [OrderController::class, 'addItems']);
    });
    
    // Close order (Kasir only)
    Route::middleware('role:kasir')->group(function () {
        Route::post('/orders/{id}/close', [OrderController::class, 'close']);
    });
});
