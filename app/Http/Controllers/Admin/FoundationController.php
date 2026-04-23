<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoundationRequest;
use App\Models\Foundation;
use App\Services\GeocoderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FoundationController extends Controller
{
    public function __construct(private readonly GeocoderService $geocoder) {}

    public function index(): View
    {
        $foundations = Foundation::latest()->paginate(15);

        return view('admin.foundations.index', [
            'foundations' => $foundations,
            'total'       => Foundation::count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.foundations.create', [
            'foundation' => new Foundation(),
        ]);
    }

    public function store(FoundationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('imagen_principal')) {
            $data['imagen_principal'] = $request->file('imagen_principal')->store('foundations', 'public');
        }

        $data = $this->autoGeocode($data);

        $foundation = Foundation::create($data);

        return redirect()
            ->route('admin.foundations.index')
            ->with('success', "Fundación «{$foundation->name}» registrada correctamente.");
    }

    public function edit(Foundation $foundation): View
    {
        return view('admin.foundations.edit', compact('foundation'));
    }

    public function update(FoundationRequest $request, Foundation $foundation): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('imagen_principal')) {
            // eliminar imagen anterior si existe
            if ($foundation->imagen_principal) {
                Storage::disk('public')->delete($foundation->imagen_principal);
            }
            $data['imagen_principal'] = $request->file('imagen_principal')->store('foundations', 'public');
        }

        $data = $this->autoGeocode($data);

        $foundation->update($data);

        return redirect()
            ->route('admin.foundations.index')
            ->with('success', "Fundación «{$foundation->name}» actualizada correctamente.");
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

    public function destroy(Foundation $foundation): RedirectResponse
    {
        $nombre = $foundation->name;
        if ($foundation->imagen_principal) {
            Storage::disk('public')->delete($foundation->imagen_principal);
        }
        $foundation->delete();

        return redirect()
            ->route('admin.foundations.index')
            ->with('success', "Fundación «{$nombre}» eliminada correctamente.");
    }
}
