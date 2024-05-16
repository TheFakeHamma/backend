<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//User APIs
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum'
], function(){
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
});

//Recipe APIs
Route::get('recipes', [RecipeController::class, 'getRecipes']);
