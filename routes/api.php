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
Route::get('/animes', [AnimeController::class, 'index'])->middleware('auth:sanctum');
Route::post('/animes', [AnimeController::class, 'create'])->middleware('auth:sanctum');
Route::delete('/animes/{anime}', [AnimeController::class, 'delete'])->middleware('auth:sanctum');
Route::patch('/animes/{anime}', [AnimeController::class, 'update'])->middleware('auth:sanctum');
