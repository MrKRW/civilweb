<?php
$title     = 'Blog — Civilanka Architecture & Design';
$meta      = 'Insights and stories from Civilanka Architecture Studio.';
$pageClass = 'blog-page';
$activeNav = 'blog';
$extraCss  = ['blog.css'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
$posts = $posts ?? [];
?>

<!-- ═══════════════════════════════════════════
     PAGE HERO BANNER
═══════════════════════════════════════════ -->
<section class="blog-hero">
  <div class="container">
    <div class="blog-hero__inner">
      <span class="blog-hero__label">Our Journal</span>
      <h1 class="blog-hero__title">Stories &amp; Insights</h1>
      <p class="blog-hero__sub">Architecture, design thinking, and behind-the-scenes perspectives from our studio.</p>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     BREADCRUMBS
═══════════════════════════════════════════ -->
<div class="breadcrumb-container">
  <div class="container">
    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <a href="<?= $BASE ?>/">Home</a>
      <span class="bc-sep">›</span>
      <span>Blog</span>
    </nav>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════ -->
<main class="blog-main-layout">
  <div class="container">
    <div class="blog-layout-grid">

      <!-- ── Blog Content (Left) ──────────── -->
      <div class="blog-content">

        <?php if (empty($posts)): ?>
          <!-- Empty State -->
          <div class="blog-empty">
            <div class="blog-empty__icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M28 4H12a4 4 0 00-4 4v32a4 4 0 004 4h24a4 4 0 004-4V16L28 4z"/>
                <polyline points="28 4 28 16 40 16"/>
                <line x1="32" y1="26" x2="16" y2="26"/>
                <line x1="32" y1="34" x2="16" y2="34"/>
                <line x1="20" y1="18" x2="16" y2="18"/>
              </svg>
            </div>
            <h2 class="blog-empty__title">No posts yet</h2>
            <p class="blog-empty__text">Check back soon for insights and stories from our studio.</p>
          </div>

        <?php else: ?>

          <?php
            $featured = $posts[0] ?? null;
            $rest     = array_slice($posts, 1);
          ?>

          <!-- ── Featured / First Post ─────── -->
          <?php if ($featured): ?>
            <?php
              $fImg  = !empty($featured['image'])
                ? $BASE . '/uploads/blog/' . htmlspecialchars($featured['image'])
                : $BASE . '/assets/images/blog/villa.png';
              $fCat  = !empty($featured['category'])
                ? strtoupper(htmlspecialchars($featured['category']))
                : 'ARCHITECTURE';
              $fDate = !empty($featured['created_at'])
                ? date('F j, Y', strtotime($featured['created_at']))
                : '';
            ?>
            <article class="blog-card blog-card--featured">
              <a href="<?= $BASE ?>/blog/post/<?= $featured['id'] ?>" class="blog-card__img-wrap">
                <img src="<?= $fImg ?>" alt="<?= htmlspecialchars($featured['title']) ?>" class="blog-card__img" loading="lazy" <?php if(!empty($featured['image'])) echo 'onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src=\'https://civilanka.com/uploads/blog/'.htmlspecialchars($featured['image']).'\';}"'; ?>>
                <span class="blog-card__cat-badge"><?= $fCat ?></span>
              </a>
              <div class="blog-card__body">
                <?php if ($fDate): ?>
                  <time class="blog-card__date"><?= $fDate ?></time>
                <?php endif; ?>
                <h2 class="blog-card__title">
                  <a href="<?= $BASE ?>/blog/post/<?= $featured['id'] ?>"><?= htmlspecialchars($featured['title']) ?></a>
                </h2>
                <?php if (!empty($featured['excerpt'])): ?>
                  <p class="blog-card__excerpt"><?= htmlspecialchars($featured['excerpt']) ?></p>
                <?php endif; ?>
                <a href="<?= $BASE ?>/blog/post/<?= $featured['id'] ?>" class="blog-card__read-more">Read more <span class="arrow">→</span></a>
              </div>
            </article>
          <?php endif; ?>

          <!-- ── Remaining Posts Grid ──────── -->
          <?php if (!empty($rest)): ?>
            <div class="blog-grid">
              <?php foreach ($rest as $post): ?>
                <?php
                  $img  = !empty($post['image'])
                    ? $BASE . '/uploads/blog/' . htmlspecialchars($post['image'])
                    : $BASE . '/assets/images/blog/villa.png';
                  $cat  = !empty($post['category'])
                    ? strtoupper(htmlspecialchars($post['category']))
                    : 'ARCHITECTURE';
                  $date = !empty($post['created_at'])
                    ? date('F j, Y', strtotime($post['created_at']))
                    : '';
                ?>
                <article class="blog-card blog-card--grid">
                  <a href="<?= $BASE ?>/blog/post/<?= $post['id'] ?>" class="blog-card__img-wrap">
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="blog-card__img" loading="lazy" <?php if(!empty($post['image'])) echo 'onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src=\'https://civilanka.com/uploads/blog/'.htmlspecialchars($post['image']).'\';}"'; ?>>
                    <span class="blog-card__cat-badge"><?= $cat ?></span>
                  </a>
                  <div class="blog-card__body">
                    <?php if ($date): ?>
                      <time class="blog-card__date"><?= $date ?></time>
                    <?php endif; ?>
                    <h3 class="blog-card__title">
                      <a href="<?= $BASE ?>/blog/post/<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                    </h3>
                    <?php if (!empty($post['excerpt'])): ?>
                      <p class="blog-card__excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <?php endif; ?>
                    <a href="<?= $BASE ?>/blog/post/<?= $post['id'] ?>" class="blog-card__read-more">Read more <span class="arrow">→</span></a>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        <?php endif; ?>

      </div><!-- /.blog-content -->

      <!-- ── Sidebar (Right) ──────────────── -->
      <aside class="blog-sidebar" aria-label="Blog sidebar">

        <!-- Search -->
        <div class="widget widget-search">
          <form class="search-form" role="search">
            <input type="text" placeholder="SEARCH" aria-label="Search blog">
            <button type="submit" aria-label="Submit search">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
          </form>
        </div>

        <!-- Categories -->
        <div class="widget widget-categories">
          <h3 class="widget-title">Categories</h3>
          <ul>
            <?php
              $cats = array_unique(array_filter(array_column($posts, 'category')));
              if (empty($cats)) {
                  $cats = ['Architecture', 'Interior', 'Landscape Architecture', 'Materials'];
              }
              foreach ($cats as $cat):
            ?>
              <li><a href="#"><?= htmlspecialchars($cat) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Recent Posts -->
        <?php if (!empty($posts)): ?>
        <div class="widget widget-recent">
          <h3 class="widget-title">Recent Posts</h3>
          <div class="recent-list">
            <?php foreach (array_slice($posts, 0, 4) as $rp): ?>
              <?php
                $rImg = !empty($rp['image'])
                  ? $BASE . '/uploads/blog/' . htmlspecialchars($rp['image'])
                  : $BASE . '/assets/images/blog/villa.png';
                $rDate = !empty($rp['created_at']) ? date('M j, Y', strtotime($rp['created_at'])) : '';
              ?>
              <a href="#" class="recent-item">
                <div class="recent-item__img">
                  <img src="<?= $rImg ?>" alt="<?= htmlspecialchars($rp['title']) ?>" <?php if(!empty($rp['image'])) echo 'onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src=\'https://civilanka.com/uploads/blog/'.htmlspecialchars($rp['image']).'\';}"'; ?>>
                </div>
                <div class="recent-item__info">
                  <span class="recent-item__title"><?= htmlspecialchars($rp['title']) ?></span>
                  <?php if ($rDate): ?><time class="recent-item__date"><?= $rDate ?></time><?php endif; ?>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Newsletter -->
        <div class="widget widget-newsletter">
          <div class="newsletter-box">
            <h3 class="widget-title">Newsletter</h3>
            <p class="newsletter-desc">Get design insights delivered to your inbox.</p>
            <form class="newsletter-form">
              <input type="email" placeholder="Your email address" required aria-label="Email address">
              <button type="submit" class="btn-send">Subscribe</button>
            </form>
          </div>
        </div>

        <!-- Get Inspired -->
        <div class="widget widget-inspired">
          <h3 class="widget-title">Get Inspired</h3>
          <div class="inspired-grid">
            <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_1.png" alt="Inspiration 1" loading="lazy"></div>
            <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_2.png" alt="Inspiration 2" loading="lazy"></div>
            <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_3.png" alt="Inspiration 3" loading="lazy"></div>
            <div class="grid-item"><img src="<?= $BASE ?>/assets/images/blog/inspired_4.png" alt="Inspiration 4" loading="lazy"></div>
          </div>
        </div>

      </aside>

    </div><!-- /.blog-layout-grid -->
  </div><!-- /.container -->
</main>
