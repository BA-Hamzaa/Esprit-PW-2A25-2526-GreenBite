<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['role'] === 'ADMIN') {
        header('Location: ' . BASE_URL . '/?page=admin-users');
    } else {
        header('Location: ' . BASE_URL . '/');
    }
    exit();
}

require_once BASE_PATH . '/app/controllers/AuthController.php';

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth   = new AuthController();
    $result = $auth->Login($_POST['email'], $_POST['password']);
    if (isset($result['error'])) {
        $error = $result['error'];
    }
}
?>


<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NutriGreen — Connexion">
  <title>Connexion — NutriGreen</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/variables.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fonts.css">
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
      <h1 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:800;color:#fff;margin-bottom:0.75rem;letter-spacing:-0.03em">NutriGreen</h1>
      <p style="color:rgba(255,255,255,0.6);font-size:1rem;max-width:20rem;margin:0 auto;line-height:1.6">Votre compagnon intelligent pour une alimentation durable et un mode de vie sain.</p>
      <div class="flex gap-4 justify-center mt-8" style="color:rgba(255,255,255,0.4);font-size:0.8rem">
        <div class="flex items-center gap-2"><i data-lucide="utensils-crossed" style="width:0.85rem;height:0.85rem"></i> Nutrition</div>
        <div class="flex items-center gap-2"><i data-lucide="shopping-basket" style="width:0.85rem;height:0.85rem"></i> Marketplace</div>
        <div class="flex items-center gap-2"><i data-lucide="book-open" style="width:0.85rem;height:0.85rem"></i> Recettes</div>
      </div>
    </div>
  </div>

  <!-- Right panel - form -->
  <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:26rem">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:var(--text-primary)">Connexion</h2>
          <p class="text-sm" style="color:var(--text-muted)">Accédez à votre espace NutriGreen</p>
        </div>
        <button onclick="toggleLoginDark()" style="width:2.25rem;height:2.25rem;border-radius:var(--radius-full);border:1px solid var(--border);background:var(--surface);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-secondary);transition:all 0.3s" title="Mode sombre">
          <i data-lucide="moon" id="loginDarkIcon" style="width:1rem;height:1rem"></i>
        </button>
      </div>
<?php if (isset($error) && $error): ?>
  <div style="background:#fee2e2;color:#dc2626;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
    <i data-lucide="alert-circle" style="width:1rem;height:1rem;flex-shrink:0"></i>
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>
<form method="POST" action="<?= BASE_URL ?>/?page=login" style="display:flex;flex-direction:column;gap:1.25rem">
          <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="login-email"><i data-lucide="mail" style="width:0.75rem;height:0.75rem"></i> Adresse email</label>
<input type="email" id="login-email" name="email" class="form-input" placeholder="votre@email.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" style="padding:0.85rem 1rem;border-radius:var(--radius-xl)">        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label" for="login-password"><i data-lucide="lock" style="width:0.75rem;height:0.75rem"></i> Mot de passe</label>
          <div style="position:relative">
<input type="password" id="login-password" name="password" class="form-input" placeholder="••••••••" style="padding:0.85rem 1rem;border-radius:var(--radius-xl);padding-right:3rem">
            <button type="button" onclick="togglePwd('login-password', this)" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0.25rem">
              <i data-lucide="eye" style="width:1rem;height:1rem"></i>
            </button>
          </div>
        </div>
        <div class="flex items-center justify-between" style="font-size:0.8rem">
          <label class="flex items-center gap-2" style="color:var(--text-secondary);cursor:pointer">
            <input type="checkbox" style="accent-color:var(--primary);width:1rem;height:1rem;border-radius:4px"> Se souvenir de moi
          </label>
          <a href="#" style="color:var(--secondary);font-weight:600;text-decoration:none" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Mot de passe oublié ?</a>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius:var(--radius-xl);padding:0.9rem;font-size:0.95rem;margin-top:0.5rem">
          <i data-lucide="log-in" style="width:1.125rem;height:1.125rem"></i> Se connecter
        </button>
      </form>

      <div style="display:flex;align-items:center;gap:1rem;margin:1.5rem 0">
        <div style="flex:1;height:1px;background:var(--border)"></div>
        <span class="text-xs" style="color:var(--text-muted)">OU</span>
        <div style="flex:1;height:1px;background:var(--border)"></div>
      </div>

      <button class="btn btn-outline btn-block" style="border-radius:var(--radius-xl);padding:0.8rem;font-size:0.85rem" onclick="showToast('success', 'Connexion Google en cours...')">
        <i data-lucide="chrome" style="width:1rem;height:1rem"></i> Continuer avec Google
      </button>

<p class="text-center text-sm mt-6" style="color:var(--text-muted)">
  Pas encore de compte ? <a href="<?= BASE_URL ?>/?page=signup" style="color:var(--secondary);font-weight:700;text-decoration:none" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Créer un compte</a>
</p>
    </div>
  </div>
</div>

<!-- Toast container -->
<div id="toastContainer"></div>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
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
  function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    const ico = btn.querySelector('[data-lucide]');
    ico.setAttribute('data-lucide', inp.type === 'password' ? 'eye' : 'eye-off');
    lucide.createIcons();
  }
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