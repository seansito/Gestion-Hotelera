<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contacto — Violeta Hotel Boutique</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    /* Reset & base */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html,body { height:100%; }
    body { font-family: 'Poppins', sans-serif; color:#1b2330; background:#fff; line-height:1.6; -webkit-font-smoothing:antialiased; }
    a { color:inherit; text-decoration:none; }

/* ===========================
   TOPBAR
=========================== */
.topbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: #081328;
  color: #fff;
  font-size: 0.9rem;
  padding: 8px 0;
  z-index: 1200;
}

.topbar .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* ===========================
   NAVBAR
=========================== */
.navbar {
  position: fixed;
  top: var(--topbar-height);
  left: 0;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 40px;
  transition: var(--transition);
  z-index: 1100;
  background: rgba(255,255,255,0.08);
  backdrop-filter: blur(12px);
  color: var(--text-muted);
}

.navbar.scrolled {
  background: rgba(255,255,255,0.96);
  color: var(--text);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.logo {
  font-size: 1.3rem;
  font-weight: 700;
}

.logo span {
  color: var(--accent);
}

/* NAV LINKS */
.main-nav ul {
  display: flex;
  gap: 24px;
  list-style: none;
}

.main-nav a {
  font-weight: 500;
  position: relative;
  padding-bottom: 2px;
}

.main-nav a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -3px;
  width: 100%;
  height: 2px;
  background: var(--accent);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s ease;
}

.main-nav a:hover::after {
  transform: scaleX(1);
}

.btn-nav {
  background: var(--accent);
  color: #fff;
  padding: 8px 20px;
  border-radius: 999px;
  font-weight: 600;
  transition: var(--transition);
}

.btn-nav:hover {
  background: var(--accent-dark);
}

/* NAV TOGGLE (mobile) */
.nav-toggle {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
}

.hamburger {
  width: 22px;
  height: 2px;
  background: currentColor;
  position: relative;
  transition: var(--transition);
}

.hamburger::before,
.hamburger::after {
  content: "";
  position: absolute;
  width: 22px;
  height: 2px;
  background: currentColor;
  transition: var(--transition);
}

.hamburger::before { top: -6px; }
.hamburger::after { bottom: -6px; }

.nav-toggle[aria-expanded="true"] .hamburger {
  background: transparent;
}

.nav-toggle[aria-expanded="true"] .hamburger::before {
  transform: rotate(45deg);
  top: 0;
}

.nav-toggle[aria-expanded="true"] .hamburger::after {
  transform: rotate(-45deg);
  bottom: 0;
}

    /* Hero */
    .hero { height:220px; background: url('images/hero.jpg') center/cover no-repeat; position:relative; display:flex; align-items:center; justify-content:center; }
    .hero::after { content:''; position:absolute; inset:0; background:linear-gradient(180deg, rgba(7,12,18,0.45), rgba(7,12,18,0.6)); }
    .hero .inner { position:relative; z-index:2; color:#fff; text-align:center; }
    .hero h2 { font-size:36px; font-weight:700; letter-spacing:0.2px; }
    .hero p { margin-top:8px; color:rgba(255,255,255,0.9); font-size:14px; }

    /* Main layout */
    .container { max-width:1200px; margin:0 auto; padding:32px 20px; }

    .grid {
      display:grid;
      grid-template-columns: 1fr 420px;
      gap:36px;
      align-items:start;
    }

    /* Contact cards (left column) */
    .cards {
      display:grid;
      grid-template-columns: repeat(2, 1fr);
      gap:18px;
      margin-bottom:20px;
    }
    .card {
      background:#fff;
      border-radius:12px;
      padding:18px;
      box-shadow:0 8px 30px rgba(11,22,34,0.04);
      min-height:110px;
      display:flex;
      flex-direction:column;
      justify-content:center;
      gap:6px;
    }
    .card .icon {
      font-size:20px;
      width:44px;
      height:44px;
      border-radius:8px;
      background:#f6ece0;
      display:flex;
      align-items:center;
      justify-content:center;
      color:#7a5c3a;
      margin-bottom:6px;
    }
    .card h4 { font-size:14px; color:#0b1320; font-weight:700; }
    .card p { color:#556680; font-size:14px; }

    /* Map */
    .map-wrap {
      margin-top:12px;
      border-radius:10px;
      overflow:hidden;
      box-shadow:0 8px 30px rgba(11,22,34,0.04);
    }
    .map-wrap iframe { width:100%; height:280px; border:0; display:block; }

    /* Right column: Contact form */
    .contact-box {
      background:#fff;
      padding:24px;
      border-radius:12px;
      box-shadow:0 8px 30px rgba(11,22,34,0.04);
    }
    .section-title { font-size:26px; font-weight:700; color:#0b1320; margin-bottom:10px; }
    .section-sub { color:#556680; margin-bottom:18px; }

    form .field { margin-bottom:12px; }
    input[type="text"], input[type="email"], input[type="tel"], textarea {
      width:100%;
      padding:12px 14px;
      border:1px solid #e6e6e6;
      border-radius:8px;
      font-size:14px;
      color:#0b1320;
      background:#fff;
      outline:none;
      transition:box-shadow .15s, border-color .15s;
    }
    input:focus, textarea:focus { border-color:#d19c2f; box-shadow:0 6px 20px rgba(209,156,47,0.12); }
    textarea { min-height:120px; resize:vertical; }

    .submit-row { display:flex; align-items:center; gap:12px; margin-top:6px; }
    .btn-send {
      background:#d19c2f; color:#fff; border:none; padding:12px 18px; border-radius:30px; font-weight:700; cursor:pointer;
    }
    .note { color:#728191; font-size:13px; }

    /* Footer */
    footer { background:#091426; color:#cbd5e1; padding:48px 20px; margin-top:40px; }
    footer .fwrap { max-width:1200px; margin:0 auto; display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:24px; align-items:start; }
    footer h3 { color:#fff; margin-bottom:12px; }
    footer p, footer li { color:#cbd5e1; font-size:14px; line-height:1.8; }
    footer ul { list-style:none; padding:0; margin:0; }

    /* Responsive */
    @media (max-width:1100px) {
      .grid { grid-template-columns: 1fr 1fr; }
      .cards { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width:880px) {
      .grid { grid-template-columns: 1fr; }
      .cards { grid-template-columns: repeat(2, 1fr); }
      .hero { height:180px; }
    }
    @media (max-width:520px) {
      .cards { grid-template-columns: 1fr 1fr; }
      nav ul { display:none; } /* simplify nav on small screens */
    }

    /* small helper */
    .muted { color:#728191; font-size:14px; }
  </style>
</head>
<body>

  <!-- 🔸 TOPBAR -->
  <div class="topbar">
    <div class="container">
      <span>📞 +598 987 3657 | 📧 tavernhotel@gmail.com</span>
      <span>📍 Dr. Luis Alberto de Herrera 438, Artigas</span>
    </div>
  </div>

  <!-- 🔸 NAVBAR -->
  <header class="navbar">
    <div class="logo">Hotel Violeta <span>Boutique</span></div>
    <button class="nav-toggle" aria-expanded="false" aria-label="Abrir menú">
      <span class="hamburger"></span>
    </button>
    <nav class="main-nav" aria-label="Navegación principal">
      <ul>
        <li><a href="/rooms.html">Habitaciones</a></li>
        <li><a href="#">Servicios</a></li>
        <li><a href="#">Galería</a></li>
        <li><a href="/contact.html">Contacto</a></li>
      </ul>
    </nav>
    <a href="#" class="btn-nav">Reservar</a>
  </header>

  <!-- Hero -->
  <section class="hero" role="img" aria-label="Interior del hotel">
    <div class="inner">
      <h2>Contáctanos</h2>
      <p class="muted">¿Tienes dudas? Escríbenos y te responderemos a la brevedad.</p>
    </div>
  </section>

  <!-- Main -->
  <main class="container">
    <div class="grid">
      <!-- LEFT COLUMN -->
      <div>
        <!-- contact cards -->
        <div class="cards">
          <div class="card">
            <div class="icon">📞</div>
            <h4>Teléfono</h4>
            <p>+598 987 3657</p>
          </div>

          <div class="card">
            <div class="icon">💬</div>
            <h4>Whatsapp</h4>
            <p>+598 97 736 557</p>
          </div>

          <div class="card">
            <div class="icon">✉️</div>
            <h4>Email</h4>
            <p>reservas@violetahotel.uy</p>
          </div>

          <div class="card">
            <div class="icon">📍</div>
            <h4>Dirección</h4>
            <p>Dr. Luis Alberto de Herrera 438, Artigas, Uruguay</p>
          </div>
        </div>

        <!-- MAP -->
        <div class="map-wrap" aria-hidden="false">
          <!-- Embedded Google Maps (query to the hotel address). 
               If querés una versión "API key" con control más fino, podemos integrarla después.
          -->
          <iframe
            src="https://www.google.com/maps?q=Dr.+Luis+Alberto+de+Herrera+438,+Artigas,+Uruguay&output=embed"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <!-- RIGHT COLUMN: FORM -->
      <aside>
        <div class="contact-box">
          <div class="section-title">Ponte en contacto</div>
          <div class="section-sub">Rellena el formulario y te responderemos lo antes posible.</div>

          <form id="contactForm" novalidate>
            <div class="field">
              <label class="muted" for="name">Nombre</label>
              <input id="name" name="name" type="text" placeholder="Tu nombre" required>
            </div>

            <div class="field">
              <label class="muted" for="email">Correo</label>
              <input id="email" name="email" type="email" placeholder="tu@ejemplo.com" required>
            </div>

            <div class="field">
              <label class="muted" for="subject">Asunto</label>
              <input id="subject" name="subject" type="text" placeholder="Asunto" required>
            </div>

            <div class="field">
              <label class="muted" for="message">Mensaje</label>
              <textarea id="message" name="message" placeholder="Escribe tu mensaje..." required></textarea>
            </div>

            <div class="submit-row">
              <button type="submit" class="btn-send">Enviar Mensaje</button>
              <div class="note" id="formNote">Respuesta normalmente en 24 horas.</div>
            </div>
          </form>

        </div>
      </aside>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="fwrap">
      <div>
        <img src="images/logo.png" alt="Violeta logo" style="width:56px;margin-bottom:12px;">
        <h3>Violeta Hotel Boutique</h3>
        <p>Dr. Luis Alberto de Herrera 438, Artigas, Uruguay<br>Tel: +598 987 3657<br>reservas@violetahotel.uy</p>
      </div>

      <div>
        <h4>Nuestro Hotel</h4>
        <ul>
          <li>Sobre Nosotros</li>
          <li>Habitaciones</li>
          <li>Servicios</li>
          <li>Reserva</li>
        </ul>
      </div>

      <div>
        <h4>Enlaces Útiles</h4>
        <ul>
          <li>Términos y Condiciones</li>
          <li>Política de Privacidad</li>
          <li>Contacto</li>
        </ul>
      </div>

      <div>
        <h4>Síguenos</h4>
        <p>Facebook · Instagram · Twitter</p>
      </div>
    </div>
  </footer>

  <script>
    // Simple front-end validation + simulated submission
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      // Basic validation
      const name = document.getElementById('name');
      const email = document.getElementById('email');
      const subject = document.getElementById('subject');
      const message = document.getElementById('message');
      if (!name.value.trim() || !email.value.trim() || !subject.value.trim() || !message.value.trim()) {
        alert('Por favor completa todos los campos.');
        return;
      }
      // Validate email simple
      const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRe.test(email.value.trim())) {
        alert('Ingresa un correo válido.');
        return;
      }

      // Simulate sending:
      const btn = form.querySelector('.btn-send');
      btn.disabled = true;
      btn.textContent = 'Enviando...';

      // Simulate async (replace with real fetch/ajax to your backend)
      setTimeout(() => {
        btn.disabled = false;
        btn.textContent = 'Enviar Mensaje';
        form.reset();
        alert('Gracias — tu mensaje ha sido enviado. Te responderemos pronto.');
      }, 1200);
    });
  </script>

</body>
</html>
