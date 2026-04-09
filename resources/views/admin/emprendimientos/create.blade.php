@extends('layouts.admin')

@section('title', 'Nuevo Emprendimiento')
@section('page-title', 'Nuevo Emprendimiento')
@section('page-subtitle', 'Registrar nuevo emprendimiento en el sistema')

@section('content')

<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #065f46 0%, #059669 45%, #10b981 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#34d399"/>
            <polygon points="115,0 200,0 200,120 170,120" fill="#6ee7b7"/>
            <polygon points="155,0 200,0 200,55" fill="#a7f3d0"/>
        </svg>
    </div>
    <div class="relative z-10 px-6 py-5 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">🛍️</div>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight">Nuevo Emprendimiento</h2>
                <p class="text-xs mt-0.5" style="color: rgba(167,243,208,0.9);">
                    Registrar nuevo emprendimiento en el sistema
                </p>
            </div>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-xs" style="color: rgba(255,255,255,0.55);">
            <a href="{{ route('admin.emprendimientos.index') }}" class="hover:text-white transition-colors font-medium">Emprendimientos</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-semibold">Nuevo</span>
        </div>
    </div>
</div>

<div class="max-w-3xl">

    {{-- Errores --}}
    @if($errors->any())
        <div class="mb-5 bg-white rounded-2xl border border-red-200 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3 border-b border-red-100" style="background:#FFF1F2;">
                <div class="w-7 h-7 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#FEE2E2;">
                    <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-red-700">
                    {{ $errors->count() }} {{ $errors->count() === 1 ? 'error encontrado' : 'errores encontrados' }}
                </p>
            </div>
            <ul class="px-5 py-3 space-y-1">
                @foreach($errors->all() as $error)
                    <li class="flex items-start gap-2 text-xs text-red-600">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.emprendimientos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @include('admin.emprendimientos._form')

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold
                           text-white rounded-xl shadow-md transition-all
                           hover:shadow-lg hover:-translate-y-0.5 active:scale-95"
                    style="background: linear-gradient(135deg, #065f46, #10b981);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Emprendimiento
            </button>
            <a href="{{ route('admin.emprendimientos.index') }}"
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

@endsection
