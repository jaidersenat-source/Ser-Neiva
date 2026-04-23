<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GeocoderService
 *
 * Geocodifica direcciones colombianas usando Google Geocoding API si hay
 * clave configurada, con Nominatim/OSM como fallback gratuito.
 * Incluye normalización de abreviaturas, validación de bounding box,
 * reverse geocoding y clasificación de precisión.
 */
class GeocoderService
{
    // ── Bounding boxes ──────────────────────────────────────────────
    const COLOMBIA_LAT_MIN =  1.0;
    const COLOMBIA_LAT_MAX = 13.0;
    const COLOMBIA_LNG_MIN = -79.0;
    const COLOMBIA_LNG_MAX = -66.0;

    const HUILA_LAT_MIN =  0.7;
    const HUILA_LAT_MAX =  3.6;
    const HUILA_LNG_MIN = -77.2;
    const HUILA_LNG_MAX = -74.5;

    const CACHE_TTL_HOURS = 24;

    // ── Geocodificar (forward) ───────────────────────────────────────
    /**
     * Convierte una dirección a coordenadas.
     * Retorna array con lat/lng y metadatos, o null si falla.
     */
    public function geocode(
        string $address,
        string $municipality = 'Neiva',
        string $department   = 'Huila',
        string $country      = 'Colombia'
    ): ?array {
        $normalized  = $this->normalizeAddress($address);
        $fullAddress = $this->buildFullAddress($normalized, $municipality, $department, $country);
        $cacheKey    = 'geocode_v1_' . md5(strtolower($fullAddress));

        return Cache::remember($cacheKey, now()->addHours(self::CACHE_TTL_HOURS), function () use ($fullAddress, $normalized, $address) {
            $googleKey = config('services.google.maps_key');

            if ($googleKey) {
                $result = $this->geocodeWithGoogle($fullAddress, $normalized, $address);
                if ($result) return $result;
                Log::info('GeocoderService: Google falló, usando Nominatim como fallback', ['address' => $fullAddress]);
            }

            return $this->geocodeWithNominatim($fullAddress, $address);
        });
    }

    // ── Normalización de direcciones colombianas ─────────────────────
    /**
     * Expande abreviaturas típicas de Neiva/Huila antes de enviar al geocoder.
     * Ej: "cll 70 N 22A-06 villa maria" → "Calle 70 # 22A-06 Villa Maria"
     */
    public function normalizeAddress(string $address): string
    {
        // Reemplazos de abreviaturas (orden importa: más específicos primero)
        $patterns = [
            // Vías
            '/\bav(?:da)?\.?\s+cll\b/i'       => 'Avenida Calle',
            '/\bav(?:da)?\.?\s+cra\b/i'        => 'Avenida Carrera',
            '/\bav(?:da)?\.?\s+cr?\.?\b/i'     => 'Avenida Carrera',
            '/\bav(?:da)?\.?\b/i'              => 'Avenida',
            '/\bcll?\.?\b/i'                   => 'Calle',
            '/\bcr(?:a)?\.?\b/i'               => 'Carrera',
            '/\bdiag\.?\b/i'                   => 'Diagonal',
            '/\btrans?v?\.?\b/i'               => 'Transversal',
            '/\bcq\.?\b/i'                     => 'Circular',
            '/\bmz\.?\b/i'                     => 'Manzana',
            '/\blte?\.?\b/i'                   => 'Lote',
            '/\bkm\.?\b/i'                     => 'Kilómetro',
            // Complementos
            '/\bapto?\.?\b/i'                  => 'Apartamento',
            '/\bloc\.?\b/i'                    => 'Local',
            '/\burb\.?\b/i'                    => 'Urbanización',
            '/\bbarr?\.?\b/i'                  => 'Barrio',
            '/\bint\.?\b/i'                    => 'Interior',
            '/\bcons?\.?\b/i'                  => 'Consultorio',
            // Número: "N " o "No. " o "#" antes de número → "# "
            '/\bN(?:ro?|o)?\.?\s+(?=\d)/i'    => '# ',
            '/\s*#\s*/'                         => ' # ',
        ];

        $result = $address;
        foreach ($patterns as $pattern => $replacement) {
            $result = preg_replace($pattern, $replacement, $result);
        }

        // Capitalizar
        $result = mb_convert_case(mb_strtolower(trim($result)), MB_CASE_TITLE, 'UTF-8');

        // Normalizar espacios múltiples
        $result = preg_replace('/\s+/', ' ', $result);

        // Asegurarse que # quede bien formateado
        $result = preg_replace('/\s*#\s*/', ' # ', $result);

        return trim($result);
    }

    private function buildFullAddress(string $normalized, string $municipality, string $department, string $country): string
    {
        $parts = array_filter([$normalized, $municipality ?: 'Neiva', $department, $country]);
        return implode(', ', $parts);
    }

    // ── Google Geocoding ─────────────────────────────────────────────
    private function geocodeWithGoogle(string $fullAddress, string $normalized, string $originalAddress): ?array
    {
        try {
            $response = Http::timeout(8)->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address'  => $fullAddress,
                'key'      => config('services.google.maps_key'),
                'language' => 'es',
                'region'   => 'co',
            ]);

            if (!$response->ok()) {
                Log::warning('GeocoderService: Google HTTP error', ['status' => $response->status()]);
                return null;
            }

            $data = $response->json();

            if (($data['status'] ?? '') !== 'OK' || empty($data['results'])) {
                Log::info('GeocoderService: Google sin resultados', [
                    'status'  => $data['status'] ?? 'unknown',
                    'address' => $fullAddress,
                ]);
                return null;
            }

            $result   = $data['results'][0];
            $location = $result['geometry']['location'];
            $locType  = $result['geometry']['location_type'] ?? 'UNKNOWN';
            $lat      = (float) $location['lat'];
            $lng      = (float) $location['lng'];

            return [
                'lat'                => $lat,
                'lng'                => $lng,
                'location_type'      => $locType,
                'precision'          => $this->classifyPrecision($locType),
                'in_colombia'        => $this->isInColombia($lat, $lng),
                'in_huila'           => $this->isInHuila($lat, $lng),
                'formatted_address'  => $result['formatted_address'] ?? $fullAddress,
                'provider'           => 'google',
                'original_address'   => $originalAddress,
                'normalized_address' => $normalized,
            ];
        } catch (\Throwable $e) {
            Log::error('GeocoderService: Google exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    // ── Nominatim (OSM) fallback ─────────────────────────────────────
    private function geocodeWithNominatim(string $fullAddress, string $originalAddress): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'SIRNNeiva/1.0 (contacto@serneiva.org)'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q'               => $fullAddress,
                    'format'          => 'json',
                    'limit'           => 1,
                    'countrycodes'    => 'co',
                    'accept-language' => 'es',
                    'addressdetails'  => 1,
                ]);

            if (!$response->ok()) return null;

            $data = $response->json();
            if (empty($data)) return null;

            $place   = $data[0];
            $lat     = (float) $place['lat'];
            $lng     = (float) $place['lon'];
            $osmType = $place['type'] ?? '';

            // Inferir precisión desde el tipo OSM
            $locType = match (true) {
                in_array($osmType, ['house', 'building', 'place_of_worship']) => 'ROOFTOP',
                in_array($osmType, ['road', 'residential', 'tertiary', 'secondary', 'primary']) => 'RANGE_INTERPOLATED',
                default => 'APPROXIMATE',
            };

            return [
                'lat'                => $lat,
                'lng'                => $lng,
                'location_type'      => $locType,
                'precision'          => $this->classifyPrecision($locType),
                'in_colombia'        => $this->isInColombia($lat, $lng),
                'in_huila'           => $this->isInHuila($lat, $lng),
                'formatted_address'  => $place['display_name'] ?? $fullAddress,
                'provider'           => 'nominatim',
                'original_address'   => $originalAddress,
                'normalized_address' => $originalAddress,
            ];
        } catch (\Throwable $e) {
            Log::error('GeocoderService: Nominatim exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    // ── Reverse geocoding ────────────────────────────────────────────
    /**
     * Convierte coordenadas a dirección aproximada.
     */
    public function reverseGeocode(float $lat, float $lng): ?array
    {
        if (config('services.google.maps_key')) {
            $result = $this->reverseGeocodeGoogle($lat, $lng);
            if ($result) return $result;
        }

        return $this->reverseGeocodeNominatim($lat, $lng);
    }

    private function reverseGeocodeGoogle(float $lat, float $lng): ?array
    {
        try {
            $response = Http::timeout(8)->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'latlng'   => "{$lat},{$lng}",
                'key'      => config('services.google.maps_key'),
                'language' => 'es',
            ]);

            if (!$response->ok()) return null;

            $data = $response->json();
            if (($data['status'] ?? '') !== 'OK' || empty($data['results'])) return null;

            $result     = $data['results'][0];
            $components = $this->extractGoogleComponents($result['address_components'] ?? []);

            return [
                'formatted_address' => $result['formatted_address'] ?? '',
                'route'             => $components['route'] ?? '',
                'street_number'     => $components['street_number'] ?? '',
                'neighborhood'      => $components['neighborhood'] ?? $components['sublocality'] ?? $components['sublocality_level_1'] ?? '',
                'city'              => $components['locality'] ?? '',
                'municipality'      => $components['administrative_area_level_2'] ?? '',
                'department'        => $components['administrative_area_level_1'] ?? '',
                'country'           => $components['country'] ?? '',
                'provider'          => 'google',
            ];
        } catch (\Throwable $e) {
            Log::error('GeocoderService: Google reverse exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    private function reverseGeocodeNominatim(float $lat, float $lng): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'SIRNNeiva/1.0 (contacto@serneiva.org)'])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat'             => $lat,
                    'lon'             => $lng,
                    'format'          => 'json',
                    'accept-language' => 'es',
                    'addressdetails'  => 1,
                ]);

            if (!$response->ok()) return null;

            $data = $response->json();
            if (empty($data['address'])) return null;

            $a = $data['address'];

            return [
                'formatted_address' => $data['display_name'] ?? '',
                'route'             => $a['road'] ?? $a['pedestrian'] ?? '',
                'street_number'     => $a['house_number'] ?? '',
                'neighborhood'      => $a['suburb'] ?? $a['neighbourhood'] ?? '',
                'city'              => $a['city'] ?? $a['town'] ?? $a['village'] ?? '',
                'municipality'      => $a['county'] ?? '',
                'department'        => $a['state'] ?? '',
                'country'           => $a['country'] ?? '',
                'provider'          => 'nominatim',
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    // ── Utilidades ───────────────────────────────────────────────────
    private function extractGoogleComponents(array $components): array
    {
        $result = [];
        foreach ($components as $comp) {
            foreach ($comp['types'] ?? [] as $type) {
                $result[$type] = $comp['long_name'];
            }
        }
        return $result;
    }

    private function classifyPrecision(string $locationType): string
    {
        return match ($locationType) {
            'ROOFTOP'            => 'exact',
            'RANGE_INTERPOLATED' => 'interpolated',
            'GEOMETRIC_CENTER'   => 'center',
            default              => 'approximate',
        };
    }

    public function isInColombia(float $lat, float $lng): bool
    {
        return $lat >= self::COLOMBIA_LAT_MIN && $lat <= self::COLOMBIA_LAT_MAX
            && $lng >= self::COLOMBIA_LNG_MIN && $lng <= self::COLOMBIA_LNG_MAX;
    }

    public function isInHuila(float $lat, float $lng): bool
    {
        return $lat >= self::HUILA_LAT_MIN && $lat <= self::HUILA_LAT_MAX
            && $lng >= self::HUILA_LNG_MIN && $lng <= self::HUILA_LNG_MAX;
    }

    /**
     * Determina si el resultado es suficientemente preciso para guardarse automáticamente.
     */
    public function isAcceptable(?array $result): bool
    {
        if (!$result) return false;
        if (!$result['in_colombia']) return false;
        return in_array($result['precision'], ['exact', 'interpolated', 'center']);
    }
}
