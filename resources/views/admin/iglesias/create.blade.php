@extends('layouts.admin')

@section('title', 'Nueva Iglesia')
@section('page-title', 'Nueva Iglesia')
@section('page-subtitle', 'Registrar nueva iglesia en el sistema')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-slate-400 mb-5">
    <a href="{{ route('admin.iglesias.index') }}" class="hover:text-[#1E3A8A] transition-colors font-medium">Iglesias</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-600 font-medium">Nueva Iglesia</span>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.iglesias.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @include('admin.iglesias._form')

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
            <button type="submit" class="btn-form-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Iglesia
            </button>
            <a href="{{ route('admin.iglesias.index') }}" class="btn-form-cancel">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection