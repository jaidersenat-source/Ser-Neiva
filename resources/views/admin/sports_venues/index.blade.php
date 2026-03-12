@extends('layouts.admin')

@section('title', 'Escenarios Deportivos')
@section('page-title', 'Escenarios Deportivos')
@section('page-subtitle', 'Canchas y espacios deportivos disponibles para iglesias')

@section('content')

{{-- Toolbar --}}
<div class="toolbar mb-4 gap-3">
    <div class="search-wrap hidden sm:flex">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="buscador-venues"
               placeholder="Buscar escenario..."
               aria-label="Buscar escenario"
               oninput="filtrarTabla(this.value)">
        <button id="btn-clear" class="hidden text-slate-400 hover:text-slate-600 transition-colors"
                onclick="limpiarBusqueda()" aria-label="Limpiar búsqueda">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="toolbar-right">
        <a href="{{ route('admin.sports_venues.create') }}" class="btn-primary">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="btn-label">Nuevo Escenario</span>
        </a>
    </div>
</div>

{{-- Tabla --}}
<div class="card overflow-hidden">
    <table class="data-table w-full" id="tabla-venues">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th class="hidden md:table-cell">Dirección</th>
                <th class="hidden lg:table-cell">Contacto</th>
                <th class="hidden lg:table-cell">Disponible</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($venues as $venue)
                <tr class="venue-row" data-nombre="{{ strtolower($venue->name) }} {{ strtolower($venue->address) }}">
                    <td class="text-slate-400 text-xs font-mono">{{ $venue->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center
                                        text-white text-sm font-bold"
                                 style="background: #EA580C;">⚽</div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm leading-tight">{{ $venue->name }}</p>
                                <p class="text-xs text-slate-400 md:hidden mt-0.5">{{ $venue->address }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="hidden md:table-cell text-sm text-slate-600">{{ $venue->address }}</td>
                    <td class="hidden lg:table-cell text-sm text-slate-600">{{ $venue->contact ?: '–' }}</td>
                    <td class="hidden lg:table-cell">
                        @if($venue->available_for_churches)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                         bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                Sí
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                         bg-slate-100 text-slate-500">
                                No
                            </span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.sports_venues.edit', $venue) }}"
                               class="btn-icon-sm" title="Editar" aria-label="Editar {{ $venue->name }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.sports_venues.destroy', $venue) }}"
                                  onsubmit="return confirm('¿Eliminar «{{ addslashes($venue->name) }}»? Esta acción no se puede deshacer.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon-sm btn-icon-danger"
                                        title="Eliminar" aria-label="Eliminar {{ $venue->name }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-16 text-slate-400">
                        <div class="flex flex-col items-center gap-3">
                            <span class="text-4xl">⚽</span>
                            <p class="font-medium">No hay escenarios deportivos registrados</p>
                            <a href="{{ route('admin.sports_venues.create') }}" class="btn-primary text-sm mt-1">
                                Registrar primer escenario
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Paginación --}}
@if($venues->hasPages())
    <div class="mt-4">
        {{ $venues->links() }}
    </div>
@endif

@push('scripts')
<script>
function filtrarTabla(q) {
    const term = q.toLowerCase().trim();
    document.querySelectorAll('.venue-row').forEach(row => {
        row.style.display = (!term || row.dataset.nombre.includes(term)) ? '' : 'none';
    });
    document.getElementById('btn-clear').classList.toggle('hidden', !q);
}
function limpiarBusqueda() {
    const input = document.getElementById('buscador-venues');
    if (input) { input.value = ''; filtrarTabla(''); input.focus(); }
}
</script>
@endpush

@endsection
