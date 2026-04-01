@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 3rem auto;">
    <h1>Edit Company Profile</h1>
    <p class="card-meta">Update your company details.</p>

    <form action="{{ route('companies.update', $company) }}" method="POST" enctype="multipart/form-data" style="margin-top: 2rem;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" required>
            @error('name')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="logo">Company Logo</label>
            <input type="file" name="logo" id="logo">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} logo" style="width: 100px; margin-top: 1rem;">
            @endif
            @error('logo')
                <p style="color: var(--danger-color); font-size: 0.8rem;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Update Company</button>
    </form>
</div>
@endsection
