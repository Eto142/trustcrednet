@extends('dashboard.layouts.app')
@section('title', 'Websites – TrustCredNet')
@section('page-title', 'Websites')

@section('content')

{{-- Page header --}}
<div class="site-page-header">
    <div>
        <h2 class="site-page-title">Your Websites</h2>
        <p class="site-page-sub">Manage your business websites and track testimonial performance.</p>
    </div>
    <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
        <i class="bi bi-plus-lg"></i> Add Website
    </a>
</div>

@if($websites->isEmpty())
    <div class="dash-card">
        <div class="dash-empty">
            <div class="dash-empty-icon-wrap">
                <i class="bi bi-globe2"></i>
            </div>
            <div class="dash-empty-title">No websites added yet</div>
            <p class="dash-empty-sub">Add your business website to start collecting and managing testimonials.</p>
            <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
                <i class="bi bi-plus-lg"></i> Add Your First Website
            </a>
        </div>
    </div>
@else

    {{-- ─── Desktop table ─── --}}
    <div class="site-list-card d-none d-md-block">
        <table class="site-table">
            <thead>
                <tr>
                    <th>Website</th>
                    <th>Status</th>
                    <th class="text-center">Testimonials</th>
                    <th>Added</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($websites as $website)
                <tr>
                    <td>
                        <div class="site-table-identity">
                            <div class="site-table-favicon">
                                {{ strtoupper(substr($website->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="site-table-name">{{ $website->name }}</div>
                                <a href="{{ $website->url }}" target="_blank" rel="noopener" class="site-table-url">
                                    {{ Str::limit(preg_replace('#^https?://(www\.)?#', '', $website->url), 35) }}
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($website->is_active)
                            <span class="site-status site-status-active">
                                <span class="site-status-dot"></span> Active
                            </span>
                        @else
                            <span class="site-status site-status-pending">
                                <span class="site-status-dot"></span> Pending
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('dashboard.testimonials.index', ['website_id' => $website->id]) }}"
                           class="site-review-count">
                            <i class="bi bi-chat-square-quote-fill"></i>
                            {{ $website->testimonials_count ?? $website->testimonials()->count() }}
                        </a>
                    </td>
                    <td>
                        <span class="site-date">{{ $website->created_at->format('M j, Y') }}</span>
                    </td>
                    <td>
                        <div class="site-actions">
                            @if($website->slug)
                            <a href="{{ $website->public_url }}" target="_blank" rel="noopener"
                               class="site-action-btn" title="View public page">
                                <i class="bi bi-eye"></i>
                            </a>
                            @endif
                            <a href="{{ route('dashboard.websites.edit', $website) }}"
                               class="site-action-btn" title="Edit website">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('dashboard.websites.destroy', $website) }}"
                                  onsubmit="return confirm('Delete this website and all its testimonials?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="site-action-btn site-action-btn-danger" title="Delete website">
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

    {{-- ─── Mobile cards ─── --}}
    <div class="site-mobile-list d-md-none">
        @foreach($websites as $website)
        <div class="site-m-card">
            {{-- Top row: favicon + name/url + status --}}
            <div class="site-m-head">
                <div class="site-m-favicon">
                    {{ strtoupper(substr($website->name, 0, 1)) }}
                </div>
                <div class="site-m-identity">
                    <div class="site-m-name">{{ $website->name }}</div>
                    <a href="{{ $website->url }}" target="_blank" rel="noopener" class="site-m-url">
                        {{ Str::limit(preg_replace('#^https?://(www\.)?#', '', $website->url), 32) }}
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>

            {{-- Status + meta row --}}
            <div class="site-m-meta">
                @if($website->is_active)
                    <span class="site-status site-status-active">
                        <span class="site-status-dot"></span> Active
                    </span>
                @else
                    <span class="site-status site-status-pending">
                        <span class="site-status-dot"></span> Pending
                    </span>
                @endif
                <span class="site-m-meta-divider"></span>
                <a href="{{ route('dashboard.testimonials.index', ['website_id' => $website->id]) }}"
                   class="site-m-reviews">
                    <i class="bi bi-chat-square-quote-fill"></i>
                    {{ $website->testimonials_count ?? $website->testimonials()->count() }} reviews
                </a>
                <span class="site-m-meta-divider"></span>
                <span class="site-m-date"><i class="bi bi-calendar3"></i> {{ $website->created_at->format('M j, Y') }}</span>
            </div>

            @if($website->description)
                <p class="site-m-desc">{{ Str::limit($website->description, 120) }}</p>
            @endif

            {{-- Actions --}}
            <div class="site-m-actions">
                @if($website->slug)
                <a href="{{ $website->public_url }}" target="_blank" rel="noopener" class="site-m-btn site-m-btn-outline">
                    <i class="bi bi-eye"></i> View
                </a>
                @endif
                <a href="{{ route('dashboard.websites.edit', $website) }}" class="site-m-btn site-m-btn-outline">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form method="POST" action="{{ route('dashboard.websites.destroy', $website) }}"
                      onsubmit="return confirm('Delete this website and all its testimonials?')" class="site-m-btn-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="site-m-btn site-m-btn-danger">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">{{ $websites->links() }}</div>

@endif

@endsection
