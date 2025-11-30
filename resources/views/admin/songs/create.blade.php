@extends('admin.layout')

@section('content')
<h1>Add Song</h1>

<form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Title:</label><br>
    <input type="text" name="song_title" required><br><br>

    <label>Artist:</label><br>
    <select name="artist_id" required>
        <option value="">Select Artist</option>
        @foreach($artists as $artist)
            <option value="{{ $artist->artist_id }}">{{ $artist->name }}</option>
        @endforeach
    </select><br><br>

    <label>Album (optional):</label><br>
    <select name="album_id">
        <option value="">Standalone Song</option>
        @foreach($albums as $album)
            <option value="{{ $album->album_id }}">{{ $album->album_name }}</option>
        @endforeach
    </select><br><br>

    <label>Genre (optional):</label><br>
    <select name="genre_id">
        <option value="">No Genre</option>
        @foreach($genres as $genre)
            <option value="{{ $genre->genre_id }}">{{ $genre->genre_name }}</option>
        @endforeach
    </select><br><br>

    <label>Song Cover (optional):</label><br>
    <input type="file" name="song_cover"><br><br>

    <label>Duration (hh:mm:ss):</label><br>
    <input type="text" name="duration"><br><br>

    <label>Release Date:</label><br>
    <input type="date" name="release_date"><br><br>

    <button type="submit">Save</button>
</form>
@endsection
