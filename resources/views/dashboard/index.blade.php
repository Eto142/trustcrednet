@extends('dashboard.layouts.app')
@section('title', 'Overview – TrustCredNet')
@section('page-title', 'Overview')

@section('content')

{{-- Stats grid --}}
<div class="dash-stats-grid">

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#E5F9EF;color:var(--tcn-green);">
            <i class="bi bi-globe2"></i>
        </div>
        <div class="dash-stat-val">{{ $websiteCount }}</div>
        <div class="dash-stat-lbl">Websites Tracked</div>
    </div>

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#EEF2FF;color:#4F46E5;">
            <i class="bi bi-chat-quote-fill"></i>
        </div>
        <div class="dash-stat-val">{{ $totalTestimonials }}</div>
        <div class="dash-stat-lbl">Total Testimonials</div>
    </div>

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#FFFBEB;color:#D97706;">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="dash-stat-val">{{ $pendingTestimonials }}</div>
        <div class="dash-stat-lbl">Pending Review</div>
    </div>

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#FFF4E5;color:#F59E0B;">
            <i class="bi bi-star-fill"></i>
        </div>
        <div class="dash-stat-val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div>
        <div class="dash-stat-lbl">Average Rating</div>
    </div>

</div>

{{-- Two columns: recent testimonials + quick actions --}}
<div class="row g-4">

    {{-- Recent testimonials --}}
    <div class="col-lg-8">
        <div class="dash-card">
            <div class="dash-card-header">
                <h2 class="dash-card-title">Recent Testimonials</h2>
                <a href="{{ route('dashboard.testimonials.index') }}" class="dash-btn dash-btn-outline dash-btn-sm">
                    View all
                </a>
            </div>

            @if($recentTestimonials->isEmpty())
                <div class="dash-empty">
                    <i class="bi bi-chat-square-quote"></i>
                    <div class="dash-empty-title">No testimonials yet</div>
                    @if($websiteCount > 0)
                        <p class="dash-empty-sub">Your website is set up. Now add your first testimonial.</p>
                        <a href="{{ route('dashboard.testimonials.create') }}" class="dash-btn dash-btn-primary">
                            <i class="bi bi-plus-lg"></i> Add Testimonial
                        </a>
                    @else
                        <p class="dash-empty-sub">Add your first website to start collecting testimonials.</p>
                        <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
                            <i class="bi bi-plus-lg"></i> Add a Website
                        </a>
                    @endif
                </div>
            @else
                <table class="dash-table">
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
                        @foreach($recentTestimonials as $t)
                        <tr>
                            <td>
                                <div style="font-weight:600;color:var(--tcn-heading);">{{ $t->author_name }}</div>
                                @if($t->author_email)
                                    <div style="font-size:.75rem;color:var(--tcn-gray);">{{ $t->author_email }}</div>
                                @endif
                            </td>
                            <td>{{ $t->website->name }}</td>
                            <td><span class="dash-stars">{{ $t->starString() }}</span></td>
                            <td>
                                @if($t->status === 'approved')
                                    <span class="dash-badge dash-badge-green"><i class="bi bi-check-circle-fill"></i> Approved</span>
                                @elseif($t->status === 'pending')
                                    <span class="dash-badge dash-badge-yellow"><i class="bi bi-clock"></i> Pending</span>
                                @else
                                    <span class="dash-badge dash-badge-red"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                                @endif
                            </td>
                            <td style="color:var(--tcn-gray);font-size:.8rem;">{{ $t->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Quick actions / account info --}}
    <div class="col-lg-4 d-flex flex-column gap-4">

        <div class="dash-card">
            <h2 class="dash-card-title" style="margin-bottom:16px;">Quick Actions</h2>
            <div class="d-flex flex-column gap-2">
                @if($websiteCount === 0)
                <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-outline" style="justify-content:flex-start;">
                    <i class="bi bi-plus-circle-fill" style="color:var(--tcn-green);"></i> Add New Website
                </a>
                @endif
                <a href="{{ route('dashboard.testimonials.create') }}" class="dash-btn dash-btn-outline" style="justify-content:flex-start;">
                    <i class="bi bi-chat-plus-fill" style="color:#4F46E5;"></i> Add Testimonial
                </a>
                <a href="{{ route('dashboard.widget') }}" class="dash-btn dash-btn-outline" style="justify-content:flex-start;">
                    <i class="bi bi-code-square" style="color:#D97706;"></i> Get Embed Code
                </a>
                <a href="{{ route('dashboard.settings') }}" class="dash-btn dash-btn-outline" style="justify-content:flex-start;">
                    <i class="bi bi-gear-fill" style="color:var(--tcn-gray);"></i> Account Settings
                </a>
            </div>
        </div>

        <div class="dash-card">
            <h2 class="dash-card-title" style="margin-bottom:14px;">Account</h2>
            <div style="display:flex;flex-direction:column;gap:9px;font-size:.855rem;color:var(--tcn-body);">
                @if($user->logo_path)
                    <img src="{{ $user->logo_path }}" alt="Logo"
                         style="width:52px;height:52px;border-radius:10px;object-fit:contain;border:1.5px solid var(--tcn-border);background:#fff;padding:4px;margin-bottom:6px;">
                @endif
                <div><i class="bi bi-person-fill me-2" style="color:var(--tcn-green);"></i>{{ $user->name }}</div>
                <div><i class="bi bi-building me-2" style="color:var(--tcn-green);"></i>{{ $user->business_name ?? '—' }}</div>
                <div><i class="bi bi-envelope me-2" style="color:var(--tcn-green);"></i>{{ $user->email }}</div>
                @if($user->website_url)
                    <div><i class="bi bi-globe me-2" style="color:var(--tcn-green);"></i>
                        <a href="{{ $user->website_url }}" target="_blank" rel="noopener"
                           style="color:var(--tcn-green-dark);font-weight:600;text-decoration:none;">{{ $user->website_url }}</a>
                    </div>
                @endif
                <div style="font-size:.75rem;color:var(--tcn-gray);margin-top:4px;">
                    <i class="bi bi-calendar me-1"></i>Joined {{ $user->created_at->format('M j, Y') }}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

