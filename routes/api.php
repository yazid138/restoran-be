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

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tables/{id}', [TableController::class, 'show']);
    
    // Order management
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    
    // Create order and add items
    Route::middleware('role:pelayan')->group(function () {
        // Table management
        Route::put('/tables/{id}', [TableController::class, 'update']);

        // Food management
        Route::apiResource('foods', FoodController::class);
        
        Route::post('/orders', [OrderController::class, 'store']);
        Route::post('/orders/{id}/items', [OrderController::class, 'addItems']);
        Route::delete('/orders/{order}/items/{item}', [OrderController::class, 'destroyItem']);
    });
    
    // Close order
    Route::middleware('role:kasir')->group(function () {
        Route::post('/orders/{id}/close', [OrderController::class, 'close']);
    });
});

// Public routes - Table dashboard (guest can view)
Route::get('/tables', [TableController::class, 'index']);
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);