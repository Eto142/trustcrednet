@extends('dashboard.layouts.app')
@section('title', 'Testimonials – TrustCredNet')
@section('page-title', 'Testimonials')

@section('content')

{{-- Filter tabs --}}
<div class="dash-card" style="padding:0;overflow:hidden;">

    <div class="tm-header">
        <div class="tm-tabs-wrap">
            @foreach([
                ['key' => 'all',      'label' => 'All',      'count' => $counts['all']],
                ['key' => 'pending',  'label' => 'Pending',  'count' => $counts['pending']],
                ['key' => 'approved', 'label' => 'Approved', 'count' => $counts['approved']],
                ['key' => 'rejected', 'label' => 'Rejected', 'count' => $counts['rejected']],
            ] as $tab)
            <a href="{{ route('dashboard.testimonials.index', ['status' => $tab['key']]) }}"
               class="tm-tab {{ request('status', 'all') === $tab['key'] ? 'tm-tab-active' : '' }}">
                {{ $tab['label'] }}
                <span class="tm-tab-count {{ request('status', 'all') === $tab['key'] ? 'tm-tab-count-active' : '' }}">{{ $tab['count'] }}</span>
            </a>
            @endforeach
        </div>
        <a href="{{ route('dashboard.testimonials.create') }}" class="dash-btn dash-btn-primary dash-btn-sm tm-add-btn">
            <i class="bi bi-plus-lg"></i> Add Testimonial
        </a>
    </div>

    <div style="height:1px;background:var(--tcn-border);"></div>

    @if($testimonials->isEmpty())
        <div class="dash-empty" style="margin:12px 24px 24px;">
            <i class="bi bi-chat-quote"></i>
            <div class="dash-empty-title">No testimonials found</div>
            <p class="dash-empty-sub">
                @if(request('status') && request('status') !== 'all')
                    No {{ request('status') }} testimonials yet.
                @else
                    You haven't added any testimonials yet.
                @endif
            </p>
            <a href="{{ route('dashboard.testimonials.create') }}" class="dash-btn dash-btn-primary">
                <i class="bi bi-plus-lg"></i> Add First Testimonial
            </a>
        </div>
    @else

        {{-- Desktop table --}}
        <div class="dash-table-responsive d-none d-md-block">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Website</th>
                        <th>Rating</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $t)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                @if($t->customer_image)
                                    <img src="{{ $t->customer_image }}" alt=""
                                         style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:1.5px solid var(--tcn-border);flex-shrink:0;">
                                @else
                                    <div style="width:36px;height:36px;border-radius:50%;background:var(--tcn-green-pale);border:1.5px solid var(--tcn-green-muted);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-person-fill" style="color:var(--tcn-green);font-size:.85rem;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:600;color:var(--tcn-heading);">{{ $t->author_name }}</div>
                                    @if($t->author_role)
                                        <div style="font-size:.72rem;color:var(--tcn-gray);">{{ $t->author_role }}</div>
                                    @elseif($t->author_email)
                                        <div style="font-size:.72rem;color:var(--tcn-gray);">{{ $t->author_email }}</div>
                                    @endif
                                    @if($t->is_featured)
                                        <span class="dash-badge dash-badge-green" style="margin-top:4px;font-size:.65rem;">
                                            <i class="bi bi-star-fill"></i> Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="font-size:.84rem;">{{ $t->website->name }}</td>
                        <td><span class="dash-stars" style="font-size:.85rem;">{{ $t->starString() }}</span></td>
                        <td style="max-width:220px;font-size:.84rem;color:var(--tcn-body);">
                            {{ Str::limit($t->content, 80) }}
                        </td>
                        <td>
                            @if($t->status === 'approved')
                                <span class="dash-badge dash-badge-green"><i class="bi bi-check-circle-fill"></i> Approved</span>
                            @elseif($t->status === 'pending')
                                <span class="dash-badge dash-badge-yellow"><i class="bi bi-clock"></i> Pending</span>
                            @else
                                <span class="dash-badge dash-badge-red"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                            @endif
                        </td>
                        <td style="color:var(--tcn-gray);font-size:.78rem;white-space:nowrap;">
                            {{ $t->reviewed_at ? $t->reviewed_at->format('M j, Y') : $t->created_at->format('M j, Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                @if($t->status === 'pending')
                                    <form method="POST" action="{{ route('dashboard.testimonials.approve', $t) }}">
                                        @csrf
                                        <button type="submit" class="dash-btn dash-btn-sm" style="background:#DCFCE7;color:#15803D;border-color:#BBF7D0;" title="Approve">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.testimonials.reject', $t) }}">
                                        @csrf
                                        <button type="submit" class="dash-btn dash-btn-sm dash-btn-danger" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('dashboard.testimonials.edit', $t) }}"
                                   class="dash-btn dash-btn-outline dash-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('dashboard.testimonials.destroy', $t) }}"
                                      onsubmit="return confirm('Delete this testimonial?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dash-btn dash-btn-danger dash-btn-sm" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile card layout --}}
        <div class="tm-mobile-list d-md-none">
            @foreach($testimonials as $t)
            <div class="tm-card">
                {{-- Top: avatar + name + status --}}
                <div class="tm-card-head">
                    <div class="tm-avatar">
                        @if($t->customer_image)
                            <img src="{{ $t->customer_image }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <div class="tm-card-identity">
                        <div class="tm-card-name">{{ $t->author_name }}</div>
                        @if($t->author_role)
                            <div class="tm-card-sub">{{ $t->author_role }}</div>
                        @elseif($t->author_email)
                            <div class="tm-card-sub">{{ $t->author_email }}</div>
                        @endif
                    </div>
                    <div class="tm-card-status">
                        @if($t->status === 'approved')
                            <span class="dash-badge dash-badge-green"><i class="bi bi-check-circle-fill"></i> Approved</span>
                        @elseif($t->status === 'pending')
                            <span class="dash-badge dash-badge-yellow"><i class="bi bi-clock"></i> Pending</span>
                        @else
                            <span class="dash-badge dash-badge-red"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                        @endif
                    </div>
                </div>

                {{-- Stars + website + date --}}
                <div class="tm-card-meta">
                    <span class="dash-stars" style="font-size:.82rem;">{{ $t->starString() }}</span>
                    <span class="tm-card-dot"></span>
                    <span class="tm-card-site"><i class="bi bi-globe2"></i> {{ $t->website->name }}</span>
                    <span class="tm-card-dot"></span>
                    <span class="tm-card-date"><i class="bi bi-calendar3"></i> {{ $t->reviewed_at ? $t->reviewed_at->format('M j, Y') : $t->created_at->format('M j, Y') }}</span>
                </div>

                @if($t->is_featured)
                    <span class="dash-badge dash-badge-green" style="font-size:.65rem;margin-bottom:10px;display:inline-flex;">
                        <i class="bi bi-star-fill"></i> Featured
                    </span>
                @endif

                {{-- Content --}}
                <p class="tm-card-content">{{ Str::limit($t->content, 120) }}</p>

                {{-- Actions --}}
                <div class="tm-card-actions">
                    @if($t->status === 'pending')
                        <form method="POST" action="{{ route('dashboard.testimonials.approve', $t) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="tm-action-btn tm-action-approve" style="width:100%;">
                                <i class="bi bi-check-lg"></i> Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('dashboard.testimonials.reject', $t) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="tm-action-btn tm-action-reject" style="width:100%;">
                                <i class="bi bi-x-lg"></i> Reject
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('dashboard.testimonials.edit', $t) }}" class="tm-action-btn tm-action-edit" style="flex:1;text-align:center;">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('dashboard.testimonials.destroy', $t) }}"
                          onsubmit="return confirm('Delete this testimonial?')" style="flex:0 0 auto;">
                        @csrf @method('DELETE')
                        <button type="submit" class="tm-action-btn tm-action-delete">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div style="padding:16px 24px;">{{ $testimonials->appends(request()->query())->links() }}</div>
    @endif

</div>

@endsection

@push('styles')
<style>
/* Header */
.tm-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    gap: 12px;
    flex-wrap: wrap;
}
.tm-tabs-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}
.tm-tab {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 12px;
    border-radius: 8px;
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    color: var(--tcn-gray);
    transition: var(--tcn-transition);
    white-space: nowrap;
}
.tm-tab-active { background: var(--tcn-green-pale); color: var(--tcn-green-dark); }
.tm-tab-count {
    background: var(--tcn-border);
    color: var(--tcn-gray);
    padding: 1px 7px;
    border-radius: 50px;
    font-size: .7rem;
    font-weight: 700;
}
.tm-tab-count-active { background: var(--tcn-green); color: #fff; }
.tm-add-btn { white-space: nowrap; }

/* Mobile list */
.tm-mobile-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}
.tm-card {
    padding: 18px 20px;
    border-bottom: 1px solid var(--tcn-border);
}
.tm-card:last-child { border-bottom: none; }

.tm-card-head {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 10px;
}
.tm-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--tcn-green-pale);
    border: 1.5px solid var(--tcn-green-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--tcn-green);
    font-size: .9rem;
    flex-shrink: 0;
    overflow: hidden;
}
.tm-card-identity { flex: 1; min-width: 0; }
.tm-card-name {
    font-weight: 700;
    font-size: .9rem;
    color: var(--tcn-heading);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tm-card-sub { font-size: .72rem; color: var(--tcn-gray); margin-top: 1px; }
.tm-card-status { flex-shrink: 0; }

.tm-card-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 10px;
    font-size: .76rem;
    color: var(--tcn-gray);
}
.tm-card-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--tcn-border);
    flex-shrink: 0;
}
.tm-card-site, .tm-card-date { display: inline-flex; align-items: center; gap: 4px; }

.tm-card-content {
    font-size: .83rem;
    color: var(--tcn-body);
    line-height: 1.55;
    margin: 0 0 14px;
}

.tm-card-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid var(--tcn-border);
}
.tm-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 14px;
    border-radius: 9px;
    font-size: .78rem;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    text-decoration: none;
    border: 1.5px solid transparent;
    white-space: nowrap;
    transition: all .18s;
}
.tm-action-approve { background: #DCFCE7; color: #15803D; border-color: #BBF7D0; }
.tm-action-approve:hover { background: #BBF7D0; }
.tm-action-reject { background: transparent; border-color: #FECACA; color: #DC2626; }
.tm-action-reject:hover { background: #FEF2F2; }
.tm-action-edit { background: var(--tcn-white); border-color: var(--tcn-border); color: var(--tcn-body); }
.tm-action-edit:hover { border-color: var(--tcn-green-muted); background: var(--tcn-green-pale); color: var(--tcn-green-dark); text-decoration: none; }
.tm-action-delete { background: transparent; border-color: #FECACA; color: #DC2626; padding: 8px 12px; }
.tm-action-delete:hover { background: #FEF2F2; }
</style>
@endpush
