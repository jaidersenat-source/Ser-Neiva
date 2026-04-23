@extends('layouts.admin')

@section('title', 'Solicitud #' . $req->id)
@section('page-title', 'Solicitud #' . $req->id)
@section('page-subtitle', $req->nombre_organizacion)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.church-requests.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a solicitudes
    </a>
</div>

@if(session('success'))
<div class="mb-4 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── DATOS DE LA SOLICITUD ── --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
                 style="background: linear-gradient(135deg,#f0f9ff,#e0f2fe);">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0"
                     style="background: linear-gradient(135deg,#0369a1,#0ea5e9);">⛪</div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Datos de la organización</p>
                    <p class="text-xs text-slate-400 mt-0.5">Información enviada desde el formulario público</p>
                </div>
            </div>
            <dl class="divide-y divide-slate-50">
                @foreach([
                    'Nombre de organización' => $req->nombre_organizacion,
                    'Líder religioso'        => $req->lider_religioso,
                    'Número de contacto'     => $req->telefono,
                    'Dirección'              => $req->direccion,
                ] as $label => $value)
                <div class="px-5 py-4 flex gap-4">
                    <dt class="w-44 flex-shrink-0 text-xs font-bold uppercase tracking-wider text-slate-400 pt-0.5">{{ $label }}</dt>
                    <dd class="text-sm text-slate-800 font-medium">{{ $value }}</dd>
                </div>
                @endforeach
                <div class="px-5 py-4 flex gap-4">
                    <dt class="w-44 flex-shrink-0 text-xs font-bold uppercase tracking-wider text-slate-400 pt-0.5">Correo electrónico</dt>
                    <dd class="text-sm text-slate-800 font-medium">
                        <a href="mailto:{{ $req->email }}" class="text-sky-600 hover:underline">{{ $req->email }}</a>
                    </dd>
                </div>
                <div class="px-5 py-4 flex gap-4">
                    <dt class="w-44 flex-shrink-0 text-xs font-bold uppercase tracking-wider text-slate-400 pt-0.5">Fecha de envío</dt>
                    <dd class="text-sm text-slate-800 font-medium">
                        {{ $req->created_at->translatedFormat('d \d\e F \d\e Y, H:i') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- ── GESTIÓN ── --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
                 style="background: linear-gradient(135deg,#fffbeb,#fef3c7);">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-extrabold flex-shrink-0"
                     style="background: linear-gradient(135deg,#78350f,#b45309);">✓</div>
                <p class="text-sm font-bold text-slate-800">Gestión</p>
            </div>
            <div class="p-5">
                <p class="text-xs text-slate-500 mb-3">Estado actual: {!! $req->estadoBadge() !!}</p>

                <form method="POST" action="{{ route('admin.church-requests.update', $req) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Cambiar estado
                        </label>
                        <select name="estado" id="estado-select"
                                onchange="toggleMotivoRechazo(this.value)"
                                class="w-full px-3 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100">
                            @foreach(['pendiente'=>'Pendiente','revisada'=>'Revisada','aprobada'=>'Aprobada','rechazada'=>'Rechazada'] as $val=>$label)
                                <option value="{{ $val }}" {{ $req->estado === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-400 mt-1.5">
                            Al guardar, se enviará un correo automático al solicitante si el estado cambia.
                        </p>
                    </div>

                    {{-- Motivo de rechazo (visible solo si estado = rechazada) --}}
                    <div id="motivo-rechazo-wrap"
                         class="{{ ($req->estado === 'rechazada' || $errors->has('motivo_rechazo')) ? '' : 'hidden' }} mb-4">
                        <label class="block text-xs font-bold uppercase tracking-wider text-red-500 mb-1.5">
                            Motivo del rechazo <span class="text-red-500">*</span>
                        </label>
                        <textarea name="motivo_rechazo" id="motivo_rechazo" rows="3"
                                  class="w-full px-3 py-2.5 text-sm rounded-xl border {{ $errors->has('motivo_rechazo') ? 'border-red-400 bg-red-50' : 'border-red-200 bg-red-50/30' }} text-slate-800 focus:outline-none focus:ring-2 focus:border-red-400 focus:ring-red-100"
                                  placeholder="Explica brevemente por qué se rechaza la solicitud…">{{ old('motivo_rechazo', $req->motivo_rechazo) }}</textarea>
                        @error('motivo_rechazo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-red-400 mt-1">Este motivo se enviará por correo al solicitante.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                            Notas internas
                        </label>
                        <textarea name="notas_admin" rows="3"
                                  class="w-full px-3 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100"
                                  placeholder="Observaciones internas (no se envían por correo)…">{{ old('notas_admin', $req->notas_admin) }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full py-2.5 text-sm font-semibold text-white rounded-xl transition-all hover:opacity-90 active:scale-95"
                            style="background: linear-gradient(135deg,#78350f,#b45309);">
                        Guardar y notificar al solicitante
                    </button>
                </form>
            </div>
        </div>

        {{-- Eliminar --}}
        <form method="POST" action="{{ route('admin.church-requests.destroy', $req) }}"
              onsubmit="return confirm('¿Eliminar esta solicitud de forma permanente?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-full py-2.5 text-sm font-semibold text-red-600 rounded-xl border border-red-200 bg-white hover:bg-red-50 transition-all">
                Eliminar solicitud
            </button>
        </form>
    </div>

</div>

@push('scripts')
<script>
function toggleMotivoRechazo(val) {
    const wrap = document.getElementById('motivo-rechazo-wrap');
    if (val === 'rechazada') {
        wrap.classList.remove('hidden');
        document.getElementById('motivo_rechazo').required = true;
    } else {
        wrap.classList.add('hidden');
        document.getElementById('motivo_rechazo').required = false;
    }
}
// Inicializar al cargar
toggleMotivoRechazo(document.getElementById('estado-select').value);
</script>
@endpush

@endsection
