<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Violeta Boutique</title>
  <link rel="stylesheet" href="../public/assets/css/inicio.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
        <li><a href="rooms.html">Habitaciones</a></li>
        <li><a href="#">Servicios</a></li>
        <li><a href="#">Galería</a></li>
        <li><a href="./includes/contact.html">Contacto</a></li>
      </ul>
    </nav>
    <a href="login.html" class="btn-nav">Acceder</a>
  </header>

  <!-- 🔸 HERO -->
  <section class="hero">
    <div class="hero-inner animate">
      <div class="hero-media-simple">
        <img src="./assets/images/Hotel Violeta al anochecer.png" alt="Recepción del hotel">
      </div>
      <div class="hero-copy-simple">
        <h1>Bienvenido a Hotel Violeta Boutique</h1>
        <p class="lead">Confort y diseño en el corazón de la ciudad. Habitaciones elegantes, servicio atento y una experiencia única.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="rooms.html">Ver Habitaciones</a>
          <a class="btn btn-ghost" href="#contact">Contacto</a>
        </div>
      </div>
    </div>
  </section>

  <!-- 🔸 ROOMS -->
  <section class="rooms animate">
    <div class="rooms-header">
      <h2>Habitaciones más destacadas</h2>
      <p class="rooms-sub">Diseñadas para ofrecerte comodidad, estilo y tranquilidad</p>
    </div>

    <div class="room-grid modern-grid">
      <!-- Tarjeta 1 -->
      <article class="room-card modern">
        <div class="room-media">
          <img src="./assets/images/Habitación con camas gemelas y arte moderno.png" alt="Suite Deluxe">
          <div class="room-badge available">Disponible</div>
          <div class="room-price">$120 <small>/ noche</small></div>
        </div>
        <div class="room-body">
          <h3>Suite Deluxe</h3>
          <p>Amplia habitación con vista, cama king-size y amenities premium para una estadía inolvidable.</p>
          <div class="room-meta"><span>2 huéspedes</span><span>45 m²</span></div>
          <div class="room-actions">
            <a class="btn btn-primary" href="rooms.html">Detalles</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 2 -->
      <article class="room-card modern">
        <div class="room-media">
          <img src="./assets/images/Dormitorio moderno con toques vintage.png" alt="Habitación Ejecutiva">
          <div class="room-badge limited">Últimas</div>
          <div class="room-price">$90 <small>/ noche</small></div>
        </div>
        <div class="room-body">
          <h3>Habitación Ejecutiva</h3>
          <p>Espacio pensado para el trabajo y el descanso, con escritorio, wifi y servicios de business center.</p>
          <div class="room-meta"><span>2 huéspedes</span><span>28 m²</span></div>
          <div class="room-actions">
            <a class="btn btn-primary" href="/rooms.html">Detalles</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 3 -->
      <article class="room-card modern">
        <div class="room-media">
          <img src="./assets/images/Habitación elegante con paredes florales.png" alt="Suite Romántica">
          <div class="room-badge booked">No disponible</div>
          <div class="room-price">$150 <small>/ noche</small></div>
        </div>
        <div class="room-body">
          <h3>Suite Romántica</h3>
          <p>Ambiente íntimo y elegante, con jacuzzi privado y detalles para una escapada en pareja.</p>
          <div class="room-meta"><span>2 huéspedes</span><span>55 m²</span></div>
          <div class="room-actions">
            <a class="btn btn-primary disabled" aria-disabled="true" href="#">Detalles</a>
          </div>
        </div>
      </article>
    </div>
  </section>

  <!-- 🔸 ABOUT -->
  <section class="about animate">
    <div class="about-text">
      <h2>Sobre Nosotros</h2>
      <p>En Hotel Violeta Boutique fusionamos la elegancia contemporánea con la calidez de la hospitalidad. Cada detalle está pensado para ofrecerte una estadía inolvidable: gastronomía gourmet, spa exclusivo y servicio de primera clase.</p>
      <a href="#" class="btn-outline">Conocer Más</a>
    </div>
    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Hotel interior">
  </section>

  <!-- 🔸 FOOTER -->
  <footer class="footer">
    <div class="footer-content">
      <div>
        <h3>Hotel Violeta Boutique</h3>
        <p>Av. Costanera 1250, Montevideo</p>
        <p>📞 +598 2400 5678</p>
      </div>
      <div>
        <h3>Enlaces</h3>
        <a href="#">Inicio</a><br>
        <a href="#">Habitaciones</a><br>
        <a href="#">Servicios</a>
      </div>
      <div>
        <h3>Redes</h3>
        <a href="#">Instagram</a><br>
        <a href="#">WhatsApp</a>
      </div>
    </div>
    <p class="copy">© 2025 Hotel Violeta Boutique | Todos los derechos reservados</p>
  </footer>

  <script src="./assets/js/inicio2.js"></script>
</body>
</html>
