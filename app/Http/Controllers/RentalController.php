<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => ['required', 'exists:cars,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
        
        $car = Car::findOrFail($validated['car_id']);
        
        // Check if car is available
        if (!$car->is_available) {
            return back()->with('error', 'This car is currently unavailable.');
        }
        
        // Check if car is available for selected dates
        if (!$car->isAvailableForDates($validated['start_date'], $validated['end_date'])) {
            return back()->with('error', 'This car is not available for the selected dates. Please choose different dates.');
        }
        
        // Calculate total price
        $startDate = new \DateTime($validated['start_date']);
        $endDate = new \DateTime($validated['end_date']);
        $days = $startDate->diff($endDate)->days + 1;
        $totalPrice = $days * $car->price_per_day;
        
        // Create rental
        $rental = Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
        
        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Booking created successfully! Your booking is pending confirmation.');
    }

    public function show(Rental $rental)
    {
        // Ensure user can only see their own rentals
        if ($rental->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return view('dashboard.rental-show', compact('rental'));
    }

    public function cancel(Rental $rental)
    {
        // Ensure user can only cancel their own rentals
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Can only cancel pending or confirmed rentals
        if (!in_array($rental->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }
        
        // Cannot cancel if rental has started
        if ($rental->start_date <= now()) {
            return back()->with('error', 'Cannot cancel a booking that has already started.');
        }
        
        $rental->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Booking cancelled successfully.');
    }
}

