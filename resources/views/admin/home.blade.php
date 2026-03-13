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
        <p class="page-subtitle">Welcome back, Administrator. Here's what's happening today.</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.manage.users') }}" class="btn-admin btn-admin-primary">
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

    <!-- Deposits Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon green">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalDeposits) }}</div>
        <div class="stat-label">Total Deposits</div>
    </div>

    <!-- Loans Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon blue">
                <i class="bi bi-bank"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalLoans) }}</div>
        <div class="stat-label">Total Loans</div>
    </div>

    <!-- Transactions Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon orange">
                <i class="bi bi-arrow-left-right"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalTransactions) }}</div>
        <div class="stat-label">Total Transactions</div>
    </div>

    <!-- Cards Card -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon pink">
                <i class="bi bi-credit-card-2-front-fill"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($totalCards) }}</div>
        <div class="stat-label">Total Cards</div>
    </div>
</div>

<!-- User Management Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="bi bi-people-fill"></i>
            User Management
        </h3>
        <a href="{{ route('admin.manage.users') }}" class="btn-admin btn-admin-secondary btn-admin-sm">
            View All
        </a>
    </div>
    
    <div class="admin-card-body" style="padding: 0;">
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Registration</th>
                        <th>Status</th>
                        <th>Verification</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($result as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    @if($user->display_picture)
                                        <img src="{{ asset('uploads/display/'.$user->display_picture) }}" alt="{{ $user->first_name }}">
                                    @else
                                        <span class="initials">{{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->first_name }} {{ $user->last_name ?? '' }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($user->created_at)->format('M j, Y') }}</div>
                            <small style="color: var(--admin-text-muted);">{{ \Carbon\Carbon::parse($user->created_at)->format('g:i A') }}</small>
                        </td>
                        <td>
                            @if($user->user_status == 1)
                                <span class="status-badge active">Active</span>
                            @else
                                <span class="status-badge inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="status-badge verified">Verified</span>
                            @else
                                <span class="status-badge unverified">Unverified</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.profile', $user->id) }}" class="action-btn view" title="View Profile">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.send-user-mail', $user->id) }}" class="action-btn email" title="Send Email">
                                    <i class="bi bi-envelope"></i>
                                </a>
                                <form action="{{ route('admin.delete', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
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

    @if($result->hasPages())
    <div class="admin-card-footer">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="color: var(--admin-text-muted); font-size: 14px;">
                Showing <strong>{{ $result->firstItem() }}</strong> to <strong>{{ $result->lastItem() }}</strong> of <strong>{{ $result->total() }}</strong> entries
            </div>
            <div class="admin-pagination">
                @if($result->onFirstPage())
                    <span class="page-link disabled">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $result->previousPageUrl() }}" class="page-link">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                @endif

                @foreach($result->getUrlRange(1, $result->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-link {{ $result->currentPage() == $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($result->hasMorePages())
                    <a href="{{ $result->nextPageUrl() }}" class="page-link">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @else
                    <span class="page-link disabled">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

@include('admin.footer')
