@extends('admin.layout')

@section('content')
<h1>Artists</h1>

<a href="{{ route('admin.artists.create') }}">Add New Artist</a>

@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Bio</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($artists as $artist)
        <tr>
            <td>
                @if($artist->photo)
                    <img src="{{ asset('storage/' . $artist->photo) }}" width="50" height="50" alt="Artist photo">
                @else
                    N/A
                @endif
            </td>
            <td>{{ $artist->name }}</td>
            <td>{{ $artist->bio }}</td>
            <td>
                <a href="{{ route('admin.artists.edit', ['id' => $artist->artist_id]) }}">Edit</a>
<form action="{{ route('admin.artists.destroy', ['id' => $artist->artist_id]) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Delete this artist?')">Delete</button>
</form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
