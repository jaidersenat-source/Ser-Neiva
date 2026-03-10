<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Iglesia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IglesiaApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Iglesia::where('estado', 'activo');

        if ($request->filled('denominacion')) {
            $query->where('denominacion', $request->denominacion);
        }

        if ($request->filled('comuna')) {
            $query->where('comuna', $request->comuna);
        }

        $iglesias = $query
            ->select([
                'id', 'nombre', 'denominacion', 'direccion',
                'comuna', 'latitud', 'longitud',
                'pastor_sacerdote', 'telefono', 'email', 'descripcion',
                'fecha_nacimiento_lider',
            ])
            ->get()
            ->map(fn($i) => [
                'id'               => $i->id,
                'nombre'           => $i->nombre,
                'denominacion'     => $i->denominacion,
                'direccion'        => $i->direccion,
                'comuna'           => $i->comuna,
                'latitud'          => (float) $i->latitud,
                'longitud'         => (float) $i->longitud,
                'pastor_sacerdote' => $i->pastor_sacerdote,
                'telefono'         => $i->telefono,
                'email'            => $i->email,
                'descripcion'      => $i->descripcion,
                'fecha_nacimiento_lider' => $i->fecha_nacimiento_lider,
            ]);

        return response()->json([
            'success' => true,
            'total'   => $iglesias->count(),
            'data'    => $iglesias,
        ]);
    }

    public function show(Iglesia $iglesia): JsonResponse
    {
        if ($iglesia->estado !== 'activo') {
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $iglesia]);
    }
}