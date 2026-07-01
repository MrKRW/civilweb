/**
 * CivilLanka — Projects Page (public)
 * Fetches published projects from the API and renders them
 * in a filterable masonry-style grid.
 */
(function () {
  const API = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/projects';
  const UPLOAD = (typeof API_BASE !== 'undefined' ? API_BASE : '') + '/uploads/projects/';
  
  let grid, emptyState, countText;
  let allProjects = [];
  let activeLocation = 'all';
  let activeType = 'all';

  window.fallbackProjImage = function(img, filename) {
    if (!img.dataset.fb) {
      img.dataset.fb = 1;
      img.src = 'https://civilanka.com/uploads/projects/' + encodeURIComponent(filename);
    }
  };

  /* ── INIT ──────────────────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    grid = document.getElementById('pj-grid');
    emptyState = document.getElementById('pj-empty');
    countText = document.getElementById('pj-count-text');

    if (!grid) return;

    // Handle initial filter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');
    if (filterParam && ['local', 'international'].includes(filterParam.toLowerCase())) {
      activeLocation = filterParam.toLowerCase();
    }

    initFilters();
    loadProjects();
  });

  /* ── LOAD ──────────────────────────────── */
  async function loadProjects() {
    try {
      const res = await fetch(API + '?action=list&status=published');
      const data = await res.json();
      allProjects = data.projects || [];
      renderProjects();
    } catch (e) {
      if (grid) grid.innerHTML = '';
      if (emptyState) emptyState.style.display = 'block';
      if (countText) countText.textContent = 'Unable to load projects';
    }
  }

  /* ── RENDER ────────────────────────────── */
  function renderProjects() {
    if (!grid) return;

    const filtered = allProjects.filter(p => {
      const matchLocation = activeLocation === 'all' || p.category === activeLocation;
      
      // Service type matching: case-insensitive exact match
      const pType = (p.service_type || '').trim().toLowerCase();
      const aType = activeType.trim().toLowerCase();
      const matchType = activeType === 'all' || pType === aType;
      
      return matchLocation && matchType;
    });

    if (filtered.length === 0) {
      grid.innerHTML = '';
      grid.parentElement.style.display = 'none';
      emptyState.style.display = 'block';
      countText.textContent = 'No matching projects found';
      return;
    }

    grid.parentElement.style.display = '';
    emptyState.style.display = 'none';

    // Count text
    let label = 'projects';
    const locLabel = activeLocation === 'all' ? '' : activeLocation;
    const typeLabel = activeType === 'all' ? '' : activeType.toLowerCase();
    
    if (locLabel && typeLabel) {
      label = `${locLabel} ${typeLabel} projects`;
    } else if (locLabel) {
      label = `${locLabel} projects`;
    } else if (typeLabel) {
      label = `${typeLabel} projects`;
    }
    
    countText.textContent = `Showing ${filtered.length} ${label}`;

    // Build cards
    grid.innerHTML = filtered.map(p => {
      const imgSrc = p.image_main
        ? UPLOAD + p.image_main
        : 'Project%20images/2023-11-07.jpg';

      const badgeClass = p.category === 'international'
        ? 'pj-card-badge--international'
        : 'pj-card-badge--local';

      const starHtml = p.featured == 1
        ? `<span class="pj-card-star visible"><svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>`
        : '';

      const metaParts = [];
      if (p.service_type) {
        metaParts.push(`<span class="pj-card-service">${escHtml(p.service_type)}</span>`);
      }
      if (p.location) {
        if (metaParts.length) metaParts.push(`<span class="pj-card-meta-sep">|</span>`);
        metaParts.push(`<span class="pj-card-location">${escHtml(p.location)}</span>`);
      }
      if (p.year) {
        if (metaParts.length) metaParts.push(`<span class="pj-card-meta-sep">|</span>`);
        metaParts.push(`<span class="pj-card-year">${p.year}</span>`);
      }

      return `
        <a href="${typeof API_BASE !== 'undefined' ? API_BASE : ''}/projects/${p.id}" style="text-decoration:none; color:inherit; display:block;">
          <article class="pj-card">
            <div class="pj-card-img">
              <img src="${imgSrc}" alt="${escAttr(p.title)}" loading="lazy" ${p.image_main ? `onerror="window.fallbackProjImage(this, '${p.image_main}')"` : ''} />
              <span class="pj-card-badge ${badgeClass}">${p.category}</span>
              ${starHtml}
            </div>
            <div class="pj-card-info">
              <h3 class="pj-card-title">${escHtml(p.title)}</h3>
              <div class="pj-card-meta">${metaParts.join('')}</div>
            </div>
          </article>
        </a>`;
    }).join('');
  }

  /* ── FILTERS ───────────────────────────── */
  function initFilters() {
    // Location filters (first bar)
    const locationBar = document.querySelector('.pj-filters-inner:not(.pj-type-filters)');
    if (locationBar) {
      // Set initial active button based on activeLocation
      const initialBtn = locationBar.querySelector(`.pj-filter-btn[data-filter="${activeLocation}"]`);
      if (initialBtn) {
        locationBar.querySelectorAll('.pj-filter-btn').forEach(b => b.classList.remove('active'));
        initialBtn.classList.add('active');
      }

      locationBar.addEventListener('click', (e) => {
        const btn = e.target.closest('.pj-filter-btn');
        if (!btn) return;

        locationBar.querySelectorAll('.pj-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeLocation = btn.dataset.filter;
        renderProjects();
      });
    }

    // Type filters (second bar)
    const typeBar = document.querySelector('.pj-type-filters');
    if (typeBar) {
      typeBar.addEventListener('click', (e) => {
        const btn = e.target.closest('.pj-type-btn');
        if (!btn) return;

        typeBar.querySelectorAll('.pj-type-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeType = btn.dataset.type;
        renderProjects();
      });
    }
  }

  /* ── HELPERS ───────────────────────────── */
  function escHtml(s) {
    const d = document.createElement('div');
    d.textContent = s || '';
    return d.innerHTML;
  }

  function escAttr(s) {
    return (s || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  }

})();
