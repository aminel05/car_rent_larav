<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_bookings' => $user->rentals()->count(),
            'active_bookings' => $user->rentals()->whereIn('status', ['pending', 'confirmed'])->count(),
            'completed_bookings' => $user->rentals()->where('status', 'completed')->count(),
            'total_spent' => $user->rentals()->where('status', '!=', 'cancelled')->sum('total_price'),
        ];
        
        $recentBookings = $user->rentals()
            ->with('car')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $upcomingBookings = $user->rentals()
            ->with('car')
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
        
        return view('dashboard.index', compact('stats', 'recentBookings', 'upcomingBookings'));
    }

    public function bookings(Request $request)
    {
        $query = auth()->user()->rentals()->with('car');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        return view('dashboard.bookings', compact('bookings'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'confirmed', Password::min(8)],
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        
        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }
        
        $user->save();
        
        return back()->with('success', 'Profile updated successfully!');
    }
}

