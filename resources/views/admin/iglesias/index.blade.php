@extends('layouts.admin')

@section('title', 'Iglesias')
@section('page-title', 'Gestión de Iglesias')
@section('page-subtitle', 'Administra el directorio de iglesias registradas')

@section('content')

@php
    $ayudasFiltro = \App\Models\Ayuda::orderBy('nombre')->get();
@endphp

{{-- ═══════════════════════════════════
     HEADER HERO STRIP
═══════════════════════════════════ --}}
<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0a1f5c 0%, #0f2d7a 40%, #0e6ba8 100%);">
    {{-- Decorative diagonal shapes --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: linear-gradient(135deg, #00b4d8, #90e0ef);"></div>
        <div class="absolute top-4 right-16 w-32 h-32 rounded-full opacity-10"
             style="background: #48cae4;"></div>
        <div class="absolute -bottom-4 right-32 w-20 h-20 rounded-full opacity-20"
             style="background: #00b4d8;"></div>
        {{-- Diagonal line decorations --}}
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#48cae4"/>
            <polygon points="110,0 200,0 200,120 170,120" fill="#90e0ef"/>
            <polygon points="150,0 200,0 200,60" fill="#caf0f8"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Directorio de Iglesias</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(144,224,239,0.85);">
                Gestión y administración del directorio de congregaciones registradas
            </p>
        </div>

        {{-- Stats inline --}}
        <div class="flex gap-4 ml-12 sm:ml-0">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $iglesias->total() }}</p>
                <p class="text-xs mt-0.5" style="color: rgba(144,224,239,0.8);">Total</p>
            </div>
            <div class="w-px" style="background: rgba(255,255,255,0.15);"></div>
            <div class="text-center">
                <p class="text-2xl font-extrabold leading-none" style="color: #48cae4;">
                    {{ $iglesias->where('church_status', 'Active')->count() }}
                </p>
                <p class="text-xs mt-0.5" style="color: rgba(144,224,239,0.8);">Activas</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     TOOLBAR DE FILTROS Y ACCIONES
═══════════════════════════════════ --}}
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    {{-- Filtros izquierda --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3 flex-wrap">

        {{-- Buscador --}}
        <div class="relative">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="buscador-iglesias"
                   placeholder="Buscar iglesia, pastor, denominación, jurídico…"
                   aria-label="Buscar iglesia"
                   oninput="filtrarTabla(this.value)"
                   class="pl-10 pr-9 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                          shadow-sm w-full sm:w-64 focus:outline-none focus:ring-2
                          focus:border-blue-500 text-slate-700 transition-all placeholder-slate-400"
                   style="focus-ring-color: rgba(14,107,168,0.2);">
            <button id="btn-clear" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                    onclick="limpiarBusqueda()" aria-label="Limpiar búsqueda">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Municipio --}}
        <form method="GET" action="{{ route('admin.iglesias.index') }}" id="form-municipio" class="flex items-center gap-1.5">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <select name="municipality"
                        onchange="document.getElementById('form-municipio').submit()"
                        class="pl-8 pr-8 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                               shadow-sm focus:outline-none focus:ring-2 focus:border-blue-500
                               text-slate-700 transition-all cursor-pointer appearance-none">
                    <option value="">Todos los municipios</option>
                    @foreach($municipios as $mun)
                        <option value="{{ $mun }}" {{ request('municipality') === $mun ? 'selected' : '' }}>
                            {{ $mun }}
                        </option>
                    @endforeach
                </select>
                <svg class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            @if(request('municipality'))
                <a href="{{ route('admin.iglesias.index') }}"
                   class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Quitar filtro">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            @endif
        </form>

        {{-- Filtro ayuda --}}
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <select id="filtro-ayuda"
                    class="pl-8 pr-8 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                           shadow-sm focus:outline-none focus:ring-2 focus:border-blue-500
                           text-slate-700 transition-all cursor-pointer appearance-none">
                <option value="">Todas las ayudas</option>
                @foreach($ayudasFiltro as $ayuda)
                    <option value="{{ $ayuda->id }}">{{ $ayuda->nombre }}</option>
                @endforeach
            </select>
            <svg class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    {{-- Acciones derecha --}}
    <div class="flex items-center gap-2 flex-shrink-0">

        {{-- Nueva iglesia --}}
        <a href="{{ route('admin.iglesias.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl
                  shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95"
           style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="hidden xs:inline sm:inline">Nueva Iglesia</span>
        </a>

        {{-- Export dropdown --}}
        <div class="relative" id="export-group">
            <button type="button" id="export-toggle"
                    aria-haspopup="true" aria-expanded="false"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl
                           border border-slate-200 bg-white text-slate-700 shadow-sm
                           hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span class="hidden sm:inline">Exportar</span>
                <svg class="w-3 h-3 text-slate-400 transition-transform duration-200" id="export-chevron"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="export-dropdown"
                 aria-hidden="true"
                 class="absolute right-0 top-full mt-2 w-56 rounded-2xl bg-white border border-slate-100
                        shadow-xl z-50 overflow-hidden opacity-0 scale-95 pointer-events-none
                        transition-all duration-150 origin-top-right"
                 style="display:none;">
                <div class="p-1.5">
                    <a href="{{ route('iglesias.export.pdf', request()->query()) }}"
                       target="_blank"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: #FEF2F2;">
                            <svg class="w-4 h-4" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Descargar PDF</p>
                            <p class="text-xs text-slate-400">Reporte A4 horizontal</p>
                        </div>
                    </a>

                    <div class="my-1 border-t border-slate-100"></div>

                    <a href="{{ route('iglesias.export.excel', request()->query()) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: #F0FDF4;">
                            <svg class="w-4 h-4" style="color: #22C55E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Descargar Excel</p>
                            <p class="text-xs text-slate-400">Formato .xlsx con estilos</p>
                        </div>
                    </a>

                    @if(request()->hasAny(['estado', 'denominacion', 'comuna', 'ayuda_id']))
                        <div class="mx-2 mt-1.5 mb-0.5 flex items-center gap-1.5 text-xs text-blue-600
                                    bg-blue-50 rounded-lg px-3 py-2">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Incluye filtros activos
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     PANEL PRINCIPAL — TABLA DESKTOP
═══════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Tabla desktop (md+) --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full" id="iglesias-table">
            <thead>
                <tr class="border-b border-slate-100" style="background: #F8FAFF;">
                    <th class="text-left text-xs font-700 text-slate-500 uppercase tracking-wider px-6 py-4">
                        Iglesia
                    </th>
                    <th class="text-left text-xs font-700 text-slate-500 uppercase tracking-wider px-4 py-4">
                        Denominación
                    </th>
                    <th class="text-left text-xs font-700 text-slate-500 uppercase tracking-wider px-4 py-4 hidden lg:table-cell">
                        Ubicación
                    </th>
                    <th class="text-left text-xs font-700 text-slate-500 uppercase tracking-wider px-4 py-4 hidden xl:table-cell">
                        Pastor / Sacerdote
                    </th>
                    <th class="text-left text-xs font-700 text-slate-500 uppercase tracking-wider px-4 py-4">
                        Estado
                    </th>
                    <th class="text-right text-xs font-700 text-slate-500 uppercase tracking-wider px-6 py-4">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="tabla-body">
                @forelse($iglesias as $iglesia)
                    <tr class="iglesia-row-data group hover:bg-blue-50/30 transition-colors duration-100"
                        data-nombre="{{ strtolower($iglesia->official_name ?? '') }}"
                        data-denominacion="{{ strtolower($iglesia->denomination ?? '') }}"
                        data-pastor="{{ strtolower($iglesia->pastor_full_name ?? '') }}"
                        data-comuna="{{ strtolower($iglesia->specific_location ?? $iglesia->comuna ?? '') }}"
                        data-municipality="{{ strtolower($iglesia->municipality ?? '') }}"
                        data-ayudas="{{ implode(',', $iglesia->ayudas->pluck('id')->toArray()) }}"
                        data-juridico="{{ strtolower(implode(' ', array_filter([$iglesia->legal_registration_type, $iglesia->legal_registration_number, $iglesia->legal_entity_granting, $iglesia->legal_personality_type]))) }}"
                        data-tiene-juridico="{{ (!empty($iglesia->legal_registration_type) || !empty($iglesia->legal_registration_number)) ? '1' : '0' }}">

                        {{-- Nombre + dirección --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Avatar --}}
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold
                                            text-white flex-shrink-0 shadow-sm"
                                     style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                                    {{ strtoupper(substr($iglesia->official_name ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight searchable-nombre">
                                        {{ $iglesia->official_name }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[200px] xl:max-w-xs">
                                        {{ $iglesia->address }}
                                    </p>
                                    @if($iglesia->municipality)
                                        <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-semibold
                                                     px-2 py-0.5 rounded-full border"
                                              style="background:#EFF6FF; color:#1D4ED8; border-color:#BFDBFE;">
                                            📍 {{ $iglesia->municipality }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Denominación --}}
                        <td class="px-4 py-4">
                            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-lg border"
                                  style="background:#F0F9FF; color:#0369A1; border-color:#BAE6FD;">
                                {{ $iglesia->denomination }}
                            </span>
                            <p class="text-xs text-slate-400 mt-1.5">
                                <span class="font-medium text-slate-500">{{ $iglesia->approx_members ?? '—' }}</span>
                                <span> miembros</span>
                            </p>
                        </td>

                        {{-- Ubicación --}}
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <p class="text-sm text-slate-600 font-medium">
                                {{ $iglesia->specific_location ?? $iglesia->comuna ?? '—' }}
                            </p>
                        </td>

                        {{-- Pastor --}}
                        <td class="px-4 py-4 hidden xl:table-cell">
                            <p class="text-sm text-slate-600">
                                {{ $iglesia->pastor_full_name ?? '—' }}
                            </p>
                        </td>

                        {{-- Estado --}}
                        <td class="px-4 py-4">
                            @if($iglesia->church_status === 'Active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    Activa
                                </span>
                            @elseif($iglesia->church_status === 'Suspended')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#FFFBEB; color:#92400E;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Suspendida
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#FFF1F2; color:#9F1239;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Inactiva
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.iglesias.show', $iglesia) }}"
                                   title="Ver detalle"
                                   class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.iglesias.edit', $iglesia) }}"
                                   title="Editar"
                                   class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.iglesias.destroy', $iglesia) }}"
                                      class="form-eliminar-iglesia inline"
                                      data-nombre="{{ addslashes($iglesia->official_name ?? '') }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all btn-eliminar-iglesia"
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
                                     style="background:#F8FAFF; border: 2px dashed #CBD5E1;">
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500 mb-1">Sin iglesias registradas</p>
                                <a href="{{ route('admin.iglesias.create') }}"
                                   class="text-xs font-medium transition-colors"
                                   style="color: #0e6ba8;">
                                    Registrar primera iglesia →
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
                 style="background:#F8FAFF; border: 2px dashed #CBD5E1;">
                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Sin resultados</p>
            <p class="text-xs text-slate-400">Prueba con otro término de búsqueda</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════
         CARDS MÓVIL (< md)
    ═══════════════════════════════════ --}}
    <div class="md:hidden divide-y divide-slate-50" id="mobile-cards-container">
        @forelse($iglesias as $iglesia)
            <div class="iglesia-card card-filtrable p-4 hover:bg-blue-50/20 transition-colors"
                 data-nombre="{{ strtolower($iglesia->official_name ?? '') }}"
                 data-denominacion="{{ strtolower($iglesia->denomination ?? '') }}"
                 data-pastor="{{ strtolower($iglesia->pastor_full_name ?? '') }}"
                 data-comuna="{{ strtolower($iglesia->specific_location ?? $iglesia->comuna ?? '') }}"
                 data-ayudas="{{ implode(',', $iglesia->ayudas->pluck('id')->toArray()) }}"
                 data-juridico="{{ strtolower(implode(' ', array_filter([$iglesia->legal_registration_type, $iglesia->legal_registration_number, $iglesia->legal_entity_granting, $iglesia->legal_personality_type]))) }}"
                 data-tiene-juridico="{{ (!empty($iglesia->legal_registration_type) || !empty($iglesia->legal_registration_number)) ? '1' : '0' }}">

                {{-- Header --}}
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-sm font-bold
                                text-white flex-shrink-0 shadow-sm"
                         style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                        {{ strtoupper(substr($iglesia->official_name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 leading-tight truncate">
                            {{ $iglesia->official_name }}
                        </p>
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded-lg border"
                                  style="background:#F0F9FF; color:#0369A1; border-color:#BAE6FD;">
                                {{ $iglesia->denomination }}
                            </span>
                            @if($iglesia->church_status === 'Active')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Activa
                                </span>
                            @elseif($iglesia->church_status === 'Suspended')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#FFFBEB; color:#92400E;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Suspendida
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#FFF1F2; color:#9F1239;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Inactiva
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Detalles --}}
                <div class="space-y-1.5 mb-3 pl-14">
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span class="truncate">{{ $iglesia->address }}</span>
                    </div>
                    @if($iglesia->pastor_full_name)
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="truncate">{{ $iglesia->pastor_full_name }}</span>
                        </div>
                    @endif
                    @php $tel = $iglesia->phone_mobile ?: $iglesia->phone_landline; @endphp
                    @if($tel)
                        <div class="flex items-center gap-2 text-xs">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:{{ $tel }}" style="color:#0e6ba8;" class="font-medium">{{ $tel }}</a>
                        </div>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="flex gap-2 pl-14">
                    <a href="{{ route('admin.iglesias.show', $iglesia) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold
                              rounded-lg border border-slate-200 text-slate-600 bg-white hover:bg-blue-50
                              hover:border-blue-200 hover:text-blue-700 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                    <a href="{{ route('admin.iglesias.edit', $iglesia) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold
                              rounded-lg border border-slate-200 text-slate-600 bg-white hover:bg-amber-50
                              hover:border-amber-200 hover:text-amber-700 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.iglesias.destroy', $iglesia) }}"
                          class="form-eliminar-iglesia flex-1 flex"
                          data-nombre="{{ addslashes($iglesia->official_name ?? '') }}">
                        @csrf @method('DELETE')
                        <button type="button"
                                class="btn-eliminar-iglesia flex-1 inline-flex items-center justify-center gap-1.5
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
                     style="background:#F8FAFF; border: 2px dashed #CBD5E1;">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Sin iglesias registradas</p>
                <a href="{{ route('admin.iglesias.create') }}"
                   class="text-xs font-medium" style="color:#0e6ba8;">
                    Registrar primera iglesia →
                </a>
            </div>
        @endforelse

        {{-- Empty mobile search --}}
        <div id="empty-search-mobile" class="hidden flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                 style="background:#F8FAFF; border: 2px dashed #CBD5E1;">
                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Sin resultados</p>
            <p class="text-xs text-slate-400 mt-0.5">Prueba con otro término</p>
        </div>
    </div>

    {{-- Paginación --}}
    @if($iglesias->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            {{ $iglesias->links() }}
        </div>
    @endif
</div>

{{-- ═══════════════════════════════════
     MODAL CONFIRMAR ELIMINAR
═══════════════════════════════════ --}}
<div id="modal-confirmar-eliminar"
     class="fixed inset-0 z-50 flex items-end sm:items-center justify-center hidden">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
    {{-- Panel --}}
    <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl p-6 w-full sm:max-w-sm mx-4 sm:mx-0 text-center
                transform transition-all duration-200">
        {{-- Icono --}}
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
             style="background: #FEF2F2;">
            <svg class="w-7 h-7" style="color:#EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-base font-bold text-slate-800 mb-2">¿Eliminar iglesia?</h2>
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
        var modal       = document.getElementById('modal-confirmar-eliminar');
        var nombreSpan  = document.getElementById('modal-eliminar-nombre');
        var btnCancelar = document.getElementById('btn-cancelar-eliminar');
        var btnConfirmar= document.getElementById('btn-confirmar-eliminar');
        if (!modal) return;

        document.querySelectorAll('.btn-eliminar-iglesia').forEach(function (btn) {
            btn.addEventListener('click', function () {
                formAEliminar = btn.closest('form');
                var nombre = formAEliminar.getAttribute('data-nombre') || '';
                nombreSpan.textContent = '¿Seguro que deseas eliminar "' + nombre + '"? Esta acción no se puede deshacer.';
                modal.classList.remove('hidden');
            });
        });
        btnCancelar.addEventListener('click', function () { modal.classList.add('hidden'); formAEliminar = null; });
        btnConfirmar.addEventListener('click', function () { if (formAEliminar) formAEliminar.submit(); });
        // Cerrar con backdrop
        modal.addEventListener('click', function(e) { if (e.target === modal) { modal.classList.add('hidden'); formAEliminar = null; } });
    }
    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', init) : init();
})();

// ── Export dropdown ──────────────────────────────────────────────
(function () {
    var toggle   = document.getElementById('export-toggle');
    var dropdown = document.getElementById('export-dropdown');
    var chevron  = document.getElementById('export-chevron');
    if (!toggle || !dropdown) return;

    function open() {
        dropdown.style.display = 'block';
        requestAnimationFrame(function() {
            dropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
            dropdown.classList.add('opacity-100', 'scale-100');
        });
        toggle.setAttribute('aria-expanded', 'true');
        if (chevron) chevron.style.transform = 'rotate(180deg)';
    }
    function close() {
        dropdown.classList.remove('opacity-100', 'scale-100');
        dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
        toggle.setAttribute('aria-expanded', 'false');
        if (chevron) chevron.style.transform = '';
        setTimeout(function() { dropdown.style.display = 'none'; }, 150);
    }

    var isOpen = false;
    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        isOpen = !isOpen;
        isOpen ? open() : close();
    });
    document.addEventListener('click', function() { if (isOpen) { isOpen = false; close(); } });
    dropdown.addEventListener('click', function(e) { e.stopPropagation(); });
})();

// ── Filtro búsqueda cliente ──────────────────────────────────────
function filtrarTabla(query) {
    var q = query.toLowerCase().trim();
    var ayudaSeleccionada = (document.getElementById('filtro-ayuda') || {}).value || '';

    var inp = document.getElementById('buscador-iglesias');
    if (inp && inp.value !== query) inp.value = query;

    var btnClear = document.getElementById('btn-clear');
    if (btnClear) btnClear.classList.toggle('hidden', q.length === 0);

    // Detectar búsqueda de datos jurídicos
    var esBusquedaJuridica = q.length > 2 && (
        q.includes('juridic') || q.includes('jur\u00eddic') ||
        q.includes('datos jur') || q.includes('registrad') ||
        q.includes('personeria') || q.includes('person\u00e9r') ||
        q.includes('resoluc') || q.includes('personali')
    );

    // Tabla
    var filas = document.querySelectorAll('.iglesia-row-data');
    var visiblesTabla = 0;
    filas.forEach(function(fila) {
        var txt = !q || fila.dataset.nombre.includes(q) || fila.dataset.denominacion.includes(q) ||
                  fila.dataset.pastor.includes(q) || fila.dataset.comuna.includes(q) ||
                  (fila.dataset.juridico || '').includes(q) ||
                  (esBusquedaJuridica && fila.dataset.tieneJuridico === '1');
        var ay  = !ayudaSeleccionada || (fila.dataset.ayudas || '').split(',').includes(ayudaSeleccionada);
        var show = txt && ay;
        fila.style.display = show ? '' : 'none';
        if (show) visiblesTabla++;
    });
    var emptySearch = document.getElementById('empty-search');
    if (emptySearch) emptySearch.classList.toggle('hidden', !(filas.length > 0 && visiblesTabla === 0));

    // Cards
    var cards = document.querySelectorAll('.card-filtrable');
    var visiblesCards = 0;
    cards.forEach(function(card) {
        var txt = !q || card.dataset.nombre.includes(q) || card.dataset.denominacion.includes(q) ||
                  card.dataset.pastor.includes(q) || card.dataset.comuna.includes(q) ||
                  (card.dataset.juridico || '').includes(q) ||
                  (esBusquedaJuridica && card.dataset.tieneJuridico === '1');
        var ay  = !ayudaSeleccionada || (card.dataset.ayudas || '').split(',').includes(ayudaSeleccionada);
        var show = txt && ay;
        card.style.display = show ? '' : 'none';
        if (show) visiblesCards++;
    });
    var emptyMobile = document.getElementById('empty-search-mobile');
    if (emptyMobile) emptyMobile.classList.toggle('hidden', !(cards.length > 0 && visiblesCards === 0));
}

function limpiarBusqueda() {
    filtrarTabla('');
    var input = document.getElementById('buscador-iglesias');
    if (input) input.focus();
}

document.addEventListener('DOMContentLoaded', function() {
    var filtroAyuda = document.getElementById('filtro-ayuda');
    if (filtroAyuda) {
        filtroAyuda.addEventListener('change', function() {
            filtrarTabla((document.getElementById('buscador-iglesias') || {}).value || '');
        });
    }
});
</script>
@endpush

@endsection