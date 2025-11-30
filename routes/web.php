<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\{
    AuthController, PlaylistController, ReviewController, AlbumController, ArtistController, SongController,
    GenreController
};

Route::get('/admin/login', function() {
    return view('admin.login');
})->name('login');

Route::post('/admin/login', [AuthController::class, 'loginWeb'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logoutWeb'])->name('admin.logout');

Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function () {
    Route::get('/', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/artists', [ArtistController::class, 'webIndex'])->name('admin.artists');
    Route::get('/admin/artists/create', [ArtistController::class, 'webCreate'])->name('admin.artists.create');
    Route::post('/admin/artists', [ArtistController::class, 'webStore'])->name('admin.artists.store');
    Route::get('/admin/artists/{id}/edit', [ArtistController::class, 'webEdit'])->name('admin.artists.edit');
    Route::put('/admin/artists/{id}', [ArtistController::class, 'webUpdate'])->name('admin.artists.update');
    Route::delete('/admin/artists/{id}', [ArtistController::class, 'webDestroy'])->name('admin.artists.destroy');

    Route::get('/admin/albums', [AlbumController::class, 'webIndex'])->name('admin.albums');
    Route::get('/admin/albums/create', [AlbumController::class, 'webCreate'])->name('admin.albums.create');
    Route::post('/admin/albums', [AlbumController::class, 'webStore'])->name('admin.albums.store');
    Route::get('/admin/albums/{id}/edit', [AlbumController::class, 'webEdit'])->name('admin.albums.edit');
    Route::put('/admin/albums/{id}', [AlbumController::class, 'webUpdate'])->name('admin.albums.update');
    Route::delete('/admin/albums/{id}', [AlbumController::class, 'webDestroy'])->name('admin.albums.destroy');

    Route::get('/admin/genres', [GenreController::class, 'webIndex'])->name('admin.genres');
    Route::get('/admin/genres/create', [GenreController::class, 'webCreate'])->name('admin.genres.create');
    Route::post('/admin/genres', [GenreController::class, 'webStore'])->name('admin.genres.store');
    Route::get('/admin/genres/{id}/edit', [GenreController::class, 'webEdit'])->name('admin.genres.edit');
    Route::put('/admin/genres/{id}', [GenreController::class, 'webUpdate'])->name('admin.genres.update');
    Route::delete('/admin/genres/{id}', [GenreController::class, 'webDestroy'])->name('admin.genres.destroy');

    Route::get('/admin/songs', [SongController::class, 'webIndex'])->name('admin.songs');
    Route::get('/admin/songs/create', [SongController::class, 'webCreate'])->name('admin.songs.create');
    Route::post('/admin/songs', [SongController::class, 'webStore'])->name('admin.songs.store');
    Route::get('/admin/songs/{id}/edit', [SongController::class, 'webEdit'])->name('admin.songs.edit');
    Route::put('/admin/songs/{id}', [SongController::class, 'webUpdate'])->name('admin.songs.update');
    Route::delete('/admin/songs/{id}', [SongController::class, 'webDestroy'])->name('admin.songs.destroy');

    Route::get('/admin/reviews', [ReviewController::class, 'webIndex'])->name('admin.reviews');
    Route::delete('/admin/reviews/{id}', [ReviewController::class, 'webDestroy'])->name('admin.reviews.destroy');
});

