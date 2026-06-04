<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();
        $matieres = Matiere::all();

        foreach ($eleves as $eleve) {
            foreach ($matieres as $matiere) {

                Note::create([
                    'eleve_id' => $eleve->id,
                    'matiere_id' => $matiere->id,
                    'note' => rand(8, 18),
                    'trimestre' => rand(1, 3),
                ]);
            }
        }
    }
}