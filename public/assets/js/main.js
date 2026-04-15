/* ============================================
   GreenBite — Main JavaScript v4 (Stable UI)
   ============================================ */

/* ===== Page Transition Overlay (Pretty Loader) ===== */
(function() {
  const savedTheme = localStorage.getItem('theme');
  const isDark = savedTheme === 'dark';
  const overlay = document.createElement('div');
  overlay.id = 'pageTransitionOverlay';
  overlay.style.cssText = [
    'position:fixed', 'inset:0', 'z-index:99999',
    'display:flex', 'align-items:center', 'justify-content:center', 'flex-direction:column',
    isDark ? 'background:#0f1117' : 'background:#f0f2f5',
    'pointer-events:none',
    'opacity:1',
    'transition:opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1)'
  ].join(';');

  // Pretty Loader HTML
  const scripts = document.getElementsByTagName('script');
  let basePath = '';
  for (let i = 0; i < scripts.length; i++) {
    if (scripts[i].src && scripts[i].src.includes('/assets/js/main.js')) {
      basePath = scripts[i].src.replace('/assets/js/main.js', '');
      break;
    }
  }
  const logoUrl = basePath + '/assets/images/logo.png';

  overlay.innerHTML = `
    <div style="display:flex;align-items:center;justify-content:center;flex-direction:column;animation:pulse 2.5s ease-in-out infinite">
      <img src="${logoUrl}" alt="GreenBite Logo" style="height:4.5rem;width:auto;object-fit:contain;filter:drop-shadow(0 8px 24px rgba(0,0,0,0.15))" />
      <span style="margin-top:1rem;font-size:1.75rem;font-weight:800;letter-spacing:-0.03em;color:var(--text-primary, #1e293b);font-family:var(--font-heading, 'Poppins', sans-serif)">GreenBite</span>
    </div>
    <div style="margin-top:2rem;width:8rem;height:4px;background:rgba(82,183,136,0.2);border-radius:2px;overflow:hidden;position:relative">
      <div style="position:absolute;top:0;left:0;bottom:0;width:50%;background:linear-gradient(90deg,var(--primary,#2D6A4F),var(--secondary,#52B788));border-radius:2px;animation:shimmer 1.5s infinite"></div>
    </div>
  `;
  document.documentElement.appendChild(overlay);

  // Fade out on load
  window.addEventListener('load', function() {
    requestAnimationFrame(() => {
      overlay.style.opacity = '0';
      setTimeout(() => { document.documentElement.style.overflow = ''; overlay.style.display = 'none'; }, 400);
    });
  });

  // Fade in on navigation
  document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript') ||
        link.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey) return;
    if (link.closest('.modal-overlay')) return;
    
    e.preventDefault();
    overlay.style.display = 'flex';
    document.documentElement.style.overflow = 'hidden'; // Stop scroll during transition
    requestAnimationFrame(() => {
      overlay.style.opacity = '1';
      setTimeout(() => { window.location.href = link.href; }, 350);
    });
  });
})();

document.addEventListener('DOMContentLoaded', function() {

  // ===== Initialize Lucide Icons =====
  if (typeof lucide !== 'undefined') lucide.createIcons();

  // ===== Delete Modal System =====
  createDeleteModal();
  bindDeleteLinks();

  // ===== Auto-hide flash messages =====
  document.querySelectorAll('.animate-fade-up').forEach(el => {
    const hasIcon = el.querySelector('[data-lucide="check-circle-2"]') ||
                    el.querySelector('[data-lucide="alert-circle"]');
    if (hasIcon) {
      setTimeout(() => {
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        setTimeout(() => el.remove(), 500);
      }, 4000);
    }
  });

  // ===== Counter animation for stat numbers =====
  document.querySelectorAll('.stat-card .text-2xl, .stat-value').forEach(el => {
    const text = el.textContent.trim();
    const number = parseInt(text.replace(/[^0-9]/g, ''));
    if (!isNaN(number) && number > 0) {
      const suffix = text.replace(/[0-9,]/g, '');
      const formatted = text.includes(',');
      let current = 0;
      const duration = 1200;
      const step = Math.ceil(number / (duration / 16));
      const counter = setInterval(() => {
        current += step;
        if (current >= number) { current = number; clearInterval(counter); }
        el.textContent = (formatted ? current.toLocaleString() : current) + suffix;
      }, 16);
    }
  });

  // ===== Form loading state =====
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      const btn = this.querySelector('button[type="submit"], .btn-primary.btn-block');
      if (btn && !btn.dataset.originalHtml) {
        btn.dataset.originalHtml = btn.innerHTML;
      }
      setTimeout(() => {
        if (!e.defaultPrevented && btn && !btn.dataset.loading) {
          btn.dataset.loading = 'true';
          btn.innerHTML = '<span style="display:inline-block;width:1rem;height:1rem;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.6s linear infinite"></span> Chargement...';
          btn.style.opacity = '0.8';
          btn.style.pointerEvents = 'none';
        }
      }, 0);
    });
  });

  // ===== Smooth table rows =====
  document.querySelectorAll('.table tbody tr').forEach(row => {
    row.style.transition = 'background-color 0.2s ease';
  });

  // ===== Active sidebar item scroll into view =====
  const activeItem = document.querySelector('.sidebar-nav-item.active');
  if (activeItem) {
    setTimeout(() => activeItem.scrollIntoView({ block: 'nearest', behavior: 'smooth' }), 200);
  }

});

/* ============================================
   Delete Confirmation Modal
   ============================================ */
function createDeleteModal() {
  if (document.getElementById('deleteModal')) return;
  const modal = document.createElement('div');
  modal.id = 'deleteModal';
  modal.className = 'modal-overlay';
  modal.innerHTML = `
    <div class="modal-box">
      <div class="modal-icon danger">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
        </svg>
      </div>
      <div class="modal-title">Confirmer la suppression</div>
      <div class="modal-text">Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</div>
      <div class="modal-actions">
        <button class="btn btn-outline btn-sm" onclick="closeDeleteModal()" style="min-width:6rem">Annuler</button>
        <button id="confirmDeleteBtn" class="btn btn-danger btn-sm" style="min-width:6rem">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:4px"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg>
          Supprimer
        </button>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closeDeleteModal();
  });
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
  });
}

function bindDeleteLinks() {
  document.querySelectorAll('a[onclick*="confirm"]').forEach(link => {
    const href = (link.getAttribute('href') || '').toLowerCase();
    const onclickStr = (link.getAttribute('onclick') || '').toLowerCase();
    if (href.includes('delete') || href.includes('supprimer') || onclickStr.includes('supprimer')) {
      link.removeAttribute('onclick');
      link.addEventListener('click', function(e) {
        e.preventDefault();
        openDeleteModal(this.href, this.closest('tr'));
      });
    }
  });
}

function openDeleteModal(url, row) {
  const modal = document.getElementById('deleteModal');
  const btn   = document.getElementById('confirmDeleteBtn');
  btn.onclick = function() {
    if (row) row.classList.add('tr-deleting');
    btn.innerHTML = '<span style="display:inline-block;width:0.875rem;height:0.875rem;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.6s linear infinite"></span>';
    // Bypass the page-transition overlay for delete navigations
    setTimeout(() => { window.location.href = url; }, 400);
  };
  modal.classList.add('active');
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  if (modal) modal.classList.remove('active');
}

/* ============================================
   Utility
   ============================================ */
function renderIcons() {
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

// Keyframes
const extraStyles = document.createElement('style');
extraStyles.textContent = `
  @keyframes spin { to { transform: rotate(360deg); } }
  #pageTransitionOverlay { will-change: opacity; }
`;
document.head.appendChild(extraStyles);
