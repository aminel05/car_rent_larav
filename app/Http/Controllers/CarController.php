<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function home()
    {
        $featuredCars = Car::where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $totalCars = Car::count();
        $brands = Car::distinct('brand')->pluck('brand');
        
        return view('home', compact('featuredCars', 'totalCars', 'brands'));
    }

    public function index(Request $request)
    {
        $query = Car::query();
        
        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        
        // Filter by transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }
        
        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }
        
        // Filter by seats
        if ($request->filled('seats')) {
            $query->where('seats', '>=', $request->seats);
        }
        
        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }
        
        // Only show available cars
        if ($request->boolean('available_only', true)) {
            $query->where('is_available', true);
        }
        
        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');
        $query->orderBy($sortField, $sortOrder);
        
        $cars = $query->paginate(9)->withQueryString();
        
        // Get unique brands for filter
        $brands = Car::distinct('brand')->pluck('brand');
        
        return view('cars.index', compact('cars', 'brands'));
    }

    public function show(Car $car)
    {
        $bookedDates = $car->getBookedDates();
        $relatedCars = Car::where('brand', $car->brand)
            ->where('id', '!=', $car->id)
            ->where('is_available', true)
            ->take(3)
            ->get();
            
        return view('cars.show', compact('car', 'bookedDates', 'relatedCars'));
    }

    public function availability(Car $car)
    {
        $bookedDates = $car->getBookedDates();
        
        return response()->json([
            'booked_dates' => $bookedDates
        ]);
    }
}

