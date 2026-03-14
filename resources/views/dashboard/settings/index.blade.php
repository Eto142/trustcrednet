@extends('dashboard.layouts.app')
@section('title', 'Settings – TrustCredNet')
@section('page-title', 'Settings')

@section('content')

<div class="row g-4">
<div class="col-lg-8">

    {{-- Profile settings --}}
    <div class="dash-card" style="margin-bottom:24px;">
        <h2 class="dash-card-title" style="margin-bottom:4px;">Profile &amp; Business Info</h2>
        <p style="font-size:.84rem;color:var(--tcn-gray);margin-bottom:20px;">
            Update your name, email, logo, and website link.
        </p>

        <form method="POST" action="{{ route('dashboard.settings.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="name">Full Name <span style="color:#DC2626;">*</span></label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="dash-form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               required>
                        @error('name') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="business_name">Business Name <span style="color:#DC2626;">*</span></label>
                        <input type="text" id="business_name" name="business_name"
                               value="{{ old('business_name', $user->business_name) }}"
                               class="dash-form-input {{ $errors->has('business_name') ? 'is-invalid' : '' }}"
                               required>
                        @error('business_name') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="dash-form-group">
                <label class="dash-form-label" for="email">Email Address <span style="color:#DC2626;">*</span></label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="dash-form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       required>
                @error('email') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            <div class="dash-form-group">
                <label class="dash-form-label" for="website_url">Business Website URL</label>
                <input type="url" id="website_url" name="website_url"
                       value="{{ old('website_url', $user->website_url) }}"
                       class="dash-form-input {{ $errors->has('website_url') ? 'is-invalid' : '' }}"
                       placeholder="https://yourwebsite.com">
                @error('website_url') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            <div class="dash-form-group">
                <label class="dash-form-label" for="logo">Business Logo</label>
                @if($user->logo_path)
                    <div style="margin-bottom:10px;display:flex;align-items:center;gap:12px;">
                        <img src="{{ $user->logo_path }}" alt="Current logo"
                             style="width:56px;height:56px;border-radius:10px;object-fit:contain;border:1.5px solid var(--tcn-border);">
                        <span style="font-size:.82rem;color:var(--tcn-gray);">Current logo. Upload a new one to replace it.</span>
                    </div>
                @endif
                <input type="file" id="logo" name="logo" accept="image/*"
                       class="dash-form-input {{ $errors->has('logo') ? 'is-invalid' : '' }}"
                       style="padding:8px 14px;">
                <div class="dash-form-help">JPG, PNG, WEBP or SVG · Max 2 MB</div>
                @error('logo') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="dash-btn dash-btn-primary">
                <i class="bi bi-check-lg"></i> Save Profile
            </button>
        </form>
    </div>

    {{-- Change password --}}
    <div class="dash-card" style="margin-bottom:24px;">
        <h2 class="dash-card-title" style="margin-bottom:4px;">Change Password</h2>
        <p style="font-size:.84rem;color:var(--tcn-gray);margin-bottom:20px;">
            Use a strong password with uppercase letters, lowercase letters, and numbers.
        </p>

        <form method="POST" action="{{ route('dashboard.settings.password') }}">
            @csrf

            <div class="dash-form-group">
                <label class="dash-form-label" for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                       class="dash-form-input {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                       autocomplete="current-password" required>
                @error('current_password') <div class="dash-form-error">{{ $message }}</div> @enderror
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="password">New Password</label>
                        <input type="password" id="password" name="password"
                               class="dash-form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               autocomplete="new-password" required>
                        @error('password') <div class="dash-form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="dash-form-group">
                        <label class="dash-form-label" for="password_confirmation">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="dash-form-input" autocomplete="new-password" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="dash-btn dash-btn-primary">
                <i class="bi bi-shield-lock-fill"></i> Update Password
            </button>
        </form>
    </div>

    {{-- Subscription --}}
    <div class="dash-card">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
            <div>
                <h2 class="dash-card-title" style="margin-bottom:4px;">Subscription</h2>
                <p style="font-size:.84rem;color:var(--tcn-gray);margin:0;">
                    View your current plan, payment details, and how to activate.
                </p>
            </div>
            <a href="{{ route('dashboard.plan') }}" class="dash-btn dash-btn-primary">
                <i class="bi bi-lightning-charge-fill"></i> Manage Plan
            </a>
        </div>
    </div>

</div>
</div>

@endsection
