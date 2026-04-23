{{-- ══════════════════════════════════════════════════════════
     _form.blade.php — Parcial compartido por create y edit
     Variables esperadas:
       $foundation → instancia de Foundation (nueva o existente)
══════════════════════════════════════════════════════════ --}}

@php
    $inp  = 'w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-emerald-400 focus:ring-emerald-100 transition-all';
    $inpE = 'w-full px-4 py-2.5 text-sm rounded-xl border border-red-300 bg-red-50 text-slate-800 placeholder-red-300 focus:outline-none focus:ring-2 focus:border-red-400 focus:ring-red-100 transition-all';
    $lbl  = 'block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5';
    $req  = '<span class="text-red-500 ml-0.5">*</span>';
@endphp

{{-- ── SECCIÓN 1: Información de la Fundación ── --}}
<div class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">

    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #ECFDF5, #D1FAE5);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #065f46, #059669);">
            1
        </div>
        <div>
            <p class="text-sm font-bold text-slate-800">Información de la Fundación</p>
            <p class="text-xs text-slate-400 mt-0.5">Nombre, NIT y representante legal</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Nombre --}}
        <div>
            <label for="name" class="{{ $lbl }}">Nombre de la Fundación {!! $req !!}</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $foundation->name ?? '') }}"
                   class="{{ $errors->has('name') ? $inpE : $inp }}"
                   placeholder="Ej: Fundación Beerseba"
                   maxlength="200" autocomplete="off">
            @error('name')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- NIT --}}
        <div>
            <label for="nit" class="{{ $lbl }}">NIT</label>
            <input type="text" id="nit" name="nit"
                   value="{{ old('nit', $foundation->nit ?? '') }}"
                   class="{{ $inp }}"
                   placeholder="Ej: 900.949.364-4"
                   maxlength="30" autocomplete="off">
        </div>

        {{-- Representante + Documento --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="representative" class="{{ $lbl }}">Nombre del Representante</label>
                <input type="text" id="representative" name="representative"
                       value="{{ old('representative', $foundation->representative ?? '') }}"
                       class="{{ $inp }}"
                       placeholder="Ej: María López Pérez"
                       maxlength="150" autocomplete="off">
            </div>
            <div>
                <label for="document" class="{{ $lbl }}">Documento del Representante</label>
                <input type="text" id="document" name="document"
                       value="{{ old('document', $foundation->document ?? '') }}"
                       class="{{ $inp }}"
                       placeholder="Ej: 7.698.874"
                       maxlength="30" autocomplete="off">
            </div>
        </div>

    </div>
</div>

{{-- ── SECCIÓN 2: Contacto y Ubicación ── --}}
<div class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">

    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #ECFDF5, #D1FAE5);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #065f46, #059669);">
            2
        </div>
        <div>
            <p class="text-sm font-bold text-slate-800">Contacto y Ubicación</p>
            <p class="text-xs text-slate-400 mt-0.5">Teléfono, correo, dirección y coordenadas</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Teléfono + Email --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="{{ $lbl }}">Teléfono</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </span>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $foundation->phone ?? '') }}"
                           class="{{ $inp }} pl-10"
                           placeholder="Ej: 3115915165"
                           maxlength="30" autocomplete="off">
                </div>
            </div>
            <div>
                <label for="email" class="{{ $lbl }}">Correo Electrónico</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $foundation->email ?? '') }}"
                           class="{{ $errors->has('email') ? $inpE : $inp }} pl-10"
                           placeholder="correo@fundacion.org"
                           maxlength="150" autocomplete="off">
                </div>
                @error('email')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Dirección --}}
        <div>
            <label for="address" class="{{ $lbl }}">Dirección</label>
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <input type="text" id="address" name="address"
                           value="{{ old('address', $foundation->address ?? '') }}"
                           class="{{ $inp }} pr-10"
                           placeholder="Ej: Cra 3A #12-20 El Centro, Neiva"
                           maxlength="255" autocomplete="off">
                    <span id="geo-spinner" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="w-4 h-4 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                    </span>
                    <span id="geo-ok"
                          class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full
                                 flex items-center justify-center"
                          style="background:#F0FDF4;" title="Coordenadas encontradas">
                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span id="geo-err"
                          class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full
                                 flex items-center justify-center"
                          style="background:#FFF1F2;" title="No se encontraron coordenadas">
                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01"/>
                        </svg>
                    </span>
                </div>
                {{-- Botón buscar manual --}}
                <button type="button" id="btn-geocode"
                        onclick="geocodeManual()"
                        title="Buscar coordenadas"
                        class="flex-shrink-0 flex items-center gap-1.5 px-3 py-2.5 text-xs font-bold
                               text-white rounded-xl transition-all hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #065f46, #059669);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Ubicar
                </button>
            </div>
            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Escribe la dirección y se llenará automáticamente, o arrastra el pin en el mapa.
            </p>
        </div>

        {{-- Latitud + Longitud --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="latitude" class="{{ $lbl }}">Latitud</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-300 pointer-events-none">
                        LAT
                    </span>
                    <input type="number" id="latitude" name="latitude" step="any"
                           value="{{ old('latitude', $foundation->latitude ?? '') }}"
                           class="{{ $errors->has('latitude') ? $inpE : $inp }} pl-12 font-mono"
                           placeholder="2.9274">
                </div>
                @error('latitude')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="longitude" class="{{ $lbl }}">Longitud</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-300 pointer-events-none">
                        LNG
                    </span>
                    <input type="number" id="longitude" name="longitude" step="any"
                           value="{{ old('longitude', $foundation->longitude ?? '') }}"
                           class="{{ $errors->has('longitude') ? $inpE : $inp }} pl-12 font-mono"
                           placeholder="-75.2819">
                </div>
                @error('longitude')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Imagen de la fundación (opcional) --}}
        <div>
            <label for="imagen_principal" class="{{ $lbl }}">Imagen de la Fundación</label>
            <div class="flex items-center gap-3">
                <input type="file" id="imagen_principal" name="imagen_principal" accept="image/*" class="text-sm">
                <button type="button" id="btn-remove-image" class="text-xs text-red-500 hidden">Quitar</button>
            </div>
            <p class="text-xs text-slate-400 mt-1.5">Sube una imagen representativa de la fundación (opcional). Tamaño máximo recomendado 2MB.</p>

            @if(isset($foundation) && ($foundation->imagen_principal ?? $foundation->image ?? false))
                <div id="image-preview" class="mt-3 w-40 h-28 overflow-hidden rounded-lg border border-slate-200">
                    <img src="{{ asset('storage/' . ($foundation->imagen_principal ?? $foundation->image)) }}" alt="Imagen" class="w-full h-full object-cover">
                </div>
            @else
                <div id="image-preview" class="mt-3 w-40 h-28 overflow-hidden rounded-lg border border-slate-200 hidden">
                    <img src="" alt="Imagen" class="w-full h-full object-cover">
                </div>
            @endif

            @error('imagen_principal')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Mini-mapa selector ── --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="{{ $lbl }} mb-0">Ubicación en el mapa</label>
                <span class="text-xs text-slate-400 italic">Haz clic o arrastra el marcador para ajustar</span>
            </div>
            <div id="foundation-map-picker"
                 style="height:260px;border-radius:14px;border:1.5px solid #D1FAE5;overflow:hidden;box-shadow:0 2px 8px rgba(5,150,105,.1);">
            </div>
            <p id="map-picker-hint" class="text-xs text-emerald-600 mt-1.5 hidden">
                ✅ Coordenadas actualizadas desde el mapa
            </p>
        </div>

    </div>
</div>

@push('scripts')
{{-- Leaflet CSS + JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
(function () {
    /* ── Referencias DOM ─────────────────────────── */
    var addressInput = document.getElementById('address');
    var latInput     = document.getElementById('latitude');
    var lngInput     = document.getElementById('longitude');
    var spinner      = document.getElementById('geo-spinner');
    var okIcon       = document.getElementById('geo-ok');
    var errIcon      = document.getElementById('geo-err');
    var hint         = document.getElementById('map-picker-hint');

    /* ── Defaults: centro de Neiva ───────────────── */
    var DEFAULT_LAT = 2.9274;
    var DEFAULT_LNG = -75.2819;
    var DEFAULT_ZOOM = 13;

    var initialLat = parseFloat(latInput.value) || DEFAULT_LAT;
    var initialLng = parseFloat(lngInput.value) || DEFAULT_LNG;
    var initialZoom = (latInput.value && lngInput.value) ? 16 : DEFAULT_ZOOM;

    /* ── Inicializar mini-mapa ───────────────────── */
    var map = L.map('foundation-map-picker', { zoomControl: true }).setView([initialLat, initialLng], initialZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OSM</a>',
        maxZoom: 19
    }).addTo(map);

    /* ── Ícono personalizado (pin esmeralda) ─────── */
    var pinIcon = L.divIcon({
        className: '',
        html: '<div style="width:28px;height:28px;background:#059669;border:3px solid #fff;'
            + 'border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 2px 6px rgba(0,0,0,.35);">'
            + '</div>',
        iconSize:   [28, 28],
        iconAnchor: [14, 28],
        popupAnchor:[0, -30]
    });

    /* ── Marcador arrastrable ────────────────────── */
    var marker = null;

    function placeMarker(lat, lng, panMap) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { icon: pinIcon, draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                var pos = e.target.getLatLng();
                setCoords(pos.lat, pos.lng, true);
            });
        }
        if (panMap) map.setView([lat, lng], Math.max(map.getZoom(), 16));
    }

    function setCoords(lat, lng, fromMap) {
        latInput.value = lat.toFixed(7);
        lngInput.value = lng.toFixed(7);
        placeMarker(lat, lng, !fromMap);
        if (fromMap) {
            hint.classList.remove('hidden');
            setTimeout(function(){ hint.classList.add('hidden'); }, 3000);
        }
    }

    /* Colocar marcador si ya hay coordenadas al cargar */
    if (latInput.value && lngInput.value) {
        placeMarker(initialLat, initialLng, false);
    }

    /* Clic en el mapa → colocar / mover marcador */
    map.on('click', function (e) {
        setCoords(e.latlng.lat, e.latlng.lng, true);
        setGeoState(null);
    });

    /* ── Estado de geocodificación ───────────────── */
    function setGeoState(state) {
        spinner.classList.add('hidden');
        okIcon.classList.add('hidden');
        errIcon.classList.add('hidden');
        if (state === 'loading') spinner.classList.remove('hidden');
        if (state === 'ok')      okIcon.classList.remove('hidden');
        if (state === 'error')   errIcon.classList.remove('hidden');
    }

    /* ── Geocodificación vía proxy ───────────── */
    const GEOCODE_URL         = '/api/geocode';
    const GEOCODE_REVERSE_URL = '/api/geocode/reverse';

    async function geocode(query) {
        try {
            const res = await fetch(GEOCODE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ address: query, municipality: 'Neiva', department: 'Huila' }),
            });
            const data = await res.json();
            if (data && data.success) {
                var lat = parseFloat(data.lat);
                var lng = parseFloat(data.lng);
                setCoords(lat, lng, false);
                setGeoState('ok');
            } else {
                setGeoState('error');
            }
        } catch { setGeoState('error'); }
    }

    /* ── Botón manual "Ubicar" ───────────────────── */
    window.geocodeManual = function () {
        var val = addressInput ? addressInput.value.trim() : '';
        if (val.length < 3) return;
        setGeoState('loading');
        geocode(val);
    };

    /* ── Debounce al escribir en Dirección ───────── */
    var debounceTimer = null;
    if (addressInput) {
        addressInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            var val = this.value.trim();
            if (val.length < 5) { setGeoState(null); return; }
            setGeoState('loading');
            debounceTimer = setTimeout(function () { geocode(val); }, 1000);
        });
    }

    /* ── Escribir en lat/lng manualmente → mover pin */
    function onManualCoordInput() {
        var lat = parseFloat(latInput.value);
        var lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng) &&
            lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
            placeMarker(lat, lng, true);
        }
    }
    latInput.addEventListener('change', onManualCoordInput);
    lngInput.addEventListener('change', onManualCoordInput);

    /* Forzar recálculo de tamaño cuando el mapa sea visible */
    setTimeout(function () { map.invalidateSize(); }, 300);
})();

// Imagen preview
(function(){
    var input = document.getElementById('imagen_principal');
    var previewWrap = document.getElementById('image-preview');
    var previewImg = previewWrap ? previewWrap.querySelector('img') : null;
    var btnRemove = document.getElementById('btn-remove-image');

    if (!input) return;

    input.addEventListener('change', function(e){
        var file = this.files && this.files[0];
        if (!file) return;
        var url = URL.createObjectURL(file);
        if (previewImg) { previewImg.src = url; previewWrap.classList.remove('hidden'); }
        if (btnRemove) btnRemove.classList.remove('hidden');
    });

    if (btnRemove) {
        btnRemove.addEventListener('click', function(){
            input.value = '';
            if (previewImg) { previewImg.src = ''; previewWrap.classList.add('hidden'); }
            this.classList.add('hidden');
        });
    }
})();
</script>
@endpush
