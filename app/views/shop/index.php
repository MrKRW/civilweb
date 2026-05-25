<?php
$title     = 'Shop — Civilanka Architecture Studio';
$meta      = 'Browse the Civilanka shop — architectural materials, design products and studio collections.';
$pageClass = 'shop-page';
$activeNav = 'shop';
$extraJs   = ['shop.js'];
$BASE      = '/civilweb';
?>

  <!-- PAGE TITLE -->
  <section class="ct-page-title">
    <div class="ct-page-title-inner">
      <h1 class="ct-title">Shop</h1>
    </div>
  </section>

  <!-- SHOP GRID — dynamically loaded by shop.js -->
  <section class="shop-section">
    <div class="container">
      <div class="shop-grid" id="shop-grid">
        <p class="loading-text" style="text-align:center;padding:60px 0;color:#888;">Loading items…</p>
      </div>
    </div>
  </section>

  <!-- EMPTY STATE -->
  <section class="pj-empty" id="shop-empty" style="display:none;">
    <div class="pj-empty-inner">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      <h2>No items available</h2>
      <p>Check back soon — new products are on the way.</p>
    </div>
  </section>
