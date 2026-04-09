@extends('layouts.admin')

@section('title', 'Directorio de Emprendimientos')
@section('page-title', 'Directorio de Emprendimientos')
@section('page-subtitle', 'Empresas y servicios del sector religioso')

@section('content')

<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #065f46 0%, #059669 45%, #10b981 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: radial-gradient(circle, #6ee7b7, transparent 70%);"></div>
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#34d399"/>
            <polygon points="115,0 200,0 200,120 170,120" fill="#6ee7b7"/>
            <polygon points="155,0 200,0 200,55" fill="#a7f3d0"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-xl"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                    🛍️
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Directorio de Emprendimientos</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(167,243,208,0.9);">
                Empresas y servicios registrados por iglesias y miembros
            </p>
        </div>

        <div class="flex gap-4 ml-12 sm:ml-0">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $total ?? $emprendimientos->total() ?? 0 }}</p>
                <p class="text-xs mt-0.5" style="color: rgba(167,243,208,0.85);">Total</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    <div class="relative">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="buscador-emprendimientos"
               placeholder="Buscar emprendimiento…"
               aria-label="Buscar emprendimiento"
               oninput="filtrarTabla(this.value)"
               class="pl-10 pr-9 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                      shadow-sm w-full sm:w-64 focus:outline-none focus:ring-2
                      focus:border-emerald-400 text-slate-700 transition-all placeholder-slate-400">
        <button id="btn-clear"
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                onclick="limpiarBusqueda()" aria-label="Limpiar">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <a href="{{ route('admin.emprendimientos.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl
              shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95 flex-shrink-0"
       style="background: linear-gradient(135deg, #065f46, #059669);">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Emprendimiento
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    <div class="hidden md:block overflow-x-auto">
        <table class="w-full" id="tabla-emprendimientos">
            <thead>
                <tr class="border-b border-slate-100" style="background: #F0FDF4;">
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4 w-14">ID</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Emprendimiento</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden lg:table-cell">Categoría</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden xl:table-cell">Teléfono</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden xl:table-cell">Iglesia</th>
                    <th class="text-right text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($emprendimientos as $e)
                    <tr class="emprendimiento-row group hover:bg-emerald-50/30 transition-colors duration-100"
                        data-search="{{ strtolower($e->nombre . ' ' . ($e->categoria ?? '') . ' ' . ($e->direccion ?? '') . ' ' . ($e->telefono ?? '')) }}">

                        <td class="px-6 py-4">
                            <span class="text-xs font-mono font-semibold text-slate-400">#{{ $e->id }}</span>
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg
                                            flex-shrink-0 shadow-sm"
                                     style="background: linear-gradient(135deg, #065f46, #059669);">
                                    🛍️
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight">
                                        {{ $e->nombre }}
                                    </p>
                                    @if($e->direccion)
                                        <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[200px] lg:hidden">
                                            {{ $e->direccion }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-4 hidden lg:table-cell">
                            <span class="text-sm text-slate-600">{{ $e->categoria ?: '—' }}</span>
                        </td>

                        <td class="px-4 py-4 hidden xl:table-cell">
                            @if($e->telefono)
                                <a href="tel:{{ $e->telefono }}" class="text-sm text-emerald-700 font-medium hover:underline">
                                    {{ $e->telefono }}
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 hidden xl:table-cell">
                            @if($e->iglesia)
                                <span class="text-sm text-slate-600">{{ $e->iglesia->official_name ?? $e->iglesia->official_name ?? '—' }}</span>
                            @else
                                <span class="text-xs text-slate-400 italic">—</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">

                                <a href="{{ route('admin.emprendimientos.show', $e) }}"
                                   title="Ver detalles"
                                   class="p-2 rounded-lg texto-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.emprendimientos.edit', $e) }}"
                                   title="Editar"
                                   class="p-2 rounded-lg texto-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.emprendimientos.destroy', $e) }}"
                                      class="form-eliminar inline"
                                      data-nombre="{{ addslashes($e->nombre) }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="abrirModalEliminar(this)"
                                            class="btn-eliminar p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all"
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
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl"
                                     style="background:#F0FDF4;">🛍️</div>
                                <p class="text-sm font-semibold text-slate-600">No hay emprendimientos registrados</p>
                                <a href="{{ route('admin.emprendimientos.create') }}"
                                   class="mt-1 text-xs font-bold text-emerald-600 hover:text-emerald-700">
                                    + Registrar primer emprendimiento
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                <tr id="empty-search-row" class="hidden">
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl border-2 border-dashed border-slate-200
                                        flex items-center justify-center">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-600">Sin resultados</p>
                                <p class="text-xs text-slate-400 mt-0.5">Prueba con otro término de búsqueda</p>
                            </div>
                            <button onclick="limpiarBusqueda()"
                                    class="mt-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700
                                           flex items-center gap-1 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Limpiar búsqueda
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="md:hidden divide-y divide-slate-50">
        @forelse($emprendimientos as $e)
              <div class="emprendimiento-row px-4 py-4"
                  data-search="{{ strtolower($e->nombre . ' ' . ($e->categoria ?? '') . ' ' . ($e->direccion ?? '') . ' ' . ($e->telefono ?? '')) }}">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0"
                         style="background: linear-gradient(135deg, #065f46, #059669);">
                        🛍️
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 leading-tight">{{ $e->nombre }}</p>
                        @if($e->categoria)
                            <p class="text-xs text-slate-500 mt-0.5">{{ $e->categoria }}</p>
                        @endif
                        @if($e->direccion)
                            <p class="text-xs text-slate-400 mt-0.5">📍 {{ $e->direccion }}</p>
                        @endif
                        @if($e->telefono)
                            <p class="text-xs mt-0.5">
                                <a href="tel:{{ $e->telefono }}" class="text-emerald-600 font-medium">
                                    📞 {{ $e->telefono }}
                                </a>
                            </p>
                        @endif
                    </div>
                    <div class="flex flex-col gap-1.5 flex-shrink-0">
                        <a href="{{ route('admin.emprendimientos.edit', $e) }}"
                           class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.emprendimientos.destroy', $e) }}"
                              class="form-eliminar"
                              data-nombre="{{ addslashes($e->nombre) }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="abrirModalEliminar(this)"
                                    class="btn-eliminar p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-semibold text-slate-600">No hay emprendimientos registrados</p>
            </div>
        @endforelse
        <div id="empty-search-mobile" class="hidden px-6 py-14 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl border-2 border-dashed border-slate-200
                            flex items-center justify-center">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-600">Sin resultados</p>
                    <p class="text-xs text-slate-400 mt-0.5">Prueba con otro término de búsqueda</p>
                </div>
                <button onclick="limpiarBusqueda()"
                        class="mt-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700
                               flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Limpiar búsqueda
                </button>
            </div>
        </div>
    </div>

    @if($emprendimientos->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $emprendimientos->links() }}
        </div>
    @endif

</div>

<div id="modal-eliminar"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-titulo">
    <div id="modal-backdrop"
         class="absolute inset-0 bg-black/40 backdrop-blur-sm"
         onclick="cerrarModalEliminar()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 flex flex-col items-center gap-4 animate-[fadeInScale_.2s_ease]">
        <div class="w-14 h-14 rounded-full flex items-center justify-center flex-shrink-0"
             style="background:#FEF2F2;">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <div class="text-center">
            <h3 id="modal-titulo" class="text-base font-bold text-slate-800">¿Eliminar emprendimiento?</h3>
            <p class="text-sm text-slate-500 mt-1">
                Se eliminará permanentemente
                <span id="modal-nombre" class="font-semibold text-slate-700"></span>.
                Esta acción no se puede deshacer.
            </p>
        </div>
        <div class="flex gap-3 w-full mt-1">
            <button onclick="cerrarModalEliminar()"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold
                           text-slate-600 hover:bg-slate-50 transition-colors">
                Cancelar
            </button>
            <button id="modal-btn-confirmar"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold text-white transition-all
                           hover:opacity-90 active:scale-95"
                    style="background:linear-gradient(135deg,#b91c1c,#ef4444);">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function filtrarTabla(q) {
    q = q.toLowerCase().trim();
    var visible = 0;
    document.querySelectorAll('.emprendimiento-row').forEach(function(row) {
        var haystack = row.dataset.search || '';
        var show = (!q || haystack.includes(q));
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('btn-clear').classList.toggle('hidden', !q);
    var sinResultados = (q.length > 0 && visible === 0);
    var emptyRow    = document.getElementById('empty-search-row');
    var emptyMobile = document.getElementById('empty-search-mobile');
    if (emptyRow)    emptyRow.classList.toggle('hidden', !sinResultados);
    if (emptyMobile) emptyMobile.classList.toggle('hidden', !sinResultados);
}
function limpiarBusqueda() {
    document.getElementById('buscador-emprendimientos').value = '';
    filtrarTabla('');
    document.getElementById('buscador-emprendimientos').focus();
}

var _formPendiente = null;
function abrirModalEliminar(btn) {
    _formPendiente = btn.closest('.form-eliminar');
    document.getElementById('modal-nombre').textContent = '«' + (_formPendiente.dataset.nombre || 'este emprendimiento') + '»';
    var modal = document.getElementById('modal-eliminar');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function cerrarModalEliminar() {
    var modal = document.getElementById('modal-eliminar');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    _formPendiente = null;
}
document.getElementById('modal-btn-confirmar').addEventListener('click', function() {
    if (_formPendiente) _formPendiente.submit();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModalEliminar();
});
document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
    btn.addEventListener('click', function() { abrirModalEliminar(this); });
});
</script>
@endpush

@endsection
