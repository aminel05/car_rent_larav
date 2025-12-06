@extends('layouts.dashboard')

@section('title', 'Booking Details')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-accent text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.bookings') }}" class="text-accent text-decoration-none">My Bookings</a></li>
            <li class="breadcrumb-item active text-muted">Booking #{{ $rental->id }}</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Booking Status Card -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">Booking #{{ $rental->id }}</h4>
                        <p class="text-muted mb-0">Created on {{ $rental->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <span class="badge {{ $rental->status_badge_class }} fs-6 px-3 py-2">
                        {{ ucfirst($rental->status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Car Details -->
        <div class="card mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-car-front text-accent me-2"></i>Vehicle Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($rental->car->image && file_exists(public_path('storage/' . $rental->car->image)))
                            <img src="{{ asset('storage/' . $rental->car->image) }}" class="img-fluid rounded" alt="{{ $rental->car->brand }} {{ $rental->car->model }}">
                        @else
                            <div class="bg-dark d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-2">{{ $rental->car->brand }} {{ $rental->car->model }}</h4>
                        <p class="text-muted mb-3">{{ $rental->car->year }} • {{ $rental->car->color }}</p>
                        
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Transmission</small>
                                <span>{{ ucfirst($rental->car->transmission) }}</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Fuel Type</small>
                                <span>{{ ucfirst($rental->car->fuel_type) }}</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Seats</small>
                                <span>{{ $rental->car->seats }} People</span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block">Daily Rate</small>
                                <span class="text-accent">${{ number_format($rental->car->price_per_day, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('cars.show', $rental->car) }}" class="btn btn-outline-accent btn-sm">
                                <i class="bi bi-eye me-1"></i>View Car Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rental Period -->
        <div class="card">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-calendar-range text-accent me-2"></i>Rental Period</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-5">
                        <div class="p-4 rounded" style="background: rgba(212, 165, 116, 0.1);">
                            <i class="bi bi-calendar-event text-accent d-block mb-2" style="font-size: 2rem;"></i>
                            <small class="text-muted d-block">Pick-up Date</small>
                            <h4 class="fw-bold mb-0">{{ $rental->start_date->format('M d, Y') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <div class="py-3">
                            <i class="bi bi-arrow-right text-accent" style="font-size: 2rem;"></i>
                            <div class="text-accent small fw-bold">{{ $rental->duration }} days</div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="p-4 rounded" style="background: rgba(212, 165, 116, 0.1);">
                            <i class="bi bi-calendar-check text-accent d-block mb-2" style="font-size: 2rem;"></i>
                            <small class="text-muted d-block">Return Date</small>
                            <h4 class="fw-bold mb-0">{{ $rental->end_date->format('M d, Y') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Price Summary -->
        <div class="card mb-4">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-receipt text-accent me-2"></i>Price Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Daily Rate</span>
                    <span>${{ number_format($rental->car->price_per_day, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Number of Days</span>
                    <span>{{ $rental->duration }}</span>
                </div>
                <hr style="border-color: var(--border-color);">
                <div class="d-flex justify-content-between py-2">
                    <span class="fw-bold">Total Amount</span>
                    <span class="fw-bold text-accent h4 mb-0">${{ number_format($rental->total_price, 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        @if(in_array($rental->status, ['pending', 'confirmed']) && $rental->start_date > now())
            <div class="card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-gear text-accent me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rentals.cancel', $rental) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-x-circle me-1"></i>Cancel Booking
                        </button>
                    </form>
                    <p class="text-muted small mt-2 mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        You can cancel this booking until the pick-up date.
                    </p>
                </div>
            </div>
        @endif
        
        <!-- Status Info -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Booking Status Info</h6>
                <div class="d-flex align-items-start mb-2">
                    <span class="badge bg-warning me-2">&nbsp;</span>
                    <small class="text-muted"><strong>Pending:</strong> Waiting for confirmation</small>
                </div>
                <div class="d-flex align-items-start mb-2">
                    <span class="badge bg-success me-2">&nbsp;</span>
                    <small class="text-muted"><strong>Confirmed:</strong> Booking approved</small>
                </div>
                <div class="d-flex align-items-start mb-2">
                    <span class="badge bg-info me-2">&nbsp;</span>
                    <small class="text-muted"><strong>Completed:</strong> Rental finished</small>
                </div>
                <div class="d-flex align-items-start">
                    <span class="badge bg-danger me-2">&nbsp;</span>
                    <small class="text-muted"><strong>Cancelled:</strong> Booking cancelled</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('dashboard.bookings') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-1"></i>Back to Bookings
    </a>
</div>
@endsection

