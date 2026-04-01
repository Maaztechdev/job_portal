@extends('layouts.app')

@section('content')
<div style="margin-top: 3rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Employer Dashboard</h1>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">Post New Job</a>
    </div>

    <div class="stats-grid">
        <div class="stat-item">
            <h3>{{ $jobs->count() }}</h3>
            <p>Active Jobs</p>
        </div>
        <div class="stat-item">
            <h3>{{ $total_applications }}</h3>
            <p>Total Applicants</p>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <h3>My Job Listings</h3>
        @if($jobs->isEmpty())
            <p style="text-align: center; padding: 2rem;">You haven't posted any jobs yet. <a href="{{ route('employer.jobs.create') }}">Post your first job</a></p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Applicants</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ ucfirst($job->type) }}</td>
                            <td>{{ $job->applications_count }}</td>
                            <td>{{ $job->created_at->format('M d, Y') }}</td>
                            <td style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('employer.jobs.applicants', $job) }}" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; background: var(--secondary-color); color: var(--white);">View Applicants</a>
                                <a href="{{ route('employer.jobs.edit', $job) }}" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; background: var(--dark-color); color: var(--white);">Edit</a>
                                <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
