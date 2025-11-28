<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto — Hotel</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
      body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background: #eef2f9;
}

/* FORMA SUPERIOR */
.hero-shape {
    position: absolute;
    top: -80px;
    left: -80px;
    width: 350px;
    height: 350px;
    background: linear-gradient(135deg, #4c6fff, #009dff);
    border-radius: 50%;
    opacity: 0.28;
    filter: blur(4px);
}

/* CONTENEDOR */
.contact-wrapper {
    max-width: 1200px;
    padding: 40px;
    margin: 80px auto 30px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 35px;
}

/* LEFT */
.contact-info h2,
.contact-form h2 {
    font-size: 28px;
    color: #15223b;
}

.subtitle {
    margin-bottom: 20px;
    color: #555;
}

.info-box {
    display: flex;
    align-items: center;
    margin: 20px 0;
}

.icon {
    background: #4c6fff;
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 15px;
    color: white;
    font-size: 22px;
    box-shadow: 0 6px 12px rgba(76,111,255,0.25);
}

.follow {
    margin-top: 25px;
}

.social-row a {
    font-size: 26px;
    margin-right: 12px;
    cursor: pointer;
    transition: 0.3s;
}

.social-row a:hover {
    transform: scale(1.2) rotate(-5deg);
}

/* FORM */
.contact-form form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

input, select, textarea {
    padding: 14px 16px;
    border-radius: 14px;
    border: 1px solid #d8dcec;
    background: #f6f8fc;
    font-size: 15px;
    transition: 0.3s;
}

input:focus, select:focus, textarea:focus {
    border-color: #4c6fff;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(76,111,255,0.2);
    outline: none;
}

textarea {
    height: 120px;
    resize: none;
}

.send-btn {
    padding: 15px;
    border: none;
    background: linear-gradient(135deg, #4c6fff, #009dff);
    color: white;
    border-radius: 14px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
}

.send-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(76,111,255,0.4);
}

/* MAPA */
#map {
    width: 100%;
    height: 430px;
    border-radius: 20px;
    margin-bottom: 40px;
    overflow: hidden;
    box-shadow: 0 14px 30px rgba(0,0,0,0.15);
}

/* ANIMACIONES */
.animate-left {
    animation: slideLeft 0.9s ease forwards;
    opacity: 0;
}

.animate-right {
    animation: slideRight 0.9s ease forwards;
    opacity: 0;
}

@keyframes slideLeft {
    from { transform: translateX(-40px); opacity: 0; }
    to   { transform: translateX(0); opacity: 1; }
}

@keyframes slideRight {
    from { transform: translateX(40px); opacity: 0; }
    to   { transform: translateX(0); opacity: 1; }
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }
}

    </style>
</head>
<body>

    <div class="hero-shape"></div>

    <section class="contact-wrapper">

        <!-- LEFT -->
        <div class="contact-info animate-left">
            <h2>Contáctanos</h2>
            <p class="subtitle">Atendemos tus consultas 24/7.</p>

            <div class="info-box">
                <span class="icon">📍</span>
                <div>
                    <h3>Dirección</h3>
                    <p>Dr. Luis Alberto de Herrera 438,<br>Artigas — Uruguay</p>
                </div>
            </div>

            <div class="info-box">
                <span class="icon">✉️</span>
                <div>
                    <h3>Email</h3>
                    <p>contacto@hotelvioleta.com</p>
                </div>
            </div>

            <div class="info-box">
                <span class="icon">📞</span>
                <div>
                    <h3>Teléfono</h3>
                    <p>+598 99 200 200</p>
                </div>
            </div>

            <h3 class="follow">Redes Sociales</h3>
            <div class="social-row">
                <a>📘</a><a>📸</a><a>▶️</a><a>🐦</a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="contact-form animate-right">
            <h2>Envíanos un mensaje</h2>

            <form id="contactForm">
                <div class="grid">
                    <input type="text" placeholder="Nombre" required>
                    <input type="text" placeholder="Empresa">
                </div>

                <div class="grid">
                    <input type="text" placeholder="Teléfono" required>
                    <input type="email" placeholder="Email" required>
                </div>

                <select required>
                    <option value="">Motivo</option>
                    <option value="consulta">Consulta</option>
                    <option value="reserva">Reserva</option>
                    <option value="otro">Otro</option>
                </select>

                <textarea placeholder="Tu mensaje..." required></textarea>

                <button class="send-btn">Enviar Mensaje</button>
            </form>
        </div>

    </section>

    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="../public/assets/js/contact.js"></script>
</body>
</html>
