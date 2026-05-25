<?php
$title     = 'Projects — Civilanka Architecture & Design';
$meta      = "Explore Civilanka's portfolio of local and international architecture projects.";
$pageClass = 'projects-page';
$activeNav = 'projects';
$extraCss  = ['contact.css', 'projects.css'];
$extraJs   = ['projects.js'];
$BASE      = '';
?>

  <!-- PAGE TITLE -->
  <section class="ct-page-title">
    <div class="ct-page-title-inner">
      <h1 class="ct-title" style="visibility: hidden;">Our Projects</h1>
    </div>
  </section>

  <!-- FILTER BAR -->
  <section class="pj-filters">
    <div class="pj-filters-inner">
      <button class="pj-filter-btn active" data-filter="all">show all</button>
      <button class="pj-filter-btn" data-filter="local">local</button>
      <button class="pj-filter-btn" data-filter="international">international</button>
    </div>
    <div class="pj-filters-inner pj-type-filters">
      <button class="pj-type-btn active" data-type="all">show all</button>
      <button class="pj-type-btn" data-type="ARCHITECTURE">Architecture</button>
      <button class="pj-type-btn" data-type="INTERIOR">Interior</button>
      <button class="pj-type-btn" data-type="WELLNESS">Wellness</button>
      <button class="pj-type-btn" data-type="COMMERCIAL">Commercial</button>
      <button class="pj-type-btn" data-type="RESIDENTIAL">Residential</button>
      <button class="pj-type-btn" data-type="LANDSCAPE">Landscape</button>
      <button class="pj-type-btn" data-type="URBAN PLANNING">Urban Planning</button>
    </div>
  </section>

  <!-- PROJECT COUNT -->
  <section class="pj-count-bar">
    <div class="pj-count-inner">
      <span class="pj-count-text" id="pj-count-text">Loading projects…</span>
    </div>
  </section>

  <!-- PROJECT GRID -->
  <section class="pj-grid-section">
    <div class="pj-grid" id="pj-grid"></div>
  </section>

  <!-- EMPTY STATE -->
  <section class="pj-empty" id="pj-empty" style="display:none;">
    <div class="pj-empty-inner">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
      <h2>No projects found</h2>
      <p>Check back soon — new projects are on the way.</p>
    </div>
  </section>

  <!-- CTA -->
  <section class="pj-cta">
    <div class="pj-cta-inner">
      <h2>Have a project in mind?</h2>
      <p>Whether it's a private home or a city block — bring us your vision. We'll shape it into something that lasts.</p>
      <a href="<?= $BASE ?>/contact" class="pj-cta-btn">
        <span>Get in touch</span>
        <svg width="36" height="10" viewBox="0 0 60 14" fill="none"><path d="M0 7H58M58 7L52 1M58 7L52 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
      </a>
    </div>
  </section>
