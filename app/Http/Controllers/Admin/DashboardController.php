<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iglesia;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ── Stats generales ──────────────────────────────────
        $stats = [
            'total'          => Iglesia::count(),
            'activas'        => Iglesia::where('estado', 'activo')->count(),
            'inactivas'      => Iglesia::where('estado', 'inactivo')->count(),
            'denominaciones' => Iglesia::distinct('denominacion')->count('denominacion'),

            // Asistentes
            'total_asistentes' => (int) Iglesia::where('estado', 'activo')
                                        ->whereNotNull('promedio_asistentes')
                                        ->sum('promedio_asistentes'),
            'promedio_global'  => (int) Iglesia::where('estado', 'activo')
                                        ->whereNotNull('promedio_asistentes')
                                        ->avg('promedio_asistentes'),
            'con_asistentes'   => Iglesia::whereNotNull('promedio_asistentes')->count(),
        ];

        // ── Clasificación por tamaño de congregación ─────────
        $tamanos = [
            'pequeña'  => Iglesia::where('estado', 'activo')->whereBetween('promedio_asistentes', [1, 49])->count(),
            'mediana'  => Iglesia::where('estado', 'activo')->whereBetween('promedio_asistentes', [50, 200])->count(),
            'grande'   => Iglesia::where('estado', 'activo')->where('promedio_asistentes', '>', 200)->count(),
            'sin_dato' => Iglesia::where('estado', 'activo')->whereNull('promedio_asistentes')->count(),
        ];

        // ── Top 5 iglesias por asistentes ────────────────────
        $topIglesias = Iglesia::select('id', 'nombre', 'denominacion', 'promedio_asistentes')
            ->where('estado', 'activo')
            ->whereNotNull('promedio_asistentes')
            ->orderByDesc('promedio_asistentes')
            ->take(5)
            ->get();

        // ── Registros recientes ───────────────────────────────
        $recientes = Iglesia::with('ayudas')
            ->latest()
            ->take(5)
            ->get();

        // ── Por denominación ──────────────────────────────────
        $porDenominacion = Iglesia::select('denominacion', DB::raw('count(*) as total'))
            ->where('estado', 'activo')
            ->groupBy('denominacion')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // ── Cumpleaños de líderes para el mini-calendario ────
        // Trae todos los que tienen fecha, calcula cuándo cae este año/siguiente
        $hoy = now();

        $cumpleanosRaw = Iglesia::whereNotNull('fecha_nacimiento_lider')
            ->whereNotNull('pastor_sacerdote')
            ->select('id', 'nombre', 'pastor_sacerdote', 'fecha_nacimiento_lider')
            ->get()
            ->map(function ($ig) use ($hoy) {
                $nac    = $ig->fecha_nacimiento_lider;
                $cumple = $nac->copy()->year($hoy->year);
                if ($cumple->lt($hoy->copy()->startOfDay())) {
                    $cumple->addYear();
                }
                return [
                    'tipo'    => 'cumpleaños',
                    'fecha'   => $cumple->format('Y-m-d'),
                    'label'   => $ig->pastor_sacerdote,
                    'iglesia' => $ig->nombre,
                    'edad'    => $nac->age + ($cumple->year > $hoy->year ? 1 : 0),
                    'color'   => '#F59E0B',
                ];
            });

        // ── Eventos desde la API (si el modelo existe) ────────
        $eventosRaw = collect();
        if (class_exists(\App\Models\Evento::class)) {
            try {
                $eventosRaw = \App\Models\Evento::select('id', 'titulo', 'fecha_inicio', 'tipo_evento')
                    ->where('fecha_inicio', '>=', $hoy->copy()->startOfMonth())
                    ->where('fecha_inicio', '<=', $hoy->copy()->addMonths(2)->endOfMonth())
                    ->orderBy('fecha_inicio')
                    ->get()
                    ->map(fn($e) => [
                        'tipo'   => 'evento',
                        'fecha'  => $e->fecha_inicio->format('Y-m-d'),
                        'label'  => $e->titulo,
                        'color'  => '#3B82F6',
                        'tipo_evento' => $e->tipo_evento ?? 'evento',
                    ]);
            } catch (\Exception) {
                $eventosRaw = collect();
            }
        }

        // Unir eventos y cumpleaños → JSON para el JS del mini-calendario
        $calendarData = $eventosRaw->merge($cumpleanosRaw)->values();

        // Próximos 5 eventos/cumpleaños desde hoy
        $proximosEventos = $calendarData
            ->filter(fn($e) => $e['fecha'] >= $hoy->format('Y-m-d'))
            ->sortBy('fecha')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'stats',
            'tamanos',
            'topIglesias',
            'recientes',
            'porDenominacion',
            'calendarData',
            'proximosEventos',
        ));
    }
}