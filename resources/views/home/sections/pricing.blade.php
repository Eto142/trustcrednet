<section id="pricing">
    <div class="container">
        <div class="text-center fade-up">
            <div class="section-eyebrow eyebrow-blue">
                <i class="bi bi-tag-fill"></i> Simple Pricing
            </div>
            <h2 class="section-headline">Plans That Grow With You</h2>
            <p class="section-sub mx-auto" style="text-align:center;">
                Start free and scale as your reputation grows. No hidden fees, no lock-in contracts.
            </p>
            <div class="billing-toggle-wrap mt-3">
                <button class="bill-btn active" id="btnMonthly" onclick="setBilling('monthly')">Monthly</button>
                <button class="bill-btn" id="btnYearly"  onclick="setBilling('yearly')">
                    Yearly <span class="save-chip">Save 20%</span>
                </button>
            </div>
        </div>

        <div class="pricing-grid">

            {{-- Starter --}}
            <div class="price-card fade-up d1">
                <div class="plan-name">Starter</div>
                <div class="price-amount-wrap">
                    <span class="price-currency">$</span>
                    <span class="price-num" id="priceStarter">0</span>
                </div>
                <div class="price-per">/ month &mdash; forever free</div>
                <p class="price-desc">Perfect for solo entrepreneurs and small businesses just getting started.</p>
                <div class="price-divider"></div>
                <ul class="price-features">
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Up to 25 reviews / month</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> 1 business profile</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Embeddable review widget</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Basic analytics</li>
                    <li class="pf-item dimmed"><i class="bi bi-x-circle-fill"></i> Custom branding</li>
                    <li class="pf-item dimmed"><i class="bi bi-x-circle-fill"></i> Priority support</li>
                </ul>
                <a href="#" class="price-cta">Get Started Free</a>
            </div>

            {{-- Growth (popular) --}}
            <div class="price-card popular fade-up d2">
                <div class="popular-tag"><i class="bi bi-lightning-fill me-1"></i>Most Popular</div>
                <div class="plan-name" style="color:var(--tcn-blue-light);">Growth</div>
                <div class="price-amount-wrap">
                    <span class="price-currency" style="color:var(--tcn-blue);">$</span>
                    <span class="price-num" id="priceGrowth" style="color:var(--tcn-blue);">49</span>
                </div>
                <div class="price-per">/ month, billed as selected</div>
                <p class="price-desc">For growing businesses that want to maximize their reputation and conversions.</p>
                <div class="price-divider"></div>
                <ul class="price-features">
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Unlimited reviews</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Up to 5 business profiles</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Custom branded widgets</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Advanced analytics + insights</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Social sharing cards</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Priority email support</li>
                </ul>
                <a href="#" class="price-cta cta-primary">
                    <i class="bi bi-building-add me-1"></i> Add Your Business
                </a>
            </div>

            {{-- Enterprise --}}
            <div class="price-card fade-up d3">
                <div class="plan-name">Enterprise</div>
                <div class="price-amount-wrap">
                    <span class="price-currency">$</span>
                    <span class="price-num" id="priceEnterprise">149</span>
                </div>
                <div class="price-per">/ month, billed as selected</div>
                <p class="price-desc">For agencies and large organisations managing multiple brands and locations.</p>
                <div class="price-divider"></div>
                <ul class="price-features">
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Everything in Growth</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Unlimited business profiles</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> White-label dashboard</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> API access &amp; webhooks</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Fraud detection AI</li>
                    <li class="pf-item"><i class="bi bi-check-circle-fill"></i> Dedicated account manager</li>
                </ul>
                <a href="#" class="price-cta">Contact Sales <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="faq-section fade-up">
            <h3 class="faq-title">Pricing FAQs</h3>
            <div class="faq-list">
                <div class="faq-item" id="faq1">
                    <button class="faq-q" onclick="toggleFaq('faq1')">
                        Can I upgrade or downgrade my plan at any time?
                        <i class="bi bi-plus faq-icon"></i>
                    </button>
                    <div class="faq-a">Yes, you can change your plan at any time from your account settings. Upgrades take effect immediately; downgrades apply at your next billing cycle.</div>
                </div>
                <div class="faq-item" id="faq2">
                    <button class="faq-q" onclick="toggleFaq('faq2')">
                        Is there a free trial for paid plans?
                        <i class="bi bi-plus faq-icon"></i>
                    </button>
                    <div class="faq-a">All paid plans come with a 14-day free trial. No credit card is required to start. You'll only be billed after the trial ends if you choose to continue.</div>
                </div>
                <div class="faq-item" id="faq3">
                    <button class="faq-q" onclick="toggleFaq('faq3')">
                        What happens to my reviews if I cancel?
                        <i class="bi bi-plus faq-icon"></i>
                    </button>
                    <div class="faq-a">Your reviews and data remain accessible for 30 days after cancellation. You can export all your data at any time from the dashboard before your account closes.</div>
                </div>
                <div class="faq-item" id="faq4">
                    <button class="faq-q" onclick="toggleFaq('faq4')">
                        Do you offer discounts for nonprofits or startups?
                        <i class="bi bi-plus faq-icon"></i>
                    </button>
                    <div class="faq-a">Yes! We offer 40% discounts for registered nonprofits and early-stage startups (under 2 years old, pre-seed or seed stage). Contact our team to apply.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Pricing toggle
const _prices = { monthly: [0,49,149], yearly: [0,39,119] };
function setBilling(type) {
    ['btnMonthly','btnYearly'].forEach(id => document.getElementById(id).classList.remove('active'));
    document.getElementById(type === 'monthly' ? 'btnMonthly' : 'btnYearly').classList.add('active');
    const [s,g,e] = _prices[type];
    document.getElementById('priceStarter').textContent   = s;
    document.getElementById('priceGrowth').textContent    = g;
    document.getElementById('priceEnterprise').textContent = e;
}

// FAQ accordion
function toggleFaq(id) {
    const item = document.getElementById(id);
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}
</script>
