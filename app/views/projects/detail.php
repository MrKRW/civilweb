<?php
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
$project = $project ?? [];
$title = htmlspecialchars(($project['title'] ?? 'Project') . ' — Civilanka Architecture');
$meta  = htmlspecialchars($project['description'] ?? 'Project detail — Civilanka Engineering & Consultancy.');
$pageClass = 'project-detail-page';
$activeNav = 'projects';
$extraCss  = ['projects.css'];

$imgSrc  = !empty($project['image_main'])
    ? $BASE . '/uploads/projects/' . $project['image_main']
    : $BASE . '/Project%20images/2023-11-07.jpg';

$gallery = is_array($project['image_gallery']) ? $project['image_gallery'] : [];
?>

  <!-- PROJECT HERO -->
  <section class="pj-detail-hero">
    <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($project['title'] ?? '') ?>" class="pj-detail-hero-img" <?php if(!empty($project['image_main'])) echo 'onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src=\'https://civilanka.com/uploads/projects/'.rawurlencode($project['image_main']).'\';}"'; ?> />
    <div class="pj-detail-hero-overlay">
      <div class="container">
        <span class="pj-detail-cat"><?= htmlspecialchars($project['service_type'] ?? '') ?></span>
        <h1 class="pj-detail-title"><?= htmlspecialchars($project['title'] ?? '') ?></h1>
      </div>
    </div>
  </section>

  <!-- PROJECT META + DESCRIPTION -->
  <section class="pj-detail-body">
    <div class="container">
      <div class="pj-detail-meta">
        <?php if (!empty($project['location'])): ?>
        <div class="pj-meta-item"><span class="pj-meta-label">Location</span><span class="pj-meta-val"><?= htmlspecialchars($project['location']) ?></span></div>
        <?php endif; ?>
        <?php if (!empty($project['client'])): ?>
        <div class="pj-meta-item"><span class="pj-meta-label">Client</span><span class="pj-meta-val"><?= htmlspecialchars($project['client']) ?></span></div>
        <?php endif; ?>
        <?php if (!empty($project['year'])): ?>
        <div class="pj-meta-item"><span class="pj-meta-label">Year</span><span class="pj-meta-val"><?= htmlspecialchars($project['year']) ?></span></div>
        <?php endif; ?>
        <?php if (!empty($project['category'])): ?>
        <div class="pj-meta-item"><span class="pj-meta-label">Category</span><span class="pj-meta-val"><?= htmlspecialchars(ucfirst($project['category'])) ?></span></div>
        <?php endif; ?>
      </div>

      <?php if (!empty($project['description'])): ?>
      <div class="pj-detail-desc">
        <div class="post-html"><?= $project['description'] ?></div>
      </div>
      <?php endif; ?>

      <?php if ($gallery): ?>
      <div class="pj-detail-gallery">
        <?php foreach ($gallery as $g): ?>
        <div class="pj-gallery-item">
          <img src="<?= $BASE ?>/uploads/projects/<?= htmlspecialchars($g) ?>" alt="Project gallery image" onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='https://civilanka.com/uploads/projects/<?= rawurlencode($g) ?>';}" />
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <div class="pj-detail-back">
        <a href="<?= $BASE ?>/projects" class="btn btn-ghost">← Back to Projects</a>
      </div>
    </div>
  </section>
