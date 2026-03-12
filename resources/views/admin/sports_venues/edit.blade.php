@extends('layouts.admin')

@section('title', 'Editar Escenario')
@section('page-title', 'Editar Escenario Deportivo')
@section('page-subtitle', $venue->name)

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5 flex-wrap">
    <a href="{{ route('admin.sports_venues.index') }}" class="hover:text-[#1E3A8A] transition-colors font-medium">
        Escenarios Deportivos
    </a>
    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-500 font-medium truncate max-w-[180px]">{{ $venue->name }}</span>
    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-600 font-medium">Editar</span>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.sports_venues.update', $venue) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('admin.sports_venues._form')

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
            <button type="submit" class="btn-form-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Actualizar Escenario
            </button>
            <a href="{{ route('admin.sports_venues.index') }}" class="btn-form-cancel">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
