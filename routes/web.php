<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/level', [LevelController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);

Route::get('/user', [UserController::class,'index']);
Route::get('/user/add', [UserController::class, 'create']);
Route::post('/user/store', [UserController::class,'store']);
Route::get('/user/edit/{id_user}', [UserController::class, 'edit']);
Route::put('/user/update/{id_user}', [UserController::class, 'update']);
Route::get('/user/delete/{id_user}', [UserController::class,'destroy']);
