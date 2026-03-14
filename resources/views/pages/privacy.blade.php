@extends('layouts.tcn')

@section('title', 'Privacy Policy – TrustCredNet')
@section('description', 'Read TrustCredNet\'s Privacy Policy to understand how we collect, use, and protect your personal data.')

@section('content')

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-eyebrow fade-up">
                <i class="bi bi-shield-lock-fill"></i> Legal
            </div>
            <h1 class="page-hero-h1 fade-up d1">Privacy Policy</h1>
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

                        <h2>1. Introduction</h2>
                        <p>TrustCredNet ("we", "us", or "our") is committed to protecting your personal information. This Privacy Policy explains what data we collect, how we use it, and your rights regarding that data when you use our platform at trustcrednet.com.</p>

                        <h2>2. Information We Collect</h2>
                        <p>We may collect the following information:</p>
                        <ul>
                            <li><strong>Account information:</strong> name, email address, and password when you register.</li>
                            <li><strong>Business information:</strong> business name, website URL, and profile details you provide.</li>
                            <li><strong>Usage data:</strong> pages visited, features used, and time spent on the platform.</li>
                            <li><strong>Payment information:</strong> handled securely by our third-party payment processor; we do not store full card details.</li>
                            <li><strong>Communications:</strong> messages you send us via the contact form or email.</li>
                        </ul>

                        <h2>3. How We Use Your Information</h2>
                        <p>We use your information to:</p>
                        <ul>
                            <li>Provide, operate, and improve our services.</li>
                            <li>Process transactions and send related billing notices.</li>
                            <li>Send service updates and respond to your enquiries.</li>
                            <li>Monitor and analyse usage to enhance platform performance.</li>
                            <li>Comply with legal obligations.</li>
                        </ul>

                        <h2>4. Sharing Your Information</h2>
                        <p>We do not sell your personal data. We may share data with trusted third-party service providers (e.g. payment processors, email delivery services) strictly to operate our platform. These providers are contractually bound to keep your data confidential.</p>

                        <h2>5. Data Retention</h2>
                        <p>We retain your data for as long as your account is active or as needed to provide services. You may request deletion of your account and associated data at any time by contacting us.</p>

                        <h2>6. Your Rights</h2>
                        <p>Depending on your location, you may have the right to access, correct, or delete your personal data, restrict or object to processing, and data portability. To exercise any of these rights, contact us at <a href="mailto:privacy@trustcrednet.com">privacy@trustcrednet.com</a>.</p>

                        <h2>7. Cookies</h2>
                        <p>We use cookies to maintain sessions and understand platform usage. See our <a href="{{ route('cookies') }}">Cookie Policy</a> for full details.</p>

                        <h2>8. Security</h2>
                        <p>We implement industry-standard measures including HTTPS encryption, hashed passwords, and regular security audits to protect your data. No method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>

                        <h2>9. Changes to This Policy</h2>
                        <p>We may update this policy from time to time. We will notify you of material changes by posting the updated policy on this page with a new "Last updated" date.</p>

                        <h2>10. Contact Us</h2>
                        <p>If you have questions about this Privacy Policy, please contact us at <a href="mailto:privacy@trustcrednet.com">privacy@trustcrednet.com</a> or via our <a href="{{ route('contact') }}">contact page</a>.</p>

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
