<?php

namespace App\Http\Controllers;

use App\Models\Consent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsentController extends Controller
{
    /**
     * Muestra la pantalla obligatoria de aceptación de términos.
     * Si el usuario ya aceptó la versión actual, redirige al dashboard.
     */
    public function show(): View|RedirectResponse
    {
        $user           = auth()->user();
        $privacyVersion = config('consents.privacy_policy.version');
        $termsVersion   = config('consents.terms_conditions.version');

        $accepted = Consent::where('user_id', $user->id)
            ->whereIn('type', ['privacy_policy', 'terms_conditions'])
            ->get()
            ->keyBy('type');

        $hasPrivacy = isset($accepted['privacy_policy'])
            && $accepted['privacy_policy']->version === $privacyVersion;

        $hasTerms = isset($accepted['terms_conditions'])
            && $accepted['terms_conditions']->version === $termsVersion;

        if ($hasPrivacy && $hasTerms) {
            return redirect()->route('iglesia.dashboard');
        }

        return view('consent.accept', compact('privacyVersion', 'termsVersion'));
    }

    /**
     * Registra el consentimiento del usuario y permite el acceso al sistema.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'accept_privacy' => ['required', 'accepted'],
            'accept_terms'   => ['required', 'accepted'],
        ], [
            'accept_privacy.required' => 'Debe aceptar la Política de Tratamiento de Datos Personales.',
            'accept_privacy.accepted' => 'Debe aceptar la Política de Tratamiento de Datos Personales.',
            'accept_terms.required'   => 'Debe aceptar los Términos y Condiciones del sistema.',
            'accept_terms.accepted'   => 'Debe aceptar los Términos y Condiciones del sistema.',
        ]);

        $user           = auth()->user();
        $ip             = $request->ip();
        $privacyVersion = config('consents.privacy_policy.version');
        $termsVersion   = config('consents.terms_conditions.version');
        $now            = now();

        Consent::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'privacy_policy',   'version' => $privacyVersion],
            ['ip_address' => $ip, 'accepted_at' => $now]
        );

        Consent::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'terms_conditions', 'version' => $termsVersion],
            ['ip_address' => $ip, 'accepted_at' => $now]
        );

        return redirect()->intended(route('iglesia.dashboard'));
    }
}
