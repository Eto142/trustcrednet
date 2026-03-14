@extends('dashboard.layouts.app')
@section('title', 'Add Website – TrustCredNet')
@section('page-title', 'Add Website')

@section('content')

<div class="row">
<div class="col-lg-7">

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">New Website</h2>
        <a href="{{ route('dashboard.websites.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('dashboard.websites.store') }}">
        @csrf

        <div class="dash-form-group">
            <label class="dash-form-label" for="name">Website / Business Name <span style="color:#DC2626;">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="dash-form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                   placeholder="e.g. My Online Store" required>
            @error('name') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="dash-form-group">
            <label class="dash-form-label" for="url">Website URL <span style="color:#DC2626;">*</span></label>
            <input type="url" id="url" name="url" value="{{ old('url') }}"
                   class="dash-form-input {{ $errors->has('url') ? 'is-invalid' : '' }}"
                   placeholder="https://yourwebsite.com" required>
            @error('url') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="dash-form-group">
            <label class="dash-form-label" for="description">Description <span style="color:var(--tcn-gray);font-weight:400;">(optional)</span></label>
            <textarea id="description" name="description" rows="6"
                      class="dash-form-input {{ $errors->has('description') ? 'is-invalid' : '' }}"
                      maxlength="5000"
                      placeholder="Short description of this website or product…"
                      oninput="document.getElementById('desc-count').textContent=this.value.length">{{ old('description') }}</textarea>
            <div class="dash-form-help" style="text-align:right;">
                <span id="desc-count">{{ strlen(old('description','')) }}</span> / 5000
            </div>
            @error('description') <div class="dash-form-error">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="dash-btn dash-btn-primary">
                <i class="bi bi-check-lg"></i> Save Website
            </button>
            <a href="{{ route('dashboard.websites.index') }}" class="dash-btn dash-btn-outline">Cancel</a>
        </div>
    </form>
</div>

</div>
</div>

@endsection
