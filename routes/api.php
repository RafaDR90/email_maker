<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TemplateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/show', [UserController::class, 'show'])->middleware('auth:api');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::post('/products', [ProductController::class, 'index']);
Route::post('/products/getTenProducts', [ProductController::class, 'getTenProducts']);
Route::post('/products/search', [ProductController::class, 'searchProductsByRef']);
Route::post('/products/styles-upload', [TemplateController::class, 'store'])->middleware('auth:api');
Route::post('/upload/svg', [TemplateController::class, 'uploadSvg'])->middleware('auth:api');
Route::get('/get-templates', [TemplateController::class, 'getTemplates'])->middleware('auth:api');
Route::post('/delete-template', [TemplateController::class, 'deleteTemplate'])->middleware('auth:api');
