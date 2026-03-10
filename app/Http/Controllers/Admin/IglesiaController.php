<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IglesiaRequest;
use App\Models\Ayuda;
use App\Models\Iglesia;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Imports\IglesiasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class IglesiaController extends Controller
{
    // ── Listado ───────────────────────────────────────────────
    public function index(): View
    {
        $iglesias = Iglesia::with('ayudas')       // eager loading evita N+1
                           ->latest()
                           ->paginate(15);

        return view('admin.iglesias.index', [
            'iglesias' => $iglesias,
            'total'    => Iglesia::count(),
            'activas'  => Iglesia::where('estado', 'activo')->count(),
        ]);
    }

    // ── Crear ─────────────────────────────────────────────────
    public function create(): View
    {
        return view('admin.iglesias.create', [
            'iglesia' => new Iglesia(),
            'ayudas'  => Ayuda::orderBy('nombre')->get(),
        ]);
    }

    // ── Guardar ───────────────────────────────────────────────
    public function store(IglesiaRequest $request): RedirectResponse
    {
        $iglesia = Iglesia::create($request->validated());

        // Sincronizar ayudas (attach con IDs del request)
        $iglesia->ayudas()->sync($request->ayudasIds());

        return redirect()
            ->route('admin.iglesias.index')
            ->with('success', "Iglesia «{$iglesia->nombre}» registrada correctamente.");
    }

    // ── Ver detalle ───────────────────────────────────────────
    public function show(Iglesia $iglesia): View
    {
        $iglesia->load('ayudas');

        return view('admin.iglesias.show', compact('iglesia'));
    }

    // ── Editar ────────────────────────────────────────────────
    public function edit(Iglesia $iglesia): View
    {
        $iglesia->load('ayudas');

        return view('admin.iglesias.edit', [
            'iglesia'        => $iglesia,
            'ayudas'         => Ayuda::orderBy('nombre')->get(),
            'ayudasActuales' => $iglesia->ayudas->pluck('id')->toArray(),
        ]);
    }

    // ── Actualizar ────────────────────────────────────────────
    public function update(IglesiaRequest $request, Iglesia $iglesia): RedirectResponse
    {
        $iglesia->update($request->validated());

        // sync() agrega las nuevas y elimina las que ya no están
        $iglesia->ayudas()->sync($request->ayudasIds());

        return redirect()
            ->route('admin.iglesias.show', $iglesia)
            ->with('success', "Iglesia «{$iglesia->nombre}» actualizada correctamente.");
    }

    // ── Eliminar ──────────────────────────────────────────────
    public function destroy(Iglesia $iglesia): RedirectResponse
    {
        $nombre = $iglesia->nombre;

        // Al eliminar la iglesia, el cascade borra las filas del pivote
        $iglesia->delete();

        return redirect()
            ->route('admin.iglesias.index')
            ->with('success', "Iglesia «{$nombre}» eliminada correctamente.");
    }

    public function import()
{
    return view('admin.iglesias.import');
}

public function importStore(Request $request)
{
    $request->validate([
        'file' => ['required', 'file', 'mimes:xlsx', 'max:20480'], // 20 MB
    ], [
        'file.required' => 'Debes seleccionar un archivo Excel.',
        'file.mimes'    => 'Solo se permiten archivos .xlsx.',
        'file.max'      => 'El archivo no debe superar los 20 MB.',
    ]);

    try {
        $import = new IglesiasImport();

        Excel::import($import, $request->file('file'));

        $report = [
            'created' => $import->created,
            'skipped' => $import->skipped,
            'errors'  => $import->errors,
        ];

        return redirect()->route('admin.iglesias.import')
            ->with('report', $report)
            ->with('success', 'Importación procesada correctamente.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error inesperado durante la importación: ' . $e->getMessage());
    }
}
}