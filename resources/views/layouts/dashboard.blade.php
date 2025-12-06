<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - CarRental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bs-body-font-family: 'Outfit', sans-serif;
            --accent-color: #f59e0b;
            --accent-hover: #d97706;
            --accent-light: #fef3c7;
            --light-bg: #f9fafb;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
        }
        
        body {
            background: var(--light-bg);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            color: var(--text-dark);
        }
        
        .navbar {
            background: #ffffff !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--accent-color) !important;
        }
        
        .btn-accent {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff;
            font-weight: 600;
        }
        
        .btn-accent:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            color: #fff;
        }
        
        .btn-outline-accent {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }
        
        .btn-outline-accent:hover {
            background: var(--accent-color);
            color: #fff;
        }
        
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .text-accent {
            color: var(--accent-color) !important;
        }
        
        .bg-accent {
            background-color: var(--accent-color) !important;
        }
        
        .form-control, .form-select {
            background: #ffffff;
            border-color: var(--border-color);
            color: var(--text-dark);
        }
        
        .form-control:focus, .form-select:focus {
            background: #ffffff;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25);
            color: var(--text-dark);
        }
        
        .sidebar {
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            min-height: calc(100vh - 56px);
            position: fixed;
            width: 260px;
            top: 56px;
            left: 0;
            overflow-y: auto;
            z-index: 100;
        }
        
        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--accent-light);
            color: var(--accent-hover);
        }
        
        .sidebar .nav-link i {
            width: 24px;
        }
        
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
        }
        
        .stat-card {
            border-left: 4px solid var(--accent-color);
        }
        
        .table {
            --bs-table-bg: transparent;
        }
        
        .table thead th {
            background: var(--accent-light);
            border-bottom: 2px solid var(--accent-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: var(--text-dark);
        }
        
        .car-thumb {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .pagination .page-link {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-dark);
        }
        
        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff;
        }
        
        .dropdown-menu {
            background: #ffffff;
            border-color: var(--border-color);
        }
        
        .dropdown-item {
            color: var(--text-dark);
        }
        
        .dropdown-item:hover {
            background: var(--accent-light);
            color: var(--accent-hover);
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <button class="btn btn-link text-dark d-lg-none me-2 p-0" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill me-2"></i>CarRental
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="bi bi-search me-1"></i>Browse Cars
                </a>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if(auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-house me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <div class="card p-3 mb-3 text-center">
                <div class="bg-accent bg-opacity-10 rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person text-accent" style="font-size: 1.5rem;"></i>
                </div>
                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>
            
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.bookings') ? 'active' : '' }}" href="{{ route('dashboard.bookings') }}">
                    <i class="bi bi-calendar-check me-2"></i>My Bookings
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}" href="{{ route('dashboard.profile') }}">
                    <i class="bi bi-person me-2"></i>Profile
                </a>
                <hr class="my-3" style="border-color: var(--border-color);">
                <a class="nav-link" href="{{ route('cars.index') }}">
                    <i class="bi bi-car-front me-2"></i>Browse Cars
                </a>
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="bi bi-house me-2"></i>Back to Home
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    
    @stack('scripts')
</body>
</html>

