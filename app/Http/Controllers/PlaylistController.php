<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistController extends Controller
{
    // Get all playlists of the authenticated user
    public function index()
    {
        $user = Auth::user();
        $playlists = Playlist::with('songs')->where('user_id', $user->user_id)->get();
        return response()->json($playlists);
    }

    // Show specific playlist with its songs
    public function show($id)
    {
        $playlist = Playlist::with('songs')->find($id);
        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }
        return response()->json($playlist);
    }

    // Create new playlist
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'playlist_name' => 'required|string|max:100',
            'playlist_description' => 'nullable|string',
            'playlist_cover' => 'nullable|string',
        ]);

        $playlist = Playlist::create([
            'user_id' => $user->user_id,
            'playlist_name' => $validated['playlist_name'],
            'playlist_description' => $validated['playlist_description'] ?? null,
            'playlist_cover' => $validated['playlist_cover'] ?? null,
        ]);

        return response()->json(['message' => 'Playlist created successfully', 'playlist' => $playlist], 201);
    }

    // Update playlist
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }
        if ($playlist->user_id !== $user->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $playlist->update($request->only(['playlist_name', 'playlist_description', 'playlist_cover']));

        return response()->json(['message' => 'Playlist updated successfully', 'playlist' => $playlist]);
    }

    // Delete playlist
    public function destroy($id)
    {
        $user = Auth::user();
        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }
        if ($playlist->user_id !== $user->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $playlist->delete();
        return response()->json(['message' => 'Playlist deleted successfully']);
    }

    // Add song to playlist
    public function addSong(Request $request, $playlistId)
    {
        $user = Auth::user();
        $playlist = Playlist::find($playlistId);

        if (!$playlist || $playlist->user_id !== $user->user_id) {
            return response()->json(['message' => 'Playlist not found or forbidden'], 404);
        }

        $request->validate(['song_id' => 'required|exists:songs,song_id']);

        $playlist->songs()->syncWithoutDetaching([$request->song_id]);

        return response()->json(['message' => 'Song added to playlist']);
    }

    // Remove song from playlist
    public function removeSong($playlistId, $songId)
    {
        $user = Auth::user();
        $playlist = Playlist::find($playlistId);

        if (!$playlist || $playlist->user_id !== $user->user_id) {
            return response()->json(['message' => 'Playlist not found or forbidden'], 404);
        }

        $playlist->songs()->detach($songId);

        return response()->json(['message' => 'Song removed from playlist']);
    }
}
