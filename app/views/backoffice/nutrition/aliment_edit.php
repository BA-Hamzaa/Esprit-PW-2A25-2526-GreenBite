<!-- Vue BackOffice : Modifier un aliment -->
<div style="padding:2rem;max-width:48rem">
  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=aliments" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux aliments
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
    </div>
    <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier l'Aliment #<?= $aliment['id'] ?></h1>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:2rem">
    <form novalidate method="POST" id="alimentForm">
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="nom"><i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Nom <span style="color:#ef4444">*</span></label>
          <input type="text" name="nom" id="nom" class="form-input" value="<?= htmlspecialchars($_POST['nom'] ?? $aliment['nom']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="unite"><i data-lucide="ruler" style="width:0.875rem;height:0.875rem"></i> Unité</label>
          <input type="text" name="unite" id="unite" class="form-input" placeholder="g, ml, unité..." value="<?= htmlspecialchars($_POST['unite'] ?? $aliment['unite'] ?? 'g') ?>">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="calories"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories</label>
          <input type="number" name="calories" id="calories" class="form-input" value="<?= htmlspecialchars($_POST['calories'] ?? $aliment['calories']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="proteines"><i data-lucide="beef" style="width:0.875rem;height:0.875rem"></i> Protéines (g)</label>
          <input type="number" name="proteines" id="proteines" class="form-input" step="0.1" value="<?= htmlspecialchars($_POST['proteines'] ?? $aliment['proteines']) ?>">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="glucides"><i data-lucide="wheat" style="width:0.875rem;height:0.875rem"></i> Glucides (g)</label>
          <input type="number" name="glucides" id="glucides" class="form-input" step="0.1" value="<?= htmlspecialchars($_POST['glucides'] ?? $aliment['glucides']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="lipides"><i data-lucide="droplets" style="width:0.875rem;height:0.875rem"></i> Lipides (g)</label>
          <input type="number" name="lipides" id="lipides" class="form-input" step="0.1" value="<?= htmlspecialchars($_POST['lipides'] ?? $aliment['lipides']) ?>">
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"><i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Mettre à jour</button>
    </form>
  </div>
</div>
<script>
const _EI3 = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
function showFE(field, msg) {
  field.classList.add('is-invalid'); field.classList.remove('is-valid');
  let wrap = field.closest('.form-group') || field.parentElement;
  let el = wrap.querySelector('.field-error');
  if (!el) { el = document.createElement('div'); el.className = 'field-error'; wrap.appendChild(el); }
  el.innerHTML = _EI3 + ' ' + msg; el.classList.add('show');
}
function clearFE(field) {
  field.classList.remove('is-invalid'); field.classList.add('is-valid');
  const wrap = field.closest('.form-group') || field.parentElement;
  const el = wrap.querySelector('.field-error'); if (el) el.classList.remove('show');
}

const nomEl  = document.getElementById('nom');
const uniEl  = document.getElementById('unite');
const calEl  = document.getElementById('calories');
const protEl = document.getElementById('proteines');
const gluEl  = document.getElementById('glucides');
const lipEl  = document.getElementById('lipides');

function validateNom() {
  const v = nomEl.value.trim();
  if (!v) { showFE(nomEl, 'Le nom est obligatoire.'); return false; }
  else if (v.length < 3) { showFE(nomEl, 'Min. 3 caractères.'); return false; }
  else { clearFE(nomEl); return true; }
}
function validateNumber(el, name, allowEmpty = false) {
  const v = el.value.trim();
  if (!v && allowEmpty) { clearFE(el); return true; }
  if (!v && !allowEmpty) { showFE(el, `${name} obligatoire.`); return false; }
  const num = parseFloat(v);
  if (isNaN(num) || num < 0) { showFE(el, `${name} doit être ≥ 0.`); return false; }
  else { clearFE(el); return true; }
}

nomEl.addEventListener('blur', validateNom);
nomEl.addEventListener('input', () => { if (nomEl.classList.contains('is-invalid')) validateNom(); });

uniEl.addEventListener('blur', () => { if (!uniEl.value.trim()) showFE(uniEl, 'Unité obligatoire.'); else clearFE(uniEl); });
uniEl.addEventListener('input', () => { if (uniEl.classList.contains('is-invalid') && uniEl.value.trim()) clearFE(uniEl); });

calEl.addEventListener('blur',  () => validateNumber(calEl,  'Calories', false));
calEl.addEventListener('input', () => { if (calEl.classList.contains('is-invalid')) validateNumber(calEl, 'Calories', false); });

protEl.addEventListener('blur',  () => validateNumber(protEl, 'Protéines', false));
protEl.addEventListener('input', () => { if (protEl.classList.contains('is-invalid')) validateNumber(protEl, 'Protéines', false); });

gluEl.addEventListener('blur',  () => validateNumber(gluEl, 'Glucides', false));
gluEl.addEventListener('input', () => { if (gluEl.classList.contains('is-invalid')) validateNumber(gluEl, 'Glucides', false); });

lipEl.addEventListener('blur',  () => validateNumber(lipEl, 'Lipides', false));
lipEl.addEventListener('input', () => { if (lipEl.classList.contains('is-invalid')) validateNumber(lipEl, 'Lipides', false); });

document.getElementById('alimentForm').addEventListener('submit', function(e) {
  let valid = true;
  if (!validateNom()) valid = false;
  if (!uniEl.value.trim()) { showFE(uniEl, 'Unité obligatoire.'); valid = false; } else clearFE(uniEl);
  if (!validateNumber(calEl,  'Calories',  false)) valid = false;
  if (!validateNumber(protEl, 'Protéines', false)) valid = false;
  if (!validateNumber(gluEl,  'Glucides',  false)) valid = false;
  if (!validateNumber(lipEl,  'Lipides',   false)) valid = false;
  if (!valid) e.preventDefault();
});
</script>
