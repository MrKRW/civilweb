<?php
$title     = htmlspecialchars(($item['title'] ?? 'Product') . ' — Civilanka Shop');
$meta      = htmlspecialchars($item['description'] ?? 'Shop product from Civilanka Architecture Studio.');
$pageClass = 'shop-product-page';
$activeNav = 'shop';
$BASE      = '/civilweb';

$imgSrc = !empty($item['image'])
    ? $BASE . '/uploads/shop/' . $item['image']
    : $BASE . '/assets/images/hero_1.png';

$gallery = is_array($item['gallery_images']) ? $item['gallery_images'] : [];
$price   = number_format((float)($item['price'] ?? 0), 2);
$origPrice = !empty($item['original_price']) ? number_format((float)$item['original_price'], 2) : null;
?>

  <!-- PRODUCT DETAIL -->
  <section class="product-detail-section">
    <div class="container">
      <div class="product-detail-grid">

        <!-- Gallery left -->
        <div class="product-gallery">
          <div class="product-main-img">
            <img id="product-main-image" src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" />
          </div>
          <?php if ($gallery): ?>
          <div class="product-thumbnails">
            <img class="product-thumb active" src="<?= $imgSrc ?>" alt="Main"
                 onclick="document.getElementById('product-main-image').src=this.src" />
            <?php foreach ($gallery as $g): ?>
            <img class="product-thumb"
                 src="<?= $BASE ?>/uploads/shop/<?= htmlspecialchars($g) ?>"
                 alt="Gallery image"
                 onclick="document.getElementById('product-main-image').src=this.src" />
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>

        <!-- Info right -->
        <div class="product-info">
          <?php if (!empty($item['category'])): ?>
          <span class="product-category"><?= htmlspecialchars($item['category']) ?></span>
          <?php endif; ?>

          <h1 class="product-title"><?= htmlspecialchars($item['title'] ?? '') ?></h1>

          <div class="product-price-wrap">
            <span class="product-price">$<?= $price ?></span>
            <?php if ($origPrice): ?>
            <span class="product-orig-price">$<?= $origPrice ?></span>
            <?php endif; ?>
          </div>

          <?php if (!empty($item['description'])): ?>
          <div class="product-description">
            <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
          </div>
          <?php endif; ?>

          <div class="product-actions">
            <a href="<?= $BASE ?>/shop" class="btn btn-ghost">← Back to Shop</a>
          </div>
        </div>

      </div>
    </div>
  </section>
