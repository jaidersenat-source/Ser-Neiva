<?php

namespace App\Http\Controllers\Iglesia;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class IglesiaEventoController extends Controller
{
    private function iglesiaId(): int
    {
        return auth()->user()->iglesia_id;
    }

    public function index(): View
    {
        $eventos = Evento::where('iglesia_id', $this->iglesiaId())
                         ->latest()
                         ->paginate(15);

        return view('iglesia.eventos.index', compact('eventos'));
    }

    public function show(Evento $evento): View
    {
        abort_unless($evento->iglesia_id === $this->iglesiaId(), 403);

        return view('iglesia.eventos.show', compact('evento'));
    }

    public function create(): View
    {
        return view('iglesia.eventos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'titulo'           => ['required', 'string', 'max:255'],
            'tipo_evento'      => ['nullable', 'string', 'max:100'],
            'fecha_inicio'     => ['required', 'date'],
            'fecha_fin'        => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'direccion_evento' => ['nullable', 'string', 'max:255'],
            'estado'           => ['nullable', 'string', 'max:100'],
            'latitud'          => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'         => ['nullable', 'numeric', 'between:-180,180'],
            'descripcion'      => ['nullable', 'string'],
            'imagen_principal' => ['nullable', 'image', 'max:2048'],
        ]);

        // Siempre asignar la iglesia del usuario logueado
        $data['iglesia_id'] = $this->iglesiaId();

        if ($request->hasFile('imagen_principal')) {
            $data['imagen_principal'] = $request->file('imagen_principal')
                ->store('eventos', 'public');
        }

        Evento::create($data);

        return redirect()->route('iglesia.eventos.index')
                         ->with('success', 'Evento creado exitosamente.');
    }

    public function edit(Evento $evento): View
    {
        abort_unless($evento->iglesia_id === $this->iglesiaId(), 403);

        return view('iglesia.eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento): RedirectResponse
    {
        abort_unless($evento->iglesia_id === $this->iglesiaId(), 403);

        $data = $request->validate([
            'titulo'           => ['required', 'string', 'max:255'],
            'tipo_evento'      => ['nullable', 'string', 'max:100'],
            'fecha_inicio'     => ['required', 'date'],
            'fecha_fin'        => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'direccion_evento' => ['nullable', 'string', 'max:255'],
            'estado'           => ['nullable', 'string', 'max:100'],
            'latitud'          => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'         => ['nullable', 'numeric', 'between:-180,180'],
            'descripcion'      => ['nullable', 'string'],
            'imagen_principal' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('imagen_principal')) {
            if ($evento->imagen_principal) {
                Storage::disk('public')->delete($evento->imagen_principal);
            }
            $data['imagen_principal'] = $request->file('imagen_principal')
                ->store('eventos', 'public');
        }

        $evento->update($data);

        return redirect()->route('iglesia.eventos.index')
                         ->with('success', 'Evento actualizado.');
    }

    public function destroy(Evento $evento): RedirectResponse
    {
        abort_unless($evento->iglesia_id === $this->iglesiaId(), 403);

        $evento->delete();

        return redirect()->route('iglesia.eventos.index')
                         ->with('success', 'Evento eliminado.');
    }
}
