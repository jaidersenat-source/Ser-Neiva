<?php

use App\Http\Controllers\Api\FoundationApiController;
use App\Http\Controllers\Api\GeocoderController;
use App\Http\Controllers\Api\IglesiaApiController;
use App\Http\Controllers\Api\EventoApiController;
use App\Http\Controllers\Api\EmprendimientoApiController;
use App\Http\Controllers\Api\SportsVenueApiController;
use Illuminate\Support\Facades\Route;

// ── Geocoding proxy (30 peticiones/minuto por IP) ───────────────────
Route::middleware('throttle:30,1')->group(function () {
    Route::post('/geocode',         [GeocoderController::class, 'geocode']);
    Route::post('/geocode/reverse', [GeocoderController::class, 'reverseGeocode']);
});

Route::get('/iglesias', [IglesiaApiController::class, 'index']);
Route::get('/iglesias/{iglesia}', [IglesiaApiController::class, 'show']);
Route::get('/eventos', [EventoApiController::class, 'index']);
Route::get('/eventos/neiva', [EventoApiController::class, 'getNeivaEvents']);
Route::get('/eventos/huila', [EventoApiController::class, 'getHuilaEvents']);
Route::get('/escenarios', [SportsVenueApiController::class, 'index']);
Route::get('/fundaciones', [FoundationApiController::class, 'index']);
Route::get('/emprendimientos', [EmprendimientoApiController::class, 'index']);