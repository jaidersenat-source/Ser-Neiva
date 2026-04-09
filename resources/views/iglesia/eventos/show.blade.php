@extends('layouts.iglesia')

@php
    $isActivo      = $evento->estado === 'activo';
    $iglesiaNombre = $evento->iglesia->official_name ?? null;
    $tipoColors    = [
        'retiro'      => ['bg' => '#F5F3FF', 'color' => '#6D28D9', 'border' => '#DDD6FE'],
        'conferencia' => ['bg' => '#EFF6FF', 'color' => '#1D4ED8', 'border' => '#BFDBFE'],
        'culto'       => ['bg' => '#EFF6FF', 'color' => '#1E3A8A', 'border' => '#BFDBFE'],
        'campamento'  => ['bg' => '#FFFBEB', 'color' => '#92400E', 'border' => '#FDE68A'],
        'otro'        => ['bg' => '#F9FAFB', 'color' => '#374151', 'border' => '#E5E7EB'],
    ];
    $tipoKey   = strtolower($evento->tipo_evento ?? 'otro');
    $tipoStyle = $tipoColors[$tipoKey] ?? $tipoColors['otro'];
@endphp

@section('title', $evento->titulo)
@section('page-title', $evento->titulo)
@section('page-subtitle', $evento->tipo_evento ?? 'Evento')

@section('content')

{{-- ═══════════════════════════════════
     HERO STRIP
═══════════════════════════════════ --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #2D1B69 0%, #4C1D95 45%, #7C3AED 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-72 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="70,0 200,0 200,120 130,120" fill="#a78bfa"/>
            <polygon points="110,0 200,0 200,120 165,120" fill="#c4b5fd"/>
            <polygon points="150,0 200,0 200,55" fill="#ede9fe"/>
        </svg>
        <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full opacity-10"
             style="background: radial-gradient(circle, #a78bfa, transparent 70%);"></div>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">

            {{-- LEFT: avatar + info --}}
            <div class="flex items-start gap-4 min-w-0">
                {{-- Avatar: mostrar imagen principal si existe, si no letra inicial --}}
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-2xl overflow-hidden shadow-lg"
                     style="background: rgba(255,255,255,0.18); backdrop-filter: blur(8px); border: 2px solid rgba(255,255,255,0.25);">
                    @if($evento->imagen_principal)
                        <img src="{{ asset('storage/' . $evento->imagen_principal) }}"
                             alt="Imagen del evento" class="w-full h-full object-cover block"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-3xl font-extrabold text-white"
                             style="background: transparent;">
                            {{ strtoupper(substr($evento->titulo, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="min-w-0 pt-1">
                    {{-- Tipo chip --}}
                    <span class="inline-block text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-full mb-2"
                          style="color:#c4b5fd; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15);">
                        {{ $evento->tipo_evento ?? 'Sin tipo' }}
                    </span>

                    <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight">
                        {{ $evento->titulo }}
                    </h2>

                    @if($iglesiaNombre)
                        <p class="mt-1.5 text-xs flex items-center gap-1.5" style="color: rgba(196,181,253,0.85);">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ $iglesiaNombre }}
                        </p>
                    @endif

                    {{-- Meta chips --}}
                    <div class="flex flex-wrap gap-2 mt-3">
                        @if($evento->fecha_inicio)
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(255,255,255,0.12); color:white;">
                                <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $evento->fecha_inicio->format('d/m/Y · H:i') }}
                            </span>
                        @endif
                        @if($evento->direccion_evento)
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(255,255,255,0.10); color:rgba(255,255,255,0.85);">
                                <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ Str::limit($evento->direccion_evento, 40) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT: estado + acciones --}}
            <div class="flex sm:flex-col items-center sm:items-end gap-3 flex-shrink-0">
                @if($isActivo)
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                          style="background:rgba(34,197,94,0.2); border:1px solid rgba(74,222,128,0.3); color:#86efac;">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Activo
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                          style="background:rgba(239,68,68,0.2); border:1px solid rgba(252,165,165,0.3); color:#fca5a5;">
                        <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                        Inactivo
                    </span>
                @endif
                <div class="flex gap-2">
                    <a href="{{ route('iglesia.eventos.edit', $evento) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold
                              transition-all hover:opacity-90 active:scale-95"
                       style="background:rgba(255,255,255,0.15); color:white; border:1px solid rgba(255,255,255,0.2); backdrop-filter:blur(8px);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('iglesia.eventos.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold
                              transition-all hover:opacity-90 active:scale-95"
                       style="background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.75); border:1px solid rgba(255,255,255,0.15);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     GRID 2 COLUMNAS
═══════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ──────────────────────────────
         COLUMNA IZQUIERDA (2/3)
    ────────────────────────────── --}}
    <div class="lg:col-span-2 flex flex-col gap-5">

        {{-- 1. Detalles del evento --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F5F3FF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EDE9FE;">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Detalles del Evento</p>
                    <p class="text-xs text-slate-400">Información principal</p>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 divide-y divide-slate-50 sm:divide-y-0">

                    {{-- Título --}}
                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Título</p>
                        <p class="text-sm font-bold text-slate-800">{{ $evento->titulo }}</p>
                    </div>

                    {{-- Tipo --}}
                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tipo de evento</p>
                        @if($evento->tipo_evento)
                            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-lg border"
                                  style="background:{{ $tipoStyle['bg'] }}; color:{{ $tipoStyle['color'] }}; border-color:{{ $tipoStyle['border'] }};">
                                {{ $evento->tipo_evento }}
                            </span>
                        @else
                            <span class="text-xs text-slate-300 italic">No registrado</span>
                        @endif
                    </div>

                    {{-- Iglesia --}}
                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Iglesia</p>
                        <p class="text-sm text-slate-600">{{ $iglesiaNombre ?? '—' }}</p>
                    </div>

                    {{-- Estado --}}
                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Estado</p>
                        @if($isActivo)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full"
                                  style="background:#F0FDF4; color:#166534;">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Activo
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full"
                                  style="background:#FFF1F2; color:#9F1239;">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Inactivo
                            </span>
                        @endif
                    </div>

                    {{-- Registrado --}}
                    <div class="py-3 sm:col-span-2">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Registrado el</p>
                        <p class="text-xs text-slate-400">{{ $evento->created_at->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>

                </div>
            </div>
        </div>

        {{-- 2. Fechas y Duración --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFFBEB;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FEF9C3;">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Fechas y Duración</p>
                    <p class="text-xs text-slate-400">Período de realización del evento</p>
                </div>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Inicio --}}
                <div class="rounded-xl p-4" style="background:#FFFBEB; border:1px solid #FDE68A;">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-600 mb-1.5">Fecha de inicio</p>
                    @if($evento->fecha_inicio)
                        <p class="text-sm font-bold text-amber-900">
                            {{ $evento->fecha_inicio->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                        <p class="text-xs text-amber-700 mt-0.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $evento->fecha_inicio->format('H:i') }} hrs
                        </p>
                    @else
                        <p class="text-xs text-slate-400 italic">No registrada</p>
                    @endif
                </div>
                {{-- Fin --}}
                <div class="rounded-xl p-4" style="background:#F0FDF4; border:1px solid #BBF7D0;">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-green-600 mb-1.5">Fecha de fin</p>
                    @if($evento->fecha_fin)
                        <p class="text-sm font-bold text-green-900">
                            {{ $evento->fecha_fin->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                        <p class="text-xs text-green-700 mt-0.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $evento->fecha_fin->format('H:i') }} hrs
                        </p>
                        @php
                            $duracion = $evento->fecha_inicio?->diffForHumans($evento->fecha_fin, true);
                        @endphp
                        @if($duracion)
                            <p class="text-[10px] font-semibold text-green-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Duración: {{ $duracion }}
                            </p>
                        @endif
                    @else
                        <p class="text-xs text-slate-400 italic">Sin fecha de fin</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- 3. Descripción --}}
        @if($evento->descripcion)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFFBEB;">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:#FEF3C7;">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Descripción</p>
                </div>
                <div class="p-5">
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $evento->descripcion }}</p>
                </div>
            </div>
        @endif

    </div>{{-- /col izquierda --}}

    {{-- ──────────────────────────────
         COLUMNA DERECHA (1/3)
    ────────────────────────────── --}}
    <div class="flex flex-col gap-5">

        {{-- Ubicación --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#DCFCE7;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Ubicación</p>
            </div>
            <div class="p-4 space-y-3">
                @if($evento->direccion_evento)
                    <div class="flex items-start gap-2.5 p-3 rounded-xl"
                         style="background:#F0FDF4; border:1px solid #DCFCE7;">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <p class="text-xs font-semibold text-emerald-800 leading-relaxed">{{ $evento->direccion_evento }}</p>
                    </div>
                @endif

                {{-- Coordenadas --}}
                <div class="p-3 rounded-xl" style="background:#F8FAFF; border:1px solid #E2E8F0;">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Coordenadas GPS</p>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center gap-1 text-xs font-mono font-semibold text-slate-600
                                     bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                            LAT {{ $evento->latitud ?? '—' }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-xs font-mono font-semibold text-slate-600
                                     bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                            LNG {{ $evento->longitud ?? '—' }}
                        </span>
                    </div>
                    @if($evento->latitud && $evento->longitud)
                        <a href="https://maps.google.com/?q={{ $evento->latitud }},{{ $evento->longitud }}"
                           target="_blank" rel="noopener"
                           class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold
                                  rounded-xl text-white transition-all hover:opacity-90 active:scale-95"
                           style="background: linear-gradient(135deg, #2D1B69, #7C3AED);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Ver en Google Maps
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Mapa --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Ubicación en el mapa</p>
            </div>
            <div id="show-map" class="h-56 w-full"></div>
        </div>

        {{-- Iglesia vinculada --}}
        @if($evento->iglesia)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
                        <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Iglesia vinculada</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-3 p-3 rounded-xl" style="background:#F8FAFF; border:1px solid #E2E8F0;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-extrabold
                                    text-white flex-shrink-0 shadow-sm"
                             style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                            {{ strtoupper(substr($iglesiaNombre, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $iglesiaNombre }}</p>
                            @if($evento->iglesia->denomination ?? null)
                                <p class="text-xs text-slate-400 truncate">
                                    {{ $evento->iglesia->denomination }}
                                </p>
                            @endif
                        </div>
                    </div>
                          <a href="{{ route('iglesia.perfil.show', $evento->iglesia) }}"
                       class="mt-3 w-full inline-flex items-center justify-center gap-2 px-3 py-2.5 text-xs font-semibold
                              rounded-xl transition-all hover:opacity-90 active:scale-95"
                       style="background:#EFF6FF; color:#1E3A8A; border:1px solid #BFDBFE;">
                        Ver ficha de iglesia
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endif

        {{-- Zona de peligro --}}
        <div class="rounded-2xl p-4" style="background:#FFF1F2; border:1px solid #FECDD3;">
            <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Zona de peligro</p>
            <p class="text-xs text-red-500 mb-3 leading-relaxed">
                Esta acción eliminará permanentemente el evento y no se puede deshacer.
            </p>
            <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
                  class="form-eliminar-evento-show" data-titulo="{{ addslashes($evento->titulo) }}">
                @csrf @method('DELETE')
                <button type="button"
                        class="btn-eliminar-evento-show w-full inline-flex items-center justify-center gap-2
                               px-4 py-2.5 text-xs font-bold text-white rounded-xl transition-all
                               hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #DC2626, #EF4444);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Eliminar este evento
                </button>
            </form>
        </div>

    </div>{{-- /col derecha --}}

</div>

{{-- Modal confirmar eliminar --}}
<div id="modal-eliminar-show" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl p-6 w-full sm:max-w-sm mx-4 sm:mx-0 text-center">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:#FEF2F2;">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-base font-bold text-slate-800 mb-2">¿Eliminar evento?</h2>
        <p class="text-sm text-slate-500 mb-6 leading-relaxed" id="modal-show-nombre">
            Esta acción no se puede deshacer.
        </p>
        <div class="flex gap-3">
            <button id="btn-cancelar-show"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold
                           text-slate-700 bg-white hover:bg-slate-50 transition-all">
                Cancelar
            </button>
            <button id="btn-confirmar-show"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                           hover:opacity-90 active:scale-95 transition-all"
                    style="background: linear-gradient(135deg, #DC2626, #EF4444);">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Mapa ───────────────────────────────────────────────── */
    const lat    = {{ $evento->latitud ?? 2.9274 }};
    const lng    = {{ $evento->longitud ?? -75.2819 }};
    const title  = @json($evento->titulo);
    const addr   = @json($evento->direccion_evento ?? 'Sin dirección registrada');
    const ig     = @json($iglesiaNombre ?? '');

    const map = L.map('show-map', { zoomControl: true }).setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>',
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:34px;height:34px;
                    background:linear-gradient(135deg,#4C1D95,#7C3AED);
                    border-radius:50% 50% 50% 0;transform:rotate(-45deg);
                    border:3px solid white;box-shadow:0 3px 14px rgba(76,29,149,.45);
                    display:flex;align-items:center;justify-content:center;">
                    <span style="transform:rotate(45deg);font-size:14px;">📅</span>
               </div>`,
        iconSize: [34,34], iconAnchor: [17,34], popupAnchor: [0,-38],
    });

    const imageUrl = @json($evento->imagen_principal ? asset('storage/' . $evento->imagen_principal) : null);
    const popupHtml = `<div style="font-family:system-ui,sans-serif;min-width:190px;padding:6px;">
            ${imageUrl ? `<div style="width:100%;height:110px;overflow:hidden;border-radius:8px;margin-bottom:8px"><img src="${imageUrl}" style="width:100%;height:100%;object-fit:cover;display:block"/></div>` : ''}
            <p style="font-weight:700;color:#4C1D95;font-size:13px;margin:0 0 6px;">${title}</p>
            ${ig ? `<div style="margin-bottom:6px"><span style="display:inline-block;background:#EDE9FE;color:#5B21B6;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;">${ig}</span></div>` : ''}
            <p style="font-size:12px;color:#64748B;margin:0;">📍 ${addr}</p>
         </div>`;

    L.marker([lat, lng], { icon }).addTo(map).bindPopup(popupHtml, { maxWidth: 280 }).openPopup();

    /* ── Modal eliminar ─────────────────────────────────────── */
    var modal    = document.getElementById('modal-eliminar-show');
    var nombreEl = document.getElementById('modal-show-nombre');
    var formEl   = null;

    document.querySelectorAll('.btn-eliminar-evento-show').forEach(function(btn) {
        btn.addEventListener('click', function() {
            formEl = btn.closest('form');
            var titulo = formEl.getAttribute('data-titulo') || '';
            nombreEl.textContent = '¿Seguro que deseas eliminar "' + titulo + '"? Esta acción no se puede deshacer.';
            modal.classList.remove('hidden');
        });
    });

    document.getElementById('btn-cancelar-show').addEventListener('click', function() {
        modal.classList.add('hidden'); formEl = null;
    });
    document.getElementById('btn-confirmar-show').addEventListener('click', function() {
        if (formEl) formEl.submit();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { modal.classList.add('hidden'); formEl = null; }
    });
});
</script>
@endpush

@endsection