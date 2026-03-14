@extends('dashboard.layouts.app')
@section('title', 'My Plan – TrustCredNet')
@section('page-title', 'My Plan')

@section('content')

@push('styles')
<style>
.tcn-head{text-align:center;padding:24px 24px 16px;background:linear-gradient(135deg,#ECFDF5,#F0FDF4,#FEF3C7);border-bottom:1px solid #E5E7EB}
.tcn-icon{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#059669,#10B981);color:#fff;font-size:1.4rem;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px}
.tcn-head h2{font-size:1.15rem;font-weight:800;color:#111827;margin:0 0 4px}
.tcn-head p{font-size:.8rem;color:#6B7280;margin:0;line-height:1.45}
.tcn-step-label{display:flex;align-items:center;gap:10px;font-weight:700;font-size:.88rem;color:#111827;margin-bottom:10px}
.tcn-num{width:24px;height:24px;border-radius:50%;background:#059669;color:#fff;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0}
.tcn-tabs{display:flex;gap:6px;margin-bottom:12px}
.tcn-tab{flex:1;padding:8px 0;border:1px solid #E5E7EB;border-radius:8px;background:#F9FAFB;font-size:.78rem;font-weight:600;color:#6B7280;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;transition:all .2s}
.tcn-tab.active{background:#059669;color:#fff;border-color:#059669}
.tcn-tab:hover:not(.active){background:#F3F4F6}
.tcn-tab-content{display:none}
.tcn-tab-content.active{display:block}
.tcn-detail-box{background:#F9FAFB;border:1px solid #E5E7EB;border-radius:10px;padding:10px 14px}
.tcn-detail-row{display:flex;align-items:center;justify-content:space-between;padding:7px 0;border-bottom:1px solid #F3F4F6;gap:8px}
.tcn-detail-row:last-child{border-bottom:none}
.tcn-label{font-size:.76rem;color:#9CA3AF;flex-shrink:0}
.tcn-value{font-size:.8rem;color:#111827;font-weight:500;text-align:right;word-break:break-all}
.tcn-mono{font-family:'Courier New',monospace;font-size:.74rem;letter-spacing:.3px}
.tcn-copy{background:none;border:none;color:#059669;cursor:pointer;font-size:.85rem;padding:2px 4px;flex-shrink:0}
.tcn-copy:hover{color:#047857}
.tcn-section{padding:16px 24px 0}
.tcn-hint{font-size:.8rem;color:#6B7280;margin:0 0 12px;line-height:1.45}
.tcn-wa-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;border-radius:10px;background:#25D366;color:#fff;font-weight:700;font-size:.88rem;text-decoration:none;transition:background .2s}
.tcn-wa-btn:hover{background:#1DA851;color:#fff}
.tcn-note{display:flex;align-items:center;gap:8px;margin:14px 24px 0;padding:10px 14px;border-radius:8px;background:#F0F9FF;border:1px solid #BAE6FD;font-size:.76rem;color:#0369A1;line-height:1.4}
.tcn-note i{flex-shrink:0;font-size:.85rem}
@media(max-width:480px){.tcn-tabs{flex-wrap:wrap}}
</style>
@endpush

@php
    $isActive = !is_null($user->payment_verified_at);
    $price    = $paymentSettings['price_usd'] ?? '30';
@endphp

{{-- Status banner --}}
<div class="dash-card" style="margin-bottom:24px;border:2px solid {{ $isActive ? 'var(--tcn-green)' : 'var(--tcn-border)' }};background:{{ $isActive ? 'var(--tcn-green-pale)' : '#fff' }};">
    <div style="display:flex;align-items:center;gap:18px;flex-wrap:wrap;">
        <div style="width:52px;height:52px;border-radius:14px;background:{{ $isActive ? 'var(--tcn-green)' : '#F3F4F6' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi {{ $isActive ? 'bi-shield-fill-check' : 'bi-shield' }}" style="font-size:1.5rem;color:{{ $isActive ? '#fff' : 'var(--tcn-gray)' }};"></i>
        </div>
        <div style="flex:1;">
            @if($isActive)
                <div style="font-size:1.05rem;font-weight:700;color:var(--tcn-green);">Active Plan</div>
                <div style="font-size:.84rem;color:var(--tcn-heading);margin-top:2px;">
                    Your account is active. Activated on
                    <strong>{{ \Carbon\Carbon::parse($user->payment_verified_at)->format('F d, Y') }}</strong>.
                </div>
            @else
                <div style="font-size:1.05rem;font-weight:700;color:var(--tcn-heading);">Free Plan</div>
                <div style="font-size:.84rem;color:var(--tcn-gray);margin-top:2px;">
                    Upgrade to unlock your full TrustCredNet listing for just <strong>${{ $price }} USD/yr</strong>.
                </div>
            @endif
        </div>
        @if(!$isActive)
        <a href="#how-to-pay" class="dash-btn dash-btn-primary" style="flex-shrink:0;">
            <i class="bi bi-lightning-charge-fill"></i> Activate Now — ${{ $price }}/yr
        </a>
        @endif
    </div>
</div>

@if(!$isActive)

{{-- How to pay --}}
<div class="dash-card" style="margin-bottom:24px;padding:0;overflow:hidden;">
    <div class="tcn-head" style="border-radius:0;">
        <div class="tcn-icon"><i class="bi bi-shield-lock-fill"></i></div>
        <h2>Activate Your Account</h2>
        <p>Just <strong>${{ $price }}/year</strong> — choose a payment method, then send your receipt via WhatsApp to complete activation.</p>
    </div>

    <div style="padding:16px 24px 0;">
        {{-- Step 1 --}}
        <div class="tcn-step-label"><span class="tcn-num">1</span> Make Payment</div>

        <div class="tcn-tabs">
            <button class="tcn-tab active" onclick="switchTab(this,'crypto')"><i class="bi bi-currency-bitcoin"></i> Crypto</button>
            <button class="tcn-tab" onclick="switchTab(this,'moniffy')"><i class="bi bi-wallet2"></i> Moniffy</button>
            <button class="tcn-tab" onclick="switchTab(this,'bank')"><i class="bi bi-bank"></i> Bank Transfer</button>
        </div>

        <div class="tcn-tab-content active" id="tab-crypto">
            <div class="tcn-detail-box">
                <div class="tcn-detail-row">
                    <span class="tcn-label">Network</span>
                    <span class="tcn-value">USDT (TRC20)</span>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Wallet Address</span>
                    <span class="tcn-value tcn-mono" id="cryptoAddr">{{ $paymentSettings['crypto_address'] ?: 'Not configured' }}</span>
                    <button class="tcn-copy" onclick="copyText('cryptoAddr')" title="Copy"><i class="bi bi-copy"></i></button>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Amount</span>
                    <span class="tcn-value" style="font-weight:700;color:#059669;">${{ $price }}.00 USDT <span style="font-weight:500;font-size:.68rem;color:#6B7280;">/year</span></span>
                </div>
            </div>
        </div>

        <div class="tcn-tab-content" id="tab-moniffy">
            <div class="tcn-detail-box">
                <div class="tcn-detail-row">
                    <span class="tcn-label">Platform</span>
                    <span class="tcn-value">Moniffy</span>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Username / Tag</span>
                    <span class="tcn-value tcn-mono" id="moniffyTag">{{ $paymentSettings['moniffy_tag'] ?: 'Not configured' }}</span>
                    <button class="tcn-copy" onclick="copyText('moniffyTag')" title="Copy"><i class="bi bi-copy"></i></button>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Amount</span>
                    <span class="tcn-value naira-amount" style="font-weight:700;color:#059669;">Loading…</span>
                </div>
            </div>
        </div>

        <div class="tcn-tab-content" id="tab-bank">
            <div class="tcn-detail-box">
                <div class="tcn-detail-row">
                    <span class="tcn-label">Bank Name</span>
                    <span class="tcn-value">{{ $paymentSettings['bank_name'] ?: 'Not configured' }}</span>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Account Number</span>
                    <span class="tcn-value tcn-mono" id="bankAcct">{{ $paymentSettings['bank_account_number'] ?: 'Not configured' }}</span>
                    <button class="tcn-copy" onclick="copyText('bankAcct')" title="Copy"><i class="bi bi-copy"></i></button>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Account Name</span>
                    <span class="tcn-value">{{ $paymentSettings['bank_account_name'] ?: 'Not configured' }}</span>
                </div>
                <div class="tcn-detail-row">
                    <span class="tcn-label">Amount</span>
                    <span class="tcn-value naira-amount" style="font-weight:700;color:#059669;">Loading…</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Step 2 --}}
    <div class="tcn-section">
        <div class="tcn-step-label"><span class="tcn-num">2</span> Send Receipt &amp; Get Activated</div>
        <p class="tcn-hint">After payment, send your receipt screenshot to our WhatsApp support. We'll verify and activate your account promptly.</p>
        <a href="https://wa.me/{{ $paymentSettings['whatsapp_number'] }}?text={{ urlencode('Hi TrustCredNet, I just made payment for account activation. Here is my receipt. Email: ' . $user->email) }}"
           target="_blank" rel="noopener" class="tcn-wa-btn">
            <i class="bi bi-whatsapp"></i> Send Receipt on WhatsApp
        </a>
    </div>

    <div class="tcn-note">
        <i class="bi bi-lock-fill"></i> Your account is saved. It goes live once payment is confirmed.
    </div>

    <div style="height:18px;"></div>
</div>

@else

{{-- Already active — what's included --}}
<div class="dash-card">
    <h2 class="dash-card-title" style="margin-bottom:16px;">What's Included</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;">
        @foreach([
            ['icon' => 'bi-globe2',             'label' => 'Business Listing',    'desc' => 'Full public profile'],
            ['icon' => 'bi-chat-quote-fill',    'label' => 'Testimonials',        'desc' => 'Collect & display reviews'],
            ['icon' => 'bi-code-square',        'label' => 'Embed Widget',        'desc' => 'Add badge to your site'],
            ['icon' => 'bi-bar-chart-line-fill','label' => 'Analytics',           'desc' => 'Track profile views'],
            ['icon' => 'bi-shield-fill-check',  'label' => 'Trust Badge',         'desc' => 'Verified credibility'],
        ] as $item)
        <div style="background:var(--tcn-light);border:1.5px solid var(--tcn-border);border-radius:12px;padding:16px;">
            <i class="bi {{ $item['icon'] }}" style="color:var(--tcn-green);font-size:1.1rem;margin-bottom:8px;display:block;"></i>
            <div style="font-size:.8rem;font-weight:700;color:var(--tcn-heading);">{{ $item['label'] }}</div>
            <div style="font-size:.73rem;color:var(--tcn-gray);margin-top:2px;">{{ $item['desc'] }}</div>
        </div>
        @endforeach
    </div>
</div>

@endif

@endsection

@push('scripts')
<script>
function switchTab(btn,id){
    document.querySelectorAll('.tcn-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.tcn-tab-content').forEach(c=>c.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-'+id).classList.add('active');
}
function copyText(id){
    const el=document.getElementById(id);
    navigator.clipboard.writeText(el.textContent.trim()).then(()=>{
        const orig=el.style.color;el.style.color='#059669';
        setTimeout(()=>el.style.color=orig,800);
    });
}
(function(){
    const USD_AMOUNT={{ (float)($paymentSettings['price_usd'] ?? 30) }};
    const setNaira=(rate)=>{
        const naira=Math.round(USD_AMOUNT*rate).toLocaleString();
        document.querySelectorAll('.naira-amount').forEach(el=>el.innerHTML='₦'+naira+' <span style="font-weight:500;font-size:.68rem;color:#6B7280;">/year</span>');
    };
    fetch('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.json')
        .then(r=>r.json())
        .then(data=>{
            const rate=data.usd&&data.usd.ngn;
            if(rate){setNaira(rate);return;}
            throw new Error('no rate');
        })
        .catch(()=>{
            fetch('https://open.er-api.com/v6/latest/USD')
                .then(r=>r.json())
                .then(data=>{
                    const rate=data.rates&&data.rates.NGN;
                    if(rate)setNaira(rate);
                    else document.querySelectorAll('.naira-amount').forEach(el=>el.textContent='₦—');
                })
                .catch(()=>{
                    document.querySelectorAll('.naira-amount').forEach(el=>el.textContent='₦—');
                });
        });
})();
</script>
@endpush
