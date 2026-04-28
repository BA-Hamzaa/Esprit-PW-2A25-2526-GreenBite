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

  // Handle bfcache (Back/Forward navigation)
  window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
      overlay.style.opacity = '0';
      document.documentElement.style.overflow = ''; 
      overlay.style.display = 'none';
    }
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

  // Handle bfcache for form buttons
  window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
      document.querySelectorAll('button[data-loading="true"]').forEach(btn => {
        delete btn.dataset.loading;
        if (btn.dataset.originalHtml) {
          btn.innerHTML = btn.dataset.originalHtml;
        }
        btn.style.opacity = '';
        btn.style.pointerEvents = '';
      });
    }
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
   Generic Confirm Modal (replaces native confirm)
   ============================================ */
function createConfirmModal() {
  if (document.getElementById('greenConfirmModal')) return;
  var modal = document.createElement('div');
  modal.id = 'greenConfirmModal';
  modal.className = 'modal-overlay';
  modal.innerHTML = 
    '<div class="modal-box">' +
      '<div id="gcmIcon" class="modal-icon danger"></div>' +
      '<div id="gcmTitle" class="modal-title"></div>' +
      '<div id="gcmText" class="modal-text"></div>' +
      '<div class="modal-actions">' +
        '<button id="gcmCancel" class="btn btn-outline btn-sm" style="min-width:6rem">Annuler</button>' +
        '<button id="gcmConfirm" class="btn btn-danger btn-sm" style="min-width:6rem">Confirmer</button>' +
      '</div>' +
    '</div>';
  document.body.appendChild(modal);
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closeConfirmModal(false);
  });
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeConfirmModal(false);
  });
}

var _gcmResolve = null;

function closeConfirmModal(result) {
  var modal = document.getElementById('greenConfirmModal');
  if (modal) modal.classList.remove('active');
  if (_gcmResolve) { _gcmResolve(result); _gcmResolve = null; }
}

// SVG icons for each type
var _gcmIcons = {
  danger: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>',
  warning: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
  success: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
  info: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
};

var _gcmBtnClasses = {
  danger:  'btn btn-danger btn-sm',
  warning: 'btn btn-sm',
  success: 'btn btn-primary btn-sm',
  info:    'btn btn-primary btn-sm'
};

/**
 * greenConfirm(options) — custom styled confirm dialog
 * @param {Object} opts
 *   title    : string (modal title)
 *   message  : string (modal body text)
 *   type     : 'danger'|'warning'|'success'|'info'
 *   confirmText : string (confirm button label)
 *   cancelText  : string (cancel button label)
 * @returns {Promise<boolean>}
 */
function greenConfirm(opts) {
  createConfirmModal();
  var type = opts.type || 'danger';
  var modal = document.getElementById('greenConfirmModal');
  var icon  = document.getElementById('gcmIcon');
  var title = document.getElementById('gcmTitle');
  var text  = document.getElementById('gcmText');
  var confirmBtn = document.getElementById('gcmConfirm');
  var cancelBtn  = document.getElementById('gcmCancel');

  // Set icon type
  icon.className = 'modal-icon ' + type;
  icon.innerHTML = _gcmIcons[type] || _gcmIcons.info;

  title.textContent = opts.title || 'Confirmer';
  text.textContent  = opts.message || 'Êtes-vous sûr ?';
  confirmBtn.className = _gcmBtnClasses[type] || _gcmBtnClasses.info;
  confirmBtn.style.minWidth = '6rem';
  confirmBtn.textContent = opts.confirmText || 'Confirmer';
  cancelBtn.textContent  = opts.cancelText  || 'Annuler';

  // Warning button gets orange style inline
  if (type === 'warning') {
    confirmBtn.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
    confirmBtn.style.color = '#fff';
    confirmBtn.style.border = 'none';
  } else {
    confirmBtn.style.background = '';
    confirmBtn.style.color = '';
    confirmBtn.style.border = '';
  }

  modal.classList.add('active');

  return new Promise(function(resolve) {
    _gcmResolve = resolve;
    confirmBtn.onclick = function() { closeConfirmModal(true); };
    cancelBtn.onclick  = function() { closeConfirmModal(false); };
  });
}

/**
 * Helper: attach confirm to a button/link via data attributes
 * Usage: <button data-confirm="message" data-confirm-title="Title"
 *               data-confirm-type="danger" data-confirm-url="/some/url">
 */
function bindAllConfirms() {
  document.querySelectorAll('[data-confirm]').forEach(function(el) {
    if (el.dataset.confirmBound) return;
    el.dataset.confirmBound = 'true';
    el.addEventListener('click', function(e) {
      e.preventDefault();
      var msg   = el.dataset.confirm;
      var title = el.dataset.confirmTitle || 'Confirmer';
      var type  = el.dataset.confirmType  || 'danger';
      var url   = el.dataset.confirmUrl   || el.getAttribute('href') || '';
      var cText = el.dataset.confirmBtn   || 'Confirmer';

      greenConfirm({
        title: title,
        message: msg,
        type: type,
        confirmText: cText
      }).then(function(ok) {
        if (ok && url) {
          window.location.href = url;
        } else if (ok && el.form) {
          el.form.submit();
        }
      });
    });
  });
}

// Auto-bind on DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
  createConfirmModal();
  bindAllConfirms();
});

/* ============================================
   Utility
   ============================================ */
function renderIcons() {
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

// Keyframes
var extraStyles = document.createElement('style');
extraStyles.textContent = [
  '@keyframes spin { to { transform: rotate(360deg); } }',
  '#pageTransitionOverlay { will-change: opacity; }'
].join('\n');
document.head.appendChild(extraStyles);
