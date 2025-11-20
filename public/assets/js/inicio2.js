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

// Keep CSS vars and body padding in sync with actual topbar/navbar heights
function updateHeaderOffsets(){
	const topbar = document.querySelector('.topbar');
	const navbarEl = document.querySelector('.navbar');
	const topH = topbar ? topbar.offsetHeight : 0;
	const navH = navbarEl ? navbarEl.offsetHeight : 0;
	// set CSS custom properties so CSS calc() picks up the real values
	document.documentElement.style.setProperty('--topbar-height', topH + 'px');
	document.documentElement.style.setProperty('--navbar-height', navH + 'px');
	// ensure body padding matches (fallback for older browsers)
	if (document.body) document.body.style.paddingTop = (topH + navH) + 'px';
	// also adjust mobile menu top directly to avoid layout jumps
	if (mainNav) mainNav.style.top = (topH + navH) + 'px';
}

// initial measurement and on small delays after DOM ready
updateHeaderOffsets();
window.addEventListener('load', updateHeaderOffsets);

// debounce resize updates
let _resizeTimer = null;
window.addEventListener('resize', () => {
	clearTimeout(_resizeTimer);
	_resizeTimer = setTimeout(() => {
		updateHeaderOffsets();
		// also close mobile menu when switching to wide layouts
		if (window.innerWidth > 850 && mainNav && mainNav.classList.contains('open')){
			mainNav.classList.remove('open');
			if (navToggle) navToggle.setAttribute('aria-expanded','false');
		}
	}, 120);
});

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

	// Close menu when resizing to a larger viewport to avoid stuck-open state
	window.addEventListener('resize', () => {
		// if window becomes wider than mobile breakpoint and nav is open, close it
		if (window.innerWidth > 850 && mainNav.classList.contains('open')) {
			mainNav.classList.remove('open');
			navToggle.setAttribute('aria-expanded','false');
		}
	});
}
