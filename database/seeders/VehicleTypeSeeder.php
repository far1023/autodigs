<?php

namespace Database\Seeders;

use App\Models\Vehicle\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = [
            'Passenger car', 'SUV', 'Pickup truck',
            'Van', 'Minivan', 'Motorcycle',
            'Scooter', 'Bus', 'Semi-truck',
            'Dump truck', 'Cement mixer', 'Garbage truck',
            'Fire truck', 'Ambulance', 'Excavator',
            'Bulldozer', 'Forklift', 'Crane',
            'Tractor', 'Combine harvester',
        ];

        foreach ($vehicleTypes as $item) {
            VehicleType::firstOrCreate(['name' => $item]);
        }
    }
}
