<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cars' => Car::count(),
            'available_cars' => Car::where('is_available', true)->count(),
            'total_rentals' => Rental::count(),
            'active_rentals' => Rental::whereIn('status', ['pending', 'confirmed'])->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_revenue' => Rental::whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
        ];
        
        $recentRentals = Rental::with(['user', 'car'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $pendingRentals = Rental::where('status', 'pending')->count();
        
        return view('admin.index', compact('stats', 'recentRentals', 'pendingRentals'));
    }

    // Car Management
    public function cars(Request $request)
    {
        $query = Car::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('available')) {
            $query->where('is_available', $request->available === 'yes');
        }
        
        $cars = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        return view('admin.cars.index', compact('cars'));
    }

    public function createCar()
    {
        return view('admin.cars.create');
    }

    public function storeCar(Request $request)
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'color' => ['required', 'string', 'max:50'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'seats' => ['required', 'integer', 'min:1', 'max:20'],
            'transmission' => ['required', 'in:automatic,manual'],
            'fuel_type' => ['required', 'in:petrol,diesel,electric,hybrid'],
            'is_available' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }
        
        $validated['is_available'] = $request->has('is_available');
        
        Car::create($validated);
        
        return redirect()->route('admin.cars')->with('success', 'Car added successfully!');
    }

    public function editCar(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function updateCar(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'color' => ['required', 'string', 'max:50'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'seats' => ['required', 'integer', 'min:1', 'max:20'],
            'transmission' => ['required', 'in:automatic,manual'],
            'fuel_type' => ['required', 'in:petrol,diesel,electric,hybrid'],
            'is_available' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);
        
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if exists
            if ($car->image && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            // Store new image
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }
        
        // Handle is_available checkbox
        $validated['is_available'] = $request->has('is_available');
        
        // Update car with validated data
        $car->update($validated);
        
        return redirect()->route('admin.cars')->with('success', 'Car updated successfully!');
    }

    public function destroyCar(Car $car)
    {
        // Check if car has active rentals
        $activeRentals = $car->rentals()->whereIn('status', ['pending', 'confirmed'])->count();
        if ($activeRentals > 0) {
            return back()->with('error', 'Cannot delete car with active bookings.');
        }
        
        // Delete image
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        
        $car->delete();
        
        return redirect()->route('admin.cars')->with('success', 'Car deleted successfully!');
    }

    // Rental Management
    public function rentals(Request $request)
    {
        $query = Rental::with(['user', 'car']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('car', function ($q2) use ($search) {
                    $q2->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%");
                });
            });
        }
        
        $rentals = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('admin.rentals.index', compact('rentals'));
    }

    public function updateRentalStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
        ]);
        
        $rental->update(['status' => $validated['status']]);
        
        return back()->with('success', 'Rental status updated successfully!');
    }

    // User Management
    public function users(Request $request)
    {
        $query = User::withCount('rentals');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }
}

