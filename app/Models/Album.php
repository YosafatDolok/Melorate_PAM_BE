<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
    protected $primaryKey = 'album_id';
    public $timestamps = false;

    protected $fillable = [
        'album_name',
        'artist_id',
        'album_cover',
        'duration',
        'release_date',
        'genre_id',
        'avg_rating'
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class, 'album_id');
    }
}
