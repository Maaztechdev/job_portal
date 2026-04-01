@extends('layouts.app')

@section('content')
<div style="margin-top: 3rem;">
    <h1>My Saved Jobs</h1>
    <p class="card-meta">You have {{ $savedJobs->total() }} saved jobs.</p>

    <div class="card" style="margin-top: 2rem;">
        @if($savedJobs->isEmpty())
            <p style="text-align: center; padding: 2rem;">You have no saved jobs. <a href="{{ route('jobs.index') }}">Browse jobs</a> to save them.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savedJobs as $savedJob)
                        <tr>
                            <td>{{ $savedJob->job->title }}</td>
                            <td>{{ $savedJob->job->employer->name }}</td>
                            <td>{{ $savedJob->job->location }}</td>
                            <td style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('jobs.show', $savedJob->job) }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View</a>
                                <form action="{{ route('saved-jobs.destroy', $savedJob) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Unsave</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 2rem;">
                {{ $savedJobs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
