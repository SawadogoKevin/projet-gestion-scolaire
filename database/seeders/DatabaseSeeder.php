<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClasseSeeder::class,
            MatiereSeeder::class,
            UserSeeder::class,
            EleveSeeder::class,
            NoteSeeder::class,
        ]);
    }
}