<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\User;
use App\Models\Barangay;
use App\Models\EmergencyVehicle;
use App\Models\IncidentType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->create();
        // Barangay::factory(44)->create();
        // IncidentType::factory(100)->create();
        // EmergencyVehicle::factory(100)->create();
        Agency::factory(4)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
