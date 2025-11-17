document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.animate').forEach(el => requestAnimationFrame(() => el.classList.add('visible')));
});

// Animación al hacer scroll
const animated = document.querySelectorAll('.animate');

const observer = new IntersectionObserver(entries => {
	entries.forEach(entry => {
		if (entry.isIntersecting) {
			entry.target.classList.add('visible');
		}
	});
}, { threshold: 0.2 });

animated.forEach(el => observer.observe(el));

// small helper: toggle navbar scrolled state for contrast
const navbar = document.querySelector('.navbar');
if (navbar) {
	const onScroll = () => {
		if (window.scrollY > 20) navbar.classList.add('scrolled'); else navbar.classList.remove('scrolled');
	};
	window.addEventListener('scroll', onScroll);
	onScroll();
}
// Parallax removed — hero simplified per user request

// Mobile nav toggle
const navToggle = document.querySelector('.nav-toggle');
const mainNav = document.querySelector('.main-nav');
if (navToggle && mainNav) {
	navToggle.addEventListener('click', () => {
		const expanded = navToggle.getAttribute('aria-expanded') === 'true';
		navToggle.setAttribute('aria-expanded', String(!expanded));
		mainNav.classList.toggle('open');
	});

	// Close menu when a link is clicked
	mainNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
		mainNav.classList.remove('open');
		navToggle.setAttribute('aria-expanded', 'false');
	}));

	// also close on scroll to avoid stuck open menu
	window.addEventListener('scroll', () => {
		if (mainNav.classList.contains('open')){
			mainNav.classList.remove('open');
			navToggle.setAttribute('aria-expanded','false');
		}
	});
}
