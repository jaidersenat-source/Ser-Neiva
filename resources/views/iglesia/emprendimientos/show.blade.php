@extends('layouts.iglesia')

@php
    $isActivo = ($emprendimiento->activo ?? false) ? true : false;
    $iglesiaNombre = $emprendimiento->iglesia->official_name ?? null;
@endphp

@section('title', $emprendimiento->nombre)
@section('page-title', $emprendimiento->nombre)
@section('page-subtitle', $emprendimiento->categoria ?? 'Emprendimiento')

@section('content')

<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #065f46 0%, #059669 45%, #10b981 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-72 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#34d399"/>
            <polygon points="115,0 200,0 200,120 170,120" fill="#6ee7b7"/>
            <polygon points="155,0 200,0 200,55" fill="#a7f3d0"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">

            <div class="flex items-start gap-4 min-w-0">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-2xl overflow-hidden shadow-lg"
                     style="background: rgba(255,255,255,0.18); backdrop-filter: blur(8px); border:2px solid rgba(255,255,255,0.25);">
                    @if(!empty($emprendimiento->imagen_principal))
                        <img src="{{ asset('storage/' . $emprendimiento->imagen_principal) }}" alt="{{ $emprendimiento->nombre }}" class="w-full h-full object-cover block">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-3xl font-extrabold text-white"
                             style="background: rgba(255,255,255,0.18);">
                            {{ strtoupper(substr($emprendimiento->nombre, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="min-w-0 pt-1">
                    <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight">{{ $emprendimiento->nombre }}</h2>
                    @if($iglesiaNombre)
                        <p class="mt-1.5 text-xs flex items-center gap-1.5" style="color: rgba(167,243,208,0.9);">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                            </svg>
                            {{ $iglesiaNombre }}
                        </p>
                    @endif

                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-full"
                              style="background:rgba(255,255,255,0.12); color:white;">
                            {{ $emprendimiento->categoria ?? '—' }}
                        </span>
                        @if($emprendimiento->telefono)
                            <a href="tel:{{ $emprendimiento->telefono }}" class="inline-flex items-center gap-1 text-[11px] font-semibold px-2.5 py-1 rounded-full bg-white/10 text-white">
                                📞 {{ $emprendimiento->telefono }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex sm:flex-col items-center sm:items-end gap-3 flex-shrink-0">
                @if($isActivo)
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                          style="background:#ffffff;color:#065f46;border:1px solid rgba(6,95,70,0.08);box-shadow:0 6px 18px rgba(6,95,70,0.06);">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Activo
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold"
                          style="background:#ffffff;color:#7f1d1d;border:1px solid rgba(220,38,38,0.06);box-shadow:0 6px 18px rgba(220,38,38,0.04);">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        Inactivo
                    </span>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('iglesia.emprendimientos.edit', $emprendimiento) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:opacity-95"
                       style="background:#ffffff;color:#065f46;border:1px solid rgba(6,95,70,0.08);box-shadow:0 6px 18px rgba(6,95,70,0.06);">
                        Editar
                    </a>
                    <a href="{{ route('iglesia.emprendimientos.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:opacity-95"
                       style="background:rgba(255,255,255,0.95);color:#044e3f;border:1px solid rgba(6,95,70,0.05);">
                        Volver
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="lg:col-span-2 flex flex-col gap-5">

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F5FDF4;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#DCFCE7;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Detalles</p>
                    <p class="text-xs text-slate-400">Información principal del emprendimiento</p>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 divide-y divide-slate-50 sm:divide-y-0">

                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Nombre</p>
                        <p class="text-sm font-bold text-slate-800">{{ $emprendimiento->nombre }}</p>
                    </div>

                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Categoría</p>
                        <p class="text-sm text-slate-600">{{ $emprendimiento->categoria ?? '—' }}</p>
                    </div>

                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Contacto</p>
                        <p class="text-sm text-slate-600">{{ $emprendimiento->email ?? '—' }}</p>
                    </div>

                    <div class="py-3 border-b border-slate-50">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Teléfono</p>
                        <p class="text-sm text-slate-600">{{ $emprendimiento->telefono ?? '—' }}</p>
                    </div>

                    <div class="py-3 sm:col-span-2">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Registrado el</p>
                        <p class="text-xs text-slate-400">{{ $emprendimiento->created_at->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>

                </div>
            </div>
        </div>

        @if($emprendimiento->descripcion)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFFBEB;">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FEF3C7;">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Descripción</p>
                </div>
                <div class="p-5">
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $emprendimiento->descripcion }}</p>
                </div>
            </div>
        @endif

    </div>

    <div class="flex flex-col gap-5">

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#DCFCE7;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Ubicación</p>
            </div>
            <div class="p-4 space-y-3">
                @if($emprendimiento->direccion)
                    <div class="flex items-start gap-2.5 p-3 rounded-xl" style="background:#F0FDF4; border:1px solid #DCFCE7;">
                        <p class="text-xs font-semibold text-emerald-800 leading-relaxed">{{ $emprendimiento->direccion }}</p>
                    </div>
                @endif

                <div class="p-3 rounded-xl" style="background:#F8FAFF; border:1px solid #E2E8F0;">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Coordenadas GPS</p>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center gap-1 text-xs font-mono font-semibold text-slate-600 bg-white px-2.5 py-1 rounded-lg border border-slate-200">LAT {{ $emprendimiento->latitud ?? '—' }}</span>
                        <span class="inline-flex items-center gap-1 text-xs font-mono font-semibold text-slate-600 bg-white px-2.5 py-1 rounded-lg border border-slate-200">LNG {{ $emprendimiento->longitud ?? '—' }}</span>
                    </div>
                    @if($emprendimiento->latitud && $emprendimiento->longitud)
                        <a href="https://maps.google.com/?q={{ $emprendimiento->latitud }},{{ $emprendimiento->longitud }}" target="_blank" rel="noopener" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold rounded-xl text-white" style="background: linear-gradient(135deg, #065f46, #10b981);">
                            Ver en Google Maps
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Ubicación en el mapa</p>
            </div>
            <div id="show-map" class="h-56 w-full"></div>
        </div>

        <div class="rounded-2xl p-4" style="background:#FFF1F2; border:1px solid #FECDD3;">
            <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Zona de peligro</p>
            <p class="text-xs text-red-500 mb-3 leading-relaxed">Esta acción eliminará permanentemente el emprendimiento y no se puede deshacer.</p>
            <form method="POST" action="{{ route('iglesia.emprendimientos.destroy', $emprendimiento) }}" class="form-eliminar-show" data-nombre="{{ addslashes($emprendimiento->nombre) }}">
                @csrf @method('DELETE')
                <button type="button" class="btn-eliminar-show w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl" style="background: linear-gradient(135deg, #DC2626, #EF4444);">Eliminar este emprendimiento</button>
            </form>
        </div>

    </div>

</div>

{{-- Modal confirmar eliminar --}}
<div id="modal-eliminar-show" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl p-6 w-full sm:max-w-sm mx-4 sm:mx-0 text-center">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:#FEF2F2;">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <h2 class="text-base font-bold text-slate-800 mb-2">¿Eliminar emprendimiento?</h2>
        <p class="text-sm text-slate-500 mb-6 leading-relaxed" id="modal-show-nombre">Esta acción no se puede deshacer.</p>
        <div class="flex gap-3">
            <button id="btn-cancelar-show" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">Cancelar</button>
            <button id="btn-confirmar-show" class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 active:scale-95 transition-all" style="background: linear-gradient(135deg, #DC2626, #EF4444);">Sí, eliminar</button>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $emprendimiento->latitud ?? 2.9274 }};
    const lng = {{ $emprendimiento->longitud ?? -75.2819 }};
    const title = @json($emprendimiento->nombre);
    const addr = @json($emprendimiento->direccion ?? 'Sin dirección registrada');
    const ig = @json($iglesiaNombre ?? '');

    const map = L.map('show-map', { zoomControl: true }).setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    const icon = L.divIcon({ className:'', html:`<div style="width:34px;height:34px;background:linear-gradient(135deg,#065f46,#10b981);border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:14px;">🏷️</span></div>`, iconSize:[34,34], iconAnchor:[17,34]});
    L.marker([lat,lng], { icon }).addTo(map).bindPopup(`<div style="font-weight:700;color:#065f46;margin-bottom:4px;">${title}</div>${ig?`<div style="font-size:12px;color:#4B5563;margin-bottom:4px;">${ig}</div>`:''}<div style="font-size:11px;color:#6B7280;">📍 ${addr}</div>`).openPopup();

    // Modal eliminar
    var modal    = document.getElementById('modal-eliminar-show');
    var nombreEl = document.getElementById('modal-show-nombre');
    var formEl   = null;

    document.querySelectorAll('.form-eliminar-show .btn-eliminar-show').forEach(function(btn){
        btn.addEventListener('click', function(){
            formEl = btn.closest('form');
            var nombre = formEl.getAttribute('data-nombre') || '';
            nombreEl.textContent = '¿Seguro que deseas eliminar "' + nombre + '"? Esta acción no se puede deshacer.';
            modal.classList.remove('hidden');
        });
    });
    document.getElementById('btn-cancelar-show').addEventListener('click', function(){ modal.classList.add('hidden'); formEl=null; });
    document.getElementById('btn-confirmar-show').addEventListener('click', function(){ if(formEl) formEl.submit(); });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ modal.classList.add('hidden'); formEl=null; } });
});
</script>
@endpush

@endsection
