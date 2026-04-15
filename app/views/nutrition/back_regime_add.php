<?php
/**
 * Vue BackOffice : Formulaire d'ajout d'un régime alimentaire (admin)
 */
?>

<style>
.regime-field-error{display:none;align-items:center;gap:.35rem;margin-top:.35rem;font-size:.75rem;font-weight:600;color:#ef4444;animation:fadeUp .2s ease}
.regime-field-error.visible{display:flex}
@keyframes fadeUp{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
</style>

<div style="padding:2rem;max-width:760px;margin:0 auto">

  <div class="flex items-center gap-4 mb-6">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 4px 16px rgba(45,106,79,0.18)">
      <i data-lucide="plus-circle" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">Ajouter un Régime</h1>
      <p style="font-size:0.78rem;color:var(--text-muted);margin-top:2px">Le régime sera publié directement (statut : Accepté).</p>
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

  <form method="POST" action="<?= BASE_URL ?>/?page=admin-nutrition&action=regime-add-back"
        class="card" style="padding:2rem;display:flex;flex-direction:column;gap:1.5rem" id="backRegimeAddForm" novalidate>

    <!-- Nom -->
    <div>
      <label for="baNom" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Nom du régime <span style="color:#ef4444">*</span>
      </label>
      <input type="text" name="nom" id="baNom"
             value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
             placeholder="Ex: Régime méditerranéen équilibré"
             style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
             onfocus="clearFieldError('baNom')" oninput="clearFieldError('baNom')">
      <div class="regime-field-error" id="err-baNom">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Objectif + Durée -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div>
        <label for="baObjectif" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
          Objectif <span style="color:#ef4444">*</span>
        </label>
        <select name="objectif" id="baObjectif"
                style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none;cursor:pointer"
                onchange="clearFieldError('baObjectif')">
          <option value="">-- Choisir --</option>
          <option value="perte_poids"    <?= ($_POST['objectif'] ?? '') === 'perte_poids'    ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien"       <?= ($_POST['objectif'] ?? '') === 'maintien'       ? 'selected' : '' ?>>Maintien du poids</option>
          <option value="prise_masse"    <?= ($_POST['objectif'] ?? '') === 'prise_masse'    ? 'selected' : '' ?>>Prise de masse</option>
          <option value="sante_generale" <?= ($_POST['objectif'] ?? '') === 'sante_generale' ? 'selected' : '' ?>>Santé générale</option>
        </select>
        <div class="regime-field-error" id="err-baObjectif">
          <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
        </div>
      </div>
      <div>
        <label for="baDuree" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
          Durée (semaines) <span style="color:#ef4444">*</span>
        </label>
        <input type="number" name="duree_semaines" id="baDuree" min="1" max="52"
               value="<?= htmlspecialchars($_POST['duree_semaines'] ?? '4') ?>"
               style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
               onfocus="clearFieldError('baDuree')" oninput="clearFieldError('baDuree')">
        <div class="regime-field-error" id="err-baDuree">
          <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
        </div>
      </div>
    </div>

    <!-- Calories / jour -->
    <div>
      <label for="baCalories" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Apport calorique journalier (kcal) <span style="color:#ef4444">*</span>
      </label>
      <input type="number" name="calories_jour" id="baCalories" min="500" max="6000"
             value="<?= htmlspecialchars($_POST['calories_jour'] ?? '2000') ?>"
             style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
             onfocus="clearFieldError('baCalories')" oninput="clearFieldError('baCalories')">
      <div class="regime-field-error" id="err-baCalories">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Description -->
    <div>
      <label style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Description <span style="font-weight:400;color:var(--text-muted)">(facultatif)</span>
      </label>
      <textarea name="description" rows="4"
                placeholder="Décrivez ce régime…"
                style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none;resize:vertical"
                onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>

    <!-- Restrictions -->
    <div>
      <label style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Restrictions <span style="font-weight:400;color:var(--text-muted)">(facultatif)</span>
      </label>
      <textarea name="restrictions" rows="2"
                placeholder="Ex: Sans gluten, végétarien…"
                style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none;resize:vertical"
                onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"><?= htmlspecialchars($_POST['restrictions'] ?? '') ?></textarea>
    </div>

    <!-- Auteur -->
    <div style="border-top:1px solid var(--border);padding-top:1.25rem">
      <label for="baAuteur" style="display:block;font-size:.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:.4rem">
        Auteur / Source <span style="color:#ef4444">*</span>
      </label>
      <input type="text" name="soumis_par" id="baAuteur"
             value="<?= htmlspecialchars($_POST['soumis_par'] ?? 'Admin GreenBite') ?>"
             placeholder="Ex: Équipe GreenBite"
             style="width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:.875rem;background:var(--surface);color:var(--foreground);transition:all .3s;outline:none"
             onfocus="clearFieldError('baAuteur')" oninput="clearFieldError('baAuteur')">
      <div class="regime-field-error" id="err-baAuteur">
        <i data-lucide="alert-circle" style="width:.75rem;height:.75rem;flex-shrink:0"></i><span></span>
      </div>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:.75rem;justify-content:flex-end;padding-top:.5rem">
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=regimes" class="btn btn-outline" style="border-radius:var(--radius-full)">
        <i data-lucide="x" style="width:.875rem;height:.875rem"></i> Annuler
      </a>
      <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="check-circle" style="width:.875rem;height:.875rem"></i> Publier le régime
      </button>
    </div>
  </form>
</div>

<script>
function showFieldError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return;
  field.style.borderColor = '#ef4444';
  field.style.boxShadow   = '0 0 0 3px rgba(239,68,68,0.12)';
  errBox.querySelector('span').textContent = message;
  errBox.classList.add('visible');
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function clearFieldError(fieldId) {
  const field = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return;
  field.style.borderColor = '';
  field.style.boxShadow   = '';
  errBox.classList.remove('visible');
}

document.getElementById('backRegimeAddForm').addEventListener('submit', function(e) {
  let firstErr = null, hasError = false;

  const rules = [
    { id:'baNom',      val:() => document.getElementById('baNom').value.trim(),
      check: v => !v ? 'Le nom est obligatoire.' : v.length < 3 ? 'Au moins 3 caractères.' : null },
    { id:'baObjectif', val:() => document.getElementById('baObjectif').value,
      check: v => !v ? "Veuillez choisir un objectif." : null },
    { id:'baDuree',    val:() => parseInt(document.getElementById('baDuree').value),
      check: v => isNaN(v) ? 'La durée est obligatoire.' : v < 1 || v > 52 ? 'Entre 1 et 52 semaines.' : null },
    { id:'baCalories', val:() => parseInt(document.getElementById('baCalories').value),
      check: v => isNaN(v) ? "L'apport calorique est obligatoire." : v < 500 || v > 6000 ? 'Entre 500 et 6 000 kcal.' : null },
    { id:'baAuteur',   val:() => document.getElementById('baAuteur').value.trim(),
      check: v => !v ? "L'auteur est obligatoire." : v.length < 2 ? 'Au moins 2 caractères.' : null },
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
