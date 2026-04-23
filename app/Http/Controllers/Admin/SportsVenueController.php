<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportsVenueRequest;
use App\Models\SportsVenue;
use App\Services\GeocoderService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SportsVenueController extends Controller
{
    public function __construct(private readonly GeocoderService $geocoder) {}

    public function index(): View
    {
        $venues = SportsVenue::latest()->paginate(15);

        return view('admin.sports_venues.index', [
            'venues' => $venues,
            'total'  => SportsVenue::count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.sports_venues.create', [
            'venue' => new SportsVenue(),
        ]);
    }

    public function store(SportsVenueRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['available_for_churches'] = $request->boolean('available_for_churches');

        if ($request->hasFile('imagen_principal')) {
            $path = $request->file('imagen_principal')->store('sports_venues', 'public');
            $data['imagen_principal'] = $path;
        }

        $data = $this->autoGeocode($data);

        SportsVenue::create($data);

        return redirect()
            ->route('admin.sports_venues.index')
            ->with('success', 'Escenario deportivo registrado correctamente.');
    }

    public function edit(SportsVenue $sports_venue): View
    {
        return view('admin.sports_venues.edit', [
            'venue' => $sports_venue,
        ]);
    }

    public function update(SportsVenueRequest $request, SportsVenue $sports_venue): RedirectResponse
    {
        $data = $request->validated();
        $data['available_for_churches'] = $request->boolean('available_for_churches');

        if ($request->hasFile('imagen_principal')) {
            // Eliminar imagen previa si existe
            if ($sports_venue->imagen_principal) {
                Storage::disk('public')->delete($sports_venue->imagen_principal);
            }
            $path = $request->file('imagen_principal')->store('sports_venues', 'public');
            $data['imagen_principal'] = $path;
        }

        $data = $this->autoGeocode($data);

        $sports_venue->update($data);

        return redirect()
            ->route('admin.sports_venues.index')
            ->with('success', "Escenario «{$sports_venue->name}» actualizado correctamente.");
    }

    private function autoGeocode(array $data): array
    {
        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;
        $neiva = [2.9274, -75.2819];
        $isEmpty = empty($lat) || empty($lng)
            || (abs((float)$lat - $neiva[0]) < 0.0001 && abs((float)$lng - $neiva[1]) < 0.0001);
        if ($isEmpty && !empty($data['address'] ?? '')) {
            $result = $this->geocoder->geocode($data['address'], 'Neiva', 'Huila');
            if ($result && $this->geocoder->isAcceptable($result)) {
                $data['latitude']  = $result['lat'];
                $data['longitude'] = $result['lng'];
            }
        }
        return $data;
    }

    public function destroy(SportsVenue $sports_venue): RedirectResponse
    {
        $nombre = $sports_venue->name;
        $sports_venue->delete();

        return redirect()
            ->route('admin.sports_venues.index')
            ->with('success', "Escenario «{$nombre}» eliminado correctamente.");
    }
}
