<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#1E3A8A">
    <meta name="description" content="Sistema de Información Religiosa de Neiva – Directorio georreferenciado de iglesias del municipio.">
    <title>@yield('title', 'SER') – Mapa Religioso de Neiva</title>

    {{-- Fuente institucional elegante --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    {{-- MarkerCluster CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    {{-- Favicon --}}
<link rel="icon" type="image/png" href="{{ asset('images/logo-sirn.png') }}">
<link rel="shortcut icon" href="{{ asset('images/logo-sirn.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/logo-sirn.png') }}">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/layouts/public.css'])
</head>

<body class="h-full antialiased">

{{-- ══════════════════════════════════════
     NAVBAR PRINCIPAL
══════════════════════════════════════ --}}
<nav class="sirn-nav" role="navigation" aria-label="Navegación principal">
    <div class="h-full max-w-screen-2xl mx-auto px-4 sm:px-6 flex items-center justify-between gap-3">

        {{-- ── IZQUIERDA: Logo + Marca ── --}}
       <a href="{{ route('mapa.index') }}" class="flex items-center gap-2.5 no-underline flex-shrink-0">
    <img src="{{ asset('images/logo-sirn.png') }}"
         alt="SIRN"
         class="h-9 w-auto"
         style="filter: brightness(0) invert(1);">  {{-- blanco sobre fondo azul --}}
    <div class="leading-tight">
        <div class="nav-brand-name">SER</div>
        <div class="nav-brand-sub hidden sm:block">
            Sistema Estratégico Religioso de Neiva
        </div>
    </div>
</a>

        {{-- ── CENTRO: badge municipio (tablet +) ── --}}
        <div class="nav-badge" aria-hidden="true">
            <span class="online-dot"></span>
            Neiva, Huila · Colombia
        </div>

        {{-- ── DERECHA: Acciones ── --}}
        <div class="flex items-center gap-3 flex-shrink-0">

            @auth
                {{-- Usuario autenticado --}}
                <div class="hidden sm:flex items-center gap-2 text-blue-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-xs font-medium truncate max-w-[120px]">{{ auth()->user()->name }}</span>
                </div>

                <div class="nav-divider hidden sm:block" aria-hidden="true"></div>

                <a href="{{ route('admin.dashboard') }}" class="btn-admin" aria-label="Ir al panel administrativo">
                    <span class="hidden sm:inline">Panel Admin</span>
                    {{-- Ícono en móvil --}}
                    <span class="sm:hidden flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Admin
                    </span>
                </a>

            @else
                {{-- Visitante --}}
                <a href="{{ route('login') }}" class="link-login" aria-label="Acceso al panel administrativo">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">Acceso Admin</span>
                    <span class="sm:hidden">Admin</span>
                </a>
            @endauth

        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════
     CONTENIDO DE LA PÁGINA
══════════════════════════════════════ --}}
<div class="page-body">
    @yield('content')
</div>

{{-- Scripts de Leaflet y páginas --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
@stack('scripts')

</body>
</html>