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
        $query = Iglesia::where(function ($q) {
            $q->where('estado', 'activo')
              ->orWhere('church_status', 'Activo');
        });

        if ($request->filled('denominacion')) {
            $query->where(function ($q) use ($request) {
                $q->where('denominacion', $request->denominacion)
                  ->orWhere('denomination', $request->denominacion);
            });
        }

        if ($request->filled('municipality')) {
            $query->where('municipality', $request->municipality);
        }

        if ($request->filled('comuna')) {
            $query->where('comuna', $request->comuna);
        }

        $iglesias = $query
            ->select([
                'id', 'nombre', 'official_name',
                'denominacion', 'denomination',
                'direccion', 'address',
                'municipality', 'department',
                'comuna', 'latitud', 'longitud',
                'pastor_sacerdote', 'pastor_full_name',
                'telefono', 'phone_mobile', 'phone_landline',
                'email', 'correo_institucional',
                'celular_institucional', 'photo',
                'fecha_nacimiento_lider', 'pastor_birth_date',
                'schedule_weekdays', 'schedule_weekends',
            ])
            ->get()
            ->map(fn($i) => [
                'id'                     => $i->id,
                'nombre'                 => $i->official_name ?: $i->nombre,
                'denominacion'           => $i->denomination  ?: $i->denominacion,
                'direccion'              => $i->address       ?: $i->direccion,
                'municipality'           => $i->municipality,
                'department'             => $i->department    ?: 'Huila',
                'comuna'                 => $i->comuna,
                'latitud'                => (float) $i->latitud,
                'longitud'               => (float) $i->longitud,
                'pastor_sacerdote'       => $i->pastor_full_name ?: $i->pastor_sacerdote,
                'telefono'               => $i->phone_landline  ?: $i->phone_mobile ?: $i->telefono,
                'celular_institucional'  => $i->phone_mobile    ?: $i->celular_institucional,
                'correo_institucional'   => $i->correo_institucional ?: $i->email,
                'schedule_weekdays'      => $i->schedule_weekdays,
                'schedule_weekends'      => $i->schedule_weekends,
                'foto_url'               => $i->photo ? asset('storage/' . $i->photo) : null,
                'fecha_nacimiento_lider' => $i->fecha_nacimiento_lider
                    ? $i->fecha_nacimiento_lider->format('Y-m-d')
                    : null,
                'pastor_birth_date'      => $i->pastor_birth_date
                    ? \Carbon\Carbon::parse($i->pastor_birth_date)->format('Y-m-d')
                    : null,
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