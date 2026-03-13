<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Collect, manage, and display your customer testimonials with TrustCredNet. Build trust and grow your business.">
    <title>TrustCredNet &ndash; Build Trust. Showcase Your Reviews.</title>

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- TrustCredNet Styles -->
    <link rel="stylesheet" href="/css/app.css">

</head>
<body>

    @include('partials.header')

    @include('home.sections.hero')
    @include('home.sections.search')
    @include('home.sections.features')
    @include('home.sections.pricing')
    @include('home.sections.testimonials')
    @include('home.sections.cta')

    @include('partials.footer')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
    particlesJS('particles-js', {
        particles: {
            number: { value: 50, density: { enable: true, value_area: 900 } },
            color: { value: ['#00B67A', '#00CF8D', '#C2E8D6'] },
            shape: { type: 'circle' },
            opacity: { value: 0.25, random: true },
            size: { value: 3, random: true },
            line_linked: { enable: true, distance: 150, color: '#C2E8D6', opacity: 0.2, width: 1 },
            move: { enable: true, speed: 1.0, direction: 'none', random: true, out_mode: 'out' }
        },
        interactivity: {
            detect_on: 'canvas',
            events: { onhover: { enable: true, mode: 'grab' }, onclick: { enable: false }, resize: true },
            modes: { grab: { distance: 160, line_linked: { opacity: 0.45 } } }
        },
        retina_detect: true
    });

    // Navbar scroll
    (function () {
        const nav = document.getElementById('mainNav');
        if (!nav) return;
        const update = () => nav.classList.toggle('nav-scrolled', window.scrollY > 10);
        window.addEventListener('scroll', update, { passive: true });
        update();
    })();

    // Mobile menu
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

    // Fade-up
    (function () {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.08 });
        document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
    })();
    </script>

</body>
</html>
