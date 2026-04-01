@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 800px; margin: 3rem auto;">
    <h1>Edit Job: {{ $job->title }}</h1>
    <p class="card-meta">Update your job listing details.</p>

    <form action="{{ route('employer.jobs.update', $job) }}" method="POST" style="margin-top: 2rem;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" required>
            @error('title')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea name="description" id="description" rows="8" required>{{ old('description', $job->description) }}</textarea>
            @error('description')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $job->location) }}" required>
                @error('location')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <option value="Engineering" {{ old('category', $job->category) == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="Design" {{ old('category', $job->category) == 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Marketing" {{ old('category', $job->category) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Finance" {{ old('category', $job->category) == 'Finance' ? 'selected' : '' }}>Finance</option>
                </select>
                @error('category')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="salary">Salary (Optional)</label>
                <input type="text" name="salary" id="salary" value="{{ old('salary', $job->salary) }}">
                @error('salary')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Job Type</label>
                <select name="type" id="type" required>
                    <option value="full-time" {{ old('type', $job->type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ old('type', $job->type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="remote" {{ old('type', $job->type) == 'remote' ? 'selected' : '' }}>Remote</option>
                </select>
                @error('type')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Update Job</button>
    </form>
</div>
@endsection
