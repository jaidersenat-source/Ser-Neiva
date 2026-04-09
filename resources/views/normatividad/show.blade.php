@extends('layouts.public')
@section('title', $decreto->title)

@section('content')
<div style="max-width:860px;margin:3rem auto;padding:0 1.5rem;">

  {{-- Volver --}}
  <a href="{{ route('decretos.index') }}"
     style="color:#1e3a8a;font-size:.85rem;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:1.5rem;">
    ← Volver a Normatividad
  </a>

  {{-- Encabezado del decreto --}}
  <div style="background:#eff6ff;border-left:4px solid #1e3a8a;border-radius:0 8px 8px 0;padding:1.2rem 1.5rem;margin-bottom:1.5rem;">
    <span style="font-size:.72rem;font-weight:700;color:#1e3a8a;letter-spacing:.08em;text-transform:uppercase;">
      DECRETO No. {{ $decreto->numero }} DE {{ $decreto->anio }}
    </span>
    <h1 style="margin:.5rem 0 .4rem;font-size:1.4rem;font-weight:700;color:#111827;line-height:1.3;">
      {{ $decreto->title }}
    </h1>
    @if($decreto->summary)
      <p style="margin:0;color:#374151;font-size:.9rem;">{{ $decreto->summary }}</p>
    @endif
    <p style="margin:.6rem 0 0;color:#6b7280;font-size:.8rem;">
      Publicado: {{ $decreto->published_at ? $decreto->published_at->format('d \d\e F \d\e Y') : $decreto->created_at->format('d \d\e F \d\e Y') }}
    </p>
  </div>

  {{-- Cuerpo del decreto --}}
  <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:2rem;line-height:1.8;color:#1f2937;font-size:.95rem;white-space:pre-wrap;word-break:break-word;">
    {!! nl2br(e($decreto->body)) !!}
  </div>

  {{-- Acciones --}}
  <div style="margin-top:1.5rem;display:flex;gap:.75rem;flex-wrap:wrap;">
    @if($decreto->filename)
      <a href="{{ route('decretos.download', $decreto->id) }}"
         style="background:#1e3a8a;color:#fff;padding:.6rem 1.4rem;border-radius:7px;font-weight:600;text-decoration:none;font-size:.9rem;">
        ↓ Descargar PDF original
      </a>
    @endif
    <a href="{{ route('decretos.index') }}"
       style="background:#f3f4f6;color:#374151;padding:.6rem 1.4rem;border-radius:7px;font-weight:600;text-decoration:none;font-size:.9rem;">
      ← Volver
    </a>
  </div>

</div>
@endsection