@extends('layouts.admin')

@section('title', 'Importar Iglesias')
@section('page-title', 'Importar Iglesias')
@section('page-subtitle', 'Carga masiva desde Excel (.xlsx)')

@section('content')

{{-- ── Hero strip ── --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0a1f5c 0%, #0f2d7a 45%, #0e6ba8 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="70,0 200,0 200,120 130,120" fill="#48cae4"/>
            <polygon points="115,0 200,0 200,120 168,120" fill="#90e0ef"/>
            <polygon points="155,0 200,0 200,55" fill="#caf0f8"/>
        </svg>
    </div>
    <div class="relative z-10 px-6 py-5 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(255,255,255,0.15); backdrop-filter:blur(8px);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight">Importar Iglesias</h2>
                <p class="text-xs mt-0.5" style="color:rgba(144,224,239,0.85);">
                    Carga masiva desde archivo Excel (.xlsx)
                </p>
            </div>
        </div>
        {{-- Breadcrumb --}}
        <div class="hidden sm:flex items-center gap-2 text-xs ml-13" style="color:rgba(255,255,255,0.6);">
            <a href="{{ route('admin.iglesias.index') }}" class="hover:text-white transition-colors font-medium">Iglesias</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-semibold">Importar</span>
        </div>
    </div>
</div>

<div class="max-w-3xl space-y-5">

    {{-- ── Flash: éxito ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl"
             style="background:#F0FDF4; border:1px solid #BBF7D0;">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:#DCFCE7;">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    {{-- ── Flash: error ── --}}
    @if(session('error'))
        <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl"
             style="background:#FFF1F2; border:1px solid #FECDD3;">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:#FEE2E2;">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ── REPORTE DE IMPORTACIÓN ── --}}
    @if(session('report'))
        @php $report = session('report'); @endphp
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Reporte de Importación</p>
                    <p class="text-xs text-slate-400">Resultados del archivo procesado</p>
                </div>
            </div>

            {{-- Stats --}}
            <div class="p-5 grid grid-cols-3 gap-3">
                <div class="flex flex-col items-center justify-center p-4 rounded-2xl text-center"
                     style="background:#F0FDF4; border:1px solid #DCFCE7;">
                    <p class="text-3xl font-extrabold text-green-600 leading-none">{{ $report['created'] }}</p>
                    <p class="text-xs font-semibold text-green-700 mt-1.5">Creadas</p>
                </div>
                <div class="flex flex-col items-center justify-center p-4 rounded-2xl text-center"
                     style="background:#FFFBEB; border:1px solid #FDE68A;">
                    <p class="text-3xl font-extrabold text-amber-500 leading-none">{{ $report['skipped'] }}</p>
                    <p class="text-xs font-semibold text-amber-700 mt-1.5">Omitidas</p>
                    <p class="text-[10px] text-amber-500 mt-0.5">duplicadas</p>
                </div>
                <div class="flex flex-col items-center justify-center p-4 rounded-2xl text-center"
                     style="background:#FFF1F2; border:1px solid #FECDD3;">
                    <p class="text-3xl font-extrabold text-red-500 leading-none">{{ count($report['errors']) }}</p>
                    <p class="text-xs font-semibold text-red-700 mt-1.5">Con errores</p>
                </div>
            </div>

            {{-- Tabla de errores --}}
            @if(count($report['errors']) > 0)
                <div class="border-t border-slate-100">
                    <div class="px-5 py-3 flex items-center gap-2" style="background:#FFF5F6;">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wider">
                            Detalle de filas con errores ({{ count($report['errors']) }})
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="background:#F8FAFF; border-bottom:1px solid #F1F5F9;">
                                    <th class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 px-5 py-3 w-16">Fila</th>
                                    <th class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 px-4 py-3">Nombre</th>
                                    <th class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 px-4 py-3 hidden sm:table-cell">Dirección</th>
                                    <th class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 px-4 py-3">Errores</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($report['errors'] as $err)
                                    <tr class="hover:bg-red-50/30 transition-colors">
                                        <td class="px-5 py-3">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold"
                                                  style="background:#FEE2E2; color:#DC2626;">
                                                {{ $err['row'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-slate-700 max-w-[160px] truncate">
                                            {{ $err['nombre'] }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-slate-500 hidden sm:table-cell max-w-[160px] truncate">
                                            {{ $err['direccion'] }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <ul class="space-y-1">
                                                @foreach($err['errors'] as $e)
                                                    <li class="flex items-start gap-1.5 text-xs text-red-600">
                                                        <span class="mt-1 w-1 h-1 rounded-full bg-red-400 flex-shrink-0"></span>
                                                        {{ $e }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- ── PASOS: cómo funciona ── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:#EFF6FF;">
                <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-bold text-slate-800">¿Cómo importar?</p>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
            @php
                $pasos = [
                    ['n'=>'1', 'title'=>'Descarga la plantilla', 'desc'=>'Usa el archivo oficial con el formato correcto e incluye el diccionario de campos.', 'color'=>'#EFF6FF', 'border'=>'#BFDBFE', 'text'=>'#1D4ED8'],
                    ['n'=>'2', 'title'=>'Rellena los datos', 'desc'=>'Completa las filas con la información de cada iglesia. Las fechas en formato YYYY-MM-DD.', 'color'=>'#FFFBEB', 'border'=>'#FDE68A', 'text'=>'#92400E'],
                    ['n'=>'3', 'title'=>'Sube el archivo', 'desc'=>'Selecciona el archivo y haz clic en «Importar Iglesias». Recibirás un reporte completo.', 'color'=>'#F0FDF4', 'border'=>'#BBF7D0', 'text'=>'#166534'],
                ];
            @endphp
            @foreach($pasos as $paso)
                <div class="flex flex-col gap-2 p-4 rounded-xl"
                     style="background:{{ $paso['color'] }}; border:1px solid {{ $paso['border'] }};">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-extrabold text-white flex-shrink-0"
                              style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                            {{ $paso['n'] }}
                        </span>
                        <p class="text-xs font-bold" style="color:{{ $paso['text'] }};">{{ $paso['title'] }}</p>
                    </div>
                    <p class="text-xs leading-relaxed" style="color:{{ $paso['text'] }}; opacity:0.8;">
                        {{ $paso['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ── PLANTILLA ── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:#DCFCE7;">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-slate-800">Plantilla oficial de importación</p>
                <p class="text-xs text-slate-400">Incluye hoja «📖 Diccionario» con descripción de cada campo</p>
            </div>
            <a href="{{ route('admin.iglesias.import.template') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white rounded-xl
                      transition-all hover:shadow-md hover:-translate-y-0.5 active:scale-95 flex-shrink-0"
               style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Descargar plantilla
            </a>
        </div>

        {{-- Campos obligatorios/opcionales --}}
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl" style="background:#FFF1F2; border:1px solid #FECDD3;">
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-red-600 mb-2">
                    Campos obligatorios
                </p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach(['official_name','estado'] as $campo)
                        <code class="text-[11px] font-mono font-semibold px-2 py-0.5 rounded-lg"
                              style="background:#FEE2E2; color:#B91C1C;">{{ $campo }}</code>
                    @endforeach
                </div>
            </div>
            <div class="p-4 rounded-xl" style="background:#F8FAFF; border:1px solid #E2E8F0;">
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 mb-2">
                    Ejemplos de campos opcionales
                </p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach(['denomination','address','municipality','phone_mobile','pastor_full_name','latitud','longitud'] as $campo)
                        <code class="text-[11px] font-mono font-semibold px-2 py-0.5 rounded-lg"
                              style="background:#EFF6FF; color:#1D4ED8;">{{ $campo }}</code>
                    @endforeach
                    <span class="text-[11px] text-slate-400 font-medium self-center">y más…</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── FORMULARIO DE CARGA ── --}}
    <form action="{{ route('admin.iglesias.import.store') }}" method="POST"
          enctype="multipart/form-data" novalidate id="form-import">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Subir archivo</p>
                    <p class="text-xs text-slate-400">Selecciona el archivo .xlsx con los datos de las iglesias</p>
                </div>
            </div>

            <div class="p-5">
                {{-- Drop zone --}}
                <div id="drop-zone"
                     class="relative flex flex-col items-center justify-center gap-3 p-8 rounded-2xl
                            border-2 border-dashed border-slate-200 bg-slate-50 cursor-pointer
                            transition-all hover:border-blue-300 hover:bg-blue-50/50 group"
                     onclick="document.getElementById('file-input').click()">

                    <input type="file" id="file-input" name="file"
                           accept=".xlsx" required class="sr-only"
                           onchange="handleFileChange(this)">

                    {{-- Ícono --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all
                                group-hover:scale-105"
                         style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE);">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    {{-- Estado normal --}}
                    <div id="drop-idle" class="text-center">
                        <p class="text-sm font-semibold text-slate-700">
                            Haz clic para seleccionar o arrastra aquí
                        </p>
                        <p class="text-xs text-slate-400 mt-0.5">Solo archivos .xlsx</p>
                    </div>

                    {{-- Estado con archivo seleccionado --}}
                    <div id="drop-selected" class="hidden text-center">
                        <p id="file-name" class="text-sm font-bold text-blue-700"></p>
                        <p id="file-size" class="text-xs text-slate-400 mt-0.5"></p>
                        <button type="button"
                                class="mt-2 text-xs font-semibold text-slate-400 hover:text-red-500 transition-colors"
                                onclick="clearFile(event)">
                            × Quitar archivo
                        </button>
                    </div>
                </div>

                @error('file')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- ── Botones ── --}}
        <div class="mt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit" id="btn-import"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold
                           text-white rounded-xl shadow-md transition-all
                           hover:shadow-lg hover:-translate-y-0.5 active:scale-95 disabled:opacity-50 disabled:pointer-events-none"
                    style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="btn-import-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span id="btn-import-label">Importar Iglesias</span>
            </button>
            <a href="{{ route('admin.iglesias.index') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold
                      rounded-xl border border-slate-200 text-slate-600 bg-white
                      hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Cancelar
            </a>
        </div>
    </form>

</div>

@push('scripts')
<script>
// ── Drag & drop ──────────────────────────────────────────────
(function () {
    var zone = document.getElementById('drop-zone');
    if (!zone) return;

    ['dragenter','dragover'].forEach(function(ev){
        zone.addEventListener(ev, function(e){
            e.preventDefault();
            zone.classList.add('border-blue-400','bg-blue-50/80');
        });
    });
    ['dragleave','drop'].forEach(function(ev){
        zone.addEventListener(ev, function(e){
            e.preventDefault();
            zone.classList.remove('border-blue-400','bg-blue-50/80');
        });
    });
    zone.addEventListener('drop', function(e){
        var files = e.dataTransfer.files;
        if (files && files[0]) {
            var input = document.getElementById('file-input');
            // Asignar el archivo al input
            var dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            handleFileChange(input);
        }
    });
})();

// ── Manejo de archivo seleccionado ──────────────────────────
window.handleFileChange = function (input) {
    var idle     = document.getElementById('drop-idle');
    var selected = document.getElementById('drop-selected');
    var nameEl   = document.getElementById('file-name');
    var sizeEl   = document.getElementById('file-size');
    var zone     = document.getElementById('drop-zone');

    if (!input.files || !input.files[0]) return;

    var file = input.files[0];
    var name = file.name;
    var size = (file.size / 1024).toFixed(0) + ' KB';
    if (file.size > 1024 * 1024) size = (file.size / (1024*1024)).toFixed(1) + ' MB';

    if (nameEl) nameEl.textContent = '📄 ' + name;
    if (sizeEl) sizeEl.textContent = size;

    idle.classList.add('hidden');
    selected.classList.remove('hidden');
    zone.classList.add('border-blue-400','bg-blue-50/50');
    zone.classList.remove('border-dashed','border-slate-200','bg-slate-50');
    zone.style.cursor = 'default';
};

window.clearFile = function(e) {
    e.stopPropagation();
    var input    = document.getElementById('file-input');
    var idle     = document.getElementById('drop-idle');
    var selected = document.getElementById('drop-selected');
    var zone     = document.getElementById('drop-zone');

    input.value = '';
    idle.classList.remove('hidden');
    selected.classList.add('hidden');
    zone.classList.remove('border-blue-400','bg-blue-50/50');
    zone.classList.add('border-dashed','border-slate-200','bg-slate-50');
    zone.style.cursor = 'pointer';
};

// ── Loading state en submit ──────────────────────────────────
document.getElementById('form-import').addEventListener('submit', function(){
    var btn   = document.getElementById('btn-import');
    var label = document.getElementById('btn-import-label');
    var icon  = document.getElementById('btn-import-icon');
    if (!btn) return;
    btn.disabled = true;
    if (label) label.textContent = 'Procesando…';
    if (icon) {
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>';
        icon.style.animation = 'spin .8s linear infinite';
    }
});

// ── Spinner CSS ──────────────────────────────────────────────
(function(){
    var s = document.createElement('style');
    s.textContent = '@keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}';
    document.head.appendChild(s);
})();
</script>
@endpush

@endsection