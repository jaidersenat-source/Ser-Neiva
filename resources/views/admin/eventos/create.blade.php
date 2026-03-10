@extends('layouts.admin')

@section('title', 'Nuevo Evento')
@section('page-title', 'Nuevo Evento')
@section('page-subtitle', 'Registrar nuevo evento en el sistema')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5">
    <a href="{{ route('admin.eventos.index') }}" 
       class="hover:text-[#1E3A8A] transition-colors font-medium">
        Eventos
    </a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-600 font-medium">Nuevo Evento</span>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.eventos.store') }}" method="POST" novalidate>
        @csrf

        @include('admin.eventos._form')

        {{-- Botones de acción --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6 border-t border-slate-100 mt-8">
            <button type="submit" class="btn-form-primary flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Evento
            </button>

            <a href="{{ route('admin.eventos.index') }}" 
               class="btn-form-cancel flex items-center justify-center">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection