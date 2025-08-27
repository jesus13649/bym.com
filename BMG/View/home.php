
<?php include 'menu.php'; ?>


  <style>
    :root{
      --rose-100:#fff0f5;
      --rose-200:#fde3ec;
      --rose-300:#f7c8d6;
      --rose-400:#f4b6c2;
      --rose-500:#f4a1b1;
      --text-900:#4b2e39;
      --text-700:#6b4c58;
      --success:#4caf50;
    }
    body{font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; background:linear-gradient(135deg,var(--rose-100),#ffffff); color:var(--text-700);}
    .hero{
      background: radial-gradient(80% 20% at 10% 10%, var(--rose-200), transparent 60%), 
                  radial-gradient(80% 20% at 90% 0%, var(--rose-300), transparent 60%),
                  linear-gradient(180deg,#fff, var(--rose-100));
      border-bottom:1px solid #f2d7df;
    }
    .chip{display:inline-flex; align-items:center; gap:.5rem; padding:.45rem .8rem; border-radius:999px; background:#fff; border:1px solid #f5d1dc; font-size:.875rem; color:var(--text-700)}
    
    .card-header{background:transparent; border:none}
    .badge-soft{background:var(--rose-200); color:var(--text-900); border:1px solid #f3c1cd}
    .list-check li{margin:.35rem 0; display:flex; gap:.6rem}
    .list-check i{color:var(--success)}
    .do{border-left:4px solid #4caf50; background:#eaf6ec}
    .dont{border-left:4px solid #f44336; background:#fdecea}
    .section-title{font-weight:800; color:var(--text-900)}
    .btn-rose{background:var(--rose-500); border:none; color:#fff}
    .btn-rose:hover{background:#e57f96}
    .anchor-offset{scroll-margin-top: 90px;}
    .back-top{position:fixed; right:16px; bottom:16px; z-index:999; display:none}
    .divider{height:1px; background:linear-gradient(90deg,transparent,var(--rose-300),transparent)}
    .hero-img{
      aspect-ratio: 16/9; width:100%; object-fit:cover; border-radius:1.25rem; border:1px solid #f4d6de
    }
  </style>
</head>
<body>

  <!-- NAV -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#"><i class=" me-"></i>Blossie & Mar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navMain" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto gap-lg-2">
          <li class="nav-item"><a class="nav-link" href="#rutina">Rutina de piel</a></li>
          <li class="nav-item"><a class="nav-link" href="#prep">Preparación</a></li>
          <li class="nav-item"><a class="nav-link" href="#tips">Tips de maquillaje</a></li>
          <li class="nav-item"><a class="nav-link" href="#errores">Errores comunes</a></li>
          <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <div class="hero ">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="chip mb-3"><i class="bi bi-heart-fill"></i> Belleza real, piel saludable</div>
          <h1 class="display-5 fw-bold text-dark">Tips de <span class="text-decoration-underline" style="text-decoration-color:var(--rose-400);">maquillaje</span> & cuidado de la piel</h1>
          <p class="lead mt-3">Aprende a preparar tu piel, elegir productos por tipo de piel y lograr un acabado luminoso y duradero sin complicaciones.</p>
          <div class="mt-4 d-flex gap-2 flex-wrap">
            <a href="#rutina" class="btn btn-rose btn-lg"><i class="bi bi-magic me-1"></i> Empezar ahora</a>
            <a href="#tips" class="btn btn-outline-dark btn-lg"><i class="bi bi-gem me-1"></i> Ver tips rápidos</a>
          </div>
        </div>
        <div class="col-lg-6">
          <img class="hero-img" src="../Assets/img/BLOCK.jpg" alt="Maquillaje y cuidado de la piel">
        </div>
      </div>
    </div>
  </div>

  <div class="divider"></div>

  <!-- RUTINA DE PIEL -->
  <section id="rutina" class="py-5 anchor-offset">
    <div class="container">
      <h2 class="section-title mb-4"><i class="bi bi-droplet-half me-2"></i>Rutina básica de cuidado de la piel</h2>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <span class="badge badge-soft mb-2">Paso 1</span>
              <h5 class="fw-bold">Limpieza suave</h5>
              <p class="mb-2">Gel o leche limpiadora según tu tipo de piel, mañana y noche.</p>
              <ul class="list-check ps-0 list-unstyled">
                <li><i class="bi bi-check-circle"></i><span>Evita sulfatos agresivos</span></li>
                <li><i class="bi bi-check-circle"></i><span>Agua tibia, no caliente</span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <span class="badge badge-soft mb-2">Paso 2</span>
              <h5 class="fw-bold">Hidratación</h5>
              <p class="mb-2">Sérum + crema. Busca texturas ligeras si eres piel mixta/grasa.</p>
              <ul class="list-check ps-0 list-unstyled">
                <li><i class="bi bi-check-circle"></i><span>Ácido hialurónico o glicerina</span></li>
                <li><i class="bi bi-check-circle"></i><span>Cuello y escote también</span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <span class="badge badge-soft mb-2">Paso 3</span>
              <h5 class="fw-bold">Protector solar</h5>
              <p class="mb-2">FPS 30+ todos los días, reaplica cada 2–3 horas si hay sol.</p>
              <ul class="list-check ps-0 list-unstyled">
                <li><i class="bi bi-check-circle"></i><span>Media cucharadita rostro</span></li>
                <li><i class="bi bi-check-circle"></i><span>Opción “no comedogénica”</span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <span class="badge badge-soft mb-2">Extra</span>
              <h5 class="fw-bold">Tratamientos</h5>
              <p class="mb-2">Exfoliantes 1–2 veces/semana y mascarillas según necesidad.</p>
              <ul class="list-check ps-0 list-unstyled">
                <li><i class="bi bi-check-circle"></i><span>Niacinamida, AHA/BHA con cuidado</span></li>
                <li><i class="bi bi-check-circle"></i><span>Prueba de parche siempre</span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </section>

  <!-- PREPARACIÓN DE LA PIEL -->
  <section id="prep" class="py-5 bg-white anchor-offset">
    <div class="container">
      <h2 class="section-title mb-4"><i class="bi bi-brush me-2"></i>Preparación de la piel antes del maquillaje</h2>
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="fw-bold">Checklist rápido</h5>
              <ul class="list-check ps-0 list-unstyled mb-0">
                <li><i class="bi bi-check-circle"></i><span>Rostro limpio y bien hidratado</span></li>
                <li><i class="bi bi-check-circle"></i><span>Protector solar (deja asentar 5–10 min)</span></li>
                <li><i class="bi bi-check-circle"></i><span>Primer según necesidad (poros, brillo, resequedad)</span></li>
                <li><i class="bi bi-check-circle"></i><span>Labios con bálsamo</span></li>
                <li><i class="bi bi-check-circle"></i><span>Niebla fijadora ligera para sellar capas</span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="fw-bold">Por tipo de piel</h5>
              <div class="row g-3">
                <div class="col-12">
                  <span class="badge badge-soft">Grasa/mixta</span>
                  <p class="mb-2">Hidratante en gel + primer matificante en zona T. Base de cobertura ligera a media.</p>
                </div>
                <div class="col-12">
                  <span class="badge badge-soft">Seca</span>
                  <p class="mb-2">Sérum hidratante + crema nutritiva. Evita polvos pesados; usa brumas entre capas.</p>
                </div>
                <div class="col-12">
                  <span class="badge badge-soft">Sensible</span>
                  <p class="mb-0">Fórmulas sin perfume y hipoalergénicas. Prioriza la barrera cutánea.</p>
                </div>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </section>

  <!-- TIPS DE MAQUILLAJE -->
  <section id="tips" class="py-5 anchor-offset">
    <div class="container">
      <h2 class="section-title mb-4"><i class="bi bi-stars me-2"></i>Tips de maquillaje que sí funcionan</h2>
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-0"><i class="bi bi-emoji-smile me-1"></i> Piel luminosa</h5>
            </div>
            <div class="card-body">
              <ul class="ps-3 mb-0">
                <li>Mezcla 1 gota de iluminador líquido con tu base.</li>
                <li>Coloca corrector solo donde sea necesario.</li>
                <li>Polvo traslúcido solo en zona T.</li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-6 col-lg-4">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-0"><i class="bi bi-eye me-1"></i> Ojos definidos</h5>
            </div>
            <div class="card-body">
              <ul class="ps-3 mb-0">
                <li>Transición suave con sombra mate en la cuenca.</li>
                <li>Delineado difuminado con sombra marrón.</li>
                <li>Máscara en zig-zag para volumen sin grumos.</li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-6 col-lg-4">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-0"><i class="bi bi-lipstick me-1"></i> Labios perfectos</h5>
            </div>
            <div class="card-body">
              <ul class="ps-3 mb-0">
                <li>Perfila con lápiz del tono más cercano a tu labio.</li>
                <li>Rellena con toques y sella con pañuelo + polvo.</li>
                <li>Hidrata antes; evita bálsamos muy grasos bajo mate.</li>
              </ul>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </section>

  <!-- ERRORES COMUNES -->
  <section id="errores" class="py-5 bg-white anchor-offset">
    <div class="container">
      <h2 class="section-title mb-4"><i class="bi bi-exclamation-triangle me-2"></i>Errores comunes (y cómo evitarlos)</h2>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card do">
            <div class="card-body">
              <h5 class="fw-bold"><i class="bi bi-hand-thumbs-up me-1"></i> Haz esto</h5>
              <ul class="mb-0 ps-3">
                <li>Elige el tono de base probando en la línea de la mandíbula.</li>
                <li>Menos es más: construye en capas finas.</li>
                <li>Limpia brochas y esponjas 1 vez por semana.</li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-6">
          <div class="card dont">
            <div class="card-body">
              <h5 class="fw-bold"><i class="bi bi-hand-thumbs-down me-1"></i> Evita esto</h5>
              <ul class="mb-0 ps-3">
                <li>Aplicar polvo en todo el rostro si tu piel es seca.</li>
                <li>Usar corrector muy claro: genera efecto “grisáceo”.</li>
                <li>Dormir con maquillaje (envejece y obstruye poros).</li>
              </ul>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </section>

  <!-- CHECKLIST DE PRODUCTOS -->
  <section class="py-5 anchor-offset">
    <div class="container">
      <h2 class="section-title mb-4"><i class="bi bi-bag-heart me-2"></i>Checklist esencial</h2>
      <div class="row g-3">
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Preparación</h6>
              <ul class="mb-0 ps-3">
                <li>Limpiador facial</li>
                <li>Hidratante</li>
                <li>Protector solar</li>
                <li>Primer</li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Tez</h6>
              <ul class="mb-0 ps-3">
                <li>Base o tinte</li>
                <li>Corrector</li>
                <li>Polvo traslúcido</li>
                <li>Rubor/Iluminador</li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Ojos</h6>
              <ul class="mb-0 ps-3">
                <li>Sombras neutras</li>
                <li>Delineador</li>
                <li>Máscara</li>
                <li>Fijador de cejas</li>
              </ul>
            </div>
          </div>
        </div>        
        <div class="col-md-6 col-lg-3">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="fw-bold mb-2">Labios & fix</h6>
              <ul class="mb-0 ps-3">
                <li>Bálsamo</li>
                <li>Lápiz perfilador</li>
                <li>Labial o tinta</li>
                <li>Bruma fijadora</li>
              </ul>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="py-5 bg-white anchor-offset">
    <div class="container">
      <h2 class="section-title mb-4"><i class="bi bi-question-circle me-2"></i>Preguntas frecuentes</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
              ¿En qué orden aplico skincare y maquillaje?
            </button>
          </h2>
          <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Limpieza → Sérum → Hidratante → Protector solar → <em>(espera 5–10 min)</em> → Primer → Base/Corrector → Polvos/Color → Fijador.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
              ¿Cómo hago que el maquillaje dure más en clima cálido?
            </button>
          </h2>
          <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Usa capas finas, primer adecuado, sella solo zonas de brillo y reaplica bruma fijadora en el día. Papelitos absorbentes ayudan sin recargar producto.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">
              ¿Cómo elijo la base correcta?
            </button>
          </h2>
          <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Prueba el tono en la línea de la mandíbula y revisa a luz natural. Ten en cuenta tu subtono (cálido, frío, neutro) y tu tipo de piel.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- NEWSLETTER -->
  <section class="py-5">
    <div class="container">
      <div class="card">
        <div class="card-body p-4 p-lg-5">
          <div class="row align-items-center g-4">
            <div class="col-lg-7">
              <h3 class="fw-bold mb-2">¿Quieres más tips y looks?</h3>
              <p class="mb-0">Suscríbete y recibe guías, lanzamientos y descuentos exclusivos.</p>
            </div>
            <div class="col-lg-5">
              <form class="d-flex gap-2">
                <input type="email" class="form-control form-control-lg" placeholder="Tu correo electrónico" required>
                <button class="btn btn-rose btn-lg" type="submit"><i class="bi bi-envelope-heart"></i></button>
              </form>
              <small class="text-muted d-block mt-2">Prometemos cero spam. 💌</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="py-4 bg-white border-top">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center gap-2">
      <span class="text-muted">© <script>document.write(new Date().getFullYear())</script> Blossie & Mar</span>
      <div class="d-flex gap-3">
        <a href="#" class="link-dark text-decoration-none"><i class="bi bi-instagram"></i></a>
        <a href="#" class="link-dark text-decoration-none"><i class="bi bi-tiktok"></i></a>
        <a href="#" class="link-dark text-decoration-none"><i class="bi bi-youtube"></i></a>
      </div>
    </div>
  </footer>

  <!-- Back to top -->
  <button id="backTop" class="btn btn-dark rounded-circle back-top" aria-label="Volver arriba">
    <i class="bi bi-arrow-up"></i>
  </button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Mostrar botón "volver arriba"
    const backTop = document.getElementById('backTop');
    window.addEventListener('scroll', () => {
      backTop.style.display = window.scrollY > 400 ? 'inline-flex' : 'none';
    });
    backTop.addEventListener('click', () => window.scrollTo({top:0, behavior:'smooth'}));

    // Suavizar scroll para links internos
    document.querySelectorAll('a[href^="#"]').forEach(a=>{
      a.addEventListener('click', e=>{
        const id = a.getAttribute('href');
        if(id.length>1){
          e.preventDefault();
          document.querySelector(id)?.scrollIntoView({behavior:'smooth'});
        }
      });
    });
  </script>
</body>
</html>
