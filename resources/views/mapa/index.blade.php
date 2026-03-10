@extends('layouts.public')

@section('title', 'Mapa Religioso')

@section('content')

@vite(['resources/css/mapa/index.css'])

{{-- ── BARRA TOGGLE DE MODO (nueva) ── --}}
<div id="mode-bar" role="group" aria-label="Modo de visualización del mapa">

  {{-- Iglesias --}}
  <button class="mode-btn iglesias active" id="btn-mode-iglesias"
          onclick="setMode('iglesias')" aria-pressed="true">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
      <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22"/>
    </svg>
    Iglesias
  </button>

  <div class="mode-sep"></div>

  {{-- Eventos --}}
  <button class="mode-btn eventos" id="btn-mode-eventos"
          onclick="setMode('eventos')" aria-pressed="false">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
      <rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round"/>
      <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
    </svg>
    Eventos
  </button>

  <div class="mode-sep"></div>

  {{-- Spinner + contador --}}
  <div id="mode-spinner"></div>
  <span id="mode-counter">–</span>

</div>

{{-- Toast sin datos --}}
<div id="sirn-toast"></div>

{{-- ── BARRA SUPERIOR MÓVIL ── --}}
<div id="mobile-topbar">
    <div class="topbar-search">
        <svg class="w-4 h-4 flex-shrink-0" style="color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input id="buscador-mobile" type="search" inputmode="search"
               autocomplete="off" autocorrect="off" spellcheck="false"
               placeholder="Buscar..." aria-label="Buscar"
               oninput="buscarElemento(this.value)">
        <button id="btn-clear-mobile" class="topbar-clear hidden"
                onclick="limpiarBusquedaMobile()" aria-label="Limpiar">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <button class="topbar-list-btn" id="btn-drawer" aria-label="Ver lista">
        <svg class="w-5 h-5" style="color:white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>

{{-- ── LAYOUT PRINCIPAL ── --}}
<div id="sirn-layout">

    <div id="drawer-overlay" onclick="cerrarDrawer()"></div>

    {{-- ══ SIDEBAR ══ --}}
    <aside id="panel-lateral" aria-label="Directorio">

        <div class="drawer-handle"><span></span></div>

        <div class="panel-header">
            <div>
                <div class="panel-header-title" id="panel-title">Directorio Religioso</div>
                <div class="panel-header-sub">Neiva, Huila – Colombia</div>
            </div>
            <button class="panel-close-btn" onclick="cerrarDrawer()" aria-label="Cerrar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="stats-strip">
            <div class="stat-item">
                <div class="stat-num">{{ $totalIglesias }}</div>
                <div class="stat-label">Iglesias</div>
            </div>
            <div class="stat-sep"></div>
            <div class="stat-item">
                <div class="stat-num">{{ $denominaciones->count() }}</div>
                <div class="stat-label">Denominaciones</div>
            </div>
            <div class="stat-sep"></div>
            <div class="stat-item">
                <div class="stat-num stat-num--amber" id="counter-badge">{{ $totalIglesias }}</div>
                <div class="stat-label">Visibles</div>
            </div>
        </div>

        {{-- Buscador desktop --}}
        <div class="panel-search">
            <div class="search-inner">
                <svg class="w-4 h-4 flex-shrink-0" style="color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="buscador" type="text" placeholder="Buscar..."
                       oninput="buscarElemento(this.value)">
                <button id="btn-clear-search" class="search-clear hidden" onclick="limpiarBusqueda()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Filtros denominación (solo en modo Iglesias) --}}
        <div class="filtros-wrap" id="filtros-section">
            <div class="filtros-label">Filtrar por denominación</div>
            <div class="filtros-chips" id="filtros-denominacion">
                <button class="filtro-btn active" data-value="" onclick="filtrarDenominacion('')">Todas</button>
                @foreach($denominaciones as $denom)
                    <button class="filtro-btn" data-value="{{ $denom }}"
                            onclick="filtrarDenominacion('{{ $denom }}')">{{ $denom }}</button>
                @endforeach
            </div>
        </div>

        <div class="results-bar">
            Resultados <span id="counter">{{ $totalIglesias }}</span>
        </div>

        <div id="items-list">
            <div class="state-center">
                <div class="w-8 h-8 border-2 border-blue-400 border-t-transparent rounded-full animate-spin mb-3"></div>
                <p class="text-sm text-slate-400">Cargando...</p>
            </div>
        </div>

    </aside>

    {{-- ══ MAPA ══ --}}
    <div id="map-wrapper">

        <button class="map-ctrl-recenter" onclick="recentrarMapa()" title="Centrar en Neiva">
            <svg class="w-5 h-5" style="color:#1E3A8A" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </button>

        <div id="badge-flotante">
            <div class="badge-pill" id="badge-pill-el">
                <span class="badge-dot" id="badge-dot-el"></span>
                <span id="badge-text">Cargando...</span>
            </div>
        </div>

        <button id="btn-ver-lista" onclick="abrirDrawer()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            Ver lista
        </button>

        <div id="map"></div>
    </div>
</div>

{{-- Popup móvil --}}
<div id="popup-overlay" onclick="cerrarPopupMovil()"></div>
<div id="popup-movil" role="dialog" aria-modal="true">
    <div class="popup-movil-inner">
        <div class="drawer-handle" style="margin-bottom:4px;"><span></span></div>
        <div id="popup-movil-content"></div>
    </div>
</div>

@push('scripts')
<script>
/* ════════════════════════════════════════════════════════════════
   SIRN – MAPA CON MODO IGLESIAS / EVENTOS
   Autor: Sistema de Información Religiosa de Neiva
════════════════════════════════════════════════════════════════ */

// ── Constantes ─────────────────────────────────────────────────
const API_BASE     = "{{ url('/api') }}";
const NEIVA_CENTER = [2.9274, -75.2819];
const isMobile     = () => window.innerWidth < 768;

// ── Colores por denominación ────────────────────────────────────
// Colores fijos para denominaciones conocidas
const COLORES_DENOM_FIJOS = {
    'Católica':             '#1E3A8A',
    'Cristiana Evangélica': '#16A34A',
    'Adventista':           '#7C3AED',
    'Pentecostal':          '#DC2626',
    'Bautista':             '#D97706',
    'Luterana':             '#0891B2',
    'Presbiteriana':        '#BE185D',
};
const COLOR_EVENTO = '#F59E0B';

// Utilidad para obtener/guardar colores únicos para nuevas denominaciones
function getDenomColors() {
    let stored = localStorage.getItem('sirn_denom_colors');
    let obj = {};
    try { if (stored) obj = JSON.parse(stored); } catch(e) {}
    return obj;
}
function setDenomColors(obj) {
    localStorage.setItem('sirn_denom_colors', JSON.stringify(obj));
}

function colorDenom(denom) {
    // Si es una denominación conocida, usar color fijo
    if (COLORES_DENOM_FIJOS[denom]) return COLORES_DENOM_FIJOS[denom];

    // Si ya tiene color asignado en localStorage, usarlo
    let customColors = getDenomColors();
    if (customColors[denom]) return customColors[denom];

    // Generar un color único (HSL, repartido por cantidad de denominaciones)
    const allColors = Object.values(COLORES_DENOM_FIJOS).concat(Object.values(customColors));
    let idx = Object.keys(customColors).length;
    let hue = (idx * 47 + 200) % 360; // Espaciado y desplazamiento para variedad
    let color = `hsl(${hue}, 65%, 48%)`;
    // Evitar duplicados
    while (allColors.includes(color)) {
        idx++;
        hue = (idx * 47 + 200) % 360;
        color = `hsl(${hue}, 65%, 48%)`;
    }
    customColors[denom] = color;
    setDenomColors(customColors);
    return color;
}

// ── Mapa Leaflet ───────────────────────────────────────────────
const map = L.map('map', {
    center: NEIVA_CENTER,
    zoom: isMobile() ? 12 : 13,
    minZoom: 10, maxZoom: 18,
    maxBounds: [[2.65, -75.55], [3.20, -75.00]],
    maxBoundsViscosity: 0.8,
    zoomControl: false,
});

L.control.zoom({ position: 'bottomright' }).addTo(map);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> | SER',
    maxZoom: 19,
}).addTo(map);

function recentrarMapa() {
    map.flyTo(NEIVA_CENTER, isMobile() ? 12 : 13, { duration: 1.2 });
}

// ── LayerGroup único — clearMarkers() lo limpia ───────────────
const markersLayer = L.layerGroup().addTo(map);

function clearMarkers() {
    markersLayer.clearLayers();
}

// ════════════════════════════════════════════════════════════════
//  ICONOS
// ════════════════════════════════════════════════════════════════
function crearIconoIglesia(denominacion) {
    const color = colorDenom(denominacion);
    const s = isMobile() ? 28 : 32;
    return L.divIcon({
        className: '',
        html: `<div style="width:${s}px;height:${s}px;background:${color};
                    border-radius:50% 50% 50% 0;transform:rotate(-45deg);
                    border:2.5px solid white;box-shadow:0 3px 10px rgba(0,0,0,.3);
                    display:flex;align-items:center;justify-content:center;">
                    <span style="transform:rotate(45deg);color:white;font-size:${isMobile()?9:11}px;font-weight:900;">✝</span>
               </div>`,
        iconSize: [s,s], iconAnchor: [s/2,s], popupAnchor: [0,-(s+4)],
    });
}

function crearIconoEvento() {
    const s = isMobile() ? 30 : 34;
    return L.divIcon({
        className: '',
        html: `<div style="width:${s}px;height:${s}px;background:${COLOR_EVENTO};
                    border-radius:50%;border:2.5px solid white;
                    box-shadow:0 3px 12px rgba(245,158,11,.45);
                    display:flex;align-items:center;justify-content:center;font-size:${isMobile()?13:15}px;">
                    📅
               </div>`,
        iconSize: [s,s], iconAnchor: [s/2,s/2], popupAnchor: [0,-(s/2+6)],
    });
}

// ════════════════════════════════════════════════════════════════
//  ESTADO GLOBAL
// ════════════════════════════════════════════════════════════════
let modoActual      = 'iglesias';   // 'iglesias' | 'eventos'
let todosLosItems   = [];           // datos cargados del API activo
let filtroActual    = '';           // denominación (solo iglesias)
let busquedaActual  = '';

// ════════════════════════════════════════════════════════════════
//  TOGGLE DE MODO
// ════════════════════════════════════════════════════════════════
function setMode(modo) {
    if (modoActual === modo) return;   // ya está en ese modo

    modoActual     = modo;
    filtroActual   = '';
    busquedaActual = '';

    // Limpiar inputs búsqueda
    ['buscador','buscador-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    ocultarClearBtns();

    // Actualizar estilos de botones
    document.getElementById('btn-mode-iglesias')
            .classList.toggle('active', modo === 'iglesias');
    document.getElementById('btn-mode-eventos')
            .classList.toggle('active', modo === 'eventos');

    // Mostrar/ocultar filtros de denominación
    const filtrosSection = document.getElementById('filtros-section');
    if (filtrosSection) filtrosSection.style.display = modo === 'iglesias' ? '' : 'none';

    // Título del panel
    document.getElementById('panel-title').textContent =
        modo === 'iglesias' ? 'Directorio Religioso' : 'Eventos';

    // Placeholder buscador
    const ph = modo === 'iglesias' ? 'Buscar iglesia...' : 'Buscar evento...';
    ['buscador','buscador-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.placeholder = ph;
    });

    // Restablecer chip "Todas" en filtros
    document.querySelectorAll('.filtro-btn').forEach(b => {
        b.classList.toggle('active', b.dataset.value === '');
    });

    // Spinner badge color
    const spinner = document.getElementById('mode-spinner');
    spinner.className = modo === 'eventos' ? 'eventos-spin visible' : 'visible';

    // Cargar datos del modo
    if (modo === 'iglesias') {
        loadIglesias();
    } else {
        loadEventos();
    }
}

// ════════════════════════════════════════════════════════════════
//  API: loadIglesias()
// ════════════════════════════════════════════════════════════════
async function loadIglesias() {
    mostrarLoading();
    try {
        const params = new URLSearchParams();
        if (filtroActual) params.append('denominacion', filtroActual);

        const url  = `${API_BASE}/iglesias${params.size ? '?' + params : ''}`;
        const res  = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const ct   = res.headers.get('content-type') || '';
        if (!res.ok || !ct.includes('application/json')) throw new Error(`HTTP ${res.status}`);

        const json = await res.json();
        if (!json.success) throw new Error('API respondió con error');

        todosLosItems = json.data;
        aplicarFiltros();

    } catch (e) {
        console.error('[loadIglesias]', e);
        mostrarError(e.message);
    } finally {
        document.getElementById('mode-spinner').classList.remove('visible');
    }
}

// ════════════════════════════════════════════════════════════════
//  API: loadEventos()
// ════════════════════════════════════════════════════════════════
async function loadEventos() {
    mostrarLoading();
    try {
        const res  = await fetch(`${API_BASE}/eventos`, { headers: { 'Accept': 'application/json' } });
        const ct   = res.headers.get('content-type') || '';
        if (!res.ok || !ct.includes('application/json')) throw new Error(`HTTP ${res.status}`);

        const data = await res.json();

        // Normalizar formato para uso interno
        todosLosItems = (Array.isArray(data) ? data : []).map(ev => ({
            id:              ev.id,
            nombre:          ev.title,
            tipo:            ev.tipo_evento || '',
            start:           ev.start,
            end:             ev.end,
            latitud:         parseFloat(ev.extendedProps?.latitud  || 0),
            longitud:        parseFloat(ev.extendedProps?.longitud || 0),
            iglesia:         ev.extendedProps?.iglesia          || '',
            direccion:       ev.extendedProps?.direccion_evento || '',
            estado:          ev.extendedProps?.estado           || '',
        })).filter(ev => ev.latitud !== 0 && ev.longitud !== 0); // solo los que tienen coords

        aplicarFiltros();

    } catch (e) {
        console.error('[loadEventos]', e);
        mostrarError(e.message);
    } finally {
        document.getElementById('mode-spinner').classList.remove('visible');
    }
}

// ════════════════════════════════════════════════════════════════
//  FILTROS + BÚSQUEDA
// ════════════════════════════════════════════════════════════════
function aplicarFiltros() {
    const q = busquedaActual.toLowerCase().trim();

    let items = todosLosItems;

    if (q) {
        if (modoActual === 'iglesias') {
            items = items.filter(ig =>
                ig.nombre.toLowerCase().includes(q) ||
                (ig.denominacion||'').toLowerCase().includes(q) ||
                (ig.direccion||'').toLowerCase().includes(q) ||
                (ig.pastor_sacerdote||'').toLowerCase().includes(q)
            );
        } else {
            items = items.filter(ev =>
                ev.nombre.toLowerCase().includes(q) ||
                (ev.iglesia||'').toLowerCase().includes(q) ||
                (ev.direccion||'').toLowerCase().includes(q) ||
                (ev.tipo||'').toLowerCase().includes(q)
            );
        }
    }

    clearMarkers();

    if (items.length === 0) {
        mostrarToast('No hay registros disponibles para esta búsqueda');
        renderizarLista([]);
        actualizarContadores(0);
        return;
    }

    if (modoActual === 'iglesias') {
        renderizarMarcadoresIglesias(items);
        renderizarListaIglesias(items);
    } else {
        renderizarMarcadoresEventos(items);
        renderizarListaEventos(items);
    }

    actualizarContadores(items.length);
    actualizarBadgeFlotante(items.length);
}

function filtrarDenominacion(valor) {
    if (modoActual !== 'iglesias') return;
    filtroActual   = valor;
    busquedaActual = '';
    ['buscador','buscador-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    ocultarClearBtns();
    document.querySelectorAll('.filtro-btn').forEach(b =>
        b.classList.toggle('active', b.dataset.value === valor));

    const spinner = document.getElementById('mode-spinner');
    spinner.className = 'visible';
    loadIglesias();
}

function buscarElemento(q) {
    busquedaActual = q;
    ['buscador','buscador-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el && el.value !== q) el.value = q;
    });
    document.getElementById('btn-clear-search')?.classList.toggle('hidden', !q);
    document.getElementById('btn-clear-mobile')?.classList.toggle('hidden', !q);
    aplicarFiltros();
}

function limpiarBusqueda() {
    buscarElemento('');
    document.getElementById('buscador')?.focus();
}
function limpiarBusquedaMobile() {
    buscarElemento('');
    document.getElementById('buscador-mobile')?.focus();
}
function ocultarClearBtns() {
    document.getElementById('btn-clear-search')?.classList.add('hidden');
    document.getElementById('btn-clear-mobile')?.classList.add('hidden');
}

// ════════════════════════════════════════════════════════════════
//  RENDER MARCADORES — IGLESIAS
// ════════════════════════════════════════════════════════════════
function renderizarMarcadoresIglesias(iglesias) {
    iglesias.forEach(ig => {
        if (!ig.latitud || !ig.longitud) return;
        const m = L.marker([ig.latitud, ig.longitud], { icon: crearIconoIglesia(ig.denominacion) });
        if (isMobile()) {
            m.on('click', () => mostrarPopupMovilIglesia(ig));
        } else {
            m.bindPopup(popupIglesia(ig), { maxWidth: 290, className: 'sirn-popup' });
        }
        m._itemData = ig;
        m.addTo(markersLayer);
    });
}

function popupIglesia(ig) {
    const color = colorDenom(ig.denominacion);
    return `<div style="font-family:'DM Sans',system-ui,sans-serif;padding:2px 0;min-width:220px;">
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
            <div style="width:38px;height:38px;flex-shrink:0;background:${color};
                border-radius:10px;display:flex;align-items:center;justify-content:center;
                color:white;font-size:17px;box-shadow:0 3px 8px ${color}55;">✝</div>
            <div>
                <h3 style="font-weight:700;color:#1E293B;margin:0;font-size:14px;line-height:1.3;">${ig.nombre}</h3>
                <span style="display:inline-block;background:#EFF6FF;color:${color};font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:700;margin-top:4px;">${ig.denominacion||''}</span>
            </div>
        </div>
        <div style="font-size:12px;color:#475569;line-height:1.9;border-top:1px solid #f1f5f9;padding-top:8px;display:flex;flex-direction:column;gap:3px;">
            ${ig.pastor_sacerdote       ? `<div>👤 <b>${ig.pastor_sacerdote}</b></div>` : ''}
            ${ig.telefono               ? `<div>📞 <a href="tel:${ig.telefono}" style="color:#1E3A8A;font-weight:600;">${ig.telefono}</a></div>` : ''}
            ${ig.celular_institucional  ? `<div>📱 <a href="tel:${ig.celular_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.celular_institucional}</a></div>` : ''}
            ${ig.correo_institucional   ? `<div>✉️ <a href="mailto:${ig.correo_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.correo_institucional}</a></div>` : ''}
            ${ig.email                  ? `<div>✉️ <a href="mailto:${ig.email}" style="color:#1E3A8A;font-weight:600;">${ig.email}</a></div>` : ''}
            <div>📍 ${ig.direccion||''}</div>
        </div>
    </div>`;
}

// ════════════════════════════════════════════════════════════════
//  RENDER MARCADORES — EVENTOS
// ════════════════════════════════════════════════════════════════
function renderizarMarcadoresEventos(eventos) {
    eventos.forEach(ev => {
        if (!ev.latitud || !ev.longitud) return;
        const m = L.marker([ev.latitud, ev.longitud], { icon: crearIconoEvento() });
        if (isMobile()) {
            m.on('click', () => mostrarPopupMovilEvento(ev));
        } else {
            m.bindPopup(popupEvento(ev), { maxWidth: 290, className: 'sirn-popup' });
        }
        m._itemData = ev;
        m.addTo(markersLayer);
    });
}

function formatFecha(iso) {
    if (!iso) return '';
    const d = new Date(iso);
    return d.toLocaleDateString('es-CO', { day:'2-digit', month:'long', year:'numeric' });
}

function popupEvento(ev) {
    return `<div style="font-family:'DM Sans',system-ui,sans-serif;padding:2px 0;min-width:220px;">
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
            <div style="width:38px;height:38px;flex-shrink:0;background:${COLOR_EVENTO};
                border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;
                box-shadow:0 3px 8px rgba(245,158,11,.4);">📅</div>
            <div>
                <h3 style="font-weight:700;color:#1E293B;margin:0;font-size:14px;line-height:1.3;">${ev.nombre}</h3>
                <span style="display:inline-block;background:#FEF3C7;color:#B45309;font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:700;margin-top:4px;">${ev.tipo||'Evento'}</span>
            </div>
        </div>
        <div style="font-size:12px;color:#475569;line-height:1.9;border-top:1px solid #f1f5f9;padding-top:8px;display:flex;flex-direction:column;gap:3px;">
            ${ev.iglesia  ? `<div>🏛️ <b>${ev.iglesia}</b></div>` : ''}
            ${ev.start    ? `<div>📆 ${formatFecha(ev.start)}${ev.end ? ' → ' + formatFecha(ev.end) : ''}</div>` : ''}
            ${ev.direccion? `<div>📍 ${ev.direccion}</div>` : ''}
            ${ev.estado   ? `<div>🔖 ${ev.estado}</div>` : ''}
        </div>
    </div>`;
}

// ════════════════════════════════════════════════════════════════
//  RENDER LISTA — IGLESIAS
// ════════════════════════════════════════════════════════════════
function renderizarListaIglesias(iglesias) {
    const c = document.getElementById('items-list');
    if (!iglesias.length) { c.innerHTML = emptyState('iglesias'); return; }
    c.innerHTML = iglesias.map(ig => `
        <div class="iglesia-item" onclick="irAlElemento(${ig.latitud},${ig.longitud},'iglesia',${ig.id})">
            <div class="iglesia-avatar" style="background:${colorDenom(ig.denominacion)};">✝</div>
            <div class="iglesia-info">
                <div class="iglesia-nombre">${ig.nombre}</div>
                <div class="iglesia-denom" style="color:${colorDenom(ig.denominacion)};">${ig.denominacion||''}</div>
                <div class="iglesia-dir">📍 ${ig.direccion||''}</div>
                ${ig.pastor_sacerdote ? `<div class="iglesia-pastor">👤 ${ig.pastor_sacerdote}</div>` : ''}
            </div>
            <svg class="iglesia-arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>`).join('');
}

// ════════════════════════════════════════════════════════════════
//  RENDER LISTA — EVENTOS
// ════════════════════════════════════════════════════════════════
function renderizarListaEventos(eventos) {
    const c = document.getElementById('items-list');
    if (!eventos.length) { c.innerHTML = emptyState('eventos'); return; }
    c.innerHTML = eventos.map(ev => `
        <div class="iglesia-item" onclick="irAlElemento(${ev.latitud},${ev.longitud},'evento',${ev.id})">
            <div class="iglesia-avatar"
                 style="background:${COLOR_EVENTO};font-size:17px;border-radius:10px;">📅</div>
            <div class="iglesia-info">
                <div class="iglesia-nombre">${ev.nombre}</div>
                <div class="iglesia-denom" style="color:#B45309;">${ev.tipo||'Evento'}</div>
                ${ev.iglesia   ? `<div class="iglesia-dir">🏛️ ${ev.iglesia}</div>`   : ''}
                ${ev.start     ? `<div class="iglesia-dir">📆 ${formatFecha(ev.start)}</div>` : ''}
                ${ev.direccion ? `<div class="iglesia-dir">📍 ${ev.direccion}</div>` : ''}
            </div>
            <svg class="iglesia-arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>`).join('');
}

// ════════════════════════════════════════════════════════════════
//  NAVEGACIÓN AL ELEMENTO
// ════════════════════════════════════════════════════════════════
function irAlElemento(lat, lng, tipo, id) {
    map.flyTo([lat, lng], isMobile() ? 16 : 17, { duration: 0.8 });
    setTimeout(() => {
        markersLayer.eachLayer(layer => {
            if (layer._itemData?.id === id) {
                if (isMobile()) {
                    tipo === 'iglesia'
                        ? mostrarPopupMovilIglesia(layer._itemData)
                        : mostrarPopupMovilEvento(layer._itemData);
                    cerrarDrawer();
                } else {
                    layer.openPopup();
                }
            }
        });
    }, 900);
}

// Alias para compatibilidad hacia atrás
function irAIglesia(lat, lng, id) { irAlElemento(lat, lng, 'iglesia', id); }

// ════════════════════════════════════════════════════════════════
//  POPUP MÓVIL — IGLESIA
// ════════════════════════════════════════════════════════════════
function mostrarPopupMovilIglesia(ig) {
    const color = colorDenom(ig.denominacion);
    document.getElementById('popup-movil-content').innerHTML = `
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:46px;height:46px;flex-shrink:0;background:${color};
                border-radius:14px;display:flex;align-items:center;justify-content:center;
                color:white;font-size:22px;box-shadow:0 4px 12px ${color}44;">✝</div>
            <div>
                <h3 style="font-weight:700;color:#1E3A8A;font-size:16px;margin:0;">${ig.nombre}</h3>
                <span style="display:inline-block;background:#EFF6FF;color:${color};font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:700;margin-top:5px;">${ig.denominacion||''}</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;color:#475569;">
            ${ig.pastor_sacerdote      ? infoRow('👤','Pastor / Sacerdote', ig.pastor_sacerdote) : ''}
            ${ig.telefono              ? infoRowLink('📞','Teléfono',`<a href="tel:${ig.telefono}" style="color:#1E3A8A;font-weight:600;">${ig.telefono}</a>`) : ''}
            ${ig.celular_institucional ? infoRowLink('📱','Celular institucional',`<a href="tel:${ig.celular_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.celular_institucional}</a>`) : ''}
            ${ig.correo_institucional  ? infoRowLink('✉️','Correo institucional',`<a href="mailto:${ig.correo_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.correo_institucional}</a>`) : ''}
            ${ig.email                 ? infoRowLink('✉️','Correo contacto',`<a href="mailto:${ig.email}" style="color:#1E3A8A;font-weight:600;">${ig.email}</a>`) : ''}
            ${infoRow('📍','Dirección', ig.direccion||'')}
        </div>
        <a href="https://maps.google.com/?q=${ig.latitud},${ig.longitud}" target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;
                  padding:13px;background:#1E3A8A;color:white;border-radius:14px;
                  font-size:13px;font-weight:700;text-decoration:none;">
            🗺️ Abrir en Google Maps
        </a>`;
    abrirPopupMovil();
}

// ════════════════════════════════════════════════════════════════
//  POPUP MÓVIL — EVENTO
// ════════════════════════════════════════════════════════════════
function mostrarPopupMovilEvento(ev) {
    document.getElementById('popup-movil-content').innerHTML = `
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:46px;height:46px;flex-shrink:0;background:${COLOR_EVENTO};
                border-radius:14px;display:flex;align-items:center;justify-content:center;
                font-size:24px;box-shadow:0 4px 12px rgba(245,158,11,.4);">📅</div>
            <div>
                <h3 style="font-weight:700;color:#1E293B;font-size:16px;margin:0;">${ev.nombre}</h3>
                <span style="display:inline-block;background:#FEF3C7;color:#B45309;font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:700;margin-top:5px;">${ev.tipo||'Evento'}</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;font-size:13px;color:#475569;">
            ${ev.iglesia   ? infoRow('🏛️','Iglesia', ev.iglesia) : ''}
            ${ev.start     ? infoRow('📆','Fecha', formatFecha(ev.start) + (ev.end ? ' → ' + formatFecha(ev.end) : '')) : ''}
            ${ev.direccion ? infoRow('📍','Dirección evento', ev.direccion) : ''}
            ${ev.estado    ? infoRow('🔖','Estado', ev.estado) : ''}
        </div>
        <a href="https://maps.google.com/?q=${ev.latitud},${ev.longitud}" target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;
                  padding:13px;background:${COLOR_EVENTO};color:white;border-radius:14px;
                  font-size:13px;font-weight:700;text-decoration:none;">
            🗺️ Abrir en Google Maps
        </a>`;
    abrirPopupMovil();
}

function abrirPopupMovil() {
    document.getElementById('popup-movil').classList.add('open');
    document.getElementById('popup-overlay').classList.add('visible');
}
function cerrarPopupMovil() {
    document.getElementById('popup-movil').classList.remove('open');
    document.getElementById('popup-overlay').classList.remove('visible');
}

// ════════════════════════════════════════════════════════════════
//  HELPERS POPUP MÓVIL
// ════════════════════════════════════════════════════════════════
function infoRow(icon, label, value) {
    return `<div style="display:flex;align-items:flex-start;gap:10px;padding:9px 12px;background:#f8fafc;border-radius:10px;">
        <span style="font-size:18px;flex-shrink:0;">${icon}</span>
        <div>
            <div style="font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">${label}</div>
            <div style="font-weight:600;color:#334155;">${value}</div>
        </div>
    </div>`;
}
function infoRowLink(icon, label, html) {
    return `<div style="display:flex;align-items:flex-start;gap:10px;padding:9px 12px;background:#f8fafc;border-radius:10px;">
        <span style="font-size:18px;flex-shrink:0;">${icon}</span>
        <div>
            <div style="font-size:10px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">${label}</div>
            ${html}
        </div>
    </div>`;
}

// ════════════════════════════════════════════════════════════════
//  DRAWER MÓVIL
// ════════════════════════════════════════════════════════════════
function abrirDrawer() {
    document.getElementById('panel-lateral').classList.add('drawer-open');
    document.getElementById('drawer-overlay').classList.add('visible');
    document.body.style.overflow = 'hidden';
}
function cerrarDrawer() {
    document.getElementById('panel-lateral').classList.remove('drawer-open');
    document.getElementById('drawer-overlay').classList.remove('visible');
    document.body.style.overflow = '';
}
document.getElementById('btn-drawer')?.addEventListener('click', abrirDrawer);

// Swipe to close
(function() {
    const panel = document.getElementById('panel-lateral');
    let sy = 0;
    panel.addEventListener('touchstart', e => { sy = e.touches[0].clientY; }, { passive: true });
    panel.addEventListener('touchend',   e => { if (e.changedTouches[0].clientY - sy > 80) cerrarDrawer(); });
})();

// ════════════════════════════════════════════════════════════════
//  CONTADORES Y UX
// ════════════════════════════════════════════════════════════════
function actualizarContadores(total) {
    document.getElementById('counter').textContent        = total;
    document.getElementById('counter-badge').textContent  = total;
    const label = modoActual === 'iglesias'
        ? `${total} iglesia${total !== 1 ? 's' : ''}`
        : `${total} evento${total !== 1 ? 's' : ''}`;
    document.getElementById('mode-counter').textContent   = label;
    document.getElementById('mode-counter').style.color   =
        total === 0 ? '#EF4444' : (modoActual === 'eventos' ? '#B45309' : '#1E3A8A');
}

function actualizarBadgeFlotante(total) {
    const badge = document.getElementById('badge-text');
    const pill  = document.getElementById('badge-pill-el');
    const dot   = document.getElementById('badge-dot-el');
    if (!badge) return;
    if (modoActual === 'iglesias') {
        badge.textContent = `${total} iglesia${total!==1?'s':''} en el mapa`;
        pill.className = 'badge-pill';
        dot.className  = 'badge-dot';
    } else {
        badge.textContent = `${total} evento${total!==1?'s':''} en el mapa`;
        pill.className = 'badge-pill badge-pill-eventos';
        dot.style.background = COLOR_EVENTO;
    }
}

function mostrarLoading() {
    document.getElementById('items-list').innerHTML = `
        <div class="state-center">
            <div style="width:32px;height:32px;border:2px solid #93c5fd;border-top-color:transparent;
                border-radius:50%;animation:spin .7s linear infinite;margin-bottom:12px;"></div>
            <p style="font-size:.83rem;color:#94a3b8;">Cargando...</p>
        </div>
        <style>@keyframes spin{to{transform:rotate(360deg)}}</style>`;
    clearMarkers();
}

function mostrarError(msg) {
    document.getElementById('items-list').innerHTML = `
        <div class="state-center">
            <div class="state-icon" style="background:#fef2f2;">
                <svg class="w-6 h-6" style="color:#f87171" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p style="font-size:.85rem;font-weight:600;color:#ef4444;">Error al cargar</p>
            <p style="font-size:.72rem;color:#94a3b8;margin-top:4px;">${msg}</p>
            <button onclick="modoActual==='iglesias'?loadIglesias():loadEventos()"
                    style="margin-top:14px;padding:9px 20px;background:#1E3A8A;color:white;
                           border:none;border-radius:10px;font-size:.75rem;font-weight:700;
                           cursor:pointer;font-family:inherit;">
                Reintentar
            </button>
        </div>`;
}

function emptyState(tipo) {
    const msg = tipo === 'iglesias' ? 'No hay iglesias disponibles' : 'No hay eventos disponibles';
    return `<div class="state-center">
        <div class="state-icon" style="background:#f1f5f9;">
            <svg class="w-6 h-6" style="color:#cbd5e1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p style="font-size:.85rem;font-weight:600;color:#64748b;">${msg}</p>
        <p style="font-size:.72rem;color:#94a3b8;margin-top:4px;">Prueba con otro término</p>
    </div>`;
}

let toastTimer;
function mostrarToast(msg) {
    const t = document.getElementById('sirn-toast');
    t.textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3200);
}

// ════════════════════════════════════════════════════════════════
//  RESIZE
// ════════════════════════════════════════════════════════════════
window.addEventListener('resize', () => {
    if (todosLosItems.length > 0) aplicarFiltros();
    map.invalidateSize();
});

// ════════════════════════════════════════════════════════════════
//  INIT — arranca en modo Iglesias
// ════════════════════════════════════════════════════════════════
loadIglesias();
</script>
@endpush

@endsection