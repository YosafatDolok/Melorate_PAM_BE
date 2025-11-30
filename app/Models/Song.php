<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';
    protected $primaryKey = 'song_id';
    public $timestamps = false;

    protected $fillable = [
        'album_id',
        'artist_id',
        'song_title',
        'song_cover',
        'duration',
        'release_date',
        'genre_id',
        'avg_rating'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_songs', 'song_id', 'playlist_id');
    }

}
