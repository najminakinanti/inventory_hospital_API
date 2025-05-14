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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('hospitals', [HospitalController::class, 'index']);
    Route::get('hospitals/{id}', [HospitalController::class, 'show']);

    Route::get('warehouses', [WarehouseController::class, 'index']);
    Route::get('warehouses/{id}', [WarehouseController::class, 'show']);

    Route::get('items', [ItemController::class, 'index']);
    Route::get('items/{id}', [ItemController::class, 'show']);

    Route::get('order-items', [OrderItemController::class, 'index']);
    Route::get('order-items/{id}', [OrderItemController::class, 'show']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
});

Route::middleware(['auth:sanctum', EnsureHospital::class])->group(function () {
    Route::apiResource('hospitals', HospitalController::class)->except(['index', 'show']);

    Route::apiResource('order-items', OrderItemController::class)->except(['index', 'show']);

    Route::post('orders', [OrderController::class, 'store']);
    Route::put('orders/{id}', [OrderController::class, 'update']);
    Route::delete('orders/{id}', [OrderController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', EnsureWarehouse::class])->group(function () {
    Route::apiResource('warehouses', WarehouseController::class)->except(['index', 'show']);

    Route::apiResource('items', ItemController::class)->except(['index', 'show']);

    Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
});