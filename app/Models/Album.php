<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
    protected $primaryKey = 'album_id';
    public $timestamps = false;

    protected $fillable = [
        'artist_id', 'album_name', 'album_cover', 'duration',
        'release_date', 'genre_id', 'avg_rating'
    ];

    public function arists() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function genre() {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function songs() {
        return $this->hasMany(Song::class, 'album_id');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'album_id');
    }

    public function artists() {
        return $this->hasMany(Artist::class, 'artist_id');
    }
}
