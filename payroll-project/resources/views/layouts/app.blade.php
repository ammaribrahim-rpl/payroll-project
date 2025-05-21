<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Payroll') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-primary: #4361ee;
            --bs-primary-rgb: 67, 97, 238;
            --bs-secondary: #3f37c9;
            --bs-secondary-rgb: 63, 55, 201;
            --bs-success: #38b000;
            --bs-info: #4cc9f0;
            --bs-warning: #ffbe0b;
            --bs-danger: #ef476f;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
            --bs-body-bg: #f5f7fa;
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--bs-body-bg);
            min-height: 100vh;
            padding-top: var(--topbar-height);
        }
        
        /* Navbar Styling */
        .navbar {
            height: var(--topbar-height);
            padding: 0 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background: #fff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--bs-primary) !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }
        
        .navbar .nav-link {
            color: #495057 !important;
            font-weight: 500;
            padding: 0.75rem 1rem;
            position: relative;
            transition: all 0.2s ease;
        }
        
        .navbar .nav-link:hover {
            color: var(--bs-primary) !important;
        }
        
        .navbar .nav-link.active {
            color: var(--bs-primary) !important;
            font-weight: 600;
        }
        
        .navbar .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 1rem;
            right: 1rem;
            height: 3px;
            background-color: var(--bs-primary);
            border-radius: 3px 3px 0 0;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* User dropdown */
        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--bs-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.5rem;
        }
        
        /* Content area */
        .content-wrapper {
            padding: 1.5rem 0;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        
        .btn-primary:hover {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }
        
        /* Dropdown menus */
        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
        }
        
        /* Alerts */
        .alert {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        /* Footer */
        .footer {
            padding: 1rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 2rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar .nav-link.active::after {
                display: none;
            }
        }
    </style>

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('karyawan.dashboard') }}">
                <i class="bi bi-building"></i>
                <span>Payroll App</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}" href="{{ route('admin.karyawan.index') }}">
                                    <i class="bi bi-people me-1"></i> Karyawan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.absensi.rekap') ? 'active' : '' }}" href="{{ route('admin.absensi.rekap') }}">
                                    <i class="bi bi-calendar-check me-1"></i> Absensi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.gaji.*') ? 'active' : '' }}" href="{{ route('admin.gaji.index') }}">
                                    <i class="bi bi-cash-stack me-1"></i> Penggajian
                                </a>
                            </li>
                        @elseif(Auth::user()->isKaryawan())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('karyawan.absensi.riwayat') ? 'active' : '' }}" href="{{ route('karyawan.absensi.riwayat') }}">
                                    <i class="bi bi-calendar-check me-1"></i> Absensi
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear me-2"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container">
            @include('partials._alerts')
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel Payroll') }}. All rights reserved.</small>
                </div>
                <div>
                    <small class="text-muted">Version 1.0</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Add active class to navbar links based on current page
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>