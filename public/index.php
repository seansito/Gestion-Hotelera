<?php
require "./includes/mensajesSesion.php";
include "includes/recuerdame.php";
mostrarMensajes();


?> 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Pagina para gestionar y registrarse en el hotel Violeta Boutique">
  <title>Hotel Violeta Boutique</title>
  <link rel="stylesheet" href="../public/assets/css/inicio.css?v=<?php echo time(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Header action styles: desktop vs mobile */
    .header-actions{display:flex;gap:10px;align-items:center}
    .header-actions a{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:8px;text-decoration:none;font-weight:600}
    .btn-primary{background:var(--accent,#6b4);color:#fff}
    .btn-outline{background:transparent;border:1px solid rgba(0,0,0,0.08);color:inherit}
    .desktop-only{display:block}
    .mobile-only{display:none}
    @media (max-width:720px){
      .desktop-only{display:none}
      .mobile-only{display:flex}
      .header-actions a{padding:8px 10px;font-size:15px;border-radius:6px}
      .mobile-only a{padding:8px 10px;font-size:15px;border-radius:6px}
    }
  </style>
    <style>
      /* Header action styles: keep both buttons visible; adjust sizes on mobile */
      .header-actions{display:flex;gap:10px;align-items:center}
      .header-actions a{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:8px;text-decoration:none;font-weight:600}
      .btn-primary{background:var(--accent,#6b4);color:#fff}
      .btn-outline{background:transparent;border:1px solid rgba(0,0,0,0.08);color:inherit}
      /* Make touch targets slightly smaller on narrow screens so they fit better */
      @media (max-width:720px){
        .header-actions{gap:6px}
        .header-actions a{padding:6px 8px;font-size:13px;border-radius:6px}
      }
    </style>
</head>
<body>


   <header class="navbar">
    <!-- Logo (izquierda) -->
    <a href="index.php" class="logo-link">
      <div class="logo">Hotel Violeta <span>Boutique</span></div>
    </a>

    <!-- NAV: solo en desktop -->
    <nav class="main-nav desktop-only">
        <ul>
            <li><a href="rooms.php">Habitaciones</a></li>
            <li><a href="./includes/contact (2).html">Contacto</a></li>
        </ul>
    </nav>

    <!-- Desktop actions: Acceder + Ir al panel -->
      <!-- Acciones del header (Acceder + Ir al panel) - visible en todas las resoluciones; size ajustado en mobile -->
      <div class="header-actions" role="navigation" aria-label="Acciones usuario">
      <a href="login.php" class="btn-outline" title="Acceder">Acceder</a>
      <a href="../admin/panel.php" class="btn-primary" title="Ir al panel">Ir al panel</a>
    </div>

      <!-- Mobile actions are now included in the header-actions div -->
</header>

<!-- 🔸 NAVEGACIÓN SECUNDARIA (MOBILE) -->
<nav class="secondary-nav">
    <a href="rooms.php">Habitaciones</a>
    <a href="./includes/contact.php">Contacto</a>
</nav>

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
          <a class="btn btn-ghost" href="./includes/contact.php">Ver Habitaciones</a>
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
          <img src="./assets/images/Habitación con camas gemelas y arte moderno.png" alt="Habitación Deluxe">
          <div class="room-badge available">Disponible</div>
          <div class="room-price">$2.500 <small>/ noche</small></div>
        </div>
        <div class="room-body">
          <h3>Habitación Deluxe</h3>
          <p>Espacio confortable con dos camas individuales, ideal para amigos o viajeros que comparten estadía manteniendo independencia. Ambiente moderno, luminoso y equipado con ropa de cama premium, Smart TV 43” y wifi de alta velocidad.</p>
          <div class="room-meta"><span>2 huéspedes</span><span>28 m²</span></div>
          <div class="room-actions">
            <a class="btn btn-primary" href="rooms.php">Detalles</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 2 -->
      <article class="room-card modern">
        <div class="room-media">
          <img src="./assets/images/Dormitorio moderno con toques vintage.png" alt="Habitación Moderna">
          <div class="room-badge limited">Reservada</div>
          <div class="room-price">$3.500 <small>/ noche</small></div>
        </div>
        <div class="room-body">
          <h3>Habitación Moderna</h3>
          <p>Habitación con estilo artístico y contemporáneo, equipada con una cama de dos plazas, decoración moderna y detalles únicos. Ofrece un ambiente luminoso, elegante y diseñado para un descanso cómodo e inspirador.</p>
          <div class="room-meta"><span>1 huésped / 2 huéspedes</span><span>24 m²</span></div>
          <div class="room-actions">
            <a class="btn btn-primary" href="rooms.php">Detalles</a>
          </div>
        </div>
      </article>

      <!-- Tarjeta 3 -->
      <article class="room-card modern">
        <div class="room-media">
          <img src="./assets/images/Habitación elegante con paredes florales.png" alt="Suite Estandar">
          <div class="room-badge booked">No disponible</div>
          <div class="room-price">$2000 <small>/ noche</small></div>
        </div>
        <div class="room-body">
          <h3>Habitacion Estándar</h3>
          <p>Habitación cómoda y funcional con una cama de dos plazas, decoración sencilla y todos los servicios esenciales para una estadía confortable. Ideal para viajeros solos o parejas que buscan una opción práctica y accesible.</p>
          <div class="room-meta"><span>1 huésped / 2 huéspedes</span><span>20 m²</span></div>
          <div class="room-actions">
            <a class="btn btn-primary disabled" aria-disabled="true" href="rooms.php">Detalles</a>
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
    </div>
    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/399471684.jpg?k=d4d84d519199999037c0c8bed4de5453e9496091de3ce8616377e5103a2de181&o=" alt="Hotel interior">
  </section>

  <!-- 🔸 FOOTER -->
  <footer class="footer">
    <div class="footer-content">
      <div>
        <h3>Hotel Violeta Boutique</h3>
        <p>Dr. Luis Alberto de Herrera 438, Artigas</p>
        <p>📞 +598 99 772 500</p>
        <p>📧 violetahotelboutique@gmail.com</p>
      </div>
      <div>
        <h3>Enlaces</h3>
        <a href="../public/includes/contact.php">Contacto</a><br>
        <a href="../public/rooms.php">Habitaciones</a><br>
        <a href="#">Galería</a>
      </div>
      <div>
        <h3>Redes</h3>
        <a href="#">Instagram</a><br>
        <a href="#">WhatsApp</a>
      </div>
    </div>
    <p class="copy">© 2025 Hotel Violeta Boutique | Todos los derechos reservados</p>
  </footer> 
  
<script>
const toggle = document.querySelector(".nav-toggle");
const nav = document.querySelector(".main-nav");

toggle.addEventListener("click", () => {
  toggle.classList.toggle("active");
  nav.classList.toggle("open");
});
</script>


  <script src="../public/assets/js/inicio2.js"></script>
</body>
</html>
