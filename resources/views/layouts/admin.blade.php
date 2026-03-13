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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-sirn.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-sirn.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
@vite('resources/css/layouts/admin.css')

    

</head>

<body>

{{-- Overlay --}}
<div id="sidebar-overlay" onclick="cerrarSidebar()" aria-hidden="true"></div>

{{-- ═══════════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════════ --}}
<aside id="sidebar" role="navigation" aria-label="Menú administrativo">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-sirn.png') }}" alt="SER" class="sidebar-logo-img"
                 style="height:42px;width:auto;filter:brightness(0) invert(1);flex-shrink:0;">
            <div class="sidebar-logo-text">
                <p style="font-size:.85rem;font-weight:700;color:#fff;letter-spacing:.02em;line-height:1.2;">SER</p>
                <p style="font-size:.67rem;color:rgba(147,197,253,.7);line-height:1.3;margin-top:2px;">Sistema Estratégico Religioso</p>
            </div>
            {{-- Cerrar sidebar (móvil) --}}
            <button class="lg:hidden ml-auto flex items-center justify-center w-7 h-7 rounded-lg
                           text-white/50 hover:text-white hover:bg-white/10 transition-all"
                    onclick="cerrarSidebar()" aria-label="Cerrar menú">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Nav --}}
    <nav id="sidebar-nav" aria-label="Navegación principal">

        {{-- ── PRINCIPAL ── --}}
        <div class="nav-section">
            <span class="nav-section-label">Principal</span>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <div class="nav-divider"></div>

        {{-- ── GESTIÓN ── --}}
        <div class="nav-section">
            <span class="nav-section-label">Gestión</span>
        </div>

        {{-- Iglesias (con sub-ítem Importar) --}}
        <a href="{{ route('admin.iglesias.index') }}"
           class="nav-item {{ request()->routeIs('admin.iglesias.index') || request()->routeIs('admin.iglesias.show', 'admin.iglesias.create', 'admin.iglesias.edit', 'admin.iglesias.store', 'admin.iglesias.update', 'admin.iglesias.destroy') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Iglesias
            @php $totalActivas = \App\Models\Iglesia::where('estado','activo')->count(); @endphp
            @if($totalActivas > 0)
                <span class="nav-badge">{{ $totalActivas }}</span>
            @endif
        </a>

        {{-- Sub-ítems de Iglesias --}}
        <div class="nav-subgroup">
            <a href="{{ route('admin.iglesias.import') }}"
               class="nav-item nav-subitem {{ request()->routeIs('admin.iglesias.import*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
                Importar
            </a>
        </div>

        {{-- Fundaciones --}}
        <a href="{{ route('admin.foundations.index') }}"
           class="nav-item {{ request()->routeIs('admin.foundations.*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            Fundaciones
            @php $totalFoundations = \App\Models\Foundation::count(); @endphp
            @if($totalFoundations > 0)
                <span class="nav-badge">{{ $totalFoundations }}</span>
            @endif
        </a>

        {{-- Eventos (con sub-ítem Calendario) --}}
        <a href="{{ route('admin.eventos.index') }}"
           class="nav-item {{ request()->routeIs('admin.eventos.index') || request()->routeIs('admin.eventos.show', 'admin.eventos.create', 'admin.eventos.edit') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Eventos
        </a>

        {{-- Sub-ítems de Eventos --}}
        <div class="nav-subgroup">
            <a href="{{ route('admin.eventos.calendar') }}"
               class="nav-item nav-subitem {{ request()->routeIs('admin.eventos.calendar') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Calendario
            </a>
        </div>

        {{-- Escenarios deportivos --}}
        <a href="{{ route('admin.sports_venues.index') }}"
           class="nav-item {{ request()->routeIs('admin.sports_venues.*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Escenarios
            @php $totalVenues = \App\Models\SportsVenue::count(); @endphp
            @if($totalVenues > 0)
                <span class="nav-badge">{{ $totalVenues }}</span>
            @endif
        </a>

        <div class="nav-divider"></div>

        {{-- ── COMUNICACIONES ── --}}
        <div class="nav-section" style="margin-top:6px;">
            <span class="nav-section-label">Comunicaciones</span>
        </div>

        <a href="{{ route('admin.campaigns.index') }}"
           class="nav-item {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Campañas de Correo
        </a>

        <div class="nav-divider"></div>

        {{-- ── ACCESOS ── --}}
        <div class="nav-section" style="margin-top:6px;">
            <span class="nav-section-label">Accesos</span>
        </div>

        <a href="{{ route('mapa.index') }}" target="_blank" rel="noopener"
           class="nav-item nav-item-external">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Mapa Público
            <svg class="nav-icon-ext w-3 h-3 ml-auto opacity-40 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>

    </nav>

    {{-- Footer ── usuario + acciones --}}
    <div class="sidebar-footer">
        {{-- Usuario --}}
        <div class="user-row">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="flex-1 min-w-0">
                <p class="user-name truncate">{{ auth()->user()->name }}</p>
                <p class="user-email truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        {{-- Acciones --}}
        <a href="{{ route('profile.edit') }}" class="btn-footer-action">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-footer-action">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <button id="btn-menu" onclick="abrirSidebar()" aria-label="Abrir menú" aria-expanded="false" aria-controls="sidebar">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div class="w-px h-5 bg-slate-200 lg:hidden" aria-hidden="true"></div>
    <div class="flex-1 min-w-0">
        <h1 class="topbar-title truncate">@yield('page-title', 'Dashboard')</h1>
        <p class="topbar-sub truncate hidden sm:block">@yield('page-subtitle', 'Sistema Estratégico Religioso de Neiva')</p>
    </div>
    <div class="date-chip" aria-live="polite">
        <span class="online-dot" aria-hidden="true"></span>
        <span class="hidden sm:inline">{{ now()->translatedFormat('d M Y') }}</span>
        <span class="sm:hidden">{{ now()->format('d/m/Y') }}</span>
    </div>
</header>

{{-- ═══════════════════════════════════════════
     MAIN
═══════════════════════════════════════════ --}}
<main id="main-content" role="main">

    @if(session('success'))
        <div class="flash flash-success" role="alert">
            <svg class="flash-icon w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-semibold text-green-800">¡Operación exitosa!</p>
                <p class="text-sm text-green-700 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()"
                    class="ml-auto text-green-400 hover:text-green-600 transition-colors flex-shrink-0"
                    aria-label="Cerrar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash flash-error" role="alert">
            <svg class="flash-icon w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-semibold text-red-800">Se produjo un error</p>
                <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()"
                    class="ml-auto text-red-400 hover:text-red-600 transition-colors flex-shrink-0"
                    aria-label="Cerrar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @yield('content')

</main>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const btnMenu = document.getElementById('btn-menu');

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

    document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarSidebar(); });
    window.addEventListener('resize', () => { if (window.innerWidth >= 1024) cerrarSidebar(); });

    // Auto-dismiss flash
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