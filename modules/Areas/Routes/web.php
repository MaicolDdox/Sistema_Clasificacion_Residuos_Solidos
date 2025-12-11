<?php

use Illuminate\Support\Facades\Route;
use Modules\Areas\Http\Controllers\AreaController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('areas', AreaController::class);
    Route::get('areas/{area}/destroy/confirm', [AreaController::class, 'confirmDestroy'])->name('areas.destroy.confirm');
});
