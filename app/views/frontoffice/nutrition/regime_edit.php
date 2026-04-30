<?php
/**
 * Vue FrontOffice : Modification d'un régime par le client
 */
$objectifLabels = [
    'perte_poids'    => 'Perte de poids',
    'maintien'       => 'Maintien du poids',
    'prise_masse'    => 'Prise de masse',
    'sante_generale' => 'Santé générale',
];
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

  <!-- Header -->
  <div class="flex items-center gap-4 mb-6">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.18)">
      <i data-lucide="edit-3" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
        <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
        Modifier mon Régime
      </h1>
      <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">Toute modification remet le régime en attente de validation.</p>
    </div>
  </div>

  <!-- Warning Banner -->
  <div style="background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));border:1px solid rgba(245,158,11,0.3);border-radius:var(--radius-xl);padding:1rem 1.25rem;display:flex;align-items:flex-start;gap:0.75rem;margin-bottom:1.75rem">
    <i data-lucide="alert-triangle" style="width:1.1rem;height:1.1rem;color:#f59e0b;flex-shrink:0;margin-top:2px"></i>
    <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin:0">
      Après modification, votre régime sera remis <strong>en attente de validation</strong> et retiré de la liste publique jusqu'à nouvel accord de l'équipe.
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

  <form method="POST" action="<?= BASE_URL ?>/?page=nutrition&action=regime-edit&id=<?= $regime['id'] ?>" class="card" style="padding:2rem;display:flex;flex-direction:column;gap:1.5rem" id="regimeEditForm" novalidate>

    <!-- Nom -->
    <div>
      <label for="reNom" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="tag" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Nom du régime <span style="color:#ef4444">*</span>
      </label>
      <input type="text" name="nom" id="reNom"
             value="<?= htmlspecialchars($_POST['nom'] ?? $regime['nom']) ?>"
             style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none"
             onfocus="clearFieldError('reNom')"
             oninput="clearFieldError('reNom')">
      <div class="regime-field-error" id="err-reNom">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Objectif + Durée -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div>
        <label for="reObjectif" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="target" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
          Objectif <span style="color:#ef4444">*</span>
        </label>
        <?php $selObj = $_POST['objectif'] ?? $regime['objectif']; ?>
        <select name="objectif" id="reObjectif"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none;cursor:pointer"
                onchange="clearFieldError('reObjectif')">
          <option value="perte_poids"    <?= $selObj === 'perte_poids'    ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien"       <?= $selObj === 'maintien'       ? 'selected' : '' ?>>Maintien du poids</option>
          <option value="prise_masse"    <?= $selObj === 'prise_masse'    ? 'selected' : '' ?>>Prise de masse</option>
          <option value="sante_generale" <?= $selObj === 'sante_generale' ? 'selected' : '' ?>>Santé générale</option>
        </select>
        <div class="regime-field-error" id="err-reObjectif">
          <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
          <span></span>
        </div>
      </div>
      <div>
        <label for="reDuree" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="calendar" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
          Durée (semaines) <span style="color:#ef4444">*</span>
        </label>
        <input type="number" name="duree_semaines" id="reDuree" 
               value="<?= htmlspecialchars($_POST['duree_semaines'] ?? $regime['duree_semaines']) ?>"
               style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none"
               onfocus="clearFieldError('reDuree')"
               oninput="clearFieldError('reDuree')">
        <div class="regime-field-error" id="err-reDuree">
          <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
          <span></span>
        </div>
      </div>
    </div>

    <!-- Calories / jour -->
    <div>
      <label for="reCalories" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="flame" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Apport calorique journalier (kcal) <span style="color:#ef4444">*</span>
      </label>
      <input type="number" name="calories_jour" id="reCalories" 
             value="<?= htmlspecialchars($_POST['calories_jour'] ?? $regime['calories_jour']) ?>"
             style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none"
             onfocus="clearFieldError('reCalories')"
             oninput="clearFieldError('reCalories')">
      <div class="regime-field-error" id="err-reCalories">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Description -->
    <div>
      <label for="reDesc" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="file-text" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Description générale <span style="color:#ef4444">*</span>
      </label>
      <textarea name="description" id="reDesc" rows="4"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none;resize:vertical"
                oninput="validateDesc()"><?= htmlspecialchars($_POST['description'] ?? $regime['description']) ?></textarea>
      <div class="regime-field-error" id="err-reDesc">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Restrictions -->
    <div>
      <label for="reRestrictions" style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        <i data-lucide="shield-check" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
        Restrictions / particularités <span style="color:#ef4444">*</span>
      </label>
      <textarea name="restrictions" id="reRestrictions" rows="2"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none;resize:vertical"
                oninput="validateRestr()"><?= htmlspecialchars($_POST['restrictions'] ?? $regime['restrictions']) ?></textarea>
      <div class="regime-field-error" id="err-reRestrictions">
        <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
        <span></span>
      </div>
    </div>

    <!-- Hidden: soumis_par -->
    <input type="hidden" name="soumis_par" value="<?= htmlspecialchars($regime['soumis_par']) ?>">

    <!-- Info box -->
    <div style="background:rgba(82,183,136,0.06);border:1px solid rgba(82,183,136,0.15);border-radius:var(--radius-xl);padding:0.75rem 1rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="user" style="width:0.875rem;height:0.875rem;color:var(--secondary);flex-shrink:0"></i>
      <span style="font-size:0.78rem;color:var(--text-secondary)">
        Régime soumis par : <strong><?= htmlspecialchars($regime['soumis_par']) ?></strong>
      </span>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:0.75rem;justify-content:flex-end;padding-top:0.5rem">
      <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="btn btn-outline" style="border-radius:var(--radius-full)">
        <i data-lucide="x" style="width:0.875rem;height:0.875rem"></i> Annuler
      </a>
      <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Soumettre les modifications
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
  clearFieldError('reNom');
  const nom = document.getElementById('reNom').value.trim();
  if (!nom) return showFieldError('reNom', 'Le nom du régime est obligatoire.');
  if (nom.length < 3) return showFieldError('reNom', 'Le nom doit contenir au moins 3 caractères.');
  return true;
}

function validateObjectif() {
  clearFieldError('reObjectif');
  if (!document.getElementById('reObjectif').value) return showFieldError('reObjectif', 'Veuillez choisir un objectif.');
  return true;
}

function validateDuree() {
  clearFieldError('reDuree');
  const val = document.getElementById('reDuree').value.trim();
  if (val === '') return showFieldError('reDuree', 'La durée est obligatoire.');
  const d = parseInt(val);
  if (isNaN(d) || d < 1 || d > 52) return showFieldError('reDuree', 'La durée doit être entre 1 et 52 semaines (valeur positive seulement).');
  return true;
}

function validateCalories() {
  clearFieldError('reCalories');
  const val = document.getElementById('reCalories').value.trim();
  if (val === '') return showFieldError('reCalories', "L'apport calorique journalier est obligatoire.");
  const c = parseInt(val);
  if (isNaN(c) || c < 500 || c > 6000) return showFieldError('reCalories', 'Les calories doivent être entre 500 et 6 000 kcal/jour (valeur positive).');
  return true;
}

function validateDesc() {
  clearFieldError('reDesc');
  const val = document.getElementById('reDesc').value.trim();
  if (!val) return showFieldError('reDesc', 'La description est obligatoire.');
  if (val.length < 3) return showFieldError('reDesc', 'La description doit contenir au moins 3 caractères.');
  return true;
}

function validateRestr() {
  clearFieldError('reRestrictions');
  const val = document.getElementById('reRestrictions').value.trim();
  if (!val) return showFieldError('reRestrictions', 'Les restrictions sont obligatoires.');
  if (val.length < 3) return showFieldError('reRestrictions', 'Les restrictions doivent contenir au moins 3 caractères.');
  return true;
}

/* ===== Bind Events ===== */
document.getElementById('reNom').addEventListener('input', validateNom);
document.getElementById('reObjectif').addEventListener('change', validateObjectif);
document.getElementById('reDuree').addEventListener('input', validateDuree);
document.getElementById('reCalories').addEventListener('input', validateCalories);
document.getElementById('reDesc').addEventListener('input', validateDesc);
document.getElementById('reRestrictions').addEventListener('input', validateRestr);

/* ===== Form submit validation ===== */
document.getElementById('regimeEditForm').addEventListener('submit', function(e) {
  let valid = true;
  if (!validateNom()) valid = false;
  if (!validateObjectif()) valid = false;
  if (!validateDuree()) valid = false;
  if (!validateCalories()) valid = false;
  if (!validateDesc()) valid = false;
  if (!validateRestr()) valid = false;

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
