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
        // ── Stats generales + tamaños en 1 solo query ────────
        $raw = Iglesia::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN church_status = 'Active' THEN 1 ELSE 0 END) as activas,
            SUM(CASE WHEN church_status = 'Inactive' THEN 1 ELSE 0 END) as inactivas,
            COUNT(DISTINCT denomination) as denominaciones,
            SUM(CASE WHEN church_status = 'Active' AND approx_members IS NOT NULL THEN approx_members ELSE 0 END) as total_asistentes,
            AVG(CASE WHEN church_status = 'Active' AND approx_members IS NOT NULL THEN approx_members END) as promedio_global,
            SUM(CASE WHEN approx_members IS NOT NULL THEN 1 ELSE 0 END) as con_asistentes,
            SUM(CASE WHEN church_status = 'Active' AND approx_members BETWEEN 1 AND 49 THEN 1 ELSE 0 END) as pequena,
            SUM(CASE WHEN church_status = 'Active' AND approx_members BETWEEN 50 AND 200 THEN 1 ELSE 0 END) as mediana,
            SUM(CASE WHEN church_status = 'Active' AND approx_members > 200 THEN 1 ELSE 0 END) as grande,
            SUM(CASE WHEN church_status = 'Active' AND approx_members IS NULL THEN 1 ELSE 0 END) as sin_dato
        ")->first();

        $stats = [
            'total'            => (int) $raw->total,
            'activas'          => (int) $raw->activas,
            'inactivas'        => (int) $raw->inactivas,
            'denominaciones'   => (int) $raw->denominaciones,
            'total_asistentes' => (int) $raw->total_asistentes,
            'promedio_global'  => (int) $raw->promedio_global,
            'con_asistentes'   => (int) $raw->con_asistentes,
        ];

        $tamanos = [
            'pequeña'  => (int) $raw->pequena,
            'mediana'  => (int) $raw->mediana,
            'grande'   => (int) $raw->grande,
            'sin_dato' => (int) $raw->sin_dato,
        ];

        // ── Top 5 iglesias por asistentes ────────────────────
        $topIglesias = Iglesia::select('id', 'official_name', 'denomination', 'approx_members')
            ->where('church_status', 'Active')
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
            ->where('church_status', 'Active')
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
