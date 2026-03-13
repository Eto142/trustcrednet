@extends('dashboard.layouts.app')
@section('title', 'Edit Website – TrustCredNet')
@section('page-title', 'Edit Website')

@section('content')

<div class="row">
<div class="col-lg-7">

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">Edit: {{ $website->name }}</h2>
        <a href="{{ route('dashboard.websites.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.websites.update', $website) }}">
        @csrf
        @method('PUT')

        <div class="dash-form-group">
            <label class="dash-form-label" for="name">Website / Business Name <span style="color:#DC2626;">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $website->name) }}"
                   class="dash-form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                   placeholder="e.g. My Online Store" required>
            @error('name') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="dash-form-group">
            <label class="dash-form-label" for="url">Website URL <span style="color:#DC2626;">*</span></label>
            <input type="url" id="url" name="url" value="{{ old('url', $website->url) }}"
                   class="dash-form-input {{ $errors->has('url') ? 'is-invalid' : '' }}"
                   placeholder="https://yourwebsite.com" required>
            @error('url') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="dash-form-group">
            <label class="dash-form-label" for="description">Description <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
            <textarea id="description" name="description" rows="3"
                      class="dash-form-input {{ $errors->has('description') ? 'is-invalid' : '' }}"
                      placeholder="Short description…">{{ old('description', $website->description) }}</textarea>
            @error('description') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        @if($website->is_active)
        <div class="dash-form-group">
            <span class="dash-form-label" style="margin:0;color:var(--tcn-green);"><i class="bi bi-check-circle-fill me-1"></i>Approved &amp; Active</span>
        </div>
        @else
        <div class="dash-form-group">
            <span class="dash-form-label" style="margin:0;color:var(--tcn-gray);"><i class="bi bi-clock me-1"></i>Pending admin approval</span>
        </div>
        @endif

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="dash-btn dash-btn-primary">
                <i class="bi bi-check-lg"></i> Save Changes
            </button>
            <a href="{{ route('dashboard.websites.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
        </div>
    </form>
</div>

</div>
</div>

@endsection
