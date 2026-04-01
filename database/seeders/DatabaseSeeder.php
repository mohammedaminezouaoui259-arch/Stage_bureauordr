<?php

namespace Database\Seeders;

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
            UserSeeder::class,
        ]);
    }
}
