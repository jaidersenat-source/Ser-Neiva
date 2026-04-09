<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay usuario autenticado, redirigir al login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Si el usuario es una iglesia (portal), redirigir a su dashboard en lugar de abortar
        if ($request->user()->isIglesia()) {
            return redirect()->route('iglesia.dashboard')
                ->with('warning', 'No tienes acceso al panel administrativo.');
        }

        return $next($request);
    }
}
