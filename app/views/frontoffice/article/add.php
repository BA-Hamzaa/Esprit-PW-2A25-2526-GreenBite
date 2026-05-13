<?php
$roles = [
    'Passionné de cuisine'     => '🍳 Passionné de cuisine',
    'Chef cuisinier'           => '👨‍🍳 Chef cuisinier',
    'Nutritionniste'           => '🥗 Nutritionniste',
    'Diététicien(ne)'          => '📋 Diététicien(ne)',
    'Étudiant en nutrition'    => '🎓 Étudiant en nutrition',
    'Athlète / Sportif'        => '🏋️ Athlète / Sportif',
    'Parent'                   => '👨‍👩‍👧 Parent',
    'Jardinier urbain'         => '🌻 Jardinier urbain',
    'Food lover'               => '🍕 Food lover',
    'Éco-activiste'            => '🌍 Éco-activiste',
    'Autre'                    => '✨ Autre',
];
?>

<style>
/* ─── Dynamic validation styles (same as regime) ─── */
.art-field-error {
  display: none;
  align-items: center;
  gap: 0.35rem;
  margin-top: 0.35rem;
  font-size: 0.75rem;
  font-weight: 600;
  color: #ef4444;
  animation: artFadeUp 0.2s ease;
}
.art-field-error.visible { display: flex; }
.art-input-invalid {
  border-color: #ef4444 !important;
  box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important;
}
.art-input-valid {
  border-color: #22c55e !important;
  box-shadow: 0 0 0 3px rgba(34,197,94,0.10) !important;
}
@keyframes artFadeUp {
  from { opacity:0; transform:translateY(4px); }
  to   { opacity:1; transform:translateY(0); }
}

/* ─── Form field base ─── */
.art-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1.5px solid var(--border);
  border-radius: 0.875rem;
  font-size: 0.9rem;
  background: var(--surface);
  color: var(--foreground);
  transition: all 0.25s;
  outline: none;
  font-family: inherit;
}
.art-input:focus {
  border-color: var(--secondary);
  box-shadow: 0 0 0 3px rgba(82,183,136,0.12);
}
.art-label {
  display: block;
  font-size: 0.82rem;
  font-weight: 700;
  color: var(--text-secondary);
  margin-bottom: 0.45rem;
  display: flex;
  align-items: center;
  gap: 0.35rem;
}
.art-char-count {
  font-size: 0.7rem;
  color: var(--text-muted);
  text-align: right;
  margin-top: 0.3rem;
  transition: color 0.2s;
}
.art-char-count.warn  { color: #d97706; }
.art-char-count.error { color: #ef4444; font-weight: 700; }

/* ─── Step indicator ─── */
.art-steps {
  display: flex;
  align-items: center;
  gap: 0;
  margin-bottom: 2rem;
}
.art-step {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--text-muted);
}
.art-step-dot {
  width: 1.75rem;
  height: 1.75rem;
  border-radius: 50%;
  background: var(--muted);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.7rem;
  font-weight: 800;
  color: var(--text-muted);
  transition: all 0.3s;
  flex-shrink: 0;
}
.art-step.done .art-step-dot {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: #fff;
}
.art-step.active .art-step-dot {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  color: #fff;
  box-shadow: 0 4px 12px rgba(245,158,11,0.4);
}
.art-step-line {
  flex: 1;
  height: 2px;
  background: var(--border);
  margin: 0 0.4rem;
}

/* ─── Submit button glow ─── */
.art-submit-btn {
  position: relative;
  overflow: hidden;
}
.art-submit-btn::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
  pointer-events: none;
}
.art-submit-btn:disabled {
  opacity: 0.55;
  cursor: not-allowed;
}

/* PIN strength dots */
.pin-dots {
  display: flex;
  gap: 0.4rem;
  margin-top: 0.5rem;
}
.pin-dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  background: var(--border);
  transition: all 0.2s;
}
.pin-dot.filled {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  box-shadow: 0 0 6px rgba(245,158,11,0.5);
}
</style>

<div style="padding:2rem;max-width:820px;margin:0 auto">

  <!-- HEADER -->
  <div class="flex items-center justify-between mb-7">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;
                  background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:1.1rem;
                  box-shadow:0 8px 24px rgba(234,179,8,0.35)">
        <i data-lucide="pen-line" style="width:1.75rem;height:1.75rem;color:#b45309"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:900;
                   color:var(--text-primary);letter-spacing:-0.02em;
                   display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.6rem;
                       background:linear-gradient(180deg,#f59e0b,#d97706);border-radius:2px"></span>
          Partager un article
        </h1>
        <p style="font-size:0.82rem;color:var(--text-muted);margin:4px 0 0 0">
          Votre expérience inspire la communauté 🌿 — soumis pour validation avant publication.
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn btn-outline"
       style="border-radius:var(--radius-full);gap:0.4rem">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour
    </a>
  </div>

  <!-- INFO BANNER -->
  <div style="background:linear-gradient(135deg,rgba(59,130,246,0.08),rgba(59,130,246,0.04));
              border:1px solid rgba(59,130,246,0.2);border-radius:var(--radius-xl);
              padding:0.9rem 1.2rem;display:flex;align-items:flex-start;gap:0.75rem;margin-bottom:1.75rem">
    <i data-lucide="info" style="width:1rem;height:1rem;color:#3b82f6;flex-shrink:0;margin-top:2px"></i>
    <p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;margin:0">
      <strong>Comment ça marche ?</strong> Remplissez le formulaire → votre article passe en révision →
      une fois approuvé, il apparaît dans le Blog. Gardez votre <strong>code PIN</strong> pour retrouver
      et modifier vos articles plus tard.
    </p>
  </div>

  <!-- SERVER ERROR BOX (fallback) -->
  <?php if (!empty($errors)): ?>
    <div style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1.5px solid #fca5a5;
                border-radius:var(--radius-xl);padding:1rem 1.25rem;margin-bottom:1.5rem">
      <?php foreach ($errors as $err): ?>
        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:#dc2626;padding:0.2rem 0">
          <i data-lucide="alert-circle" style="width:0.875rem;height:0.875rem;flex-shrink:0"></i>
          <?= htmlspecialchars($err) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- FORM -->
  <form method="post" action="<?= BASE_URL ?>/?page=article&action=add"
        id="articleAddForm" novalidate
        style="display:flex;flex-direction:column;gap:0">

    <div class="card" style="padding:2.25rem;border:1.5px solid var(--border);border-radius:1.25rem;
                              display:flex;flex-direction:column;gap:1.6rem">

      <!-- ════ ROW 1 : Titre + Auteur ════ -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">

        <!-- Titre -->
        <div>
          <label for="aaTitre" class="art-label">
            <i data-lucide="type" style="width:0.85rem;height:0.85rem;color:#f59e0b"></i>
            Titre de l'article <span style="color:#ef4444">*</span>
          </label>
          <input type="text" name="titre" id="aaTitre" class="art-input"
                 value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
                 placeholder="Ex: Les bienfaits du jeûne intermittent..."
                 maxlength="150" autocomplete="off">
          <div class="art-char-count" id="aaTitreCount">0 / 150</div>
          <div class="art-field-error" id="err-aaTitre">
            <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
            <span></span>
          </div>
        </div>

        <!-- Auteur -->
        <div>
          <label for="aaAuteur" class="art-label">
            <i data-lucide="user" style="width:0.85rem;height:0.85rem;color:#3b82f6"></i>
            Votre nom <span style="color:#ef4444">*</span>
          </label>
          <input type="text" name="auteur" id="aaAuteur" class="art-input"
                 value="<?= htmlspecialchars($_POST['auteur'] ?? $_SESSION['username'] ?? '') ?>"
                 placeholder="Ex: Amine Khoury"
                 maxlength="120" autocomplete="name">
          <div class="art-field-error" id="err-aaAuteur">
            <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
            <span></span>
          </div>
        </div>
      </div>

      <!-- ════ ROW 2 : PIN + Profil ════ -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">

        <!-- PIN -->
        <div>
          <label for="aaPin" class="art-label">
            <i data-lucide="key-round" style="width:0.85rem;height:0.85rem;color:#f59e0b"></i>
            Code PIN (4 chiffres) <span style="color:#ef4444">*</span>
          </label>
          <input type="text" name="pin" id="aaPin" class="art-input"
                 value="<?= htmlspecialchars($_POST['pin'] ?? '') ?>"
                 placeholder="Ex: 1234"
                 maxlength="4" inputmode="numeric" pattern="\d{4}"
                 style="letter-spacing:0.4em;font-size:1.2rem;font-weight:700;max-width:160px">
          <div class="pin-dots" id="aaPinDots">
            <div class="pin-dot" id="pd0"></div>
            <div class="pin-dot" id="pd1"></div>
            <div class="pin-dot" id="pd2"></div>
            <div class="pin-dot" id="pd3"></div>
          </div>
          <p style="font-size:0.7rem;color:var(--text-muted);margin:0.3rem 0 0">
            🔐 Gardez-le précieusement — il vous permettra de retrouver vos articles.
          </p>
          <div class="art-field-error" id="err-aaPin">
            <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
            <span></span>
          </div>
        </div>

        <!-- Profil / Rôle -->
        <div>
          <label for="aaRole" class="art-label">
            <i data-lucide="badge-check" style="width:0.85rem;height:0.85rem;color:#8b5cf6"></i>
            Votre profil <span style="color:#ef4444">*</span>
          </label>
          <select name="role_utilisateur" id="aaRole" class="art-input"
                  style="cursor:pointer;appearance:none;
                         background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23555b6e%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22/></svg>');
                         background-repeat:no-repeat;background-position:right 0.9rem center;background-size:1.1rem;
                         padding-right:2.5rem">
            <option value="" disabled <?= empty($_POST['role_utilisateur']) ? 'selected' : '' ?>>
              -- Choisissez votre profil --
            </option>
            <?php foreach ($roles as $value => $label): ?>
              <option value="<?= htmlspecialchars($value) ?>"
                      <?= (($_POST['role_utilisateur'] ?? '') === $value) ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p style="font-size:0.7rem;color:var(--text-muted);margin:0.3rem 0 0">
            Aide les lecteurs à mieux comprendre votre point de vue.
          </p>
          <div class="art-field-error" id="err-aaRole">
            <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
            <span></span>
          </div>
        </div>
      </div>

      <!-- ════ ROW 3 : Contenu ════ -->
      <div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.45rem">
          <label for="aaContenu" class="art-label" style="margin-bottom:0">
            <i data-lucide="file-text" style="width:0.85rem;height:0.85rem;color:#10b981"></i>
            Contenu de l'article <span style="color:#ef4444">*</span>
          </label>
          <span style="font-size:0.7rem;color:var(--text-muted)">min 20 caractères</span>
        </div>
        <textarea name="contenu" id="aaContenu" class="art-input" rows="10"
                  placeholder="Rédigez votre article ici...

Partagez vos expériences, astuces, recettes ou découvertes autour de l'alimentation saine et durable. Un bon article fait au moins 20 caractères. 🌿"
                  style="line-height:1.75;resize:vertical;min-height:220px"><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div style="display:flex;align-items:center;justify-content:space-between">
          <div class="art-field-error" id="err-aaContenu" style="margin-top:0.35rem">
            <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
            <span></span>
          </div>
          <div class="art-char-count" id="aaContenuCount" style="margin-left:auto">0 caractères</div>
        </div>
      </div>

      <!-- ════ SUBMIT ════ -->
      <div style="display:flex;align-items:center;justify-content:space-between;
                  padding-top:1rem;border-top:1.5px solid var(--border)">
        <div style="font-size:0.75rem;color:var(--text-muted);display:flex;align-items:center;gap:0.4rem">
          <i data-lucide="shield-check" style="width:0.85rem;height:0.85rem;color:var(--primary)"></i>
          Votre article sera relu avant publication
        </div>
        <button type="submit" id="aaSubmitBtn" class="btn btn-primary art-submit-btn"
                style="padding:0.8rem 2.2rem;font-size:0.95rem;border-radius:var(--radius-full);
                       gap:0.5rem;position:relative">
          <i data-lucide="send" style="width:1rem;height:1rem"></i>
          Soumettre pour validation
        </button>
      </div>

    </div>
  </form>

</div>

<script>
/* ================================================================
   DYNAMIC VALIDATION — Article Add Form (same pattern as Regime)
================================================================ */

/* ── helpers ── */
function artShowError(fieldId, message) {
  const field  = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return false;
  field.classList.remove('art-input-valid');
  field.classList.add('art-input-invalid');
  errBox.querySelector('span').textContent = message;
  errBox.classList.add('visible');
  if (typeof lucide !== 'undefined') lucide.createIcons();
  return false;
}

function artClearError(fieldId) {
  const field  = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return true;
  field.classList.remove('art-input-invalid');
  errBox.classList.remove('visible');
  return true;
}

function artMarkValid(fieldId) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  artClearError(fieldId);
  field.classList.add('art-input-valid');
}

/* ── PIN dots visual ── */
function updatePinDots(val) {
  for (let i = 0; i < 4; i++) {
    const dot = document.getElementById('pd' + i);
    if (dot) dot.classList.toggle('filled', i < val.length);
  }
}

/* ── char counter ── */
function updateCharCount(inputId, countId, max) {
  const el  = document.getElementById(inputId);
  const cnt = document.getElementById(countId);
  if (!el || !cnt) return;
  const len = el.value.length;
  cnt.textContent = max ? `${len} / ${max}` : `${len} caractères`;
  cnt.classList.remove('warn','error');
  if (max && len > max * 0.85) cnt.classList.add(len > max ? 'error' : 'warn');
}

/* ─────────────── Validators ─────────────── */
function validateTitre() {
  artClearError('aaTitre');
  const val = document.getElementById('aaTitre').value.trim();
  if (!val)             return artShowError('aaTitre', 'Le titre est obligatoire.');
  if (val.length < 3)   return artShowError('aaTitre', 'Le titre doit contenir au moins 3 caractères.');
  if (val.length > 150) return artShowError('aaTitre', 'Le titre ne peut pas dépasser 150 caractères.');
  artMarkValid('aaTitre');
  return true;
}

function validateAuteur() {
  artClearError('aaAuteur');
  const val = document.getElementById('aaAuteur').value.trim();
  if (!val)           return artShowError('aaAuteur', 'Votre nom est obligatoire.');
  if (val.length < 2) return artShowError('aaAuteur', 'Le nom doit contenir au moins 2 caractères.');
  artMarkValid('aaAuteur');
  return true;
}

function validatePin() {
  artClearError('aaPin');
  const val = document.getElementById('aaPin').value.trim();
  if (!val)                   return artShowError('aaPin', 'Le code PIN est obligatoire.');
  if (!/^\d{4}$/.test(val))  return artShowError('aaPin', 'Le PIN doit contenir exactement 4 chiffres.');
  artMarkValid('aaPin');
  return true;
}

function validateRole() {
  artClearError('aaRole');
  const val = document.getElementById('aaRole').value;
  if (!val) return artShowError('aaRole', 'Veuillez sélectionner votre profil.');
  artMarkValid('aaRole');
  return true;
}

function validateContenu() {
  artClearError('aaContenu');
  const val = document.getElementById('aaContenu').value.trim();
  if (!val)            return artShowError('aaContenu', 'Le contenu est obligatoire.');
  if (val.length < 20) return artShowError('aaContenu', 'Le contenu doit contenir au moins 20 caractères.');
  artMarkValid('aaContenu');
  return true;
}

/* ─────────────── Bind events ─────────────── */
document.getElementById('aaTitre').addEventListener('input', function() {
  validateTitre();
  updateCharCount('aaTitre', 'aaTitreCount', 150);
});

document.getElementById('aaAuteur').addEventListener('input', validateAuteur);

document.getElementById('aaPin').addEventListener('input', function() {
  // Only allow digits
  this.value = this.value.replace(/\D/g, '').slice(0, 4);
  updatePinDots(this.value);
  validatePin();
});

document.getElementById('aaRole').addEventListener('change', validateRole);

document.getElementById('aaContenu').addEventListener('input', function() {
  validateContenu();
  updateCharCount('aaContenu', 'aaContenuCount', 0);
});

/* ─────────────── Form submit ─────────────── */
document.getElementById('articleAddForm').addEventListener('submit', function(e) {
  let valid = true;
  if (!validateTitre())   valid = false;
  if (!validateAuteur())  valid = false;
  if (!validatePin())     valid = false;
  if (!validateRole())    valid = false;
  if (!validateContenu()) valid = false;

  if (!valid) {
    e.preventDefault();
    const firstInvalid = document.querySelector('.art-input-invalid');
    if (firstInvalid) {
      firstInvalid.scrollIntoView({ behavior:'smooth', block:'center' });
      firstInvalid.focus();
    }
  }
});

/* ─────────────── Init char counts ─────────────── */
document.addEventListener('DOMContentLoaded', function() {
  updateCharCount('aaTitre', 'aaTitreCount', 150);
  updateCharCount('aaContenu', 'aaContenuCount', 0);
  const pinVal = document.getElementById('aaPin').value;
  if (pinVal) updatePinDots(pinVal);
});
</script>