<?php

namespace Database\Factories\Vehicle;

use App\Models\Vehicle\VehicleType;
use App\Models\Vehicle\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle\VehicleUnit>
 */
class VehicleUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alias' => $this->faker->unique()->word,
            'vin_sn' => $this->faker->unique()->regexify('[A-HJ-NPR-Z0-9]{17}'),
            'vehicle_brand_id' => VehicleBrand::inRandomOrder()->first()->id,
            'vehicle_type_id' => VehicleType::inRandomOrder()->first()->id,
            'vehicle_model' => $this->faker->unique()->word,
            'year' => $this->faker->numberBetween(1900, date('Y')),
            'reg_no' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
        ];
    }
}
