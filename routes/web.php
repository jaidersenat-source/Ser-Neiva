<?php

use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoundationController;
use App\Http\Controllers\Admin\IglesiaController;
use App\Http\Controllers\Admin\SportsVenueController;
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
    
   

    // === IMPORTACIÓN MASIVA ===
    Route::get('/iglesias/import', [IglesiaController::class, 'import'])
        ->name('iglesias.import');

    Route::post('/iglesias/import', [IglesiaController::class, 'importStore'])
        ->name('iglesias.import.store');

    Route::get('/iglesias/import/template', [IglesiaController::class, 'importTemplate'])
        ->name('iglesias.import.template');

         // Recursos estándar para iglesias
    Route::resource('iglesias', IglesiaController::class);

    // === EVENTOS ===
    Route::resource('eventos',EventoController::class);
    Route::get('eventos-calendario', [EventoController::class, 'calendar'])->name('eventos.calendar');

    // === FUNDACIONES ===
    Route::resource('foundations', FoundationController::class);

    // === ESCENARIOS DEPORTIVOS ===
    Route::resource('sports_venues', SportsVenueController::class);

    // === CAMPAÑAS DE CORREO ===
    Route::resource('campaigns', CampaignController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::post('campaigns/{campaign}/send', [CampaignController::class, 'send'])->name('campaigns.send');
    Route::post('campaigns/upload-image', [CampaignController::class, 'uploadImage'])->name('campaigns.upload-image');
});

// Reemplaza la ruta dashboard por defecto de Breeze
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('iglesias/export')
    ->name('iglesias.export.')
    ->middleware(['auth', 'verified'])
    ->controller(\App\Http\Controllers\Admin\ExportController::class)
    ->group(function () {
        Route::get('pdf',   'pdf')   ->name('pdf');
        Route::get('excel', 'excel') ->name('excel');
    });

require __DIR__ . '/auth.php';