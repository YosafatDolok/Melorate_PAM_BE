<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile($id)
    {
        $user = User::with([
            'playlists',
            'reviews.song',
            'reviews.album',
        ])->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Sort recent reviews (newest first)
        $recentReviews = $user->reviews->sortByDesc('updated_at')->take(5)->values();

        // Collect recently reviewed songs & albums
        $recentSongs = $recentReviews->pluck('song')->filter()->unique('song_id')->take(5)->values();
        $recentAlbums = $recentReviews->pluck('album')->filter()->unique('album_id')->take(5)->values();

        return response()->json([
            'user' => [
                'user_id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
            ],
            'playlists' => $user->playlists,
            'recent_reviews' => $recentReviews->values(),
            'recent_songs' => $recentSongs,
            'recent_albums' => $recentAlbums,
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        // Validate password input
        $request->validate([
            'password' => 'required|string',
        ]);

        // Verify the password
        if (!\Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Incorrect password'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Account deleted successfully']);
    }

}
