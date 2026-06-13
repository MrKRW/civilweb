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

  /* ══════════════════════════════════════════
     PERSONALIZED HELP MODAL
  ══════════════════════════════════════════ */
  .plh-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
  }
  .plh-overlay.open {
    opacity: 1;
    pointer-events: all;
  }
  .plh-modal {
    background: #fff;
    width: 100%;
    max-width: 420px;
    max-height: 90vh;
    overflow-y: auto;
    border-radius: 4px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    transform: translateY(24px) scale(0.97);
    transition: transform 0.35s cubic-bezier(.22,.68,0,1.2), opacity 0.3s;
    opacity: 0;
  }
  .plh-overlay.open .plh-modal {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  .plh-header {
    background: #4a3728;
    color: #fff;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
  }
  .plh-header-icon {
    width: 32px;
    height: 32px;
    border: 2px solid rgba(255,255,255,0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    flex-shrink: 0;
  }
  .plh-header h3 {
    font-family: var(--font-h);
    font-size: 1.05rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    margin: 0;
  }
  .plh-close {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: rgba(255,255,255,0.8);
    font-size: 1.4rem;
    cursor: pointer;
    line-height: 1;
    padding: 4px 6px;
    transition: color 0.2s;
  }
  .plh-close:hover { color: #fff; }
  .plh-body {
    padding: 20px 22px;
  }
  .plh-row {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
  }
  .plh-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
    margin-bottom: 12px;
  }
  .plh-field label {
    font-family: var(--font-b);
    font-size: 0.8rem;
    color: #333;
    font-weight: 500;
  }
  .plh-field label .req { color: #c0392b; margin-left: 2px; }
  .plh-field input,
  .plh-field select,
  .plh-field textarea {
    font-family: var(--font-b);
    font-size: 0.88rem;
    color: #333;
    border: 1px solid #ccc;
    padding: 9px 12px;
    outline: none;
    width: 100%;
    box-sizing: border-box;
    background: #fff;
    transition: border-color 0.2s;
    border-radius: 2px;
  }
  .plh-field input::placeholder { color: #aaa; }
  .plh-field input:focus,
  .plh-field select:focus,
  .plh-field textarea:focus { border-color: #4a3728; }
  .plh-field textarea {
    resize: vertical;
    min-height: 100px;
  }
  .plh-field select { appearance: auto; }
  .plh-checkbox-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
  }
  .plh-checkbox-row input[type="checkbox"] {
    width: 15px;
    height: 15px;
    flex-shrink: 0;
    accent-color: #4a3728;
    cursor: pointer;
  }
  .plh-checkbox-row label {
    font-family: var(--font-b);
    font-size: 0.85rem;
    color: #444;
    cursor: pointer;
  }
  .plh-send-btn {
    display: block;
    width: 100%;
    background: #6b3f7a;
    color: #fff;
    text-align: center;
    padding: 15px;
    font-family: var(--font-h);
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: none;
    border-radius: 2px;
    cursor: pointer;
    transition: background 0.3s;
    margin-bottom: 20px;
  }
  .plh-send-btn:hover { background: #5a2f69; }
  .plh-send-btn:disabled { background: #aaa; cursor: not-allowed; }
  .plh-footer {
    border-top: 1px solid #eee;
    padding: 16px 22px;
    background: #fafafa;
  }
  .plh-footer p {
    font-family: var(--font-b);
    font-size: 0.8rem;
    color: #444;
    line-height: 1.6;
    margin-bottom: 8px;
  }
  .plh-footer strong { color: #222; }
  .plh-footer a { color: #c0392b; text-decoration: none; }
  .plh-footer a:hover { text-decoration: underline; }
  .plh-success {
    display: none;
    text-align: center;
    padding: 30px 22px;
  }
  .plh-success svg { margin-bottom: 16px; }
  .plh-success h4 {
    font-family: var(--font-h);
    font-size: 1.1rem;
    color: #2d7a2d;
    margin-bottom: 8px;
  }
  .plh-success p {
    font-family: var(--font-b);
    font-size: 0.9rem;
    color: #555;
  }
  @media (max-width: 480px) {
    .plh-row { flex-direction: column; gap: 0; }
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
        


        <div class="product-short-desc">
          <div><?= strip_tags($item['description'] ?? '', '<p><br><strong><b><i><em><ul><ol><li>') ?></div>
        </div>

        <?php
          $hasSpecs = !empty($item['spec_sqft']) || !empty($item['spec_beds']) || !empty($item['spec_baths']) || !empty($item['spec_floors']) || !empty($item['spec_garages']);
        ?>
        <?php if ($hasSpecs): ?>
          <div class="product-key-specs">
            <h3 class="key-specs-title">KEY SPECS</h3>
            <div class="key-specs-grid">
              <?php if (!empty($item['spec_sqft'])): ?>
                <div class="spec-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M3 9h18M9 21V9"/><circle cx="14" cy="14" r="2"/></svg>
                  <span class="spec-val"><?= htmlspecialchars($item['spec_sqft']) ?></span>
                  <span class="spec-label">sq ft</span>
                </div>
              <?php endif; ?>
              
              <?php if (!empty($item['spec_beds'])): ?>
                <div class="spec-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 12h18M3 12v6M21 12v6M4 12V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4M6 12a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm12 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                  <span class="spec-val"><?= htmlspecialchars($item['spec_beds']) ?></span>
                  <span class="spec-label">Beds</span>
                </div>
              <?php endif; ?>

              <?php if (!empty($item['spec_baths'])): ?>
                <div class="spec-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 12v5a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-5M2 12h20M7 12V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6"/><path d="M10 6v-2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/></svg>
                  <span class="spec-val"><?= htmlspecialchars($item['spec_baths']) ?></span>
                  <span class="spec-label">Baths</span>
                </div>
              <?php endif; ?>

              <?php if (!empty($item['spec_floors'])): ?>
                <div class="spec-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 10l9-7 9 7v11H3V10z"/><path d="M3 14h18"/></svg>
                  <span class="spec-val"><?= htmlspecialchars($item['spec_floors']) ?></span>
                  <span class="spec-label">Floors</span>
                </div>
              <?php endif; ?>

              <?php if (!empty($item['spec_garages'])): ?>
                <div class="spec-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 10l9-7 9 7v11H3V10z"/><path d="M8 21v-5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v5"/><path d="M10 16h4"/></svg>
                  <span class="spec-val"><?= htmlspecialchars($item['spec_garages']) ?></span>
                  <span class="spec-label">Garages</span>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>



        <!-- Customization Box -->
        <div class="plan-customize-box">
          <p class="pcb-title">This plan can be customized</p>
          <p class="pcb-desc">Tell us about your desired changes so we can prepare an estimate for the design service. Click the button to submit your request for pricing, or call <strong>1-877-803-2251</strong> for assistance.</p>
          <button type="button" class="pcb-btn" id="modify-plan-btn">MODIFY THIS PLAN</button>
        </div>

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
          <div class="desc-content"><?= !empty($item['description']) ? $item['description'] : '<p>No description available.</p>' ?></div>
        </div>
        <div id="tab-info" class="tab-pane">
          <?php
            $addlInfo   = $item['additional_info'] ?? '';
            $addlImages = is_array($item['additional_info_images']) ? $item['additional_info_images'] : [];
          ?>
          <?php if (!empty($addlInfo)): ?>
            <div class="addl-info-content"><?= $addlInfo ?></div>
          <?php else: ?>
            <p>
              Category: <?= htmlspecialchars($item['category'] ?? 'General') ?><br>
              SKU: <?= $sku ?><br>
              Price: $<?= $price ?>
            </p>
          <?php endif; ?>

          <?php if (!empty($addlImages)): ?>
            <div class="addl-info-images">
              <?php foreach ($addlImages as $aImg): ?>
                <div class="addl-info-img-item">
                  <img src="<?= $BASE ?>/uploads/shop/<?= htmlspecialchars($aImg) ?>" alt="Additional info image" loading="lazy" />
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <div class="plan-included-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; margin-top: 2rem; margin-bottom: 2rem;">
            <!-- What's Included -->
            <div class="plan-included-section">
              <h3 style="font-size: 1.6rem; font-family: var(--font-h, serif); color: #333; margin-bottom: 0.8rem; font-weight: 500;">What's Included</h3>
              <p style="margin-bottom: 1.5rem; color: #555;">Most plan sets include the following:</p>
              <ul style="list-style-type: none; padding: 0; color: #444; line-height: 1.6;">
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Floor Plans:</strong> Floor plan drawings indicating dimensions for construction
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Roof Plan:</strong> Drawings indicating roof slopes and unique conditions
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Exterior Elevations:</strong> Drawings showing appearance and the types of materials used for the exterior finish and trim
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Building Sections:</strong> Drawings cut through important locations in the structure
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Construction Details:</strong> Drawings showing specific construction of building elements at a large scale
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Electrical Plans:</strong> Basic electrical layout (suggested locations of fixtures, switches, and outlets)
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Foundation Plan:</strong> Dimensioned drawings describing specific foundation conditions for the structure
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>A building license:</strong> A single-use license for construction at one location only
                </li>
                <li style="margin-bottom: 1rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #2e8b57;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                  <strong>Our plans are designed to meet national building codes</strong>
                </li>
              </ul>
            </div>

            <!-- What's Not Included -->
            <div class="plan-not-included-section">
              <h3 style="font-size: 1.6rem; font-family: var(--font-h, serif); color: #333; margin-bottom: 0.8rem; font-weight: 500;">What's Not Included</h3>
              <p style="margin-bottom: 1.5rem; color: #555;">These items are <u>NOT</u> included:</p>
              <ul style="list-style-type: none; padding: 0; color: #444; line-height: 1.6;">
                <li style="margin-bottom: 1.5rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #d9534f;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                  We do not guarantee our plans will meet all local building requirements or building codes influenced by local geographic or climatic factors. It is the responsibility of the owner or builder to ensure these plans comply with city, county, municipal, and/or state/provincial building codes.
                </li>
                <li style="margin-bottom: 1.5rem; position: relative; padding-left: 2rem;">
                  <svg style="position: absolute; left: 0; top: 4px; color: #d9534f;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                  Your plans will not be sealed or stamped by an engineer or architect. It is the owner's (or builder's) responsibility to hire a local professional to review and seal or stamp the plans if required by the building department. This must be handled by an engineer or architect licensed in the state/province where the plan is to be built.
                </li>
              </ul>
              
              <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee;">
                <p>
                  <a href="javascript:void(0);" id="open-important-info" style="color: #5b8db5; text-decoration: none; font-size: 0.95rem; font-weight: 500;">&raquo; See important information before purchasing.</a>
                </p>
              </div>
            </div>
          </div>
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

<!-- ══ PERSONALIZED HELP MODAL ══ -->
<div class="plh-overlay" id="plh-overlay" role="dialog" aria-modal="true" aria-labelledby="plh-title">
  <div class="plh-modal" id="plh-modal">

    <!-- Header -->
    <div class="plh-header">
      <div class="plh-header-icon">?</div>
      <h3 id="plh-title">Get Personalized Help</h3>
      <button class="plh-close" id="plh-close" aria-label="Close modal">&#x2715;</button>
    </div>

    <!-- Form -->
    <form class="plh-body" id="plh-form" novalidate>

      <!-- Name row -->
      <div class="plh-row">
        <div class="plh-field" style="margin-bottom:0">
          <input type="text" name="first_name" placeholder="First Name" required />
        </div>
        <div class="plh-field" style="margin-bottom:0">
          <input type="text" name="last_name" placeholder="Last Name" required />
        </div>
      </div>

      <!-- Contact row -->
      <div class="plh-row" style="margin-top:12px">
        <div class="plh-field" style="margin-bottom:0">
          <input type="email" name="email" placeholder="Email" required />
        </div>
        <div class="plh-field" style="margin-bottom:0">
          <input type="tel" name="phone" placeholder="Phone" />
        </div>
      </div>

      <!-- Construction start -->
      <div class="plh-field" style="margin-top:12px">
        <label>When do you want to start construction?</label>
        <select name="start_construction">
          <option value="">- Select -</option>
          <option>As soon as possible</option>
          <option>Within 6 months</option>
          <option>6 – 12 months</option>
          <option>1 – 2 years</option>
          <option>More than 2 years</option>
          <option>Just researching</option>
        </select>
      </div>

      <!-- Lot -->
      <div class="plh-field">
        <label>Do you have a lot?</label>
        <select name="have_lot">
          <option value="">- Select -</option>
          <option>Yes</option>
          <option>No</option>
          <option>Currently looking</option>
        </select>
      </div>

      <!-- Builder -->
      <div class="plh-field">
        <label>Are you working with a builder?</label>
        <select name="have_builder">
          <option value="">- Select -</option>
          <option>Yes</option>
          <option>No</option>
          <option>Still searching</option>
        </select>
      </div>

      <!-- Country / State -->
      <div class="plh-field">
        <label>Where do you plan on building? <span class="req">*</span></label>
        <select name="country" required style="margin-bottom:8px">
          <option value="">- Country -</option>
          <option>Sri Lanka</option>
          <option>United States</option>
          <option>Canada</option>
          <option>Australia</option>
          <option>United Kingdom</option>
          <option>India</option>
          <option>Other</option>
        </select>
        <select name="state">
          <option value="">- State / Province -</option>
          <option>Western Province</option>
          <option>Central Province</option>
          <option>Southern Province</option>
          <option>Northern Province</option>
          <option>Eastern Province</option>
          <option>North Western Province</option>
          <option>North Central Province</option>
          <option>Uva Province</option>
          <option>Sabaragamuwa Province</option>
          <option>Other</option>
        </select>
      </div>

      <!-- Questions -->
      <div class="plh-field">
        <label>Please enter your question(s) <span class="req">*</span></label>
        <textarea name="questions" placeholder="Type your message here…" required></textarea>
      </div>

      <!-- Newsletter -->
      <div class="plh-checkbox-row">
        <input type="checkbox" id="plh-newsletter" name="newsletter" />
        <label for="plh-newsletter">Send me your Newsletter, too!</label>
      </div>

      <!-- Submit -->
      <button type="submit" class="plh-send-btn" id="plh-send">SEND MESSAGE</button>

    </form>

    <!-- Success state -->
    <div class="plh-success" id="plh-success">
      <svg width="56" height="56" viewBox="0 0 56 56" fill="none">
        <circle cx="28" cy="28" r="28" fill="#e8f5e9"/>
        <path d="M16 28l8 8 16-16" stroke="#2d7a2d" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <h4>Message Sent!</h4>
      <p>We'll get back to you within 24 – 48 business hours.</p>
    </div>

    <!-- Footer info -->
    <div class="plh-footer">
      <p><strong>We do our best to get back to you within 24 – 48 business hours.</strong></p>
      <p>Need an answer faster? Call now…<br>
        Phone: <a href="tel:18778032251">1-877-803-2251</a></p>
      <p><strong>Hours:</strong><br>
        Ready for Your Call 7 Days a Week<br>
        Every Day 7 am – 8:30 pm Eastern</p>
    </div>

  </div>
</div>

<!-- ══ IMPORTANT INFO MODAL ══ -->
<div class="plh-overlay" id="important-info-overlay" role="dialog" aria-modal="true" aria-labelledby="important-info-title">
  <div class="plh-modal" id="important-info-modal">
    <!-- Header -->
    <div class="plh-header" style="background: #fff; color: #333; border-bottom: 1px solid #eee;">
      <h3 id="important-info-title" style="font-size: 1.15rem; color: #333; margin: 0; padding-left: 0;">Important Information</h3>
      <button class="plh-close" id="important-info-close" aria-label="Close modal" style="color: #666;">&#x2715;</button>
    </div>
    <!-- Body -->
    <div class="plh-body" style="padding: 24px; color: #333; line-height: 1.6; font-size: 0.95rem;">
      <p style="margin-bottom: 16px;"><strong>IMPORTANT NOTE</strong></p>
      <p style="margin-bottom: 16px;">Plan content may vary depending on the design, building type, and selected package. Standard plans are for design review, pricing, and project understanding only.</p>
      <p style="margin-bottom: 16px;">Local code compliance, permit drawings, engineering, and site-specific changes must be checked by the relevant professionals or authorities before construction.</p>
      <p style="margin-bottom: 0;">Need changes or permit drawings? <a href="<?= $BASE ?>/contact" style="color: #5b8db5; text-decoration: underline;">Contact us to modify this plan</a></p>
      <div style="margin-top: 24px; text-align: center;">
        <button type="button" id="important-info-close-btn" style="background: #9d8c14; color: #fff; border: none; padding: 10px 24px; font-family: var(--font-h, sans-serif); font-size: 0.9rem; font-weight: 500; cursor: pointer; border-radius: 2px;">Close</button>
      </div>
    </div>
  </div>
</div>

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
  const qtyInput   = document.getElementById('qty');
  const qtyDisplay = document.getElementById('qty-display');
  function updateQtyDisplay() {
    if (qtyDisplay) qtyDisplay.textContent = qtyInput.value;
  }
  document.getElementById('qty-plus')?.addEventListener('click', () => {
    qtyInput.value = +qtyInput.value + 1;
    updateQtyDisplay();
  });
  document.getElementById('qty-minus')?.addEventListener('click', () => {
    if (+qtyInput.value > 1) { qtyInput.value = +qtyInput.value - 1; updateQtyDisplay(); }
  });

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
              </div>
              <div class="product-info">
                <h4 class="product-title"><a href="${BASE}/shop/product/${item.id}">${escapeHtml(item.title)}</a></h4>
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

  /* ── Personalized Help Modal ─────────── */
  const plhOverlay = document.getElementById('plh-overlay');
  const plhModal   = document.getElementById('plh-modal');
  const plhForm    = document.getElementById('plh-form');
  const plhSuccess = document.getElementById('plh-success');

  function openPlhModal() {
    plhOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    // reset to form view
    plhForm.style.display = '';
    plhSuccess.style.display = 'none';
  }

  function closePlhModal() {
    plhOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.getElementById('modify-plan-btn')?.addEventListener('click', openPlhModal);
  document.getElementById('plh-close')?.addEventListener('click', closePlhModal);

  // Close on backdrop click
  plhOverlay?.addEventListener('click', (e) => {
    if (e.target === plhOverlay) closePlhModal();
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && plhOverlay?.classList.contains('open')) closePlhModal();
  });

  // Form submission
  plhForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const required = plhForm.querySelectorAll('[required]');
    let valid = true;
    required.forEach(el => {
      el.style.borderColor = '';
      if (!el.value.trim()) {
        el.style.borderColor = '#c0392b';
        valid = false;
      }
    });
    if (!valid) return;

    const sendBtn = document.getElementById('plh-send');
    sendBtn.disabled = true;
    sendBtn.textContent = 'Sending…';

    // Collect form data
    const data = new FormData(plhForm);
    data.append('product_id', '<?= $pid ?>');
    data.append('product_title', '<?= addslashes(htmlspecialchars($item['title'] ?? '')) ?>');

    // POST to contact endpoint (gracefully falls back to success state)
    fetch('<?= $BASE ?>/api/contact', {
      method: 'POST',
      body: data
    })
    .catch(() => {})
    .finally(() => {
      plhForm.style.display = 'none';
      plhSuccess.style.display = 'block';
      sendBtn.disabled = false;
      sendBtn.textContent = 'SEND MESSAGE';
      // auto-close after 3 s
      setTimeout(closePlhModal, 3000);
    });
  });

  /* ── Important Info Modal ─────────── */
  const iiOverlay = document.getElementById('important-info-overlay');
  
  function openIiModal() {
    iiOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeIiModal() {
    iiOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.getElementById('open-important-info')?.addEventListener('click', (e) => {
    e.preventDefault();
    openIiModal();
  });

  document.getElementById('important-info-close')?.addEventListener('click', closeIiModal);
  document.getElementById('important-info-close-btn')?.addEventListener('click', closeIiModal);

  iiOverlay?.addEventListener('click', (e) => {
    if (e.target === iiOverlay) closeIiModal();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && iiOverlay?.classList.contains('open')) closeIiModal();
  });

})();
</script>
