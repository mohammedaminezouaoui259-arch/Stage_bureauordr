<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@bureau.dz',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Get services
        $services = DB::table('services')->get();

        $serviceUsers = [
            ['name' => 'Agent Développement Social', 'email' => 'dev.social@bureau.dz'],
            ['name' => 'Agent Travaux', 'email' => 'travaux@bureau.dz'],
            ['name' => 'Agent Finances', 'email' => 'finances@bureau.dz'],
            ['name' => 'Agent RH', 'email' => 'rh@bureau.dz'],
            ['name' => 'Agent Bureau d\'Ordre', 'email' => 'bureau.ordre@bureau.dz'],
        ];

        foreach ($services as $index => $service) {
            User::create([
                'name' => $serviceUsers[$index]['name'],
                'email' => $serviceUsers[$index]['email'],
                'password' => Hash::make('service123'),
                'role' => 'user',
                'service' => $service->nom_service,
                'service_id' => $service->id,
                'is_active' => true,
            ]);
        }
    }
}
