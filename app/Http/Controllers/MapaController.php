<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\View\View;

class MapaController extends Controller
{
    public function index(): View
    {
        $isActive = fn($q) => $q->where('estado', 'activo')->orWhere('church_status', 'Activo');

        $totalIglesias = Iglesia::where($isActive)->count();

        $denominaciones = Iglesia::where($isActive)
            ->get()
            ->map(fn($i) => $i->denomination ?: $i->denominacion)
            ->filter()
            ->unique()
            ->values();

        $datosDesdePHP = Iglesia::where($isActive)->get();

        return view('mapa.index', compact('totalIglesias', 'denominaciones', 'datosDesdePHP'));
    }
}