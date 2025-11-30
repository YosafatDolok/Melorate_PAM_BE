@extends('admin.layout')

@section('content')
<h1>Edit Genre</h1>

<form action="{{ route('admin.genres.update', $genre->genre_id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Genre Name:</label>
    <input type="text" name="genre_name" value="{{ $genre->genre_name }}" required>
    <button type="submit" class="button">Update</button>
</form>
@endsection
