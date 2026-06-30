<?php
$title     = htmlspecialchars($post['title']) . ' — Civilanka Blog';
$meta      = htmlspecialchars($post['excerpt']);
$pageClass = 'blog-post-page';
$activeNav = 'blog';
$extraCss  = ['blog.css'];
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');

$img = !empty($post['image']) ? $BASE . '/uploads/blog/' . htmlspecialchars($post['image']) : $BASE . '/assets/images/blog/villa.png';
$cat = !empty($post['category']) ? strtoupper(htmlspecialchars($post['category'])) : 'ARCHITECTURE';
$date = !empty($post['created_at']) ? date('F j, Y', strtotime($post['created_at'])) : '';
?>

<!-- ═══════════════════════════════════════════
     BREADCRUMBS
═══════════════════════════════════════════ -->
<div class="breadcrumb-container" style="padding-top: calc(var(--header-height) + 20px);">
  <div class="container">
    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <a href="<?= $BASE ?>/">Home</a>
      <span class="bc-sep">›</span>
      <a href="<?= $BASE ?>/blog">Blog</a>
      <span class="bc-sep">›</span>
      <span><?= $cat ?></span>
    </nav>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     POST HEADER
═══════════════════════════════════════════ -->
<header class="post-header">
  <div class="container post-header__inner">
    <span class="post-header__cat"><?= $cat ?></span>
    <h1 class="post-header__title"><?= htmlspecialchars($post['title']) ?></h1>
    <?php if ($date): ?>
      <time class="post-header__date"><?= $date ?></time>
    <?php endif; ?>
  </div>
</header>

<!-- ═══════════════════════════════════════════
     POST HERO IMAGE
═══════════════════════════════════════════ -->
<div class="post-hero-image">
  <div class="container">
    <div class="post-hero-image__wrap">
      <img src="<?= $img ?>" alt="<?= htmlspecialchars($post['title']) ?>" <?php if(!empty($post['image'])) echo 'onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src=\'https://civilanka.com/uploads/blog/'.htmlspecialchars($post['image']).'\';}"'; ?> />
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     POST CONTENT
═══════════════════════════════════════════ -->
<main class="post-main">
  <div class="container">
    <div class="post-content-wrap">
      <article class="post-body">
        <?php if (!empty($post['excerpt'])): ?>
          <p class="post-intro"><?= htmlspecialchars($post['excerpt']) ?></p>
        <?php endif; ?>
        
        <div class="post-html">
          <?= $post['content'] ?>
        </div>
      </article>

      <!-- Sidebar -->
      <aside class="post-sidebar">
        <!-- Recent Posts -->
        <?php if (!empty($recent)): ?>
        <div class="widget widget-recent">
          <h3 class="widget-title">Recent Posts</h3>
          <div class="recent-list">
            <?php foreach ($recent as $rp): ?>
              <?php
                if ($rp['id'] === $post['id']) continue; // Skip current
                $rImg = !empty($rp['image']) ? $BASE . '/uploads/blog/' . htmlspecialchars($rp['image']) : $BASE . '/assets/images/blog/villa.png';
                $rDate = !empty($rp['created_at']) ? date('M j, Y', strtotime($rp['created_at'])) : '';
              ?>
              <a href="<?= $BASE ?>/blog/post/<?= $rp['id'] ?>" class="recent-item">
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
      </aside>
    </div>
  </div>
</main>
