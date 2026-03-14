@extends('dashboard.layouts.app')
@section('title', 'Websites – TrustCredNet')
@section('page-title', 'Websites')

@section('content')

<div class="dash-card">
    <div class="dash-card-header">
        <h2 class="dash-card-title">Your Websites</h2>
        @if($websites->total() < Auth::user()->website_limit)
        <a href="{{ route('dashboard.websites.create') }}" class="dash-btn dash-btn-primary">
            <i class="bi bi-plus-lg"></i> Add Website
        </a>
        @endif
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
                                <span class="dash-badge" style="background: rgba(245,158,11,0.12); color: #B45309; font-size:.75rem;"><i class="bi bi-exclamation-circle-fill"></i> Inactive – Awaiting Payment</span>
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
                                @if(!$website->is_active)
                                <button type="button" onclick="document.getElementById('activationOverlay').style.display='flex';" class="dash-btn dash-btn-primary dash-btn-sm">
                                    <i class="bi bi-lightning-charge-fill"></i> Activate
                                </button>
                                <button type="button" onclick="openPreview('{{ $website->name }}','{{ addslashes(Str::limit($website->description, 120)) }}','{{ parse_url($website->url, PHP_URL_HOST) ?: $website->url }}','{{ $website->url }}','{{ strtoupper(mb_substr($website->name, 0, 2)) }}')" class="dash-btn dash-btn-outline dash-btn-sm" title="Preview how your page will look">
                                    <i class="bi bi-display"></i> Preview
                                </button>
                                @endif
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
        <div class="site-mobile-list d-md-none">
            @foreach($websites as $website)
            <div class="site-m-card">
                {{-- Header: favicon + name/url + status --}}
                <div class="site-m-head">
                    <div class="site-m-favicon">{{ strtoupper(substr($website->name, 0, 1)) }}</div>
                    <div class="site-m-identity">
                        <div class="site-m-name">{{ $website->name }}</div>
                        <a href="{{ $website->url }}" target="_blank" rel="noopener" class="site-m-url">
                            <i class="bi bi-box-arrow-up-right"></i> {{ Str::limit($website->url, 35) }}
                        </a>
                    </div>
                </div>

                {{-- Status badge --}}
                <div style="margin-bottom:12px;">
                    @if($website->is_active)
                        <span class="site-status site-status-active"><span class="site-status-dot"></span> Active</span>
                    @else
                        <span class="site-status site-status-pending"><span class="site-status-dot"></span> Inactive – Awaiting Payment</span>
                    @endif
                </div>

                @if($website->description)
                    <p class="site-m-desc">{{ Str::limit($website->description, 80) }}</p>
                @endif

                {{-- Meta row: reviews + date --}}
                <div class="site-m-meta">
                    <a href="{{ route('dashboard.testimonials.index', ['website_id' => $website->id]) }}" class="site-m-reviews">
                        <i class="bi bi-chat-square-text-fill"></i>
                        {{ $website->testimonials_count ?? $website->testimonials()->count() }} reviews
                    </a>
                    <span class="site-m-meta-divider"></span>
                    <span class="site-m-date"><i class="bi bi-calendar3"></i> {{ $website->created_at->format('M j, Y') }}</span>
                </div>

                {{-- Actions --}}
                <div class="site-m-actions">
                    @if(!$website->is_active)
                    <button type="button" onclick="document.getElementById('activationOverlay').style.display='flex';" class="site-m-btn" style="background:var(--tcn-green);color:#fff;box-shadow:0 2px 8px rgba(0,182,122,.28);flex:1;">
                        <i class="bi bi-lightning-charge-fill"></i> Activate
                    </button>
                    <button type="button" onclick="openPreview('{{ $website->name }}','{{ addslashes(Str::limit($website->description, 120)) }}','{{ parse_url($website->url, PHP_URL_HOST) ?: $website->url }}','{{ $website->url }}','{{ strtoupper(mb_substr($website->name, 0, 2)) }}')" class="site-m-btn site-m-btn-outline">
                        <i class="bi bi-display"></i> Preview
                    </button>
                    @endif
                    @if($website->slug)
                    <a href="{{ $website->public_url }}" target="_blank" rel="noopener" class="site-m-btn site-m-btn-outline">
                        <i class="bi bi-eye"></i> View
                    </a>
                    @endif
                    <a href="{{ route('dashboard.websites.edit', $website) }}" class="site-m-btn site-m-btn-outline">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('dashboard.websites.destroy', $website) }}"
                          class="site-m-btn-form"
                          onsubmit="return confirm('Delete this website and all its testimonials?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="site-m-btn site-m-btn-danger">
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

{{-- ===== ACTIVATION MODAL ===== --}}
@if(session('show_activation') || $websites->contains(fn($w) => !$w->is_active))
<div class="tcn-overlay" id="activationOverlay" onclick="if(event.target===this)this.style.display='none';" @if(session('show_activation')) style="display:flex;" @else style="display:none;" @endif>
    <div class="tcn-modal">
        <button class="tcn-close" onclick="document.getElementById('activationOverlay').style.display='none';">&times;</button>

        <div class="tcn-head">
            <div class="tcn-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <h2>Activate Your Website</h2>
            <p>Just <strong>${{ $paymentSettings['price_usd'] }}/year</strong> — choose a payment method, then send your receipt via WhatsApp to complete activation.</p>
        </div>

        {{-- Step 1 --}}
        <div class="tcn-section">
            <div class="tcn-step-label"><span class="tcn-num">1</span> Make Payment</div>

            <div class="tcn-tabs">
                <button class="tcn-tab active" onclick="switchTab(this,'crypto')"><i class="bi bi-currency-bitcoin"></i> Crypto</button>
                <button class="tcn-tab" onclick="switchTab(this,'moniffy')"><i class="bi bi-wallet2"></i> Moniffy</button>
                <button class="tcn-tab" onclick="switchTab(this,'bank')"><i class="bi bi-bank"></i> Bank Transfer</button>
            </div>

            <div class="tcn-tab-content active" id="tab-crypto">
                <div class="tcn-detail-box">
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Network</span>
                        <span class="tcn-value">USDT (TRC20)</span>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Wallet Address</span>
                        <span class="tcn-value tcn-mono" id="cryptoAddr">{{ $paymentSettings['crypto_address'] ?: 'Not configured' }}</span>
                        <button class="tcn-copy" onclick="copyText('cryptoAddr')" title="Copy"><i class="bi bi-copy"></i></button>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Amount</span>
                        <span class="tcn-value" style="font-weight:700;color:#059669;">${{ $paymentSettings['price_usd'] }}.00 USDT <span style="font-weight:500;font-size:.68rem;color:#6B7280;">/year</span></span>
                    </div>
                </div>
            </div>

            <div class="tcn-tab-content" id="tab-moniffy">
                <div class="tcn-detail-box">
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Platform</span>
                        <span class="tcn-value">Moniffy</span>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Username / Tag</span>
                        <span class="tcn-value tcn-mono" id="moniffyTag">{{ $paymentSettings['moniffy_tag'] ?: 'Not configured' }}</span>
                        <button class="tcn-copy" onclick="copyText('moniffyTag')" title="Copy"><i class="bi bi-copy"></i></button>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Amount</span>
                        <span class="tcn-value naira-amount" style="font-weight:700;color:#059669;">Loading…</span>
                    </div>
                </div>
            </div>

            <div class="tcn-tab-content" id="tab-bank">
                <div class="tcn-detail-box">
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Bank Name</span>
                        <span class="tcn-value">{{ $paymentSettings['bank_name'] ?: 'Not configured' }}</span>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Account Number</span>
                        <span class="tcn-value tcn-mono" id="bankAcct">{{ $paymentSettings['bank_account_number'] ?: 'Not configured' }}</span>
                        <button class="tcn-copy" onclick="copyText('bankAcct')" title="Copy"><i class="bi bi-copy"></i></button>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Account Name</span>
                        <span class="tcn-value">{{ $paymentSettings['bank_account_name'] ?: 'Not configured' }}</span>
                    </div>
                    <div class="tcn-detail-row">
                        <span class="tcn-label">Amount</span>
                        <span class="tcn-value naira-amount" style="font-weight:700;color:#059669;">Loading…</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 2 --}}
        <div class="tcn-section">
            <div class="tcn-step-label"><span class="tcn-num">2</span> Send Receipt & Get Activated</div>
            <p class="tcn-hint">After payment, send your receipt screenshot to our WhatsApp support. We'll verify and activate your website promptly.</p>
            <a href="https://wa.me/{{ $paymentSettings['whatsapp_number'] }}?text=Hi%20TrustCredNet%2C%20I%20just%20made%20payment%20for%20website%20activation.%20Here%20is%20my%20receipt." target="_blank" rel="noopener" class="tcn-wa-btn">
                <i class="bi bi-whatsapp"></i> Send Receipt on WhatsApp
            </a>
        </div>

        <div class="tcn-note">
            <i class="bi bi-lock-fill"></i> Your website data is saved. It goes live once payment is confirmed.
        </div>

        <button onclick="document.getElementById('activationOverlay').style.display='none';" class="tcn-later">I'll do this later</button>
    </div>
</div>
@endif

{{-- ===== PREVIEW MODAL ===== --}}
<div class="pvw-overlay" id="previewOverlay" style="display:none;" onclick="if(event.target===this)this.style.display='none';">
    <div class="pvw-modal">
        <button class="pvw-close" onclick="document.getElementById('previewOverlay').style.display='none';">&times;</button>

        <div class="pvw-banner"><i class="bi bi-eye-fill"></i> &nbsp;PREVIEW — This is how your page will look once activated</div>

        {{-- Hero --}}
        <div class="pvw-hero">
            <div class="pvw-hero-blob"></div>
            <div class="pvw-hero-inner">
                <div class="pvw-logo" id="pvwInitials">TC</div>
                <div>
                    <h2 class="pvw-name" id="pvwName">Your Business</h2>
                    <a href="#" class="pvw-url" id="pvwUrl" target="_blank" rel="noopener">
                        <i class="bi bi-globe2"></i> <span id="pvwHost">example.com</span>
                    </a>
                    <div class="pvw-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        <span class="pvw-stars-avg">4.8</span>
                        <span class="pvw-stars-count">12 reviews</span>
                    </div>
                    <div class="pvw-verified"><i class="bi bi-patch-check-fill"></i> Verified on TrustCredNet</div>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="pvw-body">
            <div class="pvw-grid">
                {{-- Left sidebar --}}
                <div>
                    <div class="pvw-card">
                        <div class="pvw-card-title">About</div>
                        <p class="pvw-about" id="pvwAbout">This business uses TrustCredNet to collect and display verified customer reviews.</p>
                        <a href="#" class="pvw-visit" id="pvwVisit" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right"></i> Visit Website</a>
                    </div>
                    <div class="pvw-card" style="margin-top:12px;">
                        <div class="pvw-card-title">Rating Breakdown</div>
                        <div class="pvw-bar-row">
                            <span class="pvw-bar-label">5<i class="bi bi-star-fill"></i></span>
                            <div class="pvw-bar-track"><div class="pvw-bar-fill pvw-bar-fill-green" style="width:72%;"></div></div>
                            <span class="pvw-bar-count">8</span>
                        </div>
                        <div class="pvw-bar-row">
                            <span class="pvw-bar-label">4<i class="bi bi-star-fill"></i></span>
                            <div class="pvw-bar-track"><div class="pvw-bar-fill pvw-bar-fill-green" style="width:22%;"></div></div>
                            <span class="pvw-bar-count">3</span>
                        </div>
                        <div class="pvw-bar-row">
                            <span class="pvw-bar-label">3<i class="bi bi-star-fill"></i></span>
                            <div class="pvw-bar-track"><div class="pvw-bar-fill pvw-bar-fill-yellow" style="width:8%;"></div></div>
                            <span class="pvw-bar-count">1</span>
                        </div>
                        <div class="pvw-bar-row">
                            <span class="pvw-bar-label">2<i class="bi bi-star-fill"></i></span>
                            <div class="pvw-bar-track"><div class="pvw-bar-fill pvw-bar-fill-red" style="width:0%;"></div></div>
                            <span class="pvw-bar-count">0</span>
                        </div>
                        <div class="pvw-bar-row">
                            <span class="pvw-bar-label">1<i class="bi bi-star-fill"></i></span>
                            <div class="pvw-bar-track"><div class="pvw-bar-fill pvw-bar-fill-red" style="width:0%;"></div></div>
                            <span class="pvw-bar-count">0</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Sample reviews --}}
                <div>
                    <div class="pvw-reviews-title"><i class="bi bi-chat-quote-fill"></i> Customer Reviews</div>
                    <div class="pvw-review">
                        <div class="pvw-review-top">
                            <div class="pvw-review-avatar">JD</div>
                            <div><div class="pvw-review-name">John Doe</div><div class="pvw-review-date">2 days ago</div></div>
                            <div class="pvw-review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        </div>
                        <p class="pvw-review-text">Absolutely outstanding service! The team was professional, responsive, and exceeded my expectations. Would highly recommend to anyone.</p>
                    </div>
                    <div class="pvw-review">
                        <div class="pvw-review-top">
                            <div class="pvw-review-avatar">SA</div>
                            <div><div class="pvw-review-name">Sarah A.</div><div class="pvw-review-date">5 days ago</div></div>
                            <div class="pvw-review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i></div>
                        </div>
                        <p class="pvw-review-text">Great experience overall. They really know what they're doing. Communication was smooth and the results spoke for themselves.</p>
                    </div>
                    <div class="pvw-review">
                        <div class="pvw-review-top">
                            <div class="pvw-review-avatar">MK</div>
                            <div><div class="pvw-review-name">Michael K.</div><div class="pvw-review-date">1 week ago</div></div>
                            <div class="pvw-review-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        </div>
                        <p class="pvw-review-text">Trusted and reliable. I've been using their services for months and the quality remains consistently excellent.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Footer --}}
        <div class="pvw-footer">
            <button type="button" onclick="document.getElementById('previewOverlay').style.display='none';document.getElementById('activationOverlay').style.display='flex';" class="pvw-activate-btn">
                <i class="bi bi-lightning-charge-fill"></i> Activate Now to Go Live
            </button>
            <div class="pvw-hint">${{ $paymentSettings['price_usd'] }}/year plan • Goes live instantly after verification</div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.tcn-overlay{position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:16px;animation:tcnIn .25s ease}
@keyframes tcnIn{from{opacity:0}to{opacity:1}}
@keyframes tcnUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.tcn-modal{background:#fff;border-radius:16px;max-width:440px;width:100%;position:relative;animation:tcnUp .3s ease;max-height:90vh;overflow-y:auto;padding:0}
.tcn-close{position:absolute;top:12px;right:14px;background:none;border:none;font-size:1.4rem;color:#9CA3AF;cursor:pointer;z-index:2;line-height:1}
.tcn-close:hover{color:#374151}
.tcn-head{text-align:center;padding:24px 24px 16px;background:linear-gradient(135deg,#ECFDF5,#F0FDF4,#FEF3C7);border-bottom:1px solid #E5E7EB}
.tcn-icon{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#059669,#10B981);color:#fff;font-size:1.4rem;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px}
.tcn-head h2{font-size:1.15rem;font-weight:800;color:#111827;margin:0 0 4px}
.tcn-head p{font-size:.8rem;color:#6B7280;margin:0;line-height:1.45}
.tcn-section{padding:16px 24px 0}
.tcn-step-label{display:flex;align-items:center;gap:10px;font-weight:700;font-size:.88rem;color:#111827;margin-bottom:10px}
.tcn-num{width:24px;height:24px;border-radius:50%;background:#059669;color:#fff;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0}
.tcn-tabs{display:flex;gap:6px;margin-bottom:12px}
.tcn-tab{flex:1;padding:8px 0;border:1px solid #E5E7EB;border-radius:8px;background:#F9FAFB;font-size:.78rem;font-weight:600;color:#6B7280;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;transition:all .2s}
.tcn-tab.active{background:#059669;color:#fff;border-color:#059669}
.tcn-tab:hover:not(.active){background:#F3F4F6}
.tcn-tab-content{display:none}
.tcn-tab-content.active{display:block}
.tcn-detail-box{background:#F9FAFB;border:1px solid #E5E7EB;border-radius:10px;padding:10px 14px}
.tcn-detail-row{display:flex;align-items:center;justify-content:space-between;padding:7px 0;border-bottom:1px solid #F3F4F6;gap:8px}
.tcn-detail-row:last-child{border-bottom:none}
.tcn-label{font-size:.76rem;color:#9CA3AF;flex-shrink:0}
.tcn-value{font-size:.8rem;color:#111827;font-weight:500;text-align:right;word-break:break-all}
.tcn-mono{font-family:'Courier New',monospace;font-size:.74rem;letter-spacing:.3px}
.tcn-copy{background:none;border:none;color:#059669;cursor:pointer;font-size:.85rem;padding:2px 4px;flex-shrink:0}
.tcn-copy:hover{color:#047857}
.tcn-hint{font-size:.8rem;color:#6B7280;margin:0 0 12px;line-height:1.45}
.tcn-wa-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;border-radius:10px;background:#25D366;color:#fff;font-weight:700;font-size:.88rem;text-decoration:none;transition:background .2s}
.tcn-wa-btn:hover{background:#1DA851;color:#fff}
.tcn-note{display:flex;align-items:center;gap:8px;margin:14px 24px 0;padding:10px 14px;border-radius:8px;background:#F0F9FF;border:1px solid #BAE6FD;font-size:.76rem;color:#0369A1;line-height:1.4}
.tcn-note i{flex-shrink:0;font-size:.85rem}
.tcn-later{display:block;margin:12px auto 18px;background:none;border:none;color:#9CA3AF;font-size:.78rem;cursor:pointer;padding:6px 12px}
.tcn-later:hover{color:#6B7280}
@media(max-width:480px){.tcn-modal{border-radius:14px;max-width:100%}.tcn-head{padding:20px 18px 14px}.tcn-section{padding:14px 18px 0}.tcn-note{margin:14px 18px 0}.tcn-tabs{flex-wrap:wrap}}

/* ── Preview Modal ── */
.pvw-overlay{position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.55);backdrop-filter:blur(5px);display:flex;align-items:center;justify-content:center;padding:16px;animation:tcnIn .25s ease}
.pvw-modal{background:#fff;border-radius:18px;max-width:680px;width:100%;position:relative;animation:tcnUp .3s ease;max-height:92vh;overflow-y:auto;box-shadow:0 25px 60px rgba(0,0,0,.25)}
.pvw-close{position:absolute;top:14px;right:16px;background:rgba(255,255,255,.9);border:none;width:32px;height:32px;border-radius:50%;font-size:1.2rem;color:#6B7280;cursor:pointer;z-index:2;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.1)}
.pvw-close:hover{color:#111;background:#fff}
.pvw-banner{text-align:center;padding:10px;background:linear-gradient(135deg,#059669,#10B981);color:#fff;font-size:.72rem;font-weight:700;letter-spacing:.5px;border-radius:18px 18px 0 0}
.pvw-hero{background:linear-gradient(135deg,#002b1a 0%,#004d2e 45%,#006e42 100%);padding:36px 32px 28px;position:relative;overflow:hidden}
.pvw-hero-blob{position:absolute;inset:0;background:radial-gradient(ellipse 70% 60% at 80% 20%,rgba(0,182,122,.25),transparent),radial-gradient(ellipse 50% 50% at 10% 90%,rgba(0,93,55,.5),transparent);pointer-events:none}
.pvw-hero-inner{position:relative;display:flex;align-items:center;gap:20px}
.pvw-logo{width:64px;height:64px;border-radius:14px;background:linear-gradient(135deg,rgba(255,255,255,.15),rgba(255,255,255,.05));backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:1.3rem;flex-shrink:0;border:2px solid rgba(255,255,255,.2)}
.pvw-name{color:#fff;font-size:1.25rem;font-weight:900;margin:0 0 4px}
.pvw-url{display:inline-flex;align-items:center;gap:5px;color:rgba(255,255,255,.7);font-size:.78rem;font-weight:500;text-decoration:none}
.pvw-url:hover{color:#fff}
.pvw-stars{margin-top:8px;display:flex;align-items:center;gap:6px}
.pvw-stars i{color:#F59E0B;font-size:.85rem}
.pvw-stars-avg{color:#fff;font-weight:800;font-size:.88rem}
.pvw-stars-count{color:rgba(255,255,255,.6);font-size:.76rem}
.pvw-verified{display:inline-flex;align-items:center;gap:5px;margin-top:8px;padding:4px 10px;border-radius:20px;background:rgba(0,182,122,.2);color:#6EE7B7;font-size:.7rem;font-weight:700}
.pvw-body{padding:24px 28px}
.pvw-grid{display:grid;grid-template-columns:1fr 1.6fr;gap:20px}
.pvw-card{background:#F9FAFB;border:1px solid #E5E7EB;border-radius:12px;padding:16px}
.pvw-card-title{font-size:.8rem;font-weight:800;color:#111827;margin:0 0 10px}
.pvw-about{font-size:.78rem;color:#6B7280;line-height:1.55;margin:0 0 12px}
.pvw-visit{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;background:var(--tcn-green-pale,#ECFDF5);color:#059669;font-size:.76rem;font-weight:700;text-decoration:none;border:1px solid #A7F3D0}
.pvw-bar-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.pvw-bar-label{font-size:.7rem;font-weight:600;color:#6B7280;width:24px;display:flex;align-items:center;gap:2px}
.pvw-bar-label i{font-size:.55rem;color:#F59E0B}
.pvw-bar-track{flex:1;height:6px;background:#E5E7EB;border-radius:4px;overflow:hidden}
.pvw-bar-fill{height:100%;border-radius:4px}
.pvw-bar-fill-green{background:#10B981}
.pvw-bar-fill-yellow{background:#F59E0B}
.pvw-bar-fill-red{background:#EF4444}
.pvw-bar-count{font-size:.68rem;color:#9CA3AF;width:16px;text-align:right}
.pvw-reviews-title{font-size:.8rem;font-weight:800;color:#111827;margin:0 0 14px;display:flex;align-items:center;gap:6px}
.pvw-reviews-title i{color:#059669;font-size:.78rem}
.pvw-review{background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:14px;margin-bottom:10px}
.pvw-review-top{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.pvw-review-avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#059669,#10B981);color:#fff;font-size:.72rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.pvw-review-name{font-size:.78rem;font-weight:700;color:#111827}
.pvw-review-date{font-size:.68rem;color:#9CA3AF}
.pvw-review-stars{margin-left:auto;color:#F59E0B;font-size:.72rem}
.pvw-review-text{font-size:.76rem;color:#4B5563;line-height:1.55;margin:0}
.pvw-footer{text-align:center;padding:0 28px 22px}
.pvw-activate-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 32px;border-radius:10px;background:linear-gradient(135deg,#059669,#10B981);color:#fff;font-weight:800;font-size:.88rem;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(0,182,122,.35);transition:all .2s}
.pvw-activate-btn:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(0,182,122,.4)}
.pvw-hint{font-size:.72rem;color:#9CA3AF;margin-top:8px}
@media(max-width:640px){.pvw-grid{grid-template-columns:1fr}.pvw-hero{padding:28px 20px 22px}.pvw-body{padding:18px 16px}.pvw-footer{padding:0 16px 18px}.pvw-modal{max-width:100%;border-radius:14px}}
</style>
@endpush

@push('scripts')
<script>
function switchTab(btn,id){
    document.querySelectorAll('.tcn-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.tcn-tab-content').forEach(c=>c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-'+id).classList.add('active');
}
function copyText(id){
    const el=document.getElementById(id);
    navigator.clipboard.writeText(el.textContent.trim()).then(()=>{
        const orig=el.style.color;el.style.color='#059669';
        setTimeout(()=>el.style.color=orig,800);
    });
}
(function(){
    const USD_AMOUNT={{ (float)($paymentSettings['price_usd'] ?? 30) }};
    const setNaira=(rate)=>{
        const naira=Math.round(USD_AMOUNT*rate).toLocaleString();
        document.querySelectorAll('.naira-amount').forEach(el=>el.innerHTML='₦'+naira+' <span style=\"font-weight:500;font-size:.68rem;color:#6B7280;\">/year</span>');
    };
    fetch('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.json')
        .then(r=>r.json())
        .then(data=>{
            const rate=data.usd&&data.usd.ngn;
            if(rate){setNaira(rate);return;}
            throw new Error('no rate');
        })
        .catch(()=>{
            fetch('https://open.er-api.com/v6/latest/USD')
                .then(r=>r.json())
                .then(data=>{
                    const rate=data.rates&&data.rates.NGN;
                    if(rate)setNaira(rate);
                    else document.querySelectorAll('.naira-amount').forEach(el=>el.textContent='₦—');
                })
                .catch(()=>{
                    document.querySelectorAll('.naira-amount').forEach(el=>el.textContent='₦—');
                });
        });
})();

function openPreview(name,desc,host,url,initials){
    document.getElementById('pvwName').textContent=name;
    document.getElementById('pvwInitials').textContent=initials;
    document.getElementById('pvwHost').textContent=host;
    document.getElementById('pvwUrl').href=url;
    document.getElementById('pvwAbout').textContent=desc||'This business uses TrustCredNet to collect and display verified customer reviews.';
    document.getElementById('pvwVisit').href=url;
    document.getElementById('previewOverlay').style.display='flex';
}
</script>
@endpush
