@extends('layouts.admin')

@section('title', 'Manage Cars')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Manage Cars</h1>
        <p class="text-muted mb-0">Add, edit, and manage your vehicle fleet.</p>
    </div>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i>Add New Car
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.cars') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by brand or model..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Availability</label>
                <select name="available" class="form-select">
                    <option value="">All</option>
                    <option value="yes" {{ request('available') == 'yes' ? 'selected' : '' }}>Available Only</option>
                    <option value="no" {{ request('available') == 'no' ? 'selected' : '' }}>Unavailable Only</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-accent w-100">
                    <i class="bi bi-search me-1"></i>Search
                </button>
            </div>
            @if(request('search') || request('available'))
                <div class="col-md-2">
                    <a href="{{ route('admin.cars') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Cars Table -->
<div class="card">
    <div class="card-body p-0">
        @if($cars->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Car</th>
                            <th>Year</th>
                            <th>Specs</th>
                            <th>Price/Day</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($car->image && file_exists(public_path('storage/' . $car->image)))
                                            <img src="{{ asset('storage/' . $car->image) }}" class="car-thumb me-3" alt="">
                                        @else
                                            <div class="car-thumb bg-dark d-flex align-items-center justify-content-center rounded me-3">
                                                <i class="bi bi-car-front text-muted small"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="d-block fw-bold">{{ $car->brand }} {{ $car->model }}</span>
                                            <small class="text-muted">{{ $car->color }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $car->year }}</td>
                                <td>
                                    <small>
                                        <i class="bi bi-gear me-1"></i>{{ ucfirst($car->transmission) }}<br>
                                        <i class="bi bi-fuel-pump me-1"></i>{{ ucfirst($car->fuel_type) }}<br>
                                        <i class="bi bi-people me-1"></i>{{ $car->seats }} seats
                                    </small>
                                </td>
                                <td class="fw-bold text-accent">${{ number_format($car->price_per_day, 2) }}</td>
                                <td>
                                    @if($car->is_available)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Unavailable</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-outline-light" title="View" target="_blank">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-outline-accent" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this car?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($cars->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $cars->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No cars found</h4>
                <p class="text-muted mb-4">
                    @if(request('search') || request('available'))
                        No cars match your search criteria.
                    @else
                        Start by adding your first car to the fleet.
                    @endif
                </p>
                <a href="{{ route('admin.cars.create') }}" class="btn btn-accent">
                    <i class="bi bi-plus-lg me-1"></i>Add New Car
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

