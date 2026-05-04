<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="GreenBite — Inscription">
  <title>Inscription — GreenBite</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
<script>if (localStorage.getItem('theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');</script>

<div style="min-height:100vh;display:flex;background:var(--background)">
  <!-- Left panel - branding -->
  <div style="flex:1;background:linear-gradient(135deg, #1B4332 0%, var(--primary) 30%, #245a42 60%, #52B788 100%);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
    <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:radial-gradient(circle, rgba(167,243,208,0.15) 0%, transparent 70%);border-radius:50%;animation:float 6s ease-in-out infinite"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:300px;height:300px;background:radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);border-radius:50%;animation:float 8s ease-in-out infinite reverse"></div>
    <div style="text-align:center;position:relative;z-index:1;padding:2rem">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5rem;height:5rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(10px);border-radius:1.5rem;margin-bottom:2rem;border:1px solid rgba(255,255,255,0.15);animation:float 3s ease-in-out infinite">
        <i data-lucide="leaf" style="width:2.5rem;height:2.5rem;color:#a7f3d0"></i>
      </div>
      <h1 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:800;color:#fff;margin-bottom:0.75rem">GreenBite</h1>
      <p style="color:rgba(255,255,255,0.6);font-size:1rem;max-width:20rem;margin:0 auto;line-height:1.6">Rejoignez une communauté engagée pour une alimentation durable.</p>
      <div class="flex flex-wrap gap-3 justify-center mt-8">
        <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:var(--radius-xl);padding:0.75rem 1rem;display:flex;align-items:center;gap:0.5rem;color:rgba(255,255,255,0.7);font-size:0.8rem"><i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem;color:#a7f3d0"></i> Suivi gratuit</div>
        <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:var(--radius-xl);padding:0.75rem 1rem;display:flex;align-items:center;gap:0.5rem;color:rgba(255,255,255,0.7);font-size:0.8rem"><i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem;color:#a7f3d0"></i> +150 aliments</div>
        <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:var(--radius-xl);padding:0.75rem 1rem;display:flex;align-items:center;gap:0.5rem;color:rgba(255,255,255,0.7);font-size:0.8rem"><i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem;color:#a7f3d0"></i> Communauté</div>
      </div>
    </div>
  </div>

  <!-- Right panel - form -->
  <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:26rem">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:var(--text-primary)">Créer un compte</h2>
          <p class="text-sm" style="color:var(--text-muted)">Commencez votre parcours santé</p>
        </div>
        <button onclick="toggleLoginDark()" style="width:2.25rem;height:2.25rem;border-radius:var(--radius-full);border:1px solid var(--border);background:var(--surface);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-secondary)" title="Mode sombre">
          <i data-lucide="moon" id="loginDarkIcon" style="width:1rem;height:1rem"></i>
        </button>
      </div>

      <form novalidate id="signupForm" style="display:flex;flex-direction:column;gap:1rem">
        <div class="grid grid-cols-2 gap-3">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label"><i data-lucide="user" style="width:0.75rem;height:0.75rem"></i> Prénom</label>
            <input type="text" class="form-input" placeholder="Ahmed" style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label"><i data-lucide="user" style="width:0.75rem;height:0.75rem"></i> Nom</label>
            <input type="text" class="form-input" placeholder="Ben Ali" style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label"><i data-lucide="mail" style="width:0.75rem;height:0.75rem"></i> Adresse email</label>
          <input type="email" class="form-input" placeholder="ahmed@email.com" style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label"><i data-lucide="lock" style="width:0.75rem;height:0.75rem"></i> Mot de passe</label>
          <input type="password" id="signup-pwd" class="form-input" placeholder="Min. 8 caractères" style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
          <div class="flex gap-1 mt-2" id="pwdStrength">
            <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
            <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
            <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
            <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label"><i data-lucide="lock" style="width:0.75rem;height:0.75rem"></i> Confirmer</label>
          <input type="password" class="form-input" placeholder="Retapez votre mot de passe" style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
        </div>
        <label class="flex items-start gap-2" style="color:var(--text-secondary);font-size:0.8rem;cursor:pointer;margin-top:0.25rem">
          <input type="checkbox" style="accent-color:var(--primary);width:1rem;height:1rem;margin-top:2px"> J'accepte les <a href="#" style="color:var(--secondary);font-weight:600">conditions d'utilisation</a> et la <a href="#" style="color:var(--secondary);font-weight:600">politique de confidentialité</a>
        </label>
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius:var(--radius-xl);padding:0.9rem;font-size:0.95rem">
          <i data-lucide="user-plus" style="width:1.125rem;height:1.125rem"></i> Créer mon compte
        </button>
      </form>

      <p class="text-center text-sm mt-6" style="color:var(--text-muted)">
        Déjà inscrit ? <a href="<?= BASE_URL ?>/?page=login" style="color:var(--secondary);font-weight:700;text-decoration:none" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Se connecter</a>
      </p>
    </div>
  </div>
</div>

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
  (function(){ if(localStorage.getItem('theme')==='dark'){ const i=document.getElementById('loginDarkIcon'); if(i){i.setAttribute('data-lucide','sun');lucide.createIcons();} }})();
  // Password strength meter
  document.getElementById('signup-pwd').addEventListener('input', function() {
    const bars = document.querySelectorAll('#pwdStrength div');
    const v = this.value;
    let s = 0;
    if (v.length >= 6) s++;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
    if (/[0-9!@#$%^&*]/.test(v)) s++;
    const colors = ['#ef4444','#f59e0b','#22c55e','#16a34a'];
    bars.forEach((b,i) => { b.style.background = i < s ? colors[Math.min(s-1,3)] : 'var(--border)'; });
  });
  const ERR_ICON = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
  function showFE(field, msg) {
    field.classList.add('is-invalid'); field.classList.remove('is-valid');
    let wrap = field.closest('.form-group') || field.parentElement;
    let el = wrap.querySelector('.field-error');
    if (!el) { el = document.createElement('div'); el.className = 'field-error'; wrap.appendChild(el); }
    el.innerHTML = ERR_ICON + ' ' + msg; el.classList.add('show');
  }
  function clearFE(field) {
    field.classList.remove('is-invalid'); field.classList.add('is-valid');
    const wrap = field.closest('.form-group') || field.parentElement;
    const el = wrap.querySelector('.field-error');
    if (el) el.classList.remove('show');
  }

  // Live blur validation
  const allInputs = document.querySelectorAll('#signupForm input[type="text"], #signupForm input[type="email"], #signupForm input[type="password"]');
  const prenom = allInputs[0], nom = allInputs[1], emailS = allInputs[2], pwdS = allInputs[3], confirmS = allInputs[4];

  prenom.addEventListener('blur', () => { if (!prenom.value.trim() || prenom.value.trim().length < 2) showFE(prenom,'Prénom requis (min. 2 car.)'); else clearFE(prenom); });
  nom.addEventListener('blur', () => { if (!nom.value.trim() || nom.value.trim().length < 2) showFE(nom,'Nom requis (min. 2 car.)'); else clearFE(nom); });
  emailS.addEventListener('blur', () => { if (!emailS.value.trim()) showFE(emailS,"Email obligatoire."); else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailS.value)) showFE(emailS,"Format d'email invalide."); else clearFE(emailS); });
  pwdS.addEventListener('blur', () => { if (!pwdS.value) showFE(pwdS,'Mot de passe obligatoire.'); else if (pwdS.value.length < 8) showFE(pwdS,'Min. 8 caractères.'); else clearFE(pwdS); });
  confirmS.addEventListener('blur', () => { if (!confirmS.value) showFE(confirmS,'Confirmation obligatoire.'); else if (confirmS.value !== pwdS.value) showFE(confirmS,'Les mots de passe ne correspondent pas.'); else clearFE(confirmS); });

  document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let valid = true;
    if (!prenom.value.trim() || prenom.value.trim().length < 2) { showFE(prenom,'Prénom requis (min. 2 car.)'); valid=false; } else clearFE(prenom);
    if (!nom.value.trim() || nom.value.trim().length < 2) { showFE(nom,'Nom requis (min. 2 car.)'); valid=false; } else clearFE(nom);
    if (!emailS.value.trim()) { showFE(emailS,"Email obligatoire."); valid=false; } else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailS.value)){ showFE(emailS,"Format invalide."); valid=false; } else clearFE(emailS);
    if (!pwdS.value) { showFE(pwdS,'Mot de passe obligatoire.'); valid=false; } else if(pwdS.value.length<8){ showFE(pwdS,'Min. 8 caractères.'); valid=false; } else clearFE(pwdS);
    if (!confirmS.value) { showFE(confirmS,'Confirmation obligatoire.'); valid=false; } else if(confirmS.value!==pwdS.value){ showFE(confirmS,'Les mots de passe ne correspondent pas.'); valid=false; } else clearFE(confirmS);
    const terms = this.querySelector('input[type="checkbox"]');
    if (terms && !terms.checked) { showToast('error',"Acceptez les conditions d'utilisation."); valid=false; }
    if (valid) showToast('success', 'Compte créé ! Redirection...');
  });


  function showToast(type, msg) {
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.innerHTML = '<i data-lucide="'+(type==='success'?'check-circle-2':'alert-circle')+'" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i><span style="font-size:0.875rem;font-weight:500">'+msg+'</span>';
    document.getElementById('toastContainer').appendChild(t);
    lucide.createIcons();
    setTimeout(()=>{ t.classList.add('hiding'); setTimeout(()=>t.remove(), 300); }, 3000);
  }
</script>
</body>
</html>
