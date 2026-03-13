@extends('dashboard.layouts.app')
@section('title', 'Testimonials – TrustCredNet')
@section('page-title', 'Testimonials')

@section('content')

{{-- Filter tabs --}}
<div class="dash-card" style="padding:0;overflow:hidden;">

    <div style="display:flex;align-items:center;justify-content:space-between;padding:20px 24px 0;">
        <div class="d-flex gap-1" style="border-bottom:none;">
            @foreach([
                ['key' => 'all',      'label' => 'All',      'count' => $counts['all']],
                ['key' => 'pending',  'label' => 'Pending',  'count' => $counts['pending']],
                ['key' => 'approved', 'label' => 'Approved', 'count' => $counts['approved']],
                ['key' => 'rejected', 'label' => 'Rejected', 'count' => $counts['rejected']],
            ] as $tab)
            <a href="{{ route('dashboard.testimonials.index', ['status' => $tab['key']]) }}"
               style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;font-size:.82rem;font-weight:600;text-decoration:none;transition:var(--tcn-transition);
                      {{ request('status', 'all') === $tab['key'] ? 'background:var(--tcn-green-pale);color:var(--tcn-green-dark);' : 'color:var(--tcn-gray);' }}">
                {{ $tab['label'] }}
                <span style="background:{{ request('status', 'all') === $tab['key'] ? 'var(--tcn-green)' : 'var(--tcn-border)' }};
                             color:{{ request('status', 'all') === $tab['key'] ? '#fff' : 'var(--tcn-gray)' }};
                             padding:1px 7px;border-radius:50px;font-size:.7rem;font-weight:700;">{{ $tab['count'] }}</span>
            </a>
            @endforeach
        </div>
        <a href="{{ route('dashboard.testimonials.create') }}" class="dash-btn dash-btn-primary dash-btn-sm">
            <i class="bi bi-plus-lg"></i> Add Testimonial
        </a>
    </div>

    <div style="height:1px;background:var(--tcn-border);margin:16px 0 0;"></div>

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
        <div style="padding:16px 24px;">{{ $testimonials->appends(request()->query())->links() }}</div>
    @endif

</div>

@endsection
