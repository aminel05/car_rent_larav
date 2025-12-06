<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'color',
        'price_per_day',
        'image',
        'description',
        'seats',
        'transmission',
        'fuel_type',
        'is_available',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'is_available' => 'boolean',
        'year' => 'integer',
        'seats' => 'integer',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function isAvailableForDates($startDate, $endDate, $excludeRentalId = null)
    {
        $query = $this->rentals()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });

        if ($excludeRentalId) {
            $query->where('id', '!=', $excludeRentalId);
        }

        return $query->count() === 0;
    }

    public function getBookedDates()
    {
        $rentals = $this->rentals()
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['start_date', 'end_date']);

        $bookedDates = [];
        foreach ($rentals as $rental) {
            $start = new \DateTime($rental->start_date);
            $end = new \DateTime($rental->end_date);
            $interval = new \DateInterval('P1D');
            $dateRange = new \DatePeriod($start, $interval, $end->modify('+1 day'));

            foreach ($dateRange as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }

        return array_unique($bookedDates);
    }
}

