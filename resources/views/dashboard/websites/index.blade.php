@extends('dashboard.layouts.app')
@section('title', 'Websites – TrustCredNet')
@section('page-title', 'Websites')

@section('content')

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">Your Websites</h2>
        <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
            <i class="bi bi-plus-lg"></i> Add Website
        </a>
    </div>

    @if($websites->isEmpty())
        <div class="dash-empty">
            <i class="bi bi-globe2"></i>
            <div class="dash-empty-title">No websites added yet</div>
            <p class="dash-empty-sub">Add your business website to start collecting and managing testimonials.</p>
            <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
                <i class="bi bi-plus-lg"></i> Add Your First Website
            </a>
        </div>
    @else
        {{-- Desktop table --}}
        <div class="dash-table-responsive d-none d-md-block">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th>Testimonials</th>
                        <th>Added</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($websites as $website)
                    <tr>
                        <td>
                            <div style="font-weight:700;color:var(--tcn-heading);">{{ $website->name }}</div>
                            @if($website->description)
                                <div style="font-size:.75rem;color:var(--tcn-gray);margin-top:2px;">{{ Str::limit($website->description, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ $website->url }}" target="_blank" rel="noopener"
                               style="color:var(--tcn-green-dark);font-weight:600;font-size:.84rem;text-decoration:none;">
                                <i class="bi bi-box-arrow-up-right me-1"></i>{{ Str::limit($website->url, 40) }}
                            </a>
                        </td>
                        <td>
                            @if($website->is_active)
                                <span class="dash-badge dash-badge-green"><i class="bi bi-check-circle-fill"></i> Active</span>
                            @else
                                <span class="dash-badge dash-badge-gray"><i class="bi bi-dash-circle"></i> Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('dashboard.testimonials.index', ['website_id' => $website->id]) }}"
                               style="font-weight:700;color:var(--tcn-heading);text-decoration:none;">
                                {{ $website->testimonials_count ?? $website->testimonials()->count() }}
                                <span style="font-weight:400;color:var(--tcn-gray);font-size:.8rem;"> reviews</span>
                            </a>
                        </td>
                        <td style="color:var(--tcn-gray);font-size:.8rem;">{{ $website->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($website->slug)
                                <a href="{{ $website->public_url }}" target="_blank" rel="noopener"
                                   class="dash-btn dash-btn-outline dash-btn-sm" title="View public profile">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                @endif
                                <a href="{{ route('dashboard.websites.edit', $website) }}"
                                   class="dash-btn dash-btn-outline dash-btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('dashboard.websites.destroy', $website) }}"
                                      onsubmit="return confirm('Delete this website and all its testimonials?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dash-btn dash-btn-danger dash-btn-sm">
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
        <div class="dash-mobile-cards d-md-none">
            @foreach($websites as $website)
            <div class="dash-mobile-card">
                <div class="dash-mobile-card-header">
                    <div>
                        <div class="dash-mobile-card-name">{{ $website->name }}</div>
                        @if($website->description)
                            <div class="dash-mobile-card-desc">{{ Str::limit($website->description, 80) }}</div>
                        @endif
                    </div>
                    @if($website->is_active)
                        <span class="dash-badge dash-badge-green"><i class="bi bi-check-circle-fill"></i> Active</span>
                    @else
                        <span class="dash-badge dash-badge-gray"><i class="bi bi-dash-circle"></i> Inactive</span>
                    @endif
                </div>

                <div class="dash-mobile-card-meta">
                    <a href="{{ $website->url }}" target="_blank" rel="noopener" class="dash-mobile-card-url">
                        <i class="bi bi-box-arrow-up-right"></i> {{ Str::limit($website->url, 50) }}
                    </a>
                    <div class="dash-mobile-card-row">
                        <span>
                            <a href="{{ route('dashboard.testimonials.index', ['website_id' => $website->id]) }}"
                               style="font-weight:700;color:var(--tcn-heading);text-decoration:none;">
                                {{ $website->testimonials_count ?? $website->testimonials()->count() }}
                                <span style="font-weight:400;color:var(--tcn-gray);"> reviews</span>
                            </a>
                        </span>
                        <span style="color:var(--tcn-gray);font-size:.8rem;">{{ $website->created_at->format('M j, Y') }}</span>
                    </div>
                </div>

                <div class="dash-mobile-card-actions">
                    @if($website->slug)
                    <a href="{{ $website->public_url }}" target="_blank" rel="noopener"
                       class="dash-btn dash-btn-outline dash-btn-sm" title="View public profile">
                        <i class="bi bi-eye"></i> View
                    </a>
                    @endif
                    <a href="{{ route('dashboard.websites.edit', $website) }}"
                       class="dash-btn dash-btn-outline dash-btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('dashboard.websites.destroy', $website) }}"
                          onsubmit="return confirm('Delete this website and all its testimonials?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="dash-btn dash-btn-danger dash-btn-sm">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-3">{{ $websites->links() }}</div>
    @endif
</div>

@endsection
