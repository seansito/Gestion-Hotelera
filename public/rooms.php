<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hotel Violeta Boutique | Habitaciones</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/rooms.css">
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
        <li><a href="./includes/contact.php">Contacto</a></li>
      </ul>
    </nav>
    <a href="#" class="btn-nav">Reservar</a>
  </header>


  <main class="rooms">
    <article class="room-card">
      <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80" alt="Deluxe Room">
      <div class="room-info">
        <h3>Deluxe Room <span class="price">$220 / noche</span></h3>
        <span class="badge available">Disponible</span>
        <p>Una habitación elegante y amplia con cama King, baño privado, WiFi y desayuno incluido.</p>
        <div class="icons">
          <span>👤 4 Personas</span>
          <span>📏 36 m²</span>
          <span>🛏 Cama King</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn">Reservar Ahora</button>
      </div>
    </article>

    <article class="room-card">
      <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80" alt="Single Room">
      <div class="room-info">
        <h3>Single Room <span class="price">$220 / noche</span></h3>
        <span class="badge unavailable">No disponible</span>
        <p>Perfecta para viajeros individuales. Espaciosa, moderna y equipada con todas las comodidades.</p>
        <div class="icons">
          <span>👤 1 Persona</span>
          <span>📏 28 m²</span>
          <span>🛏 Cama Queen</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn" disabled>Reservar Ahora</button>
      </div>
    </article>

    <article class="room-card">
      <img src="https://images.unsplash.com/photo-1590490359683-658d3d23f682?auto=format&fit=crop&w=1200&q=80" alt="Couple Room">
      <div class="room-info">
        <h3>Couple Room <span class="price">$220 / noche</span></h3>
        <span class="badge available">Disponible</span>
        <p>Diseñada para parejas, con un ambiente romántico, cama king y vistas panorámicas.</p>
        <div class="icons">
          <span>👤 2 Personas</span>
          <span>📏 35 m²</span>
          <span>🛏 Cama King</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn">Reservar Ahora</button>
      </div>
    </article>

    <article class="room-card">
      <img src="https://images.unsplash.com/photo-1505691723518-36a39a68f74b?auto=format&fit=crop&w=1200&q=80" alt="Standard Room">
      <div class="room-info">
        <h3>Standard Room <span class="price">$220 / noche</span></h3>
        <span class="badge available">Disponible</span>
        <p>Una opción moderna y confortable para quienes buscan una experiencia relajada y funcional.</p>
        <div class="icons">
          <span>👤 4 Personas</span>
          <span>📏 35 m²</span>
          <span>🛏 Cama King</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn">Reservar Ahora</button>
      </div>
    </article>



    <div class="newsletter">
      <input placeholder="Ingresa tu correo para recibir ofertas y descuentos">
      <button>Suscribirse</button>
    </div>
  </main>

  <footer>
    <div class="container">
      <div>
        <h3>Hotel Violeta Boutique</h3>
        <p>Tu refugio de confort y elegancia en el corazón de la ciudad. Reserva tu experiencia inolvidable hoy.</p>
      </div>
      <div>
        <h4>Enlaces Útiles</h4>
        <ul>
          <li>Habitaciones</li>
          <li>Restaurante</li>
          <li>Spa y Bienestar</li>
          <li>Contacto</li>
        </ul>
      </div>
      <div>
        <h4>Contacto</h4>
        <p>📞 +598 987 3657</p>
        <p>📧 tavernhotel@gmail.com</p>
        <p>📍 2612 Viole Street, Montevideo</p>
      </div>
    </div>
  </footer>

  <script src="inicio2.js"></script>

  <script>
    document.querySelectorAll('.book-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        alert('Redirigiendo al sistema de reservas...');
      });
    });
  </script>
</body>
</html>