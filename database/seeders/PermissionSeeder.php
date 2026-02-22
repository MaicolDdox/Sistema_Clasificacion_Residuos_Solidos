<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetear caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // MÓDULO: AREAS
        // ========================================
        $areaPermissions = [
            'areas.index',           // Ver listado de áreas
            'areas.create',          // Crear nueva área
            'areas.store',           // Guardar área
            'areas.show',            // Ver detalle de área
            'areas.edit',            // Editar área
            'areas.update',          // Actualizar área
            'areas.destroy',         // Eliminar área
            'areas.destroy.confirm', // Confirmar eliminación
        ];

        // ========================================
        // MÓDULO: UNIDADES PRODUCTIVAS
        // ========================================
        $productiveUnitPermissions = [
            'productive-units.index',   // Ver listado de unidades
            'productive-units.create',  // Crear nueva unidad
            'productive-units.store',   // Guardar unidad
            'productive-units.show',    // Ver detalle de unidad
            'productive-units.edit',    // Editar unidad
            'productive-units.update',  // Actualizar unidad
            'productive-units.destroy', // Eliminar unidad
        ];

        // ========================================
        // MÓDULO: RESIDUOS (Ordinarios + Peligrosos)
        // ========================================
        $wastePermissions = [
            // Navegación
            'wastes.navigator',         // Navegar por áreas/unidades

            // Residuos Ordinarios (RESOL)
            'wastes.index',             // Ver listado de residuos ordinarios
            'wastes.create',            // Crear residuo ordinario
            'wastes.store',             // Guardar residuo ordinario
            'wastes.edit',              // Editar residuo ordinario
            'wastes.update',            // Actualizar residuo ordinario
            'wastes.destroy',           // Eliminar residuo ordinario

            // Residuos Peligrosos (RESPEL)
            'hazardou-wastes.index',    // Ver listado de residuos peligrosos
            'hazardou-wastes.create',   // Crear residuo peligroso
            'hazardou-wastes.store',    // Guardar residuo peligroso
            'hazardou-wastes.edit',     // Editar residuo peligroso
            'hazardou-wastes.update',   // Actualizar residuo peligroso
            'hazardou-wastes.destroy',  // Eliminar residuo peligroso

            // Reportes
            'wastes.report.resol',      // Reporte de residuos ordinarios
            'wastes.report.respel',     // Reporte de residuos peligrosos

            // Puntos de salida (Outlets)
            'waste-outlets.index',      // Ver puntos de salida ordinarios
            'waste-outlets.store',      // Crear punto de salida ordinario
            'waste-outlets.update',     // Actualizar punto de salida ordinario
            'waste-outlets.destroy',    // Eliminar punto de salida ordinario

            'hazardou-waste-outlets.index',   // Ver puntos de salida peligrosos
            'hazardou-waste-outlets.store',   // Crear punto de salida peligroso
            'hazardou-waste-outlets.update',  // Actualizar punto de salida peligroso
            'hazardou-waste-outlets.destroy', // Eliminar punto de salida peligroso
        ];

        // ========================================
        // MÓDULO: GESTIÓN DE ROLES (Administrativo)
        // ========================================
        $roleManagementPermissions = [
            'roles.index',   // Ver listado de asignación de roles
            'roles.create',  // Asignar rol a usuario
            'roles.store',   // Guardar asignación
            'roles.edit',    // Editar asignación de rol
            'roles.update',  // Actualizar asignación
            'roles.destroy', // Remover rol de usuario
        ];

        // ========================================
        // CREAR TODOS LOS PERMISOS EN LA BD
        // ========================================
        $allPermissions = array_merge(
            $areaPermissions,
            $productiveUnitPermissions,
            $wastePermissions,
            $roleManagementPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        $this->command->info('✅' . count($allPermissions) . ' Permisos creados exitosamente.');

        // ========================================
        // ASIGNAR PERMISOS A ROLES
        // ========================================
        $this->assignPermissionsToRoles();
    }

    /**
     * Asignar permisos específicos a cada rol según la jerarquía
     */
    private function assignPermissionsToRoles(): void
    {
        // ========================================
        // ROL 1: GESTORA AMBIENTAL (Acceso Total)
        // ========================================
        $gestoraAmbiental = Role::firstOrCreate(['name' => 'Gestora Ambiental']);

        // La Gestora tiene TODOS los permisos del sistema
        $gestoraAmbiental->syncPermissions(Permission::all());

        $this->command->info('Gestora Ambiental: ' . $gestoraAmbiental->permissions->count() . ' permisos asignados (ACCESO TOTAL)');

        // ========================================
        // ROL 2: LÍDER AMBIENTAL (Sin eliminar)
        // ========================================
        $liderAmbiental = Role::firstOrCreate(['name' => 'Lider Ambiental']);

        // El Líder puede: ver, crear, editar - NO puede eliminar
        $liderPermissions = Permission::where('name', 'not like', '%.destroy')
            ->where('name', 'not like', '%.destroy.confirm')
            ->where(function ($query) {
                $query->where('name', 'not like', 'roles.%')
                    ->orWhere('name', 'roles.index');
            })
            ->get();

        $liderAmbiental->syncPermissions($liderPermissions);

        $this->command->info('Líder Ambiental: ' . $liderAmbiental->permissions->count() . ' permisos asignados (Ver/Crear/Editar)');

        // ========================================
        // ROL 3: APRENDIZ (Lectura + Crear/Editar residuos propios)
        // ========================================
        $aprendiz = Role::firstOrCreate(['name' => 'Aprendiz']);

        // El Aprendiz puede:
        // - VER todo (index, show, reportes, navegación)
        // - CREAR residuos RESOL y RESPEL
        // - EDITAR solo SUS propios registros (validado en controlador)
        $aprendizPermissions = Permission::where(function ($query) {
            $query->where('name', 'like', '%.index')
                  ->orWhere('name', 'like', '%.show')
                  ->orWhere('name', 'like', '%.report.%')
                  ->orWhere('name', '=', 'wastes.navigator')
                  // RESOL: crear y editar
                  ->orWhere('name', '=', 'wastes.create')
                  ->orWhere('name', '=', 'wastes.store')
                  ->orWhere('name', '=', 'wastes.edit')
                  ->orWhere('name', '=', 'wastes.update')
                  // RESPEL: crear y editar
                  ->orWhere('name', '=', 'hazardou-wastes.create')
                  ->orWhere('name', '=', 'hazardou-wastes.store')
                  ->orWhere('name', '=', 'hazardou-wastes.edit')
                  ->orWhere('name', '=', 'hazardou-wastes.update');
        })->get();

        $aprendiz->syncPermissions($aprendizPermissions);

        $this->command->info('Aprendiz: ' . $aprendiz->permissions->count() . ' permisos asignados (Lectura + CRUD residuos propios)');

        $this->command->newLine();
        $this->command->warn('RESUMEN DE PERMISOS:');
        $this->command->table(
            ['Rol', 'Permisos Asignados', 'Nivel de Acceso'],
            [
                ['Gestora Ambiental', $gestoraAmbiental->permissions->count(), 'TOTAL (CRUD completo)'],
                ['Líder Ambiental', $liderAmbiental->permissions->count(), 'ALTO (Ver/Crear/Editar)'],
                ['Aprendiz', $aprendiz->permissions->count(), 'BÁSICO (Lectura + residuos propios)'],
            ]
        );
    }
}
