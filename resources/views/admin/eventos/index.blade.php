@extends('layouts.admin')

@section('title', 'Eventos')
@section('page-title', 'Gestión de Eventos')
@section('page-subtitle', 'Administra la agenda de eventos y actividades')

@section('content')

{{-- ═══════════════════════════════════
     HERO STRIP
═══════════════════════════════════ --}}
<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #2d1b69 0%, #4c1d95 45%, #7c3aed 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: radial-gradient(circle, #a78bfa, transparent 70%);"></div>
        <div class="absolute top-4 right-16 w-32 h-32 rounded-full opacity-10"
             style="background: #c4b5fd;"></div>
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#a78bfa"/>
            <polygon points="110,0 200,0 200,120 170,120" fill="#c4b5fd"/>
            <polygon points="150,0 200,0 200,60" fill="#ede9fe"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Agenda de Eventos</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(196,181,253,0.9);">
                Gestión y administración de eventos y actividades registradas
            </p>
        </div>

        {{-- Stats --}}
        <div class="flex gap-4 ml-12 sm:ml-0">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $eventos->total() }}</p>
                <p class="text-xs mt-0.5" style="color: rgba(196,181,253,0.85);">Total</p>
            </div>
            <div class="w-px" style="background: rgba(255,255,255,0.15);"></div>
            <div class="text-center">
                <p class="text-2xl font-extrabold leading-none" style="color: #a78bfa;">
                    {{ $eventos->where('estado', 'activo')->count() }}
                </p>
                <p class="text-xs mt-0.5" style="color: rgba(196,181,253,0.85);">Activos</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     TOOLBAR
═══════════════════════════════════ --}}
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    {{-- Buscador --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3 flex-wrap">
        <div class="relative">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="buscador-eventos"
                   placeholder="Buscar evento, iglesia o tipo…"
                   aria-label="Buscar evento"
                   oninput="filtrarTabla(this.value)"
                   class="pl-10 pr-9 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                          shadow-sm w-full sm:w-64 focus:outline-none focus:ring-2
                          focus:border-violet-500 text-slate-700 transition-all placeholder-slate-400">
            <button id="btn-clear"
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                    onclick="limpiarBusqueda()" aria-label="Limpiar búsqueda">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="flex items-center gap-2 flex-shrink-0">
        <a href="{{ route('admin.eventos.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl
                  shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95"
           style="background: linear-gradient(135deg, #2d1b69, #7c3aed);">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="hidden xs:inline">Nuevo Evento</span>
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════
     PANEL PRINCIPAL
═══════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- ── TABLA DESKTOP (md+) ── --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full" id="eventos-table">
            <thead>
                <tr class="border-b border-slate-100" style="background: #FAFAFF;">
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4">Evento</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Iglesia</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Fecha Inicio</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden lg:table-cell">Tipo</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Estado</th>
                    <th class="text-right text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="tabla-body">
                @forelse($eventos as $evento)
                    <tr class="evento-row-data group hover:bg-violet-50/30 transition-colors duration-100"
                        data-titulo="{{ strtolower($evento->titulo) }}"
                        data-iglesia="{{ strtolower($evento->iglesia->official_name ?? '') }}"
                        data-tipo="{{ strtolower($evento->tipo_evento ?? '') }}">

                        {{-- Título --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold
                                            text-white flex-shrink-0 shadow-sm"
                                     style="background: linear-gradient(135deg, #2d1b69, #7c3aed);">
                                    {{ strtoupper(substr($evento->titulo, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight">
                                        {{ $evento->titulo }}
                                    </p>
                                    @if($evento->direccion_evento)
                                        <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[200px] xl:max-w-xs">
                                            📍 {{ $evento->direccion_evento }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Iglesia --}}
                        <td class="px-4 py-4">
                            @if($evento->iglesia)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-bold
                                                text-white flex-shrink-0"
                                         style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                                        {{ strtoupper(substr($evento->iglesia->official_name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-slate-600 font-medium truncate max-w-[140px]">
                                        {{ $evento->iglesia->official_name }}
                                    </span>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">Sin iglesia</span>
                            @endif
                        </td>

                        {{-- Fecha --}}
                        <td class="px-4 py-4">
                            @if($evento->fecha_inicio)
                                @php
                                    $fecha = $evento->fecha_inicio instanceof \DateTimeInterface
                                        ? $evento->fecha_inicio
                                        : \Carbon\Carbon::parse($evento->fecha_inicio);
                                    $esHoy   = $fecha->isToday();
                                    $esFuturo= $fecha->isFuture();
                                    $esPasado= $fecha->isPast() && !$esHoy;
                                @endphp
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm font-medium {{ $esHoy ? 'text-violet-700' : ($esPasado ? 'text-slate-400' : 'text-slate-700') }}">
                                        {{ $fecha->format('d/m/Y') }}
                                    </span>
                                    <span class="text-[11px] {{ $esHoy ? 'text-violet-500 font-semibold' : 'text-slate-400' }}">
                                        @if($esHoy) 🟣 Hoy
                                        @elseif($esFuturo) {{ $fecha->format('H:i') }}
                                        @else Pasado
                                        @endif
                                    </span>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">—</span>
                            @endif
                        </td>

                        {{-- Tipo --}}
                        <td class="px-4 py-4 hidden lg:table-cell">
                            @if($evento->tipo_evento)
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-lg border"
                                      style="background:#EEF2FF; color:#4338CA; border-color:#C7D2FE;">
                                    {{ $evento->tipo_evento }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic">—</span>
                            @endif
                        </td>

                        {{-- Estado --}}
                        <td class="px-4 py-4">
                            @if($evento->estado === 'activo')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#FFF1F2; color:#9F1239;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Inactivo
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.eventos.show', $evento) }}"
                                   title="Ver detalle"
                                   class="p-2 rounded-lg text-slate-400 hover:text-violet-600 hover:bg-violet-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.eventos.edit', $evento) }}"
                                   title="Editar"
                                   class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
                                      class="form-eliminar-evento inline"
                                      data-titulo="{{ addslashes($evento->titulo) }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all btn-eliminar-evento"
                                            title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                                     style="background:#FAFAFF; border: 2px dashed #CBD5E1;">
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500 mb-1">Sin eventos registrados</p>
                                <a href="{{ route('admin.eventos.create') }}"
                                   class="text-xs font-medium transition-colors"
                                   style="color: #7c3aed;">
                                    Registrar primer evento →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Empty search state --}}
        <div id="empty-search" class="hidden flex flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                 style="background:#FAFAFF; border: 2px dashed #CBD5E1;">
                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Sin resultados</p>
            <p class="text-xs text-slate-400">Prueba con otro término de búsqueda</p>
        </div>
    </div>

    {{-- ── CARDS MÓVIL (< md) ── --}}
    <div class="md:hidden divide-y divide-slate-50" id="mobile-cards-container">
        @forelse($eventos as $evento)
            <div class="card-filtrable p-4 hover:bg-violet-50/20 transition-colors"
                 data-titulo="{{ strtolower($evento->titulo) }}"
                 data-iglesia="{{ strtolower($evento->iglesia->official_name ?? '') }}"
                 data-tipo="{{ strtolower($evento->tipo_evento ?? '') }}">

                {{-- Header --}}
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-sm font-bold
                                text-white flex-shrink-0 shadow-sm"
                         style="background: linear-gradient(135deg, #2d1b69, #7c3aed);">
                        {{ strtoupper(substr($evento->titulo, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 leading-tight truncate">
                            {{ $evento->titulo }}
                        </p>
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            @if($evento->tipo_evento)
                                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded-lg border"
                                      style="background:#EEF2FF; color:#4338CA; border-color:#C7D2FE;">
                                    {{ $evento->tipo_evento }}
                                </span>
                            @endif
                            @if($evento->estado === 'activo')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#FFF1F2; color:#9F1239;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Detalles --}}
                <div class="space-y-1.5 mb-3 pl-14">
                    @if($evento->iglesia)
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="truncate">{{ $evento->iglesia->official_name }}</span>
                        </div>
                    @endif
                    @if($evento->fecha_inicio)
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>
                                @if($evento->fecha_inicio instanceof \DateTimeInterface)
                                    {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                                @else
                                    {{ $evento->fecha_inicio }}
                                @endif
                            </span>
                        </div>
                    @endif
                    @if($evento->direccion_evento)
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span class="truncate">{{ $evento->direccion_evento }}</span>
                        </div>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="flex gap-2 pl-14">
                    <a href="{{ route('admin.eventos.show', $evento) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold
                              rounded-lg border border-slate-200 text-slate-600 bg-white
                              hover:bg-violet-50 hover:border-violet-200 hover:text-violet-700 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                    <a href="{{ route('admin.eventos.edit', $evento) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold
                              rounded-lg border border-slate-200 text-slate-600 bg-white
                              hover:bg-amber-50 hover:border-amber-200 hover:text-amber-700 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
                          class="form-eliminar-evento flex-1 flex"
                          data-titulo="{{ addslashes($evento->titulo) }}">
                        @csrf @method('DELETE')
                        <button type="button"
                                class="btn-eliminar-evento flex-1 inline-flex items-center justify-center gap-1.5
                                       px-3 py-2 text-xs font-semibold rounded-lg border border-slate-200
                                       text-slate-600 bg-white hover:bg-red-50 hover:border-red-200
                                       hover:text-red-700 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                     style="background:#FAFAFF; border: 2px dashed #CBD5E1;">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Sin eventos registrados</p>
                <a href="{{ route('admin.eventos.create') }}"
                   class="text-xs font-medium" style="color:#7c3aed;">
                    Registrar primer evento →
                </a>
            </div>
        @endforelse

        {{-- Empty mobile search --}}
        <div id="empty-search-mobile" class="hidden flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                 style="background:#FAFAFF; border: 2px dashed #CBD5E1;">
                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Sin resultados</p>
            <p class="text-xs text-slate-400 mt-0.5">Prueba con otro término</p>
        </div>
    </div>

    {{-- Paginación --}}
    @if($eventos->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $eventos->links() }}
        </div>
    @endif
</div>

{{-- ═══════════════════════════════════
     MODAL CONFIRMAR ELIMINAR
═══════════════════════════════════ --}}
<div id="modal-confirmar-eliminar"
     class="fixed inset-0 z-50 flex items-end sm:items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl p-6 w-full sm:max-w-sm mx-4 sm:mx-0 text-center">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
             style="background: #FEF2F2;">
            <svg class="w-7 h-7" style="color:#EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-base font-bold text-slate-800 mb-2">¿Eliminar evento?</h2>
        <p class="text-sm text-slate-500 mb-6 leading-relaxed" id="modal-eliminar-nombre">
            Esta acción no se puede deshacer.
        </p>
        <div class="flex gap-3">
            <button id="btn-cancelar-eliminar"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold
                           text-slate-700 bg-white hover:bg-slate-50 transition-all">
                Cancelar
            </button>
            <button id="btn-confirmar-eliminar"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-all
                           hover:opacity-90 active:scale-95"
                    style="background: linear-gradient(135deg, #DC2626, #EF4444);">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ── Modal eliminar ───────────────────────────────────────────────
(function () {
    var formAEliminar = null;
    function init() {
        var modal        = document.getElementById('modal-confirmar-eliminar');
        var nombreSpan   = document.getElementById('modal-eliminar-nombre');
        var btnCancelar  = document.getElementById('btn-cancelar-eliminar');
        var btnConfirmar = document.getElementById('btn-confirmar-eliminar');
        if (!modal) return;

        document.querySelectorAll('.btn-eliminar-evento').forEach(function (btn) {
            btn.addEventListener('click', function () {
                formAEliminar = btn.closest('form');
                var titulo = formAEliminar.getAttribute('data-titulo') || '';
                nombreSpan.textContent = '¿Seguro que deseas eliminar "' + titulo + '"? Esta acción no se puede deshacer.';
                modal.classList.remove('hidden');
            });
        });
        btnCancelar.addEventListener('click', function () { modal.classList.add('hidden'); formAEliminar = null; });
        btnConfirmar.addEventListener('click', function () { if (formAEliminar) formAEliminar.submit(); });
        modal.addEventListener('click', function (e) { if (e.target === modal) { modal.classList.add('hidden'); formAEliminar = null; } });
    }
    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', init) : init();
})();

// ── Filtro búsqueda cliente ──────────────────────────────────────
function filtrarTabla(query) {
    var q = query.toLowerCase().trim();

    var inp = document.getElementById('buscador-eventos');
    if (inp && inp.value !== query) inp.value = query;

    var btnClear = document.getElementById('btn-clear');
    if (btnClear) btnClear.classList.toggle('hidden', q.length === 0);

    // Tabla
    var filas = document.querySelectorAll('.evento-row-data');
    var visiblesTabla = 0;
    filas.forEach(function (fila) {
        var show = !q || fila.dataset.titulo.includes(q) || fila.dataset.iglesia.includes(q) || fila.dataset.tipo.includes(q);
        fila.style.display = show ? '' : 'none';
        if (show) visiblesTabla++;
    });
    var emptySearch = document.getElementById('empty-search');
    if (emptySearch) emptySearch.classList.toggle('hidden', !(filas.length > 0 && visiblesTabla === 0));

    // Cards
    var cards = document.querySelectorAll('.card-filtrable');
    var visiblesCards = 0;
    cards.forEach(function (card) {
        var show = !q || card.dataset.titulo.includes(q) || card.dataset.iglesia.includes(q) || card.dataset.tipo.includes(q);
        card.style.display = show ? '' : 'none';
        if (show) visiblesCards++;
    });
    var emptyMobile = document.getElementById('empty-search-mobile');
    if (emptyMobile) emptyMobile.classList.toggle('hidden', !(cards.length > 0 && visiblesCards === 0));
}

function limpiarBusqueda() {
    filtrarTabla('');
    var input = document.getElementById('buscador-eventos');
    if (input) input.focus();
}
</script>
@endpush

@endsection