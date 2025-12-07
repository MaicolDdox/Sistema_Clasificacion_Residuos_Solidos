<?php

use Illuminate\Support\Facades\Route;
use Modules\ProductiveUnits\Http\Controllers\ProductiveUnitController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('productive-units', ProductiveUnitController::class);
});
