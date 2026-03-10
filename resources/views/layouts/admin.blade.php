<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1E3A8A">
    <title>@yield('title', 'SER') – Panel Administrativo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
{{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-sirn.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/layouts/admin.css'])    
</head>

<body>

{{-- ═══════════════════════════════════════════
     OVERLAY MÓVIL (cierra sidebar al tocar)
═══════════════════════════════════════════ --}}
<div id="sidebar-overlay" onclick="cerrarSidebar()" aria-hidden="true"></div>

{{-- ═══════════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════════ --}}
<aside id="sidebar" role="navigation" aria-label="Menú administrativo">

    {{-- Logo --}}
    <div class="sidebar-logo">
    <div class="flex items-center gap-3">
           <img src="{{ asset('images/logo-sirn.png') }}"
               alt="SIRN"
               class="h-16 w-auto flex-shrink-0"
               style="filter: brightness(0) invert(1);">
        <div class="leading-tight">
            <p class="text-white font-bold text-sm tracking-wide">SER</p>
            <p class="text-blue-300 text-xs font-normal">Sistema Estratégico Religioso</p>
        </div>
        {{-- Botón cerrar móvil --}}
        <button class="lg:hidden ml-auto ..." onclick="cerrarSidebar()">...</button>
    </div>
</div>
          

    {{-- Navegación --}}
    <nav class="flex-1 overflow-y-auto px-2 py-3">

        <p class="nav-section-label">Principal</p>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Inicio
        </a>

        <p class="nav-section-label">Gestión</p>

        <a href="{{ route('admin.iglesias.index') }}"
           class="nav-item {{ request()->routeIs('admin.iglesias.*') ? 'active' : '' }}"
           aria-current="{{ request()->routeIs('admin.iglesias.*') ? 'page' : 'false' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Iglesias
            {{-- Badge con conteo activo --}}
            @php $totalActivas = \App\Models\Iglesia::where('estado','activo')->count(); @endphp
            @if($totalActivas > 0)
                <span class="ml-auto text-[10px] font-bold bg-white/15 text-blue-200 rounded-full px-2 py-0.5">
                    {{ $totalActivas }}
                </span>
            @endif
        </a>

        <a href="{{ route('admin.iglesias.import') }}"
   class="nav-item {{ request()->routeIs('admin.iglesias.import') ? 'active' : '' }}"
   aria-current="{{ request()->routeIs('admin.iglesias.import') ? 'page' : 'false' }}">
    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
    </svg>
    Importar Iglesias
</a>

   <a href="{{ route('admin.eventos.index') }}"
           class="nav-item {{ request()->routeIs('admin.eventos.*') ? 'active' : '' }}"
           aria-current="{{ request()->routeIs('admin.eventos.*') ? 'page' : 'false' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Eventos
        </a>
        <a href="{{ route('admin.eventos.calendar') }}"
           class="nav-item {{ request()->routeIs('admin.eventos.calendar') ? 'active' : '' }}"
           aria-current="{{ request()->routeIs('admin.eventos.calendar') ? 'page' : 'false' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Calendario
        </a>

    
          <p class="nav-section-label">Accesos</p>

        <a href="{{ route('mapa.index') }}" target="_blank" rel="noopener"
           class="nav-item nav-item-external">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Ver Mapa Público
        </a>

    </nav>

    {{-- Footer usuario --}}
    <div class="sidebar-footer">
        <div class="flex items-center gap-2.5 px-2">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate leading-tight">{{ auth()->user()->name }}</p>
                <p class="text-blue-400 text-[11px] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>


        <a href="{{ route('profile.edit') }}" class="btn-logout mt-2 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
        
    </div>

</aside>

{{-- ═══════════════════════════════════════════
     TOPBAR
═══════════════════════════════════════════ --}}
<header id="topbar" role="banner">

    {{-- Hamburguesa (móvil / tablet) --}}
    <button id="btn-menu" onclick="abrirSidebar()" aria-label="Abrir menú" aria-expanded="false" aria-controls="sidebar">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- Separador vertical --}}
    <div class="w-px h-5 bg-slate-200 lg:hidden" aria-hidden="true"></div>

    {{-- Título de la página --}}
    <div class="flex-1 min-w-0">
        <h1 class="topbar-title truncate">@yield('page-title', 'Dashboard')</h1>
        <p class="topbar-sub truncate hidden sm:block">@yield('page-subtitle', 'Sistema de Información Religiosa de Neiva')</p>
    </div>

    {{-- Chip de fecha + estado --}}
    <div class="date-chip" aria-live="polite">
        <span class="online-dot" aria-hidden="true"></span>
        <span class="hidden sm:inline">{{ now()->translatedFormat('d M Y') }}</span>
        <span class="sm:hidden">{{ now()->format('d/m/Y') }}</span>
    </div>

</header>

{{-- ═══════════════════════════════════════════
     CONTENIDO PRINCIPAL
═══════════════════════════════════════════ --}}
<main id="main-content" role="main">

    {{-- Flash: éxito --}}
    @if(session('success'))
        <div class="flash flash-success" role="alert">
            <svg class="flash-icon w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-semibold text-green-800">¡Operación exitosa!</p>
                <p class="text-sm text-green-700 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()"
                    class="ml-auto text-green-400 hover:text-green-600 transition-colors flex-shrink-0"
                    aria-label="Cerrar mensaje">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Flash: error --}}
    @if(session('error'))
        <div class="flash flash-error" role="alert">
            <svg class="flash-icon w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-semibold text-red-800">Se produjo un error</p>
                <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()"
                    class="ml-auto text-red-400 hover:text-red-600 transition-colors flex-shrink-0"
                    aria-label="Cerrar mensaje">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Contenido de cada vista --}}
    @yield('content')

</main>

{{-- ═══════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════ --}}
<script>
    // ── Sidebar toggle ──────────────────────────
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const btnMenu  = document.getElementById('btn-menu');

    function abrirSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        btnMenu.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function cerrarSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        btnMenu.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    // Cerrar con Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') cerrarSidebar();
    });

    // Cerrar al cambiar a desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) cerrarSidebar();
    });

    // ── Auto-dismiss flash messages ──────────────
    document.querySelectorAll('.flash').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity .4s, transform .4s';
            el.style.opacity    = '0';
            el.style.transform  = 'translateY(-6px)';
            setTimeout(() => el.remove(), 400);
        }, 5000);
    });
</script>

@stack('scripts')
</body>
</html>