<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – TrustCredNet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    @yield('head')
    @stack('styles')
</head>
<body class="dash-body">

<div class="dash-wrap">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="dash-sidebar" id="dashSidebar">
        <div class="dash-sidebar-inner">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="dash-logo">
                <div class="dash-logo-icon"><i class="bi bi-shield-fill-check"></i></div>
                <span class="dash-logo-text">Trust<span>Cred</span>Net</span>
            </a>

            {{-- Navigation --}}
            <nav class="dash-nav">
                <div class="dash-nav-label">Main</div>

                <a href="{{ route('dashboard.index') }}"
                   class="dash-nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    <span>Overview</span>
                </a>

                <a href="{{ route('dashboard.websites.index') }}"
                   class="dash-nav-link {{ request()->routeIs('dashboard.websites.*') ? 'active' : '' }}">
                    <i class="bi bi-globe2"></i>
                    <span>Websites</span>
                </a>

                <a href="{{ route('dashboard.testimonials.index') }}"
                   class="dash-nav-link {{ request()->routeIs('dashboard.testimonials.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-quote-fill"></i>
                    <span>Testimonials</span>
                </a>

                <div class="dash-nav-label" style="margin-top:12px;">Tools</div>

                <a href="{{ route('dashboard.widget') }}"
                   class="dash-nav-link {{ request()->routeIs('dashboard.widget') ? 'active' : '' }}">
                    <i class="bi bi-code-square"></i>
                    <span>Widget / Embed</span>
                </a>

                <a href="{{ route('dashboard.analytics') }}"
                   class="dash-nav-link {{ request()->routeIs('dashboard.analytics') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <span>Analytics</span>
                </a>

                <div class="dash-nav-label" style="margin-top:12px;">Account</div>

                <a href="{{ route('dashboard.settings') }}"
                   class="dash-nav-link {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i>
                    <span>Settings</span>
                </a>
            </nav>

            {{-- Footer: user info + logout --}}
            <div class="dash-sidebar-footer">
                @if(Auth::user()->logo_path)
                    <img src="{{ Auth::user()->logo_path }}" class="dash-user-avatar" alt="">
                @else
                    <div class="dash-user-avatar-fallback">
                        <i class="bi bi-building"></i>
                    </div>
                @endif

                <div class="dash-user-info">
                    <div class="dash-user-name">{{ Auth::user()->name }}</div>
                    <div class="dash-user-biz">{{ Auth::user()->business_name ?? 'My Business' }}</div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                    @csrf
                    <button type="submit" class="dash-logout-btn" title="Sign out">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div class="dash-overlay" id="dashOverlay" onclick="closeDashSidebar()"></div>

    {{-- ===== MAIN ===== --}}
    <main class="dash-main">

        {{-- Top bar --}}
        <div class="dash-topbar">
            <button class="dash-mobile-toggle" onclick="openDashSidebar()" aria-label="Open menu">
                <i class="bi bi-list"></i>
            </button>

            <h1 class="dash-page-title">@yield('page-title', 'Dashboard')</h1>

            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="dash-topbar-link" target="_blank" rel="noopener">
                    <i class="bi bi-box-arrow-up-right me-1"></i>View Site
                </a>
            </div>
        </div>

        {{-- Content + flash alerts --}}
        <div class="dash-content">

            @if(session('success'))
                <div class="dash-alert dash-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="dash-alert dash-alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openDashSidebar() {
        document.getElementById('dashSidebar').classList.add('open');
        document.getElementById('dashOverlay').classList.add('show');
    }
    function closeDashSidebar() {
        document.getElementById('dashSidebar').classList.remove('open');
        document.getElementById('dashOverlay').classList.remove('show');
    }
</script>
@yield('scripts')
@stack('scripts')

</body>
</html>
