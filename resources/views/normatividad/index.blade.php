<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SER Neiva — Normatividad</title>
  <link rel="icon" href="{{ asset('images/logo-sirn.png') }}" type="image/png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  @vite(['resources/css/home.css'])
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
    <a href="{{ route('home') }}#iglesias">Iglesias</a>
    <a href="{{ route('home') }}#what">El Proyecto</a>
    <a href="{{ route('home') }}#features">Funcionalidades</a>
    <a href="{{ route('home') }}#agenda">Agenda</a>
    <a href="{{ route('home') }}#about">Nosotros</a>
    <a href="{{ route('decretos.index') }}">Normatividad</a>
  </div>
  <a href="{{ route('mapa.index') }}" class="nav-cta" target="_blank">Explorar mapa →</a>
  <button class="nav-toggle" id="nav-toggle" aria-label="Menú">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile menu -->
<div class="nav-mobile" id="nav-mobile">
  <a href="{{ route('home') }}#iglesias">Iglesias</a>
  <a href="{{ route('home') }}#what">El Proyecto</a>
  <a href="{{ route('home') }}#features">Funcionalidades</a>
  <a href="{{ route('home') }}#agenda">Agenda</a>
  <a href="{{ route('home') }}#about">Nosotros</a>
  <a href="{{ route('decretos.index') }}">Normatividad</a>
  <a href="{{ route('mapa.index') }}" class="nav-cta" target="_blank">Explorar mapa →</a>
</div>

<!-- ══ CONTENIDO NORMATIVIDAD ══ -->
<section id="normatividad" style="padding:5rem 0 4rem;min-height:60vh;">
  <div style="max-width:860px;margin:0 auto;padding:0 1.5rem;">

    {{-- Encabezado --}}
    <div class="iglesias-header reveal" style="margin-bottom:2.5rem;">
      <p class="sec-eyebrow">Marco legal</p>
      <h2 class="sec-title">Documentos y <em>decretos</em><br>del sector religioso</h2>
      <p style="max-width:520px;">Normativa oficial relacionada con la libertad religiosa y el sector religioso del municipio de Neiva, Huila.</p>
    </div>

    {{-- Lista de decretos --}}
    @if($decretos->count())
      <div style="display:flex;flex-direction:column;gap:1.2rem;">
        @foreach($decretos as $d)
          <article class="reveal" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:14px;padding:1.6rem 1.8rem;display:flex;justify-content:space-between;align-items:center;gap:1.5rem;">

            {{-- Icono PDF --}}
            <div style="flex-shrink:0;width:44px;height:44px;background:rgba(34,186,187,.12);border-radius:10px;display:flex;align-items:center;justify-content:center;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#22BABB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
              </svg>
            </div>

            {{-- Texto --}}
            <div style="flex:1;">
              <span style="font-size:.72rem;font-weight:600;color:#22BABB;letter-spacing:.08em;text-transform:uppercase;">
                @if($d->numero && $d->numero !== '—')
                  Decreto No. {{ $d->numero }} · {{ $d->anio }}
                @else
                  {{ $d->anio }}
                @endif
                · {{ $d->published_at ? $d->published_at->format('d M Y') : $d->created_at->format('d M Y') }}
              </span>
              <h3 style="margin:.4rem 0 .5rem;font-size:1rem;font-weight:600;color:var(--fg, #eaf6ff);line-height:1.4;">
                {{ $d->title }}
              </h3>
              @if($d->summary)
                <p style="margin:0;color:var(--muted, #8fa3bf);font-size:.87rem;line-height:1.55;">
                  {{ Str::limit($d->summary, 200) }}
                </p>
              @endif
            </div>

            {{-- Botón descarga --}}
            @if($d->filename)
              <a href="{{ route('decretos.download', $d->id) }}"
                 style="flex-shrink:0;display:inline-flex;align-items:center;gap:.5rem;background:var(--teal,#22BABB);color:#0a1a2f;padding:.55rem 1.1rem;border-radius:8px;font-size:.83rem;font-weight:700;text-decoration:none;transition:opacity .2s;"
                 onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                  <polyline points="7 10 12 15 17 10"/>
                  <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Descargar PDF
              </a>
            @else
              <span style="flex-shrink:0;font-size:.78rem;color:var(--muted,#8fa3bf);font-style:italic;">PDF próximamente</span>
            @endif

          </article>
        @endforeach
      </div>
      <div style="margin-top:1.5rem;">{{ $decretos->links() }}</div>
    @else
      <p style="color:var(--muted,#8fa3bf);">No hay documentos publicados aún.</p>
    @endif

  </div>
</section>

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
    <p>© 2026 Jaidercode · Proyecto <strong>SER Neiva</strong>. <a href="https://my-portfolio-sooty-nine-14.vercel.app/" target="_blank" rel="noopener noreferrer">Ver más trabajos</a></p>
    <p>Hecho con propósito social para la ciudad de Neiva.</p>
  </div>
</footer>

<script>
  // Nav scroll
  const nav = document.getElementById('main-nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
  });

  // Mobile toggle
  const toggle = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('nav-mobile');
  toggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
    toggle.querySelectorAll('span')[0].style.transform = mobileMenu.classList.contains('open') ? 'rotate(45deg) translate(5px, 5px)' : '';
    toggle.querySelectorAll('span')[1].style.opacity = mobileMenu.classList.contains('open') ? '0' : '1';
    toggle.querySelectorAll('span')[2].style.transform = mobileMenu.classList.contains('open') ? 'rotate(-45deg) translate(5px, -5px)' : '';
  });
  mobileMenu.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      toggle.querySelectorAll('span').forEach(s => { s.style.transform = ''; s.style.opacity = '1'; });
    });
  });

  // Reveal on scroll
  const revealEls = document.querySelectorAll('.reveal, .reveal-left');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1 });
  revealEls.forEach(el => obs.observe(el));

  // Smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const href = a.getAttribute('href');
      if (href === '#') return;
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
</script>
</body>
</html>