@extends('layouts.app')

@section('content')
<div class="hero">
    <div class="container">
        <h1>Find Your Dream Job</h1>
        <p>Thousands of jobs waiting for you to apply</p>

        <form action="{{ route('jobs.index') }}" method="GET" style="display: flex; gap: 0.5rem; justify-content: center; margin-top: 2rem;">
            @foreach(request()->only(['category', 'type']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <div class="form-group" style="flex: 1; max-width: 400px; margin-bottom: 0;">
                <input type="text" name="search" placeholder="Job title or keywords" value="{{ request('search') }}">
            </div>
            <div class="form-group" style="flex: 1; max-width: 250px; margin-bottom: 0;">
                <input type="text" name="location" placeholder="Location" value="{{ request('location') }}">
            </div>
            <button type="submit" class="btn btn-primary" style="background: var(--dark-color);">Search</button>
        </form>
    </div>
</div>

<div class="jobs-list">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Featured Jobs</h2>
        <div class="filters">
            <form action="{{ route('jobs.index') }}" method="GET" id="filter-form" style="display: flex; gap: 1rem;">
                @foreach(request()->except(['category', 'type', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select name="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Engineering" {{ request('category') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="Design" {{ request('category') == 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Marketing" {{ request('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                </select>
                <select name="type" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="remote" {{ request('type') == 'remote' ? 'selected' : '' }}>Remote</option>
                </select>
            </form>
        </div>
    </div>

    @forelse($jobs as $job)
        <div class="card" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 class="card-title">{{ $job->title }}</h3>
                <p class="card-meta">
                    <strong>{{ $job->employer->name }}</strong> |
                    <span>{{ $job->location }}</span> |
                    <span>{{ ucfirst($job->type) }}</span> |
                    <span>{{ $job->category }}</span>
                </p>
                <p>{{ Str::limit($job->description, 150) }}</p>
            </div>
            <div>
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    @empty
        <p style="text-align: center; margin: 4rem 0;">No jobs found matching your criteria.</p>
    @endforelse

    <div style="margin-top: 2rem;">
        {{ $jobs->appends(request()->query())->links() }}
    </div>
</div>
@endsection
