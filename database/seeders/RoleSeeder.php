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

        /*

        El RoleSeeder ya no se ejecuta 
        porque PermissionSeeder ya crea 
        los 3 roles con Role::firstOrCreate dentro de assignPermissionsToRoles().

        $gestoraAmbiental   = Role::firstOrCreate(['name'  => 'Gestora Ambiental']);
        $liderAmbiental     = Role::firstOrCreate(['name'  => 'Lider Ambiental']);
        $aprendiz           = Role::firstOrCreate(['name'  => 'Aprendiz']);
        */
    }
}


    
