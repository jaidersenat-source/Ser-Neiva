@extends('layouts.admin')

@section('title', 'Iglesias')
@section('page-title', 'Gestión de Iglesias')
@section('page-subtitle', 'Administra el directorio de iglesias registradas')


@section('content')

{{-- Filtro de ayudas --}}
@php
    // Obtener todas las ayudas para el filtro visual
    $ayudasFiltro = \App\Models\Ayuda::orderBy('nombre')->get();
@endphp
<div class="mb-4 flex flex-wrap gap-2 items-center">
    <label for="filtro-ayuda" class="font-medium text-sm">Filtrar por ayuda:</label>
    <select id="filtro-ayuda" class="border rounded px-2 py-1 text-sm focus:outline-none">
        <option value="">Todas</option>
        @foreach($ayudasFiltro as $ayuda)
            <option value="{{ $ayuda->id }}">{{ $ayuda->nombre }}</option>
        @endforeach
    </select>
</div>

@vite(['resources/css/admin/iglesias/index.css']) 

{{-- ── Toolbar ── --}}
<div class="toolbar mb-4 gap-3">
    <div class="search-wrap hidden sm:flex">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="buscador-iglesias"
               placeholder="Buscar iglesia..."
               aria-label="Buscar iglesia"
               oninput="filtrarTabla(this.value)">
        <button id="btn-clear" class="hidden text-slate-400 hover:text-slate-600 transition-colors"
                onclick="limpiarBusqueda()" aria-label="Limpiar búsqueda">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Filtro por municipio --}}
    <form method="GET" action="{{ route('admin.iglesias.index') }}" id="form-municipio" class="flex items-center gap-2">
        <select name="municipality"
                onchange="document.getElementById('form-municipio').submit()"
                class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 text-slate-700 bg-white
                       focus:outline-none focus:ring-2 focus:ring-[#1E3A8A]/30 focus:border-[#1E3A8A]
                       hover:border-slate-300 transition-colors cursor-pointer">
            <option value="">&#x1F4CD; Todos los municipios</option>
            @foreach($municipios as $mun)
                <option value="{{ $mun }}" {{ request('municipality') === $mun ? 'selected' : '' }}>
                    {{ $mun }}
                </option>
            @endforeach
        </select>
        @if(request('municipality'))
            <a href="{{ route('admin.iglesias.index') }}"
               class="text-xs text-slate-400 hover:text-red-500 transition-colors" title="Quitar filtro">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        @endif
    </form>

    <div class="toolbar-right">
        <a href="{{ route('admin.iglesias.create') }}" class="btn-primary" aria-label="Registrar nueva iglesia">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="btn-label">Nueva Iglesia</span>
        </a>

        {{-- ── Botones de exportación ── --}}
        <div class="export-group" id="export-group">
            <button type="button" class="export-btn" id="export-toggle" aria-haspopup="true" aria-expanded="false">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span class="export-btn-label">Exportar</span>
                <svg class="export-chevron w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div class="export-dropdown" id="export-dropdown" aria-hidden="true">
                <a href="{{ route('iglesias.export.pdf', request()->query()) }}"
                   class="export-option" target="_blank">
                    <span class="export-option-icon export-icon-pdf">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="export-option-title">Descargar PDF</p>
                        <p class="export-option-sub">Reporte A4 horizontal · DomPDF</p>
                    </div>
                </a>
                <div class="export-divider"></div>
                <a href="{{ route('iglesias.export.excel', request()->query()) }}" class="export-option">
                    <span class="export-option-icon export-icon-excel">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="export-option-title">Descargar Excel</p>
                        <p class="export-option-sub">Formato .xlsx · Con estilos</p>
                    </div>
                </a>
                @if(request()->hasAny(['estado', 'denominacion', 'comuna', 'ayuda_id']))
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
        <table class="data-table" id="iglesias-table">
            <thead>
                <tr>
                    <th>Iglesia</th>
                    <th>Denominación</th>
                    <th>Comuna</th>
                    <th class="hidden lg:table-cell">Pastor / Sacerdote</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-body">
                @forelse($iglesias as $iglesia)
                    <tr class="iglesia-row-data"
                        data-nombre="{{ strtolower($iglesia->official_name ?? '') }}"
                        data-denominacion="{{ strtolower($iglesia->denomination ?? '') }}"
                        data-pastor="{{ strtolower($iglesia->pastor_full_name ?? '') }}"
                        data-comuna="{{ strtolower($iglesia->comuna ?? '') }}"
                        data-municipality="{{ strtolower($iglesia->municipality ?? '') }}"
                        data-ayudas="{{ implode(',', $iglesia->ayudas->pluck('id')->toArray()) }}">

                        {{-- Nombre + dirección --}}
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="iglesia-avatar-table">{{ substr($iglesia->official_name ?? '?', 0, 1) }}</div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight searchable-nombre">
                                        {{ $iglesia->official_name }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[180px] lg:max-w-xs">
                                        {{ $iglesia->address }}
                                    </p>
                                    @if($iglesia->municipality)
                                        <span class="inline-block mt-1 text-[10px] font-semibold px-2 py-0.5 rounded-full
                                                     bg-blue-50 text-blue-600 border border-blue-100">
                                            📍 {{ $iglesia->municipality }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Denominación --}}
                        <td>
                            <span class="denom-chip">{{ $iglesia->denomination }}</span>
                            <br>
                            <span class="text-xs text-slate-500">Miembros aprox.: <b>{{ $iglesia->approx_members ?? '—' }}</b></span>
                        </td>

                        {{-- Comuna --}}
                        <td class="text-xs text-slate-500 font-medium">
                            {{ $iglesia->comuna ?? '—' }}
                        </td>

                        {{-- Pastor (solo lg+) --}}
                        <td class="hidden lg:table-cell text-xs text-slate-500">
                            {{ $iglesia->pastor_full_name ?? '—' }}
                        </td>

                        {{-- Estado --}}
                        <td>
                            <span class="estado-badge {{ $iglesia->church_status === 'Active' ? 'estado-activo' : 'estado-inactivo' }}">
                                <span class="estado-dot {{ $iglesia->church_status === 'Active' ? 'dot-activo' : 'dot-inactivo' }}" aria-hidden="true"></span>
                                {{ $iglesia->church_status === 'Active' ? 'Activa' : ($iglesia->church_status === 'Suspended' ? 'Suspendida' : 'Inactiva') }}
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.iglesias.show', $iglesia) }}"
                                   class="action-btn action-btn--view" title="Ver detalle" aria-label="Ver {{ $iglesia->official_name }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.iglesias.edit', $iglesia) }}"
                                   class="action-btn action-btn--edit" title="Editar" aria-label="Editar {{ $iglesia->official_name }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.iglesias.destroy', $iglesia) }}"
                                      class="form-eliminar-iglesia" data-nombre="{{ addslashes($iglesia->official_name ?? '') }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="action-btn action-btn--delete btn-eliminar-iglesia"
                                            title="Eliminar" aria-label="Eliminar {{ $iglesia->official_name }}">
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
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500 mb-1">Sin iglesias registradas</p>
                                <a href="{{ route('admin.iglesias.create') }}" class="text-xs text-blue-500 hover:underline font-medium">
                                    Registrar primera iglesia →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Empty state búsqueda (tabla) --}}
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
        @forelse($iglesias as $iglesia)
              <div class="iglesia-card card-filtrable"
                  data-nombre="{{ strtolower($iglesia->official_name ?? '') }}"
                  data-denominacion="{{ strtolower($iglesia->denomination ?? '') }}"
                  data-pastor="{{ strtolower($iglesia->pastor_full_name ?? '') }}"
                  data-comuna="{{ strtolower($iglesia->comuna ?? '') }}"
                  data-ayudas="{{ implode(',', $iglesia->ayudas->pluck('id')->toArray()) }}">

                {{-- Header de la card --}}
                <div class="iglesia-card-header">
                    <div class="iglesia-avatar-card">{{ substr($iglesia->official_name ?? '?', 0, 1) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 leading-tight mb-1 truncate">
                            {{ $iglesia->official_name }}
                        </p>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="denom-chip">{{ $iglesia->denomination }}</span>
                            <span class="estado-badge {{ $iglesia->church_status === 'Active' ? 'estado-activo' : 'estado-inactivo' }}">
                                <span class="estado-dot {{ $iglesia->church_status === 'Active' ? 'dot-activo' : 'dot-inactivo' }}" aria-hidden="true"></span>
                                {{ $iglesia->church_status === 'Active' ? 'Activa' : ($iglesia->church_status === 'Suspended' ? 'Suspendida' : 'Inactiva') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Detalles --}}
                <div class="grid grid-cols-1 gap-1.5 mb-3 text-xs text-slate-500">
                    <div class="flex items-start gap-2">
                        <span class="text-slate-300 flex-shrink-0 mt-0.5">📍</span>
                        <span class="truncate">{{ $iglesia->address }}</span>
                    </div>
                    @if($iglesia->pastor_full_name)
                        <div class="flex items-center gap-2">
                            <span class="text-slate-300 flex-shrink-0">👤</span>
                            <span class="truncate">{{ $iglesia->pastor_full_name }}</span>
                        </div>
                    @endif
                    @php $tel = $iglesia->phone_mobile ?: $iglesia->phone_landline; @endphp
                    @if($tel)
                        <div class="flex items-center gap-2">
                            <span class="text-slate-300 flex-shrink-0">📞</span>
                            <a href="tel:{{ $tel }}" class="text-blue-500 font-medium">
                                {{ $tel }}
                            </a>
                        </div>
                    @endif
                    @if($iglesia->comuna)
                        <div class="flex items-center gap-2">
                            <span class="text-slate-300 flex-shrink-0">🏘️</span>
                            <span>{{ $iglesia->comuna }}</span>
                        </div>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="iglesia-card-actions">
                    <a href="{{ route('admin.iglesias.show', $iglesia) }}"
                       class="card-action-btn card-btn-view" aria-label="Ver {{ $iglesia->official_name }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                    <a href="{{ route('admin.iglesias.edit', $iglesia) }}"
                       class="card-action-btn card-btn-edit" aria-label="Editar {{ $iglesia->official_name }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.iglesias.destroy', $iglesia) }}"
                          class="form-eliminar-iglesia" data-nombre="{{ addslashes($iglesia->official_name ?? '') }}"
                          style="flex:1; display:flex;">
                        @csrf @method('DELETE')
                        <button type="button" class="card-action-btn card-btn-delete btn-eliminar-iglesia" style="flex:1;"
                                aria-label="Eliminar {{ $iglesia->nombre }}">
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
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Sin iglesias registradas</p>
                <a href="{{ route('admin.iglesias.create') }}" class="text-xs text-blue-500 hover:underline font-medium">
                    Registrar primera iglesia →
                </a>
            </div>
        @endforelse

        {{-- Empty state búsqueda (cards) --}}
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

    {{-- ── Paginación ── --}}
    @if($iglesias->hasPages())
        <div class="pagination-wrap">
            {{ $iglesias->links() }}
        </div>
    @endif

</div>

{{-- ── Modal de confirmación para eliminar (único, fuera del loop) ── --}}
<div id="modal-confirmar-eliminar" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-xl p-7 max-w-xs w-full text-center">
        <svg class="mx-auto mb-3 w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        <h2 class="font-bold text-lg mb-2">¿Eliminar iglesia?</h2>
        <p class="text-slate-600 mb-5" id="modal-eliminar-nombre">Esta acción no se puede deshacer.</p>
        <div class="flex justify-center gap-3">
            <button id="btn-cancelar-eliminar" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">Cancelar</button>
            <button id="btn-confirmar-eliminar" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold">Eliminar</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ── Modal de confirmación para eliminar ──────────────────────────
    (function () {
        var formAEliminar = null;

        function initEliminarModal() {
            var modal        = document.getElementById('modal-confirmar-eliminar');
            var nombreSpan   = document.getElementById('modal-eliminar-nombre');
            var btnCancelar  = document.getElementById('btn-cancelar-eliminar');
            var btnConfirmar = document.getElementById('btn-confirmar-eliminar');

            if (!modal || !nombreSpan || !btnCancelar || !btnConfirmar) return;

            document.querySelectorAll('.btn-eliminar-iglesia').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    formAEliminar = btn.closest('form');
                    var nombre = formAEliminar.getAttribute('data-nombre') || '';
                    nombreSpan.textContent = '¿Seguro que deseas eliminar "' + nombre + '"? Esta acción no se puede deshacer.';
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

    // ── Export dropdown (sin Alpine) ────────────────────────────────
(function () {
    var group   = document.getElementById('export-group');
    var toggle  = document.getElementById('export-toggle');
    var dropdown = document.getElementById('export-dropdown');
    if (!group || !toggle || !dropdown) return;

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = group.classList.toggle('open');
        toggle.setAttribute('aria-expanded', isOpen);
        dropdown.setAttribute('aria-hidden', !isOpen);
    });

    document.addEventListener('click', function () {
        group.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        dropdown.setAttribute('aria-hidden', 'true');
    });

    dropdown.addEventListener('click', function (e) { e.stopPropagation(); });
})();

    // ── Filtro de búsqueda en cliente ────────────────────────────────

    function filtrarTabla(query) {
        var q = query.toLowerCase().trim();
        var ayudaSeleccionada = document.getElementById('filtro-ayuda') ? document.getElementById('filtro-ayuda').value : '';

        // Sincronizar el input
        var inp = document.getElementById('buscador-iglesias');
        if (inp && inp.value !== query) inp.value = query;

        // Mostrar/ocultar botón clear (desktop)
        var btnClear = document.getElementById('btn-clear');
        if (btnClear) btnClear.classList.toggle('hidden', q.length === 0);

        // ── Tabla (desktop) ──
        var filas = document.querySelectorAll('.iglesia-row-data');
        var visiblesTabla = 0;
        filas.forEach(function (fila) {
            var coincideTexto = !q ||
                fila.dataset.nombre.includes(q) ||
                fila.dataset.denominacion.includes(q) ||
                fila.dataset.pastor.includes(q) ||
                fila.dataset.comuna.includes(q);
            var coincideAyuda = !ayudaSeleccionada || (fila.dataset.ayudas && fila.dataset.ayudas.split(',').includes(ayudaSeleccionada));
            var mostrar = coincideTexto && coincideAyuda;
            fila.style.display = mostrar ? '' : 'none';
            if (mostrar) visiblesTabla++;
        });
        var emptySearch = document.getElementById('empty-search');
        if (emptySearch) {
            if ((q.length === 0 && !ayudaSeleccionada) || filas.length === 0) {
                emptySearch.style.display = 'none';
            } else {
                emptySearch.style.display = (visiblesTabla === 0) ? '' : 'none';
            }
        }

        // ── Cards (móvil) ──
        var cards = document.querySelectorAll('.card-filtrable');
        var visiblesCards = 0;
        cards.forEach(function (card) {
            var coincideTexto = !q ||
                card.dataset.nombre.includes(q) ||
                card.dataset.denominacion.includes(q) ||
                card.dataset.pastor.includes(q) ||
                card.dataset.comuna.includes(q);
            var coincideAyuda = !ayudaSeleccionada || (card.dataset.ayudas && card.dataset.ayudas.split(',').includes(ayudaSeleccionada));
            var mostrar = coincideTexto && coincideAyuda;
            card.style.display = mostrar ? '' : 'none';
            if (mostrar) visiblesCards++;
        });
        var emptyMobile = document.getElementById('empty-search-mobile');
        if (emptyMobile) {
            if ((q.length === 0 && !ayudaSeleccionada) || cards.length === 0) {
                emptyMobile.style.display = 'none';
            } else {
                emptyMobile.style.display = (visiblesCards === 0) ? '' : 'none';
            }
        }
    }

    // Filtro de ayuda: evento para actualizar filtro
    document.addEventListener('DOMContentLoaded', function () {
        var filtroAyuda = document.getElementById('filtro-ayuda');
        if (filtroAyuda) {
            filtroAyuda.addEventListener('change', function () {
                filtrarTabla(document.getElementById('buscador-iglesias') ? document.getElementById('buscador-iglesias').value : '');
            });
        }
    });

    function limpiarBusqueda() {
        filtrarTabla('');
        var input = document.getElementById('buscador-iglesias');
        if (input) input.focus();
    }
</script>

@endpush

@endsection