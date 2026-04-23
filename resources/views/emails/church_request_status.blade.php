<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualización de solicitud — SER Neiva</title>
  <style>
    body { margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b; }
    .wrapper { max-width:600px;margin:40px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header-revisada  { background:linear-gradient(135deg,#1d4ed8,#2563eb); }
    .header-aprobada  { background:linear-gradient(135deg,#047857,#059669); }
    .header-rechazada { background:linear-gradient(135deg,#b91c1c,#dc2626); }
    .header { padding:32px 36px; }
    .header-icon { font-size:2.2rem;margin-bottom:12px; }
    .header-title { color:#fff;font-size:1.35rem;font-weight:700;margin:0 0 4px; }
    .header-sub { color:rgba(255,255,255,.75);font-size:.88rem;margin:0; }
    .body { padding:32px 36px; }
    .label { font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:4px; }
    .value { font-size:.95rem;color:#1e293b;font-weight:500;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid #f1f5f9; }
    .value:last-child { border-bottom:none; }
    .msg-box { padding:1.2rem 1.4rem;border-radius:12px;margin-bottom:1.5rem;font-size:.9rem;line-height:1.7; }
    .msg-revisada  { background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8; }
    .msg-aprobada  { background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46; }
    .msg-rechazada { background:#fef2f2;border:1px solid #fecaca;color:#991b1b; }
    .motivo-box { background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:1rem 1.2rem;margin-top:1rem;font-size:.88rem;color:#92400e;line-height:1.6; }
    .footer { background:#f8fafc;padding:20px 36px;text-align:center;color:#94a3b8;font-size:.78rem;border-top:1px solid #e2e8f0; }
    .btn { display:inline-block;padding:11px 26px;border-radius:10px;text-decoration:none;font-weight:700;font-size:.88rem;margin-top:12px; }
    .btn-aprobada { background:linear-gradient(135deg,#047857,#059669);color:#fff; }
  </style>
</head>
<body>
  <div class="wrapper">

    <div class="header header-{{ $estado }}">
      <div class="header-icon">
        @if($estado === 'revisada') 🔍
        @elseif($estado === 'aprobada') ✅
        @else ❌
        @endif
      </div>
      <p class="header-title">
        @if($estado === 'revisada') Tu solicitud está siendo revisada
        @elseif($estado === 'aprobada') ¡Solicitud aprobada!
        @else Solicitud no procesada
        @endif
      </p>
      <p class="header-sub">SER Neiva · Plataforma Religiosa de Neiva, Huila</p>
    </div>

    <div class="body">
      <p style="font-size:.95rem;color:#475569;margin:0 0 20px;">
        Hola <strong>{{ $req->lider_religioso }}</strong>, te informamos sobre el estado de la solicitud de
        <strong>{{ $req->nombre_organizacion }}</strong>:
      </p>

      {{-- Mensaje según estado --}}
      <div class="msg-box msg-{{ $estado }}">
        @if($estado === 'revisada')
          <strong>🔍 En revisión.</strong> Hemos recibido tu solicitud y nuestro equipo la está analizando.
          En breve nos pondremos en contacto contigo para confirmar los datos o solicitarte información adicional.
        @elseif($estado === 'aprobada')
          <strong>🎉 ¡Felicitaciones!</strong> Tu solicitud ha sido <strong>aprobada</strong>.
          Pronto recibirás un correo adicional con tus credenciales de acceso (usuario y contraseña) para que puedas
          ingresar al sistema y actualizar toda la información de tu organización en la plataforma.
        @else
          Lamentablemente tu solicitud <strong>no pudo ser procesada</strong> en esta oportunidad.
          A continuación encontrarás el motivo indicado por nuestro equipo.
        @endif
      </div>

      {{-- Motivo de rechazo --}}
      @if($estado === 'rechazada' && $req->motivo_rechazo)
      <div>
        <div class="label">Motivo del rechazo</div>
        <div class="motivo-box">{{ $req->motivo_rechazo }}</div>
      </div>
      @endif

      {{-- Datos de la solicitud --}}
      <div style="margin-top:1.5rem;">
        <div class="label">Organización</div>
        <div class="value">{{ $req->nombre_organizacion }}</div>

        <div class="label">Líder religioso</div>
        <div class="value">{{ $req->lider_religioso }}</div>

        <div class="label">Correo registrado</div>
        <div class="value">{{ $req->email }}</div>
      </div>

      {{-- CTA solo para aprobados --}}
      @if($estado === 'aprobada')
      <div style="text-align:center;margin-top:1.5rem;">
        <p style="font-size:.85rem;color:#64748b;margin-bottom:.5rem;">
          Cuando recibas tus credenciales, podrás acceder desde aquí:
        </p>
        <a href="{{ url('/login') }}" class="btn btn-aprobada">
          Ir al panel de acceso →
        </a>
      </div>
      @endif

      @if($estado === 'rechazada')
      <p style="font-size:.83rem;color:#64748b;margin-top:1.5rem;">
        Si crees que hay un error o deseas aclarar algún punto, puedes contactarnos respondiendo este correo
        o escribiéndonos a <a href="mailto:contacto@serneiva.org" style="color:#b45309;">contacto@serneiva.org</a>.
      </p>
      @endif
    </div>

    <div class="footer">
      Este mensaje fue generado automáticamente por SER Neiva.<br>
      {{ now()->translatedFormat('d \d\e F \d\e Y, H:i') }}
    </div>
  </div>
</body>
</html>
