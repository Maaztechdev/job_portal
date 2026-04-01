@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 3rem auto;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Create a New Account</h2>
    
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <p style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
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

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="role">Register as</label>
            <select name="role" id="role" required>
                <option value="seeker" {{ old('role') === 'seeker' ? 'selected' : '' }}>Job Seeker</option>
                <option value="employer" {{ old('role') === 'employer' ? 'selected' : '' }}>Employer</option>
            </select>
            @error('role')
                <p style="color: var(--danger-color); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Register</button>
    </form>
    
    <p style="text-align: center; margin-top: 1.5rem;">
        Already have an account? <a href="{{ route('login') }}" style="color: var(--primary-color);">Login here</a>
    </p>
</div>
@endsection
