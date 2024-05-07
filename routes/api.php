<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/show', [UserController::class, 'show'])->middleware('auth:api');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::post('/products/search', [ProductController::class, 'searchProductsByRef']);
