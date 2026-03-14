<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Collect, manage, and display customer reviews with TrustCredNet.')">
    <title>@yield('title', 'TrustCredNet – Build Trust. Showcase Your Reviews.')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">

    @yield('head')
</head>
<body class="is-inner-page">

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    {{-- Cookie Consent Banner --}}
    <div id="cookieBanner" role="dialog" aria-live="polite" aria-label="Cookie consent" style="
        display: none;
        position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
        width: calc(100% - 48px); max-width: 720px;
        background: #0F172A;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 16px;
        padding: 20px 24px;
        z-index: 9999;
        box-shadow: 0 16px 48px rgba(0,0,0,.45);
        display: flex; align-items: center; justify-content: space-between; gap: 20px;
        flex-wrap: wrap;
    ">
        <div style="display:flex;align-items:flex-start;gap:14px;flex:1;min-width:220px;">
            <i class="bi bi-cookie" style="font-size:1.5rem;color:#F59E0B;flex-shrink:0;margin-top:2px;"></i>
            <p style="margin:0;font-size:.88rem;color:rgba(255,255,255,.8);line-height:1.6;">
                We use cookies to keep you logged in and understand how you use TrustCredNet.
                By clicking <strong style="color:#fff;">Accept</strong> you agree to our
                <a href="{{ route('cookies') }}" style="color:var(--tcn-green);text-decoration:underline;">Cookie Policy</a>
                and
                <a href="{{ route('privacy') }}" style="color:var(--tcn-green);text-decoration:underline;">Privacy Policy</a>.
            </p>
        </div>
        <div style="display:flex;gap:10px;flex-shrink:0;flex-wrap:wrap;">
            <button id="cookieDecline" style="
                background: rgba(255,255,255,.08);
                border: 1px solid rgba(255,255,255,.15);
                color: rgba(255,255,255,.7);
                border-radius: 9px; padding: 9px 18px;
                font-size: .85rem; font-weight: 600; cursor: pointer;
                transition: background .2s;
            ">Decline</button>
            <button id="cookieAccept" style="
                background: #00B67A;
                border: none; color: #fff;
                border-radius: 9px; padding: 9px 20px;
                font-size: .85rem; font-weight: 700; cursor: pointer;
                transition: background .2s;
            ">Accept All</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Navbar scroll effect
    (function () {
        const nav = document.getElementById('mainNav');
        if (!nav) return;
        const update = () => nav.classList.toggle('nav-scrolled', window.scrollY > 10);
        window.addEventListener('scroll', update, { passive: true });
        update();
    })();

    // Mobile menu toggle
    (function () {
        const toggle = document.getElementById('mobileMenuToggle');
        const menu   = document.getElementById('mobileMenu');
        if (!toggle || !menu) return;
        toggle.addEventListener('click', () => {
            const open = menu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', String(open));
            toggle.innerHTML = open ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-list"></i>';
        });
        menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
            menu.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.innerHTML = '<i class="bi bi-list"></i>';
        }));
    })();

    // Fade-up on scroll
    (function () {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
    })();
    </script>

    @yield('scripts')

    <script>
    // Cookie consent banner
    (function () {
        const banner  = document.getElementById('cookieBanner');
        const accept  = document.getElementById('cookieAccept');
        const decline = document.getElementById('cookieDecline');
        if (!banner) return;
        if (!localStorage.getItem('tcn_cookie_consent')) {
            banner.style.display = 'flex';
        }
        accept.addEventListener('click', function () {
            localStorage.setItem('tcn_cookie_consent', 'accepted');
            banner.style.display = 'none';
        });
        decline.addEventListener('click', function () {
            localStorage.setItem('tcn_cookie_consent', 'declined');
            banner.style.display = 'none';
        });
    })();
    </script>
</body>
</html>
