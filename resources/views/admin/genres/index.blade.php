@extends('admin.layout')

@section('content')
<h1>Genres</h1>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.genres.create') }}" class="button">+ Add Genre</a>

<table style="width:100%; border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr style="background-color: #f3f4f6;">
            <th style="padding: 10px; text-align:left;">ID</th>
            <th style="padding: 10px; text-align:left;">Genre Name</th>
            <th style="padding: 10px; text-align:left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($genres as $genre)
        <tr style="border-bottom: 1px solid #e5e7eb;">
            <td style="padding: 10px;">{{ $genre->genre_id }}</td>
            <td style="padding: 10px;">{{ $genre->genre_name }}</td>
            <td style="padding: 10px;">
                <a href="{{ route('admin.genres.edit', $genre->genre_id) }}">Edit</a> |
                <form action="{{ route('admin.genres.destroy', $genre->genre_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
