 // Booking
    document.getElementById("bookingForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const checkin = document.getElementById("checkin").value;
      const checkout = document.getElementById("checkout").value;
      const adults = document.getElementById("adults").value;
      const children = document.getElementById("children").value;
      const result = document.getElementById("bookingResult");

      if (!checkin || !checkout) {
        result.textContent = "⚠️ Selecciona ambas fechas.";
        result.style.color = "red"; return;
      }
      if (checkout <= checkin) {
        result.textContent = "⚠️ La salida debe ser posterior a la entrada.";
        result.style.color = "red"; return;
      }
      result.textContent = `✅ Habitaciones disponibles del ${checkin} al ${checkout} para ${adults} adulto(s) y ${children} niño(s).`;
      result.style.color = "green";
    });

    // Slider (solo una vez, dentro de DOMContentLoaded)

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".extra-card");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  cards.forEach(card => observer.observe(card));
});



document.addEventListener("DOMContentLoaded", () => {
  const facilities = document.querySelectorAll(".facility-card");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });

  facilities.forEach(el => observer.observe(el));
});


document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".room-track");
  const rooms = document.querySelectorAll(".room");
  const prev = document.querySelector(".arrow.left");
  const next = document.querySelector(".arrow.right");

  let index = 0;

  function updateSlider() {
    const roomWidth = rooms[0].offsetWidth + 30; // ancho + margen
    track.style.transform = `translateX(${-index * roomWidth}px)`;
  }

  next.addEventListener("click", () => {
    if (index < rooms.length - 1) index++;
    else index = 0;
    updateSlider();
  });

  prev.addEventListener("click", () => {
    if (index > 0) index--;
    else index = rooms.length - 1;
    updateSlider();
  });

  // Animación automática cada 5 segundos
  setInterval(() => {
    next.click();
  }, 5000);

  window.addEventListener("resize", updateSlider);
});


  const track = document.querySelector('.room-track');
  const rooms = document.querySelectorAll('.room');
  const next = document.querySelector('.arrow.right');
  const prev = document.querySelector('.arrow.left');

  let index = 0;

  function updateSlider() {
    const roomWidth = rooms[0].offsetWidth + 30;
    track.style.transform = `translateX(-${index * roomWidth}px)`;
  }

  next.addEventListener('click', () => {
    if (index < rooms.length - 1) index++;
    updateSlider();
  });

  prev.addEventListener('click', () => {
    if (index > 0) index--;
    updateSlider();
  });

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".extra-card");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-extra");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  cards.forEach(card => observer.observe(card));
});
console.log("tumami")