<?php
$title     = 'Civilanka — Architecture & Design Studio';
$meta      = 'Civilanka is a premier architecture and design studio in Sri Lanka, creating spaces that inspire.';
$pageClass = 'home-page';
$activeNav = 'home';
$extraJs   = ['main.js'];
$BASE      = '';
?>

  <!-- HERO TOP BAR -->
  <div id="top-bar">
    <a href="<?= $BASE ?>/" class="hero-topleft-brand" aria-label="Civilanka Home">
      <img src="<?= $BASE ?>/Logos/TRANSPARENT CIVILANKA.png" alt="Civilanka" class="hero-topleft-logo-img" />
    </a>
  </div>

  <!-- HERO SECTION -->
  <section id="hero" class="split-view" aria-label="Featured Projects Split View">
    <div class="split-half split-left">
      <img src="<?= $BASE ?>/Project%20images/1%20(4).png" class="split-bg" alt="International architecture" />
      <div class="split-overlay dark"></div>
      <a href="<?= $BASE ?>/projects?filter=local" class="vert-text vert-left">local</a>
    </div>
    <div class="split-half split-right">
      <img src="<?= $BASE ?>/Project%20images/A%20(10).png" class="split-bg" alt="Local architecture" />
      <div class="split-overlay dark"></div>
      <a href="<?= $BASE ?>/projects?filter=international" class="vert-text vert-right">international</a>
    </div>
    <div class="center-brand">
      <img src="<?= $BASE ?>/Logos/transparent-logo-only.png" alt="Civilanka Architects" class="center-logo-img" />
    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="about" class="section-pad">
    <div class="container">
      <div class="new-about-top">
        <div class="new-about-text reveal-left">
          <span class="new-section-label">&bull; &nbsp;ARCHITECT STUDIO</span>
          <h2 class="new-about-heading">Architects excited about beauty,<br>affordability sustainability
            materials<br>for every project and person</h2>
          <a href="<?= $BASE ?>/about" class="new-read-more">read more</a>
        </div>
        <div class="about-slideshow reveal-right">
          <div class="about-slide active">
            <img src="<?= $BASE ?>/assets/images/about_team.png" alt="Architects working">
          </div>
          <div class="about-slide">
            <img src="<?= $BASE ?>/Project images/A (10).png" alt="Slide 2">
          </div>
          <div class="about-slide">
            <img src="<?= $BASE ?>/Project images/1 (4).png" alt="Slide 3">
          </div>
        </div>
      </div>
      <div class="new-about-bottom stagger">
        <div class="new-about-links">
          <a href="#">Design a perfect home</a>
          <a href="#">Download our brochure</a>
          <a href="#">Ask us your questions our architects</a>
        </div>
        <div class="new-about-col">
          <h3>Urban Exteriors</h3>
          <p>Purus sit amet vol utpat con sequat mauris nunc congue. Sed id s emper risus in hend rrerit. Facilisi etiam dig nissim diam quis enim. Quis auctor.</p>
        </div>
        <div class="new-about-col">
          <h3>Cityscapes Buildings</h3>
          <p>Purus sit amet vol utpat con sequat mauris nunc congue. Sed id s emper risus in hend rrerit. Facilisi etiam dig nissim diam quis enim. Quis auctor.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PROJECTS / OUR WORK SECTION -->
  <section id="projects" class="section-pad dark-section">
    <div class="our-work-container">
      <div class="our-work-left reveal-left">
        <span class="our-work-label">&bull; &nbsp;OUR WORK</span>
        <div class="our-work-info">
          <h2 class="our-work-title">The feel of Villa Yun</h2>
          <span class="our-work-cat">WELLNESS</span>
        </div>
      </div>
      <div class="our-work-right reveal-right">
        <div class="swiper our-work-swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide our-work-slide" data-title="The feel of Villa Yun" data-cat="WELLNESS">
              <img src="<?= $BASE ?>/Project%20images/2023-11-07.jpg" alt="Villa Yun" />
            </div>
            <div class="swiper-slide our-work-slide" data-title="Contemporary Interior" data-cat="INTERIOR">
              <img src="<?= $BASE ?>/Project%20images/A%20(10).png" alt="Contemporary Interior" />
            </div>
            <div class="swiper-slide our-work-slide" data-title="Modern Structure" data-cat="ARCHITECTURE">
              <img src="<?= $BASE ?>/Project%20images/1%20(4).png" alt="Modern Structure" />
            </div>
            <div class="swiper-slide our-work-slide" data-title="Industrial Facility" data-cat="COMMERCIAL">
              <img src="<?= $BASE ?>/Project%20images/WIN_Facility6.jpg" alt="Industrial Facility" />
            </div>
          </div>
        </div>
        <div class="our-work-nav">
          <button class="our-work-prev">
            <svg width="40" height="10" viewBox="0 0 60 14" fill="none"><path d="M60 7H2M2 7L8 1M2 7L8 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <button class="our-work-next">
            <svg width="40" height="10" viewBox="0 0 60 14" fill="none"><path d="M0 7H58M58 7L52 1M58 7L52 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES ACCORDION -->
  <section id="services" class="accordion-section reveal">
    <div class="acc-container">
      <div class="acc-item">
        <div class="acc-header"><span class="acc-icon">+</span><span class="acc-title">Urban Planning</span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/Project%20images/2023-11-07.jpg" alt="Urban Planning" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a href="#" class="read-more">read more</a></div>
        </div>
      </div>
      <div class="acc-item">
        <div class="acc-header"><span class="acc-icon">+</span><span class="acc-title">Exterior</span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/Project%20images/1%20(4).png" alt="Exterior" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a href="#" class="read-more">read more</a></div>
        </div>
      </div>
      <div class="acc-item">
        <div class="acc-header"><span class="acc-icon">+</span><span class="acc-title">Residential</span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/assets/images/hero_2.png" alt="Residential" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a href="#" class="read-more">read more</a></div>
        </div>
      </div>
      <div class="acc-item active">
        <div class="acc-header"><span class="acc-icon">&minus;</span><span class="acc-title">Interior</span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/Project%20images/A%20(10).png" alt="Interior" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a href="#" class="read-more">read more</a></div>
        </div>
      </div>
    </div>
  </section>

  <!-- QUOTE BANNER -->
  <section id="quote-banner">
    <div class="quote-banner-content container">
      <h2>The whimsical feel of Villa Esther begins with the Neo-Modern gateway in the style of Le Corbusier's Villa Savoye.</h2>
    </div>
  </section>

  <!-- TEAM SECTION -->
  <section id="team" aria-label="Our Team">
    <div class="team-grid">
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/29.png" alt="Architect portrait" /></div>
      <div class="team-cell team-info"><h3 class="team-name">Lorem ipsum</h3><p class="team-role"><span class="team-role-accent">CEO</span> / <span class="team-role-plain">ARCHITECT</span></p></div>
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/30.png" alt="Main Contractor portrait" /></div>
      <div class="team-cell team-info"><h3 class="team-name">Lorem ipsum</h3><p class="team-role"><span class="team-role-accent">MAIN CONTRACTOR</span></p></div>
      <div class="team-cell team-jobs" rowspan="2"><a href="#" class="team-jobs-link">jobs and internships</a></div>
      <div class="team-cell team-empty"></div>
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/32.png" alt="Architect portrait" /></div>
      <div class="team-cell team-info"><h3 class="team-name">Lorem ipsum</h3><p class="team-role"><span class="team-role-plain">Lorem ipsum</span></p></div>
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/33.png" alt="Product Designer portrait" /></div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section id="testimonials" class="section-pad">
    <div class="container">
      <div class="testimonials-inner reveal">
        <span class="section-label">Client Words</span>
        <div class="swiper test-swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <p class="testimonial-text">Civilanka transformed our vision into a home that surpasses everything we imagined. Their attention to light, material, and proportion is extraordinary.</p>
              <p class="testimonial-author">JAMES &amp; CLARA WHITFIELD</p>
              <p class="testimonial-role">Private Residence Client, London</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Working with the Civilanka team was a revelation. They listened deeply and delivered a commercial space that perfectly reflects our brand values.</p>
              <p class="testimonial-author">SEBASTIAN NAKAMURA</p>
              <p class="testimonial-role">CEO, Nakamura Group</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">The master plan Civilanka created for our mixed-use development is visionary. Their urban sensibility and design quality are unmatched in the industry.</p>
              <p class="testimonial-author">AMARA OSEI-BONSU</p>
              <p class="testimonial-role">Director of Development, Cityline Properties</p>
            </div>
          </div>
          <div class="swiper-pagination test-pagination"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- BLOG / JOURNAL -->
  <section id="ref-journal">
    <div class="container">
      <div class="ref-journal-grid reveal">
        <article class="ref-journal-card">
          <div class="ref-journal-img-wrap"><img src="<?= $BASE ?>/Project images/2023-11-07.jpg" alt="Interior Design"></div>
          <h3 class="ref-journal-title">Studio Hiroshi Cuisine And Bar Innovative Interior Design</h3>
          <div class="ref-journal-meta"><span>INTERVIEWS</span><span class="ref-journal-meta-sep">|</span><span>DECEMBER 14, 2022</span></div>
        </article>
        <article class="ref-journal-card">
          <div class="ref-journal-img-wrap"><img src="<?= $BASE ?>/team images/29.png" alt="Zara Madid"></div>
          <h3 class="ref-journal-title">Zara Madid Speaking About Her Influence And Creative Vision</h3>
          <div class="ref-journal-meta"><span>INTERVIEWS</span><span class="ref-journal-meta-sep">|</span><span>DECEMBER 14, 2022</span></div>
        </article>
        <article class="ref-journal-card">
          <div class="ref-journal-img-wrap"><img src="<?= $BASE ?>/Project images/1 (4).png" alt="Glass Wall Facade"></div>
          <h3 class="ref-journal-title">Glass Wall Facade And How To Design It With AluProfiles</h3>
          <div class="ref-journal-meta"><span>INTERVIEWS</span><span class="ref-journal-meta-sep">|</span><span>DECEMBER 14, 2022</span></div>
        </article>
        <article class="ref-journal-card">
          <div class="ref-journal-img-wrap"><img src="<?= $BASE ?>/Project images/A (10).png" alt="Landscape Architecture"></div>
          <h3 class="ref-journal-title">Coexisting With The Landscape Is The Main Rule</h3>
          <div class="ref-journal-meta"><span>INTERVIEWS</span><span class="ref-journal-meta-sep">|</span><span>DECEMBER 14, 2022</span></div>
        </article>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section id="cta-banner">
    <div class="container">
      <div class="cta-inner reveal">
        <h2>Let's Build Something<br />Remarkable Together.</h2>
        <p>Whether a private home or a city block — bring us your vision. We'll shape it into something that lasts.</p>
        <a href="#footer" class="btn btn-dark btn-arrow"><span>Contact us now</span></a>
      </div>
    </div>
  </section>

  <script>
    (async function loadFeaturedProjects() {
      try {
        const res = await fetch('/api/projects?action=featured');
        const data = await res.json();
        const projects = data.projects;
        if (!projects || projects.length === 0) return;
        const wrapper = document.querySelector('.our-work-swiper .swiper-wrapper');
        if (!wrapper) return;
        wrapper.innerHTML = '';
        projects.forEach(p => {
          const imgSrc = p.image_main ? '/uploads/projects/' + p.image_main : '/Project%20images/2023-11-07.jpg';
          const slide = document.createElement('div');
          slide.className = 'swiper-slide our-work-slide';
          slide.setAttribute('data-title', p.title);
          slide.setAttribute('data-cat', p.service_type || '');
          slide.innerHTML = `<img src="${imgSrc}" alt="${p.title}" />`;
          wrapper.appendChild(slide);
        });
        if (projects.length > 0) {
          const titleEl = document.querySelector('.our-work-title');
          const catEl = document.querySelector('.our-work-cat');
          if (titleEl) titleEl.textContent = projects[0].title;
          if (catEl) catEl.textContent = projects[0].service_type || '';
        }
        const swiperEl = document.querySelector('.our-work-swiper');
        if (swiperEl && swiperEl.swiper) swiperEl.swiper.update();
      } catch (e) { /* keep static slides */ }
    })();
  </script>
