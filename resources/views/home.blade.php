@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Find Your Perfect <span class="text-accent">Ride</span>
                </h1>
                <p class="lead text-muted mb-4">
                    Discover our premium collection of vehicles for every journey. 
                    From economy to luxury, we have the perfect car waiting for you.
                </p>
                <div class="d-flex gap-3 mb-5">
                    <a href="{{ route('cars.index') }}" class="btn btn-accent btn-lg px-4">
                        <i class="bi bi-search me-2"></i>Browse Cars
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                            Get Started
                        </a>
                    @endguest
                </div>
                
                <!-- Stats -->
                <div class="row text-center g-4">
                    <div class="col-4">
                        <h3 class="fw-bold text-accent mb-0">{{ $totalCars }}+</h3>
                        <small class="text-muted">Vehicles</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold text-accent mb-0">{{ $brands->count() }}</h3>
                        <small class="text-muted">Brands</small>
                    </div>
                    <div class="col-4">
                        <h3 class="fw-bold text-accent mb-0">24/7</h3>
                        <small class="text-muted">Support</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <div class="position-relative">
                    <div class="bg-accent rounded-circle position-absolute" style="width: 300px; height: 300px; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1;"></div>
                    <i class="bi bi-car-front-fill display-1 text-accent" style="font-size: 15rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 card-hover p-4 text-center">
                    <div class="card-body">
                        <div class="bg-accent bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check text-accent" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold">Safe & Secure</h5>
                        <p class="text-muted mb-0">All our vehicles are regularly maintained and insured for your peace of mind.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 card-hover p-4 text-center">
                    <div class="card-body">
                        <div class="bg-accent bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-calendar-check text-accent" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold">Easy Booking</h5>
                        <p class="text-muted mb-0">Book your car in minutes with our intuitive calendar system.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 card-hover p-4 text-center">
                    <div class="card-body">
                        <div class="bg-accent bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-currency-dollar text-accent" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold">Best Prices</h5>
                        <p class="text-muted mb-0">Competitive rates with no hidden fees. Pay only for what you use.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Cars Section -->
<section class="py-5 bg-dark">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Featured <span class="text-accent">Vehicles</span></h2>
                <p class="text-muted mb-0">Explore our most popular cars</p>
            </div>
            <a href="{{ route('cars.index') }}" class="btn btn-outline-accent">
                View All <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @forelse($featuredCars as $car)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 card-hover">
                        @if($car->image && file_exists(public_path('storage/' . $car->image)))
                            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top car-image" alt="{{ $car->brand }} {{ $car->model }}">
                        @else
                            <div class="car-placeholder">
                                <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title fw-bold mb-0">{{ $car->brand }} {{ $car->model }}</h5>
                                    <small class="text-muted">{{ $car->year }}</small>
                                </div>
                                <span class="badge bg-accent text-dark">${{ number_format($car->price_per_day, 0) }}/day</span>
                            </div>
                            <div class="d-flex gap-3 text-muted small mb-3">
                                <span><i class="bi bi-gear me-1"></i>{{ ucfirst($car->transmission) }}</span>
                                <span><i class="bi bi-fuel-pump me-1"></i>{{ ucfirst($car->fuel_type) }}</span>
                                <span><i class="bi bi-people me-1"></i>{{ $car->seats }} seats</span>
                            </div>
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-accent w-100">
                                View Details <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">No cars available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="card bg-accent text-dark p-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">Ready to hit the road?</h3>
                    <p class="mb-0 opacity-75">Create an account today and get access to our full fleet of premium vehicles.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-dark btn-lg px-4">
                            Sign Up Now <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    @else
                        <a href="{{ route('cars.index') }}" class="btn btn-dark btn-lg px-4">
                            Browse Cars <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

