<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';
    protected $primaryKey = 'artist_id';
    public $timestamps = false;

    protected $fillable = ['name', 'bio', 'photo'];

    public function albums() {
        return $this->hasMany(Album::class, 'artist_id');
    }

    public function songs() {
        return $this->hasManyThrough(Song::class, Album::class, 'artist_id', 'album_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'genre_id');
    }
}
