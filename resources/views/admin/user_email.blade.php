@include('admin.header')
@include('admin.navbar')

<!-- Page Header -->
<div class="page-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <a href="{{ route('admin.users') }}">Users</a>
            <span class="separator">/</span>
            <span class="current">Send Email</span>
        </nav>
        <h1 class="page-title">Send Email</h1>
        <p class="page-subtitle">Send an email to {{ $user->name }} ({{ $user->email }})</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.users.show', $user) }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Profile
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="bi bi-envelope-fill"></i>
                    Compose Email
                </h3>
            </div>
            <div class="admin-card-body">
                @if($errors->any())
                    <div class="admin-alert admin-alert-error" style="margin-bottom: 20px;">
                        <i class="admin-alert-icon bi bi-exclamation-circle-fill"></i>
                        <div class="admin-alert-content">
                            <div class="admin-alert-message">{{ $errors->first() }}</div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.email.send', $user) }}">
                    @csrf

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">To</label>
                        <input type="text" value="{{ $user->name }} <{{ $user->email }}>" disabled
                               style="width: 100%; padding: 10px 14px; border-radius: var(--admin-radius-sm); border: 1px solid var(--admin-border-light); background: var(--admin-surface); color: var(--admin-text-muted); font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="subject" style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               placeholder="Enter email subject"
                               style="width: 100%; padding: 10px 14px; border-radius: var(--admin-radius-sm); border: 1px solid var(--admin-border-light); background: var(--admin-surface-light); color: var(--admin-text); font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label for="body" style="display: block; margin-bottom: 6px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">Message</label>
                        <textarea id="body" name="body" rows="8" required
                                  placeholder="Write your message here..."
                                  style="width: 100%; padding: 10px 14px; border-radius: var(--admin-radius-sm); border: 1px solid var(--admin-border-light); background: var(--admin-surface-light); color: var(--admin-text); font-size: 0.9rem; resize: vertical;">{{ old('body') }}</textarea>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn-admin btn-admin-primary">
                            <i class="bi bi-send-fill"></i>
                            Send Email
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn-admin btn-admin-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')
