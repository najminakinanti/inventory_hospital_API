<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\OrderItemController;


// items
Route::apiResource('items', ItemController::class);

// orders (keseluruhan)
Route::apiResource('orders', OrderController::class);
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);

// order item (per item)
Route::apiResource('order-items', OrderItemController::class);

// hospitals
Route::apiResource('hospitals', HospitalController::class);

// warehouses
Route::apiResource('warehouses', WarehouseController::class);
