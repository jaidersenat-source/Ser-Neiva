<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SER Neiva — Mapa Religioso de Neiva</title>
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
    <a href="#iglesias">Iglesias</a>
    <a href="#what">El Proyecto</a>
    <a href="#features">Funcionalidades</a>
    <a href="{{ route('blog.index') }}">Blog</a>
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
<section id="hero">
  <div class="hero-bg">
    <div class="hero-bg-img"></div>
    <div class="hero-bg-overlay"></div>
    <div class="hero-teal-accent"></div>
  </div>
  <div class="hero-grid"></div>

  <!-- Church image cards -->
  <div class="hero-cards">
    <div class="hero-card">
      <img src="{{ asset('images/hero/1.png') }}" alt="Neiva, Huila" loading="lazy" />
      <div class="hero-card-label">Neiva, Huila</div>
    </div>
    <div class="hero-card">
      <img src="{{ asset('images/hero/comunidad.jpg') }}" alt="Comunidad unida Neiva" loading="lazy" style="object-position: center 23%;" />
      <div class="hero-card-label">Comunidad — Unida</div>
    </div>
    <div class="hero-card">
      <img src="{{ asset('images/hero/actividad.jpg') }}" alt="Trabajo social Neiva" loading="lazy" style="object-position: center 25%;" />
      <div class="hero-card-label">Trabajo social</div>
    </div>
  </div>
  <br>
  <br>
  <br>
   

  <!-- Pulse pins -->
  <div class="pin-wrap p1"><div class="ping"></div></div>
  <div class="pin-wrap p2"><div class="ping"></div></div>
  <div class="pin-wrap p3"><div class="ping"></div></div>

  <!-- Content -->
  <div class="hero-content">
   
    <h1 class="hero-title">
      El mapa que<br><em>conecta</em> la fe<br>de <span class="tl">Neiva</span>
    </h1>
    <p class="hero-sub">
      Directorio interactivo con todas las iglesias de la ciudad — sus actividades, eventos y líderes religiosos en un solo lugar.
    </p>
    <div class="hero-cta-row">
      <a href="{{ route('mapa.index') }}" class="btn-main" target="_blank">
        Explorar el mapa <span class="btn-arr">→</span>
      </a>
      
      <a href="#iglesias" class="btn-ghost">Ver iglesias ↓</a>
    </div>
    <div class="hero-stats">
      <div class="stat"><div class="stat-n">200</div><div class="stat-l">Iglesias registradas</div></div>
      <div class="stat"><div class="stat-n">14</div><div class="stat-l">Denominaciones</div></div>
      <div class="stat"><div class="stat-n">360°</div><div class="stat-l">Cobertura urbana</div></div>
    </div>
  </div>

  <div class="scroll-cue">
    <span>Explorar</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- ══ IGLESIAS DESTACADAS ══ -->
<section id="iglesias">
  <div class="iglesias-inner">
    <div class="iglesias-header reveal">
      <p class="sec-eyebrow">Comunidades de fe</p>
      <h2 class="sec-title">Las <em>iglesias</em> que<br>dan vida a <span class="tl">Neiva</span></h2>
      <p>Desde la Catedral hasta los templos barriales — todas las comunidades religiosas de la ciudad en un solo mapa.</p>
    </div>

    <div class="iglesias-grid reveal">
      <!-- Featured -->
     <div class="ig-card featured">
  <img src="{{ asset('images/hero/1.png') }}" alt="Comunidad diversa de Neiva trabajando junta" loading="lazy" />
  <div class="ig-card-info">
    <div class="ig-denom">Comunidad</div>
    <div class="ig-name">Comunidad de Neiva</div>
    <div class="ig-addr">Centro Histórico, Neiva</div>
    <span class="ig-badge">Todas las denominaciones</span>
  </div>
</div>

      <!-- Small cards -->
  <div class="ig-card">
  <img src="{{ asset('images/iglesias/catolica.jpg') }}" alt="Reunión de la comunidad católica en la Parroquia Inmaculada Concepción, Neiva" loading="lazy" />
  <div class="ig-card-info">
    <div class="ig-denom">Católica</div>
    <div class="ig-name">Parroquia Inmaculada Concepción</div>
    <div class="ig-addr">Cra. 5 #7-38, Centro Histórico, Neiva</div>
  </div>
</div>

     <div class="ig-card">
  <img src="{{ asset('images/iglesias/evangelica.jpg') }}" alt="Reunión comunidad evangélica en Neiva" loading="lazy" />
  <div class="ig-card-info">
    <div class="ig-denom">Evangélica</div>
    <div class="ig-name">Iglesia Cristiana El Camino</div>
    <div class="ig-addr">Av. Circunvalar, Neiva</div>
  </div>
</div>

      <div class="ig-card">
  <img src="{{ asset('images/iglesias/adventista.jpg') }}" alt="Actividad social Iglesia Adventista en Neiva" loading="lazy" />
  <div class="ig-card-info">
    <div class="ig-denom">Adventista</div>
    <div class="ig-name">Iglesia Adventista Central</div>
    <div class="ig-addr">Cra. 10 #16-45, Neiva</div>
  </div>
</div>

      <div class="ig-card">
  <img src="{{ asset('images/iglesias/bautista.jpg') }}" alt="Jóvenes de la comunidad Bautista en Neiva" loading="lazy" />
  <div class="ig-card-info">
    <div class="ig-denom">Bautista</div>
    <div class="ig-name">Primera Iglesia Bautista</div>
    <div class="ig-addr">Calle 8 #6-15, Neiva</div>
  </div>
</div>

      <div class="ig-card">
  <img src="{{ asset('images/iglesias/judia.jpg') }}" alt="Actividad comunitaria de la comunidad judía/musulmana en Neiva" loading="lazy" />
  <div class="ig-card-info">
    <div class="ig-denom">Judía / Musulmana</div>
    <div class="ig-name">Comunidad de Neiva</div>
    <div class="ig-addr">Barrio Centro, Neiva</div>
  </div>
</div>


    <div style="text-align:center; margin-top: 3rem;" class="reveal">
      <a href="{{ route('mapa.index') }}" class="btn-main" target="_blank" style="display:inline-flex;">
        Ver todas las 200 iglesias en el mapa <span class="btn-arr">→</span>
      </a>
    </div>
  </div>
</section>

<!-- ══ QUÉ ES ══ -->
<section id="what">
  <div class="what-visual reveal-left">
    <img
      src="{{ asset('images/iglesias/comunidad.jpg') }}"
      alt="Ciudad de Neiva con comunidad diversa participando en actividades"
      loading="lazy"
    />
    <div class="what-visual-overlay"></div>

    <!-- Map dots -->
    <div class="map-dot"></div>
    <div class="map-dot"></div>
    <div class="map-dot"></div>

    <!-- Badge de número de iglesias -->
    <div class="what-map-badge">
      <div class="badge-num">200</div>
      <div class="badge-lbl">Iglesias mapeadas</div>
    </div>

    <!-- Tarjeta de info (neutral) -->
    <div class="what-card-info">
      <div class="wc-name">Comunidad de Neiva</div>
      <div class="wc-addr">Centro Histórico, Neiva</div>
      <span class="wc-tag">Todas las denominaciones</span>
    </div>
  </div>

  <div class="what-content reveal">
    <p class="sec-eyebrow">¿Qué es este proyecto?</p>
    <h2 class="sec-title">Un mapa para<br>toda la <em>comunidad</em></h2>
    <p>SER Neiva centraliza la información de todas las iglesias, templos y comunidades religiosas de la ciudad en una plataforma interactiva, pública y gratuita.</p>
    <p>Sin importar tu denominación, aquí encuentras la iglesia más cercana, sus horarios y sus actividades.</p>

    <div class="what-cards">
      <div class="wc">
        <div class="wc-icon">🗺️</div>
        <h3>Mapa interactivo</h3>
        <p>Marcadores por denominación sobre el mapa real de Neiva.</p>
      </div>
      <div class="wc">
        <div class="wc-icon">⛪</div>
        <h3>Todas las denominaciones</h3>
        <p>Católica, evangélica, pentecostal, bautista y más.</p>
      </div>
      <div class="wc">
        <div class="wc-icon">🤝</div>
        <h3>Red comunitaria</h3>
        <p>Colaboración entre iglesias para proyectos sociales.</p>
      </div>
      <div class="wc">
        <div class="wc-icon">📅</div>
        <h3>Agenda de eventos</h3>
        <p>Cultos, retiros y actividades en tiempo real.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ VIDEO ══ -->
<section id="video-sec">
  <div class="video-inner" style="max-width:1280px;margin:0 auto;">
    <div class="video-content reveal">
      <p class="sec-eyebrow">Recorrido en video</p>
      <h2 class="sec-title">Neiva y sus<br><em>comunidades</em> de fe</h2>
      <p>Conoce la riqueza espiritual y social de Neiva — una ciudad donde más de 200 comunidades religiosas trabajan juntas por el bienestar de todos.</p>
      <p>El Sector Religioso de Neiva es uno de los más activos del Huila, con iniciativas sociales, culturales y espirituales que llegan a miles de familias cada semana.</p>
      <div class="video-feature-list">
        <div class="vf-row"><div class="vf-dot"></div><div class="vf-text"><strong>Más de 200 iglesias</strong> registradas en la plataforma</div></div>
        <div class="vf-row"><div class="vf-dot"></div><div class="vf-text"><strong>14 denominaciones</strong> representadas en Neiva</div></div>
        <div class="vf-row"><div class="vf-dot"></div><div class="vf-text"><strong>Decenas de eventos</strong> comunitarios cada mes</div></div>
        <div class="vf-row"><div class="vf-dot"></div><div class="vf-text"><strong>Plataforma gratuita</strong> y abierta para toda la ciudadanía</div></div>
      </div>
    </div>

    <div class="reveal">
      <div class="video-player" id="video-player">
        <!-- Local video (lazy-loaded). Put your MP4 in public/videos/neiva.mp4 -->
        <video
          id="local-video"
          data-src="{{ asset('videos/neiva.mp4') }}"
          preload="none"
          controls
          playsinline
          style="display:none;width:100%;height:100%;object-fit:cover;filter:brightness(0.7);"
          title="Neiva Huila Colombia — Sector Religioso"
        ></video>

        <!-- Thumbnail fallback (click to load video) -->
        <img id="video-thumb" src="{{ asset('videos/neiva-thumb.png') }}" alt="Video Neiva Huila" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.7);" />

        <div class="video-player-overlay" id="play-overlay">
          <div class="play-btn">▶</div>
        </div>
        <div class="video-caption">🎬 Neiva, Huila — Sector Religioso</div>
      </div>
    </div>
  </div>
</section>

<!-- ══ BENEFICIOS ══ -->
<section id="benefits">
  <div class="benefits-inner">
    <div class="benefits-header reveal">
      <p class="sec-eyebrow">¿Para qué sirve?</p>
      <h2 class="sec-title">Lo que <em>transforma</em><br>este directorio</h2>
      <p>Una herramienta pensada para fortalecer el tejido social y espiritual de Neiva.</p>
    </div>
    <div class="benefits-row reveal">
      <div class="ben">
        <div class="ben-n">01</div>
        <div>
          <div class="ben-title">Conectar iglesias entre sí</div>
          <div class="ben-desc">Que líderes de diferentes denominaciones puedan encontrarse, comunicarse y apoyarse en proyectos comunes.</div>
        </div>
        <span class="ben-tag">Red eclesial</span>
      </div>
      <div class="ben">
        <div class="ben-n">02</div>
        <div>
          <div class="ben-title">Visibilizar actividades sociales</div>
          <div class="ben-desc">Ollas comunitarias, brigadas de salud, jornadas de alfabetización — todas las iniciativas en un solo lugar.</div>
        </div>
        <span class="ben-tag">Impacto social</span>
      </div>
      <div class="ben">
        <div class="ben-n">03</div>
        <div>
          <div class="ben-title">Informar a la ciudadanía</div>
          <div class="ben-desc">Cualquier habitante de Neiva puede encontrar la iglesia más cercana, sus horarios y sus actividades.</div>
        </div>
        <span class="ben-tag">Acceso público</span>
      </div>
      <div class="ben">
        <div class="ben-n">04</div>
        <div>
          <div class="ben-title">Apoyar la gestión institucional</div>
          <div class="ben-desc">Pastores y sacerdotes pueden actualizar sus datos y publicar eventos directamente en la plataforma.</div>
        </div>
        <span class="ben-tag">Gestión digital</span>
      </div>
    </div>
  </div>
</section>

<!-- ══ BLOG PREVIEW ══ -->
<section id="blog-preview">
  <div class="blog-inner">
    <div class="blog-header reveal">
      <div>
        <p class="sec-eyebrow">Noticias y reflexiones</p>
        <h2 class="sec-title">El <em>blog</em> del<br>sector religioso</h2>
      </div>
      <a href="{{ route('blog.index') }}" class="btn-ghost" style="margin-bottom: 0.4rem;">
        Ver todos los artículos →
      </a>
    </div>

    <div class="blog-grid reveal">
      @if(!empty($recentPosts) && $recentPosts->count())
        @foreach($recentPosts as $post)
          <article class="blog-card">
            <div class="blog-card-img">
              @if($post->imagen)
                <a href="{{ route('blog.show', $post->slug) }}">
                  <img src="{{ Storage::url($post->imagen) }}" alt="{{ $post->titulo }}" loading="lazy" />
                </a>
              @else
                <a href="{{ route('blog.show', $post->slug) }}">
                  <img src="{{ asset('images/hero/1.png') }}" alt="{{ $post->titulo }}" loading="lazy" />
                </a>
              @endif
            </div>
            <div class="blog-card-body">
              <div class="blog-card-cat">Artículo</div>
              <h3 class="blog-card-title">{{ $post->titulo }}</h3>
              @if($post->extracto)
                <p class="blog-card-excerpt">{{ Str::limit($post->extracto, 140) }}</p>
              @else
                <p class="blog-card-excerpt">{{ Str::limit(strip_tags($post->contenido), 140) }}</p>
              @endif
              <div class="blog-card-meta">
                <span>{{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : $post->created_at->translatedFormat('d M Y') }}</span>
                <a href="{{ route('blog.show', $post->slug) }}">Leer más →</a>
              </div>
            </div>
          </article>
        @endforeach
      @else
        <p style="color:var(--muted);">No hay artículos publicados todavía.</p>
      @endif
    </div>
  </div>
</section>

<!-- ══ FEATURES ══ -->
<section id="features">
  <div class="features-inner">
    <div class="features-header reveal">
      <p class="sec-eyebrow">Funcionalidades</p>
      <h2 class="sec-title">Todo lo que<br>encuentras <em>aquí</em></h2>
    </div>

    <div class="bento reveal">
      <div class="bento-card wide">
        <div>
          <div class="bento-icon">🗺️</div>
          <div class="bento-lbl">Núcleo del sistema</div>
          <div class="bento-title">Mapa interactivo en tiempo real</div>
          <div class="bento-desc">Explora el mapa de Neiva con marcadores de colores por denominación. Filtra, busca y descubre cada comunidad religiosa de la ciudad en segundos.</div>
        </div>
        <div class="map-preview">
          <div id="mini-map"></div>
        </div>
        <a href="{{ route('mapa.index') }}" class="bento-link" target="_blank">Abrir mapa →</a>
      </div>

      <div class="bento-card">
        <div>
          <div class="bento-icon">⛪</div>
          <div class="bento-lbl">Información completa</div>
          <div class="bento-title">Ficha de cada iglesia</div>
          <div class="bento-desc">Nombre, pastor, dirección, teléfono, denominación y horarios de culto — todo al alcance de un clic.</div>
        </div>
      </div>

      <div class="bento-card">
        <div>
          <div class="bento-icon">📅</div>
          <div class="bento-lbl">Organización temporal</div>
          <div class="bento-title">Agenda de actividades</div>
          <div class="bento-desc">Eventos por día, semana o mes. Cultos especiales, retiros y jornadas comunitarias en un calendario visual.</div>
        </div>
      </div>

      <div class="bento-card">
        <div>
          <div class="bento-icon">🛍️</div>
          <div class="bento-lbl">Economía local</div>
          <div class="bento-title">Emprendimientos y fundaciones</div>
          <div class="bento-desc">Negocios y organizaciones sociales vinculadas a las iglesias — visibles en el mapa con ubicación, contacto y horario.</div>
        </div>
      </div>

      <div class="bento-card">
        <div>
          <div class="bento-icon">⚽</div>
          <div class="bento-lbl">Deporte y comunidad</div>
          <div class="bento-title">Escenarios deportivos</div>
          <div class="bento-desc">Canchas, polideportivos y espacios disponibles para las iglesias — georreferenciados en el mapa de Neiva.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ REGISTRO DE IGLESIAS ══ -->
<section id="registro" style="padding:5rem 0;background:linear-gradient(160deg,#071526 0%,#0a1a2f 60%,#071e38 100%);">
  <div style="max-width:1100px;margin:0 auto;padding:0 1.5rem;">

    {{-- Alerta éxito --}}
    @if(session('registro_exitoso'))
    <div style="margin-bottom:2rem;padding:1.2rem 1.6rem;background:rgba(34,186,187,.1);border:1px solid rgba(34,186,187,.3);border-radius:14px;display:flex;align-items:flex-start;gap:.9rem;max-width:800px;margin-left:auto;margin-right:auto;">
      <svg width="22" height="22" viewBox="0 0 20 20" fill="#22BABB" style="flex-shrink:0;margin-top:1px;">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
      </svg>
      <div>
        <p style="color:#22BABB;font-weight:700;font-size:.95rem;margin:0 0 .2rem;">¡Solicitud enviada con éxito!</p>
        <p style="color:#8fa3bf;font-size:.85rem;margin:0;">
          Hemos recibido la solicitud de <strong style="color:#c9dfff;">{{ session('registro_nombre') }}</strong>.
          Nuestro equipo la revisará pronto y te contactará al correo registrado.
        </p>
      </div>
    </div>
    @endif

    {{-- Layout dos columnas --}}
    <div style="display:flex;align-items:stretch;border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,.07);">

      {{-- ── COLUMNA IZQUIERDA: Visual / Presentación ── --}}
      <div style="flex:1 1 42%;background:linear-gradient(155deg,#0d2240 0%,#0a3050 50%,#0c2a42 100%);padding:3rem 2.5rem;display:flex;flex-direction:column;justify-content:center;position:relative;overflow:hidden;border-right:1px solid rgba(34,186,187,.12);">

        {{-- Halo decorativo fondo --}}
        <div style="position:absolute;top:-80px;right:-80px;width:340px;height:340px;border-radius:50%;background:radial-gradient(circle,rgba(34,186,187,.08) 0%,transparent 70%);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-60px;left:-60px;width:260px;height:260px;border-radius:50%;background:radial-gradient(circle,rgba(13,148,136,.06) 0%,transparent 70%);pointer-events:none;"></div>

        {{-- Ilustración SVG: iglesias en red --}}
        <div style="position:relative;z-index:1;margin-bottom:2rem;">
          <svg viewBox="0 0 280 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:300px;display:block;">
            {{-- Iglesia central --}}
            <rect x="90" y="90" width="100" height="90" rx="3" fill="rgba(34,186,187,.08)" stroke="rgba(34,186,187,.2)" stroke-width="1"/>
            <polygon points="140,30 88,92 192,92" fill="rgba(34,186,187,.12)" stroke="rgba(34,186,187,.25)" stroke-width="1"/>
            <rect x="128" y="50" width="24" height="2" rx="1" fill="rgba(34,186,187,.5)"/>
            <rect x="139" y="39" width="2" height="24" rx="1" fill="rgba(34,186,187,.5)"/>
            <rect x="113" y="130" width="22" height="50" rx="2" fill="rgba(34,186,187,.07)" stroke="rgba(34,186,187,.15)" stroke-width="1"/>
            <rect x="145" y="130" width="22" height="50" rx="2" fill="rgba(34,186,187,.07)" stroke="rgba(34,186,187,.15)" stroke-width="1"/>
            <rect x="120" y="110" width="10" height="14" rx="1.5" fill="rgba(34,186,187,.2)"/>
            <rect x="150" y="110" width="10" height="14" rx="1.5" fill="rgba(34,186,187,.2)"/>
            {{-- Iglesia izquierda --}}
            <circle cx="50" cy="140" r="28" fill="rgba(13,148,136,.06)" stroke="rgba(13,148,136,.1)" stroke-width="1"/>
            <rect x="40" y="128" width="20" height="24" rx="2" fill="rgba(13,148,136,.1)" stroke="rgba(13,148,136,.18)" stroke-width="1"/>
            <polygon points="50,112 38,130 62,130" fill="rgba(13,148,136,.1)" stroke="rgba(13,148,136,.18)" stroke-width="1"/>
            <rect x="47" y="104" width="1.5" height="12" rx="1" fill="rgba(13,148,136,.3)"/>
            <rect x="44" y="107" width="8" height="1.5" rx="1" fill="rgba(13,148,136,.3)"/>
            {{-- Iglesia derecha --}}
            <circle cx="230" cy="130" r="22" fill="rgba(34,186,187,.05)" stroke="rgba(34,186,187,.1)" stroke-width="1"/>
            <rect x="221" y="120" width="18" height="22" rx="2" fill="rgba(34,186,187,.08)" stroke="rgba(34,186,187,.15)" stroke-width="1"/>
            <polygon points="230,106 219,122 241,122" fill="rgba(34,186,187,.08)" stroke="rgba(34,186,187,.15)" stroke-width="1"/>
            <rect x="228.5" y="100" width="1.5" height="10" rx="1" fill="rgba(34,186,187,.25)"/>
            <rect x="226" y="103" width="7" height="1.5" rx="1" fill="rgba(34,186,187,.25)"/>
            {{-- Nodos de conexión --}}
            <circle cx="50" cy="140" r="3" fill="rgba(34,186,187,.4)"/>
            <circle cx="140" cy="180" r="3" fill="rgba(34,186,187,.4)"/>
            <circle cx="230" cy="130" r="3" fill="rgba(34,186,187,.4)"/>
            {{-- Líneas de red --}}
            <line x1="53" y1="140" x2="137" y2="180" stroke="rgba(34,186,187,.15)" stroke-width="1" stroke-dasharray="4 3"/>
            <line x1="143" y1="179" x2="227" y2="132" stroke="rgba(34,186,187,.15)" stroke-width="1" stroke-dasharray="4 3"/>
            <line x1="53" y1="138" x2="226" y2="132" stroke="rgba(34,186,187,.08)" stroke-width="1" stroke-dasharray="3 4"/>
          </svg>
        </div>

        {{-- Eyebrow --}}
        <p style="position:relative;z-index:1;font-size:.7rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#22BABB;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
          <span style="width:24px;height:1.5px;background:#22BABB;display:inline-block;"></span>
          Red de Iglesias
        </p>

        {{-- Título --}}
        <h2 style="position:relative;z-index:1;font-size:clamp(1.4rem,2.5vw,2rem);font-weight:800;color:#fff;line-height:1.25;margin-bottom:1rem;">
          Tu iglesia merece<br>estar en el <em style="color:#22BABB;font-style:italic;">mapa</em>
        </h2>

        {{-- Descripción --}}
        <p style="position:relative;z-index:1;font-size:.88rem;color:#7a9abf;line-height:1.75;margin-bottom:1.8rem;">
          Conectamos comunidades de fe en Neiva y toda la región. El registro es gratuito y tu organización quedará visible para toda la plataforma.
        </p>

        {{-- Beneficios --}}
        <ul style="position:relative;z-index:1;list-style:none;padding:0;display:flex;flex-direction:column;gap:.7rem;">
          <li style="display:flex;align-items:center;gap:.7rem;font-size:.83rem;color:#a8c4df;">
            <span style="width:22px;height:22px;border-radius:50%;background:rgba(34,186,187,.15);border:1px solid rgba(34,186,187,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 5l2 2 4-4" stroke="#22BABB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            Visibilidad en el mapa interactivo
          </li>
          <li style="display:flex;align-items:center;gap:.7rem;font-size:.83rem;color:#a8c4df;">
            <span style="width:22px;height:22px;border-radius:50%;background:rgba(34,186,187,.15);border:1px solid rgba(34,186,187,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 5l2 2 4-4" stroke="#22BABB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            Perfil propio con información detallada
          </li>
          <li style="display:flex;align-items:center;gap:.7rem;font-size:.83rem;color:#a8c4df;">
            <span style="width:22px;height:22px;border-radius:50%;background:rgba(34,186,187,.15);border:1px solid rgba(34,186,187,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 5l2 2 4-4" stroke="#22BABB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            Proceso de verificación rápido y sin costo
          </li>
        </ul>

      </div>{{-- fin columna izquierda --}}

      {{-- ── COLUMNA DERECHA: Formulario ── --}}
      <div style="flex:1 1 58%;background:linear-gradient(180deg,#071526 0%,#0a1a2f 100%);padding:3rem 2.5rem;display:flex;flex-direction:column;justify-content:center;">

        <p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#8fa3bf;margin-bottom:.5rem;">¿Tu iglesia no está en el mapa?</p>
        <h2 style="font-size:clamp(1.4rem,2.5vw,1.9rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:1.8rem;">
          Solicita tu <em style="color:#22BABB;font-style:italic;">registro gratuito</em>
        </h2>

        {{-- Errores de validación --}}
        @if($errors->has('nombre_organizacion') || $errors->has('lider_religioso') || $errors->has('telefono') || $errors->has('direccion') || $errors->has('email') || $errors->has('consent'))
        <div style="margin-bottom:1.5rem;padding:1rem 1.4rem;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:12px;">
          <p style="color:#f87171;font-size:.85rem;font-weight:700;margin:0 0 .5rem;">Por favor corrige los siguientes errores:</p>
          <ul style="margin:0;padding-left:1.2rem;color:#fca5a5;font-size:.83rem;">
            @foreach($errors->only(['nombre_organizacion','lider_religioso','telefono','direccion','email','consent']) as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('church-request.store') }}"
              style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:16px;padding:2rem;">
          @csrf

          {{-- Nombre organización --}}
          <div style="margin-bottom:1.1rem;">
            <label for="reg_nombre" style="display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6a85a0;margin-bottom:.45rem;">
              Nombre de iglesia u organización religiosa <span style="color:#ef4444;">*</span>
            </label>
            <input type="text" id="reg_nombre" name="nombre_organizacion"
                   value="{{ old('nombre_organizacion') }}"
                   required maxlength="255"
                   placeholder="Ej: Iglesia Cristiana Ríos de Agua Viva"
                   style="width:100%;padding:.72rem 1rem;border-radius:9px;border:1px solid {{ $errors->has('nombre_organizacion') ? '#ef4444' : 'rgba(255,255,255,.09)' }};background:rgba(255,255,255,.05);color:#daeeff;font-size:.88rem;outline:none;transition:border-color .2s,background .2s;box-sizing:border-box;"
                   onfocus="this.style.borderColor='#22BABB';this.style.background='rgba(34,186,187,.05)'"
                   onblur="this.style.borderColor='{{ $errors->has('nombre_organizacion') ? '#ef4444' : 'rgba(255,255,255,.09)' }}';this.style.background='rgba(255,255,255,.05)'">
          </div>

          {{-- Líder + Teléfono en fila --}}
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.1rem;">

            <div>
              <label for="reg_lider" style="display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6a85a0;margin-bottom:.45rem;">
                Líder religioso <span style="color:#ef4444;">*</span>
              </label>
              <input type="text" id="reg_lider" name="lider_religioso"
                     value="{{ old('lider_religioso') }}"
                     required maxlength="255"
                     placeholder="Pastor / Obispo / Director"
                     style="width:100%;padding:.72rem 1rem;border-radius:9px;border:1px solid {{ $errors->has('lider_religioso') ? '#ef4444' : 'rgba(255,255,255,.09)' }};background:rgba(255,255,255,.05);color:#daeeff;font-size:.88rem;outline:none;transition:border-color .2s,background .2s;box-sizing:border-box;"
                     onfocus="this.style.borderColor='#22BABB';this.style.background='rgba(34,186,187,.05)'"
                     onblur="this.style.borderColor='rgba(255,255,255,.09)';this.style.background='rgba(255,255,255,.05)'">
            </div>

            <div>
              <label for="reg_telefono" style="display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6a85a0;margin-bottom:.45rem;">
                Número de contacto <span style="color:#ef4444;">*</span>
              </label>
              <input type="tel" id="reg_telefono" name="telefono"
                     value="{{ old('telefono') }}"
                     required maxlength="30"
                     placeholder="+57 310 000 0000"
                     style="width:100%;padding:.72rem 1rem;border-radius:9px;border:1px solid {{ $errors->has('telefono') ? '#ef4444' : 'rgba(255,255,255,.09)' }};background:rgba(255,255,255,.05);color:#daeeff;font-size:.88rem;outline:none;transition:border-color .2s,background .2s;box-sizing:border-box;"
                     onfocus="this.style.borderColor='#22BABB';this.style.background='rgba(34,186,187,.05)'"
                     onblur="this.style.borderColor='rgba(255,255,255,.09)';this.style.background='rgba(255,255,255,.05)'">
            </div>

          </div>

          {{-- Dirección --}}
          <div style="margin-bottom:1.1rem;">
            <label for="reg_direccion" style="display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6a85a0;margin-bottom:.45rem;">
              Dirección <span style="color:#ef4444;">*</span>
            </label>
            <input type="text" id="reg_direccion" name="direccion"
                   value="{{ old('direccion') }}"
                   required maxlength="500"
                   placeholder="Calle / Carrera / Barrio — Neiva, Huila"
                   style="width:100%;padding:.72rem 1rem;border-radius:9px;border:1px solid {{ $errors->has('direccion') ? '#ef4444' : 'rgba(255,255,255,.09)' }};background:rgba(255,255,255,.05);color:#daeeff;font-size:.88rem;outline:none;transition:border-color .2s,background .2s;box-sizing:border-box;"
                   onfocus="this.style.borderColor='#22BABB';this.style.background='rgba(34,186,187,.05)'"
                   onblur="this.style.borderColor='{{ $errors->has('direccion') ? '#ef4444' : 'rgba(255,255,255,.09)' }}';this.style.background='rgba(255,255,255,.05)'">
          </div>

          {{-- Correo --}}
          <div style="margin-bottom:1.4rem;">
            <label for="reg_email" style="display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6a85a0;margin-bottom:.45rem;">
              Correo electrónico <span style="color:#ef4444;">*</span>
            </label>
            <input type="email" id="reg_email" name="email"
                   value="{{ old('email') }}"
                   required maxlength="255"
                   placeholder="contacto@miorganizacion.com"
                   style="width:100%;padding:.72rem 1rem;border-radius:9px;border:1px solid {{ $errors->has('email') ? '#ef4444' : 'rgba(255,255,255,.09)' }};background:rgba(255,255,255,.05);color:#daeeff;font-size:.88rem;outline:none;transition:border-color .2s,background .2s;box-sizing:border-box;"
                   onfocus="this.style.borderColor='#22BABB';this.style.background='rgba(34,186,187,.05)'"
                   onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : 'rgba(255,255,255,.09)' }}';this.style.background='rgba(255,255,255,.05)'">
          </div>

          {{-- Consentimiento de Datos (obligatorio, Ley 1581/2012) --}}
          <div style="margin-bottom:1.4rem;padding:1rem 1.2rem;border-radius:11px;border:1px solid {{ $errors->has('consent') ? '#ef4444' : 'rgba(34,186,187,.2)' }};background:{{ $errors->has('consent') ? 'rgba(239,68,68,.05)' : 'rgba(34,186,187,.04)' }};">
            <label style="display:flex;align-items:flex-start;gap:.75rem;cursor:pointer;">
              <input type="checkbox" name="consent" id="reg_consent" value="1"
                     {{ old('consent') ? 'checked' : '' }}
                     style="margin-top:.18rem;width:17px;height:17px;flex-shrink:0;accent-color:#22BABB;cursor:pointer;">
              <span style="font-size:.80rem;color:#a8c4df;line-height:1.55;">
                He leído, entiendo y acepto la
                <a href="{{ route('consent.policy') }}" target="_blank"
                   style="color:#22BABB;text-decoration:underline;">Política de Tratamiento de Datos Personales</a>
                y autorizo el uso de la información conforme a lo establecido.
                <span style="color:#ef4444;font-weight:700;">*</span>
              </span>
            </label>
            @error('consent')
              <p style="color:#f87171;font-size:.78rem;margin:.45rem 0 0 1.6rem;">{{ $message }}</p>
            @enderror
          </div>

          {{-- Botón submit --}}
          <button type="submit"
                  style="width:100%;padding:.9rem 1.2rem;border-radius:11px;border:none;cursor:pointer;font-size:.92rem;font-weight:700;color:#071526;background:linear-gradient(130deg,#22BABB 0%,#0d9488 100%);transition:opacity .2s,transform .15s;letter-spacing:.02em;"
                  onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'"
                  onmousedown="this.style.transform='scale(.98)'" onmouseup="this.style.transform='scale(1)'">
            Enviar solicitud de registro →
          </button>

          <p style="text-align:center;font-size:.73rem;color:rgba(143,163,191,.45);margin-top:.75rem;">
            Tu información es confidencial y solo será usada para el proceso de registro.
          </p>

        </form>

      </div>{{-- fin columna derecha --}}

    </div>{{-- fin layout dos columnas --}}

  </div>
</section>

<!-- ══ AGENDA ══ -->
<section id="agenda">
  <div class="agenda-inner">
    <div class="reveal">
      <p class="sec-eyebrow">Eventos y actividades</p>
      <h2 class="sec-title">La agenda <em>viva</em><br>del sector religioso</h2>
      <p style="color:var(--muted);margin-top:0.8rem;max-width:460px;font-size:0.88rem;">
        Cada iglesia puede publicar sus actividades. El resultado: un calendario colectivo que refleja la riqueza espiritual de Neiva.
      </p>
    </div>

    <div class="agenda-layout reveal">
      <!-- Calendar -->
      <div class="cal">
        <div class="cal-head">
          <span class="cal-month">Abril 2025</span>
          <div class="cal-nav">
            <button>‹</button>
            <button>›</button>
          </div>
        </div>
        <div class="cal-dh">
          <div class="cal-dl">Do</div><div class="cal-dl">Lu</div><div class="cal-dl">Ma</div>
          <div class="cal-dl">Mi</div><div class="cal-dl">Ju</div><div class="cal-dl">Vi</div><div class="cal-dl">Sá</div>
        </div>
        <div class="cal-days">
          <div class="cal-d empty"></div>
          <div class="cal-d">1</div><div class="cal-d ev">2</div><div class="cal-d">3</div>
          <div class="cal-d ev">4</div><div class="cal-d">5</div><div class="cal-d ev">6</div>
          <div class="cal-d">7</div><div class="cal-d">8</div><div class="cal-d ev">9</div>
          <div class="cal-d">10</div><div class="cal-d ev">11</div><div class="cal-d">12</div>
          <div class="cal-d">13</div><div class="cal-d">14</div><div class="cal-d today">15</div>
          <div class="cal-d">16</div><div class="cal-d ev">17</div><div class="cal-d">18</div>
          <div class="cal-d ev">19</div><div class="cal-d">20</div><div class="cal-d">21</div>
          <div class="cal-d ev">22</div><div class="cal-d">23</div><div class="cal-d">24</div>
          <div class="cal-d ev">25</div><div class="cal-d">26</div><div class="cal-d">27</div>
          <div class="cal-d">28</div><div class="cal-d">29</div><div class="cal-d ev">30</div>
        </div>
      </div>

      <!-- Events -->
      <div class="ev-list">
        <div class="ev-item">
          <div class="ev-date"><div class="ev-day">15</div><div class="ev-month">Abr</div></div>
          <div>
            <div class="ev-title">Encuentro de Pastores del Huila</div>
            <div class="ev-meta">Auditorio Central — 9:00 AM</div>
            <span class="ev-type">Red eclesial</span>
          </div>
        </div>
        <div class="ev-item">
          <div class="ev-date"><div class="ev-day">17</div><div class="ev-month">Abr</div></div>
          <div>
            <div class="ev-title">Brigada de salud comunitaria</div>
            <div class="ev-meta">Barrio La Gabriela — 8:00 AM · Asamblea de Dios</div>
            <span class="ev-type">Acción social</span>
          </div>
        </div>
        <div class="ev-item">
          <div class="ev-date"><div class="ev-day">19</div><div class="ev-month">Abr</div></div>
          <div>
            <div class="ev-title">Vigilia de oración interdenominacional</div>
            <div class="ev-meta">Catedral San Pedro — 10:00 PM</div>
            <span class="ev-type">Culto especial</span>
          </div>
        </div>
        <div class="ev-item">
          <div class="ev-date"><div class="ev-day">22</div><div class="ev-month">Abr</div></div>
          <div>
            <div class="ev-title">🎂 Cumpleaños — Pastor Édgar Perdomo</div>
            <div class="ev-meta">Iglesia Pentecostal Unida · Neiva</div>
            <span class="ev-type">Aniversario</span>
          </div>
        </div>
        <div class="ev-item">
          <div class="ev-date"><div class="ev-day">25</div><div class="ev-month">Abr</div></div>
          <div>
            <div class="ev-title">Olla Comunitaria — Parque Santander</div>
            <div class="ev-meta">11:00 AM · Varias iglesias</div>
            <span class="ev-type">Servicio social</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ ABOUT ══ -->
<section id="about">
  <div class="about-inner">
    <div class="about-content reveal">
      <p class="sec-eyebrow">Sobre el proyecto</p>
      <h2 class="sec-title">Construido para<br><em>servir</em> a Neiva</h2>
      <p>SER Neiva nació de la necesidad de organizar y visibilizar el inmenso trabajo que realiza el sector religioso de la ciudad — un trabajo que muchas veces permanece invisible para la ciudadanía.</p>
      <p>Esta plataforma no pertenece a ninguna denominación en particular. Es un espacio neutral, inclusivo y abierto a todas las tradiciones religiosas del tejido social de Neiva, Huila.</p>
      <div class="about-vals">
        <div class="av-row"><div class="av-dot"></div><p class="av-text"><strong>Inclusión:</strong> Todas las denominaciones son bienvenidas, sin distinción.</p></div>
        <div class="av-row"><div class="av-dot"></div><p class="av-text"><strong>Transparencia:</strong> Información pública, abierta y verificable.</p></div>
        <div class="av-row"><div class="av-dot"></div><p class="av-text"><strong>Comunidad:</strong> Construir puentes entre iglesias y ciudadanos.</p></div>
        <div class="av-row"><div class="av-dot"></div><p class="av-text"><strong>Servicio social:</strong> Apoyar iniciativas que beneficien a toda la ciudad.</p></div>
      </div>
    </div>

    <div class="about-visual reveal">
      <div class="quote-block">
        <p class="quote-text">"Una ciudad que conoce sus comunidades religiosas es una ciudad más unida, más solidaria y más fuerte."</p>
        <p class="quote-author">— Equipo SER Neiva</p>
      </div>
      <div class="denom-pills">
        <p class="denom-lbl">Denominaciones incluidas</p>
        <div class="pills">
          <span class="pill">Católica</span>
          <span class="pill">Evangélica</span>
          <span class="pill">Pentecostal</span>
          <span class="pill">Bautista</span>
          <span class="pill">Adventista</span>
          <span class="pill">Presbiteriana</span>
          <span class="pill">Metodista</span>
          <span class="pill">y más…</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ CTA ══ -->
<section id="cta">
  <div class="cta-inner reveal">
    <p class="sec-eyebrow" style="justify-content:center;">¿Listo para explorar?</p>
    <h2 class="cta-title">Descubre la <em>fe</em><br>de Neiva en el mapa</h2>
    <p class="cta-sub">Más de 200 iglesias, eventos, actividades y líderes religiosos — todo gratis, todo abierto, todo para la comunidad.</p>
    <a href="{{ route('mapa.index') }}" class="btn-main-lg" target="_blank">
      Ver el mapa ahora →
    </a>
  </div>
</section>



<!-- ══ FOOTER ══ -->
<footer>
  <div class="footer-top">

    {{-- Brand --}}
    <div class="footer-brand">
      <a href="#" class="footer-brand-logo">
        <span style="width:7px;height:7px;border-radius:50%;background:var(--gold);display:inline-block;"></span>
        SER Neiva
      </a>
      <p>Directorio interactivo del sector religioso de Neiva, Huila. Un proyecto de ciudad para la comunidad.</p>
    </div>

    {{-- Explorar --}}
    <div class="footer-col">
      <h4>Explorar</h4>
      <ul>
        <li><a href="{{ route('mapa.index') }}" target="_blank">Mapa interactivo</a></li>
        <li><a href="#agenda">Agenda de eventos</a></li>
        <li><a href="#features">Funcionalidades</a></li>
      </ul>
    </div>

    {{-- Proyecto --}}
    <div class="footer-col">
      <h4>Proyecto</h4>
      <ul>
        <li><a href="#about">Sobre nosotros</a></li>
        <li><a href="#what">¿Qué es SER Neiva?</a></li>
        <li><a href="#benefits">Beneficios</a></li>
        <li><a href="{{ route('consent.policy') }}">Política de privacidad</a></li>
      </ul>
    </div>

    {{-- Contacto + Redes --}}
    <div class="footer-col">
      <h4>Contacto</h4>
      <ul>
        <li><a href="mailto:contacto@serneiva.org">contacto@serneiva.org</a></li>
        <li><a href="{{ route('mapa.index') }}" target="_blank">serneiva.org</a></li>
        <li><a href="#">Neiva, Huila — Colombia</a></li>
      </ul>

      {{-- Redes sociales --}}
      <div style="margin-top:1rem;display:flex;align-items:center;gap:.6rem;">
        <a href="https://www.youtube.com/channel/UCbM8Q77joYwPZqM2ICI0SCw" target="_blank" rel="noopener noreferrer" title="Canal YouTube"
           style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;
                  border-radius:8px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
                  color:var(--muted,#8fa3bf);text-decoration:none;transition:background .2s,color .2s;"
           onmouseover="this.style.background='rgba(239,68,68,.15)';this.style.color='#ef4444'"
           onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.color='var(--muted,#8fa3bf)'">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M23.5 6.2s-.2-1.6-.8-2.3c-.8-1-1.7-1-2.1-1.1C16.9 2.5 12 2.5 12 2.5s-4.9 0-8.6.3c-.4 0-1.4.1-2.1 1.1C.6 4.6.4 6.2.4 6.2S0 8 0 9.8v4.3C0 16.1.4 18 .4 18s.2 1.6.8 2.3c.8 1 1.9 1 2.4 1.1 1.8.2 7.6.3 7.6.3s4.9 0 8.6-.3c.4 0 1.4-.1 2.1-1.1.6-.7.8-2.3.8-2.3s.4-1.9.4-3.7V9.8c0-1.9-.4-3.6-.4-3.6zM9.8 15.6V8.4l6.6 3.6-6.6 3.6z"/>
          </svg>
        </a>
      </div>
    </div>

  </div>

  {{-- Footer bottom --}}
  <div class="footer-bottom">
    <p>
      © 2026 Jaidercode · <strong>SER Neiva</strong> ·
      <a href="https://my-portfolio-sooty-nine-14.vercel.app/" target="_blank" rel="noopener noreferrer">Ver más trabajos</a>
    </p>
    <div class="footer-bottom-links">
      <a href="{{ route('consent.policy') }}">Política de privacidad</a>
      <span class="footer-bottom-sep">·</span>
      <span>Neiva, Huila — Colombia</span>
    </div>
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

  // Video play (local MP4 lazy-load)
  const playOverlay = document.getElementById('play-overlay');
  const localVideo = document.getElementById('local-video');
  const videoThumb = document.getElementById('video-thumb');
  playOverlay.addEventListener('click', () => {
    if (localVideo && localVideo.dataset && localVideo.dataset.src) {
      localVideo.src = localVideo.dataset.src;
    }
    if (localVideo) localVideo.style.display = 'block';
    if (videoThumb) videoThumb.style.display = 'none';
    playOverlay.classList.add('hidden');
    if (localVideo) localVideo.play().catch(() => {});
  });
</script>
</body>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var el = document.getElementById('mini-map');
  if (!el) return;
  var map = L.map('mini-map', {
    center: [2.9274, -75.2819], zoom: 13,
    zoomControl: false, attributionControl: false,
    dragging: false, scrollWheelZoom: false,
    doubleClickZoom: false, boxZoom: false,
    touchZoom: false, keyboard: false
  });
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
  var colores = ['#1E3A8A','#0891B2','#7C3AED','#DC2626','#D97706','#059669','#BE185D'];
  var points = @json($previewPoints ?? []);
  points.forEach(function(p, i) {
    var color = colores[i % colores.length];
    L.divIcon && L.marker([p[0], p[1]], {
      icon: L.divIcon({
        className: '',
        html: '<div style="width:10px;height:10px;background:'+color+';border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:2px solid white;box-shadow:0 2px 5px rgba(0,0,0,.4);"></div>',
        iconSize: [10,10], iconAnchor: [5,10]
      })
    }).addTo(map);
  });
});
</script>
</html>