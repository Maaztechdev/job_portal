@extends('layouts.app')

@section('content')
<div class="card" style="margin-top: 3rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h1>{{ $job->title }}</h1>
            <p class="card-meta">
                <strong>{{ $job->employer->name }}</strong> |
                <span>{{ $job->location }}</span> |
                <span>{{ ucfirst($job->type) }}</span> |
                <span>{{ $job->category }}</span>
            </p>
        </div>
        <div>
            @if(auth()->check() && auth()->user()->role === 'seeker')
                @php
                    $applied = \App\Models\Application::where('user_id', auth()->id())->where('job_id', $job->id)->exists();
                @endphp
                @if($applied)
                    <button class="btn" style="background: var(--success-color); color: var(--white);" disabled>Already Applied</button>
                @else
                    <button id="apply-btn" class="btn btn-primary">Apply Now</button>
                @endif
            @elseif(!auth()->check())
                <a href="{{ route('login') }}" class="btn btn-primary">Login to Apply</a>
            @endif

            @if(auth()->check() && auth()->user()->role === 'seeker')
                @php
                    $saved = auth()->user()->savedJobs()->where('job_id', $job->id)->exists();
                @endphp
                @if($saved)
                    <form action="{{ route('saved-jobs.destroy', $job) }}" method="POST" style="margin-left: 1rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: var(--danger-color); margin-top: 5px; color: var(--white);">Unsave Job</button>
                    </form>
                @else
                    <form action="{{ route('saved-jobs.store', $job) }}" method="POST" style="margin-left: 1rem;">
                        @csrf
                        <button type="submit" class="btn" style="background: var(--accent-color); margin-top: 5px; color: var(--white);">Save Job</button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    <hr style="border: 0; border-top: 1px solid var(--border-color); margin-bottom: 2rem;">

    <div style="margin-bottom: 2rem;">
        <h3>Job Description</h3>
        <p style="white-space: pre-line;">{{ $job->description }}</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; background: var(--light-color); padding: 1.5rem; border-radius: 8px;">
        <div>
            <strong>Salary:</strong>
            <p>{{ $job->salary ?: 'Not Specified' }}</p>
        </div>
        <div>
            <strong>Category:</strong>
            <p>{{ $job->category }}</p>
        </div>
        <div>
            <strong>Location:</strong>
            <p>{{ $job->location }}</p>
        </div>
        <div>
            <strong>Type:</strong>
            <p>{{ ucfirst($job->type) }}</p>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role === 'seeker')
        <div id="apply-modal" class="modal" style="display:none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
            <div class="modal-content card" style="background-color: #fefefe; margin: 10% auto; padding: 2rem; border: 1px solid #888; width: 80%; max-width: 600px;">
                <span class="close" id="close-modal" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                <h2>Apply for {{ $job->title }}</h2>
                <form action="{{ route('seeker.jobs.apply', $job) }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label for="cover_letter">Cover Letter</label>
                        <textarea name="cover_letter" id="cover_letter" rows="8" required placeholder="Write your cover letter here..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Application</button>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('apply-btn')?.addEventListener('click', function() {
                document.getElementById('apply-modal').style.display = 'block';
            });
            document.getElementById('close-modal')?.addEventListener('click', function() {
                document.getElementById('apply-modal').style.display = 'none';
            });
            window.onclick = function(event) {
                if (event.target == document.getElementById('apply-modal')) {
                    document.getElementById('apply-modal').style.display = 'none';
                }
            }
        </script>
    @endif
</div>
@endsection
