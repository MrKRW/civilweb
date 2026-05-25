/**
 * CivilLanka – Shop Page Logic
 */

document.addEventListener('DOMContentLoaded', () => {
  const shopGrid = document.querySelector('.shop-grid');
  if (shopGrid) {
    loadShopItems(shopGrid);
  }
});

async function loadShopItems(container) {
  try {
    container.innerHTML = '<p class="loading-text" style="grid-column: 1 / -1; text-align: center;">Loading shop items...</p>';

    const res = await fetch('/civilweb/api/shop?action=list');
    const data = await res.json();
    const items = data.items || [];

    // Filter only published items
    const published = items.filter(item => item.status === 'published');

    if (published.length === 0) {
      container.innerHTML = '<p class="empty-state" style="grid-column: 1 / -1; text-align: center;">No products available at the moment.</p>';

      const resultCount = document.querySelector('.result-count');
      if (resultCount) resultCount.textContent = 'SHOWING 0 RESULTS';
      return;
    }

    // Update result count
    const resultCount = document.querySelector('.result-count');
    if (resultCount) {
      resultCount.textContent = `SHOWING 1-${published.length} OF ${published.length} RESULTS`;
    }

    container.innerHTML = published.map(item => {
      const imgPath = item.image ? `/civilweb/uploads/shop/${item.image}` : '/civilweb/Project images/placeholder.png';

      // Handle pricing
      let priceHtml = '';
      if (item.original_price && item.original_price > item.price) {
        priceHtml = `<p class="product-price"><del>$${Number(item.original_price).toFixed(2)}</del> <span>$${Number(item.price).toFixed(2)}</span></p>`;
      } else {
        priceHtml = `<p class="product-price"><span>$${Number(item.price).toFixed(2)}</span></p>`;
      }

      // Add Sale badge if discounted
      let badgeHtml = '';
      if (item.original_price && item.original_price > item.price) {
        badgeHtml = `<span class="sale-badge">SALE</span>`;
      }

      return `
        <div class="product-card">
          <div class="product-image">
            ${badgeHtml}
            <img src="${imgPath}" alt="${escapeHtml(item.title)}">
            <div class="product-overlay">
              <button class="add-to-cart">+ add to cart</button>
            </div>
          </div>
          <div class="product-info">
            <h4 class="product-title"><a href="/civilweb/shop/product/${item.id}">${escapeHtml(item.title)}</a></h4>
            <div class="price-wrap">
              ${priceHtml}
            </div>
          </div>
        </div>
      `;
    }).join('');

  } catch (err) {
    console.error('Failed to load shop items', err);
    container.innerHTML = '<p class="empty-state" style="grid-column: 1 / -1; text-align: center;">Failed to load products. Please try again later.</p>';
  }
}

function escapeHtml(str) {
  if (!str) return '';
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}
