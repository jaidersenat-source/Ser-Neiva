<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IglesiaController;
use App\Http\Controllers\MapaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventoController;

// Redirección raíz
Route::get('/', fn() => redirect()->route('mapa.index'));

// Mapa público (sin autenticación)
Route::get('/mapa', [MapaController::class, 'index'])->name('mapa.index');

// Panel Administrativo (requiere autenticación)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
   

    // === IMPORTACIÓN MASIVA (corregido: sin /admin/ repetido) ===
    Route::get('/iglesias/import', [IglesiaController::class, 'import'])
        ->name('iglesias.import');

    Route::post('/iglesias/import', [IglesiaController::class, 'importStore'])
        ->name('iglesias.import.store');

         // Recursos estándar para iglesias
    Route::resource('iglesias', IglesiaController::class);

    // === EVENTOS ===
    Route::resource('eventos',EventoController::class);
    Route::get('eventos-calendario', [EventoController::class, 'calendar'])->name('eventos.calendar');
});

// Reemplaza la ruta dashboard por defecto de Breeze
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/perfil', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/perfil', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

Route::prefix('iglesias/export')
    ->name('iglesias.export.')
    ->controller(\App\Http\Controllers\Admin\ExportController::class)
    ->group(function () {
        Route::get('pdf',   'pdf')   ->name('pdf');
        Route::get('excel', 'excel') ->name('excel');
    });

require __DIR__ . '/auth.php';