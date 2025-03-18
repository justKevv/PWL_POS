<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/category', [CategoryController::class, 'index']);
