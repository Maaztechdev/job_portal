@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 800px; margin: 3rem auto;">
    <h1>Post a New Job</h1>
    <p class="card-meta">Find the right talent for your company.</p>

    <form action="{{ route('employer.jobs.store') }}" method="POST" style="margin-top: 2rem;">
        @csrf
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Software Engineer">
            @error('title')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea name="description" id="description" rows="8" required placeholder="Describe the job, requirements, etc...">{{ old('description') }}</textarea>
            @error('description')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" required placeholder="e.g. New York, NY">
                @error('location')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <option value="">Select Category</option>
                    <option value="Engineering" {{ old('category') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="Design" {{ old('category') == 'Design' ? 'selected' : '' }}>Design</option>
                    <option value="Marketing" {{ old('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Finance" {{ old('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                </select>
                @error('category')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label for="salary">Salary (Optional)</label>
                <input type="text" name="salary" id="salary" value="{{ old('salary') }}" placeholder="e.g. $50,000 - $80,000">
                @error('salary')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Job Type</label>
                <select name="type" id="type" required>
                    <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="remote" {{ old('type') == 'remote' ? 'selected' : '' }}>Remote</option>
                </select>
                @error('type')
                    <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Post Job</button>
    </form>
</div>
@endsection
