@extends('layouts.admin')

@section('title', $evento->titulo)
@section('page-title', $evento->titulo)
@section('page-subtitle', $evento->tipo_evento ?? 'Evento')

@section('content')

@vite(['resources/css/admin/event/evento-show.css'])

{{-- Hero – título + estado + acciones rápidas --}}
<div class="evento-hero mb-6">
    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="min-w-0">
            {{-- Tipo chip --}}
            <span class="inline-block text-[10px] font-bold tracking-widest uppercase
                         text-indigo-300 bg-white/10 border border-white/15
                         px-3 py-1 rounded-full mb-3">
                {{ $evento->tipo_evento ?? 'Sin tipo' }}
            </span>
            <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight truncate">
                {{ $evento->titulo }}
            </h2>
            @if($evento->iglesia)
                <p class="text-indigo-200 text-xs sm:text-sm mt-1.5 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>
                    </svg>
                    {{ $evento->iglesia->nombre }}
                </p>
            @endif
        </div>

        {{-- Estado badge grande --}}
        <div class="flex-shrink-0">
            @if($evento->estado === 'activo')
                <div class="flex items-center gap-2 bg-green-500/20 border border-green-400/30 rounded-xl px-5 py-3">
                    <span class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse" aria-hidden="true"></span>
                    <span class="text-green-200 text-sm font-bold">Activo</span>
                </div>
            @else
                <div class="flex items-center gap-2 bg-red-500/20 border border-red-400/30 rounded-xl px-5 py-3">
                    <span class="w-2.5 h-2.5 bg-red-400 rounded-full" aria-hidden="true"></span>
                    <span class="text-red-200 text-sm font-bold">Inactivo</span>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Barra de acciones --}}
<div class="action-bar flex flex-wrap items-center gap-3 mb-6">
    <a href="{{ route('admin.eventos.edit', $evento) }}" class="btn-edit flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Editar Evento
    </a>

    <a href="{{ route('admin.eventos.index') }}" class="btn-back flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a lista
    </a>

    <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
          class="ml-auto"
          onsubmit="return confirm('¿Confirmas eliminar «{{ addslashes($evento->titulo) }}»? Esta acción no se puede deshacer.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-delete flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Eliminar
        </button>
    </form>
</div>

{{-- Grid de tarjetas de información --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

    {{-- Tarjeta 1 – Detalles principales --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon bg-indigo-50">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="info-card-title">Detalles del Evento</span>
        </div>

        <div class="data-row">
            <span class="data-label">Título</span>
            <span class="data-value font-semibold">{{ $evento->titulo }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Iglesia</span>
            <span class="data-value">{{ $evento->iglesia->nombre ?? '—' }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Tipo</span>
            <span class="data-value">
                <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-medium px-2.5 py-1 rounded-full">
                    {{ $evento->tipo_evento ?? '—' }}
                </span>
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Estado</span>
            <span class="data-value">
                @if($evento->estado === 'activo')
                    <span class="badge-activo">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                        Activo
                    </span>
                @else
                    <span class="badge-inactivo">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                        Inactivo
                    </span>
                @endif
            </span>
        </div>
        <div class="data-row">
            <span class="data-label">Creado</span>
            <span class="data-value text-slate-500 text-sm">
                {{ $evento->created_at->translatedFormat('d \d\e F \d\e Y') }}
            </span>
        </div>
    </div>

    {{-- Tarjeta 2 – Fechas y Ubicación --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-icon bg-amber-50">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="info-card-title">Fechas y Ubicación</span>
        </div>

        <div class="data-row">
            <span class="data-label">Inicio</span>
            <span class="data-value font-medium">
                @if($evento->fecha_inicio instanceof \DateTimeInterface)
                    {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                @elseif($evento->fecha_inicio)
                    {{ $evento->fecha_inicio }}
                @else
                    —
                @endif
            </span>
        </div>

        @if($evento->fecha_fin)
            <div class="data-row">
                <span class="data-label">Fin</span>
                <span class="data-value font-medium">
                    @if($evento->fecha_fin instanceof \DateTimeInterface)
                        {{ $evento->fecha_fin->format('d/m/Y H:i') }}
                    @else
                        {{ $evento->fecha_fin }}
                    @endif
                </span>
            </div>
        @endif

        <div class="data-row">
            <span class="data-label">Dirección</span>
            <span class="data-value">{{ $evento->direccion_evento ?? '—' }}</span>
        </div>

        <div class="data-row">
            <span class="data-label">Coordenadas</span>
            <span class="data-value font-mono text-slate-600">
                {{ $evento->latitud ?? '—' }}, {{ $evento->longitud ?? '—' }}
            </span>
        </div>

        <div class="px-5 py-4 bg-slate-50 border-t border-slate-100">
            <a href="https://www.google.com/maps/search/?api=1&query={{ $evento->latitud }},{{ $evento->longitud }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Abrir en Google Maps
            </a>
        </div>
    </div>

</div>

{{-- Descripción (si existe) --}}
@if($evento->descripcion)
    <div class="desc-card mb-6">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Descripción</span>
        </div>
        <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $evento->descripcion }}
        </p>
    </div>
@endif

{{-- Mapa --}}
<div class="info-card">
    <div class="info-card-header">
        <div class="info-card-icon bg-green-50">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
        </div>
        <span class="info-card-title">Ubicación del Evento</span>
    </div>
    <div id="show-map" class="h-64 md:h-80 w-full"></div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat  = {{ $evento->latitud ?? 2.9274 }};
    const lng  = {{ $evento->longitud ?? -75.2819 }};
    const title = @json($evento->titulo);
    const addr  = @json($evento->direccion_evento ?? 'Sin dirección registrada');
    const iglesia = @json($evento->iglesia->nombre ?? '');

    const map = L.map('show-map', { zoomControl: true }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
    }).addTo(map);

    // Ícono personalizado (similar al de iglesias, pero con color diferente)
    const icon = L.divIcon({
        className: '',
        html: `<div style="
            width:36px;height:36px;
            background:#8B5CF6;
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            border:4px solid white;
            box-shadow:0 4px 14px rgba(139,92,246,.4);
            display:flex;align-items:center;justify-content:center;
        "><span style="transform:rotate(45deg);color:white;font-size:16px;">📅</span></div>`,
        iconSize: [36, 36],
        iconAnchor: [18, 36],
        popupAnchor: [0, -40],
    });

    const popupContent = `
        <div style="min-width:220px;padding:4px 0;font-family:'Inter',sans-serif;">
            <p style="font-weight:700;color:#1E3A8A;font-size:14px;margin:0 0 6px;">${title}</p>
            <span style="display:inline-block;background:#EEF2FF;color:#4F46E5;font-size:11px;font-weight:600;padding:3px 9px;border-radius:999px;">
                ${iglesia || 'Evento independiente'}
            </span>
            <p style="font-size:12px;color:#475569;margin:8px 0 0;">📍 ${addr}</p>
        </div>`;

    L.marker([lat, lng], { icon })
        .addTo(map)
        .bindPopup(popupContent, { maxWidth: 280 })
        .openPopup();
});
</script>
@endpush

@endsection