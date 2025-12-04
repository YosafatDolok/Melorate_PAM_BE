<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q');
        if (!$query) {
            return response()->json([
                'songs' => [],
                'albums' => [],
                'artists' => [],
            ]);
        }

        $songs = Song::with(['artist', 'album', 'genre'])
            ->where('song_title', 'ILIKE', "%$query%")
            ->take(10)
            ->get();

        $albums = Album::with(['artist', 'genre'])
            ->where('album_name', 'ILIKE', "%$query%")
            ->take(10)
            ->get();

        $artists = Artist::where('name', 'ILIKE', "%$query%")
            ->take(10)
            ->get();

        return response()->json([
            'songs' => $songs,
            'albums' => $albums,
            'artists' => $artists,
        ]);
    }
}
