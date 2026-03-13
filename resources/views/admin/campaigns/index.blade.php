@extends('layouts.admin')

@section('title', 'Campañas de Correo')
@section('page-title', 'Campañas de Correo')
@section('page-subtitle', 'Gestiona y envía correos masivos a las iglesias')

@section('content')

{{-- HERO STRIP --}}
<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0f4c3a 0%, #065f46 45%, #059669 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: radial-gradient(circle, #6ee7b7, transparent 70%);"></div>
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#6ee7b7"/>
            <polygon points="110,0 200,0 200,120 170,120" fill="#a7f3d0"/>
            <polygon points="150,0 200,0 200,60" fill="#d1fae5"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Campañas de Correo</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(167,243,208,0.9);">
                Envía correos masivos a las iglesias registradas
            </p>
        </div>

        <div class="flex gap-3 ml-12 sm:ml-0">
            <a href="{{ route('admin.campaigns.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
                      text-emerald-900 transition-all hover:opacity-90 active:scale-95"
               style="background: rgba(255,255,255,0.95); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Campaña
            </a>
        </div>
    </div>
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl mb-5"
         style="background: #F0FDF4; border: 1px solid #BBF7D0;">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl mb-5"
         style="background: #FFF1F2; border: 1px solid #FECDD3;">
        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
    </div>
@endif

{{-- Tabla de campañas --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    @if($campaigns->count())
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100" style="background: #F8FAFC;">
                    <th class="text-left px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">#</th>
                    <th class="text-left px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Asunto</th>
                    <th class="text-left px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">Filtro</th>
                    <th class="text-center px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">Destinatarios</th>
                    <th class="text-center px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Estado</th>
                    <th class="text-left px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400 hidden lg:table-cell">Fecha</th>
                    <th class="text-right px-5 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($campaigns as $campaign)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3 text-xs text-slate-400 font-mono">{{ $campaign->id }}</td>
                        <td class="px-5 py-3">
                            <p class="font-semibold text-slate-800 truncate max-w-[250px]">{{ $campaign->subject }}</p>
                        </td>
                        <td class="px-5 py-3 hidden md:table-cell">
                            @if($campaign->filter_type === 'all')
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-bold rounded-full"
                                      style="background:#EFF6FF; color:#1E3A8A;">Todas</span>
                            @elseif($campaign->filter_type === 'city')
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-bold rounded-full"
                                      style="background:#FEF9C3; color:#854D0E;">{{ $campaign->city }}</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 text-[11px] font-bold rounded-full"
                                      style="background:#F3E8FF; color:#6B21A8;">Selección manual</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center hidden sm:table-cell">
                            <span class="font-bold text-slate-700">{{ $campaign->recipients_count }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if($campaign->isSent())
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Enviada
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-full"
                                      style="background:#FEF9C3; color:#854D0E;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Borrador
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-xs text-slate-400 hidden lg:table-cell">
                            {{ $campaign->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.campaigns.show', $campaign) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-semibold rounded-lg
                                      transition-all hover:opacity-80"
                               style="background:#EFF6FF; color:#1E3A8A;">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-5 py-3 border-t border-slate-100">
            {{ $campaigns->links() }}
        </div>
    @else
        <div class="text-center py-16 px-6">
            <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4"
                 style="background:#F0FDF4;">
                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-sm font-bold text-slate-700 mb-1">No hay campañas aún</p>
            <p class="text-xs text-slate-400 mb-4">Crea tu primera campaña de correo para comenzar.</p>
            <a href="{{ route('admin.campaigns.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white
                      transition-all hover:opacity-90"
               style="background: linear-gradient(135deg, #065f46, #059669);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Crear campaña
            </a>
        </div>
    @endif
</div>

@endsection
