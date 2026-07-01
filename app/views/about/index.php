<?php
$title     = 'Our Studio — Civilanka Architecture & Design';
$meta      = "Learn about Civilanka's philosophy, founding architects, and our approach to timeless design.";
$pageClass = 'about-page';
$activeNav = 'about';
$extraCss  = ['about.css'];
$extraJs   = ['about.js'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>

  <!-- HERO -->
  <section id="about-hero" class="hs-hero">
    <div class="hs-hero-bg"></div>

    <!-- Transparent overlay navbar (visible before sticky header appears) -->
    <header class="hs-hero-header" id="about-hero-nav">
      <a href="<?= $BASE ?>" class="hs-hero-logo">
        <img src="<?= $BASE ?>/Logos/trans.PNG" alt="Civilanka" style="height:52px;width:auto;filter:brightness(0) invert(1);" />
      </a>
      <nav class="hs-hero-nav">
        <ul>
          <li<?= $activeNav === 'home'     ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/">home</a></li>
          <li<?= $activeNav === 'about'    ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/about">about</a></li>
          <li<?= $activeNav === 'services' ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/services">services</a></li>
          <li<?= $activeNav === 'projects' ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/projects">projects</a></li>
          <li<?= $activeNav === 'blog'     ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/blog">blog</a></li>
          <li<?= $activeNav === 'shop'     ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/shop">shop</a></li>
          <li<?= $activeNav === 'contact'  ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/contact">contact</a></li>
        </ul>
      </nav>
    </header>

    <div class="hs-hero-content"><h1 class="hs-hero-title">Our Studio</h1></div>
    <div class="hs-hero-footer">
      <div class="hs-hero-tag"><span class="dot"></span> A SENSE OF SERENITY</div>
    </div>
  </section>

  <script>
    // Fade out the about hero navbar as user scrolls toward the sticky header reveal point
    (function() {
      var heroNav = document.getElementById('about-hero-nav');
      if (!heroNav) return;
      var THRESHOLD = 80; // must match main.js REVEAL_THRESHOLD
      function updateHeroNav() {
        var s = window.scrollY;
        var opacity = Math.max(0, 1 - (s / THRESHOLD));
        heroNav.style.opacity = opacity;
        heroNav.style.pointerEvents = opacity < 0.1 ? 'none' : 'all';
      }
      updateHeroNav();
      window.addEventListener('scroll', updateHeroNav, { passive: true });
    })();
  </script>

  <!-- INTRO -->
  <section class="hs-intro">
    <div class="hs-intro-inner">
      <div class="hs-intro-left reveal-left">
        <h2 class="hs-intro-heading">Multidisciplinary architecture<br class="hs-desktop-br">engineering and project consultancy for practical,<br class="hs-desktop-br"> buildable developments </h2>
      </div>
      <div class="hs-intro-right reveal-right">
        <div class="hs-intro-img-wrap">
          <img src="<?= $BASE ?>/Project%20images/WhatsApp%20Image%202023-07-17%20at%2021.07.37%20(1).jpeg" alt="Architects collaborating in studio" />
        </div>
      </div>
    </div>
  </section>

  <!-- APPROACH COLUMNS -->
  <section class="hs-approach">
    <div class="hs-approach-inner">
      <div class="hs-approach-col">
        <div class="hs-approach-links">
          <a href="#" class="hs-approach-link">Design your perfect home</a>
          <a href="#" class="hs-approach-link">Download our brochure</a>
          <a href="#" class="hs-approach-link">Ask our architect any question</a>
        </div>
      </div>
      <div class="hs-approach-col">
        <h3 class="hs-approach-title">Who We Are </h3>
        <p>CiviLanka is a multidisciplinary consultancy providing architecture, structural engineering, civil, MEP, BIM, quantity surveying, visualization and project support services for residential, commercial, industrial and infrastructure developments. </p>
        <a href="#" class="hs-read-more">learn more</a>
      </div>
      <div class="hs-approach-col">
        <h3 class="hs-approach-title">How We Work </h3>
        <p>We combine design thinking, engineering accuracy and construction practicality to produce coordinated drawings, models, reports and documentation that support clear decisions and efficient project delivery. </p>
        <a href="#" class="hs-read-more">Our process</a>
      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="hs-gallery">
    <div class="hs-gallery-wrapper">
      <div class="hs-gallery-slider" id="hs-gallery-slider">
        <div class="hs-gallery-item active"><img src="<?= $BASE ?>/Project%20images/1%20(4).png" alt="Studio interior" /></div>
        <div class="hs-gallery-item"><img src="<?= $BASE ?>/Project%20images/WhatsApp%20Image%202023-07-17%20at%2021.07.37%20(1).jpeg" alt="Team at work" /></div>
        <div class="hs-gallery-item"><img src="<?= $BASE ?>/Project%20images/A%20(10).png" alt="Technical drawings" /></div>
        <div class="hs-gallery-item"><img src="<?= $BASE ?>/Project%20images/2023-11-07.jpg" alt="Architects collaborating" /></div>
        <div class="hs-gallery-item"><img src="<?= $BASE ?>/Project%20images/hero_exterior.png" alt="Hero exterior" /></div>
      </div>
    </div>
    <div class="hs-gallery-controls">
      <div class="hs-gallery-counter"><span id="hs-gal-current">1</span>/<span id="hs-gal-total">5</span></div>
      <div class="hs-gallery-nav">
        <button id="hs-gal-prev" aria-label="Previous">&#8592;</button>
        <button id="hs-gal-next" aria-label="Next">&#8594;</button>
      </div>
    </div>
  </section>


  <!-- BANNER -->
  <section class="hs-banner">
    <div class="hs-banner-bg"></div>
    <div class="hs-banner-content">
      <h2 class="hs-banner-quote">Integrated architecture, engineering and project consultancy for practical, coordinated and buildable developments. </h2>
    </div>
  </section>

  <!-- STATS -->
  <section class="hs-stats">
    <div class="hs-stats-inner">
      <div class="hs-stat-item reveal"><span class="hs-stat-num">5</span><span class="hs-stat-label">Local</span></div>
      <div class="hs-stat-divider"></div>
      <div class="hs-stat-item reveal"><span class="hs-stat-num">200+</span><span class="hs-stat-label">International</span></div>
      <div class="hs-stat-divider"></div>
      <div class="hs-stat-item reveal"><span class="hs-stat-num">200+</span><span class="hs-stat-label">Happy<br>Clients</span></div>
      <div class="hs-stat-divider"></div>
      <div class="hs-stat-item reveal"><span class="hs-stat-num">10</span><span class="hs-stat-label">Years of<br>Practice</span></div>
      <div class="hs-stat-nav">
        <button aria-label="Previous stat">&#8592;</button>
        <button aria-label="Next stat">&#8594;</button>
      </div>
    </div>
  </section>

  <!-- LOGO STRIP -->
  <?php 
  // Hardcoded partner logos to prevent database glitches
  $hardcodedPartners = [
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad76eafe28.21349305.jpg', 'alt_text' => 'Mazanec'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad5a6c9a02.13187782.jpg', 'alt_text' => 'EPIC'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad48c67e40.02405538.jpg', 'alt_text' => 'Hosokawa Alpine'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad35666e06.11957914.jpg', 'alt_text' => 'Westport'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad27b9de38.76631544.png', 'alt_text' => 'Gems & Partner'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad19e8dbb5.78825162.jpg', 'alt_text' => 'Intrafor'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bad0c67e525.84899538.png', 'alt_text' => 'Surewest'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bacf3aa2e46.12771378.png', 'alt_text' => 'mindstudio'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bac7a5a69e5.79779457.png', 'alt_text' => 'RA international'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bac6b237270.37936484.jpg', 'alt_text' => 'Vykres'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bac5bd72539.14685798.jpg', 'alt_text' => 'Metro Tow Trucks'],
      ['image' => 'logo_6a43b3ce4036a9.00932853.png', 'alt_text' => 'H&B Steel'], // Local fallback
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bac11af5993.43430116.jpg', 'alt_text' => 'BEHMER'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3babfba214c6.16496199.jpg', 'alt_text' => 'BCS'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3babebbdf290.27183116.png', 'alt_text' => 'Swan Li'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3babdde8a177.51262754.png', 'alt_text' => 'Apex'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bab197c6bd1.36913317.png', 'alt_text' => 'Urth.'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3bab53950272.13239386.png', 'alt_text' => 'Modpadz'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3baa868d1380.46961839.png', 'alt_text' => 'BOI'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3baa7d484fb5.94758977.png', 'alt_text' => 'Natex'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3ba0d45d4b11.99581543.png', 'alt_text' => 'Australian HSRA'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3ba0bae18230.48420255.png', 'alt_text' => 'SLA'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3ba0aee35e15.23455713.png', 'alt_text' => 'Hga'],
      ['image' => 'https://civilanka.com/uploads/logos/logo_6a3ba00d6663c2.29865339.png', 'alt_text' => 'Timmons Group']
  ];
  
  // Use hardcoded array if DB fails or is empty, to guarantee display
  $logosToDisplay = !empty($partnerLogos) ? $partnerLogos : $hardcodedPartners;
  ?>
  <section class="hs-logo-strip">
    <h2 class="hs-partners-heading">OUR PARTNERS</h2>
    <div class="hs-logo-track">
      <!-- First set of logos -->
      <div class="hs-logos">
        <?php foreach ($logosToDisplay as $logo): ?>
          <div class="hs-logo-item">
            <?php
              if (strpos($logo['image'], 'http') === 0) {
                  $imgSrc = htmlspecialchars($logo['image']);
              } else {
                  $localPath = ROOT_DIR . '/uploads/logos/' . $logo['image'];
                  if (!empty($logo['image']) && file_exists($localPath) && is_file($localPath)) {
                      $imgSrc = $BASE . '/uploads/logos/' . htmlspecialchars($logo['image']);
                  } else {
                      // Fallback to the live site URL if not found locally
                      $imgSrc = 'https://civilanka.com/uploads/logos/' . htmlspecialchars($logo['image']);
                  }
              }
            ?>
            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($logo['alt_text'] ?: 'Partner Logo') ?>" onerror="this.outerHTML='<span style=&quot;font-size:1.2rem;font-weight:600;color:var(--text-secondary);text-align:center;padding:10px;text-transform:uppercase;&quot;>'+this.alt+'</span>';" />
          </div>
        <?php endforeach; ?>
      </div>
      <!-- Duplicate set for seamless looping -->
      <div class="hs-logos">
        <?php foreach ($logosToDisplay as $logo): ?>
          <div class="hs-logo-item">
            <?php
              if (strpos($logo['image'], 'http') === 0) {
                  $imgSrc = htmlspecialchars($logo['image']);
              } else {
                  $localPath = ROOT_DIR . '/uploads/logos/' . $logo['image'];
                  if (!empty($logo['image']) && file_exists($localPath) && is_file($localPath)) {
                      $imgSrc = $BASE . '/uploads/logos/' . htmlspecialchars($logo['image']);
                  } else {
                      $imgSrc = 'https://civilanka.com/uploads/logos/' . htmlspecialchars($logo['image']);
                  }
              }
            ?>
            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($logo['alt_text'] ?: 'Partner Logo') ?>" onerror="this.outerHTML='<span style=&quot;font-size:1.2rem;font-weight:600;color:var(--text-secondary);text-align:center;padding:10px;text-transform:uppercase;&quot;>'+this.alt+'</span>';" />
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FOUNDERS -->
  <section class="hs-founders">
    <div class="hs-founders-inner">
      <div class="hs-founders-text reveal-left">
        <h2 class="hs-founders-heading">Meet our Team Behind CiviLanka</h2>
        <p>Our multidisciplinary team brings together architecture, structural engineering, civil works, MEP coordination, BIM documentation, cost planning, construction and project coordination expertise to support residential, commercial, industrial and infrastructure developments from concept to completion.  </p>
        <a href="#footer" class="hs-read-more" style="margin-top:2rem;display:inline-block;">Work with us</a>
      </div>
      <div class="hs-founders-photos">
        <div class="hs-founder-photo reveal"><img src="<?= $BASE ?>/team%20images/32.png" alt="Jacob, Founding Architect" /></div>
        <div class="hs-founder-photo reveal"><img src="<?= $BASE ?>/team%20images/33.png" alt="Maria, Founding Architect" /></div>
      </div>
    </div>
  </section>

  <!-- TEAM GRID -->
  <section class="hs-team">
    <div class="hs-team-grid">
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/32.png" alt="Robert Jhonson" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Teshan</h3><p class="hs-tc-role">Structural Engineer</p>
        </div>
      </div>
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/33.png" alt="Aida Belul" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Dhiyan</h3><p class="hs-tc-role">Senior Structural Engineer</p>
        </div>
      </div>
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/29.png" alt="Rebecca Wales" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Harsha</h3><p class="hs-tc-role">Draughtsman & 3D Visualizer</p>
        </div>
      </div>
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/30.png" alt="Jasmin Dorothy" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Janith</h3><p class="hs-tc-role">Facility Engineer</p>
        </div>
      </div>
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

  <!-- CTA -->
  <section class="hs-cta">
    <div class="hs-cta-inner reveal">
      <p class="hs-cta-text">Have a project that needs design, engineering, BIM, costing or construction support? Send us your brief, drawings or project scope and our team will guide the next step. </p>
      <a href="<?= $BASE ?>/contact" class="hs-cta-btn">Contact us</a>
    </div>
  </section>
