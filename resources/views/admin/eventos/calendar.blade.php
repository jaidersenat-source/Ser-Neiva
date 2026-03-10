@extends('layouts.admin')

@section('title', 'Calendario')
@section('page-title', 'Calendario de Eventos')
@section('page-subtitle', 'Visualiza y gestiona los eventos en un calendario interactivo')

@section('content')

@vite(['resources/css/admin/event/calendario.css'])

<style>
/* ── Tamaño fijo de celdas: siempre igual, con o sin eventos ── */
.cal-table td {
  height: 100px !important;
  min-height: 100px !important;
  max-height: 100px !important;
  vertical-align: top;
  overflow: hidden;
}

/* ── Dias CON eventos: borde izquierdo + fondo suave ── */
.cal-table td.has-events {
  background: linear-gradient(135deg, #EFF6FF 0%, #F8FAFF 100%);
  border-left: 3px solid #3B82F6 !important;
  box-shadow: inset 2px 0 8px rgba(59,130,246,.06);
}

/* ── Punto indicador bajo el numero ── */
.cal-table td.has-events .day-num::after {
  content: '';
  display: block;
  width: 5px;
  height: 5px;
  background: #3B82F6;
  border-radius: 50%;
  margin: 2px auto 0;
}

/* ── Hoy con eventos: punto blanco ── */
.cal-table td.today.has-events .day-num::after {
  background: #fff;
}

/* ── Chips de eventos: linea discreta, sin cambiar altura ── */
.event-chip {
  display: block;
  font-size: .68rem;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 4px;
  margin-top: 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}
</style>

<main class="page">
  <nav class="breadcrumb">
    <a href="{{ route('admin.eventos.index') }}">Eventos</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
    <span>Calendario</span>
  </nav>

  <div class="cal-card">
    <div class="cal-topbar">
      <div class="cal-title-group">
        <div class="cal-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="cal-title-text">
          <h2>Calendario de Eventos</h2>
          <p>Haz clic en un evento para ver detalles</p>
        </div>
      </div>
      <div class="cal-actions">
        <button class="btn-icon" title="Filtros">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="14" y2="12"/><line x1="4" y1="18" x2="10" y2="18"/></svg>
        </button>
        <button class="btn-primary" onclick="openNewEventModal()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Nuevo Evento
        </button>
        <script>
        document.querySelector('.btn-primary').onclick = function() {
          window.location.href = '/admin/eventos/create';
        };
        </script>
      </div>
    </div>

    <div class="cal-nav">
      <div class="nav-left">
        <button class="btn-nav" onclick="navigate(-1)">&#8249;</button>
        <button class="btn-nav" onclick="navigate(1)">&#8250;</button>
        <button class="btn-today" onclick="goToday()">Hoy</button>
      </div>
      <div class="cal-month-title" id="monthTitle">febrero de 2026</div>
      <div class="view-tabs">
        <button class="view-tab active" onclick="switchView('month',this)">Mes</button>
        <button class="view-tab" onclick="switchView('week',this)">Semana</button>
        <button class="view-tab" onclick="switchView('day',this)">Dia</button>
        <button class="view-tab" onclick="switchView('list',this)">Lista</button>
      </div>
    </div>

    <div id="monthView">
      <div class="cal-grid">
        <table class="cal-table">
          <thead><tr id="weekHeaders"></tr></thead>
          <tbody id="calBody"></tbody>
        </table>
      </div>
    </div>

    <div id="weekView" class="week-view" style="overflow-x:auto;">
      <div class="week-grid" id="weekGrid"></div>
    </div>

    <div id="dayView" class="day-view-container">
      <div class="day-view-title" id="dayViewTitle"></div>
      <div class="day-event-list" id="dayEventList"></div>
    </div>

    <div id="listView" class="list-view">
      <div id="listContent"></div>
    </div>
  </div>
</main>

<div class="modal-overlay" id="eventModal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="modalTitle">Nuevo Evento</h3>
      <button class="modal-close" onclick="closeModal()">x</button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label class="form-label">Nombre del evento</label>
        <input class="form-input" type="text" placeholder="Ej: Conferencia Anual" id="eventName">
      </div>
      <div class="form-group">
        <label class="form-label">Tipo</label>
        <select class="form-select" id="eventType">
          <option value="retiro">Retiro</option>
          <option value="conferencia">Conferencia</option>
          <option value="culto">Culto</option>
          <option value="campamento">Campamento</option>
          <option value="otro">Otro</option>
        </select>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Fecha inicio</label>
          <input class="form-input" type="date" id="eventStart" value="2026-02-25">
        </div>
        <div class="form-group">
          <label class="form-label">Fecha fin</label>
          <input class="form-input" type="date" id="eventEnd" value="2026-02-25">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Descripcion (opcional)</label>
        <input class="form-input" type="text" placeholder="Breve descripcion..." id="eventDesc">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal()">Cancelar</button>
      <button class="btn-primary" onclick="saveEvent()">Guardar Evento</button>
    </div>
  </div>
</div>

<script>
const DAYS_ES = ['dom','lun','mar','mie','jue','vie','sa'];
const DAYS_FULL = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
const MONTHS_ES = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];


const TYPE_LABELS = { retiro:'Retiro', conferencia:'Conferencia', culto:'Culto', campamento:'Campamento', otro:'Otro', cumple:'Cumpleaños' };
const TYPE_COLORS = { retiro:'#8B5CF6', conferencia:'#3B82F6', culto:'#1E3A8A', campamento:'#F59E0B', otro:'#6B7280', cumple:'#F43F5E' };

let currentDate = new Date(2026, 1, 1);
let today = new Date();
let currentView = 'month';
let events = [];

function fetchEvents() {
  // 1. Obtener eventos normales
  fetch('/api/eventos')
    .then(res => res.json())
    .then(data => {
      events = data.map(ev => ({
        id:       ev.id,
        name:     ev.title,
        type:     ev.tipo_evento,
        start:    ev.start.substring(0,10),
        end:      ev.end ? ev.end.substring(0,10) : ev.start.substring(0,10),
        desc:     ev.extendedProps && ev.extendedProps.direccion_evento ? ev.extendedProps.direccion_evento : '',
        iglesia:  ev.extendedProps && ev.extendedProps.iglesia          ? ev.extendedProps.iglesia          : '',
        latitud:  ev.extendedProps && ev.extendedProps.latitud          ? ev.extendedProps.latitud          : '',
        longitud: ev.extendedProps && ev.extendedProps.longitud         ? ev.extendedProps.longitud         : '',
        estado:   ev.extendedProps && ev.extendedProps.estado           ? ev.extendedProps.estado           : '',
      }));
      // 2. Obtener cumpleaños de líderes de iglesias
      fetch('/api/iglesias')
        .then(res => res.json())
        .then(igdata => {
          if (igdata && igdata.data) {
            igdata.data.forEach(ig => {
              if (ig.fecha_nacimiento_lider) {
                // Cumpleaños este año
                const fecha = new Date(ig.fecha_nacimiento_lider);
                const year = (new Date()).getFullYear();
                const cumple = year + '-' + String(fecha.getMonth()+1).padStart(2,'0') + '-' + String(fecha.getDate()).padStart(2,'0');
                events.push({
                  id: 'cumple-'+ig.id,
                  name: '🎂', // Solo icono de torta
                  type: 'cumple',
                  start: cumple,
                  end: cumple,
                  desc: 'Cumpleaños de ' + (ig.pastor_sacerdote || 'Líder') + (ig.nombre ? ' ('+ig.nombre+')' : ''),
                  iglesia: ig.nombre,
                  latitud: ig.latitud,
                  longitud: ig.longitud,
                  estado: '',
                  cumple_full: '🎂 Cumpleaños ' + (ig.pastor_sacerdote || 'Líder') + (ig.nombre ? ' ('+ig.nombre+')' : ''),
                });
              }
            });
          }
          render();
        })
        .catch(err => { console.error('Error al obtener iglesias:', err); render(); });
    })
    .catch(err => { console.error('Error al obtener eventos:', err); events = []; render(); });
}

window.addEventListener('DOMContentLoaded', fetchEvents);

function getEventsForDate(ds) {
  return events.filter(e => ds >= e.start && ds <= e.end);
}

function dateStr(y, m, d) {
  return y + '-' + String(m+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
}

function isToday(y, m, d) {
  return today.getFullYear()===y && today.getMonth()===m && today.getDate()===d;
}

function render() {
  if      (currentView === 'month') renderMonth();
  else if (currentView === 'week')  renderWeek();
  else if (currentView === 'day')   renderDay();
  else                              renderList();
  updateTitle();
}

function updateTitle() {
  const y = currentDate.getFullYear(), m = currentDate.getMonth();
  if (currentView === 'month') {
    document.getElementById('monthTitle').textContent = MONTHS_ES[m] + ' de ' + y;
  } else if (currentView === 'week') {
    const ws = getWeekStart(currentDate);
    const we = new Date(ws); we.setDate(we.getDate()+6);
    document.getElementById('monthTitle').textContent = ws.getDate() + ' - ' + we.getDate() + ' ' + MONTHS_ES[we.getMonth()] + ' ' + we.getFullYear();
  } else if (currentView === 'day') {
    document.getElementById('monthTitle').textContent = DAYS_FULL[currentDate.getDay()] + ', ' + currentDate.getDate() + ' ' + MONTHS_ES[currentDate.getMonth()] + ' ' + currentDate.getFullYear();
  } else {
    document.getElementById('monthTitle').textContent = MONTHS_ES[m] + ' de ' + y;
  }
}

function renderMonth() {
  const y = currentDate.getFullYear(), m = currentDate.getMonth();
  const startDow = new Date(y, m, 1).getDay();

  document.getElementById('weekHeaders').innerHTML = DAYS_ES.map(d => '<th>' + d + '</th>').join('');

  let html = '';
  let day = 1 - startDow;

  for (let row = 0; row < 6; row++) {
    const firstDayOfRow = new Date(y, m, 1 - startDow + row * 7);
    if (firstDayOfRow.getMonth() > m && firstDayOfRow.getFullYear() >= y) break;

    let rowHtml = '';
    for (let col = 0; col < 7; col++, day++) {
      const d  = new Date(y, m, day);
      const dy = d.getFullYear(), dm = d.getMonth(), dd = d.getDate();
      const ds = dateStr(dy, dm, dd);

      const evs      = getEventsForDate(ds);
      const isOther  = dm !== m;
      const hasEvts  = evs.length > 0 && !isOther;

      // Clases de la celda
      let cls = '';
      if (isToday(dy, dm, dd)) cls += ' today';
      if (isOther)              cls += ' other-month';
      if (hasEvts)              cls += ' has-events';   // <-- resaltado

      // Chips (max 2, coloreados por tipo)
      let chips = evs.slice(0,2).map(e => {
        const color = TYPE_COLORS[(e.type||'').toLowerCase()] || '#6B7280';
        return '<span class="event-chip" style="background:' + color + '18;color:' + color + ';border-left:2px solid ' + color + ';" title="' + e.name + '">' + e.name + '</span>';
      }).join('');
      if (evs.length > 2) {
        chips += '<span class="event-chip" style="background:#F1F5F9;color:#64748B;">+' + (evs.length-2) + ' mas</span>';
      }

      rowHtml += '<td class="' + cls.trim() + '" onclick="clickDay(\'' + ds + '\')">';
      rowHtml += '<div class="day-num">' + dd + '</div>';
      rowHtml += chips;
      rowHtml += '</td>';
    }
    html += '<tr>' + rowHtml + '</tr>';
  }

  document.getElementById('calBody').innerHTML = html;
}

function getWeekStart(d) {
  const s = new Date(d);
  s.setDate(s.getDate() - s.getDay());
  s.setHours(0,0,0,0);
  return s;
}

function renderWeek() {
  const ws = getWeekStart(currentDate);
  let html = '';
  for (let i=0; i<7; i++) {
    const d = new Date(ws); d.setDate(d.getDate()+i);
    const cls = isToday(d.getFullYear(),d.getMonth(),d.getDate()) ? 'today-header' : '';
    html += '<div class="week-day-header ' + cls + '">' + DAYS_ES[i] + '<br><strong>' + d.getDate() + '</strong></div>';
  }
  for (let i=0; i<7; i++) {
    const d  = new Date(ws); d.setDate(d.getDate()+i);
    const ds = dateStr(d.getFullYear(), d.getMonth(), d.getDate());
    const cls = isToday(d.getFullYear(),d.getMonth(),d.getDate()) ? 'today' : '';
    const evs = getEventsForDate(ds);
    const chips = evs.map(e => {
      const color = TYPE_COLORS[(e.type||'').toLowerCase()] || '#6B7280';
      return '<span class="event-chip" style="background:' + color + '18;color:' + color + ';border-left:2px solid ' + color + ';">' + e.name + '</span>';
    }).join('');
    html += '<div class="week-day-col ' + cls + '"><div class="week-day-num">' + d.getDate() + '</div>' + chips + '</div>';
  }
  document.getElementById('weekGrid').innerHTML = html;
}

function renderDay() {
  const d  = currentDate;
  const ds = dateStr(d.getFullYear(), d.getMonth(), d.getDate());
  const evs = getEventsForDate(ds);

  document.getElementById('dayViewTitle').textContent =
    DAYS_FULL[d.getDay()] + ', ' + d.getDate() + ' de ' + MONTHS_ES[d.getMonth()];

  if (evs.length === 0) {
    document.getElementById('dayEventList').innerHTML =
      '<div class="empty-state"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>No hay eventos para este dia</div>';
    return;
  }

  document.getElementById('dayEventList').innerHTML = evs.map(e => {
    const color     = TYPE_COLORS[(e.type||'').toLowerCase()] || '#6B7280';
    const typeLabel = TYPE_LABELS[(e.type||'').toLowerCase()] || e.type;
    let html = '<div class="day-event-card" style="display:flex;gap:12px;padding:14px;border:1px solid #E2E8F0;border-radius:10px;margin-bottom:10px;border-left:4px solid ' + color + ';">';
    html += '<div style="flex:1;min-width:0;">';
    // Si es cumpleaños, mostrar el texto completo solo en el detalle
    if (e.type === 'cumple') {
      html += '<h4 style="margin:0 0 6px;font-size:.95rem;font-weight:700;color:#1E293B;">' + (e.cumple_full || '🎂 Cumpleaños') + '</h4>';
    } else {
      html += '<h4 style="margin:0 0 6px;font-size:.95rem;font-weight:700;color:#1E293B;">' + e.name + '</h4>';
    }
    html += '<div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:6px;">';
    if (typeLabel) html += '<span style="font-size:.72rem;font-weight:600;padding:2px 10px;border-radius:99px;background:' + color + '18;color:' + color + ';">' + typeLabel + '</span>';
    if (e.estado)  html += '<span style="font-size:.72rem;font-weight:600;padding:2px 10px;border-radius:99px;background:#F0FDF4;color:#16A34A;">' + e.estado + '</span>';
    html += '</div>';
    if (e.iglesia) html += '<p style="margin:3px 0;font-size:.8rem;color:#475569;"><strong>Iglesia:</strong> ' + e.iglesia + '</p>';
    if (e.desc)    html += '<p style="margin:3px 0;font-size:.8rem;color:#475569;"><strong>' + (e.type === 'cumple' ? 'Descripción' : 'Dirección') + ':</strong> ' + e.desc + '</p>';
    html += '<p style="margin:3px 0;font-size:.8rem;color:#94A3B8;">' + e.start + (e.end && e.end !== e.start ? ' &mdash; ' + e.end : '') + '</p>';
    html += '</div>';
    html += '</div>';
    return html;
  }).join('');
}

function renderList() {
  const y = currentDate.getFullYear(), m = currentDate.getMonth();
  const filtered = events
    .filter(e => e.start.startsWith(y + '-' + String(m+1).padStart(2,'0')))
    .sort((a,b) => a.start.localeCompare(b.start));

  if (filtered.length === 0) {
    document.getElementById('listContent').innerHTML =
      '<div class="empty-state"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>No hay eventos para mostrar</div>';
    return;
  }

  const label = MONTHS_ES[m].charAt(0).toUpperCase() + MONTHS_ES[m].slice(1) + ' de ' + y;
  const rows  = filtered.map(e => {
    const dt    = new Date(e.start + 'T12:00:00');
    const color = TYPE_COLORS[(e.type||'').toLowerCase()] || '#6B7280';
    return '<div class="list-event">' +
      '<div class="list-date-box"><div class="list-day">' + dt.getDate() + '</div><div class="list-dow">' + DAYS_ES[dt.getDay()] + '</div></div>' +
      '<div class="list-event-info">' +
        '<h4>' + e.name + '</h4>' +
        (e.iglesia ? '<div style="font-size:.75rem;color:#64748B;">' + e.iglesia + '</div>' : '') +
        '<div class="list-type" style="color:' + color + ';">' + (TYPE_LABELS[(e.type||'').toLowerCase()] || e.type) + '</div>' +
      '</div>' +
    '</div>';
  }).join('');

  document.getElementById('listContent').innerHTML =
    '<div class="list-month-group"><div class="list-month-label">' + label + '</div>' + rows + '</div>';
}

function navigate(dir) {
  if      (currentView === 'month') currentDate.setMonth(currentDate.getMonth() + dir);
  else if (currentView === 'week')  currentDate.setDate(currentDate.getDate() + dir * 7);
  else if (currentView === 'day')   currentDate.setDate(currentDate.getDate() + dir);
  else                              currentDate.setMonth(currentDate.getMonth() + dir);
  render();
}

function goToday() {
  currentDate = new Date(today);
  if (currentView === 'month') currentDate.setDate(1);
  render();
}

function switchView(view, btn) {
  currentView = view;
  document.querySelectorAll('.view-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  ['monthView','weekView','dayView','listView'].forEach(id => {
    const el = document.getElementById(id);
    el.style.display = 'none';
    el.classList.remove('active');
  });
  if (view === 'month') {
    document.getElementById('monthView').style.display = '';
    currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
  } else if (view === 'week') {
    document.getElementById('weekView').style.display = '';
    document.getElementById('weekView').classList.add('active');
    // Al cambiar a semana, mostrar la semana de hoy
    currentDate = new Date(today);
  } else if (view === 'day') {
    document.getElementById('dayView').style.display = '';
    document.getElementById('dayView').classList.add('active');
  } else {
    document.getElementById('listView').style.display = '';
    document.getElementById('listView').classList.add('active');
  }
  render();
}

function clickDay(ds) {
  currentDate = new Date(ds + 'T12:00:00');
  switchView('day', document.querySelectorAll('.view-tab')[2]);
}

function openNewEventModal() {
  document.getElementById('modalTitle').textContent = 'Nuevo Evento';
  document.getElementById('eventName').value = '';
  document.getElementById('eventDesc').value = '';
  document.getElementById('eventModal').classList.add('open');
}

function closeModal() {
  document.getElementById('eventModal').classList.remove('open');
}

function saveEvent() {
  const name = document.getElementById('eventName').value.trim();
  if (!name) return;
  events.push({
    id:    Date.now(),
    name,
    type:  document.getElementById('eventType').value,
    start: document.getElementById('eventStart').value,
    end:   document.getElementById('eventEnd').value,
    desc:  document.getElementById('eventDesc').value.trim(),
  });
  closeModal();
  render();
}

document.getElementById('eventModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});

// Init
document.getElementById('weekView').style.display = 'none';
document.getElementById('dayView').style.display = 'none';
document.getElementById('listView').style.display = 'none';
render();
</script>

@endsection