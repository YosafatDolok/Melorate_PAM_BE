@extends('admin.layout')

@section('content')
<h1>Edit Song</h1>

<form action="{{ route('admin.songs.update', $song->song_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Title:</label><br>
    <input type="text" name="song_title" value="{{ $song->song_title }}" required><br><br>

    <label>Artist:</label><br>
    <select name="artist_id" required>
        @foreach($artists as $artist)
            <option value="{{ $artist->artist_id }}" {{ $song->artist_id == $artist->artist_id ? 'selected' : '' }}>
                {{ $artist->name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Album (optional):</label><br>
    <select name="album_id">
        <option value="">Standalone</option>
        @foreach($albums as $album)
            <option value="{{ $album->album_id }}" {{ $song->album_id == $album->album_id ? 'selected' : '' }}>
                {{ $album->album_name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Genre (optional):</label><br>
    <select name="genre_id">
        <option value="">No Genre</option>
        @foreach($genres as $genre)
            <option value="{{ $genre->genre_id }}" {{ $song->genre_id == $genre->genre_id ? 'selected' : '' }}>
                {{ $genre->genre_name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Song Cover (optional):</label><br>
    <input type="file" name="song_cover"><br><br>

    <label>Duration (hh:mm:ss):</label><br>
    <input type="text" name="duration" value="{{ $song->duration }}"><br><br>

    <label>Release Date:</label><br>
    <input type="date" name="release_date" value="{{ $song->release_date }}"><br><br>

    <button type="submit">Update</button>
</form>
@endsection
