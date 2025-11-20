<?php
require_once "../src/connect.php";

$sql = "SELECT * FROM habitaciones";
$resultado = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hotel Violeta Boutique | Habitaciones</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Shared site styles for header/footer/colors/animations -->
  <link rel="stylesheet" href="../public/assets/css/rooms.css?v=<?php echo time(); ?>">
 <link rel="stylesheet" href="../public/assets/css/inicio.css?v=<?php echo time(); ?>"> 
<!-- estas etiquetas raras de php en los conectores css son para que la pagina se recargue todo el tiempo -->
</head>
<body>
 <!-- 🔸 TOPBAR -->
  <div class="topbar">
    <div class="container">
      <span>📞 +598 99 772 500 | 📧 violetahotelboutique@gmail.com</span>
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
        <li><a href="../public/rooms.php">Habitaciones</a></li>
        <li><a href="#">Servicios</a></li>
        <li><a href="#">Galería</a></li>
        <li><a href="./includes/contact.php">Contacto</a></li>
      </ul>
    </nav>
    <a href="login.php" class="btn-nav">Acceder</a>
  </header>

  <main class="rooms">

  <?php while ($habitacion = $resultado->fetch_assoc()): ?>
    
  <?php
    $estado = $habitacion['estado'] == 1;
    
    $badgeClass = $estado ? "available" : "unavailable";
    $badgeText  = $estado ? "Disponible" : "Reservado";

    $buttonDisabled = $estado ? "" : "disabled";
  ?>
    <!-- <article class="room-card">
      <div class="room-media">
        <img src="../public/assets/images/Habitación con camas gemelas y arte moderno.png">

        <span class="badge available">Disponible</span>
      </div>
      <div class="room-info">
        <h3>Habitación Twin <span class="price">$2.500 / noche</span></h3>
        <p>Espacio confortable con dos camas individuales, ideal para amigos o viajeros que comparten estadía manteniendo independencia. Ambiente moderno, luminoso y equipado con ropa de cama premium, Smart TV 43” y wifi de alta velocidad.</p>
        <div class="icons">
          <span>👤 2 huéspedes</span>
          <span>📏 28 m²</span>
          <span>🛏 Camas gemelas</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
  <button class="book-btn" disabled>Reservar Ahora</button>
      </div>
    </article> -->
    <article class="room-card">

    <div class="room-media">
        <img src="../public/assets/images/<?php echo $habitacion['imagen'];?>" alt="<?php echo $habitacion['nombre_habitacion']; ?>">

        <span class="badge <?php echo $badgeClass; ?>">
            <?php echo $badgeText; ?>
        </span>
    </div>

    <div class="room-info">
        <h3>
            <?php echo $habitacion['nombre_habitacion']; ?>
            <span class="price">$<?php echo number_format($habitacion['precio'], 0, ',', '.'); ?> / noche</span>
        </h3>

        <p><?php echo $habitacion['descripcion']; ?></p>

        <div class="icons">
            <span>👤 <?php echo $habitacion['capacidad']; ?> huéspedes</span>
            <span>📏 <?php echo $habitacion['tamaño']; ?> m²</span>
            <span>🛏 <?php echo $habitacion['camas']; ?></span>
            <?php if ($habitacion['wifi']) echo "<span>📶 WiFi</span>"; ?>
            <span>🚿 Ducha</span>
            <?php if ($habitacion['desayuno']) echo "<span>🍽 Desayuno</span>"; ?>
        </div>

        <button class="book-btn" <?php echo $buttonDisabled; ?>>
            Reservar Ahora
        </button>
    </div>

</article>

<?php endwhile; ?>

    <div class="newsletter">
      <input placeholder="Ingresa tu correo para recibir ofertas y descuentos">
      <button>Suscribirse</button>
    </div>
  </main>

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

  <script src="../public/assets/js/inicio2.js"></script>

</body>
</html>