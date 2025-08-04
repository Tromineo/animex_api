<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/animes', [AnimeController::class, 'index']);
    Route::get('/animes/{anime}', [AnimeController::class, 'show']);
    Route::post('/animes', [AnimeController::class, 'create']);
    Route::delete('/animes/{anime}', [AnimeController::class, 'delete']);
    Route::patch('/animes/{anime}', [AnimeController::class, 'update']);
});