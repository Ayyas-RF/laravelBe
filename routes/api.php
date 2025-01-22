<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('category', CategoryController::class);
Route::apiResource('product', ProductController::class);
Route::post('/product-update/{id}', [ProductController::class, "update"]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
