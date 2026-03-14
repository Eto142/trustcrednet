<nav id="mainNav" role="navigation" aria-label="Main navigation">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="tcn-logo" aria-label="TrustCredNet Home">
                <div class="logo-icon-wrap" aria-hidden="true">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <span class="logo-text">Trust<span>Cred</span>Net</span>
            </a>

            <!-- Desktop Nav Links -->
            <ul class="nav-links desktop-nav" role="list">
                <li><a href="{{ route('home') }}"     class="{{ request()->routeIs('home')     ? 'nav-active' : '' }}">Home</a></li>
                <li><a href="{{ route('features') }}" class="{{ request()->routeIs('features') ? 'nav-active' : '' }}">Features</a></li>
                <li><a href="{{ route('pricing') }}"  class="{{ request()->routeIs('pricing')  ? 'nav-active' : '' }}">Pricing</a></li>
                <li><a href="{{ route('about') }}"    class="{{ request()->routeIs('about')    ? 'nav-active' : '' }}">About</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'nav-active' : '' }}">Contact</a></li>
            </ul>

            <!-- Desktop Auth CTAs -->
            <div class="d-flex align-items-center gap-2 desktop-nav">
                @auth
                    <span class="nav-user">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="nav-logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-login">Login</a>
                    <a href="{{ route('contact') }}" class="nav-cta">
                        <i class="bi bi-person-plus"></i> Sign Up
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <button
                class="hamburger"
                id="mobileMenuToggle"
                aria-label="Open navigation menu"
                aria-expanded="false"
                aria-controls="mobileMenu"
            >
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" role="navigation" aria-label="Mobile menu">
        <a href="{{ route('home') }}"     class="{{ request()->routeIs('home')     ? 'nav-active' : '' }}"><i class="bi bi-house me-2"></i>Home</a>
        <a href="{{ route('features') }}" class="{{ request()->routeIs('features') ? 'nav-active' : '' }}"><i class="bi bi-grid me-2"></i>Features</a>
        <a href="{{ route('pricing') }}"  class="{{ request()->routeIs('pricing')  ? 'nav-active' : '' }}"><i class="bi bi-tag me-2"></i>Pricing</a>
        <a href="{{ route('about') }}"    class="{{ request()->routeIs('about')    ? 'nav-active' : '' }}"><i class="bi bi-info-circle me-2"></i>About</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'nav-active' : '' }}"><i class="bi bi-envelope me-2"></i>Contact</a>
        <div class="mobile-divider"></div>
        @auth
            <span class="mobile-user-row">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-logout-btn">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
            <a href="{{ route('contact') }}" class="mobile-cta"><i class="bi bi-person-plus me-1"></i>Sign Up Free</a>
        @endauth
    </div>
</nav>
