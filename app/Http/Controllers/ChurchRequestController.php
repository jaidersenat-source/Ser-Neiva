<?php

namespace App\Http\Controllers;

use App\Mail\ChurchRequestMail;
use App\Models\ChurchRequest;
use App\Models\Consent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChurchRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_organizacion' => ['required', 'string', 'max:255'],
            'lider_religioso'     => ['required', 'string', 'max:255'],
            'telefono'            => ['required', 'string', 'max:30'],
            'direccion'           => ['required', 'string', 'max:500'],
            'email'               => ['required', 'email', 'max:255'],
            'consent'             => ['required', 'accepted'],
        ], [
            'nombre_organizacion.required' => 'El nombre de la organización es obligatorio.',
            'lider_religioso.required'     => 'El nombre del líder religioso es obligatorio.',
            'telefono.required'            => 'El número de contacto es obligatorio.',
            'direccion.required'           => 'La dirección es obligatoria.',
            'email.required'               => 'El correo electrónico es obligatorio.',
            'email.email'                  => 'El correo electrónico no tiene un formato válido.',
            'consent.required'             => 'Debe aceptar la Política de Tratamiento de Datos Personales para continuar.',
            'consent.accepted'             => 'Debe aceptar la Política de Tratamiento de Datos Personales para continuar.',
        ]);

        $consentVersion = config('consents.registration.version');
        $consentIp      = $request->ip();
        $consentAt      = now();

        $churchRequest = ChurchRequest::create(array_merge(
            Arr::except($data, ['consent']),
            [
                'consent_accepted'    => true,
                'consent_version'     => $consentVersion,
                'consent_ip'          => $consentIp,
                'consent_accepted_at' => $consentAt,
            ]
        ));

        // Registrar consentimiento en tabla dedicada
        Consent::create([
            'church_request_id' => $churchRequest->id,
            'type'              => 'registration',
            'version'           => $consentVersion,
            'ip_address'        => $consentIp,
            'accepted_at'       => $consentAt,
        ]);

        // Enviar notificación al correo administrador
        $adminEmail = config('mail.admin_email', env('MAIL_FROM_ADDRESS', 'contacto@serneiva.org'));

        try {
            Mail::to($adminEmail)->send(new ChurchRequestMail($churchRequest));
        } catch (\Throwable $e) {
            // Si el correo falla, igual guardamos y continuamos
            Log::error('ChurchRequest mail failed: ' . $e->getMessage());
        }

        return back()
            ->with('registro_exitoso', true)
            ->with('registro_nombre', $data['nombre_organizacion'])
            ->withFragment('registro');
    }
}
