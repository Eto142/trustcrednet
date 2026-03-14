@extends('layouts.tcn')

@section('title', 'Cookie Policy – TrustCredNet')
@section('description', 'Learn how TrustCredNet uses cookies and how you can manage your preferences.')

@section('content')

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-eyebrow fade-up">
                <i class="bi bi-cookie"></i> Legal
            </div>
            <h1 class="page-hero-h1 fade-up d1">Cookie Policy</h1>
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

                        <h2>1. What Are Cookies?</h2>
                        <p>Cookies are small text files placed on your device by websites you visit. They are widely used to make websites work more efficiently, remember your preferences, and provide basic reporting information.</p>

                        <h2>2. How We Use Cookies</h2>
                        <p>TrustCredNet uses cookies for the following purposes:</p>

                        <h3 style="font-size:1rem;font-weight:700;margin-top:1.2rem;">Essential Cookies</h3>
                        <p>These are required for the platform to function. They enable core features such as user authentication, session management, and security (e.g. CSRF protection). You cannot opt out of these cookies.</p>

                        <h3 style="font-size:1rem;font-weight:700;margin-top:1.2rem;">Performance & Analytics Cookies</h3>
                        <p>These cookies help us understand how visitors interact with our platform — which pages are visited most, where users come from, and how they navigate. This data is aggregated and anonymous. We use this to improve the platform experience.</p>

                        <h3 style="font-size:1rem;font-weight:700;margin-top:1.2rem;">Preference Cookies</h3>
                        <p>These remember choices you make (such as billing cycle selection on the pricing page) so you don't have to re-enter them on each visit.</p>

                        <h2>3. Cookies We Set</h2>
                        <table style="width:100%;border-collapse:collapse;font-size:.9rem;margin-bottom:1.5rem;">
                            <thead>
                                <tr style="background:var(--tcn-light);border-bottom:2px solid var(--tcn-border);">
                                    <th style="padding:10px 12px;text-align:left;">Cookie Name</th>
                                    <th style="padding:10px 12px;text-align:left;">Type</th>
                                    <th style="padding:10px 12px;text-align:left;">Purpose</th>
                                    <th style="padding:10px 12px;text-align:left;">Expires</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom:1px solid var(--tcn-border);">
                                    <td style="padding:10px 12px;"><code>trustcrednet_session</code></td>
                                    <td style="padding:10px 12px;">Essential</td>
                                    <td style="padding:10px 12px;">Maintains your login session</td>
                                    <td style="padding:10px 12px;">Session</td>
                                </tr>
                                <tr style="border-bottom:1px solid var(--tcn-border);">
                                    <td style="padding:10px 12px;"><code>XSRF-TOKEN</code></td>
                                    <td style="padding:10px 12px;">Essential</td>
                                    <td style="padding:10px 12px;">Protects against cross-site request forgery</td>
                                    <td style="padding:10px 12px;">Session</td>
                                </tr>
                                <tr style="border-bottom:1px solid var(--tcn-border);">
                                    <td style="padding:10px 12px;"><code>remember_web_*</code></td>
                                    <td style="padding:10px 12px;">Preference</td>
                                    <td style="padding:10px 12px;">Keeps you logged in if "Remember me" is selected</td>
                                    <td style="padding:10px 12px;">400 days</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2>4. Managing Cookies</h2>
                        <p>Most web browsers allow you to manage cookie preferences through their settings. You can block or delete cookies at any time. Note that disabling essential cookies will prevent you from logging in or using core features of the platform.</p>
                        <p>Here are links to cookie management guidance for common browsers:</p>
                        <ul>
                            <li><strong>Chrome:</strong> Settings → Privacy and security → Cookies and other site data</li>
                            <li><strong>Firefox:</strong> Options → Privacy & Security → Cookies and Site Data</li>
                            <li><strong>Safari:</strong> Preferences → Privacy → Manage Website Data</li>
                            <li><strong>Edge:</strong> Settings → Cookies and site permissions</li>
                        </ul>

                        <h2>5. Third-Party Cookies</h2>
                        <p>We do not currently use third-party advertising cookies. If we integrate third-party analytics or tools in the future, this policy will be updated accordingly.</p>

                        <h2>6. Changes to This Policy</h2>
                        <p>We may update this Cookie Policy as our use of cookies changes. Any updates will be posted on this page with a revised "Last updated" date.</p>

                        <h2>7. Contact Us</h2>
                        <p>If you have any questions about our use of cookies, please contact us at <a href="mailto:privacy@trustcrednet.com">privacy@trustcrednet.com</a> or via our <a href="{{ route('contact') }}">contact page</a>.</p>

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
    .legal-body table th, .legal-body table td {
        color: var(--tcn-body);
    }
    .legal-body code {
        background: var(--tcn-light);
        border: 1px solid var(--tcn-border);
        border-radius: 4px;
        padding: 1px 5px;
        font-size: .85rem;
    }
</style>
@endsection
