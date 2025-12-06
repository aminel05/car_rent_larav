@extends('layouts.app')

@section('title', 'Browse Cars')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Browse <span class="text-accent">Cars</span></h1>
            <p class="text-muted mb-0">Find your perfect vehicle from our collection</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-funnel me-2 text-accent"></i>Filters</h5>
                
                <form action="{{ route('cars.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Brand</label>
                        <select name="brand" class="form-select form-select-sm">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Transmission</label>
                        <select name="transmission" class="form-select form-select-sm">
                            <option value="">Any</option>
                            <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Fuel Type</label>
                        <select name="fuel_type" class="form-select form-select-sm">
                            <option value="">Any</option>
                            <option value="petrol" {{ request('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                            <option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="electric" {{ request('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                            <option value="hybrid" {{ request('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Minimum Seats</label>
                        <select name="seats" class="form-select form-select-sm">
                            <option value="">Any</option>
                            <option value="2" {{ request('seats') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="4" {{ request('seats') == '4' ? 'selected' : '' }}>4+</option>
                            <option value="5" {{ request('seats') == '5' ? 'selected' : '' }}>5+</option>
                            <option value="7" {{ request('seats') == '7' ? 'selected' : '' }}>7+</option>
                        </select>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Min Price</label>
                            <input type="number" name="min_price" class="form-control form-control-sm" 
                                   value="{{ request('min_price') }}" placeholder="$0">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Max Price</label>
                            <input type="number" name="max_price" class="form-control form-control-sm" 
                                   value="{{ request('max_price') }}" placeholder="$500">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Sort By</label>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
                            <option value="price_per_day" {{ request('sort') == 'price_per_day' ? 'selected' : '' }}>Price</option>
                            <option value="brand" {{ request('sort') == 'brand' ? 'selected' : '' }}>Brand</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-search me-1"></i>Apply Filters
                        </button>
                        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary btn-sm">
                            Clear All
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Cars Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Showing {{ $cars->count() }} of {{ $cars->total() }} cars</span>
            </div>
            
            <div class="row g-4">
                @forelse($cars as $car)
                    <div class="col-md-6 col-xl-4">
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
                                        <small class="text-muted">{{ $car->year }} • {{ $car->color }}</small>
                                    </div>
                                    @if($car->is_available)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Unavailable</span>
                                    @endif
                                </div>
                                
                                <div class="d-flex gap-3 text-muted small mb-3">
                                    <span><i class="bi bi-gear me-1"></i>{{ ucfirst($car->transmission) }}</span>
                                    <span><i class="bi bi-fuel-pump me-1"></i>{{ ucfirst($car->fuel_type) }}</span>
                                    <span><i class="bi bi-people me-1"></i>{{ $car->seats }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-accent mb-0">${{ number_format($car->price_per_day, 0) }}<small class="text-muted fw-normal">/day</small></span>
                                    <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-accent btn-sm">
                                        View <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center">
                            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">No cars found</h4>
                            <p class="text-muted">Try adjusting your filters to find what you're looking for.</p>
                            <a href="{{ route('cars.index') }}" class="btn btn-accent">Clear Filters</a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($cars->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $cars->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

