<?php
$title     = 'Services — Civilanka Architecture & Engineering';
$meta      = "Explore Civilanka's full range of architectural, structural, MEP, and construction services.";
$pageClass = 'services-page';
$activeNav = 'services';
$extraJs   = ['services.js'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>

  <!-- SERVICES -->
  <section id="our-services" class="services-section">
    <div class="srv-section-header reveal-up">
      <div class="srv-section-badge">Our Services</div>
      <h2 class="srv-section-title">Comprehensive Solutions</h2>
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
            <li>Architectural Design</li>
            <li>3D Modelling &amp; Visualization</li>
            <li>Landscape &amp; Outdoor Space Design</li>
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
            <li>Structural Engineering Support</li>
            <li>Civil Engineering &amp; External Works</li>
            <li>MEP &amp; Building Services Coordination</li>
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
            <li>Quantity Surveying &amp; Cost Estimation</li>
            <li>Project Management &amp; Supervision Support</li>
            <li>Research &amp; Development</li>
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
            <li>Handover Documentation</li>
            <li>Aftercare</li>
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
            <li>Turnkey Solutions</li>
            <li>Building &amp; Renovation</li>
            <li>Site &amp; Civil Works</li>
            <li>Building Systems &amp; Finishing</li>
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
