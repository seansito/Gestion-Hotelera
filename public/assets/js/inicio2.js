/* =================== Intersection Observer para animaciones =================== */
// Este script se carga en el HTML junto con el Intersection Observer
// No hay lógica de menú hamburger, el header es estático en mobile

/* =================== ANIMACIONES DE SCROLL =================== */

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.animate').forEach(el => {
    requestAnimationFrame(() => el.classList.add('visible'));
  });
});

const animated = document.querySelectorAll('.animate');
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, { threshold: 0.2 });

animated.forEach(el => observer.observe(el));

/* =================== NAVBAR SCROLLED STATE =================== */

const navbar = document.querySelector('.navbar');
if (navbar) {
  const onScroll = () => {
    if (window.scrollY > 20) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  };
  window.addEventListener('scroll', onScroll);
  onScroll();
}
