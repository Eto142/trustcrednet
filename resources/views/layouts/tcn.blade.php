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
</body>
</html>
