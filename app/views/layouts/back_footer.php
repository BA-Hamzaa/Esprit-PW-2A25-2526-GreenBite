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
      const icon = document.getElementById('darkIcon');
      if (label) label.textContent = theme === 'dark' ? 'Mode clair' : 'Mode sombre';
      if (icon) icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
      if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    updateDarkBtn(localStorage.getItem('theme') || 'light');
  </script>
</body>
</html>
