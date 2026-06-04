<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClasseSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['nom' => 'CP1', 'frais_scolarite' => 5000],
            ['nom' => 'CP2', 'frais_scolarite' => 5000],
            ['nom' => 'CE1', 'frais_scolarite' => 5500],
            ['nom' => 'CE2', 'frais_scolarite' => 5500],
            ['nom' => 'CM1', 'frais_scolarite' => 6000],
            ['nom' => 'CM2', 'frais_scolarite' => 6000],
        ];

        foreach ($classes as $classe) {
            Classe::create($classe);
        }
    }
}