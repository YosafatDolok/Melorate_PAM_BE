<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Artist::with('albums')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string'
        ]);

        $artist = Artist::create($data);
        return response()->json(['message' => 'Artist created successfully', 'artist' => $artist], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artist = Artist::with('albums.songs')->find($id);
        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        return response()->json($artist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $artist = Artist::find($id);
        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $artist->update($request->only(['name', 'bio', 'photo']));
        return response()->json(['message' => 'Artist updated successfully', 'artist' => $artist]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $artist = Artist::find($id);
        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }

        $artist->delete();
        return response()->json(['message' => 'Artist deleted successfully']);
    }
}
