{{-- ═══════════════════════════════════════════════════════════
     _form.blade.php  –  Parcial compartido por create y edit
     Variables esperadas:
       $iglesia        → instancia de Iglesia (nueva o existente)
       $ayudas         → Collection<Ayuda> (todas disponibles)
       $ayudasActuales → array de IDs ya asociados (en edit)
═══════════════════════════════════════════════════════════ --}}

@vite(['resources/css/admin/iglesias/form.css'])

{{-- ═══════════════════════════════════
     SECCIÓN 1 – Información básica
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">1</div>
        <div>
            <p class="section-title">Información básica</p>
            <p class="section-sub">Nombre, denominación y datos institucionales</p>
        </div>
    </div>
    <div class="form-section-body">

        {{-- Nombre --}}
        <div class="field-group">
            <label class="field-label" for="nombre">Nombre de la Iglesia <span class="field-required">*</span></label>
            <input type="text" id="nombre" name="nombre"
                   value="{{ old('nombre', $iglesia->nombre ?? '') }}"
                   class="field-input {{ $errors->has('nombre') ? 'error' : '' }}"
                   placeholder="Ej: Parroquia San Agustín de Hipona"
                   maxlength="200" autocomplete="off">
            @error('nombre')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
        </div>

        {{-- Denominación + Estado --}}
        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="denominacion">Denominación <span class="field-required">*</span></label>
                <input type="text" id="denominacion" name="denominacion"
                       value="{{ old('denominacion', $iglesia->denominacion ?? '') }}"
                       class="field-input {{ $errors->has('denominacion') ? 'error' : '' }}"
                       list="denominaciones-list" placeholder="Ej: Católica, Evangélica..." maxlength="150" autocomplete="off">
                <datalist id="denominaciones-list">
                    <option value="Católica"><option value="Cristiana Evangélica"><option value="Adventista">
                    <option value="Pentecostal"><option value="Bautista"><option value="Luterana">
                    <option value="Presbiteriana"><option value="Metodista"><option value="Anglicana">
                </datalist>
                @error('denominacion')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="estado">
                    Estado <span class="field-required">*</span>
                    <span id="estado-preview"
                          class="estado-preview {{ old('estado', $iglesia->estado ?? 'activo') === 'activo' ? 'activo' : 'inactivo' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ old('estado', $iglesia->estado ?? 'activo') === 'activo' ? 'bg-green-500' : 'bg-red-400' }}" id="estado-dot"></span>
                        <span id="estado-label">{{ old('estado', $iglesia->estado ?? 'activo') === 'activo' ? 'Visible' : 'Oculta' }}</span>
                    </span>
                </label>
                <select id="estado" name="estado" class="field-input" onchange="actualizarEstadoPreview(this.value)">
                    <option value="activo"   {{ old('estado', $iglesia->estado ?? 'activo') === 'activo'   ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado', $iglesia->estado ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>

        {{-- ─── Dirección con geocodificación automática ─── --}}
        <div class="field-group">
            <label class="field-label" for="direccion">
                Dirección <span class="field-required">*</span>
            </label>

            {{-- Wrapper posición relativa para el spinner y el estado --}}
            <div style="position:relative;">
                <input type="text" id="direccion" name="direccion"
                       value="{{ old('direccion', $iglesia->direccion ?? '') }}"
                       class="field-input {{ $errors->has('direccion') ? 'error' : '' }}"
                       placeholder="Ej: Calle 8 # 4-37, Centro, Neiva"
                       maxlength="255"
                       autocomplete="off">

                {{-- Icono estado geocodificación (spinner / ok / error) --}}
                <span id="geo-status-icon"
                      style="position:absolute;right:10px;top:50%;transform:translateY(-50%);display:none;pointer-events:none;">
                </span>
            </div>

            {{-- Mensaje de estado debajo del campo --}}
            <p id="geo-status-msg" style="margin-top:4px;font-size:.75rem;display:none;"></p>

            @error('direccion')
                <p class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Comuna + Corregimiento --}}
        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="comuna">Comuna</label>
                <input type="text" id="comuna" name="comuna"
                       value="{{ old('comuna', $iglesia->comuna ?? '') }}"
                       class="field-input" list="comunas-list" placeholder="Ej: Comuna 1">
                <datalist id="comunas-list">
                    @for($i = 1; $i <= 12; $i++)<option value="Comuna {{ $i }}">@endfor
                </datalist>
            </div>
            <div class="field-group">
                <label class="field-label" for="corregimiento">Corregimiento</label>
                <input type="text" id="corregimiento" name="corregimiento"
                       value="{{ old('corregimiento', $iglesia->corregimiento ?? '') }}"
                       class="field-input" placeholder="Ej: San Luis, Fortalecillas...">
            </div>
        </div>

        {{-- Celular institucional + Correo institucional --}}
        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="celular_institucional">Celular institucional</label>
                <div class="field-icon-wrap">
                    <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <input type="tel" id="celular_institucional" name="celular_institucional"
                           value="{{ old('celular_institucional', $iglesia->celular_institucional ?? '') }}"
                           class="field-input"
                           placeholder="315 123 4567" maxlength="20">
                </div>
                @error('celular_institucional')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="correo_institucional">Correo institucional</label>
                <div class="field-icon-wrap">
                    <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input type="email" id="correo_institucional" name="correo_institucional"
                           value="{{ old('correo_institucional', $iglesia->correo_institucional ?? '') }}"
                           class="field-input {{ $errors->has('correo_institucional') ? 'error' : '' }}"
                           placeholder="info@iglesia.org" maxlength="150">
                </div>
                @error('correo_institucional')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Entidad registrada + Promedio asistentes --}}
        <div class="grid-2">
            <div class="field-group">
                <label class="field-label">
                    Entidad registrada en Colombia <span class="field-required">*</span>
                </label>
                @php $entidadActual = old('entidad_registrada_colombia', $iglesia->entidad_registrada_colombia ?? 'NO'); @endphp
                <div class="entidad-group">
                    @foreach(\App\Models\Iglesia::ENTIDAD_OPCIONES as $valor => $etiqueta)
                        @php
                            $selCss = match($valor) {
                                'SI'         => 'sel-si',
                                'NO'         => 'sel-no',
                                'EN_PROCESO' => 'sel-proceso',
                            };
                            $activo = $entidadActual === $valor;
                        @endphp
                        <label class="entidad-radio {{ $activo ? $selCss : '' }}"
                               for="entidad_{{ $valor }}"
                               onclick="activarEntidad(this, '{{ $selCss }}')">
                            <input type="radio"
                                   id="entidad_{{ $valor }}"
                                   name="entidad_registrada_colombia"
                                   value="{{ $valor }}"
                                   class="sr-only"
                                   {{ $activo ? 'checked' : '' }}>
                            <span class="entidad-radio-dot"></span>
                            <span class="entidad-radio-txt">{{ $etiqueta }}</span>
                        </label>
                    @endforeach
                </div>
                @error('entidad_registrada_colombia')
                    <p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="promedio_asistentes">
                    Promedio de asistentes
                    <span class="label-hint">por servicio</span>
                </label>
                <div class="field-icon-wrap">
                    <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <input type="number" id="promedio_asistentes" name="promedio_asistentes"
                           value="{{ old('promedio_asistentes', $iglesia->promedio_asistentes ?? '') }}"
                           class="field-input {{ $errors->has('promedio_asistentes') ? 'error' : '' }}"
                           placeholder="Ej: 150" min="0" max="999999" step="1">
                </div>
                <p class="field-hint">Número aproximado de personas que asisten regularmente</p>
                @error('promedio_asistentes')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 2 – Contacto y responsable
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">2</div>
        <div>
            <p class="section-title">Contacto y responsable</p>
            <p class="section-sub">Pastor, sacerdote o líder a cargo</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="grid-3">
            <div class="field-group">
                <label class="field-label" for="pastor_sacerdote">Pastor / Sacerdote / Líder</label>
                <input type="text" id="pastor_sacerdote" name="pastor_sacerdote"
                       value="{{ old('pastor_sacerdote', $iglesia->pastor_sacerdote ?? '') }}"
                       class="field-input" placeholder="Nombre completo" maxlength="150">
            </div>

            <div class="field-group">
                <label class="field-label" for="fecha_nacimiento_lider">
                    Fecha de nacimiento
                    @if(isset($iglesia->fecha_nacimiento_lider) && $iglesia->fecha_nacimiento_lider)
                        <span class="label-hint">· {{ $iglesia->edad_lider }} años</span>
                    @endif
                </label>
                <input type="date" id="fecha_nacimiento_lider" name="fecha_nacimiento_lider"
                       value="{{ old('fecha_nacimiento_lider', isset($iglesia->fecha_nacimiento_lider) && $iglesia->fecha_nacimiento_lider
                           ? $iglesia->fecha_nacimiento_lider->format('Y-m-d')
                           : '') }}"
                       class="field-input {{ $errors->has('fecha_nacimiento_lider') ? 'error' : '' }}"
                       max="{{ now()->subDay()->format('Y-m-d') }}"
                       min="1900-01-01">
                @error('fecha_nacimiento_lider')
                    <p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                @enderror
                <p class="edad-badge" id="edad-badge">
                    🎂 <span id="edad-valor"></span> años
                </p>
            </div>

            <div class="field-group">
                <label class="field-label" for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono"
                       value="{{ old('telefono', $iglesia->telefono ?? '') }}"
                       class="field-input" placeholder="311 456 7890" maxlength="20">
            </div>
        </div>

        <div class="field-group">
            <label class="field-label" for="email">Correo electrónico de contacto</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $iglesia->email ?? '') }}"
                   class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                   placeholder="iglesia@ejemplo.com" maxlength="150">
            @error('email')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
        </div>

        <div class="field-group">
            <label class="field-label" for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="field-input"
                      placeholder="Breve reseña de la congregación..." maxlength="2000" rows="3">{{ old('descripcion', $iglesia->descripcion ?? '') }}</textarea>
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 3 – Ayudas Sociales
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">3</div>
        <div style="flex:1;">
            <p class="section-title">Ayudas Sociales</p>
            <p class="section-sub">Selecciona los programas de ayuda que ofrece esta iglesia</p>
        </div>
        @if($ayudas->count() > 0)
            <button type="button" class="ayudas-toggle-all" onclick="toggleTodasAyudas()" id="btn-toggle-ayudas">
                Seleccionar todas
            </button>
        @endif
    </div>
    <div class="form-section-body">

        @if($errors->has('ayudas') || $errors->has('ayudas.*'))
            <p class="field-error mb-3">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $errors->first('ayudas') ?: $errors->first('ayudas.*') }}
            </p>
        @endif

        @if($ayudas->isEmpty())
            <div class="flex items-center gap-3 bg-slate-50 rounded-xl p-4 text-sm text-slate-500">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                No hay ayudas registradas. Corre el seeder:
                <code class="bg-slate-100 px-2 py-0.5 rounded text-xs ml-1">php artisan db:seed --class=AyudaSeeder</code>
            </div>
        @else
            <div class="ayudas-grid" id="ayudas-grid">
                @php
                    $seleccionadas = old('ayudas', isset($ayudasActuales) ? $ayudasActuales : []);
                @endphp

                @foreach($ayudas as $ayuda)
                    @php $checked = in_array($ayuda->id, (array)$seleccionadas); @endphp
                    <label class="ayuda-checkbox-label {{ $checked ? 'checked' : '' }}"
                           for="ayuda_{{ $ayuda->id }}"
                           onclick="toggleAyudaLabel(this)">
                        <input type="checkbox"
                               id="ayuda_{{ $ayuda->id }}"
                               name="ayudas[]"
                               value="{{ $ayuda->id }}"
                               class="ayuda-check"
                               {{ $checked ? 'checked' : '' }}>
                        <span class="ayuda-icono">{{ $ayuda->icono ?? '🤝' }}</span>
                        <div style="min-width:0;">
                            <p class="ayuda-nombre">{{ $ayuda->nombre }}</p>
                            @if($ayuda->descripcion)
                                <p class="ayuda-desc truncate">{{ Str::limit($ayuda->descripcion, 50) }}</p>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <p class="field-hint mt-3" id="ayudas-contador">
                <span id="num-seleccionadas">{{ count((array)$seleccionadas) }}</span> ayuda(s) seleccionada(s)
            </p>
        @endif
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
            <p class="section-sub">Ubica la iglesia en el mapa de Neiva</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="map-tip">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>
                <strong>Haz clic en el mapa</strong> para establecer la ubicación, arrastra el marcador,
                o <strong>escribe la dirección arriba</strong> para geocodificar automáticamente.
            </span>
        </div>

        <div class="coords-grid">
            <div class="field-group" style="margin-bottom:0;">
                <label class="field-label" for="latitud">Latitud <span class="field-required">*</span></label>
                <input type="number" id="latitud" name="latitud"
                       value="{{ old('latitud', $iglesia->latitud ?? '2.9274') }}"
                       class="field-input {{ $errors->has('latitud') ? 'error' : '' }}"
                       step="0.00000001" min="-90" max="90" placeholder="2.9274" oninput="sincronizarCoords()">
                @error('latitud')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
            <div class="field-group" style="margin-bottom:0;">
                <label class="field-label" for="longitud">Longitud <span class="field-required">*</span></label>
                <input type="number" id="longitud" name="longitud"
                       value="{{ old('longitud', $iglesia->longitud ?? '-75.2819') }}"
                       class="field-input {{ $errors->has('longitud') ? 'error' : '' }}"
                       step="0.00000001" min="-180" max="180" placeholder="-75.2819" oninput="sincronizarCoords()">
                @error('longitud')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

        <div id="map-selector" aria-label="Mapa selector de ubicación"></div>

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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/**
 * ════════════════════════════════════════════════════════════════
 *  MAPA + GEOCODIFICACIÓN AUTOMÁTICA
 *  - Forward geocoding: dirección → lat/lng  (Nominatim OSM)
 *  - Reverse geocoding: lat/lng → dirección  (cuando se mueve marcador)
 *  - Debounce 600ms en el campo dirección
 * ════════════════════════════════════════════════════════════════
 */
(function () {

    /* ── Constantes ─────────────────────────────────────────── */
    const NEIVA       = [2.9274, -75.2819];
    const NOMINATIM   = 'https://nominatim.openstreetmap.org';
    const DEBOUNCE_MS = 600;

    /* ── Referencias DOM ────────────────────────────────────── */
    const latInput    = document.getElementById('latitud');
    const lngInput    = document.getElementById('longitud');
    const dirInput    = document.getElementById('direccion');
    const geoIcon     = document.getElementById('geo-status-icon');
    const geoMsg      = document.getElementById('geo-status-msg');

    /* ── Estado inicial del mapa ────────────────────────────── */
    const initLat = parseFloat(latInput.value) || NEIVA[0];
    const initLng = parseFloat(lngInput.value) || NEIVA[1];

    /* ── Inicializar Leaflet ─────────────────────────────────── */
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
        maxZoom: 19,
    }).addTo(map);

    /* ── Icono personalizado (cruz) ─────────────────────────── */
    const icono = L.divIcon({
        className: '',
        html: `<div style="
                    width:34px;height:34px;
                    background:#1E3A8A;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    border:3px solid white;
                    box-shadow:0 3px 12px rgba(30,58,138,.5);
                    display:flex;align-items:center;justify-content:center;">
                    <span style="transform:rotate(45deg);color:white;font-size:13px;font-weight:900;">✝</span>
               </div>`,
        iconSize  : [34, 34],
        iconAnchor: [17, 34],
        popupAnchor: [0, -38],
    });

    const marker = L.marker([initLat, initLng], { draggable: true, icon: icono }).addTo(map);
    marker.bindPopup('<span style="font-size:12px;font-weight:600;color:#1E3A8A;">📍 Ubica aquí la iglesia</span>').openPopup();

    /* ── Helpers de estado GEO ──────────────────────────────── */
    function geoSetBuscando() {
        geoIcon.style.display = 'inline';
        geoIcon.innerHTML     = `<svg style="width:16px;height:16px;animation:spin .8s linear infinite;color:#3B82F6"
                                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                      <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4
                                               M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                                  </svg>`;
        geoMsg.style.display  = 'block';
        geoMsg.style.color    = '#3B82F6';
        geoMsg.textContent    = 'Buscando ubicación...';
    }

    function geoSetOk(displayName) {
        geoIcon.style.display = 'inline';
        geoIcon.innerHTML     = `<svg style="width:16px;height:16px;color:#16A34A" viewBox="0 0 24 24"
                                      fill="none" stroke="currentColor" stroke-width="2.5">
                                      <polyline points="20 6 9 17 4 12"/>
                                  </svg>`;
        geoMsg.style.display  = 'block';
        geoMsg.style.color    = '#16A34A';
        geoMsg.textContent    = '✓ ' + displayName;
    }

    function geoSetError(msg) {
        geoIcon.style.display = 'inline';
        geoIcon.innerHTML     = `<svg style="width:16px;height:16px;color:#DC2626" viewBox="0 0 24 24"
                                      fill="none" stroke="currentColor" stroke-width="2">
                                      <circle cx="12" cy="12" r="10"/>
                                      <line x1="12" y1="8" x2="12" y2="12"/>
                                      <line x1="12" y1="16" x2="12.01" y2="16"/>
                                  </svg>`;
        geoMsg.style.display  = 'block';
        geoMsg.style.color    = '#DC2626';
        geoMsg.textContent    = msg;
    }

    function geoSetIdle() {
        geoIcon.style.display = 'none';
        geoMsg.style.display  = 'none';
        geoMsg.textContent    = '';
    }

    /* ── Actualizar inputs lat/lng y mover el mapa ──────────── */
    function aplicarCoordenadas(lat, lng, zoom) {
        latInput.value = lat.toFixed(8);
        lngInput.value = lng.toFixed(8);
        latInput.classList.remove('error');
        lngInput.classList.remove('error');
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], zoom || map.getZoom());
        marker.openPopup();
    }

    /* ── Debounce ────────────────────────────────────────────── */
    function debounce(fn, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    /* ── Forward Geocoding: dirección → lat/lng ─────────────── */
    async function geocodificarDireccion(query) {
        if (!query || query.trim().length < 5) {
            geoSetIdle();
            return;
        }

        geoSetBuscando();

        // Añadir "Neiva, Huila, Colombia" como contexto para mejorar precisión
        const queryCompleta = query.trim() + ', Neiva, Huila, Colombia';

        const url = new URL(NOMINATIM + '/search');
        url.searchParams.set('q',               queryCompleta);
        url.searchParams.set('format',          'json');
        url.searchParams.set('limit',           '1');
        url.searchParams.set('countrycodes',    'co');
        url.searchParams.set('addressdetails',  '1');
        url.searchParams.set('accept-language', 'es');

        try {
            const res = await fetch(url.toString(), {
                headers: { 'Accept': 'application/json' }
            });

            if (!res.ok) throw new Error('Error de red: ' + res.status);

            const data = await res.json();

            if (!data || data.length === 0) {
                geoSetError('No se encontró la dirección. Intenta con más detalles.');
                return;
            }

            const lugar = data[0];
            const lat   = parseFloat(lugar.lat);
            const lng   = parseFloat(lugar.lon);

            aplicarCoordenadas(lat, lng, 17);

            // Mostrar nombre resumido del resultado
            const nombre = lugar.display_name
                ? lugar.display_name.split(',').slice(0, 3).join(',')
                : 'Ubicación encontrada';

            geoSetOk(nombre);

        } catch (err) {
            console.error('[Geocoding]', err);
            geoSetError('Error al buscar la dirección. Intenta de nuevo.');
        }
    }

    /* ── Reverse Geocoding: lat/lng → dirección ─────────────── */
    async function reverseGeocodificar(lat, lng) {
        const url = new URL(NOMINATIM + '/reverse');
        url.searchParams.set('lat',             lat.toFixed(8));
        url.searchParams.set('lon',             lng.toFixed(8));
        url.searchParams.set('format',          'json');
        url.searchParams.set('accept-language', 'es');

        try {
            const res  = await fetch(url.toString(), {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data && data.address) {
                // Construir una dirección legible
                const a       = data.address;
                const partes  = [
                    a.road || a.pedestrian || a.path || '',
                    a.house_number || '',
                    a.suburb || a.neighbourhood || a.quarter || '',
                ].filter(Boolean);

                const nuevaDireccion = partes.join(', ');

                if (nuevaDireccion) {
                    // Actualizar campo dirección sin disparar el debounce
                    dirInput.removeEventListener('input', debouncedGeocodificar);
                    dirInput.value = nuevaDireccion;
                    dirInput.addEventListener('input', debouncedGeocodificar);

                    geoSetOk('Dirección actualizada desde el mapa');
                }
            }
        } catch (err) {
            console.warn('[Reverse Geocoding]', err);
            // Silencioso: el usuario ya ve las coords actualizadas
        }
    }

    /* ── Eventos del mapa ────────────────────────────────────── */

    // Drag del marcador → actualizar coords + reverse geocoding
    marker.on('dragend', function (e) {
        const { lat, lng } = e.target.getLatLng();
        aplicarCoordenadas(lat, lng);
        reverseGeocodificar(lat, lng);
    });

    // Clic en el mapa → mover marcador + reverse geocoding
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]).openPopup();
        aplicarCoordenadas(lat, lng);
        reverseGeocodificar(lat, lng);
    });

    /* ── Evento del campo Dirección ─────────────────────────── */
    const debouncedGeocodificar = debounce(function () {
        geocodificarDireccion(dirInput.value);
    }, DEBOUNCE_MS);

    dirInput.addEventListener('input', debouncedGeocodificar);

    // También al salir del campo (blur) si no se ha geocodificado
    dirInput.addEventListener('blur', function () {
        if (this.value.trim().length >= 5) {
            geocodificarDireccion(this.value);
        }
    });

    /* ── Funciones públicas (usadas en oninput del HTML) ─────── */
    window.sincronizarCoords = function () {
        const lat = parseFloat(latInput.value);
        const lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], map.getZoom());
        }
    };

    window.centrarEnNeiva = function () {
        map.flyTo(NEIVA, 14, { duration: 1 });
    };

    // Forzar rerender del mapa al aparecer (por si está en tab oculto)
    setTimeout(() => map.invalidateSize(), 300);

})();


/* ── Animación spinner ──────────────────────────────────────── */
(function injectSpinCSS() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg);   }
            to   { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
})();


/* ════════════════════════════════════════════════════════════════
   RESTO DE FUNCIONES DEL FORMULARIO (sin cambios)
════════════════════════════════════════════════════════════════ */

// ── Estado preview (select activo/inactivo) ───────────────────
window.actualizarEstadoPreview = function (valor) {
    const preview = document.getElementById('estado-preview');
    const dot     = document.getElementById('estado-dot');
    const lbl     = document.getElementById('estado-label');
    if (valor === 'activo') {
        preview.className = 'estado-preview activo';
        dot.className     = 'w-1.5 h-1.5 rounded-full bg-green-500';
        lbl.textContent   = 'Visible';
    } else {
        preview.className = 'estado-preview inactivo';
        dot.className     = 'w-1.5 h-1.5 rounded-full bg-red-400';
        lbl.textContent   = 'Oculta';
    }
};

// ── Entidad registrada (radio buttons visuales) ───────────────
window.activarEntidad = function (labelEl, selCss) {
    document.querySelectorAll('.entidad-radio').forEach(l => {
        l.classList.remove('sel-si', 'sel-no', 'sel-proceso');
    });
    setTimeout(() => labelEl.classList.add(selCss), 5);
};

// ── Fecha nacimiento líder → calcular edad ────────────────────
document.getElementById('fecha_nacimiento_lider')?.addEventListener('input', function () {
    const badge = document.getElementById('edad-badge');
    const span  = document.getElementById('edad-valor');
    if (!this.value) { badge.style.display = 'none'; return; }

    const hoy  = new Date(), nac = new Date(this.value);
    let edad   = hoy.getFullYear() - nac.getFullYear();
    const m    = hoy.getMonth() - nac.getMonth();
    if (m < 0 || (m === 0 && hoy.getDate() < nac.getDate())) edad--;

    if (edad >= 0 && edad < 130) {
        span.textContent    = edad;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
});

// ── Ayudas checkboxes ─────────────────────────────────────────
window.toggleAyudaLabel = function (label) {
    setTimeout(() => {
        const cb = label.querySelector('input[type="checkbox"]');
        label.classList.toggle('checked', cb.checked);
        actualizarContador();
    }, 10);
};

function actualizarContador() {
    const total = document.querySelectorAll('.ayuda-check:checked').length;
    const el    = document.getElementById('num-seleccionadas');
    if (el) el.textContent = total;
}

window.toggleTodasAyudas = function () {
    const checks = document.querySelectorAll('.ayuda-check');
    const btn    = document.getElementById('btn-toggle-ayudas');
    const todas  = [...checks].every(c => c.checked);
    checks.forEach(c => {
        c.checked = !todas;
        c.closest('.ayuda-checkbox-label').classList.toggle('checked', !todas);
    });
    btn.textContent = todas ? 'Seleccionar todas' : 'Deseleccionar todas';
    actualizarContador();
};
</script>
@endpush