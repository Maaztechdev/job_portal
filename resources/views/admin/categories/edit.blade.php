@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 3rem auto;">
    <h1>Edit Category</h1>
    <p class="card-meta">Update the job category details.</p>

    <form action="{{ route('categories.update', $category) }}" method="POST" style="margin-top: 2rem;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="icon">Icon (e.g., SVG path or Font Awesome class)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}">
            @error('icon')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Update Category</button>
    </form>
</div>
@endsection
