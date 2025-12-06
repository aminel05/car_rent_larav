@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Manage Users</h1>
        <p class="text-muted mb-0">View all registered users and their activity.</p>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-accent w-100">
                    <i class="bi bi-search me-1"></i>Search
                </button>
            </div>
            @if(request('search') || request('role'))
                <div class="col-md-2">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Rentals</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="ps-4">{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-accent bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-accent"></i>
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold">{{ $user->name }}</span>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->phone)
                                        <small><i class="bi bi-telephone me-1"></i>{{ $user->phone }}</small><br>
                                    @endif
                                    @if($user->address)
                                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($user->address, 30) }}</small>
                                    @endif
                                    @if(!$user->phone && !$user->address)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-accent text-dark">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">User</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-dark">{{ $user->rentals_count }} bookings</span>
                                </td>
                                <td>
                                    <small>{{ $user->created_at->format('M d, Y') }}</small><br>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                <h4 class="mt-3">No users found</h4>
                <p class="text-muted">
                    @if(request('search') || request('role'))
                        No users match your search criteria.
                    @else
                        No users have registered yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

