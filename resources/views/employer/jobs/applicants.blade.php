@extends('layouts.app')

@section('content')
<div style="margin-top: 3rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Applicants for {{ $job->title }}</h1>
        <a href="{{ route('employer.dashboard') }}" class="btn" style="background: var(--dark-color); color: var(--white);">Back to Dashboard</a>
    </div>

    @if($applications->isEmpty())
        <p style="text-align: center; padding: 4rem;">No applications received for this job yet.</p>
    @else
        @foreach($applications as $application)
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <h3>{{ $application->user?->name ?? 'User Deleted' }}</h3>
                        <p class="card-meta">
                            <strong>Applied on:</strong> {{ $application->created_at->format('M d, Y') }} |
                            <strong>Email:</strong> {{ $application->user?->email ?? 'N/A' }}
                        </p>
                        @if($application->user?->profile)
                            <p><strong>Skills:</strong> {{ $application->user->profile->skills ?: 'Not specified' }}</p>
                            <p><strong>Experience:</strong> {{ $application->user->profile->experience ?: 'Not specified' }}</p>
                            @if($application->user->profile->resume)
                                <a href="{{ asset('storage/' . $application->user->profile->resume) }}" target="_blank" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; background: var(--primary-color); color: var(--white); margin-top: 1rem; display: inline-block;">Download Resume</a>
                            @endif
                        @else
                            <p style="margin-top: 1rem;"><em>No profile information available for this user.</em></p>
                        @endif
                        <div style="margin-top: 1.5rem; background: var(--light-color); padding: 1rem; border-radius: 8px;">
                            <strong>Cover Letter:</strong>
                            <p style="white-space: pre-line; margin-top: 0.5rem;">{{ $application->cover_letter }}</p>
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('employer.applications.status', $application) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color);">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </form>
                        <form action="{{ route('messages.start', ['receiver' => $application->user->id]) }}" method="POST" style="margin-top: 0.5rem;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
