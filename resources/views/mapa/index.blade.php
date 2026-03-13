@extends('layouts.public')

@section('title', 'Mapa Religioso')

@section('content')

@vite(['resources/css/mapa/index.css'])

{{-- ── BARRA SUPERIOR MÓVIL ── --}}
<div id="mobile-topbar">
    <div class="topbar-search">
        <svg class="w-4 h-4 flex-shrink-0" style="color:rgba(255,255,255,.5)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    {{-- ★ BOTÓN TOGGLE — FUERA del sidebar, siempre clickeable ── --}}
    <button id="sidebar-toggle-btn" onclick="toggleSidebar()" aria-label="Abrir/cerrar directorio" title="Colapsar panel">
        <svg id="toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <div id="drawer-overlay" onclick="cerrarDrawer()"></div>

    {{-- ══ SIDEBAR ══ --}}
    <aside id="panel-lateral" aria-label="Directorio">

        <div class="drawer-handle"><span></span></div>

        {{-- Header con gradiente --}}
        <div class="panel-header">
            <div>
                <div class="panel-header-title" id="panel-title">Directorio Religioso</div>
                <div class="panel-header-sub">Huila – Colombia</div>
            </div>
            {{-- Móvil: X para cerrar drawer (solo visible en móvil) --}}
            <button class="panel-close-btn-mobile" id="panel-close-mobile"
                    onclick="cerrarDrawer()"
                    aria-label="Cerrar panel">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Stats strip --}}
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
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--c-text3)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="buscador" type="text" placeholder="Buscar iglesia..."
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
            <div class="filtros-label">Denominación</div>
            <div class="filtros-chips" id="filtros-denominacion">
                <button class="filtro-btn active" data-value="" onclick="filtrarDenominacion('')">Todas</button>
                @foreach($denominaciones as $denom)
                    <button class="filtro-btn" data-value="{{ $denom }}"
                            onclick="filtrarDenominacion('{{ $denom }}')">{{ $denom }}</button>
                @endforeach
            </div>

            <div class="filtros-label mt-3">Municipio</div>
            <div class="filtros-chips" id="filtros-municipio">
                <button class="filtro-btn active" data-mun="" onclick="filtrarMunicipio('')">Todos</button>
                @foreach(\App\Models\Iglesia::select('municipality')->whereNotNull('municipality')->where('municipality','!=','')->distinct()->orderBy('municipality')->pluck('municipality') as $mun)
                    <button class="filtro-btn" data-mun="{{ $mun }}"
                            onclick="filtrarMunicipio('{{ $mun }}')">{{ $mun }}</button>
                @endforeach
            </div>
        </div>

        <div class="results-bar">
            Resultados <span id="counter">{{ $totalIglesias }}</span>
        </div>

        <div id="items-list">
            <div class="state-center">
                <div style="width:32px;height:32px;border:2.5px solid rgba(0,180,216,.25);
                     border-top-color:var(--c-cyan);border-radius:50%;
                     animation:spin .7s linear infinite;margin-bottom:12px;"></div>
                <p style="font-size:.83rem;color:var(--c-text3);">Cargando...</p>
            </div>
        </div>

    </aside>

    {{-- ══ MAPA ══ --}}
    <div id="map-wrapper">

        {{-- ── PÍLDORA DE MODO (flota sobre el mapa, no sobre el sidebar) ── --}}
        <div id="mode-bar" role="group" aria-label="Modo de visualización del mapa">

          <button class="mode-btn iglesias active" id="btn-mode-iglesias"
                  onclick="setMode('iglesias')" aria-pressed="true">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
              <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Iglesias</span>
          </button>

          <div class="mode-sep"></div>

          <button class="mode-btn eventos" id="btn-mode-eventos"
                  onclick="setMode('eventos')" aria-pressed="false">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Eventos</span>
          </button>

          <div class="mode-sep"></div>

          <button class="mode-btn escenarios" id="btn-mode-escenarios"
                  onclick="setMode('escenarios')" aria-pressed="false">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
              <circle cx="12" cy="12" r="9" stroke-linecap="round"/>
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3c2.4 2.4 3 5.6 3 9s-.6 6.6-3 9M12 3c-2.4 2.4-3 5.6-3 9s.6 6.6 3 9M3 12h18"/>
            </svg>
            <span>Escenarios</span>
          </button>

          <div class="mode-sep"></div>

          <button class="mode-btn fundaciones" id="btn-mode-fundaciones"
                  onclick="setMode('fundaciones')" aria-pressed="false">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            <span>Fundaciones</span>
          </button>

          {{-- spinner y contador eliminados de la píldora --}}
          <div id="mode-spinner" style="display:none"></div>
          <span id="mode-counter" style="display:none">–</span>

        </div>

        {{-- Toast --}}
        <div id="sirn-toast"></div>

        <button class="map-ctrl-recenter" onclick="recentrarMapa()" title="Centrar en Neiva">
            <svg class="w-5 h-5" style="color:var(--c-navy-mid)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
   SIRN — MAPA RELIGIOSO
   Versión rediseñada con paleta azul/cyan corporativa
════════════════════════════════════════════════════════════════ */

const API_BASE     = "{{ url('/api') }}";
const NEIVA_CENTER = [2.9274, -75.2819];
const isMobile     = () => window.innerWidth < 768;

/* ── Paleta corporativa ── */
const COLOR_NEIVA      = '#1E3A8A';
const COLOR_HUILA      = '#0891B2';   // cyan-600 — diferencia clara de Neiva
const COLOR_EVENTO     = '#7c3aed';
const COLOR_ESCENARIO  = '#EF4444';
const COLOR_FUNDACION  = '#059669';   // emerald-600

const COLORES_DENOM_FIJOS = {
    'Católica':             '#1E3A8A',
    'Cristiana Evangélica': '#0891B2',
    'Adventista':           '#7C3AED',
    'Pentecostal':          '#DC2626',
    'Bautista':             '#D97706',
    'Luterana':             '#0E7490',
    'Presbiteriana':        '#BE185D',
};

function colorPorMunicipio(municipality) {
    if (!municipality || municipality.trim().toLowerCase() === 'neiva') return COLOR_NEIVA;
    return COLOR_HUILA;
}

function getDenomColors() {
    try { return JSON.parse(localStorage.getItem('sirn_denom_colors') || '{}'); } catch(e) { return {}; }
}
function setDenomColors(obj) {
    try { localStorage.setItem('sirn_denom_colors', JSON.stringify(obj)); } catch(e) {}
}
function colorDenom(denom) {
    if (COLORES_DENOM_FIJOS[denom]) return COLORES_DENOM_FIJOS[denom];
    let custom = getDenomColors();
    if (custom[denom]) return custom[denom];
    let idx = Object.keys(custom).length;
    const hue = (idx * 53 + 180) % 360;
    const color = `hsl(${hue}, 60%, 42%)`;
    custom[denom] = color;
    setDenomColors(custom);
    return color;
}

/* ── Leaflet map ── */
const map = L.map('map', {
    center: NEIVA_CENTER,
    zoom: isMobile() ? 12 : 13,
    minZoom: 8, maxZoom: 18,
    maxBounds: [[1.40, -76.80], [3.50, -74.30]],
    maxBoundsViscosity: 0.8,
    zoomControl: false,
});
L.control.zoom({ position: 'bottomright' }).addTo(map);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>',
    maxZoom: 19,
}).addTo(map);

function recentrarMapa() {
    map.flyTo(NEIVA_CENTER, isMobile() ? 12 : 13, { duration: 1.2 });
}

const markersLayer = L.markerClusterGroup({
    showCoverageOnHover: false,
    spiderfyOnMaxZoom:   true,
    maxClusterRadius:    60,
    animate:             true,
}).addTo(map);

function clearMarkers() { markersLayer.clearLayers(); }

/* ── Iconos ── */
function crearIconoIglesia(denominacion, municipality) {
    const color = municipality ? colorPorMunicipio(municipality) : colorDenom(denominacion);
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
                    📅</div>`,
        iconSize: [s,s], iconAnchor: [s/2,s/2], popupAnchor: [0,-(s/2+6)],
    });
}
function crearIconoEscenario() {
    const s = isMobile() ? 30 : 34;
    return L.divIcon({
        className: '',
        html: `<div style="width:${s}px;height:${s}px;background:${COLOR_ESCENARIO};
                    border-radius:50%;border:2.5px solid white;
                    box-shadow:0 3px 12px rgba(239,68,68,.45);
                    display:flex;align-items:center;justify-content:center;font-size:${isMobile()?13:15}px;">
                    ⚽</div>`,
        iconSize: [s,s], iconAnchor: [s/2,s/2], popupAnchor: [0,-(s/2+6)],
    });
}
function crearIconoFundacion() {
    const s = isMobile() ? 30 : 34;
    return L.divIcon({
        className: '',
        html: `<div style="width:${s}px;height:${s}px;background:${COLOR_FUNDACION};
                    border-radius:8px;border:2.5px solid white;transform:rotate(45deg);
                    box-shadow:0 3px 12px rgba(5,150,105,.45);
                    display:flex;align-items:center;justify-content:center;font-size:${isMobile()?11:13}px;">
                    <span style="transform:rotate(-45deg);">🤝</span></div>`,
        iconSize: [s,s], iconAnchor: [s/2,s/2], popupAnchor: [0,-(s/2+6)],
    });
}

/* ── Estado global ── */
let modoActual      = 'iglesias';
let todosLosItems   = [];
let filtroActual    = '';
let municipioActual = '';
let busquedaActual  = '';

/* ── Cambio de modo ── */
function setMode(modo) {
    if (modoActual === modo) return;
    modoActual = modo; filtroActual = ''; municipioActual = ''; busquedaActual = '';

    ['buscador','buscador-mobile'].forEach(id => {
        const el = document.getElementById(id); if (el) el.value = '';
    });
    ocultarClearBtns();

    ['iglesias','eventos','escenarios','fundaciones'].forEach(m => {
        document.getElementById(`btn-mode-${m}`)?.classList.toggle('active', m === modo);
    });

    const filtrosSection = document.getElementById('filtros-section');
    if (filtrosSection) filtrosSection.style.display = modo === 'iglesias' ? '' : 'none';

    const titles = { iglesias: 'Directorio Religioso', eventos: 'Eventos', escenarios: 'Escenarios Deportivos', fundaciones: 'Fundaciones' };
    document.getElementById('panel-title').textContent = titles[modo];

    const placeholders = { iglesias: 'Buscar iglesia...', eventos: 'Buscar evento...', escenarios: 'Buscar escenario...', fundaciones: 'Buscar fundación...' };
    ['buscador','buscador-mobile'].forEach(id => {
        const el = document.getElementById(id); if (el) el.placeholder = placeholders[modo];
    });

    document.querySelectorAll('.filtro-btn').forEach(b => {
        b.classList.toggle('active', (b.dataset.value === '' && b.dataset.mun === undefined) || b.dataset.mun === '');
    });

    const spinner = document.getElementById('mode-spinner');
    spinner.className = modo === 'eventos' ? 'eventos-spin visible' : modo === 'escenarios' ? 'escenarios-spin visible' : 'visible';

    if (modo === 'iglesias')        loadIglesias();
    else if (modo === 'escenarios') loadEscenarios();
    else if (modo === 'fundaciones') loadFundaciones();
    else loadEventos();
}

/* ── API calls ── */
async function loadIglesias() {
    mostrarLoading();
    try {
        const params = new URLSearchParams();
        if (filtroActual)    params.append('denominacion', filtroActual);
        if (municipioActual) params.append('municipality', municipioActual);
        const url = `${API_BASE}/iglesias${params.size ? '?' + params : ''}`;
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const ct  = res.headers.get('content-type') || '';
        if (!res.ok || !ct.includes('application/json')) throw new Error(`HTTP ${res.status}`);
        const json = await res.json();
        if (!json.success) throw new Error('API respondió con error');
        todosLosItems = json.data;
        aplicarFiltros();
    } catch(e) { console.error('[loadIglesias]', e); mostrarError(e.message); }
    finally { document.getElementById('mode-spinner').classList.remove('visible'); }
}

async function loadEventos() {
    mostrarLoading();
    try {
        const res  = await fetch(`${API_BASE}/eventos`, { headers: { 'Accept': 'application/json' } });
        const ct   = res.headers.get('content-type') || '';
        if (!res.ok || !ct.includes('application/json')) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        todosLosItems = (Array.isArray(data) ? data : []).map(ev => ({
            id: ev.id, nombre: ev.title, tipo: ev.tipo_evento || '', start: ev.start, end: ev.end,
            latitud:   parseFloat(ev.extendedProps?.latitud  || 0),
            longitud:  parseFloat(ev.extendedProps?.longitud || 0),
            iglesia:   ev.extendedProps?.iglesia          || '',
            direccion: ev.extendedProps?.direccion_evento || '',
            estado:    ev.extendedProps?.estado           || '',
        })).filter(ev => ev.latitud !== 0 && ev.longitud !== 0);
        aplicarFiltros();
    } catch(e) { console.error('[loadEventos]', e); mostrarError(e.message); }
    finally { document.getElementById('mode-spinner').classList.remove('visible'); }
}

async function loadEscenarios() {
    mostrarLoading();
    try {
        const res  = await fetch(`${API_BASE}/escenarios`, { headers: { 'Accept': 'application/json' } });
        const ct   = res.headers.get('content-type') || '';
        if (!res.ok || !ct.includes('application/json')) throw new Error(`HTTP ${res.status}`);
        const json = await res.json();
        if (!json.success) throw new Error('API respondió con error');
        todosLosItems = json.data;
        aplicarFiltros();
    } catch(e) { console.error('[loadEscenarios]', e); mostrarError(e.message); }
    finally { document.getElementById('mode-spinner').classList.remove('visible'); }
}

async function loadFundaciones() {
    mostrarLoading();
    try {
        const res  = await fetch(`${API_BASE}/fundaciones`, { headers: { 'Accept': 'application/json' } });
        const ct   = res.headers.get('content-type') || '';
        if (!res.ok || !ct.includes('application/json')) throw new Error(`HTTP ${res.status}`);
        const json = await res.json();
        if (!json.success) throw new Error('API respondió con error');
        todosLosItems = json.data;
        aplicarFiltros();
    } catch(e) { console.error('[loadFundaciones]', e); mostrarError(e.message); }
    finally { document.getElementById('mode-spinner').classList.remove('visible'); }
}

/* ── Filtros ── */
function aplicarFiltros() {
    const q = busquedaActual.toLowerCase().trim();
    let items = todosLosItems;
    if (q) {
        if (modoActual === 'iglesias') {
            items = items.filter(ig =>
                ig.nombre.toLowerCase().includes(q) ||
                (ig.denominacion||'').toLowerCase().includes(q) ||
                (ig.direccion||'').toLowerCase().includes(q) ||
                (ig.pastor_sacerdote||'').toLowerCase().includes(q) ||
                (ig.municipality||'').toLowerCase().includes(q));
        } else if (modoActual === 'escenarios') {
            items = items.filter(es =>
                es.name.toLowerCase().includes(q) ||
                (es.address||'').toLowerCase().includes(q) ||
                (es.contact||'').toLowerCase().includes(q));
        } else if (modoActual === 'fundaciones') {
            items = items.filter(f =>
                f.name.toLowerCase().includes(q) ||
                (f.representative||'').toLowerCase().includes(q) ||
                (f.address||'').toLowerCase().includes(q) ||
                (f.nit||'').toLowerCase().includes(q));
        } else {
            items = items.filter(ev =>
                ev.nombre.toLowerCase().includes(q) ||
                (ev.iglesia||'').toLowerCase().includes(q) ||
                (ev.direccion||'').toLowerCase().includes(q) ||
                (ev.tipo||'').toLowerCase().includes(q));
        }
    }
    clearMarkers();
    if (items.length === 0) {
        mostrarToast('No hay registros para esta búsqueda');
        renderizarLista([]);
        actualizarContadores(0);
        return;
    }
    if      (modoActual === 'iglesias')    { renderizarMarcadoresIglesias(items);    renderizarListaIglesias(items); }
    else if (modoActual === 'escenarios')  { renderizarMarcadoresEscenarios(items);  renderizarListaEscenarios(items); }
    else if (modoActual === 'fundaciones') { renderizarMarcadoresFundaciones(items); renderizarListaFundaciones(items); }
    else                                   { renderizarMarcadoresEventos(items);     renderizarListaEventos(items); }
    actualizarContadores(items.length);
    actualizarBadgeFlotante(items.length);
}

function filtrarDenominacion(valor) {
    if (modoActual !== 'iglesias') return;
    filtroActual = valor; busquedaActual = '';
    ['buscador','buscador-mobile'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
    ocultarClearBtns();
    document.querySelectorAll('#filtros-denominacion .filtro-btn').forEach(b => b.classList.toggle('active', b.dataset.value === valor));
    document.getElementById('mode-spinner').className = 'visible';
    loadIglesias();
}
function filtrarMunicipio(valor) {
    if (modoActual !== 'iglesias') return;
    municipioActual = valor;
    document.querySelectorAll('#filtros-municipio .filtro-btn').forEach(b => b.classList.toggle('active', b.dataset.mun === valor));
    document.getElementById('mode-spinner').className = 'visible';
    loadIglesias();
}
function buscarElemento(q) {
    busquedaActual = q;
    ['buscador','buscador-mobile'].forEach(id => { const el = document.getElementById(id); if (el && el.value !== q) el.value = q; });
    document.getElementById('btn-clear-search')?.classList.toggle('hidden', !q);
    document.getElementById('btn-clear-mobile')?.classList.toggle('hidden', !q);
    aplicarFiltros();
}
function limpiarBusqueda()       { buscarElemento(''); document.getElementById('buscador')?.focus(); }
function limpiarBusquedaMobile() { buscarElemento(''); document.getElementById('buscador-mobile')?.focus(); }
function ocultarClearBtns() {
    document.getElementById('btn-clear-search')?.classList.add('hidden');
    document.getElementById('btn-clear-mobile')?.classList.add('hidden');
}

/* ── Popup helpers ── */
function popupIglesia(ig) {
    const color    = ig.municipality ? colorPorMunicipio(ig.municipality) : colorDenom(ig.denominacion);
    const ubicacion = [ig.municipality, ig.department || 'Huila'].filter(Boolean).join(', ');
    return `<div style="font-family:'DM Sans',system-ui,sans-serif;padding:2px 0;min-width:220px;">
        ${ig.foto_url ? `<img src="${ig.foto_url}" alt="${ig.nombre}" style="width:100%;height:110px;object-fit:cover;border-radius:10px;margin-bottom:10px;">` : ''}
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
            <div style="width:38px;height:38px;flex-shrink:0;background:${color};border-radius:10px;
                display:flex;align-items:center;justify-content:center;color:white;font-size:17px;
                box-shadow:0 3px 8px ${color}55;">✝</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;margin:0;font-size:14px;line-height:1.3;">${ig.nombre}</h3>
                <span style="display:inline-block;background:#EFF6FF;color:${color};font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:700;margin-top:4px;">${ig.denominacion||''}</span>
                ${ubicacion ? `<span style="display:inline-block;background:#E0F7FA;color:#0891B2;font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:600;margin-top:4px;margin-left:4px;">📍 ${ubicacion}</span>` : ''}
            </div>
        </div>
        <div style="font-size:12px;color:#475569;line-height:1.9;border-top:1px solid #EEF2FF;padding-top:8px;display:flex;flex-direction:column;gap:3px;">
            ${ig.pastor_sacerdote     ? `<div>👤 <b>${ig.pastor_sacerdote}</b></div>` : ''}
            ${ig.telefono             ? `<div>📞 <a href="tel:${ig.telefono}" style="color:#1E3A8A;font-weight:600;">${ig.telefono}</a></div>` : ''}
            ${ig.correo_institucional ? `<div>✉️ <a href="mailto:${ig.correo_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.correo_institucional}</a></div>` : ''}
            ${(ig.schedule_weekdays || ig.schedule_weekends) ? `
            <div style="margin-top:5px;padding:6px 8px;background:#F0FDF4;border-radius:7px;border:1px solid #BBF7D0;">
                <div style="font-size:10px;font-weight:700;color:#166534;margin-bottom:3px;">🕐 Horario de atención</div>
                ${ig.schedule_weekdays ? `<div style="font-size:11px;color:#15803D;"><span style="font-weight:600;">Lun – Vie:</span> ${ig.schedule_weekdays}</div>` : ''}
                ${ig.schedule_weekends ? `<div style="font-size:11px;color:#15803D;"><span style="font-weight:600;">Sáb – Dom:</span> ${ig.schedule_weekends}</div>` : ''}
            </div>` : ''}
            <div>📍 ${ig.direccion||''}</div>
        </div>
    </div>`;
}

function formatFecha(iso) {
    if (!iso) return '';
    const d = new Date(iso);
    return d.toLocaleDateString('es-CO', { day:'2-digit', month:'long', year:'numeric' });
}

function popupEvento(ev) {
    return `<div style="font-family:'DM Sans',system-ui,sans-serif;padding:2px 0;min-width:220px;">
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
            <div style="width:38px;height:38px;flex-shrink:0;background:${COLOR_EVENTO};border-radius:10px;
                display:flex;align-items:center;justify-content:center;font-size:20px;
                box-shadow:0 3px 8px rgba(245,158,11,.4);">📅</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;margin:0;font-size:14px;line-height:1.3;">${ev.nombre}</h3>
                <span style="display:inline-block;background:#FEF3C7;color:#B45309;font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:700;margin-top:4px;">${ev.tipo||'Evento'}</span>
            </div>
        </div>
        <div style="font-size:12px;color:#475569;line-height:1.9;border-top:1px solid #EEF2FF;padding-top:8px;display:flex;flex-direction:column;gap:3px;">
            ${ev.iglesia  ? `<div>🏛️ <b>${ev.iglesia}</b></div>` : ''}
            ${ev.start    ? `<div>📆 ${formatFecha(ev.start)}${ev.end ? ' → ' + formatFecha(ev.end) : ''}</div>` : ''}
            ${ev.direccion? `<div>📍 ${ev.direccion}</div>` : ''}
            ${ev.estado   ? `<div>🔖 ${ev.estado}</div>` : ''}
        </div>
    </div>`;
}

function popupEscenario(es) {
    return `<div style="font-family:'DM Sans',system-ui,sans-serif;padding:2px 0;min-width:220px;">
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
            <div style="width:38px;height:38px;flex-shrink:0;background:${COLOR_ESCENARIO};border-radius:10px;
                display:flex;align-items:center;justify-content:center;font-size:20px;
                box-shadow:0 3px 8px rgba(239,68,68,.4);">⚽</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;margin:0;font-size:14px;line-height:1.3;">${es.name}</h3>
                <span style="display:inline-block;background:#FFF1F2;color:#BE123C;font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:700;margin-top:4px;">Escenario Deportivo</span>
            </div>
        </div>
        <div style="font-size:12px;color:#475569;line-height:1.9;border-top:1px solid #EEF2FF;padding-top:8px;display:flex;flex-direction:column;gap:3px;">
            <div>📍 ${es.address}</div>
            ${es.contact ? `<div>📞 <a href="tel:${es.contact}" style="color:#EF4444;font-weight:600;">${es.contact}</a></div>` : ''}
            <div>⛪ Disponible para iglesias: <b>${es.available_for_churches ? 'Sí' : 'No'}</b></div>
        </div>
    </div>`;
}

function popupFundacion(f) {
    return `<div style="font-family:'DM Sans',system-ui,sans-serif;padding:2px 0;min-width:220px;">
        <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
            <div style="width:38px;height:38px;flex-shrink:0;background:${COLOR_FUNDACION};border-radius:10px;
                display:flex;align-items:center;justify-content:center;font-size:20px;
                box-shadow:0 3px 8px rgba(5,150,105,.4);">🤝</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;margin:0;font-size:14px;line-height:1.3;">${f.name}</h3>
                <span style="display:inline-block;background:#ECFDF5;color:#065f46;font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:700;margin-top:4px;">Fundación</span>
                ${f.nit ? `<span style="display:inline-block;background:#F0FDF4;color:#166534;font-size:10px;
                    padding:2px 8px;border-radius:20px;font-weight:600;margin-top:4px;margin-left:4px;">NIT: ${f.nit}</span>` : ''}
            </div>
        </div>
        <div style="font-size:12px;color:#475569;line-height:1.9;border-top:1px solid #EEF2FF;padding-top:8px;display:flex;flex-direction:column;gap:3px;">
            ${f.representative ? `<div>👤 <b>${f.representative}</b></div>` : ''}
            ${f.phone          ? `<div>📞 <a href="tel:${f.phone}" style="color:${COLOR_FUNDACION};font-weight:600;">${f.phone}</a></div>` : ''}
            ${f.email          ? `<div>✉️ <a href="mailto:${f.email}" style="color:${COLOR_FUNDACION};font-weight:600;">${f.email}</a></div>` : ''}
            ${f.address        ? `<div>📍 ${f.address}</div>` : ''}
        </div>
    </div>`;
}

/* ── Render marcadores ── */
function renderizarMarcadoresIglesias(iglesias) {
    iglesias.forEach(ig => {
        if (!ig.latitud || !ig.longitud) return;
        const m = L.marker([ig.latitud, ig.longitud], { icon: crearIconoIglesia(ig.denominacion, ig.municipality) });
        if (isMobile()) m.on('click', () => mostrarPopupMovilIglesia(ig));
        else m.bindPopup(popupIglesia(ig), { maxWidth: 290, className: 'sirn-popup' });
        m._itemData = ig;
        markersLayer.addLayer(m);
    });
}
function renderizarMarcadoresEventos(eventos) {
    eventos.forEach(ev => {
        if (!ev.latitud || !ev.longitud) return;
        const m = L.marker([ev.latitud, ev.longitud], { icon: crearIconoEvento() });
        if (isMobile()) m.on('click', () => mostrarPopupMovilEvento(ev));
        else m.bindPopup(popupEvento(ev), { maxWidth: 290, className: 'sirn-popup' });
        m._itemData = ev;
        markersLayer.addLayer(m);
    });
}
function renderizarMarcadoresEscenarios(escenarios) {
    escenarios.forEach(es => {
        if (!es.latitude || !es.longitude) return;
        const m = L.marker([es.latitude, es.longitude], { icon: crearIconoEscenario() });
        if (isMobile()) m.on('click', () => mostrarPopupMovilEscenario(es));
        else m.bindPopup(popupEscenario(es), { maxWidth: 290, className: 'sirn-popup' });
        m._itemData = es;
        markersLayer.addLayer(m);
    });
}
function renderizarMarcadoresFundaciones(fundaciones) {
    fundaciones.forEach(f => {
        if (!f.latitude || !f.longitude) return;
        const m = L.marker([f.latitude, f.longitude], { icon: crearIconoFundacion() });
        if (isMobile()) m.on('click', () => mostrarPopupMovilFundacion(f));
        else m.bindPopup(popupFundacion(f), { maxWidth: 290, className: 'sirn-popup' });
        m._itemData = f;
        markersLayer.addLayer(m);
    });
}

/* ── Render listas ── */
function renderizarListaIglesias(iglesias) {
    const c = document.getElementById('items-list');
    if (!iglesias.length) { c.innerHTML = emptyState('iglesias'); return; }
    c.innerHTML = iglesias.map((ig, i) => {
        const color = ig.municipality ? colorPorMunicipio(ig.municipality) : colorDenom(ig.denominacion);
        return `<div class="iglesia-item" style="animation-delay:${i * 0.02}s"
                     onclick="irAlElemento(${ig.latitud},${ig.longitud},'iglesia',${ig.id})">
            <div class="iglesia-avatar" style="background:${color};">✝</div>
            <div class="iglesia-info">
                <div class="iglesia-nombre">${ig.nombre}</div>
                <div class="iglesia-denom" style="color:${color};">${ig.denominacion||''}</div>
                ${ig.municipality ? `<div class="iglesia-dir">🏷️ ${ig.municipality}${ig.department?', '+ig.department:''}</div>` : ''}
                <div class="iglesia-dir">📍 ${ig.direccion||''}</div>
                ${ig.pastor_sacerdote ? `<div class="iglesia-pastor">👤 ${ig.pastor_sacerdote}</div>` : ''}
            </div>
            <svg class="iglesia-arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>`;
    }).join('');
}
function renderizarListaEventos(eventos) {
    const c = document.getElementById('items-list');
    if (!eventos.length) { c.innerHTML = emptyState('eventos'); return; }
    c.innerHTML = eventos.map((ev, i) => `
        <div class="iglesia-item" style="animation-delay:${i*0.02}s"
             onclick="irAlElemento(${ev.latitud},${ev.longitud},'evento',${ev.id})">
            <div class="iglesia-avatar" style="background:${COLOR_EVENTO};font-size:17px;border-radius:10px;">📅</div>
            <div class="iglesia-info">
                <div class="iglesia-nombre">${ev.nombre}</div>
                <div class="iglesia-denom" style="color:#B45309;">${ev.tipo||'Evento'}</div>
                ${ev.iglesia  ? `<div class="iglesia-dir">🏛️ ${ev.iglesia}</div>` : ''}
                ${ev.start    ? `<div class="iglesia-dir">📆 ${formatFecha(ev.start)}</div>` : ''}
                ${ev.direccion? `<div class="iglesia-dir">📍 ${ev.direccion}</div>` : ''}
            </div>
            <svg class="iglesia-arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>`).join('');
}
function renderizarListaEscenarios(escenarios) {
    const c = document.getElementById('items-list');
    if (!escenarios.length) { c.innerHTML = emptyState('escenarios'); return; }
    c.innerHTML = escenarios.map((es, i) => `
        <div class="iglesia-item" style="animation-delay:${i*0.02}s"
             onclick="irAlElemento(${es.latitude},${es.longitude},'escenario',${es.id})">
            <div class="iglesia-avatar" style="background:${COLOR_ESCENARIO};font-size:17px;border-radius:10px;">⚽</div>
            <div class="iglesia-info">
                <div class="iglesia-nombre">${es.name}</div>
                <div class="iglesia-denom" style="color:#BE123C;">Escenario Deportivo</div>
                <div class="iglesia-dir">📍 ${es.address}</div>
                ${es.contact ? `<div class="iglesia-dir">📞 ${es.contact}</div>` : ''}
                <div class="iglesia-dir">⛪ Disponible: ${es.available_for_churches ? 'Sí' : 'No'}</div>
            </div>
            <svg class="iglesia-arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>`).join('');
}
function renderizarListaFundaciones(fundaciones) {
    const c = document.getElementById('items-list');
    if (!fundaciones.length) { c.innerHTML = emptyState('fundaciones'); return; }
    c.innerHTML = fundaciones.map((f, i) => `
        <div class="iglesia-item" style="animation-delay:${i*0.02}s"
             onclick="${f.latitude && f.longitude ? `irAlElemento(${f.latitude},${f.longitude},'fundacion',${f.id})` : ''}">
            <div class="iglesia-avatar" style="background:${COLOR_FUNDACION};font-size:17px;border-radius:10px;">🤝</div>
            <div class="iglesia-info">
                <div class="iglesia-nombre">${f.name}</div>
                <div class="iglesia-denom" style="color:#065f46;">Fundación${f.nit ? ' · ' + f.nit : ''}</div>
                ${f.representative ? `<div class="iglesia-dir">👤 ${f.representative}</div>` : ''}
                ${f.address        ? `<div class="iglesia-dir">📍 ${f.address}</div>` : ''}
                ${f.phone          ? `<div class="iglesia-dir">📞 ${f.phone}</div>` : ''}
            </div>
            <svg class="iglesia-arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>`).join('');
}

/* ── Navegación al elemento ── */
function irAlElemento(lat, lng, tipo, id) {
    map.flyTo([lat, lng], isMobile() ? 16 : 17, { duration: 0.8 });
    setTimeout(() => {
        markersLayer.eachLayer(layer => {
            if (layer._itemData?.id === id) {
                if (isMobile()) {
                    if (tipo === 'iglesia')        mostrarPopupMovilIglesia(layer._itemData);
                    else if (tipo === 'escenario') mostrarPopupMovilEscenario(layer._itemData);
                    else if (tipo === 'fundacion') mostrarPopupMovilFundacion(layer._itemData);
                    else                           mostrarPopupMovilEvento(layer._itemData);
                    cerrarDrawer();
                } else {
                    layer.openPopup();
                }
            }
        });
    }, 900);
}
function irAIglesia(lat, lng, id) { irAlElemento(lat, lng, 'iglesia', id); }

/* ── Popup móvil helpers ── */
function infoRow(icon, label, value) {
    return `<div style="display:flex;align-items:flex-start;gap:10px;padding:9px 12px;background:#F7FAFF;border-radius:10px;">
        <span style="font-size:16px;flex-shrink:0;">${icon}</span>
        <div>
            <div style="font-size:10px;color:#7E94BA;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">${label}</div>
            <div style="font-weight:600;color:#0D2149;font-size:13px;">${value}</div>
        </div>
    </div>`;
}
function infoRowLink(icon, label, html) {
    return `<div style="display:flex;align-items:flex-start;gap:10px;padding:9px 12px;background:#F7FAFF;border-radius:10px;">
        <span style="font-size:16px;flex-shrink:0;">${icon}</span>
        <div>
            <div style="font-size:10px;color:#7E94BA;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">${label}</div>
            ${html}
        </div>
    </div>`;
}

function mapsBtn(lat, lng, color) {
    return `<a href="https://maps.google.com/?q=${lat},${lng}" target="_blank"
       style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;
              padding:13px;background:${color};color:white;border-radius:14px;
              font-size:13px;font-weight:700;text-decoration:none;">
        🗺️ Abrir en Google Maps
    </a>`;
}

/* ── Popup móvil — Iglesia ── */
function mostrarPopupMovilIglesia(ig) {
    const color = ig.municipality ? colorPorMunicipio(ig.municipality) : colorDenom(ig.denominacion);
    document.getElementById('popup-movil-content').innerHTML = `
        ${ig.foto_url ? `<img src="${ig.foto_url}" alt="${ig.nombre}" style="width:100%;height:160px;object-fit:cover;border-radius:14px;margin-bottom:14px;">` : ''}
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:46px;height:46px;flex-shrink:0;background:${color};border-radius:14px;
                display:flex;align-items:center;justify-content:center;color:white;font-size:22px;
                box-shadow:0 4px 12px ${color}44;">✝</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;font-size:16px;margin:0;">${ig.nombre}</h3>
                <span style="display:inline-block;background:#EFF6FF;color:${color};font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:700;margin-top:5px;">${ig.denominacion||''}</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            ${ig.municipality         ? infoRow('🏷️','Municipio', ig.municipality + (ig.department ? ', '+ig.department : '')) : ''}
            ${ig.pastor_sacerdote     ? infoRow('👤','Pastor / Sacerdote', ig.pastor_sacerdote) : ''}
            ${ig.telefono             ? infoRowLink('📞','Teléfono',`<a href="tel:${ig.telefono}" style="color:#1E3A8A;font-weight:600;">${ig.telefono}</a>`) : ''}
            ${ig.celular_institucional? infoRowLink('📱','Celular',`<a href="tel:${ig.celular_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.celular_institucional}</a>`) : ''}
            ${ig.correo_institucional ? infoRowLink('✉️','Correo',`<a href="mailto:${ig.correo_institucional}" style="color:#1E3A8A;font-weight:600;">${ig.correo_institucional}</a>`) : ''}
            ${ig.email                ? infoRowLink('✉️','Correo',`<a href="mailto:${ig.email}" style="color:#1E3A8A;font-weight:600;">${ig.email}</a>`) : ''}
            ${infoRow('📍','Dirección', ig.direccion||'')}
        </div>
        ${mapsBtn(ig.latitud, ig.longitud, color)}`;
    abrirPopupMovil();
}

/* ── Popup móvil — Evento ── */
function mostrarPopupMovilEvento(ev) {
    document.getElementById('popup-movil-content').innerHTML = `
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:46px;height:46px;flex-shrink:0;background:${COLOR_EVENTO};border-radius:14px;
                display:flex;align-items:center;justify-content:center;font-size:24px;
                box-shadow:0 4px 12px rgba(245,158,11,.4);">📅</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;font-size:16px;margin:0;">${ev.nombre}</h3>
                <span style="display:inline-block;background:#FEF3C7;color:#B45309;font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:700;margin-top:5px;">${ev.tipo||'Evento'}</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            ${ev.iglesia   ? infoRow('🏛️','Iglesia', ev.iglesia) : ''}
            ${ev.start     ? infoRow('📆','Fecha', formatFecha(ev.start) + (ev.end ? ' → ' + formatFecha(ev.end) : '')) : ''}
            ${ev.direccion ? infoRow('📍','Dirección', ev.direccion) : ''}
            ${ev.estado    ? infoRow('🔖','Estado', ev.estado) : ''}
        </div>
        ${mapsBtn(ev.latitud, ev.longitud, COLOR_EVENTO)}`;
    abrirPopupMovil();
}

/* ── Popup móvil — Escenario ── */
function mostrarPopupMovilEscenario(es) {
    document.getElementById('popup-movil-content').innerHTML = `
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:46px;height:46px;flex-shrink:0;background:${COLOR_ESCENARIO};border-radius:14px;
                display:flex;align-items:center;justify-content:center;font-size:24px;
                box-shadow:0 4px 12px rgba(239,68,68,.4);">⚽</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;font-size:16px;margin:0;">${es.name}</h3>
                <span style="display:inline-block;background:#FFF1F2;color:#BE123C;font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:700;margin-top:5px;">Escenario Deportivo</span>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            ${infoRow('📍','Dirección', es.address)}
            ${es.contact ? infoRowLink('📞','Contacto',`<a href="tel:${es.contact}" style="color:${COLOR_ESCENARIO};font-weight:600;">${es.contact}</a>`) : ''}
            ${infoRow('⛪','Disponible para iglesias', es.available_for_churches ? 'Sí' : 'No')}
        </div>
        ${mapsBtn(es.latitude, es.longitude, COLOR_ESCENARIO)}`;
    abrirPopupMovil();
}

/* ── Popup móvil — Fundación ── */
function mostrarPopupMovilFundacion(f) {
    document.getElementById('popup-movil-content').innerHTML = `
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:46px;height:46px;flex-shrink:0;background:${COLOR_FUNDACION};border-radius:14px;
                display:flex;align-items:center;justify-content:center;font-size:24px;
                box-shadow:0 4px 12px rgba(5,150,105,.4);">🤝</div>
            <div>
                <h3 style="font-weight:700;color:#0D2149;font-size:16px;margin:0;">${f.name}</h3>
                <span style="display:inline-block;background:#ECFDF5;color:#065f46;font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:700;margin-top:5px;">Fundación</span>
                ${f.nit ? `<span style="display:inline-block;background:#F0FDF4;color:#166534;font-size:11px;
                    padding:3px 10px;border-radius:99px;font-weight:600;margin-top:5px;margin-left:4px;">NIT: ${f.nit}</span>` : ''}
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            ${f.representative ? infoRow('👤','Representante', f.representative) : ''}
            ${f.phone          ? infoRowLink('📞','Teléfono',`<a href="tel:${f.phone}" style="color:${COLOR_FUNDACION};font-weight:600;">${f.phone}</a>`) : ''}
            ${f.email          ? infoRowLink('✉️','Correo',`<a href="mailto:${f.email}" style="color:${COLOR_FUNDACION};font-weight:600;">${f.email}</a>`) : ''}
            ${f.address        ? infoRow('📍','Dirección', f.address) : ''}
        </div>
        ${f.latitude && f.longitude ? mapsBtn(f.latitude, f.longitude, COLOR_FUNDACION) : ''}`;
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

/* ── Drawer ── */
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

(function() {
    const panel = document.getElementById('panel-lateral');
    let sy = 0;
    panel.addEventListener('touchstart', e => { sy = e.touches[0].clientY; }, { passive: true });
    panel.addEventListener('touchend',   e => { if (e.changedTouches[0].clientY - sy > 80) cerrarDrawer(); });
})();

/* ── Contadores y UX ── */
function actualizarContadores(total) {
    document.getElementById('counter').textContent       = total;
    document.getElementById('counter-badge').textContent = total;
    const label = modoActual === 'iglesias'    ? `${total} iglesia${total!==1?'s':''}`
                : modoActual === 'escenarios'  ? `${total} escenario${total!==1?'s':''}`
                : modoActual === 'fundaciones' ? `${total} fundación${total!==1?'es':''}`
                : `${total} evento${total!==1?'s':''}`;
    const counter = document.getElementById('mode-counter');
    counter.textContent = label;
    counter.style.color = total === 0 ? '#EF4444'
        : modoActual === 'eventos'     ? '#FDE68A'
        : modoActual === 'escenarios'  ? '#FCA5A5'
        : modoActual === 'fundaciones' ? '#6ee7b7'
        : 'rgba(255,255,255,.6)';
}

function actualizarBadgeFlotante(total) {
    const badge = document.getElementById('badge-text');
    const pill  = document.getElementById('badge-pill-el');
    const dot   = document.getElementById('badge-dot-el');
    if (!badge) return;
    if (modoActual === 'iglesias') {
        badge.textContent = `${total} iglesia${total!==1?'s':''} en el mapa`;
        pill.className = 'badge-pill';
        dot.style.background = '#00B4D8';
    } else if (modoActual === 'escenarios') {
        badge.textContent = `${total} escenario${total!==1?'s':''} en el mapa`;
        pill.className = 'badge-pill badge-pill-eventos';
        dot.style.background = COLOR_ESCENARIO;
    } else if (modoActual === 'fundaciones') {
        badge.textContent = `${total} fundación${total!==1?'es':''} en el mapa`;
        pill.className = 'badge-pill badge-pill-eventos';
        dot.style.background = COLOR_FUNDACION;
    } else {
        badge.textContent = `${total} evento${total!==1?'s':''} en el mapa`;
        pill.className = 'badge-pill badge-pill-eventos';
        dot.style.background = COLOR_EVENTO;
    }
}

function mostrarLoading() {
    document.getElementById('items-list').innerHTML = `
        <div class="state-center">
            <div style="width:32px;height:32px;border:2.5px solid rgba(0,180,216,.2);
                border-top-color:#00B4D8;border-radius:50%;animation:spin .7s linear infinite;margin-bottom:12px;"></div>
            <p style="font-size:.83rem;color:var(--c-text3);">Cargando...</p>
        </div>
        <style>@keyframes spin{to{transform:rotate(360deg)}}</style>`;
    clearMarkers();
}

function mostrarError(msg) {
    document.getElementById('items-list').innerHTML = `
        <div class="state-center">
            <div class="state-icon" style="background:#FFF1F2;">
                <svg style="width:24px;height:24px;color:#EF4444" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p style="font-size:.85rem;font-weight:600;color:#EF4444;">Error al cargar</p>
            <p style="font-size:.72rem;color:var(--c-text3);margin-top:4px;">${msg}</p>
            <button onclick="modoActual==='iglesias'?loadIglesias():modoActual==='escenarios'?loadEscenarios():modoActual==='fundaciones'?loadFundaciones():loadEventos()"
                    style="margin-top:14px;padding:9px 20px;background:var(--c-navy-mid);color:white;
                           border:none;border-radius:10px;font-size:.75rem;font-weight:700;
                           cursor:pointer;font-family:var(--font);">
                Reintentar
            </button>
        </div>`;
}

function emptyState(tipo) {
    const msg = tipo === 'iglesias'    ? 'No hay iglesias disponibles'
              : tipo === 'escenarios'  ? 'No hay escenarios disponibles'
              : tipo === 'fundaciones' ? 'No hay fundaciones disponibles'
              : 'No hay eventos disponibles';
    return `<div class="state-center">
        <div class="state-icon" style="background:#EFF6FF;">
            <svg style="width:24px;height:24px;color:#93C5FD" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p style="font-size:.85rem;font-weight:600;color:var(--c-text2);">${msg}</p>
        <p style="font-size:.72rem;color:var(--c-text3);margin-top:4px;">Prueba con otro término</p>
    </div>`;
}

function renderizarLista(items) { if (!items.length) return; }

let toastTimer;
function mostrarToast(msg) {
    const t = document.getElementById('sirn-toast');
    t.textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3200);
}

/* ── Resize ── */
window.addEventListener('resize', () => {
    if (todosLosItems.length > 0) aplicarFiltros();
    map.invalidateSize();
});

/* ── Sidebar toggle (desktop) ── */
let sidebarOpen = true;

function toggleSidebar() {
    sidebarOpen = !sidebarOpen;
    const layout  = document.getElementById('sirn-layout');
    const sidebar = document.getElementById('panel-lateral');
    const btn     = document.getElementById('sidebar-toggle-btn');

    layout.classList.toggle('sidebar-collapsed', !sidebarOpen);
    sidebar.classList.toggle('collapsed', !sidebarOpen);

    // Rotar la flecha
    btn.classList.toggle('rotated', !sidebarOpen);
    btn.title = sidebarOpen ? 'Colapsar panel' : 'Abrir panel';

    // Reajustar Leaflet al nuevo tamaño
    setTimeout(() => map.invalidateSize(), 310);
}

/* ── Init ── */
loadIglesias();
</script>
@endpush

@endsection