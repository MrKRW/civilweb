<?php
$title     = 'Services — Civilanka Architecture & Engineering';
$meta      = "Explore Civilanka's full range of architectural, structural, MEP, and construction services.";
$pageClass = 'services-page';
$activeNav = 'services';
$extraJs   = ['services.js'];
$BASE      = '/civilweb';
?>

  <!-- PAGE HERO -->
  <section class="services-hero">
    <div class="services-hero-inner">
      <span class="new-section-label">• &nbsp;WHAT WE OFFER</span>
      <h1 class="services-hero-title">Our Services</h1>
      <p class="services-hero-sub">Comprehensive architecture, engineering &amp; construction solutions — delivered locally and internationally with precision and creativity.</p>
    </div>
    <div class="services-scroll-hint"><span>scroll</span><div class="services-scroll-line"></div></div>
  </section>

  <!-- SERVICES -->
  <section id="our-services" class="services-section">
    <div class="srv-section-header reveal-up">
      <div class="srv-section-badge">Our Services</div>
      <h2 class="srv-section-title">Comprehensive <em>Solutions</em></h2>
      <p class="srv-section-desc">Delivering world-class design, engineering, and construction services for every stage of your project.</p>
    </div>

    <div class="srv-intl-layout">
      <!-- Service 1 -->
      <div class="srv-intl-featured reveal-left">
        <div class="srv-intl-featured-img">
          <img src="<?= $BASE ?>/Project images/A (10).png" alt="Design & Visualization" />
          <div class="srv-intl-img-overlay"><span class="srv-intl-img-label">Design &amp; Visualization</span></div>
        </div>
        <div class="srv-intl-featured-content">
          <span class="srv-intl-num">01</span>
          <h3>Design &amp; Visualization</h3>
          <ul class="srv-card-list">
            <li><strong>Architectural Design:</strong> Professional design and drawings documentation for residential, commercial, Industrial and Mixed use projects.</li>
            <li><strong>3D Modelling &amp; Visualization:</strong> Clear visual and technical models supporting design and construction.</li>
            <li><strong>Landscape &amp; Outdoor Space Design:</strong> External space design documentation for diverse developments.</li>
          </ul>
        </div>
      </div>

      <!-- Service 2 -->
      <div class="srv-intl-featured srv-intl-featured--reverse reveal-right">
        <div class="srv-intl-featured-img">
          <img src="<?= $BASE ?>/Project images/1 (4).png" alt="Engineering & Infrastructure" />
          <div class="srv-intl-img-overlay"><span class="srv-intl-img-label">Engineering &amp; Infrastructure</span></div>
        </div>
        <div class="srv-intl-featured-content">
          <span class="srv-intl-num">02</span>
          <h3>Engineering &amp; Infrastructure</h3>
          <ul class="srv-card-list">
            <li><strong>Structural Engineering Support:</strong> Structural designs, drafting, detailing, structural calculation reports, soil investigation coordination.</li>
            <li><strong>Civil Engineering &amp; External Works:</strong> Design documentation for site development, drainage, and infrastructure.</li>
            <li><strong>MEP &amp; Building Services Coordination:</strong> Drafting and coordination for mechanical, electrical, plumbing, and smart systems.</li>
          </ul>
        </div>
      </div>

      <!-- Service 3 -->
      <div class="srv-intl-featured reveal-left">
        <div class="srv-intl-featured-img">
          <img src="<?= $BASE ?>/Project images/WIN_Facility6.jpg" alt="Management, Costing & Consulting" />
          <div class="srv-intl-img-overlay"><span class="srv-intl-img-label">Management, Costing &amp; Consulting</span></div>
        </div>
        <div class="srv-intl-featured-content">
          <span class="srv-intl-num">03</span>
          <h3>Management, Costing &amp; Consulting</h3>
          <ul class="srv-card-list">
            <li><strong>Quantity Surveying &amp; Cost Estimation:</strong> Cost and quantity documentation for budgeting, tendering, and cost control.</li>
            <li><strong>Project Management &amp; Supervision Support:</strong> Project planning, technical coordination, monitoring, and reporting assistance.</li>
            <li><strong>Research &amp; Development:</strong> Pre-feasibility and feasibility study reports, technical specifications, green building consultancy.</li>
          </ul>
        </div>
      </div>

      <!-- Service 4 -->
      <div class="srv-intl-featured srv-intl-featured--reverse reveal-right">
        <div class="srv-intl-featured-img">
          <img src="<?= $BASE ?>/Project images/2023-11-07.jpg" alt="Project Close-Out" />
          <div class="srv-intl-img-overlay"><span class="srv-intl-img-label">Project Close-Out</span></div>
        </div>
        <div class="srv-intl-featured-content">
          <span class="srv-intl-num">04</span>
          <h3>Project Close-Out</h3>
          <ul class="srv-card-list">
            <li><strong>Handover Documentation:</strong> Project close-out support including final documentation and handover preparation.</li>
            <li><strong>Aftercare:</strong> Maintenance services.</li>
          </ul>
        </div>
      </div>

      <!-- Service 5 -->
      <div class="srv-intl-featured reveal-left">
        <div class="srv-intl-featured-img">
          <img src="<?= $BASE ?>/Project images/A (10).png" alt="End-to-End Turnkey Construction" />
          <div class="srv-intl-img-overlay"><span class="srv-intl-img-label">End-to-End Turnkey Construction</span></div>
        </div>
        <div class="srv-intl-featured-content">
          <span class="srv-intl-num">05</span>
          <h3>End-to-End Turnkey Construction</h3>
          <p class="srv-card-sub" style="margin-top:-10px; margin-bottom: 10px; color: #555;">Exclusive physical construction, management and delivery services for local clients.</p>
          <ul class="srv-card-list">
            <li><strong>Turnkey Solutions:</strong> Complete, end-to-end construction delivery for local residential and commercial projects.</li>
            <li><strong>Building &amp; Renovation:</strong> Full-scale housing and commercial construction, including renovations and extensions.</li>
            <li><strong>Site &amp; Civil Works:</strong> Site preparation, road access, and underground service infrastructure.</li>
            <li><strong>Building Systems &amp; Finishing:</strong> Installation of mechanical, electrical, plumbing, smart systems, and finishing works.</li>
          </ul>
        </div>
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
