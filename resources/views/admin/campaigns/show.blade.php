@extends('layouts.admin')

@section('title', $campaign->subject)
@section('page-title', 'Vista Previa de Campaña')
@section('page-subtitle', $campaign->subject)

@section('content')

{{-- Hero strip --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0f4c3a 0%, #065f46 45%, #059669 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="70,0 200,0 200,120 130,120" fill="#6ee7b7"/>
            <polygon points="115,0 200,0 200,120 168,120" fill="#a7f3d0"/>
            <polygon points="155,0 200,0 200,55" fill="#d1fae5"/>
        </svg>
    </div>
    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5">
            <div class="flex items-start gap-4 min-w-0">
                <div class="w-14 h-14 sm:w-16 sm:h-16 flex-shrink-0 rounded-2xl flex items-center justify-center shadow-lg"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 2px solid rgba(255,255,255,0.2);">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="min-w-0 pt-1">
                    <h2 class="text-white font-bold text-xl sm:text-2xl leading-tight">{{ $campaign->subject }}</h2>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @if($campaign->isSent())
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full"
                                  style="background:rgba(34,197,94,0.2); color:#86efac;">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Enviada
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-2.5 py-1 rounded-full"
                                  style="background:rgba(255,255,255,0.15); color:white;">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Borrador
                            </span>
                        @endif
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full"
                              style="background:rgba(255,255,255,0.12); color:white;">
                            {{ $campaign->recipients->count() }} destinatarios
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex sm:flex-col items-center sm:items-end gap-3 flex-shrink-0">
                <div class="flex gap-2">
                    @if(!$campaign->isSent())
                        <button type="button" onclick="openModal('sendModal')"
                                class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl text-xs font-bold
                                       text-white transition-all hover:opacity-90 active:scale-95"
                                style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); backdrop-filter:blur(8px);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Enviar Campaña
                        </button>
                    @endif
                    <a href="{{ route('admin.campaigns.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-semibold
                              transition-all hover:opacity-90 active:scale-95"
                       style="background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.75); border:1px solid rgba(255,255,255,0.15);">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl mb-5"
         style="background: #F0FDF4; border: 1px solid #BBF7D0;">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl mb-5"
         style="background: #FFF1F2; border: 1px solid #FECDD3;">
        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- COLUMNA IZQUIERDA: Vista previa del correo --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#D1FAE5;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Vista previa del correo</p>
                    <p class="text-xs text-slate-400">Así verán el correo los destinatarios</p>
                </div>
            </div>

            {{-- Simulación del correo --}}
            <div class="p-5">
                <div class="border border-slate-200 rounded-xl overflow-hidden" style="max-width:640px; margin:0 auto;">
                    {{-- Header del email --}}
                    <div style="background: linear-gradient(135deg, #0a1f5c 0%, #0f2d7a 45%, #1E3A8A 100%); padding: 28px 24px; text-align:center;">
                        <h3 style="color:#fff; font-size:18px; font-weight:700; margin:0 0 4px;">SER – Sistema Estratégico Religioso</h3>
                        <p style="color:#93C5FD; font-size:12px; margin:0;">Neiva, Huila – Colombia</p>
                    </div>
                    {{-- Body del email --}}
                    <div style="padding:24px; font-size:14px; line-height:1.7; color:#334155;">
                        <p style="color:#64748B; font-size:13px; margin-bottom:14px;">Hola <strong>[Nombre del contacto]</strong>,</p>
                        <div class="prose prose-sm max-w-none">
                            {!! $campaign->message !!}
                        </div>
                    </div>
                    {{-- Imágenes --}}
                    @if($campaign->images->isNotEmpty())
                        <div style="padding:0 24px 16px;">
                            @foreach($campaign->images as $img)
                                <img src="{{ asset('storage/' . $img->path) }}"
                                     alt="{{ $img->original_name }}"
                                     style="max-width:100%; border-radius:10px; margin-bottom:10px; display:block;">
                            @endforeach
                        </div>
                    @endif
                    {{-- Footer --}}
                    <div style="background:#F8FAFC; border-top:1px solid #E2E8F0; padding:16px 24px; text-align:center;">
                        <p style="font-size:11px; color:#94A3B8; margin:0;">Este correo fue enviado desde el <strong>Sistema Estratégico Religioso de Neiva</strong>.</p>
                        <p style="font-size:11px; color:#94A3B8; margin:6px 0 0;">© {{ date('Y') }} SER – Neiva, Huila</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- COLUMNA DERECHA: Info de la campaña --}}
    <div class="flex flex-col gap-5">

        {{-- Detalles --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#EFF6FF;">
                    <svg class="w-4 h-4" style="color:#1E3A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">Detalles</p>
            </div>
            <div class="p-4 space-y-3">
                <div class="flex justify-between items-start gap-2 py-2 border-b border-slate-50">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Asunto</span>
                    <span class="text-xs font-semibold text-slate-700 text-right">{{ $campaign->subject }}</span>
                </div>
                <div class="flex justify-between items-start gap-2 py-2 border-b border-slate-50">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Filtro</span>
                    <span class="text-xs font-semibold text-slate-700">
                        @if($campaign->filter_type === 'all') Todas las iglesias
                        @elseif($campaign->filter_type === 'city') Ciudad: {{ $campaign->city }}
                        @else Selección manual
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-start gap-2 py-2 border-b border-slate-50">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Imágenes</span>
                    <span class="text-xs font-semibold text-slate-700">{{ $campaign->images->count() }}</span>
                </div>
                <div class="flex justify-between items-start gap-2 py-2 border-b border-slate-50">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Creada</span>
                    <span class="text-xs text-slate-500">{{ $campaign->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
                @if($campaign->sent_at)
                    <div class="flex justify-between items-start gap-2 py-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Enviada</span>
                        <span class="text-xs text-slate-500">{{ $campaign->sent_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Lista de destinatarios --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#D1FAE5;">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-800">Destinatarios</p>
                </div>
                <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                    {{ $campaign->recipients->count() }}
                </span>
            </div>
            <div class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                @foreach($campaign->recipients as $recipient)
                    @if($recipient->iglesia)
                        <div class="flex items-center gap-3 px-4 py-2.5">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0"
                                 style="background: linear-gradient(135deg, #065f46, #059669);">
                                {{ strtoupper(substr($recipient->iglesia->official_name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-slate-700 truncate">{{ $recipient->iglesia->official_name }}</p>
                                <p class="text-[11px] text-slate-400 truncate">{{ $recipient->iglesia->pastor_email ?: $recipient->iglesia->email }}</p>
                            </div>
                            @if($recipient->sent_at)
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Acciones --}}
        @if(!$campaign->isSent())
            <div class="space-y-3">
                <button type="button" onclick="openModal('sendModal')"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold
                               text-white transition-all hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #065f46, #059669);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Enviar Campaña Ahora
                </button>

                <button type="button" onclick="openModal('deleteModal')"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold
                               text-red-600 border border-red-200 hover:bg-red-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Eliminar Campaña
                </button>
            </div>
        @endif
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{--  MODAL: Confirmar Envío de Campaña                                --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@if(!$campaign->isSent())
<div id="sendModal" class="fixed inset-0 z-50 hidden">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('sendModal')"></div>
    {{-- Panel --}}
    <div class="flex items-center justify-center min-h-full p-4">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all"
             style="animation: modalIn 0.25s ease-out;">
            {{-- Header con icono --}}
            <div class="flex flex-col items-center pt-8 pb-2 px-6">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                     style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0);">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Enviar Campaña</h3>
                <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                    ¿Estás seguro de enviar esta campaña a
                    <span class="font-bold text-emerald-700">{{ $campaign->recipients->count() }}</span>
                    destinatarios?
                </p>
                <p class="text-xs text-slate-400 text-center mt-1">
                    Esta acción no se puede revertir una vez iniciado el envío.
                </p>
            </div>
            {{-- Acciones --}}
            <div class="flex gap-3 p-6 pt-4">
                <button type="button" onclick="closeModal('sendModal')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600
                               border border-slate-200 hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <form method="POST" action="{{ route('admin.campaigns.send', $campaign) }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-bold text-white transition-all
                                   hover:opacity-90 active:scale-95"
                            style="background: linear-gradient(135deg, #065f46, #059669);">
                        Sí, enviar ahora
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{--  MODAL: Confirmar Eliminación de Campaña                          --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('deleteModal')"></div>
    {{-- Panel --}}
    <div class="flex items-center justify-center min-h-full p-4">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all"
             style="animation: modalIn 0.25s ease-out;">
            {{-- Header con icono --}}
            <div class="flex flex-col items-center pt-8 pb-2 px-6">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                     style="background: linear-gradient(135deg, #FEE2E2, #FECACA);">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Eliminar Campaña</h3>
                <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                    ¿Estás seguro de eliminar esta campaña?
                </p>
                <p class="text-xs text-red-400 text-center mt-1 font-semibold">
                    Esta acción no se puede deshacer.
                </p>
            </div>
            {{-- Acciones --}}
            <div class="flex gap-3 p-6 pt-4">
                <button type="button" onclick="closeModal('deleteModal')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600
                               border border-slate-200 hover:bg-slate-50 transition-colors">
                    Cancelar
                </button>
                <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-bold text-white transition-all
                                   hover:opacity-90 active:scale-95"
                            style="background: linear-gradient(135deg, #DC2626, #EF4444);">
                        Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Estilos y JS para modales --}}
<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes modalOut {
        from { opacity: 1; transform: scale(1) translateY(0); }
        to   { opacity: 0; transform: scale(0.95) translateY(10px); }
    }
</style>
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        const modal = document.getElementById(id);
        const panel = modal.querySelector('.relative.w-full');
        panel.style.animation = 'modalOut 0.2s ease-in forwards';
        setTimeout(() => {
            modal.classList.add('hidden');
            panel.style.animation = 'modalIn 0.25s ease-out';
            document.body.style.overflow = '';
        }, 200);
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.fixed.z-50:not(.hidden)').forEach(m => closeModal(m.id));
        }
    });
</script>

@endsection
