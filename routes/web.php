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

    Route::get('/create_ajax', [UserController::class,'create_ajax']);
    Route::post('/ajax', [UserController::class,'store_ajax']);
    Route::get('/{user}/show_ajax', [UserController::class,'show_ajax']);
    Route::get('/{user}/edit_ajax', [UserController::class,'edit_ajax']);
    Route::put('/{user}/update_ajax', [UserController::class,'update_ajax']);
    Route::get('/{user}/delete_ajax', [UserController::class,'confirm_ajax']);
    Route::delete('/{user}/delete_ajax', [UserController::class,'delete_ajax']);

    Route::get('/{user}', [UserController::class,'show']);
    Route::get('/{user}/edit', [UserController::class,'edit']);
    Route::put('/{user}', [UserController::class,'update']);
    Route::delete('/{user}', [UserController::class,'destroy']);
});

Route::prefix('level')->group(function () {
    Route::get('/', [LevelController::class,'index']);
    Route::post('/list', [LevelController::class,'list']);

    // Add these new AJAX routes
    Route::get('/create_ajax', [LevelController::class,'create_ajax']);
    Route::post('/ajax', [LevelController::class,'store_ajax']);
    Route::get('/{level}/show_ajax', [LevelController::class,'show_ajax']);
    Route::get('/{level}/edit_ajax', [LevelController::class,'edit_ajax']);
    Route::put('/{level}/update_ajax', [LevelController::class,'update_ajax']);
    Route::get('/{level}/delete_ajax', [LevelController::class,'confirm_ajax']);
    Route::delete('/{level}/delete_ajax', [LevelController::class,'delete_ajax']);

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

    // Add these new AJAX routes
    Route::get('/create_ajax', [CategoryController::class,'create_ajax']);
    Route::post('/ajax', [CategoryController::class,'store_ajax']);
    Route::get('/{category}/show_ajax', [CategoryController::class,'show_ajax']);
    Route::get('/{category}/edit_ajax', [CategoryController::class,'edit_ajax']);
    Route::put('/{category}/update_ajax', [CategoryController::class,'update_ajax']);
    Route::get('/{category}/delete_ajax', [CategoryController::class,'confirm_ajax']);
    Route::delete('/{category}/delete_ajax', [CategoryController::class,'delete_ajax']);

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
    
    // Add these new AJAX routes
    Route::get('/create_ajax', [ProductController::class,'create_ajax']);
    Route::post('/ajax', [ProductController::class,'store_ajax']);
    Route::get('/{product}/show_ajax', [ProductController::class,'show_ajax']);
    Route::get('/{product}/edit_ajax', [ProductController::class,'edit_ajax']);
    Route::put('/{product}/update_ajax', [ProductController::class,'update_ajax']);
    Route::get('/{product}/delete_ajax', [ProductController::class,'confirm_ajax']);
    Route::delete('/{product}/delete_ajax', [ProductController::class,'delete_ajax']);

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
