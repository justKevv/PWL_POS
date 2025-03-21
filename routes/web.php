<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class,'index']);
    Route::post('/list', [UserController::class,'list']);
    Route::get('/create', [UserController::class,'create']);
    Route::post('/', [UserController::class,'store']);
    Route::get('/{user}', [UserController::class,'show']);
    Route::get('/{user}/edit', [UserController::class,'edit']);
    Route::put('/{user}', [UserController::class,'update']);
    Route::delete('/{user}', [UserController::class,'destroy']);
});

Route::prefix('level')->group(function () {
    Route::get('/', [LevelController::class,'index']);
    Route::post('/list', [LevelController::class,'list']);
    Route::get('/create', [LevelController::class,'create']);
    Route::post('/', [LevelController::class,'store']);
    Route::get('/{level}', [LevelController::class,'show']);
    Route::get('/{level}/edit', [LevelController::class,'edit']);
    Route::put('/{level}', [LevelController::class,'update']);
    Route::delete('/{level}', [LevelController::class,'destroy']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class,'index']);
    Route::post('/list', [CategoryController::class,'list']);
    Route::get('/create', [CategoryController::class,'create']);
    Route::post('/', [CategoryController::class,'store']);
    Route::get('/{category}', [CategoryController::class,'show']);
    Route::get('/{category}/edit', [CategoryController::class,'edit']);
    Route::put('/{category}', [CategoryController::class,'update']);
    Route::delete('/{category}', [CategoryController::class,'destroy']);
});

Route::prefix('item')->group(function () {
    Route::get('/', [ProductController::class,'index']);
    Route::post('/list', [ProductController::class,'list']);
    Route::get('/getNextId/{category}', [ProductController::class, 'getNextId']);
    Route::get('/create', [ProductController::class,'create']);
    Route::post('/', [ProductController::class,'store']);
    Route::get('/{product}', [ProductController::class,'show']);
    Route::get('/{product}/edit', [ProductController::class,'edit']);
    Route::put('/{product}', [ProductController::class,'update']);
    Route::delete('/{product}', [ProductController::class,'destroy']);
});

Route::prefix('stock')->group(function () {
    Route::get('/', [StockController::class,'index']);
    Route::post('/list', [StockController::class,'list']);
    Route::get('/create', [StockController::class,'create']);
    Route::post('/', [StockController::class,'store']);
    Route::get('/{stock}', [StockController::class,'show']);
    Route::get('/{stock}/edit', [StockController::class,'edit']);
    Route::put('/{stock}', [StockController::class,'update']);
    Route::delete('/{stock}', [StockController::class,'destroy']);
});

Route::prefix('sales')->group(function () {
    Route::get('/', [SalesController::class,'index']);
    Route::post('/list', [SalesController::class,'list']);
    Route::get('/getNextCode/{date}', [SalesController::class, 'getNextCode']);
    Route::get('/getProductPrice/{id}', [SalesController::class, 'getProductPrice']);
    Route::get('/create', [SalesController::class,'create']);
    Route::post('/', [SalesController::class,'store']);
    Route::get('/{sales}', [SalesController::class,'show']);
    Route::get('/{sales}/edit', [SalesController::class,'edit']);
    Route::put('/{sales}', [SalesController::class,'update']);
    Route::delete('/{sales}', [SalesController::class,'destroy']);
});
