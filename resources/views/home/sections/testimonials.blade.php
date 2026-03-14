<section id="testimonials">
    <div class="container">
        <div class="text-center fade-up">
            <div class="section-eyebrow eyebrow-teal">
                <i class="bi bi-chat-quote-fill"></i> Success Stories
            </div>
            <h2 class="section-headline">Businesses Love TrustCredNet</h2>
            <p class="section-sub mx-auto" style="text-align:center;">
                Thousands of businesses have grown their revenue and reputation  here's what they say.
            </p>
        </div>

        {{-- Logo marquee --}}
        <div class="marquee-section fade-up d1">
            <p class="marquee-label">Trusted by companies across every industry</p>
            <div class="marquee-track" aria-hidden="true">
                @php
                    $logos = [
                        ['icon' => 'bi-cpu',           'name' => 'TechCorp'],
                        ['icon' => 'bi-heart-pulse',   'name' => 'HealthFirst'],
                        ['icon' => 'bi-leaf',          'name' => 'GreenLeaf'],
                        ['icon' => 'bi-graph-up',      'name' => 'GrowthLabs'],
                        ['icon' => 'bi-briefcase',     'name' => 'LexPro Legal'],
                        ['icon' => 'bi-activity',      'name' => 'FitZone'],
                        ['icon' => 'bi-house',         'name' => 'HomeCraft'],
                        ['icon' => 'bi-cash-stack',    'name' => 'FinancePro'],
                        ['icon' => 'bi-camera',        'name' => 'PixelStudio'],
                        ['icon' => 'bi-cloud',         'name' => 'CloudBase'],
                    ];
                @endphp
                @foreach(array_merge($logos, $logos) as $logo)
                    <div class="marquee-logo">
                        <i class="bi {{ $logo['icon'] }}"></i>
                        {{ $logo['name'] }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Testimonial cards --}}
        <div class="testi-grid">
            <div class="testi-card fade-up d1">
                <span class="testi-quote-icon">&ldquo;</span>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"TrustCredNet transformed our reputation strategy. Our conversion rate jumped 38% within two months of launching our review widget."</p>
                <div class="testi-author">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#2563EB,#1D4ED8);">JD</div>
                    <div>
                        <div class="testi-name">James Davidson</div>
                        <div class="testi-role">CEO, TechCorp Solutions</div>
                    </div>
                    <span class="testi-result-badge">+38% CVR</span>
                </div>
            </div>

            <div class="testi-card fade-up d2">
                <span class="testi-quote-icon">&ldquo;</span>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"We had no idea how powerful social proof could be. After 3 months, our Google Ads ROAS doubled. The embed widget is insanely easy to use."</p>
                <div class="testi-author">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#10B981,#059669);">SM</div>
                    <div>
                        <div class="testi-name">Sarah Mitchell</div>
                        <div class="testi-role">Marketing Director, GreenLeaf</div>
                    </div>
                    <span class="testi-result-badge">2× ROAS</span>
                </div>
            </div>

            <div class="testi-card fade-up d3">
                <span class="testi-quote-icon">&ldquo;</span>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"Managing reviews used to take 3 hours a week across 5 platforms. Now it takes 20 minutes in TrustCredNet. The analytics alone are worth it."</p>
                <div class="testi-author">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#7C3AED,#6D28D9);">RK</div>
                    <div>
                        <div class="testi-name">Riya Kapoor</div>
                        <div class="testi-role">Operations Lead, FitZone</div>
                    </div>
                    <span class="testi-result-badge">3h saved/wk</span>
                </div>
            </div>

            <div class="testi-card fade-up d1">
                <span class="testi-quote-icon">&ldquo;</span>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"The fraud detection is a game-changer. We went from dealing with 12 fake reviews a month to zero. The Verified badge has boosted client trust significantly."</p>
                <div class="testi-author">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#0891B2,#0E7490);">AL</div>
                    <div>
                        <div class="testi-name">Alex Lee</div>
                        <div class="testi-role">Partner, LexPro Legal</div>
                    </div>
                    <span class="testi-result-badge">0 fake reviews</span>
                </div>
            </div>

            <div class="testi-card fade-up d2">
                <span class="testi-quote-icon">&ldquo;</span>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"We switched from a competitor and immediately noticed the difference in customer support quality. The platform is intuitive and the analytics are top-tier."</p>
                <div class="testi-author">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#F59E0B,#D97706);">NP</div>
                    <div>
                        <div class="testi-name">Nina Patel</div>
                        <div class="testi-role">Founder, HomeCraft Design</div>
                    </div>
                    <span class="testi-result-badge">5★ avg rating</span>
                </div>
            </div>

            <div class="testi-card fade-up d3">
                <span class="testi-quote-icon">&ldquo;</span>
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"As an agency we manage 30+ brands. TrustCredNet's Enterprise plan pays for itself. The white-label dashboard impresses our clients every single time."</p>
                <div class="testi-author">
                    <div class="testi-avatar" style="background:linear-gradient(135deg,#EC4899,#BE185D);">DW</div>
                    <div>
                        <div class="testi-name">Daniel Wong</div>
                        <div class="testi-role">CEO, PixelStudio Agency</div>
                    </div>
                    <span class="testi-result-badge">30+ brands</span>
                </div>
            </div>
        </div>

        {{-- Stats strip --}}
        <div class="testi-stats-strip fade-up">
            <div class="tss-item">
                <div class="tss-val">12K+</div>
                <div class="tss-lbl">Businesses</div>
            </div>
            <div class="tss-divider"></div>
            <div class="tss-item">
                <div class="tss-val">2.4M+</div>
                <div class="tss-lbl">Reviews Collected</div>
            </div>
            <div class="tss-divider"></div>
            <div class="tss-item">
                <div class="tss-val">4.9★</div>
                <div class="tss-lbl">Platform Rating</div>
            </div>
            <div class="tss-divider"></div>
            <div class="tss-item">
                <div class="tss-val">98%</div>
                <div class="tss-lbl">Authenticity Rate</div>
            </div>
            <div class="tss-divider"></div>
            <div class="tss-item">
                <div class="tss-val">50+</div>
                <div class="tss-lbl">Industries</div>
            </div>
        </div>

    </div>
</section>
