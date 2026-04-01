<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">Job<span>Portal</span></a>
            <ul class="nav-links">
                <li><a href="{{ route('jobs.index') }}">Browse Jobs</a></li>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                    @elseif(auth()->user()->role === 'employer')
                        <li><a href="{{ route('employer.dashboard') }}">Employer Dashboard</a></li>
                    @else
                        <li><a href="{{ route('seeker.dashboard') }}">My Dashboard</a></li>
                        <li><a href="{{ route('seeker.profile.edit') }}">My Profile</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-logout">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-primary">Register</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Job Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
