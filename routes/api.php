<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;


Route::get('/users', [UserController::class, 'index']);

Route::get('/user/{id}', [UserController::class, 'show']);

Route::resource('posts', PostController::class)->except('store');
