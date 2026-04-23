<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use App\Models\Iglesia;
use App\Services\GeocoderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EmprendimientoController extends Controller
{
    public function __construct(private readonly GeocoderService $geocoder) {}

    public function index()
    {
        $emprendimientos = Emprendimiento::with('iglesia')->latest()->paginate(20);
        return view('admin.emprendimientos.index', compact('emprendimientos'));
    }

    public function create()
    {
        $iglesias = Iglesia::where('church_status', 'Active')
            ->select('id', 'official_name')
            ->orderBy('official_name')
            ->get();
        $baseCategorias = ['Alimentos','Restaurante','Salud','Belleza','Hogar','Construcción','Otro'];
        return view('admin.emprendimientos.create', compact('iglesias','baseCategorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'iglesia_id'      => 'nullable|exists:iglesias,id',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'horario'         => 'nullable|string|max:255',
            'categoria'       => 'required|string|max:150',
            'otra_categoria'  => 'nullable|string|max:150',
            'telefono'        => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:191',
            'direccion'       => 'nullable|string|max:255',
            'latitud'         => 'nullable|numeric|between:-90,90',
            'web'             => 'nullable|url|max:255',
            'longitud'        => 'nullable|numeric|between:-180,180',
            'imagen_principal'=> 'nullable|image|max:2048',
            'activo'          => 'nullable|boolean',
            'verificado'      => 'nullable|boolean',
        ]);

        if (($data['categoria'] ?? '') === 'Otro' && !empty($data['otra_categoria'])) {
            $data['categoria'] = $data['otra_categoria'];
        }
        unset($data['otra_categoria']);

        if ($request->hasFile('imagen_principal')) {
            $path = $request->file('imagen_principal')->store('emprendimientos', 'public');
            $data['imagen_principal'] = $path;
        }
        // Auto-geocode if coordinates empty
        $data = $this->autoGeocode($data);
        // Normalize lat/lng to floats or null
        $data['latitud'] = isset($data['latitud']) && $data['latitud'] !== null && $data['latitud'] !== '' ? (float) $data['latitud'] : null;
        $data['longitud'] = isset($data['longitud']) && $data['longitud'] !== null && $data['longitud'] !== '' ? (float) $data['longitud'] : null;

        // Generate unique slug
        $slug = $this->generateUniqueSlug($data['nombre']);
        $data['slug'] = $slug;

        Emprendimiento::create($data);
        return redirect()->route('admin.emprendimientos.index')->with('success', 'Emprendimiento creado correctamente.');
    }

    public function show(Emprendimiento $emprendimiento)
    {
        $emprendimiento->load('iglesia');
        return view('admin.emprendimientos.show', compact('emprendimiento'));
    }

    public function edit(Emprendimiento $emprendimiento)
    {
        $iglesias = Iglesia::where('church_status', 'Active')
            ->select('id', 'official_name')
            ->orderBy('official_name')
            ->get();
        $baseCategorias = ['Alimentos','Restaurante','Salud','Belleza','Hogar','Construcción','Otro'];
        return view('admin.emprendimientos.edit', compact('emprendimiento','iglesias','baseCategorias'));
    }

    public function update(Request $request, Emprendimiento $emprendimiento)
    {
        $data = $request->validate([
            'iglesia_id'      => 'nullable|exists:iglesias,id',
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'horario'         => 'nullable|string|max:255',
            'categoria'       => 'required|string|max:150',
            'otra_categoria'  => 'nullable|string|max:150',
            'telefono'        => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:191',
            'direccion'       => 'nullable|string|max:255',
            'latitud'         => 'nullable|numeric|between:-90,90',
            'web'             => 'nullable|url|max:255',
            'longitud'        => 'nullable|numeric|between:-180,180',
            'imagen_principal'=> 'nullable|image|max:2048',
            'activo'          => 'nullable|boolean',
            'verificado'      => 'nullable|boolean',
        ]);

        if (($data['categoria'] ?? '') === 'Otro' && !empty($data['otra_categoria'])) {
            $data['categoria'] = $data['otra_categoria'];
        }
        unset($data['otra_categoria']);

        if ($request->hasFile('imagen_principal')) {
            // eliminar anterior si existe
            if ($emprendimiento->imagen_principal) {
                Storage::disk('public')->delete($emprendimiento->imagen_principal);
            }
            $path = $request->file('imagen_principal')->store('emprendimientos', 'public');
            $data['imagen_principal'] = $path;
        }

        // actualizar slug si cambia el nombre
        if (!empty($data['nombre']) && $data['nombre'] !== $emprendimiento->nombre) {
            $data['slug'] = $this->generateUniqueSlug($data['nombre'], $emprendimiento->id);
        }

        // Auto-geocode if coordinates empty
        $data = $this->autoGeocode($data);
        // Normalize lat/lng to floats or null
        $data['latitud'] = isset($data['latitud']) && $data['latitud'] !== null && $data['latitud'] !== '' ? (float) $data['latitud'] : null;
        $data['longitud'] = isset($data['longitud']) && $data['longitud'] !== null && $data['longitud'] !== '' ? (float) $data['longitud'] : null;

        $emprendimiento->update($data);
        return redirect()->route('admin.emprendimientos.index')->with('success', 'Emprendimiento actualizado correctamente.');
    }

    private function autoGeocode(array $data): array
    {
        $lat = $data['latitud'] ?? null;
        $lng = $data['longitud'] ?? null;
        $neiva = [2.9274, -75.2819];
        $isEmpty = ($lat === null || $lat === '' || $lat === 0)
            || ($lng === null || $lng === '' || $lng === 0)
            || (abs((float)$lat - $neiva[0]) < 0.0001 && abs((float)$lng - $neiva[1]) < 0.0001);
        if ($isEmpty && !empty($data['direccion'] ?? '')) {
            $result = $this->geocoder->geocode($data['direccion'], 'Neiva', 'Huila');
            if ($result && $this->geocoder->isAcceptable($result)) {
                $data['latitud']  = $result['lat'];
                $data['longitud'] = $result['lng'];
            }
        }
        return $data;
    }

    /**
     * Generate a unique slug for the emprendimiento.
     */
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (Emprendimiento::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function destroy(Emprendimiento $emprendimiento)
    {
        if ($emprendimiento->imagen_principal) {
            Storage::disk('public')->delete($emprendimiento->imagen_principal);
        }
        $emprendimiento->delete();
        return redirect()->route('admin.emprendimientos.index')->with('success', 'Emprendimiento eliminado correctamente.');
    }
}
