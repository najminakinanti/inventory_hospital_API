<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureHospital;
use App\Http\Middleware\EnsureWarehouse;


// Auth routes
Route::post('/register/hospital', [AuthController::class, 'registerHospital']);
Route::post('/login/hospital', [AuthController::class, 'loginHospital']);
Route::post('/register/warehouse', [AuthController::class, 'registerWarehouse']);
Route::post('/login/warehouse', [AuthController::class, 'loginwarehouse']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// yang bisa diakses hospital dan warehouse
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('orders', OrderController::class);
});


Route::middleware(['auth:sanctum', EnsureHospital::class])->group(function () {
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('hospitals', HospitalController::class);
});

Route::middleware(['auth:sanctum', EnsureWarehouse::class])->group(function () {
    Route::apiResource('items', ItemController::class);
    Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
    Route::apiResource('warehouses', WarehouseController::class);
});
