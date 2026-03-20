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
        $query = Iglesia::where('church_status', 'Active');

        if ($request->filled('denominacion')) {
            $query->where('denomination', $request->denominacion);
        }

        if ($request->filled('municipality')) {
            $query->where('municipality', $request->municipality);
        }

        if ($request->filled('comuna')) {
            $query->where('comuna', $request->comuna);
        }

        $iglesias = $query
            ->select([
                'id', 'official_name', 'denomination',
                'address', 'municipality', 'department',
                'comuna', 'latitud', 'longitud',
                'pastor_full_name', 'phone_mobile', 'phone_landline',
                'email', 'correo_institucional', 'pastor_email', 'photo', 'pastor_birth_date',
                'schedule_weekdays', 'schedule_weekends',
            ])
            ->get()
            ->map(fn($i) => [
                'id'                     => $i->id,
                'nombre'                 => $i->official_name,
                'denominacion'           => $i->denomination,
                'direccion'              => $i->address,
                'municipality'           => $i->municipality,
                'department'             => $i->department ?: 'Huila',
                'comuna'                 => $i->comuna,
                'latitud'                => (float) $i->latitud,
                'longitud'               => (float) $i->longitud,
                'pastor_sacerdote'       => $i->pastor_full_name,
                'telefono'               => $i->phone_landline ?: $i->phone_mobile,
                'celular_institucional'  => $i->phone_mobile,
                'correo_institucional'   => $i->correo_institucional ?: $i->pastor_email ?: $i->email,
                'schedule_weekdays'      => $i->schedule_weekdays,
                'schedule_weekends'      => $i->schedule_weekends,
                'foto_url'               => $i->photo ? asset('storage/' . $i->photo) : null,
                'pastor_birth_date'      => $i->pastor_birth_date
                    ? $i->pastor_birth_date->format('Y-m-d')
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
        if ($iglesia->church_status !== 'Active') {
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $iglesia->only([
            'id', 'official_name', 'denomination', 'confessional_character',
            'address', 'neighborhood', 'municipality', 'comuna', 'city',
            'department', 'country', 'latitud', 'longitud',
            'pastor_full_name', 'phone_mobile', 'phone_landline',
            'email', 'correo_institucional', 'pastor_email', 'photo',
            'schedule_weekdays', 'schedule_weekends', 'approx_members',
        ])]);
    }
}