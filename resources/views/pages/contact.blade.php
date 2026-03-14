@extends('layouts.tcn')

@section('title', 'Contact Us – TrustCredNet')
@section('description', 'Want to get started with TrustCredNet? Send us your business name and email and we\'ll set you up.')

@section('head')
<style>
    /* ── Contact page ────────────────────────────────── */
    .contact-hero {
        padding: 96px 0 56px;
        background: linear-gradient(135deg, #f0f5ff 0%, #e8f4fd 100%);
        text-align: center;
    }
    .contact-hero .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(16,69,168,.08);
        color: var(--tcn-green);
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 20px;
        margin-bottom: 20px;
    }
    .contact-hero h1 {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        color: var(--tcn-dark);
        margin-bottom: 16px;
    }
    .contact-hero p {
        font-size: 1.1rem;
        color: var(--tcn-gray);
        max-width: 540px;
        margin: 0 auto;
    }

    /* ── Form card ───────────────────────────────────── */
    .contact-section {
        padding: 72px 0 96px;
    }
    .contact-card {
        background: #fff;
        border: 1px solid var(--tcn-border);
        border-radius: var(--tcn-radius-lg);
        box-shadow: var(--tcn-shadow-lg);
        padding: 48px 44px;
        max-width: 560px;
        margin: 0 auto;
    }
    @media (max-width: 576px) {
        .contact-card { padding: 32px 20px; }
    }

    .contact-card .form-label {
        font-weight: 600;
        font-size: .9rem;
        color: var(--tcn-dark);
        margin-bottom: 6px;
    }
    .contact-card .form-control,
    .contact-card textarea.form-control {
        border: 1.5px solid var(--tcn-border);
        border-radius: 10px;
        padding: 12px 14px;
        font-size: .95rem;
        transition: var(--tcn-transition);
    }
    .contact-card .form-control:focus {
        border-color: var(--tcn-green);
        box-shadow: 0 0 0 3px rgba(0,182,122,.15);
    }
    .contact-card .is-invalid {
        border-color: #dc3545 !important;
    }

    .contact-submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--tcn-green-dark) 0%, var(--tcn-green-light) 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .02em;
        cursor: pointer;
        transition: var(--tcn-transition);
        margin-top: 8px;
    }
    .contact-submit-btn:hover {
        background: linear-gradient(135deg, var(--tcn-green) 0%, var(--tcn-green-dark) 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,182,122,.35);
    }

    /* ── Info side ───────────────────────────────────── */
    .contact-info-card {
        background: linear-gradient(135deg, var(--tcn-green-dark) 0%, var(--tcn-green) 100%);
        border-radius: var(--tcn-radius-lg);
        padding: 40px 36px;
        color: #fff;
        height: 100%;
    }
    .contact-info-card h3 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 12px;
    }
    .contact-info-card p {
        font-size: .95rem;
        opacity: .9;
        margin-bottom: 28px;
    }
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 22px;
    }
    .info-item-icon {
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,.18);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .info-item-text strong {
        display: block;
        font-size: .9rem;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .info-item-text span {
        font-size: .88rem;
        opacity: .85;
    }

    /* ── alert ───────────────────────────────────────── */
    .tcn-alert-success {
        background: #ecfdf5;
        border: 1.5px solid #6ee7b7;
        color: #065f46;
        border-radius: 10px;
        padding: 14px 18px;
        font-size: .95rem;
        font-weight: 500;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
</style>
@endsection

@section('content')

    {{-- Hero --}}
    <div class="contact-hero">
        <div class="container">
            <div class="eyebrow"><i class="bi bi-envelope-fill"></i> Get in Touch</div>
            <h1>Ready to Join TrustCredNet?</h1>
            <p>We review every sign-up personally. Drop us your details below and we'll get you onboarded fast.</p>
        </div>
    </div>

    {{-- Main --}}
    <section class="contact-section">
        <div class="container">
            <div class="row g-5 align-items-start justify-content-center">

                {{-- Form --}}
                <div class="col-lg-7">
                    <div class="contact-card">

                        @if(session('success'))
                            <div class="tcn-alert-success" role="alert">
                                <i class="bi bi-check-circle-fill fs-5 flex-shrink-0"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <h2 class="fw-800 mb-1" style="font-size:1.5rem;">Send Us a Message</h2>
                        <p class="text-muted mb-4" style="font-size:.9rem;">Fill in the form and we'll be in touch within one business day.</p>

                        <form method="POST" action="{{ route('contact.store') }}" novalidate>
                            @csrf

                            {{-- Business Name --}}
                            <div class="mb-3">
                                <label for="business_name" class="form-label">
                                    Business Name <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="business_name"
                                    name="business_name"
                                    class="form-control @error('business_name') is-invalid @enderror"
                                    value="{{ old('business_name') }}"
                                    placeholder="e.g. Acme Corp"
                                    required
                                    autocomplete="organization"
                                >
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Business Email <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="you@yourbusiness.com"
                                    required
                                    autocomplete="email"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="mb-4">
                                <label for="message" class="form-label">
                                    Tell us about your business <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="4"
                                    class="form-control @error('message') is-invalid @enderror"
                                    placeholder="What does your business do? How many customers do you have? Anything else we should know?"
                                    required
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="contact-submit-btn">
                                <i class="bi bi-send-fill me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Info sidebar --}}
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="contact-info-card">
                        <h3>What Happens Next?</h3>
                        <p>We review each enquiry personally to make sure TrustCredNet is the right fit.</p>

                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-1-circle-fill"></i></div>
                            <div class="info-item-text">
                                <strong>We review your message</strong>
                                <span>Usually within one business day.</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-2-circle-fill"></i></div>
                            <div class="info-item-text">
                                <strong>We reach out to you</strong>
                                <span>Expect an email with next steps.</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-3-circle-fill"></i></div>
                            <div class="info-item-text">
                                <strong>You get onboarded</strong>
                                <span>Start collecting verified reviews.</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
