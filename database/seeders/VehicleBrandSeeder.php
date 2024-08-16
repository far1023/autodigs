<?php

namespace Database\Seeders;

use App\Models\Vehicle\VehicleBrand;
use Illuminate\Database\Seeder;

class VehicleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleBrands = [
            'Toyota', 'Honda', 'Ford', 'Chevrolet', 'Volkswagen',
            'BMW', 'Mercedes-Benz', 'Audi', 'Nissan', 'Hyundai',
            'Kia', 'Mazda', 'Subaru', 'Volvo', 'Lexus',
            'Jeep', 'Chrysler', 'Dodge', 'Ram', 'Fiat',
        ];

        foreach ($vehicleBrands as $item) {
            VehicleBrand::firstOrCreate(['name' => $item]);
        }
    }
}
