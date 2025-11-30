<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';
    protected $primaryKey = 'genre_id';
    public $timestamps = false;

    protected $fillable = ['genre_name'];

    public function albums() {
        return $this->hasMany(Album::class, 'genre_id');
    }

    public function songs() {
        return $this->hasMany(Song::class, 'genre_id');
    }
}
