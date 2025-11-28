// Coordenadas reales de la dirección
const lat = -30.4027;
const lon = -56.4660;

// Inicializar mapa
const map = L.map("map").setView([lat, lon], 16);

// Capa base OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19
}).addTo(map);

// Marcador
L.marker([lat, lon])
    .addTo(map)
    .bindPopup("Ubicación del hotel")
    .openPopup();

// Form
document.getElementById("contactForm").addEventListener("submit", e => {
    e.preventDefault();
    alert("Mensaje enviado ✔️");
});
