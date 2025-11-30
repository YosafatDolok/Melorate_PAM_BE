@extends('admin.layout')

@section('content')
<h1>Reviews</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Target</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <td>{{ $review->review_id }}</td>
                <td>{{ $review->user->username ?? 'Unknown' }}</td>
                <td>
                    @if($review->song)
                        Song: {{ $review->song->song_title }}
                    @elseif($review->album)
                        Album: {{ $review->album->album_name }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $review->rating }}/5</td>
                <td>{{ $review->review_text ?? '—' }}</td>
                <td>{{ $review->created_at }}</td>
                <td>
                    <form action="{{ route('admin.reviews.destroy', $review->review_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this review?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">No reviews found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
