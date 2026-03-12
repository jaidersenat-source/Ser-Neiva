{{-- ══════════════════════════════════════════════════════════
     _form.blade.php — Parcial compartido por create y edit
     Variables esperadas:
       $venue → instancia de SportsVenue (nueva o existente)
══════════════════════════════════════════════════════════ --}}

@vite(['resources/css/admin/iglesias/form.css'])

<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">1</div>
        <div>
            <p class="section-title">Información del Escenario</p>
            <p class="section-sub">Nombre, dirección, coordenadas y contacto</p>
        </div>
    </div>

    <div class="form-section-body">

        {{-- Nombre --}}
        <div class="field-group">
            <label class="field-label" for="name">
                Nombre <span class="field-required">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $venue->name ?? '') }}"
                   class="field-input {{ $errors->has('name') ? 'error' : '' }}"
                   placeholder="Ej: Cancha Villa Olímpica"
                   maxlength="200" autocomplete="off">
            @error('name')
                <p class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Dirección --}}
        <div class="field-group">
            <label class="field-label" for="address">
                Dirección <span class="field-required">*</span>
            </label>
            <div class="relative">
                <input type="text" id="address" name="address"
                       value="{{ old('address', $venue->address ?? '') }}"
                       class="field-input {{ $errors->has('address') ? 'error' : '' }}"
                       placeholder="Ej: Cra 5 # 10-20, Neiva"
                       maxlength="255" autocomplete="off">
                {{-- Indicador de geocodificación --}}
                <span id="geo-spinner"
                      class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4 animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                </span>
                <span id="geo-ok"
                      class="hidden absolute right-3 top-1/2 -translate-y-1/2
                             text-green-500 font-bold text-sm" title="Coordenadas encontradas">✓</span>
                <span id="geo-err"
                      class="hidden absolute right-3 top-1/2 -translate-y-1/2
                             text-red-400 text-xs font-semibold" title="No se encontraron coordenadas">?</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">
                Al escribir la dirección, la latitud y longitud se completarán automáticamente.
            </p>
            @error('address')
                <p class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Latitud + Longitud --}}
        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="latitude">
                    Latitud <span class="field-required">*</span>
                </label>
                <input type="number" id="latitude" name="latitude" step="any"
                       value="{{ old('latitude', $venue->latitude ?? '') }}"
                       class="field-input {{ $errors->has('latitude') ? 'error' : '' }}"
                       placeholder="Ej: 2.9274">
                @error('latitude')
                    <p class="field-error">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="longitude">
                    Longitud <span class="field-required">*</span>
                </label>
                <input type="number" id="longitude" name="longitude" step="any"
                       value="{{ old('longitude', $venue->longitude ?? '') }}"
                       class="field-input {{ $errors->has('longitude') ? 'error' : '' }}"
                       placeholder="Ej: -75.2819">
                @error('longitude')
                    <p class="field-error">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Contacto --}}
        <div class="field-group">
            <label class="field-label" for="contact">Contacto</label>
            <input type="text" id="contact" name="contact"
                   value="{{ old('contact', $venue->contact ?? '') }}"
                   class="field-input"
                   placeholder="Ej: 3000000000"
                   maxlength="100" autocomplete="off">
        </div>

        {{-- Disponible para iglesias --}}
        <div class="field-group">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="hidden" name="available_for_churches" value="0">
                <input type="checkbox" id="available_for_churches"
                       name="available_for_churches" value="1"
                       class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                       {{ old('available_for_churches', $venue->available_for_churches ?? false) ? 'checked' : '' }}>
                <span class="field-label mb-0">Disponible para iglesias</span>
            </label>
            <p class="text-xs text-slate-400 mt-1 ml-6">Marcar si este escenario puede ser usado por iglesias para actividades gratuitas.</p>
        </div>

    </div>
</div>

@push('scripts')
<script>
(function () {
    const addressInput = document.getElementById('address');
    const latInput     = document.getElementById('latitude');
    const lngInput     = document.getElementById('longitude');
    const spinner      = document.getElementById('geo-spinner');
    const okIcon       = document.getElementById('geo-ok');
    const errIcon      = document.getElementById('geo-err');

    let debounceTimer = null;

    function setGeoState(state) {
        spinner.classList.add('hidden');
        okIcon.classList.add('hidden');
        errIcon.classList.add('hidden');
        if (state === 'loading') spinner.classList.remove('hidden');
        if (state === 'ok')     okIcon.classList.remove('hidden');
        if (state === 'error')  errIcon.classList.remove('hidden');
    }

    async function geocode(query) {
        const url = 'https://nominatim.openstreetmap.org/search?'
            + new URLSearchParams({
                q:              query + ', Neiva, Huila, Colombia',
                format:         'json',
                limit:          '1',
                addressdetails: '0',
            });

        const res  = await fetch(url, {
            headers: { 'Accept-Language': 'es', 'User-Agent': 'SIRN-Neiva/1.0' },
        });
        const data = await res.json();

        if (data.length > 0) {
            latInput.value = parseFloat(data[0].lat).toFixed(7);
            lngInput.value = parseFloat(data[0].lon).toFixed(7);
            setGeoState('ok');
        } else {
            setGeoState('error');
        }
    }

    addressInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const val = this.value.trim();

        if (val.length < 5) {
            setGeoState(null);
            return;
        }

        setGeoState('loading');

        debounceTimer = setTimeout(() => geocode(val), 900);
    });
})();
</script>
@endpush
