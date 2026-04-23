<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog — SER Neiva</title>
  <meta name="description" content="Artículos, noticias y contenido del sector religioso de Neiva, Huila." />
  <link rel="icon" href="{{ asset('images/logo-sirn.png') }}" type="image/png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
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

<!-- ══ HERO BLOG ══ -->
<section style="padding:5.5rem 0 3rem;min-height:40vh;">
  <div style="max-width:1000px;margin:0 auto;padding:0 1.5rem;">

    <!-- Encabezado -->
    <div class="iglesias-header reveal" style="margin-bottom:3rem;">
      <p class="sec-eyebrow">Contenido</p>
      <h2 class="sec-title">Artículos y <em>noticias</em><br>del sector religioso</h2>
      <p style="max-width:540px;">
        Descubre historias, reflexiones y novedades de las iglesias y comunidades religiosas de Neiva, Huila.
      </p>
    </div>

    <!-- Grid de entradas -->
    @if($blogs->count())
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:1.8rem;">
        @foreach($blogs as $blog)
          <article class="reveal"
                   style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);
                          border-radius:16px;overflow:hidden;display:flex;flex-direction:column;
                          transition:transform .2s,border-color .2s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='rgba(34,186,187,.35)'"
                   onmouseout="this.style.transform='';this.style.borderColor='rgba(255,255,255,0.09)'">

            <!-- Imagen -->
            @if($blog->imagen)
              <a href="{{ route('blog.show', $blog->slug) }}" style="display:block;overflow:hidden;height:180px;">
                <img src="{{ Storage::url($blog->imagen) }}"
                     alt="{{ $blog->titulo }}"
                     style="width:100%;height:100%;object-fit:cover;transition:transform .35s;"
                     onmouseover="this.style.transform='scale(1.04)'"
                     onmouseout="this.style.transform=''">
              </a>
            @else
              <a href="{{ route('blog.show', $blog->slug) }}"
                 style="display:flex;align-items:center;justify-content:center;height:120px;
                        background:linear-gradient(135deg,rgba(120,53,15,.3),rgba(180,83,9,.2));
                        font-size:2.5rem;">
                ✍️
              </a>
            @endif

            <!-- Contenido tarjeta -->
            <div style="padding:1.4rem 1.6rem;flex:1;display:flex;flex-direction:column;gap:.8rem;">

              <!-- Meta -->
              <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
                <span style="font-size:.7rem;font-weight:700;color:var(--teal,#22BABB);letter-spacing:.07em;text-transform:uppercase;">
                  {{ $blog->published_at ? $blog->published_at->translatedFormat('d M Y') : $blog->created_at->translatedFormat('d M Y') }}
                </span>
                @if($blog->youtube_url)
                  <span style="font-size:.68rem;font-weight:600;color:#ef4444;letter-spacing:.05em;
                               display:inline-flex;align-items:center;gap:.3rem;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-2.74 12.69 12.69 0 0 0-6.54 0A4.83 4.83 0 0 1 5.51 6.69C3.78 8.15 3 9.85 3 12s.78 3.85 2.51 5.31a4.83 4.83 0 0 1 3.77 2.74 12.69 12.69 0 0 0 6.54 0 4.83 4.83 0 0 1 3.77-2.74C21.22 15.85 22 14.15 22 12s-.78-3.85-2.41-5.31zM10 15V9l5 3-5 3z"/>
                    </svg>
                    Video
                  </span>
                @endif
              </div>

              <!-- Título -->
              <h3 style="margin:0;font-size:1.05rem;font-weight:700;color:var(--fg,#eaf6ff);line-height:1.4;">
                <a href="{{ route('blog.show', $blog->slug) }}"
                   style="color:inherit;text-decoration:none;"
                   onmouseover="this.style.color='var(--teal,#22BABB)'"
                   onmouseout="this.style.color='var(--fg,#eaf6ff)'">
                  {{ $blog->titulo }}
                </a>
              </h3>

              <!-- Extracto -->
              @if($blog->extracto)
                <p style="margin:0;color:var(--muted,#8fa3bf);font-size:.87rem;line-height:1.6;flex:1;">
                  {{ Str::limit($blog->extracto, 150) }}
                </p>
              @endif

              <!-- Pie de tarjeta -->
              <div style="display:flex;align-items:center;justify-content:space-between;margin-top:.4rem;">
                <span style="font-size:.76rem;color:var(--muted,#8fa3bf);">
                  Por {{ $blog->autor->name ?? 'SER Neiva' }}
                </span>
                <a href="{{ route('blog.show', $blog->slug) }}"
                   style="font-size:.8rem;font-weight:700;color:var(--teal,#22BABB);
                          text-decoration:none;display:inline-flex;align-items:center;gap:.3rem;"
                   onmouseover="this.style.opacity='.75'"
                   onmouseout="this.style.opacity='1'">
                  Leer más
                  <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                  </svg>
                </a>
              </div>

            </div>
          </article>
        @endforeach
      </div>

      <!-- Paginación -->
      <div style="margin-top:2.5rem;">{{ $blogs->links() }}</div>

    @else
      <div style="text-align:center;padding:4rem 0;color:var(--muted,#8fa3bf);">
        <p style="font-size:2.5rem;margin-bottom:1rem;">✍️</p>
        <p style="font-size:1rem;font-weight:600;">Aún no hay artículos publicados.</p>
        <p style="font-size:.87rem;margin-top:.4rem;">Vuelve pronto, estamos preparando contenido para ti.</p>
      </div>
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
// Reveal on scroll – usa la clase 'visible' que define home.css
const obs = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
}, { threshold: 0.05, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// Nav scroll
const nav = document.getElementById('main-nav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 40);
});

// Nav toggle móvil
document.getElementById('nav-toggle')?.addEventListener('click', () => {
  document.getElementById('nav-mobile')?.classList.toggle('open');
});
</script>

</body>
</html>
