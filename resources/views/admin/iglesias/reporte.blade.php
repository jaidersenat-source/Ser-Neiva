<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SIRN – Reporte de Iglesias</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8.5px;
            color: #1E293B;
            background: #fff;
        }

        @page {
            margin: 12mm 10mm 16mm 10mm;
            size: A4 landscape;
        }

        /* ── Footer fijo ── */
        .footer {
            position: fixed;
            bottom: -10mm; left: 0; right: 0;
            border-top: 1.5px solid #1E3A8A;
            padding-top: 3px;
        }
        .footer table { width: 100%; }
        .footer td { font-size: 7px; color: #64748B; vertical-align: middle; }
        .footer .center { text-align: center; font-style: italic; color: #94A3B8; }
        .footer .right  { text-align: right; }

        /* ── Header ── */
        .header {
            background: #1E3A8A;
            border-radius: 7px;
            padding: 10px 14px;
            margin-bottom: 8px;
        }
        .header table { width: 100%; }
        .header td { vertical-align: middle; }
        .logo-box {
            width: 40px; height: 40px;
            background: #F59E0B;
            border-radius: 9px;
            text-align: center; line-height: 40px;
            font-size: 20px; font-weight: 900; color: #fff;
        }
        .h-title { font-size: 14px; font-weight: 700; color: #fff; }
        .h-sub   { font-size: 8px; color: #93C5FD; margin-top: 2px; }
        .h-date  { font-size: 8px; color: #BFDBFE; text-align: right; }
        .h-badge {
            display: inline-block;
            background: #F59E0B; color: #fff;
            font-size: 7px; font-weight: 700;
            padding: 2px 9px; border-radius: 20px;
            margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;
        }

        .accent { height: 2.5px; background: #3B82F6; border-radius: 2px; margin-bottom: 7px; }

        /* ── Stats ── */
        .stats { width: 100%; border-collapse: separate; border-spacing: 5px 0; margin-bottom: 8px; }
        .stat-cell {
            width: 20%;
            background: #F8FAFC; border: 1px solid #E2E8F0;
            border-radius: 7px; padding: 6px 8px;
            text-align: center; vertical-align: middle;
        }
        .stat-num { font-size: 18px; font-weight: 700; color: #1E3A8A; line-height: 1; }
        .stat-lbl { font-size: 6.5px; color: #64748B; text-transform: uppercase; letter-spacing: 0.7px; margin-top: 2px; }
        .stat-green .stat-num { color: #166534; }
        .stat-red   .stat-num { color: #9F1239; }
        .stat-amber .stat-num { color: #92400E; }
        .stat-purple .stat-num { color: #5B21B6; }

        /* ── Filtros ── */
        .filtros {
            background: #FFFBEB; border: 1px solid #FDE68A;
            border-radius: 5px; padding: 4px 8px;
            margin-bottom: 8px; font-size: 7.5px; color: #92400E;
        }

        /* ── Ficha de iglesia ── */
        .iglesia-card {
            border: 1px solid #CBD5E1;
            border-radius: 7px;
            margin-bottom: 8px;
            page-break-inside: avoid;
            overflow: hidden;
        }

        /* Encabezado de la ficha */
        .card-header {
            background: #1E3A8A;
            padding: 6px 10px;
        }
        .card-header table { width: 100%; }
        .card-header td { vertical-align: middle; }
        .card-num {
            width: 20px; height: 20px;
            background: #F59E0B;
            border-radius: 50%;
            text-align: center; line-height: 20px;
            font-size: 8px; font-weight: 700; color: #fff;
        }
        .card-title { font-size: 10px; font-weight: 700; color: #fff; padding-left: 7px; }
        .card-subtitle { font-size: 7.5px; color: #93C5FD; padding-left: 7px; margin-top: 1px; }

        /* Badge estado en cabecera */
        .badge {
            display: inline-block;
            padding: 2px 7px; border-radius: 10px;
            font-size: 7px; font-weight: 700; text-transform: uppercase;
        }
        .b-activo   { background: #DCFCE7; color: #166534; }
        .b-inactivo { background: #FFE4E6; color: #9F1239; }

        /* Cuerpo de la ficha: grid de secciones */
        .card-body { padding: 6px 8px; }
        .sections-table { width: 100%; border-collapse: separate; border-spacing: 4px 0; }
        .section { vertical-align: top; }

        /* Título de sección */
        .sec-title {
            font-size: 6.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #fff; background: #334155;
            padding: 2px 5px; border-radius: 3px;
            margin-bottom: 3px;
        }

        /* Filas de campo dentro de sección */
        .field { margin-bottom: 2px; line-height: 1.4; }
        .field-label { color: #94A3B8; font-size: 7px; }
        .field-val   { color: #1E293B; font-size: 7.5px; font-weight: 600; }
        .field-val.muted { color: #CBD5E1; font-weight: 400; font-style: italic; }

        /* Chips ayudas */
        .chip {
            display: inline-block;
            background: #EFF6FF; color: #1E40AF;
            border: 1px solid #BFDBFE; border-radius: 6px;
            padding: 1px 4px; font-size: 6px; font-weight: 600;
            margin: 1px 1px 1px 0;
        }
        .chip-min {
            display: inline-block;
            background: #F0FDF4; color: #166534;
            border: 1px solid #BBF7D0; border-radius: 6px;
            padding: 1px 4px; font-size: 6px; font-weight: 600;
            margin: 1px 1px 1px 0;
        }

        /* Separador entre filas de fichas */
        .page-section-title {
            background: #F1F5F9; border: 1px solid #E2E8F0;
            border-radius: 5px; padding: 4px 10px;
            font-size: 8px; font-weight: 700; color: #475569;
            margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;
        }

        .empty-state { text-align: center; padding: 24px; color: #94A3B8; font-style: italic; font-size: 9px; }
    </style>
</head>
<body>

{{-- ── Footer fijo ── --}}
<div class="footer">
    <table>
        <tr>
            <td><strong>SIRN</strong> · Sistema de Información Religiosa de Neiva</td>
            <td class="center">Alcaldía Municipal de Neiva · Secretaría de Gobierno · Huila, Colombia</td>
            <td class="right">{{ $fecha }} · {{ $hora }}</td>
        </tr>
    </table>
</div>

{{-- ── Header ── --}}
<div class="header">
    <table>
        <tr>
            <td style="width:50px;"><div class="logo-box">✝</div></td>
            <td style="padding-left:10px;">
                <div class="h-title">SIRN – Sistema de Información Religiosa de Neiva</div>
                <div class="h-sub">Alcaldía Municipal de Neiva · Secretaría de Gobierno · Huila, Colombia</div>
            </td>
            <td style="text-align:right; padding-left:10px;">
                <div class="h-date">{{ $fecha }} · {{ $hora }}</div>
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
            <div class="stat-num">{{ $iglesias->pluck('denomination')->filter()->unique()->count() }}</div>
            <div class="stat-lbl">Denominaciones</div>
        </td>
        <td class="stat-cell stat-purple">
            <div class="stat-num">{{ $iglesias->filter(fn($i) => !empty($i->legal_registration_number))->count() }}</div>
            <div class="stat-lbl">Reg. Legal</div>
        </td>
    </tr>
</table>

{{-- ── Filtros activos ── --}}
<div class="filtros">
    <strong>Filtros aplicados:</strong> {{ $filtros }}
</div>

{{-- ── Fichas por iglesia ── --}}
@forelse($iglesias as $iglesia)
@php
    $nombre     = $iglesia->official_name ?? '—';
    $denom      = $iglesia->denomination ?? '—';
    $dir        = $iglesia->address ?? '—';
    $pastor     = $iglesia->pastor_full_name ?? null;
    $tel        = $iglesia->phone_mobile ?? $iglesia->phone_landline ?? null;
    $correo     = $iglesia->email ?? null;
    $ubicacion  = $iglesia->specific_location ?? $iglesia->comuna ?? null;
@endphp

<div class="iglesia-card">

    {{-- Encabezado de la ficha --}}
    <div class="card-header">
        <table>
            <tr>
                <td style="width:26px;"><div class="card-num">{{ $loop->iteration }}</div></td>
                <td>
                    <div class="card-title">{{ $nombre }}</div>
                </td>
                <td style="text-align:right; white-space:nowrap;">
                    <span class="badge {{ $iglesia->church_status === 'Active' ? 'b-activo' : 'b-inactivo' }}">
                        {{ $iglesia->church_status === 'Active' ? 'Activa' : 'Inactiva' }}
                    </span>
                    &nbsp;
                    @if($iglesia->church_status)
                        <span style="font-size:7px; color:#93C5FD;">{{ $iglesia->church_status }}</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- Cuerpo: 5 columnas de secciones --}}
    <div class="card-body">
    <table class="sections-table">
        <tr>

            {{-- COL 1: Información General --}}
            <td class="section" style="width:21%;">
                <div class="sec-title">Informacion General</div>

                <div class="field">
                    <div class="field-label">Denominacion</div>
                    <div class="field-val">{{ $denom }}</div>
                </div>
                @if($iglesia->confessional_character)
                <div class="field">
                    <div class="field-label">Caracter Confesional</div>
                    <div class="field-val">{{ $iglesia->confessional_character }}</div>
                </div>
                @endif
                @if($iglesia->foundation_date)
                <div class="field">
                    <div class="field-label">Fecha Fundacion</div>
                    <div class="field-val">{{ \Carbon\Carbon::parse($iglesia->foundation_date)->format('d/m/Y') }}</div>
                </div>
                @endif
                @php $miembros = $iglesia->approx_members; @endphp
                @if($miembros)
                <div class="field">
                    <div class="field-label">Aprox. Miembros</div>
                    <div class="field-val">{{ number_format($miembros) }}</div>
                </div>
                @endif
                @if($iglesia->website_or_social)
                <div class="field">
                    <div class="field-label">Web / Red Social</div>
                    <div class="field-val">{{ $iglesia->website_or_social }}</div>
                </div>
                @endif
                @if($iglesia->additional_notes)
                <div class="field">
                    <div class="field-label">Observaciones</div>
                    <div class="field-val">{{ \Illuminate\Support\Str::limit($iglesia->additional_notes, 80) }}</div>
                </div>
                @endif
            </td>

            {{-- COL 2: Ubicación y Contacto --}}
            <td class="section" style="width:21%;">
                <div class="sec-title">Ubicacion y Contacto</div>

                <div class="field">
                    <div class="field-label">Direccion</div>
                    <div class="field-val">{{ $dir }}</div>
                </div>
                @if($iglesia->neighborhood)
                <div class="field">
                    <div class="field-label">Barrio</div>
                    <div class="field-val">{{ $iglesia->neighborhood }}</div>
                </div>
                @endif
                @if($ubicacion)
                <div class="field">
                    <div class="field-label">Ubicacion especifica</div>
                    <div class="field-val">{{ $ubicacion }}</div>
                </div>
                @endif
                <div class="field">
                    <div class="field-label">Municipio / Ciudad</div>
                    <div class="field-val">{{ $iglesia->municipality ?? $iglesia->city ?? '—' }}{{ $iglesia->department ? ', ' . $iglesia->department : '' }}</div>
                </div>
                @if($iglesia->country)
                <div class="field">
                    <div class="field-label">Pais</div>
                    <div class="field-val">{{ $iglesia->country }}</div>
                </div>
                @endif
                @if($iglesia->latitud && $iglesia->longitud)
                <div class="field">
                    <div class="field-label">Coordenadas</div>
                    <div class="field-val">{{ $iglesia->latitud }}, {{ $iglesia->longitud }}</div>
                </div>
                @endif
                @if($tel)
                <div class="field">
                    <div class="field-label">Telefono / Celular</div>
                    <div class="field-val">{{ $tel }}</div>
                </div>
                @endif
                @if($correo)
                <div class="field">
                    <div class="field-label">Correo</div>
                    <div class="field-val">{{ $correo }}</div>
                </div>
                @endif
            </td>

            {{-- COL 3: Pastor Principal --}}
            <td class="section" style="width:21%;">
                <div class="sec-title">Pastor Principal</div>

                @if($pastor)
                <div class="field">
                    <div class="field-label">Nombre</div>
                    <div class="field-val">{{ $pastor }}</div>
                </div>
                @endif
                @if($iglesia->pastor_document_type || $iglesia->pastor_document_number)
                <div class="field">
                    <div class="field-label">Documento</div>
                    <div class="field-val">{{ $iglesia->pastor_document_type }} {{ $iglesia->pastor_document_number }}</div>
                </div>
                @endif
                @if($iglesia->pastor_birth_date)
                <div class="field">
                    <div class="field-label">Fecha Nacimiento</div>
                    <div class="field-val">{{ \Carbon\Carbon::parse($iglesia->pastor_birth_date)->format('d/m/Y') }}
                        @php $edad = \Carbon\Carbon::parse($iglesia->pastor_birth_date)->age; @endphp
                        @if($edad) <span style="color:#64748B;">({{ $edad }} años)</span> @endif
                    </div>
                </div>
                @endif
                @if($iglesia->leadership_period_type)
                <div class="field">
                    <div class="field-label">Tipo Periodo</div>
                    <div class="field-val">{{ $iglesia->leadership_period_type }}</div>
                </div>
                @endif
                @if($iglesia->pastor_phone)
                <div class="field">
                    <div class="field-label">Telefono Pastor</div>
                    <div class="field-val">{{ $iglesia->pastor_phone }}</div>
                </div>
                @endif
                @if($iglesia->pastor_email)
                <div class="field">
                    <div class="field-label">Email Pastor</div>
                    <div class="field-val">{{ $iglesia->pastor_email }}</div>
                </div>
                @endif
                @if($iglesia->women_leader_full_name)
                <div class="field" style="margin-top:4px;">
                    <div class="field-label">Lider de Mujeres</div>
                    <div class="field-val">{{ $iglesia->women_leader_full_name }}</div>
                </div>
                @if($iglesia->women_leader_phone)
                <div class="field">
                    <div class="field-label">Tel. Lider Mujeres</div>
                    <div class="field-val">{{ $iglesia->women_leader_phone }}</div>
                </div>
                @endif
                @endif
            </td>

            {{-- COL 4: Datos Jurídicos --}}
            <td class="section" style="width:21%;">
                <div class="sec-title">Datos Juridicos</div>

                <div class="field">
                    <div class="field-label">Registrada Colombia</div>
                    <div class="field-val">{{ $iglesia->entidad_label }}</div>
                </div>
                @if($iglesia->legal_registration_type)
                <div class="field">
                    <div class="field-label">Tipo Registro</div>
                    <div class="field-val">{{ $iglesia->legal_registration_type }}</div>
                </div>
                @endif
                @if($iglesia->legal_registration_number)
                <div class="field">
                    <div class="field-label">N° Personeria Juridica</div>
                    <div class="field-val">{{ $iglesia->legal_registration_number }}</div>
                </div>
                @endif
                @if($iglesia->legal_entity_granting)
                <div class="field">
                    <div class="field-label">Entidad que otorga</div>
                    <div class="field-val">{{ $iglesia->legal_entity_granting }}</div>
                </div>
                @endif
                @if($iglesia->resolution_number)
                <div class="field">
                    <div class="field-label">N° Resolucion</div>
                    <div class="field-val">{{ $iglesia->resolution_number }}
                        @if($iglesia->resolution_date) <span style="color:#64748B;">{{ \Carbon\Carbon::parse($iglesia->resolution_date)->format('d/m/Y') }}</span> @endif
                    </div>
                </div>
                @endif
                @if($iglesia->file_number)
                <div class="field">
                    <div class="field-label">N° Expediente</div>
                    <div class="field-val">{{ $iglesia->file_number }}</div>
                </div>
                @endif
                @if($iglesia->legal_personality_type)
                <div class="field">
                    <div class="field-label">Tipo Personeria</div>
                    <div class="field-val">{{ $iglesia->legal_personality_type }}</div>
                </div>
                @endif
                @if($iglesia->legal_notes)
                <div class="field">
                    <div class="field-label">Notas Juridicas</div>
                    <div class="field-val">{{ \Illuminate\Support\Str::limit($iglesia->legal_notes, 80) }}</div>
                </div>
                @endif
            </td>

            {{-- COL 5: Programas y Ayudas --}}
            <td class="section" style="width:16%;">
                <div class="sec-title">Programas y Ayudas</div>

                @if($iglesia->ministries)
                <div class="field">
                    <div class="field-label">Ministerios</div>
                    <div class="field-val">
                        @foreach((array)$iglesia->ministries as $min)
                            <span class="chip-min">{{ $min }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($iglesia->ayudas->isNotEmpty())
                <div class="field" style="margin-top:3px;">
                    <div class="field-label">Ayudas Sociales</div>
                    <div class="field-val">
                        @foreach($iglesia->ayudas as $ayuda)
                            <span class="chip">{{ $ayuda->nombre }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($iglesia->additional_notes)
                <div class="field" style="margin-top:3px;">
                    <div class="field-label">Notas Adicionales</div>
                    <div class="field-val">{{ \Illuminate\Support\Str::limit($iglesia->additional_notes, 100) }}</div>
                </div>
                @endif

                @if(!$iglesia->ministries && $iglesia->ayudas->isEmpty() && !$iglesia->additional_notes)
                    <div class="field-val muted">Sin programas registrados</div>
                @endif
            </td>

        </tr>
    </table>
    </div>

</div>
@empty
<div class="empty-state">No se encontraron iglesias con los filtros seleccionados.</div>
@endforelse

</body>
</html>
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
            <div class="stat-num">{{ $iglesias->pluck('denomination')->filter()->unique()->count() }}</div>
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
            <th style="width:20px;">#</th>
            <th style="width:135px;">Nombre Oficial</th>
            <th style="width:72px;">Denominación</th>
            <th style="width:105px;">Dirección</th>
            <th style="width:60px;">Municipio</th>
            <th style="width:50px;">Ubicación</th>
            <th style="width:90px;">Pastor / Sacerdote</th>
            <th style="width:65px;">Teléfono</th>
            <th style="width:48px;">Estado</th>
            <th>Ayudas Sociales</th>
        </tr>
    </thead>
    <tbody>
        @forelse($iglesias as $iglesia)
        <tr>
            <td class="c" style="color:#94A3B8; font-size:7.5px;">{{ $loop->iteration }}</td>

            <td>
                @php
                    $nombrePdf   = $iglesia->official_name;
                    $correoPdf   = $iglesia->email;
                @endphp
                <strong>{{ $nombrePdf }}</strong>
                @if($correoPdf)
                    <br><span style="color:#64748B; font-size:6.5px;">{{ $correoPdf }}</span>
                @endif
            </td>

            <td>{{ $iglesia->denomination ?? '—' }}</td>

            <td style="font-size:7.5px;">
                {{ $iglesia->address ?? '—' }}
                @if($iglesia->neighborhood)
                    <br><span style="color:#94A3B8;">{{ $iglesia->neighborhood }}</span>
                @endif
            </td>

            <td class="c" style="font-size:7.5px;">{{ $iglesia->municipality ?? '—' }}</td>

            <td class="c" style="font-size:7.5px;">{{ $iglesia->specific_location ?? $iglesia->comuna ?? '—' }}</td>

            <td>{{ $iglesia->pastor_full_name ?? '—' }}</td>

            <td class="c">
                @php $tel = $iglesia->phone_mobile ?? $iglesia->phone_landline; @endphp
                {{ $tel ?? '—' }}
            </td>

            <td class="c">
                <span class="badge {{ $iglesia->church_status === 'Active' ? 'b-activo' : 'b-inactivo' }}">
                    {{ $iglesia->church_status === 'Active' ? 'Activa' : 'Inactiva' }}
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
            <td colspan="10" class="empty-row">
                No se encontraron iglesias con los filtros seleccionados.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>