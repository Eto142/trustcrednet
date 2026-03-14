@include('admin.header')
@include('admin.navbar')

<div class="page-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.users') }}">Users</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>
            <span class="separator">/</span>
            <span class="current">Edit</span>
        </nav>
        <h1 class="page-title">Edit User</h1>
        <p class="page-subtitle">{{ $user->name }} &mdash; {{ $user->email }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.users.show', $user) }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

@if($errors->any())
<div class="admin-alert" style="margin-bottom:20px;padding:12px 18px;border-radius:8px;background:#FEE2E2;border:1px solid #FECACA;color:#991B1B;">
    <i class="bi bi-exclamation-circle-fill"></i>
    <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="admin-card" style="max-width:520px;">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="bi bi-sliders"></i> Account Limits</h3>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="website_limit" class="form-label fw-semibold">Website Limit</label>
                <input type="number" min="1" name="website_limit" id="website_limit"
                       class="form-control @error('website_limit') is-invalid @enderror"
                       value="{{ old('website_limit', $user->website_limit) }}" required>
                @error('website_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Maximum number of websites this user can add.</small>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-admin btn-admin-primary">
                    <i class="bi bi-floppy-fill"></i> Save Changes
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="btn-admin btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@include('admin.footer')
