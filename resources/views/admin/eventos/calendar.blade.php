@extends('layouts.admin')

@section('title', 'Calendarios de Eventos')
@section('page-title', 'Calendarios de Eventos')
@section('page-subtitle', 'Eventos en Neiva y el departamento del Huila')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

{{-- ═══════════════════════════════════
     HERO STRIP
═══════════════════════════════════ --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #2d1b69 0%, #4c1d95 45%, #7c3aed 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full opacity-10"
             style="background: radial-gradient(circle, #a78bfa, transparent 70%);"></div>
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
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight">Calendarios de Eventos</h2>
                <p class="text-xs mt-0.5" style="color: rgba(196,181,253,0.85);">
                    Agenda de eventos en Neiva y el departamento del Huila
                </p>
            </div>
        </div>

        {{-- Breadcrumb --}}
        <div class="hidden sm:flex items-center gap-2 text-xs" style="color: rgba(255,255,255,0.55);">
            <a href="{{ route('admin.eventos.index') }}"
               class="hover:text-white transition-colors font-medium">Eventos</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-semibold">Calendarios</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     LEYENDA DE TIPOS
═══════════════════════════════════ --}}
<div class="mb-5 flex flex-wrap items-center gap-2">
    @php
        $tipoLegend = [
            ['label'=>'Retiro',       'color'=>'#8B5CF6', 'bg'=>'#F5F3FF'],
            ['label'=>'Conferencia',  'color'=>'#3B82F6', 'bg'=>'#EFF6FF'],
            ['label'=>'Culto',        'color'=>'#1E3A8A', 'bg'=>'#EFF6FF'],
            ['label'=>'Campamento',   'color'=>'#F59E0B', 'bg'=>'#FFFBEB'],
            ['label'=>'Otro',         'color'=>'#6B7280', 'bg'=>'#F9FAFB'],
            ['label'=>'Cumpleaños',   'color'=>'#F43F5E', 'bg'=>'#FFF1F2'],
        ];
    @endphp
    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-1">Tipos:</span>
    @foreach($tipoLegend as $t)
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full border"
              style="background:{{ $t['bg'] }}; color:{{ $t['color'] }}; border-color:{{ $t['color'] }}30;">
            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $t['color'] }};"></span>
            {{ $t['label'] }}
        </span>
    @endforeach
</div>

{{-- ═══════════════════════════════════
     TABS
═══════════════════════════════════ --}}
<div class="flex gap-2 mb-5">
    <button id="tab-neiva" onclick="switchTab('neiva')"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all
                   text-white shadow-md"
            style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8); box-shadow: 0 4px 12px rgba(14,107,168,0.3);">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Neiva
    </button>
    <button id="tab-huila" onclick="switchTab('huila')"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all
                   border border-slate-200 bg-white text-slate-500 hover:border-violet-300 hover:text-violet-700">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 13l4.553 2.276A1 1 0 0021 21.382V10.618a1 1 0 00-.553-.894L15 7m0 13V7m0 0L9 4"/>
        </svg>
        Huila
    </button>
</div>

{{-- ═══════════════════════════════════
     PANELES DE CALENDARIO
═══════════════════════════════════ --}}
<div class="max-w-6xl space-y-4">

    {{-- NEIVA --}}
    <div id="panel-neiva" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100"
             style="background: linear-gradient(135deg, #0a1f5c 0%, #0e6ba8 100%);">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(255,255,255,0.15); backdrop-filter: blur(6px);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-bold text-base leading-tight">Eventos en Neiva</h2>
                <p class="text-xs mt-0.5" style="color: rgba(144,224,239,0.85);">
                    Iglesias con municipio = Neiva
                </p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <div id="calendar-neiva"></div>
        </div>
    </div>

    {{-- HUILA --}}
    <div id="panel-huila" class="hidden bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100"
             style="background: linear-gradient(135deg, #2d1b69 0%, #7c3aed 100%);">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background: rgba(255,255,255,0.15); backdrop-filter: blur(6px);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 13l4.553 2.276A1 1 0 0021 21.382V10.618a1 1 0 00-.553-.894L15 7m0 13V7m0 0L9 4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-bold text-base leading-tight">Eventos en Huila</h2>
                <p class="text-xs mt-0.5" style="color: rgba(196,181,253,0.85);">
                    Iglesias con departamento = Huila
                </p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <div id="calendar-huila"></div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════
     MODAL DETALLE EVENTO
═══════════════════════════════════ --}}
<div id="ev-modal-overlay"
     class="fixed inset-0 z-50 hidden items-end sm:items-center justify-center p-0 sm:p-4"
     style="background: rgba(15,23,42,0.55); backdrop-filter: blur(4px);"
     onclick="cerrarModal(event)">

    <div class="bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl w-full sm:max-w-md overflow-hidden relative"
         onclick="event.stopPropagation()">

        {{-- Barra de acento --}}
        <div id="ev-modal-accent" class="h-1.5 w-full"></div>

        <div class="p-6">
            {{-- Cerrar --}}
            <button onclick="cerrarModalBtn()"
                    class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-xl
                           text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Badge tipo --}}
            <span id="ev-modal-badge"
                  class="inline-block text-xs font-bold px-3 py-1 rounded-full mb-3"></span>

            {{-- Título --}}
            <h3 id="ev-modal-title"
                class="font-bold text-slate-800 text-lg pr-8 mb-4 leading-snug"></h3>

            {{-- Filas --}}
            <div id="ev-modal-body" class="space-y-3 text-sm text-slate-600"></div>

            {{-- Link --}}
            <a id="ev-modal-link" href="#"
               class="mt-5 inline-flex items-center gap-1.5 text-xs font-bold rounded-lg px-4 py-2.5
                      text-white transition-all hover:opacity-90 hover:shadow-md hover:-translate-y-0.5"
               style="background: linear-gradient(135deg, #2d1b69, #7c3aed);">
                Ver detalles completos
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

{{-- ── FullCalendar overrides ── --}}
<style>
.fc .fc-toolbar-title        { font-size: 1rem; font-weight: 700; color: #1e293b; }
.fc .fc-button               { border-radius: .625rem !important; font-size: .75rem !important; font-weight: 600 !important; text-transform: none !important; }
.fc .fc-button-primary       { background: linear-gradient(135deg,#2d1b69,#7c3aed) !important; border: none !important; }
.fc .fc-button-primary:hover { opacity: .88 !important; }
.fc .fc-button-primary:not(:disabled):active,
.fc .fc-button-primary.fc-button-active { background: #2d1b69 !important; }
.fc .fc-button-primary:focus  { box-shadow: 0 0 0 2px #c4b5fd !important; }
.fc .fc-today-button          { background: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0 !important; }
.fc .fc-daygrid-day.fc-day-today { background: #f5f3ff !important; }
.fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color: #7c3aed; font-weight: 800; }
.fc .fc-event               { border-radius: .5rem !important; border: none !important; font-size: .7rem !important; font-weight: 600 !important; padding: 2px 5px !important; }
.fc .fc-col-header-cell-cushion { font-size: .7rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
.fc .fc-daygrid-day-number  { font-size: .78rem; font-weight: 600; color: #475569; }
.fc .fc-more-link            { font-size: .68rem; font-weight: 700; color: #7c3aed; }
.fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const LOCALE = {
        locale: 'es',
        buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día', list: 'Lista' },
        allDayText: 'Todo el día',
        moreLinkText: function(n){ return '+' + n + ' más'; },
    };

    const TYPE_LABELS = {
        retiro: 'Retiro', conferencia: 'Conferencia',
        culto: 'Culto', campamento: 'Campamento', otro: 'Otro'
    };
    const TYPE_COLORS = {
        retiro: '#8B5CF6', conferencia: '#3B82F6',
        culto: '#1E3A8A', campamento: '#F59E0B', otro: '#6B7280'
    };

    // ── Modal helpers ────────────────────────────────────────────
    function abrirModal(accentColor, badge, badgeStyle, title, rows, linkHref) {
        document.getElementById('ev-modal-accent').style.background = accentColor;
        const badgeEl = document.getElementById('ev-modal-badge');
        badgeEl.textContent = badge;
        badgeEl.style.cssText = badgeStyle;
        document.getElementById('ev-modal-title').textContent = title;
        document.getElementById('ev-modal-body').innerHTML = rows ||
            '<p class="text-slate-400 text-sm italic">Sin información adicional.</p>';
        const link = document.getElementById('ev-modal-link');
        if (linkHref) { link.href = linkHref; link.style.display = ''; }
        else          { link.style.display = 'none'; }
        const overlay = document.getElementById('ev-modal-overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    }

    function fmtDate(d) {
        if (!d) return '';
        return d.toLocaleDateString('es-CO', { day: 'numeric', month: 'long', year: 'numeric' });
    }

    function evRow(icon, label, value) {
        return `<div class="flex items-start gap-3 py-2 border-b border-slate-50 last:border-0">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                 style="background:#F8FAFF;">
                ${icon}
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">${label}</p>
                <p class="text-sm font-semibold text-slate-700 leading-snug">${value}</p>
            </div>
        </div>`;
    }

    const ICON_CAL  = `<svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;
    const ICON_CHUR = `<svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>`;
    const ICON_PIN  = `<svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`;
    const ICON_INFO = `<svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;

    function onEventClick(info) {
        const id = info.event.id;
        const p  = info.event.extendedProps;

        if (String(id).startsWith('cumple-')) {
            let rows = '';
            if (p.iglesia)      rows += evRow(ICON_CHUR, 'Iglesia',   p.iglesia);
            if (p.municipality) rows += evRow(ICON_PIN,  'Municipio', p.municipality);
            abrirModal('#F43F5E', '🎂 Cumpleaños',
                'background:#FFF1F2;color:#F43F5E;border:1px solid #FCA5A5;',
                info.event.title, rows, null);
            return;
        }

        const tipo  = (p.tipo_evento || 'otro').toLowerCase();
        const color = TYPE_COLORS[tipo] || '#6B7280';
        const label = TYPE_LABELS[tipo] || p.tipo_evento || 'Evento';

        const startFmt = fmtDate(info.event.start);
        let endFmt = '';
        if (info.event.end) {
            const d = new Date(info.event.end);
            d.setDate(d.getDate() - 1);
            const d0 = fmtDate(d);
            if (d0 !== startFmt) endFmt = d0;
        }

        let rows = '';
        rows += evRow(ICON_CAL,  'Fecha',    startFmt + (endFmt ? ' — ' + endFmt : ''));
        if (p.iglesia)          rows += evRow(ICON_CHUR, 'Iglesia',   p.iglesia);
        if (p.direccion_evento) rows += evRow(ICON_PIN,  'Dirección', p.direccion_evento);
        if (p.estado)           rows += evRow(ICON_INFO, 'Estado',    p.estado);

        abrirModal(color,
            label,
            `background:${color}18;color:${color};border:1px solid ${color}30;`,
            info.event.title, rows,
            '/admin/eventos/' + id);
    }

    const BASE_CONFIG = {
        ...LOCALE,
        initialView: 'dayGridMonth',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listMonth',
        },
        height: 'auto',
        eventClick: onEventClick,
    };

    const calNeiva = new FullCalendar.Calendar(
        document.getElementById('calendar-neiva'),
        { ...BASE_CONFIG, events: '/api/eventos/neiva', eventColor: '#0e6ba8' }
    );
    calNeiva.render();

    const calHuila = new FullCalendar.Calendar(
        document.getElementById('calendar-huila'),
        { ...BASE_CONFIG, events: '/api/eventos/huila', eventColor: '#7c3aed' }
    );
    calHuila.render();

    // ── Tabs ────────────────────────────────────────────────────
    window.switchTab = function(tab) {
        const isNeiva = tab === 'neiva';

        document.getElementById('panel-neiva').classList.toggle('hidden', !isNeiva);
        document.getElementById('panel-huila').classList.toggle('hidden',  isNeiva);

        const baseInactive = 'inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all border border-slate-200 bg-white text-slate-500 hover:border-violet-300 hover:text-violet-700';

        if (isNeiva) {
            document.getElementById('tab-neiva').className =
                'inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all text-white shadow-md';
            document.getElementById('tab-neiva').style.cssText =
                'background: linear-gradient(135deg,#0a1f5c,#0e6ba8); box-shadow:0 4px 12px rgba(14,107,168,0.3);';
            document.getElementById('tab-huila').className  = baseInactive;
            document.getElementById('tab-huila').style.cssText = '';
        } else {
            document.getElementById('tab-huila').className =
                'inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all text-white shadow-md';
            document.getElementById('tab-huila').style.cssText =
                'background: linear-gradient(135deg,#2d1b69,#7c3aed); box-shadow:0 4px 12px rgba(124,58,237,0.3);';
            document.getElementById('tab-neiva').className  = baseInactive;
            document.getElementById('tab-neiva').style.cssText = '';
        }

        setTimeout(function() {
            if (isNeiva) calNeiva.updateSize();
            else         calHuila.updateSize();
        }, 100);
    };

    // ── Cumpleaños ──────────────────────────────────────────────
    fetch('/api/iglesias')
        .then(r => r.json())
        .then(res => {
            const year    = new Date().getFullYear();
            const evNeiva = [];
            const evHuila = [];

            (res.data || []).forEach(ig => {
                const rawDate = ig.pastor_birth_date || ig.fecha_nacimiento_lider;
                if (!rawDate) return;
                const raw = new Date(rawDate + 'T12:00:00');
                if (isNaN(raw)) return;

                const start = year + '-'
                    + String(raw.getMonth() + 1).padStart(2, '0') + '-'
                    + String(raw.getDate()).padStart(2, '0');

                const ev = {
                    id: 'cumple-' + ig.id,
                    title: '🎂 ' + (ig.pastor_sacerdote || ig.nombre || ''),
                    start, end: start,
                    color: '#F43F5E',
                    extendedProps: {
                        iglesia:      ig.nombre || '',
                        tipo_evento:  'Cumpleaños',
                        municipality: ig.municipality,
                        department:   ig.department,
                    },
                };

                const mun = (ig.municipality || '').normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase().trim();
                const dep = (ig.department   || '').normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase().trim();

                if (mun === 'neiva') evNeiva.push(ev);
                if (dep === 'huila') evHuila.push(ev);
            });

            if (evNeiva.length) calNeiva.addEventSource(evNeiva);
            if (evHuila.length) calHuila.addEventSource(evHuila);
        })
        .catch(err => console.error('Error cargando cumpleaños:', err));
});

// ── Cerrar modal ─────────────────────────────────────────────────
function cerrarModal(e) {
    const overlay = document.getElementById('ev-modal-overlay');
    if (e && e.target !== overlay) return;
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
}
function cerrarModalBtn() {
    const overlay = document.getElementById('ev-modal-overlay');
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
}

// Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModalBtn();
});
</script>
@endpush