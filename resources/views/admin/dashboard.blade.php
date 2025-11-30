@extends('admin.layout')

@section('content')
<style>
    .dashboard {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
    }

    h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .welcome {
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        transition: all 0.2s ease;
    }

    .card:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.1);
    }

    .card h2 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .card p {
        color: var(--text-light);
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .card a {
        display: inline-block;
        background: var(--primary);
        color: white;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.2s;
    }

    .card a:hover {
        background: #6d28d9;
    }

    .alert {
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        border: 1px solid;
    }

    .alert-success {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }

    .logout-container {
        text-align: center;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }

    .logout-btn {
        background: var(--white);
        color: var(--text-light);
        border: 1px solid var(--border);
        padding: 0.75rem 2rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .logout-btn:hover {
        background: var(--primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }
</style>

<div class="dashboard">
    <h1>Admin Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p class="welcome">Welcome back, <strong>{{ auth()->user()->username ?? 'Admin' }}</strong></p>

    <div class="grid">
        <div class="card">
            <h2>Manage Artists</h2>
            <p>View, edit, or delete existing artists</p>
            <a href="{{ route('admin.artists') }}">Manage Artists</a>
        </div>

        <div class="card">
            <h2>Manage Albums</h2>
            <p>Handle album details and cover images</p>
            <a href="{{ route('admin.albums') }}">Manage Albums</a>
        </div>

        <div class="card">
            <h2>Manage Songs</h2>
            <p>Add new songs or edit existing ones</p>
            <a href="{{ route('admin.songs') }}">Manage Songs</a>
        </div>

        <div class="card">
            <h2>Manage Genres</h2>
            <p>Create, update, or delete music genres</p>
            <a href="{{ route('admin.genres') }}">Manage Genres</a>
        </div>

        <div class="card">
            <h2>Manage Reviews</h2>
            <p>View and moderate user reviews and ratings</p>
            <a href="{{ route('admin.reviews') }}">Manage Reviews</a>
        </div>
</div>
@endsection