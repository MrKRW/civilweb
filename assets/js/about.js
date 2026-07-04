/* ============================================================
   ABOUT PAGE — Interactive JS
============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* -------------------------------------------------------
     STICKY HEADER logic removed to standardize navigation.
     The sticky header is now always visible.
  ------------------------------------------------------- */

  /* -------------------------------------------------------
     SCROLL REVEAL (reuse classes from main style.css)
  ------------------------------------------------------- */
  const revealEls = document.querySelectorAll(
    '.reveal, .reveal-left, .reveal-right, .stagger'
  );

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });

  revealEls.forEach(el => revealObserver.observe(el));

  /* -------------------------------------------------------
     QUOTE DOT NAVIGATION
  ------------------------------------------------------- */
  const quotes = [
    {
      text: "Our studio is built on the principle that great architecture emerges from collaboration, diverse perspectives, and a shared commitment to excellence. We bring together architects and craftspeople.",
      author: "JACOB, OWNER"
    },
    {
      text: "Architecture is not just about buildings — it is about the experience of space, light, and material. Every project is an opportunity to create something that endures.",
      author: "MARIA, CO-FOUNDER"
    },
    {
      text: "We believe the best design solutions come from listening deeply to our clients and understanding the way they want to live and work in the spaces we create.",
      author: "ROBERT, SENIOR ARCHITECT"
    }
  ];

  let currentQuote = 0;
  const quoteText   = document.querySelector('.hs-quote-text');
  const quoteAuthor = document.querySelector('.hs-quote-author');
  const dots        = document.querySelectorAll('.hs-dot');

  function setQuote(index) {
    if (!quoteText || !quoteAuthor) return;

    quoteText.style.opacity   = '0';
    quoteText.style.transform = 'translateY(10px)';
    quoteAuthor.style.opacity   = '0';
    quoteAuthor.style.transform = 'translateY(10px)';

    setTimeout(() => {
      quoteText.textContent   = quotes[index].text;
      quoteAuthor.textContent = quotes[index].author;

      quoteText.style.opacity   = '1';
      quoteText.style.transform = 'translateY(0)';
      quoteAuthor.style.opacity   = '1';
      quoteAuthor.style.transform = 'translateY(0)';
    }, 400);

    dots.forEach((d, i) => d.classList.toggle('active', i === index));
    currentQuote = index;
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      setQuote(i);
      resetQuoteInterval();
    });
  });

  let quoteInterval = setInterval(() => {
    const next = (currentQuote + 1) % quotes.length;
    setQuote(next);
  }, 6000);

  function resetQuoteInterval() {
    clearInterval(quoteInterval);
    quoteInterval = setInterval(() => {
      const next = (currentQuote + 1) % quotes.length;
      setQuote(next);
    }, 6000);
  }

  /* -------------------------------------------------------
     INFINITE CIRCULAR SLIDER GALLERY
  ------------------------------------------------------- */
  const slider       = document.getElementById('hs-gallery-slider');
  const galPrev      = document.getElementById('hs-gal-prev');
  const galNext      = document.getElementById('hs-gal-next');
  const currentCounter = document.getElementById('hs-gal-current');
  const totalCounter   = document.getElementById('hs-gal-total');

  if (slider && slider.children.length > 0 && galPrev && galNext) {
    let isAnimating = false;

    Array.from(slider.children).forEach((item, index) => {
      item.dataset.index = index;
    });

    if (totalCounter) totalCounter.textContent = slider.children.length;

    function updateCounter(activeItem) {
      if (currentCounter && activeItem) {
        currentCounter.textContent = parseInt(activeItem.dataset.index) + 1;
      }
    }

    galNext.addEventListener('click', () => {
      if (isAnimating) return;
      isAnimating = true;
      resetAutoplay();

      const firstItem  = slider.children[0];
      const secondItem = slider.children[1];
      const itemWidth  = secondItem.offsetWidth +
        (parseFloat(window.getComputedStyle(slider).gap) || 0);

      firstItem.classList.remove('active');
      secondItem.classList.add('active');
      updateCounter(secondItem);

      slider.style.transition = 'transform 2s cubic-bezier(0.25, 1, 0.5, 1)';
      slider.style.transform  = `translateX(-${itemWidth}px)`;

      slider.addEventListener('transitionend', function onNextEnd(e) {
        if (e.target !== slider) return;
        slider.removeEventListener('transitionend', onNextEnd);
        slider.appendChild(firstItem);
        slider.style.transition = 'none';
        slider.style.transform  = 'translateX(0)';
        void slider.offsetWidth;
        isAnimating = false;
      });
    });

    galPrev.addEventListener('click', () => {
      if (isAnimating) return;
      isAnimating = true;
      resetAutoplay();

      const firstItem = slider.children[0];
      const lastItem  = slider.children[slider.children.length - 1];
      const itemWidth = lastItem.offsetWidth +
        (parseFloat(window.getComputedStyle(slider).gap) || 0);

      firstItem.classList.remove('active');
      lastItem.classList.add('active');
      updateCounter(lastItem);

      slider.style.transition = 'none';
      slider.prepend(lastItem);
      slider.style.transform  = `translateX(-${itemWidth}px)`;
      void slider.offsetWidth;

      slider.style.transition = 'transform 2s cubic-bezier(0.25, 1, 0.5, 1)';
      slider.style.transform  = 'translateX(0)';

      slider.addEventListener('transitionend', function onPrevEnd(e) {
        if (e.target !== slider) return;
        slider.removeEventListener('transitionend', onPrevEnd);
        isAnimating = false;
      });
    });

    slider.children[0].classList.add('active');
    updateCounter(slider.children[0]);

    let autoplayInterval = setInterval(() => { galNext.click(); }, 3000);

    function resetAutoplay() {
      clearInterval(autoplayInterval);
      autoplayInterval = setInterval(() => { galNext.click(); }, 3000);
    }

    const galleryWrapper = document.querySelector('.hs-gallery-wrapper');
    if (galleryWrapper) {
      galleryWrapper.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
      galleryWrapper.addEventListener('mouseleave', () => {
        autoplayInterval = setInterval(() => { galNext.click(); }, 3000);
      });
    }
  }

  /* -------------------------------------------------------
     LOGO STRIP — pixel-accurate seamless loop
     -------------------------------------------------------
     Problem: CSS translateX(-50%) only works when both logo
     sets are exactly the same pixel width. On mobile, image
     loading timing can make them unequal → jump at loop end.

     Fix: After all images load, measure the FIRST set's exact
     offsetWidth and inject a @keyframes rule that translates
     by exactly that many pixels. This guarantees a perfect loop
     regardless of image sizes or screen width.

     Drag (mouse) + Swipe (touch) support included.
  ------------------------------------------------------- */
  (function initLogoScroll() {
    const track    = document.querySelector('.hs-logo-track');
    const firstSet = document.querySelector('.hs-logos');  // first duplicate
    if (!track || !firstSet) return;

    let isDragging = false;
    let startX     = 0;
    let pausedAt   = 0;
    let dragDelta  = 0;
    let loopPx     = 0;   // exact pixel width of one logo set

    /* ---- inject pixel-precise keyframes ---- */
    function applyPixelAnimation() {
      loopPx = firstSet.offsetWidth;
      if (loopPx <= 0) return;

      // Remove any old injected style
      const old = document.getElementById('logo-scroll-kf');
      if (old) old.remove();

      const dur = parseFloat(getComputedStyle(track).animationDuration) || 30;

      const style = document.createElement('style');
      style.id = 'logo-scroll-kf';
      style.textContent = `
        @keyframes scroll-logos-px {
          0%   { transform: translateX(0px); }
          100% { transform: translateX(-${loopPx}px); }
        }
        .hs-logo-track {
          animation-name: scroll-logos-px !important;
          animation-duration: ${dur}s !important;
        }
      `;
      document.head.appendChild(style);
    }

    /* Run after images have loaded so sizes are final */
    const imgs = track.querySelectorAll('img');
    let loaded = 0;
    function onImgLoad() {
      loaded++;
      if (loaded >= imgs.length) applyPixelAnimation();
    }
    if (imgs.length === 0) {
      applyPixelAnimation();
    } else {
      imgs.forEach(img => {
        if (img.complete) { onImgLoad(); }
        else {
          img.addEventListener('load',  onImgLoad, { once: true });
          img.addEventListener('error', onImgLoad, { once: true });
        }
      });
    }

    /* ---- helpers ---- */
    function liveX() {
      const mat = new DOMMatrix(window.getComputedStyle(track).transform);
      return mat.m41;
    }

    function wrapX(x) {
      if (loopPx <= 0) return x;
      x = x % -loopPx;
      if (x > 0)  x -= loopPx;
      if (x < -loopPx) x += loopPx;
      return x;
    }

    function freeze() {
      pausedAt = liveX();
      track.style.animationPlayState = 'paused';
      track.style.transform = `translateX(${pausedAt}px)`;
    }

    function resume(fromX) {
      const dur  = parseFloat(getComputedStyle(track).animationDuration) || 30;
      const frac = loopPx > 0 ? Math.abs(fromX) / loopPx : 0;
      track.style.transform          = '';
      track.style.animationDelay     = `${-(frac * dur)}s`;
      track.style.animationPlayState = 'running';
    }

    /* ---- drag / touch handlers ---- */
    function onDown(e) {
      if (e.type === 'mousedown' && e.button !== 0) return;
      isDragging = true;
      dragDelta  = 0;
      startX     = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
      freeze();
      track.style.cursor = 'grabbing';
      e.preventDefault();
    }

    function onMove(e) {
      if (!isDragging) return;
      const x   = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
      dragDelta  = x - startX;
      track.style.transform = `translateX(${wrapX(pausedAt + dragDelta)}px)`;
      e.preventDefault();
    }

    function onUp() {
      if (!isDragging) return;
      isDragging = false;
      track.style.cursor = 'grab';
      resume(wrapX(pausedAt + dragDelta));
    }

    track.addEventListener('mousedown',  onDown, { passive: false });
    window.addEventListener('mousemove', onMove, { passive: false });
    window.addEventListener('mouseup',   onUp);

    track.addEventListener('touchstart', onDown, { passive: false });
    window.addEventListener('touchmove', onMove, { passive: false });
    window.addEventListener('touchend',  onUp);

    track.style.cursor       = 'grab';
    track.style.userSelect   = 'none';
    track.style.webkitUserSelect = 'none';

  })();

});
