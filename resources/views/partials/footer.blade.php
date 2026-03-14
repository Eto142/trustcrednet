<footer id="mainFooter" aria-label="Site footer">
    <div class="container">
        <div class="row g-5">

            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6">
                <a href="/" class="tcn-logo" style="font-size:1.15rem;">
                    <div class="logo-icon-wrap" style="width:32px;height:32px;font-size:.9rem;" aria-hidden="true">
                        <i class="bi bi-shield-fill-check"></i>
                    </div>
                    <span class="logo-text">Trust<span>Cred</span>Net</span>
                </a>
                <p class="footer-brand-desc">
                    The trusted platform for collecting, managing, and showcasing authentic customer reviews. Build credibility that converts.
                </p>
                <div class="mt-3">
                    <a href="mailto:support@trustcrednet.com" class="footer-contact-chip">
                        <i class="bi bi-envelope-fill"></i> support@trustcrednet.com
                    </a>
                    <a href="#" class="footer-contact-chip">
                        <i class="bi bi-headset"></i> 24/7 Support Portal
                    </a>
                </div>
                {{-- <div class="footer-social">
                    <a href="#" class="social-icon" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div> --}}
            </div>

            <!-- Product -->
            <div class="col-lg-2 col-md-3 col-6">
                <p class="footer-heading">Product</p>
                <ul class="footer-links">
                    <li><a href="{{ route('features') }}">Features</a></li>
                    <li><a href="{{ route('pricing') }}">Pricing</a></li>
                    {{-- <li><a href="#">Widget Builder</a></li> --}}
                    {{-- <li><a href="#">Analytics</a></li> --}}
                    {{-- <li><a href="#">Integrations</a></li> --}}
                    {{-- <li><a href="#">API Docs</a></li> --}}
                </ul>
            </div>

            <!-- Company -->
            <div class="col-lg-2 col-md-3 col-6">
                <p class="footer-heading">Company</p>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    {{-- <li><a href="#">Blog</a></li> --}}
                    {{-- <li><a href="#">Careers</a></li> --}}
                    {{-- <li><a href="#">Press Kit</a></li> --}}
                    {{-- <li><a href="#">Partners</a></li> --}}
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-lg-2 col-md-3 col-6">
                <p class="footer-heading">Support</p>
                <ul class="footer-links">
                    {{-- <li><a href="#">Help Center</a></li> --}}
                    {{-- <li><a href="#">Status</a></li> --}}
                    {{-- <li><a href="#">Community</a></li> --}}
                    {{-- <li><a href="#">Changelog</a></li> --}}
                    {{-- <li><a href="#">Security</a></li> --}}
                </ul>
            </div>

            <!-- Legal -->
            <div class="col-lg-2 col-md-3 col-6">
                <p class="footer-heading">Legal</p>
                <ul class="footer-links">
                    {{-- <li><a href="#">Privacy Policy</a></li> --}}
                    {{-- <li><a href="#">Terms of Service</a></li> --}}
                    {{-- <li><a href="#">Cookie Policy</a></li> --}}
                    {{-- <li><a href="#">GDPR</a></li> --}}
                    {{-- <li><a href="#">Accessibility</a></li> --}}
                </ul>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <p class="mb-0" style="font-size:.8rem;color:rgba(255,255,255,.33);">
                    &copy; {{ date('Y') }} TrustCredNet. All rights reserved.
                </p>
                <ul class="footer-bottom-links">
                    <li><a href="{{ route('privacy') }}">Privacy</a></li>
                    <li><a href="{{ route('terms') }}">Terms</a></li>
                    <li><a href="{{ route('cookies') }}">Cookies</a></li>
                    <li>
                        <a href="#" style="display:flex;align-items:center;">
                            <span class="status-dot"></span> All systems operational
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
