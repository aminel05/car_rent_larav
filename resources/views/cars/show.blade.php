@extends('layouts.app')

@section('title', $car->brand . ' ' . $car->model)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-accent text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}" class="text-accent text-decoration-none">Cars</a></li>
            <li class="breadcrumb-item active text-muted">{{ $car->brand }} {{ $car->model }}</li>
        </ol>
    </nav>
    
    <div class="row g-4">
        <!-- Car Image & Details -->
        <div class="col-lg-7">
            <div class="card mb-4">
                @if($car->image && file_exists(public_path('storage/' . $car->image)))
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" style="height: 400px; object-fit: cover;" alt="{{ $car->brand }} {{ $car->model }}">
                @else
                    <div class="bg-dark d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-car-front text-muted" style="font-size: 8rem;"></i>
                    </div>
                @endif
            </div>
            
            <!-- Car Info -->
            <div class="card p-4 mb-4">
                <h2 class="fw-bold mb-1">{{ $car->brand }} {{ $car->model }}</h2>
                <p class="text-muted mb-4">{{ $car->year }} • {{ $car->color }}</p>
                
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded" style="background: rgba(212, 165, 116, 0.1);">
                            <i class="bi bi-gear text-accent d-block mb-2" style="font-size: 1.5rem;"></i>
                            <small class="text-muted d-block">Transmission</small>
                            <span class="fw-bold">{{ ucfirst($car->transmission) }}</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded" style="background: rgba(212, 165, 116, 0.1);">
                            <i class="bi bi-fuel-pump text-accent d-block mb-2" style="font-size: 1.5rem;"></i>
                            <small class="text-muted d-block">Fuel Type</small>
                            <span class="fw-bold">{{ ucfirst($car->fuel_type) }}</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded" style="background: rgba(212, 165, 116, 0.1);">
                            <i class="bi bi-people text-accent d-block mb-2" style="font-size: 1.5rem;"></i>
                            <small class="text-muted d-block">Seats</small>
                            <span class="fw-bold">{{ $car->seats }} People</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 rounded" style="background: rgba(212, 165, 116, 0.1);">
                            <i class="bi bi-palette text-accent d-block mb-2" style="font-size: 1.5rem;"></i>
                            <small class="text-muted d-block">Color</small>
                            <span class="fw-bold">{{ $car->color }}</span>
                        </div>
                    </div>
                </div>
                
                <h5 class="fw-bold mb-3">Description</h5>
                <p class="text-muted">{{ $car->description ?? 'No description available for this vehicle.' }}</p>
            </div>
        </div>
        
        <!-- Booking Card -->
        <div class="col-lg-5">
            <div class="card p-4 sticky-top" style="top: 100px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="h3 text-accent fw-bold">${{ number_format($car->price_per_day, 0) }}</span>
                        <span class="text-muted">/ day</span>
                    </div>
                    @if($car->is_available)
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Available
                        </span>
                    @else
                        <span class="badge bg-danger fs-6 px-3 py-2">
                            <i class="bi bi-x-circle me-1"></i>Unavailable
                        </span>
                    @endif
                </div>
                
                @auth
                    @if($car->is_available)
                        <form action="{{ route('rentals.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            
                            <div class="mb-3">
                                <label class="form-label">Pick-up Date</label>
                                <input type="date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       name="start_date" 
                                       id="start_date"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('start_date') }}"
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Return Date</label>
                                <input type="date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       name="end_date" 
                                       id="end_date"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('end_date') }}"
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="bg-dark rounded p-3 mb-4" id="priceBreakdown" style="display: none;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Daily Rate</span>
                                    <span>${{ number_format($car->price_per_day, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Number of Days</span>
                                    <span id="numDays">0</span>
                                </div>
                                <hr class="my-2" style="border-color: var(--border-color);">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold text-accent" id="totalPrice">$0.00</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-accent w-100 py-3">
                                <i class="bi bi-calendar-check me-2"></i>Book Now
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            This car is currently unavailable for booking.
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-person-lock text-muted" style="font-size: 3rem;"></i>
                        <p class="mt-3 mb-4">Please login to book this car</p>
                        <a href="{{ route('login') }}" class="btn btn-accent w-100 mb-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </a>
                        <p class="text-muted small mb-0">
                            Don't have an account? <a href="{{ route('register') }}" class="text-accent">Register</a>
                        </p>
                    </div>
                @endauth
                
                <!-- Availability Calendar -->
                <div class="mt-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2 text-accent"></i>Availability Calendar</h6>
                    <div id="availabilityCalendar"></div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <span class="badge bg-danger me-1">&nbsp;</span> Booked dates
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Cars -->
    @if($relatedCars->count() > 0)
        <div class="mt-5">
            <h4 class="fw-bold mb-4">More {{ $car->brand }} Vehicles</h4>
            <div class="row g-4">
                @foreach($relatedCars as $relatedCar)
                    <div class="col-md-4">
                        <div class="card h-100 card-hover">
                            @if($relatedCar->image && file_exists(public_path('storage/' . $relatedCar->image)))
                                <img src="{{ asset('storage/' . $relatedCar->image) }}" class="card-img-top car-image" alt="{{ $relatedCar->brand }} {{ $relatedCar->model }}">
                            @else
                                <div class="car-placeholder">
                                    <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-1">{{ $relatedCar->brand }} {{ $relatedCar->model }}</h5>
                                <p class="text-muted small mb-3">{{ $relatedCar->year }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-accent fw-bold">${{ number_format($relatedCar->price_per_day, 0) }}/day</span>
                                    <a href="{{ route('cars.show', $relatedCar) }}" class="btn btn-outline-accent btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookedDates = @json($bookedDates);
        const pricePerDay = {{ $car->price_per_day }};
        
        // Initialize calendar
        const calendarEl = document.getElementById('availabilityCalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            height: 'auto',
            events: bookedDates.map(date => ({
                start: date,
                display: 'background',
                backgroundColor: '#dc3545'
            })),
            validRange: {
                start: new Date().toISOString().split('T')[0]
            },
            dateClick: function(info) {
                if (!bookedDates.includes(info.dateStr)) {
                    const startInput = document.getElementById('start_date');
                    const endInput = document.getElementById('end_date');
                    
                    if (!startInput.value || (startInput.value && endInput.value)) {
                        startInput.value = info.dateStr;
                        endInput.value = '';
                    } else {
                        if (info.dateStr > startInput.value) {
                            endInput.value = info.dateStr;
                        } else {
                            endInput.value = startInput.value;
                            startInput.value = info.dateStr;
                        }
                    }
                    calculatePrice();
                }
            }
        });
        calendar.render();
        
        // Price calculation
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const priceBreakdown = document.getElementById('priceBreakdown');
        const numDaysEl = document.getElementById('numDays');
        const totalPriceEl = document.getElementById('totalPrice');
        
        function calculatePrice() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            if (startDateInput.value && endDateInput.value && endDate >= startDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                const total = diffDays * pricePerDay;
                
                numDaysEl.textContent = diffDays;
                totalPriceEl.textContent = '$' + total.toFixed(2);
                priceBreakdown.style.display = 'block';
            } else {
                priceBreakdown.style.display = 'none';
            }
        }
        
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                endDateInput.min = this.value;
                calculatePrice();
            });
            endDateInput.addEventListener('change', calculatePrice);
        }
    });
</script>
@endpush
@endsection

