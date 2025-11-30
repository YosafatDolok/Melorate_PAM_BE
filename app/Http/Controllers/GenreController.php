<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Genre;

class GenreController extends Controller
{
    // === API: Regular users (read-only) ===
    public function index()
    {
        return response()->json(Genre::all());
    }

    public function show($id)
    {
        $genre = Genre::with(['albums', 'songs'])->find($id);
        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }
        return response()->json($genre);
    }

    // === Web: Admin CRUD ===
    public function webIndex()
    {
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    public function webCreate()
    {
        return view('admin.genres.create');
    }

    public function webStore(Request $request)
    {
        $request->validate(['genre_name' => 'required|string|max:50']);
        Genre::create(['genre_name' => $request->genre_name]);
        return redirect()->route('admin.genres')->with('success', 'Genre added successfully.');
    }

    public function webEdit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genres.edit', compact('genre'));
    }

    public function webUpdate(Request $request, $id)
    {
        $request->validate(['genre_name' => 'required|string|max:50']);
        $genre = Genre::findOrFail($id);
        $genre->update(['genre_name' => $request->genre_name]);
        return redirect()->route('admin.genres')->with('success', 'Genre updated successfully.');
    }

    public function webDestroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
        return redirect()->route('admin.genres')->with('success', 'Genre deleted successfully.');
    }
}
