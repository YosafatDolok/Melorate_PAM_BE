@extends('admin.layout')

@section('content')
<h1>Add Album</h1>

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Album Name:</label>
        <input type="text" name="album_name" value="{{ old('album_name') }}" required>
    </div>

    <div>
        <label>Artist:</label>
        <select name="artist_id" required>
            <option value="">-- Select Artist --</option>
            @foreach($artists as $artist)
                <option value="{{ $artist->artist_id }}" {{ old('artist_id') == $artist->artist_id ? 'selected' : '' }}>
                    {{ $artist->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Genre:</label>
        <select name="genre_id" required>
            <option value="">-- Select Genre --</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->genre_id }}" {{ old('genre_id') == $genre->genre_id ? 'selected' : '' }}>
                    {{ $genre->genre_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Release Date:</label>
        <input type="date" name="release_date" value="{{ old('release_date') }}" required>
    </div>

    <div>
        <label>Duration (HH:MM:SS):</label>
        <input type="text" name="duration" value="{{ old('duration') }}">
    </div>

    <div>
        <label>Album Cover:</label>
        <input type="file" name="album_cover" accept="image/*">
    </div>

    <div>
        <button type="submit">Add Album</button>
        <a href="{{ route('admin.albums') }}">Cancel</a>
    </div>
</form>
@endsection
