<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    // === API: all users ===

    // Get all reviews
    public function index()
    {
        $reviews = Review::with(['user', 'song', 'album'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($reviews);
    }

    // Get reviews for a specific song or album
    public function show($id, Request $request)
{
    // Determine context based on query param ?type=song or ?type=album
    $type = $request->query('type', 'song'); // default to song if not specified

    if ($type === 'album') {
        $reviews = Review::where('album_id', $id)
            ->with('user')
            ->get();
    } else {
        $reviews = Review::where('song_id', $id)
            ->with('user')
            ->get();
    }

    if ($reviews->isEmpty()) {
        return response()->json(['message' => 'No reviews found.'], 404);
    }

    return response()->json($reviews);
}


    // Add or update a review (only one per user per song/album)
    public function store(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'song_id' => 'nullable|exists:songs,song_id',
        'album_id' => 'nullable|exists:albums,album_id',
        'rating' => 'required|integer|between:1,5',
        'review_text' => 'nullable|string',
    ]);

    // ensure either song or album is set, not both null
    if (!$request->song_id && !$request->album_id) {
        return response()->json(['message' => 'Review must belong to a song or an album'], 400);
    }

    // ensure user only has one review per album/song
    $existing = Review::where('user_id', $user->user_id)
        ->when($request->song_id, fn($q) => $q->where('song_id', $request->song_id))
        ->when($request->album_id, fn($q) => $q->where('album_id', $request->album_id))
        ->first();

    if ($existing) {
        $existing->update([
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'updated_at' => now(),
        ]);
        return response()->json(['message' => 'Review updated successfully', 'review' => $existing]);
    }

    $review = Review::create([
        'user_id' => $user->user_id,
        'song_id' => $request->song_id,
        'album_id' => $request->album_id,
        'rating' => $request->rating,
        'review_text' => $request->review_text,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'Review added successfully', 'review' => $review], 201);
}


    // Edit your own review
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if ($review->user_id !== $user->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'rating' => 'nullable|integer|between:1,5',
            'review_text' => 'nullable|string',
        ]);

        $review->update([
            'rating' => $request->rating ?? $review->rating,
            'review_text' => $request->review_text ?? $review->review_text,
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Review updated successfully', 'review' => $review]);
    }

    // Delete your own review
    public function destroy($id)
    {
        $user = Auth::user();
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if ($review->user_id !== $user->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }

    // === Admin Web Views ===
    public function webIndex()
    {
        $reviews = Review::with(['user', 'song', 'album'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function webDestroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return redirect()->route('admin.reviews')->with('error', 'Review not found.');
        }

        $review->delete();
        return redirect()->route('admin.reviews')->with('success', 'Review deleted successfully.');
    }
}
