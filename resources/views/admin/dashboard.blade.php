@extends('layouts.app')

@section('content')
<div style="margin-top: 3rem;">
    <h1>Admin Dashboard</h1>
    <p class="card-meta">Manage the entire system from here.</p>

    <div class="stats-grid" style="margin-top: 2rem;">
        <div class="stat-item">
            <h3>{{ $stats['total_jobs'] }}</h3>
            <p>Total Jobs</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['total_users'] }}</h3>
            <p>Total Users</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['total_applications'] }}</h3>
            <p>Total Applications</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['employers'] }}</h3>
            <p>Employers</p>
        </div>
        <div class="stat-item">
            <h3>{{ $stats['seekers'] }}</h3>
            <p>Job Seekers</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <div class="card">
            <h3>Recent Applications</h3>
            <a href="{{ route('admin.applications.index') }}" class="btn btn-primary" style="margin-top: 1rem; width: 100%;">View All Applications</a>
        </div>
        <div class="card">
            <h3>Manage Job Portal</h3>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary" style="margin-top: 1rem; width: 100%;">View All Jobs</a>
        </div>
    </div>
</div>
@endsection
