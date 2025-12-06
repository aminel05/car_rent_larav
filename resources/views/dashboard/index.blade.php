@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-muted mb-0">Here's what's happening with your rentals.</p>
    </div>
    <a href="{{ route('cars.index') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i>New Booking
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Total Bookings</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_bookings'] }}</h3>
                </div>
                <div class="bg-accent bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-calendar-check text-accent" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Active Bookings</p>
                    <h3 class="fw-bold mb-0">{{ $stats['active_bookings'] }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-clock-history text-success" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Completed</p>
                    <h3 class="fw-bold mb-0">{{ $stats['completed_bookings'] }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-check-circle text-info" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted small mb-1">Total Spent</p>
                    <h3 class="fw-bold mb-0">${{ number_format($stats['total_spent'], 0) }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-currency-dollar text-warning" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Upcoming Bookings -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-calendar-event text-accent me-2"></i>Upcoming Rentals</h5>
            </div>
            <div class="card-body">
                @forelse($upcomingBookings as $booking)
                    <div class="d-flex align-items-center p-3 rounded mb-2" style="background: rgba(255,255,255,0.03);">
                        <div class="me-3">
                            @if($booking->car->image && file_exists(public_path('storage/' . $booking->car->image)))
                                <img src="{{ asset('storage/' . $booking->car->image) }}" class="car-thumb" alt="{{ $booking->car->brand }}">
                            @else
                                <div class="car-thumb bg-dark d-flex align-items-center justify-content-center rounded">
                                    <i class="bi bi-car-front text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $booking->car->brand }} {{ $booking->car->model }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>{{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}
                            </small>
                        </div>
                        <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">No upcoming rentals</p>
                    </div>
                @endforelse
                
                @if($upcomingBookings->count() > 0)
                    <div class="text-center mt-3">
                        <a href="{{ route('dashboard.bookings') }}" class="btn btn-outline-accent btn-sm">
                            View All Bookings
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Bookings -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-accent me-2"></i>Recent Activity</h5>
            </div>
            <div class="card-body">
                @if($recentBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Car</th>
                                    <th>Dates</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($booking->car->image && file_exists(public_path('storage/' . $booking->car->image)))
                                                    <img src="{{ asset('storage/' . $booking->car->image) }}" class="car-thumb me-2" alt="">
                                                @else
                                                    <div class="car-thumb bg-dark d-flex align-items-center justify-content-center rounded me-2">
                                                        <i class="bi bi-car-front text-muted small"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="d-block">{{ $booking->car->brand }} {{ $booking->car->model }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <small>{{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d') }}</small>
                                        </td>
                                        <td class="fw-bold">${{ number_format($booking->total_price, 0) }}</td>
                                        <td>
                                            <span class="badge {{ $booking->status_badge_class }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('rentals.show', $booking) }}" class="btn btn-sm btn-outline-light">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-3">No bookings yet</p>
                        <a href="{{ route('cars.index') }}" class="btn btn-accent">
                            <i class="bi bi-search me-1"></i>Browse Cars
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

