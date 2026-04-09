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
    <a href="#agenda">Agenda</a>
    <a href="#about">Nosotros</a>
    <a href="{{ route('decretos.index') }}">Normatividad</a>
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
      <div class="stat"><div class="stat-n">133</div><div class="stat-l">Iglesias registradas</div></div>
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
        Ver todas las 140 iglesias en el mapa <span class="btn-arr">→</span>
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
      <div class="badge-num">133</div>
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
      <p>Conoce la riqueza espiritual y social de Neiva — una ciudad donde más de 133 comunidades religiosas trabajan juntas por el bienestar de todos.</p>
      <p>El Sector Religioso de Neiva es uno de los más activos del Huila, con iniciativas sociales, culturales y espirituales que llegan a miles de familias cada semana.</p>
      <div class="video-feature-list">
        <div class="vf-row"><div class="vf-dot"></div><div class="vf-text"><strong>Más de 133 iglesias</strong> registradas en la plataforma</div></div>
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
    <p class="cta-sub">Más de 133 iglesias, eventos, actividades y líderes religiosos — todo gratis, todo abierto, todo para la comunidad.</p>
    <a href="{{ route('mapa.index') }}" class="btn-main-lg" target="_blank">
      Ver el mapa ahora →
    </a>
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