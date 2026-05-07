/* ============================================================
   ABOUT PAGE — Interactive JS
============================================================ */

document.addEventListener('DOMContentLoaded', () => {

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
  const quoteText = document.querySelector('.hs-quote-text');
  const quoteAuthor = document.querySelector('.hs-quote-author');
  const dots = document.querySelectorAll('.hs-dot');

  function setQuote(index) {
    if (!quoteText || !quoteAuthor) return;
    
    quoteText.style.opacity = '0';
    quoteText.style.transform = 'translateY(10px)';
    quoteAuthor.style.opacity = '0';
    quoteAuthor.style.transform = 'translateY(10px)';

    setTimeout(() => {
      quoteText.textContent = quotes[index].text;
      quoteAuthor.textContent = quotes[index].author;
      
      quoteText.style.opacity = '1';
      quoteText.style.transform = 'translateY(0)';
      quoteAuthor.style.opacity = '1';
      quoteAuthor.style.transform = 'translateY(0)';
    }, 400); // Slightly longer delay to match the 0.5s transition

    dots.forEach((d, i) => d.classList.toggle('active', i === index));
    currentQuote = index;
  }

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      setQuote(i);
      resetQuoteInterval();
    });
  });

  // Auto-cycle quotes every 6 seconds (longer than gallery)
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
  const slider = document.getElementById('hs-gallery-slider');
  const galPrev = document.getElementById('hs-gal-prev');
  const galNext = document.getElementById('hs-gal-next');
  const currentCounter = document.getElementById('hs-gal-current');
  const totalCounter = document.getElementById('hs-gal-total');

  if (slider && slider.children.length > 0 && galPrev && galNext) {
    let isAnimating = false;
    const itemWidth = 416; // 400px inactive item width + 16px gap
    
    // Assign original indices for the counter
    Array.from(slider.children).forEach((item, index) => {
      item.dataset.index = index;
    });

    if (totalCounter) {
      totalCounter.textContent = slider.children.length;
    }

    function updateCounter(activeItem) {
      if (currentCounter && activeItem) {
        currentCounter.textContent = parseInt(activeItem.dataset.index) + 1;
      }
    }

    galNext.addEventListener('click', () => {
      if (isAnimating) return;
      isAnimating = true;
      resetAutoplay(); // Reset timer on manual click

      const firstItem = slider.children[0];
      const secondItem = slider.children[1];

      firstItem.classList.remove('active');
      secondItem.classList.add('active');
      updateCounter(secondItem);

      slider.style.transition = 'transform 2s cubic-bezier(0.25, 1, 0.5, 1)';
      slider.style.transform = `translateX(-${itemWidth}px)`;

      slider.addEventListener('transitionend', function onNextEnd(e) {
        if (e.target !== slider) return;
        slider.removeEventListener('transitionend', onNextEnd);
        
        // Move the first item to the end
        slider.appendChild(firstItem);
        
        // Reset transform without animation
        slider.style.transition = 'none';
        slider.style.transform = 'translateX(0)';
        
        // Force reflow
        void slider.offsetWidth;
        
        isAnimating = false;
      });
    });

    galPrev.addEventListener('click', () => {
      if (isAnimating) return;
      isAnimating = true;
      resetAutoplay(); // Reset timer on manual click

      const firstItem = slider.children[0];
      const lastItem = slider.children[slider.children.length - 1];

      firstItem.classList.remove('active');
      lastItem.classList.add('active');
      updateCounter(lastItem);

      // Move last item to the front before animating
      slider.style.transition = 'none';
      slider.prepend(lastItem);
      slider.style.transform = `translateX(-${itemWidth}px)`;

      // Force reflow
      void slider.offsetWidth;

      // Animate to 0
      slider.style.transition = 'transform 2s cubic-bezier(0.25, 1, 0.5, 1)';
      slider.style.transform = 'translateX(0)';

      slider.addEventListener('transitionend', function onPrevEnd(e) {
        if (e.target !== slider) return;
        slider.removeEventListener('transitionend', onPrevEnd);
        isAnimating = false;
      });
    });

    // Initialize
    slider.children[0].classList.add('active');
    updateCounter(slider.children[0]);

    // Auto-play functionality
    let autoplayInterval = setInterval(() => {
      galNext.click();
    }, 5000); // Increased to 5s for better pacing

    function resetAutoplay() {
      clearInterval(autoplayInterval);
      autoplayInterval = setInterval(() => {
        galNext.click();
      }, 5000);
    }

    // Pause on hover
    const galleryWrapper = document.querySelector('.hs-gallery-wrapper');
    if (galleryWrapper) {
      galleryWrapper.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
      galleryWrapper.addEventListener('mouseleave', () => {
        autoplayInterval = setInterval(() => {
          galNext.click();
        }, 4000);
      });
    }
  }



});
