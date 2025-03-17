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

Route::get('/level', [LevelController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);
