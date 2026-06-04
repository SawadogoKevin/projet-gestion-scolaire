<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Gestionnaire
    User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('123456'),
        'role' => 'gestionnaire'
    ]);

    // Enseignant
    User::create([
        'name' => 'Prof',
        'email' => 'prof@gmail.com',
        'password' => bcrypt('123456'),
        'role' => 'enseignant'
    ]);
    }
}
