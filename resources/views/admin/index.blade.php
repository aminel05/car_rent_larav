@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Admin Dashboard</h1>
        <p class="text-muted mb-0">Welcome back! Here's an overview of your car rental business.</p>
    </div>
    @if($pendingRentals > 0)
        <a href="{{ route('admin.rentals', ['status' => 'pending']) }}" class="btn btn-warning">
            <i class="bi bi-bell me-1"></i>{{ $pendingRentals }} Pending Rentals
        </a>
    @endif
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-4">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Total Cars</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_cars'] }}</h3>
                    <small class="text-success">{{ $stats['available_cars'] }} available</small>
                </div>
                <div class="bg-accent bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-car-front text-accent" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Total Rentals</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_rentals'] }}</h3>
                    <small class="text-info">{{ $stats['active_rentals'] }} active</small>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-calendar-check text-success" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Total Users</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_users'] }}</h3>
                    <small class="text-muted">registered users</small>
                </div>
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-people text-info" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card p-4 bg-accent bg-opacity-10" style="border-color: var(--accent-color);">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-2">Total Revenue</h4>
                    <h2 class="display-4 fw-bold text-accent mb-0">${{ number_format($stats['total_revenue'], 2) }}</h2>
                    <p class="text-muted mb-0">from confirmed and completed rentals</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="bi bi-graph-up-arrow text-accent" style="font-size: 5rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Rentals -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-lightning text-accent me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-accent">
                        <i class="bi bi-plus-circle me-2"></i>Add New Car
                    </a>
                    <a href="{{ route('admin.rentals', ['status' => 'pending']) }}" class="btn btn-outline-warning">
                        <i class="bi bi-clock me-2"></i>Review Pending Rentals
                    </a>
                    <a href="{{ route('admin.cars') }}" class="btn btn-outline-light">
                        <i class="bi bi-list me-2"></i>View All Cars
                    </a>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-light">
                        <i class="bi bi-people me-2"></i>View All Users
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-accent me-2"></i>Recent Rentals</h5>
                <a href="{{ route('admin.rentals') }}" class="btn btn-sm btn-outline-accent">View All</a>
            </div>
            <div class="card-body">
                @if($recentRentals->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRentals as $rental)
                                    <tr>
                                        <td>#{{ $rental->id }}</td>
                                        <td>
                                            <span class="d-block">{{ $rental->user->name }}</span>
                                            <small class="text-muted">{{ $rental->user->email }}</small>
                                        </td>
                                        <td>{{ $rental->car->brand }} {{ $rental->car->model }}</td>
                                        <td class="fw-bold">${{ number_format($rental->total_price, 0) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $rental->status }}">{{ ucfirst($rental->status) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">No rentals yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

