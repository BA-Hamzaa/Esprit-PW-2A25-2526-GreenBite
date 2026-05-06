<?php
// Si déjà connecté → rediriger
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: ' . BASE_URL . '/');
    exit();
}

require_once BASE_PATH . '/app/controllers/UserController.php';
require_once BASE_PATH . '/config/recaptcha.php';

$error  = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm'];
    $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;

    // Vérifier reCAPTCHA
    $recaptchaResult = verifyRecaptcha($recaptchaResponse);
    if (!$recaptchaResult['success']) {
        $error = $recaptchaResult['message'];
    } elseif (empty($username) || empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== $confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        $ctrl = new UserController();

        // Vérifier si email déjà utilisé
        $existing = $ctrl->RecupererUserByEmail($email);
        if ($existing) {
            $error = 'Cet email est déjà utilisé.';
        } else {
            // Créer le user avec rôle USER par défaut
            $user = new User($username, $email, $password, 'USER');
            $ctrl->AjouterUser($user, $_FILES['avatar'] ?? null);
            $success = 'Compte créé avec succès ! Vous pouvez vous connecter.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NutriGreen — Inscription">
  <title>Inscription — NutriGreen</title>
<!-- NOUVEAU -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/variables.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/fonts.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
      <h1 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:800;color:#fff;margin-bottom:0.75rem">NutriGreen</h1>
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
<?php if ($error): ?>
  <div style="background:#fee2e2;color:#dc2626;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
    <i data-lucide="alert-circle" style="width:1rem;height:1rem;flex-shrink:0"></i>
    <?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<?php if ($success): ?>
  <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
    <i data-lucide="check-circle-2" style="width:1rem;height:1rem;flex-shrink:0"></i>
    <?= htmlspecialchars($success) ?>
    <a href="<?= BASE_URL ?>/?page=login" style="color:#166534;font-weight:700;margin-left:0.5rem">→ Se connecter</a>
  </div>
<?php endif; ?>
<form method="POST" action="<?= BASE_URL ?>/?page=signup" enctype="multipart/form-data" id="signupForm" novalidate style="display:flex;flex-direction:column;gap:1rem">

  <!-- Username -->
  <div class="form-group" style="margin-bottom:0">
    <label class="form-label"><i data-lucide="user" style="width:0.75rem;height:0.75rem"></i> Nom d'utilisateur</label>
    <input type="text" name="username" id="signup-username" class="form-input"
           placeholder="john_doe"
           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
           style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
    <span id="err-username" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
  </div>

  <!-- Email -->
  <div class="form-group" style="margin-bottom:0">
    <label class="form-label"><i data-lucide="mail" style="width:0.75rem;height:0.75rem"></i> Adresse email</label>
    <input type="email" name="email" id="signup-email" class="form-input"
           placeholder="ahmed@email.com"
           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
           style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
    <span id="err-email" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
  </div>

  <!-- Password -->
  <div class="form-group" style="margin-bottom:0">
    <label class="form-label"><i data-lucide="lock" style="width:0.75rem;height:0.75rem"></i> Mot de passe</label>
    <input type="password" name="password" id="signup-pwd" class="form-input"
           placeholder="Min. 8 caractères"
           style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
    <div class="flex gap-1 mt-2" id="pwdStrength">
      <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
      <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
      <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
      <div style="flex:1;height:3px;border-radius:4px;background:var(--border);transition:all 0.3s"></div>
    </div>
    <span id="err-password" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
  </div>

  <!-- Confirm Password -->
  <div class="form-group" style="margin-bottom:0">
    <label class="form-label"><i data-lucide="lock" style="width:0.75rem;height:0.75rem"></i> Confirmer</label>
    <input type="password" name="confirm" id="signup-confirm" class="form-input"
           placeholder="Retapez votre mot de passe"
           style="padding:0.8rem 1rem;border-radius:var(--radius-xl)">
    <span id="err-confirm" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
  </div>

  <!-- Avatar (optionnel) -->
  <div class="form-group" style="margin-bottom:0">
    <label class="form-label">
      <i data-lucide="image" style="width:0.75rem;height:0.75rem"></i>
      Photo de profil <span style="color:var(--text-muted);font-weight:400">(optionnel)</span>
    </label>
    <input type="file" name="avatar" id="signup-avatar" accept="image/*"
           style="padding:0.6rem 1rem;border-radius:var(--radius-xl);border:1px solid var(--border);background:var(--surface);width:100%;font-size:0.8rem;cursor:pointer;color:var(--text-secondary)">
    <span id="err-avatar" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
  </div>

  <!-- CGU -->
  <label class="flex items-start gap-2" style="color:var(--text-secondary);font-size:0.8rem;cursor:pointer;margin-top:0.25rem">
    <input type="checkbox" id="signup-cgu" style="accent-color:var(--primary);width:1rem;height:1rem;margin-top:2px">
    J'accepte les <a href="#" style="color:var(--secondary);font-weight:600">conditions d'utilisation</a> et la <a href="#" style="color:var(--secondary);font-weight:600">politique de confidentialité</a>
  </label>
  <span id="err-cgu" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:-8px"></span>

  <!-- reCAPTCHA -->
  <div style="margin-top:0.5rem">
    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired"></div>
  </div>

  <!-- Submit -->
  <button type="submit" id="signupSubmitBtn" class="btn btn-primary btn-lg btn-block" style="border-radius:var(--radius-xl);padding:0.9rem;font-size:0.95rem" disabled>
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
  // ==================== LUCIDE ====================
  if (typeof lucide !== 'undefined') lucide.createIcons();

  // ==================== DARK MODE ====================
  function toggleLoginDark() {
    const html = document.documentElement;
    const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    const icon = document.getElementById('loginDarkIcon');
    if (icon) {
      icon.setAttribute('data-lucide', next === 'dark' ? 'sun' : 'moon');
      lucide.createIcons();
    }
  }
  (function () {
    if (localStorage.getItem('theme') === 'dark') {
      const i = document.getElementById('loginDarkIcon');
      if (i) { i.setAttribute('data-lucide', 'sun'); lucide.createIcons(); }
    }
  })();

  // ==================== PASSWORD STRENGTH ====================
  document.getElementById('signup-pwd').addEventListener('input', function () {
    const bars = document.querySelectorAll('#pwdStrength div');
    const v = this.value;
    let s = 0;
    if (v.length >= 6) s++;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
    if (/[0-9!@#$%^&*]/.test(v)) s++;
    const colors = ['#ef4444', '#f59e0b', '#22c55e', '#16a34a'];
    bars.forEach((b, i) => {
      b.style.background = i < s ? colors[Math.min(s - 1, 3)] : 'var(--border)';
    });
    // Effacer l'erreur en live
    clearErr('err-password');
  });

  // ==================== LIVE VALIDATION ====================
  document.getElementById('signup-username').addEventListener('input', function () {
    const v = this.value.trim();
    if (!v) {
      showErr('err-username', "Le nom d'utilisateur est obligatoire.");
    } else if (v.length < 3) {
      showErr('err-username', "Minimum 3 caractères.");
    } else {
      clearErr('err-username');
      setBorder(this, true);
    }
  });

  document.getElementById('signup-email').addEventListener('input', function () {
    const v = this.value.trim();
    if (!v) {
      showErr('err-email', "L'email est obligatoire.");
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
      showErr('err-email', "Adresse email invalide.");
    } else {
      clearErr('err-email');
      setBorder(this, true);
    }
  });

  document.getElementById('signup-confirm').addEventListener('input', function () {
    const pwd     = document.getElementById('signup-pwd').value;
    const confirm = this.value;
    if (!confirm) {
      showErr('err-confirm', "Veuillez confirmer votre mot de passe.");
    } else if (pwd !== confirm) {
      showErr('err-confirm', "Les mots de passe ne correspondent pas.");
    } else {
      clearErr('err-confirm');
      setBorder(this, true);
    }
  });

  document.getElementById('signup-avatar').addEventListener('change', function () {
    const file    = this.files[0];
    const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (file) {
      if (!allowed.includes(file.type)) {
        showErr('err-avatar', "Format non supporté (jpg, png, webp, gif).");
      } else if (file.size > 2 * 1024 * 1024) {
        showErr('err-avatar', "Image trop lourde (max 2MB).");
      } else {
        clearErr('err-avatar');
      }
    }
  });

  // ==================== SUBMIT VALIDATION ====================
  document.getElementById('signupForm').addEventListener('submit', function (e) {
    let valid = true;

    // Reset toutes les erreurs
    document.querySelectorAll('[id^="err-"]').forEach(el => {
      el.style.display = 'none';
      el.textContent   = '';
    });

    const username = document.getElementById('signup-username').value.trim();
    const email    = document.getElementById('signup-email').value.trim();
    const password = document.getElementById('signup-pwd').value;
    const confirm  = document.getElementById('signup-confirm').value;
    const avatar   = document.getElementById('signup-avatar').files[0];
    const cgu      = document.getElementById('signup-cgu').checked;

    // Username
    if (!username) {
      showErr('err-username', "Le nom d'utilisateur est obligatoire."); valid = false;
    } else if (username.length < 3) {
      showErr('err-username', "Minimum 3 caractères."); valid = false;
    }

    // Email
    if (!email) {
      showErr('err-email', "L'email est obligatoire."); valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showErr('err-email', "Adresse email invalide."); valid = false;
    }

    // Password
    if (!password) {
      showErr('err-password', "Le mot de passe est obligatoire."); valid = false;
    } else if (password.length < 8) {
      showErr('err-password', "Minimum 8 caractères."); valid = false;
    }

    // Confirm
    if (!confirm) {
      showErr('err-confirm', "Veuillez confirmer votre mot de passe."); valid = false;
    } else if (password !== confirm) {
      showErr('err-confirm', "Les mots de passe ne correspondent pas."); valid = false;
    }

    // Avatar optionnel
    if (avatar) {
      const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
      if (!allowed.includes(avatar.type)) {
        showErr('err-avatar', "Format non supporté (jpg, png, webp, gif)."); valid = false;
      } else if (avatar.size > 2 * 1024 * 1024) {
        showErr('err-avatar', "Image trop lourde (max 2MB)."); valid = false;
      }
    }

    // CGU
    if (!cgu) {
      showErr('err-cgu', "Vous devez accepter les conditions d'utilisation."); valid = false;
    }

    if (!valid) e.preventDefault();
  });

  // ==================== HELPERS ====================
  function showErr(id, msg) {
    const el = document.getElementById(id);
    if (el) {
      el.textContent   = msg;
      el.style.display = 'block';
      // Mettre la bordure rouge sur l'input associé
      const input = el.previousElementSibling?.tagName === 'INPUT'
        ? el.previousElementSibling
        : document.querySelector('[id^="signup-"]');
      setBorderById(id.replace('err-', 'signup-'), false);
    }
  }

  function clearErr(id) {
    const el = document.getElementById(id);
    if (el) { el.style.display = 'none'; el.textContent = ''; }
    setBorderById(id.replace('err-', 'signup-'), true);
  }

  function setBorder(input, valid) {
    input.style.borderColor = valid ? 'var(--primary)' : '#dc2626';
  }

  function setBorderById(inputId, valid) {
    const input = document.getElementById(inputId);
    if (input) setBorder(input, valid);
  }

  // ==================== reCAPTCHA ====================
  function recaptchaCallback(token) {
    document.getElementById('signupSubmitBtn').disabled = false;
  }
  function recaptchaExpired() {
    document.getElementById('signupSubmitBtn').disabled = true;
  }
</script>
</body>
</html>
