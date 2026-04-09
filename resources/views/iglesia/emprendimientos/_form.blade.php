{{--
    _form.blade.php – Parcial para create/edit de Emprendimiento
    Variables esperadas:
        $emprendimiento   → instancia de Emprendimiento (nueva o existente)
        $iglesias         → Collection<Iglesia> (opcional, para relacionar)
--}}
@php
    $editing = isset($emprendimiento) && $emprendimiento && $emprendimiento->exists;
    $inp  = 'w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-emerald-400 focus:ring-emerald-100 transition-all';
    $inpE = 'w-full px-4 py-2.5 text-sm rounded-xl border border-red-300 bg-red-50 text-slate-800 placeholder-red-300 focus:outline-none focus:ring-2 focus:border-red-400 focus:ring-red-100 transition-all';
    $lbl  = 'block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5';
    $req  = '<span class="text-red-500 ml-0.5">*</span>';
    $baseCats = ['Alimentos','Restaurante','Salud','Belleza','Hogar','Construcción','Otro'];
    $currentCat = old('categoria', $emprendimiento->categoria ?? '');
    $isCustomCat = $currentCat && !in_array($currentCat, $baseCats);
@endphp

{{-- SECCIÓN 1 – Información básica --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #F5FFF6, #ECFEF3);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #065f46, #10b981);">1</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Información básica</p>
            <p class="text-xs text-slate-400 mt-0.5">Nombre, categoría y relación con iglesia</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Iglesia asociada (opcional) --}}
        @php
            $userIglesia = Auth::user()?->iglesia ?? null;
        @endphp

        @if($userIglesia)
            <div>
                <label class="{{ $lbl }}">Iglesia asociada</label>
                <input type="hidden" id="iglesia_id" name="iglesia_id" value="{{ old('iglesia_id', $emprendimiento->iglesia_id ?? $userIglesia->id) }}"
                       data-lat="{{ $userIglesia->latitud ?? '' }}"
                       data-lng="{{ $userIglesia->longitud ?? '' }}"
                       data-address="{{ addslashes($userIglesia->address ?? '') }}">

                <div class="py-2 px-3 rounded-xl border border-slate-100 bg-slate-50 text-sm text-slate-700">{{ $userIglesia->official_name }}</div>
            </div>
        @elseif(isset($iglesias))
            <div>
                <label for="iglesia_id" class="{{ $lbl }}">Iglesia asociada</label>
                <div class="relative">
                    <select id="iglesia_id" name="iglesia_id" class="{{ $errors->has('iglesia_id') ? $inpE : $inp }} appearance-none pr-10">
                        <option value="">Sin iglesia</option>
                        @foreach($iglesias as $iglesia)
                            <option value="{{ $iglesia->id }}"
                                    data-lat="{{ $iglesia->latitud ?? '' }}"
                                    data-lng="{{ $iglesia->longitud ?? '' }}"
                                    data-address="{{ addslashes($iglesia->address ?? '') }}"
                                    {{ old('iglesia_id', $emprendimiento->iglesia_id ?? '') == $iglesia->id ? 'selected' : '' }}>
                                {{ $iglesia->official_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
                @error('iglesia_id')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- Nombre y categoría --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="nombre" class="{{ $lbl }}">Nombre del emprendimiento {!! $req !!}</label>
                <input type="text" id="nombre" name="nombre" required
                       value="{{ old('nombre', $emprendimiento->nombre ?? '') }}"
                       class="{{ $errors->has('nombre') ? $inpE : $inp }}"
                       placeholder="Ej: Panadería La Esperanza" maxlength="200" autocomplete="off">
                @error('nombre')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="categoria" class="{{ $lbl }}">Categoría {!! $req !!}</label>
                <div class="relative">
                    <select id="categoria" name="categoria" required class="{{ $errors->has('categoria') ? $inpE : $inp }} appearance-none pr-10">
                        @foreach($baseCats as $cat)
                            @if($cat === 'Otro')
                                <option value="Otro" {{ old('categoria') === 'Otro' || ($isCustomCat && !$editing ? false : ($isCustomCat ? 'selected' : '')) ? 'selected' : '' }}>Otro</option>
                            @else
                                <option value="{{ $cat }}" {{ old('categoria', $emprendimiento->categoria ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
                @error('categoria')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Otra categoría (visible solo cuando se elige Otro) --}}
        <div id="otra-categoria-wrap" class="{{ $isCustomCat ? '' : 'hidden' }}">
            <label for="otra_categoria" class="{{ $lbl }}">Otra categoría</label>
            <input type="text" id="otra_categoria" name="otra_categoria"
                   value="{{ old('otra_categoria', $isCustomCat ? $currentCat : '') }}"
                   class="{{ $errors->has('otra_categoria') ? $inpE : $inp }}"
                   placeholder="Escribe la nueva categoría (ej: Tecnología, Servicios)" maxlength="100">
            @error('otra_categoria')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

    </div>
</div>

{{-- SECCIÓN 2 – Contacto y dirección --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background: linear-gradient(135deg,#FFF7ED,#FFFBEB);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0" style="background: linear-gradient(135deg,#C2410C,#FB923C);">2</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Contacto y ubicación</p>
            <p class="text-xs text-slate-400 mt-0.5">Teléfono, correo, sitio web y dirección</p>
        </div>
    </div>
    <div class="p-5 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label for="telefono" class="{{ $lbl }}">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $emprendimiento->telefono ?? '') }}" class="{{ $errors->has('telefono') ? $inpE : $inp }}" placeholder="Ej: 3101234567">
                @error('telefono')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="{{ $lbl }}">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email', $emprendimiento->email ?? '') }}" class="{{ $errors->has('email') ? $inpE : $inp }}" placeholder="contacto@ejemplo.com">
                @error('email')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="web" class="{{ $lbl }}">Sitio web / Red social</label>
                <input type="url" id="web" name="web" value="{{ old('web', $emprendimiento->web ?? '') }}" class="{{ $errors->has('web') ? $inpE : $inp }}" placeholder="https://">
                @error('web')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="horario" class="{{ $lbl }}">Horario</label>
                <input type="text" id="horario" name="horario" value="{{ old('horario', $emprendimiento->horario ?? '') }}" class="{{ $errors->has('horario') ? $inpE : $inp }}" placeholder="Ej: Lun–Vie 8:00–17:00 · Sáb 8:00–12:00">
                @error('horario')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="direccion" class="{{ $lbl }}">Dirección</label>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $emprendimiento->direccion ?? '') }}" class="{{ $errors->has('direccion') ? $inpE : $inp }}" placeholder="Calle 1 # 2-3, Barrio">
                    <button type="button" id="geocode-btn" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/></svg>
                    Buscar
                </button>
                </div>
                <div id="geocode-results" class="hidden mt-1 text-sm"></div>
            </div>
            @error('direccion')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="latitud" class="{{ $lbl }}">Latitud</label>
                <input type="text" id="latitud" name="latitud" value="{{ old('latitud', $emprendimiento->latitud ?? '') }}" class="{{ $errors->has('latitud') ? $inpE : $inp }}" placeholder="Ej: 2.927123">
                @error('latitud')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="longitud" class="{{ $lbl }}">Longitud</label>
                <input type="text" id="longitud" name="longitud" value="{{ old('longitud', $emprendimiento->longitud ?? '') }}" class="{{ $errors->has('longitud') ? $inpE : $inp }}" placeholder="Ej: -75.280456">
                @error('longitud')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="{{ $lbl }}">Ubicar en el mapa</label>
            <div id="empr-map"
                 class="w-full rounded-2xl overflow-hidden border border-slate-100 shadow-sm mb-2"
                 style="height:320px; position:relative;"
                 aria-label="Mapa selector de ubicación del emprendimiento">
            </div>
            <p class="text-xs text-slate-400">Haz clic en el mapa o arrastra el marcador para establecer la ubicación.</p>
        </div>
    </div>
</div>

{{-- SECCIÓN 3 – Descripción e imágenes --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background: linear-gradient(135deg,#EEF2FF,#EEF7FF);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0" style="background: linear-gradient(135deg,#1E40AF,#3B82F6);">3</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Descripción y multimedia</p>
            <p class="text-xs text-slate-400 mt-0.5">Breve descripción y foto principal</p>
        </div>
    </div>
    <div class="p-5 space-y-4">
        <div>
            <label for="descripcion" class="{{ $lbl }}">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" maxlength="1200" class="{{ $errors->has('descripcion') ? $inpE : $inp }} resize-none">{{ old('descripcion', $emprendimiento->descripcion ?? '') }}</textarea>
            @error('descripcion')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="imagen_principal" class="{{ $lbl }}">Imagen principal</label>
            <input type="file" id="imagen_principal" name="imagen_principal" accept="image/*" class="{{ $inp }}">
            @if($editing && ($emprendimiento->imagen_principal ?? false))
                <p class="text-xs text-slate-500 mt-2">Imagen actual: <span class="font-medium">{{ $emprendimiento->imagen_principal }}</span></p>
            @endif
            @error('imagen_principal')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    var sel = document.getElementById('categoria');
    var wrap = document.getElementById('otra-categoria-wrap');
    var otra = document.getElementById('otra_categoria');
    function toggle() {
        if (!sel) return;
        if (sel.value === 'Otro') { wrap.classList.remove('hidden'); if(otra) otra.required = true; }
        else { wrap.classList.add('hidden'); if(otra) { otra.required = false; otra.value = ''; } }
    }
    if (sel) sel.addEventListener('change', toggle);
    toggle();
});
</script>
@endpush

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #empr-map { width: 100% !important; height: 320px !important; }
        #empr-map .leaflet-container { width: 100% !important; height: 100% !important; }
    </style>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    (function(){
        const NEIVA = [2.9274, -75.2819];
        const NOMINATIM = 'https://nominatim.openstreetmap.org';
        const DEBOUNCE_MS = 600;

        const latInput = document.getElementById('latitud');
        const lngInput = document.getElementById('longitud');
        const dirInput = document.getElementById('direccion');
        const mapEl = document.getElementById('empr-map');
        if (!mapEl || typeof L === 'undefined') return;

        const initLat = parseFloat(latInput.value) || NEIVA[0];
        const initLng = parseFloat(lngInput.value) || NEIVA[1];

        const map = L.map('empr-map', { center:[initLat, initLng], zoom: (latInput.value && lngInput.value)?15:12, minZoom:10, maxZoom:19,
            maxBounds: [[2.65, -75.55], [3.20, -75.00]], maxBoundsViscosity: 0.85
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors', maxZoom: 19 }).addTo(map);

        const icono = L.divIcon({ className:'', html:`<div style="width:36px;height:36px;background:linear-gradient(135deg,#065f46,#10b981);border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 3px 12px rgba(16,185,129,.25);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:15px;">📍</span></div>`, iconSize:[36,36], iconAnchor:[18,36], popupAnchor:[0,-40] });

        const marker = L.marker([initLat, initLng], { draggable:true, icon: icono }).addTo(map);
        marker.bindPopup('<strong>Arrastra para ubicar</strong>').openPopup();

        function aplicarCoordenadas(lat, lng, zoom){
            // Normalize to dot decimal separator and fixed precision
            var la = typeof lat === 'string' ? parseFloat(lat.replace(',', '.')) : parseFloat(lat);
            var lo = typeof lng === 'string' ? parseFloat(lng.replace(',', '.')) : parseFloat(lng);
            if (isNaN(la) || isNaN(lo)) return;
            latInput.value = la.toFixed(8);
            lngInput.value = lo.toFixed(8);
            marker.setLatLng([lat,lng]);
            map.setView([lat,lng], zoom || map.getZoom(), { animate:true });
            marker.openPopup();
        }

        function debounce(fn, ms){ let t; return function(){ clearTimeout(t); t = setTimeout(()=>fn.apply(this, arguments), ms); }; }

        async function geocodificarDireccion(q){
            if (!q || q.trim().length < 3) return;
            // Clean query and avoid duplicating city if user already included it
            var query = q.trim();
            if (!/neiva/i.test(query)) query = query + ', Neiva, Huila, Colombia';
            // Build URL
            const url = new URL(NOMINATIM + '/search');
            url.searchParams.set('q', query);
            url.searchParams.set('format','json'); url.searchParams.set('limit','3'); url.searchParams.set('countrycodes','co'); url.searchParams.set('accept-language','es');
            try{
                console.log('Geocoding query:', query, url.toString());
                const res = await fetch(url.toString()); const data = await res.json();
                if (!data || !data.length) { showGeocodeResults([]); return; }

                // If multiple results, show a chooser so user can pick the exact match
                if (data.length > 1) {
                    showGeocodeResults(data.slice(0,5));
                    // still pick the heuristic-best to preview
                    var bestPreview = data[0];
                    for (var i=0;i<data.length;i++){ var t=(data[i].type||'').toLowerCase(); if(t==='house'||t==='residential'||t==='building'){ bestPreview = data[i]; break; } }
                    aplicarCoordenadas(bestPreview.lat, bestPreview.lon, 15);
                    marker.bindPopup(bestPreview.display_name || '').openPopup();
                    return;
                }

                // Single result -> apply directly
                const single = data[0];
                showGeocodeResults([]);
                aplicarCoordenadas(single.lat, single.lon, 17);
                if (single.display_name) marker.bindPopup(single.display_name).openPopup();
            }catch(e){ console.error('geo error', e); }
        }

        // Render geocode candidate list below the address input
        const geocodeResultsEl = document.getElementById('geocode-results');
        function showGeocodeResults(list){
            if (!geocodeResultsEl) return;
            if (!list || !list.length) { geocodeResultsEl.innerHTML = ''; geocodeResultsEl.classList.add('hidden'); return; }
            geocodeResultsEl.classList.remove('hidden');
            geocodeResultsEl.innerHTML = '';
            list.forEach(function(item, idx){
                const div = document.createElement('div');
                div.className = 'p-2 rounded-lg hover:bg-slate-50 cursor-pointer border border-transparent';
                div.style.borderRadius = '8px';
                div.style.marginBottom = '6px';
                div.innerHTML = '<div class="font-semibold">' + (item.display_name || item.type || 'Resultado ' + (idx+1)) + '</div>'+
                                '<div class="text-xs text-slate-500 mt-0.5">Lat: ' + parseFloat(item.lat).toFixed(6) + ' • Lon: ' + parseFloat(item.lon).toFixed(6) + '</div>';
                div.addEventListener('click', function(){
                    aplicarCoordenadas(item.lat, item.lon, 17);
                    dirInput.value = item.display_name || dirInput.value;
                    geocodeResultsEl.innerHTML = '';
                    geocodeResultsEl.classList.add('hidden');
                });
                geocodeResultsEl.appendChild(div);
            });
        }

        async function reverseGeocodificar(lat,lng){
            const url = new URL(NOMINATIM + '/reverse');
            url.searchParams.set('lat', lat.toFixed(8)); url.searchParams.set('lon', lng.toFixed(8)); url.searchParams.set('format','json'); url.searchParams.set('accept-language','es');
            try{
                const res = await fetch(url.toString()); const data = await res.json();
                if (data && data.address){
                    const a = data.address; const texto = [a.road||a.pedestrian||'', a.house_number||'', a.suburb||a.neighbourhood||''].filter(Boolean).join(', ');
                    if (texto){ dirInput.removeEventListener('input', debouncedGeo); dirInput.value = texto; dirInput.addEventListener('input', debouncedGeo); }
                }
            }catch(e){ /* silent */ }
        }

        marker.on('dragend', function(e){ const p = e.target.getLatLng(); aplicarCoordenadas(p.lat,p.lng); reverseGeocodificar(p.lat,p.lng); });
        map.on('click', function(e){ const p = e.latlng; aplicarCoordenadas(p.lat,p.lng); reverseGeocodificar(p.lat,p.lng); });

        const debouncedGeo = debounce(function(){ geocodificarDireccion(dirInput.value); }, DEBOUNCE_MS);
        if (dirInput){ dirInput.addEventListener('input', debouncedGeo); dirInput.addEventListener('blur', function(){ if(this.value.trim().length>=3) geocodificarDireccion(this.value); }); }

        // geocode button + enter
        const geocodeBtn = document.getElementById('geocode-btn');
        if (geocodeBtn){ geocodeBtn.addEventListener('click', function(){ if(dirInput && dirInput.value.trim()) geocodificarDireccion(dirInput.value); }); }
        if (dirInput){ dirInput.addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); geocodificarDireccion(dirInput.value); } }); }

        // iglesia select or hidden fly-to (supports select or hidden input with data-* attributes)
        const iglesiaSelect = document.getElementById('iglesia_id');
        function volarAIglesia(opt){
            if(!opt) return;
            const ds = opt.dataset || {};
            const lat = parseFloat(ds.lat), lng = parseFloat(ds.lng);
            if(!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0){
                map.flyTo([lat,lng],16,{duration:1.2});
                marker.setLatLng([lat,lng]).openPopup();
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);
                const addr = ds.address || '';
                if(addr && !dirInput.value.trim()){
                    dirInput.removeEventListener('input', debouncedGeo);
                    dirInput.value = addr;
                    dirInput.addEventListener('input', debouncedGeo);
                }
            }
        }

        if (iglesiaSelect){
            const tag = (iglesiaSelect.tagName || '').toUpperCase();
            if(tag === 'SELECT'){
                iglesiaSelect.addEventListener('change', function(){ volarAIglesia(this.options[this.selectedIndex]); });
                if(iglesiaSelect.value){
                    const opt = iglesiaSelect.options[iglesiaSelect.selectedIndex];
                    const eventoLat = parseFloat(latInput.value), eventoLng = parseFloat(lngInput.value);
                    if((!eventoLat && !eventoLng) || (eventoLat===0 && eventoLng===0)) volarAIglesia(opt);
                }
            } else {
                // hidden input or simple element with data attributes
                volarAIglesia(iglesiaSelect);
            }
        }

        // inputs manual sync
        [latInput,lngInput].forEach(function(el){ if(!el) return; el.addEventListener('change', function(){ const la = parseFloat(latInput.value), lo = parseFloat(lngInput.value); if(!isNaN(la)&&!isNaN(lo)){ marker.setLatLng([la,lo]); map.setView([la,lo]); } }); });

        // Robust rendering: reintentar invalidateSize hasta que el contenedor tenga dimensiones útiles
        (function ensureMapRendered(maxRetries = 12, delay = 300) {
            let attempts = 0;
            function check() {
                attempts++;
                try {
                    const rect = mapEl.getBoundingClientRect();
                    const container = map.getContainer();
                    const cRect = container.getBoundingClientRect();
                    const good = rect.width > 80 && rect.height > 80 && cRect.width > 80 && cRect.height > 80;
                    map.invalidateSize(true);
                    if (!good && attempts < maxRetries) {
                        setTimeout(check, delay);
                        return;
                    }
                    // Force tile redraw if available
                    map.eachLayer(function(layer){ try{ if (layer && typeof layer.redraw === 'function') layer.redraw(); }catch(e){} });
                } catch (e) {
                    if (attempts < maxRetries) setTimeout(check, delay);
                }
            }
            check();

            // Re-apply on window resize
            window.addEventListener('resize', function(){ setTimeout(function(){ map.invalidateSize(true); }, 120); });

            // Observe parent changes (visibility/layout) and invalidate
            try {
                const observer = new MutationObserver(function(){ setTimeout(function(){ map.invalidateSize(true); }, 50); });
                let parent = mapEl.parentElement;
                if (parent) observer.observe(parent, { attributes: true, childList: true, subtree: true });
            } catch (e) { /* ignore */ }
        })();
    })();
    </script>
@endpush
