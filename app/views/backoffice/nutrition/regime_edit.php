<?php
/**
 * Vue BackOffice : Formulaire de modification d'un régime alimentaire (admin)
 */
?>

<style>
.regime-field-error{display:none;align-items:center;gap:.35rem;margin-top:.35rem;font-size:.75rem;font-weight:600;color:#ef4444;animation:fadeUp .2s ease}
.regime-field-error.visible{display:flex}
.regime-input-invalid{border-color:#ef4444 !important;box-shadow:0 0 0 3px rgba(239,68,68,.12) !important}
@keyframes fadeUp{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
</style>

<div style="padding:2rem;max-width:760px;margin:0 auto">

  <div class="flex items-center gap-4 mb-6">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 4px 16px rgba(45,106,79,0.18)">
      <i data-lucide="edit" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">Modifier le Régime</h1>
      <p style="font-size:0.78rem;color:var(--text-muted);margin-top:2px">
        Modification de : <strong><?= htmlspecialchars($regime['nom']) ?></strong> — restera publié.
      </p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1px solid #fca5a5;border-radius:var(--radius-xl);padding:1rem 1.25rem;margin-bottom:1.5rem">
      <?php foreach ($errors as $err): ?>
        <div style="display:flex;align-items:center;gap:.5rem;font-size:.82rem;color:#DC2626;padding:.2rem 0">
          <i data-lucide="alert-circle" style="width:.875rem;height:.875rem;flex-shrink:0"></i>
          <?= htmlspecialchars($err) ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?= BASE_URL ?>/?page=admin-nutrition&action=regime-edit-back&id=<?= $regime['id'] ?>"
        class="card" style="padding:2rem;display:flex;flex-direction:column;gap:1.5rem" id="backRegimeEditForm" novalidate>

    <!-- Nom -->
    <div>
      <label for="beNom" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Nom du régime <span style="color:#ef4444">*</span>
      </label>
      <input type="text" name="nom" id="beNom"
             value="<?= htmlspecialchars($_POST['nom'] ?? $regime['nom']) ?>"
             style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
             onfocus="clearFieldError('beNom')" oninput="validateNom()" onblur="validateNom()">
      <div class="regime-field-error" id="err-beNom">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Objectif + Durée -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div>
        <label for="beObjectif" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
          Objectif <span style="color:#ef4444">*</span>
        </label>
        <?php $selObj = $_POST['objectif'] ?? $regime['objectif']; ?>
        <select name="objectif" id="beObjectif"
                style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none;cursor:pointer"
                onchange="validateObjectif()">
          <option value="perte_poids"    <?= $selObj === 'perte_poids'    ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien"       <?= $selObj === 'maintien'       ? 'selected' : '' ?>>Maintien du poids</option>
          <option value="prise_masse"    <?= $selObj === 'prise_masse'    ? 'selected' : '' ?>>Prise de masse</option>
          <option value="sante_generale" <?= $selObj === 'sante_generale' ? 'selected' : '' ?>>Santé générale</option>
        </select>
        <div class="regime-field-error" id="err-beObjectif">
          <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
        </div>
      </div>
      <div>
        <label for="beDuree" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
          Durée (semaines) <span style="color:#ef4444">*</span>
        </label>
        <input type="number" name="duree_semaines" id="beDuree" 
               value="<?= htmlspecialchars($_POST['duree_semaines'] ?? $regime['duree_semaines']) ?>"
               style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
               onfocus="clearFieldError('beDuree')" oninput="validateDuree()" onblur="validateDuree()">
        <div class="regime-field-error" id="err-beDuree">
          <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
        </div>
      </div>
    </div>

    <!-- Calories / jour -->
    <div>
      <label for="beCalories" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Apport calorique journalier (kcal) <span style="color:#ef4444">*</span>
      </label>
      <input type="number" name="calories_jour" id="beCalories" 
             value="<?= htmlspecialchars($_POST['calories_jour'] ?? $regime['calories_jour']) ?>"
             style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
             onfocus="clearFieldError('beCalories')" oninput="validateCalories()" onblur="validateCalories()">
      <div class="regime-field-error" id="err-beCalories">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Description -->
    <div>
      <label for="beDesc" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Description <span style="color:#ef4444">*</span>
      </label>
      <textarea name="description" id="beDesc" rows="4"
                style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none;resize:vertical"
                oninput="validateDesc()" onblur="validateDesc()"><?= htmlspecialchars($_POST['description'] ?? $regime['description']) ?></textarea>
      <div class="regime-field-error" id="err-beDesc">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Restrictions -->
    <div>
      <label for="beRestrictions" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Restrictions <span style="color:#ef4444">*</span>
      </label>
      <textarea name="restrictions" id="beRestrictions" rows="2"
                style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none;resize:vertical"
                oninput="validateRestr()" onblur="validateRestr()"><?= htmlspecialchars($_POST['restrictions'] ?? $regime['restrictions']) ?></textarea>
      <div class="regime-field-error" id="err-beRestrictions">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Soumis par (info only) -->
    <div style="background:rgba(82,183,136,0.06);border:1px solid rgba(82,183,136,0.15);border-radius:var(--radius-xl);padding:.75rem 1rem;display:flex;align-items:center;gap:.5rem">
      <i data-lucide="user" style="width:.875rem;height:.875rem;color:var(--secondary);flex-shrink:0"></i>
      <span style="font-size:.78rem;color:var(--text-secondary)">
        Soumis par : <strong><?= htmlspecialchars($regime['soumis_par']) ?></strong> — non modifiable
      </span>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:.75rem;justify-content:flex-end;padding-top:.5rem">
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=regimes" class="btn btn-outline" style="border-radius:var(--radius-full)">
        <i data-lucide="x" style="width:.875rem;height:.875rem"></i> Annuler
      </a>
      <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="save" style="width:.875rem;height:.875rem"></i> Enregistrer les modifications
      </button>
    </div>
  </form>
</div>

<script>
function showFieldError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return;
  field.classList.add('regime-input-invalid');
  errBox.querySelector('span').textContent = message;
  errBox.classList.add('visible');
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function clearFieldError(fieldId) {
  const field = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return;
  field.classList.remove('regime-input-invalid');
  errBox.classList.remove('visible');
}

/* ===== Real-time Validation ===== */
function validateDesc() {
  const val = document.getElementById('beDesc').value.trim();
  if (!val) return showFieldError('beDesc', 'La description est obligatoire.');
  if (val.length < 3) return showFieldError('beDesc', 'La description doit contenir au moins 3 caractères.');
  clearFieldError('beDesc'); return true;
}
function validateRestr() {
  const val = document.getElementById('beRestrictions').value.trim();
  if (!val) return showFieldError('beRestrictions', 'Les restrictions sont obligatoires.');
  if (val.length < 3) return showFieldError('beRestrictions', 'Les restrictions doivent contenir au moins 3 caractères.');
  clearFieldError('beRestrictions'); return true;
}
function validateNom() {
  const v = document.getElementById('beNom').value.trim();
  if (!v) return showFieldError('beNom', 'Le nom est obligatoire.');
  if (v.length < 3) return showFieldError('beNom', 'Au moins 3 caractères.');
  clearFieldError('beNom'); return true;
}
function validateObjectif() {
  const v = document.getElementById('beObjectif').value;
  if (!v) return showFieldError('beObjectif', 'Veuillez choisir un objectif.');
  clearFieldError('beObjectif'); return true;
}
function validateDuree() {
  const v = parseInt(document.getElementById('beDuree').value);
  if (isNaN(v)) return showFieldError('beDuree', 'La durée est obligatoire.');
  if (v < 1 || v > 52) return showFieldError('beDuree', 'Entre 1 et 52 semaines.');
  clearFieldError('beDuree'); return true;
}
function validateCalories() {
  const v = parseInt(document.getElementById('beCalories').value);
  if (isNaN(v)) return showFieldError('beCalories', "L'apport calorique est obligatoire.");
  if (v < 500 || v > 6000) return showFieldError('beCalories', 'Entre 500 et 6 000 kcal.');
  clearFieldError('beCalories'); return true;
}

document.getElementById('beNom').addEventListener('input', validateNom);
document.getElementById('beObjectif').addEventListener('change', validateObjectif);
document.getElementById('beDuree').addEventListener('input', validateDuree);
document.getElementById('beCalories').addEventListener('input', validateCalories);
document.getElementById('beDesc').addEventListener('input', validateDesc);
document.getElementById('beRestrictions').addEventListener('input', validateRestr);

document.getElementById('backRegimeEditForm').addEventListener('submit', function(e) {
  let firstErr = null, hasError = false;

  const rules = [
    { id:'beNom',           val:() => document.getElementById('beNom').value.trim(),
      check: v => !v ? 'Le nom est obligatoire.' : v.length < 3 ? 'Au moins 3 caract\u00e8res.' : null },
    { id:'beObjectif',      val:() => document.getElementById('beObjectif').value,
      check: v => !v ? "Veuillez choisir un objectif." : null },
    { id:'beDuree',         val:() => parseInt(document.getElementById('beDuree').value),
      check: v => isNaN(v) ? 'La dur\u00e9e est obligatoire.' : v < 1 || v > 52 ? 'Entre 1 et 52 semaines.' : null },
    { id:'beCalories',      val:() => parseInt(document.getElementById('beCalories').value),
      check: v => isNaN(v) ? "L'apport calorique est obligatoire." : v < 500 || v > 6000 ? 'Entre 500 et 6\u202f000 kcal.' : null },
    { id:'beDesc',          val:() => document.getElementById('beDesc').value.trim(),
      check: v => !v ? 'La description est obligatoire.' : v.length < 3 ? 'La description doit contenir au moins 3 caract\u00e8res.' : null },
    { id:'beRestrictions',  val:() => document.getElementById('beRestrictions').value.trim(),
      check: v => !v ? 'Les restrictions sont obligatoires.' : v.length < 3 ? 'Les restrictions doivent contenir au moins 3 caract\u00e8res.' : null },
  ];

  rules.forEach(r => {
    const msg = r.check(r.val());
    if (msg) {
      showFieldError(r.id, msg);
      if (!firstErr) firstErr = r.id;
      hasError = true;
    }
  });

  if (hasError) {
    e.preventDefault();
    const el = document.getElementById(firstErr);
    if (el) { el.scrollIntoView({ behavior:'smooth', block:'center' }); el.focus(); }
  }
});
</script>
