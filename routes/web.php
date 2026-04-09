<?php

use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoundationController;
use App\Http\Controllers\Admin\IglesiaController;
use App\Http\Controllers\Admin\SportsVenueController;
use App\Http\Controllers\MapaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\EmprendimientoController;
use App\Http\Controllers\DecretoController;

// Página de inicio pública (pasar coordenadas para preview del mapa)
Route::get('/', function () {
    $points = \App\Models\Iglesia::whereNotNull('latitud')
        ->whereNotNull('longitud')
        ->limit(200)
        ->get(['latitud', 'longitud'])
        ->map(function ($i) {
            return [$i->latitud, $i->longitud];
        })->toArray();

    return view('home', ['previewPoints' => $points]);
})->name('home');

// Mapa público (sin autenticación)
Route::get('/mapa', [MapaController::class, 'index'])->name('mapa.index');

// Panel Administrativo (requiere autenticación)
use App\Http\Middleware\EnsureIsAdmin;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', EnsureIsAdmin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
   

    // === IMPORTACIÓN MASIVA ===
    Route::get('/iglesias/import', [IglesiaController::class, 'import'])
        ->name('iglesias.import');

    Route::post('/iglesias/import', [IglesiaController::class, 'importStore'])
        ->name('iglesias.import.store');

    Route::get('/iglesias/import/template', [IglesiaController::class, 'importTemplate'])
        ->name('iglesias.import.template');

    // === CREDENCIALES DE ACCESO AL PORTAL ===
    Route::post('/iglesias/{iglesia}/credentials', [IglesiaController::class, 'setCredentials'])
        ->name('iglesias.credentials');

         // Recursos estándar para iglesias
    Route::resource('iglesias', IglesiaController::class);

        // === EMPRENDIMIENTOS ===
        Route::resource('emprendimientos', EmprendimientoController::class);

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
Route::get('/dashboard', function () {
    if (auth()->user()?->isIglesia()) {
        return redirect()->route('iglesia.dashboard');
    }
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// ══ Portal Iglesia ══
Route::prefix('iglesia')->name('iglesia.')->middleware(['auth', 'role.iglesia'])->group(function () {
    Route::get('/dashboard',          [\App\Http\Controllers\Iglesia\IglesiaPortalController::class, 'dashboard'])->name('dashboard');
    Route::resource('eventos',        \App\Http\Controllers\Iglesia\IglesiaEventoController::class);
    Route::resource('emprendimientos',\App\Http\Controllers\Iglesia\IglesiaEmprendimientoController::class);
    // Mostrar perfil del usuario autenticado (primera vista al pulsar "Perfil")
    Route::get('/perfil',             [\App\Http\Controllers\Iglesia\IglesiaPortalController::class, 'showOwn'])->name('perfil.index');
    // Editar perfil
    Route::get('/perfil/edit',        [\App\Http\Controllers\Iglesia\IglesiaPortalController::class, 'editPerfil'])->name('perfil.edit');
    // Actualizar perfil (mantener PUT en /perfil)
    Route::put('/perfil',             [\App\Http\Controllers\Iglesia\IglesiaPortalController::class, 'updatePerfil'])->name('perfil.update');
    // Mostrar perfil público/portal de una iglesia (acepta parámetro de modelo)
    Route::get('/perfil/{iglesia}',   [\App\Http\Controllers\Iglesia\IglesiaPortalController::class, 'show'])->name('perfil.show');
});

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

    // === NORMATIVIDAD (pública) ===
Route::get('normatividad', [DecretoController::class, 'index'])->name('decretos.index');
Route::get('normatividad/{slug}', [DecretoController::class, 'show'])->name('decretos.show');
Route::get('normatividad/{id}/stream', [DecretoController::class, 'streamInline'])->name('decretos.stream');
Route::get('normatividad/{id}/download', [DecretoController::class, 'download'])->name('decretos.download');

require __DIR__ . '/auth.php';