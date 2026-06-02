<?php
/**
 * Main public layout – header + content + footer
 * $content  string – the rendered view output
 * $pageClass string – body class (e.g. 'home-page', 'about-page')
 * $title    string – page <title>
 * $meta     string – meta description
 * $extraCss array  – additional CSS files
 * $extraJs  array  – additional JS files
 */
$pageClass = $pageClass ?? '';
$title     = $title     ?? 'Civilanka — Architecture & Design Studio';
$meta      = $meta      ?? 'Civilanka is a premier architecture and design studio in Sri Lanka.';
$extraCss  = $extraCss  ?? [];
$extraJs   = $extraJs   ?? [];
$activeNav = $activeNav ?? '';
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($title) ?></title>
  <script>const API_BASE = '<?= $BASE ?>';</script>
  <meta name="description" content="<?= htmlspecialchars($meta) ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&family=Inter:wght@300;400;500&family=DM+Sans:wght@300;400;500;600;700&family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Swiper -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Core styles -->
  <link rel="stylesheet" href="<?= $BASE ?>/assets/css/style.css?v=<?= time() ?>" />
  <link rel="stylesheet" href="<?= $BASE ?>/assets/css/services.css" />

  <!-- Page-specific styles -->
  <?php foreach ($extraCss as $css): ?>
  <link rel="stylesheet" href="<?= $BASE . '/assets/css/' . htmlspecialchars($css) ?>?v=<?= time() ?>" />
  <?php endforeach; ?>
</head>
<body class="<?= htmlspecialchars($pageClass) ?>">

  <!-- STICKY HEADER -->
  <header id="sticky-header" role="banner" aria-label="Sticky Navigation">
    <a href="<?= $BASE ?>/" class="sticky-logo" aria-label="Civilanka Home">
      <img src="<?= $BASE ?>/Logos/trans.PNG" alt="Civilanka Architects" class="logo-img logo-img--sticky" />
    </a>
    <ul class="sticky-nav" role="list">
      <li<?= $activeNav === 'home'     ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/">home</a></li>
      <li<?= $activeNav === 'about'    ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/about">about</a></li>
      <li<?= $activeNav === 'services' ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/services">services</a></li>
      <li<?= $activeNav === 'projects' ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/projects">projects</a></li>
      <li<?= $activeNav === 'blog'     ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/blog">blog</a></li>
      <li<?= $activeNav === 'shop'     ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/shop">shop</a></li>
      <li<?= $activeNav === 'contact'  ? ' class="active"' : '' ?>><a href="<?= $BASE ?>/contact">contact</a></li>
    </ul>
    <button class="hamburger-btn" id="hamburger-btn" aria-label="Open navigation menu">
      <span></span><span></span><span></span>
    </button>
  </header>

  <!-- MOBILE NAV -->
  <nav id="mobile-nav" role="navigation" aria-label="Mobile Navigation">
    <button id="mobile-nav-close" aria-label="Close menu">&#x2715;</button>
    <a href="<?= $BASE ?>/">home</a>
    <a href="<?= $BASE ?>/about">about</a>
    <a href="<?= $BASE ?>/services">services</a>
    <a href="<?= $BASE ?>/projects">projects</a>
    <a href="<?= $BASE ?>/blog">blog</a>
    <a href="<?= $BASE ?>/shop">shop</a>
    <a href="<?= $BASE ?>/contact">contact</a>
  </nav>

  <!-- PAGE CONTENT -->
  <?= $content ?>

  <!-- FOOTER -->
  <footer id="footer" role="contentinfo">
    <div class="hs-footer-inner">
      <div class="hs-footer-brand">
        <a href="<?= $BASE ?>/" class="hs-footer-logo">
          <img src="<?= $BASE ?>/Logos/trans.PNG" alt="Civilanka Architects" class="logo-img logo-img--footer" />
        </a>
      </div>
      <div class="hs-footer-cols">
        <div class="hs-footer-col">
          <span class="hs-footer-col-label">Navigate</span>
          <ul>
            <li><a href="<?= $BASE ?>/about">About</a></li>
            <li><a href="<?= $BASE ?>/services">Services</a></li>
            <li><a href="<?= $BASE ?>/projects">Projects</a></li>
            <li><a href="<?= $BASE ?>/blog">Journal</a></li>
            <li><a href="<?= $BASE ?>/contact">Contact</a></li>
          </ul>
        </div>
        <div class="hs-footer-col">
          <span class="hs-footer-col-label">Explore</span>
          <ul>
            <li><a href="<?= $BASE ?>/services">Architectural Design</a></li>
            <li><a href="<?= $BASE ?>/services">Interior Architecture</a></li>
            <li><a href="<?= $BASE ?>/services">Urban Planning</a></li>
            <li><a href="<?= $BASE ?>/services">Landscape Design</a></li>
          </ul>
        </div>
        <div class="hs-footer-col">
          <span class="hs-footer-col-label">Contact</span>
          <address>
            <span>374, Peradeniya Road</span>
            <span>Kandy, Sri Lanka</span>
            <a href="tel:0812387235">0812 387 235</a>
            <a href="mailto:hello@civilweb.com">hello@civilweb.com</a>
          </address>
        </div>
      </div>
    </div>
    <div class="hs-footer-bottom">
      <p>&copy; 2025 Civilanka Architecture Studio. All rights reserved.</p>
    </div>
  </footer>

  <!-- Back to top -->
  <button id="back-top" aria-label="Back to top">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M4 18 H18 V6" stroke="#111" stroke-width="1.5" />
      <polygon points="14,8 22,8 18,2" fill="#111" />
    </svg>
  </button>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <!-- Main JS -->
  <script src="<?= $BASE ?>/assets/js/main.js"></script>

  <!-- Page-specific JS -->
  <?php foreach ($extraJs as $js): ?>
  <script src="<?= $BASE . '/assets/js/' . htmlspecialchars($js) ?>?v=<?= time() ?>"></script>
  <?php endforeach; ?>
</body>
</html>
