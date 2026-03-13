@include('admin.header')
@include('admin.navbar')

<!-- Page Header -->
<div class="page-header">
    <div>
        <nav class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span class="separator">/</span>
            <span class="current">Websites</span>
        </nav>
        <h1 class="page-title">Websites</h1>
        <p class="page-subtitle">All registered websites across the platform</p>
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
            <i class="bi bi-globe2"></i>
            All Websites
        </h3>
        <span style="color: var(--admin-text-muted); font-size: 14px;">{{ $websites->total() }} total</span>
    </div>

    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Website</th>
                        <th>Owner</th>
                        <th>Testimonials</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($websites as $website)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-name">{{ $website->name }}</div>
                                <div class="user-email">{{ $website->url }}</div>
                            </div>
                        </td>
                        <td>{{ $website->user->name ?? '—' }}</td>
                        <td>{{ $website->testimonials_count }}</td>
                        <td>
                            @if($website->is_active)
                                <span class="status-badge active">Active</span>
                            @else
                                <span class="status-badge inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $website->created_at->format('M j, Y') }}</div>
                            <small style="color: var(--admin-text-muted);">{{ $website->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="action-buttons" style="display: flex; gap: 6px;">
                                @if(!$website->is_active)
                                <form action="{{ route('admin.websites.approve', $website) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="action-btn view" title="Approve" onclick="return confirm('Approve this website?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.websites.reject', $website) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="action-btn delete" title="Reject" onclick="return confirm('Reject this website?')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="bi bi-globe2"></i></div>
                                <div class="empty-state-title">No websites found</div>
                                <div class="empty-state-text">No websites have been registered yet.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($websites->hasPages())
    <div class="admin-card-footer">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="color: var(--admin-text-muted); font-size: 14px;">
                Showing <strong>{{ $websites->firstItem() }}</strong> to <strong>{{ $websites->lastItem() }}</strong> of <strong>{{ $websites->total() }}</strong>
            </div>
            <div class="admin-pagination">
                {{ $websites->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

@include('admin.footer')
