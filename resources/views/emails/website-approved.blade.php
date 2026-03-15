<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your listing is live on TrustCredNet</title>
<style>
  body{margin:0;padding:0;background:#F3F4F6;font-family:'Inter',Arial,sans-serif;color:#111827;}
  .wrap{max-width:580px;margin:40px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.07);}
  .header{background:linear-gradient(135deg,#002b1a 0%,#004d2e 50%,#006e42 100%);padding:36px 40px 28px;text-align:center;}
  .header-logo{display:inline-flex;align-items:center;gap:10px;text-decoration:none;}
  .header-icon{width:42px;height:42px;background:rgba(255,255,255,.15);border-radius:10px;display:inline-flex;align-items:center;justify-content:center;font-size:1.2rem;}
  .header-name{color:#fff;font-size:1.2rem;font-weight:800;letter-spacing:-.3px;}
  .header-name span{color:#4ADE80;}
  .hero{padding:32px 40px 8px;text-align:center;}
  .hero-badge{display:inline-block;background:#ECFDF5;color:#059669;border:1.5px solid #A7F3D0;border-radius:20px;padding:6px 16px;font-size:.8rem;font-weight:700;margin-bottom:16px;}
  .hero h1{font-size:1.55rem;font-weight:800;margin:0 0 10px;color:#111827;line-height:1.3;}
  .hero p{font-size:.92rem;color:#6B7280;line-height:1.65;margin:0;}
  .body{padding:24px 40px 32px;}
  .info-box{background:#F9FAFB;border:1.5px solid #E5E7EB;border-radius:12px;padding:18px 20px;margin-bottom:22px;}
  .info-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid #F3F4F6;font-size:.85rem;}
  .info-row:last-child{border-bottom:none;}
  .info-label{color:#9CA3AF;font-weight:500;}
  .info-value{color:#111827;font-weight:600;text-align:right;}
  .cta{text-align:center;margin:24px 0 8px;}
  .cta a{display:inline-block;background:linear-gradient(135deg,#059669,#10B981);color:#fff;text-decoration:none;font-weight:700;font-size:.92rem;padding:13px 32px;border-radius:10px;box-shadow:0 4px 12px rgba(0,182,122,.3);}
  .steps{margin:24px 0;}
  .step{display:flex;gap:14px;align-items:flex-start;margin-bottom:14px;}
  .step-num{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#059669,#10B981);color:#fff;font-size:.75rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
  .step-text{font-size:.85rem;color:#374151;line-height:1.55;}
  .step-text strong{color:#111827;}
  .footer{background:#F9FAFB;border-top:1px solid #E5E7EB;padding:20px 40px;text-align:center;font-size:.75rem;color:#9CA3AF;line-height:1.6;}
  .footer a{color:#059669;text-decoration:none;}
</style>
</head>
<body>
<div class="wrap">

  {{-- Header --}}
  <div class="header">
    <div class="header-logo">
      <div class="header-icon">✓</div>
      <span class="header-name">Trust<span>Cred</span>Net</span>
    </div>
  </div>

  {{-- Hero --}}
  <div class="hero">
    <div class="hero-badge">✅ Listing Approved</div>
    <h1>Your listing is now live!</h1>
    <p>
      Congratulations, <strong>{{ $website->user->name }}</strong>!<br>
      <strong>{{ $website->name }}</strong> has been reviewed and approved by our team.
      Your public profile page is now visible on TrustCredNet.
    </p>
  </div>

  {{-- Body --}}
  <div class="body">

    {{-- Listing details --}}
    <div class="info-box">
      <div class="info-row">
        <span class="info-label">Business Name</span>
        <span class="info-value">{{ $website->name }}</span>
      </div>
      @if($website->url)
      <div class="info-row">
        <span class="info-label">Website</span>
        <span class="info-value">{{ parse_url($website->url, PHP_URL_HOST) ?: $website->url }}</span>
      </div>
      @endif
      <div class="info-row">
        <span class="info-label">Your TrustCredNet Profile</span>
        <span class="info-value"><a href="{{ url('/' . $website->slug) }}" style="color:#059669;">trustcrednet.com/{{ $website->slug }}</a></span>
      </div>
      <div class="info-row">
        <span class="info-label">Live Since</span>
        <span class="info-value">{{ now()->format('F j, Y') }}</span>
      </div>
    </div>

    {{-- CTA --}}
    <div class="cta">
      <a href="{{ url('/' . $website->slug) }}">View Your Live Profile →</a>
    </div>

    {{-- Next steps --}}
    <div class="steps">
      <p style="font-size:.85rem;font-weight:700;color:#111827;margin:20px 0 12px;">What to do next:</p>
      <div class="step">
        <div class="step-num">1</div>
        <div class="step-text"><strong>Share your profile link</strong> — Send <code>trustcrednet.com/{{ $website->slug }}</code> to your customers so they can leave reviews.</div>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <div class="step-text"><strong>Embed the widget</strong> — Add a review badge to your website to show off your TrustCredNet rating. Find it in your <a href="{{ url('/dashboard/widget') }}" style="color:#059669;">Dashboard → Widget</a>.</div>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <div class="step-text"><strong>Manage your reviews</strong> — Visit your <a href="{{ url('/dashboard') }}" style="color:#059669;">Dashboard</a> to approve, feature, and respond to incoming testimonials.</div>
      </div>
    </div>

  </div>

  {{-- Footer --}}
  <div class="footer">
    You're receiving this because you registered on <a href="{{ url('/') }}">TrustCredNet</a>.<br>
    Questions? Contact us at <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.
  </div>

</div>
</body>
</html>
