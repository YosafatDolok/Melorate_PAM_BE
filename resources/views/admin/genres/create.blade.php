@extends('admin.layout')

@section('content')
<h1>Add Genre</h1>

<form action="{{ route('admin.genres.store') }}" method="POST">
    @csrf
    <label>Genre Name:</label>
    <input type="text" name="genre_name" required>
    <button type="submit" class="button">Save</button>
</form>
@endsection
