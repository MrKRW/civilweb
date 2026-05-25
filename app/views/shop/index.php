<?php
$title     = 'Shop — Civilanka Architecture Studio';
$meta      = 'Browse the Civilanka shop — architectural materials, design products and studio collections.';
$pageClass = 'shop-page';
$activeNav = 'shop';
$extraJs   = ['shop.js'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>

  <!-- MAIN SHOP SECTION -->
  <main id="shop-main" class="main-below-header" style="padding-bottom: 100px;">
    <div class="container">

      <div class="shop-breadcrumb">
        <a href="<?= $BASE ?>/">Home</a> <span class="sep">/</span> <span class="current">Shop</span>
      </div>

      <div class="shop-layout">
        <!-- SIDEBAR -->
        <aside class="shop-sidebar">

          <!-- Categories -->
          <div class="sidebar-widget">
            <h3 class="widget-title">Categories</h3>
            <ul class="widget-list">
              <li><a href="#">1 BEDROOM APARTMENT</a></li>
              <li><a href="#">2 BEDROOMS APARTMENT</a></li>
              <li><a href="#">3 BEDROOMS APARTMENT</a></li>
              <li><a href="#">CHAIR</a></li>
              <li><a href="#">FURNITURE</a></li>
              <li><a href="#">TILES</a></li>
            </ul>
          </div>

          <!-- Tags -->
          <div class="sidebar-widget">
            <h3 class="widget-title">Tags</h3>
            <div class="widget-tags">
              <a href="#" class="tag-pill">design</a>
              <a href="#" class="tag-pill">materials</a>
              <a href="#" class="tag-pill">technology</a>
            </div>

            <div class="price-slider-placeholder">
              <div class="slider-track">
                <div class="slider-fill"></div>
              </div>
            </div>
          </div>

          <!-- Search -->
          <div class="sidebar-widget widget-search">
            <form class="shop-search" action="#">
              <input type="text" placeholder="SEARCH" />
              <button type="submit" aria-label="Search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="11" cy="11" r="8" />
                  <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
              </button>
            </form>
          </div>

          <!-- Banner -->
          <div class="sidebar-banner">
            <img src="<?= $BASE ?>/Project images/A (10).png" alt="Promo banner">
            <div class="banner-overlay">
              <h4>Up to 40%<br>Off All<br>Products</h4>
              <a href="#" class="banner-link">shop now</a>
            </div>
          </div>

        </aside>

        <!-- MAIN GRID -->
        <div class="shop-content">
          <div class="shop-topbar">
            <p class="result-count">SHOWING 0 RESULTS</p>
            <div class="sort-dropdown">
              <select>
                <option>Default sorting</option>
                <option>Sort by popularity</option>
                <option>Sort by average rating</option>
                <option>Sort by latest</option>
                <option>Sort by price: low to high</option>
                <option>Sort by price: high to low</option>
              </select>
            </div>
          </div>

          <div class="shop-grid" id="shop-grid">
            <p class="loading-text" style="grid-column: 1 / -1; text-align: center; padding: 40px 0;">Loading products...</p>
          </div>

          <!-- Pagination -->
          <div class="shop-pagination">
            <div class="pagination-links">
              <a href="#" class="page-num active">1</a>
              <a href="#" class="page-num">2</a>
              <a href="#" class="page-num">3</a>
            </div>
            <a href="#" class="page-next">
              <svg width="24" height="10" viewBox="0 0 24 10" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M0 5h22M18 1l4 4-4 4" />
              </svg>
            </a>
          </div>

        </div>
      </div>
    </div>
  </main>

