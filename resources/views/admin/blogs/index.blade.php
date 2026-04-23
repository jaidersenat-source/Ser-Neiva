@extends('layouts.admin')

@section('title', 'Blog')
@section('page-title', 'Blog')
@section('page-subtitle', 'Entradas publicadas y borradores')

@section('content')

{{-- ── HERO ── --}}
<div class="relative mb-8 rounded-2xl overflow-hidden"
     style="background: linear-gradient(135deg, #78350f 0%, #b45309 45%, #f59e0b 100%);">
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-8 -right-8 w-56 h-56 rounded-full opacity-10"
             style="background: radial-gradient(circle, #fde68a, transparent 70%);"></div>
        <svg class="absolute right-0 top-0 h-full w-64 opacity-10" viewBox="0 0 200 120" preserveAspectRatio="none">
            <polygon points="80,0 200,0 200,120 140,120" fill="#fcd34d"/>
            <polygon points="115,0 200,0 200,120 170,120" fill="#fde68a"/>
            <polygon points="155,0 200,0 200,55" fill="#fef3c7"/>
        </svg>
    </div>

    <div class="relative z-10 px-6 py-6 sm:px-8 sm:py-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 text-xl"
                     style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);">
                    ✍️
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Blog</h1>
            </div>
            <p class="text-sm ml-12" style="color: rgba(254,243,199,0.9);">
                Entradas de contenido para atraer visitantes al sitio
            </p>
        </div>

        <div class="flex gap-6 ml-12 sm:ml-0">
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $blogs->total() }}</p>
                <p class="text-xs mt-0.5" style="color: rgba(254,243,199,0.85);">Total</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-extrabold text-white leading-none">
                    {{ \App\Models\Blog::publicados()->count() }}
                </p>
                <p class="text-xs mt-0.5" style="color: rgba(254,243,199,0.85);">Publicados</p>
            </div>
        </div>
    </div>
</div>

{{-- ── TOOLBAR ── --}}
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="relative">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" id="buscador-blogs"
               placeholder="Buscar entrada…"
               aria-label="Buscar entrada del blog"
               oninput="filtrarTabla(this.value)"
               class="pl-10 pr-9 py-2.5 text-sm rounded-xl border border-slate-200 bg-white
                      shadow-sm w-full sm:w-64 focus:outline-none focus:ring-2
                      focus:border-amber-400 text-slate-700 transition-all placeholder-slate-400">
        <button id="btn-clear"
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                onclick="limpiarBusqueda()" aria-label="Limpiar">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <a href="{{ route('admin.blogs.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl
              shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 active:scale-95 flex-shrink-0"
       style="background: linear-gradient(135deg, #78350f, #b45309);">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nueva Entrada
    </a>
</div>

{{-- ── TABLA ── --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Desktop --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full" id="tabla-blogs">
            <thead>
                <tr class="border-b border-slate-100" style="background: #FFFBEB;">
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4 w-12">ID</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Entrada</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden lg:table-cell">Autor</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4 hidden xl:table-cell">Fecha</th>
                    <th class="text-left text-xs font-bold text-slate-500 uppercase tracking-wider px-4 py-4">Estado</th>
                    <th class="text-right text-xs font-bold text-slate-500 uppercase tracking-wider px-6 py-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="tbody-blogs">
                @forelse($blogs as $blog)
                    <tr class="blog-row group hover:bg-amber-50/30 transition-colors duration-100"
                        data-search="{{ strtolower($blog->titulo . ' ' . ($blog->extracto ?? '') . ' ' . ($blog->autor->name ?? '')) }}">

                        <td class="px-6 py-4">
                            <span class="text-xs font-mono font-semibold text-slate-400">#{{ $blog->id }}</span>
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                @if($blog->imagen)
                                    <img src="{{ Storage::url($blog->imagen) }}"
                                         alt="{{ $blog->titulo }}"
                                         class="w-12 h-10 rounded-lg object-cover flex-shrink-0 shadow-sm">
                                @else
                                    <div class="w-12 h-10 rounded-lg flex items-center justify-center flex-shrink-0 text-base shadow-sm"
                                         style="background: linear-gradient(135deg, #78350f, #b45309);">
                                        ✍️
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight line-clamp-1">
                                        {{ $blog->titulo }}
                                    </p>
                                    @if($blog->extracto)
                                        <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[260px]">
                                            {{ $blog->extracto }}
                                        </p>
                                    @endif
                                    @if($blog->youtube_url)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-red-500 mt-0.5">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-2.74 12.69 12.69 0 0 0-6.54 0A4.83 4.83 0 0 1 5.51 6.69C3.78 8.15 3 9.85 3 12s.78 3.85 2.51 5.31a4.83 4.83 0 0 1 3.77 2.74 12.69 12.69 0 0 0 6.54 0 4.83 4.83 0 0 1 3.77-2.74C21.22 15.85 22 14.15 22 12s-.78-3.85-2.41-5.31zM10 15V9l5 3-5 3z"/>
                                            </svg>
                                            Video incluido
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-4 hidden lg:table-cell">
                            <span class="text-sm text-slate-600">{{ $blog->autor->name ?? '—' }}</span>
                        </td>

                        <td class="px-4 py-4 hidden xl:table-cell">
                            <span class="text-sm text-slate-500">
                                {{ $blog->published_at ? $blog->published_at->format('d/m/Y') : $blog->created_at->format('d/m/Y') }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            @if($blog->publicado)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                      style="background: #D1FAE5; color: #065f46;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                      style="background: #FEF3C7; color: #92400e;">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    Borrador
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.blogs.show', $blog) }}"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                                   title="Ver">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                                   title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar esta entrada del blog?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                            title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="text-4xl mb-3">✍️</div>
                            <p class="text-sm font-semibold text-slate-500">Aún no hay entradas en el blog</p>
                            <p class="text-xs text-slate-400 mt-1">Crea tu primera entrada para atraer visitantes</p>
                            <a href="{{ route('admin.blogs.create') }}"
                               class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white rounded-xl"
                               style="background: linear-gradient(135deg, #78350f, #b45309);">
                                + Nueva Entrada
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile cards --}}
    <div class="md:hidden divide-y divide-slate-50" id="mobile-blogs">
        @forelse($blogs as $blog)
            <div class="blog-row p-4"
                 data-search="{{ strtolower($blog->titulo . ' ' . ($blog->extracto ?? '') . ' ' . ($blog->autor->name ?? '')) }}">
                <div class="flex items-start gap-3">
                    @if($blog->imagen)
                        <img src="{{ Storage::url($blog->imagen) }}"
                             alt="{{ $blog->titulo }}"
                             class="w-14 h-12 rounded-xl object-cover flex-shrink-0 shadow-sm">
                    @else
                        <div class="w-14 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                             style="background: linear-gradient(135deg, #78350f, #b45309);">✍️</div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ $blog->titulo }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $blog->autor->name ?? '—' }} · {{ $blog->published_at ? $blog->published_at->format('d/m/Y') : $blog->created_at->format('d/m/Y') }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            @if($blog->publicado)
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#D1FAE5;color:#065f46;">Publicado</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#FEF3C7;color:#92400e;">Borrador</span>
                            @endif
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-xs font-semibold text-amber-700 hover:underline">Editar</a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-500 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-400 text-sm">Sin entradas aún.</div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($blogs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $blogs->links() }}
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
function filtrarTabla(q) {
    q = q.toLowerCase().trim();
    document.getElementById('btn-clear').classList.toggle('hidden', q === '');

    // Desktop
    document.querySelectorAll('#tbody-blogs .blog-row').forEach(row => {
        row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
    // Mobile
    document.querySelectorAll('#mobile-blogs .blog-row').forEach(row => {
        row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
}

function limpiarBusqueda() {
    const inp = document.getElementById('buscador-blogs');
    inp.value = '';
    filtrarTabla('');
    inp.focus();
}
</script>
@endpush
