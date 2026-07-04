<?php
$title     = 'Contact Us — Civilanka Engineering & Consultancy';
$meta      = 'Get in touch with Civilanka Engineering & Consultancy. Find our offices in Colombo, contact details, and send us a message directly.';
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
        <p class="ct-intro-text">Have a project, drawing set or site requirement you need help with?  Send us your inquiry and our team will review your requirements for design, engineering, BIM, costing, consultancy or construction support.</p>

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
          <div class="ct-form-row">
            <div class="ct-form-field">
              <label for="contact-phone">PHONE / WHATSAPP</label>
              <input type="text" id="contact-phone" name="phone" required />
            </div>
            <div class="ct-form-field">
              <label for="contact-location">PROJECT LOCATION</label>
              <input type="text" id="contact-location" name="location" required />
            </div>
          </div>
          <div class="ct-form-field ct-form-field--full">
            <label for="contact-service">SERVICE REQUIRED</label>
            <select id="contact-service" name="service" required>
              <option value="" disabled selected></option>
              <option value="Architectural Design">Architectural Design</option>
              <option value="Structural Engineering">Structural Engineering</option>
              <option value="Civil & Infrastructure Works">Civil & Infrastructure Works</option>
              <option value="MEP Design & Coordination">MEP Design & Coordination</option>
              <option value="BIM Modeling & Documentation">BIM Modeling & Documentation</option>
              <option value="3D Visualization & Rendering">3D Visualization & Rendering</option>
              <option value="Quantity Surveying / BOQ / Cost Estimation">Quantity Surveying / BOQ / Cost Estimation</option>
              <option value="Project Management / Site Supervision">Project Management / Site Supervision</option>
              <option value="Landscape & Outdoor Space Design">Landscape & Outdoor Space Design</option>
              <option value="Turnkey Construction">Turnkey Construction</option>
              <option value="General Consultation">General Consultation</option>
            </select>
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
              <p>374, Peradeniya Road,</p>
              <p>Kandy 2000, Sri Lanka.</p>
              <p>Phone: 0812 387 235</p>
               <p><a href="https://wa.me/94765797472" target="_blank">WhatsApp: 0765 797 472</a></p>
              <p><a href="mailto:contact@civilanka.com">contact@civilanka.com</a></p>
            </address>
          </div>
          <div class="ct-info-panel">
            <span class="ct-info-label">ADMINISTRATIVE HOURS</span>
            <div class="ct-info-hours">
              <p>Monday to Friday, <span class="ct-accent">9AM–6PM</span></p>
              <p class="ct-accent">Sunday: By appointment only </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- MAP -->
  <section class="ct-map-section">
    <div class="ct-map-inner">
      <div class="ct-map-embed">
        <iframe src="https://maps.google.com/maps?q=374%2C%20Peradeniya%20Road%2C%20Kandy&t=&z=15&ie=UTF8&iwloc=&output=embed"
          width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="Civilanka Office Location">
        </iframe>
      </div>
    </div>
  </section>
