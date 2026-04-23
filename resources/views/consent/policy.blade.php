
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Política de Tratamiento de Datos Personales — SER Neiva</title>
  <meta name="description" content="Política de Tratamiento y Protección de Datos Personales. Marco legal Ley 1581 de 2012." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  @vite(['resources/css/home.css'])
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --teal: #22BABB;
      --gold: #F0A500;
      --bg: #0b1220;
      --bg2: #0f1928;
      --fg: #eaf6ff;
      --muted: #8fa3bf;
      --border: rgba(255,255,255,0.08);
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Outfit', sans-serif;
      background: var(--bg);
      color: var(--fg);
      min-height: 100vh;
    }

   
    /* ══ HERO POLICY ══ */
    .policy-hero {
      padding: 7rem 1.5rem 3rem;
      max-width: 800px;
      margin: 0 auto;
    }

    .eyebrow {
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: .4rem;
    }

    .policy-hero h1 {
      font-family: 'Libre Baskerville', serif;
      font-size: clamp(1.6rem, 3.5vw, 2.4rem);
      font-weight: 700;
      color: var(--fg);
      line-height: 1.2;
      margin-bottom: 1rem;
    }
    .policy-hero h1 em {
      color: var(--teal);
      font-style: normal;
    }

    .badge-version {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      background: rgba(34,186,187,.08);
      border: 1px solid rgba(34,186,187,.2);
      border-radius: 8px;
      padding: .4rem .9rem;
    }
    .badge-version span {
      font-size: .72rem;
      font-weight: 700;
      color: var(--teal);
      letter-spacing: .05em;
      text-transform: uppercase;
    }

    /* ══ BODY ══ */
    .policy-body {
      max-width: 800px;
      margin: 0 auto;
      padding: 0 1.5rem 5rem;
    }

    .policy-card {
      background: rgba(255,255,255,.02);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2.5rem;
      font-size: .88rem;
      color: var(--muted);
      line-height: 1.75;
    }

    .policy-section {
      margin-bottom: 1.8rem;
    }
    .policy-section:last-child { margin-bottom: 0; }

    .policy-section h2 {
      font-family: 'Outfit', sans-serif;
      font-size: .78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--teal);
      margin-bottom: .55rem;
    }

    .policy-section p {
      margin: 0;
    }

    .policy-section ul {
      padding-left: 1.3rem;
      margin-top: .3rem;
    }
    .policy-section ul li {
      margin-bottom: .35rem;
    }

    .policy-divider {
      border: none;
      border-top: 1px solid var(--border);
      margin: 1.8rem 0;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      color: var(--muted);
      font-size: .82rem;
      text-decoration: none;
      margin-top: 2rem;
      transition: color .2s;
    }
    .back-link:hover { color: var(--teal); }

  </style>
</head>
<body>

<!-- ══ NAV ══ -->
<nav id="main-nav">
  <a href="{{ route('home') }}" class="nav-logo">
    <span class="nav-logo-dot"></span>
    <img src="{{ asset('images/logo.png') }}" alt="SER Neiva" class="nav-logo-img" />
    <span class="nav-logo-text">SER Neiva</span>
  </a>
  <div class="nav-links">
    <a href="#iglesias">Iglesias</a>
    <a href="#what">El Proyecto</a>
    <a href="#features">Funcionalidades</a>
    <a href="{{ route('blog.index') }}">Blog</a>
    <a href="#agenda">Agenda</a>
    <a href="#about">Nosotros</a>
    <a href="{{ route('decretos.index') }}">Normatividad</a>
    <a href="#registro" style="color:var(--teal,#22BABB);font-weight:600;">Registrar iglesia</a>
  </div>
  
  <a href="{{ route('mapa.index') }}" class="nav-cta" target="_blank">Explorar mapa →</a>
  <button class="nav-toggle" id="nav-toggle" aria-label="Menú">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile menu -->
<div class="nav-mobile" id="nav-mobile">
  <a href="#iglesias">Iglesias</a>
  <a href="#what">El Proyecto</a>
  <a href="#features">Funcionalidades</a>
  <a href="#agenda">Agenda</a>
  <a href="#about">Nosotros</a>
  <a href="{{ route('decretos.index') }}">Normatividad</a>
  <a href="{{ route('blog.index') }}">Blog</a>
  <a href="#registro" style="color:var(--teal,#22BABB);font-weight:600;">Registrar iglesia</a>
  <a href="{{ route('mapa.index') }}" class="nav-cta" target="_blank">Explorar mapa →</a>
</div>

<!-- ══ HERO ══ -->
<div class="policy-hero">
  <p class="eyebrow">Marco legal – Ley 1581 de 2012</p>
  <h1>Política de Tratamiento y<br><em>Protección de Datos Personales</em></h1>
  <div class="badge-version">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#22BABB" stroke-width="2">
      <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
    </svg>
    <span>Versión 1.0 — Vigente</span>
  </div>
</div>

<!-- ══ CONTENIDO ══ -->
<div class="policy-body">
  <div class="policy-card">

    <div class="policy-section">
      <h2>1. Identificación del Responsable del Tratamiento</h2>
      <p>La presente plataforma es operada por la comunidad responsable de la gestión de información entre iglesias participantes con fines de organización de ayudas comunitarias. Para efectos de la presente política, el "Responsable del Tratamiento" es la entidad o administración designada por la red de iglesias que utiliza este sistema.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>2. Marco Legal Aplicable</h2>
      <p>Esta política se rige por lo dispuesto en la Ley 1581 de 2012, el Decreto 1377 de 2013 y demás normas concordantes sobre protección de datos personales en la República de Colombia.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>3. Objeto</h2>
      <p>La presente Política establece los lineamientos para la recolección, almacenamiento, uso, circulación, actualización, rectificación y eliminación de los datos personales registrados en esta plataforma, garantizando el derecho constitucional al habeas data.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>4. Datos Personales Objeto de Tratamiento</h2>
      <ul>
        <li>Datos de identificación (nombre completo u otros identificadores)</li>
        <li>Datos de contacto (teléfono, correo electrónico u otros medios)</li>
        <li>Información de pertenencia a iglesias o comunidades religiosas</li>
        <li>Información relacionada con necesidades sociales, económicas o de asistencia</li>
        <li>Registros de solicitudes y asignación de ayudas</li>
        <li>Cualquier otro dato necesario para el cumplimiento de la finalidad del sistema</li>
      </ul>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>5. Finalidades del Tratamiento de los Datos</h2>
      <ul>
        <li>Gestión, administración y coordinación de ayudas comunitarias</li>
        <li>Registro y seguimiento de solicitudes de apoyo social</li>
        <li>Organización interna entre iglesias participantes</li>
        <li>Validación y actualización de información por parte de representantes autorizados</li>
        <li>Comunicación entre administradores, representantes y miembros de la comunidad</li>
        <li>Generación de reportes internos de carácter operativo y social</li>
      </ul>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>6. Usuarios con Acceso a la Información</h2>
      <p>El acceso a los datos personales estará estrictamente limitado a administradores del sistema y representantes oficialmente autorizados de cada iglesia. Cada representante podrá acceder únicamente a la información correspondiente a su iglesia o comunidad asignada, conforme a los permisos establecidos en el sistema.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>7. Autorización del Titular</h2>
      <p>El tratamiento de los datos personales requiere la autorización previa, expresa e informada del titular. Al registrarse o permitir el ingreso de su información en la plataforma, el titular autoriza de manera libre, voluntaria e inequívoca el tratamiento de sus datos conforme a esta política.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>8. Derechos del Titular</h2>
      <ul>
        <li>Conocer, actualizar y rectificar sus datos personales</li>
        <li>Solicitar prueba de la autorización otorgada</li>
        <li>Ser informado sobre el uso que se ha dado a sus datos</li>
        <li>Presentar quejas ante la Superintendencia de Industria y Comercio (SIC)</li>
        <li>Revocar la autorización y/o solicitar la supresión de los datos cuando no exista un deber legal o contractual que lo impida</li>
        <li>Acceder de forma gratuita a sus datos personales</li>
      </ul>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>9. Medidas de Seguridad</h2>
      <p>La plataforma implementa medidas técnicas, administrativas y organizativas razonables para proteger los datos personales contra pérdida, uso indebido, acceso no autorizado, alteración o destrucción. No obstante, el sistema no puede garantizar seguridad absoluta en entornos digitales, por lo que el tratamiento de la información se realiza bajo principios de diligencia y buena fe.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>10. Transferencia y Transmisión de Datos</h2>
      <p>Los datos personales no serán vendidos, cedidos ni transferidos a terceros ajenos a la comunidad, salvo en los siguientes casos: cuando exista autorización expresa del titular, cuando sea requerido por una autoridad competente, o cuando sea necesario para el cumplimiento de obligaciones legales.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>11. Conservación de la Información</h2>
      <p>Los datos personales serán conservados durante el tiempo necesario para cumplir con las finalidades descritas en esta política o mientras el titular mantenga relación activa con la comunidad, salvo obligación legal en contrario.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>12. Actualización de la Información</h2>
      <p>Los representantes autorizados de cada iglesia serán responsables de mantener actualizada la información registrada en el sistema, garantizando su veracidad, integridad y exactitud.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>13. Modificaciones a la Política</h2>
      <p>La presente política podrá ser modificada en cualquier momento para adaptarse a cambios normativos, técnicos o administrativos. Las modificaciones serán publicadas en esta misma plataforma y entrarán en vigor desde su publicación, requiriendo nueva aceptación por parte de los usuarios.</p>
    </div>

    <hr class="policy-divider">

    <div class="policy-section">
      <h2>14. Canales de Atención</h2>
      <p>Para consultas, quejas, reclamos o ejercicio de derechos relacionados con el tratamiento de datos personales, el titular podrá comunicarse con el administrador del sistema o el representante autorizado de su iglesia.</p>
    </div>

  </div>

  <a href="{{ route('home') }}" class="back-link">← Volver al inicio</a>
</div>

<!-- ══ FOOTER ══ -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <a href="#" class="footer-brand-logo">
        <span style="width:7px;height:7px;border-radius:50%;background:var(--gold);display:inline-block;"></span>
        SER Neiva
      </a>
      <p>Directorio interactivo del sector religioso de Neiva, Huila. Un proyecto de ciudad para la comunidad.</p>
    </div>
    <div class="footer-col">
      <h4>Explorar</h4>
      <ul>
        <li><a href="{{ route('mapa.index') }}" target="_blank">Mapa interactivo</a></li>
        <li><a href="#agenda">Agenda de eventos</a></li>
        <li><a href="#features">Funcionalidades</a></li>
      </ul>
    </div>
    <div class="footer-col">
  <h4>Proyecto</h4>
  <ul>
    <li><a href="#about">Sobre nosotros</a></li>
    <li><a href="#what">¿Qué es SER Neiva?</a></li>
    <li><a href="#benefits">Beneficios</a></li>
    <li><a href="{{ route('consent.policy') }}">Política de privacidad</a></li>
  </ul>
</div>
    <div class="footer-col">
      <h4>Contacto</h4>
      <ul>
        <li><a href="mailto:contacto@serneiva.org">contacto@serneiva.org</a></li>
        <li><a href="{{ route('mapa.index') }}" target="_blank">serneiva.org</a></li>
        <li><a href="#">Neiva, Huila — Colombia</a></li>
      </ul>
    </div>
  </div>
 <div class="footer-bottom">
  <p>© 2026 Jaidercode · <strong>SER Neiva</strong> ·
    <a href="https://my-portfolio-sooty-nine-14.vercel.app/" target="_blank" rel="noopener noreferrer">Ver más trabajos</a>
  </p>
  <div class="footer-bottom-links">
    
    <span class="footer-bottom-sep">·</span>
    <a href="{{ route('consent.policy') }}">Política de privacidad</a>
    <span class="footer-bottom-sep">·</span>
    <span>Neiva, Huila — Colombia</span>
  </div>
</div>
</footer>

<script>
  const nav = document.getElementById('main-nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  });

  document.getElementById('nav-toggle')?.addEventListener('click', () => {
    document.getElementById('nav-mobile')?.classList.toggle('open');
  });
</script>

</body>
</html>
