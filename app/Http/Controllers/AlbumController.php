<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::with(['genre', 'songs'])->get();
        return response()->json($albums);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'artist_id' => 'required|integer|exists:artists,artist_id',
            'album_name' => 'required|string|max:255',
            'album_cover' => 'nullable|string',
            'duration' => 'nullable|integer',
            'release_date' => 'nullable|date',
            'genre_id' => 'required|integer|exists:genres,genre_id'
        ]);

        $album = Album::create([
            'user_id' => Auth::id(),
            ...$data,
            'avg_rating' => 0
        ]);

        return response()->json([
            'message' => 'Album created successfully',
            'album' => $album
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $album = Album::with(['artists', 'songs', 'genre', 'reviews'])->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        return response()->json($album); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $album = Album::find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $album->update($request->only([
            'album_name', 'album_cover', 'duration', 'release_date', 'genre_id'
        ]));

        return response()->json([
            'message' => 'Album updated successfully',
            'album' => $album
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $album = Album::find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        $album->delete();

        return response()->json(['message' => 'Album deleted successfully']);
    }
}
