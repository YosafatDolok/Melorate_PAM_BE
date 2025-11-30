@extends('admin.layout')

@section('content')
<h1>Albums</h1>

<a href="{{ route('admin.albums.create') }}">Add New Album</a>

@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Cover</th>
            <th>Album Name</th>
            <th>Artist</th>
            <th>Genre</th>
            <th>Duration</th>
            <th>Release Date</th>
            <th>Average Rating</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($albums as $album)
        <tr>
            <td>
                @if($album->album_cover)
                    <img src="{{ asset('storage/' . $album->album_cover) }}" width="50" height="50" alt="Cover">
                @else
                    N/A
                @endif
            </td>
            <td>{{ $album->album_name }}</td>
            <td>{{ $album->artist->name ?? 'Unknown' }}</td>
            <td>{{ $album->genre->genre_name ?? 'Unknown' }}</td>
            <td>{{ $album->duration ?? '-' }}</td>
            <td>{{ $album->release_date }}</td>
            <td>{{ $album->avg_rating ?? 0 }}</td>
            <td>
                <a href="{{ route('admin.albums.edit', ['id' => $album->album_id]) }}">Edit</a>

                <form action="{{ route('admin.albums.destroy', ['id' => $album->album_id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this album?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
