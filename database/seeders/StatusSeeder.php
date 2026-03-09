<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::create([
            'nom' => 'Draft',
            'description' => 'Courrier en brouillon'
        ]);

        Status::create([
            'nom' => 'En cours',
            'description' => 'Courrier en traitement'
        ]);

        Status::create([
            'nom' => 'Terminé',
            'description' => 'Traitement terminé'
        ]);

        Status::create([
            'nom' => 'Archivé',
            'description' => 'Courrier archivé'
        ]);
    }
}