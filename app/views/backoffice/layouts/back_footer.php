    </div><!-- fin page-content-admin -->
  </div><!-- fin page-with-sidebar -->

  <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
  <script>
    // Init Lucide icons
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // Dark mode toggle
    function toggleDarkMode() {
      const html = document.documentElement;
      const current = html.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
      updateDarkBtn(next);
    }
    function updateDarkBtn(theme) {
      const label = document.getElementById('darkLabel');
      const icon  = document.getElementById('darkIcon');
      if (label) label.textContent = theme === 'dark' ? 'Mode clair' : 'Mode sombre';
      if (icon)  { icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon'); lucide.createIcons(); }
    }
    updateDarkBtn(localStorage.getItem('theme') || 'light');

    // Show Toast helper (reusable in all back pages)
    window.showToast = function(type, msg) {
      let cont = document.getElementById('toastContainer');
      if (!cont) {
        cont = document.createElement('div');
        cont.id = 'toastContainer';
        document.body.appendChild(cont);
      }
      const t = document.createElement('div');
      t.className = 'toast ' + type;
      t.innerHTML = '<i data-lucide="' + (type === 'success' ? 'check-circle-2' : 'alert-circle') + '" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i><span style="font-size:0.875rem;font-weight:500">' + msg + '</span>';
      cont.appendChild(t);
      if (typeof lucide !== 'undefined') lucide.createIcons();
      setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 350); }, 3200);
    };

    // Smooth delete rows
    document.querySelectorAll('.tr-delete-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        const row = btn.closest('tr');
        if (row) row.classList.add('tr-deleting');
      });
    });
  </script>

  <!-- Toast container (if not already present) -->
  <div id="toastContainer" style="position:fixed;top:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:0.75rem;pointer-events:none"></div>

</body>
</html>
