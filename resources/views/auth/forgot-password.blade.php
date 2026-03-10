<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña – SIRN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-sirn.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/auth/forgot.css']) 
</head>
<body>

<div class="card">

    {{-- ── Header ── --}}
    <div class="card-header">
        {{-- Marca --}}
        <div class="header-logo">
            <img src="{{ asset('images/logo-sirn.png') }}" alt="SIRN">
            <span class="header-logo-text">SIRN · Panel Administrativo</span>
        </div>

        {{-- Ícono --}}
        <div class="header-icon">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>

        <h1 class="card-title">Recuperar contraseña</h1>
        <p class="card-subtitle">
            Te enviaremos un enlace seguro a tu correo para que puedas restablecer tu contraseña.
        </p>
    </div>

    {{-- ── Cuerpo ── --}}
    <div class="card-body">

        {{-- Alerta de éxito (Breeze session status) --}}
        @if (session('status'))
            <div class="status-alert" role="alert">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-semibold text-green-800" style="font-size:.78rem;">¡Enlace enviado!</p>
                    <p>{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            {{-- Email --}}
            <div class="field">
                <label class="field-label" for="email">
                    Correo electrónico
                </label>
                <div class="field-input-wrap">
                    <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input id="email" name="email" type="email"
                           class="field-input {{ $errors->get('email') ? 'error' : '' }}"
                           value="{{ old('email') }}"
                           placeholder="admin@sirn.gov.co"
                           required autofocus autocomplete="email">
                </div>

                {{-- Hint informativo --}}
                <div class="field-hint">
                    <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Ingresa el correo registrado en el sistema. Recibirás el enlace en pocos minutos.
                </div>

                @foreach ($errors->get('email') as $msg)
                    <p class="field-error">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $msg }}
                    </p>
                @endforeach
            </div>

            {{-- Botón enviar --}}
            <button type="submit" class="btn-submit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Enviar enlace de recuperación
            </button>
        </form>
    </div>

    {{-- ── Footer ── --}}
    <div class="card-footer">
        <a href="{{ route('login') }}" class="back-link">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver al inicio de sesión
        </a>
        <a href="{{ route('mapa.index') }}" class="map-link">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Ir al mapa público
        </a>
    </div>

</div>

</body>
</html>