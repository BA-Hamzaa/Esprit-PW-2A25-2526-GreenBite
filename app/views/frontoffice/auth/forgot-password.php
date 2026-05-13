<?php
require_once BASE_PATH . '/app/controllers/AuthController.php';

$error = null;
$success = null;

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $result = $auth->RequestPasswordReset($_POST['email']);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        $success = $result['success'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NutriGreen — Mot de passe oublié">
  <title>Mot de passe oublié — NutriGreen</title>
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
    </div>
  </div>

  <!-- Right panel - form -->
  <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:26rem">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:var(--text-primary)">Mot de passe oublié</h2>
          <p class="text-sm" style="color:var(--text-muted)">Entrez votre email pour réinitialiser votre mot de passe</p>
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

<?php if (isset($success) && $success): ?>
  <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
    <i data-lucide="check-circle-2" style="width:1rem;height:1rem;flex-shrink:0"></i>
    <?= htmlspecialchars($success) ?>
  </div>
<?php endif; ?>

<?php if (!isset($success)): ?>
<form method="POST" action="<?= BASE_URL ?>/?page=forgot-password" style="display:flex;flex-direction:column;gap:1.25rem">
  <div class="form-group" style="margin-bottom:0">
    <label class="form-label" for="email"><i data-lucide="mail" style="width:0.75rem;height:0.75rem"></i> Adresse email</label>
    <input type="email" id="email" name="email" class="form-input" placeholder="votre@email.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" style="padding:0.85rem 1rem;border-radius:var(--radius-xl)" required>
  </div>
  <button type="submit" class="btn btn-primary btn-lg btn-block" style="border-radius:var(--radius-xl);padding:0.9rem;font-size:0.95rem;margin-top:0.5rem">
    <i data-lucide="send" style="width:1.125rem;height:1.125rem"></i> Envoyer le lien de réinitialisation
  </button>
</form>
<?php endif; ?>

<p class="text-center text-sm mt-6" style="color:var(--text-muted)">
  <a href="<?= BASE_URL ?>/?page=login" style="color:var(--secondary);font-weight:700;text-decoration:none" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
    <i data-lucide="arrow-left" style="width:0.875rem;height:0.875rem;display:inline"></i> Retour à la connexion
  </a>
</p>
    </div>
  </div>
</div>

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
</script>
</body>
</html>
