<?php

use Illuminate\Support\Facades\Route;
use Modules\ProductiveUnits\Http\Controllers\ProductiveUnitController;

/*
|--------------------------------------------------------------------------
| RUTAS DEL MÓDULO UNIDADES PRODUCTIVAS
|--------------------------------------------------------------------------
| Protegidas con permisos según el rol:
| - Gestora Ambiental: Acceso total (CRUD completo)
| - Líder Ambiental: Ver, crear, editar (sin eliminar)
| - Aprendiz: Solo ver (index, show)
*/

Route::middleware(['web', 'auth'])->group(function () {

    // ========================================
    // RUTAS DE LECTURA (Todos los roles autenticados)
    // ========================================
    Route::get('productive-units', [ProductiveUnitController::class, 'index'])
        ->middleware('permission:productive-units.index')
        ->name('productive-units.index');

    // ========================================
    // RUTAS DE CREACIÓN (Gestora + Líder)
    // ========================================
    Route::get('productive-units/create', [ProductiveUnitController::class, 'create'])
        ->middleware('permission:productive-units.create')
        ->name('productive-units.create');

    Route::post('productive-units', [ProductiveUnitController::class, 'store'])
        ->middleware('permission:productive-units.store')
        ->name('productive-units.store');

    // ========================================
    // RUTAS DE EDICIÓN (Gestora + Líder)
    // ========================================
    Route::get('productive-units/{productiveUnit}/edit', [ProductiveUnitController::class, 'edit'])
        ->middleware('permission:productive-units.edit')
        ->name('productive-units.edit');

    Route::put('productive-units/{productiveUnit}', [ProductiveUnitController::class, 'update'])
        ->middleware('permission:productive-units.update')
        ->name('productive-units.update');

    Route::patch('productive-units/{productiveUnit}', [ProductiveUnitController::class, 'update'])
        ->middleware('permission:productive-units.update');

    // ========================================
    // RUTAS DE ELIMINACIÓN (Solo Gestora)
    // ========================================
    Route::delete('productive-units/{productiveUnit}', [ProductiveUnitController::class, 'destroy'])
        ->middleware('permission:productive-units.destroy')
        ->name('productive-units.destroy');

    // ========================================
    // RUTAS DE DETALLE (Debe ir al final)
    // ========================================
    Route::get('productive-units/{productiveUnit}', [ProductiveUnitController::class, 'show'])
        ->middleware('permission:productive-units.show')
        ->name('productive-units.show');
});
