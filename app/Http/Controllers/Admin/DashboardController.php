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
            'activas'        => Iglesia::where('church_status', 'Activo')->count(),
            'inactivas'      => Iglesia::where('church_status', 'Inactivo')->count(),
            'denominaciones' => Iglesia::distinct('denomination')->count('denomination'),

            // Asistentes
            'total_asistentes' => (int) Iglesia::where('church_status', 'Activo')
                                        ->whereNotNull('approx_members')
                                        ->sum('approx_members'),
            'promedio_global'  => (int) Iglesia::where('church_status', 'Activo')
                                        ->whereNotNull('approx_members')
                                        ->avg('approx_members'),
            'con_asistentes'   => Iglesia::whereNotNull('approx_members')->count(),
        ];

        // ── Clasificación por tamaño de congregación ─────────
        $tamanos = [
            'pequeña'  => Iglesia::where('church_status', 'Activo')->whereBetween('approx_members', [1, 49])->count(),
            'mediana'  => Iglesia::where('church_status', 'Activo')->whereBetween('approx_members', [50, 200])->count(),
            'grande'   => Iglesia::where('church_status', 'Activo')->where('approx_members', '>', 200)->count(),
            'sin_dato' => Iglesia::where('church_status', 'Activo')->whereNull('approx_members')->count(),
        ];

        // ── Top 5 iglesias por asistentes ────────────────────
        $topIglesias = Iglesia::select('id', 'official_name', 'denomination', 'approx_members')
            ->where('church_status', 'Activo')
            ->whereNotNull('approx_members')
            ->orderByDesc('approx_members')
            ->take(5)
            ->get();

        // ── Registros recientes ───────────────────────────────
        $recientes = Iglesia::with('ayudas')
            ->latest()
            ->take(5)
            ->get();

        // ── Por denominación ──────────────────────────────────
        $porDenominacion = Iglesia::select('denomination', DB::raw('count(*) as total'))
            ->where('church_status', 'Activo')
            ->groupBy('denomination')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // ── Cumpleaños de líderes para el mini-calendario ────
        // Trae todos los que tienen fecha, calcula cuándo cae este año/siguiente
        $hoy = now();

        $cumpleanosRaw = Iglesia::whereNotNull('pastor_birth_date')
            ->whereNotNull('pastor_full_name')
            ->select('id', 'official_name', 'pastor_full_name', 'pastor_birth_date')
            ->get()
            ->map(function ($ig) use ($hoy) {
                $nac    = $ig->pastor_birth_date;
                $cumple = $nac->copy()->year($hoy->year);
                if ($cumple->lt($hoy->copy()->startOfDay())) {
                    $cumple->addYear();
                }
                return [
                    'tipo'    => 'cumpleaños',
                    'fecha'   => $cumple->format('Y-m-d'),
                    'label'   => $ig->pastor_full_name,
                    'iglesia' => $ig->official_name,
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
        $calendarData = collect($eventosRaw)->merge(collect($cumpleanosRaw))->values();

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