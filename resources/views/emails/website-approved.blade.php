<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your listing is live on TrustCredNet</title>
<style>
  * { box-sizing: border-box; }
  body {
    margin: 0; padding: 0;
    background: #F0F4F0;
    font-family: Arial, sans-serif;
    color: #111827;
  }
  .outer {
    padding: 48px 16px;
  }
  .card {
    max-width: 560px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,.08);
  }

  /* ── Header ── */
  .header {
    background: linear-gradient(135deg, #002b1a 0%, #005c35 60%, #007c48 100%);
    padding: 40px 48px 36px;
    text-align: center;
  }
  .logo-row {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
  }
  .logo-icon {
    width: 40px; height: 40px;
    background: rgba(255,255,255,.18);
    border-radius: 10px;
    font-size: 1.1rem;
    line-height: 40px;
    text-align: center;
  }
  .logo-text {
    color: #fff;
    font-size: 1.15rem;
    font-weight: 800;
    letter-spacing: -.3px;
  }
  .logo-text span { color: #4ADE80; }
  .header-badge {
    display: inline-block;
    background: rgba(74,222,128,.18);
    color: #4ADE80;
    border: 1.5px solid rgba(74,222,128,.35);
    border-radius: 24px;
    padding: 6px 18px;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 18px;
  }
  .header h1 {
    margin: 0 0 10px;
    color: #fff;
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1.25;
  }
  .header-sub {
    margin: 0;
    color: rgba(255,255,255,.7);
    font-size: .9rem;
    line-height: 1.6;
  }

  /* ── Divider ── */
  .divider {
    height: 1px;
    background: #E5E7EB;
    margin: 0 48px;
  }

  /* ── Section ── */
  .section {
    padding: 36px 48px;
  }
  .section-label {
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #9CA3AF;
    margin: 0 0 16px;
  }

  /* ── Detail rows ── */
  .detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px 0;
    border-bottom: 1px solid #F3F4F6;
  }
  .detail-row:last-child { border-bottom: none; }
  .detail-key {
    font-size: .82rem;
    color: #6B7280;
    font-weight: 500;
  }
  .detail-val {
    font-size: .85rem;
    color: #111827;
    font-weight: 700;
    text-align: right;
    max-width: 65%;
  }
  .detail-val a { color: #059669; text-decoration: none; }

  /* ── CTA ── */
  .cta-section {
    padding: 8px 48px 36px;
    text-align: center;
  }
  .cta-btn {
    display: inline-block;
    background: linear-gradient(135deg, #059669, #10B981);
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: .95rem;
    padding: 15px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(16,185,129,.28);
    letter-spacing: .2px;
  }

  /* ── Steps ── */
  .step {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    padding: 18px 0;
    border-bottom: 1px solid #F3F4F6;
  }
  .step:last-child { border-bottom: none; }
  .step-num {
    width: 32px; height: 32px;
    flex-shrink: 0;
    border-radius: 50%;
    background: linear-gradient(135deg, #059669, #10B981);
    color: #fff;
    font-size: .75rem;
    font-weight: 800;
    text-align: center;
    line-height: 32px;
    margin-top: 1px;
  }
  .step-body { flex: 1; }
  .step-title {
    font-size: .88rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 5px;
  }
  .step-desc {
    font-size: .82rem;
    color: #6B7280;
    line-height: 1.6;
    margin: 0;
  }
  .step-desc a { color: #059669; text-decoration: none; }

  /* ── Footer ── */
  .footer {
    background: #F9FAFB;
    border-top: 1px solid #E5E7EB;
    padding: 24px 48px;
    text-align: center;
    font-size: .75rem;
    color: #9CA3AF;
    line-height: 1.7;
  }
  .footer a { color: #059669; text-decoration: none; }
</style>
</head>
<body>
<div class="outer">
<div class="card">

  {{-- ─ Header ─ --}}
  <div class="header">
    <div class="logo-row">
      <div class="logo-icon">✓</div>
      <span class="logo-text">Trust<span>Cred</span>Net</span>
    </div>
    <div class="header-badge">✅ &nbsp;Listing Approved</div>
    <h1>Your listing is now live!</h1>
    <p class="header-sub">
      Congratulations, <strong style="color:#fff;">{{ $website->user->name }}</strong>.<br>
      Your profile has been reviewed and approved by our team.
    </p>
  </div>

  {{-- ─ Listing Details ─ --}}
  <div class="section">
    <p class="section-label">Listing Details</p>

    <div class="detail-row">
      <span class="detail-key">Business Name</span>
      <span class="detail-val">{{ $website->name }}</span>
    </div>

    @if($website->url)
    <div class="detail-row">
      <span class="detail-key">Website</span>
      <span class="detail-val">{{ parse_url($website->url, PHP_URL_HOST) ?: $website->url }}</span>
    </div>
    @endif

    <div class="detail-row">
      <span class="detail-key">Your TrustCredNet Profile</span>
      <span class="detail-val">
        <a href="{{ url('/reviews/' . $website->slug) }}">trustcrednet.com/reviews/{{ $website->slug }}</a>
      </span>
    </div>

    <div class="detail-row">
      <span class="detail-key">Live Since</span>
      <span class="detail-val">{{ now()->format('F j, Y') }}</span>
    </div>
  </div>

  {{-- ─ CTA ─ --}}
  <div class="cta-section">
    <a href="{{ url('/reviews/' . $website->slug) }}" class="cta-btn">View Your Live Profile &rarr;</a>
  </div>

  <div class="divider"></div>

  {{-- ─ Next Steps ─ --}}
  <div class="section">
    <p class="section-label">What to do next</p>

    <div class="step">
      <div class="step-num">1</div>
      <div class="step-body">
        <p class="step-title">Share your profile link</p>
        <p class="step-desc">
          Send <strong>trustcrednet.com/reviews/{{ $website->slug }}</strong> to your customers
          so they can find and leave reviews for your business.
        </p>
      </div>
    </div>

    <div class="step">
      <div class="step-num">2</div>
      <div class="step-body">
        <p class="step-title">Embed the trust widget</p>
        <p class="step-desc">
          Add a review badge to your own website to showcase your TrustCredNet rating.
          Find the embed code in <a href="{{ url('/dashboard/widget') }}">Dashboard &rarr; Widget</a>.
        </p>
      </div>
    </div>

    <div class="step">
      <div class="step-num">3</div>
      <div class="step-body">
        <p class="step-title">Manage your reviews</p>
        <p class="step-desc">
          Approve, feature, and respond to incoming testimonials from your
          <a href="{{ url('/dashboard') }}">Dashboard</a>.
        </p>
      </div>
    </div>
  </div>

  {{-- ─ Footer ─ --}}
  <div class="footer">
    You received this email because you registered on
    <a href="{{ url('/') }}">TrustCredNet</a>.<br>
    Questions? Reach us at
    <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.
  </div>

</div>
</div>
</body>
</html>
