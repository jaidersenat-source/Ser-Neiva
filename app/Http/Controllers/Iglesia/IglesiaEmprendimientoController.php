<?php

namespace App\Http\Controllers\Iglesia;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class IglesiaEmprendimientoController extends Controller
{
    private function iglesiaId(): int
    {
        return auth()->user()->iglesia_id;
    }

    public function index(): View
    {
        $emprendimientos = Emprendimiento::where('iglesia_id', $this->iglesiaId())
                                         ->latest()
                                         ->paginate(15);

        return view('iglesia.emprendimientos.index', compact('emprendimientos'));
    }

    public function create(): View
    {
        return view('iglesia.emprendimientos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'categoria'   => ['nullable', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'direccion'   => ['nullable', 'string', 'max:255'],
            'telefono'    => ['nullable', 'string', 'max:30'],
            'email'      => ['nullable', 'email', 'max:255'],
            'horario'     => ['nullable', 'string', 'max:255'],
            'web'         => ['nullable', 'url', 'max:255'],
            'latitud'     => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'    => ['nullable', 'numeric', 'between:-180,180'],
            'imagen_principal' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['iglesia_id'] = $this->iglesiaId();
        $data['slug']       = $this->uniqueSlug($data['nombre']);

        if ($request->hasFile('imagen_principal')) {
            $data['imagen_principal'] = $request->file('imagen_principal')
                ->store('emprendimientos', 'public');
        }

        Emprendimiento::create($data);

        return redirect()->route('iglesia.emprendimientos.index')
                         ->with('success', 'Emprendimiento creado.');
    }

    public function edit(Emprendimiento $emprendimiento): View
    {
        abort_unless($emprendimiento->iglesia_id === $this->iglesiaId(), 403);

        return view('iglesia.emprendimientos.edit', compact('emprendimiento'));
    }

    public function show(Emprendimiento $emprendimiento): View
    {
        abort_unless($emprendimiento->iglesia_id === $this->iglesiaId(), 403);

        return view('iglesia.emprendimientos.show', compact('emprendimiento'));
    }

    public function update(Request $request, Emprendimiento $emprendimiento): RedirectResponse
    {
        abort_unless($emprendimiento->iglesia_id === $this->iglesiaId(), 403);

        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'categoria'   => ['nullable', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'direccion'   => ['nullable', 'string', 'max:255'],
            'telefono'    => ['nullable', 'string', 'max:30'],
            'email'      => ['nullable', 'email', 'max:255'],
            'horario'     => ['nullable', 'string', 'max:255'],
            'web'         => ['nullable', 'url', 'max:255'],
            'latitud'     => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'    => ['nullable', 'numeric', 'between:-180,180'],
            'imagen_principal' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('imagen_principal')) {
            if ($emprendimiento->imagen_principal) {
                Storage::disk('public')->delete($emprendimiento->imagen_principal);
            }
            $data['imagen_principal'] = $request->file('imagen_principal')
                ->store('emprendimientos', 'public');
        }

        $emprendimiento->update($data);

        return redirect()->route('iglesia.emprendimientos.index')
                         ->with('success', 'Emprendimiento actualizado.');
    }

    public function destroy(Emprendimiento $emprendimiento): RedirectResponse
    {
        abort_unless($emprendimiento->iglesia_id === $this->iglesiaId(), 403);

        if ($emprendimiento->imagen_principal) {
            Storage::disk('public')->delete($emprendimiento->imagen_principal);
        }
        $emprendimiento->delete();

        return redirect()->route('iglesia.emprendimientos.index')
                         ->with('success', 'Emprendimiento eliminado.');
    }

    private function uniqueSlug(string $nombre): string
    {
        $base = Str::slug($nombre);
        $slug = $base;
        $i    = 2;
        while (Emprendimiento::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}
