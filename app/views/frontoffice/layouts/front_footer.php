    </div><!-- end page-content-admin -->
  </div><!-- end page-with-sidebar -->

  <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
  <script>
    if (typeof lucide !== 'undefined') lucide.createIcons();

    function toggleDarkMode() {
      const html = document.documentElement;
      const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
      const icon  = document.getElementById('frontDarkLucide');
      const label = document.getElementById('frontDarkLabel');
      if (icon) { icon.setAttribute('data-lucide', next === 'dark' ? 'sun' : 'moon'); lucide.createIcons(); }
      if (label) label.textContent = next === 'dark' ? 'Mode clair' : 'Mode sombre';
    }

    (function() {
      const saved = localStorage.getItem('theme');
      if (saved === 'dark') {
        const icon  = document.getElementById('frontDarkLucide');
        const label = document.getElementById('frontDarkLabel');
        if (icon) { icon.setAttribute('data-lucide', 'sun'); lucide.createIcons(); }
        if (label) label.textContent = 'Mode clair';
      }
    })();

    // Toast helper
    window.showToast = function(type, msg) {
      let cont = document.getElementById('toastContainer');
      if (!cont) { cont = document.createElement('div'); cont.id = 'toastContainer'; document.body.appendChild(cont); }
      const t = document.createElement('div');
      t.className = 'toast ' + type;
      t.innerHTML = '<i data-lucide="' + (type === 'success' ? 'check-circle-2' : 'alert-circle') + '" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i><span style="font-size:0.875rem;font-weight:500">' + msg + '</span>';
      cont.appendChild(t);
      if (typeof lucide !== 'undefined') lucide.createIcons();
      setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 350); }, 3200);
    };
  </script>

  <!-- Toast container -->
  <div id="toastContainer" style="position:fixed;top:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:0.75rem;pointer-events:none"></div>

</body>
</html>
