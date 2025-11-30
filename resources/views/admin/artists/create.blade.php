@extends('admin.layout')

@section('content')
<h1>Add Artist</h1>

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div>
        <label>Bio:</label>
        <textarea name="bio">{{ old('bio') }}</textarea>
    </div>
    <div>
        <label>Photo:</label>
        <input type="file" name="photo" accept="image/*">
    </div>
    <div>
        <button type="submit">Add Artist</button>
        <a href="{{ route('admin.artists') }}">Cancel</a>
    </div>
</form>
@endsection
