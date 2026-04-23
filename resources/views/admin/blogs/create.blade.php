@extends('layouts.admin')

@section('title', 'Nueva Entrada del Blog')
@section('page-title', 'Nueva Entrada del Blog')
@section('page-subtitle', 'Completa los campos para crear la entrada')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Encabezado + volver --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.blogs.index') }}"
           class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors"
           title="Volver al listado">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-slate-800">Nueva Entrada del Blog</h2>
            <p class="text-xs text-slate-400">Completa los campos y guarda el artículo</p>
        </div>
    </div>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        @include('admin.blogs._form', ['blog' => new \App\Models\Blog()])

        {{-- Botones --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.blogs.index') }}"
               class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200
                      rounded-xl hover:bg-slate-50 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white
                           rounded-xl shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95"
                    style="background: linear-gradient(135deg, #78350f, #b45309);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Entrada
            </button>
        </div>
    </form>

</div>

@endsection
