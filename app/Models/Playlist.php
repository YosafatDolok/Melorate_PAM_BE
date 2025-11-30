<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $table = 'playlists';
    protected $primaryKey = 'playlist_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'playlist_name',
        'playlist_description',
        'playlist_cover'
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_songs', 'playlist_id', 'song_id');
    }
}
