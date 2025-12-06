<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CarRental') - Premium Car Rental Service</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bs-body-font-family: 'Outfit', sans-serif;
            --accent-color: #f59e0b;
            --accent-hover: #d97706;
            --accent-light: #fef3c7;
            --light-bg: #fafafa;
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
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
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
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(245, 158, 11, 0.15);
        }
        
        .text-accent {
            color: var(--accent-color) !important;
        }
        
        .bg-accent {
            background-color: var(--accent-color) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #ffffff 0%, var(--accent-light) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(245, 158, 11, 0.1) 0%, transparent 70%);
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
        
        .form-control::placeholder {
            color: var(--text-muted);
        }
        
        .badge-status {
            font-weight: 500;
            padding: 0.5em 1em;
        }
        
        footer {
            background: #1f2937;
            border-top: 1px solid var(--border-color);
            color: #fff;
        }
        
        footer .text-muted {
            color: #9ca3af !important;
        }
        
        .sidebar {
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            min-height: calc(100vh - 76px);
        }
        
        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem 0;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: var(--accent-light);
            color: var(--accent-hover);
        }
        
        .sidebar .nav-link i {
            width: 24px;
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
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: var(--text-dark);
        }
        
        .car-image {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .car-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
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
        
        .fc {
            --fc-border-color: var(--border-color);
            --fc-page-bg-color: var(--card-bg);
            --fc-neutral-bg-color: #f3f4f6;
            --fc-today-bg-color: var(--accent-light);
        }
        
        .fc .fc-button-primary {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .fc .fc-button-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
        }
        
        .fc-event {
            background: #dc3545 !important;
            border-color: #dc3545 !important;
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
        
        .input-group-text {
            background: #f9fafb;
            border-color: var(--border-color);
            color: var(--accent-color);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill me-2"></i>CarRental
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active text-accent' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cars.*') ? 'active text-accent' : '' }}" href="{{ route('cars.index') }}">Browse Cars</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>Admin Panel
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.bookings') }}"><i class="bi bi-calendar-check me-2"></i>My Bookings</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-accent btn-sm ms-2" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-accent"><i class="bi bi-car-front-fill me-2"></i>CarRental</h5>
                    <p class="text-muted small">Premium car rental service offering a wide selection of vehicles for every need.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="{{ route('cars.index') }}" class="text-muted text-decoration-none">Browse Cars</a></li>
                        <li><a href="{{ route('login') }}" class="text-muted text-decoration-none">Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3">Contact</h6>
                    <ul class="list-unstyled text-muted small">
                        <li><i class="bi bi-geo-alt me-2"></i>123 Rental Street, City</li>
                        <li><i class="bi bi-telephone me-2"></i>+1 234 567 890</li>
                        <li><i class="bi bi-envelope me-2"></i>info@carental.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-3" style="border-color: var(--border-color);">
            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} CarRental. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    
    @stack('scripts')
</body>
</html>

