<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users',[UserController::class, 'index']);
Route::get('/users/{id}',[UserController::class, 'show']);
Route::post('/users',[UserController::class, 'store']);
Route::put('/users/{id}',[UserController::class, 'update']);
Route::delete('/users/{id}',[UserController::class, 'destroy']);

/**Product routes */

Route::apiResource('products', ProductController::class);
Route::get('products/brand/{brandId}', [ProductController::class, 'getByBrand']);
Route::get('products/category/{categoryId}', [ProductController::class, 'getByCategory']);
Route::get('products/search', [ProductController::class, 'search']);
Route::patch('products/{id}/toggle-status', [ProductController::class, 'toggleStatus']);
