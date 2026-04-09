@extends('layouts.admin')

@php
    $nombre   = $iglesia->official_name ?? 'Sin nombre';
    $denom    = $iglesia->denomination ?? '';
    $status   = $iglesia->church_status ?? 'Active';
    $isActiva = $status === 'Active';
@endphp

@section('title', $nombre)
@section('page-title', $nombre)
@section('page-subtitle', $denom)

@section('content')

{{-- ═══════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════ --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0a1f5c 0%, #0f2d7a 45%, #0e6ba8 100%);">

    {{-- Decorative shapes --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-72 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="70,0 200,0 200,120 130,120" fill="#48cae4"/>
            <polygon points="110,0 200,0 200,120 165,120" fill="#90e0ef"/>
            <polygon points="150,0 200,0 200,55" fill="#caf0f8"/>
        </svg>
        <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full opacity-10"
             style="background: radial-gradient(circle, #48cae4, transparent 70%);"></div>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">

            {{-- Left: foto + nombre --}}
            <div class="flex items-start gap-4 min-w-0">
                @if($iglesia->photo)
                    <img src="{{ Storage::url($iglesia->photo) }}"
                         alt="Foto de {{ $nombre }}"
                         class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 object-cover rounded-2xl
                                border-2 shadow-lg" style="border-color:rgba(255,255,255,0.3);">
                @else
                    <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-2xl flex items-center
                                justify-center text-2xl font-extrabold text-white shadow-lg flex-shrink-0"
                         style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
                                border: 2px solid rgba(255,255,255,0.2);">
                        {{ strtoupper(substr($nombre, 0, 1)) }}
                    </div>
                @endif

                <div class="min-w-0 pt-1">
                    <span class="inline-block text-[10px] font-bold tracking-widest uppercase
                                 px-3 py-1 rounded-full mb-2"
                          style="color:#90e0ef; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15);">
                        {{ $denom }}
                    </span>
                    <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight">{{ $nombre }}</h2>
                    @if($iglesia->address)
                        <p class="mt-1.5 text-xs flex items-center gap-1.5" style="color: rgba(144,224,239,0.85);">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $iglesia->address }}
                        </p>
                    @endif

                    {{-- Pills --}}
                    <div class="flex flex-wrap gap-2 mt-3">
                        @if($iglesia->approx_members)
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(255,255,255,0.12); color:white;">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                ~{{ number_format($iglesia->approx_members) }} miembros
                            </span>
                        @endif
                        @if($iglesia->ayudas && $iglesia->ayudas->count())
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(72,202,228,0.2); color:#90e0ef;">
                                🤝 {{ $iglesia->ayudas->count() }} ayuda(s) social(es)
                            </span>
                        @endif
                        @if($iglesia->municipality)
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(255,255,255,0.1); color:white;">
                                📍 {{ $iglesia->municipality }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: estado + acciones --}}
            <div class="flex sm:flex-col items-center sm:items-end gap-3 flex-shrink-0">
                @if($isActiva)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                         style="background:rgba(34,197,94,0.2); border:1px solid rgba(74,222,128,0.3); color:#86efac;">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Activa
                    </div>
                @elseif($status === 'Suspended')
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                         style="background:rgba(245,158,11,0.2); border:1px solid rgba(251,191,36,0.3); color:#fde68a;">
                        <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                        Suspendida
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                         style="background:rgba(239,68,68,0.2); border:1px solid rgba(252,165,165,0.3); color:#fca5a5;">
                        <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                        Inactiva
                    </div>
                @endif

                {{-- Acciones hero --}}
                <div class="flex gap-2">
                    <a href="{{ route('admin.iglesias.edit', $iglesia) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold
                              transition-all hover:opacity-90 active:scale-95"
                       style="background:rgba(255,255,255,0.15); color:white; border:1px solid rgba(255,255,255,0.2); backdrop-filter:blur(8px);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('admin.iglesias.index') }}"
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

{{-- ═══════════════════════════════════════════════════
     LAYOUT DE 2 COLUMNAS
═══════════════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ══════════════════════
         COLUMNA IZQUIERDA (2/3)
    ══════════════════════ --}}
    <div class="lg:col-span-2 flex flex-col gap-5">

        {{-- ── 1. INFORMACIÓN GENERAL ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Información General</p>
                    <p class="text-xs text-slate-400">Datos básicos de la congregación</p>
                </div>
            </div>

            {{-- Grid de datos 2 cols --}}
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-0 divide-y divide-slate-50 sm:divide-y-0">
                @php
                    $infoItems = [
                        ['label' => 'Nombre oficial',       'value' => $iglesia->official_name ?? null, 'bold' => true],
                        ['label' => 'Denominación',          'value' => $iglesia->denomination ?? null, 'chip' => true, 'chipColor' => 'blue'],
                        ['label' => 'Carácter confesional', 'value' => $iglesia->confessional_character ?? null],
                        ['label' => 'Miembros aprox.',      'value' => $iglesia->approx_members ? '~'.number_format($iglesia->approx_members).' personas' : null],
                        ['label' => 'Fecha de fundación',   'value' => $iglesia->foundation_date ? (is_string($iglesia->foundation_date) ? $iglesia->foundation_date : $iglesia->foundation_date->translatedFormat('d \d\e F \d\e Y')) : null],
                        ['label' => 'Ubicación específica', 'value' => $iglesia->specific_location ?? null],
                        ['label' => 'Registrada el',        'value' => $iglesia->created_at->translatedFormat('d \d\e F \d\e Y'), 'muted' => true],
                    ];
                @endphp

                @foreach($infoItems as $item)
                    <div class="py-3 flex flex-col gap-0.5 border-b border-slate-50 last:border-0 sm:last:border-0">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            {{ $item['label'] }}
                        </span>
                        @if(!empty($item['value']))
                            @if(!empty($item['bold']))
                                <span class="text-sm font-semibold text-slate-800">{{ $item['value'] }}</span>
                            @elseif(!empty($item['chip']))
                                <span class="inline-block w-fit mt-0.5 px-2.5 py-1 text-xs font-semibold rounded-lg border"
                                      style="background:#EFF6FF; color:#1D4ED8; border-color:#BFDBFE;">
                                    {{ $item['value'] }}
                                </span>
                            @elseif(!empty($item['muted']))
                                <span class="text-xs text-slate-400">{{ $item['value'] }}</span>
                            @else
                                <span class="text-sm text-slate-600">{{ $item['value'] }}</span>
                            @endif
                        @else
                            <span class="text-xs text-slate-300 italic">No registrado</span>
                        @endif
                    </div>
                @endforeach

                {{-- Estado ocupa celda completa --}}
                <div class="py-3 flex flex-col gap-0.5 border-b border-slate-50 last:border-0 sm:col-span-2 sm:border-t">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Estado de la iglesia</span>
                    <div class="mt-1">
                        @if($isActiva)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full"
                                  style="background:#F0FDF4; color:#166534;">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Activa
                            </span>
                        @elseif($status === 'Suspended')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full"
                                  style="background:#FFFBEB; color:#92400E;">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Suspendida
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full"
                                  style="background:#FFF1F2; color:#9F1239;">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                Inactiva
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 2. PASTOR / LÍDER ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FEFCE8;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#FEF9C3;">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Pastor o Líder Principal</p>
                    <p class="text-xs text-slate-400">Representante de la congregación</p>
                </div>
            </div>

            <div class="p-5">
                {{-- Avatar del pastor --}}
                @if($iglesia->pastor_full_name)
                    <div class="flex items-center gap-3 mb-4 p-3 rounded-xl" style="background:#FAFAFA; border:1px solid #F1F5F9;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                             style="background: linear-gradient(135deg, #D97706, #F59E0B);">
                            {{ strtoupper(substr($iglesia->pastor_full_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">
                                {{ $iglesia->pastor_full_name }}
                            </p>
                            @if($iglesia->leadership_period_type)
                                <p class="text-xs text-slate-400">{{ $iglesia->leadership_period_type }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-0 divide-y divide-slate-50 sm:divide-y-0">
                    @php
                        $pastorBirth = $iglesia->pastor_birth_date ?? null;
                        $pastorItems = [
                            ['label' => 'Documento',        'value' => ($iglesia->pastor_document_type && $iglesia->pastor_document_number) ? $iglesia->pastor_document_type.': '.$iglesia->pastor_document_number : null],
                            ['label' => 'Fecha de nacimiento', 'value' => $pastorBirth ? (is_string($pastorBirth) ? $pastorBirth : $pastorBirth->translatedFormat('d \d\e F \d\e Y')) : null],
                            ['label' => 'Teléfono',          'value' => $iglesia->pastor_phone ?? null, 'tel' => true],
                            ['label' => 'Email',             'value' => $iglesia->pastor_email ?? null, 'email' => true],
                        ];
                    @endphp
                    @foreach($pastorItems as $item)
                        <div class="py-3 flex flex-col gap-0.5 border-b border-slate-50 last:border-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $item['label'] }}</span>
                            @if(!empty($item['value']))
                                @if(!empty($item['tel']))
                                    <a href="tel:{{ $item['value'] }}" class="text-sm font-medium" style="color:#0e6ba8;">
                                        📞 {{ $item['value'] }}
                                    </a>
                                @elseif(!empty($item['email']))
                                    <a href="mailto:{{ $item['value'] }}" class="text-sm font-medium break-all" style="color:#0e6ba8;">
                                        ✉ {{ $item['value'] }}
                                    </a>
                                @else
                                    <span class="text-sm text-slate-600">{{ $item['value'] }}</span>
                                @endif
                            @else
                                <span class="text-xs text-slate-300 italic">No registrado</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── 3. LÍDER DE MUJERES (condicional) ── --}}
        @if($iglesia->women_leader_full_name)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFF0F6;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#FFE4EF;">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Líder de Mujeres</p>
                    <p class="text-xs text-slate-400">Responsable del ministerio femenino</p>
                </div>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                <div class="py-3 flex flex-col gap-0.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nombre</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $iglesia->women_leader_full_name }}</span>
                </div>
                <div class="py-3 flex flex-col gap-0.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Teléfono</span>
                    @if($iglesia->women_leader_phone)
                        <a href="tel:{{ $iglesia->women_leader_phone }}" class="text-sm font-medium" style="color:#0e6ba8;">
                            📞 {{ $iglesia->women_leader_phone }}
                        </a>
                    @else
                        <span class="text-xs text-slate-300 italic">No registrado</span>
                    @endif
                </div>
                <div class="py-3 flex flex-col gap-0.5 sm:col-span-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Email</span>
                    @if($iglesia->women_leader_email)
                        <a href="mailto:{{ $iglesia->women_leader_email }}" class="text-sm font-medium break-all" style="color:#0e6ba8;">
                            ✉ {{ $iglesia->women_leader_email }}
                        </a>
                    @else
                        <span class="text-xs text-slate-300 italic">No registrado</span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- ── 4. DATOS JURÍDICOS (condicional) ── --}}
        @if($iglesia->legal_registration_type || $iglesia->legal_registration_number)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FAF5FF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#F3E8FF;">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Datos Jurídicos</p>
                    <p class="text-xs text-slate-400">Registro legal e institucional</p>
                </div>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-0">
                @php
                    $legalItems = [
                        ['label' => 'Tipo de registro',    'value' => $iglesia->legal_registration_type ?? null],
                        ['label' => 'Número de registro',  'value' => $iglesia->legal_registration_number ?? null],
                        ['label' => 'Entidad que otorga',  'value' => $iglesia->legal_entity_granting ?? null],
                        ['label' => 'N° Resolución',       'value' => $iglesia->resolution_number ?? null],
                        ['label' => 'Fecha resolución',    'value' => $iglesia->resolution_date ? (is_string($iglesia->resolution_date) ? $iglesia->resolution_date : $iglesia->resolution_date->translatedFormat('d \d\e F \d\e Y')) : null],
                        ['label' => 'N° Expediente',       'value' => $iglesia->file_number ?? null],
                        ['label' => 'Tipo personería',     'value' => $iglesia->legal_personality_type ?? null],
                    ];
                @endphp
                @foreach($legalItems as $item)
                    <div class="py-3 flex flex-col gap-0.5 border-b border-slate-50 last:border-0">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $item['label'] }}</span>
                        @if(!empty($item['value']))
                            <span class="text-sm text-slate-600">{{ $item['value'] }}</span>
                        @else
                            <span class="text-xs text-slate-300 italic">No registrado</span>
                        @endif
                    </div>
                @endforeach
            </div>
            @if($iglesia->legal_notes)
                <div class="mx-5 mb-5 p-3 rounded-xl" style="background:#FAF5FF; border:1px solid #E9D5FF;">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-violet-500 mb-1">Notas jurídicas</p>
                    <p class="text-sm text-violet-900 leading-relaxed">{{ $iglesia->legal_notes }}</p>
                </div>
            @endif
        </div>
        @endif

        {{-- ── 5. OBSERVACIONES ── --}}
        @if($iglesia->additional_notes)
        <div class="rounded-2xl p-5" style="background:#FFFBEB; border:1px solid #FDE68A;">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Observaciones Adicionales</span>
            </div>
            <p class="text-sm text-amber-900 leading-relaxed">{{ $iglesia->additional_notes }}</p>
        </div>
        @endif

        {{-- ── HORARIO DE ATENCIÓN ── --}}
        @if($iglesia->schedule_weekdays || $iglesia->schedule_weekends)
        <div class="rounded-2xl p-5" style="background:#F0FDF4; border:1px solid #BBF7D0;">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-xs font-bold text-green-700 uppercase tracking-wider">Horario de Atención</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @if($iglesia->schedule_weekdays)
                <div class="flex items-start gap-2.5 rounded-xl p-3" style="background:white; border:1px solid #DCFCE7;">
                    <span class="text-base flex-shrink-0">📅</span>
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-0.5">Lunes – Viernes</p>
                        <p class="text-sm font-semibold text-green-800">{{ $iglesia->schedule_weekdays }}</p>
                    </div>
                </div>
                @endif
                @if($iglesia->schedule_weekends)
                <div class="flex items-start gap-2.5 rounded-xl p-3" style="background:white; border:1px solid #DCFCE7;">
                    <span class="text-base flex-shrink-0">🕐</span>
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-0.5">Sábado – Domingo</p>
                        <p class="text-sm font-semibold text-green-800">{{ $iglesia->schedule_weekends }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>{{-- /col izquierda --}}

    {{-- ══════════════════════
         COLUMNA DERECHA (1/3)
    ══════════════════════ --}}
    <div class="flex flex-col gap-5">

        {{-- ── CONTACTO ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0F9FF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#E0F2FE;">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Contacto</p>
            </div>
            <div class="p-4 space-y-3">
                @php
                    $contactItems = [
                        ['icon' => '📞', 'label' => 'Teléfono fijo',       'value' => $iglesia->phone_landline ?? null, 'tel' => true],
                        ['icon' => '📱', 'label' => 'Celular',              'value' => $iglesia->phone_mobile ?? null, 'tel' => true],
                        ['icon' => '✉',  'label' => 'Correo general',       'value' => $iglesia->email ?? null, 'email' => true],
                        ['icon' => '📧', 'label' => 'Correo institucional', 'value' => $iglesia->correo_institucional ?? null, 'email' => true],
                        ['icon' => '🌐', 'label' => 'Web / Red social',     'value' => $iglesia->website_or_social ?? null, 'web' => true],
                    ];
                @endphp
                @foreach($contactItems as $c)
                    @if(!empty($c['value']))
                        <div class="flex items-start gap-3 p-3 rounded-xl transition-colors hover:bg-slate-50"
                             style="border:1px solid #F1F5F9;">
                            <span class="text-lg leading-none flex-shrink-0 mt-0.5">{{ $c['icon'] }}</span>
                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">
                                    {{ $c['label'] }}
                                </p>
                                @if(!empty($c['tel']))
                                    <a href="tel:{{ $c['value'] }}" class="text-sm font-medium" style="color:#0e6ba8;">
                                        {{ $c['value'] }}
                                    </a>
                                @elseif(!empty($c['email']))
                                    <a href="mailto:{{ $c['value'] }}" class="text-sm font-medium break-all" style="color:#0e6ba8;">
                                        {{ $c['value'] }}
                                    </a>
                                @elseif(!empty($c['web']))
                                    <a href="{{ Str::startsWith($c['value'], 'http') ? $c['value'] : 'https://'.$c['value'] }}"
                                       target="_blank" rel="noopener"
                                       class="text-sm font-medium break-all" style="color:#0e6ba8;">
                                        {{ $c['value'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                @if(!($iglesia->phone_landline || $iglesia->phone_mobile || $iglesia->email || $iglesia->correo_institucional || $iglesia->website_or_social))
                    <p class="text-xs text-slate-400 italic text-center py-2">Sin datos de contacto registrados</p>
                @endif
            </div>
        </div>

        {{-- ── ACCESO AL PORTAL ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#7C3AED,#A855F7);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Acceso al portal</p>
            </div>
            <div class="p-4 space-y-3">
                @if($linkedUser)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400">Usuario</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $linkedUser->username }}</p>
                        </div>
                        <a href="{{ route('admin.iglesias.edit', $iglesia) }}" class="text-xs font-semibold px-3 py-2 rounded-lg bg-violet-50 text-violet-700 border border-violet-100">
                            Editar credenciales
                        </a>
                    </div>
                    <p class="text-xs text-slate-400">Contraseña: <span class="font-semibold">(no se muestra por seguridad)</span></p>
                @else
                    <p class="text-sm text-slate-600">Sin cuenta de acceso configurada.</p>
                    <a href="{{ route('admin.iglesias.edit', $iglesia) }}" class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-lg bg-violet-50 text-violet-700 border border-violet-100">
                        Crear credenciales
                    </a>
                @endif
            </div>
        </div>

        {{-- ── UBICACIÓN ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#DCFCE7;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Ubicación</p>
            </div>
            <div class="p-4 space-y-2">
                @php
                    $ubicItems = [
                        ['label'=>'Dirección',     'value'=>$iglesia->address ?? null],
                        ['label'=>'Barrio',        'value'=>$iglesia->neighborhood ?? null],
                        ['label'=>'Comuna',        'value'=>$iglesia->comuna ?? null],
                        ['label'=>'Municipio',     'value'=>$iglesia->municipality ?? null],
                        ['label'=>'Ciudad',        'value'=>$iglesia->city ?? 'Neiva'],
                        
                    ];
                @endphp
                @foreach($ubicItems as $u)
                    @if(!empty($u['value']))
                        <div class="flex justify-between items-start gap-2 py-1.5 border-b border-slate-50 last:border-0">
                            <span class="text-xs text-slate-400 flex-shrink-0">{{ $u['label'] }}</span>
                            <span class="text-xs font-semibold text-slate-700 text-right">{{ $u['value'] }}</span>
                        </div>
                    @endif
                @endforeach

                {{-- Coords --}}
                <div class="mt-2 p-3 rounded-xl" style="background:#F8FAFF; border:1px solid #E2E8F0;">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Coordenadas GPS</p>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-600 bg-white px-2 py-1 rounded-lg border border-slate-200">
                            Lat: {{ $iglesia->latitud }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-600 bg-white px-2 py-1 rounded-lg border border-slate-200">
                            Lng: {{ $iglesia->longitud }}
                        </span>
                    </div>
                    <a href="https://maps.google.com/?q={{ $iglesia->latitud }},{{ $iglesia->longitud }}"
                       target="_blank" rel="noopener"
                       class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold
                              rounded-xl text-white transition-all hover:opacity-90 active:scale-95"
                       style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Ver en Google Maps
                    </a>
                </div>
            </div>
        </div>

        {{-- ── MINISTERIOS ── --}}
        @php
            $ministeriosData = $iglesia->ministries ?? null;
            if (is_string($ministeriosData)) $ministeriosData = json_decode($ministeriosData, true) ?? [];
            $ministeriosLabels = [
                'Children Ministry' => ['icon'=>'👶','label'=>'Niños'],
                'Worship'           => ['icon'=>'🎵','label'=>'Alabanza'],
                'Family'            => ['icon'=>'🏠','label'=>'Familia'],
                'Couples'           => ['icon'=>'💑','label'=>'Parejas'],
                'Youth'             => ['icon'=>'🌟','label'=>'Jóvenes'],
                'Dance'             => ['icon'=>'💃','label'=>'Danza'],
                'Elderly'           => ['icon'=>'🧓','label'=>'Adulto Mayor'],
                'Women'             => ['icon'=>'🌸','label'=>'Mujeres'],
                'Intercession'      => ['icon'=>'🙏','label'=>'Intercesión'],
                'Prison Support'    => ['icon'=>'🔗','label'=>'Carcelario'],
                'Missionaries'      => ['icon'=>'🌍','label'=>'Misioneros'],
                'Counseling'        => ['icon'=>'💬','label'=>'Consejería'],
            ];
        @endphp
        @if(!empty($ministeriosData))
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50" style="background:#EEF2FF;">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:#E0E7FF;">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Ministerios</p>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-100 border border-indigo-200 px-2 py-0.5 rounded-full">
                    {{ count($ministeriosData) }}
                </span>
            </div>
            <div class="p-4 flex flex-wrap gap-2">
                @foreach((array) $ministeriosData as $min)
                    @php $md = $ministeriosLabels[$min] ?? ['icon'=>'✝','label'=>$min]; @endphp
                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold rounded-xl border"
                          style="background:#EEF2FF; color:#3730A3; border-color:#C7D2FE;">
                        {{ $md['icon'] }} {{ $md['label'] }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── AYUDAS SOCIALES ── --}}
        @if($iglesia->ayudas && $iglesia->ayudas->count())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                         style="background:#DCFCE7;">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Ayudas Sociales</p>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-100 border border-green-200 px-2 py-0.5 rounded-full">
                    {{ $iglesia->ayudas->count() }}
                </span>
            </div>
            <div class="p-4 space-y-2">
                @foreach($iglesia->ayudas as $ayuda)
                    <div class="flex items-start gap-2.5 p-2.5 rounded-xl transition-colors hover:bg-green-50"
                         style="border:1px solid #DCFCE7;">
                        <span class="text-lg leading-none flex-shrink-0 mt-0.5">{{ $ayuda->icono ?? '🤝' }}</span>
                        <div>
                            <p class="text-xs font-bold text-slate-800">{{ $ayuda->nombre }}</p>
                            @if($ayuda->descripcion)
                                <p class="text-[11px] text-slate-400 mt-0.5 leading-snug">
                                    {{ Str::limit($ayuda->descripcion, 50) }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── MAPA ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Ubicación en el mapa</p>
            </div>
            <div id="show-map" class="h-56 w-full"></div>
        </div>

        {{-- ── ELIMINAR (zona peligrosa) ── --}}
        <div class="rounded-2xl p-4" style="background:#FFF1F2; border:1px solid #FECDD3;">
            <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Zona de peligro</p>
            <p class="text-xs text-red-500 mb-3 leading-relaxed">
                Esta acción eliminará permanentemente la iglesia y no se puede deshacer.
            </p>
            <form method="POST" action="{{ route('admin.iglesias.destroy', $iglesia) }}"
                  onsubmit="return confirm('¿Confirmas eliminar «{{ addslashes($iglesia->official_name ?? '') }}»? Esta acción no se puede deshacer.')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold
                               text-white rounded-xl transition-all hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #DC2626, #EF4444);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Eliminar esta iglesia
                </button>
            </form>
        </div>

    </div>{{-- /col derecha --}}

</div>{{-- /grid --}}

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat   = {{ $iglesia->latitud }};
    const lng   = {{ $iglesia->longitud }};
    const name  = @json($iglesia->official_name);
    const addr  = @json($iglesia->address);
    const denom = @json($iglesia->denomination);
    const ayudas= @json($iglesia->ayudas->map(fn($a) => ['icono' => $a->icono ?? '🤝', 'nombre' => $a->nombre]));

    const map = L.map('show-map', { zoomControl: true }).setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="width:34px;height:34px;background:linear-gradient(135deg,#0a1f5c,#0e6ba8);border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 3px 14px rgba(10,31,92,.45);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);color:white;font-size:13px;font-weight:900;">✝</span></div>`,
        iconSize: [34,34], iconAnchor: [17,34], popupAnchor: [0,-38],
    });

    const ayudasHtml = ayudas.length
        ? `<div style="margin-top:8px;display:flex;flex-wrap:wrap;gap:3px;">
               ${ayudas.map(a=>`<span style="background:#F0FDF4;color:#166534;border:1px solid #BBF7D0;border-radius:20px;padding:2px 7px;font-size:10px;font-weight:600;">${a.icono} ${a.nombre}</span>`).join('')}
           </div>` : '';

    L.marker([lat,lng],{icon}).addTo(map).bindPopup(
        `<div style="font-family:system-ui,sans-serif;min-width:190px;padding:2px 0;">
            <p style="font-weight:700;color:#0a1f5c;font-size:13px;margin:0 0 4px;">${name}</p>
            <span style="display:inline-block;background:#EFF6FF;color:#3B82F6;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;margin-bottom:7px;">${denom}</span>
            <p style="font-size:11px;color:#64748B;margin:0;">📍 ${addr}</p>${ayudasHtml}
        </div>`, { maxWidth: 280 }
    ).openPopup();
});
</script>
@endpush

@endsection