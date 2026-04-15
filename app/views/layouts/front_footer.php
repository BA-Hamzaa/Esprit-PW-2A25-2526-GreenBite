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
      // Update icon
      const icon = document.getElementById('frontDarkLucide');
      if (icon) {
        icon.setAttribute('data-lucide', next === 'dark' ? 'sun' : 'moon');
        lucide.createIcons();
      }
      const label = document.getElementById('frontDarkLabel');
      if (label) label.textContent = next === 'dark' ? 'Mode clair' : 'Mode sombre';
    }
    (function() {
      if (localStorage.getItem('theme') === 'dark') {
        const icon = document.getElementById('frontDarkLucide');
        if (icon) {
          icon.setAttribute('data-lucide', 'sun');
          lucide.createIcons();
        }
        const label = document.getElementById('frontDarkLabel');
        if (label) label.textContent = 'Mode clair';
      }
    })();
  </script>
</body>
</html>
