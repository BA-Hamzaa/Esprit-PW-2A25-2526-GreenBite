    </div><!-- end page-content-admin -->
  </div><!-- end page-with-sidebar -->

  <script src="<?= BASE_URL ?>/assets/js/main.js"></script>

  <!-- ============================================================
       GLOBAL NOTIFICATION SYSTEM — bottom toasts + custom confirm
       ============================================================ -->
  <style>
    /* ── Bottom Toast Container ── */
    #gbToastContainer {
      position: fixed;
      bottom: 1.5rem;
      right: 1.5rem;
      z-index: 99999;
      display: flex;
      flex-direction: column-reverse;
      gap: 0.6rem;
      pointer-events: none;
    }
    .gb-toast {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      padding: 0.85rem 1.2rem;
      border-radius: 1rem;
      min-width: 260px;
      max-width: 400px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.18), 0 2px 8px rgba(0,0,0,0.10);
      font-weight: 600;
      font-size: 0.875rem;
      pointer-events: auto;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      transform: translateX(120%);
      opacity: 0;
      transition: transform 0.38s cubic-bezier(.34,1.56,.64,1), opacity 0.3s ease;
    }
    .gb-toast.show {
      transform: translateX(0);
      opacity: 1;
    }
    .gb-toast.hiding {
      transform: translateX(120%);
      opacity: 0;
    }
    .gb-toast.success {
      background: linear-gradient(135deg, rgba(22,163,74,0.95), rgba(16,185,129,0.9));
      color: #fff;
      border: 1px solid rgba(255,255,255,0.2);
    }
    .gb-toast.error {
      background: linear-gradient(135deg, rgba(220,38,38,0.95), rgba(239,68,68,0.9));
      color: #fff;
      border: 1px solid rgba(255,255,255,0.2);
    }
    .gb-toast.warning {
      background: linear-gradient(135deg, rgba(217,119,6,0.97), rgba(245,158,11,0.9));
      color: #fff;
      border: 1px solid rgba(255,255,255,0.2);
    }
    .gb-toast.info {
      background: linear-gradient(135deg, rgba(59,130,246,0.97), rgba(99,102,241,0.9));
      color: #fff;
      border: 1px solid rgba(255,255,255,0.2);
    }
    .gb-toast .gb-toast-icon { flex-shrink: 0; font-size: 1.1rem; line-height: 1; }
    .gb-toast .gb-toast-close {
      margin-left: auto;
      background: transparent;
      border: none;
      color: rgba(255,255,255,0.75);
      cursor: pointer;
      font-size: 1rem;
      line-height: 1;
      padding: 0;
      flex-shrink: 0;
    }
    .gb-toast .gb-toast-close:hover { color: #fff; }

    /* ── Custom Confirm Dialog ── */
    #gbConfirmOverlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.45);
      z-index: 100000;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      animation: gbFadeIn 0.2s ease;
    }
    #gbConfirmOverlay.show { display: flex; }
    @keyframes gbFadeIn { from { opacity:0; } to { opacity:1; } }
    #gbConfirmBox {
      background: var(--card, #fff);
      border: 1.5px solid var(--border, #e5e7eb);
      border-radius: 1.5rem;
      padding: 2rem 1.75rem 1.5rem;
      max-width: 380px;
      width: 90%;
      box-shadow: 0 24px 60px rgba(0,0,0,0.25);
      text-align: center;
      animation: gbSlideUp 0.35s cubic-bezier(.34,1.56,.64,1);
    }
    @keyframes gbSlideUp {
      from { transform: translateY(40px) scale(0.95); opacity:0; }
      to   { transform: translateY(0) scale(1); opacity:1; }
    }
    #gbConfirmIcon { font-size: 2.5rem; margin-bottom: 0.75rem; }
    #gbConfirmTitle {
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--text-primary, #111);
      margin-bottom: 0.4rem;
    }
    #gbConfirmMessage {
      font-size: 0.875rem;
      color: var(--text-muted, #6b7280);
      margin-bottom: 1.5rem;
      line-height: 1.55;
    }
    #gbConfirmActions { display: flex; gap: 0.6rem; justify-content: center; }
    #gbConfirmCancel {
      padding: 0.6rem 1.4rem;
      border: 1.5px solid var(--border, #e5e7eb);
      border-radius: var(--radius-full, 999px);
      background: transparent;
      color: var(--text-secondary, #374151);
      font-size: 0.875rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
    }
    #gbConfirmCancel:hover { background: var(--muted, #f3f4f6); }
    #gbConfirmOk {
      padding: 0.6rem 1.5rem;
      border: none;
      border-radius: var(--radius-full, 999px);
      background: linear-gradient(135deg, #dc2626, #ef4444);
      color: #fff;
      font-size: 0.875rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: 0 4px 14px rgba(220,38,38,0.3);
    }
    #gbConfirmOk:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(220,38,38,0.4); }
    #gbConfirmOk.safe {
      background: linear-gradient(135deg, #2d6a4f, #52b788);
      box-shadow: 0 4px 14px rgba(45,106,79,0.3);
    }
    #gbConfirmOk.safe:hover { box-shadow: 0 6px 18px rgba(45,106,79,0.4); }
    #gbConfirmOk.danger { background:linear-gradient(135deg,#7c3aed,#dc2626); box-shadow:0 4px 14px rgba(124,58,237,0.3); }
    #gbConfirmOk.danger:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(124,58,237,0.4); }
  </style>

  <!-- Bottom Toast Container -->
  <div id="gbToastContainer"></div>

  <!-- Custom Confirm Modal -->
  <div id="gbConfirmOverlay">
    <div id="gbConfirmBox">
      <div id="gbConfirmIcon">⚠️</div>
      <div id="gbConfirmTitle">Confirmation</div>
      <div id="gbConfirmMessage">Êtes-vous sûr ?</div>
      <div id="gbConfirmActions">
        <button id="gbConfirmCancel">Annuler</button>
        <button id="gbConfirmOk">Confirmer</button>
      </div>
    </div>
  </div>

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

    /* ── gbToast(type, message) ── */
    window.gbToast = function(type, msg) {
      const icons = { success:'✅', error:'❌', warning:'⚠️', info:'ℹ️' };
      const cont = document.getElementById('gbToastContainer');
      const t = document.createElement('div');
      t.className = 'gb-toast ' + (type || 'info');
      t.innerHTML =
        '<span class="gb-toast-icon">' + (icons[type] || '💬') + '</span>' +
        '<span style="flex:1;line-height:1.45">' + msg + '</span>' +
        '<button class="gb-toast-close" onclick="this.parentElement.remove()">✕</button>';
      cont.appendChild(t);
      requestAnimationFrame(() => { requestAnimationFrame(() => t.classList.add('show')); });
      setTimeout(() => {
        t.classList.add('hiding');
        setTimeout(() => t.remove(), 380);
      }, 4000);
    };

    /* Legacy alias — keeps compatibility with older showToast calls */
    window.showToast = function(type, msg) { gbToast(type, msg); };

    /* ── gbConfirm(message, title?, icon?, okClass?) → Promise<bool> ── */
    window.gbConfirm = function(message, title, icon, okClass) {
      return new Promise(function(resolve) {
        const overlay = document.getElementById('gbConfirmOverlay');
        document.getElementById('gbConfirmMessage').textContent = message || 'Êtes-vous sûr ?';
        document.getElementById('gbConfirmTitle').textContent   = title  || 'Confirmation';
        document.getElementById('gbConfirmIcon').textContent    = icon   || '⚠️';
        const okBtn = document.getElementById('gbConfirmOk');
        okBtn.className = okClass === 'safe' ? 'safe' : '';

        overlay.classList.add('show');

        function cleanup() {
          overlay.classList.remove('show');
          overlay.onclick = null;
        }

        document.getElementById('gbConfirmOk').onclick = function() {
          cleanup(); resolve(true);
        };
        document.getElementById('gbConfirmCancel').onclick = function() {
          cleanup(); resolve(false);
        };
        // Delay backdrop listener so the triggering click doesn't immediately close it
        overlay.onclick = null;
        setTimeout(function() {
          overlay.onclick = function(e) {
            if (e.target === overlay) { cleanup(); resolve(false); }
          };
        }, 100);
      });
    };

    /* ── gbAlert(message, type?) ── replaces native alert() ── */
    window.gbAlert = function(msg, type) { gbToast(type || 'info', msg); };
  </script>

</body>
</html>
