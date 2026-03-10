@extends('layouts.admin')

@section('title', 'Inicio')
@section('page-title', 'Inicio')
@section('page-subtitle', 'Resumen general del sistema')

@section('content')

@vite(['resources/css/admin/dashboard.css'])

{{-- ═══════════════════════
     WELCOME BANNER
═══════════════════════ --}}
<div class="welcome-banner mb-5">
    <div class="relative z-10">
        <p class="welcome-eyebrow">Bienvenido de nuevo</p>
        <h2 class="welcome-name">{{ auth()->user()->name }}</h2>
        <p class="welcome-date">
            {{ now()->locale('es')->translatedFormat('l, d \d\e F \d\e Y') }}
        </p>
    </div>
    <a href="{{ route('admin.iglesias.create') }}" class="welcome-cta">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nueva Iglesia
    </a>
</div>

{{-- ═══════════════════════
     FILA 1: 4 STAT CARDS
═══════════════════════ --}}
<div class="stats-row mb-4">

    <div class="stat-card stat-card--blue">
        <div class="stat-top">
            <div class="stat-icon bg-blue-50">
                <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="stat-tag">Total</span>
        </div>
        <p class="stat-num">{{ $stats['total'] }}</p>
        <p class="stat-desc">Iglesias registradas</p>
    </div>

    <div class="stat-card stat-card--green">
        <div class="stat-top">
            <div class="stat-icon bg-green-50">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="stat-tag green">Activas</span>
        </div>
        <p class="stat-num">{{ $stats['activas'] }}</p>
        <p class="stat-desc">Iglesias activas</p>
    </div>

    <div class="stat-card stat-card--red">
        <div class="stat-top">
            <div class="stat-icon bg-red-50">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="stat-tag red">Inactivas</span>
        </div>
        <p class="stat-num">{{ $stats['inactivas'] }}</p>
        <p class="stat-desc">Iglesias inactivas</p>
    </div>

    <div class="stat-card stat-card--amber">
        <div class="stat-top">
            <div class="stat-icon bg-amber-50">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <span class="stat-tag amber">Tipos</span>
        </div>
        <p class="stat-num">{{ $stats['denominaciones'] }}</p>
        <p class="stat-desc">Denominaciones</p>
    </div>

</div>

{{-- ═══════════════════════════════════════
     FILA 2: ASISTENTES (si hay datos)
     Diseño: card izq oscura + 2 columnas
═══════════════════════════════════════ --}}
@if($stats['con_asistentes'] > 0)
<div class="asist-card mb-5">

    {{-- Panel izquierdo: KPI grande --}}
    <div class="asist-kpi">
        <div class="asist-kpi-icon">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                         M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                         m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="asist-kpi-num">~{{ number_format($stats['total_asistentes']) }}</div>
        <div class="asist-kpi-lbl">feligreses en total</div>

        <div class="asist-kpi-minis">
            <div class="asist-mini">
                <span class="asist-mini-val">{{ number_format($stats['promedio_global']) }}</span>
                <span class="asist-mini-lbl">Promedio / iglesia</span>
            </div>
            <div class="asist-mini-sep"></div>
            <div class="asist-mini">
                <span class="asist-mini-val">{{ $stats['con_asistentes'] }}</span>
                <span class="asist-mini-lbl">Con dato</span>
            </div>
        </div>
    </div>

    {{-- Panel centro: tamaños --}}
    <div class="asist-section">
        <p class="asist-section-title">Tamaño de congregaciones</p>
        @php $tot = max($tamanos['pequeña']+$tamanos['mediana']+$tamanos['grande'], 1); @endphp

        <div class="sz-row">
            <div class="sz-meta">
                <span class="sz-dot" style="background:#94A3B8;"></span>
                <span class="sz-lbl">Pequeña <em>&lt;50</em></span>
                <span class="sz-num">{{ $tamanos['pequeña'] }}</span>
            </div>
            <div class="sz-track">
                <div class="sz-bar" style="width:{{ round($tamanos['pequeña']/$tot*100) }}%;background:linear-gradient(90deg,#CBD5E1,#94A3B8);"></div>
            </div>
        </div>

        <div class="sz-row">
            <div class="sz-meta">
                <span class="sz-dot" style="background:#60A5FA;"></span>
                <span class="sz-lbl">Mediana <em>50–200</em></span>
                <span class="sz-num">{{ $tamanos['mediana'] }}</span>
            </div>
            <div class="sz-track">
                <div class="sz-bar" style="width:{{ round($tamanos['mediana']/$tot*100) }}%;background:linear-gradient(90deg,#93C5FD,#60A5FA);"></div>
            </div>
        </div>

        <div class="sz-row">
            <div class="sz-meta">
                <span class="sz-dot" style="background:#1E3A8A;"></span>
                <span class="sz-lbl">Grande <em>&gt;200</em></span>
                <span class="sz-num">{{ $tamanos['grande'] }}</span>
            </div>
            <div class="sz-track">
                <div class="sz-bar" style="width:{{ round($tamanos['grande']/$tot*100) }}%;background:linear-gradient(90deg,#3B82F6,#1E3A8A);"></div>
            </div>
        </div>

        @if($tamanos['sin_dato'] > 0)
            <p class="sz-note">{{ $tamanos['sin_dato'] }} iglesia(s) sin dato registrado</p>
        @endif
    </div>

    {{-- Panel derecha: top iglesias --}}
    @if($topIglesias->count())
    <div class="asist-section asist-section--border">
        <p class="asist-section-title">Top por asistentes</p>
        @php $maxA = $topIglesias->max('promedio_asistentes') ?: 1; @endphp
        @foreach($topIglesias as $ig)
            <a href="{{ route('admin.iglesias.show', $ig) }}" class="top-row">
                <div class="top-meta">
                    <span class="top-rank">#{{ $loop->iteration }}</span>
                    <span class="top-name">{{ Str::limit($ig->nombre, 22) }}</span>
                    <span class="top-num">{{ number_format($ig->promedio_asistentes) }}</span>
                </div>
                <div class="sz-track">
                    <div class="sz-bar" style="width:{{ round($ig->promedio_asistentes/$maxA*100) }}%;background:linear-gradient(90deg,#93C5FD,#1E3A8A);transition:width .8s cubic-bezier(.4,0,.2,1);"></div>
                </div>
            </a>
        @endforeach
    </div>
    @endif

</div>
@endif

{{-- ═══════════════════════════════════════
     FILA 3: PANELES INFERIORES
     Recientes | Denominaciones | Calendario
═══════════════════════════════════════ --}}
<div class="dash-bottom">

    {{-- ── Registros recientes ── --}}
    <div class="panel-card">
        <div class="panel-hd">
            <h3 class="panel-title">Registros recientes</h3>
            <a href="{{ route('admin.iglesias.index') }}" class="panel-link">Ver todos</a>
        </div>

        @forelse($recientes as $ig)
            <a href="{{ route('admin.iglesias.show', $ig) }}" class="ig-row group">
                <div class="ig-avatar">{{ substr($ig->nombre, 0, 1) }}</div>
                <div class="flex-1 min-w-0">
                    <p class="ig-name group-hover:text-[#1E3A8A] transition-colors">{{ $ig->nombre }}</p>
                    <p class="ig-denom">{{ $ig->denominacion }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if($ig->promedio_asistentes)
                        <span class="chip-asist">~{{ number_format($ig->promedio_asistentes) }}</span>
                    @endif
                    <span class="{{ $ig->estado === 'activo' ? 'badge-on' : 'badge-off' }}">
                        {{ $ig->estado === 'activo' ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </a>
        @empty
            <div class="ig-empty">
                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                </svg>
                <p>Sin registros aún</p>
            </div>
        @endforelse

        <div class="panel-ft">
            <a href="{{ route('admin.iglesias.create') }}" class="btn-cta">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Registrar nueva iglesia
            </a>
        </div>
    </div>

    {{-- ── Por denominación ── --}}
    <div class="panel-card flex flex-col">
        <div class="panel-hd">
            <h3 class="panel-title">Por denominación</h3>
            <span class="panel-badge">{{ $stats['activas'] }} activas</span>
        </div>

        <div class="denom-body flex-1">
            @forelse($porDenominacion as $item)
                @php
                    $pct   = $stats['activas'] > 0 ? round($item->total / $stats['activas'] * 100) : 0;
                    $clrs  = ['#1E3A8A','#16A34A','#7C3AED','#DC2626','#D97706','#0891B2'];
                    $color = $clrs[$loop->index % count($clrs)];
                @endphp
                <div class="denom-row">
                    <div class="denom-info">
                        <div class="flex items-center gap-2 min-w-0 flex-1">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $color }};"></span>
                            <span class="denom-name">{{ $item->denominacion }}</span>
                        </div>
                        <span class="denom-num">{{ $item->total }}</span>
                        <span class="denom-pct">{{ $pct }}%</span>
                    </div>
                    <div class="denom-track">
                        <div class="denom-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,{{ $color }}99,{{ $color }});"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400 text-center py-6">Sin denominaciones registradas.</p>
            @endforelse
        </div>

        <div class="panel-ft mt-auto">
            <a href="{{ route('admin.iglesias.create') }}" class="btn-cta">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Registrar nueva iglesia
            </a>
        </div>
    </div>

    {{-- ── Mini-Calendario ── --}}
    <div class="panel-card flex flex-col cal-panel">

        <div class="panel-hd">
            <h3 class="panel-title">
                <svg class="w-3.5 h-3.5 inline -mt-0.5 mr-1 text-[#1E3A8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18" stroke-width="2"/>
                </svg>
                Calendario
            </h3>
            <div class="cal-nav-group">
                <button onclick="mcNav(-1)" class="cal-nav-btn">‹</button>
                <span class="cal-month-lbl" id="mcTitle"></span>
                <button onclick="mcNav(1)"  class="cal-nav-btn">›</button>
            </div>
            <a href="{{ route('admin.eventos.calendar') }}" class="panel-link">Ver todo</a>
        </div>

        {{-- Cuadrícula --}}
        <div class="cal-grid-wrap">
            <div class="cal-dow-row">
                @foreach(['D','L','M','X','J','V','S'] as $d)
                    <div class="cal-dow">{{ $d }}</div>
                @endforeach
            </div>
            <div class="cal-days" id="mcGrid"></div>
        </div>

        {{-- Leyenda --}}
        <div class="cal-legend">
            <span class="leg-dot" style="background:#3B82F6;"></span>
            <span class="leg-txt">Evento</span>
            <span class="leg-dot" style="background:#F59E0B; margin-left:10px;"></span>
            <span class="leg-txt">Cumpleaños</span>
        </div>

        {{-- Próximos --}}
        <div class="cal-proximos">
            <p class="prox-title">Próximos</p>
            @forelse($proximosEventos as $ev)
                <div class="prox-row">
                    <span class="prox-dot" style="background:{{ $ev['tipo'] === 'cumpleaños' ? '#F59E0B' : '#3B82F6' }};"></span>
                    <div class="flex-1 min-w-0">
                        <p class="prox-label">
                            @if($ev['tipo'] === 'cumpleaños')🎂 @endif{{ $ev['label'] }}
                        </p>
                        @if(!empty($ev['iglesia']))
                            <p class="prox-sub">{{ $ev['iglesia'] }}</p>
                        @endif
                    </div>
                    <span class="prox-fecha">
                        {{ \Carbon\Carbon::parse($ev['fecha'])->translatedFormat('d M') }}
                    </span>
                </div>
            @empty
                <p class="prox-empty">Sin eventos próximos</p>
            @endforelse
        </div>

    </div>

</div>

<script>const MC_EVENTS = @json($calendarData);</script>

@push('scripts')
<script>
(function(){
    const MES = ['enero','febrero','marzo','abril','mayo','junio',
                 'julio','agosto','septiembre','octubre','noviembre','diciembre'];
    let cur = new Date(), hoy = new Date();

    function render(){
        const y=cur.getFullYear(), m=cur.getMonth();
        document.getElementById('mcTitle').textContent =
            MES[m].charAt(0).toUpperCase()+MES[m].slice(1)+' '+y;

        const fd = new Date(y,m,1).getDay(), dm = new Date(y,m+1,0).getDate();
        let h = '';
        for(let i=0;i<fd;i++) h+='<div class="mc-cell mc-empty"></div>';
        for(let d=1;d<=dm;d++){
            const ds = `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const ev = MC_EVENTS.filter(e=>e.fecha===ds);
            const isH = hoy.getFullYear()===y&&hoy.getMonth()===m&&hoy.getDate()===d;
            const haE = ev.some(e=>e.tipo==='evento');
            const haC = ev.some(e=>e.tipo==='cumpleaños');
            let cls = 'mc-cell'+(isH?' mc-today':'')+(ev.length?' mc-has':'');
            const tip = ev.map(e=>(e.tipo==='cumpleaños'?'🎂 ':'📅 ')+e.label).join('\n');
            h+=`<div class="${cls}" title="${tip.replace(/"/g,'&quot;')}" onclick="mcClickDay('${ds}')">
                    <span class="mc-num">${d}</span>
                    <div class="mc-dots">
                        ${haE?'<span class="mc-dot" style="background:#3B82F6"></span>':''}
                        ${haC?'<span class="mc-dot" style="background:#F59E0B"></span>':''}
                    </div>
                </div>`;
        }
        document.getElementById('mcGrid').innerHTML = h;
    }

    window.mcNav = dir => { cur = new Date(cur.getFullYear(), cur.getMonth()+dir, 1); render(); };
    window.mcClickDay = ds => { window.location.href='/admin/eventos?fecha='+ds; };
    render();
})();
</script>
@endpush

@endsection