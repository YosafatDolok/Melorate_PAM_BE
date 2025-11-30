@extends('admin.layout')

@section('content')
<h1>Edit Artist</h1>

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.artists.update', ['id' => $artist->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name', $artist->name) }}" required>
    </div>
    <div>
        <label>Bio:</label>
        <textarea name="bio">{{ old('bio', $artist->bio) }}</textarea>
    </div>
    <div>
        <label>Current Photo:</label>
        @if($artist->photo)
            <img src="{{ asset('storage/' . $artist->photo) }}" width="50" height="50" alt="Artist photo">
        @else
            N/A
        @endif
    </div>
    <div>
        <label>New Photo:</label>
        <input type="file" name="photo" accept="image/*">
    </div>
    <div>
        <button type="submit">Update Artist</button>
        <a href="{{ route('admin.artists') }}">Cancel</a>
    </div>
</form>
@endsection
