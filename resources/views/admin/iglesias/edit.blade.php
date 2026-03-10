@extends('layouts.admin')

@section('title', 'Editar Iglesia')
@section('page-title', 'Editar Iglesia')
@section('page-subtitle', $iglesia->nombre)

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 flex-wrap">
    <a href="{{ route('admin.iglesias.index') }}" class="hover:text-[#1E3A8A] transition-colors font-medium">Iglesias</a>
    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-500 font-medium truncate max-w-[180px]">{{ $iglesia->nombre }}</span>
    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-600 font-medium">Editar</span>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.iglesias.update', $iglesia) }}" method="POST" novalidate>
        @csrf @method('PUT')
        @include('admin.iglesias._form')

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
            <button type="submit" class="btn-form-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Actualizar Iglesia
            </button>
            <a href="{{ route('admin.iglesias.show', $iglesia) }}" class="btn-form-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Ver detalle
            </a>
            <a href="{{ route('admin.iglesias.index') }}" class="btn-form-cancel">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection