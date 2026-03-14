@extends('layouts.tcn')

@section('title', 'Terms of Service – TrustCredNet')
@section('description', 'Read TrustCredNet\'s Terms of Service governing your use of our platform.')

@section('content')

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-eyebrow fade-up">
                <i class="bi bi-file-earmark-text-fill"></i> Legal
            </div>
            <h1 class="page-hero-h1 fade-up d1">Terms of Service</h1>
            <p class="page-hero-sub fade-up d2">
                Last updated: {{ date('F d, Y') }}
            </p>
        </div>
    </div>

    <section style="padding: 64px 0 96px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="legal-body">

                        <h2>1. Acceptance of Terms</h2>
                        <p>By creating an account or using TrustCredNet ("the Service"), you agree to be bound by these Terms of Service. If you do not agree, do not use the Service.</p>

                        <h2>2. Description of Service</h2>
                        <p>TrustCredNet is an online platform that enables businesses to collect, manage, and display customer reviews. Features include embeddable widgets, analytics dashboards, and business profile pages.</p>

                        <h2>3. Account Registration</h2>
                        <p>You must provide accurate and complete information when registering. You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. Notify us immediately at <a href="mailto:support@trustcrednet.com">support@trustcrednet.com</a> if you suspect unauthorised access.</p>

                        <h2>4. Acceptable Use</h2>
                        <p>You agree not to:</p>
                        <ul>
                            <li>Post false, misleading, or fraudulent reviews or business information.</li>
                            <li>Use the Service for any unlawful purpose.</li>
                            <li>Attempt to reverse-engineer, scrape, or disrupt the platform.</li>
                            <li>Impersonate any person or entity.</li>
                            <li>Upload harmful, offensive, or infringing content.</li>
                        </ul>

                        <h2>5. Subscriptions & Billing</h2>
                        <p>Paid plans are billed on a monthly or annual basis as selected. All fees are non-refundable except where required by law. We reserve the right to change pricing with 30 days' notice. Continued use after a price change constitutes acceptance of the new pricing.</p>

                        <h2>6. Intellectual Property</h2>
                        <p>All content, design, and code comprising TrustCredNet is owned by or licensed to us. You retain ownership of content you submit (reviews, business details) but grant us a licence to display and process it as needed to provide the Service.</p>

                        <h2>7. Termination</h2>
                        <p>We may suspend or terminate your account at our discretion if you violate these Terms or engage in conduct harmful to other users or to TrustCredNet. You may cancel your account at any time from your dashboard settings.</p>

                        <h2>8. Disclaimers</h2>
                        <p>The Service is provided "as is" without warranties of any kind. We do not guarantee that review content is accurate or that the platform will be uninterrupted or error-free.</p>

                        <h2>9. Limitation of Liability</h2>
                        <p>To the maximum extent permitted by law, TrustCredNet shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service.</p>

                        <h2>10. Governing Law</h2>
                        <p>These Terms shall be governed by and construed in accordance with applicable law. Any disputes shall be resolved through binding arbitration or the courts of competent jurisdiction.</p>

                        <h2>11. Changes to Terms</h2>
                        <p>We may update these Terms at any time. Continued use of the Service after changes are posted constitutes your acceptance of the revised Terms.</p>

                        <h2>12. Contact</h2>
                        <p>Questions about these Terms? Contact us at <a href="mailto:legal@trustcrednet.com">legal@trustcrednet.com</a> or via our <a href="{{ route('contact') }}">contact page</a>.</p>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('head')
<style>
    .legal-body h2 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--tcn-heading);
        margin: 2rem 0 .6rem;
    }
    .legal-body p, .legal-body li {
        color: var(--tcn-body);
        line-height: 1.8;
        font-size: .97rem;
    }
    .legal-body ul {
        padding-left: 1.4rem;
        margin-bottom: 1rem;
    }
    .legal-body a {
        color: var(--tcn-green);
        text-decoration: underline;
    }
</style>
@endsection
