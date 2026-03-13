<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SIRN - Exportacion de Iglesias</title>
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

        .stats { width: 100%; border-collapse: separate; border-spacing: 5px 0; margin-bottom: 8px; }
        .stat-cell {
            width: 20%;
            background: #F8FAFC; border: 1px solid #E2E8F0;
            border-radius: 7px; padding: 6px 8px;
            text-align: center; vertical-align: middle;
        }
        .stat-num { font-size: 18px; font-weight: 700; color: #1E3A8A; line-height: 1; }
        .stat-lbl { font-size: 6.5px; color: #64748B; text-transform: uppercase; letter-spacing: 0.7px; margin-top: 2px; }
        .stat-green  .stat-num { color: #166534; }
        .stat-red    .stat-num { color: #9F1239; }
        .stat-amber  .stat-num { color: #92400E; }
        .stat-purple .stat-num { color: #5B21B6; }

        .filtros {
            background: #FFFBEB; border: 1px solid #FDE68A;
            border-radius: 5px; padding: 4px 8px;
            margin-bottom: 8px; font-size: 7.5px; color: #92400E;
        }

        .iglesia-card {
            border: 1px solid #CBD5E1;
            border-radius: 7px;
            margin-bottom: 8px;
            page-break-inside: avoid;
            overflow: hidden;
        }

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
        .card-title    { font-size: 10px; font-weight: 700; color: #fff; padding-left: 7px; }
        .card-subtitle { font-size: 7.5px; color: #93C5FD; padding-left: 7px; margin-top: 1px; }

        .badge {
            display: inline-block;
            padding: 2px 7px; border-radius: 10px;
            font-size: 7px; font-weight: 700; text-transform: uppercase;
        }
        .b-activo   { background: #DCFCE7; color: #166534; }
        .b-inactivo { background: #FFE4E6; color: #9F1239; }

        .card-body { padding: 6px 8px; }
        .sections-table { width: 100%; border-collapse: separate; border-spacing: 4px 0; }
        .section { vertical-align: top; }

        .sec-title {
            font-size: 6.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #fff; background: #334155;
            padding: 2px 5px; border-radius: 3px;
            margin-bottom: 3px;
        }

        .field { margin-bottom: 2px; line-height: 1.4; }
        .field-label { color: #94A3B8; font-size: 7px; }
        .field-val   { color: #1E293B; font-size: 7.5px; font-weight: 600; }
        .field-val.muted { color: #CBD5E1; font-weight: 400; font-style: italic; }

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

        .empty-state { text-align: center; padding: 24px; color: #94A3B8; font-style: italic; font-size: 9px; }
    </style>
</head>
<body>
{{-- Footer fijo --}}
<div class="footer">
    <table>
        <tr>
            <td><strong>SIRN</strong> &middot; Sistema de Informacion Religiosa de Neiva</td>
            <td class="center">Alcaldia Municipal de Neiva &middot; Secretaria de Gobierno &middot; Huila, Colombia</td>
            <td class="right">{{ $fecha }} &middot; {{ $hora }}</td>
        </tr>
    </table>
</div>

{{-- Header --}}
<div class="header">
    <table>
        <tr>
            <td style="width:50px;"><div class="logo-box">&#10013;</div></td>
            <td style="padding-left:10px;">
                <div class="h-title">SIRN &ndash; Sistema de Informacion Religiosa de Neiva</div>
                <div class="h-sub">Alcaldia Municipal de Neiva &middot; Secretaria de Gobierno &middot; Huila, Colombia</div>
            </td>
            <td style="text-align:right; padding-left:10px;">
                <div class="h-date">{{ $fecha }} &middot; {{ $hora }}</div>
                <div style="text-align:right; margin-top:4px;">
                    <span class="h-badge">Exportacion Oficial</span>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="accent"></div>

{{-- Stats --}}
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
            <div class="stat-num">{{ $iglesias->map(fn($i) => $i->denomination ?? $i->denominacion)->filter()->unique()->count() }}</div>
            <div class="stat-lbl">Denominaciones</div>
        </td>
        <td class="stat-cell stat-purple">
            <div class="stat-num">{{ $iglesias->filter(fn($i) => $i->entidad_registrada_colombia === 'SI')->count() }}</div>
            <div class="stat-lbl">Reg. Colombia</div>
        </td>
    </tr>
</table>

{{-- Filtros --}}
<div class="filtros">
    <strong>Filtros aplicados:</strong> {{ $filtros }}
</div>

{{-- Fichas --}}
@forelse($iglesias as $iglesia)
@php
    $nombre    = $iglesia->official_name    ?? $iglesia->nombre          ?? '&mdash;';
    $denom     = $iglesia->denomination     ?? $iglesia->denominacion    ?? '&mdash;';
    $dir       = $iglesia->address          ?? $iglesia->direccion       ?? '&mdash;';
    $pastor    = $iglesia->pastor_full_name ?? $iglesia->pastor_sacerdote ?? null;
    $tel       = $iglesia->phone_mobile     ?? $iglesia->phone_landline  ?? $iglesia->telefono ?? null;
    $correo    = $iglesia->correo_institucional ?? $iglesia->email       ?? null;
    $ubicacion = $iglesia->specific_location ?? $iglesia->comuna        ?? null;
@endphp

<div class="iglesia-card">
    <div class="card-header">
        <table>
            <tr>
                <td style="width:26px;"><div class="card-num">{{ $loop->iteration }}</div></td>
                <td>
                    <div class="card-title">{{ $nombre }}</div>
                    @if($iglesia->official_name && $iglesia->nombre && $iglesia->official_name !== $iglesia->nombre)
                        <div class="card-subtitle">Legacy: {{ $iglesia->nombre }}</div>
                    @endif
                </td>
                <td style="text-align:right; white-space:nowrap;">
                    <span class="badge {{ $iglesia->estado === 'activo' ? 'b-activo' : 'b-inactivo' }}">
                        {{ $iglesia->estado === 'activo' ? 'Activa' : 'Inactiva' }}
                    </span>
                    @if($iglesia->church_status)
                        &nbsp;<span style="font-size:7px; color:#93C5FD;">{{ $iglesia->church_status }}</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="card-body">
    <table class="sections-table">
        <tr>

            {{-- COL 1: Informacion General --}}
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
                @php $miembros = $iglesia->approx_members ?? $iglesia->promedio_asistentes; @endphp
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
                @if($iglesia->descripcion)
                <div class="field">
                    <div class="field-label">Descripcion</div>
                    <div class="field-val">{{ \Illuminate\Support\Str::limit($iglesia->descripcion, 80) }}</div>
                </div>
                @endif
            </td>

            {{-- COL 2: Ubicacion y Contacto --}}
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
                    <div class="field-label">Municipio / Dpto</div>
                    <div class="field-val">{{ $iglesia->municipality ?? $iglesia->city ?? '&mdash;' }}{{ $iglesia->department ? ', ' . $iglesia->department : '' }}</div>
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
                @if($iglesia->pastor_birth_date ?? $iglesia->fecha_nacimiento_lider)
                <div class="field">
                    <div class="field-label">Fecha Nacimiento</div>
                    <div class="field-val">
                        {{ \Carbon\Carbon::parse($iglesia->pastor_birth_date ?? $iglesia->fecha_nacimiento_lider)->format('d/m/Y') }}
                        @php $edad = $iglesia->pastor_birth_date ? \Carbon\Carbon::parse($iglesia->pastor_birth_date)->age : $iglesia->edad_lider; @endphp
                        @if($edad) <span style="color:#64748B;">({{ $edad }} a&ntilde;os)</span> @endif
                    </div>
                </div>
                @endif
                @if($iglesia->leadership_period_type)
                <div class="field">
                    <div class="field-label">Tipo Periodo</div>
                    <div class="field-val">{{ $iglesia->leadership_period_type }}</div>
                </div>
                @endif
                @if($iglesia->pastor_phone ?? $iglesia->telefono)
                <div class="field">
                    <div class="field-label">Telefono Pastor</div>
                    <div class="field-val">{{ $iglesia->pastor_phone ?? $iglesia->telefono }}</div>
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

            {{-- COL 4: Datos Juridicos --}}
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
                    <div class="field-label">N&deg; Personeria Juridica</div>
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
                    <div class="field-label">N&deg; Resolucion</div>
                    <div class="field-val">{{ $iglesia->resolution_number }}
                        @if($iglesia->resolution_date) <span style="color:#64748B;">{{ \Carbon\Carbon::parse($iglesia->resolution_date)->format('d/m/Y') }}</span> @endif
                    </div>
                </div>
                @endif
                @if($iglesia->file_number)
                <div class="field">
                    <div class="field-label">N&deg; Expediente</div>
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