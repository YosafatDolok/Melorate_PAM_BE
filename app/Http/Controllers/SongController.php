<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;

class SongController extends Controller
{
    // === API for mobile app ===
    public function index()
    {
        $songs = Song::with(['album', 'artist', 'genre'])->get();
        return response()->json($songs);
    }

    public function show($id)
    {
        $song = Song::with(['album', 'artist', 'genre'])->find($id);
        if (!$song) {
            return response()->json(['message' => 'Song not found'], 404);
        }
        return response()->json($song);
    }

    // === Admin web CRUD ===
    public function webIndex()
    {
        $songs = Song::with(['artist', 'album', 'genre'])->get();
        return view('admin.songs.index', compact('songs'));
    }

    public function webCreate()
    {
        $artists = Artist::all();
        $albums = Album::all();
        $genres = Genre::all();
        return view('admin.songs.create', compact('artists', 'albums', 'genres'));
    }

    public function webStore(Request $request)
    {
        $request->validate([
            'song_title' => 'required|string|max:100',
            'artist_id' => 'required|exists:artists,artist_id',
            'album_id' => 'nullable|exists:albums,album_id',
            'genre_id' => 'nullable|exists:genres,genre_id',
            'song_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'duration' => 'nullable',
            'release_date' => 'nullable|date'
        ]);

        $data = $request->all();

        if ($request->hasFile('song_cover')) {
            $path = $request->file('song_cover')->store('songs', 'public');
            $data['song_cover'] = $path;
        }

        Song::create($data);
        return redirect()->route('admin.songs')->with('success', 'Song added successfully.');
    }

    public function webEdit($id)
    {
        $song = Song::findOrFail($id);
        $artists = Artist::all();
        $albums = Album::all();
        $genres = Genre::all();
        return view('admin.songs.edit', compact('song', 'artists', 'albums', 'genres'));
    }

    public function webUpdate(Request $request, $id)
    {
        $song = Song::findOrFail($id);

        $request->validate([
            'song_title' => 'required|string|max:100',
            'artist_id' => 'required|exists:artists,artist_id',
            'album_id' => 'nullable|exists:albums,album_id',
            'genre_id' => 'nullable|exists:genres,genre_id',
            'song_cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'duration' => 'nullable',
            'release_date' => 'nullable|date'
        ]);

        $data = $request->all();

        if ($request->hasFile('song_cover')) {
            if ($song->song_cover && Storage::disk('public')->exists($song->song_cover)) {
                Storage::disk('public')->delete($song->song_cover);
            }
            $path = $request->file('song_cover')->store('songs', 'public');
            $data['song_cover'] = $path;
        }

        $song->update($data);
        return redirect()->route('admin.songs')->with('success', 'Song updated successfully.');
    }

    public function webDestroy($id)
    {
        $song = Song::findOrFail($id);

        if ($song->song_cover && Storage::disk('public')->exists($song->song_cover)) {
            Storage::disk('public')->delete($song->song_cover);
        }

        $song->delete();
        return redirect()->route('admin.songs')->with('success', 'Song deleted successfully.');
    }
}
