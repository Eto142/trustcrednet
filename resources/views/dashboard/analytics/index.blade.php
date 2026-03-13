@extends('dashboard.layouts.app')
@section('title', 'Analytics – TrustCredNet')
@section('page-title', 'Analytics')

@section('content')

{{-- Stats grid --}}
<div class="dash-stats-grid" style="margin-bottom:24px;">

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#EFF6FF;color:#3B82F6;">
            <i class="bi bi-eye-fill"></i>
        </div>
        <div class="dash-stat-val">{{ number_format($stats['page_views']) }}</div>
        <div class="dash-stat-lbl">Page Views</div>
    </div>

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#F5F3FF;color:#7C3AED;">
            <i class="bi bi-cursor-fill"></i>
        </div>
        <div class="dash-stat-val">{{ number_format($stats['widget_clicks']) }}</div>
        <div class="dash-stat-lbl">Widget Clicks</div>
    </div>

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#FFF7ED;color:#EA580C;">
            <i class="bi bi-search"></i>
        </div>
        <div class="dash-stat-val">{{ number_format($stats['search_queries']) }}</div>
        <div class="dash-stat-lbl">Search Queries</div>
    </div>

    <div class="dash-stat">
        <div class="dash-stat-icon" style="background:#F0FDF4;color:var(--tcn-green);">
            <i class="bi bi-patch-check-fill"></i>
        </div>
        <div class="dash-stat-val">{{ number_format($stats['approved_reviews']) }}</div>
        <div class="dash-stat-lbl">Published Reviews</div>
    </div>

</div>

{{-- Coming soon banner --}}
<div class="dash-card">
    <div style="text-align:center;padding:40px 20px;">
        <div style="width:64px;height:64px;border-radius:16px;background:var(--tcn-green-pale);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.8rem;color:var(--tcn-green);">
            <i class="bi bi-bar-chart-line-fill"></i>
        </div>
        <h3 style="font-size:1.1rem;font-weight:800;color:var(--tcn-heading);margin-bottom:8px;">
            Detailed Analytics Coming Soon
        </h3>
        <p style="font-size:.9rem;color:var(--tcn-gray);max-width:460px;margin:0 auto 20px;">
            We're building detailed traffic charts, conversion tracking, and widget performance metrics.
            The review count above is live — everything else is on the roadmap.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            @foreach(['Traffic Trends', 'Rating Over Time', 'Widget CTR', 'Source Attribution'] as $feat)
                <span style="background:var(--tcn-green-pale);color:var(--tcn-green-dark);border:1px solid var(--tcn-green-muted);border-radius:50px;padding:5px 14px;font-size:.78rem;font-weight:600;">
                    <i class="bi bi-check2 me-1"></i>{{ $feat }}
                </span>
            @endforeach
        </div>
    </div>
</div>

@endsection
