<?php

use Illuminate\Support\Facades\Route;
use Modules\Wastes\Http\Controllers\HazardouWasteController;
use Modules\Wastes\Http\Controllers\HazardouWasteOutletController;
use Modules\Wastes\Http\Controllers\WasteController;
use Modules\Wastes\Http\Controllers\WasteOutletController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('wastes', WasteController::class);
    Route::resource('hazardou-wastes', HazardouWasteController::class);
    Route::resource('waste-outlets', WasteOutletController::class);
    Route::resource('hazardou-waste-outlets', HazardouWasteOutletController::class);
});
