@extends('layouts.admin')

@section('title', 'Manage Rentals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Manage Rentals</h1>
        <p class="text-muted mb-0">View and manage all customer bookings.</p>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.rentals') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by customer name, email, or car..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Status</label>
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
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
            @if(request('search') || request('status'))
                <div class="col-md-2">
                    <a href="{{ route('admin.rentals') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Rentals Table -->
<div class="card">
    <div class="card-body p-0">
        @if($rentals->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Dates</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rentals as $rental)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $rental->id }}</td>
                                <td>
                                    <span class="d-block fw-bold">{{ $rental->user->name }}</span>
                                    <small class="text-muted">{{ $rental->user->email }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($rental->car->image && file_exists(public_path('storage/' . $rental->car->image)))
                                            <img src="{{ asset('storage/' . $rental->car->image) }}" class="car-thumb me-2" alt="">
                                        @else
                                            <div class="car-thumb bg-dark d-flex align-items-center justify-content-center rounded me-2">
                                                <i class="bi bi-car-front text-muted small"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="d-block">{{ $rental->car->brand }} {{ $rental->car->model }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small>
                                        {{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}<br>
                                        <span class="text-muted">{{ $rental->duration }} days</span>
                                    </small>
                                </td>
                                <td class="fw-bold text-accent">${{ number_format($rental->total_price, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $rental->status }}">{{ ucfirst($rental->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Update Status
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                            <li>
                                                <form action="{{ route('admin.rentals.status', $rental) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="dropdown-item {{ $rental->status == 'pending' ? 'active' : '' }}">
                                                        <i class="bi bi-clock me-2 text-warning"></i>Pending
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.rentals.status', $rental) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="dropdown-item {{ $rental->status == 'confirmed' ? 'active' : '' }}">
                                                        <i class="bi bi-check-circle me-2 text-success"></i>Confirmed
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.rentals.status', $rental) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item {{ $rental->status == 'completed' ? 'active' : '' }}">
                                                        <i class="bi bi-check-all me-2 text-info"></i>Completed
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.rentals.status', $rental) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item {{ $rental->status == 'cancelled' ? 'active' : '' }}">
                                                        <i class="bi bi-x-circle me-2 text-danger"></i>Cancelled
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($rentals->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $rentals->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No rentals found</h4>
                <p class="text-muted">
                    @if(request('search') || request('status'))
                        No rentals match your search criteria.
                    @else
                        No bookings have been made yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

