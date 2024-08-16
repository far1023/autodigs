<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Role::firstOrCreate(['name' => 'super-admin']);

        User::create([
            'name' => 'Administrator',
            'username' => 'far1023',
            'email' => 'far@mail.com',
            'password' => '$2y$10$TUC4pP7L.bXMnyGyL1/UVe6npXHuxyDP6AZ2Ziq47JgtG42pbWkAK',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])->assignRole(1);

        $this->call([
            AccessSeeder::class,
            VehicleBrandSeeder::class,
            VehicleTypeSeeder::class,
            VehicleUnitSeeder::class,
        ]);
    }
}
