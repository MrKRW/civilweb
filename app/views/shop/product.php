<?php
$title     = htmlspecialchars(($item['title'] ?? 'Product') . ' — Civilanka Shop');
$meta      = htmlspecialchars($item['description'] ?? 'Shop product from Civilanka Architecture Studio.');
$pageClass = 'shop-product-page';
$activeNav = 'shop';
$BASE = defined('BASE_PATH') ? BASE_PATH : (in_array($_SERVER['HTTP_HOST']??'',['localhost','127.0.0.1','::1'])?'/civilweb':'');

$imgSrc = !empty($item['image'])
    ? $BASE . '/uploads/shop/' . $item['image']
    : $BASE . '/assets/images/placeholder.png';

$gallery = is_array($item['gallery_images']) ? $item['gallery_images'] : [];
$price   = number_format((float)($item['price'] ?? 0), 2);
$origPrice = !empty($item['original_price']) ? number_format((float)$item['original_price'], 2) : null;

$categoryStr = !empty($item['category']) ? $item['category'] : 'GEN';
$sku = 'CL-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $categoryStr), 0, 3)) . '-' . $item['id'];


$pid         = (int)($item['id'] ?? 0);
?>

<style>
  /* ── Thumbnail active state ───────────── */
  .product-thumbnails img {
    cursor: pointer;
    transition: opacity 0.2s, outline 0.2s;
    outline: 2px solid transparent;
  }
  .product-thumbnails img.active,
  .product-thumbnails img:hover { opacity: 1; outline: 2px solid #111; }
  .product-thumbnails img:not(.active) { opacity: 0.55; }

  /* ── Main image transition ────────────── */
  .product-main-image img { transition: opacity 0.25s ease; }
  .product-main-image img.fading { opacity: 0; }


</style>

<!-- MAIN PRODUCT SECTION -->
<main id="single-product-main" class="main-below-header" style="padding-bottom: 100px;">
  <div class="container">
    
    <div class="shop-breadcrumb">
      <a href="<?= $BASE ?>/">Home</a> <span class="sep">/</span> <a href="<?= $BASE ?>/shop">Shop</a> <span class="sep">/</span> <span class="current"><?= htmlspecialchars($item['title'] ?? '') ?></span>
    </div>

    <div class="product-single-container">
      <!-- Gallery left -->
      <div class="product-gallery">
        <div class="product-thumbnails" id="product-thumbnails">
          <img src="<?= $imgSrc ?>" alt="Main View" class="active" data-src="<?= $imgSrc ?>" />
          <?php foreach ($gallery as $i => $img): ?>
            <img src="<?= $BASE ?>/uploads/shop/<?= htmlspecialchars($img) ?>" alt="View <?= $i + 2 ?>" data-src="<?= $BASE ?>/uploads/shop/<?= htmlspecialchars($img) ?>" />
          <?php endforeach; ?>
        </div>
        <div class="product-main-image">
          <img id="main-product-img" src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" />
        </div>
      </div>

      <!-- Details right -->
      <div class="product-summary">
        <h1 class="product-single-title"><?= htmlspecialchars($item['title'] ?? '') ?></h1>
        
        <p class="product-single-price">
          <?php if ($origPrice): ?>
            <del style="color:#aaa;font-weight:300;margin-right:8px;">$<?= $origPrice ?></del>
          <?php endif; ?>
          $<?= $price ?>
        </p>
        


        <div class="product-short-desc">
          <p><?= nl2br(htmlspecialchars($item['description'] ?? '')) ?></p>
        </div>

        <form class="product-cart-form" action="#">
          <div class="quantity-selector">
            <input type="number" id="qty" value="1" min="1">
            <div class="qty-btns">
              <button type="button" class="qty-btn plus">+</button>
              <button type="button" class="qty-btn minus">-</button>
            </div>
          </div>
          <button type="button" class="btn btn-dark add-to-cart-btn" style="background:#111;color:#fff;border:none;padding:0 30px;font-family:var(--font-h);font-size:0.85rem;letter-spacing:0.1em;text-transform:uppercase;cursor:pointer;transition:opacity 0.3s;">add to cart</button>
        </form>

        <div class="product-meta">
          <div class="meta-row"><span class="meta-label">SKU</span> <span class="meta-value"><?= $sku ?></span></div>
          <?php if (!empty($item['category'])): ?>
            <div class="meta-row"><span class="meta-label">CATEGORY</span> <span class="meta-value"><?= htmlspecialchars(strtoupper($item['category'])) ?></span></div>
          <?php endif; ?>
        </div>

        <div class="product-share">
          <a href="#" aria-label="Share">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Product Tabs -->
    <div class="product-tabs-section">
      <div class="product-tabs-nav">
        <button class="tab-link active" data-tab="desc">Description</button>
        <button class="tab-link" data-tab="info">Additional information</button>

      </div>
      <div class="product-tabs-content">
        <div id="tab-desc" class="tab-pane active">
          <p><?= nl2br(htmlspecialchars($item['description'] ?? 'No description available.')) ?></p>
        </div>
        <div id="tab-info" class="tab-pane">
          <p>
            Category: <?= htmlspecialchars($item['category'] ?? 'General') ?><br>
            SKU: <?= $sku ?><br>
            Price: $<?= $price ?>
          </p>
        </div>


      </div>
    </div>

    <!-- Related Products -->
    <div class="related-products-section">
      <div class="related-header">
        <h2>Related products</h2>
        <div class="related-nav">
          <button class="related-prev">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="11"/><path d="M14 8l-4 4 4 4"/></svg>
          </button>
          <button class="related-next">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="11"/><path d="M10 8l4 4-4 4"/></svg>
          </button>
        </div>
      </div>
      <div class="shop-grid" id="related-products-grid">
        <p style="color:#888;font-family:var(--font-h);">Loading related products…</p>
      </div>
    </div>

  </div>
</main>

<script>
(function () {
  const BASE = '<?= $BASE ?>';
  const PRODUCT_ID = <?= $pid ?>;

  /* ── Thumbnail switcher ──────────── */
  const mainImg    = document.getElementById('main-product-img');
  const thumbnails = document.querySelectorAll('#product-thumbnails img');
  thumbnails.forEach(thumb => {
    thumb.addEventListener('click', () => {
      thumbnails.forEach(t => t.classList.remove('active'));
      thumb.classList.add('active');
      if (mainImg) {
        mainImg.classList.add('fading');
        setTimeout(() => { mainImg.src = thumb.dataset.src; mainImg.classList.remove('fading'); }, 220);
      }
    });
  });

  /* ── Quantity ─────────────────────── */
  const qtyInput = document.getElementById('qty');
  if (qtyInput) {
    document.querySelector('.qty-btn.plus')?.addEventListener('click', () => qtyInput.value = +qtyInput.value + 1);
    document.querySelector('.qty-btn.minus')?.addEventListener('click', () => { if (+qtyInput.value > 1) qtyInput.value = +qtyInput.value - 1; });
  }

  /* ── Tabs ─────────────────────────── */
  document.querySelectorAll('.tab-link').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-link').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      const pane = document.getElementById('tab-' + btn.dataset.tab);
      if (pane) pane.classList.add('active');
    });
  });



  /* ── Load related products ────────── */
  const relatedGrid = document.getElementById('related-products-grid');
  if (relatedGrid) {
    fetch(BASE + '/api/shop?action=list')
      .then(res => res.json())
      .then(data => {
        const others = (data.items || [])
          .filter(i => i.status === 'published' && parseInt(i.id) !== PRODUCT_ID)
          .slice(0, 4);
        if (others.length === 0) {
          relatedGrid.innerHTML = '<p style="color:#888;font-family:var(--font-h);grid-column:1/-1;">No related products found.</p>';
          return;
        }
        relatedGrid.innerHTML = others.map(item => {
          const imgPath = item.image ? `${BASE}/uploads/shop/${item.image}` : `${BASE}/Project images/placeholder.png`;
          const priceHtml = (item.original_price && parseFloat(item.original_price) > parseFloat(item.price))
            ? `<p class="product-price"><del>$${Number(item.original_price).toFixed(2)}</del> <span>$${Number(item.price).toFixed(2)}</span></p>`
            : `<p class="product-price"><span>$${Number(item.price).toFixed(2)}</span></p>`;
          return `
            <div class="product-card">
              <div class="product-image">
                <img src="${imgPath}" alt="${escapeHtml(item.title)}">
                <div class="product-overlay"><button class="add-to-cart">+ add to cart</button></div>
              </div>
              <div class="product-info">
                <h4 class="product-title"><a href="${BASE}/shop/product/${item.id}">${escapeHtml(item.title)}</a></h4>
                <div class="price-wrap">${priceHtml}</div>
              </div>
            </div>`;
        }).join('');
      })
      .catch(() => {
        relatedGrid.innerHTML = '<p style="color:#888;font-family:var(--font-h);">Could not load related products.</p>';
      });
  }

  function escapeHtml(str) {
    if (!str) return '';
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
  }


})();
</script>
