<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'nom_service' => 'services de développement social, coopération, mutuelle et partenariat',
                'description' => 'Gestion des projets sociaux et partenariats'
            ],
            [
                'nom_service' => 'Services des travaux, équipements et aménagement des espaces',
                'description' => 'Suivi des chantiers et équipements'
            ],
            [
                'nom_service' => 'Services de programmation, finances et budget',
                'description' => 'Élaboration et suivi budgétaire'
            ],
            [
                'nom_service' => 'services des ressources humaines, affaires juridiques, patrimoine et contentieux',
                'description' => 'Gestion du personnel et affaires juridiques'
            ],
        ]);
    }
}