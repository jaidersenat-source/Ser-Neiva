<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoApiController extends Controller
{
    private function formatEvent(Evento $evento): array
    {
        return [
            'id'    => $evento->id,
            'title' => $evento->titulo,
            'start' => $evento->fecha_inicio->toDateString(),
            'end'   => $evento->fecha_fin
                ? $evento->fecha_fin->addDay()->toDateString()
                : null,
            'extendedProps' => [
                'iglesia'          => $evento->iglesia->nombre ?? null,
                'tipo_evento'      => $evento->tipo_evento,
                'direccion_evento' => $evento->direccion_evento,
                'estado'           => $evento->estado,
            ],
        ];
    }

    public function getNeivaEvents(): \Illuminate\Http\JsonResponse
    {
        $eventos = Evento::with('iglesia')
            ->where('estado', 'activo')
            ->whereHas('iglesia', fn($q) => $q->where('municipality', 'Neiva'))
            ->get();

        return response()->json($eventos->map(fn($e) => $this->formatEvent($e)));
    }

    public function getHuilaEvents(): \Illuminate\Http\JsonResponse
    {
        $eventos = Evento::with('iglesia')
            ->where('estado', 'activo')
            ->whereHas('iglesia', fn($q) => $q->where('department', 'Huila'))
            ->get();

        return response()->json($eventos->map(fn($e) => $this->formatEvent($e)));
    }

    public function index(Request $request)
    {
        // Puedes agregar filtros por fecha, tipo, etc. si lo necesitas
        $eventos = Evento::where('estado', 'activo')->get();

        // Adaptar formato para FullCalendar
        $result = $eventos->map(function($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio->toIso8601String(),
                'end' => $evento->fecha_fin ? $evento->fecha_fin->toIso8601String() : null,
                'tipo_evento' => $evento->tipo_evento,
                'extendedProps' => [
                    'iglesia' => $evento->iglesia->nombre ?? null,
                    'direccion_evento' => $evento->direccion_evento,
                    'latitud' => $evento->latitud,
                    'longitud' => $evento->longitud,
                    'estado' => $evento->estado,
                ],
            ];
        });

        return response()->json($result);
    }
}
