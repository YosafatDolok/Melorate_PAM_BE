<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, AlbumController, SongController,
    PlaylistController, ReviewController, GenreController
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('playlists', PlaylistController::class);
    Route::apiResource('reviews', ReviewController::class);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('genres', GenreController::class);
    Route::apiResource('artists', ArtistController::class);
    Route::apiResource('albums', AlbumController::class);
    Route::apiResource('songs', SongController::class);
});
