@extends('layouts.admin')

@section('title', 'Calendarios de Eventos')
@section('page-title', 'Calendarios de Eventos')
@section('page-subtitle', 'Eventos en Neiva y el departamento del Huila')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<div class="flex items-center gap-2 text-xs text-slate-400 mb-5">
    <a href="{{ route('admin.eventos.index') }}" class="hover:text-[#1E3A8A] transition-colors font-medium">Eventos</a>
    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-600 font-medium">Calendarios</span>
</div>

{{-- Selector de pestañas --}}
<div class="flex gap-2 mb-6 max-w-6xl">
    <button id="tab-neiva" onclick="switchTab('neiva')"
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all
                   bg-[#1E3A8A] text-white shadow-md shadow-blue-200">
        <span>&#x1F4CD;</span> Neiva
    </button>
    <button id="tab-huila" onclick="switchTab('huila')"
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all
                   bg-white text-slate-500 border border-slate-200 hover:border-violet-300 hover:text-violet-700">
        <span>&#x1F5FA;&#xFE0F;</span> Huila
    </button>
</div>

<div class="max-w-6xl">

    {{-- CALENDARIO 1: NEIVA --}}
    <div id="panel-neiva" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100"
             style="background: linear-gradient(135deg,#1E3A8A 0%,#2563EB 100%);">
            <span class="text-2xl">&#x1F4CD;</span>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight">Eventos en Neiva</h2>
                <p class="text-blue-200 text-xs mt-0.5">Eventos de iglesias con municipio = Neiva</p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <div id="calendar-neiva"></div>
        </div>
    </div>

    {{-- CALENDARIO 2: HUILA --}}
    <div id="panel-huila" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100"
             style="background: linear-gradient(135deg,#7C3AED 0%,#6D28D9 100%);">
            <span class="text-2xl">&#x1F5FA;&#xFE0F;</span>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight">Eventos en Huila</h2>
                <p class="text-violet-200 text-xs mt-0.5">Eventos de iglesias con departamento = Huila</p>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <div id="calendar-huila"></div>
        </div>
    </div>

</div>

{{-- Modal detalle evento --}}
<div id="ev-modal-overlay"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center p-4"
     onclick="cerrarModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative"
         onclick="event.stopPropagation()">

        {{-- Barra de acento coloreada --}}
        <div id="ev-modal-accent" class="h-1.5 w-full"></div>

        <div class="p-6">
            <button onclick="cerrarModal()"
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Badge tipo --}}
            <span id="ev-modal-badge"
                  class="inline-block text-xs font-bold px-3 py-0.5 rounded-full mb-3"></span>

            {{-- Título --}}
            <h3 id="ev-modal-title"
                class="font-bold text-slate-800 text-lg pr-6 mb-4 leading-snug"></h3>

            {{-- Filas de datos --}}
            <div id="ev-modal-body" class="space-y-2.5 text-sm text-slate-600"></div>

            {{-- Enlace a detalle completo (solo en eventos reales) --}}
            <a id="ev-modal-link" href="#"
               class="mt-5 flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                Ver detalles completos
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

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

    const TYPE_LABELS = { retiro:'Retiro', conferencia:'Conferencia', culto:'Culto', campamento:'Campamento', otro:'Otro' };
    const TYPE_COLORS = { retiro:'#8B5CF6', conferencia:'#3B82F6', culto:'#1E3A8A', campamento:'#F59E0B', otro:'#6B7280' };

    function abrirModal(accentColor, badge, badgeStyle, title, rows, linkHref) {
        document.getElementById('ev-modal-accent').style.background = accentColor;
        const badgeEl = document.getElementById('ev-modal-badge');
        badgeEl.textContent = badge;
        badgeEl.style.cssText = badgeStyle;
        document.getElementById('ev-modal-title').textContent = title;
        document.getElementById('ev-modal-body').innerHTML = rows || '<p class="text-slate-400 text-sm">Sin información adicional.</p>';
        const link = document.getElementById('ev-modal-link');
        if (linkHref) { link.href = linkHref; link.style.display = ''; }
        else          { link.style.display = 'none'; }
        document.getElementById('ev-modal-overlay').classList.remove('hidden');
        document.getElementById('ev-modal-overlay').classList.add('flex');
    }

    function fmtDate(d) {
        if (!d) return '';
        return d.toLocaleDateString('es-CO', { day:'numeric', month:'long', year:'numeric' });
    }

    function evRow(label, value) {
        return `<div class="flex gap-2">
            <span class="font-semibold text-slate-700 shrink-0 w-24">${label}:</span>
            <span class="text-slate-600">${value}</span>
        </div>`;
    }

    function onEventClick(info) {
        const id = info.event.id;
        const p  = info.event.extendedProps;

        if (String(id).startsWith('cumple-')) {
            let rows = '';
            if (p.iglesia)      rows += evRow('Iglesia',   p.iglesia);
            if (p.municipality) rows += evRow('Municipio', p.municipality);
            abrirModal('#F43F5E', '🎂 Cumpleaños', 'background:#FFF1F2;color:#F43F5E;', info.event.title, rows, null);
            return;
        }

        // Evento real
        const tipo  = (p.tipo_evento || 'otro').toLowerCase();
        const color = TYPE_COLORS[tipo] || '#6B7280';
        const label = TYPE_LABELS[tipo] || p.tipo_evento || 'Evento';

        const startFmt = fmtDate(info.event.start);
        let endFmt = '';
        if (info.event.end) {
            const d = new Date(info.event.end);
            d.setDate(d.getDate() - 1); // FullCalendar end es exclusivo
            const d0 = fmtDate(d);
            if (d0 !== startFmt) endFmt = d0;
        }

        let rows = '';
        rows += evRow('Fecha', startFmt + (endFmt ? ' — ' + endFmt : ''));
        if (p.iglesia)          rows += evRow('Iglesia',   p.iglesia);
        if (p.direccion_evento) rows += evRow('Dirección', p.direccion_evento);
        if (p.estado)           rows += evRow('Estado',    p.estado);

        abrirModal(color, label, `background:${color}18;color:${color};`, info.event.title, rows, '/admin/eventos/' + id);
    }

    const BASE_CONFIG = {
        ...LOCALE,
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth',
        },
        height: 'auto',
        eventClick: onEventClick,
        loading: function(isLoading) {
            // nothing
        },
    };

    const calNeiva = new FullCalendar.Calendar(
        document.getElementById('calendar-neiva'),
        {
            ...BASE_CONFIG,
            events: '/api/eventos/neiva',
            eventColor: '#2563EB',
        }
    );
    calNeiva.render();

    const calHuila = new FullCalendar.Calendar(
        document.getElementById('calendar-huila'),
        {
            ...BASE_CONFIG,
            events: '/api/eventos/huila',
            eventColor: '#7C3AED',
        }
    );
    calHuila.render();

    // Ocultar Huila inicialmente (DESPUÉS de render para que tenga dimensiones correctas)
    document.getElementById('panel-huila').classList.add('hidden');

    // ── Tabs: mostrar un calendario a la vez ──
    window.switchTab = function(tab) {
        const isNeiva = tab === 'neiva';

        document.getElementById('panel-neiva').classList.toggle('hidden', !isNeiva);
        document.getElementById('panel-huila').classList.toggle('hidden',  isNeiva);

        // Estilos activo / inactivo
        const btnActive   = isNeiva ? 'tab-neiva' : 'tab-huila';
        const btnInactive = isNeiva ? 'tab-huila' : 'tab-neiva';
        const activeColor = isNeiva ? ['bg-[#1E3A8A]','text-white','shadow-md','shadow-blue-200']
                                    : ['bg-[#7C3AED]','text-white','shadow-md','shadow-violet-200'];

        document.getElementById(btnActive).className =
            'flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all '
            + activeColor.join(' ');
        document.getElementById(btnInactive).className =
            'flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all '
            + 'bg-white text-slate-500 border border-slate-200 hover:border-slate-400 hover:text-slate-700';

        // FullCalendar necesita recalcular tamaño al hacerse visible
        setTimeout(() => {
            if (isNeiva) { calNeiva.updateSize(); }
            else         { calHuila.updateSize(); }
        }, 100);
    };

    // ── Cargar cumpleaños de líderes como fuente de eventos ──
    fetch('/api/iglesias')
        .then(r => r.json())
        .then(res => {
            const year    = new Date().getFullYear();
            const evNeiva = [];
            const evHuila = [];

            (res.data || []).forEach(ig => {
                // Soportar ambos campos: pastor_birth_date (importadas) y fecha_nacimiento_lider (legado)
                const rawDate = ig.pastor_birth_date || ig.fecha_nacimiento_lider;
                if (!rawDate) return;

                const raw = new Date(rawDate + 'T12:00:00');
                if (isNaN(raw)) return;

                const start = year + '-'
                    + String(raw.getMonth() + 1).padStart(2, '0') + '-'
                    + String(raw.getDate()).padStart(2, '0');

                const nombrePastor  = ig.pastor_sacerdote || '';
                const nombreIglesia = ig.nombre           || '';

                const ev = {
                    id:    'cumple-' + ig.id,
                    title: '\uD83C\uDF82 ' + (nombrePastor || nombreIglesia),
                    start,
                    end:   start,
                    color: '#F43F5E',
                    extendedProps: {
                        iglesia:      nombreIglesia,
                        tipo_evento:  'Cumplea\u00f1os',
                        municipality: ig.municipality,
                        department:   ig.department,
                    },
                };

                const mun = (ig.municipality || '').normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
                const dep = (ig.department  || '').normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();

                if (mun === 'neiva') evNeiva.push(ev);
                if (dep === 'huila') evHuila.push(ev);
            });

            // addEventSource garantiza que los eventos persistan aunque el panel esté oculto
            if (evNeiva.length) calNeiva.addEventSource(evNeiva);
            if (evHuila.length) calHuila.addEventSource(evHuila);
        })
        .catch(err => console.error('Error cargando cumpleaños:', err))
        .finally(() => {
            document.getElementById('panel-huila').classList.add('hidden');
        });
});

function cerrarModal(e) {
    if (e && e.target !== document.getElementById('ev-modal-overlay')) return;
    document.getElementById('ev-modal-overlay').classList.add('hidden');
    document.getElementById('ev-modal-overlay').classList.remove('flex');
}
</script>
@endpush