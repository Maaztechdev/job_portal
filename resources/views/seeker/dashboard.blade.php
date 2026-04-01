
@extends('layouts.app')

@section('content')
<div style="margin-top: 48px;">
    <h1>My Dashboard</h1>
    <p class="card-meta">Welcome back, {{ auth()->user()->name }}!</p>

    <div class="stats-grid" style="margin-top: 32px;">
        <div class="stat-item">
            <h3>{{ $applications->count() }}</h3>
            <p>Total Applications</p>
        </div>
        <div class="stat-item">
            <h3>{{ $applications->where('status', 'accepted')->count() }}</h3>
            <p>Accepted Applications</p>
        </div>
        <div class="stat-item">
            <h3>{{ $applications->where('status', 'pending')->count() }}</h3>
            <p>Pending Applications</p>
        </div>
    </div>

    <div class="card" style="margin-top: 32px;">
        <h3>My Applied Jobs</h3>
        @if($applications->isEmpty())
            <p style="text-align: center; padding: 32px;">You haven't applied for any jobs yet. <a href="{{ route('jobs.index') }}">Browse jobs now</a></p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->job?->title ?? 'N/A' }}</td>
                            <td>{{ $application->job?->employer?->name ?? 'N/A' }}</td>
                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $application->status }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>
                                @if($application->job)
                                    <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 12.8px;">View Job</a>
                                @else
                                    <span style="font-size: 12.8px; color: #777;">Job Deleted</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
