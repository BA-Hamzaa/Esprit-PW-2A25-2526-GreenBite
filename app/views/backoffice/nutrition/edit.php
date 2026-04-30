<!-- Vue BackOffice : Modifier un repas -->
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=list" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour à la liste
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier le Repas #<?= $repas['id'] ?></h1>
      <p class="text-sm" style="color:var(--text-muted)">Modifiez les détails et les aliments</p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:2rem">
    <form novalidate method="POST" id="repasForm">
      <div class="form-group">
        <label class="form-label" for="nom"><i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Nom du repas <span style="color:#ef4444">*</span></label>
        <input type="text" name="nom" id="nom" class="form-input" value="<?= htmlspecialchars($_POST['nom'] ?? $repas['nom']) ?>">
        <div id="err-editRepasNom" style="display:none;align-items:center;gap:0.35rem;margin-top:0.35rem;font-size:0.75rem;font-weight:600;color:#ef4444">
          <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem"></i>
          <span></span>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="date_repas"><i data-lucide="calendar" style="width:0.875rem;height:0.875rem"></i> Date</label>
          <input type="date" name="date_repas" id="date_repas" class="form-input" value="<?= htmlspecialchars($_POST['date_repas'] ?? $repas['date_repas']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="type_repas"><i data-lucide="tag" style="width:0.875rem;height:0.875rem"></i> Type</label>
          <?php $curType = $_POST['type_repas'] ?? $repas['type_repas']; ?>
          <select name="type_repas" id="type_repas" class="form-input">
            <option value="">-- Choisir --</option>
            <option value="petit_dejeuner" <?= $curType === 'petit_dejeuner' ? 'selected' : '' ?>>Petit-déjeuner</option>
            <option value="dejeuner" <?= $curType === 'dejeuner' ? 'selected' : '' ?>>Déjeuner</option>
            <option value="diner" <?= $curType === 'diner' ? 'selected' : '' ?>>Dîner</option>
            <option value="collation" <?= $curType === 'collation' ? 'selected' : '' ?>>Collation</option>
          </select>
        </div>
      </div>

      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <label class="form-label"><i data-lucide="apple" style="width:0.875rem;height:0.875rem"></i> Aliments</label>
        <div id="aliments-container" class="space-y-3">
          <?php if (!empty($repasAliments)): ?>
            <?php foreach ($repasAliments as $ra): ?>
              <div class="flex gap-3 items-center aliment-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
                <select name="aliment_ids[]" class="form-input flex-1"><?php foreach ($aliments as $a): ?><option value="<?= $a['id'] ?>" <?= $a['id'] == $ra['aliment_id'] ? 'selected' : '' ?>><?= htmlspecialchars($a['nom']) ?> (<?= $a['calories'] ?> kcal)</option><?php endforeach; ?></select>
                <input type="number" name="quantites[]" class="form-input" style="width:120px" value="<?= $ra['quantite'] ?>" step="0.01">
                <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.aliment-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="flex gap-3 items-center aliment-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
              <select name="aliment_ids[]" class="form-input flex-1"><option value="">-- Aliment --</option><?php foreach ($aliments as $a): ?><option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nom']) ?></option><?php endforeach; ?></select>
              <input type="number" name="quantites[]" class="form-input" style="width:120px" placeholder="Qté" step="0.01">
              <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.aliment-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
            </div>
          <?php endif; ?>
        </div>
        <button type="button" id="add-aliment-btn" class="btn btn-outline-primary btn-sm mt-3"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un aliment</button>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"><i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Mettre à jour</button>
    </form>
  </div>
</div>
<script>
document.getElementById('add-aliment-btn').addEventListener('click', function() {
  const c = document.getElementById('aliments-container');
  const row = c.querySelector('.aliment-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '';
  c.appendChild(row);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});
document.getElementById('repasForm').addEventListener('submit', function(e) {
  let errors = [];
  const nomVal = document.getElementById('nom').value.trim();
  const errBox = document.getElementById('err-editRepasNom');
  errBox.style.display = 'none';
  document.getElementById('nom').style.borderColor = '';
  document.getElementById('nom').style.boxShadow   = '';
  if (!nomVal) {
    errors.push('Le nom est obligatoire.');
    _showNomErr('Le nom est obligatoire.');
  } else if (nomVal.length < 3) {
    errors.push('Le nom doit contenir au moins 3 caractères.');
    _showNomErr('Le nom doit contenir au moins 3 caractères.');
  }
  if (document.getElementById('date_repas').value === '') errors.push('La date est obligatoire.');
  if (document.getElementById('type_repas').value === '') errors.push('Le type est obligatoire.');
  if (errors.length > 0) {
    e.preventDefault();
    if (typeof showToast === 'function') showToast('error', errors[0]);
  }
  function _showNomErr(msg) {
    const f = document.getElementById('nom'), b = document.getElementById('err-editRepasNom');
    f.style.borderColor = '#ef4444'; f.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.12)';
    b.querySelector('span').textContent = msg; b.style.display = 'flex';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }
});
document.getElementById('nom').addEventListener('input', function() {
  const val = this.value.trim(), box = document.getElementById('err-editRepasNom');
  if (val.length > 0 && val.length < 3) {
    this.style.borderColor = '#ef4444'; this.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.12)';
    box.querySelector('span').textContent = 'Le nom doit contenir au moins 3 caractères.';
    box.style.display = 'flex';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  } else { this.style.borderColor = ''; this.style.boxShadow = ''; box.style.display = 'none'; }
});
</script>
