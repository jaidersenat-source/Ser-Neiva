<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SportsVenue;
use Illuminate\Http\JsonResponse;

class SportsVenueApiController extends Controller
{
    public function index(): JsonResponse
    {
        $venues = SportsVenue::select([
                'id', 'name', 'address', 'latitude', 'longitude',
                'contact', 'available_for_churches',
            ])
            ->get()
            ->map(fn($v) => [
                'id'                     => $v->id,
                'name'                   => $v->name,
                'address'                => $v->address,
                'latitude'               => (float) $v->latitude,
                'longitude'              => (float) $v->longitude,
                'contact'                => $v->contact,
                'available_for_churches' => (bool) $v->available_for_churches,
            ]);

        return response()->json(['success' => true, 'data' => $venues]);
    }
}
