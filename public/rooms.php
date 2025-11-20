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

        <button class="book-btn" data-room="<?php echo htmlspecialchars($habitacion['nombre_habitacion'], ENT_QUOTES); ?>" <?php echo $buttonDisabled; ?>>
          Reservar Ahora
        </button>
    </div>

</article>

<?php endwhile; ?>
<!-- 

    <article class="room-card">
      <div class="room-media">
        <img src="../public/assets/images/Dormitorio moderno con toques vintage.png" alt="Single Room">
        <span class="badge unavailable">Reservado</span>
      </div>
      <div class="room-info">
        <h3>Habitación Moderna <span class="price">$3.500 / noche</span></h3>
        <p>Habitación con estilo artístico y contemporáneo, equipada con una cama de dos plazas, decoración moderna y detalles únicos. Ofrece un ambiente luminoso, elegante y diseñado para un descanso cómodo e inspirador.</p>
        <div class="icons">
          <span>👤 1 huésped / 2 huéspedes</span>
          <span>📏 24 m²</span>
          <span>🛏 Cama Queen</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn" disabled>Reservar Ahora</button>
      </div>
    </article>

    <article class="room-card">
      <div class="room-media">
        <img src="../public/assets/images/Habitación elegante con paredes florales.png">
        <span class="badge unavailable">Reservado</span>
      </div>
      <div class="room-info">
        <h3>Habitación Estándar <span class="price">$2.000  / noche</span></h3>
        <p>Habitación cómoda y funcional con una cama de dos plazas, decoración sencilla y todos los servicios esenciales para una estadía confortable. Ideal para viajeros solos o parejas que buscan una opción práctica y accesible.</p>
        <div class="icons">
          <span>👤 1 huésped / 2 huéspedes</span>
          <span>📏 20 m²</span>
          <span>🛏 Cama King</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn">Reservar Ahora</button>
      </div>
    </article>

    <article class="room-card">
      <div class="room-media">
        <img src="../public/assets/images/Galería de arte con geodas y pintura.png">
        <span class="badge available">Disponible</span>
      </div>
      <div class="room-info">
        <h3>Habitación Clásica Confort<span class="price">$3.000 / noche</span></h3>
        <p>Espacio acogedor y elegante equipado con una cama de dos plazas, iluminación cálida y detalles decorativos que crean un ambiente ideal para descansar. Su estilo clásico y armonioso la convierte en una opción perfecta para viajeros que buscan comodidad y tranquilidad durante su estadía.</p>
        <div class="icons">
          <span>👤 2 huéspedes</span>
          <span>📏 20-22 m²</span>
          <span>🛏 Cama King</span>
          <span>📶 WiFi</span>
          <span>🚿 Ducha</span>
          <span>🍽 Desayuno</span>
        </div>
        <button class="book-btn">Reservar Ahora</button>
      </div>
    </article> -->



    <div class="newsletter">
      <input placeholder="Ingresa tu correo para recibir ofertas y descuentos">
      <button>Suscribirse</button>
    </div>
  </main>

  <!-- Modal de reserva -->
  <div id="reserveModal" class="modal" aria-hidden="true">
    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <header class="modal-header">
        <h2 id="modalTitle">Agendar Habitación</h2>
        <button id="modalClose" class="modal-close" aria-label="Cerrar">×</button>
      </header>
      <form id="reserveForm" class="modal-body">
        <input type="hidden" id="roomName" name="roomName">
        <input type="hidden" id="roomId" name="roomId">

        <label for="roomType">Tipo de habitación</label>
        <input type="text" id="roomType" name="roomType" readonly>

        <label for="startDate">Fecha de entrada</label>
        <input type="date" id="startDate" name="startDate" required>

        <label for="endDate">Fecha de salida</label>
        <input type="date" id="endDate" name="endDate" required>

        <div class="modal-actions">
          <button type="button" id="cancelBtn" class="btn btn-secondary">Cancelar</button>
          <button type="submit" id="sendBtn" class="btn btn-primary">Confirmar</button>
        </div>
      </form>
    </div>
  </div>

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

  <style>
    /* Modal básico */
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); align-items: center; justify-content: center; z-index: 9999; }
    .modal[aria-hidden="false"] { display: flex; }
    .modal-dialog { background: #fff; border-radius: 8px; width: 360px; max-width: calc(100% - 32px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); overflow: hidden; }
    .modal-header { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid #eee; }
    .modal-body { display:flex; flex-direction:column; gap:8px; padding:16px; }
    .modal-body label { font-size:0.9rem; color:#333; }
    .modal-body input[type="date"] { padding:8px; border:1px solid #ccc; border-radius:4px; }
    .modal-actions { display:flex; gap:8px; justify-content:flex-end; margin-top:8px; }
    .btn { padding:8px 12px; border-radius:6px; border:none; cursor:pointer; }
    .btn-primary { background:#6c5ce7; color:#fff; }
    .btn-secondary { background:#eee; color:#333; }
    .modal-close { background:transparent; border:none; font-size:20px; cursor:pointer; }
  </style>

  <script>
    // Abre el modal y rellena los campos de habitación
    function openModal(roomName, roomId) {
      document.getElementById('roomName').value = roomName || '';
      document.getElementById('roomId').value = roomId || '';
      document.getElementById('roomType').value = roomName || '';
      // mantener título principal y mostrar modal
      const modal = document.getElementById('reserveModal');
      modal.setAttribute('aria-hidden', 'false');
      setTimeout(() => document.getElementById('startDate').focus(), 50);
    }

    function closeModal() {
      const modal = document.getElementById('reserveModal');
      modal.setAttribute('aria-hidden', 'true');
      document.getElementById('reserveForm').reset();
      document.getElementById('roomType').value = '';
    }

    // Vincular botones Reservar Ahora a la apertura del modal (usando data-room)
    document.querySelectorAll('.book-btn').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        const roomName = btn.dataset.room || '';
        const roomId = btn.dataset.roomId || '';
        openModal(roomName, roomId);
      });
    });

    // Cerrar modal con el botón X o Cancelar
    document.getElementById('modalClose').addEventListener('click', closeModal);
    document.getElementById('cancelBtn').addEventListener('click', closeModal);

    // Envío del formulario (validación simple)
    document.getElementById('reserveForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const start = document.getElementById('startDate').value;
      const end = document.getElementById('endDate').value;
      const room = document.getElementById('roomType').value;

      if (!start || !end) {
        alert('Por favor selecciona ambas fechas.');
        return;
      }

      if (start > end) {
        alert('La fecha de entrada no puede ser posterior a la de salida.');
        return;
      }

      // Aquí podrías enviar los datos al servidor con fetch/AJAX.
      // Por ahora mostramos una confirmación y cerramos el modal.
      alert('Reserva enviada para ' + room + '\nDesde: ' + start + ' Hasta: ' + end);
      closeModal();
    });
  </script>
</body>
</html>