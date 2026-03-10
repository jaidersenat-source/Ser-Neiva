@extends('layouts.admin')

@section('title', 'Importar Iglesias')
@section('page-title', 'Importar Iglesias')
@section('page-subtitle', 'Carga masiva desde Excel (.xlsx)')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5">
    <a href="{{ route('admin.iglesias.index') }}" class="hover:text-[#1E3A8A] transition-colors font-medium">Iglesias</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-600 font-medium">Importar</span>
</div>

<div class="max-w-4xl">

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- REPORTE --}}
    @if (session('report'))
        <div class="mb-8 bg-white border border-slate-200 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span class="text-emerald-600">✓</span> Reporte de Importación
            </h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-emerald-600">{{ session('report')['created'] }}</div>
                    <div class="text-sm text-emerald-700">Creadas</div>
                </div>
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-amber-600">{{ session('report')['skipped'] }}</div>
                    <div class="text-sm text-amber-700">Omitidas (duplicadas)</div>
                </div>
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
                    <div class="text-3xl font-bold text-red-600">{{ count(session('report')['errors']) }}</div>
                    <div class="text-sm text-red-700">Con errores</div>
                </div>
            </div>

            @if (count(session('report')['errors']) > 0)
                <div class="mt-8">
                    <h4 class="font-medium mb-3 text-slate-700">Detalle de filas con errores</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-slate-600">Fila</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-600">Nombre</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-600">Dirección</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-600">Errores</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach (session('report')['errors'] as $err)
                                <tr>
                                    <td class="px-4 py-3 font-mono text-slate-500">{{ $err['row'] }}</td>
                                    <td class="px-4 py-3">{{ $err['nombre'] }}</td>
                                    <td class="px-4 py-3">{{ $err['direccion'] }}</td>
                                    <td class="px-4 py-3">
                                        <ul class="list-disc list-inside text-red-600 text-xs space-y-1">
                                            @foreach ($err['errors'] as $e)
                                                <li>{{ $e }}</li>
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

    {{-- FORMULARIO --}}
    <form action="{{ route('admin.iglesias.import.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="bg-white border border-slate-200 rounded-2xl p-8">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Archivo Excel <span class="text-red-500">*</span>
            </label>
            <input type="file" 
                   name="file" 
                   accept=".xlsx"
                   required
                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#1E3A8A] file:text-white hover:file:bg-[#1E3A8A]/90 transition-colors">

            <div class="mt-4 text-xs text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">
                <strong>Columnas obligatorias:</strong> nombre, direccion, ciudad<br>
                <strong>Opcionales:</strong> telefono, email<br><br>
                La primera fila debe contener exactamente estos encabezados (no importa mayúsculas/minúsculas).
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6">
            <button type="submit" class="flex items-center justify-center gap-2 flex-1 sm:flex-none px-5 py-3 rounded-xl font-semibold shadow transition-colors duration-150 text-white" style="background-color:#1E3A8A;" onmouseover="this.style.backgroundColor='#233876'" onmouseout="this.style.backgroundColor='#1E3A8A'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v-4m0 0l4 4m-4-4l4-4m12 4v4m0 0l-4-4m4 4l-4 4"/>
                </svg>
                Importar Iglesias
            </button>
            <a href="{{ route('admin.iglesias.index') }}" class="flex items-center justify-center flex-1 sm:flex-none px-5 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-center shadow transition-colors duration-150">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection