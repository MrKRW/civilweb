// ============================
// ELEMENT REFS
// ============================

const topBar = document.getElementById('top-bar');
const stickyHeader = document.getElementById('sticky-header');
const backTop = document.getElementById('back-top');
const mobileNav = document.getElementById('mobile-nav');
const mobileClose = document.getElementById('mobile-nav-close');
const hamburgerBtn = document.getElementById('hamburger-btn');

// Section→nav-label mapping (for active highlight on home page)
const sectionMap = [
  { id: 'hero', label: 'home' },
  { id: 'about', label: 'about' },
  { id: 'projects', label: 'projects' },
  { id: 'footer', label: 'contact' },
];

function getActiveSection() {
  let current = 'home';
  sectionMap.forEach(({ id, label }) => {
    const el = document.getElementById(id);
    if (el && window.scrollY >= el.offsetTop - 120) current = label;
  });
  return current;
}

function updateNavActive(label) {
  if (!stickyHeader) return;
  stickyHeader.querySelectorAll('.sticky-nav li').forEach(li => {
    const a = li.querySelector('a');
    if (a) li.classList.toggle('active', a.textContent.trim() === label);
  });
}

function setActiveNavFromPath() {
  if (!stickyHeader || document.getElementById('hero')) return;

  const page = window.location.pathname.split('/').pop() || 'index.html';
  const pageKey = page === '' || page === 'index.html' ? 'home' : page.replace('.html', '');

  stickyHeader.querySelectorAll('.sticky-nav li').forEach(li => {
    const a = li.querySelector('a');
    if (!a) return;
    const href = a.getAttribute('href') || '';
    const linkKey = href === 'index.html' ? 'home' : href.replace('.html', '');
    li.classList.toggle('active', linkKey === pageKey);
  });

  if (mobileNav) {
    mobileNav.querySelectorAll('a').forEach(a => {
      const href = a.getAttribute('href') || '';
      const linkKey = href === 'index.html' ? 'home' : href.replace('.html', '');
      a.classList.toggle('active', linkKey === pageKey);
    });
  }
}

// ============================
// SCROLL-REVEAL NAV (home page only)
// On the home page the nav is hidden at page-top and slides in on scroll.
// On all other pages it is always visible.
// ============================
const isScrollRevealPage = document.getElementById('hero') !== null;

if (isScrollRevealPage && stickyHeader) {
  stickyHeader.classList.add('nav-hidden');
}


// Apply border-hidden class on load if already at top
if (stickyHeader) {
  stickyHeader.classList.toggle('nav-at-top', window.scrollY === 0);
}

const REVEAL_THRESHOLD = 80; // px

// Set initial active nav highlight on page load
if (document.getElementById('hero')) {
  updateNavActive('home');
} else {
  setActiveNavFromPath();
}

window.addEventListener('scroll', () => {
  const scrolled = window.scrollY;

  // Hide/show hero top-bar
  if (topBar) topBar.classList.toggle('hidden', scrolled > 50);

  if (stickyHeader) {
    // Scroll-reveal on home & about
    if (isScrollRevealPage) {
      stickyHeader.classList.toggle('nav-hidden', scrolled < REVEAL_THRESHOLD);
    } else if (document.body.classList.contains('home-page') && stickyHeader) {
      stickyHeader.classList.remove('nav-hidden');
    }

    // Hide bottom border at page-top, show when scrolled
    stickyHeader.classList.toggle('nav-at-top', scrolled === 0);

    // Back-to-top button
    if (backTop) backTop.classList.toggle('show', scrolled > 400);

    // Active nav highlight (home page only) — always keep "home" active
    if (document.getElementById('hero')) {
      updateNavActive('home');
    }
  }
});

// ============================
// MOBILE NAV (hamburger + close button)
// ============================

function openMenu() { if (mobileNav) mobileNav.classList.add('open'); }
function closeMenu() { if (mobileNav) mobileNav.classList.remove('open'); }

if (hamburgerBtn) hamburgerBtn.addEventListener('click', openMenu);
if (mobileClose) mobileClose.addEventListener('click', closeMenu);
if (mobileNav) mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
// ============================
// BACK TO TOP
// ============================
if (backTop) backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

// ============================
// OLD HERO SWIPER REMOVED
// ============================

// ============================
// OUR WORK SWIPER
// ============================
const ourWorkTitle = document.querySelector('.our-work-title');
const ourWorkCat = document.querySelector('.our-work-cat');

// Helper: fade-update the left-panel text smoothly
function updateOurWorkInfo(title, cat) {
  if (!ourWorkTitle || !ourWorkCat) return;

  // Fade out
  ourWorkTitle.style.opacity = '0';
  ourWorkCat.style.opacity = '0';

  // After fade-out completes, swap text and fade back in
  setTimeout(() => {
    ourWorkTitle.textContent = title || '';
    ourWorkCat.textContent = cat || '';
    ourWorkTitle.style.opacity = '1';
    ourWorkCat.style.opacity = '1';
  }, 280); // matches CSS transition duration
}

let ourWorkSwiper;
if (typeof Swiper !== 'undefined' && document.querySelector('.our-work-swiper')) {
  ourWorkSwiper = new Swiper('.our-work-swiper', {
    loop: true,
    speed: 700,
    grabCursor: true,
    centeredSlides: false,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    slidesPerView: 'auto',
    spaceBetween: 4,
    breakpoints: {
      0:    { spaceBetween: 4 },
      768:  { spaceBetween: 4 },
      1024: { spaceBetween: 4 }
    },
    navigation: {
      prevEl: '.our-work-prev',
      nextEl: '.our-work-next'
    },
    observer: true,
    observeParents: true,
    on: {
      slideChange() {
        // realIndex always points to the original (non-cloned) slide in loop mode
        const realSlides = this.slides.filter(s => !s.classList.contains('swiper-slide-duplicate'));
        const realSlide = realSlides[this.realIndex];
        if (realSlide) {
          updateOurWorkInfo(realSlide.dataset.title, realSlide.dataset.cat);
        }
      }
    }
  });
}

// ============================
// TESTIMONIALS SWIPER
// ============================
let testSwiper;
if (typeof Swiper !== 'undefined' && document.querySelector('.test-swiper')) {
  testSwiper = new Swiper('.test-swiper', {
    loop: true,
    speed: 900,
    // Use horizontal slide animation (default)
    direction: 'horizontal',
    // Removed fade effect for slide transition
    autoplay: { delay: 6000, disableOnInteraction: false },
    pagination: {
      el: '.test-pagination',
      clickable: true,
    }
  });
}

// ============================
// HORIZONTAL ACCORDION
// ============================
const accHeaders = document.querySelectorAll('.acc-header');
const accCloses = document.querySelectorAll('.acc-close');

accHeaders.forEach(header => {
  header.addEventListener('click', () => {
    // Remove active from all items
    document.querySelectorAll('.acc-item').forEach(item => {
      item.classList.remove('active');
      const icon = item.querySelector('.acc-icon');
      if (icon) icon.innerHTML = '+';
    });

    // Add active to clicked item
    const parentItem = header.parentElement;
    parentItem.classList.add('active');
    const activeIcon = parentItem.querySelector('.acc-icon');
    if (activeIcon) activeIcon.innerHTML = '&minus;';
  });
});

accCloses.forEach(closeBtn => {
  closeBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const parentItem = closeBtn.closest('.acc-item');
    if (parentItem) {
      parentItem.classList.remove('active');
      const icon = parentItem.querySelector('.acc-icon');
      if (icon) icon.innerHTML = '+';
    }
  });
});

// ============================
// SCROLL REVEAL
// ============================
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      observer.unobserve(e.target);
    }
  });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .stagger, .reveal-up')
  .forEach(el => observer.observe(el));

// ============================
// TEAM LEFT-SLIDE ANIMATION
// ============================
const teamSection = document.getElementById('team');
if (teamSection) {
  const teamObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        teamSection.querySelectorAll('.team-cell').forEach(cell => {
          cell.classList.add('slide-in');
        });
        teamObserver.unobserve(teamSection);
      }
    });
  }, { threshold: 0.1 });
  teamObserver.observe(teamSection);
}

// ============================
// ABOUT SLIDESHOW
// ============================
const aboutSlides = document.querySelectorAll('.about-slide');
if (aboutSlides.length > 0) {
  let currentSlide = 0;
  setInterval(() => {
    aboutSlides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % aboutSlides.length;
    aboutSlides[currentSlide].classList.add('active');
  }, 4000);
}

