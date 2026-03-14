@extends('layouts.tcn')

@section('title', 'Register Your Business – TrustCredNet')
@section('description', 'Create your free TrustCredNet account. Start collecting verified customer reviews and build the trust that grows your business.')
@section('og_title', 'Register Your Business – TrustCredNet')
@section('og_description', 'Join thousands of businesses on TrustCredNet. Collect verified reviews, showcase your reputation, and convert more customers.')

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

        <h1 class="auth-title">Register your business</h1>
        <p class="auth-sub">Start building trust with your customers today</p>

        {{-- Validation errors --}}
        @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-circle-fill" style="flex-shrink:0;margin-top:1px;"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Business Name --}}
            <div class="form-group">
                <label for="business_name" class="form-label">
                    <i class="bi bi-building me-1"></i>Business Name
                </label>
                <input
                    type="text" id="business_name" name="business_name"
                    class="form-input {{ $errors->has('business_name') ? 'is-invalid' : '' }}"
                    value="{{ old('business_name') }}"
                    placeholder="e.g. GreenLeaf Organics"
                    autocomplete="organization"
                    required
                >
                @error('business_name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- Owner Name --}}
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="bi bi-person me-1"></i>Owner Name
                </label>
                <input
                    type="text" id="name" name="name"
                    class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    value="{{ old('name') }}"
                    placeholder="Your full name"
                    autocomplete="name"
                    required
                >
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i>Email Address
                </label>
                <input
                    type="email" id="email" name="email"
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}"
                    placeholder="you@company.com"
                    autocomplete="email"
                    required
                >
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i>Password
                </label>
                <div style="position:relative;">
                    <input
                        type="password" id="password" name="password"
                        class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="At least 8 characters"
                        autocomplete="new-password"
                        required
                        style="padding-right:44px;"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Toggle password visibility" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--tcn-gray);font-size:1.1rem;padding:0;line-height:1;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill me-1"></i>Confirm Password
                </label>
                <div style="position:relative;">
                    <input
                        type="password" id="password_confirmation" name="password_confirmation"
                        class="form-input"
                        placeholder="Repeat your password"
                        autocomplete="new-password"
                        required
                        style="padding-right:44px;"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" aria-label="Toggle password visibility" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--tcn-gray);font-size:1.1rem;padding:0;line-height:1;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Website URL --}}
            <div class="form-group">
                <label for="website_url" class="form-label">
                    <i class="bi bi-globe me-1"></i>Website URL
                </label>
                <input
                    type="url" id="website_url" name="website_url"
                    class="form-input {{ $errors->has('website_url') ? 'is-invalid' : '' }}"
                    value="{{ old('website_url') }}"
                    placeholder="https://yourwebsite.com"
                    autocomplete="url"
                >
                @error('website_url')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- Logo Upload (optional) --}}
            <div class="form-group">
                <label for="logo" class="form-label">
                    <i class="bi bi-image me-1"></i>Business Logo
                    <span style="font-weight:400;color:var(--tcn-gray);margin-left:4px;">(optional)</span>
                </label>
                <div class="file-upload-area {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="fileUploadArea">
                    <input
                        type="file" id="logo" name="logo"
                        accept="image/png,image/jpeg,image/webp,image/svg+xml"
                        class="file-upload-input"
                        onchange="previewLogo(this)"
                    >
                    <div class="file-upload-placeholder" id="fileUploadPlaceholder">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Drop your logo here or <strong>browse</strong></span>
                        <small>PNG, JPG, WebP or SVG · Max 2 MB</small>
                    </div>
                    <div class="file-upload-preview" id="fileUploadPreview" style="display:none;">
                        <img id="logoPreviewImg" src="" alt="Logo preview">
                        <span id="logoFileName"></span>
                        <button type="button" class="file-remove-btn" onclick="removeLogo()">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                </div>
                @error('logo')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="auth-submit">
                <i class="bi bi-building-add"></i> Register Business
            </button>

            <p class="auth-terms">
                By creating an account you agree to our
                <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </p>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
function previewLogo(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('logoPreviewImg').src = e.target.result;
        document.getElementById('logoFileName').textContent = file.name;
        document.getElementById('fileUploadPlaceholder').style.display = 'none';
        document.getElementById('fileUploadPreview').style.display = 'flex';
    };
    reader.readAsDataURL(file);
}
function removeLogo() {
    document.getElementById('logo').value = '';
    document.getElementById('logoPreviewImg').src = '';
    document.getElementById('logoFileName').textContent = '';
    document.getElementById('fileUploadPreview').style.display = 'none';
    document.getElementById('fileUploadPlaceholder').style.display = 'flex';
}
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
// Drag-and-drop support
(function () {
    const area = document.getElementById('fileUploadArea');
    if (!area) return;
    area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('drag-over'); });
    area.addEventListener('dragleave', () => area.classList.remove('drag-over'));
    area.addEventListener('drop', e => {
        e.preventDefault();
        area.classList.remove('drag-over');
        const input = document.getElementById('logo');
        input.files = e.dataTransfer.files;
        previewLogo(input);
    });
})();
</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/69b592721ff85f1c36fe4864/1jjmk84is';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
@endsection
