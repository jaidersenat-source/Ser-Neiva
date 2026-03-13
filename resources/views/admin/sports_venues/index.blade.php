@extends('layouts.admin')

@section('title', 'Escenarios Deportivos')
@section('page-title', 'Escenarios Deportivos')
@section('page-subtitle', 'Canchas y espacios deportivos disponibles para iglesias')

@section('content')

{{-- ═══════════════════════════════════
     HERO STRIP
═══════════════════════════════════ --}}
<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #7c2d12 0%, #c2410c 45%, #ea580c 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: radial-gradient(circle, #fdba74, transparent 70%);"></div>
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#fb923c"/>
            <polygon points="115,0 200,0 200,120 170,120" fill="#fdba74"/>
            <polygon points="155,0 200,0 200,55" fill="#fed7aa"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-xl"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                    ⚽
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Escenarios Deportivos</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(253,186,116,0.9);">
                Canchas y espacios deportivos disponibles para iglesias
            </p>
        </div>

        {{-- Stats --}}
        <div class="flex gap-4 ml-12 sm:ml-0">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $venues->total() }}</p>
                <p class="text-xs mt-0.5" style="color: rgba(253,186,116,0.85);">Total</p>
            </div>
            <div class="w-px" style="background: rgba(255,255,255,0.2);"></div>
            <div class="text-center">
                <p class="text-2xl font-extrabold leading-none" style="color: #fdba74;">
                    {{ $venues->where('available_for_churches', true)->count() }}
                </p>
                <p class="text-xs mt-0.5" style="color: rgba(253,186,116,0.85);">Disponibles</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     TOOLBAR
═══════════════════════════════════ --}}
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    {{-- Buscador --}}
    <div class="relative">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="buscador-venues"
               placeholder="Buscar escenario o dirección…"
               aria-label="Buscar escenario"
               oninput="filtrarTabla(this.value)"
               class="pl-10 pr-9 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                      shadow-sm w-full sm:w-64 focus:outline-none focus:ring-2
                      focus:border-orange-400 text-slate-700 transition-all placeholder-slate-400">
        <button id="btn-clear"
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                onclick="limpiarBusqueda()" aria-label="Limpiar búsqueda">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Botón nuevo --}}
    <a href="{{ route('admin.sports_venues.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl
              shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95 flex-shrink-0"
       style="background: linear-gradient(135deg, #7c2d12, #ea580c);">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Escenario
    </a>
</div>

{{-- ═══════════════════════════════════
     PANEL PRINCIPAL
═══════════════════════════════════ --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- ── TABLA DESKTOP (md+) ── --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full" id="tabla-venues">
            <thead>
                <tr class="border-b border-slate-100" style="background: #FFFAF7;">
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4 w-14">ID</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Escenario</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden lg:table-cell">Dirección</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden xl:table-cell">Contacto</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Disponible</th>
                    <th class="text-right text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($venues as $venue)
                    <tr class="venue-row group hover:bg-orange-50/30 transition-colors duration-100"
                        data-nombre="{{ strtolower($venue->name) }} {{ strtolower($venue->address) }}">

                        {{-- ID --}}
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono font-semibold text-slate-400">
                                #{{ $venue->id }}
                            </span>
                        </td>

                        {{-- Nombre --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg
                                            flex-shrink-0 shadow-sm"
                                     style="background: linear-gradient(135deg, #7c2d12, #ea580c);">
                                    ⚽
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight">
                                        {{ $venue->name }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[180px] lg:hidden">
                                        {{ $venue->address }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Dirección --}}
                        <td class="px-4 py-4 hidden lg:table-cell">
                            <p class="text-sm text-slate-600 truncate max-w-[200px]">
                                {{ $venue->address ?: '—' }}
                            </p>
                        </td>

                        {{-- Contacto --}}
                        <td class="px-4 py-4 hidden xl:table-cell">
                            @if($venue->contact)
                                <div class="flex items-center gap-1.5 text-sm text-slate-600">
                                    <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $venue->contact }}
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">—</span>
                            @endif
                        </td>

                        {{-- Disponible --}}
                        <td class="px-4 py-4">
                            @if($venue->available_for_churches)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full"
                                      style="background:#F8FAFC; color:#64748B;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    No disponible
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.sports_venues.edit', $venue) }}"
                                   title="Editar"
                                   class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.sports_venues.destroy', $venue) }}"
                                      class="form-eliminar-venue inline"
                                      data-nombre="{{ addslashes($venue->name) }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="btn-eliminar-venue p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                            title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <td colspan="6">
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4 text-3xl"
                                     style="background:#FFF7ED; border: 2px dashed #FED7AA;">
                                    ⚽
                                </div>
                                <p class="text-sm font-semibold text-slate-500 mb-1">Sin escenarios registrados</p>
                                <a href="{{ route('admin.sports_venues.create') }}"
                                   class="text-xs font-medium transition-colors"
                                   style="color: #ea580c;">
                                    Registrar primer escenario →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Empty search --}}
        <div id="empty-search" style="display:none;" class="flex-col items-center justify-center py-14 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                 style="background:#FFF7ED; border: 2px dashed #FED7AA;">
                <svg class="w-6 h-6 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Sin resultados</p>
            <p class="text-xs text-slate-400">Prueba con otro término de búsqueda</p>
        </div>
    </div>

    {{-- ── CARDS MÓVIL (< md) ── --}}
    <div class="md:hidden divide-y divide-slate-50" id="mobile-cards-container">
        @forelse($venues as $venue)
            <div class="venue-card p-4 hover:bg-orange-50/20 transition-colors"
                 data-nombre="{{ strtolower($venue->name) }} {{ strtolower($venue->address) }}">

                <div class="flex items-start gap-3 mb-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-xl flex-shrink-0 shadow-sm"
                         style="background: linear-gradient(135deg, #7c2d12, #ea580c);">
                        ⚽
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 leading-tight truncate">
                            {{ $venue->name }}
                        </p>
                        <div class="mt-1.5">
                            @if($venue->available_for_churches)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#F0FDF4; color:#166534;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-semibold rounded-full"
                                      style="background:#F8FAFC; color:#64748B;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    No disponible
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 mb-3 pl-14">
                    @if($venue->address)
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span class="truncate">{{ $venue->address }}</span>
                        </div>
                    @endif
                    @if($venue->contact)
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $venue->contact }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex gap-2 pl-14">
                    <a href="{{ route('admin.sports_venues.edit', $venue) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-semibold
                              rounded-lg border border-slate-200 text-slate-600 bg-white
                              hover:bg-amber-50 hover:border-amber-200 hover:text-amber-700 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.sports_venues.destroy', $venue) }}"
                          class="form-eliminar-venue flex-1 flex"
                          data-nombre="{{ addslashes($venue->name) }}">
                        @csrf @method('DELETE')
                        <button type="button"
                                class="btn-eliminar-venue flex-1 inline-flex items-center justify-center gap-1.5
                                       px-3 py-2 text-xs font-semibold rounded-lg border border-slate-200
                                       text-slate-600 bg-white hover:bg-red-50 hover:border-red-200
                                       hover:text-red-700 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4 text-3xl"
                     style="background:#FFF7ED; border: 2px dashed #FED7AA;">⚽</div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Sin escenarios registrados</p>
                <a href="{{ route('admin.sports_venues.create') }}"
                   class="text-xs font-medium" style="color:#ea580c;">
                    Registrar primer escenario →
                </a>
            </div>
        @endforelse

        <div id="empty-search-mobile" style="display:none;" class="flex-col items-center justify-center py-14 text-center">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4"
                 style="background:#FFF7ED; border: 2px dashed #FED7AA;">
                <svg class="w-6 h-6 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Sin resultados</p>
            <p class="text-xs text-slate-400 mt-0.5">Prueba con otro término</p>
        </div>
    </div>

    {{-- Paginación --}}
    @if($venues->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $venues->links() }}
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
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-base font-bold text-slate-800 mb-2">¿Eliminar escenario?</h2>
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
// ── Modal eliminar ──────────────────────────────────────────────
(function () {
    var formAEliminar = null;
    function init() {
        var modal        = document.getElementById('modal-confirmar-eliminar');
        var nombreSpan   = document.getElementById('modal-eliminar-nombre');
        var btnCancelar  = document.getElementById('btn-cancelar-eliminar');
        var btnConfirmar = document.getElementById('btn-confirmar-eliminar');
        if (!modal) return;

        document.querySelectorAll('.btn-eliminar-venue').forEach(function(btn) {
            btn.addEventListener('click', function() {
                formAEliminar = btn.closest('form');
                var nombre = formAEliminar.getAttribute('data-nombre') || '';
                nombreSpan.textContent = '¿Seguro que deseas eliminar «' + nombre + '»? Esta acción no se puede deshacer.';
                modal.classList.remove('hidden');
            });
        });
        btnCancelar.addEventListener('click', function() { modal.classList.add('hidden'); formAEliminar = null; });
        btnConfirmar.addEventListener('click', function() { if (formAEliminar) formAEliminar.submit(); });
        modal.addEventListener('click', function(e) {
            if (e.target === modal) { modal.classList.add('hidden'); formAEliminar = null; }
        });
    }
    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', init) : init();
})();

// ── Filtro búsqueda ─────────────────────────────────────────────
function filtrarTabla(q) {
    var term = q.toLowerCase().trim();
    var btnClear = document.getElementById('btn-clear');
    if (btnClear) btnClear.classList.toggle('hidden', !q);

    // Tabla
    var filas = document.querySelectorAll('.venue-row');
    var visibles = 0;
    filas.forEach(function(row) {
        var show = !term || row.dataset.nombre.includes(term);
        row.style.display = show ? '' : 'none';
        if (show) visibles++;
    });
    var emptySearch = document.getElementById('empty-search');
    if (emptySearch) emptySearch.style.display = (filas.length > 0 && visibles === 0) ? 'flex' : 'none';

    // Cards
    var cards = document.querySelectorAll('.venue-card');
    var visiblesCards = 0;
    cards.forEach(function(card) {
        var show = !term || card.dataset.nombre.includes(term);
        card.style.display = show ? '' : 'none';
        if (show) visiblesCards++;
    });
    var emptyMobile = document.getElementById('empty-search-mobile');
    if (emptyMobile) emptyMobile.style.display = (cards.length > 0 && visiblesCards === 0) ? 'flex' : 'none';
}

function limpiarBusqueda() {
    filtrarTabla('');
    var input = document.getElementById('buscador-venues');
    if (input) input.focus();
}
</script>
@endpush

@endsection