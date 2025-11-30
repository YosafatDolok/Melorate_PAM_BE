<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Artist;

class ArtistController extends Controller
{
    /** ---------------- API METHODS (for mobile / regular users) ---------------- **/

    public function index()
    {
        return response()->json(Artist::with('albums')->get());
    }

    public function show(string $id)
    {
        $artist = Artist::with('albums.songs')->find($id);
        if (!$artist) {
            return response()->json(['message' => 'Artist not found'], 404);
        }
        return response()->json($artist);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('artists', 'public');
        }

        $artist = Artist::create($data);
        return response()->json(['message' => 'Artist created successfully', 'artist' => $artist], 201);
    }

    public function update(Request $request, string $id)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $artist = Artist::find($id);
        if (!$artist) return response()->json(['message' => 'Artist not found'], 404);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
                Storage::disk('public')->delete($artist->photo);
            }
            $data['photo'] = $request->file('photo')->store('artists', 'public');
        }

        $artist->update($data);
        return response()->json(['message' => 'Artist updated successfully', 'artist' => $artist]);
    }

    public function destroy(string $id)
    {
        if (Auth::user()->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $artist = Artist::find($id);
        if (!$artist) return response()->json(['message' => 'Artist not found'], 404);

        if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
            Storage::disk('public')->delete($artist->photo);
        }

        $artist->delete();
        return response()->json(['message' => 'Artist deleted successfully']);
    }


    /** ---------------- WEB METHODS (admin-only Blade CRUD) ---------------- **/

    public function webIndex()
    {
        $artists = Artist::all();
        return view('admin.artists.index', compact('artists'));
    }

    public function webCreate()
    {
        return view('admin.artists.create');
    }

    public function webStore(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('artists', 'public');
        }

        Artist::create($data);

        return redirect()->route('admin.artists')->with('success', 'Artist created successfully.');
    }

    public function webEdit($id)
    {
        $this->authorizeAdmin();
        $artist = Artist::findOrFail($id);
        return view('admin.artists.edit', compact('artist'));
    }

    public function webUpdate(Request $request, $id)
    {
        $this->authorizeAdmin();

        $artist = Artist::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
                Storage::disk('public')->delete($artist->photo);
            }
            $data['photo'] = $request->file('photo')->store('artists', 'public');
        }

        $artist->update($data);

        return redirect()->route('admin.artists')->with('success', 'Artist updated successfully.');
    }

    public function webDestroy($id)
    {
        $this->authorizeAdmin();

        $artist = Artist::findOrFail($id);

        if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
            Storage::disk('public')->delete($artist->photo);
        }

        $artist->delete();

        return redirect()->route('admin.artists')->with('success', 'Artist deleted successfully.');
    }

    /** ---------------- HELPER ---------------- **/

    private function authorizeAdmin()
    {
        if (!auth()->check() || auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized.');
        }
    }
}
