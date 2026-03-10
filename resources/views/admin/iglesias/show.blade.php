@extends('layouts.admin')

@section('title', $iglesia->nombre)
@section('page-title', $iglesia->nombre)
@section('page-subtitle', $iglesia->denominacion)

@section('content')

@vite(['resources/css/admin/iglesias/show.css'])

{{-- ═══════════════════════════
     HERO
═══════════════════════════ --}}
<div class="iglesia-hero mb-5">
    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="min-w-0">
            <span class="inline-block text-[10px] font-bold tracking-widest uppercase
                         text-blue-300 bg-white/10 border border-white/15
                         px-3 py-1 rounded-full mb-3">
                {{ $iglesia->denominacion }}
            </span>
            <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight truncate">
                {{ $iglesia->nombre }}
            </h2>
            @if($iglesia->direccion)
                <p class="text-blue-300 text-xs sm:text-sm mt-1.5 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $iglesia->direccion }}
                </p>
            @endif

            {{-- Mini-stats en el hero --}}
            <div class="hero-pills">
                @if($iglesia->promedio_asistentes)
                    <span class="hero-pill">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        ~{{ number_format($iglesia->promedio_asistentes) }} asistentes
                    </span>
                @endif

                @if($iglesia->ayudas && $iglesia->ayudas->count())
                    <span class="hero-pill">
                        🤝 {{ $iglesia->ayudas->count() }} ayuda(s)
                    </span>
                @endif

                @php
                    $ent    = $iglesia->entidad_registrada_colombia ?? 'NO';
                    $entCss = match($ent) { 'SI' => 'hero-pill--si', 'EN_PROCESO' => 'hero-pill--proceso', default => 'hero-pill--no' };
                @endphp
                <span class="hero-pill {{ $entCss }}">
                    {{ $iglesia->entidad_label }}
                </span>
            </div>
        </div>

        <div class="flex-shrink-0">
            @if($iglesia->estado === 'activo')
                <div class="flex items-center gap-2 bg-green-500/20 border border-green-400/30 rounded-xl px-4 py-2.5">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse" aria-hidden="true"></span>
                    <span class="text-green-300 text-sm font-bold">Activa</span>
                </div>
            @else
                <div class="flex items-center gap-2 bg-red-500/20 border border-red-400/30 rounded-xl px-4 py-2.5">
                    <span class="w-2 h-2 bg-red-400 rounded-full" aria-hidden="true"></span>
                    <span class="text-red-300 text-sm font-bold">Inactiva</span>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ═══════════════════════════
     BARRA DE ACCIONES
═══════════════════════════ --}}
<div class="action-bar flex items-center gap-2.5 mb-5 flex-wrap">
    <a href="{{ route('admin.iglesias.edit', $iglesia) }}" class="btn-edit">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Editar
    </a>

    <a href="{{ route('admin.iglesias.index') }}" class="btn-back">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver
    </a>

    <form method="POST" action="{{ route('admin.iglesias.destroy', $iglesia) }}"
          class="ml-auto"
          onsubmit="return confirm('¿Confirmas que deseas eliminar « {{ addslashes($iglesia->nombre) }} »? Esta acción no se puede deshacer.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="hidden sm:inline">Eliminar</span>
        </button>
    </form>
</div>

{{-- ═══════════════════════════
     CARDS DE INFORMACIÓN
     1 col móvil · 2 col md+
═══════════════════════════ --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

    {{-- ────────────────────────
         Card 1 – Info General
    ──────────────────────── --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon bg-blue-50">
                <svg class="w-4 h-4 text-[#1E3A8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="info-card-title">Información General</span>
        </div>

        <div class="data-row">
            <span class="data-label">Nombre</span>
            <span class="data-value font-semibold text-slate-800">{{ $iglesia->nombre }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Denominación</span>
            <span class="data-value">
                <span class="inline-block bg-blue-50 text-[#1E3A8A] text-xs font-bold px-2.5 py-1 rounded-full border border-blue-100">
                    {{ $iglesia->denominacion }}
                </span>
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Estado</span>
            <span class="data-value">
                @if($iglesia->estado === 'activo')
                    <span class="badge-activo">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full" aria-hidden="true"></span>
                        Activa
                    </span>
                @else
                    <span class="badge-inactivo">
                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full" aria-hidden="true"></span>
                        Inactiva
                    </span>
                @endif
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Dirección</span>
            <span class="data-value">{{ $iglesia->direccion }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Comuna</span>
            <span class="data-value text-slate-{{ $iglesia->comuna ? '700' : '400' }}">
                {{ $iglesia->comuna ?? 'No registrada' }}
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Corregimiento</span>
            <span class="data-value text-slate-{{ $iglesia->corregimiento ? '700' : '400' }}">
                {{ $iglesia->corregimiento ?? 'No registrado' }}
            </span>
        </div>

        {{-- ── NUEVOS: datos institucionales ── --}}
        <div class="data-row">
            <span class="data-label">Cel. inst.</span>
            <span class="data-value">
                @if($iglesia->celular_institucional)
                    <a href="tel:{{ $iglesia->celular_institucional }}" class="link-contact">
                        📱 {{ $iglesia->celular_institucional }}
                    </a>
                @else
                    <span class="text-slate-400">No registrado</span>
                @endif
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Correo inst.</span>
            <span class="data-value">
                @if($iglesia->correo_institucional)
                    <a href="mailto:{{ $iglesia->correo_institucional }}" class="link-contact break-all">
                        ✉ {{ $iglesia->correo_institucional }}
                    </a>
                @else
                    <span class="text-slate-400">No registrado</span>
                @endif
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Reg. Colombia</span>
            <span class="data-value">
                @php
                    $ent    = $iglesia->entidad_registrada_colombia ?? 'NO';
                    $entCss = match($ent) { 'SI' => 'badge-ent--si', 'EN_PROCESO' => 'badge-ent--proceso', default => 'badge-ent--no' };
                @endphp
                <span class="badge-ent {{ $entCss }}">{{ $iglesia->entidad_label }}</span>
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Asistentes</span>
            <span class="data-value">
                @if($iglesia->promedio_asistentes)
                    <span class="asist-chip">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        ~{{ number_format($iglesia->promedio_asistentes) }} por servicio
                    </span>
                @else
                    <span class="text-slate-400">No registrado</span>
                @endif
            </span>
        </div>

        <div class="data-row">
            <span class="data-label">Registrada</span>
            <span class="data-value text-slate-500 text-xs">
                {{ $iglesia->created_at->translatedFormat('d \d\e F \d\e Y') }}
            </span>
        </div>
    </div>

    {{-- ────────────────────────
         Card 2 – Contacto
    ──────────────────────── --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon bg-amber-50">
                <svg class="w-4 h-4 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="info-card-title">Contacto y Responsable</span>
        </div>

        <div class="data-row">
            <span class="data-label">Pastor / Líder</span>
            <span class="data-value {{ $iglesia->pastor_sacerdote ? 'font-semibold text-slate-800' : 'text-slate-400' }}">
                {{ $iglesia->pastor_sacerdote ?? 'No registrado' }}
            </span>
        </div>

        {{-- ── NUEVO: Fecha de nacimiento del líder ── --}}
        <div class="data-row">
            <span class="data-label">Nac. del líder</span>
            <span class="data-value">
                @if($iglesia->fecha_nacimiento_lider)
                    <span class="nacimiento-wrap">
                        <span class="nacimiento-fecha">
                            🎂 {{ $iglesia->fecha_nacimiento_lider->translatedFormat('d \d\e F \d\e Y') }}
                        </span>
                        <span class="nacimiento-edad">{{ $iglesia->edad_lider }} años</span>
                    </span>
                @else
                    <span class="text-slate-400">No registrada</span>
                @endif
            </span>
        </div>

        <div class="data-row">
            <span class="data-label">Teléfono</span>
            <span class="data-value">
                @if($iglesia->telefono)
                    <a href="tel:{{ $iglesia->telefono }}" class="link-contact">
                        {{ $iglesia->telefono }}
                    </a>
                @else
                    <span class="text-slate-400">No registrado</span>
                @endif
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Email</span>
            <span class="data-value">
                @if($iglesia->email)
                    <a href="mailto:{{ $iglesia->email }}" class="link-contact break-all">
                        {{ $iglesia->email }}
                    </a>
                @else
                    <span class="text-slate-400">No registrado</span>
                @endif
            </span>
        </div>

        {{-- Coordenadas GPS --}}
        <div class="px-4 py-3 bg-slate-50 border-t border-slate-100">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 mb-2">
                Coordenadas GPS
            </p>
            <div class="flex flex-wrap gap-2">
                <span class="coords-chip">
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    Lat: {{ $iglesia->latitud }}
                </span>
                <span class="coords-chip">
                    Lng: {{ $iglesia->longitud }}
                </span>
            </div>
            <a href="https://maps.google.com/?q={{ $iglesia->latitud }},{{ $iglesia->longitud }}"
               target="_blank" rel="noopener"
               class="btn-maps mt-3 inline-flex">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Ver en Google Maps
            </a>
        </div>
    </div>

</div>

{{-- ═══════════════════════════
     DESCRIPCIÓN (si existe)
═══════════════════════════ --}}
@if($iglesia->descripcion)
    <div class="desc-card mb-4">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Descripción</span>
        </div>
        <p class="text-sm text-amber-900 leading-relaxed">{{ $iglesia->descripcion }}</p>
    </div>
@endif

{{-- ═══════════════════════════
     AYUDAS SOCIALES
═══════════════════════════ --}}
@if($iglesia->ayudas && $iglesia->ayudas->count())
    <div class="info-card mb-4">
        <div class="info-card-header">
            <div class="info-card-icon bg-green-50">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <span class="info-card-title">Ayudas Sociales</span>
            <span class="ml-auto text-xs font-bold text-green-600 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full">
                {{ $iglesia->ayudas->count() }} programa(s)
            </span>
        </div>
        <div class="ayudas-list flex flex-wrap gap-2 p-4">
            @foreach($iglesia->ayudas as $ayuda)
                <span class="ayuda-chip">
                    <span>{{ $ayuda->icono ?? '🤝' }}</span>
                    <span>{{ $ayuda->nombre }}</span>
                    @if($ayuda->descripcion)
                        <span class="ayuda-chip-sub">{{ Str::limit($ayuda->descripcion, 40) }}</span>
                    @endif
                </span>
            @endforeach
        </div>
    </div>
@endif

{{-- ═══════════════════════════
     MAPA
═══════════════════════════ --}}
<div class="info-card">
    <div class="info-card-header">
        <div class="info-card-icon bg-blue-50">
            <svg class="w-4 h-4 text-[#1E3A8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <span class="info-card-title">Ubicación en el mapa</span>
    </div>
    <div id="show-map" class="h-52 sm:h-64 md:h-72 w-full"></div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat    = {{ $iglesia->latitud }};
    const lng    = {{ $iglesia->longitud }};
    const name   = @json($iglesia->nombre);
    const addr   = @json($iglesia->direccion);
    const denom  = @json($iglesia->denominacion);
    const ayudas = @json($iglesia->ayudas->map(fn($a) => ['icono' => $a->icono ?? '🤝', 'nombre' => $a->nombre]));

    const map = L.map('show-map', { zoomControl: true }).setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors'
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:34px;height:34px;background:#1E3A8A;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 3px 12px rgba(30,58,138,.45);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);color:white;font-size:13px;font-weight:900;">✝</span></div>`,
        iconSize: [34, 34], iconAnchor: [17, 34], popupAnchor: [0, -38],
    });

    // Chips de ayudas en el popup
    const ayudasHtml = ayudas.length
        ? `<div style="margin-top:8px;display:flex;flex-wrap:wrap;gap:3px;">
               ${ayudas.map(a =>
                   `<span style="background:#F0FDF4;color:#166534;border:1px solid #BBF7D0;border-radius:20px;padding:2px 7px;font-size:10px;font-weight:600;">${a.icono} ${a.nombre}</span>`
               ).join('')}
           </div>`
        : '';

    const popup = `
        <div style="font-family:'DM Sans',sans-serif;min-width:190px;padding:2px 0;">
            <p style="font-weight:700;color:#1E3A8A;font-size:13px;margin:0 0 4px;">${name}</p>
            <span style="display:inline-block;background:#EFF6FF;color:#3B82F6;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;margin-bottom:7px;">${denom}</span>
            <p style="font-size:11px;color:#64748B;margin:0;">📍 ${addr}</p>
            ${ayudasHtml}
        </div>`;

    L.marker([lat, lng], { icon })
        .addTo(map)
        .bindPopup(popup, { maxWidth: 280 })
        .openPopup();
});
</script>
@endpush

@endsection