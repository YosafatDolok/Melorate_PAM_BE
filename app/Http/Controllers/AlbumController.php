<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;

class AlbumController extends Controller
{
    /** ---------------- API (Mobile) ---------------- **/

    public function index()
    {
        // Show all albums sorted by release date (newest first)
        $albums = \App\Models\Album::with(['artist', 'genre'])
        ->orderBy('release_date', 'desc')
        ->get();

        return response()->json($albums);
    }


    public function show($id)
    {
        $album = \App\Models\Album::with(['artist', 'genre', 'songs'])->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album not found'], 404);
        }

        return response()->json($album, 200);
    }


    /** ---------------- Web (Admin CRUD) ---------------- **/

    public function webIndex()
    {
        $albums = Album::with(['artist', 'genre'])->get();
        return view('admin.albums.index', compact('albums'));
    }

    public function webCreate()
    {
        $artists = Artist::all();
        $genres = Genre::all();
        return view('admin.albums.create', compact('artists', 'genres'));
    }

    public function webStore(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'album_name' => 'required|string|max:100',
            'artist_id' => 'required|integer|exists:artists,artist_id',
            'genre_id' => 'required|integer|exists:genres,genre_id',
            'release_date' => 'required|date',
            'duration' => 'nullable',
            'album_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('album_cover')) {
            $data['album_cover'] = $request->file('album_cover')->store('albums', 'public');
        }

        Album::create($data);

        return redirect()->route('admin.albums')->with('success', 'Album created successfully.');
    }

    public function webEdit($id)
    {
        $this->authorizeAdmin();

        $album = Album::findOrFail($id);
        $artists = Artist::all();
        $genres = Genre::all();

        return view('admin.albums.edit', compact('album', 'artists', 'genres'));
    }

    public function webUpdate(Request $request, $id)
    {
        $this->authorizeAdmin();

        $album = Album::findOrFail($id);

        $data = $request->validate([
            'album_name' => 'required|string|max:100',
            'artist_id' => 'required|integer|exists:artists,artist_id',
            'genre_id' => 'required|integer|exists:genres,genre_id',
            'release_date' => 'required|date',
            'duration' => 'nullable',
            'album_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('album_cover')) {
            if ($album->album_cover && Storage::disk('public')->exists($album->album_cover)) {
                Storage::disk('public')->delete($album->album_cover);
            }
            $data['album_cover'] = $request->file('album_cover')->store('albums', 'public');
        }

        $album->update($data);

        return redirect()->route('admin.albums')->with('success', 'Album updated successfully.');
    }

    public function webDestroy($id)
    {
        $this->authorizeAdmin();

        $album = Album::findOrFail($id);

        if ($album->album_cover && Storage::disk('public')->exists($album->album_cover)) {
            Storage::disk('public')->delete($album->album_cover);
        }

        $album->delete();

        return redirect()->route('admin.albums')->with('success', 'Album deleted successfully.');
    }

    /** ---------------- Helper ---------------- **/

    private function authorizeAdmin()
    {
        if (!auth()->check() || auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized.');
        }
    }
}
