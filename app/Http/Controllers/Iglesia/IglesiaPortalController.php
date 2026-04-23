<?php

namespace App\Http\Controllers\Iglesia;

use App\Http\Controllers\Controller;
use App\Models\Iglesia;
use App\Services\GeocoderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class IglesiaPortalController extends Controller
{
    public function __construct(private readonly GeocoderService $geocoder) {}
    /**
     * Dashboard principal del portal iglesia.
     */
    public function dashboard(): View
    {
        $iglesia = Auth::user()?->iglesia;

        $totalEventos         = $iglesia ? $iglesia->eventos()->count()         : 0;
        $totalEmprendimientos = $iglesia ? $iglesia->emprendimientos()->count()  : 0;

        // Próximos eventos (hoy en adelante, máx 5)
        $proximosEventos = $iglesia
            ? $iglesia->eventos()
                ->where('fecha_inicio', '>=', now()->toDateString())
                ->orderBy('fecha_inicio')
                ->limit(5)
                ->get()
            : collect();

        // Últimos emprendimientos registrados
        $ultimosEmprendimientos = $iglesia
            ? $iglesia->emprendimientos()
                ->latest()
                ->limit(4)
                ->get()
            : collect();

        return view('iglesia.dashboard', compact(
            'iglesia', 'totalEventos', 'totalEmprendimientos',
            'proximosEventos', 'ultimosEmprendimientos'
        ));
    }

    /**
     * Formulario de edición de datos de la iglesia.
     */
    public function editPerfil(): View
    {
        $iglesia = Auth::user()?->iglesia;
        abort_unless($iglesia, 404, 'No tienes una iglesia asignada.');

        // cargar ayudas disponibles y las asociadas a esta iglesia
        $iglesia->load('ayudas');
        $ayudas = \App\Models\Ayuda::orderBy('nombre')->get();
        $ayudasActuales = $iglesia->ayudas->pluck('id')->toArray();
        $linkedUser = \App\Models\User::where('iglesia_id', $iglesia->id)->first();

        return view('iglesia.perfil.perfil', compact('iglesia', 'ayudas', 'ayudasActuales', 'linkedUser'));
    }

    /**
     * Guardar cambios en el perfil de la iglesia.
     */
    public function updatePerfil(Request $request): RedirectResponse
    {
        $iglesia = Auth::user()?->iglesia;
        abort_unless($iglesia, 404);

        $data = $request->validate([
            // Sección 1
            'official_name'         => ['required', 'string', 'max:255'],
            'denomination'          => ['nullable', 'string', 'max:80'],
            'confessional_character'=> ['nullable', 'string', 'max:80'],
            'church_status'         => ['nullable', 'string', 'max:30'],
            'specific_location'     => ['nullable', 'string', 'max:255'],
            'foundation_date'       => ['nullable', 'date'],
            'approx_members'        => ['nullable', 'integer', 'min:0'],

            // Ubicación
            'address'               => ['nullable', 'string', 'max:255'],
            'neighborhood'          => ['nullable', 'string', 'max:120'],
            'comuna'                => ['nullable', 'string', 'max:80'],
            'department'            => ['nullable', 'string', 'max:80'],
            'municipality'          => ['nullable', 'string', 'max:120'],
            'city'                  => ['nullable', 'string', 'max:120'],
            'country'               => ['nullable', 'string', 'max:120'],

            // Contacto
            'email'                 => ['nullable', 'email', 'max:150'],
            'correo_institucional'  => ['nullable', 'email', 'max:255'],
            'phone_landline'        => ['nullable', 'string', 'max:30'],
            'phone_mobile'          => ['nullable', 'string', 'max:30'],
            'website_or_social'     => ['nullable', 'string', 'max:255'],

            // Pastor / líder
            'pastor_full_name'      => ['nullable', 'string', 'max:150'],
            'pastor_document_type'  => ['nullable', 'string', 'max:30'],
            'pastor_document_number'=> ['nullable', 'string', 'max:30'],
            'pastor_birth_date'     => ['nullable', 'date'],
            'leadership_period_type'=> ['nullable', 'string', 'max:40'],
            'pastor_phone'          => ['nullable', 'string', 'max:30'],
            'pastor_email'          => ['nullable', 'email', 'max:150'],

            // Líder de mujeres
            'women_leader_full_name'=> ['nullable', 'string', 'max:150'],
            'women_leader_phone'    => ['nullable', 'string', 'max:30'],
            'women_leader_email'    => ['nullable', 'email', 'max:150'],

            // Otros
            'ministries'            => ['nullable', 'array'],
            'additional_notes'      => ['nullable', 'string'],
            'schedule_weekdays'     => ['nullable', 'string', 'max:100'],
            'schedule_weekends'     => ['nullable', 'string', 'max:100'],

            // Geo
            'latitud'               => ['nullable', 'numeric'],
            'longitud'              => ['nullable', 'numeric'],

            // Datos jurídicos / institucionales
            'legal_registration_type'   => ['nullable', 'string', 'max:80'],
            'legal_registration_number' => ['nullable', 'string', 'max:80'],
            'legal_entity_granting'     => ['nullable', 'string', 'max:255'],
            'resolution_number'         => ['nullable', 'string', 'max:80'],
            'resolution_date'           => ['nullable', 'date'],
            'file_number'               => ['nullable', 'string', 'max:80'],
            'legal_personality_type'    => ['nullable', 'string', 'max:80'],
            'legal_notes'               => ['nullable', 'string'],

            // Foto (nota: en el formulario el input se llama 'photo')
            'photo'                 => ['nullable', 'image', 'max:2048'],

            // Ayudas
            'ayudas'                => ['nullable', 'array'],
            'ayudas.*'              => ['integer', 'exists:ayudas,id'],
        ]);

        // Subir foto si viene
        if ($request->hasFile('photo')) {
            if ($iglesia->photo) {
                Storage::disk('public')->delete($iglesia->photo);
            }
            $data['photo'] = $request->file('photo')->store('iglesias', 'public');
        }

        // Geocoding server-side: re-geocodificar si lat/lng están vacíos
        $hasCoords = !empty($data['latitud']) && !empty($data['longitud'])
            && $data['latitud'] != 2.9274 && $data['longitud'] != -75.2819;

        if (!$hasCoords && !empty($data['address'])) {
            $geocoded = $this->geocoder->geocode(
                $data['address'],
                $data['municipality'] ?? 'Neiva',
                $data['department']   ?? 'Huila',
            );
            if ($geocoded && $this->geocoder->isAcceptable($geocoded)) {
                $data['latitud']  = $geocoded['lat'];
                $data['longitud'] = $geocoded['lng'];
            }
        }

        // Guardar los cambios principales
        $iglesia->update($data);

        // Sincronizar ayudas si vienen
        if ($request->filled('ayudas')) {
            $iglesia->ayudas()->sync($request->input('ayudas'));
        }

        return redirect()->route('iglesia.perfil.index')
                         ->with('success', 'Datos actualizados correctamente.');
    }

    /**
     * Mostrar el perfil público / portal de una iglesia específica.
     */
    public function show(Iglesia $iglesia): View
    {
        // Cargar relaciones necesarias
        $iglesia->load('ayudas');
        $linkedUser = \App\Models\User::where('iglesia_id', $iglesia->id)->first();

        return view('iglesia.perfil.show', compact('iglesia', 'linkedUser'));
    }

    /**
     * Mostrar el perfil de la iglesia del usuario autenticado.
     */
    public function showOwn(): View
    {
        $iglesia = Auth::user()?->iglesia;
        abort_unless($iglesia, 404, 'No tienes una iglesia asignada.');

        $iglesia->load('ayudas');
        $linkedUser = \App\Models\User::where('iglesia_id', $iglesia->id)->first();

        return view('iglesia.perfil.show', compact('iglesia', 'linkedUser'));
    }
}
