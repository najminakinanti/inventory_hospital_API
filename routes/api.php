<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\WarehouseController;

// items
Route::apiResource('items', ItemController::class);

// orders
Route::apiResource('orders', OrderController::class);

// status orders
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);

// hospitals
Route::apiResource('hospitals', HospitalController::class);

// warehouses
Route::apiResource('warehouses', WarehouseController::class);

?>
