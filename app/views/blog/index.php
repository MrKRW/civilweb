<?php
$title     = 'Blog — Civilanka Architecture & Design';
$meta      = 'Insights and stories from Civilanka Architecture Studio.';
$pageClass = 'blog-page';
$activeNav = 'blog';
$extraCss  = ['blog.css'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?>

  <!-- Breadcrumbs -->
  <div class="breadcrumb-container">
    <div class="container">
      <nav class="breadcrumbs">
        <a href="<?= $BASE ?>/">Home</a> / <span>Right Sidebar</span>
      </nav>
    </div>
  </div>

  <!-- Main Content -->
  <main class="blog-main-layout">
    <div class="container">
      <div class="blog-layout-grid">

        <!-- Blog Content Left -->
        <div class="blog-content">

          <!-- Post 1: Slider Style -->
          <article class="post-item post-slider">
            <div class="post-media">
              <img src="<?= $BASE ?>/assets/images/blog/kitchen.png" alt="Living Room Trends">
              <div class="slider-controls">
                <span class="slide-count">1/3</span>
                <div class="slide-arrows">
                  <button class="prev-arrow">←</button>
                  <button class="next-arrow">→</button>
                </div>
              </div>
            </div>
            <div class="post-info">
              <h2 class="post-title"><a href="#">Living Room Trends For The Upcoming Season 2024</a></h2>
              <div class="post-meta">
                <span class="post-cat">LANDSCAPE ARCHITECTURE</span>
                <span class="post-date">DECEMBER 14, 2022</span>
              </div>
            </div>
          </article>

          <!-- Post 2: Quote Style -->
          <article class="post-item post-quote">
            <div class="quote-container">
              <div class="author-img"><img src="<?= $BASE ?>/assets/images/blog/architect.png" alt="Frank Gehry"></div>
              <div class="quote-text-wrap">
                <blockquote class="quote-text">"Architecture should speak of its time and place, but yearn for timelessness."</blockquote>
                <cite class="quote-author">FRANK GEHRY</cite>
              </div>
            </div>
          </article>

          <!-- Post 3: Standard Image -->
          <article class="post-item post-standard">
            <div class="post-media"><img src="<?= $BASE ?>/assets/images/blog/villa.png" alt="Glass Wall Facade"></div>
            <div class="post-info">
              <h2 class="post-title"><a href="#">Glass Wall Facade And How To Design It With Wooden Profiles</a></h2>
              <div class="post-meta">
                <span class="post-cat">LANDSCAPE ARCHITECTURE</span>
                <span class="post-date">DECEMBER 14, 2022</span>
              </div>
            </div>
          </article>

          <!-- Post 4: Small Image List Style -->
          <article class="post-item post-list-style">
            <div class="post-list-inner">
              <div class="post-thumb"><img src="<?= $BASE ?>/Project%20images/hero_local_bright.png" alt="Flooring types"></div>
              <div class="post-list-content">
                <h3 class="post-list-title"><a href="#">Types of flooring to consider for your new apartment</a></h3>
              </div>
            </div>
          </article>

          <!-- Post 5: Standard Image 2 -->
          <article class="post-item post-standard">
            <div class="post-media"><img src="<?= $BASE ?>/assets/images/blog/bathroom.png" alt="Hotel Rooms Puerto Rico"></div>
            <div class="post-info">
              <h2 class="post-title"><a href="#">Architecture &amp; Interior Design Of The Hotel Rooms In Puerto Rico</a></h2>
              <div class="post-meta">
                <span class="post-cat">LANDSCAPE ARCHITECTURE</span>
                <span class="post-date">DECEMBER 14, 2022</span>
              </div>
            </div>
          </article>

          <!-- Pagination -->
          <div class="pagination">
            <ul>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#" class="next-page">→</a></li>
            </ul>
          </div>

        </div><!-- /.blog-content -->

        <!-- Sidebar Right -->
        <aside class="blog-sidebar">
          <div class="widget widget-search">
            <form class="search-form">
              <input type="text" placeholder="SEARCH" aria-label="Search">
              <button type="submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </button>
            </form>
          </div>
          <div class="widget widget-categories">
            <h3 class="widget-title">Blog categories</h3>
            <ul>
              <li><a href="#">ARCHITECTURE</a></li>
              <li><a href="#">INTERVIEWS</a></li>
              <li><a href="#">LANDSCAPE ARCHITECTURE</a></li>
              <li><a href="#">MATERIALS</a></li>
            </ul>
          </div>
          <div class="widget widget-read-next">
            <h3 class="widget-title">Read next</h3>
            <div class="read-next-list">
              <div class="read-next-item">
                <h4><a href="#">Living Room Trends For The Upcoming Season 2024</a></h4>
                <span class="item-cat">LANDSCAPE ARCHITECTURE</span>
              </div>
              <div class="read-next-item">
                <h4><a href="#">Frank Gehry</a></h4>
                <span class="item-cat">LANDSCAPE ARCHITECTURE</span>
              </div>
            </div>
          </div>
          <div class="widget widget-newsletter">
            <div class="newsletter-box">
              <h3 class="widget-title">Join Our Newsletter</h3>
              <form class="newsletter-form">
                <input type="email" placeholder="Your Email" required>
                <button type="submit" class="btn-send">send</button>
              </form>
            </div>
          </div>
          <div class="widget widget-inspired">
            <h3 class="widget-title">Get Inspired</h3>
            <div class="inspired-grid">
              <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_1.png" alt="Inspiration 1"></div>
              <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_2.png" alt="Inspiration 2"></div>
              <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_3.png" alt="Inspiration 3"></div>
              <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_4.png" alt="Inspiration 4"></div>
            </div>
          </div>
          <div class="widget widget-promo">
            <div class="promo-box">
              <div class="promo-img"><img src="<?= $BASE ?>/assets/images/blog/magazine.png" alt="Lighthouse Magazine"></div>
              <div class="promo-content">
                <h4>Light House Magazine No 23</h4>
                <a href="#" class="order-link">order now</a>
              </div>
            </div>
          </div>
        </aside>

      </div>
    </div>
  </main>
