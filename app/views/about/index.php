<?php
$title     = 'Our Studio — Civilanka Architecture & Design';
$meta      = "Learn about Civilanka's philosophy, founding architects, and our approach to timeless design.";
$pageClass = 'about-page';
$activeNav = 'about';
$extraCss  = ['about.css'];
$extraJs   = ['about.js'];
$BASE      = '';
?>

  <!-- HERO -->
  <section id="about-hero" class="hs-hero">
    <div class="hs-hero-bg"></div>
    <nav class="about-hero-nav" aria-label="Hero Navigation">
      <a href="<?= $BASE ?>/" class="hero-logo" aria-label="Civilanka Home">
        <img src="<?= $BASE ?>/Logos/trans.PNG" alt="Civilanka Architects" />
      </a>
      <ul role="list">
        <li><a href="<?= $BASE ?>/">home</a></li>
        <li class="active"><a href="<?= $BASE ?>/about">about</a></li>
        <li><a href="<?= $BASE ?>/projects">projects</a></li>
        <li><a href="<?= $BASE ?>/blog">blog</a></li>
        <li><a href="<?= $BASE ?>/shop">shop</a></li>
        <li><a href="<?= $BASE ?>/contact">contact</a></li>
      </ul>
    </nav>
    <div class="hs-hero-content"><h1 class="hs-hero-title">Our Studio</h1></div>
    <div class="hs-hero-footer">
      <div class="hs-hero-tag"><span class="dot"></span> A SENSE OF SERENITY</div>
    </div>
  </section>

  <!-- INTRO -->
  <section class="hs-intro">
    <div class="hs-intro-inner">
      <div class="hs-intro-left reveal-left">
        <h2 class="hs-intro-heading">Architects and other<br class="hs-desktop-br">engineers meeting to improve<br class="hs-desktop-br">the learning and collaboration<br class="hs-desktop-br">between one another</h2>
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
        <h3 class="hs-approach-title">Urban Exteriors</h3>
        <p>From street-facing facades to public plazas, we design exterior spaces that activate communities and create memorable experiences.</p>
        <a href="#" class="hs-read-more">read more</a>
      </div>
      <div class="hs-approach-col">
        <h3 class="hs-approach-title">Cityscapes Buildings</h3>
        <p>We create buildings that become landmarks — structures that define skylines and serve as gathering places. Each project is an opportunity to shape how cities evolve.</p>
        <a href="#" class="hs-read-more">read more</a>
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

  <!-- QUOTE -->
  <section class="hs-quote">
    <div class="hs-quote-inner reveal">
      <p class="hs-quote-text">Our studio is built on the principle that great architecture emerges from collaboration, diverse perspectives, and a shared commitment to excellence.</p>
      <span class="hs-quote-author">JACOB, OWNER</span>
      <div class="hs-quote-dots">
        <span class="hs-dot active"></span><span class="hs-dot"></span><span class="hs-dot"></span>
      </div>
    </div>
  </section>

  <!-- BANNER -->
  <section class="hs-banner">
    <div class="hs-banner-bg"></div>
    <div class="hs-banner-content">
      <h2 class="hs-banner-quote">The whimsical feel of Villa Esther begins with the Neo-Modern gateway in the style of Le Corbusier's Villa Savoye.</h2>
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

  <!-- FOUNDERS -->
  <section class="hs-founders">
    <div class="hs-founders-inner">
      <div class="hs-founders-text reveal-left">
        <h2 class="hs-founders-heading">Meet our Architects:<br>Jacob and Maria</h2>
        <p>Our founding partners bring together decades of experience and a shared vision for architecture that is both beautiful and functional.</p>
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
          <h3 class="hs-tc-name">Robert Jhonson</h3><p class="hs-tc-role">CEO / ARCHITECT</p>
          <div class="hs-tc-socials"><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-facebook-f"></i></a></div>
        </div>
      </div>
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/33.png" alt="Aida Belul" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Aida Belul</h3><p class="hs-tc-role">MAIN CONTRACTOR</p>
          <div class="hs-tc-socials"><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-facebook-f"></i></a></div>
        </div>
      </div>
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/29.png" alt="Rebecca Wales" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Rebecca Wales</h3><p class="hs-tc-role">ARCHITECT</p>
          <div class="hs-tc-socials"><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-facebook-f"></i></a></div>
        </div>
      </div>
      <div class="hs-team-card">
        <div class="hs-tc-photo"><img src="<?= $BASE ?>/team%20images/30.png" alt="Jasmin Dorothy" /></div>
        <div class="hs-tc-info">
          <h3 class="hs-tc-name">Jasmin Dorothy</h3><p class="hs-tc-role">PRODUCT DESIGNER</p>
          <div class="hs-tc-socials"><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-facebook-f"></i></a></div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="hs-cta">
    <div class="hs-cta-inner reveal">
      <p class="hs-cta-text">Lorem ipsum dolor sit amet, cons tetur adip scing elit. Praesent accumsan libero ac ullamcorper ultrices.</p>
      <a href="#footer" class="hs-cta-btn">contact us</a>
    </div>
  </section>
