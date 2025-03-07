<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [UserController::class, 'logout']);
    Route::get('user/{id}', [UserController::class, 'find']);

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);          // GET /posts (list paginated posts)
        Route::get('/{id}', [PostController::class, 'show']);       // GET /posts/{id} (get single post)
        Route::post('/', [PostController::class, 'store']);         // POST /posts (create new post)
        Route::patch('/{id}', [PostController::class, 'update']);     // PATCH /posts/{id} (update post)
        Route::delete('/{id}', [PostController::class, 'destroy']); // DELETE /posts/{id} (delete post)
    });
    Route::get('/weather/perth', [WeatherController::class, 'getWeatherData']);
});


