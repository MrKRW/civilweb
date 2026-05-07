/**
 * CivilLanka — Project Details Page (public)
 * Fetches a single project from the API and renders it.
 */
(function () {
  const API = 'api/projects.php';
  const UPLOAD = 'uploads/projects/';
  
  // Fallback images from "Project images" folder
  const FALLBACK_IMAGES = [
    'Project%20images/hero_exterior.png',
    'Project%20images/hero_interior.png',
    'Project%20images/2023-11-07.jpg',
    'Project%20images/unnamed.jpg',
    'Project%20images/unnamed%20(1).jpg',
    'Project%20images/VIEW%2001.png'
  ];

  document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (!id) {
      handleError('Project ID not found in URL.');
      return;
    }

    loadProject(id);
  });

  async function loadProject(id) {
    try {
      const res = await fetch(`${API}?action=get&id=${id}`);
      if (!res.ok) throw new Error('Failed to fetch project');
      const data = await res.json();
      
      if (data.error) {
        throw new Error(data.error);
      }

      renderProject(data.project);
    } catch (e) {
      handleError(e.message || 'Unable to load project details.');
    }
  }

  function renderProject(project) {
    document.getElementById('pd-title').textContent = project.title || 'Untitled Project';

    // Meta blocks
    const metaContainer = document.getElementById('pd-meta-container');
    let metaHTML = '';
    
    if (project.category) {
      metaHTML += `
        <div class="pd-meta-block">
          <span class="pd-meta-label">Category:</span>
          <span class="pd-meta-value">${escHtml(project.category)}</span>
        </div>`;
    }
    if (project.service_type) {
      metaHTML += `
        <div class="pd-meta-block">
          <span class="pd-meta-label">Tags:</span>
          <span class="pd-meta-value">${escHtml(project.service_type)}</span>
        </div>`;
    }
    if (project.location) {
      metaHTML += `
        <div class="pd-meta-block">
          <span class="pd-meta-label">Location:</span>
          <span class="pd-meta-value">${escHtml(project.location)}</span>
        </div>`;
    }
    
    metaContainer.innerHTML = metaHTML;

    // Description
    const descEl = document.getElementById('pd-description');
    if (project.description) {
      descEl.innerHTML = project.description.replace(/\n/g, '<br>');
    } else {
       descEl.innerHTML = 'Pellentesque ornare sem lacinia quam venenatis vestibulum. Maecenas sed diam eget risus varius blandit sit amet non magna. Cras mattis consectetur purus sit amet fermentum. Lorem ipsum dolor sit amet.';
    }

    // Gallery
    const galleryEl = document.getElementById('pd-gallery');
    let images = [];

    // Main image
    if (project.image_main) {
      images.push(UPLOAD + project.image_main);
    }

    // Gallery images added from admin panel
    if (project.image_gallery && Array.isArray(project.image_gallery) && project.image_gallery.length > 0) {
      images = images.concat(project.image_gallery.map(img => UPLOAD + img));
    }

    // Fallback if no images found or just the main image
    if (images.length <= 1) {
       images = images.concat(FALLBACK_IMAGES);
    }

    if (images.length === 0) {
      galleryEl.innerHTML = '<p>No images available for this project.</p>';
    } else {
      galleryEl.innerHTML = images.map((imgSrc, idx) => {
        return `<img src="${imgSrc}" alt="${escAttr(project.title)} - Image ${idx + 1}" class="pd-gallery-item" loading="lazy" />`;
      }).join('');
    }

    loadRelatedProjects(project.id);
  }

  async function loadRelatedProjects(currentId) {
    try {
      const res = await fetch(API + '?action=list&status=published');
      if (!res.ok) return;
      const data = await res.json();
      let allProjects = data.projects || [];
      
      // Filter out current project
      let related = allProjects.filter(p => p.id !== currentId);
      
      // Take first 4
      related = related.slice(0, 4);
      
      const relatedGrid = document.getElementById('pd-related-grid');
      
      if (related.length === 0) {
        relatedGrid.parentElement.style.display = 'none';
        return;
      }
      
      relatedGrid.innerHTML = related.map(p => {
         const imgSrc = p.image_main ? UPLOAD + p.image_main : 'Project%20images/2023-11-07.jpg';
         return `
           <a href="project-details.html?id=${p.id}" class="rel-card">
             <img src="${imgSrc}" alt="${escAttr(p.title)}" class="rel-card-img" loading="lazy" />
             <h3 class="rel-title">${escHtml(p.title)}</h3>
             <span class="rel-meta">${escHtml(p.service_type || p.category || '')}</span>
           </a>
         `;
      }).join('');

      // Simple Prev/Next logic based on IDs in the fetched list
      const currentIndex = allProjects.findIndex(p => p.id == currentId);
      if (currentIndex > -1) {
         const prevObj = allProjects[currentIndex - 1];
         const nextObj = allProjects[currentIndex + 1];
         
         const prevLink = document.getElementById('pd-prev');
         const nextLink = document.getElementById('pd-next');
         
         if (prevObj) {
            prevLink.href = `project-details.html?id=${prevObj.id}`;
            prevLink.style.visibility = 'visible';
         } else {
            prevLink.style.visibility = 'hidden';
         }
         
         if (nextObj) {
            nextLink.href = `project-details.html?id=${nextObj.id}`;
            nextLink.style.visibility = 'visible';
         } else {
            nextLink.style.visibility = 'hidden';
         }
      }

    } catch(e) {
      console.error('Could not load related projects', e);
    }
  }

  function escHtml(s) {
    const d = document.createElement('div');
    d.textContent = s || '';
    return d.innerHTML;
  }

  function handleError(msg) {
    document.getElementById('pd-title').textContent = 'Error';
    document.getElementById('pd-description').textContent = msg;
  }

  function escAttr(s) {
    return (s || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  }

})();
