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

$reviews     = $reviews     ?? [];
$reviewCount = $reviewCount ?? 0;
$avgRating   = $avgRating   ?? 0.0;
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

  /* ── Reviews Tab ──────────────────────── */
  .reviews-section { padding: 0 0 40px; }

  /* existing reviews list */
  .reviews-list { display: flex; flex-direction: column; gap: 24px; margin-bottom: 40px; }
  .review-item {
    border: 1px solid #e8e8e8;
    border-radius: 12px;
    padding: 22px 26px;
    background: #fafafa;
    transition: box-shadow 0.2s;
  }
  .review-item:hover { box-shadow: 0 4px 18px rgba(0,0,0,0.07); }
  .review-item-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 10px;
  }
  .review-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: #111;
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-h);
    font-size: 0.95rem;
    font-weight: 600;
    flex-shrink: 0;
    text-transform: uppercase;
  }
  .review-meta { flex: 1; }
  .review-author {
    font-family: var(--font-h);
    font-size: 0.92rem;
    font-weight: 600;
    color: #111;
    margin: 0 0 2px;
  }
  .review-date {
    font-size: 0.78rem;
    color: #999;
    font-family: var(--font-h);
  }
  .review-stars { color: #d4af37; font-size: 1rem; letter-spacing: 1px; }
  .review-stars .empty-star { color: #ddd; }
  .review-body { font-size: 0.93rem; color: #444; line-height: 1.7; margin: 8px 0 0; }

  .no-reviews-msg {
    padding: 28px;
    text-align: center;
    color: #999;
    font-family: var(--font-h);
    font-size: 0.9rem;
    border: 1px dashed #ddd;
    border-radius: 12px;
    margin-bottom: 36px;
  }

  /* ── Review Summary bar ─────────────── */
  .review-summary-bar {
    display: flex; align-items: center; gap: 18px;
    padding: 20px 26px;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 12px;
    margin-bottom: 32px;
  }
  .review-avg-score {
    font-family: var(--font-h);
    font-size: 2.8rem;
    font-weight: 700;
    color: #111;
    line-height: 1;
  }
  .review-avg-detail { display: flex; flex-direction: column; gap: 4px; }
  .review-avg-stars { color: #d4af37; font-size: 1.1rem; }
  .review-avg-label { font-size: 0.8rem; color: #888; font-family: var(--font-h); }

  /* ── Write a Review Form ────────────── */
  .review-form-section {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 14px;
    padding: 32px 30px;
    margin-top: 8px;
  }
  .review-form-title {
    font-family: var(--font-h);
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin: 0 0 6px;
    color: #111;
  }
  .review-form-subtitle {
    font-size: 0.82rem;
    color: #999;
    margin: 0 0 24px;
  }

  /* Star picker */
  .star-rating-picker { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 4px; margin-bottom: 20px; }
  .star-rating-picker input { display: none; }
  .star-rating-picker label {
    font-size: 1.6rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.15s;
  }
  .star-rating-picker label:hover,
  .star-rating-picker label:hover ~ label,
  .star-rating-picker input:checked ~ label { color: #d4af37; }

  .review-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
  }
  @media (max-width: 600px) { .review-form-grid { grid-template-columns: 1fr; } }

  .review-field { display: flex; flex-direction: column; gap: 6px; }
  .review-field label {
    font-family: var(--font-h);
    font-size: 0.75rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #555;
    font-weight: 600;
  }
  .review-field input,
  .review-field textarea {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 11px 14px;
    font-size: 0.9rem;
    font-family: inherit;
    color: #111;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fafafa;
    resize: vertical;
  }
  .review-field input:focus,
  .review-field textarea:focus {
    border-color: #111;
    box-shadow: 0 0 0 3px rgba(17,17,17,0.06);
    background: #fff;
  }
  .review-field textarea { min-height: 110px; }

  .review-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #111;
    color: #fff;
    border: none;
    padding: 13px 32px;
    font-family: var(--font-h);
    font-size: 0.82rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    border-radius: 8px;
    margin-top: 6px;
    transition: background 0.2s, transform 0.15s;
  }
  .review-submit-btn:hover { background: #333; transform: translateY(-1px); }
  .review-submit-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

  .review-form-msg {
    margin-top: 14px;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.88rem;
    display: none;
  }
  .review-form-msg.success { background: #f0fff4; color: #1a7a3a; border: 1px solid #b2e8c4; display: block; }
  .review-form-msg.error   { background: #fff5f5; color: #c0392b; border: 1px solid #f5c6cb; display: block; }

  /* Rating label display */
  .rating-label-display {
    font-size: 0.82rem;
    color: #d4af37;
    font-family: var(--font-h);
    font-weight: 600;
    letter-spacing: 0.05em;
    min-height: 1.2em;
    margin-bottom: 4px;
  }
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
        
        <div class="product-rating">
          <?php
            $fullStars  = (int) round($avgRating);
            $starHtml   = str_repeat('★', $fullStars) . str_repeat('☆', 5 - $fullStars);
          ?>
          <span class="stars" style="color:#d4af37;"><?= $starHtml ?></span>
          <span class="review-count" id="header-review-count"><?= $reviewCount ?> review<?= $reviewCount !== 1 ? 's' : '' ?></span>
        </div>

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
        <button class="tab-link" data-tab="reviews" id="reviews-tab-btn">Reviews (<span id="tab-review-count"><?= $reviewCount ?></span>)</button>
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

        <!-- ── REVIEWS TAB ── -->
        <div id="tab-reviews" class="tab-pane reviews-section">

          <!-- Rating summary bar (only shown if there are reviews) -->
          <?php if ($reviewCount > 0): ?>
          <div class="review-summary-bar">
            <div class="review-avg-score"><?= number_format($avgRating, 1) ?></div>
            <div class="review-avg-detail">
              <div class="review-avg-stars">
                <?php
                  $full  = (int) round($avgRating);
                  echo str_repeat('★', $full) . str_repeat('☆', 5 - $full);
                ?>
              </div>
              <div class="review-avg-label">Based on <?= $reviewCount ?> review<?= $reviewCount !== 1 ? 's' : '' ?></div>
            </div>
          </div>
          <?php endif; ?>

          <!-- Reviews list -->
          <div class="reviews-list" id="reviews-list">
            <?php if (empty($reviews)): ?>
              <div class="no-reviews-msg" id="no-reviews-placeholder">
                ✦ &nbsp;There are no reviews yet. Be the first to leave a review!
              </div>
            <?php else: ?>
              <?php foreach ($reviews as $r): 
                $initials = strtoupper(substr(trim($r['reviewer_name']), 0, 1));
                $ratingFull = (int) $r['rating'];
                $starStr = str_repeat('★', $ratingFull) . str_repeat('☆', 5 - $ratingFull);
                $dateStr = date('M d, Y', strtotime($r['created_at']));
              ?>
              <div class="review-item">
                <div class="review-item-header">
                  <div class="review-avatar"><?= htmlspecialchars($initials) ?></div>
                  <div class="review-meta">
                    <p class="review-author"><?= htmlspecialchars($r['reviewer_name']) ?></p>
                    <p class="review-date"><?= $dateStr ?></p>
                  </div>
                  <div class="review-stars"><?= $starStr ?></div>
                </div>
                <p class="review-body"><?= nl2br(htmlspecialchars($r['review_text'])) ?></p>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <!-- Write a Review form -->
          <div class="review-form-section">
            <p class="review-form-title">Write a Review</p>
            <p class="review-form-subtitle">Your email address will not be published. Required fields are marked *</p>

            <p style="font-family:var(--font-h);font-size:0.75rem;letter-spacing:0.1em;text-transform:uppercase;color:#555;font-weight:600;margin:0 0 6px;">Your Rating *</p>
            <div class="star-rating-picker" id="star-picker">
              <input type="radio" id="star5" name="rating" value="5">
              <label for="star5" title="5 stars">★</label>
              <input type="radio" id="star4" name="rating" value="4">
              <label for="star4" title="4 stars">★</label>
              <input type="radio" id="star3" name="rating" value="3">
              <label for="star3" title="3 stars">★</label>
              <input type="radio" id="star2" name="rating" value="2">
              <label for="star2" title="2 stars">★</label>
              <input type="radio" id="star1" name="rating" value="1">
              <label for="star1" title="1 star">★</label>
            </div>
            <div class="rating-label-display" id="rating-label-display"></div>

            <div class="review-form-grid">
              <div class="review-field">
                <label for="review-name">Name *</label>
                <input type="text" id="review-name" placeholder="Your name" autocomplete="name">
              </div>
              <div class="review-field">
                <label for="review-email">Email *</label>
                <input type="email" id="review-email" placeholder="your@email.com" autocomplete="email">
              </div>
            </div>
            <div class="review-field" style="margin-bottom:20px;">
              <label for="review-text">Your Review *</label>
              <textarea id="review-text" placeholder="Share your thoughts about this product…"></textarea>
            </div>

            <button class="review-submit-btn" id="review-submit-btn">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
              Submit Review
            </button>
            <div class="review-form-msg" id="review-form-msg"></div>
          </div>

        </div><!-- /tab-reviews -->
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

  /* ── Star picker label ────────────── */
  const ratingLabels = {1:'Poor',2:'Fair',3:'Good',4:'Very Good',5:'Excellent'};
  const labelDisplay = document.getElementById('rating-label-display');
  document.querySelectorAll('#star-picker input[type=radio]').forEach(radio => {
    radio.addEventListener('change', () => {
      if (labelDisplay) labelDisplay.textContent = ratingLabels[radio.value] || '';
    });
  });

  /* ── Submit review ────────────────── */
  const submitBtn = document.getElementById('review-submit-btn');
  const formMsg   = document.getElementById('review-form-msg');
  const reviewsList = document.getElementById('reviews-list');

  function showMsg(text, type) {
    formMsg.textContent = text;
    formMsg.className = 'review-form-msg ' + type;
  }

  function buildReviewHtml(r) {
    const initials = (r.reviewer_name || '?').trim().charAt(0).toUpperCase();
    const stars = '★'.repeat(r.rating) + '☆'.repeat(5 - r.rating);
    const date  = new Date(r.created_at).toLocaleDateString('en-US', {year:'numeric',month:'short',day:'numeric'});
    const body  = escapeHtml(r.review_text).replace(/\n/g, '<br>');
    return `
      <div class="review-item" style="animation:fadeIn 0.4s ease;">
        <div class="review-item-header">
          <div class="review-avatar">${escapeHtml(initials)}</div>
          <div class="review-meta">
            <p class="review-author">${escapeHtml(r.reviewer_name)}</p>
            <p class="review-date">${date}</p>
          </div>
          <div class="review-stars">${stars}</div>
        </div>
        <p class="review-body">${body}</p>
      </div>`;
  }

  if (submitBtn) {
    submitBtn.addEventListener('click', async () => {
      const name   = document.getElementById('review-name')?.value.trim();
      const email  = document.getElementById('review-email')?.value.trim();
      const text   = document.getElementById('review-text')?.value.trim();
      const ratingEl = document.querySelector('#star-picker input[name=rating]:checked');
      const rating = ratingEl ? parseInt(ratingEl.value) : 0;

      formMsg.className = 'review-form-msg';

      if (!name)   return showMsg('Please enter your name.', 'error');
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return showMsg('Please enter a valid email.', 'error');
      if (!rating) return showMsg('Please select a star rating.', 'error');
      if (text.length < 10) return showMsg('Your review must be at least 10 characters.', 'error');

      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting…';

      const fd = new FormData();
      fd.append('product_id', PRODUCT_ID);
      fd.append('name', name);
      fd.append('email', email);
      fd.append('rating', rating);
      fd.append('review_text', text);

      try {
        const res  = await fetch(BASE + '/api/shop?action=add_review', { method: 'POST', body: fd });
        const data = await res.json();
        if (!res.ok || data.error) throw new Error(data.error || 'Failed to submit review.');

        showMsg('✓ Thank you! Your review has been posted.', 'success');

        // Prepend new review into list
        const placeholder = document.getElementById('no-reviews-placeholder');
        if (placeholder) placeholder.remove();

        const now = new Date().toISOString();
        reviewsList.insertAdjacentHTML('afterbegin', buildReviewHtml({
          reviewer_name: name, rating, review_text: text, created_at: now
        }));

        // Update counts
        const tabCount   = document.getElementById('tab-review-count');
        const headCount  = document.getElementById('header-review-count');
        const current    = parseInt(tabCount?.textContent || '0') + 1;
        if (tabCount)  tabCount.textContent  = current;
        if (headCount) headCount.textContent = current + ' review' + (current !== 1 ? 's' : '');

        // Reset form
        document.getElementById('review-name').value  = '';
        document.getElementById('review-email').value = '';
        document.getElementById('review-text').value  = '';
        document.querySelectorAll('#star-picker input').forEach(r => r.checked = false);
        if (labelDisplay) labelDisplay.textContent = '';

      } catch (err) {
        showMsg(err.message, 'error');
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg> Submit Review';
      }
    });
  }

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

  /* fade-in animation for new review */
  const style = document.createElement('style');
  style.textContent = '@keyframes fadeIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }';
  document.head.appendChild(style);
})();
</script>
