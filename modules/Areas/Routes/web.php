<?php

use Illuminate\Support\Facades\Route;
use Modules\Areas\Http\Controllers\AreaController;

/*
|--------------------------------------------------------------------------
| RUTAS DEL MÓDULO AREAS
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
    Route::get('areas', [AreaController::class, 'index'])
        ->middleware('permission:areas.index')
        ->name('areas.index');

    // ========================================
    // RUTAS DE CREACIÓN (Gestora + Líder)
    // ========================================
    Route::get('areas/create', [AreaController::class, 'create'])
        ->middleware('permission:areas.create')
        ->name('areas.create');

    Route::post('areas', [AreaController::class, 'store'])
        ->middleware('permission:areas.store')
        ->name('areas.store');

    // ========================================
    // RUTAS DE EDICIÓN (Gestora + Líder)
    // ========================================
    Route::get('areas/{area}/edit', [AreaController::class, 'edit'])
        ->middleware('permission:areas.edit')
        ->name('areas.edit');

    Route::put('areas/{area}', [AreaController::class, 'update'])
        ->middleware('permission:areas.update')
        ->name('areas.update');

    // ========================================
    // RUTAS DE ELIMINACIÓN (Solo Gestora)
    // ========================================
    Route::get('areas/{area}/destroy/confirm', [AreaController::class, 'confirmDestroy'])
        ->middleware('permission:areas.destroy.confirm')
        ->name('areas.destroy.confirm');

    Route::delete('areas/{area}', [AreaController::class, 'destroy'])
        ->middleware('permission:areas.destroy')
        ->name('areas.destroy');

    // ========================================
    // RUTAS DE DETALLE (Debe ir al final)
    // ========================================
    Route::get('areas/{area}', [AreaController::class, 'show'])
        ->middleware('permission:areas.show')
        ->name('areas.show');
});
