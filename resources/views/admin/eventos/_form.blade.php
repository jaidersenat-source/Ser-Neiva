{{-- ═══════════════════════════════════════════════════════════
     _form.blade.php  – Parcial compartido por create y edit de Eventos
     Variables esperadas:
         $evento       → instancia de Evento (nueva o existente)
         $iglesias     → Collection<Iglesia> (todas disponibles para el select)
═══════════════════════════════════════════════════════════ --}}
@php
    $editing = isset($evento) && $evento;
@endphp
@vite(['resources/css/admin/event/evento.form.css'])

{{-- ═══════════════════════════════════
     SECCIÓN 1 – Información básica
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">1</div>
        <div>
            <p class="section-title">Información básica</p>
            <p class="section-sub">Título, iglesia asociada y tipo de evento</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="field-group">
            <label class="field-label" for="iglesia_id">Iglesia organizadora <span class="field-required">*</span></label>
            <select id="iglesia_id" name="iglesia_id" required
                    class="field-input {{ $errors->has('iglesia_id') ? 'error' : '' }}">
                <option value="">Seleccione una iglesia...</option>
                @foreach($iglesias as $iglesia)
                    <option value="{{ $iglesia->id }}"
                            data-lat="{{ $iglesia->latitud ?? '' }}"
                            data-lng="{{ $iglesia->longitud ?? '' }}"
                            data-address="{{ addslashes($iglesia->address ?? '') }}"
                            {{ old('iglesia_id', $evento->iglesia_id ?? '') == $iglesia->id ? 'selected' : '' }}>
                        {{ $iglesia->official_name }}
                    </option>
                @endforeach
            </select>
            @error('iglesia_id')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="titulo">Título del evento <span class="field-required">*</span></label>
                <input type="text" id="titulo" name="titulo"
                       value="{{ old('titulo', $evento->titulo ?? '') }}"
                       class="field-input {{ $errors->has('titulo') ? 'error' : '' }}"
                       placeholder="Ej: Retiro Juvenil 'Levántate y Brilla' 2025" maxlength="200" autocomplete="off">
                @error('titulo')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="tipo_evento">Tipo de evento <span class="field-required">*</span></label>
                <input type="text" id="tipo_evento" name="tipo_evento"
                       value="{{ old('tipo_evento', $evento->tipo_evento ?? '') }}"
                       class="field-input {{ $errors->has('tipo_evento') ? 'error' : '' }}"
                       placeholder="Ej: Retiro, Conferencia, Culto especial" maxlength="100">
                @error('tipo_evento')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="field-group">
            <label class="field-label" for="estado">
                Estado <span class="field-required">*</span>
                <span id="estado-preview"
                      class="estado-preview {{ old('estado', $evento->estado ?? 'activo') === 'activo' ? 'activo' : 'inactivo' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ old('estado', $evento->estado ?? 'activo') === 'activo' ? 'bg-green-500' : 'bg-red-400' }}" id="estado-dot"></span>
                    <span id="estado-label">{{ old('estado', $evento->estado ?? 'activo') === 'activo' ? 'Visible' : 'Oculta' }}</span>
                </span>
            </label>
            <select id="estado" name="estado" class="field-input" onchange="actualizarEstadoPreview(this.value)">
                <option value="activo"   {{ old('estado', $evento->estado ?? 'activo') === 'activo'   ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado', $evento->estado ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 2 – Fechas y Ubicación
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">2</div>
        <div>
            <p class="section-title">Fechas y Ubicación</p>
            <p class="section-sub">Cuándo y dónde se realizará el evento</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="fecha_inicio">Fecha y hora de inicio <span class="field-required">*</span></label>
                <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required
                       value="{{ old('fecha_inicio', $editing ? ($evento->fecha_inicio instanceof \DateTimeInterface ? $evento->fecha_inicio->format('Y-m-d\TH:i') : $evento->fecha_inicio) : '') }}"
                       class="field-input {{ $errors->has('fecha_inicio') ? 'error' : '' }}">
                @error('fecha_inicio')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="fecha_fin">Fecha y hora de fin</label>
                <input type="datetime-local" id="fecha_fin" name="fecha_fin"
                       value="{{ old('fecha_fin', $editing && $evento->fecha_fin ? ($evento->fecha_fin instanceof \DateTimeInterface ? $evento->fecha_fin->format('Y-m-d\TH:i') : $evento->fecha_fin) : '') }}"
                       class="field-input {{ $errors->has('fecha_fin') ? 'error' : '' }}">
                @error('fecha_fin')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ─── Dirección con geocodificación automática ─── --}}
        <div class="field-group">
            <label class="field-label" for="direccion_evento">
                Dirección del evento <span class="field-required">*</span>
            </label>

            {{-- Wrapper relativo para el icono de estado --}}
            <div style="position:relative;">
                <input type="text" id="direccion_evento" name="direccion_evento" required
                       value="{{ old('direccion_evento', $evento->direccion_evento ?? '') }}"
                       class="field-input {{ $errors->has('direccion_evento') ? 'error' : '' }}"
                       placeholder="Ej: Calle 10 # 5-23, Barrio Las Palmas, Neiva"
                       maxlength="255" autocomplete="off">

                {{-- Icono estado (spinner / ok / error) --}}
                <span id="geo-status-icon-evento"
                      style="position:absolute;right:10px;top:50%;transform:translateY(-50%);display:none;pointer-events:none;">
                </span>
            </div>

            {{-- Mensaje de estado --}}
            <p id="geo-status-msg-evento" style="margin-top:4px;font-size:.75rem;display:none;"></p>

            @error('direccion_evento')
                <p class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 3 – Descripción
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">3</div>
        <div>
            <p class="section-title">Descripción y detalles</p>
            <p class="section-sub">Información adicional del evento</p>
        </div>
    </div>
    <div class="form-section-body">
        <div class="field-group">
            <label class="field-label" for="descripcion">Descripción completa</label>
            <textarea id="descripcion" name="descripcion" class="field-input"
                      placeholder="Detalles del evento, horario, público objetivo, requisitos, notas importantes..."
                      rows="5" maxlength="2000">{{ old('descripcion', $evento->descripcion ?? '') }}</textarea>
            @error('descripcion')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 4 – Geolocalización
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">4</div>
        <div>
            <p class="section-title">Geolocalización</p>
            <p class="section-sub">Ubica el lugar del evento en el mapa</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="map-tip">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>
                <strong>Escribe la dirección arriba</strong> para geocodificar automáticamente,
                o <strong>haz clic en el mapa</strong> / arrastra el marcador.
                Los campos Latitud y Longitud se actualizarán en tiempo real.
            </span>
        </div>

        {{-- Campos lat / lng --}}
        <div class="coords-grid">
            <div class="field-group" style="margin-bottom:0;">
                <label class="field-label" for="latitud">
                    Latitud <span class="field-required">*</span>
                </label>
                <input type="number" id="latitud" name="latitud"
                       step="0.00000001" min="-90" max="90" required
                       value="{{ old('latitud', $evento->latitud ?? '2.9274') }}"
                       class="field-input {{ $errors->has('latitud') ? 'error' : '' }}"
                       placeholder="Ej: 2.92740000"
                       oninput="sincronizarCoords()">
                @error('latitud')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>

            <div class="field-group" style="margin-bottom:0;">
                <label class="field-label" for="longitud">
                    Longitud <span class="field-required">*</span>
                </label>
                <input type="number" id="longitud" name="longitud"
                       step="0.00000001" min="-180" max="180" required
                       value="{{ old('longitud', $evento->longitud ?? '-75.2819') }}"
                       class="field-input {{ $errors->has('longitud') ? 'error' : '' }}"
                       placeholder="Ej: -75.28190000"
                       oninput="sincronizarCoords()">
                @error('longitud')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

        <div id="map-selector" aria-label="Mapa selector de ubicación del evento"></div>

        <div class="flex items-center justify-between mt-3 flex-wrap gap-2">
            <p class="field-hint" style="margin:0;">Zona permitida: municipio de Neiva, Huila</p>
            <button type="button" onclick="centrarEnNeiva()"
                    class="flex items-center gap-2 text-xs font-semibold text-[#1E3A8A] bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                📍 Centrar en Neiva
            </button>
        </div>

    </div>
</div>

@push('scripts')
<style>
@keyframes geo-spin { to { transform: rotate(360deg); } }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
/**
 * ════════════════════════════════════════════════════════════════
 *  MAPA + GEOCODIFICACIÓN – Formulario de Eventos
 *
 *  Flujos disponibles:
 *    1. Usuario escribe dirección  → geocoding → actualiza lat/lng + mueve mapa
 *    2. Usuario edita lat o lng    → mueve marcador + mueve mapa (sincronizarCoords)
 *    3. Usuario arrastra marcador  → actualiza lat/lng + reverse geocoding → actualiza dirección
 *    4. Usuario hace clic en mapa  → actualiza lat/lng + reverse geocoding → actualiza dirección
 * ════════════════════════════════════════════════════════════════
 */
(function () {

    /* ── Constantes ──────────────────────────────────────────── */
    const NEIVA       = [2.9274, -75.2819];
    const NOMINATIM   = 'https://nominatim.openstreetmap.org';
    const DEBOUNCE_MS = 600;

    /* ── Referencias DOM ─────────────────────────────────────── */
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    const dirInput = document.getElementById('direccion_evento');
    const geoIcon  = document.getElementById('geo-status-icon-evento');
    const geoMsg   = document.getElementById('geo-status-msg-evento');

    /* ── Estado inicial ──────────────────────────────────────── */
    const initLat = parseFloat(latInput.value) || NEIVA[0];
    const initLng = parseFloat(lngInput.value) || NEIVA[1];

    /* ════════════════════════════════════════════════════════════
       MAPA LEAFLET
    ════════════════════════════════════════════════════════════ */
    const map = L.map('map-selector', {
        center            : [initLat, initLng],
        zoom              : 15,
        minZoom           : 10,
        maxZoom           : 19,
        maxBounds         : [[2.65, -75.55], [3.20, -75.00]],
        maxBoundsViscosity: 0.85,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom    : 19,
    }).addTo(map);

    /* ── Ícono personalizado para eventos ────────────────────── */
    const icono = L.divIcon({
        className: '',
        html: `<div style="
                    width:36px;height:36px;
                    background:#8B5CF6;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    border:3px solid white;
                    box-shadow:0 3px 14px rgba(139,92,246,.5);
                    display:flex;align-items:center;justify-content:center;">
                    <span style="transform:rotate(45deg);font-size:15px;">📅</span>
               </div>`,
        iconSize    : [36, 36],
        iconAnchor  : [18, 36],
        popupAnchor : [0, -40],
    });

    const marker = L.marker([initLat, initLng], { draggable: true, icon: icono }).addTo(map);
    marker.bindPopup(
        '<span style="font-size:12px;font-weight:600;color:#6D28D9;">📍 Ubica aquí el evento</span>'
    ).openPopup();

    /* ════════════════════════════════════════════════════════════
       HELPERS — actualizar inputs y mover el mapa
    ════════════════════════════════════════════════════════════ */

    /**
     * Aplica coordenadas a los inputs, mueve el marcador y centra el mapa.
     * @param {number} lat
     * @param {number} lng
     * @param {number} [zoom]  — si se omite, conserva el zoom actual
     */
    function aplicarCoordenadas(lat, lng, zoom) {
        latInput.value = lat.toFixed(8);
        lngInput.value = lng.toFixed(8);
        latInput.classList.remove('error');
        lngInput.classList.remove('error');
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], zoom || map.getZoom(), { animate: true });
        marker.openPopup();
    }

    /* ════════════════════════════════════════════════════════════
       FEEDBACK VISUAL (icono + mensaje bajo el campo dirección)
    ════════════════════════════════════════════════════════════ */
    function geoSetBuscando() {
        geoIcon.style.display = 'inline';
        geoIcon.innerHTML = `<svg style="width:16px;height:16px;
                                animation:geo-spin .8s linear infinite;color:#3B82F6"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83
                                         M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                             </svg>`;
        geoMsg.style.display = 'block';
        geoMsg.style.color   = '#3B82F6';
        geoMsg.textContent   = 'Buscando ubicación...';
    }

    function geoSetOk(nombre) {
        geoIcon.style.display = 'inline';
        geoIcon.innerHTML = `<svg style="width:16px;height:16px;color:#16A34A"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"/>
                             </svg>`;
        geoMsg.style.display = 'block';
        geoMsg.style.color   = '#16A34A';
        geoMsg.textContent   = '✓ ' + nombre;
    }

    function geoSetError(msg) {
        geoIcon.style.display = 'inline';
        geoIcon.innerHTML = `<svg style="width:16px;height:16px;color:#DC2626"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                             </svg>`;
        geoMsg.style.display = 'block';
        geoMsg.style.color   = '#DC2626';
        geoMsg.textContent   = msg;
    }

    function geoSetIdle() {
        geoIcon.style.display = 'none';
        geoMsg.style.display  = 'none';
    }

    /* ════════════════════════════════════════════════════════════
       DEBOUNCE
    ════════════════════════════════════════════════════════════ */
    function debounce(fn, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    /* ════════════════════════════════════════════════════════════
       FORWARD GEOCODING  — dirección → lat / lng
    ════════════════════════════════════════════════════════════ */
    async function geocodificarDireccion(query) {
        if (!query || query.trim().length < 5) { geoSetIdle(); return; }

        geoSetBuscando();

        const url = new URL(NOMINATIM + '/search');
        url.searchParams.set('q',               query.trim() + ', Neiva, Huila, Colombia');
        url.searchParams.set('format',          'json');
        url.searchParams.set('limit',           '1');
        url.searchParams.set('countrycodes',    'co');
        url.searchParams.set('addressdetails',  '1');
        url.searchParams.set('accept-language', 'es');

        try {
            const res  = await fetch(url.toString(), { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Error de red ' + res.status);

            const data = await res.json();

            if (!data || data.length === 0) {
                geoSetError('No se encontró la dirección. Intenta con más detalles.');
                return;
            }

            const lugar = data[0];
            const lat   = parseFloat(lugar.lat);
            const lng   = parseFloat(lugar.lon);

            /* ✅ Actualiza inputs lat/lng Y mueve el mapa */
            aplicarCoordenadas(lat, lng, 17);

            const nombre = lugar.display_name
                ? lugar.display_name.split(',').slice(0, 3).join(',')
                : 'Ubicación encontrada';
            geoSetOk(nombre);

        } catch (err) {
            console.error('[Geocoding]', err);
            geoSetError('Error al buscar la dirección. Intenta de nuevo.');
        }
    }

    /* ════════════════════════════════════════════════════════════
       REVERSE GEOCODING  — lat / lng → dirección
    ════════════════════════════════════════════════════════════ */
    async function reverseGeocodificar(lat, lng) {
        const url = new URL(NOMINATIM + '/reverse');
        url.searchParams.set('lat',             lat.toFixed(8));
        url.searchParams.set('lon',             lng.toFixed(8));
        url.searchParams.set('format',          'json');
        url.searchParams.set('accept-language', 'es');

        try {
            const res  = await fetch(url.toString(), { headers: { 'Accept': 'application/json' } });
            const data = await res.json();

            if (data && data.address) {
                const a     = data.address;
                const texto = [
                    a.road || a.pedestrian || a.path || '',
                    a.house_number || '',
                    a.suburb || a.neighbourhood || a.quarter || '',
                ].filter(Boolean).join(', ');

                if (texto) {
                    /* Desconecta el listener para no disparar forward geocoding en bucle */
                    dirInput.removeEventListener('input', debouncedGeocodificar);
                    dirInput.value = texto;
                    dirInput.addEventListener('input', debouncedGeocodificar);
                    geoSetOk('Dirección actualizada desde el mapa');
                }
            }
        } catch (err) {
            console.warn('[Reverse Geocoding]', err);
        }
    }

    /* ════════════════════════════════════════════════════════════
       EVENTOS DEL MAPA
    ════════════════════════════════════════════════════════════ */

    /* Drag del marcador */
    marker.on('dragend', function (e) {
        const { lat, lng } = e.target.getLatLng();
        aplicarCoordenadas(lat, lng);   /* ✅ actualiza inputs y mapa */
        reverseGeocodificar(lat, lng);
    });

    /* Clic en el mapa */
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        aplicarCoordenadas(lat, lng);   /* ✅ actualiza inputs y mapa */
        reverseGeocodificar(lat, lng);
    });

    /* ════════════════════════════════════════════════════════════
       EVENTOS DEL CAMPO DIRECCIÓN
    ════════════════════════════════════════════════════════════ */
    const debouncedGeocodificar = debounce(function () {
        geocodificarDireccion(dirInput.value);
    }, DEBOUNCE_MS);

    dirInput.addEventListener('input', debouncedGeocodificar);

    /* Al salir del campo, fuerza la búsqueda si aún no se hizo */
    dirInput.addEventListener('blur', function () {
        if (this.value.trim().length >= 5) geocodificarDireccion(this.value);
    });

    /* ════════════════════════════════════════════════════════════
       FUNCIÓN PÚBLICA — edición manual de lat/lng en los inputs
       Se llama desde oninput="sincronizarCoords()" en el HTML
    ════════════════════════════════════════════════════════════ */
    window.sincronizarCoords = function () {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)
            && lat >= -90 && lat <= 90
            && lng >= -180 && lng <= 180) {
            /* ✅ mueve el marcador Y centra el mapa */
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], map.getZoom(), { animate: true });
            marker.openPopup();
        }
    };

    /* ════════════════════════════════════════════════════════════
       CENTRAR EN NEIVA
    ════════════════════════════════════════════════════════════ */
    window.centrarEnNeiva = function () {
        map.flyTo(NEIVA, 14, { duration: 1 });
    };

    /* ════════════════════════════════════════════════════════════
       IGLESIA SELECCIONADA → centrar mapa en su ubicación
    ════════════════════════════════════════════════════════════ */
    const iglesiaSelect = document.getElementById('iglesia_id');
    if (iglesiaSelect) {
        iglesiaSelect.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            const lat = parseFloat(opt.dataset.lat);
            const lng = parseFloat(opt.dataset.lng);
            const addr = opt.dataset.address || '';

            if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                map.flyTo([lat, lng], 16, { duration: 1.2 });
                marker.setLatLng([lat, lng]).openPopup();
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);
                latInput.classList.remove('error');
                lngInput.classList.remove('error');

                // Rellenar dirección del evento si está vacío
                if (addr && !dirInput.value.trim()) {
                    dirInput.removeEventListener('input', debouncedGeocodificar);
                    dirInput.value = addr;
                    dirInput.addEventListener('input', debouncedGeocodificar);
                }

                geoSetOk('Ubicación de la iglesia seleccionada');
            }
        });

        // Al cargar, si ya hay una iglesia seleccionada (modo edición) centrar el mapa
        if (iglesiaSelect.value) {
            const opt = iglesiaSelect.options[iglesiaSelect.selectedIndex];
            const lat = parseFloat(opt.dataset.lat);
            const lng = parseFloat(opt.dataset.lng);
            if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                // Solo centrar si no hay coords propias del evento ya guardadas
                const eventoLat = parseFloat(latInput.value);
                const eventoLng = parseFloat(lngInput.value);
                const sinCoords = (eventoLat === 2.9274 && eventoLng === -75.2819);
                if (sinCoords) {
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]).openPopup();
                    latInput.value = lat.toFixed(8);
                    lngInput.value = lng.toFixed(8);
                }
            }
        }
    }

    /* Forzar redibujado si el mapa estaba en un tab oculto */
    setTimeout(() => map.invalidateSize(), 300);

})();

/* ════════════════════════════════════════════════════════════════
   ESTADO PREVIEW (select activo / inactivo)
════════════════════════════════════════════════════════════════ */
window.actualizarEstadoPreview = function (valor) {
    const preview = document.getElementById('estado-preview');
    const dot     = document.getElementById('estado-dot');
    const label   = document.getElementById('estado-label');
    if (valor === 'activo') {
        preview.className = 'estado-preview activo';
        dot.className     = 'w-1.5 h-1.5 rounded-full bg-green-500';
        label.textContent = 'Visible';
    } else {
        preview.className = 'estado-preview inactivo';
        dot.className     = 'w-1.5 h-1.5 rounded-full bg-red-400';
        label.textContent = 'Oculta';
    }
};
</script>
@endpush