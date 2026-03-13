@include('admin.header')
@include('admin.navbar')

<!-- Page Header -->
<div class="page-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Home</a>
            <span class="separator">/</span>
            <span class="current">Dashboard</span>
        </nav>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Administrator' }}. Here's what's happening today.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.users') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-people-fill"></i>
            Manage Users
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Users Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon purple">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
        <div class="stat-label">Total Users</div>
    </div>

    <!-- Websites Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon green">
                <i class="bi bi-globe2"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalWebsites) }}</div>
        <div class="stat-label">Total Websites</div>
    </div>

    <!-- Testimonials Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon blue">
                <i class="bi bi-chat-quote-fill"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalTestimonials) }}</div>
        <div class="stat-label">Total Testimonials</div>
    </div>

    <!-- Pending Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($pendingTestimonials) }}</div>
        <div class="stat-label">Pending Review</div>
    </div>

    <!-- Avg Rating Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon pink">
                <i class="bi bi-star-fill"></i>
            </div>
        </div>
        <div class="stat-value">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
        <div class="stat-label">Average Rating</div>
    </div>
</div>

<!-- Recent Users Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="bi bi-people-fill"></i>
            Recent Users
        </h3>
        <a href="{{ route('admin.users') }}" class="btn-admin btn-admin-secondary btn-admin-sm">
            View All
        </a>
    </div>

    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Business</th>
                        <th>Websites</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    <span class="initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->business_name ?? '—' }}</td>
                        <td>{{ $user->websites_count }}</td>
                        <td>
                            <div>{{ $user->created_at->format('M j, Y') }}</div>
                            <small style="color: var(--admin-text-muted);">{{ $user->created_at->format('g:i A') }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="empty-state-title">No users found</div>
                                <div class="empty-state-text">There are no registered users yet.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Testimonials Table -->
<div class="admin-card" style="margin-top: 24px;">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="bi bi-chat-quote-fill"></i>
            Recent Testimonials
        </h3>
        <a href="{{ route('admin.testimonials') }}" class="btn-admin btn-admin-secondary btn-admin-sm">
            View All
        </a>
    </div>

    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Website</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTestimonials as $t)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    <span class="initials">{{ strtoupper(substr($t->author_name, 0, 1)) }}</span>
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $t->author_name }}</div>
                                    <div class="user-email">{{ $t->author_email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $t->website->name ?? '—' }}</td>
                        <td style="color: #f59e0b;">{{ $t->starString() }}</td>
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
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-chat-square-quote"></i>
                                </div>
                                <div class="empty-state-title">No testimonials yet</div>
                                <div class="empty-state-text">No testimonials have been submitted yet.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.footer')
