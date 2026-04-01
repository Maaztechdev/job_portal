@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 3rem auto;">
    <h1>Create Company Profile</h1>
    <p class="card-meta">Add your company details to attract top talent.</p>

    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" style="margin-top: 2rem;">
        @csrf
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="logo">Company Logo</label>
            <input type="file" name="logo" id="logo">
            @error('logo')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Create Company</button>
    </form>
</div>
@endsection
