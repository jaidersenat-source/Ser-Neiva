<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IglesiaRequest;
use App\Models\Ayuda;
use App\Models\Iglesia;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Imports\IglesiasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class IglesiaController extends Controller
{
    // ── Listado ───────────────────────────────────────────────
    public function index(\Illuminate\Http\Request $request): View
    {
        $query = Iglesia::with('ayudas')->latest();

        // Búsqueda por texto en varios campos (server-side) para cubrir todas las páginas
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('official_name', 'like', "%{$q}%")
                    ->orWhere('pastor_full_name', 'like', "%{$q}%")
                    ->orWhere('denomination', 'like', "%{$q}%")
                    ->orWhere('specific_location', 'like', "%{$q}%")
                    ->orWhere('municipality', 'like', "%{$q}%")
                    ->orWhere('legal_registration_number', 'like', "%{$q}%")
                    ->orWhere('legal_registration_type', 'like', "%{$q}%");
            });
        }

        if ($request->filled('municipality')) {
            $query->where('municipality', $request->municipality);
        }

        $iglesias      = $query->paginate(15)->withQueryString();

        $counts = Iglesia::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN church_status = 'Active' THEN 1 ELSE 0 END) as activas
        ")->first();

        $municipios    = Iglesia::select('municipality')
                            ->whereNotNull('municipality')
                            ->where('municipality', '!=', '')
                            ->distinct()
                            ->orderBy('municipality')
                            ->pluck('municipality');

        return view('admin.iglesias.index', [
            'iglesias'   => $iglesias,
            'total'      => (int) $counts->total,
            'activas'    => (int) $counts->activas,
            'municipios' => $municipios,
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
        $data = $request->validated();
        unset($data['photo']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('iglesias', 'public');
        }

        $iglesia = Iglesia::create($data);
        $iglesia->ayudas()->sync($request->ayudasIds());

        return redirect()
            ->route('admin.iglesias.index')
            ->with('success', "Iglesia «{$iglesia->official_name}» registrada correctamente.");
    }

    // ── Ver detalle ───────────────────────────────────────────
    public function show(Iglesia $iglesia): View
    {
        $iglesia->load('ayudas');

        $linkedUser = User::where('iglesia_id', $iglesia->id)->first();

        return view('admin.iglesias.show', [
            'iglesia'    => $iglesia,
            'linkedUser' => $linkedUser,
        ]);
    }

    // ── Editar ────────────────────────────────────────────────
    public function edit(Iglesia $iglesia): View
    {
        $this->authorize('update', $iglesia);

        $iglesia->load('ayudas');

        return view('admin.iglesias.edit', [
            'iglesia'        => $iglesia,
            'ayudas'         => Ayuda::orderBy('nombre')->get(),
            'ayudasActuales' => $iglesia->ayudas->pluck('id')->toArray(),
            'linkedUser'     => User::where('iglesia_id', $iglesia->id)->first(),
        ]);
    }

    // ── Actualizar ────────────────────────────────────────────
    public function update(IglesiaRequest $request, Iglesia $iglesia): RedirectResponse
    {
        $this->authorize('update', $iglesia);

        $data = $request->validated();
        unset($data['photo']);

        if ($request->hasFile('photo')) {
            if ($iglesia->photo) {
                Storage::disk('public')->delete($iglesia->photo);
            }
            $data['photo'] = $request->file('photo')->store('iglesias', 'public');
        }

        $iglesia->update($data);
        $iglesia->ayudas()->sync($request->ayudasIds());

        return redirect()
            ->route('admin.iglesias.show', $iglesia)
            ->with('success', "Iglesia «{$iglesia->official_name}» actualizada correctamente.");
    }

    // ── Eliminar ──────────────────────────────────────────────
    public function destroy(Iglesia $iglesia): RedirectResponse
    {
        $this->authorize('delete', $iglesia);

        $nombre = $iglesia->official_name;

        if ($iglesia->photo) {
            Storage::disk('public')->delete($iglesia->photo);
        }

        $iglesia->delete();

        return redirect()
            ->route('admin.iglesias.index')
            ->with('success', "Iglesia «{$nombre}» eliminada correctamente.");
    }

    // ── Credenciales de acceso al portal ──────────────────────
    public function setCredentials(Request $request, Iglesia $iglesia): RedirectResponse
    {
        $this->authorize('update', $iglesia);

        $linkedUser = User::where('iglesia_id', $iglesia->id)->first();
        $userId     = $linkedUser?->id;

        $rules = [
            'username' => [
                'required', 'string', 'min:3', 'max:50',
                'regex:/^[a-zA-Z0-9._]+$/',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'password' => [
                $linkedUser ? 'nullable' : 'required',
                'nullable', 'string', 'min:8', 'confirmed',
            ],
        ];

        $messages = [
            'username.required'  => 'El nombre de usuario es obligatorio.',
            'username.min'       => 'El usuario debe tener al menos 3 caracteres.',
            'username.max'       => 'El usuario no puede superar 50 caracteres.',
            'username.regex'     => 'Solo se permiten letras, números, puntos y guiones bajos.',
            'username.unique'    => 'Ese nombre de usuario ya está en uso.',
            'password.required'  => 'La contraseña es obligatoria al crear el acceso por primera vez.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];

        $validated = $request->validate($rules, $messages);

        if (!$linkedUser) {
            $linkedUser             = new User();
            $linkedUser->email      = 'iglesia_' . $iglesia->id . '@portal.local';
            $linkedUser->role       = 'iglesia';
            $linkedUser->iglesia_id = $iglesia->id;
            $linkedUser->name       = $iglesia->official_name ?? 'Iglesia';
        }

        $linkedUser->username = $validated['username'];

        if (!empty($validated['password'])) {
            $linkedUser->password = Hash::make($validated['password']);
        }

        $linkedUser->save();

        return redirect()
            ->route('admin.iglesias.edit', $iglesia)
            ->with('success_credentials', 'Credenciales de acceso guardadas correctamente.');
    }

    public function import()
    {
        return view('admin.iglesias.import');
    }

    public function importTemplate()
    {
        $path = public_path('templates/plantilla_importacion_iglesias.xlsx');
        return response()->download($path, 'plantilla_importacion_iglesias.xlsx');
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