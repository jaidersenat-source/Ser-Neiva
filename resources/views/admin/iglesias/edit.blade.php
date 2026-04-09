@extends('layouts.admin')

@section('title', 'Editar — ' . ($iglesia->official_name ?? 'Iglesia'))
@section('page-title', 'Editar Iglesia')
@section('page-subtitle', $iglesia->official_name)

@section('content')

{{-- ── Hero strip con datos de la iglesia ── --}}
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
        <div class="flex items-center gap-3 min-w-0">
            {{-- Avatar --}}
            @if($iglesia->photo)
                <img src="{{ Storage::url($iglesia->photo) }}" alt=""
                     class="w-11 h-11 rounded-xl object-cover flex-shrink-0"
                     style="border:2px solid rgba(255,255,255,0.25);">
            @else
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg font-extrabold
                            text-white flex-shrink-0"
                     style="background:rgba(255,255,255,0.15); backdrop-filter:blur(8px);
                            border:2px solid rgba(255,255,255,0.2);">
                    {{ strtoupper(substr($iglesia->official_name ?? '?', 0, 1)) }}
                </div>
            @endif
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-widest mb-0.5"
                   style="color:rgba(144,224,239,0.8);">Editando</p>
                <h2 class="text-white font-bold text-lg leading-tight truncate">
                    {{ $iglesia->official_name }}
                </h2>
                @if($iglesia->denomination)
                    <p class="text-xs mt-0.5" style="color:rgba(144,224,239,0.75);">
                        {{ $iglesia->denomination }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Acciones rápidas + breadcrumb --}}
        <div class="flex items-center gap-2 flex-shrink-0 ml-14 sm:ml-0">
            <a href="{{ route('admin.iglesias.show', $iglesia) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all hover:opacity-90"
               style="background:rgba(255,255,255,0.12); color:rgba(255,255,255,0.9); border:1px solid rgba(255,255,255,0.18);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span class="hidden sm:inline">Ver detalle</span>
            </a>
            <a href="{{ route('admin.iglesias.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold transition-all hover:opacity-90"
               style="background:rgba(255,255,255,0.07); color:rgba(255,255,255,0.7); border:1px solid rgba(255,255,255,0.12);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="hidden sm:inline">Lista</span>
            </a>
        </div>
    </div>
</div>

{{-- ── Indicador de progreso por secciones ── --}}
<div class="mb-6 hidden sm:block">
    <div class="flex items-center gap-1 overflow-x-auto pb-1">
        @php
            $secciones = [
                ['num'=>1,'label'=>'Iglesia'],
                ['num'=>2,'label'=>'Ubicación'],
                ['num'=>3,'label'=>'Contacto'],
                ['num'=>4,'label'=>'Pastor'],
                ['num'=>5,'label'=>'Mujeres'],
                ['num'=>6,'label'=>'Jurídico'],
                ['num'=>7,'label'=>'Ministerios'],
                ['num'=>8,'label'=>'Notas'],
                ['num'=>9,'label'=>'Ayudas'],
                ['num'=>10,'label'=>'Mapa'],
            ];
        @endphp
        @foreach($secciones as $sec)
            <a href="#seccion-{{ $sec['num'] }}"
               class="flex items-center gap-1.5 flex-shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold
                      transition-all hover:bg-white hover:shadow-sm group"
               style="color:#64748B;">
                <span class="w-5 h-5 rounded-md flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0
                             group-hover:scale-110 transition-transform"
                      style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                    {{ $sec['num'] }}
                </span>
                {{ $sec['label'] }}
            </a>
            @if(!$loop->last)
                <div class="w-3 h-px flex-shrink-0" style="background:#E2E8F0;"></div>
            @endif
        @endforeach
    </div>
</div>

{{-- ── Errores de validación ── --}}
@if($errors->any())
    <div class="mb-5 rounded-2xl border overflow-hidden" style="background:#FFF1F2; border-color:#FECDD3;">
        <div class="flex items-center gap-3 px-5 py-3 border-b" style="border-color:#FECDD3; background:#FFF5F6;">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#FEE2E2;">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-bold text-red-700">
                {{ $errors->count() }} error(es) encontrado(s). Revisa los campos marcados.
            </p>
        </div>
        <ul class="px-5 py-3 space-y-1">
            @foreach($errors->all() as $error)
                <li class="flex items-start gap-2 text-xs text-red-600">
                    <span class="mt-0.5 flex-shrink-0">•</span>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── Alerta de cambios sin guardar ── --}}
<div id="unsaved-alert" class="hidden mb-5 rounded-2xl px-5 py-3 flex items-center gap-3"
     style="background:#FFFBEB; border:1px solid #FDE68A;">
    <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <p class="text-sm font-semibold text-amber-700">Tienes cambios sin guardar.</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.iglesias.update', $iglesia) }}" method="POST"
          enctype="multipart/form-data" novalidate id="form-editar">
        @csrf @method('PUT')

        @include('admin.iglesias._form')

        {{-- ── Barra de acciones sticky ── --}}
        <div class="sticky bottom-0 z-20 mt-6 -mx-4 sm:mx-0 sm:relative sm:bottom-auto
                    px-4 sm:px-0 py-4 sm:py-0
                    bg-white sm:bg-transparent border-t border-slate-100 sm:border-0
                    shadow-[0_-4px_20px_rgba(0,0,0,0.06)] sm:shadow-none">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white
                               rounded-xl shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95"
                        style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Actualizar Iglesia
                </button>
                <a href="{{ route('admin.iglesias.show', $iglesia) }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold
                          rounded-xl border text-white transition-all active:scale-95 hover:opacity-90"
                   style="background: linear-gradient(135deg, #0e6ba8, #48cae4); border-color:transparent;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Ver detalle
                </a>
                <a href="{{ route('admin.iglesias.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold
                          rounded-xl border border-slate-200 text-slate-600 bg-white
                          hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </a>
            </div>
        </div>
    </form>

    {{-- ══════════════════════════════════════════════════════════════
         SECCIÓN INDEPENDIENTE: Credenciales de acceso al portal
    ══════════════════════════════════════════════════════════════ --}}
    @if(session('success_credentials'))
        <div class="mt-5 rounded-2xl px-5 py-3 flex items-center gap-3 border"
             style="background:#F0FDF4; border-color:#BBF7D0;">
            <svg class="w-4 h-4 flex-shrink-0" style="color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-sm font-semibold" style="color:#15803D;">{{ session('success_credentials') }}</p>
        </div>
    @endif

    <div class="mt-6 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: linear-gradient(135deg, #7C3AED, #A855F7);">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">Acceso al portal</p>
                <p class="text-xs text-slate-400">
                    @if($linkedUser)
                        Cuenta activa — usuario: <strong class="text-violet-600">{{ $linkedUser->username }}</strong>
                    @else
                        Sin cuenta de acceso configurada
                    @endif
                </p>
            </div>
            @if($linkedUser)
                <span class="ml-auto inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold"
                      style="background:#F3E8FF; color:#7C3AED;">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Activo
                </span>
            @endif
        </div>

        <form action="{{ route('admin.iglesias.credentials', $iglesia) }}" method="POST"
              class="p-5 space-y-4">
            @csrf

            {{-- Errores de credenciales --}}
            @if($errors->has('username') || $errors->has('password') || $errors->has('password_confirmation'))
                <div class="rounded-xl border px-4 py-3" style="background:#FFF1F2; border-color:#FECDD3;">
                    <p class="text-xs font-bold text-red-600 mb-1">Corrige los siguientes errores:</p>
                    <ul class="space-y-0.5">
                        @foreach(['username','password','password_confirmation'] as $field)
                            @error($field)
                                <li class="text-xs text-red-500">• {{ $message }}</li>
                            @enderror
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Username --}}
                <div class="sm:col-span-1">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                        Nombre de usuario *
                    </label>
                    <input type="text" name="username"
                           value="{{ old('username', $linkedUser->username ?? '') }}"
                           autocomplete="off" spellcheck="false"
                           placeholder="ej: iglesia_central"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm
                                  text-slate-700 font-medium placeholder-slate-300 outline-none transition-all
                                  focus:border-violet-400 focus:ring-2 focus:ring-violet-400/10
                                  {{ $errors->has('username') ? 'border-red-300 bg-red-50' : '' }}">
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                        Contraseña {{ $linkedUser ? '(dejar vacío = sin cambios)' : '*' }}
                    </label>
                    <input type="password" name="password"
                           autocomplete="new-password"
                           placeholder="{{ $linkedUser ? '••••••••' : 'Mínimo 8 caracteres' }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm
                                  text-slate-700 font-medium placeholder-slate-300 outline-none transition-all
                                  focus:border-violet-400 focus:ring-2 focus:ring-violet-400/10
                                  {{ $errors->has('password') ? 'border-red-300 bg-red-50' : '' }}">
                </div>

                {{-- Confirmar contraseña --}}
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                        Confirmar contraseña
                    </label>
                    <input type="password" name="password_confirmation"
                           autocomplete="new-password"
                           placeholder="Repetir contraseña"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm
                                  text-slate-700 font-medium placeholder-slate-300 outline-none transition-all
                                  focus:border-violet-400 focus:ring-2 focus:ring-violet-400/10">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white
                               rounded-xl shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5 active:scale-95"
                        style="background: linear-gradient(135deg, #7C3AED, #A855F7);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $linkedUser ? 'Actualizar credenciales' : 'Crear acceso' }}
                </button>
                <p class="text-xs text-slate-400">
                    La iglesia usa su usuario y contraseña para ingresar al portal propio.
                </p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Alerta de cambios sin guardar
(function () {
    var form    = document.getElementById('form-editar');
    var alert   = document.getElementById('unsaved-alert');
    var dirty   = false;
    var submitted = false;

    if (!form || !alert) return;

    form.addEventListener('input',  function () { if (!dirty) { dirty = true; alert.classList.remove('hidden'); } });
    form.addEventListener('change', function () { if (!dirty) { dirty = true; alert.classList.remove('hidden'); } });
    form.addEventListener('submit', function () { submitted = true; });

    window.addEventListener('beforeunload', function (e) {
        if (dirty && !submitted) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
})();
</script>
@endpush

@endsection