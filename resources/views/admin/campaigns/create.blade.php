@extends('layouts.admin')

@section('title', 'Nueva Campaña')
@section('page-title', 'Nueva Campaña')
@section('page-subtitle', 'Crear y configurar una nueva campaña de correo')

@section('content')

{{-- Hero strip --}}
<div class="relative mb-6 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #0f4c3a 0%, #065f46 45%, #059669 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="70,0 200,0 200,120 130,120" fill="#6ee7b7"/>
            <polygon points="115,0 200,0 200,120 168,120" fill="#a7f3d0"/>
            <polygon points="155,0 200,0 200,55" fill="#d1fae5"/>
        </svg>
    </div>
    <div class="relative z-10 px-6 py-5 sm:px-8 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:rgba(255,255,255,0.15); backdrop-filter:blur(8px);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight">Nueva Campaña de Correo</h2>
                <p class="text-xs mt-0.5" style="color:rgba(167,243,208,0.85);">Redacta el mensaje, sube imágenes y selecciona destinatarios</p>
            </div>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-xs" style="color:rgba(255,255,255,0.6);">
            <a href="{{ route('admin.campaigns.index') }}" class="hover:text-white transition-colors font-medium">Campañas</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-semibold">Nueva</span>
        </div>
    </div>
</div>

{{-- Errores de validación --}}
@if($errors->any())
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl mb-5"
         style="background: #FFF1F2; border: 1px solid #FECDD3;">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-bold text-red-700 mb-1">Corrige los siguientes errores:</p>
            <ul class="text-xs text-red-600 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" id="campaign-form" novalidate>
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- COLUMNA IZQUIERDA (2/3) --}}
        <div class="lg:col-span-2 flex flex-col gap-5">

            {{-- S1: Asunto y Mensaje --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#F0FDF4;">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
                         style="background: linear-gradient(135deg, #065f46, #059669);">1</div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Contenido del Correo</p>
                        <p class="text-xs text-slate-400">Escribe el asunto y el mensaje para los destinatarios</p>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    {{-- Asunto --}}
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5" for="subject">
                            Asunto del correo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="subject" name="subject"
                               value="{{ old('subject') }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 font-medium
                                      placeholder-slate-300 transition-all outline-none
                                      focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/10
                                      hover:border-slate-300 {{ $errors->has('subject') ? 'border-red-300 bg-red-50' : '' }}"
                               placeholder="Ej: Invitación al Encuentro Regional de Iglesias 2026"
                               maxlength="255" autocomplete="off">
                        @error('subject')
                            <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Mensaje --}}
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5" for="message">
                            Mensaje <span class="text-red-500">*</span>
                        </label>
                        <p class="text-[11px] text-slate-400 mb-2">Puedes usar formato: <strong>negrita</strong>, <em>cursiva</em>, listas, enlaces, etc.</p>

                        {{-- Toolbar del editor --}}
                        <div class="flex flex-wrap gap-1 mb-2 p-2 rounded-xl border border-slate-200" style="background:#FAFBFF;">
                            <button type="button" onclick="execCmd('bold')" title="Negrita"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <strong class="text-sm">B</strong>
                            </button>
                            <button type="button" onclick="execCmd('italic')" title="Cursiva"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <em class="text-sm">I</em>
                            </button>
                            <button type="button" onclick="execCmd('underline')" title="Subrayado"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <span class="text-sm underline">U</span>
                            </button>
                            <div class="w-px h-6 bg-slate-200 self-center mx-1"></div>
                            <button type="button" onclick="execCmd('insertUnorderedList')" title="Lista"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                            <button type="button" onclick="insertLink()" title="Insertar enlace"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </button>
                            <div class="w-px h-6 bg-slate-200 self-center mx-1"></div>
                            <button type="button" onclick="insertEditorImage()" title="Insertar imagen desde URL"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </button>
                            <select onchange="execCmdArg('fontSize', this.value); this.selectedIndex=0;"
                                    class="text-xs border border-slate-200 rounded-lg px-2 py-1 text-slate-500 bg-white">
                                <option value="">Tamaño</option>
                                <option value="2">Pequeño</option>
                                <option value="3">Normal</option>
                                <option value="4">Mediano</option>
                                <option value="5">Grande</option>
                            </select>
                        </div>

                        {{-- Editor contenteditable --}}
                        <div id="editor"
                             contenteditable="true"
                             class="w-full min-h-[250px] bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700
                                    outline-none transition-all focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                                    prose prose-sm max-w-none"
                             style="line-height: 1.7;">{!! old('message', '') !!}</div>
                        <textarea name="message" id="message-hidden" class="hidden">{{ old('message', '') }}</textarea>
                        @error('message')
                            <p class="flex items-center gap-1.5 text-xs font-semibold text-red-500 mt-1.5">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- S2: Imágenes --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#FFFBEB;">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
                         style="background: linear-gradient(135deg, #92400e, #d97706);">2</div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Imágenes Adjuntas</p>
                        <p class="text-xs text-slate-400">Sube imágenes que se mostrarán al final del correo (máx. 5, 2MB c/u)</p>
                    </div>
                </div>
                <div class="p-5">
                    <label class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 rounded-xl
                                  cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/30 transition-all"
                           for="images">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-500">Haz clic para seleccionar imágenes</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, GIF, WebP — máximo 2 MB cada una</p>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden"
                               onchange="previewFiles(this)">
                    </label>
                    <div id="image-preview" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4"></div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA (1/3) --}}
        <div class="flex flex-col gap-5">

            {{-- S3: Destinatarios --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50" style="background:#EFF6FF;">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-extrabold text-white flex-shrink-0"
                         style="background: linear-gradient(135deg, #0a1f5c, #1E3A8A);">3</div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Destinatarios</p>
                        <p class="text-xs text-slate-400">¿A quién enviar el correo?</p>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    {{-- Tipo de filtro --}}
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all
                                      hover:border-emerald-300 hover:bg-emerald-50/30
                                      {{ old('filter_type', 'all') === 'all' ? 'border-emerald-400 bg-emerald-50/40' : 'border-slate-200' }}">
                            <input type="radio" name="filter_type" value="all"
                                   {{ old('filter_type', 'all') === 'all' ? 'checked' : '' }}
                                   onchange="toggleFilterOptions()"
                                   class="text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Todas las iglesias</p>
                                <p class="text-[11px] text-slate-400">Enviar a todos los contactos registrados</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all
                                      hover:border-emerald-300 hover:bg-emerald-50/30
                                      {{ old('filter_type') === 'city' ? 'border-emerald-400 bg-emerald-50/40' : 'border-slate-200' }}">
                            <input type="radio" name="filter_type" value="city"
                                   {{ old('filter_type') === 'city' ? 'checked' : '' }}
                                   onchange="toggleFilterOptions()"
                                   class="text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Por ciudad</p>
                                <p class="text-[11px] text-slate-400">Solo iglesias de una ciudad específica</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all
                                      hover:border-emerald-300 hover:bg-emerald-50/30
                                      {{ old('filter_type') === 'selected' ? 'border-emerald-400 bg-emerald-50/40' : 'border-slate-200' }}">
                            <input type="radio" name="filter_type" value="selected"
                                   {{ old('filter_type') === 'selected' ? 'checked' : '' }}
                                   onchange="toggleFilterOptions()"
                                   class="text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Selección manual</p>
                                <p class="text-[11px] text-slate-400">Elegir contactos uno por uno</p>
                            </div>
                        </label>
                    </div>

                    {{-- Selector de ciudad --}}
                    <div id="city-selector" class="{{ old('filter_type') === 'city' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Ciudad</label>
                        <select name="city"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700
                                       outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10">
                            <option value="">Selecciona una ciudad...</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ old('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Selector manual de iglesias --}}
                    <div id="contacts-selector" class="{{ old('filter_type') === 'selected' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Iglesias</label>
                        <div class="max-h-64 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-50">
                            @forelse($iglesias as $iglesia)
                                <label class="flex items-center gap-3 px-3 py-2.5 cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="checkbox" name="iglesias[]" value="{{ $iglesia->id }}"
                                           {{ in_array($iglesia->id, old('iglesias', [])) ? 'checked' : '' }}
                                           class="rounded text-emerald-600 focus:ring-emerald-500">
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-slate-700 truncate">{{ $iglesia->official_name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">
                                            {{ $iglesia->pastor_email ?: $iglesia->email }}
                                            {{ ($iglesia->city ?: $iglesia->municipality) ? ' · ' . ($iglesia->city ?: $iglesia->municipality) : '' }}
                                        </p>
                                    </div>
                                </label>
                            @empty
                                <div class="p-4 text-center">
                                    <p class="text-xs text-slate-400">No hay iglesias con correo registrado.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold
                               text-white transition-all hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #065f46, #059669);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Crear Campaña y Vista Previa
                </button>

                <a href="{{ route('admin.campaigns.index') }}"
                   class="w-full inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-medium
                          text-slate-500 border border-slate-200 hover:bg-slate-50 transition-colors">
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    // === Editor WYSIWYG ===
    function execCmd(cmd) {
        document.execCommand(cmd, false, null);
        document.getElementById('editor').focus();
    }
    function execCmdArg(cmd, val) {
        if (val) document.execCommand(cmd, false, val);
        document.getElementById('editor').focus();
    }
    function insertLink() {
        const url = prompt('Ingresa la URL del enlace:', 'https://');
        if (url) document.execCommand('createLink', false, url);
    }
    function insertEditorImage() {
        const url = prompt('Ingresa la URL de la imagen:');
        if (url) document.execCommand('insertImage', false, url);
    }

    // Sincronizar editor → textarea oculto
    const editor = document.getElementById('editor');
    const hiddenField = document.getElementById('message-hidden');

    editor.addEventListener('input', () => {
        hiddenField.value = editor.innerHTML;
    });

    document.getElementById('campaign-form').addEventListener('submit', () => {
        hiddenField.value = editor.innerHTML;
    });

    // === Filtros de destinatarios ===
    function toggleFilterOptions() {
        const type = document.querySelector('input[name="filter_type"]:checked').value;
        document.getElementById('city-selector').classList.toggle('hidden', type !== 'city');
        document.getElementById('contacts-selector').classList.toggle('hidden', type !== 'selected');

        // Estilo visual
        document.querySelectorAll('input[name="filter_type"]').forEach(r => {
            const label = r.closest('label');
            if (r.checked) {
                label.classList.add('border-emerald-400', 'bg-emerald-50/40');
                label.classList.remove('border-slate-200');
            } else {
                label.classList.remove('border-emerald-400', 'bg-emerald-50/40');
                label.classList.add('border-slate-200');
            }
        });
    }

    // === Vista previa de imágenes ===
    function previewFiles(input) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        if (!input.files) return;

        Array.from(input.files).forEach((file, i) => {
            if (i >= 5) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'relative rounded-xl overflow-hidden border border-slate-200';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover" alt="Preview">
                    <p class="text-[10px] text-slate-500 truncate px-2 py-1 bg-slate-50">${file.name}</p>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush

@endsection
