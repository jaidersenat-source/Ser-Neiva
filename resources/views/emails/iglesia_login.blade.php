<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de sesión — SER Neiva</title>
  <style>
    body { margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;color:#1e293b; }
    .wrapper { max-width:600px;margin:40px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:linear-gradient(135deg,#0f172a,#1e3a5f);padding:28px 36px; }
    .header-title { color:#fff;font-size:1.25rem;font-weight:700;margin:0 0 4px; }
    .header-sub { color:rgba(186,230,253,.75);font-size:.85rem;margin:0; }
    .body { padding:28px 36px; }
    .label { font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;margin-bottom:4px; }
    .value { font-size:.93rem;color:#1e293b;font-weight:500;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid #f1f5f9; }
    .alert-box { background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;padding:1rem 1.2rem;font-size:.87rem;color:#92400e;line-height:1.6;margin-bottom:1.5rem; }
    .btn { display:inline-block;background:linear-gradient(135deg,#1e3a5f,#0369a1);color:#fff;padding:11px 26px;border-radius:10px;text-decoration:none;font-weight:700;font-size:.88rem; }
    .footer { background:#f8fafc;padding:18px 36px;text-align:center;color:#94a3b8;font-size:.76rem;border-top:1px solid #e2e8f0; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <p class="header-title">🔔 Inicio de sesión registrado</p>
      <p class="header-sub">SER Neiva · Notificación al administrador</p>
    </div>
    <div class="body">
      <div class="alert-box">
        Una iglesia acaba de iniciar sesión en la plataforma SER Neiva.
      </div>

      <div class="label">Usuario</div>
      <div class="value">{{ $user->name }}</div>

      <div class="label">Correo electrónico</div>
      <div class="value"><a href="mailto:{{ $user->email }}" style="color:#0369a1;">{{ $user->email }}</a></div>

      <div class="label">Dirección IP</div>
      <div class="value">{{ $ip }}</div>

      <div class="label">Fecha y hora</div>
      <div class="value">{{ $fechaHora }}</div>

      @if($user->iglesia)
      <div class="label">Iglesia vinculada</div>
      <div class="value">{{ $user->iglesia->nombre ?? '—' }}</div>
      @endif

      <div style="text-align:center;margin-top:1.2rem;">
        <a href="{{ url('/admin/dashboard') }}" class="btn">
          Ir al panel de administración →
        </a>
      </div>
    </div>
    <div class="footer">
      Notificación automática · SER Neiva · {{ $fechaHora }}
    </div>
  </div>
</body>
</html>
