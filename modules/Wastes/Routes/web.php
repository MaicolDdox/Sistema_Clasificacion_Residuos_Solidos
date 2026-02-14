<?php

use Illuminate\Support\Facades\Route;
use Modules\Wastes\Http\Controllers\HazardouWasteExportController;
use Modules\Wastes\Http\Controllers\HazardouWasteController;
use Modules\Wastes\Http\Controllers\WasteReportController;
use Modules\Wastes\Http\Controllers\WasteNavigatorController;
use Modules\Wastes\Http\Controllers\WasteController;
use Modules\Wastes\Http\Controllers\WasteExportController;

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

    Route::get('wastes/unit/{unit}/export/pdf', [WasteExportController::class, 'rangePdf'])
        ->middleware('permission:wastes.report.resol')
        ->name('wastes.export.range.pdf');

    Route::get('wastes/unit/{unit}/export/excel', [WasteExportController::class, 'rangeExcel'])
        ->middleware('permission:wastes.report.resol')
        ->name('wastes.export.range.excel');

    Route::get('hazardou-wastes/unit/{unit}/export/pdf', [HazardouWasteExportController::class, 'rangePdf'])
        ->middleware('permission:wastes.report.respel')
        ->name('hazardou-wastes.export.range.pdf');

    Route::get('hazardou-wastes/unit/{unit}/export/excel', [HazardouWasteExportController::class, 'rangeExcel'])
        ->middleware('permission:wastes.report.respel')
        ->name('hazardou-wastes.export.range.excel');

    // ========================================
    // RESIDUOS ORDINARIOS (RESOL)
    // ========================================

    // Lectura (Todos los roles)
    Route::get('wastes/unit/{unit}', [WasteController::class, 'byUnit'])
        ->middleware('permission:wastes.index')
        ->name('wastes.byUnit');

    Route::get('wastes/{waste}', [WasteController::class, 'show'])
        ->middleware('permission:wastes.index')
        ->name('wastes.show');

    Route::get('wastes/{waste}/export/pdf', [WasteExportController::class, 'singlePdf'])
        ->middleware('permission:wastes.report.resol')
        ->name('wastes.export.single.pdf');

    Route::get('wastes/{waste}/export/excel', [WasteExportController::class, 'singleExcel'])
        ->middleware('permission:wastes.report.resol')
        ->name('wastes.export.single.excel');

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

    Route::get('hazardou-wastes/{hazardou_waste}', [HazardouWasteController::class, 'show'])
        ->middleware('permission:hazardou-wastes.index')
        ->name('hazardou-wastes.show');

    Route::get('hazardou-wastes/{hazardou_waste}/export/pdf', [HazardouWasteExportController::class, 'singlePdf'])
        ->middleware('permission:wastes.report.respel')
        ->name('hazardou-wastes.export.single.pdf');

    Route::get('hazardou-wastes/{hazardou_waste}/export/excel', [HazardouWasteExportController::class, 'singleExcel'])
        ->middleware('permission:wastes.report.respel')
        ->name('hazardou-wastes.export.single.excel');

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
});
