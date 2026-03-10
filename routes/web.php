<?php

use App\Http\Controllers\AsigRoleController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/desarrolladores', function(){
    return view('credits');
})->name('credits');



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/manuales', function () {
        return view('manuales');
    })->middleware(['role:Gestora Ambiental|Lider Ambiental|Aprendiz'])->name('manuales');

    Route::get('/manuales/descargar/usuario', function () {
        return response()->download(public_path('pdfs/Manual_Usuario_SCR_v2.pdf'), 'Manual_Usuario_SCR_v2.pdf');
    })->middleware(['role:Gestora Ambiental|Lider Ambiental|Aprendiz'])->name('manuales.download.usuario');

    Route::get('/manuales/descargar/tecnico', function () {
        return response()->download(public_path('pdfs/Manual_Tecnico_S.C.R.pdf'), 'Manual_Tecnico_SCR.pdf');
    })->middleware(['role:Gestora Ambiental'])->name('manuales.download.tecnico');

    Route::get('/manuales/visualizar/usuario', function () {
        return response()->file(public_path('pdfs/Manual_Usuario_SCR_v2.pdf'));
    })->middleware(['role:Gestora Ambiental|Lider Ambiental|Aprendiz'])->name('manuales.view.usuario');

    Route::get('/manuales/visualizar/tecnico', function () {
        return response()->file(public_path('pdfs/Manual_Tecnico_S.C.R.pdf'));
    })->middleware(['role:Gestora Ambiental'])->name('manuales.view.tecnico')->name('manuales.view.tecnico');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    /*
    |--------------------------------------------------------------------------
    | GESTIÓN DE ROLES (Solo Gestora Ambiental)
    |--------------------------------------------------------------------------
    | Protegido con middleware de roles - Solo la Gestora Ambiental puede
    | asignar, editar o remover roles de otros usuarios
    */
    Route::middleware(['role:Gestora Ambiental'])->group(function () {
        Route::resource('roles', AsigRoleController::class);
    });
});
