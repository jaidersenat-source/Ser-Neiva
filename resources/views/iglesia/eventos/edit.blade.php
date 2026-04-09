@extends('layouts.iglesia')

@section('title', 'Editar Evento')
@section('page-title', 'Editar Evento')
@section('page-subtitle', $evento->titulo)

@section('content')

{{-- ═══════════════════════════════════
     HERO STRIP
═══════════════════════════════════ --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #2d1b69 0%, #4c1d95 45%, #7c3aed 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#a78bfa"/>
            <polygon points="115,0 200,0 200,120 170,120" fill="#c4b5fd"/>
            <polygon points="155,0 200,0 200,55" fill="#ede9fe"/>
        </svg>
    </div>
    <div class="relative z-10 px-6 py-5 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight truncate max-w-xs sm:max-w-sm">
                    {{ $evento->titulo }}
                </h2>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-xs" style="color: rgba(196,181,253,0.85);">Editando evento</p>
                    @if($evento->estado === 'activo')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold rounded-full"
                              style="background: rgba(255,255,255,0.15); color: #c4b5fd;">
                            <span class="w-1 h-1 rounded-full bg-green-400"></span>
                            Activo
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick links + breadcrumb --}}
        <div class="hidden sm:flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('iglesia.eventos.show', $evento) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-xl
                      transition-all hover:opacity-90"
               style="background: rgba(255,255,255,0.15); color: white; backdrop-filter: blur(6px);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Ver detalle
            </a>
                <div class="flex items-center gap-2 text-xs" style="color: rgba(255,255,255,0.55);">
                <a href="{{ route('iglesia.eventos.index') }}" class="hover:text-white transition-colors font-medium">Eventos</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white font-semibold">Editar</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-3xl">

    {{-- Alerta cambios no guardados --}}
    <div id="unsaved-alert"
         class="hidden mb-5 flex items-center gap-3 px-5 py-3.5 rounded-2xl"
         style="background:#FFFBEB; border:1px solid #FDE68A;">
        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <p class="text-xs font-semibold text-amber-800">Tienes cambios sin guardar</p>
    </div>

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

        <form action="{{ route('iglesia.eventos.update', $evento) }}" method="POST"
            novalidate id="form-editar-evento" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('iglesia.eventos._form')

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold
                           text-white rounded-xl shadow-md transition-all
                           hover:shadow-lg hover:-translate-y-0.5 active:scale-95"
                    style="background: linear-gradient(135deg, #2d1b69, #7c3aed);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Actualizar Evento
            </button>
            <a href="{{ route('iglesia.eventos.show', $evento) }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold
                      rounded-xl text-white transition-all hover:opacity-90 active:scale-95"
               style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Ver detalle
            </a>
            <a href="{{ route('iglesia.eventos.index') }}"
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
(function() {
    var form = document.getElementById('form-editar-evento');
    var alert = document.getElementById('unsaved-alert');
    var changed = false, submitted = false;
    if (!form || !alert) return;
    form.addEventListener('input',  function(){ if(!changed){ changed=true; alert.classList.remove('hidden'); } });
    form.addEventListener('change', function(){ if(!changed){ changed=true; alert.classList.remove('hidden'); } });
    form.addEventListener('submit', function(){ submitted=true; });
    window.addEventListener('beforeunload', function(e){ if(changed&&!submitted){ e.preventDefault(); e.returnValue=''; } });
})();
</script>
@endpush

@endsection