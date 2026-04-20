<?php
/**
 * Vue FrontOffice : Formulaire de soumission d'un régime alimentaire
 */
?>

<style>
.regime-field-error {
  display:none;
  align-items:center;
  gap:0.35rem;
  margin-top:0.35rem;
  font-size:0.75rem;
  font-weight:600;
  color:#ef4444;
  animation:fadeUp 0.2s ease;
}
.regime-field-error.visible { display:flex; }
.regime-input-invalid {
  border-color:#ef4444 !important;
  box-shadow:0 0 0 3px rgba(239,68,68,0.12) !important;
}
@keyframes fadeUp {
  from { opacity:0; transform:translateY(4px); }
  to   { opacity:1; transform:translateY(0); }
}
</style>

<div style="padding:2rem;position:relative;max-width:760px;margin:0 auto">

  <!-- Page Header -->
  <div class="flex items-center gap-4 mb-6">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.18)">
      <i data-lucide="send" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
        <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
        Proposer un Régime
      </h1>
      <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">Votre proposition sera examinée par notre équipe avant publication.</p>
    </div>
  </div>

  <!-- Info Banner -->
  <div style="background:linear-gradient(135deg,rgba(59,130,246,0.08),rgba(59,130,246,0.04));border:1px solid rgba(59,130,246,0.2);border-radius:var(--radius-xl);padding:1rem 1.25rem;display:flex;align-items:flex-start;gap:0.75rem;margin-bottom:1.75rem">
    <i data-lucide="info" style="width:1.1rem;height:1.1rem;color:#3b82f6;flex-shrink:0;margin-top:2px"></i>
    <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin:0">
      Après soumission, votre régime sera examiné par un administrateur. Vous pouvez consulter son statut dans la section <strong>Régimes Alimentaires</strong>.
    </p>
  </div>

  <!-- PHP Server errors (fallback) -->
  <?php if (!empty($errors)): ?>
    <div style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1px solid #fca5a5;border-radius:var(--radius-xl);padding:1rem 1.25rem;margin-bottom:1.5rem">
      <?php foreach ($errors as $err): ?>
        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:#DC2626;padding:0.25rem 0">
          <i data-lucide="alert-circle" style="width:0.875rem;height:0.875rem;flex-shrink:0"></i>
          <?= htmlspecialchars($err) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Form -->
  <form method="POST" action="<?= BASE_URL ?>/?page=nutrition&action=regime-add" class="card" style="padding:2rem;display:flex;flex-direction:column;gap:1.5rem" id="regimeAddForm" novalidate>

    <!-- Nom -->
    <div>
      <label for="raNom" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="tag" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Nom du régime <span style="color:#ef4444">*</span>
      </label>
      <input type="text" name="nom" id="raNom"
             value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
             placeholder="Ex: Régime méditerranéen 4 semaines"
             style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none">
      <div class="regime-field-error" id="err-raNom">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Objectif + Durée -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div>
        <label for="raObjectif" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="target" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
          Objectif <span style="color:#ef4444">*</span>
        </label>
        <select name="objectif" id="raObjectif"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none;cursor:pointer">
          <option value="">-- Choisir --</option>
          <option value="perte_poids"    <?= ($_POST['objectif'] ?? '') === 'perte_poids'    ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien"       <?= ($_POST['objectif'] ?? '') === 'maintien'       ? 'selected' : '' ?>>Maintien du poids</option>
          <option value="prise_masse"    <?= ($_POST['objectif'] ?? '') === 'prise_masse'    ? 'selected' : '' ?>>Prise de masse</option>
          <option value="sante_generale" <?= ($_POST['objectif'] ?? '') === 'sante_generale' ? 'selected' : '' ?>>Santé générale</option>
        </select>
        <div class="regime-field-error" id="err-raObjectif">
          <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
          <span></span>
        </div>
      </div>
      <div>
        <label for="raDuree" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="calendar" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
          Durée (semaines) <span style="color:#ef4444">*</span>
        </label>
        <input type="number" name="duree_semaines" id="raDuree" 
               value="<?= htmlspecialchars($_POST['duree_semaines'] ?? '') ?>"
               placeholder="Ex: 4"
               style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none">
        <div class="regime-field-error" id="err-raDuree">
          <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
          <span></span>
        </div>
      </div>
    </div>

    <!-- Calories / jour -->
    <div>
      <label for="raCalories" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="flame" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Apport calorique journalier (kcal) <span style="color:#ef4444">*</span>
      </label>
      <input type="number" name="calories_jour" id="raCalories" 
             value="<?= htmlspecialchars($_POST['calories_jour'] ?? '') ?>"
             placeholder="Ex: 1800"
             style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none">
      <div class="regime-field-error" id="err-raCalories">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Description -->
    <div>
      <label for="raDesc" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="file-text" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Description générale <span style="color:#ef4444">*</span>
      </label>
      <textarea name="description" id="raDesc" rows="4"
                placeholder="Décrivez votre régime : principes, aliments recommandés, conseils…"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none;resize:vertical"
                onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      <div class="regime-field-error" id="err-raDesc">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Restrictions -->
    <div>
      <label for="raRestrictions" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="shield-check" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Restrictions / particularités <span style="color:#ef4444">*</span>
      </label>
      <textarea name="restrictions" id="raRestrictions" rows="2"
                placeholder="Ex: Sans gluten, végétarien, sans lactose, halal…"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none;resize:vertical"
                onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"><?= htmlspecialchars($_POST['restrictions'] ?? '') ?></textarea>
      <div class="regime-field-error" id="err-raRestrictions">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Soumis par -->
    <div style="border-top:1px solid var(--border);padding-top:1.25rem">
      <label for="raSoumisBy" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="user" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Votre nom <span style="color:#ef4444">*</span>
      </label>
      <input type="text" name="soumis_par" id="raSoumisBy"
             value="<?= htmlspecialchars($_POST['soumis_par'] ?? '') ?>"
             placeholder="Ex: Jean Dupont"
             style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none">
      <div class="regime-field-error" id="err-raSoumisBy">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:0.75rem;justify-content:flex-end;padding-top:0.5rem">
      <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="btn btn-outline" style="border-radius:var(--radius-full)">
        <i data-lucide="x" style="width:0.875rem;height:0.875rem"></i> Annuler
      </a>
      <button type="submit" id="raSubmitBtn" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Soumettre mon régime
      </button>
    </div>
  </form>
</div>

<script>
/* ===== Inline field validation helpers ===== */
function showFieldError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return false;
  field.classList.add('regime-input-invalid');
  field.style.borderColor = '#ef4444';
  field.style.boxShadow   = '0 0 0 3px rgba(239,68,68,0.12)';
  errBox.querySelector('span').textContent = message;
  errBox.classList.add('visible');
  if (typeof lucide !== 'undefined') lucide.createIcons();
  return false;
}

function clearFieldError(fieldId) {
  const field = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return true;
  field.classList.remove('regime-input-invalid');
  field.style.borderColor = '';
  field.style.boxShadow   = '';
  errBox.classList.remove('visible');
  return true;
}

/* ===== Real-time Validation Functions ===== */
function validateNom() {
  clearFieldError('raNom');
  const nom = document.getElementById('raNom').value.trim();
  if (!nom) return showFieldError('raNom', 'Le nom du régime est obligatoire.');
  if (nom.length < 3) return showFieldError('raNom', 'Le nom doit contenir au moins 3 caractères.');
  return true;
}

function validateObjectif() {
  clearFieldError('raObjectif');
  if (!document.getElementById('raObjectif').value) return showFieldError('raObjectif', 'Veuillez choisir un objectif.');
  return true;
}

function validateDuree() {
  clearFieldError('raDuree');
  const val = document.getElementById('raDuree').value.trim();
  if (val === '') return showFieldError('raDuree', 'La durée est obligatoire.');
  const d = parseInt(val);
  if (isNaN(d) || d < 1 || d > 52) return showFieldError('raDuree', 'La durée doit être entre 1 et 52 semaines (valeur positive seulement).');
  return true;
}

function validateCalories() {
  clearFieldError('raCalories');
  const val = document.getElementById('raCalories').value.trim();
  if (val === '') return showFieldError('raCalories', "L'apport calorique journalier est obligatoire.");
  const c = parseInt(val);
  if (isNaN(c) || c < 500 || c > 6000) return showFieldError('raCalories', 'Les calories doivent être entre 500 et 6 000 kcal/jour (valeur positive).');
  return true;
}

function validateDesc() {
  clearFieldError('raDesc');
  if (!document.getElementById('raDesc').value.trim()) return showFieldError('raDesc', 'La description est obligatoire.');
  return true;
}

function validateRestr() {
  clearFieldError('raRestrictions');
  if (!document.getElementById('raRestrictions').value.trim()) return showFieldError('raRestrictions', 'Les restrictions sont obligatoires.');
  return true;
}

function validateSoumisBy() {
  clearFieldError('raSoumisBy');
  const n = document.getElementById('raSoumisBy').value.trim();
  if (!n) return showFieldError('raSoumisBy', 'Votre nom est obligatoire.');
  if (n.length < 2) return showFieldError('raSoumisBy', 'Votre nom doit contenir au moins 2 caractères.');
  return true;
}

/* ===== Bind Events ===== */
document.getElementById('raNom').addEventListener('input', validateNom);
document.getElementById('raObjectif').addEventListener('change', validateObjectif);
document.getElementById('raDuree').addEventListener('input', validateDuree);
document.getElementById('raCalories').addEventListener('input', validateCalories);
document.getElementById('raDesc').addEventListener('input', validateDesc);
document.getElementById('raRestrictions').addEventListener('input', validateRestr);
document.getElementById('raSoumisBy').addEventListener('input', validateSoumisBy);

/* ===== Form submit validation ===== */
document.getElementById('regimeAddForm').addEventListener('submit', function(e) {
  let valid = true;
  if (!validateNom()) valid = false;
  if (!validateObjectif()) valid = false;
  if (!validateDuree()) valid = false;
  if (!validateCalories()) valid = false;
  if (!validateDesc()) valid = false;
  if (!validateRestr()) valid = false;
  if (!validateSoumisBy()) valid = false;

  if (!valid) {
    e.preventDefault();
    // find first error
    const firstInvalid = document.querySelector('.regime-input-invalid');
    if (firstInvalid) {
      firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
      firstInvalid.focus();
    }
  }
});
</script>
