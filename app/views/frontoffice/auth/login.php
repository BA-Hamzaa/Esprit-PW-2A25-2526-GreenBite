<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="GreenBite — Connexion à votre espace personnel">
  <title>Connexion — GreenBite</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <style>
    /* Login page specific overrides */
    body { overflow: hidden; }
    body::before { animation: gradientMove 12s ease infinite; }

    .login-left {
      flex: 1;
      background: linear-gradient(135deg, #0a1f14 0%, #1B4332 30%, #2D6A4F 60%, #40916C 85%, #52B788 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    /* Animated mesh grid */
    .login-left::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 40px 40px;
    }

    .login-feature-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.875rem 1.25rem;
      background: rgba(255,255,255,0.06);
      border-radius: 1rem;
      border: 1px solid rgba(255,255,255,0.08);
      backdrop-filter: blur(8px);
      transition: all 0.3s;
    }
    .login-feature-item:hover {
      background: rgba(255,255,255,0.1);
      transform: translateX(4px);
    }
    .login-feature-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 0.75rem;
      background: rgba(167,243,208,0.15);
      flex-shrink: 0;
    }

    .login-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      overflow-y: auto;
    }

    .login-form-card {
      width: 100%;
      max-width: 27rem;
      animation: fadeInUp 0.6s ease-out;
    }

    .social-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.625rem;
      width: 100%;
      padding: 0.8rem 1rem;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-xl);
      background: var(--surface);
      cursor: pointer;
      transition: all 0.3s;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--text-primary);
    }
    .social-btn:hover {
      border-color: var(--primary);
      background: rgba(45,106,79,0.04);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(45,106,79,0.1);
    }
  </style>
</head>
<body>
<script>if (localStorage.getItem('theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');</script>

<div style="min-height:100vh;display:flex">

  <!-- ===== LEFT PANEL — Branding ===== -->
  <div class="login-left">
    <!-- Animated floating orbs -->
    <div style="position:absolute;top:-120px;right:-80px;width:380px;height:380px;background:radial-gradient(circle,rgba(167,243,208,0.18) 0%,transparent 65%);border-radius:50%;animation:float 7s ease-in-out infinite"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:260px;height:260px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 65%);border-radius:50%;animation:floatReverse 9s ease-in-out infinite"></div>
    <div style="position:absolute;top:40%;left:-60px;width:180px;height:180px;background:radial-gradient(circle,rgba(82,183,136,0.12) 0%,transparent 70%);border-radius:50%;animation:float 11s ease-in-out 1s infinite"></div>
    <div style="position:absolute;bottom:25%;right:-40px;width:140px;height:140px;background:radial-gradient(circle,rgba(167,243,208,0.1) 0%,transparent 70%);border-radius:50%;animation:floatReverse 8s ease-in-out 2s infinite"></div>

    <!-- Content -->
    <div style="text-align:center;position:relative;z-index:1;padding:3rem 2.5rem;max-width:28rem">
      <!-- Logo icon -->
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5.5rem;height:5.5rem;background:rgba(255,255,255,0.1);backdrop-filter:blur(12px);border-radius:1.75rem;margin-bottom:2rem;border:1px solid rgba(255,255,255,0.15);animation:float 3.5s ease-in-out infinite;box-shadow:0 12px 40px rgba(0,0,0,0.2)">
        <i data-lucide="leaf" style="width:3rem;height:3rem;color:#a7f3d0"></i>
      </div>

      <h1 style="font-family:var(--font-heading);font-size:3rem;font-weight:900;color:#fff;margin-bottom:0.75rem;letter-spacing:-0.04em;line-height:1">
        Nutri<span style="background:linear-gradient(90deg,#a7f3d0,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Green</span>
      </h1>
      <p style="color:rgba(255,255,255,0.55);font-size:1rem;max-width:20rem;margin:0 auto 2.5rem;line-height:1.65">
        Votre compagnon intelligent pour une alimentation durable et un mode de vie sain. 🌱
      </p>

      <!-- Feature pills -->
      <div style="display:flex;flex-direction:column;gap:0.75rem;text-align:left">
        <div class="login-feature-item">
          <div class="login-feature-icon">
            <i data-lucide="utensils-crossed" style="width:1.125rem;height:1.125rem;color:#a7f3d0"></i>
          </div>
          <div>
            <div style="color:#fff;font-weight:600;font-size:0.875rem">Suivi Nutritionnel</div>
            <div style="color:rgba(255,255,255,0.45);font-size:0.75rem">Analysez vos macros & objectifs</div>
          </div>
        </div>
        <div class="login-feature-item">
          <div class="login-feature-icon">
            <i data-lucide="shopping-basket" style="width:1.125rem;height:1.125rem;color:#a7f3d0"></i>
          </div>
          <div>
            <div style="color:#fff;font-weight:600;font-size:0.875rem">Marketplace Bio</div>
            <div style="color:rgba(255,255,255,0.45);font-size:0.75rem">Produits locaux & durables</div>
          </div>
        </div>
        <div class="login-feature-item">
          <div class="login-feature-icon">
            <i data-lucide="book-open" style="width:1.125rem;height:1.125rem;color:#a7f3d0"></i>
          </div>
          <div>
            <div style="color:#fff;font-weight:600;font-size:0.875rem">Recettes Durables</div>
            <div style="color:rgba(255,255,255,0.45);font-size:0.75rem">Score carbone intégré</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== RIGHT PANEL — Form ===== -->
  <div class="login-right">
    <div class="login-form-card">

      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <div style="display:inline-flex;align-items:center;gap:0.4rem;background:linear-gradient(135deg,rgba(45,106,79,0.08),rgba(82,183,136,0.06));border:1px solid rgba(82,183,136,0.2);border-radius:var(--radius-full);padding:0.3rem 0.8rem;margin-bottom:0.75rem">
            <i data-lucide="shield-check" style="width:0.75rem;height:0.75rem;color:var(--secondary)"></i>
            <span style="font-size:0.7rem;font-weight:700;color:var(--secondary);text-transform:uppercase;letter-spacing:0.1em">Connexion sécurisée</span>
          </div>
          <h2 style="font-family:var(--font-heading);font-size:1.875rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.03em;line-height:1.1">Bon retour !</h2>
          <p style="font-size:0.85rem;color:var(--text-muted);margin-top:4px">Accédez à votre espace GreenBite</p>
        </div>
        <button onclick="toggleLoginDark()" style="width:2.5rem;height:2.5rem;border-radius:var(--radius-full);border:1.5px solid var(--border);background:var(--surface);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-secondary);transition:all 0.3s;flex-shrink:0" onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'" title="Mode sombre">
          <i data-lucide="moon" id="loginDarkIcon" style="width:1rem;height:1rem"></i>
        </button>
      </div>

      <!-- Form -->
      <form novalidate id="loginForm" style="display:flex;flex-direction:column;gap:1.25rem">

        <!-- Email -->
        <div>
          <label class="form-label" for="login-email">
            <i data-lucide="mail" style="width:0.75rem;height:0.75rem"></i> Adresse email
          </label>
          <div class="input-wrapper">
            <i data-lucide="at-sign" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);width:1rem;height:1rem;color:var(--text-muted);pointer-events:none"></i>
            <input type="email" id="login-email" class="form-input" placeholder="votre@email.com" style="padding:0.875rem 1rem 0.875rem 2.75rem;border-radius:var(--radius-xl)">
          </div>
        </div>

        <!-- Password -->
        <div>
          <label class="form-label" for="login-password">
            <i data-lucide="lock" style="width:0.75rem;height:0.75rem"></i> Mot de passe
          </label>
          <div class="input-wrapper">
            <i data-lucide="lock" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);width:1rem;height:1rem;color:var(--text-muted);pointer-events:none"></i>
            <input type="password" id="login-password" class="form-input" placeholder="••••••••" style="padding:0.875rem 3rem 0.875rem 2.75rem;border-radius:var(--radius-xl)">
            <button type="button" onclick="togglePwd('login-password', this)" style="position:absolute;right:0.875rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0.25rem;transition:color 0.2s" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
              <i data-lucide="eye" style="width:1rem;height:1rem"></i>
            </button>
          </div>
        </div>

        <!-- Options -->
        <div class="flex items-center justify-between" style="font-size:0.82rem">
          <label style="display:flex;align-items:center;gap:0.5rem;color:var(--text-secondary);cursor:pointer;user-select:none">
            <input type="checkbox" style="accent-color:var(--primary);width:1rem;height:1rem;border-radius:4px"> Se souvenir de moi
          </label>
          <a href="#" style="color:var(--secondary);font-weight:600;text-decoration:none;transition:all 0.2s" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--secondary)'">Mot de passe oublié ?</a>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius:var(--radius-xl);padding:1rem;font-size:0.95rem;margin-top:0.25rem;letter-spacing:0.02em">
          <i data-lucide="log-in" style="width:1.125rem;height:1.125rem"></i> Se connecter
        </button>
      </form>

      <!-- Divider -->
      <div style="display:flex;align-items:center;gap:1rem;margin:1.5rem 0">
        <div style="flex:1;height:1px;background:linear-gradient(to right,transparent,var(--border))"></div>
        <span style="font-size:0.75rem;color:var(--text-muted);font-weight:600;letter-spacing:0.08em">OU</span>
        <div style="flex:1;height:1px;background:linear-gradient(to left,transparent,var(--border))"></div>
      </div>

      <!-- Social buttons -->
      <button class="social-btn" onclick="showToast('success', 'Connexion Google en cours...')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
          <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
          <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
          <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continuer avec Google
      </button>

      <!-- Sign up link -->
      <p style="text-align:center;font-size:0.875rem;color:var(--text-muted);margin-top:1.5rem">
        Pas encore de compte ?
        <a href="<?= BASE_URL ?>/?page=signup" style="color:var(--secondary);font-weight:700;text-decoration:none;transition:color 0.2s;margin-left:0.25rem" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--secondary)'">Créer un compte →</a>
      </p>
    </div>
  </div>
</div>

<!-- Toast container -->
<div id="toastContainer"></div>

<script>
  if (typeof lucide !== 'undefined') lucide.createIcons();

  function toggleLoginDark() {
    const html = document.documentElement;
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    const icon = document.getElementById('loginDarkIcon');
    if (icon) { icon.setAttribute('data-lucide', next === 'dark' ? 'sun' : 'moon'); lucide.createIcons(); }
  }
  (function(){
    if (localStorage.getItem('theme') === 'dark') {
      const i = document.getElementById('loginDarkIcon');
      if (i) { i.setAttribute('data-lucide', 'sun'); lucide.createIcons(); }
    }
  })();

  function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    const ico = btn.querySelector('[data-lucide]');
    ico.setAttribute('data-lucide', inp.type === 'password' ? 'eye' : 'eye-off');
    lucide.createIcons();
  }

  // Inline validation helpers (validate.js not loaded here so we inline them)
  const ERR_ICON = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
  function showFE(field, msg) {
    field.classList.add('is-invalid'); field.classList.remove('is-valid');
    let el = field.closest('div').querySelector('.field-error');
    if (!el) { el = document.createElement('div'); el.className = 'field-error'; field.closest('div').appendChild(el); }
    el.innerHTML = ERR_ICON + ' ' + msg; el.classList.add('show');
  }
  function clearFE(field) {
    field.classList.remove('is-invalid'); field.classList.add('is-valid');
    const el = field.closest('div').querySelector('.field-error');
    if (el) el.classList.remove('show');
  }

  const emailEl = document.getElementById('login-email');
  const pwdEl   = document.getElementById('login-password');

  emailEl.addEventListener('blur', () => {
    if (!emailEl.value.trim()) showFE(emailEl, "L'adresse email est obligatoire.");
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) showFE(emailEl, "Format d'email invalide.");
    else clearFE(emailEl);
  });
  pwdEl.addEventListener('blur', () => {
    if (!pwdEl.value) showFE(pwdEl, "Le mot de passe est obligatoire.");
    else clearFE(pwdEl);
  });

  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let valid = true;
    if (!emailEl.value.trim()) { showFE(emailEl, "L'adresse email est obligatoire."); valid = false; }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) { showFE(emailEl, "Format d'email invalide."); valid = false; }
    else clearFE(emailEl);
    if (!pwdEl.value) { showFE(pwdEl, "Le mot de passe est obligatoire."); valid = false; }
    else clearFE(pwdEl);
    if (valid) showToast('success', 'Connexion réussie ! Redirection...');
  });
  function showToast(type, msg) {
    const cont = document.getElementById('toastContainer');
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.innerHTML = '<i data-lucide="' + (type === 'success' ? 'check-circle-2' : 'alert-circle') + '" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i><span style="font-size:0.875rem;font-weight:500">' + msg + '</span>';
    cont.appendChild(t);
    lucide.createIcons();
    setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 3200);
  }
</script>
</body>
</html>
