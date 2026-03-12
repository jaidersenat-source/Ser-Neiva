{{-- ═══════════════════════════════════════════════════════════
     _form.blade.php  –  Parcial compartido por create y edit
     Variables esperadas:
       $iglesia        → instancia de Iglesia (nueva o existente)
       $ayudas         → Collection<Ayuda> (todas disponibles)
       $ayudasActuales → array de IDs ya asociados (en edit)
═══════════════════════════════════════════════════════════ --}}

@vite(['resources/css/admin/iglesias/form.css'])

{{-- ══════════════════════════════════════
     SECCIÓN 1 — INFORMACIÓN DE LA IGLESIA
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">1</div>
        <div>
            <p class="section-title">Información de la Iglesia</p>
            <p class="section-sub">Nombre oficial, denominación, estado y caracterización</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="field-group">
            <label class="field-label" for="official_name">Nombre oficial <span class="field-required">*</span></label>
            <input type="text" id="official_name" name="official_name"
                   value="{{ old('official_name', $iglesia->official_name ?? '') }}"
                   class="field-input {{ $errors->has('official_name') ? 'error' : '' }}"
                   placeholder="Ej: Parroquia Nuestra Señora de la Asunción"
                   maxlength="200" autocomplete="off">
            @error('official_name')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="denomination">Denominación <span class="field-required">*</span></label>
                <select id="denomination" name="denomination"
                        class="field-input {{ $errors->has('denomination') ? 'error' : '' }}">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Catholic' => 'Católica', 'Evangelical' => 'Evangélica', 'Pentecostal' => 'Pentecostal', 'Baptist' => 'Bautista', 'Other' => 'Otra'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('denomination', $iglesia->denomination ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
                @error('denomination')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
            <div class="field-group">
                <label class="field-label" for="confessional_character">Carácter confesional</label>
                <select id="confessional_character" name="confessional_character" class="field-input">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Christian' => 'Cristiana', 'Islamic' => 'Islámica', 'Jewish' => 'Judía', 'Other' => 'Otra'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('confessional_character', $iglesia->confessional_character ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="church_status">Estado <span class="field-required">*</span></label>
                <select id="church_status" name="church_status"
                        class="field-input {{ $errors->has('church_status') ? 'error' : '' }}">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Active' => 'Activa', 'Inactive' => 'Inactiva', 'Suspended' => 'Suspendida'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('church_status', $iglesia->church_status ?? 'Active') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
                @error('church_status')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
            <div class="field-group">
                <label class="field-label" for="foundation_date">Fecha de fundación</label>
                <input type="date" id="foundation_date" name="foundation_date"
                       value="{{ old('foundation_date', isset($iglesia->foundation_date) && $iglesia->foundation_date ? (is_string($iglesia->foundation_date) ? $iglesia->foundation_date : $iglesia->foundation_date->format('Y-m-d')) : '') }}"
                       class="field-input" max="{{ now()->format('Y-m-d') }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="specific_location">Ubicación específica</label>
                <input type="text" id="specific_location" name="specific_location"
                       value="{{ old('specific_location', $iglesia->specific_location ?? '') }}"
                       class="field-input" placeholder="Ej: Barrio Villa del Río, local 3">
            </div>
            <div class="field-group">
                <label class="field-label" for="approx_members">Miembros aproximados</label>
                <input type="number" id="approx_members" name="approx_members"
                       value="{{ old('approx_members', $iglesia->approx_members ?? '') }}"
                       class="field-input {{ $errors->has('approx_members') ? 'error' : '' }}"
                       placeholder="Ej: 250" min="0" max="999999" step="1">
                @error('approx_members')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── Fotografía ── --}}
        <div class="field-group mt-2">
            <label class="field-label" for="photo">Fotografía de la iglesia</label>

            {{-- Vista previa: foto actual (en editar) o placeholder (en crear) --}}
            <div class="flex items-start gap-4 mb-3">
                @if(isset($iglesia->photo) && $iglesia->photo)
                    <img id="foto-preview"
                         src="{{ Storage::url($iglesia->photo) }}"
                         alt="Foto actual"
                         class="w-28 h-28 object-cover rounded-xl border border-slate-200 shadow-sm flex-shrink-0">
                @else
                    <div id="foto-preview-wrap"
                         class="w-28 h-28 flex items-center justify-center bg-slate-50 rounded-xl border-2 border-dashed border-slate-200 flex-shrink-0">
                        <img id="foto-preview" src="" alt="" class="hidden w-full h-full object-cover rounded-xl">
                        <svg id="foto-placeholder-icon" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <input type="file" id="photo" name="photo"
                           accept="image/jpeg,image/png,image/webp"
                           class="field-input py-1.5 file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                                  file:text-xs file:font-semibold file:bg-blue-50 file:text-[#1E3A8A]
                                  hover:file:bg-blue-100 file:cursor-pointer cursor-pointer"
                           onchange="previsualizarFotoIglesia(this)">
                    <p class="text-xs text-slate-400 mt-1.5">JPG, PNG o WebP &middot; Máximo 2 MB</p>
                    @if(isset($iglesia->photo) && $iglesia->photo)
                        <p class="text-xs text-slate-500 mt-1">Sube una nueva imagen para reemplazar la actual.</p>
                    @endif
                </div>
            </div>

            @error('photo')
                <p class="field-error">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 2 — UBICACIÓN DE LA IGLESIA
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">2</div>
        <div>
            <p class="section-title">Ubicación de la Iglesia</p>
            <p class="section-sub">Dirección completa y datos geográficos</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="field-group">
            <label class="field-label" for="address">Dirección <span class="field-required">*</span></label>
            <div style="position:relative;">
                <input type="text" id="address" name="address"
                       value="{{ old('address', $iglesia->address ?? '') }}"
                       class="field-input {{ $errors->has('address') ? 'error' : '' }}"
                       placeholder="Ej: Calle 8 # 4-37, Centro, Neiva"
                       maxlength="255" autocomplete="off">
                <span id="geo-status-icon"
                      style="position:absolute;right:10px;top:50%;transform:translateY(-50%);display:none;pointer-events:none;"></span>
            </div>
            <p id="geo-status-msg" style="margin-top:4px;font-size:.75rem;display:none;"></p>
            @error('address')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="neighborhood">Barrio</label>
                <input type="text" id="neighborhood" name="neighborhood"
                       value="{{ old('neighborhood', $iglesia->neighborhood ?? '') }}"
                       class="field-input" placeholder="Ej: El Recreo">
            </div>
            <div class="field-group">
                <label class="field-label" for="comuna">Comuna</label>
                <input type="text" id="comuna" name="comuna"
                       value="{{ old('comuna', $iglesia->comuna ?? '') }}"
                       class="field-input" list="comunas-list" placeholder="Ej: Comuna 1">
                <datalist id="comunas-list">
                    @for($i = 1; $i <= 12; $i++)<option value="Comuna {{ $i }}">@endfor
                </datalist>
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="department">Departamento</label>
                <select id="department" name="department" class="field-input">
                    @foreach(['Huila' => 'Huila', 'Otro' => 'Otro'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('department', $iglesia->department ?? 'Huila') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field-group">
                <label class="field-label" for="municipality">Municipio</label>
                <select id="municipality" name="municipality" class="field-input">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Neiva','Pitalito','Garzón','La Plata','Rivera','Palermo','Campoalegre','Gigante','Algeciras','Acevedo','Aipe','Altamira','Baraya','Colombia','Elías','Hobo','Iquira','Isnos','La Argentina','Nátaga','Oporapa','Paicol','Palestina','Pital','Saladoblanco','San Agustín','Santa María','Suaza','Tarqui','Tello','Teruel','Tesalia','Timaía','Villavieja','Yaguárá','Otro'] as $mun)
                        <option value="{{ $mun }}" {{ old('municipality', $iglesia->municipality ?? '') === $mun ? 'selected' : '' }}>{{ $mun }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="city">Ciudad</label>
                <input type="text" id="city" name="city"
                       value="{{ old('city', $iglesia->city ?? 'Neiva') }}"
                       class="field-input" placeholder="Ej: Neiva">
            </div>
            <div class="field-group">
                <label class="field-label" for="country">País</label>
                <input type="text" id="country" name="country"
                       value="{{ old('country', $iglesia->country ?? 'Colombia') }}"
                       class="field-input" placeholder="Ej: Colombia" maxlength="80">
            </div>
        </div>

        {{-- country viene del grid-2 de arriba --}}

    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 3 — CONTACTO DE LA IGLESIA
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">3</div>
        <div>
            <p class="section-title">Contacto de la Iglesia</p>
            <p class="section-sub">Teléfonos, correo electrónico y redes sociales</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="phone_landline">Teléfono fijo</label>
                <input type="tel" id="phone_landline" name="phone_landline"
                       value="{{ old('phone_landline', $iglesia->phone_landline ?? '') }}"
                       class="field-input" placeholder="(8) 871 0000" maxlength="20">
            </div>
            <div class="field-group">
                <label class="field-label" for="phone_mobile">Teléfono móvil</label>
                <input type="tel" id="phone_mobile" name="phone_mobile"
                       value="{{ old('phone_mobile', $iglesia->phone_mobile ?? '') }}"
                       class="field-input" placeholder="315 123 4567" maxlength="20">
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="email">Correo electrónico</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $iglesia->email ?? '') }}"
                       class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                       placeholder="iglesia@ejemplo.org" maxlength="150">
                @error('email')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
            <div class="field-group">
                <label class="field-label" for="website_or_social">Sitio web o red social</label>
                <input type="text" id="website_or_social" name="website_or_social"
                       value="{{ old('website_or_social', $iglesia->website_or_social ?? '') }}"
                       class="field-input" placeholder="https://... o @usuario" maxlength="255">
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 4 — PASTOR / LÍDER PRINCIPAL
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">4</div>
        <div>
            <p class="section-title">Pastor o Líder Principal</p>
            <p class="section-sub">Datos del responsable pastoral de la congregación</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="field-group">
            <label class="field-label" for="pastor_full_name">Nombre completo</label>
            <input type="text" id="pastor_full_name" name="pastor_full_name"
                   value="{{ old('pastor_full_name', $iglesia->pastor_full_name ?? '') }}"
                   class="field-input" placeholder="Nombres y apellidos completos" maxlength="150">
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="pastor_document_type">Tipo de documento</label>
                <select id="pastor_document_type" name="pastor_document_type" class="field-input">
                    <option value="">— Seleccionar —</option>
                    @foreach(['CC' => 'Cédula de Ciudadanía', 'CE' => 'Cédula de Extranjería', 'Passport' => 'Pasaporte'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('pastor_document_type', $iglesia->pastor_document_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field-group">
                <label class="field-label" for="pastor_document_number">Número de documento</label>
                <input type="text" id="pastor_document_number" name="pastor_document_number"
                       value="{{ old('pastor_document_number', $iglesia->pastor_document_number ?? '') }}"
                       class="field-input" placeholder="Ej: 12345678" maxlength="30">
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="pastor_birth_date">Fecha de nacimiento</label>
                <input type="date" id="pastor_birth_date" name="pastor_birth_date"
                       value="{{ old('pastor_birth_date', isset($iglesia->pastor_birth_date) && $iglesia->pastor_birth_date ? (is_string($iglesia->pastor_birth_date) ? $iglesia->pastor_birth_date : $iglesia->pastor_birth_date->format('Y-m-d')) : '') }}"
                       class="field-input {{ $errors->has('pastor_birth_date') ? 'error' : '' }}"
                       max="{{ now()->subDay()->format('Y-m-d') }}" min="1900-01-01">
                @error('pastor_birth_date')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
            <div class="field-group">
                <label class="field-label" for="leadership_period_type">Tipo de período de liderazgo</label>
                <select id="leadership_period_type" name="leadership_period_type" class="field-input">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Determined' => 'Determinado', 'Indefinite' => 'Indefinido', 'Lifetime' => 'Vitalicio'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('leadership_period_type', $iglesia->leadership_period_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="pastor_phone">Teléfono del pastor</label>
                <input type="tel" id="pastor_phone" name="pastor_phone"
                       value="{{ old('pastor_phone', $iglesia->pastor_phone ?? '') }}"
                       class="field-input" placeholder="311 456 7890" maxlength="20">
            </div>
            <div class="field-group">
                <label class="field-label" for="pastor_email">Correo del pastor</label>
                <input type="email" id="pastor_email" name="pastor_email"
                       value="{{ old('pastor_email', $iglesia->pastor_email ?? '') }}"
                       class="field-input {{ $errors->has('pastor_email') ? 'error' : '' }}"
                       placeholder="pastor@ejemplo.org" maxlength="150">
                @error('pastor_email')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 5 — LÍDER DE MUJERES
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">5</div>
        <div>
            <p class="section-title">Líder de Mujeres</p>
            <p class="section-sub">Responsable del ministerio femenino</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="field-group">
            <label class="field-label" for="women_leader_full_name">Nombre completo</label>
            <input type="text" id="women_leader_full_name" name="women_leader_full_name"
                   value="{{ old('women_leader_full_name', $iglesia->women_leader_full_name ?? '') }}"
                   class="field-input" placeholder="Nombres y apellidos" maxlength="150">
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="women_leader_phone">Teléfono</label>
                <input type="tel" id="women_leader_phone" name="women_leader_phone"
                       value="{{ old('women_leader_phone', $iglesia->women_leader_phone ?? '') }}"
                       class="field-input" placeholder="311 456 7890" maxlength="20">
            </div>
            <div class="field-group">
                <label class="field-label" for="women_leader_email">Correo electrónico</label>
                <input type="email" id="women_leader_email" name="women_leader_email"
                       value="{{ old('women_leader_email', $iglesia->women_leader_email ?? '') }}"
                       class="field-input {{ $errors->has('women_leader_email') ? 'error' : '' }}"
                       placeholder="lider@ejemplo.org" maxlength="150">
                @error('women_leader_email')<p class="field-error"><svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 6 — DATOS JURÍDICOS / INSTITUCIONALES
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">6</div>
        <div>
            <p class="section-title">Datos Jurídicos / Institucionales</p>
            <p class="section-sub">Registro legal, personería jurídica y resoluciones</p>
        </div>
    </div>
    <div class="form-section-body">

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="legal_registration_type">Tipo de registro</label>
                <select id="legal_registration_type" name="legal_registration_type" class="field-input">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Legal Personality' => 'Personería Jurídica', 'Chamber of Commerce' => 'Cámara de Comercio', 'Religious Organization Registry' => 'Registro de Entidades Religiosas', 'Other' => 'Otro'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('legal_registration_type', $iglesia->legal_registration_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field-group">
                <label class="field-label" for="legal_registration_number">Número de registro</label>
                <input type="text" id="legal_registration_number" name="legal_registration_number"
                       value="{{ old('legal_registration_number', $iglesia->legal_registration_number ?? '') }}"
                       class="field-input" placeholder="Ej: 0234-2020" maxlength="50">
            </div>
        </div>

        <div class="field-group">
            <label class="field-label" for="legal_entity_granting">Entidad que otorga</label>
            <input type="text" id="legal_entity_granting" name="legal_entity_granting"
                   value="{{ old('legal_entity_granting', $iglesia->legal_entity_granting ?? '') }}"
                   class="field-input" placeholder="Ej: Ministerio del Interior de Colombia" maxlength="200">
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="resolution_number">Número de resolución</label>
                <input type="text" id="resolution_number" name="resolution_number"
                       value="{{ old('resolution_number', $iglesia->resolution_number ?? '') }}"
                       class="field-input" placeholder="Ej: Resolución 0014" maxlength="80">
            </div>
            <div class="field-group">
                <label class="field-label" for="resolution_date">Fecha de resolución</label>
                <input type="date" id="resolution_date" name="resolution_date"
                       value="{{ old('resolution_date', isset($iglesia->resolution_date) && $iglesia->resolution_date ? (is_string($iglesia->resolution_date) ? $iglesia->resolution_date : $iglesia->resolution_date->format('Y-m-d')) : '') }}"
                       class="field-input {{ $errors->has('resolution_date') ? 'error' : '' }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="field-group">
                <label class="field-label" for="file_number">Número de expediente</label>
                <input type="text" id="file_number" name="file_number"
                       value="{{ old('file_number', $iglesia->file_number ?? '') }}"
                       class="field-input" placeholder="Ej: EXP-2019-0041" maxlength="80">
            </div>
            <div class="field-group">
                <label class="field-label" for="legal_personality_type">Tipo de personería jurídica</label>
                <select id="legal_personality_type" name="legal_personality_type" class="field-input">
                    <option value="">— Seleccionar —</option>
                    @foreach(['Extended' => 'Ampliada', 'Special' => 'Especial'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('legal_personality_type', $iglesia->legal_personality_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="field-group">
            <label class="field-label" for="legal_notes">Notas jurídicas</label>
            <textarea id="legal_notes" name="legal_notes" rows="3"
                      class="field-input"
                      placeholder="Observaciones sobre el estado legal o registros adicionales..."
                      maxlength="2000">{{ old('legal_notes', $iglesia->legal_notes ?? '') }}</textarea>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 7 — MINISTERIOS DE LA IGLESIA
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">7</div>
        <div>
            <p class="section-title">Ministerios de la Iglesia</p>
            <p class="section-sub">Ministerios activos en esta congregación</p>
        </div>
    </div>
    <div class="form-section-body">
        @php
            $ministeriosList = [
                'Children Ministry' => ['icon' => '👶', 'label' => 'Ministerio de Niños'],
                'Worship'           => ['icon' => '🎵', 'label' => 'Alabanza y Adoración'],
                'Family'            => ['icon' => '🏠', 'label' => 'Familia'],
                'Couples'           => ['icon' => '💑', 'label' => 'Parejas'],
                'Youth'             => ['icon' => '🌟', 'label' => 'Jóvenes'],
                'Dance'             => ['icon' => '💃', 'label' => 'Danza'],
                'Elderly'           => ['icon' => '🧓', 'label' => 'Adulto Mayor'],
                'Women'             => ['icon' => '🌸', 'label' => 'Mujeres'],
                'Intercession'      => ['icon' => '🙏', 'label' => 'Intercesión'],
                'Prison Support'    => ['icon' => '🔗', 'label' => 'Apoyo Carcelario'],
                'Missionaries'      => ['icon' => '🌍', 'label' => 'Misioneros'],
                'Counseling'        => ['icon' => '💬', 'label' => 'Consejería'],
            ];
            $ministeriosSeleccionados = old('ministries', $iglesia->ministries ?? []);
            if (is_string($ministeriosSeleccionados)) {
                $ministeriosSeleccionados = json_decode($ministeriosSeleccionados, true) ?? [];
            }
        @endphp
        <div class="ayudas-grid">
            @foreach($ministeriosList as $val => $data)
                @php $checked = in_array($val, (array) $ministeriosSeleccionados); @endphp
                <label class="ayuda-checkbox-label {{ $checked ? 'checked' : '' }}"
                       for="ministerio_{{ Str::slug($val) }}"
                       onclick="toggleAyudaLabel(this)">
                    <input type="checkbox"
                           id="ministerio_{{ Str::slug($val) }}"
                           name="ministries[]"
                           value="{{ $val }}"
                           class="ayuda-check"
                           {{ $checked ? 'checked' : '' }}>
                    <span class="ayuda-icono">{{ $data['icon'] }}</span>
                    <div><p class="ayuda-nombre">{{ $data['label'] }}</p></div>
                </label>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     SECCIÓN 8 — OBSERVACIONES ADICIONALES
══════════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">8</div>
        <div>
            <p class="section-title">Observaciones Adicionales</p>
            <p class="section-sub">Información complementaria o notas internas</p>
        </div>
    </div>
    <div class="form-section-body">
        <div class="field-group">
            <label class="field-label" for="additional_notes">Observaciones</label>
            <textarea id="additional_notes" name="additional_notes" rows="4"
                      class="field-input"
                      placeholder="Cualquier información adicional relevante sobre la iglesia..."
                      maxlength="3000">{{ old('additional_notes', $iglesia->additional_notes ?? '') }}</textarea>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════
     SECCIÓN 9 – Ayudas Sociales
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">9</div>
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
     SECCIÓN 10 – Geolocalización
═══════════════════════════════════ --}}
<div class="form-section">
    <div class="form-section-header">
        <div class="section-number">10</div>
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
                El mapa cubre todo el departamento de <strong>Huila</strong>.
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
            <p class="field-hint" style="margin:0;">Zona permitida: departamento de Huila, Colombia</p>
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
    const dirInput    = document.getElementById('address');
    const geoIcon     = document.getElementById('geo-status-icon');
    const geoMsg      = document.getElementById('geo-status-msg');

    /* ── Estado inicial del mapa ────────────────────────────── */
    const initLat = parseFloat(latInput.value) || NEIVA[0];
    const initLng = parseFloat(lngInput.value) || NEIVA[1];

    /* ── Inicializar Leaflet ─────────────────────────────────── */
    const map = L.map('map-selector', {
        center            : [initLat, initLng],
        zoom              : 15,
        minZoom           : 8,
        maxZoom           : 19,
        maxBounds         : [[1.40, -76.80], [3.50, -74.30]],  // Todo Huila
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

    /* ── Municipios del Huila → coordenadas centradas ───────── */
    const COORDS_MUNICIPIOS = {
        'Neiva':          [2.9274,  -75.2819],
        'Pitalito':       [1.8508,  -76.0534],
        'Garzón':         [2.1997,  -75.6291],
        'La Plata':       [2.3867,  -75.8902],
        'Rivera':         [2.7783,  -75.2400],
        'Palermo':        [3.0792,  -75.4359],
        'Campoalegre':    [2.6897,  -75.3322],
        'Gigante':        [2.3889,  -75.5469],
        'Algeciras':      [2.5267,  -75.3189],
        'Acevedo':        [1.8186,  -75.9964],
        'Aipe':           [3.2228,  -75.2417],
        'Altamira':       [2.0486,  -75.7819],
        'Baraya':         [3.1578,  -75.0731],
        'Colombia':       [3.3894,  -74.8928],
        'Elías':          [2.0278,  -75.7114],
        'Hobo':           [2.5706,  -75.4622],
        'Iquira':         [2.6208,  -75.6328],
        'Isnos':          [1.9394,  -76.2233],
        'La Argentina':   [2.2256,  -75.9678],
        'Nátaga':         [2.3122,  -75.7194],
        'Oporapa':        [1.9608,  -76.0814],
        'Paicol':         [2.4000,  -75.7236],
        'Palestina':      [1.7400,  -76.0328],
        'Pital':          [2.1022,  -75.7197],
        'Saladoblanco':   [1.9028,  -76.0894],
        'San Agustín':    [1.8681,  -76.2739],
        'Santa María':    [3.0000,  -74.8833],
        'Suaza':          [1.9769,  -75.7958],
        'Tarqui':         [2.1028,  -75.8147],
        'Tello':          [3.0683,  -75.1342],
        'Teruel':         [2.6836,  -75.5756],
        'Tesalia':        [2.4881,  -75.6606],
        'Timaía':         [1.9667,  -75.9306],
        'Villavieja':     [3.2256,  -75.2169],
        'Yaguárá':        [2.6619,  -75.5022],
    };

    /* ── Listener select Municipio → centrar mapa ────────────── */
    const municipioSelect = document.getElementById('municipality');
    if (municipioSelect) {
        municipioSelect.addEventListener('change', function () {
            const mun   = this.value;
            const coords = COORDS_MUNICIPIOS[mun];

            if (coords) {
                // Zoom 14 = nivel ciudad; muestra bien el casco urbano
                map.flyTo(coords, 14, { duration: 1.2 });
                marker.setLatLng(coords).openPopup();
                latInput.value = coords[0].toFixed(8);
                lngInput.value = coords[1].toFixed(8);
                latInput.classList.remove('error');
                lngInput.classList.remove('error');
                geoSetOk('Centrado en ' + mun + ', Huila');
            } else if (mun && mun !== '') {
                // "Otro" u otro valor sin coordenadas: geocodificar por nombre
                geocodificarDireccion(mun + ', Huila, Colombia');
            }
        });
    }

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

window.previsualizarFotoIglesia = function (input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        const preview = document.getElementById('foto-preview');
        const icon    = document.getElementById('foto-placeholder-icon');
        const wrap    = document.getElementById('foto-preview-wrap');
        if (preview) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        if (icon)  icon.classList.add('hidden');
        if (wrap)  wrap.classList.remove('border-dashed', 'border-2', 'border-slate-200', 'bg-slate-50');
    };
    reader.readAsDataURL(input.files[0]);
};
</script>
@endpush