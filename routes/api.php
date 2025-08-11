<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnimeCategoriaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::group(['prefix' => 'animes'], function () {
        Route::get('/', [AnimeController::class, 'index']);
        Route::get('/{anime}', [AnimeController::class, 'show']);
        Route::post('/', [AnimeController::class, 'create']);
        Route::delete('/{anime}', [AnimeController::class, 'delete']);
        Route::patch('/{anime}', [AnimeController::class, 'update']);        
    });

    Route::group(['prefix' => 'categorias'], function () {
        Route::get('/', [CategoriaController::class, 'index']);
        Route::get('/{categoria}', [CategoriaController::class, 'show']);
        Route::post('/', [CategoriaController::class, 'create']);
        Route::delete('/{categoria}', [CategoriaController::class, 'delete']);
        Route::patch('/{categoria}', [CategoriaController::class, 'update']);        
    });

    Route::group(['prefix' => 'animeCategorias'], function () {
        Route::get('/', [AnimeCategoriaController::class, 'index']);
        Route::get('/{categoria}', [AnimeCategoriaController::class, 'show']);
        Route::post('/', [AnimeCategoriaController::class, 'create']);
        Route::delete('/{categoria}', [AnimeCategoriaController::class, 'delete']);
        Route::patch('/{categoria}', [AnimeCategoriaController::class, 'update']);
    });
});