<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeListController;

//User APIs
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum'
], function(){
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
});

//Recipe Lists
Route::middleware('auth:sanctum')->group(function () {
    Route::get('recipe-lists', [RecipeListController::class, 'index']);
    Route::post('recipe-lists', [RecipeListController::class, 'store']);
    Route::get('recipe-lists/{id}', [RecipeListController::class, 'show']);
    Route::put('recipe-lists/{id}', [RecipeListController::class, 'update']);
    Route::delete('recipe-lists/{id}', [RecipeListController::class, 'destroy']);
    Route::post('recipe-lists/{listId}/recipes', [RecipeListController::class, 'addRecipe']);
    Route::delete('recipe-lists/{listId}/recipes/{recipeId}', [RecipeListController::class, 'removeRecipe']);
});

//Recipe APIs
Route::get('recipes', [RecipeController::class, 'getRecipes']);
