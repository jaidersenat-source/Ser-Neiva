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
                'phone', 'email', 'address', 'latitude', 'longitude',
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
            ]);

        return response()->json(['success' => true, 'data' => $foundations]);
    }
}
