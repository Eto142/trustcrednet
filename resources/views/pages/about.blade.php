@extends('layouts.tcn')

@section('title', 'About – TrustCredNet')
@section('description', 'Learn about TrustCredNet\'s mission to make trust transparent for businesses and consumers worldwide.')

@section('content')

    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="container">
            <div class="page-hero-eyebrow fade-up">
                <i class="bi bi-info-circle-fill"></i> Our Story
            </div>
            <h1 class="page-hero-h1 fade-up d1">About TrustCredNet</h1>
            <p class="page-hero-sub fade-up d2">
                We're on a mission to make trust transparent — helping real consumers find businesses they can rely on, and helping great businesses earn the recognition they deserve.
            </p>
        </div>
    </div>

    {{-- Mission --}}
    <section id="about-mission">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 fade-up">
                    <blockquote class="mission-quote">
                        "We believe every great business relationship starts with trust — and trust starts with transparency."
                    </blockquote>
                </div>
                <div class="col-lg-6 fade-up d1">
                    <p class="about-story">
                        TrustCredNet was founded with a simple belief: consumers deserve honest information, and honest businesses deserve to be found.
                    </p>
                    <p class="about-story mt-4">
                        We've built a platform where every review is verified, every business profile is transparent, and every consumer can make confident decisions. No sponsored placements, no manipulated rankings — just real experiences from real people.
                    </p>
                    <p class="about-story mt-4">
                        Today, over 12,000 businesses across 180+ countries use TrustCredNet to build lasting credibility with their customers.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section id="about-values">
        <div class="container">
            <div class="text-center fade-up">
                <div class="section-eyebrow eyebrow-green">
                    <i class="bi bi-heart-fill"></i> Our Values
                </div>
                <h2 class="section-headline">What We Stand For</h2>
                <p class="section-sub mx-auto">Four principles that guide everything we build and every decision we make.</p>
            </div>

            <div class="values-grid">
                <div class="value-card fade-up d1">
                    <div class="value-icon"><i class="bi bi-patch-check-fill"></i></div>
                    <div class="value-title">Authenticity</div>
                    <p class="value-desc">Every review on our platform comes from a verified customer interaction. We invest heavily in fraud detection so you can trust what you read.</p>
                </div>
                <div class="value-card fade-up d2">
                    <div class="value-icon"><i class="bi bi-eye-fill"></i></div>
                    <div class="value-title">Transparency</div>
                    <p class="value-desc">No pay-to-win placement. No suppressed reviews. Businesses can't buy a better rating — they have to earn it through great service.</p>
                </div>
                <div class="value-card fade-up d3">
                    <div class="value-icon"><i class="bi bi-shield-lock-fill"></i></div>
                    <div class="value-title">Security</div>
                    <p class="value-desc">We take privacy seriously. Your data and your customers' data are always protected under the highest security and compliance standards.</p>
                </div>
                <div class="value-card fade-up d4">
                    <div class="value-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="value-title">Community</div>
                    <p class="value-desc">We exist to serve both consumers and businesses. Every feature we build is designed to strengthen the relationship between them.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats strip --}}
    <section id="about-stats">
        <div class="container">
            <div class="about-stats-grid">
                <div class="fade-up">
                    <div class="about-stat-val">12K+</div>
                    <div class="about-stat-lbl">Businesses Worldwide</div>
                </div>
                <div class="fade-up d1">
                    <div class="about-stat-val">2.4M+</div>
                    <div class="about-stat-lbl">Verified Reviews</div>
                </div>
                <div class="fade-up d2">
                    <div class="about-stat-val">180+</div>
                    <div class="about-stat-lbl">Countries Covered</div>
                </div>
                <div class="fade-up d3">
                    <div class="about-stat-val">99.9%</div>
                    <div class="about-stat-lbl">Platform Uptime</div>
                </div>
            </div>
        </div>
    </section>

    @include('home.sections.cta')

@endsection
