@extends('layouts.iglesia')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen de tu iglesia')

@section('content')

{{-- ═══════════════════════
     WELCOME BANNER
═══════════════════════ --}}
<div class="relative mb-5 rounded-2xl overflow-hidden"
     style="background:linear-gradient(135deg,#0a1f5c 0%,#0f2d7a 45%,#0e6ba8 100%);">

    {{-- Decorative shapes --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-72 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="70,0 200,0 200,120 130,120" fill="#48cae4"/>
            <polygon points="110,0 200,0 200,120 165,120" fill="#90e0ef"/>
            <polygon points="150,0 200,0 200,55" fill="#caf0f8"/>
        </svg>
        <div class="absolute -bottom-8 -left-8 w-48 h-48 rounded-full opacity-10"
             style="background:radial-gradient(circle,#90e0ef,transparent 70%);"></div>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

        <div class="flex items-center gap-4 min-w-0">
            {{-- Foto o inicial --}}
            @if(isset($iglesia) && $iglesia->photo)
                <img src="{{ Storage::url($iglesia->photo) }}" alt="Foto"
                     class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-2xl object-cover shadow-lg"
                     style="border:2px solid rgba(255,255,255,.25);">
            @else
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-2xl flex items-center justify-center
                            text-2xl font-extrabold text-white shadow-lg"
                     style="background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:2px solid rgba(255,255,255,.2);">
                    {{ strtoupper(substr($iglesia->official_name ?? auth()->user()->name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0">
                <p class="text-[10px] font-bold tracking-widest uppercase mb-1"
                   style="color:rgba(144,224,239,.8);">Portal de gestión</p>
                <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight truncate">
                    {{ $iglesia->official_name ?? 'Mi Iglesia' }}
                </h2>
                <p class="text-sm mt-1 truncate" style="color:rgba(191,219,254,.85);">
                    Bienvenido, {{ auth()->user()->name }}
                    @if($iglesia && $iglesia->municipality)
                        &nbsp;·&nbsp; 📍 {{ $iglesia->municipality }}
                    @endif
                </p>
            </div>
        </div>

        {{-- CTAs hero --}}
        <div class="flex flex-wrap gap-2 flex-shrink-0">
            <a href="{{ route('iglesia.eventos.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all hover:opacity-90 active:scale-95"
               style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2);backdrop-filter:blur(8px);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo evento
            </a>
            <a href="{{ route('iglesia.perfil.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all hover:opacity-90 active:scale-95"
               style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.12);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Mi perfil
            </a>
        </div>
    </div>
</div>

{{-- ═══════════════════════
     STAT CARDS
═══════════════════════ --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">

    {{-- Eventos --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
                <svg class="w-5 h-5" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full"
                  style="background:#EFF6FF;color:#1E3A8A;">Total</span>
        </div>
        <div>
            <p class="text-3xl font-extrabold leading-none" style="color:#1E3A8A;">{{ $totalEventos }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Eventos registrados</p>
        </div>
        <a href="{{ route('iglesia.eventos.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold transition-opacity hover:opacity-70"
           style="color:#1E3A8A;">
            Ver todos
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Emprendimientos --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#F0FDF4;">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full"
                  style="background:#F0FDF4;color:#059669;">Total</span>
        </div>
        <div>
            <p class="text-3xl font-extrabold leading-none text-emerald-600">{{ $totalEmprendimientos }}</p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Emprendimientos</p>
        </div>
        <a href="{{ route('iglesia.emprendimientos.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 transition-opacity hover:opacity-70">
            Ver todos
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Ayudas sociales --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FAF5FF;">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full"
                  style="background:#FAF5FF;color:#7C3AED;">Social</span>
        </div>
        <div>
            <p class="text-3xl font-extrabold leading-none text-violet-500">
                {{ $iglesia ? $iglesia->ayudas()->count() : 0 }}
            </p>
            <p class="text-xs text-slate-400 mt-1 font-medium">Ayudas sociales</p>
        </div>
        <a href="{{ route('iglesia.perfil.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-violet-500 transition-opacity hover:opacity-70">
            Ver perfil
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

</div>

{{-- ════════════════════════════
     PANELES: EVENTOS | EMPRENDIMIENTOS
════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    {{-- ── Próximos Eventos ── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Próximos eventos</p>
            </div>
            <a href="{{ route('iglesia.eventos.index') }}"
               class="text-xs font-semibold transition-opacity hover:opacity-70" style="color:#0e6ba8;">Ver todos</a>
        </div>

        <div class="divide-y divide-slate-50 flex-1">
            @forelse($proximosEventos as $ev)
                <a href="{{ route('iglesia.eventos.show', $ev) }}"
                   class="flex items-center gap-3 px-5 py-3.5 hover:bg-blue-50/30 transition-colors group">
                    <div class="w-11 h-11 rounded-xl flex flex-col items-center justify-center flex-shrink-0 text-center"
                         style="background:linear-gradient(135deg,#0a1f5c,#0e6ba8);">
                        <span class="text-[9px] font-bold uppercase leading-none"
                              style="color:rgba(144,224,239,.85);">
                            {{ $ev->fecha_inicio?->translatedFormat('M') }}
                        </span>
                        <span class="text-base font-extrabold text-white leading-tight">
                            {{ $ev->fecha_inicio?->format('d') }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-blue-700 transition-colors">
                            {{ $ev->titulo }}
                        </p>
                        @if($ev->lugar ?? null)
                            <p class="text-xs text-slate-400 truncate mt-0.5">📍 {{ $ev->lugar }}</p>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-10 text-center px-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3"
                         style="background:#F8FAFF;border:2px dashed #CBD5E1;">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">Sin eventos próximos</p>
                    <p class="text-xs text-slate-300 mt-1">Crea el primero desde el botón de abajo</p>
                </div>
            @endforelse
        </div>

        <div class="px-5 py-3 border-t border-slate-50 mt-auto" style="background:#F8FAFF;">
            <a href="{{ route('iglesia.eventos.create') }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold
                      text-white rounded-xl transition-all hover:opacity-90 active:scale-95"
               style="background:linear-gradient(135deg,#0a1f5c,#0e6ba8);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Crear nuevo evento
            </a>
        </div>
    </div>

    {{-- ── Últimos Emprendimientos ── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#F0FDF4;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Últimos emprendimientos</p>
            </div>
            <a href="{{ route('iglesia.emprendimientos.index') }}"
               class="text-xs font-semibold text-emerald-600 transition-opacity hover:opacity-70">Ver todos</a>
        </div>

        <div class="divide-y divide-slate-50 flex-1">
            @forelse($ultimosEmprendimientos as $em)
                <a href="{{ route('iglesia.emprendimientos.show', $em) }}"
                   class="flex items-center gap-3 px-5 py-3.5 hover:bg-emerald-50/30 transition-colors group">
                    @if($em->photo ?? null)
                        <img src="{{ Storage::url($em->photo) }}" alt=""
                             class="w-11 h-11 rounded-xl object-cover flex-shrink-0 border border-slate-100">
                    @else
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-sm font-extrabold
                                    text-white flex-shrink-0"
                             style="background:linear-gradient(135deg,#065f46,#059669);">
                            {{ strtoupper(substr($em->nombre ?? '?', 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-emerald-700 transition-colors">
                            {{ $em->nombre }}
                        </p>
                        @if($em->categoria ?? null)
                            <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $em->categoria }}</p>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-10 text-center px-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3"
                         style="background:#F8FAFF;border:2px dashed #CBD5E1;">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-400">Sin emprendimientos aún</p>
                    <p class="text-xs text-slate-300 mt-1">Registra el primero desde el botón de abajo</p>
                </div>
            @endforelse
        </div>

        <div class="px-5 py-3 border-t border-slate-50 mt-auto" style="background:#F8FAFF;">
            <a href="{{ route('iglesia.emprendimientos.create') }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold
                      text-white rounded-xl transition-all hover:opacity-90 active:scale-95"
               style="background:linear-gradient(135deg,#065f46,#059669);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Crear emprendimiento
            </a>
        </div>
    </div>

</div>

@endsection
