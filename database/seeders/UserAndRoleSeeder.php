<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //PARA CREAR USUARIOS DE PRUEBA

        $gestoraAmbiental = User::firstOrCreate(
            ['email' => 'gestora_ambiental@gmail.com'],
            ['name' => 'Gestora Ambiental', 'password' => bcrypt('gestora_ambiental12345678')]
        );
        $gestoraAmbiental->assignRole('Gestora Ambiental');

        $liderAmbiental = User::firstOrCreate(
            ['email' => 'lider_ambiental@gmail.com'],
            ['name' => 'Lider Ambiental', 'password' => bcrypt('lider_ambiental12345678')]
        );
        $liderAmbiental->assignRole('Lider Ambiental');

        $aprendiz = User::firstOrCreate(
            ['email' => 'aprendiz@gmail.com'],
            ['name' => 'Aprendiz', 'password' => bcrypt('aprendiz12345678')]
        );
        $aprendiz->assignRole('Aprendiz');

        $belen = User::firstOrCreate(
            ['email' => 'alexcequisena2023@gmail.com'],
            ['name' => 'Instructora Belen', 'password' => bcrypt('belen12345678')]
        );
        $belen->assignRole('Gestora Ambiental');

        }
}
