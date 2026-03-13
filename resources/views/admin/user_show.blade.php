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
            <span class="current">{{ $user->name }}</span>
        </nav>
        <h1 class="page-title">{{ $user->name }}</h1>
        <p class="page-subtitle">User profile details</p>
    </div>
    <div class="page-header-actions" style="display: flex; gap: 8px;">
        <a href="{{ route('admin.users.email', $user) }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-envelope"></i>
            Send Email
        </a>
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-admin btn-admin-secondary" style="border-color: var(--admin-danger); color: var(--admin-danger);" onclick="return confirm('Are you sure you want to delete this user and all their data?')">
                <i class="bi bi-trash"></i>
                Delete User
            </button>
        </form>
        <a href="{{ route('admin.users') }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- User Info Card -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-body" style="text-align: center; padding: 32px 24px;">
                <div class="user-avatar" style="width: 80px; height: 80px; margin: 0 auto 16px; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: var(--admin-primary); color: #fff;">
                    <span class="initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <h3 style="color: var(--admin-text); margin-bottom: 4px;">{{ $user->name }}</h3>
                <p style="color: var(--admin-text-muted); margin-bottom: 20px;">{{ $user->email }}</p>

                <div style="text-align: left; display: flex; flex-direction: column; gap: 12px; font-size: 0.9rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--admin-text-muted);">Business</span>
                        <span style="color: var(--admin-text);">{{ $user->business_name ?? '—' }}</span>
                    </div>
                    @if($user->website_url)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--admin-text-muted);">Website URL</span>
                        <a href="{{ $user->website_url }}" target="_blank" style="color: var(--admin-primary-light);">{{ $user->website_url }}</a>
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--admin-text-muted);">Websites</span>
                        <span style="color: var(--admin-text);">{{ $user->websites_count }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--admin-text-muted);">Testimonials</span>
                        <span style="color: var(--admin-text);">{{ $testimonials->count() }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--admin-text-muted);">Joined</span>
                        <span style="color: var(--admin-text);">{{ $user->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-8 d-flex flex-column gap-4">

        <!-- Websites Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="bi bi-globe2"></i>
                    Websites ({{ $user->websites->count() }})
                </h3>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Testimonials</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->websites as $website)
                            <tr>
                                <td style="font-weight: 600; color: var(--admin-text);">{{ $website->name }}</td>
                                <td><a href="{{ $website->url }}" target="_blank" style="color: var(--admin-primary-light);">{{ $website->url }}</a></td>
                                <td>{{ $website->testimonials->count() }}</td>
                                <td>
                                    @if($website->is_active)
                                        <span class="status-badge active">Active</span>
                                    @else
                                        <span class="status-badge inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons" style="display: flex; gap: 6px;">
                                        @if(!$website->is_active)
                                        <form action="{{ route('admin.websites.approve', $website) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="action-btn view" title="Approve Website" onclick="return confirm('Approve this website?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.websites.reject', $website) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="action-btn delete" title="Reject Website" onclick="return confirm('Reject this website?')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon"><i class="bi bi-globe2"></i></div>
                                        <div class="empty-state-title">No websites</div>
                                        <div class="empty-state-text">This user hasn't added any websites yet.</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Testimonials Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="bi bi-chat-quote-fill"></i>
                    Testimonials ({{ $testimonials->count() }})
                </h3>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Website</th>
                                <th>Content</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $t)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">
                                            <span class="initials">{{ strtoupper(substr($t->author_name, 0, 1)) }}</span>
                                        </div>
                                        <div class="user-info">
                                            <div class="user-name">{{ $t->author_name }}</div>
                                            <div class="user-email">{{ $t->author_email ?? '' }}</div>
                                            @if($t->author_role)
                                                <div class="user-email">{{ $t->author_role }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $t->website->name ?? '—' }}</td>
                                <td style="max-width: 250px; white-space: normal; font-size: 0.85rem; color: var(--admin-text-muted);">{{ Str::limit($t->content, 100) }}</td>
                                <td style="color: #f59e0b; white-space: nowrap;">{{ $t->starString() }}</td>
                                <td>
                                    @if($t->status === 'approved')
                                        <span class="status-badge active">Approved</span>
                                    @elseif($t->status === 'pending')
                                        <span class="status-badge" style="background: rgba(245,158,11,0.15); color: #f59e0b;">Pending</span>
                                    @else
                                        <span class="status-badge inactive">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $t->created_at->format('M j, Y') }}</div>
                                    <small style="color: var(--admin-text-muted);">{{ $t->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon"><i class="bi bi-chat-square-quote"></i></div>
                                        <div class="empty-state-title">No testimonials</div>
                                        <div class="empty-state-text">No testimonials found for this user's websites.</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.footer')
