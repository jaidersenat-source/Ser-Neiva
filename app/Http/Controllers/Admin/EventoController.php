<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Iglesia;
use App\Services\GeocoderService;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function __construct(private readonly GeocoderService $geocoder) {}

    public function index()
    {
        // Eliminar eventos pasados automáticamente (mismo comportamiento que en módulo Iglesia)
        $now = now();
        $oldEvents = Evento::where(function ($q) use ($now) {
            $q->whereNotNull('fecha_fin')->where('fecha_fin', '<', $now);
        })->orWhere(function ($q) use ($now) {
            $q->whereNull('fecha_fin')->whereNotNull('fecha_inicio')->where('fecha_inicio', '<', $now);
        })->get();

        // Borrar archivos asociados y luego los registros
        foreach ($oldEvents as $old) {
            if ($old->imagen_principal) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old->imagen_principal);
            }
            $old->delete();
        }

        $eventos = Evento::with('iglesia')->latest()->paginate(20);
        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        $iglesias = Iglesia::where('church_status', 'Active')
            ->select('id', 'official_name')
            ->orderBy('official_name')
            ->get();
        return view('admin.eventos.create', compact('iglesias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'iglesia_id'      => 'required|exists:iglesias,id',
            'titulo'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'fecha_inicio'    => 'required|date',
            'fecha_fin'       => 'nullable|date|after_or_equal:fecha_inicio',
            'direccion_evento'=> 'required|string|max:255',
            'latitud'         => 'nullable|numeric',
            'longitud'        => 'nullable|numeric',
            'tipo_evento'     => 'required|string|max:100',
            'estado'          => 'required|string|max:50',
            'imagen_principal'=> 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('imagen_principal')) {
            $data['imagen_principal'] = $request->file('imagen_principal')->store('eventos', 'public');
        }

        $data = $this->autoGeocode($data, $data['direccion_evento']);

        Evento::create($data);
        return redirect()->route('admin.eventos.index')->with('success', 'Evento creado correctamente.');
    }

    public function show(Evento $evento)
    {
        $evento->load('iglesia');
        return view('admin.eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        $iglesias = Iglesia::where('church_status', 'Active')
            ->select('id', 'official_name')
            ->orderBy('official_name')
            ->get();
        return view('admin.eventos.edit', compact('evento', 'iglesias'));
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'iglesia_id'      => 'required|exists:iglesias,id',
            'titulo'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string',
            'fecha_inicio'    => 'required|date',
            'fecha_fin'       => 'nullable|date|after_or_equal:fecha_inicio',
            'direccion_evento'=> 'required|string|max:255',
            'latitud'         => 'nullable|numeric',
            'longitud'        => 'nullable|numeric',
            'tipo_evento'     => 'required|string|max:100',
            'estado'          => 'required|string|max:50',
            'imagen_principal'=> 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('imagen_principal')) {
            if ($evento->imagen_principal) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($evento->imagen_principal);
            }
            $data['imagen_principal'] = $request->file('imagen_principal')->store('eventos', 'public');
        }

        $data = $this->autoGeocode($data, $data['direccion_evento']);

        $evento->update($data);
        return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    private function autoGeocode(array $data, string $direccion): array
    {
        $lat = $data['latitud'] ?? null;
        $lng = $data['longitud'] ?? null;
        $neiva = [2.9274, -75.2819];
        $isEmpty = empty($lat) || empty($lng)
            || (abs((float)$lat - $neiva[0]) < 0.0001 && abs((float)$lng - $neiva[1]) < 0.0001);
        if ($isEmpty && !empty($direccion)) {
            $result = $this->geocoder->geocode($direccion, 'Neiva', 'Huila');
            if ($result && $this->geocoder->isAcceptable($result)) {
                $data['latitud']  = $result['lat'];
                $data['longitud'] = $result['lng'];
            }
        }
        return $data;
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado correctamente.');
    }

    public function calendar()
    {
        $iglesias = Iglesia::where('church_status', 'Active')
            ->select('id', 'official_name')
            ->orderBy('official_name')
            ->get();
        $tiposEvento = ['retiro', 'conferencia', 'culto', 'campamento', 'otro'];
        return view('admin.eventos.calendar', [
            'iglesias' => $iglesias,
            'tiposEvento' => $tiposEvento
        ]);
    }
}
