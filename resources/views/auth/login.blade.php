<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo – SER</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-sirn.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@vite(['resources/css/auth/login.css'])

<div class="login-wrap">

    {{-- ══════════════════════════════════
         PANEL IZQUIERDO (solo desktop)
    ══════════════════════════════════ --}}
    <div class="panel-left">
        <div class="panel-left-content">

            {{-- Marca --}}
            <div class="panel-brand">
                <img src="{{ asset('images/logo-sirn.png') }}"
                     alt="SIRN"
                     class="panel-logo"
                     style="filter: brightness(0) invert(1);">
            </div>

            {{-- Texto central --}}
            <div>
                <h1 class="panel-headline">
                    Sistema Estratégico para las<br>Entidades Religiosas de Neiva
                </h1>
                <p class="panel-sub">
                    Plataforma oficial de gestión y visualización georreferenciada
                    de las instituciones religiosas del municipio de Neiva, Huila.
                </p>

                {{-- Stats dinámicos --}}
                @php
                    $totalLogin   = \App\Models\Iglesia::count();
                    $activasLogin = \App\Models\Iglesia::where('church_status','Active')->count();
                    $denomsLogin  = \App\Models\Iglesia::distinct()->count('denomination');
                @endphp
                <div class="panel-stats">
                    <div class="stat-item">
                        <div class="stat-num">{{ $totalLogin }}</div>
                        <div class="stat-lbl">Iglesias</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">{{ $activasLogin }}</div>
                        <div class="stat-lbl">Activas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">{{ $denomsLogin }}</div>
                        <div class="stat-lbl">Denominaciones</div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                © {{ date('Y') }} Alcaldía de Neiva · SER v1.0
            </div>
        </div>

        {{-- Ícono decorativo --}}
        <div class="deco-icon" aria-hidden="true">✝</div>
    </div>

    {{-- ══════════════════════════════════
         PANEL DERECHO – Formulario
    ══════════════════════════════════ --}}
    <div class="panel-right">
        <div class="form-box">

            {{-- Logo en móvil --}}
            <div class="mobile-brand">
                <img src="{{ asset('images/logo-sirn.png') }}"
                     alt="SIRN"
                     class="mobile-logo">
                <p class="mobile-brand-name">SER</p>
                <p class="mobile-brand-sub">Sistema Estratégico Religioso de Neiva</p>
            </div>

            {{-- Encabezado --}}
            <div class="hidden lg:block mb-8">
                <h2 class="form-heading">Bienvenido</h2>
                <p class="form-subhead">Ingresa tus credenciales para acceder al panel</p>
            </div>

            {{-- Alerta de sesión (Breeze) --}}
            @if (session('status'))
                <div class="session-alert">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Formulario --}}

            {{-- Selector de tipo de acceso: Admin / Iglesia --}}
            <div class="access-mode">
                <div class="label">Acceso</div>
                <button type="button" id="btn-mode-admin" class="mode-btn-small active" onclick="setLoginMode('admin')">Admin</button>
                <button type="button" id="btn-mode-iglesia" class="mode-btn-small" onclick="setLoginMode('iglesia')">Iglesia</button>
            </div>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                {{-- Enviado dentro del form para que llegue al servidor --}}
                <input type="hidden" id="login_mode" name="login_mode" value="admin">

                {{-- Email / Usuario (se alterna según modo) --}}
                <div class="field">
                    <label id="label-identifier" class="field-label" for="email">Correo electrónico</label>
                    <div class="field-input-wrap">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                           <input id="email" name="email" type="email"
                               class="field-input {{ $errors->get('email') ? 'border-red-400 bg-red-50' : '' }}"
                               value="{{ old('email') }}"
                               placeholder="admin@ser.gov.co"
                               required autofocus autocomplete="username">
                    </div>
                    @foreach ($errors->get('email') as $msg)
                        <p class="field-error">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $msg }}
                        </p>
                    @endforeach
                </div>

                {{-- Contraseña --}}
                <div class="field">
                    <label class="field-label" for="password">Contraseña</label>
                    <div class="field-input-wrap">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input id="password" name="password" type="password"
                               class="field-input {{ $errors->get('password') ? 'border-red-400 bg-red-50' : '' }}"
                               placeholder="••••••••••"
                               required autocomplete="current-password">
                        {{-- Toggle ver contraseña --}}
                        <button type="button" class="pwd-toggle" onclick="togglePassword()" aria-label="Mostrar contraseña" id="pwd-toggle-btn">
                            <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @foreach ($errors->get('password') as $msg)
                        <p class="field-error">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $msg }}
                        </p>
                    @endforeach
                </div>

                {{-- Recordarme --}}
                <div class="remember-wrap">
                    <input type="checkbox" id="remember_me" name="remember"
                           class="remember-check">
                    <label for="remember_me" class="remember-label">
                        Mantener sesión iniciada
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link ml-auto" style="margin-top:0; display:inline;">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                {{-- Botón ingresar --}}
                <button type="submit" class="btn-login">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Ingresar al sistema
                </button>

            </form>

            {{-- Divider --}}
            <div class="divider"><span>ACCESO RESTRINGIDO</span></div>

            {{-- Badge informativo --}}
            <div class="admin-badge">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Solo el administrador autorizado puede ingresar
            </div>

            {{-- Volver al mapa --}}
            <a href="{{ route('mapa.index') }}" class="back-link">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al mapa público
            </a>

        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input  = document.getElementById('password');
        const open   = document.getElementById('eye-open');
        const closed = document.getElementById('eye-closed');
        const isText = input.type === 'text';

        input.type   = isText ? 'password' : 'text';
        open.classList.toggle('hidden',  !isText);
        closed.classList.toggle('hidden', isText);
    }

    // Alternar modo de login: 'admin' (email) o 'iglesia' (usuario)
    function setLoginMode(mode) {
        const btnAdmin = document.getElementById('btn-mode-admin');
        const btnIgl   = document.getElementById('btn-mode-iglesia');
        const label    = document.getElementById('label-identifier');
        const input    = document.getElementById('email');
        const hidden   = document.getElementById('login_mode');

        if (!label || !input || !hidden) return;

        if (mode === 'iglesia') {
            btnAdmin.classList.remove('active');
            btnIgl.classList.add('active');

            label.textContent = 'Usuario';
            input.type = 'text';
            input.placeholder = 'usuario';
            input.autocomplete = 'username';
            hidden.value = 'iglesia';
        } else {
            btnIgl.classList.remove('active');
            btnAdmin.classList.add('active');

            label.textContent = 'Correo electrónico';
            input.type = 'email';
            input.placeholder = 'admin@ser.gov.co';
            input.autocomplete = 'username';
            hidden.value = 'admin';
        }
        // focus en el input luego del cambio
        setTimeout(() => input.focus(), 80);
    }

    // Inicializar (por defecto admin)
    document.addEventListener('DOMContentLoaded', () => setLoginMode('admin'));
</script>

</body>
</html>