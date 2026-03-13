@extends('layouts.tcn')

@section('title', 'Log In – TrustCredNet')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="auth-logo">
            <div class="logo-icon-wrap" aria-hidden="true">
                <i class="bi bi-shield-fill-check"></i>
            </div>
            <span class="auth-logo-text">Trust<span>Cred</span>Net</span>
        </a>

        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Sign in to your TrustCredNet account</p>

        {{-- Error messages --}}
        @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        {{-- Status (e.g. after password reset) --}}
        @if(session('status'))
        <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;color:#16a34a;padding:12px 16px;border-radius:10px;font-size:.875rem;margin-bottom:18px;">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <input
                    type="email" id="email" name="email"
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}"
                    placeholder="you@company.com"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position:relative;">
                    <input
                        type="password" id="password" name="password"
                        class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                        style="padding-right:44px;"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Toggle password visibility" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--tcn-gray);font-size:1.1rem;padding:0;line-height:1;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="auth-remember">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit" class="auth-submit">
                <i class="bi bi-box-arrow-in-right"></i> Sign In
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Sign up free</a>
        </div>

    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
@endsection
