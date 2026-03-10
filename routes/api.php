<?php

use App\Http\Controllers\Api\IglesiaApiController;
use App\Http\Controllers\Api\EventoApiController;
use Illuminate\Support\Facades\Route;

Route::get('/iglesias', [IglesiaApiController::class, 'index']);
Route::get('/iglesias/{iglesia}', [IglesiaApiController::class, 'show']);
Route::get('/eventos', [EventoApiController::class, 'index']);