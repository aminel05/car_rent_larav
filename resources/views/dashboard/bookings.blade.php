@extends('layouts.dashboard')

@section('title', 'My Bookings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">My Bookings</h1>
        <p class="text-muted mb-0">View and manage all your rental bookings.</p>
    </div>
    <a href="{{ route('cars.index') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i>New Booking
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('dashboard.bookings') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">Filter by Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-accent w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
            @if(request('status'))
                <div class="col-md-2">
                    <a href="{{ route('dashboard.bookings') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="card-body p-0">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Booking ID</th>
                            <th>Car</th>
                            <th>Pick-up Date</th>
                            <th>Return Date</th>
                            <th>Duration</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold">#{{ $booking->id }}</span>
                                </td>
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
                                            <span class="d-block fw-bold">{{ $booking->car->brand }} {{ $booking->car->model }}</span>
                                            <small class="text-muted">{{ $booking->car->year }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-calendar me-1 text-accent"></i>
                                    {{ $booking->start_date->format('M d, Y') }}
                                </td>
                                <td>
                                    <i class="bi bi-calendar-check me-1 text-accent"></i>
                                    {{ $booking->end_date->format('M d, Y') }}
                                </td>
                                <td>{{ $booking->duration }} days</td>
                                <td class="fw-bold text-accent">${{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $booking->status_badge_class }} badge-status">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('rentals.show', $booking) }}" class="btn btn-sm btn-outline-light" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(in_array($booking->status, ['pending', 'confirmed']) && $booking->start_date > now())
                                            <form action="{{ route('rentals.cancel', $booking) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel Booking">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No bookings found</h4>
                <p class="text-muted mb-4">
                    @if(request('status'))
                        No {{ request('status') }} bookings found. Try a different filter.
                    @else
                        You haven't made any bookings yet. Start by browsing our cars!
                    @endif
                </p>
                <a href="{{ route('cars.index') }}" class="btn btn-accent">
                    <i class="bi bi-search me-1"></i>Browse Cars
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

