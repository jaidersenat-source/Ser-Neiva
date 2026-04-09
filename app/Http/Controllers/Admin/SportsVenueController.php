<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportsVenueRequest;
use App\Models\SportsVenue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SportsVenueController extends Controller
{
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

        $sports_venue->update($data);

        return redirect()
            ->route('admin.sports_venues.index')
            ->with('success', "Escenario «{$sports_venue->name}» actualizado correctamente.");
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
