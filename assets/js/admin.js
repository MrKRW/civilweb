/**
 * CivilLanka Admin – Client-side Logic
 */
const API = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/projects';
const SHOP_API = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/shop';
const BLOG_API = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/blog';
const AUTH = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/auth';
const SETTINGS_API = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/settings';
const UPLOAD_BASE = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/uploads/projects/';
const SHOP_UPLOAD_BASE = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/uploads/shop/';
const BLOG_UPLOAD_BASE = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/uploads/blog/';

/* ── NAVIGATION ─────────────────────────── */
document.querySelectorAll('.nav-item[data-page]').forEach(item => {
  item.addEventListener('click', e => {
    e.preventDefault();
    navigateTo(item.dataset.page);
  });
});

function navigateTo(page) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item[data-page]').forEach(n => n.classList.remove('active'));
  const el = document.getElementById('page-' + page);
  if (el) el.classList.add('active');
  const nav = document.querySelector(`.nav-item[data-page="${page}"]`);
  if (nav) nav.classList.add('active');

  // Close mobile sidebar
  document.getElementById('sidebar')?.classList.remove('open');

  // Load data when switching pages
  if (page === 'dashboard') loadDashboard();
  if (page === 'projects') loadProjects();
  if (page === 'shop') loadShopItems();
  if (page === 'blog-posts') loadBlogPosts();
  if (page === 'add-project') {
    if (!document.getElementById('edit-id').value) resetForm();
  }
  if (page === 'add-shop-item') {
    if (!document.getElementById('shop-edit-id').value) resetShopForm();
  }
  if (page === 'add-blog-post') {
    if (!document.getElementById('blog-edit-id').value) resetBlogForm();
  }
}

/* ── MOBILE TOGGLE ──────────────────────── */
document.getElementById('mobile-toggle')?.addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle('open');
});
document.getElementById('sidebar-overlay')?.addEventListener('click', () => {
  document.getElementById('sidebar').classList.remove('open');
});

/* ── LOGOUT ─────────────────────────────── */
document.getElementById('logout-btn')?.addEventListener('click', async (e) => {
  e.preventDefault();
  await fetch(AUTH + '?action=logout', { method: 'POST' });
  window.location.href = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/admin/login';
});

/* ── TOAST ──────────────────────────────── */
function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.className = `toast toast--${type}`;
  toast.textContent = message;
  container.appendChild(toast);
  setTimeout(() => {
    toast.classList.add('toast-out');
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

/* ── DASHBOARD ──────────────────────────── */
async function loadDashboard() {
  try {
    const res = await fetch(API + '?action=list');
    const data = await res.json();
    const projects = data.projects || [];

    document.getElementById('stat-total').textContent = projects.length;
    document.getElementById('stat-local').textContent = projects.filter(p => p.category === 'local').length;
    document.getElementById('stat-intl').textContent = projects.filter(p => p.category === 'international').length;
    document.getElementById('stat-featured').textContent = projects.filter(p => p.featured == 1).length;

    // Blog post count
    try {
      const blogRes = await fetch(BLOG_API + '?action=list&status=published');
      const blogData = await blogRes.json();
      const blogEl = document.getElementById('stat-blog');
      if (blogEl) blogEl.textContent = (blogData.posts || []).length;
    } catch {}

    // Recent table — show last 5
    const recent = projects.slice(0, 5);
    document.getElementById('recent-projects-table').innerHTML = recent.length
      ? buildProjectTable(recent)
      : '<p class="empty-state">No projects yet. <a href="#" onclick="navigateTo(\'add-project\')" style="color:var(--accent)">Add your first project →</a></p>';
  } catch (err) {
    document.getElementById('recent-projects-table').innerHTML = '<p class="empty-state">Failed to load projects.</p>';
  }
}

/* ── PROJECTS LIST ──────────────────────── */
async function loadProjects() {
  const category = document.getElementById('filter-category').value;
  const status = document.getElementById('filter-status').value;
  let url = API + '?action=list';
  if (category) url += '&category=' + category;
  if (status) url += '&status=' + status;

  try {
    const res = await fetch(url);
    const data = await res.json();
    const projects = data.projects || [];

    document.getElementById('all-projects-table').innerHTML = projects.length
      ? buildProjectTable(projects)
      : '<p class="empty-state">No projects found.</p>';
  } catch {
    document.getElementById('all-projects-table').innerHTML = '<p class="empty-state">Failed to load.</p>';
  }
}

// Filter change listeners
document.getElementById('filter-category')?.addEventListener('change', loadProjects);
document.getElementById('filter-status')?.addEventListener('change', loadProjects);

/* ── BUILD TABLE ────────────────────────── */
function buildProjectTable(projects) {
  let html = `<div class="table-wrap"><table class="data-table">
    <thead><tr>
      <th>Image</th><th>Title</th><th>Category</th><th>Service</th><th>Status</th><th>Actions</th>
    </tr></thead><tbody>`;

  projects.forEach(p => {
    const thumb = p.image_main
      ? `<img src="${UPLOAD_BASE}${p.image_main}" class="project-thumb" alt="" />`
      : `<div class="project-thumb" style="background:var(--bg-hover);"></div>`;
    const catBadge = `<span class="badge badge--${p.category}">${p.category}</span>`;
    const statusBadge = `<span class="badge badge--${p.status}">${p.status}</span>`;
    const starClass = p.featured == 1 ? ' active' : '';

    html += `<tr>
      <td>${thumb}</td>
      <td><strong>${escHtml(p.title)}</strong>${p.location ? '<br><small style="color:var(--text-muted)">' + escHtml(p.location) + '</small>' : ''}</td>
      <td>${catBadge}</td>
      <td>${p.service_type || '—'}</td>
      <td>${statusBadge}</td>
      <td><div class="action-btns">
        <button class="action-btn action-btn--star${starClass}" onclick="toggleFeatured(${p.id})" title="Toggle featured">
          <svg viewBox="0 0 24 24" fill="${p.featured == 1 ? 'currentColor' : 'none'}" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </button>
        <button class="action-btn action-btn--edit" onclick="editProject(${p.id})" title="Edit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
        <button class="action-btn action-btn--delete" onclick="deleteProject(${p.id}, '${escHtml(p.title)}')" title="Delete">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
        </button>
      </div></td>
    </tr>`;
  });

  html += '</tbody></table></div>';
  return html;
}

function escHtml(s) {
  const d = document.createElement('div');
  d.textContent = s || '';
  return d.innerHTML;
}

/* ── CREATE / UPDATE PROJECT ────────────── */
document.getElementById('project-form')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const editId = document.getElementById('edit-id').value;
  const isEdit = !!editId;
  const btn = document.getElementById('form-submit-btn');
  btn.querySelector('span').textContent = 'Saving…';
  btn.disabled = true;

  // Sync TinyMCE description to textarea
  if (typeof tinymce !== 'undefined' && tinymce.get('proj-desc')) {
    tinymce.get('proj-desc').save();
  }

  const fd = new FormData(e.target);

  // Handle featured checkbox
  if (!document.getElementById('proj-featured').checked) {
    fd.set('featured', '0');
  }

  let url = API + '?action=' + (isEdit ? 'update&id=' + editId : 'create');

  try {
    const res = await fetch(url, { method: 'POST', body: fd });
    const data = await res.json();

    if (data.success) {
      showToast(isEdit ? 'Project updated!' : 'Project created!', 'success');
      resetForm();
      navigateTo('projects');
    } else {
      showToast(data.error || 'Save failed', 'error');
    }
  } catch (err) {
    console.error('Project save error:', err);
    showToast('Network error', 'error');
  }

  btn.querySelector('span').textContent = 'Save Project';
  btn.disabled = false;
});

/* ── EDIT PROJECT ───────────────────────── */
async function editProject(id) {
  try {
    const res = await fetch(API + '?action=get&id=' + id);
    const data = await res.json();
    if (!data.project) { showToast('Project not found', 'error'); return; }

    const p = data.project;
    document.getElementById('edit-id').value = p.id;
    document.getElementById('proj-title').value = p.title;
    document.getElementById('proj-category').value = p.category;
    document.getElementById('proj-service').value = p.service_type || '';
    document.getElementById('proj-location').value = p.location || '';
    document.getElementById('proj-client').value = p.client || '';
    document.getElementById('proj-year').value = p.year || '';
    document.getElementById('proj-status').value = p.status;
    document.getElementById('proj-featured').checked = p.featured == 1;
    document.getElementById('proj-sort').value = p.sort_order || 0;
    const projDesc = p.description || '';
    document.getElementById('proj-desc').value = projDesc;
    if (typeof tinymce !== 'undefined' && tinymce.get('proj-desc')) {
      tinymce.get('proj-desc').setContent(projDesc);
    }

    // Show existing main image
    if (p.image_main) {
      const preview = document.getElementById('main-upload-preview');
      const img = document.getElementById('main-preview-img');
      img.src = UPLOAD_BASE + p.image_main;
      preview.style.display = 'inline-block';
      document.getElementById('main-upload-placeholder').style.display = 'none';
    }

    // Show existing gallery images
    if (p.image_gallery && Array.isArray(p.image_gallery)) {
      p.image_gallery.forEach((imgSrc, index) => {
        if (index < 4) {
          const slot = index + 1;
          document.getElementById('gallery-img-' + slot).src = UPLOAD_BASE + imgSrc;
          document.getElementById('gallery-preview-' + slot).style.display = 'inline-block';
          document.getElementById('gallery-placeholder-' + slot).style.display = 'none';
          document.getElementById('existing-gallery-' + slot).value = imgSrc;
        }
      });
    }

    document.getElementById('form-page-title').textContent = 'Edit Project';
    document.getElementById('form-submit-btn').querySelector('span').textContent = 'Update Project';
    navigateTo('add-project');
  } catch {
    showToast('Failed to load project', 'error');
  }
}

/* ── DELETE PROJECT ─────────────────────── */
async function deleteProject(id, title) {
  if (!confirm(`Delete "${title}"? This cannot be undone.`)) return;

  try {
    const fd = new FormData();
    fd.append('id', id);
    const res = await fetch(API + '?action=delete&id=' + id, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      showToast('Project deleted', 'success');
      loadProjects();
      loadDashboard();
    } else {
      showToast(data.error || 'Delete failed', 'error');
    }
  } catch (err) {
    console.error('Project delete error:', err);
    showToast('Network error', 'error');
  }
}

/* ── TOGGLE FEATURED ────────────────────── */
async function toggleFeatured(id) {
  try {
    const fd = new FormData();
    fd.append('id', id);
    await fetch(API + '?action=toggle_featured&id=' + id, { method: 'POST', body: fd });
    showToast('Featured status toggled', 'info');
    loadProjects();
    loadDashboard();
  } catch {
    showToast('Failed', 'error');
  }
}

/* ── FORM HELPERS ───────────────────────── */
function resetForm() {
  document.getElementById('project-form').reset();
  document.getElementById('edit-id').value = '';
  document.getElementById('form-page-title').textContent = 'Add New Project';
  document.getElementById('form-submit-btn').querySelector('span').textContent = 'Save Project';
  document.getElementById('main-upload-preview').style.display = 'none';
  document.getElementById('main-upload-placeholder').style.display = '';
  if (typeof tinymce !== 'undefined' && tinymce.get('proj-desc')) {
    tinymce.get('proj-desc').setContent('');
  }
  
  for (let i = 1; i <= 4; i++) {
    document.getElementById('gallery-preview-' + i).style.display = 'none';
    document.getElementById('gallery-placeholder-' + i).style.display = '';
    document.getElementById('existing-gallery-' + i).value = '';
  }
  document.getElementById('remove-gallery-input').value = '[]';
}

function removeMainImage() {
  document.getElementById('main-upload-preview').style.display = 'none';
  document.getElementById('main-upload-placeholder').style.display = '';
  document.getElementById('proj-image').value = '';
}

function removeGalleryImage(slot) {
  const existingInput = document.getElementById('existing-gallery-' + slot);
  if (existingInput && existingInput.value) {
    const removeInput = document.getElementById('remove-gallery-input');
    const toRemove = JSON.parse(removeInput.value || '[]');
    toRemove.push(existingInput.value);
    removeInput.value = JSON.stringify(toRemove);
    existingInput.value = '';
  }
  
  document.getElementById('gallery-preview-' + slot).style.display = 'none';
  document.getElementById('gallery-placeholder-' + slot).style.display = '';
  document.getElementById('proj-gallery-' + slot).value = '';
}

/* ── IMAGE PREVIEW ──────────────────────── */
document.getElementById('proj-image')?.addEventListener('change', function() {
  if (this.files && this.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('main-preview-img').src = e.target.result;
      document.getElementById('main-upload-preview').style.display = 'inline-block';
      document.getElementById('main-upload-placeholder').style.display = 'none';
    };
    reader.readAsDataURL(this.files[0]);
  }
});

for (let i = 1; i <= 4; i++) {
  document.getElementById('proj-gallery-' + i)?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
      // If there was an existing image, mark it for removal
      const existingInput = document.getElementById('existing-gallery-' + i);
      if (existingInput && existingInput.value) {
        const removeInput = document.getElementById('remove-gallery-input');
        const toRemove = JSON.parse(removeInput.value || '[]');
        toRemove.push(existingInput.value);
        removeInput.value = JSON.stringify(toRemove);
        existingInput.value = '';
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('gallery-img-' + i).src = e.target.result;
        document.getElementById('gallery-preview-' + i).style.display = 'inline-block';
        document.getElementById('gallery-placeholder-' + i).style.display = 'none';
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
}

/* ── DRAG & DROP ────────────────────────── */
['main-upload-zone', 'gallery-zone-1', 'gallery-zone-2', 'gallery-zone-3', 'gallery-zone-4'].forEach(id => {
  const zone = document.getElementById(id);
  if (!zone) return;
  zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
  zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
  zone.addEventListener('drop', e => { e.preventDefault(); zone.classList.remove('drag-over'); });
});

/* ── SETTINGS FORM ──────────────────────── */
document.getElementById('settings-form')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const newPw = document.getElementById('set-new-pw').value;
  const confirmPw = document.getElementById('set-confirm-pw').value;

  if (newPw !== confirmPw) {
    showToast('Passwords do not match', 'error');
    return;
  }

  const fd = new FormData(e.target);
  try {
    const res = await fetch(SETTINGS_API, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      showToast('Password updated!', 'success');
      e.target.reset();
    } else {
      showToast(data.error || 'Update failed', 'error');
    }
  } catch (err) {
    console.error('Settings update error:', err);
    showToast('Network error', 'error');
  }
});

/* ── SHOP LOGIC ─────────────────────────── */

async function loadShopItems() {
  try {
    const res = await fetch(SHOP_API + '?action=list');
    const data = await res.json();
    const items = data.items || [];

    document.getElementById('shop-items-table').innerHTML = items.length
      ? buildShopTable(items)
      : '<p class="empty-state">No shop items found.</p>';
  } catch {
    document.getElementById('shop-items-table').innerHTML = '<p class="empty-state">Failed to load shop items.</p>';
  }
}

function buildShopTable(items) {
  let html = `<div class="table-wrap"><table class="data-table">
    <thead><tr>
      <th>Image</th><th>Name</th><th>Price</th><th>Category</th><th>Status</th><th>Actions</th>
    </tr></thead><tbody>`;

  items.forEach(p => {
    const thumb = p.image
      ? `<img src="${SHOP_UPLOAD_BASE}${p.image}" class="project-thumb" alt="" />`
      : `<div class="project-thumb" style="background:var(--bg-hover);"></div>`;
    const statusBadge = `<span class="badge badge--${p.status}">${p.status}</span>`;

    html += `<tr>
      <td>${thumb}</td>
      <td><strong>${escHtml(p.title)}</strong></td>
      <td>$${p.price}</td>
      <td>${p.category || '—'}</td>
      <td>${statusBadge}</td>
      <td><div class="action-btns">
        <button class="action-btn action-btn--edit" onclick="editShopItem(${p.id})" title="Edit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
        <button class="action-btn action-btn--delete" onclick="deleteShopItem(${p.id}, '${escHtml(p.title)}')" title="Delete">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
        </button>
      </div></td>
    </tr>`;
  });

  html += '</tbody></table></div>';
  return html;
}

document.getElementById('shop-form')?.addEventListener('submit', async (e) => {
  e.preventDefault();

  // Sync TinyMCE to textarea
  if (typeof tinymce !== 'undefined') {
    tinymce.triggerSave();
  }

  const editId = document.getElementById('shop-edit-id').value;
  const isEdit = !!editId;
  const btn = document.getElementById('shop-form-submit-btn');
  btn.querySelector('span').textContent = 'Saving…';
  btn.disabled = true;

  const fd = new FormData(e.target);
  let url = SHOP_API + '?action=' + (isEdit ? 'update&id=' + editId : 'create');

  try {
    const res = await fetch(url, { method: 'POST', body: fd });
    const data = await res.json();

    if (data.success) {
      showToast(isEdit ? 'Item updated!' : 'Item created!', 'success');
      resetShopForm();
      navigateTo('shop');
    } else {
      showToast(data.error || 'Save failed', 'error');
    }
  } catch (err) {
    console.error('Shop item save error:', err);
    showToast('Network error', 'error');
  }

  btn.querySelector('span').textContent = 'Save Item';
  btn.disabled = false;
});

async function editShopItem(id) {
  try {
    const res = await fetch(SHOP_API + '?action=get&id=' + id);
    const data = await res.json();
    if (!data.item) { showToast('Item not found', 'error'); return; }

    const p = data.item;
    document.getElementById('shop-edit-id').value = p.id;
    document.getElementById('shop-title').value = p.title;
    document.getElementById('shop-category').value = p.category || '';
    document.getElementById('shop-status').value = p.status;
    document.getElementById('shop-sort').value = p.sort_order || 0;
    
    document.getElementById('shop-desc').value = p.description || '';
    if (typeof tinymce !== 'undefined' && tinymce.get('shop-desc')) {
      tinymce.get('shop-desc').setContent(p.description || '');
    }
    document.getElementById('shop-spec-sqft').value = p.spec_sqft || '';
    document.getElementById('shop-spec-beds').value = p.spec_beds || '';
    document.getElementById('shop-spec-baths').value = p.spec_baths || '';
    document.getElementById('shop-spec-floors').value = p.spec_floors || '';
    document.getElementById('shop-spec-garages').value = p.spec_garages || '';

    // Populate Additional Info TinyMCE
    const addlInfoContent = p.additional_info || '';
    document.getElementById('shop-additional-info').value = addlInfoContent;
    if (typeof tinymce !== 'undefined' && tinymce.get('shop-additional-info')) {
      tinymce.get('shop-additional-info').setContent(addlInfoContent);
    }

    // Main image
    if (p.image) {
      document.getElementById('shop-preview-img').src = SHOP_UPLOAD_BASE + p.image;
      document.getElementById('shop-upload-preview').style.display = 'inline-block';
      document.getElementById('shop-upload-placeholder').style.display = 'none';
    }

    // Gallery images
    const gallery = Array.isArray(p.gallery_images) ? p.gallery_images : [];
    gallery.forEach((imgSrc, index) => {
      if (index < 4) {
        const slot = index + 1;
        document.getElementById('shop-gallery-img-' + slot).src = SHOP_UPLOAD_BASE + imgSrc;
        document.getElementById('shop-gallery-preview-' + slot).style.display = 'inline-block';
        document.getElementById('shop-gallery-placeholder-' + slot).style.display = 'none';
        document.getElementById('shop-existing-gallery-' + slot).value = imgSrc;
      }
    });

    // Additional Info images
    const addlImgs = Array.isArray(p.additional_info_images) ? p.additional_info_images : [];
    addlImgs.forEach((imgSrc, index) => {
      if (index < 6) {
        const slot = index + 1;
        document.getElementById('addl-img-preview-' + slot).src = SHOP_UPLOAD_BASE + imgSrc;
        document.getElementById('addl-preview-' + slot).style.display = 'inline-block';
        document.getElementById('addl-placeholder-' + slot).style.display = 'none';
        document.getElementById('addl-existing-' + slot).value = imgSrc;
      }
    });

    document.getElementById('shop-form-page-title').textContent = 'Edit Shop Item';
    document.getElementById('shop-form-submit-btn').querySelector('span').textContent = 'Update Item';
    navigateTo('add-shop-item');
  } catch {
    showToast('Failed to load item', 'error');
  }
}

async function deleteShopItem(id, title) {
  if (!confirm(`Delete "${title}"? This cannot be undone.`)) return;

  try {
    const fd = new FormData();
    fd.append('id', id);
    const res = await fetch(SHOP_API + '?action=delete&id=' + id, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      showToast('Item deleted', 'success');
      loadShopItems();
    } else {
      showToast(data.error || 'Delete failed', 'error');
    }
  } catch (err) {
    console.error('Shop item delete error:', err);
    showToast('Network error', 'error');
  }
}

function resetShopForm() {
  document.getElementById('shop-form').reset();
  document.getElementById('shop-edit-id').value = '';
  document.getElementById('shop-form-page-title').textContent = 'Add New Shop Item';
  document.getElementById('shop-form-submit-btn').querySelector('span').textContent = 'Save Item';
  document.getElementById('shop-upload-preview').style.display = 'none';
  document.getElementById('shop-upload-placeholder').style.display = '';
  document.getElementById('shop-spec-sqft').value = '';
  document.getElementById('shop-spec-beds').value = '';
  document.getElementById('shop-spec-baths').value = '';
  document.getElementById('shop-spec-floors').value = '';
  document.getElementById('shop-spec-garages').value = '';
  
  if (typeof tinymce !== 'undefined' && tinymce.get('shop-desc')) {
    tinymce.get('shop-desc').setContent('');
  }
  // Clear gallery slots
  for (let i = 1; i <= 4; i++) {
    document.getElementById('shop-gallery-preview-' + i).style.display = 'none';
    document.getElementById('shop-gallery-placeholder-' + i).style.display = '';
    document.getElementById('shop-existing-gallery-' + i).value = '';
  }
  document.getElementById('remove-shop-gallery-input').value = '[]';
  // Clear additional info
  document.getElementById('shop-additional-info').value = '';
  if (typeof tinymce !== 'undefined' && tinymce.get('shop-additional-info')) {
    tinymce.get('shop-additional-info').setContent('');
  }
  for (let i = 1; i <= 6; i++) {
    const prev = document.getElementById('addl-preview-' + i);
    const ph   = document.getElementById('addl-placeholder-' + i);
    const ex   = document.getElementById('addl-existing-' + i);
    if (prev) prev.style.display = 'none';
    if (ph)   ph.style.display = '';
    if (ex)   ex.value = '';
  }
  const removeAddlInput = document.getElementById('remove-addl-info-images-input');
  if (removeAddlInput) removeAddlInput.value = '[]';
}

function removeShopImage() {
  document.getElementById('shop-upload-preview').style.display = 'none';
  document.getElementById('shop-upload-placeholder').style.display = '';
  document.getElementById('shop-image').value = '';
}

function removeShopGalleryImage(slot) {
  const existingInput = document.getElementById('shop-existing-gallery-' + slot);
  if (existingInput && existingInput.value) {
    const removeInput = document.getElementById('remove-shop-gallery-input');
    const toRemove = JSON.parse(removeInput.value || '[]');
    toRemove.push(existingInput.value);
    removeInput.value = JSON.stringify(toRemove);
    existingInput.value = '';
  }
  document.getElementById('shop-gallery-preview-' + slot).style.display = 'none';
  document.getElementById('shop-gallery-placeholder-' + slot).style.display = '';
  document.getElementById('shop-gallery-' + slot).value = '';
}

document.getElementById('shop-image')?.addEventListener('change', function() {
  if (this.files && this.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('shop-preview-img').src = e.target.result;
      document.getElementById('shop-upload-preview').style.display = 'inline-block';
      document.getElementById('shop-upload-placeholder').style.display = 'none';
    };
    reader.readAsDataURL(this.files[0]);
  }
});

// Shop gallery file-change previews
for (let i = 1; i <= 4; i++) {
  document.getElementById('shop-gallery-' + i)?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
      // If replacing an existing gallery image, mark the old one for removal
      const existingInput = document.getElementById('shop-existing-gallery-' + i);
      if (existingInput && existingInput.value) {
        const removeInput = document.getElementById('remove-shop-gallery-input');
        const toRemove = JSON.parse(removeInput.value || '[]');
        toRemove.push(existingInput.value);
        removeInput.value = JSON.stringify(toRemove);
        existingInput.value = '';
      }
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('shop-gallery-img-' + i).src = e.target.result;
        document.getElementById('shop-gallery-preview-' + i).style.display = 'inline-block';
        document.getElementById('shop-gallery-placeholder-' + i).style.display = 'none';
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
}

// Shop gallery drag-and-drop
['shop-upload-zone', 'shop-gallery-zone-1', 'shop-gallery-zone-2', 'shop-gallery-zone-3', 'shop-gallery-zone-4'].forEach(id => {
  const zone = document.getElementById(id);
  if (!zone) return;
  zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
  zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
  zone.addEventListener('drop', e => { e.preventDefault(); zone.classList.remove('drag-over'); });
});

/* ── Additional Info Images helpers ─────── */
function removeAddlInfoImage(slot) {
  const existingInput = document.getElementById('addl-existing-' + slot);
  if (existingInput && existingInput.value) {
    const removeInput = document.getElementById('remove-addl-info-images-input');
    const toRemove = JSON.parse(removeInput.value || '[]');
    toRemove.push(existingInput.value);
    removeInput.value = JSON.stringify(toRemove);
    existingInput.value = '';
  }
  document.getElementById('addl-preview-' + slot).style.display = 'none';
  document.getElementById('addl-placeholder-' + slot).style.display = '';
  document.getElementById('addl-img-' + slot).value = '';
}

// Addl info image file-change previews
for (let i = 1; i <= 6; i++) {
  document.getElementById('addl-img-' + i)?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
      const existingInput = document.getElementById('addl-existing-' + i);
      if (existingInput && existingInput.value) {
        const removeInput = document.getElementById('remove-addl-info-images-input');
        const toRemove = JSON.parse(removeInput.value || '[]');
        toRemove.push(existingInput.value);
        removeInput.value = JSON.stringify(toRemove);
        existingInput.value = '';
      }
      const reader = new FileReader();
      reader.onload = function(ev) {
        document.getElementById('addl-img-preview-' + i).src = ev.target.result;
        document.getElementById('addl-preview-' + i).style.display = 'inline-block';
        document.getElementById('addl-placeholder-' + i).style.display = 'none';
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
}

/* ── BLOG LOGIC ─────────────────────────── */

const BLOG_CATEGORIES = ['Architecture','Interior','Landscape Architecture','Materials','Interviews'];

async function loadBlogPosts() {
  const status = document.getElementById('filter-blog-status')?.value || '';
  let url = BLOG_API + '?action=list';
  if (status) url += '&status=' + status;

  const tableEl = document.getElementById('blog-posts-table');
  if (!tableEl) return;
  tableEl.innerHTML = '<p class="loading-text">Loading…</p>';

  try {
    const res = await fetch(url);
    const data = await res.json();
    const posts = data.posts || [];
    tableEl.innerHTML = posts.length ? buildBlogTable(posts) : '<p class="empty-state">No blog posts found. <a href="#" onclick="navigateTo(\'add-blog-post\')" style="color:var(--accent)">Add your first post →</a></p>';
  } catch {
    tableEl.innerHTML = '<p class="empty-state">Failed to load blog posts.</p>';
  }
}

function buildBlogTable(posts) {
  let html = `<div class="table-wrap"><table class="data-table">
    <thead><tr>
      <th>Image</th><th>Title</th><th>Category</th><th>Status</th><th>Date</th><th>Actions</th>
    </tr></thead><tbody>`;

  posts.forEach(p => {
    const thumb = p.image
      ? `<img src="${BLOG_UPLOAD_BASE}${p.image}" class="project-thumb" alt="" />`
      : `<div class="project-thumb" style="background:var(--bg-hover);display:flex;align-items:center;justify-content:center;"><svg viewBox="0 0 24 24" width="20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>`;
    const statusBadge = `<span class="badge badge--${p.status}">${p.status}</span>`;
    const date = p.created_at ? new Date(p.created_at).toLocaleDateString('en-US', {year:'numeric',month:'short',day:'numeric'}) : '—';

    html += `<tr>
      <td>${thumb}</td>
      <td><strong>${escHtml(p.title)}</strong>${p.excerpt ? '<br><small style="color:var(--text-muted)">' + escHtml(p.excerpt.substring(0,80)) + (p.excerpt.length > 80 ? '…' : '') + '</small>' : ''}</td>
      <td>${p.category ? escHtml(p.category) : '—'}</td>
      <td>${statusBadge}</td>
      <td><small>${date}</small></td>
      <td><div class="action-btns">
        <button class="action-btn action-btn--edit" onclick="editBlogPost(${p.id})" title="Edit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
        <button class="action-btn action-btn--delete" onclick="deleteBlogPost(${p.id}, '${escHtml(p.title)}')" title="Delete">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
        </button>
      </div></td>
    </tr>`;
  });

  html += '</tbody></table></div>';
  return html;
}

document.getElementById('blog-form')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  
  // Sync TinyMCE blog editor HTML to the textarea
  if (typeof tinymce !== 'undefined' && tinymce.get('blog-content-editor')) {
    tinymce.get('blog-content-editor').save();
  }

  const editId = document.getElementById('blog-edit-id').value;
  const isEdit = !!editId;
  const btn = document.getElementById('blog-form-submit-btn');
  btn.querySelector('span').textContent = 'Saving…';
  btn.disabled = true;

  const fd = new FormData(e.target);
  const url = BLOG_API + '?action=' + (isEdit ? 'update&id=' + editId : 'create');

  try {
    const res = await fetch(url, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      showToast(isEdit ? 'Post updated!' : 'Post published!', 'success');
      resetBlogForm();
      navigateTo('blog-posts');
    } else {
      showToast(data.error || 'Save failed', 'error');
    }
  } catch (err) {
    console.error('Blog save error:', err);
    showToast('Network error', 'error');
  }

  btn.querySelector('span').textContent = 'Save Post';
  btn.disabled = false;
});

async function editBlogPost(id) {
  try {
    const res = await fetch(BLOG_API + '?action=get&id=' + id);
    const data = await res.json();
    if (!data.post) { showToast('Post not found', 'error'); return; }

    const p = data.post;
    document.getElementById('blog-edit-id').value  = p.id;
    document.getElementById('blog-title').value     = p.title;
    document.getElementById('blog-category').value  = p.category || '';
    document.getElementById('blog-status').value    = p.status;
    document.getElementById('blog-sort').value      = p.sort_order || 0;
    document.getElementById('blog-excerpt').value   = p.excerpt || '';
    
    const content = p.content || '';
    document.getElementById('blog-content-editor').value = content;
    if (typeof tinymce !== 'undefined' && tinymce.get('blog-content-editor')) {
      tinymce.get('blog-content-editor').setContent(content);
    }

    // Show existing cover image
    if (p.image) {
      document.getElementById('blog-preview-img').src = BLOG_UPLOAD_BASE + p.image;
      document.getElementById('blog-upload-preview').style.display = 'inline-block';
      document.getElementById('blog-upload-placeholder').style.display = 'none';
    }

    document.getElementById('blog-form-page-title').textContent = 'Edit Blog Post';
    document.getElementById('blog-form-submit-btn').querySelector('span').textContent = 'Update Post';
    navigateTo('add-blog-post');
  } catch {
    showToast('Failed to load post', 'error');
  }
}

async function deleteBlogPost(id, title) {
  if (!confirm(`Delete "${title}"? This cannot be undone.`)) return;
  try {
    const fd = new FormData();
    fd.append('id', id);
    const res = await fetch(BLOG_API + '?action=delete&id=' + id, { method: 'POST', body: fd });
    const data = await res.json();
    if (data.success) {
      showToast('Post deleted', 'success');
      loadBlogPosts();
      loadDashboard();
    } else {
      showToast(data.error || 'Delete failed', 'error');
    }
  } catch (err) {
    console.error('Blog delete error:', err);
    showToast('Network error', 'error');
  }
}

function resetBlogForm() {
  document.getElementById('blog-form').reset();
  document.getElementById('blog-edit-id').value = '';
  document.getElementById('blog-form-page-title').textContent = 'Add New Blog Post';
  document.getElementById('blog-form-submit-btn').querySelector('span').textContent = 'Save Post';
  document.getElementById('blog-upload-preview').style.display = 'none';
  document.getElementById('blog-upload-placeholder').style.display = '';
  if (typeof tinymce !== 'undefined' && tinymce.get('blog-content-editor')) {
    tinymce.get('blog-content-editor').setContent('');
  }
}

function removeBlogImage() {
  document.getElementById('blog-upload-preview').style.display = 'none';
  document.getElementById('blog-upload-placeholder').style.display = '';
  document.getElementById('blog-image').value = '';
}

document.getElementById('blog-image')?.addEventListener('change', function() {
  if (this.files && this.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('blog-preview-img').src = e.target.result;
      document.getElementById('blog-upload-preview').style.display = 'inline-block';
      document.getElementById('blog-upload-placeholder').style.display = 'none';
    };
    reader.readAsDataURL(this.files[0]);
  }
});

// Blog upload zone drag-and-drop
const blogZone = document.getElementById('blog-upload-zone');
if (blogZone) {
  blogZone.addEventListener('dragover', e => { e.preventDefault(); blogZone.classList.add('drag-over'); });
  blogZone.addEventListener('dragleave', () => blogZone.classList.remove('drag-over'));
  blogZone.addEventListener('drop', e => { e.preventDefault(); blogZone.classList.remove('drag-over'); });
}

// Blog status filter
document.getElementById('filter-blog-status')?.addEventListener('change', loadBlogPosts);

/* ── INIT ───────────────────────────────── */
loadDashboard();

// ── TINYMCE INITIALIZATION ─────────────────────
document.addEventListener('DOMContentLoaded', () => {

  // ── Shared TinyMCE image uploader helper ─────
  function blogImageUploader(blobInfo, progress) {
    return new Promise((resolve, reject) => {
      const fd = new FormData();
      fd.append('file', blobInfo.blob(), blobInfo.filename());
      fetch(BLOG_API + '?action=upload_image', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
          if (data.location) resolve(data.location);
          else reject({ message: data.error || 'Upload failed', remove: true });
        })
        .catch(() => reject({ message: 'Network error', remove: true }));
    });
  }

  // ── Blog Content Editor ───────────────────────
  if (typeof tinymce !== 'undefined') {
    const commonConfig = {
      convert_urls: false,
      images_upload_handler: blogImageUploader,
      automatic_uploads: true,
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.addEventListener('change', function () {
          const file = this.files[0];
          const fd = new FormData();
          fd.append('file', file, file.name);
          fetch(BLOG_API + '?action=upload_image', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
              if (data.location) cb(data.location, { title: file.name });
            });
        });
        input.click();
      }
    };

    // Blog editor — full featured with image resize
    tinymce.init({
      selector: '#blog-content-editor',
      plugins: 'image link lists table media code',
      toolbar:
        'undo redo | blocks | bold italic underline strikethrough | ' +
        'alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist | blockquote | link image media table | code | removeformat',
      menubar: false,
      height: 480,
      resize: true,
      image_advtab: true,
      image_caption: true,
      object_resizing: true,
      image_dimensions: true,
      image_class_list: [
        { title: 'None',         value: '' },
        { title: 'Left float',   value: 'img-align-left' },
        { title: 'Center',       value: 'img-align-center' },
        { title: 'Right float',  value: 'img-align-right' },
        { title: 'Full width',   value: 'img-full-width' }
      ],
      // Allow all img attributes including style, width, height, class
      extended_valid_elements: 'img[src|alt|title|width|height|style|class|loading]',
      content_css: 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Jost:wght@300;400;500;600;700&display=swap',
      content_style: `
        body { font-family: 'Inter', sans-serif; font-size: 16px; font-weight: 400;
               line-height: 1.8; color: #3A3A3A;
               max-width: 820px; margin: 24px auto; padding: 0 20px; }
        p { margin-bottom: 1.6em; font-weight: 300; }
        h1, h2, h3, h4, h5 { font-family: 'Jost', sans-serif; font-weight: 300;
               letter-spacing: -0.02em; line-height: 1.2; color: #0D0D0D; margin: 1.8em 0 0.6em; }
        h2 { font-size: 1.75rem; }
        h3 { font-size: 1.35rem; }
        h4 { font-size: 1.1rem; }
        img { max-width: 100%; height: auto; border-radius: 2px; }
        img.img-align-left  { float: left;  margin: 0 24px 16px 0; }
        img.img-align-right { float: right; margin: 0 0 16px 24px; }
        img.img-align-center{ display: block; margin: 0 auto 24px; }
        img.img-full-width  { display: block; width: 100%; }
        blockquote { border-left: 3px solid #111; padding: 12px 24px; margin: 0 0 1.8em;
               font-style: italic; color: #9A9A9A; background: #F5F3EF; }
      `,
      setup: function(editor) {
        editor.on('change input', function() { editor.save(); });
      },
      ...commonConfig
    });

    // Shared rich content editor — identical to blog editor, with image upload
    tinymce.init({
      selector: '#proj-desc, #shop-desc, #shop-additional-info',
      plugins: 'image link lists table media code',
      toolbar:
        'undo redo | blocks | bold italic underline strikethrough | ' +
        'alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist | blockquote | link image media table | code | removeformat',
      menubar: false,
      height: 380,
      resize: true,
      image_advtab: true,
      image_caption: true,
      object_resizing: true,
      image_dimensions: true,
      image_class_list: [
        { title: 'None',         value: '' },
        { title: 'Left float',   value: 'img-align-left' },
        { title: 'Center',       value: 'img-align-center' },
        { title: 'Right float',  value: 'img-align-right' },
        { title: 'Full width',   value: 'img-full-width' }
      ],
      extended_valid_elements: 'img[src|alt|title|width|height|style|class|loading]',
      content_css: 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Jost:wght@300;400;500;600;700&display=swap',
      content_style: `
        body { font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 400;
               line-height: 1.8; color: #3A3A3A; margin: 16px; padding: 0; }
        p { margin-bottom: 1.4em; font-weight: 300; }
        h2, h3, h4 { font-family: 'Jost', sans-serif; font-weight: 300;
               letter-spacing: -0.02em; line-height: 1.2; color: #0D0D0D; margin: 1.6em 0 0.5em; }
        img { max-width: 100%; height: auto; border-radius: 2px; }
        img.img-align-left  { float: left;  margin: 0 24px 16px 0; }
        img.img-align-right { float: right; margin: 0 0 16px 24px; }
        img.img-align-center{ display: block; margin: 0 auto 24px; }
        img.img-full-width  { display: block; width: 100%; }
        blockquote { border-left: 3px solid #111; padding: 10px 20px; margin: 0 0 1.4em;
               font-style: italic; color: #9A9A9A; background: #F5F3EF; }
      `,
      setup: function(editor) {
        editor.on('change input', function() { editor.save(); });
      },
      ...commonConfig
    });
  }
});
