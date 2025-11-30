@extends('admin.layout')

@section('content')
<h1>Edit Album</h1>

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.albums.update', ['id' => $album->album_id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Album Name:</label>
        <input type="text" name="album_name" value="{{ old('album_name', $album->album_name) }}" required>
    </div>

    <div>
        <label>Artist:</label>
        <select name="artist_id" required>
            @foreach($artists as $artist)
                <option value="{{ $artist->artist_id }}" {{ $artist->artist_id == $album->artist_id ? 'selected' : '' }}>
                    {{ $artist->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Genre:</label>
        <select name="genre_id" required>
            @foreach($genres as $genre)
                <option value="{{ $genre->genre_id }}" {{ $genre->genre_id == $album->genre_id ? 'selected' : '' }}>
                    {{ $genre->genre_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Release Date:</label>
        <input type="date" name="release_date" value="{{ old('release_date', $album->release_date) }}" required>
    </div>

    <div>
        <label>Duration (HH:MM:SS):</label>
        <input type="text" name="duration" value="{{ old('duration', $album->duration) }}">
    </div>

    <div>
        <label>Current Cover:</label>
        @if($album->album_cover)
            <img src="{{ asset('storage/' . $album->album_cover) }}" width="50" height="50" alt="Cover">
        @else
            N/A
        @endif
    </div>

    <div>
        <label>New Cover:</label>
        <input type="file" name="album_cover" accept="image/*">
    </div>

    <div>
        <button type="submit">Update Album</button>
        <a href="{{ route('admin.albums') }}">Cancel</a>
    </div>
</form>
@endsection
