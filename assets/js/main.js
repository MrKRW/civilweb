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

// ============================
// OUR WORK — Featured Projects Slideshow
// ============================
(function () {
  const track       = document.getElementById('ow-track');
  const prevBtn     = document.getElementById('ow-prev');
  const nextBtn     = document.getElementById('ow-next');
  const nameEl      = document.getElementById('ow-project-name');
  const typeEl      = document.getElementById('ow-project-type');
  const progressEl  = document.getElementById('ow-progress-fill');

  if (!track) return; // not on home page

  const UPLOAD   = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/uploads/projects/';
  const PROJ_URL = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/projects/';
  const API_URL  = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/projects';

  let projects = [];
  let current  = 0;
  let autoTimer = null;
  let isAnimating = false;

  /* ── Show skeleton while loading ─── */
  track.innerHTML = '<div class="ow-skeleton"></div>';

  /* ── Fetch featured projects ─────── */
  fetch(API_URL + '?action=featured')
    .then(r => r.json())
    .then(data => {
      projects = (data.projects || []).filter(p => p.image_main);
      if (projects.length === 0) {
        // fallback: fetch all published and take first 6
        return fetch(API_URL + '?action=list&status=published')
          .then(r => r.json())
          .then(d => {
            projects = (d.projects || []).filter(p => p.image_main).slice(0, 6);
            buildSlider();
          });
      }
      buildSlider();
    })
    .catch(() => {
      track.innerHTML = ''; // silent fail, section stays dark
    });

  /* ── Build slider DOM ────────────── */
  function buildSlider() {
    if (projects.length === 0) { track.innerHTML = ''; return; }

    const buildHTML = (p, i) => {
      const src = UPLOAD + encodeURIComponent(p.image_main);
      const href = PROJ_URL + p.id;
      return `
        <a class="ow-slide" href="${href}" data-index="${i % projects.length}" draggable="false">
          <img src="${src}" alt="${escAttr(p.title)}" loading="${(i % projects.length) === 0 ? 'eager' : 'lazy'}"
               onerror="this.onerror=null;this.src='https://civilanka.com/uploads/projects/'+encodeURIComponent('${p.image_main}')">
        </a>`;
    };

    let html = '';
    for(let j = 0; j < 3; j++) {
       html += projects.map((p, i) => buildHTML(p, i + j * projects.length)).join('');
    }
    track.innerHTML = html;
    
    current = projects.length; // start at middle set

    updateSlideClasses(true);
    updateInfo(current % projects.length, false);
    updateProgress();
    startAuto();

    prevBtn && prevBtn.addEventListener('click', () => go(-1));
    nextBtn && nextBtn.addEventListener('click', () => go(1));

    /* Swipe support */
    let tsX = 0;
    track.addEventListener('touchstart', e => { tsX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
      const diff = tsX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 40) go(diff > 0 ? 1 : -1);
    }, { passive: true });

    /* Click on non-active slide navigates */
    track.addEventListener('click', e => {
      const slide = e.target.closest('.ow-slide');
      if (!slide) return;
      const slides = Array.from(track.querySelectorAll('.ow-slide'));
      const physicalIdx = slides.indexOf(slide);
      if (physicalIdx === current) return; // allow link navigation
      e.preventDefault();
      goTo(physicalIdx);
    });
  }

  /* ── Navigate ──────────────────── */
  function go(dir) {
    if (isAnimating) return;
    goTo(current + dir);
  }

  function goTo(idx) {
    if (idx === current || isAnimating) return;
    isAnimating = true;
    current = idx;

    updateSlideClasses(false);
    updateInfo(current % projects.length, true);
    updateProgress();
    resetAuto();

    setTimeout(() => { 
      isAnimating = false; 
      checkLoop();
    }, 780);
  }

  function checkLoop() {
    if (current >= projects.length * 2) {
      current -= projects.length;
      jumpToCurrent();
    } else if (current < projects.length) {
      current += projects.length;
      jumpToCurrent();
    }
  }

  function jumpToCurrent() {
    track.style.transition = 'none';
    updateSlideClasses(true);
    void track.offsetHeight;
    track.style.transition = '';
  }

  /* ── Update slide positions ──────── */
  function updateSlideClasses(sync = false) {
    const slides = track.querySelectorAll('.ow-slide');

    // 1. First remove all classes so layout reflows to default widths
    slides.forEach(s => s.classList.remove('ow-main', 'ow-peek'));

    // 2. Apply main + peek to current and next slide
    slides.forEach((s, i) => {
      if (i === current) s.classList.add('ow-main');
      else if (i === current + 1) s.classList.add('ow-peek');
    });

    // 3. Compute pixel offset by summing widths of slides before `current`
    const applyTransform = () => {
      let offset = 0;
      slides.forEach((s, i) => {
        if (i < current) offset += s.offsetWidth + 6; // 6px gap
      });
      track.style.transform = `translateX(-${offset}px)`;
    };

    if (sync) {
      applyTransform();
    } else {
      requestAnimationFrame(applyTransform);
    }
  }

  /* ── Update text labels ──────────── */
  function updateInfo(idx, animate) {
    const p = projects[idx];
    if (!p) return;

    if (animate && nameEl && typeEl) {
      nameEl.classList.add('ow-fade-out');
      typeEl.classList.add('ow-fade-out');
      setTimeout(() => {
        nameEl.textContent = p.title || '';
        typeEl.textContent = p.service_type || p.category || '';
        nameEl.classList.remove('ow-fade-out');
        typeEl.classList.remove('ow-fade-out');
        nameEl.classList.add('ow-fade-in');
        typeEl.classList.add('ow-fade-in');
        setTimeout(() => {
          nameEl.classList.remove('ow-fade-in');
          typeEl.classList.remove('ow-fade-in');
        }, 400);
      }, 260);
    } else if (nameEl && typeEl) {
      nameEl.textContent = p.title || '';
      typeEl.textContent = p.service_type || p.category || '';
    }
  }

  /* ── Progress bar ────────────────── */
  function updateProgress() {
    if (!progressEl || projects.length === 0) return;
    const realIdx = current % projects.length;
    const pct = ((realIdx + 1) / projects.length) * 100;
    progressEl.style.width = pct + '%';
  }

  /* ── Autoplay ────────────────────── */
  function startAuto() {
    if (projects.length <= 1) return;
    autoTimer = setInterval(() => go(1), 5000);
  }
  function resetAuto() {
    clearInterval(autoTimer);
    startAuto();
  }

  /* ── Pause on hover ──────────────── */
  const section = document.getElementById('our-work');
  if (section) {
    section.addEventListener('mouseenter', () => clearInterval(autoTimer));
    section.addEventListener('mouseleave', () => startAuto());
  }

  function escAttr(s) {
    return (s || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  }
})();
