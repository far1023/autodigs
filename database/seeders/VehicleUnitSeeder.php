<?php

namespace Database\Seeders;

use App\Models\Vehicle\VehicleUnit;
use Illuminate\Database\Seeder;

class VehicleUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleUnit::factory()->count(10)->create();
    }
}
