@extends('layouts.admin')

@section('title', 'Edit Car')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-accent text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.cars') }}" class="text-accent text-decoration-none">Cars</a></li>
            <li class="breadcrumb-item active text-muted">Edit {{ $car->brand }} {{ $car->model }}</li>
        </ol>
    </nav>
    <h1 class="h3 fw-bold mb-1">Edit Car</h1>
    <p class="text-muted mb-0">Update vehicle information.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand', $car->brand) }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model', $car->model) }}" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                   id="year" name="year" value="{{ old('year', $car->year) }}" 
                                   min="1900" max="{{ date('Y') + 1 }}" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                   id="color" name="color" value="{{ old('color', $car->color) }}" required>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="price_per_day" class="form-label">Price Per Day ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price_per_day') is-invalid @enderror" 
                                   id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" min="0" required>
                            @error('price_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="seats" class="form-label">Seats <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('seats') is-invalid @enderror" 
                                   id="seats" name="seats" value="{{ old('seats', $car->seats) }}" min="1" max="20" required>
                            @error('seats')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="transmission" class="form-label">Transmission <span class="text-danger">*</span></label>
                            <select class="form-select @error('transmission') is-invalid @enderror" 
                                    id="transmission" name="transmission" required>
                                <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="fuel_type" class="form-label">Fuel Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('fuel_type') is-invalid @enderror" 
                                    id="fuel_type" name="fuel_type" required>
                                <option value="petrol" {{ old('fuel_type', $car->fuel_type) == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('fuel_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $car->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="image" class="form-label">Car Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="text-muted">Leave empty to keep current image. Max 2MB.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_available" name="is_available" 
                                       {{ old('is_available', $car->is_available) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">
                                    Available for rent
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4" style="border-color: var(--border-color);">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i>Update Car
                        </button>
                        <a href="{{ route('admin.cars') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Current Image -->
        <div class="card mb-4">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0">Current Image</h6>
            </div>
            <div class="card-body">
                @if($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}?t={{ time() }}" class="img-fluid rounded" alt="{{ $car->brand }} {{ $car->model }}" id="currentImage">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded" style="height: 150px; background: #f3f4f6;">
                        <div class="text-center text-muted">
                            <i class="bi bi-car-front d-block" style="font-size: 3rem;"></i>
                            <small>No image uploaded</small>
                        </div>
                    </div>
                @endif
                
                <!-- Image Preview -->
                <div id="imagePreviewContainer" class="mt-3" style="display: none;">
                    <p class="text-muted small mb-2">New image preview:</p>
                    <img id="imagePreview" class="img-fluid rounded" alt="Preview">
                </div>
            </div>
        </div>
        
        <!-- Car Stats -->
        <div class="card">
            <div class="card-header bg-transparent border-0">
                <h6 class="fw-bold mb-0">Car Statistics</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--border-color) !important;">
                        <span class="text-muted">Total Rentals</span>
                        <span>{{ $car->rentals->count() }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--border-color) !important;">
                        <span class="text-muted">Active Rentals</span>
                        <span>{{ $car->rentals->whereIn('status', ['pending', 'confirmed'])->count() }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">Added On</span>
                        <span>{{ $car->created_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
});
</script>
@endpush
@endsection

