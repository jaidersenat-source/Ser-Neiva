<?php

use App\Http\Controllers\Api\IglesiaApiController;
use App\Http\Controllers\Api\EventoApiController;
use App\Http\Controllers\Api\SportsVenueApiController;
use Illuminate\Support\Facades\Route;

Route::get('/iglesias', [IglesiaApiController::class, 'index']);
Route::get('/iglesias/{iglesia}', [IglesiaApiController::class, 'show']);
Route::get('/eventos', [EventoApiController::class, 'index']);
Route::get('/eventos/neiva', [EventoApiController::class, 'getNeivaEvents']);
Route::get('/eventos/huila', [EventoApiController::class, 'getHuilaEvents']);
Route::get('/escenarios', [SportsVenueApiController::class, 'index']);