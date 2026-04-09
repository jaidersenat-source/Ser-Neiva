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
                'iglesia'          => $evento->iglesia->official_name ?? null,
                'tipo_evento'      => $evento->tipo_evento,
                'direccion_evento' => $evento->direccion_evento,
                'estado'           => $evento->estado,
                'imagen_principal' => $evento->imagen_principal ? asset('storage/' . $evento->imagen_principal) : null,
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
        $eventos = Evento::with('iglesia')->where('estado', 'activo')->get();

        // Adaptar formato para FullCalendar
        $result = $eventos->map(function($evento) {
            // Normalizar a la zona adecuada (si app.timezone es UTC usamos America/Bogota)
            $tz = config('app.timezone') === 'UTC' ? 'America/Bogota' : config('app.timezone');
            return [
                'id' => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->fecha_inicio ? $evento->fecha_inicio->setTimezone($tz)->toIso8601String() : null,
                'end' => $evento->fecha_fin ? $evento->fecha_fin->setTimezone($tz)->toIso8601String() : null,
                'start_ts' => $evento->fecha_inicio ? $evento->fecha_inicio->setTimezone($tz)->getTimestamp() * 1000 : null,
                'end_ts' => $evento->fecha_fin ? $evento->fecha_fin->setTimezone($tz)->getTimestamp() * 1000 : null,
                'tipo_evento' => $evento->tipo_evento,
                'extendedProps' => [
                    'iglesia' => $evento->iglesia->official_name ?? null,
                    'direccion_evento' => $evento->direccion_evento,
                    'latitud' => $evento->latitud,
                    'longitud' => $evento->longitud,
                    'estado' => $evento->estado,
                    'imagen_principal' => $evento->imagen_principal ? asset('storage/' . $evento->imagen_principal) : null,
                ],
            ];
        });

        return response()->json($result);
    }
}
