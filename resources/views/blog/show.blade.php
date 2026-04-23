<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $blog->titulo }} — Blog SER Neiva</title>
  <meta name="description" content="{{ $blog->extracto ? Str::limit($blog->extracto, 160) : Str::limit(strip_tags($blog->contenido), 160) }}" />
  {{-- Open Graph --}}
  <meta property="og:title" content="{{ $blog->titulo }}" />
  <meta property="og:description" content="{{ $blog->extracto ? Str::limit($blog->extracto, 200) : Str::limit(strip_tags($blog->contenido), 200) }}" />
  @if($blog->imagen)
    <meta property="og:image" content="{{ Storage::url($blog->imagen) }}" />
  @endif
  <meta property="og:type" content="article" />
  <link rel="icon" href="{{ asset('images/logo-sirn.png') }}" type="image/png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  @vite(['resources/css/home.css'])

  <style>
    /* Estilos específicos del artículo */
    .blog-content { color: var(--fg, #eaf6ff); font-size: .97rem; line-height: 1.9; }
    .blog-content h2 { font-size: 1.35rem; font-weight: 700; margin: 2rem 0 .8rem; color: #fff; }
    .blog-content h3 { font-size: 1.1rem; font-weight: 600; margin: 1.5rem 0 .6rem; color: #e2efff; }
    .blog-content p  { margin: 0 0 1.1rem; }
    .blog-content ul, .blog-content ol { padding-left: 1.5rem; margin-bottom: 1.1rem; }
    .blog-content li { margin-bottom: .4rem; }
    .blog-content a  { color: var(--teal, #22BABB); text-decoration: underline; }
    .blog-content strong, .blog-content b { font-weight: 700; color: #fff; }
    .blog-content em, .blog-content i { font-style: italic; color: #c9dfff; }
    .blog-content blockquote {
      border-left: 3px solid var(--teal, #22BABB);
      margin: 1.5rem 0;
      padding: .8rem 1.2rem;
      background: rgba(34,186,187,.07);
      border-radius: 0 8px 8px 0;
      color: #a8c8e8;
      font-style: italic;
    }
    .related-card:hover { transform: translateY(-2px); border-color: rgba(34,186,187,.35); }
    .related-card { transition: transform .2s, border-color .2s; }
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
    <a href="{{ route('home') }}#iglesias">Iglesias</a>
    <a href="{{ route('home') }}#what">El Proyecto</a>
    <a href="{{ route('home') }}#features">Funcionalidades</a>
    <a href="{{ route('blog.index') }}" style="color:var(--teal,#22BABB);">Blog</a>
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
  <a href="{{ route('blog.index') }}" style="color:var(--teal,#22BABB);">Blog</a>
  <a href="{{ route('home') }}#agenda">Agenda</a>
  <a href="{{ route('home') }}#about">Nosotros</a>
  <a href="{{ route('decretos.index') }}">Normatividad</a>
  
  <a href="{{ route('mapa.index') }}" class="nav-cta" target="_blank">Explorar mapa →</a>
</div>

<!-- ══ ARTÍCULO ══ -->
<section style="padding:5.5rem 0 4rem;min-height:70vh;">
  <div style="max-width:780px;margin:0 auto;padding:0 1.5rem;">

    <!-- Volver -->
    <a href="{{ route('blog.index') }}"
       style="color:var(--teal,#22BABB);font-size:.85rem;text-decoration:none;
              display:inline-flex;align-items:center;gap:.4rem;margin-bottom:2rem;opacity:.85;"
       onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.85'">
      ← Volver al Blog
    </a>

    <!-- Imagen de portada -->
    @if($blog->imagen)
      <div style="width:100%;border-radius:16px;overflow:hidden;margin-bottom:2rem;
                  border:1px solid rgba(255,255,255,0.08);box-shadow:0 8px 40px rgba(0,0,0,.3);">
        <img src="{{ Storage::url($blog->imagen) }}"
             alt="{{ $blog->titulo }}"
             style="width:100%;max-height:420px;object-fit:cover;display:block;">
      </div>
    @endif

    <!-- Meta -->
    <div style="display:flex;align-items:center;gap:.8rem;flex-wrap:wrap;margin-bottom:1.2rem;">
      <span style="font-size:.72rem;font-weight:700;color:var(--teal,#22BABB);
                   letter-spacing:.08em;text-transform:uppercase;">
        {{ $blog->published_at ? $blog->published_at->translatedFormat('d \d\e F \d\e Y') : $blog->created_at->translatedFormat('d \d\e F \d\e Y') }}
      </span>
      <span style="color:rgba(255,255,255,.2);font-size:.8rem;">·</span>
      <span style="font-size:.82rem;color:var(--muted,#8fa3bf);">
        Por <strong style="color:#c9dfff;font-weight:600;">{{ $blog->autor->name ?? 'SER Neiva' }}</strong>
      </span>
      @if($blog->youtube_url)
        <span style="font-size:.72rem;font-weight:700;color:#ef4444;letter-spacing:.06em;
                     text-transform:uppercase;display:inline-flex;align-items:center;gap:.3rem;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-2.74 12.69 12.69 0 0 0-6.54 0A4.83 4.83 0 0 1 5.51 6.69C3.78 8.15 3 9.85 3 12s.78 3.85 2.51 5.31a4.83 4.83 0 0 1 3.77 2.74 12.69 12.69 0 0 0 6.54 0 4.83 4.83 0 0 1 3.77-2.74C21.22 15.85 22 14.15 22 12s-.78-3.85-2.41-5.31zM10 15V9l5 3-5 3z"/>
          </svg>
          Incluye video
        </span>
      @endif
    </div>

    <!-- Título -->
    <h1 style="font-size:2rem;font-weight:700;color:#fff;line-height:1.25;margin:0 0 1.2rem;">
      {{ $blog->titulo }}
    </h1>

    <!-- Extracto / lead -->
    @if($blog->extracto)
      <p style="font-size:1.05rem;color:#a8c8e8;font-style:italic;line-height:1.7;
                border-left:3px solid var(--teal,#22BABB);padding-left:1rem;margin-bottom:2rem;">
        {{ $blog->extracto }}
      </p>
    @endif

    <!-- Separador -->
    <hr style="border:none;border-top:1px solid rgba(255,255,255,.08);margin-bottom:2rem;">

    <!-- Contenido del artículo -->
    <div class="blog-content">
      {!! nl2br(e($blog->contenido)) !!}
    </div>

    <!-- ══ VIDEO YOUTUBE ══ -->
    @if($blog->youtubeEmbedUrl())
      <div style="margin-top:2.5rem;">
        <div style="display:flex;align-items:center;gap:.7rem;margin-bottom:1rem;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="#ef4444">
            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-2.74 12.69 12.69 0 0 0-6.54 0A4.83 4.83 0 0 1 5.51 6.69C3.78 8.15 3 9.85 3 12s.78 3.85 2.51 5.31a4.83 4.83 0 0 1 3.77 2.74 12.69 12.69 0 0 0 6.54 0 4.83 4.83 0 0 1 3.77-2.74C21.22 15.85 22 14.15 22 12s-.78-3.85-2.41-5.31zM10 15V9l5 3-5 3z"/>
          </svg>
          <span style="font-size:.75rem;font-weight:700;color:#ef4444;
                       letter-spacing:.08em;text-transform:uppercase;">Video</span>
        </div>
        <div style="border-radius:14px;overflow:hidden;border:1px solid rgba(255,255,255,.1);
                    box-shadow:0 8px 32px rgba(0,0,0,.4);"
             class="yt-embed-wrapper">
              <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                <div id="yt-player-wrap" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                  <div id="yt-player-overlay" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;z-index:5;background:linear-gradient(180deg,rgba(0,0,0,.15),rgba(0,0,0,.15));cursor:pointer;">
                    <button aria-label="Reproducir video" style="background:rgba(255,255,255,.06);backdrop-filter:blur(4px);border:1px solid rgba(255,255,255,.08);width:78px;height:78px;border-radius:999px;display:flex;align-items:center;justify-content:center;">
                      <svg width="28" height="28" viewBox="0 0 24 24" fill="#fff"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                  </div>
                  <div id="yt-player-container" style="width:100%;height:100%;position:relative;">
                    <iframe id="yt-player-iframe"
                      src="{{ $blog->youtubeEmbedUrl() }}?controls=1&rel=0&modestbranding=1&enablejsapi=1"
                      style="position:absolute;top:0;left:0;width:100%;height:100%;"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen
                      title="{{ $blog->titulo }}"></iframe>
                  </div>
                </div>
            </div>
        </div>
        <!-- Enlace directo a YouTube -->
        <div style="margin-top:.8rem;text-align:right;">
          <a href="{{ $blog->youtube_url }}" target="_blank" rel="noopener noreferrer"
             style="font-size:.78rem;color:var(--muted,#8fa3bf);text-decoration:none;
                    display:inline-flex;align-items:center;gap:.35rem;"
             onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--muted,#8fa3bf)'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Ver directamente en YouTube
          </a>
        </div>
      </div>
    @endif

    <!-- ══ COMPARTIR ══ -->
    <div style="margin-top:2.5rem;padding:1.4rem 1.6rem;
                background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);
                border-radius:14px;display:flex;align-items:center;justify-content:space-between;
                gap:1rem;flex-wrap:wrap;">
      <span style="font-size:.85rem;color:var(--muted,#8fa3bf);font-weight:500;">¿Te gustó este artículo? Compártelo</span>
      <div style="display:flex;gap:.7rem;">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
           target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem .9rem;
                  background:#1877f2;color:#fff;border-radius:8px;font-size:.78rem;font-weight:700;
                  text-decoration:none;transition:opacity .2s;"
           onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
          Facebook
        </a>
        <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->titulo . ' ' . request()->url()) }}"
           target="_blank" rel="noopener"
           style="display:inline-flex;align-items:center;gap:.4rem;padding:.5rem .9rem;
                  background:#25d366;color:#fff;border-radius:8px;font-size:.78rem;font-weight:700;
                  text-decoration:none;transition:opacity .2s;"
           onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
          WhatsApp
        </a>
      </div>
    </div>

    <!-- ══ RELACIONADOS ══ -->
    @if($relacionados->count())
      <div style="margin-top:3rem;">
        <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:1.4rem;">
          Más artículos
        </h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.2rem;">
          @foreach($relacionados as $rel)
            <a href="{{ route('blog.show', $rel->slug) }}"
               class="related-card"
               style="display:flex;flex-direction:column;gap:.8rem;text-decoration:none;
                      background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
                      border-radius:12px;overflow:hidden;">
              @if($rel->imagen)
                <div style="height:110px;overflow:hidden;">
                  <img src="{{ Storage::url($rel->imagen) }}"
                       alt="{{ $rel->titulo }}"
                       style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>
              @else
                <div style="height:70px;background:linear-gradient(135deg,rgba(120,53,15,.25),rgba(180,83,9,.15));
                             display:flex;align-items:center;justify-content:center;font-size:1.8rem;">✍️</div>
              @endif
              <div style="padding:.8rem 1rem 1rem;">
                <span style="font-size:.68rem;font-weight:700;color:var(--teal,#22BABB);
                             letter-spacing:.07em;text-transform:uppercase;">
                  {{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : $rel->created_at->translatedFormat('d M Y') }}
                </span>
                <p style="margin:.4rem 0 0;font-size:.9rem;font-weight:600;color:var(--fg,#eaf6ff);line-height:1.4;">
                  {{ Str::limit($rel->titulo, 70) }}
                </p>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    @endif

    <!-- Volver al blog -->
    <div style="margin-top:2.5rem;text-align:center;">
      <a href="{{ route('blog.index') }}"
         style="display:inline-flex;align-items:center;gap:.5rem;
                background:var(--teal,#22BABB);color:#0a1a2f;
                padding:.65rem 1.6rem;border-radius:9px;
                font-size:.9rem;font-weight:700;text-decoration:none;transition:opacity .2s;"
         onmouseover="this.style.opacity='.82'" onmouseout="this.style.opacity='1'">
        ← Ver todos los artículos
      </a>
    </div>

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

<!-- YouTube player helper: carga la API y reproduce tras interacción del usuario -->
<script>
  // Crea la función global que YouTube API espera
  function onYouTubeIframeAPIReady() {
    try {
      window.ytPlayer = new YT.Player('yt-player-iframe');
    } catch (e) {
      // si algo falla, seguiremos con el fallback de postMessage
    }
  }

  (function () {
    const overlay = document.getElementById('yt-player-overlay');
    if (!overlay) return;
    overlay.addEventListener('click', function () {
      // Primero intentamos con la API si está disponible
      if (window.ytPlayer && typeof window.ytPlayer.playVideo === 'function') {
        window.ytPlayer.playVideo();
        this.style.display = 'none';
        return;
      }
      // Fallback: enviamos comando por postMessage
      const iframe = document.getElementById('yt-player-iframe');
      if (iframe && iframe.contentWindow) {
        iframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'playVideo', args: [] }), '*');
        this.style.display = 'none';
      }
    });
  })();
</script>
<script src="https://www.youtube.com/iframe_api"></script>

</body>
</html>
