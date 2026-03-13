@include('admin.header')
@include('admin.navbar')

<!-- Page Header -->
<div class="page-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <span class="current">Testimonials</span>
        </nav>
        <h1 class="page-title">Testimonials</h1>
        <p class="page-subtitle">All testimonials across the platform</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="bi bi-chat-quote-fill"></i>
            All Testimonials
        </h3>
        <span style="color: var(--admin-text-muted); font-size: 14px;">{{ $testimonials->total() }} total</span>
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
                                <div class="empty-state-icon"><i class="bi bi-chat-square-quote"></i></div>
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

    @if($testimonials->hasPages())
    <div class="admin-card-footer">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="color: var(--admin-text-muted); font-size: 14px;">
                Showing <strong>{{ $testimonials->firstItem() }}</strong> to <strong>{{ $testimonials->lastItem() }}</strong> of <strong>{{ $testimonials->total() }}</strong>
            </div>
            <div class="admin-pagination">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@include('admin.footer')
