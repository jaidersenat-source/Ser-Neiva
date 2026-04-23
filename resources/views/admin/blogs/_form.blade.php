{{--
    _form.blade.php – Parcial para create/edit de Blog
    Variables esperadas:
        $blog   → instancia de Blog (nueva o existente)
--}}
@php
    $editing = isset($blog) && $blog && $blog->exists;
    $inp  = 'w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:border-amber-400 focus:ring-amber-100 transition-all';
    $inpE = 'w-full px-4 py-2.5 text-sm rounded-xl border border-red-300 bg-red-50 text-slate-800 placeholder-red-300 focus:outline-none focus:ring-2 focus:border-red-400 focus:ring-red-100 transition-all';
    $lbl  = 'block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5';
    $req  = '<span class="text-red-500 ml-0.5">*</span>';
@endphp

{{-- SECCIÓN 1 – Información principal --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #FFFBEB, #FEF3C7);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #78350f, #b45309);">1</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Información principal</p>
            <p class="text-xs text-slate-400 mt-0.5">Título, extracto y estado de publicación</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Título --}}
        <div>
            <label for="titulo" class="{{ $lbl }}">Título {!! $req !!}</label>
            <input type="text" id="titulo" name="titulo" required
                   value="{{ old('titulo', $blog->titulo ?? '') }}"
                   class="{{ $errors->has('titulo') ? $inpE : $inp }}"
                   placeholder="Ej: 5 razones para visitar las iglesias de Neiva"
                   maxlength="255" autocomplete="off">
            @error('titulo')
                <p class="flex items-center gap-1.5 text-xs text-red-500 mt-1.5">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Extracto --}}
        <div>
            <label for="extracto" class="{{ $lbl }}">
                Extracto
                <span class="normal-case font-normal text-slate-400 ml-1">(resumen corto para vista previa, máx. 400 caracteres)</span>
            </label>
            <textarea id="extracto" name="extracto" rows="2"
                      maxlength="400"
                      class="{{ $errors->has('extracto') ? $inpE : $inp }}"
                      placeholder="Describe brevemente de qué trata esta entrada…">{{ old('extracto', $blog->extracto ?? '') }}</textarea>
            @error('extracto')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
            <p class="text-xs text-slate-400 mt-1">
                <span id="extracto-count">{{ strlen(old('extracto', $blog->extracto ?? '')) }}</span>/400 caracteres
            </p>
        </div>

        {{-- Publicado --}}
        <div class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-slate-50">
            <input type="hidden" name="publicado" value="0">
            <input type="checkbox" id="publicado" name="publicado" value="1"
                   {{ old('publicado', $blog->publicado ?? false) ? 'checked' : '' }}
                   class="w-4 h-4 rounded accent-amber-600 cursor-pointer">
            <div>
                <label for="publicado" class="text-sm font-semibold text-slate-700 cursor-pointer">
                    Publicar entrada
                </label>
                <p class="text-xs text-slate-400 mt-0.5">
                    Si está activo, la entrada aparecerá en el blog público.
                </p>
            </div>
        </div>

    </div>
</div>

{{-- SECCIÓN 2 – Contenido --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #FFF7ED, #FFEDD5);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #c2410c, #f97316);">2</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Contenido</p>
            <p class="text-xs text-slate-400 mt-0.5">Cuerpo completo de la entrada del blog</p>
        </div>
    </div>

    <div class="p-5">
        <label for="contenido" class="{{ $lbl }}">Contenido {!! $req !!}</label>
        <textarea id="contenido" name="contenido" rows="14" required
                  class="{{ $errors->has('contenido') ? $inpE : $inp }} font-mono text-sm leading-relaxed"
                  placeholder="Escribe aquí el contenido completo de la entrada…">{{ old('contenido', $blog->contenido ?? '') }}</textarea>
        @error('contenido')
            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
        @enderror
        <p class="text-xs text-slate-400 mt-1.5">
            Puedes usar HTML básico: <code class="bg-slate-100 px-1 rounded">&lt;b&gt;</code>, <code class="bg-slate-100 px-1 rounded">&lt;i&gt;</code>, <code class="bg-slate-100 px-1 rounded">&lt;ul&gt;</code>, <code class="bg-slate-100 px-1 rounded">&lt;a href=""&gt;</code>, <code class="bg-slate-100 px-1 rounded">&lt;h2&gt;</code>, etc.
        </p>
    </div>
</div>

{{-- SECCIÓN 3 – Multimedia --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-50"
         style="background: linear-gradient(135deg, #F0F9FF, #E0F2FE);">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-extrabold flex-shrink-0"
             style="background: linear-gradient(135deg, #0369a1, #0ea5e9);">3</div>
        <div>
            <p class="text-sm font-bold text-slate-800">Multimedia</p>
            <p class="text-xs text-slate-400 mt-0.5">Imagen de portada y video de YouTube</p>
        </div>
    </div>

    <div class="p-5 space-y-5">

        {{-- Imagen de portada --}}
        <div>
            <label class="{{ $lbl }}">Imagen de portada</label>

            @if($editing && $blog->imagen)
                <div class="mb-3 flex items-center gap-4">
                    <img src="{{ Storage::url($blog->imagen) }}"
                         alt="Portada actual"
                         class="h-24 w-40 object-cover rounded-xl shadow-sm border border-slate-200">
                    <div>
                        <p class="text-xs font-semibold text-slate-600">Imagen actual</p>
                        <p class="text-xs text-slate-400 mt-0.5">Sube una nueva imagen para reemplazarla</p>
                    </div>
                </div>
            @endif

            <label for="imagen"
                   class="flex flex-col items-center justify-center gap-2 w-full h-28 rounded-xl border-2 border-dashed border-slate-300
                          bg-slate-50 cursor-pointer hover:border-amber-400 hover:bg-amber-50/40 transition-all">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span id="imagen-label" class="text-xs text-slate-500 font-medium">
                    Haz clic para seleccionar imagen (JPG, PNG, WEBP · máx. 3 MB)
                </span>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp"
                       class="sr-only" onchange="previewImagen(this)">
            </label>

            {{-- Preview nueva imagen --}}
            <div id="imagen-preview-wrap" class="hidden mt-3">
                <img id="imagen-preview" src="#" alt="Preview"
                     class="h-32 w-auto rounded-xl shadow-sm object-cover border border-slate-200">
            </div>

            @error('imagen')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- URL de YouTube --}}
        <div>
            <label for="youtube_url" class="{{ $lbl }}">
                URL de YouTube
                <span class="normal-case font-normal text-slate-400 ml-1">(opcional)</span>
            </label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-2.74 12.69 12.69 0 0 0-6.54 0A4.83 4.83 0 0 1 5.51 6.69C3.78 8.15 3 9.85 3 12s.78 3.85 2.51 5.31a4.83 4.83 0 0 1 3.77 2.74 12.69 12.69 0 0 0 6.54 0 4.83 4.83 0 0 1 3.77-2.74C21.22 15.85 22 14.15 22 12s-.78-3.85-2.41-5.31zM10 15V9l5 3-5 3z"/>
                    </svg>
                </span>
                <input type="url" id="youtube_url" name="youtube_url"
                       value="{{ old('youtube_url', $blog->youtube_url ?? '') }}"
                       class="{{ $errors->has('youtube_url') ? $inpE : $inp }} pl-10"
                       placeholder="https://www.youtube.com/watch?v=… o https://youtu.be/…">
            </div>
            @error('youtube_url')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
            <p class="text-xs text-slate-400 mt-1.5">
                El video se mostrará embebido dentro de la entrada del blog.
                Formatos aceptados: <code class="bg-slate-100 px-1 rounded">youtube.com/watch?v=</code> · <code class="bg-slate-100 px-1 rounded">youtu.be/</code>
            </p>

            {{-- Preview embed --}}
            <div id="yt-preview" class="{{ old('youtube_url', $blog->youtube_url ?? '') ? '' : 'hidden' }} mt-3">
                <p class="text-xs font-semibold text-slate-500 mb-1.5">Vista previa del video:</p>
                <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm" style="aspect-ratio:16/9;max-width:480px;">
                        <iframe id="yt-iframe"
                            src="{{ ($blog->youtube_url ?? '') ? 'https://www.youtube.com/embed/' . ($blog->youtubeId() ?? '') . '?controls=1&rel=0&modestbranding=1' : '' }}"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            title="Preview video YouTube"></iframe>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
// Counter extracto
document.getElementById('extracto')?.addEventListener('input', function () {
    document.getElementById('extracto-count').textContent = this.value.length;
});

// Preview imagen
function previewImagen(input) {
    if (input.files && input.files[0]) {
        const label = document.getElementById('imagen-label');
        label.textContent = input.files[0].name;

        const reader = new FileReader();
        reader.onload = function (e) {
            const wrap = document.getElementById('imagen-preview-wrap');
            const img  = document.getElementById('imagen-preview');
            img.src    = e.target.result;
            wrap.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview YouTube
function extractYoutubeId(url) {
    if (!url) return null;
    let m;
    if ((m = url.match(/youtu\.be\/([a-zA-Z0-9_\-]{11})/))) return m[1];
    if ((m = url.match(/[?&]v=([a-zA-Z0-9_\-]{11})/))) return m[1];
    if ((m = url.match(/\/embed\/([a-zA-Z0-9_\-]{11})/))) return m[1];
    return null;
}

document.getElementById('youtube_url')?.addEventListener('input', function () {
    const id = extractYoutubeId(this.value.trim());
    const preview = document.getElementById('yt-preview');
    const iframe  = document.getElementById('yt-iframe');
    if (id) {
        iframe.src = `https://www.youtube.com/embed/${id}?controls=1&rel=0&modestbranding=1`;
        preview.classList.remove('hidden');
    } else {
        iframe.src = '';
        preview.classList.add('hidden');
    }
});
</script>
@endpush
