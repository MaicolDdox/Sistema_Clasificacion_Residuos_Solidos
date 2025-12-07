<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //PARA CREAR ROLES Y PERMISOS POR DEFECTO DEL SISTEMA

        // -------------------------
        // Creación de Roles
        // -------------------------
        $gestoraAmbiental   = Role::create(['name'  => 'Gestora Ambiental']);
        $liderAmbiental     = Role::create(['name'  => 'Lider Ambiental']);
        $aprendiz           = Role::create(['name'  => 'Aprendiz']);
    }
}
