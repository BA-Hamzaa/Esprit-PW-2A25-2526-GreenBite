/* ============================================
   NutriGreen — Main JavaScript v3
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
  // ===== Initialize Lucide Icons =====
  if (typeof lucide !== 'undefined') lucide.createIcons();

  // ===== Delete Modal System =====
  createDeleteModal();
  bindDeleteLinks();

  // ===== Auto-hide flash messages → convert to toasts =====
  document.querySelectorAll('.animate-fade-up').forEach(el => {
    const parent = el.closest('.container') || el.closest('[style*="padding"]');
    if (parent && (el.textContent.includes('✅') || el.textContent.includes('⚠️') || el.querySelector('[data-lucide="check-circle-2"]') || el.querySelector('[data-lucide="alert-circle"]'))) {
      setTimeout(() => {
        el.style.transition = 'opacity 0.5s, transform 0.5s';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-10px)';
        setTimeout(() => el.remove(), 500);
      }, 4000);
    }
  });

  // ===== Intersection Observer for scroll animations =====
  const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.card, .stat-card, .chart-card').forEach(el => {
    if (!el.closest('.grid')) observer.observe(el);
  });

  // ===== Counter animation for stat numbers =====
  document.querySelectorAll('.stat-card .text-2xl').forEach(el => {
    const text = el.textContent.trim();
    const number = parseInt(text.replace(/[^0-9]/g, ''));
    if (!isNaN(number) && number > 0) {
      const suffix = text.replace(/[0-9,]/g, '');
      const formatted = text.includes(',');
      let current = 0;
      const duration = 1500;
      const step = Math.ceil(number / (duration / 16));
      const counter = setInterval(() => {
        current += step;
        if (current >= number) { current = number; clearInterval(counter); }
        el.textContent = (formatted ? current.toLocaleString() : current) + suffix;
      }, 16);
    }
  });

  // ===== Add loading state to forms (deferred - lets per-form validation run first) =====
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      // Use setTimeout(0) so per-form validation handlers run first and can call preventDefault
      const btn = this.querySelector('button[type="submit"], .btn-primary.btn-block');
      if (btn) {
        // Store original HTML for restore
        if (!btn.dataset.originalHtml) btn.dataset.originalHtml = btn.innerHTML;
      }
      setTimeout(() => {
        // Only show loading if the event was NOT prevented
        if (!e.defaultPrevented && btn && !btn.dataset.loading) {
          btn.dataset.loading = 'true';
          btn.innerHTML = '<span style="display:inline-block;width:1rem;height:1rem;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.6s linear infinite"></span> Chargement...';
          btn.style.opacity = '0.8';
          btn.style.pointerEvents = 'none';
        }
      }, 0);
    });
  });

  // ===== Card tilt on hover =====
  document.querySelectorAll('.hover-shadow').forEach(card => {
    card.addEventListener('mousemove', function(e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / 25;
      const rotateY = (centerX - x) / 25;
      this.style.transform = `translateY(-6px) perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0) perspective(1000px) rotateX(0) rotateY(0)';
    });
  });

  // ===== Smooth hover on table rows =====
  document.querySelectorAll('.table tbody tr').forEach(row => {
    row.addEventListener('mouseenter', function() {
      this.style.transition = 'all 0.25s cubic-bezier(0.4, 0, 0.2, 1)';
    });
  });
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
        <button class="btn btn-outline btn-sm" onclick="closeDeleteModal()" style="min-width:6rem">
          Annuler
        </button>
        <button id="confirmDeleteBtn" class="btn btn-danger btn-sm" style="min-width:6rem">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:4px"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg>
          Supprimer
        </button>
      </div>
    </div>
  `;
  document.body.appendChild(modal);
  
  // Close on backdrop click
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closeDeleteModal();
  });
  
  // Close on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
  });
}

function bindDeleteLinks() {
  document.querySelectorAll('a[onclick*="confirm"]').forEach(link => {
    link.removeAttribute('onclick');
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const url = this.href;
      const row = this.closest('tr');
      openDeleteModal(url, row);
    });
  });
}

function openDeleteModal(url, row) {
  const modal = document.getElementById('deleteModal');
  const btn = document.getElementById('confirmDeleteBtn');
  
  // Set confirm action
  btn.onclick = function() {
    // Animate row if in table
    if (row) {
      row.classList.add('tr-deleting');
    }
    
    // Show loading state on button
    btn.innerHTML = '<span style="display:inline-block;width:0.875rem;height:0.875rem;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.6s linear infinite"></span>';
    
    setTimeout(() => {
      window.location.href = url;
    }, 400);
  };
  
  modal.classList.add('active');
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  if (modal) modal.classList.remove('active');
}

/* ============================================
   Utility Functions
   ============================================ */
// Reinit icons after dynamic content
function renderIcons() {
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

// Spin keyframe
const spinStyle = document.createElement('style');
spinStyle.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(spinStyle);
