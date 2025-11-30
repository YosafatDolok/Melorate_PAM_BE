@extends('admin.layout')

@section('content')
<h1>Admin Login</h1>

@if(session('error'))
    <div style="color:red">{{ session('error') }}</div>
@endif

<form action="{{ route('admin.login.submit') }}" method="POST">
    @csrf
    <label>Email:</label><br>
    <input type="email" name="email" value="{{ old('email') }}" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>
@endsection
