<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;

class EmprendimientoApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Emprendimiento::with('iglesia')->where('activo', true);

        // Opcional: filtrar por municipio/department si viene el parámetro
        if ($request->filled('municipio')) {
            $municipio = $request->get('municipio');
            $query->whereHas('iglesia', fn($q) => $q->where('municipality', $municipio));
        }

        $items = $query->get();

        $result = $items->map(function (Emprendimiento $e) {
            return [
                'id' => $e->id,
                'title' => $e->nombre,
                'latitud' => $e->latitud,
                'longitud' => $e->longitud,
                'direccion' => $e->direccion,
                'categoria' => $e->categoria,
                'telefono' => $e->telefono,
                'web' => $e->web,
                'horario' => $e->horario,
                'imagen_principal' => $e->imagen_principal ? asset('storage/' . $e->imagen_principal) : null,
                'iglesia' => $e->iglesia->official_name ?? null,
                'slug' => $e->slug,
                // derive whether likely sells food based on category/description/name
                'vende_comida' => (bool) preg_match('/\b(comida|restaurante|alimentos|comestible|caf[eé]|antojitos|desayuno|almuerzo|cena|snack|empanada|arepa|piqueo)\b/i', ($e->categoria.' '.$e->descripcion.' '.$e->nombre)),
            ];
        });

        return response()->json($result);
    }
}
