<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@carental.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'address' => '123 Admin Street',
            'role' => 'admin',
        ]);

        // Create a regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@carental.com',
            'password' => Hash::make('password'),
            'phone' => '+0987654321',
            'address' => '456 User Avenue',
            'role' => 'user',
        ]);

        // Create sample cars
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2023,
                'color' => 'Silver',
                'price_per_day' => 75.00,
                'description' => 'Reliable and fuel-efficient sedan perfect for business trips and family outings.',
                'seats' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'Honda',
                'model' => 'CR-V',
                'year' => 2023,
                'color' => 'White',
                'price_per_day' => 85.00,
                'description' => 'Spacious SUV with excellent safety features and comfortable ride.',
                'seats' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'BMW',
                'model' => '3 Series',
                'year' => 2024,
                'color' => 'Black',
                'price_per_day' => 120.00,
                'description' => 'Luxury sports sedan with powerful performance and premium features.',
                'seats' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'Mercedes-Benz',
                'model' => 'E-Class',
                'year' => 2024,
                'color' => 'Navy Blue',
                'price_per_day' => 150.00,
                'description' => 'Executive class sedan with ultimate comfort and cutting-edge technology.',
                'seats' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'hybrid',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2024,
                'color' => 'Red',
                'price_per_day' => 110.00,
                'description' => 'Electric vehicle with autopilot features and zero emissions.',
                'seats' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'electric',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'Ford',
                'model' => 'Mustang',
                'year' => 2023,
                'color' => 'Yellow',
                'price_per_day' => 130.00,
                'description' => 'Iconic American muscle car with powerful V8 engine.',
                'seats' => 4,
                'transmission' => 'manual',
                'fuel_type' => 'petrol',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'Audi',
                'model' => 'Q5',
                'year' => 2023,
                'color' => 'Gray',
                'price_per_day' => 115.00,
                'description' => 'Premium compact SUV with quattro all-wheel drive.',
                'seats' => 5,
                'transmission' => 'automatic',
                'fuel_type' => 'diesel',
                'is_available' => true,
                'image' => null,
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'year' => 2023,
                'color' => 'Green',
                'price_per_day' => 55.00,
                'description' => 'Compact hatchback ideal for city driving and easy parking.',
                'seats' => 5,
                'transmission' => 'manual',
                'fuel_type' => 'diesel',
                'is_available' => true,
                'image' => null,
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
