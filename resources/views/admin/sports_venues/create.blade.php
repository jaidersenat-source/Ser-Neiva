@extends('layouts.admin')

@section('title', 'Nuevo Escenario Deportivo')
@section('page-title', 'Nuevo Escenario Deportivo')
@section('page-subtitle', 'Registrar nuevo escenario deportivo en el sistema')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5">
    <a href="{{ route('admin.sports_venues.index') }}" class="hover:text-[#1E3A8A] transition-colors font-medium">
        Escenarios Deportivos
    </a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-600 font-medium">Nuevo Escenario</span>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.sports_venues.store') }}" method="POST" novalidate>
        @csrf
        @include('admin.sports_venues._form')

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
            <button type="submit" class="btn-form-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Escenario
            </button>
            <a href="{{ route('admin.sports_venues.index') }}" class="btn-form-cancel">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
