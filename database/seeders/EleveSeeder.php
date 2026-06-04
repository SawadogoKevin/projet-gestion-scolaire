<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Classe;

class EleveSeeder extends Seeder
{
    public function run(): void
    {
        $classe = Classe::first();

        for ($i = 1; $i <= 20; $i++) {
            Eleve::create([
                'nom' => 'Sana1',
                'prenom' => 'Ali1',
                'classe_id' => 1,
                'date_naissance' => '2012-05-10',
            ]);
        
        }
    }
}