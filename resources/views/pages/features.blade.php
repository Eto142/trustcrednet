@extends('layouts.tcn')

@section('title', 'Features – TrustCredNet')
@section('description', 'Explore every tool TrustCredNet offers to collect, manage, and showcase authentic customer reviews.')

@section('content')
    <div class="page-hero">
        <div class="container">
            <div class="page-hero-eyebrow fade-up">
                <i class="bi bi-grid-fill"></i> Platform Features
            </div>
            <h1 class="page-hero-h1 fade-up d1">Everything You Need to<br>Win Customer Trust</h1>
            <p class="page-hero-sub fade-up d2">
                From automated review collection to real-time analytics, TrustCredNet gives you the tools to build, manage, and showcase your reputation.
            </p>
        </div>
    </div>

    @include('home.sections.features')
    @include('home.sections.cta')
@endsection
