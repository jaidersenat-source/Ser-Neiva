{{-- ══════════════════════════════════════════════════════════
     _form.blade.php — Parcial compartido por create y edit
     Variables esperadas:
       $venue → instancia de SportsVenue (nueva o existente)
══════════════════════════════════════════════════════════ --}}

@php
    $inp  = 'w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-orange-400 focus:ring-orange-100 transition-all';
    $inpE = 'w-full px-4 py-2.5 text-sm rounded-xl border border-red-300 bg-red-50 text-slate-800 placeholder-red-300 focus:outline-none focus:ring-2 focus:border-red-400 focus:ring-red-100 transition-all';
    $lbl  = 'block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5';
    $req  = '<span class="text-red-500 ml-0.5">*</span>';
@endphp

{{-- ── SECCIÓN 1: Información del Escenario ── --}}
<div id="seccion-1" class="scroll-mt-20 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">

    {{-- Header de sección --}}
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #FFF7ED, #FFEDD5);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #7c2d12, #ea580c);">
            1
        </div>
        <div>
            <p class="text-sm font-bold text-slate-800">Información del Escenario</p>
            <p class="text-xs text-slate-400 mt-0.5">Nombre, dirección, coordenadas y contacto</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Nombre --}}
        <div>
            <label for="name" class="{{ $lbl }}">
                Nombre {!! $req !!}
            </label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $venue->name ?? '') }}"
                   class="{{ $errors->has('name') ? $inpE : $inp }}"
                   placeholder="Ej: Cancha Villa Olímpica"
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

        {{-- Dirección --}}
        <div>
            <label for="address" class="{{ $lbl }}">
                Dirección {!! $req !!}
            </label>
            <div class="relative">
                <input type="text" id="address" name="address"
                       value="{{ old('address', $venue->address ?? '') }}"
                       class="{{ $errors->has('address') ? $inpE : $inp }} pr-10"
                       placeholder="Ej: Cra 5 # 10-20, Neiva"
                       maxlength="255" autocomplete="off">
                {{-- Estados geocodificación --}}
                <span id="geo-spinner" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                    <svg class="w-4 h-4 animate-spin text-orange-500" fill="none" viewBox="0 0 24 24">
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
            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Al escribir la dirección, la latitud y longitud se completarán automáticamente.
            </p>
            @error('address')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Latitud + Longitud --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="latitude" class="{{ $lbl }}">
                    Latitud {!! $req !!}
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-300 pointer-events-none">
                        LAT
                    </span>
                    <input type="number" id="latitude" name="latitude" step="any"
                           value="{{ old('latitude', $venue->latitude ?? '') }}"
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
                <label for="longitude" class="{{ $lbl }}">
                    Longitud {!! $req !!}
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-300 pointer-events-none">
                        LNG
                    </span>
                    <input type="number" id="longitude" name="longitude" step="any"
                           value="{{ old('longitude', $venue->longitude ?? '') }}"
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

        {{-- Contacto --}}
        <div>
            <label for="contact" class="{{ $lbl }}">Contacto</label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </span>
                <input type="text" id="contact" name="contact"
                       value="{{ old('contact', $venue->contact ?? '') }}"
                       class="{{ $inp }} pl-10"
                       placeholder="Ej: 3000000000"
                       maxlength="100" autocomplete="off">
            </div>
        </div>

        {{-- Imagen del escenario (opcional) --}}
        <div>
            <label for="imagen_principal" class="{{ $lbl }}">Imagen del escenario</label>
            <div class="flex items-center gap-3">
                <input type="file" id="imagen_principal" name="imagen_principal" accept="image/*" class="text-sm">
                <button type="button" id="btn-remove-image" class="text-xs text-red-500 hidden">Quitar</button>
            </div>
            <p class="text-xs text-slate-400 mt-1.5">Sube una imagen representativa del escenario (opcional). Tamaño máximo recomendado 2MB.</p>

            @if(isset($venue) && ($venue->imagen_principal ?? $venue->image ?? false))
                <div id="image-preview" class="mt-3 w-40 h-28 overflow-hidden rounded-lg border border-slate-200">
                    <img src="{{ asset('storage/' . ($venue->imagen_principal ?? $venue->image)) }}" alt="Imagen" class="w-full h-full object-cover">
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

        {{-- Disponible para iglesias --}}
        <div class="pt-1">
            <label for="available_for_churches"
                   class="flex items-start gap-3 p-4 rounded-xl cursor-pointer transition-all
                          border border-slate-100 hover:border-orange-200 hover:bg-orange-50/40
                          has-[:checked]:border-orange-300 has-[:checked]:bg-orange-50/60 group">
                <input type="hidden" name="available_for_churches" value="0">
                <div class="relative flex-shrink-0 mt-0.5">
                    <input type="checkbox" id="available_for_churches"
                           name="available_for_churches" value="1"
                           class="sr-only peer"
                           {{ old('available_for_churches', $venue->available_for_churches ?? false) ? 'checked' : '' }}>
                    <div class="w-10 h-6 rounded-full border-2 border-slate-200 bg-slate-100
                                peer-checked:border-orange-500 peer-checked:bg-orange-500 transition-all">
                    </div>
                    <div class="absolute top-1 left-1 w-4 h-4 rounded-full bg-white shadow
                                transition-all peer-checked:translate-x-4">
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700 leading-tight">
                        Disponible para iglesias
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">
                        Marcar si este escenario puede ser usado por iglesias para actividades gratuitas.
                    </p>
                </div>
            </label>
        </div>

    </div>
</div>

@push('scripts')
<script>
(function () {
    var addressInput = document.getElementById('address');
    var latInput     = document.getElementById('latitude');
    var lngInput     = document.getElementById('longitude');
    var spinner      = document.getElementById('geo-spinner');
    var okIcon       = document.getElementById('geo-ok');
    var errIcon      = document.getElementById('geo-err');

    var debounceTimer = null;

    function setGeoState(state) {
        spinner.classList.add('hidden');
        okIcon.classList.add('hidden');
        errIcon.classList.add('hidden');
        if (state === 'loading') spinner.classList.remove('hidden');
        if (state === 'ok')      okIcon.classList.remove('hidden');
        if (state === 'error')   errIcon.classList.remove('hidden');
    }

    const GEOCODE_URL = '/api/geocode';

    async function geocode(query) {
        try {
            const res = await fetch(GEOCODE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ address: query + ', Neiva, Huila, Colombia', municipality: 'Neiva', department: 'Huila' }),
            });
            const data = await res.json();
            if (data && data.success) {
                latInput.value = parseFloat(data.lat).toFixed(7);
                lngInput.value = parseFloat(data.lng).toFixed(7);
                setGeoState('ok');
            } else {
                setGeoState('error');
            }
        } catch { setGeoState('error'); }
    }

    if (addressInput) {
        addressInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            var val = this.value.trim();
            if (val.length < 5) { setGeoState(null); return; }
            setGeoState('loading');
            debounceTimer = setTimeout(function(){ geocode(val); }, 900);
        });
    }

    // Toggle visual del switch
    var checkbox = document.getElementById('available_for_churches');
    if (checkbox) {
        checkbox.addEventListener('change', function() {
            var dot = this.closest('label').querySelector('.absolute.top-1.left-1');
            // La animación CSS peer-checked:translate-x-4 lo maneja solo
        });
    }
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