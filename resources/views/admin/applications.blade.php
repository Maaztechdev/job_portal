@extends('layouts.app')

@section('content')
<div style="margin-top: 3rem;">
    <h1>All Job Applications</h1>
    <p class="card-meta">A complete list of all applications in the system.</p>

    <div class="card" style="margin-top: 2rem;">
        @if($applications->isEmpty())
            <p style="text-align: center; padding: 2rem;">No applications found in the system.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Applicant</th>
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
                            <td>{{ $application->user?->name ?? 'N/A' }}</td>
                            <td>{{ $application->job?->employer?->name ?? 'N/A' }}</td>
                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $application->status }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>
                                @if($application->job)
                                    <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View Job</a>
                                @else
                                    <span style="font-size: 0.8rem; color: #777;">Job Deleted</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 2rem;">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
