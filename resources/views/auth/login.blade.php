@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 3rem auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Login to Your Account</h2>
    
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <p style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem;">
        Don't have an account? <a href="{{ route('register') }}" style="color: var(--primary-color);">Register here</a>
    </p>
</div>
@endsection
