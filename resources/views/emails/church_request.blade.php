<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nueva solicitud de registro — SER Neiva</title>
  <style>
    body { margin:0; padding:0; background:#f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; color:#1e293b; }
    .wrapper { max-width:600px; margin:40px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:linear-gradient(135deg,#78350f,#b45309); padding:32px 36px; }
    .header-title { color:#fff; font-size:1.4rem; font-weight:700; margin:0 0 4px; }
    .header-sub { color:rgba(255,255,255,.75); font-size:.88rem; margin:0; }
    .body { padding:32px 36px; }
    .label { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; margin-bottom:4px; }
    .value { font-size:.97rem; color:#1e293b; font-weight:500; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9; }
    .value:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
    .badge { display:inline-block; background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:700; }
    .footer { background:#f8fafc; padding:20px 36px; text-align:center; color:#94a3b8; font-size:.78rem; border-top:1px solid #e2e8f0; }
    .btn { display:inline-block; background:linear-gradient(135deg,#78350f,#b45309); color:#fff; padding:12px 28px; border-radius:10px; text-decoration:none; font-weight:700; font-size:.9rem; margin-top:8px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <p class="header-title">Nueva solicitud de registro</p>
      <p class="header-sub">SER Neiva · Plataforma Religiosa de Neiva, Huila</p>
    </div>
    <div class="body">
      <p style="font-size:.95rem;color:#475569;margin:0 0 24px;">
        Se ha recibido una nueva solicitud de registro de iglesia u organización religiosa. Revisa los datos a continuación:
      </p>

      <div class="label">Nombre de iglesia / organización</div>
      <div class="value">{{ $req->nombre_organizacion }}</div>

      <div class="label">Líder religioso</div>
      <div class="value">{{ $req->lider_religioso }}</div>

      <div class="label">Número de contacto</div>
      <div class="value">{{ $req->telefono }}</div>

      <div class="label">Dirección</div>
      <div class="value">{{ $req->direccion }}</div>

      <div class="label">Correo electrónico</div>
      <div class="value"><a href="mailto:{{ $req->email }}" style="color:#b45309;">{{ $req->email }}</a></div>

      <div class="label">Estado</div>
      <div class="value"><span class="badge">Pendiente de revisión</span></div>

      <div style="text-align:center;margin-top:28px;">
        <a href="{{ url('/admin/church-requests') }}" class="btn">
          Ver en el panel de administración →
        </a>
      </div>
    </div>
    <div class="footer">
      Este mensaje fue generado automáticamente por SER Neiva.<br>
      {{ now()->translatedFormat('d \d\e F \d\e Y, H:i') }}
    </div>
  </div>
</body>
</html>
