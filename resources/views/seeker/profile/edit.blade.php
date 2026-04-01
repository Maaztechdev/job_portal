@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 800px; margin: 3rem auto;">
    <h1>My Profile</h1>
    <p class="card-meta">Keep your profile updated to attract employers.</p>

    <form action="{{ route('seeker.profile.update') }}" method="POST" enctype="multipart/form-data" style="margin-top: 2rem;">
        @csrf
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" rows="5" placeholder="Write a short bio about yourself...">{{ old('bio', $profile->bio) }}</textarea>
            @error('bio')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="skills">Skills</label>
            <input type="text" name="skills" id="skills" value="{{ old('skills', $profile->skills) }}" placeholder="e.g. PHP, Laravel, React, etc.">
            @error('skills')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="experience">Experience</label>
            <input type="text" name="experience" id="experience" value="{{ old('experience', $profile->experience) }}" placeholder="e.g. 3 years as a Software Engineer">
            @error('experience')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="resume">Resume (PDF/DOC/DOCX)</label>
            <input type="file" name="resume" id="resume">
            @if($profile->resume)
                <p style="margin-top: 0.5rem; font-size: 0.9rem;">
                    Current Resume: <a href="{{ asset('storage/' . $profile->resume) }}" target="_blank" style="color: var(--primary-color);">Download</a>
                </p>
            @endif
            @error('resume')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Update Profile</button>
    </form>
</div>
@endsection
