{{-- ═══════════════════════════════════════════════════════════
     _form.blade.php  –  Parcial compartido por create y edit
     Variables esperadas:
       $iglesia        → instancia de Iglesia (nueva o existente)
       $ayudas         → Collection<Ayuda> (todas disponibles)
       $ayudasActuales → array de IDs ya asociados (en edit)
═══════════════════════════════════════════════════════════ --}}

@php
    /* Helper: clases base para inputs */
    $inp  = 'w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 font-medium
             placeholder-slate-300 transition-all outline-none
             focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/10
             hover:border-slate-300';
    $inpE = 'border-red-300 bg-red-50 focus:border-red-400 focus:ring-red-400/10';
    $lbl  = 'block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5';
    $req  = '<span class="text-red-500 ml-0.5">*</span>';

    /* Helper: componente de error inline */
    function errIcon() {
        return '<svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
    }
@endphp

{{-- ══════════════════════════════════════════════
     Macro: sección
══════════════════════════════════════════════ --}}

{{-- ──────────────────────────────────────────────
     S1 — INFORMACIÓN DE LA IGLESIA
────────────────────────────────────────────── --}}
<div id="seccion-1" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    {{-- Header --}}
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">1</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Información de la Iglesia</p>
            <p class="text-xs text-slate-400">Nombre oficial, denominación, estado y caracterización</p>
        </div>
    </div>
    <div class="p-5 space-y-4">

        {{-- Nombre oficial --}}
        <div>
            <label class="{{ $lbl }}" for="official_name">Nombre oficial {!! $req !!}</label>
            <input type="text" id="official_name" name="official_name"
                   value="{{ old('official_name', $iglesia->official_name ?? '') }}"
                   class="{{ $inp }} {{ $errors->has('official_name') ? $inpE : '' }}"
                   placeholder="Ej: Parroquia Nuestra Señora de la Asunción"
                   maxlength="200" autocomplete="off">
            @error('official_name')
                <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                    {!! errIcon() !!} {{ $message }}
                </p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="denomination">Denominación {!! $req !!}</label>
                <div class="relative">
                    <select id="denomination" name="denomination"
                            class="{{ $inp }} {{ $errors->has('denomination') ? $inpE : '' }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Catholic'=>'Católica','Evangelical'=>'Evangélica','Pentecostal'=>'Pentecostal','Baptist'=>'Bautista','Other'=>'Otra'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('denomination', $iglesia->denomination ?? '') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('denomination')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
            <div>
                <label class="{{ $lbl }}" for="confessional_character">Carácter confesional</label>
                <div class="relative">
                    <select id="confessional_character" name="confessional_character"
                            class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Christian'=>'Cristiana','Islamic'=>'Islámica','Jewish'=>'Judía','Other'=>'Otra'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('confessional_character', $iglesia->confessional_character ?? '') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="church_status">Estado {!! $req !!}</label>
                <div class="relative">
                    <select id="church_status" name="church_status"
                            class="{{ $inp }} {{ $errors->has('church_status') ? $inpE : '' }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Active'=>'Activa','Inactive'=>'Inactiva','Suspended'=>'Suspendida'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('church_status', $iglesia->church_status ?? 'Active') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('church_status')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
            <div>
                <label class="{{ $lbl }}" for="foundation_date">Fecha de fundación</label>
                <input type="date" id="foundation_date" name="foundation_date"
                       value="{{ old('foundation_date', isset($iglesia->foundation_date) && $iglesia->foundation_date ? (is_string($iglesia->foundation_date) ? $iglesia->foundation_date : $iglesia->foundation_date->format('Y-m-d')) : '') }}"
                       class="{{ $inp }}" max="{{ now()->format('Y-m-d') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="specific_location">Ubicación específica</label>
                <input type="text" id="specific_location" name="specific_location"
                       value="{{ old('specific_location', $iglesia->specific_location ?? '') }}"
                       class="{{ $inp }}" placeholder="Ej: Barrio Villa del Río, local 3">
            </div>
            <div>
                <label class="{{ $lbl }}" for="approx_members">Miembros aproximados</label>
                <input type="number" id="approx_members" name="approx_members"
                       value="{{ old('approx_members', $iglesia->approx_members ?? '') }}"
                       class="{{ $inp }} {{ $errors->has('approx_members') ? $inpE : '' }}"
                       placeholder="Ej: 250" min="0" max="999999" step="1">
                @error('approx_members')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Fotografía --}}
        <div>
            <label class="{{ $lbl }}" for="photo">Fotografía de la iglesia</label>
            <div class="flex items-start gap-4">
                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 border-2 border-dashed border-slate-200
                            bg-slate-50 flex items-center justify-center" id="foto-preview-wrap">
                    @if(isset($iglesia->photo) && $iglesia->photo)
                        <img id="foto-preview" src="{{ Storage::url($iglesia->photo) }}"
                             alt="Foto actual" class="w-full h-full object-cover">
                    @else
                        <img id="foto-preview" src="" alt="" class="hidden w-full h-full object-cover">
                        <svg id="foto-placeholder-icon" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="photo" name="photo"
                           accept="image/jpeg,image/png,image/webp"
                           class="{{ $inp }} py-1.5 cursor-pointer
                                  file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                  file:text-xs file:font-semibold file:cursor-pointer
                                  file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                           onchange="previsualizarFotoIglesia(this)">
                    <p class="text-xs text-slate-400 mt-1.5">JPG, PNG o WebP · Máximo 2 MB</p>
                    @if(isset($iglesia->photo) && $iglesia->photo)
                        <p class="text-xs text-slate-400 mt-0.5">Sube una nueva imagen para reemplazarla.</p>
                    @endif
                    @error('photo')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ──────────────────────────────────────────────
     S2 — UBICACIÓN
────────────────────────────────────────────── --}}
<div id="seccion-2" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #059669, #10b981);">2</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Ubicación de la Iglesia</p>
            <p class="text-xs text-slate-400">Dirección completa y datos geográficos</p>
        </div>
    </div>
    <div class="p-5 space-y-4">

        <div>
            <label class="{{ $lbl }}" for="address">Dirección {!! $req !!}</label>
            <div class="relative">
                <input type="text" id="address" name="address"
                       value="{{ old('address', $iglesia->address ?? '') }}"
                       class="{{ $inp }} {{ $errors->has('address') ? $inpE : '' }} pr-9"
                       placeholder="Ej: Calle 8 # 4-37, Centro, Neiva"
                       maxlength="255" autocomplete="off">
                <span id="geo-status-icon"
                      class="absolute right-3 top-1/2 -translate-y-1/2 hidden pointer-events-none"></span>
            </div>
            <p id="geo-status-msg" class="text-xs mt-1.5 hidden"></p>
            @error('address')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="neighborhood">Barrio</label>
                <input type="text" id="neighborhood" name="neighborhood"
                       value="{{ old('neighborhood', $iglesia->neighborhood ?? '') }}"
                       class="{{ $inp }}" placeholder="Ej: El Recreo">
            </div>
            <div>
                <label class="{{ $lbl }}" for="comuna">Comuna</label>
                <input type="text" id="comuna" name="comuna"
                       value="{{ old('comuna', $iglesia->comuna ?? '') }}"
                       class="{{ $inp }}" list="comunas-list" placeholder="Ej: Comuna 1">
                <datalist id="comunas-list">
                    @for($i = 1; $i <= 12; $i++)<option value="Comuna {{ $i }}">@endfor
                </datalist>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="department">Departamento</label>
                <div class="relative">
                    <select id="department" name="department" class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        @foreach(['Huila'=>'Huila','Otro'=>'Otro'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('department', $iglesia->department ?? 'Huila') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div>
                <label class="{{ $lbl }}" for="municipality">Municipio</label>
                <div class="relative">
                    <select id="municipality" name="municipality" class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Neiva','Pitalito','Garzón','La Plata','Rivera','Palermo','Campoalegre','Gigante','Algeciras','Acevedo','Aipe','Altamira','Baraya','Colombia','Elías','Hobo','Iquira','Isnos','La Argentina','Nátaga','Oporapa','Paicol','Palestina','Pital','Saladoblanco','San Agustín','Santa María','Suaza','Tarqui','Tello','Teruel','Tesalia','Timaía','Villavieja','Yaguárá','Otro'] as $mun)
                            <option value="{{ $mun }}" {{ old('municipality', $iglesia->municipality ?? '') === $mun ? 'selected' : '' }}>{{ $mun }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="city">Ciudad</label>
                <input type="text" id="city" name="city"
                       value="{{ old('city', $iglesia->city ?? 'Neiva') }}"
                       class="{{ $inp }}" placeholder="Ej: Neiva">
            </div>
            <div>
                <label class="{{ $lbl }}" for="country">País</label>
                <input type="text" id="country" name="country"
                       value="{{ old('country', $iglesia->country ?? 'Colombia') }}"
                       class="{{ $inp }}" placeholder="Ej: Colombia" maxlength="80">
            </div>
        </div>

    </div>
</div>

{{-- ──────────────────────────────────────────────
     S3 — CONTACTO
────────────────────────────────────────────── --}}
<div id="seccion-3" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0F9FF;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #0369a1, #0ea5e9);">3</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Contacto de la Iglesia</p>
            <p class="text-xs text-slate-400">Teléfonos, correo electrónico y redes sociales</p>
        </div>
    </div>
    <div class="p-5 space-y-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="phone_landline">Teléfono fijo</label>
                <input type="tel" id="phone_landline" name="phone_landline"
                       value="{{ old('phone_landline', $iglesia->phone_landline ?? '') }}"
                       class="{{ $inp }}" placeholder="(8) 871 0000" maxlength="20">
            </div>
            <div>
                <label class="{{ $lbl }}" for="phone_mobile">Teléfono móvil</label>
                <input type="tel" id="phone_mobile" name="phone_mobile"
                       value="{{ old('phone_mobile', $iglesia->phone_mobile ?? '') }}"
                       class="{{ $inp }}" placeholder="315 123 4567" maxlength="20">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="email">Correo electrónico</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $iglesia->email ?? '') }}"
                       class="{{ $inp }} {{ $errors->has('email') ? $inpE : '' }}"
                       placeholder="iglesia@ejemplo.org" maxlength="150">
                @error('email')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
            <div>
                <label class="{{ $lbl }}" for="website_or_social">Sitio web o red social</label>
                <input type="text" id="website_or_social" name="website_or_social"
                       value="{{ old('website_or_social', $iglesia->website_or_social ?? '') }}"
                       class="{{ $inp }}" placeholder="https://... o @usuario" maxlength="255">
            </div>
        </div>

    </div>
</div>

{{-- ──────────────────────────────────────────────
     S4 — PASTOR / LÍDER
────────────────────────────────────────────── --}}
<div id="seccion-4" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FEFCE8;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #b45309, #f59e0b);">4</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Pastor o Líder Principal</p>
            <p class="text-xs text-slate-400">Datos del responsable pastoral de la congregación</p>
        </div>
    </div>
    <div class="p-5 space-y-4">

        <div>
            <label class="{{ $lbl }}" for="pastor_full_name">Nombre completo</label>
            <input type="text" id="pastor_full_name" name="pastor_full_name"
                   value="{{ old('pastor_full_name', $iglesia->pastor_full_name ?? '') }}"
                   class="{{ $inp }}" placeholder="Nombres y apellidos completos" maxlength="150">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="pastor_document_type">Tipo de documento</label>
                <div class="relative">
                    <select id="pastor_document_type" name="pastor_document_type" class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['CC'=>'Cédula de Ciudadanía','CE'=>'Cédula de Extranjería','Passport'=>'Pasaporte'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('pastor_document_type', $iglesia->pastor_document_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div>
                <label class="{{ $lbl }}" for="pastor_document_number">Número de documento</label>
                <input type="text" id="pastor_document_number" name="pastor_document_number"
                       value="{{ old('pastor_document_number', $iglesia->pastor_document_number ?? '') }}"
                       class="{{ $inp }}" placeholder="Ej: 12345678" maxlength="30">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="pastor_birth_date">Fecha de nacimiento</label>
                <input type="date" id="pastor_birth_date" name="pastor_birth_date"
                       value="{{ old('pastor_birth_date', isset($iglesia->pastor_birth_date) && $iglesia->pastor_birth_date ? (is_string($iglesia->pastor_birth_date) ? $iglesia->pastor_birth_date : $iglesia->pastor_birth_date->format('Y-m-d')) : '') }}"
                       class="{{ $inp }} {{ $errors->has('pastor_birth_date') ? $inpE : '' }}"
                       max="{{ now()->subDay()->format('Y-m-d') }}" min="1900-01-01">
                @error('pastor_birth_date')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
            <div>
                <label class="{{ $lbl }}" for="leadership_period_type">Período de liderazgo</label>
                <div class="relative">
                    <select id="leadership_period_type" name="leadership_period_type" class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Determined'=>'Determinado','Indefinite'=>'Indefinido','Lifetime'=>'Vitalicio'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('leadership_period_type', $iglesia->leadership_period_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="pastor_phone">Teléfono del pastor</label>
                <input type="tel" id="pastor_phone" name="pastor_phone"
                       value="{{ old('pastor_phone', $iglesia->pastor_phone ?? '') }}"
                       class="{{ $inp }}" placeholder="311 456 7890" maxlength="20">
            </div>
            <div>
                <label class="{{ $lbl }}" for="pastor_email">Correo del pastor</label>
                <input type="email" id="pastor_email" name="pastor_email"
                       value="{{ old('pastor_email', $iglesia->pastor_email ?? '') }}"
                       class="{{ $inp }} {{ $errors->has('pastor_email') ? $inpE : '' }}"
                       placeholder="pastor@ejemplo.org" maxlength="150">
                @error('pastor_email')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
        </div>

    </div>
</div>

{{-- ──────────────────────────────────────────────
     S5 — LÍDER DE MUJERES
────────────────────────────────────────────── --}}
<div id="seccion-5" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFF0F6;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #be185d, #ec4899);">5</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Líder de Mujeres</p>
            <p class="text-xs text-slate-400">Responsable del ministerio femenino</p>
        </div>
    </div>
    <div class="p-5 space-y-4">
        <div>
            <label class="{{ $lbl }}" for="women_leader_full_name">Nombre completo</label>
            <input type="text" id="women_leader_full_name" name="women_leader_full_name"
                   value="{{ old('women_leader_full_name', $iglesia->women_leader_full_name ?? '') }}"
                   class="{{ $inp }}" placeholder="Nombres y apellidos" maxlength="150">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="women_leader_phone">Teléfono</label>
                <input type="tel" id="women_leader_phone" name="women_leader_phone"
                       value="{{ old('women_leader_phone', $iglesia->women_leader_phone ?? '') }}"
                       class="{{ $inp }}" placeholder="311 456 7890" maxlength="20">
            </div>
            <div>
                <label class="{{ $lbl }}" for="women_leader_email">Correo electrónico</label>
                <input type="email" id="women_leader_email" name="women_leader_email"
                       value="{{ old('women_leader_email', $iglesia->women_leader_email ?? '') }}"
                       class="{{ $inp }} {{ $errors->has('women_leader_email') ? $inpE : '' }}"
                       placeholder="lider@ejemplo.org" maxlength="150">
                @error('women_leader_email')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>

{{-- ──────────────────────────────────────────────
     S6 — DATOS JURÍDICOS
────────────────────────────────────────────── --}}
<div id="seccion-6" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FAF5FF;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #6d28d9, #8b5cf6);">6</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Datos Jurídicos / Institucionales</p>
            <p class="text-xs text-slate-400">Registro legal, personería jurídica y resoluciones</p>
        </div>
    </div>
    <div class="p-5 space-y-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="legal_registration_type">Tipo de registro</label>
                <div class="relative">
                    <select id="legal_registration_type" name="legal_registration_type" class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Legal Personality'=>'Personería Jurídica','Chamber of Commerce'=>'Cámara de Comercio','Religious Organization Registry'=>'Registro Entidades Religiosas','Other'=>'Otro'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('legal_registration_type', $iglesia->legal_registration_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
            <div>
                <label class="{{ $lbl }}" for="legal_registration_number">Número de registro</label>
                <input type="text" id="legal_registration_number" name="legal_registration_number"
                       value="{{ old('legal_registration_number', $iglesia->legal_registration_number ?? '') }}"
                       class="{{ $inp }}" placeholder="Ej: 0234-2020" maxlength="50">
            </div>
        </div>

        <div>
            <label class="{{ $lbl }}" for="legal_entity_granting">Entidad que otorga</label>
            <input type="text" id="legal_entity_granting" name="legal_entity_granting"
                   value="{{ old('legal_entity_granting', $iglesia->legal_entity_granting ?? '') }}"
                   class="{{ $inp }}" placeholder="Ej: Ministerio del Interior de Colombia" maxlength="200">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="resolution_number">N° de resolución</label>
                <input type="text" id="resolution_number" name="resolution_number"
                       value="{{ old('resolution_number', $iglesia->resolution_number ?? '') }}"
                       class="{{ $inp }}" placeholder="Ej: Resolución 0014" maxlength="80">
            </div>
            <div>
                <label class="{{ $lbl }}" for="resolution_date">Fecha de resolución</label>
                <input type="date" id="resolution_date" name="resolution_date"
                       value="{{ old('resolution_date', isset($iglesia->resolution_date) && $iglesia->resolution_date ? (is_string($iglesia->resolution_date) ? $iglesia->resolution_date : $iglesia->resolution_date->format('Y-m-d')) : '') }}"
                       class="{{ $inp }} {{ $errors->has('resolution_date') ? $inpE : '' }}">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="file_number">N° de expediente</label>
                <input type="text" id="file_number" name="file_number"
                       value="{{ old('file_number', $iglesia->file_number ?? '') }}"
                       class="{{ $inp }}" placeholder="Ej: EXP-2019-0041" maxlength="80">
            </div>
            <div>
                <label class="{{ $lbl }}" for="legal_personality_type">Tipo de personería</label>
                <div class="relative">
                    <select id="legal_personality_type" name="legal_personality_type" class="{{ $inp }} appearance-none pr-9 cursor-pointer">
                        <option value="">— Seleccionar —</option>
                        @foreach(['Extended'=>'Ampliada','Special'=>'Especial'] as $val => $lbl2)
                            <option value="{{ $val }}" {{ old('legal_personality_type', $iglesia->legal_personality_type ?? '') === $val ? 'selected' : '' }}>{{ $lbl2 }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <div>
            <label class="{{ $lbl }}" for="legal_notes">Notas jurídicas</label>
            <textarea id="legal_notes" name="legal_notes" rows="3"
                      class="{{ $inp }} resize-y min-h-[80px]"
                      placeholder="Observaciones sobre el estado legal o registros adicionales..."
                      maxlength="2000">{{ old('legal_notes', $iglesia->legal_notes ?? '') }}</textarea>
        </div>

    </div>
</div>

{{-- ──────────────────────────────────────────────
     S7 — MINISTERIOS
────────────────────────────────────────────── --}}
<div id="seccion-7" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#EEF2FF;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #4338ca, #6366f1);">7</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Ministerios de la Iglesia</p>
            <p class="text-xs text-slate-400">Ministerios activos en esta congregación</p>
        </div>
    </div>
    <div class="p-5">
        @php
            $ministeriosList = [
                'Children Ministry'=>['icon'=>'👶','label'=>'Ministerio de Niños'],
                'Worship'          =>['icon'=>'🎵','label'=>'Alabanza y Adoración'],
                'Family'           =>['icon'=>'🏠','label'=>'Familia'],
                'Couples'          =>['icon'=>'💑','label'=>'Parejas'],
                'Youth'            =>['icon'=>'🌟','label'=>'Jóvenes'],
                'Dance'            =>['icon'=>'💃','label'=>'Danza'],
                'Elderly'          =>['icon'=>'🧓','label'=>'Adulto Mayor'],
                'Women'            =>['icon'=>'🌸','label'=>'Mujeres'],
                'Intercession'     =>['icon'=>'🙏','label'=>'Intercesión'],
                'Prison Support'   =>['icon'=>'🔗','label'=>'Apoyo Carcelario'],
                'Missionaries'     =>['icon'=>'🌍','label'=>'Misioneros'],
                'Counseling'       =>['icon'=>'💬','label'=>'Consejería'],
            ];
            $ministeriosSeleccionados = old('ministries', $iglesia->ministries ?? []);
            if (is_string($ministeriosSeleccionados)) {
                $ministeriosSeleccionados = json_decode($ministeriosSeleccionados, true) ?? [];
            }
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
            @foreach($ministeriosList as $val => $data)
                @php $checked = in_array($val, (array) $ministeriosSeleccionados); @endphp
                <label for="ministerio_{{ Str::slug($val) }}"
                       class="ministerio-label relative flex flex-col items-center gap-2 p-3 rounded-xl cursor-pointer
                              border-2 transition-all select-none text-center
                              {{ $checked ? 'border-indigo-400 bg-indigo-50' : 'border-slate-200 bg-slate-50 hover:border-indigo-200 hover:bg-indigo-50/50' }}">
                    <input type="checkbox"
                           id="ministerio_{{ Str::slug($val) }}"
                           name="ministries[]"
                           value="{{ $val }}"
                           class="sr-only"
                           {{ $checked ? 'checked' : '' }}
                           onchange="toggleMinisterio(this)">
                    <span class="text-2xl leading-none">{{ $data['icon'] }}</span>
                    <span class="text-xs font-semibold text-slate-700 leading-tight">{{ $data['label'] }}</span>
                    @if($checked)
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-indigo-500 flex items-center justify-center check-indicator">
                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                    @else
                        <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full border-2 border-slate-200 check-indicator"></span>
                    @endif
                </label>
            @endforeach
        </div>
    </div>
</div>

{{-- ──────────────────────────────────────────────
     S8 — OBSERVACIONES
────────────────────────────────────────────── --}}
<div id="seccion-8" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFFBEB;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #b45309, #f59e0b);">8</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Observaciones Adicionales</p>
            <p class="text-xs text-slate-400">Información complementaria o notas internas</p>
        </div>
    </div>
    <div class="p-5">
        <label class="{{ $lbl }}" for="additional_notes">Observaciones</label>
        <textarea id="additional_notes" name="additional_notes" rows="4"
                  class="{{ $inp }} resize-y min-h-[100px]"
                  placeholder="Cualquier información adicional relevante sobre la iglesia..."
                  maxlength="3000">{{ old('additional_notes', $iglesia->additional_notes ?? '') }}</textarea>
    </div>
</div>

{{-- ──────────────────────────────────────────────
     HORARIOS DE ATENCIÓN
────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0F9FF;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #0369a1, #38bdf8);">🕐</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Horario de Atención</p>
            <p class="text-xs text-slate-400">Se mostrará en el mapa público al hacer clic en el marcador</p>
        </div>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="{{ $lbl }}" for="schedule_weekdays">Lunes a Viernes</label>
            <input id="schedule_weekdays" name="schedule_weekdays" type="text"
                   class="{{ $inp }}"
                   placeholder="Ej: 8:00 AM – 6:00 PM"
                   value="{{ old('schedule_weekdays', $iglesia->schedule_weekdays ?? '') }}">
        </div>
        <div>
            <label class="{{ $lbl }}" for="schedule_weekends">Sábado a Domingo</label>
            <input id="schedule_weekends" name="schedule_weekends" type="text"
                   class="{{ $inp }}"
                   placeholder="Ej: 9:00 AM – 1:00 PM  /  No atiende"
                   value="{{ old('schedule_weekends', $iglesia->schedule_weekends ?? '') }}">
        </div>
    </div>
</div>

{{-- ──────────────────────────────────────────────
     S9 — AYUDAS SOCIALES
────────────────────────────────────────────── --}}
<div id="seccion-9" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
        <div class="flex items-center gap-3">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
                 style="background: linear-gradient(135deg, #15803d, #22c55e);">9</div>
            <div>
                <p class="text-sm font-bold text-slate-800">Ayudas Sociales</p>
                <p class="text-xs text-slate-400">Programas de apoyo que ofrece esta iglesia</p>
            </div>
        </div>
        @if($ayudas->count() > 0)
            <button type="button" id="btn-toggle-ayudas"
                    onclick="toggleTodasAyudas()"
                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-green-200
                           text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
                Seleccionar todas
            </button>
        @endif
    </div>
    <div class="p-5">

        @if($errors->has('ayudas') || $errors->has('ayudas.*'))
            <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mb-3">
                {!! errIcon() !!}
                {{ $errors->first('ayudas') ?: $errors->first('ayudas.*') }}
            </p>
        @endif

        @if($ayudas->isEmpty())
            <div class="flex items-center gap-3 bg-slate-50 rounded-xl p-4 text-sm text-slate-500">
                <svg class="w-5 h-5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                No hay ayudas registradas. Corre:
                <code class="bg-slate-100 px-2 py-0.5 rounded text-xs ml-1">php artisan db:seed --class=AyudaSeeder</code>
            </div>
        @else
            @php $seleccionadas = old('ayudas', isset($ayudasActuales) ? $ayudasActuales : []); @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2" id="ayudas-grid">
                @foreach($ayudas as $ayuda)
                    @php $checked = in_array($ayuda->id, (array)$seleccionadas); @endphp
                    <label for="ayuda_{{ $ayuda->id }}"
                           class="ayuda-label flex items-center gap-3 p-3 rounded-xl cursor-pointer border-2
                                  transition-all select-none
                                  {{ $checked ? 'border-green-400 bg-green-50' : 'border-slate-200 bg-slate-50 hover:border-green-200 hover:bg-green-50/50' }}">
                        <input type="checkbox"
                               id="ayuda_{{ $ayuda->id }}"
                               name="ayudas[]"
                               value="{{ $ayuda->id }}"
                               class="ayuda-check sr-only"
                               {{ $checked ? 'checked' : '' }}
                               onchange="toggleAyudaCheckbox(this)">
                        <span class="text-xl leading-none flex-shrink-0">{{ $ayuda->icono ?? '🤝' }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 leading-tight">{{ $ayuda->nombre }}</p>
                            @if($ayuda->descripcion)
                                <p class="text-[10px] text-slate-400 mt-0.5 truncate">{{ Str::limit($ayuda->descripcion, 40) }}</p>
                            @endif
                        </div>
                        <div class="w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center transition-all
                                    {{ $checked ? 'bg-green-500' : 'border-2 border-slate-200' }} check-dot">
                            @if($checked)
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
            <p class="text-xs text-slate-400 mt-3">
                <span id="num-seleccionadas" class="font-bold text-slate-600">{{ count((array)$seleccionadas) }}</span>
                ayuda(s) seleccionada(s)
            </p>
        @endif

    </div>
</div>

{{-- ──────────────────────────────────────────────
     S10 — GEOLOCALIZACIÓN
────────────────────────────────────────────── --}}
<div id="seccion-10" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4 scroll-mt-20">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F8FAFF;">
        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
             style="background: linear-gradient(135deg, #0a1f5c, #0e6ba8);">10</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Geolocalización</p>
            <p class="text-xs text-slate-400">Ubica la iglesia en el mapa de Huila</p>
        </div>
    </div>
    <div class="p-5 space-y-4">

        <div class="flex items-start gap-3 rounded-xl px-4 py-3 text-sm"
             style="background:#EFF6FF; border:1px solid #BFDBFE;">
            <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-xs text-blue-800 leading-relaxed">
                <strong>Haz clic en el mapa</strong> para establecer la ubicación, arrastra el marcador,
                o <strong>escribe la dirección arriba</strong> para geocodificar automáticamente.
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="{{ $lbl }}" for="latitud">Latitud {!! $req !!}</label>
                <input type="number" id="latitud" name="latitud"
                       value="{{ old('latitud', $iglesia->latitud ?? '2.9274') }}"
                       class="{{ $inp }} {{ $errors->has('latitud') ? $inpE : '' }}"
                       step="0.00000001" min="-90" max="90" placeholder="2.9274"
                       oninput="sincronizarCoords()">
                @error('latitud')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
            <div>
                <label class="{{ $lbl }}" for="longitud">Longitud {!! $req !!}</label>
                <input type="number" id="longitud" name="longitud"
                       value="{{ old('longitud', $iglesia->longitud ?? '-75.2819') }}"
                       class="{{ $inp }} {{ $errors->has('longitud') ? $inpE : '' }}"
                       step="0.00000001" min="-180" max="180" placeholder="-75.2819"
                       oninput="sincronizarCoords()">
                @error('longitud')<p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">{!! errIcon() !!} {{ $message }}</p>@enderror
            </div>
        </div>

        <div id="map-selector"
             class="w-full rounded-2xl overflow-hidden border border-slate-200"
             style="height:280px; position:relative; z-index:1;"
             aria-label="Mapa selector de ubicación"></div>

        <div class="flex items-center justify-between flex-wrap gap-2">
            <p class="text-xs text-slate-400">Zona permitida: departamento de Huila, Colombia</p>
            <button type="button" onclick="centrarEnNeiva()"
                    class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-lg
                           border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                📍 Centrar en Neiva
            </button>
        </div>

    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/* ════════════════════════════════════════════════════════════
   MAPA + GEOCODIFICACIÓN (sin cambios funcionales)
════════════════════════════════════════════════════════════ */
(function () {
    const NEIVA       = [2.9274, -75.2819];
    const NOMINATIM   = 'https://nominatim.openstreetmap.org';
    const DEBOUNCE_MS = 600;

    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    const dirInput = document.getElementById('address');
    const geoIcon  = document.getElementById('geo-status-icon');
    const geoMsg   = document.getElementById('geo-status-msg');

    const initLat = parseFloat(latInput.value) || NEIVA[0];
    const initLng = parseFloat(lngInput.value) || NEIVA[1];

    const map = L.map('map-selector', {
        center:[initLat, initLng], zoom:15, minZoom:8, maxZoom:19,
        maxBounds:[[1.40,-76.80],[3.50,-74.30]], maxBoundsViscosity:0.85,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:'© OpenStreetMap contributors', maxZoom:19,
    }).addTo(map);

    const icono = L.divIcon({
        className:'',
        html:`<div style="width:34px;height:34px;background:linear-gradient(135deg,#0a1f5c,#0e6ba8);border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 3px 12px rgba(30,58,138,.5);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);color:white;font-size:13px;font-weight:900;">✝</span></div>`,
        iconSize:[34,34], iconAnchor:[17,34], popupAnchor:[0,-38],
    });

    const marker = L.marker([initLat, initLng], {draggable:true, icon:icono}).addTo(map);
    marker.bindPopup('<span style="font-size:12px;font-weight:600;color:#0a1f5c;">📍 Ubica aquí la iglesia</span>').openPopup();

    function geoSetBuscando() {
        if(geoIcon) { geoIcon.style.display='inline'; geoIcon.innerHTML=`<svg style="width:16px;height:16px;animation:spin .8s linear infinite;color:#3B82F6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>`; }
        if(geoMsg) { geoMsg.style.display='block'; geoMsg.style.color='#3B82F6'; geoMsg.textContent='Buscando...'; }
    }
    function geoSetOk(txt) {
        if(geoIcon) { geoIcon.style.display='inline'; geoIcon.innerHTML=`<svg style="width:16px;height:16px;color:#16A34A" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`; }
        if(geoMsg) { geoMsg.style.display='block'; geoMsg.style.color='#16A34A'; geoMsg.textContent='✓ '+txt; }
    }
    function geoSetError(msg) {
        if(geoIcon) { geoIcon.style.display='inline'; geoIcon.innerHTML=`<svg style="width:16px;height:16px;color:#DC2626" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`; }
        if(geoMsg) { geoMsg.style.display='block'; geoMsg.style.color='#DC2626'; geoMsg.textContent=msg; }
    }

    function aplicarCoordenadas(lat, lng, zoom) {
        latInput.value = lat.toFixed(8);
        lngInput.value = lng.toFixed(8);
        latInput.classList.remove('border-red-300','bg-red-50');
        lngInput.classList.remove('border-red-300','bg-red-50');
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], zoom || map.getZoom());
        marker.openPopup();
    }

    function debounce(fn, delay) { let t; return function(...a){ clearTimeout(t); t=setTimeout(()=>fn.apply(this,a),delay); }; }

    async function geocodificarDireccion(query) {
        if(!query||query.trim().length<5){return;}
        geoSetBuscando();
        const url = new URL(NOMINATIM+'/search');
        url.searchParams.set('q', query.trim()+', Neiva, Huila, Colombia');
        url.searchParams.set('format','json'); url.searchParams.set('limit','1');
        url.searchParams.set('countrycodes','co'); url.searchParams.set('accept-language','es');
        try {
            const res = await fetch(url.toString(), {headers:{'Accept':'application/json'}});
            const data = await res.json();
            if(!data||!data.length){geoSetError('No se encontró la dirección.');return;}
            const lugar=data[0];
            aplicarCoordenadas(parseFloat(lugar.lat), parseFloat(lugar.lon), 17);
            geoSetOk(lugar.display_name.split(',').slice(0,3).join(','));
        } catch(e){geoSetError('Error al buscar. Intenta de nuevo.');}
    }

    async function reverseGeocodificar(lat, lng) {
        const url = new URL(NOMINATIM+'/reverse');
        url.searchParams.set('lat',lat.toFixed(8)); url.searchParams.set('lon',lng.toFixed(8));
        url.searchParams.set('format','json'); url.searchParams.set('accept-language','es');
        try {
            const res=await fetch(url.toString(),{headers:{'Accept':'application/json'}});
            const data=await res.json();
            if(data&&data.address){
                const a=data.address;
                const partes=[a.road||a.pedestrian||'',a.house_number||'',a.suburb||a.neighbourhood||''].filter(Boolean);
                const addr=partes.join(', ');
                if(addr){
                    dirInput.removeEventListener('input',debouncedGeocodificar);
                    dirInput.value=addr;
                    dirInput.addEventListener('input',debouncedGeocodificar);
                    geoSetOk('Dirección actualizada desde el mapa');
                }
            }
        } catch(e){}
    }

    marker.on('dragend', function(e){
        const{lat,lng}=e.target.getLatLng();
        aplicarCoordenadas(lat,lng); reverseGeocodificar(lat,lng);
    });
    map.on('click', function(e){
        const{lat,lng}=e.latlng;
        marker.setLatLng([lat,lng]).openPopup();
        aplicarCoordenadas(lat,lng); reverseGeocodificar(lat,lng);
    });

    const debouncedGeocodificar = debounce(()=>geocodificarDireccion(dirInput.value), DEBOUNCE_MS);
    dirInput.addEventListener('input', debouncedGeocodificar);
    dirInput.addEventListener('blur', function(){if(this.value.trim().length>=5) geocodificarDireccion(this.value);});

    const COORDS_MUNICIPIOS = {
        'Neiva':[2.9274,-75.2819],'Pitalito':[1.8508,-76.0534],'Garzón':[2.1997,-75.6291],
        'La Plata':[2.3867,-75.8902],'Rivera':[2.7783,-75.2400],'Palermo':[3.0792,-75.4359],
        'Campoalegre':[2.6897,-75.3322],'Gigante':[2.3889,-75.5469],'Algeciras':[2.5267,-75.3189],
        'Acevedo':[1.8186,-75.9964],'Aipe':[3.2228,-75.2417],'Altamira':[2.0486,-75.7819],
        'Baraya':[3.1578,-75.0731],'Colombia':[3.3894,-74.8928],'Elías':[2.0278,-75.7114],
        'Hobo':[2.5706,-75.4622],'Iquira':[2.6208,-75.6328],'Isnos':[1.9394,-76.2233],
        'La Argentina':[2.2256,-75.9678],'Nátaga':[2.3122,-75.7194],'Oporapa':[1.9608,-76.0814],
        'Paicol':[2.4000,-75.7236],'Palestina':[1.7400,-76.0328],'Pital':[2.1022,-75.7197],
        'Saladoblanco':[1.9028,-76.0894],'San Agustín':[1.8681,-76.2739],'Santa María':[3.0000,-74.8833],
        'Suaza':[1.9769,-75.7958],'Tarqui':[2.1028,-75.8147],'Tello':[3.0683,-75.1342],
        'Teruel':[2.6836,-75.5756],'Tesalia':[2.4881,-75.6606],'Timaía':[1.9667,-75.9306],
        'Villavieja':[3.2256,-75.2169],'Yaguárá':[2.6619,-75.5022],
    };

    const municipioSelect = document.getElementById('municipality');
    if(municipioSelect){
        municipioSelect.addEventListener('change', function(){
            const coords=COORDS_MUNICIPIOS[this.value];
            if(coords){ map.flyTo(coords,14,{duration:1.2}); marker.setLatLng(coords).openPopup(); latInput.value=coords[0].toFixed(8); lngInput.value=coords[1].toFixed(8); geoSetOk('Centrado en '+this.value+', Huila'); }
            else if(this.value) geocodificarDireccion(this.value+', Huila, Colombia');
        });
    }

    window.sincronizarCoords = function(){
        const lat=parseFloat(latInput.value), lng=parseFloat(lngInput.value);
        if(!isNaN(lat)&&!isNaN(lng)){ marker.setLatLng([lat,lng]); map.setView([lat,lng],map.getZoom()); }
    };
    window.centrarEnNeiva = function(){ map.flyTo(NEIVA,14,{duration:1}); };

    setTimeout(()=>map.invalidateSize(), 300);

    (function(){const s=document.createElement('style'); s.textContent='@keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}'; document.head.appendChild(s);})();
})();

/* ════════ Ministerios checkboxes ════════ */
window.toggleMinisterio = function(cb) {
    const label = cb.closest('label');
    const dot   = label.querySelector('.check-indicator');
    if(cb.checked){
        label.classList.add('border-indigo-400','bg-indigo-50');
        label.classList.remove('border-slate-200','bg-slate-50');
        dot.className = 'absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-indigo-500 flex items-center justify-center check-indicator';
        dot.innerHTML = '<svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
    } else {
        label.classList.remove('border-indigo-400','bg-indigo-50');
        label.classList.add('border-slate-200','bg-slate-50');
        dot.className = 'absolute top-1.5 right-1.5 w-4 h-4 rounded-full border-2 border-slate-200 check-indicator';
        dot.innerHTML = '';
    }
};

/* ════════ Ayudas checkboxes ════════ */
window.toggleAyudaCheckbox = function(cb) {
    const label = cb.closest('label');
    const dot   = label.querySelector('.check-dot');
    if(cb.checked){
        label.classList.add('border-green-400','bg-green-50');
        label.classList.remove('border-slate-200','bg-slate-50');
        dot.className = 'w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center bg-green-500 transition-all check-dot';
        dot.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
    } else {
        label.classList.remove('border-green-400','bg-green-50');
        label.classList.add('border-slate-200','bg-slate-50');
        dot.className = 'w-5 h-5 rounded-full flex-shrink-0 border-2 border-slate-200 transition-all check-dot';
        dot.innerHTML = '';
    }
    actualizarContador();
};

function actualizarContador(){
    const n = document.querySelectorAll('.ayuda-check:checked').length;
    const el = document.getElementById('num-seleccionadas');
    if(el) el.textContent = n;
}

window.toggleTodasAyudas = function(){
    const checks = document.querySelectorAll('.ayuda-check');
    const btn    = document.getElementById('btn-toggle-ayudas');
    const todas  = [...checks].every(c=>c.checked);
    checks.forEach(c=>{ c.checked=!todas; window.toggleAyudaCheckbox(c); });
    if(btn) btn.textContent = todas ? 'Seleccionar todas' : 'Deseleccionar todas';
};

/* Alias para compatibilidad con código anterior */
window.toggleAyudaLabel = function(label){ const cb=label.querySelector('input[type="checkbox"]'); setTimeout(()=>{ window.toggleAyudaCheckbox(cb); },10); };

/* ════════ Foto preview ════════ */
window.previsualizarFotoIglesia = function(input){
    if(!input.files||!input.files[0]) return;
    const reader=new FileReader();
    reader.onload=function(e){
        const preview=document.getElementById('foto-preview');
        const icon=document.getElementById('foto-placeholder-icon');
        const wrap=document.getElementById('foto-preview-wrap');
        if(preview){ preview.src=e.target.result; preview.classList.remove('hidden'); }
        if(icon) icon.classList.add('hidden');
        if(wrap){ wrap.classList.remove('border-dashed','border-2','border-slate-200','bg-slate-50'); }
    };
    reader.readAsDataURL(input.files[0]);
};
</script>
@endpush