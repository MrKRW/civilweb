// ============================
// SERVICES PAGE — services.js
// ============================

// Scroll Reveal for .reveal-up elements (services page uses this class)
const revealUpEls = document.querySelectorAll('.reveal-up');
if (revealUpEls.length > 0) {
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        revealObserver.unobserve(e.target);
      }
    });
  }, { threshold: 0.08 });

  revealUpEls.forEach(el => revealObserver.observe(el));
}

// Hash-based section highlight for nav
function highlightServicesNav() {
  const hash = window.location.hash;
  const navLinks = document.querySelectorAll('.sticky-nav li a');
  navLinks.forEach(a => {
    const li = a.closest('li');
    if (li) li.classList.remove('active');
  });

  const servicesLi = document.querySelector('.sticky-nav li.nav-has-dropdown');
  if (servicesLi) servicesLi.classList.add('active');
}

highlightServicesNav();
window.addEventListener('hashchange', highlightServicesNav);

// Smooth scroll for anchor links within services page
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      e.preventDefault();
      window.scrollTo({
        top: target.offsetTop - 80,
        behavior: 'smooth'
      });
    }
  });
});
