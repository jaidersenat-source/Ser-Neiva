<?php

namespace App\Http\Controllers;

use App\Models\Iglesia;
use Illuminate\View\View;

class MapaController extends Controller
{
    public function index(): View
    {
        $totalIglesias = Iglesia::where('church_status', 'Active')->count();

        $denominaciones = Iglesia::where('church_status', 'Active')
            ->whereNotNull('denomination')
            ->where('denomination', '!=', '')
            ->distinct()
            ->orderBy('denomination')
            ->pluck('denomination');

        return view('mapa.index', compact('totalIglesias', 'denominaciones'));
    }
}