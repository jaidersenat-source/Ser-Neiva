<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\IglesiaLoginNotificationMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        /** @var \App\Models\User $user */
        // Notificar al admin cuando una iglesia inicia sesión
        if ($user->isIglesia()) {
            try {
                $adminEmail = config('mail.admin_email', env('MAIL_FROM_ADDRESS', 'contacto@serneiva.org'));
                $ip         = $request->ip();
                $fechaHora  = now()->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
                Mail::to($adminEmail)->send(new IglesiaLoginNotificationMail($user, $ip, $fechaHora));
            } catch (\Throwable $e) {
                Log::error('IglesiaLoginNotificationMail failed: ' . $e->getMessage());
            }

            return redirect()->intended(route('iglesia.dashboard'));
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
