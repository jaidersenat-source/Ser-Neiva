<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\View\View;

class MapaController extends Controller
{
    public function index(): View
    {
    $totalIglesias   = Iglesia::activas()->count();
    $denominaciones  = Iglesia::activas()
                        ->select('denominacion')
                        ->distinct()
                        ->pluck('denominacion');

    // Obtén los datos que necesitas pasar a JS
    $datosDesdePHP = Iglesia::activas()->get();

    return view('mapa.index', compact('totalIglesias', 'denominaciones', 'datosDesdePHP'));
}
}