@extends('layouts.tcn')

@section('title', $website->name . ' Reviews & Ratings – TrustCredNet | Verified Business Testimonials')

@php
    use Illuminate\Support\Str;

    $reviewWord   = Str::plural('review', $total);
    $ratingStr    = $avgRating ? number_format($avgRating, 1) . '/5' : null;
    $hostName     = $website->url ? (parse_url($website->url, PHP_URL_HOST) ?: $website->url) : null;

    $metaDescription = $website->description
        ? Str::limit($website->description, 155)
        : ($ratingStr
            ? $website->name . ' has a ' . $ratingStr . ' star rating from ' . $total . ' verified ' . $reviewWord . '. Read real customer testimonials for ' . $website->name . ($hostName ? ' (' . $hostName . ')' : '') . ' on TrustCredNet.'
            : 'Read ' . $total . ' verified customer ' . $reviewWord . ' for ' . $website->name . ($hostName ? ' (' . $hostName . ')' : '') . ' on TrustCredNet. See ratings, testimonials and more.');

    $canonicalUrl = url('/' . $website->slug);
    $ogImage      = $website->user->logo_path ?: asset('images/og-default.png');

    $keywords = collect([
        $website->name . ' reviews',
        $website->name . ' testimonials',
        $website->name . ' ratings',
        $website->name . ' trustworthy',
        $website->name . ' legit',
        $website->name . ' customer reviews',
        $website->name . ' verified reviews',
        $hostName ? $hostName . ' reviews' : null,
        $hostName ? $hostName . ' legit' : null,
        $website->user->business_name ? $website->user->business_name . ' reviews' : null,
        'TrustCredNet ' . $website->name,
    ])->filter()->implode(', ');
@endphp

@section('description', $metaDescription)
@section('keywords', $keywords)

@section('head')
{{-- Canonical --}}
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Indexing directives --}}
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="googlebot" content="index, follow">

{{-- Keywords --}}
<meta name="keywords" content="{{ $keywords }}">

{{-- Open Graph --}}
<meta property="og:type"        content="website">
<meta property="og:url"         content="{{ $canonicalUrl }}">
<meta property="og:title"       content="{{ $website->name }} Reviews{{ $ratingStr ? ' – ' . $ratingStr . ' Stars' : '' }} | TrustCredNet">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image"       content="{{ $ogImage }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name"   content="TrustCredNet">
<meta property="og:locale"      content="en_US">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $website->name }} Reviews{{ $ratingStr ? ' – ' . $ratingStr . ' Stars' : '' }} | TrustCredNet">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image"       content="{{ $ogImage }}">

{{-- JSON-LD: LocalBusiness + AggregateRating + Reviews --}}
@php
    $jsonLdBusiness = [
        '@context' => 'https://schema.org',
        '@type'    => ['LocalBusiness', 'Organization'],
        '@id'      => $canonicalUrl . '#business',
        'name'     => $website->name,
        'url'      => $website->url ?: $canonicalUrl,
        'mainEntityOfPage' => $canonicalUrl,
    ];
    if ($website->description) {
        $jsonLdBusiness['description'] = $website->description;
    }
    if ($website->user->logo_path) {
        $jsonLdBusiness['logo']  = ['@type' => 'ImageObject', 'url' => $website->user->logo_path];
        $jsonLdBusiness['image'] = $website->user->logo_path;
    }
    $jsonLdBusiness['sameAs'] = array_filter([$website->url, $canonicalUrl]);
    if ($total > 0 && $avgRating) {
        $jsonLdBusiness['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => number_format($avgRating, 1),
            'bestRating'  => '5',
            'worstRating' => '1',
            'reviewCount' => (string) $total,
        ];
    }
    if ($website->approvedTestimonials->isNotEmpty()) {
        $jsonLdBusiness['review'] = $website->approvedTestimonials->take(10)->map(fn ($t) => [
            '@type'         => 'Review',
            'author'        => ['@type' => 'Person', 'name' => $t->author_name],
            'datePublished' => ($t->reviewed_at ?? $t->created_at)->toDateString(),
            'reviewRating'  => [
                '@type'       => 'Rating',
                'ratingValue' => (string) $t->rating,
                'bestRating'  => '5',
                'worstRating' => '1',
            ],
            'reviewBody'    => $t->content,
            'publisher'     => ['@type' => 'Organization', 'name' => 'TrustCredNet', 'url' => url('/')],
        ])->values()->toArray();
    }

    // JSON-LD: WebPage
    $jsonLdPage = [
        '@context'        => 'https://schema.org',
        '@type'           => 'WebPage',
        '@id'             => $canonicalUrl,
        'url'             => $canonicalUrl,
        'name'            => $website->name . ' Reviews – TrustCredNet',
        'description'     => $metaDescription,
        'inLanguage'      => 'en-US',
        'isPartOf'        => ['@type' => 'WebSite', 'url' => url('/'), 'name' => 'TrustCredNet'],
        'about'           => ['@id' => $canonicalUrl . '#business'],
        'dateModified'    => $website->updated_at->toIso8601String(),
    ];

    // JSON-LD: BreadcrumbList
    $jsonLdBreadcrumb = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',    'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Reviews', 'item' => url('/search')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $website->name . ' Reviews', 'item' => $canonicalUrl],
        ],
    ];

    // JSON-LD: FAQPage — helps capture FAQ rich snippets
    $faqEntries = [];
    if ($total > 0 && $avgRating) {
        $faqEntries[] = [
            '@type'          => 'Question',
            'name'           => 'What is the rating for ' . $website->name . '?',
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $website->name . ' has an average rating of ' . number_format($avgRating, 1) . ' out of 5 based on ' . $total . ' verified customer ' . $reviewWord . ' on TrustCredNet.'],
        ];
    }
    $faqEntries[] = [
        '@type'          => 'Question',
        'name'           => 'Is ' . $website->name . ' legit and trustworthy?',
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $website->name . ' is listed and verified on TrustCredNet, a platform for collecting and displaying authentic customer testimonials.' . ($total > 0 ? ' It has ' . $total . ' verified customer ' . $reviewWord . '.' : '')],
    ];
    $faqEntries[] = [
        '@type'          => 'Question',
        'name'           => 'Where can I read reviews for ' . $website->name . '?',
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'You can read all verified reviews for ' . $website->name . ' on TrustCredNet at ' . $canonicalUrl],
    ];
    $jsonLdFaq = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faqEntries];
@endphp
<script type="application/ld+json">{!! json_encode($jsonLdBusiness,   JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($jsonLdPage,       JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($jsonLdBreadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($jsonLdFaq,        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

<style>
/* ── Review submitted banner ── */
.prof-review-submitted {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #ECFDF5;
    border: 1.5px solid #6EE7B7;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    font-size: .9rem;
    color: #065F46;
    line-height: 1.5;
}
.prof-review-submitted i {
    font-size: 1.3rem;
    color: #059669;
    flex-shrink: 0;
    margin-top: 1px;
}

/* ── Write-a-review box ── */
.prof-write-review {
    background: var(--tcn-light, #F9FAFB);
    border: 1.5px solid var(--tcn-border, #E5E7EB);
    border-radius: 16px;
    padding: 28px;
    margin-top: 28px;
}
.prof-wr-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--tcn-border, #E5E7EB);
}
.prof-wr-header > i {
    font-size: 1.4rem;
    color: var(--tcn-green, #059669);
    flex-shrink: 0;
    margin-top: 2px;
}
.prof-wr-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--tcn-heading, #111827);
    margin: 0 0 3px;
}
.prof-wr-sub {
    font-size: .82rem;
    color: var(--tcn-gray, #6B7280);
    margin: 0;
}
.prof-wr-errors {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    background: #FEF2F2;
    border: 1.5px solid #FECACA;
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 20px;
    font-size: .82rem;
    color: #991B1B;
}
.prof-wr-errors i { flex-shrink: 0; margin-top: 2px; }
.prof-wr-errors ul { margin: 0; padding-left: 18px; }

/* Star picker */
.prof-star-picker {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 6px;
}
.prof-star-btn {
    font-size: 1.6rem;
    color: #D1D5DB;
    cursor: pointer;
    transition: color .12s, transform .1s;
}
.prof-star-btn.active,
.prof-star-btn.hovered {
    color: #F59E0B;
}
.prof-star-btn:hover {
    transform: scale(1.15);
}
.prof-star-hint {
    font-size: .8rem;
    color: var(--tcn-gray, #9CA3AF);
    margin-left: 6px;
}

/* Fields */
.prof-wr-field {
    margin-bottom: 0;
}
.prof-wr-label {
    display: block;
    font-size: .82rem;
    font-weight: 600;
    color: var(--tcn-heading, #374151);
    margin-bottom: 6px;
}
.prof-wr-req { color: #EF4444; }
.prof-wr-opt { font-weight: 400; color: #9CA3AF; }
.prof-wr-input {
    width: 100%;
    background: #fff;
    border: 1.5px solid var(--tcn-border, #E5E7EB);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: .88rem;
    color: var(--tcn-heading, #111827);
    outline: none;
    transition: border-color .15s;
    font-family: inherit;
}
.prof-wr-input:focus {
    border-color: var(--tcn-green, #059669);
    box-shadow: 0 0 0 3px rgba(5,150,105,.1);
}
.prof-wr-input.is-invalid {
    border-color: #EF4444;
}
.prof-wr-textarea { resize: vertical; min-height: 110px; }
.prof-wr-charcount {
    text-align: right;
    font-size: .75rem;
    color: #9CA3AF;
    margin-top: 4px;
}
.prof-wr-error-msg {
    display: block;
    font-size: .78rem;
    color: #EF4444;
    margin-top: 4px;
}

/* Footer bar */
.prof-wr-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid var(--tcn-border, #E5E7EB);
}
.prof-wr-note {
    font-size: .78rem;
    color: #9CA3AF;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    flex: 1;
    min-width: 0;
}
.prof-wr-submit {
    background: linear-gradient(135deg, #059669, #10B981);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 26px;
    font-size: .9rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: opacity .15s;
    white-space: nowrap;
}
.prof-wr-submit:hover { opacity: .88; }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<div class="prof-hero">
    <div class="prof-hero-blob"></div>

    <div class="container">
        <div class="prof-header-inner">

            {{-- Business logo / avatar --}}
            @if($website->user->logo_path)
                <img src="{{ $website->user->logo_path }}"
                     alt="{{ $website->name }}" class="prof-logo">
            @else
                <div class="prof-logo-fallback">
                    {{ strtoupper(mb_substr($website->name, 0, 2)) }}
                </div>
            @endif

            <div class="prof-header-text">
                <h1 class="prof-name">{{ $website->name }}</h1>

                @if($website->url)
                    <a href="{{ $website->url }}" target="_blank" rel="noopener" class="prof-site-link">
                        <i class="bi bi-globe2"></i>
                        {{ parse_url($website->url, PHP_URL_HOST) ?: $website->url }}
                    </a>
                @endif

                <div class="prof-rating-row">
                    @php $stars = $avgRating ? (round($avgRating * 2) / 2) : 0; @endphp

                    <div class="prof-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($stars))
                                <i class="bi bi-star-fill"></i>
                            @elseif($i - 0.5 <= $stars)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>

                    @if($avgRating)
                        <span class="prof-avg">{{ number_format($avgRating, 1) }}</span>
                    @endif
                    <span class="prof-review-count">
                        {{ $total }} {{ Str::plural('review', $total) }}
                    </span>
                </div>

                <div class="prof-verified-badge">
                    <i class="bi bi-patch-check-fill"></i> Verified on TrustCredNet
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     BODY
══════════════════════════════════════ --}}
<section class="prof-body">
    <div class="container">
        <div class="row g-4">

            {{-- ─── LEFT SIDEBAR ─── --}}
            <div class="col-lg-4">

                {{-- About card --}}
                @if($website->description || $website->url)
                <div class="prof-card">
                    <h3 class="prof-card-title">About</h3>

                    @if($website->description)
                        <p class="prof-about-text">{{ $website->description }}</p>
                    @endif

                    @if($website->url)
                        <a href="{{ $website->url }}" target="_blank" rel="noopener" class="prof-visit-btn">
                            <i class="bi bi-box-arrow-up-right"></i> Visit Website
                        </a>
                    @endif
                </div>
                @endif

                {{-- Rating breakdown --}}
                @if($total > 0)
                <div class="prof-card">
                    <h3 class="prof-card-title">Rating Breakdown</h3>
                    @for($s = 5; $s >= 1; $s--)
                        @php $c = $counts->get($s, 0); $pct = $total > 0 ? ($c / $total * 100) : 0; @endphp
                        <div class="prof-bar-row">
                            <span class="prof-bar-label">{{ $s }}<i class="bi bi-star-fill" style="font-size:.65rem;"></i></span>
                            <div class="prof-bar-track">
                                <div class="prof-bar-fill {{ $s >= 4 ? 'fill-green' : ($s == 3 ? 'fill-yellow' : 'fill-red') }}"
                                     style="width:{{ $pct }}%;"></div>
                            </div>
                            <span class="prof-bar-count">{{ $c }}</span>
                        </div>
                    @endfor
                </div>
                @endif

                {{-- Owner card --}}
                <div class="prof-card">
                    <h3 class="prof-card-title">Business Owner</h3>
                    <div class="prof-owner-row">
                        @if($website->user->logo_path)
                            <img src="{{ $website->user->logo_path }}" alt=""
                                 style="width:40px;height:40px;border-radius:10px;object-fit:contain;border:1.5px solid var(--tcn-border);">
                        @else
                            <div class="prof-owner-avatar-icon">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                        <div>
                            <div class="prof-owner-name">{{ $website->user->name }}</div>
                            @if($website->user->business_name)
                                <div class="prof-owner-biz">{{ $website->user->business_name }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Claim CTA --}}
                @guest
                <div class="prof-card prof-claim-card">
                    <div class="prof-claim-icon"><i class="bi bi-shield-fill-check"></i></div>
                    <h4 class="prof-claim-title">Own a business?</h4>
                    <p class="prof-claim-text">Collect and display verified reviews for free with TrustCredNet.</p>
                    <a href="{{ route('contact') }}" class="prof-claim-btn">
                        Get Started Free <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endguest

            </div>

            {{-- ─── RIGHT: REVIEWS ─── --}}
            <div class="col-lg-8">

                {{-- ── Success notice ── --}}
                @if(session('review_submitted'))
                <div class="prof-review-submitted">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Thank you for your review!</strong><br>
                        <span>It will appear here once it's been approved by the business.</span>
                    </div>
                </div>
                @endif

                <div class="prof-reviews-header">
                    <h2 class="prof-reviews-title">
                        <i class="bi bi-chat-quote-fill" style="color:var(--tcn-green);"></i>
                        Customer Reviews
                    </h2>
                    @if($total > 0)
                        <div class="prof-overall">
                            <span class="prof-overall-score">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</span>
                            <span class="prof-overall-label">out of 5</span>
                        </div>
                    @endif
                </div>

                @if($total === 0)
                    <div class="prof-empty-reviews">
                        <i class="bi bi-chat-square-quote"></i>
                        <p>No reviews yet for this business.</p>
                    </div>
                @else
                    <div class="prof-reviews-list">
                        @foreach($website->approvedTestimonials as $t)
                        <div class="prof-review-card{{ $t->is_featured ? ' is-featured' : '' }}">

                            @if($t->is_featured)
                                <div class="prof-featured-tag">
                                    <i class="bi bi-star-fill"></i> Featured Review
                                </div>
                            @endif

                            <div class="prof-review-top">
                                {{-- Avatar --}}
                                @if($t->customer_image)
                                    <img src="{{ $t->customer_image }}"
                                         alt="{{ $t->author_name }}"
                                         class="prof-review-avatar">
                                @else
                                    <div class="prof-review-avatar-fallback">
                                        {{ strtoupper(mb_substr($t->author_name, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- Name + role + date --}}
                                <div class="prof-review-meta" style="flex:1;">
                                    <div class="prof-review-name">{{ $t->author_name }}</div>
                                    @if($t->author_role)
                                        <div class="prof-review-role">{{ $t->author_role }}</div>
                                    @endif
                                </div>

                                <div class="prof-review-date">
                                    <i class="bi bi-calendar3" style="font-size:.7rem;"></i>
                                    {{ ($t->reviewed_at ?? $t->created_at)->format('M j, Y') }}
                                </div>
                            </div>

                            {{-- Stars --}}
                            <div class="prof-review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}"></i>
                                @endfor
                                <span class="prof-review-rating-num">{{ $t->rating }}.0</span>
                            </div>

                            {{-- Content --}}
                            <p class="prof-review-text">&ldquo;{{ $t->content }}&rdquo;</p>

                        </div>
                        @endforeach
                    </div>
                @endif

                {{-- ════════════════════════════════
                     WRITE A REVIEW
                ════════════════════════════════ --}}
                <div class="prof-write-review" id="write-review">
                    <div class="prof-wr-header">
                        <i class="bi bi-pencil-square"></i>
                        <div>
                            <h3 class="prof-wr-title">Write a Review</h3>
                            <p class="prof-wr-sub">Share your experience with {{ $website->name }}</p>
                        </div>
                    </div>

                    @if($errors->any())
                    <div class="prof-wr-errors">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('public.profile.review', $website->slug) }}">
                        @csrf

                        {{-- Star rating picker --}}
                        <div class="prof-wr-field">
                            <label class="prof-wr-label">Your Rating <span class="prof-wr-req">*</span></label>
                            <div class="prof-star-picker" id="starPicker">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star prof-star-btn" data-val="{{ $i }}"></i>
                                @endfor
                                <span class="prof-star-hint" id="starHint">Click to rate</span>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}">
                            @error('rating')
                                <span class="prof-wr-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="prof-wr-field">
                                    <label class="prof-wr-label" for="wr_name">Full Name <span class="prof-wr-req">*</span></label>
                                    <input type="text" id="wr_name" name="author_name"
                                           class="prof-wr-input @error('author_name') is-invalid @enderror"
                                           value="{{ old('author_name') }}"
                                           placeholder="e.g. John Adeyemi" maxlength="100">
                                    @error('author_name')
                                        <span class="prof-wr-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="prof-wr-field">
                                    <label class="prof-wr-label" for="wr_email">Email <span class="prof-wr-opt">(optional)</span></label>
                                    <input type="email" id="wr_email" name="author_email"
                                           class="prof-wr-input @error('author_email') is-invalid @enderror"
                                           value="{{ old('author_email') }}"
                                           placeholder="Not shown publicly" maxlength="150">
                                    @error('author_email')
                                        <span class="prof-wr-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="prof-wr-field">
                                    <label class="prof-wr-label" for="wr_role">Your Role / Title <span class="prof-wr-opt">(optional)</span></label>
                                    <input type="text" id="wr_role" name="author_role"
                                           class="prof-wr-input"
                                           value="{{ old('author_role') }}"
                                           placeholder="e.g. CEO, Customer, Freelancer" maxlength="100">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="prof-wr-field">
                                    <label class="prof-wr-label" for="wr_content">Your Review <span class="prof-wr-req">*</span></label>
                                    <textarea id="wr_content" name="content" rows="5"
                                              class="prof-wr-input prof-wr-textarea @error('content') is-invalid @enderror"
                                              placeholder="Tell others about your experience — what went well, what could be better…"
                                              maxlength="2000">{{ old('content') }}</textarea>
                                    <div class="prof-wr-charcount">
                                        <span id="wr-char-count">0</span> / 2000
                                    </div>
                                    @error('content')
                                        <span class="prof-wr-error-msg">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="prof-wr-footer">
                            <p class="prof-wr-note">
                                <i class="bi bi-shield-check"></i>
                                Reviews are moderated before publishing. Your email (if provided) will never be shown publicly.
                            </p>
                            <button type="submit" class="prof-wr-submit">
                                <i class="bi bi-send-fill"></i> Submit Review
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     POWERED BY BANNER
══════════════════════════════════════ --}}
<div class="prof-powered-bar">
    <span>Powered by</span>
    <a href="{{ route('home') }}">
        <i class="bi bi-shield-fill-check"></i> TrustCredNet
    </a>
    <span class="prof-powered-sep">&middot;</span>
    <a href="{{ route('contact') }}">Collect reviews for your business, free →</a>
</div>

{{-- SEO: semantically rich summary for crawlers --}}
<section aria-label="Review summary" style="border-top:1px solid var(--tcn-border);background:var(--tcn-light);padding:32px 0;">
    <div class="container">
        <div style="max-width:720px;margin:0 auto;">
            <h2 style="font-size:1.1rem;font-weight:700;color:var(--tcn-heading);margin-bottom:10px;">
                About {{ $website->name }} Reviews on TrustCredNet
            </h2>
            <p style="font-size:.88rem;color:var(--tcn-gray);line-height:1.7;margin-bottom:10px;">
                This page contains <strong>{{ $total }} verified {{ Str::plural('customer review', $total) }}</strong>
                for <strong>{{ $website->name }}</strong>{{ $hostName ? ' (' . $hostName . ')' : '' }}.
                @if($ratingStr) The overall rating is <strong>{{ $ratingStr }} stars</strong> based on authentic testimonials collected via TrustCredNet. @endif
                All reviews on TrustCredNet are submitted by real customers and go through a moderation process before being published.
            </p>
            <p style="font-size:.88rem;color:var(--tcn-gray);line-height:1.7;margin-bottom:0;">
                Looking for honest opinions about {{ $website->name }}? Read genuine feedback from verified customers above.
                TrustCredNet helps businesses collect, manage and publicly display trusted reviews — making it easy for consumers to make informed decisions.
                @if($website->url) Visit <a href="{{ $website->url }}" rel="noopener" style="color:var(--tcn-green);">{{ $hostName }}</a> to learn more about the business. @endif
            </p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    // ── Star picker ──
    const stars   = document.querySelectorAll('.prof-star-btn');
    const input   = document.getElementById('ratingInput');
    const hint    = document.getElementById('starHint');
    const labels  = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
    let current   = parseInt(input ? input.value : 0) || 0;

    function paintStars(val) {
        stars.forEach(s => {
            const v = parseInt(s.dataset.val);
            s.classList.remove('bi-star-fill', 'bi-star');
            s.classList.add(v <= val ? 'bi-star-fill' : 'bi-star');
        });
    }

    if (current) { paintStars(current); if (hint) hint.textContent = labels[current]; }

    stars.forEach(star => {
        const val = parseInt(star.dataset.val);
        star.addEventListener('mouseenter', () => {
            paintStars(val);
            if (hint) hint.textContent = labels[val];
        });
        star.addEventListener('mouseleave', () => {
            paintStars(current);
            if (hint) hint.textContent = current ? labels[current] : 'Click to rate';
        });
        star.addEventListener('click', () => {
            current = val;
            if (input) input.value = val;
            paintStars(current);
            if (hint) hint.textContent = labels[current];
        });
    });

    // ── Char counter ──
    const textarea  = document.getElementById('wr_content');
    const charCount = document.getElementById('wr-char-count');
    if (textarea && charCount) {
        charCount.textContent = textarea.value.length;
        textarea.addEventListener('input', () => {
            charCount.textContent = textarea.value.length;
        });
    }
})();
</script>
@endsection
