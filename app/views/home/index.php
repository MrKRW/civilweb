<?php
$title     = 'Civilanka — Architecture & Design Studio';
$meta      = 'Civilanka is a premier architecture and design studio in Sri Lanka, creating spaces that inspire.';
$pageClass = 'home-page';
$activeNav = 'home';
$extraJs   = [];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>


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
          <span class="new-section-label">&bull; &nbsp;ARCHITECTURE  • ENGINEERING   • BIM   • PROJECT CONSULTANCY </span>
          <h2 class="new-about-heading">Architecture, engineering and project solutions, designed<br> with purpose and precision</h2>
          <a href="<?= $BASE ?>/services" class="new-read-more">Explore our services</a>
        </div>
        <div class="about-slideshow reveal-right">
          <div class="about-slide active">
            <img src="<?= $BASE ?>/Project%20images/home/WhatsApp%20Image%202026-06-25%20at%2011.48.40.jpeg" alt="Architects working">
          </div>
          <div class="about-slide">
            <img src="<?= $BASE ?>/Project%20images/home/WhatsApp%20Image%202026-06-25%20at%2011.48.57.jpeg" alt="Slide 2">
          </div>
          <div class="about-slide">
            <img src="<?= $BASE ?>/Project%20images/home/ferfref.jpeg" alt="Slide 3">
          </div>
        </div>
      </div>
      <div class="new-about-bottom stagger">
        <div class="new-about-links">
          <a href="#">Design a perfect home</a>
          <a href="<?= $BASE ?>/Project%20images/home/COMPANY%20PROFILE%20-%20CIVILANKA.pdf" target="_blank" download>Download our company profile</a>
          <a href="<?= $BASE ?>/contact">Ask our technical team</a>
        </div>
        <div class="new-about-col">
          <h3>Architectural Design & Planning </h3>
          <p> Concept design, space planning, authority drawings, 3D visualization and construction documentation for residential, commercial and industrial projects. </p>
        </div>
        <div class="new-about-col">
          <h3> Engineering & BIM Solutions </h3>
          <p>Structural, civil, stormwater, MEP, BIM modelling, quantity take-off and technical documentation prepared for accurate coordination and practical construction. </p>
        </div>
      </div>
    </div>
  </section>

  <!-- OUR WORK SECTION -->
  <section id="our-work" class="ow-section" aria-label="Our Work">
    <div class="ow-left">
      <span class="ow-label">&#x2022; OUR WORK</span>
      <div class="ow-info-wrap">
        <h2 class="ow-project-name" id="ow-project-name">&nbsp;</h2>
        <p class="ow-project-type" id="ow-project-type">&nbsp;</p>
      </div>
      <div class="ow-nav">
        <button class="ow-arrow ow-prev" id="ow-prev" aria-label="Previous project">
          <svg width="38" height="12" viewBox="0 0 60 14" fill="none">
            <path d="M60 7H2M2 7L8 1M2 7L8 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <button class="ow-arrow ow-next" id="ow-next" aria-label="Next project">
          <svg width="38" height="12" viewBox="0 0 60 14" fill="none">
            <path d="M0 7H58M58 7L52 1M58 7L52 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>
    <div class="ow-slider-wrap" id="ow-slider-wrap">
      <div class="ow-track" id="ow-track">
        <!-- slides injected by JS -->
    </div>
  </section>

  <!-- SERVICES ACCORDION -->
  <section id="services" class="accordion-section reveal">
    <div class="acc-container">
      <div class="acc-item">
        <div class="acc-header"><span class="acc-icon">+</span><span class="acc-title">Design & Visualization</span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/Project%20images/1%20(4).png" alt="Urban Planning" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Professional architectural design, 3D modelling, visualization, landscape design and technical drawing documentation for residential, commercial, industrial and mixed-use projects. </p><a href="#" class="read-more">View engineering services</a></div>
        </div>
      </div>
      <div class="acc-item">
        <div class="acc-header"><span class="acc-icon">+</span><span class="acc-title">Engineering & Infrastructure </span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/Project%20images/home/WhatsApp%20Image%202026-06-25%20at%2011.57.20.jpeg" alt="Exterior" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Structural, civil, drainage, infrastructure and MEP design support prepared with practical engineering coordination for accurate construction and authority submission. </p><a href="#" class="read-more">View engineering services</a></div>
        </div>
      </div>
      <div class="acc-item">
        <div class="acc-header"><span class="acc-icon">+</span><span class="acc-title">Management & Costing </span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/Project%20images/2023-11-07.jpg" alt="Residential" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Cost estimation, quantity surveying, project coordination, feasibility studies, technical specifications and consultancy support for better project planning and control. </p><a href="#" class="read-more">View engineering services</a></div>
        </div>
      </div>
      <div class="acc-item active">
        <div class="acc-header"><span class="acc-icon">&minus;</span><span class="acc-title">Project Close-Out </span></div>
        <div class="acc-content">
          <div class="acc-img-wrap"><img src="<?= $BASE ?>/assets/images/hero_2.png" alt="Interior" /></div>
          <div class="acc-text-wrap"><span class="acc-close">&minus;</span><p>Project completion support including final documentation, handover preparation, maintenance planning and aftercare assistance for a controlled project close-out process.  </p><a href="#" class="read-more">View engineering services</a></div>
        </div>
      </div>
    </div>
  </section>

  <!-- QUOTE BANNER -->
  <section id="quote-banner">
    <div class="quote-banner-content container">
      <h2>From concept to construction, we deliver coordinated architecture, engineering, BIM, costing and project support for practical, buildable developments</h2>
    </div>
  </section>

  <!-- TEAM SECTION -->
  <section id="team" aria-label="Our Team">
    <div class="team-grid">
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/29.png" alt="Architect portrait" /></div>
      <div class="team-cell team-info"><h3 class="team-name">Harsha</h3><p class="team-role"><span class="team-role-accent">Draughtsman &amp; 3D Visualizer </span></p></div>
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/33.png" alt="Main Contractor portrait" /></div>
      <div class="team-cell team-info"><h3 class="team-name">Dhiyan</h3><p class="team-role"><span class="team-role-accent">Senior Structural Engineer </span></p></div>
      <div class="team-cell team-jobs"><a href="#" class="team-jobs-link">careers and internships</a></div>
      <div class="team-cell team-empty"></div>
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/32.png" alt="Architect portrait" /></div>
      <div class="team-cell team-info"><h3 class="team-name">Teshan </h3><p class="team-role"><span class="team-role-plain">Structural Engineer </span></p></div>
      <div class="team-cell team-photo"><img src="<?= $BASE ?>/team%20images/30.png" alt="Product Designer portrait" /></div>
      <div class="team-cell team-info team-info-last"><h3 class="team-name">Janith</h3><p class="team-role"><span class="team-role-plain">Facility Engineer</span></p></div>
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
              <p class="testimonial-text">They did an amazing job on my civil and structural design project! His creativity and attention to detail truly impressed me. He was friendly, communicative, and delivered everything ahead of schedule. I can't wait to work with him again!</p>
              <p class="testimonial-author">ANTONE AUSTIN</p>
              <p class="testimonial-role">GDI</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Produced very good, high quality Structural Engineering documentation &amp; drawings. I've got more upcoming work and will be engaging Civilanka Team for this.</p>
              <p class="testimonial-author">GREG NICHOLS</p>
              <p class="testimonial-role">Apex BTI</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Civilanka is really great professional, not focused only on his field of engineering, but he also knows very well consequences and circumstances of his job to the rest of project. Definitely I want work with him again.</p>
              <p class="testimonial-author">PETR SYKORA</p>
              <p class="testimonial-role">Mazanec Fenix</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Hi. One of the best Engineering Team i have ever worked with. Their skills in his field is really awesome. I'll definitely work with again on any civil project.</p>
              <p class="testimonial-author">ANDREW</p>
              <p class="testimonial-role">Epic</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Thank you for the outstanding structural design project. The rigorous load assessments, validated stress modeling, and meticulous technical documentation have resulted in a structurally robust and constructible final product. Highly recommended</p>
              <p class="testimonial-author">MATT BEHMER</p>
              <p class="testimonial-role">Behmer Group</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Civilanka Team is very responsible, professional, and easy to work with. I am already planning on using him for my next project!</p>
              <p class="testimonial-author">BRIAN SCHOELKOPF</p>
              <p class="testimonial-role">BCS Sports LLC</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">It is nice to work with Civilanka. They are accommodating and responsive.</p>
              <p class="testimonial-author">KENNY C</p>
              <p class="testimonial-role">Swan Li</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">A very professional and high standard work done in analysis seismic and harmonic force analysis of a RCC bridge in Autodesk Robot software. Highly recommended. Also helped with stamping the drawings and documents.</p>
              <p class="testimonial-author">WEBB WEHBE</p>
              <p class="testimonial-role">Metro Trucks</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Civilanka was great. Great work, great communication, on schedule. Worked great with my architecture team</p>
              <p class="testimonial-author">RAY B</p>
              <p class="testimonial-role">Westport Structures</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">They consistently delivers top-quality work, demonstrating exceptional responsiveness and a keen attention to detail when reviewing my reports. Their unparalleled efficiency and accuracy makes them an invaluable asset.</p>
              <p class="testimonial-author">SOREN GEMS</p>
              <p class="testimonial-role">Gems &amp; Partners</p>
            </div>
            <div class="swiper-slide">
              <p class="testimonial-text">Amazing, they were the only contractor to call and seek clarification on the work scope, they has worked methodically thought the entire project providing all aspects on plans required, and is happy to make alterations very quickly, we highly recommend him for future projects</p>
              <p class="testimonial-author">SHAUN SURSOK</p>
              <p class="testimonial-role">Surewest Group</p>
            </div>
          </div>
          <div class="test-nav-wrapper">
            <div class="swiper-pagination test-pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- BLOG / JOURNAL -->
  <section id="ref-journal">
    <div class="container">
      <div class="ref-journal-grid reveal">
        <?php $recentBlogs = $recentBlogs ?? []; ?>
        <?php if (!empty($recentBlogs)): ?>
          <?php foreach ($recentBlogs as $blog): ?>
            <?php
              $bImg = !empty($blog['image'])
                ? $BASE . '/uploads/blog/' . htmlspecialchars($blog['image'])
                : $BASE . '/Project images/2023-11-07.jpg';
              $bCat = !empty($blog['category']) ? strtoupper(htmlspecialchars($blog['category'])) : 'INTERVIEWS';
              $bDate = !empty($blog['created_at']) ? strtoupper(date('F j, Y', strtotime($blog['created_at']))) : 'DECEMBER 14, 2022';
              $bTitle = htmlspecialchars($blog['title']);
            ?>
            <article class="ref-journal-card">
              <div class="ref-journal-img-wrap"><img src="<?= $bImg ?>" alt="<?= htmlspecialchars($blog['title']) ?>"></div>
              <h3 class="ref-journal-title"><?= $bTitle ?></h3>
              <div class="ref-journal-meta"><span><?= $bCat ?></span><span class="ref-journal-meta-sep">|</span><span><?= $bDate ?></span></div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
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
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section id="cta-banner">
    <div class="container">
      <div class="cta-inner reveal">
        <h2>Let's Build Something<br />Remarkable Together.</h2>
        <p>Whether a private home or a city block — bring us your vision. We'll shape it into something that lasts.</p>
        <a href="<?= $BASE ?>/contact" class="btn btn-dark btn-arrow"><span>Contact us now</span></a>
      </div>
    </div>
  </section>

