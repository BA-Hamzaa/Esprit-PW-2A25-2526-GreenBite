<!-- Vue BackOffice : Ajouter un aliment -->
<div style="padding:2rem;max-width:48rem">
  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=aliments" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux aliments
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
      <i data-lucide="plus-circle" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
    </div>
    <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Ajouter un Aliment</h1>
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
          <input type="text" name="nom" id="nom" class="form-input" placeholder="Ex: Avocat" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
          <div id="err-alimentNom" style="display:none;align-items:center;gap:0.35rem;margin-top:0.35rem;font-size:0.75rem;font-weight:600;color:#ef4444">
            <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem"></i><span></span>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="unite"><i data-lucide="ruler" style="width:0.875rem;height:0.875rem"></i> Unité</label>
          <input type="text" name="unite" id="unite" class="form-input" placeholder="g, ml, unité..." value="<?= htmlspecialchars($_POST['unite'] ?? 'g') ?>">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="calories"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories</label>
          <input type="number" name="calories" id="calories" class="form-input" placeholder="160" value="<?= htmlspecialchars($_POST['calories'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="proteines"><i data-lucide="beef" style="width:0.875rem;height:0.875rem"></i> Protéines (g)</label>
          <input type="number" name="proteines" id="proteines" class="form-input" step="0.1" placeholder="2" value="<?= htmlspecialchars($_POST['proteines'] ?? '0') ?>">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="glucides"><i data-lucide="wheat" style="width:0.875rem;height:0.875rem"></i> Glucides (g)</label>
          <input type="number" name="glucides" id="glucides" class="form-input" step="0.1" placeholder="8.5" value="<?= htmlspecialchars($_POST['glucides'] ?? '0') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="lipides"><i data-lucide="droplets" style="width:0.875rem;height:0.875rem"></i> Lipides (g)</label>
          <input type="number" name="lipides" id="lipides" class="form-input" step="0.1" placeholder="14.7" value="<?= htmlspecialchars($_POST['lipides'] ?? '0') ?>">
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"><i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Enregistrer</button>
    </form>
  </div>
</div>
<script>
document.getElementById('alimentForm').addEventListener('submit', function(e) {
  let errors = [];
  const nomVal = document.getElementById('nom').value.trim();
  const errBox = document.getElementById('err-alimentNom');
  errBox.style.display = 'none';
  document.getElementById('nom').style.borderColor = '';
  document.getElementById('nom').style.boxShadow   = '';
  if (!nomVal) {
    _showNomErr('Le nom est obligatoire.'); errors.push('Le nom est obligatoire.');
  } else if (nomVal.length < 3) {
    _showNomErr('Le nom doit contenir au moins 3 caractères.'); errors.push('Le nom doit contenir au moins 3 caractères.');
  }
  const cal = document.getElementById('calories').value;
  if (cal === '' || isNaN(cal) || parseInt(cal) < 0) errors.push('Calories invalides.');
  if (errors.length > 0) {
    e.preventDefault();
    if (typeof showToast === 'function') showToast('error', errors[0]);
  }
  function _showNomErr(msg) {
    const f = document.getElementById('nom'), b = document.getElementById('err-alimentNom');
    f.style.borderColor = '#ef4444'; f.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.12)';
    b.querySelector('span').textContent = msg; b.style.display = 'flex';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }
});
document.getElementById('nom').addEventListener('input', function() {
  const val = this.value.trim(), box = document.getElementById('err-alimentNom');
  if (val.length > 0 && val.length < 3) {
    this.style.borderColor = '#ef4444'; this.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.12)';
    box.querySelector('span').textContent = 'Le nom doit contenir au moins 3 caractères.';
    box.style.display = 'flex';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  } else { this.style.borderColor = ''; this.style.boxShadow = ''; box.style.display = 'none'; }
});
</script>
