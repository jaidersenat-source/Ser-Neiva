@extends('layouts.admin')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')
@section('page-subtitle', 'Administra tu información personal y seguridad')

@section('content')

{{-- Estilos globales compartidos por los tres partials --}}
<style>
    /* ── Wrapper general ── */
    .profile-wrap { display: flex; flex-direction: column; gap: 20px; }

    /* ── Card ── */
    .p-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
        overflow: hidden;
    }
    .p-card-header {
        display: flex; align-items: center; gap: 14px;
        padding: 16px 24px;
        border-bottom: 1px solid #F8FAFC;
        background: #FAFBFF;
    }
    .p-header-icon {
        width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .p-icon-blue   { background: #EFF6FF; }
    .p-icon-amber  { background: #FFFBEB; }
    .p-icon-red    { background: #FFF1F2; }
    .p-card-title  { font-size: .9rem; font-weight: 700; color: #1E293B; }
    .p-card-sub    { font-size: .72rem; color: #94A3B8; margin-top: 1px; }
    .p-card-body   { padding: 24px; }

    /* ── Avatar banner ── */
    .p-avatar-banner {
        background: linear-gradient(135deg, #0F2563, #1E3A8A);
        padding: 20px 24px;
        display: flex; align-items: center; gap: 16px;
        border-radius: 18px;
        position: relative; overflow: hidden;
        margin-bottom: 0;
    }
    .p-avatar-banner::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
        background-size: 18px 18px;
    }
    .p-avatar-circle {
        width: 60px; height: 60px;
        background: #F59E0B; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 800; color: #fff;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(245,158,11,.45);
        border: 3px solid rgba(255,255,255,.2);
        position: relative; z-index: 1;
    }
    .p-avatar-info { position: relative; z-index: 1; }
    .p-avatar-name  { font-size: 1rem; font-weight: 700; color: #fff; }
    .p-avatar-email { font-size: .74rem; color: #93C5FD; margin-top: 2px; }
    .p-avatar-role  {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(245,158,11,.2); border: 1px solid rgba(245,158,11,.3);
        color: #FCD34D; font-size: .67rem; font-weight: 700;
        padding: 3px 9px; border-radius: 20px; margin-top: 6px;
        letter-spacing: .04em;
    }

    /* ── Campos ── */
    .p-label {
        display: block;
        font-size: .72rem; font-weight: 700;
        color: #475569; letter-spacing: .04em; text-transform: uppercase;
        margin-bottom: 7px;
    }
    .p-input {
        width: 100%;
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: .86rem; color: #334155;
        font-family: inherit; outline: none;
        transition: border-color .15s, box-shadow .15s, background .15s;
        box-sizing: border-box;
        -webkit-appearance: none;
    }
    .p-input:focus {
        border-color: #3B82F6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,.12);
    }
    .p-input.has-error { border-color: #F87171; background: #FFF5F5; }
    .p-input[type="password"] { padding-right: 38px; }

    /* ── Ojo contraseña ── */
    .p-pwd-wrap { position: relative; }
    .p-pwd-eye {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #94A3B8; padding: 3px; transition: color .15s;
    }
    .p-pwd-eye:hover { color: #475569; }

    /* ── Error ── */
    .p-error {
        display: flex; align-items: center; gap: 5px;
        font-size: .7rem; font-weight: 600; color: #EF4444; margin-top: 5px;
    }

    /* ── Grid ── */
    .p-grid-2 { display: grid; grid-template-columns: 1fr; gap: 16px; }
    @media(min-width:640px) { .p-grid-2 { grid-template-columns: 1fr 1fr; } }
    .p-col-full { grid-column: 1 / -1; }

    /* ── Alert éxito ── */
    .p-alert-ok {
        display: flex; align-items: center; gap: 10px;
        background: #F0FDF4; border: 1px solid #BBF7D0;
        border-radius: 12px; padding: 12px 16px;
        font-size: .8rem; font-weight: 500; color: #166534;
        margin-bottom: 18px;
        animation: pFadeUp .3s ease;
    }
    @keyframes pFadeUp {
        from { opacity:0; transform:translateY(-6px); }
        to   { opacity:1; transform:translateY(0); }
    }

    /* ── Botones ── */
    .p-btn-save {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #0F2563, #1E3A8A);
        color: #fff; font-size: .84rem; font-weight: 600;
        padding: 10px 22px; border-radius: 12px;
        border: none; cursor: pointer;
        box-shadow: 0 3px 10px rgba(30,58,138,.3);
        transition: opacity .15s, transform .12s;
        font-family: inherit;
    }
    .p-btn-save:hover  { opacity: .9; transform: translateY(-1px); }
    .p-btn-save:active { transform: scale(.97); }

    .p-btn-danger {
        display: inline-flex; align-items: center; gap: 7px;
        background: #FFF1F2; color: #9F1239;
        font-size: .84rem; font-weight: 600;
        padding: 10px 22px; border-radius: 12px;
        border: 1.5px solid #FECDD3; cursor: pointer;
        transition: background .15s, transform .12s;
        font-family: inherit;
    }
    .p-btn-danger:hover  { background: #FFE4E6; transform: translateY(-1px); }

    /* ── Danger zone ── */
    .p-danger-zone {
        background: #FFF5F5; border: 1.5px solid #FED7D7;
        border-radius: 14px; padding: 18px 20px;
    }
    .p-danger-title { font-size: .88rem; font-weight: 700; color: #9B1C1C; margin-bottom: 6px; }
    .p-danger-desc  { font-size: .78rem; color: #C53030; line-height: 1.6; margin-bottom: 16px; }

    /* ── Modal ── */
    .p-modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(15,37,99,.5); backdrop-filter: blur(3px);
        z-index: 300; align-items: center; justify-content: center; padding: 20px;
    }
    .p-modal-overlay.show { display: flex; }
    .p-modal-box {
        background: #fff; border-radius: 20px;
        width: 100%; max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        overflow: hidden; animation: pFadeUp .25s ease;
    }
    .p-modal-header {
        background: #FFF1F2; padding: 20px 24px;
        border-bottom: 1px solid #FED7D7;
        display: flex; align-items: center; gap: 12px;
    }
    .p-modal-icon {
        width: 40px; height: 40px; background: #FEE2E2;
        border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .p-modal-title { font-size: .95rem; font-weight: 700; color: #9B1C1C; }
    .p-modal-sub   { font-size: .75rem; color: #C53030; margin-top: 2px; }
    .p-modal-body  { padding: 24px; }
    .p-modal-body p { font-size: .83rem; color: #64748B; line-height: 1.6; margin-bottom: 18px; }
    .p-modal-footer {
        padding: 16px 24px; border-top: 1px solid #F1F5F9;
        display: flex; gap: 10px; justify-content: flex-end; flex-wrap: wrap;
    }
    .p-btn-modal-cancel {
        padding: 9px 18px; border-radius: 10px;
        border: 1.5px solid #E2E8F0; background: #fff;
        font-size: .82rem; font-weight: 600; color: #64748B;
        cursor: pointer; font-family: inherit; transition: background .15s;
    }
    .p-btn-modal-cancel:hover { background: #F8FAFC; }
    .p-btn-modal-confirm {
        padding: 9px 18px; border-radius: 10px;
        background: #DC2626; border: none;
        font-size: .82rem; font-weight: 700; color: #fff;
        cursor: pointer; font-family: inherit; transition: background .15s;
    }
    .p-btn-modal-confirm:hover { background: #B91C1C; }

    /* ── Overrides Breeze ── */
    /* Neutralizar estilos genéricos que puedan colarse de los partials */
    .p-card-body section > p   { display: none; }  /* oculta el párrafo "Manage account info" de Breeze */
    .p-card-body section > h2  { display: none; }  /* oculta el h2 de Breeze */
</style>

<div class="profile-wrap">

    {{-- ── Avatar banner ── --}}
    <div class="p-avatar-banner">
        <div class="p-avatar-circle">{{ substr(auth()->user()->name, 0, 1) }}</div>
        <div class="p-avatar-info">
            <p class="p-avatar-name">{{ auth()->user()->name }}</p>
            <p class="p-avatar-email">{{ auth()->user()->email }}</p>
            <span class="p-avatar-role">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                Administrador SIRN
            </span>
        </div>
    </div>

    {{-- ── Información del perfil ── --}}
    <div class="p-card">
        <div class="p-card-header">
            <div class="p-header-icon p-icon-blue">
                <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="p-card-title">Información del perfil</p>
                <p class="p-card-sub">Actualiza tu nombre y correo electrónico</p>
            </div>
        </div>
        <div class="p-card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- ── Contraseña ── --}}
    <div class="p-card">
        <div class="p-card-header">
            <div class="p-header-icon p-icon-amber">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <p class="p-card-title">Cambiar contraseña</p>
                <p class="p-card-sub">Usa una contraseña segura de al menos 8 caracteres</p>
            </div>
        </div>
        <div class="p-card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- ── Eliminar cuenta ── --}}
    <div class="p-card">
        <div class="p-card-header">
            <div class="p-header-icon p-icon-red">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <p class="p-card-title">Zona de peligro</p>
                <p class="p-card-sub">Acciones irreversibles sobre tu cuenta</p>
            </div>
        </div>
        <div class="p-card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

@endsection