{{-- ═══════════════════════════════════════════════════════════
     _form.blade.php  – Parcial compartido por create y edit de Eventos
     Variables esperadas:
         $evento       → instancia de Evento (nueva o existente)
         $iglesias     → Collection<Iglesia> (todas disponibles para el select)
═══════════════════════════════════════════════════════════ --}}
@php
    $editing = isset($evento) && $evento && $evento->exists;
    $inp  = 'w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-violet-400 focus:ring-violet-100 transition-all';
    $inpE = 'w-full px-4 py-2.5 text-sm rounded-xl border border-red-300 bg-red-50 text-slate-800 placeholder-red-300 focus:outline-none focus:ring-2 focus:border-red-400 focus:ring-red-100 transition-all';
    $lbl  = 'block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5';
    $req  = '<span class="text-red-500 ml-0.5">*</span>';
@endphp

{{-- ═══════════════════════════════════
     SECCIÓN 1 – Información básica
═══════════════════════════════════ --}}
<div id="seccion-1" class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #F5F3FF, #EDE9FE);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #2d1b69, #7c3aed);">1</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Información básica</p>
            <p class="text-xs text-slate-400 mt-0.5">Título, iglesia asociada y tipo de evento</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Iglesia organizadora --}}
        <div>
            <label for="iglesia_id" class="{{ $lbl }}">
                Iglesia organizadora {!! $req !!}
            </label>
            <div class="relative">
                <select id="iglesia_id" name="iglesia_id" required
                        class="{{ $errors->has('iglesia_id') ? $inpE : $inp }} appearance-none pr-10">
                    <option value="">Seleccione una iglesia…</option>
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
                <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </div>
            @error('iglesia_id')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Título + Tipo --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="titulo" class="{{ $lbl }}">
                    Título del evento {!! $req !!}
                </label>
                <input type="text" id="titulo" name="titulo"
                       value="{{ old('titulo', $evento->titulo ?? '') }}"
                       class="{{ $errors->has('titulo') ? $inpE : $inp }}"
                       placeholder="Ej: Retiro Juvenil 2025"
                       maxlength="200" autocomplete="off">
                @error('titulo')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="tipo_evento" class="{{ $lbl }}">
                    Tipo de evento {!! $req !!}
                </label>
                <input type="text" id="tipo_evento" name="tipo_evento"
                       value="{{ old('tipo_evento', $evento->tipo_evento ?? '') }}"
                       class="{{ $errors->has('tipo_evento') ? $inpE : $inp }}"
                       placeholder="Ej: Retiro, Conferencia, Culto"
                       maxlength="100" list="tipos-evento-list">
                <datalist id="tipos-evento-list">
                    @foreach(['Retiro','Conferencia','Culto','Campamento','Otro'] as $t)
                        <option value="{{ $t }}">
                    @endforeach
                </datalist>
                @error('tipo_evento')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Estado --}}
        <div>
            <label for="estado" class="{{ $lbl }}">
                Estado {!! $req !!}
            </label>
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <select id="estado" name="estado"
                            class="{{ $inp }} appearance-none pr-10"
                            onchange="actualizarEstadoPreview(this.value)">
                        <option value="activo"   {{ old('estado', $evento->estado ?? 'activo') === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $evento->estado ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </div>
                {{-- Badge preview --}}
                <span id="estado-preview"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full flex-shrink-0 transition-all"
                      style="{{ old('estado', $evento->estado ?? 'activo') === 'activo'
                          ? 'background:#F0FDF4;color:#166534;'
                          : 'background:#FFF1F2;color:#9F1239;' }}">
                    <span id="estado-dot"
                          class="w-1.5 h-1.5 rounded-full {{ old('estado', $evento->estado ?? 'activo') === 'activo' ? 'bg-green-500 animate-pulse' : 'bg-red-400' }}">
                    </span>
                    <span id="estado-label">
                        {{ old('estado', $evento->estado ?? 'activo') === 'activo' ? 'Visible' : 'Oculto' }}
                    </span>
                </span>
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 2 – Fechas y Ubicación
═══════════════════════════════════ --}}
<div id="seccion-2" class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #ECFDF5, #D1FAE5);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #065f46, #059669);">2</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Fechas y Ubicación</p>
            <p class="text-xs text-slate-400 mt-0.5">Cuándo y dónde se realizará el evento</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Fechas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="fecha_inicio" class="{{ $lbl }}">
                    Fecha y hora de inicio {!! $req !!}
                </label>
                <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required
                       value="{{ old('fecha_inicio', $editing ? ($evento->fecha_inicio instanceof \DateTimeInterface ? $evento->fecha_inicio->format('Y-m-d\TH:i') : $evento->fecha_inicio) : '') }}"
                       class="{{ $errors->has('fecha_inicio') ? $inpE : $inp }}">
                @error('fecha_inicio')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="fecha_fin" class="{{ $lbl }}">Fecha y hora de fin</label>
                <input type="datetime-local" id="fecha_fin" name="fecha_fin"
                       value="{{ old('fecha_fin', $editing && $evento->fecha_fin ? ($evento->fecha_fin instanceof \DateTimeInterface ? $evento->fecha_fin->format('Y-m-d\TH:i') : $evento->fecha_fin) : '') }}"
                       class="{{ $errors->has('fecha_fin') ? $inpE : $inp }}">
                @error('fecha_fin')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Dirección con geocodificación --}}
        <div>
            <label for="direccion_evento" class="{{ $lbl }}">
                Dirección del evento {!! $req !!}
            </label>
            <div class="relative">
                <input type="text" id="direccion_evento" name="direccion_evento" required
                       value="{{ old('direccion_evento', $evento->direccion_evento ?? '') }}"
                       class="{{ $errors->has('direccion_evento') ? $inpE : $inp }} pr-10"
                       placeholder="Ej: Calle 10 # 5-23, Barrio Las Palmas, Neiva"
                       maxlength="255" autocomplete="off">
                {{-- Indicador de estado geocoding --}}
                <span id="geo-status-icon-evento"
                      class="hidden absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                </span>
            </div>
            <p id="geo-status-msg-evento" class="hidden text-xs mt-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <span id="geo-status-text" class="font-medium text-emerald-600">
                    Al escribir la dirección se geocodificará automáticamente
                </span>
            </p>
            @error('direccion_evento')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
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
<div id="seccion-3" class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #FFFBEB, #FEF3C7);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #78350f, #d97706);">3</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Descripción y detalles</p>
            <p class="text-xs text-slate-400 mt-0.5">Información adicional del evento</p>
        </div>
    </div>

    <div class="p-5">
        <label for="descripcion" class="{{ $lbl }}">Descripción completa</label>
        <textarea id="descripcion" name="descripcion"
                  class="{{ $inp }} resize-none"
                  placeholder="Detalles del evento, horario, público objetivo, requisitos, notas importantes…"
                  rows="5" maxlength="2000"
                  oninput="actualizarContadorDesc(this)">{{ old('descripcion', $evento->descripcion ?? '') }}</textarea>
        <div class="flex items-center justify-between mt-1.5">
            @error('descripcion')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @else
                <span></span>
            @enderror
            <span id="desc-counter" class="text-[11px] text-slate-400 font-medium">
                {{ strlen(old('descripcion', $evento->descripcion ?? '')) }} / 2000
            </span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 5 – Imagen principal
═══════════════════════════════════ --}}
<div id="seccion-5" class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background: linear-gradient(135deg, #F8FAFF, #EFF6FF);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0" style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">5</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Imagen principal</p>
            <p class="text-xs text-slate-400 mt-0.5">Sube una imagen que se mostrará en la ficha y en el mapa</p>
        </div>
    </div>

    <div class="p-5">
        <label for="imagen_principal" class="{{ $lbl }}">Imagen principal</label>
        <div class="flex items-center gap-4">
            <input type="file" id="imagen_principal" name="imagen_principal" accept="image/*" class="text-sm">
            @if(isset($evento) && $evento->imagen_principal)
                <div class="w-20 h-20 rounded-lg overflow-hidden border border-slate-100">
                    <img src="{{ asset('storage/' . $evento->imagen_principal) }}" alt="Imagen" class="w-full h-full object-cover">
                </div>
            @endif
        </div>
        @error('imagen_principal')
            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 4 – Geolocalización
═══════════════════════════════════ --}}
<div id="seccion-4" class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #F8FAFF, #EFF6FF);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">4</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Geolocalización</p>
            <p class="text-xs text-slate-400 mt-0.5">Ubica el lugar del evento en el mapa</p>
        </div>
    </div>

    <div class="p-5 space-y-4">

        {{-- Tip --}}
        <div class="flex items-start gap-3 p-3.5 rounded-xl"
             style="background:#EFF6FF; border:1px solid #BFDBFE;">
            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-blue-700 leading-relaxed">
                <strong>Escribe la dirección arriba</strong> para geocodificar automáticamente,
                o <strong>haz clic en el mapa</strong> / arrastra el marcador.
                Los campos de coordenadas se actualizarán en tiempo real.
            </p>
        </div>

        {{-- Lat / Lng --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="latitud" class="{{ $lbl }}">Latitud {!! $req !!}</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-300 pointer-events-none">LAT</span>
                    <input type="number" id="latitud" name="latitud"
                           step="0.00000001" min="-90" max="90" required
                           value="{{ old('latitud', $evento->latitud ?? '2.9274') }}"
                           class="{{ $errors->has('latitud') ? $inpE : $inp }} pl-12 font-mono"
                           placeholder="2.92740000"
                           oninput="sincronizarCoords()">
                </div>
                @error('latitud')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="longitud" class="{{ $lbl }}">Longitud {!! $req !!}</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-300 pointer-events-none">LNG</span>
                    <input type="number" id="longitud" name="longitud"
                           step="0.00000001" min="-180" max="180" required
                           value="{{ old('longitud', $evento->longitud ?? '-75.2819') }}"
                           class="{{ $errors->has('longitud') ? $inpE : $inp }} pl-12 font-mono"
                           placeholder="-75.28190000"
                           oninput="sincronizarCoords()">
                </div>
                @error('longitud')
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Mapa --}}
        <div id="map-selector"
             class="w-full rounded-2xl overflow-hidden border border-slate-100 shadow-sm"
             style="height:380px;"
             aria-label="Mapa selector de ubicación del evento">
        </div>

        <div class="flex items-center justify-between flex-wrap gap-2">
            <p class="text-xs text-slate-400">Zona permitida: municipio de Neiva, Huila</p>
            <button type="button" onclick="centrarEnNeiva()"
                    class="inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 rounded-xl
                           border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Centrar en Neiva
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
(function () {

    /* ── Constantes ─────────────────────────────────────────── */
    const NEIVA       = [2.9274, -75.2819];
    const DEBOUNCE_MS = 600;
    const GEOCODE_URL         = '/api/geocode';
    const GEOCODE_REVERSE_URL = '/api/geocode/reverse';

    /* ── DOM ────────────────────────────────────────────────── */
    const latInput  = document.getElementById('latitud');
    const lngInput  = document.getElementById('longitud');
    const dirInput  = document.getElementById('direccion_evento');
    const geoIcon   = document.getElementById('geo-status-icon-evento');
    const geoMsgEl  = document.getElementById('geo-status-msg-evento');
    const geoText   = document.getElementById('geo-status-text');

    /* ── Mapa Leaflet ───────────────────────────────────────── */
    const initLat = parseFloat(latInput.value) || NEIVA[0];
    const initLng = parseFloat(lngInput.value) || NEIVA[1];

    const map = L.map('map-selector', {
        center: [initLat, initLng], zoom: 15, minZoom: 10, maxZoom: 19,
        maxBounds: [[2.65, -75.55], [3.20, -75.00]], maxBoundsViscosity: 0.85,
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors', maxZoom: 19,
    }).addTo(map);

    const icono = L.divIcon({
        className: '',
        html: `<div style="width:36px;height:36px;background:linear-gradient(135deg,#2d1b69,#7c3aed);
                    border-radius:50% 50% 50% 0;transform:rotate(-45deg);
                    border:3px solid white;box-shadow:0 3px 14px rgba(124,58,237,.5);
                    display:flex;align-items:center;justify-content:center;">
                    <span style="transform:rotate(45deg);font-size:15px;">📅</span>
               </div>`,
        iconSize: [36, 36], iconAnchor: [18, 36], popupAnchor: [0, -40],
    });
    const marker = L.marker([initLat, initLng], { draggable: true, icon: icono }).addTo(map);
    marker.bindPopup('<span style="font-size:12px;font-weight:600;color:#6D28D9;">📍 Ubica aquí el evento</span>').openPopup();

    /* ── Helpers ────────────────────────────────────────────── */
    function aplicarCoordenadas(lat, lng, zoom) {
        latInput.value = lat.toFixed(8);
        lngInput.value = lng.toFixed(8);
        latInput.classList.remove('border-red-300','bg-red-50');
        lngInput.classList.remove('border-red-300','bg-red-50');
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], zoom || map.getZoom(), { animate: true });
        marker.openPopup();
    }

    function debounce(fn, delay) {
        let t; return function(...a){ clearTimeout(t); t = setTimeout(()=>fn.apply(this,a), delay); };
    }

    /* ── Feedback geocoding ─────────────────────────────────── */
    function geoSet(state, text) {
        geoIcon.classList.remove('hidden');
        geoMsgEl.classList.remove('hidden');
        if (state === 'loading') {
            geoIcon.innerHTML = `<svg style="width:16px;height:16px;animation:geo-spin .8s linear infinite;color:#7c3aed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>`;
            geoText.style.color = '#6D28D9'; geoText.textContent = 'Buscando ubicación…';
        } else if (state === 'ok') {
            geoIcon.innerHTML = `<svg style="width:16px;height:16px;color:#16A34A" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`;
            geoText.style.color = '#16A34A'; geoText.textContent = '✓ ' + (text || 'Ubicación encontrada');
        } else {
            geoIcon.innerHTML = `<svg style="width:16px;height:16px;color:#DC2626" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
            geoText.style.color = '#DC2626'; geoText.textContent = text || 'No se encontró la dirección';
        }
    }
    function geoHide() { geoIcon.classList.add('hidden'); geoMsgEl.classList.add('hidden'); }

    /* ── Forward geocoding ──────────────────────────────────── */
    async function geocodificarDireccion(query) {
        if (!query || query.trim().length < 5) { geoHide(); return; }
        geoSet('loading');
        try {
            const res = await fetch(GEOCODE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ address: query.trim(), municipality: 'Neiva', department: 'Huila' }),
            });
            const data = await res.json();
            if (!data.success) { geoSet('error', data.message || 'No se encontró la dirección.'); return; }
            aplicarCoordenadas(data.lat, data.lng, 17);
            const precision = { exact: '✓ Alta precisión', interpolated: '~ Precisión media', center: '◎ Área aproximada', approximate: '⚠ Baja precisión' }[data.precision] || '';
            geoSet('ok', precision + ' — ' + (data.formatted || '').split(',').slice(0,3).join(','));
        } catch { geoSet('error', 'Error de conexión. Intenta de nuevo.'); }
    }

    /* ── Reverse geocoding ──────────────────────────────────── */
    async function reverseGeocodificar(lat, lng) {
        try {
            const res = await fetch(GEOCODE_REVERSE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ lat, lng }),
            });
            const data = await res.json();
            if (!data.success) return;
            const texto = [data.route, data.street_number, data.neighborhood].filter(Boolean).join(', ');
            if (texto) {
                dirInput.removeEventListener('input', debouncedGeo);
                dirInput.value = texto;
                dirInput.addEventListener('input', debouncedGeo);
                geoSet('ok', 'Dirección actualizada desde el mapa');
            }
        } catch { /* silencioso */ }
    }

    /* ── Eventos mapa ───────────────────────────────────────── */
    marker.on('dragend', function(e){ const {lat,lng}=e.target.getLatLng(); aplicarCoordenadas(lat,lng); reverseGeocodificar(lat,lng); });
    map.on('click', function(e){ const {lat,lng}=e.latlng; aplicarCoordenadas(lat,lng); reverseGeocodificar(lat,lng); });

    /* ── Eventos campo dirección ────────────────────────────── */
    const debouncedGeo = debounce(function(){ geocodificarDireccion(dirInput.value); }, DEBOUNCE_MS);
    dirInput.addEventListener('input', debouncedGeo);
    dirInput.addEventListener('blur', function(){ if(this.value.trim().length>=5) geocodificarDireccion(this.value); });

    /* ── Funciones públicas ─────────────────────────────────── */
    window.sincronizarCoords = function() {
        const lat = parseFloat(latInput.value), lng = parseFloat(lngInput.value);
        if (!isNaN(lat)&&!isNaN(lng)&&lat>=-90&&lat<=90&&lng>=-180&&lng<=180) {
            marker.setLatLng([lat,lng]); map.setView([lat,lng],map.getZoom(),{animate:true}); marker.openPopup();
        }
    };
    window.centrarEnNeiva = function() { map.flyTo(NEIVA, 14, {duration:1}); };

    /* ── Al seleccionar iglesia, centrar en sus coords ──────── */
    const iglesiaSelect = document.getElementById('iglesia_id');
    function volarAIglesia(opt) {
        const lat = parseFloat(opt.dataset.lat), lng = parseFloat(opt.dataset.lng);
        if (!isNaN(lat)&&!isNaN(lng)&&lat!==0&&lng!==0) {
            map.flyTo([lat,lng],16,{duration:1.2}); marker.setLatLng([lat,lng]).openPopup();
            latInput.value=lat.toFixed(8); lngInput.value=lng.toFixed(8);
            const addr = opt.dataset.address||'';
            if(addr&&!dirInput.value.trim()){ dirInput.removeEventListener('input',debouncedGeo); dirInput.value=addr; dirInput.addEventListener('input',debouncedGeo); }
            geoSet('ok','Ubicación de la iglesia seleccionada');
        }
    }
    if (iglesiaSelect) {
        iglesiaSelect.addEventListener('change', function(){ volarAIglesia(this.options[this.selectedIndex]); });
        if (iglesiaSelect.value) {
            const opt = iglesiaSelect.options[iglesiaSelect.selectedIndex];
            const eventoLat = parseFloat(latInput.value), eventoLng = parseFloat(lngInput.value);
            if (eventoLat===2.9274&&eventoLng===-75.2819) volarAIglesia(opt);
        }
    }

    setTimeout(()=>map.invalidateSize(), 300);
})();

/* ── Estado preview ─────────────────────────────────────────── */
window.actualizarEstadoPreview = function(valor) {
    const preview = document.getElementById('estado-preview');
    const dot     = document.getElementById('estado-dot');
    const label   = document.getElementById('estado-label');
    if (valor==='activo') {
        preview.style.cssText = 'background:#F0FDF4;color:#166534;';
        dot.className = 'w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse';
        label.textContent = 'Visible';
    } else {
        preview.style.cssText = 'background:#FFF1F2;color:#9F1239;';
        dot.className = 'w-1.5 h-1.5 rounded-full bg-red-400';
        label.textContent = 'Oculto';
    }
};

/* ── Contador descripción ───────────────────────────────────── */
window.actualizarContadorDesc = function(el) {
    var counter = document.getElementById('desc-counter');
    if (counter) counter.textContent = el.value.length + ' / 2000';
};
</script>
@endpush