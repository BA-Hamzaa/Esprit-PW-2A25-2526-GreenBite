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
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth   = new AuthController();
    $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;
    $result = $auth->Login($_POST['email'], $_POST['password'], $recaptchaResponse);
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
          <a href="<?= BASE_URL ?>/?page=forgot-password" style="color:var(--secondary);font-weight:600;text-decoration:none" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Mot de passe oublié ?</a>
        </div>
        <div style="margin-top:0.5rem">
          <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired"></div>
        </div>
        <button type="submit" id="loginSubmitBtn" class="btn btn-primary btn-lg btn-block" style="border-radius:var(--radius-xl);padding:0.9rem;font-size:0.95rem;margin-top:0.5rem" disabled>
          <i data-lucide="log-in" style="width:1.125rem;height:1.125rem"></i> Se connecter
        </button>
      </form>

      <div style="display:flex;align-items:center;gap:1rem;margin:1.5rem 0">
        <div style="flex:1;height:1px;background:var(--border)"></div>
        <span class="text-xs" style="color:var(--text-muted)">OU</span>
        <div style="flex:1;height:1px;background:var(--border)"></div>
      </div>

      <div style="display:flex;gap:1rem">
        <a href="<?= BASE_URL ?>/?page=google-auth" class="btn btn-outline btn-block" style="flex:1;display:inline-flex;align-items:center;justify-content:center;border-radius:var(--radius-xl);padding:0.8rem;font-size:0.85rem;text-decoration:none;color:inherit">
          <svg style="width:1rem;height:1rem;margin-right:0.5rem" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg> Google
        </a>
        <button type="button" onclick="openFaceIdModal()" class="btn btn-outline btn-block" style="flex:1;display:inline-flex;align-items:center;justify-content:center;border-radius:var(--radius-xl);padding:0.8rem;font-size:0.85rem;text-decoration:none;color:inherit">
          <i data-lucide="scan-face" style="width:1rem;height:1rem;margin-right:0.5rem"></i> Face ID
        </button>
      </div>

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
  function recaptchaCallback(token) {
    document.getElementById('loginSubmitBtn').disabled = false;
  }
  function recaptchaExpired() {
    document.getElementById('loginSubmitBtn').disabled = true;
  }
</script>
<!-- Face ID Modal -->
<div id="faceIdModal" class="modal-overlay">
  <div class="modal-box" style="text-align:center;max-width:400px;width:100%">
    <h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:700;margin-bottom:1rem;color:var(--text-primary)">Connexion Face ID</h3>
    
    <div id="login-video-container" class="relative mx-auto rounded-xl overflow-hidden shadow-sm bg-gray-100" style="width:300px; height:225px; display:flex; align-items:center; justify-content:center;margin-bottom:1rem">
        <div id="login-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100 z-10">
            <i data-lucide="loader-2" class="animate-spin text-primary w-8 h-8 mb-2"></i>
            <span class="text-sm">Chargement de l'IA...</span>
        </div>
        <video id="login-video" width="300" height="225" autoplay muted class="object-cover w-full h-full" style="display:none;"></video>
        <canvas id="login-overlay" class="absolute top-0 left-0 w-full h-full z-20 pointer-events-none"></canvas>
    </div>

    <p id="login-status-msg" class="text-sm font-medium mb-4" style="color:var(--text-secondary)">Placez votre visage devant la caméra.</p>
    
    <button type="button" onclick="closeFaceIdModal()" class="btn btn-outline btn-block">Annuler</button>
  </div>
</div>

<!-- Scripts Face ID -->
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script>
let faceIdInterval;
let faceIdStream;

async function openFaceIdModal() {
    document.getElementById('faceIdModal').classList.add('active');
    
    const video = document.getElementById('login-video');
    const loading = document.getElementById('login-loading');
    const statusMsg = document.getElementById('login-status-msg');
    const overlay = document.getElementById('login-overlay');
    
    statusMsg.textContent = "Chargement des modèles...";
    
    const MODEL_URL = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights';
    try {
        await Promise.all([
            faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);
        
        loading.style.display = 'none';
        video.style.display = 'block';
        statusMsg.textContent = "Recherche d'un visage...";
        
        faceIdStream = await navigator.mediaDevices.getUserMedia({ video: {} });
        video.srcObject = faceIdStream;
        
        video.onplay = () => {
            const displaySize = { width: video.width, height: video.height };
            faceapi.matchDimensions(overlay, displaySize);
            
            faceIdInterval = setInterval(async () => {
                const detections = await faceapi.detectSingleFace(video).withFaceLandmarks().withFaceDescriptor();
                const ctx = overlay.getContext('2d');
                ctx.clearRect(0, 0, overlay.width, overlay.height);
                
                if (detections) {
                    const resizedDetections = faceapi.resizeResults(detections, displaySize);
                    faceapi.draw.drawDetections(overlay, resizedDetections);
                    
                    clearInterval(faceIdInterval);
                    statusMsg.textContent = "Visage détecté ! Vérification...";
                    statusMsg.style.color = 'var(--primary)';
                    
                    const descriptor = Array.from(detections.descriptor);
                    
                    fetch('<?= BASE_URL ?>/?page=api-face-login', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ descriptor })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            statusMsg.textContent = "Bienvenue " + data.user.username + " !";
                            statusMsg.style.color = 'green';
                            setTimeout(() => window.location.href = '<?= BASE_URL ?>/', 1000);
                        } else {
                            statusMsg.textContent = data.error;
                            statusMsg.style.color = 'red';
                            setTimeout(closeFaceIdModal, 2000);
                        }
                    })
                    .catch(e => {
                        statusMsg.textContent = "Erreur serveur.";
                        statusMsg.style.color = 'red';
                        setTimeout(closeFaceIdModal, 2000);
                    });
                }
            }, 500);
        };
        
    } catch (e) {
        statusMsg.textContent = "Erreur de caméra ou IA.";
        statusMsg.style.color = 'red';
    }
}

function closeFaceIdModal() {
    document.getElementById('faceIdModal').classList.remove('active');
    if (faceIdInterval) clearInterval(faceIdInterval);
    if (faceIdStream) {
        faceIdStream.getTracks().forEach(track => track.stop());
    }
    document.getElementById('login-video').style.display = 'none';
    document.getElementById('login-loading').style.display = 'flex';
}
</script>
</body>
</html>