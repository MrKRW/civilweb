<?php
$BASE = '';
$adminName = $adminName ?? 'Admin';
$adminUser = $adminUser ?? 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — CivilLanka Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= $BASE ?>/admin/assets/css/admin.css?v=1.1" />
  <script>
    // Make BASE available to admin.js
    const API_BASE = "<?= $BASE ?>";
  </script>
</head>
<body>

  <!-- ═══════════════════════════════════════════
       SIDEBAR
  ═══════════════════════════════════════════ -->
  <aside id="sidebar">
    <div class="sidebar-top">
      <a href="<?= $BASE ?>/" class="sidebar-logo" target="_blank">
        <img src="<?= $BASE ?>/Logos/trans.PNG" alt="CivilLanka" />
      </a>
      <span class="sidebar-badge">Admin</span>
    </div>

    <nav class="sidebar-nav">
      <a href="#" class="nav-item active" data-page="dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
        <span>Dashboard</span>
      </a>
      <a href="#" class="nav-item" data-page="projects">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 7l10-4 10 4-10 4L2 7z"/><path d="M2 17l10 4 10-4"/><path d="M2 12l10 4 10-4"/></svg>
        <span>All Projects</span>
      </a>
      <a href="#" class="nav-item" data-page="add-project">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
        <span>Add Project</span>
      </a>
      <a href="#" class="nav-item" data-page="shop">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span>Shop Items</span>
      </a>
      <a href="#" class="nav-item" data-page="add-shop-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
        <span>Add Shop Item</span>
      </a>
      <a href="#" class="nav-item" data-page="settings">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
        <span>Settings</span>
      </a>
    </nav>

    <div class="sidebar-bottom">
      <div class="sidebar-user">
        <div class="sidebar-avatar"><?php echo strtoupper(substr($adminUser, 0, 1)); ?></div>
        <div>
          <p class="sidebar-user-name"><?php echo htmlspecialchars($adminName); ?></p>
          <p class="sidebar-user-role"><?php echo htmlspecialchars($adminUser); ?></p>
        </div>
      </div>
      <a href="<?= $BASE ?>/admin/logout" id="logout-btn" class="nav-item nav-item--logout">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Logout</span>
      </a>
    </div>
  </aside>

  <!-- ═══════════════════════════════════════════
       MAIN CONTENT
  ═══════════════════════════════════════════ -->
  <main id="main-content">

    <!-- Mobile header bar -->
    <div class="mobile-header">
      <button id="mobile-toggle" aria-label="Toggle menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <span class="mobile-title">CivilLanka Admin</span>
    </div>

    <!-- ── DASHBOARD PAGE ──────────────────────── -->
    <section id="page-dashboard" class="page active">
      <div class="page-header">
        <h1>Dashboard</h1>
        <p class="page-subtitle">Overview of your projects</p>
      </div>

      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon stat-icon--total">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 7l10-4 10 4-10 4L2 7z"/><path d="M2 17l10 4 10-4"/><path d="M2 12l10 4 10-4"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-number" id="stat-total">—</span>
            <span class="stat-label">Total Projects</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-icon--local">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-number" id="stat-local">—</span>
            <span class="stat-label">Local Projects</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-icon--intl">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-number" id="stat-intl">—</span>
            <span class="stat-label">International</span>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-icon--featured">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <div class="stat-info">
            <span class="stat-number" id="stat-featured">—</span>
            <span class="stat-label">Featured</span>
          </div>
        </div>
      </div>

      <!-- Recent projects table -->
      <div class="card">
        <div class="card-header">
          <h2>Recent Projects</h2>
          <button class="btn-primary btn-sm" onclick="navigateTo('add-project')">+ Add New</button>
        </div>
        <div id="recent-projects-table" class="table-wrap">
          <p class="loading-text">Loading…</p>
        </div>
      </div>
    </section>

    <!-- ── PROJECTS PAGE ───────────────────────── -->
    <section id="page-projects" class="page">
      <div class="page-header">
        <h1>All Projects</h1>
        <div class="page-actions">
          <div class="filter-group">
            <select id="filter-category" class="filter-select">
              <option value="">All Categories</option>
              <option value="local">Local</option>
              <option value="international">International</option>
            </select>
            <select id="filter-status" class="filter-select">
              <option value="">All Status</option>
              <option value="published">Published</option>
              <option value="draft">Draft</option>
            </select>
          </div>
          <button class="btn-primary" onclick="navigateTo('add-project')">+ Add Project</button>
        </div>
      </div>

      <div class="card">
        <div id="all-projects-table" class="table-wrap">
          <p class="loading-text">Loading…</p>
        </div>
      </div>
    </section>

    <!-- ── ADD / EDIT PROJECT PAGE ──────────────── -->
    <section id="page-add-project" class="page">
      <div class="page-header">
        <h1 id="form-page-title">Add New Project</h1>
        <p class="page-subtitle">Fill in the project details below</p>
      </div>

      <div class="card">
        <form id="project-form" enctype="multipart/form-data">
          <input type="hidden" id="edit-id" name="id" value="" />

          <div class="form-grid">
            <!-- Title -->
            <div class="form-group full-width">
              <label for="proj-title">Project Title <span class="req">*</span></label>
              <input type="text" id="proj-title" name="title" required placeholder="Enter project title" />
            </div>

            <!-- Category -->
            <div class="form-group">
              <label for="proj-category">Category <span class="req">*</span></label>
              <select id="proj-category" name="category" required>
                <option value="local">Local</option>
                <option value="international">International</option>
              </select>
            </div>

            <!-- Service Type -->
            <div class="form-group">
              <label for="proj-service">Service Type</label>
              <select id="proj-service" name="service_type">
                <option value="">Select type</option>
                <option value="ARCHITECTURE">Architecture</option>
                <option value="INTERIOR">Interior</option>
                <option value="WELLNESS">Wellness</option>
                <option value="COMMERCIAL">Commercial</option>
                <option value="RESIDENTIAL">Residential</option>
                <option value="LANDSCAPE">Landscape</option>
                <option value="URBAN PLANNING">Urban Planning</option>
              </select>
            </div>

            <!-- Location -->
            <div class="form-group">
              <label for="proj-location">Location</label>
              <input type="text" id="proj-location" name="location" placeholder="e.g. Colombo, Sri Lanka" />
            </div>

            <!-- Client -->
            <div class="form-group">
              <label for="proj-client">Client</label>
              <input type="text" id="proj-client" name="client" placeholder="Client name" />
            </div>

            <!-- Year -->
            <div class="form-group">
              <label for="proj-year">Year</label>
              <input type="number" id="proj-year" name="year" min="2000" max="2030" placeholder="2025" />
            </div>

            <!-- Status -->
            <div class="form-group">
              <label for="proj-status">Status</label>
              <select id="proj-status" name="status">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
              </select>
            </div>

            <!-- Featured -->
            <div class="form-group">
              <label for="proj-featured">Featured on Homepage</label>
              <label class="toggle-switch">
                <input type="checkbox" id="proj-featured" name="featured" value="1" />
                <span class="toggle-slider"></span>
                <span class="toggle-label">Show in homepage slider</span>
              </label>
            </div>

            <!-- Sort Order -->
            <div class="form-group">
              <label for="proj-sort">Sort Order</label>
              <input type="number" id="proj-sort" name="sort_order" value="0" min="0" />
            </div>

            <!-- Description -->
            <div class="form-group full-width">
              <label for="proj-desc">Description</label>
              <textarea id="proj-desc" name="description" rows="4" placeholder="Describe the project…"></textarea>
            </div>

            <!-- Main Image -->
            <div class="form-group full-width">
              <label>Main Image</label>
              <div class="upload-zone" id="main-upload-zone">
                <input type="file" id="proj-image" name="image_main" accept="image/*" class="upload-input" />
                <div class="upload-placeholder" id="main-upload-placeholder">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <span>Click or drag to upload main image</span>
                  <small>JPEG, PNG, WebP — max 10 MB</small>
                </div>
                <div class="upload-preview" id="main-upload-preview" style="display:none;">
                  <img id="main-preview-img" src="" alt="Preview" />
                  <button type="button" class="upload-remove" onclick="removeMainImage()">×</button>
                </div>
              </div>
            </div>

            <!-- Gallery Images -->
            <div class="form-group full-width">
              <label>Gallery Images</label>
              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <!-- Gallery 1 -->
                <div class="upload-zone" id="gallery-zone-1">
                  <input type="file" id="proj-gallery-1" name="image_gallery[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="gallery-placeholder-1" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Upload Image 1</span>
                  </div>
                  <div class="upload-preview" id="gallery-preview-1" style="display:none;">
                    <img id="gallery-img-1" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeGalleryImage(1)">×</button>
                    <input type="hidden" id="existing-gallery-1" value="" />
                  </div>
                </div>
                <!-- Gallery 2 -->
                <div class="upload-zone" id="gallery-zone-2">
                  <input type="file" id="proj-gallery-2" name="image_gallery[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="gallery-placeholder-2" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Upload Image 2</span>
                  </div>
                  <div class="upload-preview" id="gallery-preview-2" style="display:none;">
                    <img id="gallery-img-2" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeGalleryImage(2)">×</button>
                    <input type="hidden" id="existing-gallery-2" value="" />
                  </div>
                </div>
                <!-- Gallery 3 -->
                <div class="upload-zone" id="gallery-zone-3">
                  <input type="file" id="proj-gallery-3" name="image_gallery[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="gallery-placeholder-3" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Upload Image 3</span>
                  </div>
                  <div class="upload-preview" id="gallery-preview-3" style="display:none;">
                    <img id="gallery-img-3" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeGalleryImage(3)">×</button>
                    <input type="hidden" id="existing-gallery-3" value="" />
                  </div>
                </div>
                <!-- Gallery 4 -->
                <div class="upload-zone" id="gallery-zone-4">
                  <input type="file" id="proj-gallery-4" name="image_gallery[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="gallery-placeholder-4" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Upload Image 4</span>
                  </div>
                  <div class="upload-preview" id="gallery-preview-4" style="display:none;">
                    <img id="gallery-img-4" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeGalleryImage(4)">×</button>
                    <input type="hidden" id="existing-gallery-4" value="" />
                  </div>
                </div>
              </div>
              <input type="hidden" id="remove-gallery-input" name="remove_gallery" value="[]" />
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn-ghost" onclick="resetForm()">Cancel</button>
            <button type="submit" class="btn-primary" id="form-submit-btn">
              <span>Save Project</span>
            </button>
          </div>
        </form>
      </div>
    </section>

    <!-- ── SHOP ITEMS PAGE ─────────────────────── -->
    <section id="page-shop" class="page">
      <div class="page-header">
        <h1>Shop Items</h1>
        <div class="page-actions">
          <button class="btn-primary" onclick="navigateTo('add-shop-item')">+ Add Shop Item</button>
        </div>
      </div>

      <div class="card">
        <div id="shop-items-table" class="table-wrap">
          <p class="loading-text">Loading…</p>
        </div>
      </div>
    </section>

    <!-- ── ADD / EDIT SHOP ITEM PAGE ────────────── -->
    <section id="page-add-shop-item" class="page">
      <div class="page-header">
        <h1 id="shop-form-page-title">Add New Shop Item</h1>
        <p class="page-subtitle">Fill in the shop item details below</p>
      </div>

      <div class="card">
        <form id="shop-form" enctype="multipart/form-data">
          <input type="hidden" id="shop-edit-id" name="id" value="" />

          <div class="form-grid">
            <div class="form-group full-width">
              <label for="shop-title">Item Name <span class="req">*</span></label>
              <input type="text" id="shop-title" name="title" required placeholder="Enter item name" />
            </div>

            <div class="form-group">
              <label for="shop-price">Price ($) <span class="req">*</span></label>
              <input type="number" id="shop-price" name="price" step="0.01" required placeholder="0.00" />
            </div>

            <div class="form-group">
              <label for="shop-original-price">Original Price ($)</label>
              <input type="number" id="shop-original-price" name="original_price" step="0.01" placeholder="e.g. 60.00 (shows strike-through)" />
            </div>

            <div class="form-group">
              <label for="shop-category">Category</label>
              <input type="text" id="shop-category" name="category" placeholder="e.g. Furniture" />
            </div>

            <div class="form-group">
              <label for="shop-status">Status</label>
              <select id="shop-status" name="status">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
              </select>
            </div>

            <div class="form-group">
              <label for="shop-sort">Sort Order</label>
              <input type="number" id="shop-sort" name="sort_order" value="0" min="0" />
            </div>

            <div class="form-group full-width">
              <label for="shop-desc">Description</label>
              <textarea id="shop-desc" name="description" rows="4" placeholder="Describe the item…"></textarea>
            </div>

            <!-- Main Image -->
            <div class="form-group full-width">
              <label>Main Image <span class="req">*</span></label>
              <div class="upload-zone" id="shop-upload-zone">
                <input type="file" id="shop-image" name="image" accept="image/*" class="upload-input" />
                <div class="upload-placeholder" id="shop-upload-placeholder">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  <span>Click or drag to upload main item image</span>
                  <small>JPEG, PNG, WebP — max 10 MB</small>
                </div>
                <div class="upload-preview" id="shop-upload-preview" style="display:none;">
                  <img id="shop-preview-img" src="" alt="Preview" />
                  <button type="button" class="upload-remove" onclick="removeShopImage()">×</button>
                </div>
              </div>
            </div>

            <!-- Gallery Images (up to 4) -->
            <div class="form-group full-width">
              <label>Gallery Images <small style="font-weight:400;color:var(--text-muted);">(shown in product detail page — up to 4)</small></label>
              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">

                <!-- Shop Gallery 1 -->
                <div class="upload-zone" id="shop-gallery-zone-1">
                  <input type="file" id="shop-gallery-1" name="gallery_images[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="shop-gallery-placeholder-1" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Gallery Image 1</span>
                  </div>
                  <div class="upload-preview" id="shop-gallery-preview-1" style="display:none;">
                    <img id="shop-gallery-img-1" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeShopGalleryImage(1)">×</button>
                    <input type="hidden" id="shop-existing-gallery-1" value="" />
                  </div>
                </div>

                <!-- Shop Gallery 2 -->
                <div class="upload-zone" id="shop-gallery-zone-2">
                  <input type="file" id="shop-gallery-2" name="gallery_images[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="shop-gallery-placeholder-2" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Gallery Image 2</span>
                  </div>
                  <div class="upload-preview" id="shop-gallery-preview-2" style="display:none;">
                    <img id="shop-gallery-img-2" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeShopGalleryImage(2)">×</button>
                    <input type="hidden" id="shop-existing-gallery-2" value="" />
                  </div>
                </div>

                <!-- Shop Gallery 3 -->
                <div class="upload-zone" id="shop-gallery-zone-3">
                  <input type="file" id="shop-gallery-3" name="gallery_images[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="shop-gallery-placeholder-3" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Gallery Image 3</span>
                  </div>
                  <div class="upload-preview" id="shop-gallery-preview-3" style="display:none;">
                    <img id="shop-gallery-img-3" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeShopGalleryImage(3)">×</button>
                    <input type="hidden" id="shop-existing-gallery-3" value="" />
                  </div>
                </div>

                <!-- Shop Gallery 4 -->
                <div class="upload-zone" id="shop-gallery-zone-4">
                  <input type="file" id="shop-gallery-4" name="gallery_images[]" accept="image/*" class="upload-input" />
                  <div class="upload-placeholder" id="shop-gallery-placeholder-4" style="padding: 20px 10px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:10px;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span style="font-size:0.85rem;">Gallery Image 4</span>
                  </div>
                  <div class="upload-preview" id="shop-gallery-preview-4" style="display:none;">
                    <img id="shop-gallery-img-4" src="" alt="Preview" />
                    <button type="button" class="upload-remove" onclick="removeShopGalleryImage(4)">×</button>
                    <input type="hidden" id="shop-existing-gallery-4" value="" />
                  </div>
                </div>

              </div>
              <input type="hidden" id="remove-shop-gallery-input" name="remove_gallery" value="[]" />
            </div>

          </div>

          <div class="form-actions">
            <button type="button" class="btn-ghost" onclick="resetShopForm()">Cancel</button>
            <button type="submit" class="btn-primary" id="shop-form-submit-btn">
              <span>Save Item</span>
            </button>
          </div>
        </form>
      </div>
    </section>

    <!-- ── SETTINGS PAGE ───────────────────────── -->
    <section id="page-settings" class="page">
      <div class="page-header">
        <h1>Settings</h1>
        <p class="page-subtitle">Update your admin credentials</p>
      </div>

      <div class="card" style="max-width:520px;">
        <form id="settings-form">
          <div class="form-group">
            <label for="set-current-pw">Current Password</label>
            <input type="password" id="set-current-pw" name="current_password" required />
          </div>
          <div class="form-group">
            <label for="set-new-pw">New Password</label>
            <input type="password" id="set-new-pw" name="new_password" required minlength="6" />
          </div>
          <div class="form-group">
            <label for="set-confirm-pw">Confirm New Password</label>
            <input type="password" id="set-confirm-pw" name="confirm_password" required minlength="6" />
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary">Update Password</button>
          </div>
        </form>
      </div>
    </section>

  </main>

  <!-- Toast container -->
  <div id="toast-container"></div>

  <script src="<?= $BASE ?>/admin/assets/js/admin.js?v=2"></script>
</body>
</html>
