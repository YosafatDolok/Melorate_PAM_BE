<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\{
    AuthController, PlaylistController, ReviewController, AlbumController, ArtistController, SongController,
    GenreController, UserController, SearchController
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'registerApi']);
Route::post('/login', [AuthController::class, 'loginApi']);
Route::post('/logout', [AuthController::class, 'logoutApi']);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('playlists', PlaylistController::class);
    Route::apiResource('reviews', ReviewController::class);

    Route::get('/albums', [AlbumController::class, 'index']);
    Route::get('/albums/{id}', [AlbumController::class, 'show']);

    Route::get('/genres', [GenreController::class, 'index']);
    Route::get('/genres/{id}', [GenreController::class, 'show']);

    Route::get('/songs', [SongController::class, 'index']);
    Route::get('/songs/{id}', [SongController::class, 'show']);

    Route::get('/reviews/{id}', [ReviewController::class, 'show']); // use ?type=song or ?type=album
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    Route::get('/playlists', [PlaylistController::class, 'index']);
    Route::get('/playlists/{id}', [PlaylistController::class, 'show']);
    Route::post('/playlists', [PlaylistController::class, 'store']);
    Route::put('/playlists/{id}', [PlaylistController::class, 'update']);
    Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy']);
    Route::post('/playlists/{id}/add-song', [PlaylistController::class, 'addSong']);
    Route::delete('/playlists/{id}/remove-song/{songId}', [PlaylistController::class, 'removeSong']);
    Route::get('/playlists/{id}/songs', [PlaylistController::class, 'getSongs']);

    Route::get('/users/{id}/profile', [UserController::class, 'getProfile']);
    Route::delete('/user/delete', [UserController::class, 'deleteAccount']);
    Route::get('/search',[SearchController::class, 'search']);

    Route::get('/artists', [ArtistController::class, 'index']);
    Route::get('/artists/{id}', [ArtistController::class, 'show']);
});
