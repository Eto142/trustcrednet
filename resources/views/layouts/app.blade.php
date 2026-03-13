<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Collect, manage, and display your customer testimonials with TrustCredNet. Build trust and grow your business.')">
    <title>@yield('title', 'TrustCredNet – Build Trust. Showcase Your Reviews.')</title>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @yield('styles')

    <style>
        /* ══════════════════════════════════════════════
           GLOBAL DESIGN TOKENS & SHARED STYLES
        ══════════════════════════════════════════════ */
        :root {
            --tcn-blue:        #1045A8;
            --tcn-blue-light:  #2563EB;
            --tcn-blue-dark:   #0C3480;
            --tcn-teal:        #0891B2;
            --tcn-gold:        #F59E0B;
            --tcn-dark:        #0F172A;
            --tcn-gray:        #64748B;
            --tcn-gray-light:  #94A3B8;
            --tcn-light:       #F8FAFC;
            --tcn-border:      #E2E8F0;
            --tcn-success:     #10B981;
            --tcn-transition:  all .22s ease;
            --tcn-radius:      12px;
            --tcn-radius-lg:   18px;
            --tcn-shadow:      0 4px 24px rgba(16,69,168,.10);
            --tcn-shadow-lg:   0 12px 48px rgba(16,69,168,.16);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--tcn-dark);
            background: #fff;
            overflow-x: hidden;
            line-height: 1.6;
        }
        img { max-width: 100%; }

        /* ══ Utility colors ══ */
        .text-teal  { color: var(--tcn-teal)  !important; }
        .text-gold  { color: var(--tcn-gold)  !important; }
        .text-blue  { color: var(--tcn-blue)  !important; }
        .text-muted { color: var(--tcn-gray)  !important; }

        /* ══ Shared Buttons ══ */
        .btn-tcn-primary {
            background: linear-gradient(135deg, var(--tcn-blue-light), var(--tcn-blue));
            color: #fff !important;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: var(--tcn-radius);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--tcn-transition);
            box-shadow: 0 4px 18px rgba(37,99,235,.35);
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
        }
        .btn-tcn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(37,99,235,.45);
        }

        .btn-tcn-outline {
            background: transparent;
            color: #fff !important;
            font-weight: 600;
            padding: 12px 26px;
            border-radius: var(--tcn-radius);
            border: 1.5px solid rgba(255,255,255,.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--tcn-transition);
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
        }
        .btn-tcn-outline:hover {
            border-color: rgba(255,255,255,.9);
            background: rgba(255,255,255,.1);
        }

        .btn-tcn-light {
            background: #fff;
            color: var(--tcn-blue) !important;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: var(--tcn-radius);
            border: 1.5px solid var(--tcn-border);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--tcn-transition);
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
        }
        .btn-tcn-light:hover {
            transform: translateY(-2px);
            border-color: var(--tcn-blue-light);
            box-shadow: var(--tcn-shadow);
        }

        /* ══ Section Helpers ══ */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 14px;
        }
        .eyebrow-blue  { background: rgba(16,69,168,.09); color: var(--tcn-blue-light); }
        .eyebrow-teal  { background: rgba(8,145,178,.09); color: var(--tcn-teal); }
        .eyebrow-white { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2); color: rgba(255,255,255,.9); }

        .section-headline {
            font-size: clamp(1.9rem, 3.5vw, 2.75rem);
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1.12;
            margin-bottom: 14px;
        }
        .section-sub {
            font-size: 1.07rem;
            color: var(--tcn-gray);
            line-height: 1.7;
            max-width: 520px;
        }

        /* ══ Fade-Up Scroll Animation ══ */
        .fade-up {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity .55s ease, transform .55s ease;
        }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .fade-up.d1 { transition-delay: .1s; }
        .fade-up.d2 { transition-delay: .2s; }
        .fade-up.d3 { transition-delay: .3s; }
        .fade-up.d4 { transition-delay: .4s; }
        .fade-up.d5 { transition-delay: .5s; }
        .fade-up.d6 { transition-delay: .6s; }
    </style>
</head>
<body>

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    /* ══════════════════════════════════════════════
       SHARED JAVASCRIPT
    ══════════════════════════════════════════════ */

    // Navbar scroll shadow
    (function () {
        const nav = document.getElementById('mainNav');
        if (!nav) return;
        const update = () => {
            nav.classList.toggle('nav-scrolled', window.scrollY > 10);
        };
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
            toggle.innerHTML = open
                ? '<i class="bi bi-x-lg"></i>'
                : '<i class="bi bi-list"></i>';
        });
        menu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                menu.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.innerHTML = '<i class="bi bi-list"></i>';
            });
        });
    })();

    // Fade-up IntersectionObserver
    (function () {
        const els = document.querySelectorAll('.fade-up');
        if (!els.length) return;
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.08 });
        els.forEach(el => obs.observe(el));
    })();
    </script>

    @yield('scripts')
</body>
</html>
