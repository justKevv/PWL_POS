<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/user', [UserController::class,'index']);
