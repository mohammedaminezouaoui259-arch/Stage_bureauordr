<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nature;

class NatureSeeder extends Seeder
{

public function run(): void
{

Nature::create([
'nom' => 'Simple'
]);

Nature::create([
'nom' => 'Recommandé'
]);

Nature::create([
'nom' => 'Confidentiel'
]);

}

}