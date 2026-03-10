<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Iglesia;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with('iglesia')->latest()->paginate(20);
        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        $iglesias = Iglesia::orderBy('nombre')->get();
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
            'latitud'         => 'required|numeric',
            'longitud'        => 'required|numeric',
            'tipo_evento'     => 'required|string|max:100',
            'estado'          => 'required|string|max:50',
        ]);
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
        $iglesias = Iglesia::orderBy('nombre')->get();
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
            'latitud'         => 'required|numeric',
            'longitud'        => 'required|numeric',
            'tipo_evento'     => 'required|string|max:100',
            'estado'          => 'required|string|max:50',
        ]);
        $evento->update($data);
        return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado correctamente.');
    }

    public function calendar()
    {
        $iglesias = \App\Models\Iglesia::orderBy('nombre')->get();
        $tiposEvento = ['retiro', 'conferencia', 'culto', 'campamento', 'otro'];
        return view('admin.eventos.calendar', [
            'iglesias' => $iglesias,
            'tiposEvento' => $tiposEvento
        ]);
    }
}
