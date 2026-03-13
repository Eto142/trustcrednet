<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="TrustCredNet Admin Dashboard" />
    <meta name="author" content="TrustCredNet" />
    <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.svg')}}" />
    <title>Admin Dashboard - TrustCredNet</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS (for modals and components) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Modern Admin CSS (loads after Bootstrap to override) -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/admin-modern.css')}}?v={{ filemtime(public_path('admin/assets/css/admin-modern.css')) }}" />

    @stack('styles')
</head>

<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Admin Header -->
    <header class="admin-header">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="header-search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search users, websites..." />
            </div>
        </div>

        <div class="header-right">
            <button class="header-icon-btn" type="button" aria-label="Notifications">
                <i class="bi bi-bell"></i>
                <span class="badge"></span>
            </button>

            <div class="header-profile" id="profileDropdownToggle">
                <div class="avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="profile-info">
                    <span class="profile-name">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</span>
                    <span class="profile-role">Super Admin</span>
                </div>
                <i class="bi bi-chevron-down dropdown-icon"></i>

                <div class="profile-dropdown" id="profileDropdown">
                    <div class="dropdown-header">
                        <div class="name">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</div>
                        <div class="email">{{ Auth::guard('admin')->user()->email ?? '' }}</div>
                    </div>
                    <a href="{{ url('/') }}" class="dropdown-item" target="_blank">
                        <i class="bi bi-globe"></i>
                        <span>Visit Site</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </header>