@extends('layouts.admin')

@section('title', $blog->titulo)
@section('page-title', 'Ver Entrada del Blog')
@section('page-subtitle', $blog->titulo)

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Volver + acciones --}}
    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blogs.index') }}"
               class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors"
               title="Volver">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-slate-800">Vista previa</h2>
                <p class="text-xs text-slate-400">Así se ve la entrada del blog</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($blog->publicado)
                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Ver en sitio
                </a>
            @endif
            <a href="{{ route('admin.blogs.edit', $blog) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-white rounded-xl transition-all hover:shadow-md"
               style="background: linear-gradient(135deg, #78350f, #b45309);">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
        </div>
    </div>

    {{-- Tarjeta principal --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        {{-- Imagen de portada --}}
        @if($blog->imagen)
            <div class="w-full h-56 sm:h-72 overflow-hidden">
                <img src="{{ Storage::url($blog->imagen) }}"
                     alt="{{ $blog->titulo }}"
                     class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6 sm:p-8">

            {{-- Estado + fecha + autor --}}
            <div class="flex flex-wrap items-center gap-3 mb-4">
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
                <span class="text-xs text-slate-400">
                    {{ $blog->published_at ? $blog->published_at->translatedFormat('d \d\e F \d\e Y') : $blog->created_at->translatedFormat('d \d\e F \d\e Y') }}
                </span>
                <span class="text-xs text-slate-400">·</span>
                <span class="text-xs text-slate-500 font-medium">{{ $blog->autor->name ?? '—' }}</span>
            </div>

            {{-- Título --}}
            <h1 class="text-2xl font-bold text-slate-900 leading-tight mb-3">{{ $blog->titulo }}</h1>

            {{-- Extracto --}}
            @if($blog->extracto)
                <p class="text-slate-500 text-sm leading-relaxed mb-5 italic border-l-4 border-amber-300 pl-4">
                    {{ $blog->extracto }}
                </p>
            @endif

            <hr class="border-slate-100 mb-5">

            {{-- Contenido --}}
            <div class="prose prose-slate max-w-none text-sm leading-relaxed">
                {!! nl2br(e($blog->contenido)) !!}
            </div>

            {{-- Video YouTube --}}
            @if($blog->youtubeEmbedUrl())
                <div class="mt-8">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Video</p>
                    <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm"
                         style="aspect-ratio:16/9;">
                        <iframe src="{{ $blog->youtubeEmbedUrl() }}?controls=1&rel=0&modestbranding=1"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            title="{{ $blog->titulo }}"></iframe>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Metadatos --}}
    <div class="mt-4 bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Información técnica</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs text-slate-600">
            <div>
                <p class="text-slate-400 font-medium">ID</p>
                <p class="font-semibold font-mono">#{{ $blog->id }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-medium">Slug (URL)</p>
                <p class="font-semibold truncate">/blog/{{ $blog->slug }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-medium">Creado</p>
                <p class="font-semibold">{{ $blog->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-medium">Actualizado</p>
                <p class="font-semibold">{{ $blog->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-medium">Publicado el</p>
                <p class="font-semibold">{{ $blog->published_at ? $blog->published_at->format('d/m/Y H:i') : '—' }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-medium">YouTube</p>
                <p class="font-semibold">{{ $blog->youtube_url ? 'Sí' : 'No' }}</p>
            </div>
        </div>
    </div>

</div>

@endsection
