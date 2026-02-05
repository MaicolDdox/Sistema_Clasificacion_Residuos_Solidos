<?php

use Illuminate\Support\Facades\Route;
use Modules\Wastes\Http\Controllers\HazardouWasteController;
use Modules\Wastes\Http\Controllers\HazardouWasteOutletController;
use Modules\Wastes\Http\Controllers\WasteReportController;
use Modules\Wastes\Http\Controllers\WasteNavigatorController;
use Modules\Wastes\Http\Controllers\WasteController;
use Modules\Wastes\Http\Controllers\WasteOutletController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('wastes/area/{area}/units', [WasteNavigatorController::class, 'unitsByArea'])->name('wastes.units.byArea');

    Route::get('/wastes/unit/{unit}/report/resol', [WasteReportController::class, 'resolReport'])->name('wastes.report.resol');
    Route::get('/wastes/unit/{unit}/report/respel', [WasteReportController::class, 'respelReport'])->name('wastes.report.respel');

    Route::get('wastes/create/{unit}', [WasteController::class, 'create'])->name('wastes.create');
    Route::get('hazardou-wastes/create/{unit}', [HazardouWasteController::class, 'create'])->name('hazardou-wastes.create');

    Route::get('wastes/unit/{unit}', [WasteController::class, 'byUnit'])->name('wastes.byUnit');
    Route::get('hazardou-wastes/unit/{unit}', [HazardouWasteController::class, 'byUnit'])->name('hazardou-wastes.byUnit');

    Route::resource('wastes', WasteController::class)->except(['create', 'index', 'show']);
    Route::resource('hazardou-wastes', HazardouWasteController::class)->except(['create', 'index', 'show']);
    Route::resource('waste-outlets', WasteOutletController::class);
    Route::resource('hazardou-waste-outlets', HazardouWasteOutletController::class);
});
