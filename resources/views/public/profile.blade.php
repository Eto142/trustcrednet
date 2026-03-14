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
