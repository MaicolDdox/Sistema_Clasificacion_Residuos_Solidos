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

        //creamos un rol Gestora Ambiental
        $gestoraAmbiental = User::factory()->create([
            'name' => 'Gestora Ambiental',
            'email' => 'gestora_ambiental@gmail.com',
            'password' => bcrypt('gestora_ambiental12345678'),
        ]);
        $gestoraAmbiental->assignRole('Gestora Ambiental');

        //creamos un rol Gestora Ambiental
        $liderAmbiental = User::factory()->create([
            'name' => 'Lider Ambiental',
            'email' => 'lider_ambiental@gmail.com',
            'password' => bcrypt('lider_ambiental12345678'),
        ]);
        $liderAmbiental->assignRole('Lider Ambiental');

        //creamos un rol Gestora Ambiental
        $aprendiz = User::factory()->create([
            'name' => 'Aprendiz',
            'email' => 'aprendiz@gmail.com',
            'password' => bcrypt('aprendiz12345678'),
        ]);
        $aprendiz->assignRole('Aprendiz');

        $belen = User::factory()->create([
            'name' => 'Instructora Belen',
            'email' => 'alexcequisena2023@gmail.com',
            'password' => bcrypt('belen12345678'),
        ]);
        $belen->assignRole('Gestora Ambiental');

        }
}
