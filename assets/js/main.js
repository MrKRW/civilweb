// ============================
// ELEMENT REFS
// ============================

const topBar = document.getElementById('top-bar');
const stickyHeader = document.getElementById('sticky-header');
const backTop = document.getElementById('back-top');
const mobileNav = document.getElementById('mobile-nav');
const mobileClose = document.getElementById('mobile-nav-close');
const hamburgerBtn = document.getElementById('hamburger-btn');

// Section→nav-label mapping removed because PHP handles active states

// ============================
// SCROLL-REVEAL NAV REMOVED
// Sticky header is always visible to standardize look.
// ============================


// Pages where the sticky header should be hidden until the user scrolls
const HIDE_NAV_PAGES = ['home-page', 'about-page'];
const isHideNavPage = HIDE_NAV_PAGES.some(cls => document.body.classList.contains(cls));

const REVEAL_THRESHOLD = 80; // px — header slides in after this many pixels

// Apply initial states on load
if (stickyHeader) {
  stickyHeader.classList.toggle('nav-at-top', window.scrollY === 0);
  // Hide the header immediately on home/about pages if at the top
  if (isHideNavPage && window.scrollY < REVEAL_THRESHOLD) {
    stickyHeader.classList.add('nav-hidden');
  }
}

window.addEventListener('scroll', () => {
  const scrolled = window.scrollY;

  // Hide/show hero top-bar (if still present)
  if (topBar) topBar.classList.toggle('hidden', scrolled > 50);

  if (stickyHeader) {

    // Hide bottom border at page-top, show when scrolled
    stickyHeader.classList.toggle('nav-at-top', scrolled === 0);

    // On home & about pages: hide header at top, reveal after scroll threshold
    if (isHideNavPage) {
      stickyHeader.classList.toggle('nav-hidden', scrolled < REVEAL_THRESHOLD);
    }

    // Back-to-top button
    if (backTop) backTop.classList.toggle('show', scrolled > 400);

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

let ourWorkTimeout;

// Helper: fade-update the left-panel text smoothly
function updateOurWorkInfo(title, cat) {
  if (!ourWorkTitle || !ourWorkCat) return;

  if (ourWorkTimeout) {
    clearTimeout(ourWorkTimeout);
  }

  // Fade out immediately
  ourWorkTitle.style.opacity = '0';
  ourWorkCat.style.opacity = '0';

  // After fade-out completes, swap text and fade back in
  // 300ms: slightly more than the 0.28s CSS transition to avoid flicker
  ourWorkTimeout = setTimeout(() => {
    ourWorkTitle.textContent = title || '';
    ourWorkCat.textContent = cat || '';
    // Small rAF to ensure DOM update before re-opacity
    requestAnimationFrame(() => {
      ourWorkTitle.style.opacity = '1';
      ourWorkCat.style.opacity = '1';
    });
  }, 300);
}

window.initOurWorkSwiper = function() {
  const swiperEl = document.querySelector('.our-work-swiper');
  if (!swiperEl || typeof Swiper === 'undefined') return;

  if (swiperEl.swiper) {
    swiperEl.swiper.destroy(true, true);
  }

  window.ourWorkSwiper = new Swiper('.our-work-swiper', {
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
      // realIndexChange fires ONLY when the true project content changes —
      // not during the silent loop-jump Swiper does internally.
      // This prevents double text-update flicker on loop boundaries.
      realIndexChange() {
        const realSlides = this.slides.filter(s => !s.classList.contains('swiper-slide-duplicate'));
        const realSlide = realSlides[this.realIndex];
        if (realSlide) {
          updateOurWorkInfo(realSlide.dataset.title, realSlide.dataset.cat);
        }
      }
    }
  });
};

window.initOurWorkSwiper();

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
      type: 'progressbar',
      clickable: true,
    }
  });

  // Make the entire wrapper clickable (left side = prev, right side = next)
  const navWrapper = document.querySelector('.test-nav-wrapper');
  if (navWrapper) {
    navWrapper.addEventListener('click', (e) => {
      const rect = navWrapper.getBoundingClientRect();
      const clickX = e.clientX - rect.left;
      if (clickX < rect.width / 2) {
        testSwiper.slidePrev();
      } else {
        testSwiper.slideNext();
      }
    });
  }
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

