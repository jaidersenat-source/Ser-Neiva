<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SIRN – Reporte de Iglesias</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #1E293B;
            background: #fff;
        }

        @page {
            margin: 12mm 10mm 18mm 10mm;
            size: A4 landscape;
        }

        /* ── Footer fijo ── */
        .footer {
            position: fixed;
            bottom: -12mm; left: 0; right: 0;
            border-top: 2px solid #1E3A8A;
            padding-top: 4px;
        }
        .footer table { width: 100%; }
        .footer td { font-size: 7.5px; color: #64748B; vertical-align: middle; }
        .footer .center { text-align: center; font-style: italic; color: #94A3B8; }
        .footer .right  { text-align: right; }

        /* ── Header ── */
        .header {
            background: #1E3A8A;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 10px;
        }
        .header table { width: 100%; }
        .header td { vertical-align: middle; }

        .logo-box {
            width: 44px; height: 44px;
            background: #F59E0B;
            border-radius: 10px;
            text-align: center; line-height: 44px;
            font-size: 22px; font-weight: 900; color: white;
        }

        .h-title {
            font-size: 15px; font-weight: 700; color: #fff;
            letter-spacing: 0.3px;
        }
        .h-sub   { font-size: 8.5px; color: #93C5FD; margin-top: 2px; }

        .h-date  { font-size: 8.5px; color: #BFDBFE; text-align: right; }
        .h-badge {
            display: inline-block;
            background: #F59E0B; color: #fff;
            font-size: 7.5px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* ── Línea decorativa ── */
        .accent { height: 3px; background: #3B82F6; border-radius: 2px; margin-bottom: 8px; }

        /* ── Stats ── */
        .stats { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-bottom: 10px; }
        .stat-cell {
            width: 25%;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 7px 10px;
            text-align: center;
            vertical-align: middle;
        }
        .stat-num { font-size: 20px; font-weight: 700; color: #1E3A8A; line-height: 1; }
        .stat-lbl { font-size: 7px; color: #64748B; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 2px; }
        .stat-green .stat-num { color: #166534; }
        .stat-red   .stat-num { color: #9F1239; }
        .stat-amber .stat-num { color: #92400E; }

        /* ── Filtros ── */
        .filtros {
            background: #FFFBEB; border: 1px solid #FDE68A;
            border-radius: 6px; padding: 5px 10px;
            margin-bottom: 10px; font-size: 8px; color: #92400E;
        }

        /* ── Tabla ── */
        .data-table { width: 100%; border-collapse: collapse; }

        .data-table thead tr { background: #1E3A8A; }
        .data-table th {
            color: #fff; padding: 6px 5px;
            font-size: 7.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.4px;
            border: 1px solid #2548a8; text-align: left;
        }
        .data-table tbody tr:nth-child(odd)  { background: #FFFFFF; }
        .data-table tbody tr:nth-child(even) { background: #F8FAFC; }
        .data-table td {
            padding: 5px 5px;
            border: 1px solid #E2E8F0;
            vertical-align: middle;
            line-height: 1.3;
        }
        .data-table td.c { text-align: center; }
        .data-table td.muted { color: #94A3B8; font-size: 7px; text-align: center; }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 2px 7px; border-radius: 10px;
            font-size: 7px; font-weight: 700; text-transform: uppercase;
        }
        .b-activo   { background: #DCFCE7; color: #166534; }
        .b-inactivo { background: #FFE4E6; color: #9F1239; }

        /* ── Chips ayudas ── */
        .chip {
            display: inline-block;
            background: #EFF6FF; color: #1E40AF;
            border: 1px solid #BFDBFE; border-radius: 8px;
            padding: 1px 5px; font-size: 6.5px; font-weight: 600;
            margin: 1px 1px 1px 0;
        }

        .empty-row { text-align: center; padding: 20px; color: #94A3B8; font-style: italic; }
    </style>
</head>
<body>

{{-- ── Footer fijo ── --}}
<div class="footer">
    <table>
        <tr>
            <td><strong>SIRN</strong> · Sistema de Información Religiosa de Neiva</td>
            <td class="center">Alcaldía Municipal de Neiva · Huila · Colombia</td>
            <td class="right">{{ $fecha }} · {{ $hora }}</td>
        </tr>
    </table>
</div>

{{-- ── Header ── --}}
<div class="header">
    <table>
        <tr>
            <td style="width:54px;">
                <div class="logo-box">✝</div>
            </td>
            <td style="padding-left:12px;">
                <div class="h-title">SIRN – Sistema de Información Religiosa de Neiva</div>
                <div class="h-sub">Alcaldía Municipal de Neiva · Secretaría de Gobierno · Huila, Colombia</div>
            </td>
            <td style="text-align:right; padding-left:10px;">
                <div class="h-date">{{ $fecha }}</div>
                <div style="text-align:right; margin-top:4px;">
                    <span class="h-badge">Reporte Oficial</span>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="accent"></div>

{{-- ── Stats ── --}}
<table class="stats">
    <tr>
        <td class="stat-cell">
            <div class="stat-num">{{ $total }}</div>
            <div class="stat-lbl">Total iglesias</div>
        </td>
        <td class="stat-cell stat-green">
            <div class="stat-num">{{ $activas }}</div>
            <div class="stat-lbl">Activas</div>
        </td>
        <td class="stat-cell stat-red">
            <div class="stat-num">{{ $inactivas }}</div>
            <div class="stat-lbl">Inactivas</div>
        </td>
        <td class="stat-cell stat-amber">
            <div class="stat-num">{{ $iglesias->pluck('denominacion')->unique()->count() }}</div>
            <div class="stat-lbl">Denominaciones</div>
        </td>
    </tr>
</table>

{{-- ── Filtros activos ── --}}
<div class="filtros">
    <strong>🔍 Filtros aplicados:</strong> {{ $filtros }}
</div>

{{-- ── Tabla de datos ── --}}
<table class="data-table">
    <thead>
        <tr>
            <th style="width:22px;">#</th>
            <th style="width:130px;">Nombre</th>
            <th style="width:80px;">Denominación</th>
            <th style="width:120px;">Dirección</th>
            <th style="width:52px;">Comuna</th>
            <th style="width:95px;">Pastor / Sacerdote</th>
            <th style="width:68px;">Teléfono</th>
            <th style="width:52px;">Estado</th>
            <th>Ayudas Sociales</th>
        </tr>
    </thead>
    <tbody>
        @forelse($iglesias as $iglesia)
        <tr>
            <td class="c" style="color:#94A3B8; font-size:7.5px;">{{ $loop->iteration }}</td>

            <td>
                <strong>{{ $iglesia->nombre }}</strong>
                @if($iglesia->email)
                    <br><span style="color:#64748B; font-size:6.5px;">{{ $iglesia->email }}</span>
                @endif
            </td>

            <td>{{ $iglesia->denominacion }}</td>

            <td style="font-size:7.5px;">
                {{ $iglesia->direccion }}
                @if($iglesia->corregimiento)
                    <br><span style="color:#94A3B8;">{{ $iglesia->corregimiento }}</span>
                @endif
            </td>

            <td class="c">{{ $iglesia->comuna ?? '—' }}</td>

            <td>{{ $iglesia->pastor_sacerdote ?? '—' }}</td>

            <td class="c">{{ $iglesia->telefono ?? '—' }}</td>

            <td class="c">
                <span class="badge {{ $iglesia->estado === 'activo' ? 'b-activo' : 'b-inactivo' }}">
                    {{ $iglesia->estado === 'activo' ? 'Activa' : 'Inactiva' }}
                </span>
            </td>

            <td>
                @if($iglesia->ayudas->isNotEmpty())
                    @foreach($iglesia->ayudas as $ayuda)
                        <span class="chip">{{ $ayuda->icono }} {{ $ayuda->nombre }}</span>
                    @endforeach
                @else
                    <span style="color:#CBD5E1; font-style:italic;">Ninguna</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="empty-row">
                No se encontraron iglesias con los filtros seleccionados.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>