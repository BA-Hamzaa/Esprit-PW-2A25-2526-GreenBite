<?php
$articleId = (int)$article['id'];
$pin       = htmlspecialchars($_GET['pin'] ?? '');
$auteur    = htmlspecialchars($article['auteur'] ?? '');
$valTitre  = htmlspecialchars($_POST['titre']            ?? $article['titre']            ?? '');
$valContenu= htmlspecialchars($_POST['contenu']          ?? $article['contenu']          ?? '');
$valRole   = htmlspecialchars($_POST['role_utilisateur'] ?? $article['role_utilisateur'] ?? 'Passionné de cuisine');
$roles = [
    'Passionné de cuisine'  => '🍳 Passionné de cuisine',
    'Chef cuisinier'        => '👨‍🍳 Chef cuisinier',
    'Nutritionniste'        => '🥗 Nutritionniste',
    'Diététicien(ne)'       => '📋 Diététicien(ne)',
    'Étudiant en nutrition' => '🎓 Étudiant en nutrition',
    'Athlète / Sportif'     => '🏋️ Athlète / Sportif',
    'Parent'                => '👨‍👩‍👧 Parent',
    'Jardinier urbain'      => '🌻 Jardinier urbain',
    'Food lover'            => '🍕 Food lover',
    'Éco-activiste'         => '🌍 Éco-activiste',
    'Autre'                 => '✨ Autre',
];
?>

<style>
/* ─── Edit Article Styles ─── */
.ea-wrap   { padding:2rem 2.5rem 3rem; max-width:860px; margin:0 auto; }

/* Field */
.ea-label  { display:flex;align-items:center;gap:.35rem;font-size:.82rem;font-weight:700;color:var(--text-secondary);margin-bottom:.45rem; }
.ea-input  { width:100%;padding:.75rem 1rem;border:1.5px solid var(--border);border-radius:.875rem;font-size:.9rem;background:var(--surface);color:var(--text-primary);transition:all .25s;outline:none;font-family:inherit; }
.ea-input:focus { border-color:var(--secondary);box-shadow:0 0 0 3px rgba(82,183,136,.12); }
.ea-input.invalid { border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.12); }
.ea-input.valid   { border-color:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.10); }
.ea-err { display:none;align-items:center;gap:.3rem;margin-top:.35rem;font-size:.75rem;font-weight:600;color:#ef4444;animation:eaFadeUp .2s ease; }
.ea-err.show { display:flex; }
@keyframes eaFadeUp { from{opacity:0;transform:translateY(4px)} to{opacity:1;transform:none} }

/* Role cards */
.ea-roles { display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.6rem;margin-top:.5rem; }
.ea-role  { border:2px solid var(--border);border-radius:.875rem;padding:.6rem .75rem;cursor:pointer;font-size:.78rem;font-weight:600;color:var(--text-secondary);background:var(--surface);transition:all .2s;text-align:center;user-select:none; }
.ea-role:hover  { border-color:var(--secondary);color:var(--primary); }
.ea-role.active { border-color:var(--primary);background:rgba(45,106,79,.08);color:var(--primary);font-weight:700; }

/* Char counter */
.ea-counter { font-size:.7rem;color:var(--text-muted);text-align:right;margin-top:.25rem;transition:color .2s; }
.ea-counter.warn  { color:#f59e0b; }
.ea-counter.error { color:#ef4444; }

/* Save btn shimmer */
.ea-save { position:relative;overflow:hidden; }
.ea-save::after { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.18),transparent);pointer-events:none; }
.ea-save:disabled { opacity:.55;cursor:not-allowed; }
</style>

<div class="ea-wrap">

  <!-- ── Header ── -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem">
    <div style="display:flex;align-items:center;gap:1rem">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#fef9ec,#fde68a);border-radius:1rem;box-shadow:0 6px 18px rgba(234,179,8,.2)">
        <i data-lucide="file-pen-line" style="width:1.6rem;height:1.6rem;color:#b45309"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:900;color:var(--text-primary);margin:0;letter-spacing:-.02em">
          Modifier mon article
        </h1>
        <p style="font-size:.78rem;color:var(--text-muted);margin:3px 0 0;display:flex;align-items:center;gap:.3rem">
          <i data-lucide="user" style="width:.75rem;height:.75rem"></i>
          <?= $auteur ?> · repassera en validation avant publication
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=article&action=mes-activites"
       class="btn"
       style="border-radius:var(--radius-full);background:rgba(45,106,79,.06);border:1px solid rgba(45,106,79,.15);color:var(--primary);display:flex;align-items:center;gap:.4rem">
      <i data-lucide="arrow-left" style="width:.9rem;height:.9rem"></i> Retour
    </a>
  </div>

  <!-- ── Error banner ── -->
  <?php if (!empty($errors)): ?>
    <div style="padding:1rem 1.25rem;margin-bottom:1.5rem;border-radius:var(--radius);background:#fef2f2;color:#991b1b;border:1.5px solid #fca5a5;display:flex;flex-direction:column;gap:.3rem">
      <?php foreach ($errors as $e): ?>
        <div style="display:flex;align-items:center;gap:.5rem;font-size:.82rem">
          <i data-lucide="alert-circle" style="width:.85rem;height:.85rem;flex-shrink:0"></i>
          <?= htmlspecialchars($e) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- ── Form ── -->
  <form method="post"
        action="<?= BASE_URL ?>/?page=article&action=edit-mes-articles&id=<?= $articleId ?>&pin=<?= $pin ?>&auteur=<?= urlencode($auteur) ?>"
        id="editArticleForm"
        novalidate>
    <input type="hidden" name="auteur" value="<?= $auteur ?>">

    <!-- Card -->
    <div class="card" style="padding:2rem;border:1.5px solid var(--border);display:flex;flex-direction:column;gap:1.75rem">

      <!-- Row 1: Titre + Rôle -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">

        <!-- Titre -->
        <div style="grid-column:1/-1">
          <label for="editTitre" class="ea-label">
            <i data-lucide="type" style="width:.85rem;height:.85rem;color:#3b82f6"></i>
            Titre <span style="color:#ef4444">*</span>
          </label>
          <input type="text" name="titre" id="editTitre" class="ea-input"
                 value="<?= $valTitre ?>"
                 placeholder="Un titre accrocheur pour votre article…"
                 maxlength="150">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div class="ea-err" id="errTitre"><i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span></div>
            <div class="ea-counter" id="cntTitre" style="margin-left:auto">0 / 150</div>
          </div>
        </div>

      </div>

      <!-- Rôle -->
      <div>
        <label class="ea-label">
          <i data-lucide="badge" style="width:.85rem;height:.85rem;color:#f59e0b"></i>
          Votre profil <span style="color:#ef4444">*</span>
        </label>
        <input type="hidden" name="role_utilisateur" id="roleHidden" value="<?= $valRole ?>">
        <div class="ea-roles" id="roleCards">
          <?php foreach ($roles as $value => $label): ?>
            <div class="ea-role <?= $valRole === $value ? 'active' : '' ?>"
                 data-value="<?= htmlspecialchars($value) ?>"
                 onclick="selectRole(this)">
              <?= $label ?>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="ea-err" id="errRole"><i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span></div>
      </div>

      <!-- Contenu -->
      <div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.45rem">
          <label for="editContenu" class="ea-label" style="margin-bottom:0">
            <i data-lucide="align-left" style="width:.85rem;height:.85rem;color:#10b981"></i>
            Contenu <span style="color:#ef4444">*</span>
          </label>
          <span style="font-size:.7rem;color:var(--text-muted)">min 20 caractères</span>
        </div>
        <textarea name="contenu" id="editContenu" class="ea-input"
                  rows="12"
                  placeholder="Partagez votre expérience, vos conseils, vos recettes…"
                  style="resize:vertical;min-height:220px;line-height:1.7"><?= $valContenu ?></textarea>
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-top:.35rem">
          <div class="ea-err" id="errContenu"><i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span></div>
          <div class="ea-counter" id="cntContenu" style="margin-left:auto">0 caractères</div>
        </div>
      </div>

      <!-- Info banner -->
      <div style="display:flex;align-items:flex-start;gap:.75rem;padding:.875rem 1rem;background:rgba(245,158,11,.06);border:1px solid rgba(245,158,11,.25);border-radius:.875rem">
        <i data-lucide="info" style="width:1rem;height:1rem;color:#f59e0b;flex-shrink:0;margin-top:.1rem"></i>
        <p style="font-size:.78rem;color:#92400e;margin:0;line-height:1.6">
          Après modification, votre article repassera en <strong>validation</strong> avant d'être republié. Les changements seront enregistrés immédiatement.
        </p>
      </div>

      <!-- Submit row -->
      <div style="display:flex;align-items:center;justify-content:space-between;padding-top:1rem;border-top:1.5px solid var(--border);flex-wrap:wrap;gap:1rem">
        <a href="<?= BASE_URL ?>/?page=article&action=mes-activites"
           style="font-size:.82rem;color:var(--text-muted);font-weight:600;text-decoration:none;display:flex;align-items:center;gap:.35rem">
          <i data-lucide="x" style="width:.85rem;height:.85rem"></i> Annuler les modifications
        </a>
        <button type="submit" id="editSubmitBtn" class="btn btn-primary ea-save"
                style="border-radius:var(--radius-full);padding:.8rem 2.2rem;font-size:.95rem;gap:.5rem;display:flex;align-items:center">
          <i data-lucide="save" style="width:1.1rem;height:1.1rem"></i>
          Enregistrer les modifications
        </button>
      </div>

    </div>
  </form>
</div>

<script>
// ── Role card picker ──────────────────────────────────
function selectRole(el) {
  document.querySelectorAll('.ea-role').forEach(function(c){ c.classList.remove('active'); });
  el.classList.add('active');
  document.getElementById('roleHidden').value = el.dataset.value;
  document.getElementById('errRole').classList.remove('show');
}

// ── Helpers ──────────────────────────────────────────
function eaShowErr(errId, msg) {
  var e = document.getElementById(errId);
  e.querySelector('span').textContent = msg;
  e.classList.add('show');
  return false;
}
function eaClear(errId, inputId) {
  document.getElementById(errId).classList.remove('show');
  if (inputId) {
    var el = document.getElementById(inputId);
    el.classList.remove('invalid','valid');
  }
}
function eaMarkValid(inputId)   { var el=document.getElementById(inputId); el.classList.remove('invalid'); el.classList.add('valid'); }
function eaMarkInvalid(inputId) { var el=document.getElementById(inputId); el.classList.remove('valid');   el.classList.add('invalid'); }

// ── Live char counters ────────────────────────────────
function updateTitreCounter() {
  var el  = document.getElementById('editTitre');
  var cnt = document.getElementById('cntTitre');
  var len = el.value.length;
  cnt.textContent = len + ' / 150';
  cnt.className   = 'ea-counter' + (len > 130 ? ' warn' : '') + (len >= 150 ? ' error' : '');
  if (len >= 3) eaMarkValid('editTitre'); else eaMarkInvalid('editTitre');
}
function updateContenuCounter() {
  var el  = document.getElementById('editContenu');
  var cnt = document.getElementById('cntContenu');
  var len = el.value.length;
  cnt.textContent = len + ' caractère' + (len > 1 ? 's' : '');
  cnt.className   = 'ea-counter' + (len >= 20 ? '' : ' error');
  if (len >= 20) eaMarkValid('editContenu'); else eaMarkInvalid('editContenu');
}

// ── Validation ────────────────────────────────────────
function validateEditForm() {
  var titre   = document.getElementById('editTitre').value.trim();
  var contenu = document.getElementById('editContenu').value.trim();
  var role    = document.getElementById('roleHidden').value;
  var ok = true;

  eaClear('errTitre','editTitre'); eaClear('errContenu','editContenu'); eaClear('errRole',null);

  if (titre.length < 3) {
    eaShowErr('errTitre','Titre obligatoire (min 3 caractères).');
    eaMarkInvalid('editTitre');
    ok = false;
  } else { eaMarkValid('editTitre'); }

  if (contenu.length < 20) {
    eaShowErr('errContenu','Contenu obligatoire (min 20 caractères).');
    eaMarkInvalid('editContenu');
    ok = false;
  } else { eaMarkValid('editContenu'); }

  if (!role) {
    eaShowErr('errRole','Veuillez sélectionner votre profil.');
    ok = false;
  }

  if (!ok) {
    var first = document.querySelector('.ea-input.invalid');
    if (first) { first.scrollIntoView({behavior:'smooth',block:'center'}); first.focus(); }
  } else {
    var btn = document.getElementById('editSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader-2" style="width:1rem;height:1rem;animation:spin .9s linear infinite"></i> Enregistrement...';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }
  return ok;
}

// ── Init ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
  var titre   = document.getElementById('editTitre');
  var contenu = document.getElementById('editContenu');

  if (titre) {
    titre.addEventListener('input', function() { updateTitreCounter(); });
    updateTitreCounter();
  }
  if (contenu) {
    contenu.addEventListener('input', function() { updateContenuCounter(); });
    updateContenuCounter();
  }

  document.getElementById('editArticleForm').addEventListener('submit', function(e) {
    if (!validateEditForm()) e.preventDefault();
  });

  if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>