@extends('layouts.tcn')

@section('title', 'Pricing – TrustCredNet')
@section('description', 'Simple, transparent pricing for every business. Start free — no credit card required.')

@section('content')
    <div class="page-hero">
        <div class="container">
            <div class="page-hero-eyebrow fade-up">
                <i class="bi bi-tag-fill"></i> Pricing Plans
            </div>
            <h1 class="page-hero-h1 fade-up d1">Simple, Transparent Pricing</h1>
            <p class="page-hero-sub fade-up d2">
                Start free and scale as you grow. No hidden fees, no lock-in contracts — just straightforward value for businesses of every size.
            </p>
        </div>
    </div>

    @include('home.sections.pricing')
    @include('home.sections.cta')
@endsection
