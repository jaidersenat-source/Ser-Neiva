<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foundation;
use Illuminate\Http\JsonResponse;

class FoundationApiController extends Controller
{
    public function index(): JsonResponse
    {
        $foundations = Foundation::select([
                'id', 'name', 'nit', 'representative',
                'phone', 'email', 'address', 'latitude', 'longitude', 'imagen_principal',
            ])
            ->get()
            ->map(fn($f) => [
                'id'             => $f->id,
                'name'           => $f->name,
                'nit'            => $f->nit,
                'representative' => $f->representative,
                'phone'          => $f->phone,
                'email'          => $f->email,
                'address'        => $f->address,
                'latitude'       => (float) $f->latitude,
                'longitude'      => (float) $f->longitude,
                'imagen_principal' => $f->imagen_principal ? asset('storage/' . $f->imagen_principal) : null,
            ]);

        return response()->json(['success' => true, 'data' => $foundations]);
    }
}
