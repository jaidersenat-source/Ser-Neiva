@extends('layouts.admin')

@section('title', 'Eventos')
@section('page-title', 'Gestión de Eventos')
@section('page-subtitle', 'Administra la agenda de eventos y actividades')

@section('content')

@vite(['resources/css/admin/event/evento.index.css'])  {{-- Crea este archivo si quieres estilos específicos, o reutiliza el de iglesias --}}

{{-- ── Toolbar ── --}}
<div class="toolbar mb-4 gap-3">
    <div class="search-wrap hidden sm:flex">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="buscador-eventos"
               placeholder="Buscar evento, iglesia o tipo..."
               aria-label="Buscar evento"
               oninput="filtrarTabla(this.value)">
        <button id="btn-clear" class="hidden text-slate-400 hover:text-slate-600 transition-colors"
                onclick="limpiarBusqueda()" aria-label="Limpiar búsqueda">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="toolbar-right">
        <a href="{{ route('admin.eventos.create') }}" class="btn-primary" aria-label="Registrar nuevo evento">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="btn-label">Nuevo Evento</span>
        </a>

       
                @if(request()->hasAny(['estado', 'tipo_evento']))
                    <div class="export-filter-note">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Incluye filtros activos
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>

{{-- Buscador en móvil eliminado para evitar duplicidad --}}

{{-- ═══════════════════════════════════
     PANEL PRINCIPAL
═══════════════════════════════════ --}}
<div class="table-panel">

    {{-- ════════════
         TABLA (md+)
    ════════════ --}}
    <div class="desktop-table">
        <table class="data-table" id="eventos-table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Iglesia</th>
                    <th>Fecha Inicio</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-body">
                @forelse($eventos as $evento)
                    <tr class="evento-row-data"
                        data-titulo="{{ strtolower($evento->titulo) }}"
                        data-iglesia="{{ strtolower($evento->iglesia->official_name ?? '') }}"
                        data-tipo="{{ strtolower($evento->tipo_evento ?? '') }}">

                        {{-- Título + dirección --}}
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="iglesia-avatar-table" style="background:#8B5CF6;">
                                    {{ substr($evento->titulo, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight searchable-titulo">
                                        {{ $evento->titulo }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[180px] lg:max-w-xs">
                                        {{ $evento->direccion_evento ?? 'Sin dirección' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>{{ $evento->iglesia->official_name ?? '—' }}</td>
                        <td>
                            @if($evento->fecha_inicio instanceof \DateTimeInterface)
                                {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                            @elseif($evento->fecha_inicio)
                                {{ $evento->fecha_inicio }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <span class="denom-chip" style="background:#EEF2FF; color:#4F46E5;">
                                {{ $evento->tipo_evento ?? '—' }}
                            </span>
                        </td>

                        <td>
                            <span class="estado-badge {{ $evento->estado === 'activo' ? 'estado-activo' : 'estado-inactivo' }}">
                                <span class="estado-dot {{ $evento->estado === 'activo' ? 'dot-activo' : 'dot-inactivo' }}" aria-hidden="true"></span>
                                {{ $evento->estado === 'activo' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>

                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.eventos.show', $evento) }}"
                                   class="action-btn action-btn--view" title="Ver detalle" aria-label="Ver {{ $evento->titulo }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.eventos.edit', $evento) }}"
                                   class="action-btn action-btn--edit" title="Editar" aria-label="Editar {{ $evento->titulo }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
                                      class="form-eliminar-evento" data-titulo="{{ addslashes($evento->titulo) }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="action-btn action-btn--delete btn-eliminar-evento"
                                            title="Eliminar" aria-label="Eliminar {{ $evento->titulo }}">
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
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500 mb-1">Sin eventos registrados</p>
                                <a href="{{ route('admin.eventos.create') }}" class="text-xs text-indigo-500 hover:underline font-medium">
                                    Registrar primer evento →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Empty búsqueda (tabla) --}}
        <div id="empty-search" class="empty-state" style="display:none;">
            <div class="empty-icon">
                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Sin resultados</p>
            <p class="text-xs text-slate-400">Prueba con otro término de búsqueda</p>
        </div>
    </div>

    {{-- ════════════
         CARDS (móvil)
    ════════════ --}}
    <div class="mobile-cards" id="mobile-cards-container">
        @forelse($eventos as $evento)
            <div class="iglesia-card card-filtrable"
                 data-titulo="{{ strtolower($evento->titulo) }}"
                 data-iglesia="{{ strtolower($evento->iglesia->official_name ?? '') }}"
                 data-tipo="{{ strtolower($evento->tipo_evento ?? '') }}">

                {{-- Header --}}
                <div class="iglesia-card-header">
                    <div class="iglesia-avatar-card" style="background:#8B5CF6;">
                        {{ substr($evento->titulo, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 leading-tight mb-1 truncate">
                            {{ $evento->titulo }}
                        </p>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="denom-chip" style="background:#EEF2FF; color:#4F46E5;">
                                {{ $evento->tipo_evento ?? '—' }}
                            </span>
                            <span class="estado-badge {{ $evento->estado === 'activo' ? 'estado-activo' : 'estado-inactivo' }}">
                                <span class="estado-dot {{ $evento->estado === 'activo' ? 'dot-activo' : 'dot-inactivo' }}" aria-hidden="true"></span>
                                {{ $evento->estado === 'activo' ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Detalles --}}
                <div class="grid grid-cols-1 gap-1.5 mb-3 text-xs text-slate-500">
                    <div class="flex items-start gap-2">
                        <span class="text-slate-300 flex-shrink-0 mt-0.5">⛪</span>
                        <span class="truncate">{{ $evento->iglesia->official_name ?? 'Sin iglesia' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-300 flex-shrink-0">📅</span>
                        <span>
                            @if($evento->fecha_inicio instanceof \DateTimeInterface)
                                {{ $evento->fecha_inicio->format('d/m/Y H:i') }}
                            @elseif($evento->fecha_inicio)
                                {{ $evento->fecha_inicio }}
                            @else
                                —
                            @endif
                        </span>
                    </div>
                    @if($evento->direccion_evento)
                        <div class="flex items-start gap-2">
                            <span class="text-slate-300 flex-shrink-0 mt-0.5">📍</span>
                            <span class="truncate">{{ $evento->direccion_evento }}</span>
                        </div>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="iglesia-card-actions">
                    <a href="{{ route('admin.eventos.show', $evento) }}"
                       class="card-action-btn card-btn-view" aria-label="Ver {{ $evento->titulo }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                    <a href="{{ route('admin.eventos.edit', $evento) }}"
                       class="card-action-btn card-btn-edit" aria-label="Editar {{ $evento->titulo }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.eventos.destroy', $evento) }}"
                          class="form-eliminar-evento" data-titulo="{{ addslashes($evento->titulo) }}"
                          style="flex:1; display:flex;">
                        @csrf @method('DELETE')
                        <button type="button" class="card-action-btn card-btn-delete btn-eliminar-evento" style="flex:1;"
                                aria-label="Eliminar {{ $evento->titulo }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Sin eventos registrados</p>
                <a href="{{ route('admin.eventos.create') }}" class="text-xs text-indigo-500 hover:underline font-medium">
                    Registrar primer evento →
                </a>
            </div>
        @endforelse

        {{-- Empty búsqueda (cards) --}}
        <div id="empty-search-mobile" class="empty-state" style="display:none;">
            <div class="empty-icon">
                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Sin resultados</p>
            <p class="text-xs text-slate-400 mt-1">Prueba con otro término</p>
        </div>
    </div>

    {{-- Paginación --}}
    @if($eventos->hasPages())
        <div class="pagination-wrap">
            {{ $eventos->links() }}
        </div>
    @endif

</div>

{{-- Modal de confirmación eliminar --}}
<div id="modal-confirmar-eliminar" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-xl p-7 max-w-xs w-full text-center">
        <svg class="mx-auto mb-3 w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        <h2 class="font-bold text-lg mb-2">¿Eliminar evento?</h2>
        <p class="text-slate-600 mb-5" id="modal-eliminar-nombre">Esta acción no se puede deshacer.</p>
        <div class="flex justify-center gap-3">
            <button id="btn-cancelar-eliminar" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">Cancelar</button>
            <button id="btn-confirmar-eliminar" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold">Eliminar</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ── Modal de confirmación ────────────────────────────────
(function () {
    var formAEliminar = null;

    function initEliminarModal() {
        var modal        = document.getElementById('modal-confirmar-eliminar');
        var nombreSpan   = document.getElementById('modal-eliminar-nombre');
        var btnCancelar  = document.getElementById('btn-cancelar-eliminar');
        var btnConfirmar = document.getElementById('btn-confirmar-eliminar');

        if (!modal || !nombreSpan || !btnCancelar || !btnConfirmar) return;

        document.querySelectorAll('.btn-eliminar-evento').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                formAEliminar = btn.closest('form');
                var titulo = formAEliminar.getAttribute('data-titulo') || '';
                nombreSpan.textContent = '¿Seguro que deseas eliminar "' + titulo + '"? Esta acción no se puede deshacer.';
                modal.classList.remove('hidden');
            });
        });

        btnCancelar.addEventListener('click', function () {
            modal.classList.add('hidden');
            formAEliminar = null;
        });

        btnConfirmar.addEventListener('click', function () {
            if (formAEliminar) formAEliminar.submit();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEliminarModal);
    } else {
        initEliminarModal();
    }
})();

// ── Filtro de búsqueda en cliente ────────────────────────────────
function filtrarTabla(query) {
    var q = query.toLowerCase().trim();

    // Sincronizar los dos inputs
    document.querySelectorAll('#buscador-eventos, #buscador-eventos-mobile').forEach(function (inp) {
        if (inp.value !== query) inp.value = query;
    });

    // Botón clear
    var btnClear = document.getElementById('btn-clear');
    if (btnClear) btnClear.classList.toggle('hidden', q.length === 0);

    // Tabla desktop
    var filas = document.querySelectorAll('.evento-row-data');
    var visiblesTabla = 0;
    filas.forEach(function (fila) {
        var coincide = !q ||
            fila.dataset.titulo.includes(q) ||
            fila.dataset.iglesia.includes(q) ||
            fila.dataset.tipo.includes(q);
        fila.style.display = coincide ? '' : 'none';
        if (coincide) visiblesTabla++;
    });
    var emptySearch = document.getElementById('empty-search');
    if (emptySearch) {
        if (q.length === 0 || filas.length === 0) {
            emptySearch.style.display = 'none';
        } else {
            emptySearch.style.display = (visiblesTabla === 0) ? '' : 'none';
        }
    }

    // Cards móvil
    var cards = document.querySelectorAll('.card-filtrable');
    var visiblesCards = 0;
    cards.forEach(function (card) {
        var coincide = !q ||
            card.dataset.titulo.includes(q) ||
            card.dataset.iglesia.includes(q) ||
            card.dataset.tipo.includes(q);
        card.style.display = coincide ? '' : 'none';
        if (coincide) visiblesCards++;
    });
    var emptyMobile = document.getElementById('empty-search-mobile');
    if (emptyMobile) {
        if (q.length === 0 || cards.length === 0) {
            emptyMobile.style.display = 'none';
        } else {
            emptyMobile.style.display = (visiblesCards === 0) ? '' : 'none';
        }
    }
}

function limpiarBusqueda() {
    filtrarTabla('');
    var input = document.getElementById('buscador-eventos');
    if (input) input.focus();
}
</script>
@endpush

@endsection