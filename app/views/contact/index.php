<?php
$title     = 'Contact Us — Civilanka Architecture & Design';
$meta      = 'Get in touch with Civilanka Architecture Studio. Find our offices in Colombo, contact details, and send us a message directly.';
$pageClass = 'contact-page';
$activeNav = 'contact';
$extraCss  = ['contact.css'];
$extraJs   = ['contact.js'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>

  <!-- PAGE TITLE -->
  <section class="ct-page-title">
    <div class="ct-page-title-inner">
      <h1 class="ct-title">Contact Us</h1>
    </div>
  </section>

  <!-- CONTACT BODY -->
  <section class="ct-body">
    <div class="ct-body-inner">

      <!-- LEFT: Form -->
      <div class="ct-left">
        <p class="ct-intro-text">Morbi tristique senectus et netus. Arcu odio ut sem nulla pharetra. Sapien eget mi proin sed libero enim sed faucibus turpis. Sit amet cursus sit amet.</p>

        <form id="contact-form" class="ct-form" novalidate>
          <div class="ct-form-row">
            <div class="ct-form-field">
              <label for="contact-name">NAME</label>
              <input type="text" id="contact-name" name="name" autocomplete="name" required />
            </div>
            <div class="ct-form-field">
              <label for="contact-email">EMAIL</label>
              <input type="email" id="contact-email" name="email" autocomplete="email" required />
            </div>
          </div>
          <div class="ct-form-field ct-form-field--full">
            <label for="contact-message">MESSAGE</label>
            <textarea id="contact-message" name="message" rows="6" required></textarea>
          </div>
          <div class="ct-form-bottom">
            <button type="submit" class="ct-submit-btn" id="ct-submit">
              <span>Send Message</span>
              <svg width="36" height="10" viewBox="0 0 60 14" fill="none"><path d="M0 7H58M58 7L52 1M58 7L52 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <p class="ct-form-note" id="ct-form-note" aria-live="polite"></p>
          </div>
        </form>
      </div>

      <!-- RIGHT: Contact Info -->
      <div class="ct-right">
        <div class="ct-info-row">
          <div class="ct-info-panel">
            <span class="ct-info-label">DIRECT CONTACT</span>
            <address class="ct-info-address">
              <p>24 Studio Lane, Colombo</p>
              <p><a href="tel:+94112345678">+94 11 234 5678</a></p>
              <p><a href="mailto:hello@civilweb.com">hello@civilweb.com</a></p>
            </address>
          </div>
          <div class="ct-info-panel">
            <span class="ct-info-label">ADMINISTRATIVE HOURS</span>
            <div class="ct-info-hours">
              <p>Monday to Friday, <span class="ct-accent">9AM–5PM</span></p>
              <p class="ct-accent">Weekend Closed</p>
            </div>
          </div>
        </div>
        <hr class="ct-info-divider" />
        <div class="ct-info-row">
          <div class="ct-info-panel">
            <span class="ct-info-label">COLOMBO</span>
            <address class="ct-info-address">
              <p>24 Studio Lane Colombo 03</p>
              <p><a href="tel:+94112345678">+94 11 234 5678</a></p>
              <p><a href="mailto:hello@civilweb.com">hello@civilweb.com</a></p>
            </address>
          </div>
          <div class="ct-info-panel">
            <span class="ct-info-label">KANDY</span>
            <address class="ct-info-address">
              <p>12 Hill Street Kandy, Sri Lanka</p>
              <p><a href="tel:+94812345678">+94 81 234 5678</a></p>
              <p><a href="mailto:kandy@civilweb.com">kandy@civilweb.com</a></p>
            </address>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- MAP -->
  <section class="ct-map-section">
    <div class="ct-map-inner">
      <div class="ct-map-embed">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63371.80388554756!2d79.8211526!3d6.9270786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae253d10f7a7003%3A0x320b2e4d32d3838d!2sColombo%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1699900000000!5m2!1sen!2slk"
          width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="Civilanka Office Location">
        </iframe>
      </div>
    </div>
  </section>
