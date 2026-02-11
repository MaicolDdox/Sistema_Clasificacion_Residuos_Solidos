<?php

use Illuminate\Support\Facades\Route;
use Modules\Wastes\Http\Controllers\HazardouWasteController;
use Modules\Wastes\Http\Controllers\HazardouWasteOutletController;
use Modules\Wastes\Http\Controllers\WasteReportController;
use Modules\Wastes\Http\Controllers\WasteNavigatorController;
use Modules\Wastes\Http\Controllers\WasteController;
use Modules\Wastes\Http\Controllers\WasteOutletController;

/*
|--------------------------------------------------------------------------
| RUTAS DEL MÓDULO WASTES (Residuos Ordinarios + Peligrosos)
|--------------------------------------------------------------------------
| Protegidas con permisos según el rol:
| - Gestora Ambiental: Acceso total (CRUD completo)
| - Líder Ambiental: Ver, crear, editar (sin eliminar)
| - Aprendiz: Solo ver (listados y reportes)
*/

Route::middleware(['web', 'auth'])->group(function () {

    // ========================================
    // NAVEGACIÓN Y REPORTES (Todos los roles)
    // ========================================
    Route::get('wastes/area/{area}/units', [WasteNavigatorController::class, 'unitsByArea'])
        ->middleware('permission:wastes.navigator')
        ->name('wastes.units.byArea');

    Route::get('wastes/unit/{unit}/report/resol', [WasteReportController::class, 'resolReport'])
        ->middleware('permission:wastes.report.resol')
        ->name('wastes.report.resol');

    Route::get('wastes/unit/{unit}/report/respel', [WasteReportController::class, 'respelReport'])
        ->middleware('permission:wastes.report.respel')
        ->name('wastes.report.respel');

    // ========================================
    // RESIDUOS ORDINARIOS (RESOL)
    // ========================================

    // Lectura (Todos los roles)
    Route::get('wastes/unit/{unit}', [WasteController::class, 'byUnit'])
        ->middleware('permission:wastes.index')
        ->name('wastes.byUnit');

    // Creación (Gestora + Líder)
    Route::get('wastes/create/{unit}', [WasteController::class, 'create'])
        ->middleware('permission:wastes.create')
        ->name('wastes.create');

    Route::post('wastes', [WasteController::class, 'store'])
        ->middleware('permission:wastes.store')
        ->name('wastes.store');

    // Edición (Gestora + Líder)
    Route::get('wastes/{waste}/edit', [WasteController::class, 'edit'])
        ->middleware('permission:wastes.edit')
        ->name('wastes.edit');

    Route::put('wastes/{waste}', [WasteController::class, 'update'])
        ->middleware('permission:wastes.update')
        ->name('wastes.update');

    Route::patch('wastes/{waste}', [WasteController::class, 'update'])
        ->middleware('permission:wastes.update');

    // Eliminación (Solo Gestora)
    Route::delete('wastes/{waste}', [WasteController::class, 'destroy'])
        ->middleware('permission:wastes.destroy')
        ->name('wastes.destroy');

    // ========================================
    // RESIDUOS PELIGROSOS (RESPEL)
    // ========================================

    // Lectura (Todos los roles)
    Route::get('hazardou-wastes/unit/{unit}', [HazardouWasteController::class, 'byUnit'])
        ->middleware('permission:hazardou-wastes.index')
        ->name('hazardou-wastes.byUnit');

    // Creación (Gestora + Líder)
    Route::get('hazardou-wastes/create/{unit}', [HazardouWasteController::class, 'create'])
        ->middleware('permission:hazardou-wastes.create')
        ->name('hazardou-wastes.create');

    Route::post('hazardou-wastes', [HazardouWasteController::class, 'store'])
        ->middleware('permission:hazardou-wastes.store')
        ->name('hazardou-wastes.store');

    // Edición (Gestora + Líder)
    Route::get('hazardou-wastes/{hazardou_waste}/edit', [HazardouWasteController::class, 'edit'])
        ->middleware('permission:hazardou-wastes.edit')
        ->name('hazardou-wastes.edit');

    Route::put('hazardou-wastes/{hazardou_waste}', [HazardouWasteController::class, 'update'])
        ->middleware('permission:hazardou-wastes.update')
        ->name('hazardou-wastes.update');

    Route::patch('hazardou-wastes/{hazardou_waste}', [HazardouWasteController::class, 'update'])
        ->middleware('permission:hazardou-wastes.update');

    // Eliminación (Solo Gestora)
    Route::delete('hazardou-wastes/{hazardou_waste}', [HazardouWasteController::class, 'destroy'])
        ->middleware('permission:hazardou-wastes.destroy')
        ->name('hazardou-wastes.destroy');

    // ========================================
    // PUNTOS DE SALIDA - RESIDUOS ORDINARIOS
    // ========================================

    // Lectura (Todos los roles)
    Route::get('waste-outlets', [WasteOutletController::class, 'index'])
        ->middleware('permission:waste-outlets.index')
        ->name('waste-outlets.index');

    Route::get('waste-outlets/{waste_outlet}', [WasteOutletController::class, 'show'])
        ->middleware('permission:waste-outlets.index')
        ->name('waste-outlets.show');

    // Creación (Gestora + Líder)
    Route::get('waste-outlets/create', [WasteOutletController::class, 'create'])
        ->middleware('permission:waste-outlets.store')
        ->name('waste-outlets.create');

    Route::post('waste-outlets', [WasteOutletController::class, 'store'])
        ->middleware('permission:waste-outlets.store')
        ->name('waste-outlets.store');

    // Edición (Gestora + Líder)
    Route::get('waste-outlets/{waste_outlet}/edit', [WasteOutletController::class, 'edit'])
        ->middleware('permission:waste-outlets.update')
        ->name('waste-outlets.edit');

    Route::put('waste-outlets/{waste_outlet}', [WasteOutletController::class, 'update'])
        ->middleware('permission:waste-outlets.update')
        ->name('waste-outlets.update');

    Route::patch('waste-outlets/{waste_outlet}', [WasteOutletController::class, 'update'])
        ->middleware('permission:waste-outlets.update');

    // Eliminación (Solo Gestora)
    Route::delete('waste-outlets/{waste_outlet}', [WasteOutletController::class, 'destroy'])
        ->middleware('permission:waste-outlets.destroy')
        ->name('waste-outlets.destroy');

    // ========================================
    // PUNTOS DE SALIDA - RESIDUOS PELIGROSOS
    // ========================================

    // Lectura (Todos los roles)
    Route::get('hazardou-waste-outlets', [HazardouWasteOutletController::class, 'index'])
        ->middleware('permission:hazardou-waste-outlets.index')
        ->name('hazardou-waste-outlets.index');

    Route::get('hazardou-waste-outlets/{hazardou_waste_outlet}', [HazardouWasteOutletController::class, 'show'])
        ->middleware('permission:hazardou-waste-outlets.index')
        ->name('hazardou-waste-outlets.show');

    // Creación (Gestora + Líder)
    Route::get('hazardou-waste-outlets/create', [HazardouWasteOutletController::class, 'create'])
        ->middleware('permission:hazardou-waste-outlets.store')
        ->name('hazardou-waste-outlets.create');

    Route::post('hazardou-waste-outlets', [HazardouWasteOutletController::class, 'store'])
        ->middleware('permission:hazardou-waste-outlets.store')
        ->name('hazardou-waste-outlets.store');

    // Edición (Gestora + Líder)
    Route::get('hazardou-waste-outlets/{hazardou_waste_outlet}/edit', [HazardouWasteOutletController::class, 'edit'])
        ->middleware('permission:hazardou-waste-outlets.update')
        ->name('hazardou-waste-outlets.edit');

    Route::put('hazardou-waste-outlets/{hazardou_waste_outlet}', [HazardouWasteOutletController::class, 'update'])
        ->middleware('permission:hazardou-waste-outlets.update')
        ->name('hazardou-waste-outlets.update');

    Route::patch('hazardou-waste-outlets/{hazardou_waste_outlet}', [HazardouWasteOutletController::class, 'update'])
        ->middleware('permission:hazardou-waste-outlets.update');

    // Eliminación (Solo Gestora)
    Route::delete('hazardou-waste-outlets/{hazardou_waste_outlet}', [HazardouWasteOutletController::class, 'destroy'])
        ->middleware('permission:hazardou-waste-outlets.destroy')
        ->name('hazardou-waste-outlets.destroy');
});
