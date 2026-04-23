<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeocoderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * GeocoderController
 *
 * Actúa como proxy entre el cliente (Leaflet form) y el servicio de geocoding.
 * La API key de Google nunca se expone al cliente.
 */
class GeocoderController extends Controller
{
    public function __construct(private readonly GeocoderService $geocoder) {}

    /**
     * POST /api/geocode
     * Convierte una dirección a coordenadas (lat/lng) con metadatos de precisión.
     */
    public function geocode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'address'      => ['required', 'string', 'min:4', 'max:300'],
            'municipality' => ['nullable', 'string', 'max:120'],
            'department'   => ['nullable', 'string', 'max:80'],
        ]);

        $result = $this->geocoder->geocode(
            $validated['address'],
            $validated['municipality'] ?? 'Neiva',
            $validated['department']   ?? 'Huila',
        );

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la dirección. Intenta ser más específico o agrega el municipio.',
            ], 422);
        }

        if (!$result['in_colombia']) {
            return response()->json([
                'success' => false,
                'message' => 'La ubicación encontrada está fuera de Colombia. Verifica la dirección.',
            ], 422);
        }

        // Generar advertencia según nivel de precisión
        $warning = match ($result['precision']) {
            'approximate' => 'Precisión baja: la dirección es aproximada. Ajusta manualmente el marcador si es necesario.',
            'center'      => 'Precisión media: se encontró el área pero no la dirección exacta.',
            'interpolated' => 'Precisión media-alta: interpolación entre números de calle. Verifica el marcador.',
            default       => null,
        };

        return response()->json([
            'success'    => true,
            'lat'        => $result['lat'],
            'lng'        => $result['lng'],
            'precision'  => $result['precision'],   // exact|interpolated|center|approximate
            'type'       => $result['location_type'],
            'warning'    => $warning,
            'formatted'  => $result['formatted_address'],
            'normalized' => $result['normalized_address'],
            'in_huila'   => $result['in_huila'],
            'provider'   => $result['provider'],
        ]);
    }

    /**
     * POST /api/geocode/reverse
     * Convierte coordenadas (lat/lng) a dirección aproximada.
     */
    public function reverseGeocode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $lat = (float) $validated['lat'];
        $lng = (float) $validated['lng'];

        // Validar bounding box antes de llamar al servicio externo
        if (!$this->geocoder->isInColombia($lat, $lng)) {
            return response()->json([
                'success' => false,
                'message' => 'Las coordenadas están fuera de Colombia.',
            ], 422);
        }

        $result = $this->geocoder->reverseGeocode($lat, $lng);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo obtener la dirección para estas coordenadas.',
            ], 422);
        }

        return response()->json(['success' => true, ...$result]);
    }
}
