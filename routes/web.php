<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [CarController::class, 'home'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::get('/dashboard/bookings', [DashboardController::class, 'bookings'])->name('dashboard.bookings');
    
    // Rental routes
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
    Route::put('/rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel');
    
    // API route for car availability
    Route::get('/api/cars/{car}/availability', [CarController::class, 'availability'])->name('cars.availability');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Car management
    Route::get('/cars', [AdminController::class, 'cars'])->name('cars');
    Route::get('/cars/create', [AdminController::class, 'createCar'])->name('cars.create');
    Route::post('/cars', [AdminController::class, 'storeCar'])->name('cars.store');
    Route::get('/cars/{car}/edit', [AdminController::class, 'editCar'])->name('cars.edit');
    Route::put('/cars/{car}', [AdminController::class, 'updateCar'])->name('cars.update');
    Route::delete('/cars/{car}', [AdminController::class, 'destroyCar'])->name('cars.destroy');
    
    // Rental management
    Route::get('/rentals', [AdminController::class, 'rentals'])->name('rentals');
    Route::put('/rentals/{rental}/status', [AdminController::class, 'updateRentalStatus'])->name('rentals.status');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});
