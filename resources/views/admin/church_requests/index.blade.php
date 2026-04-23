@extends('layouts.admin')

@section('title', 'Solicitudes de Registro')
@section('page-title', 'Solicitudes de Registro')
@section('page-subtitle', 'Iglesias y organizaciones que desean aparecer en SER Neiva')

@section('content')

{{-- ── HERO ── --}}
<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 55%, #0369a1 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: radial-gradient(circle, #38bdf8, transparent 70%);"></div>
    </div>
    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-xl"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">⛪</div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Solicitudes de Registro</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(186,230,253,0.9);">
                Formularios enviados desde el sitio público
            </p>
        </div>
        <div class="flex gap-5 ml-12 sm:ml-0 flex-wrap">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $counts['total'] }}</p>
                <p class="text-xs mt-0.5" style="color:rgba(186,230,253,.85);">Total</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-yellow-300 leading-none">{{ $counts['pendiente'] }}</p>
                <p class="text-xs mt-0.5" style="color:rgba(186,230,253,.85);">Pendientes</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-green-300 leading-none">{{ $counts['aprobada'] }}</p>
                <p class="text-xs mt-0.5" style="color:rgba(186,230,253,.85);">Aprobadas</p>
            </div>
        </div>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="mb-4 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- ── FILTROS ── --}}
<div class="mb-5 flex flex-wrap gap-2">
    @foreach([''=>'Todas','pendiente'=>'Pendientes','revisada'=>'Revisadas','aprobada'=>'Aprobadas','rechazada'=>'Rechazadas'] as $val=>$label)
        <a href="{{ route('admin.church-requests.index', $val ? ['estado'=>$val] : []) }}"
           class="px-3.5 py-1.5 rounded-xl text-xs font-semibold border transition-all
                  {{ ($estado ?? '') === $val
                      ? 'bg-slate-800 text-white border-slate-800 shadow-sm'
                      : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400' }}">
            {{ $label }}
            @if($val === '') <span class="ml-1 opacity-60">({{ $counts['total'] }})</span>
            @elseif($val !== '') <span class="ml-1 opacity-60">({{ $counts[$val] }})</span>
            @endif
        </a>
    @endforeach
</div>

{{-- ── TABLA ── --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    @if($requests->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-400">
            <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm font-medium">No hay solicitudes{{ $estado ? ' con estado «'.$estado.'»' : '' }}</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Organización</th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Líder</th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">Contacto</th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Estado</th>
                        <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Fecha</th>
                        <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($requests as $req)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="px-5 py-4 text-slate-400 font-mono text-xs">{{ $req->id }}</td>
                        <td class="px-5 py-4">
                            <p class="font-semibold text-slate-800 leading-tight">{{ $req->nombre_organizacion }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $req->email }}</p>
                        </td>
                        <td class="px-5 py-4 text-slate-600 hidden sm:table-cell">{{ $req->lider_religioso }}</td>
                        <td class="px-5 py-4 text-slate-600 hidden md:table-cell">{{ $req->telefono }}</td>
                        <td class="px-5 py-4">{!! $req->estadoBadge() !!}</td>
                        <td class="px-5 py-4 text-slate-400 text-xs hidden lg:table-cell">
                            {{ $req->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.church-requests.show', $req) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 text-slate-700 hover:border-slate-400 transition-all">
                                Ver
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $requests->links() }}
        </div>
        @endif
    @endif
</div>

@endsection
