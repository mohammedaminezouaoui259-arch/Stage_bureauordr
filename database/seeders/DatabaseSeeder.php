<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed statuses & services
        $this->call([
            StatusSeeder::class,
            ServiceSeeder::class,
            NatureSeeder::class,
        ]);

        // User de test (اختياري)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}