@extends('admin.layout')

@section('content')
<h1>Songs</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<a href="{{ route('admin.songs.create') }}">Add New Song</a>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top:20px; width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Artist</th>
            <th>Album</th>
            <th>Genre</th>
            <th>Release Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($songs as $song)
            <tr>
                <td>{{ $song->song_id }}</td>
                <td>{{ $song->song_title }}</td>
                <td>{{ $song->artist->name ?? '—' }}</td>
                <td>{{ $song->album->album_name ?? 'Standalone' }}</td>
                <td>{{ $song->genre->genre_name ?? '—' }}</td>
                <td>{{ $song->release_date ?? '—' }}</td>
                <td>
                    <a href="{{ route('admin.songs.edit', $song->song_id) }}">Edit</a>
                    <form action="{{ route('admin.songs.destroy', $song->song_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">No songs found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
