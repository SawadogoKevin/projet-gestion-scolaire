<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\Matiere;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Liste des classes
        $classes = [
            'CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2'
        ];

        // 2. Matières communes
        $matieres = [
            ['nom' => 'Operation', 'coefficient' => 1],
            ['nom' => 'Dictée', 'coefficient' => 1],
            ['nom' => 'Observation', 'coefficient' => 1],
            ['nom' => 'Histoire-Géo', 'coefficient' => 1],
            ['nom' => 'Anglais', 'coefficient' => 1],
            ['nom' => 'Dessin', 'coefficient' => 1],
            ['nom' => 'Sport', 'coefficient' => 1],
            ['nom' => 'Expression Ecrite', 'coefficient' => 1],
            ['nom' => 'Rédaction', 'coefficient' => 1],
            ['nom' => 'Chant', 'coefficient' => 1],
            ['nom' => 'Lecture', 'coefficient' => 1],
        ];

        // 3. Boucle sur les classes
        foreach ($classes as $classeNom) {

            // récupérer la classe
            $classe = Classe::where('nom', $classeNom)->first();

            if (!$classe) {
                continue; // si la classe n'existe pas
            }

            // créer les matières pour cette classe
            foreach ($matieres as $matiere) {
                Matiere::create([
                    'nom' => $matiere['nom'],
                    'coefficient' => $matiere['coefficient'],
                    'classe_id' => $classe->id
                ]);
            }
        }
    }
}