<!-- Vue FrontOffice : Ajouter un repas -->
<div style="padding:2rem;max-width:48rem">
  <a href="<?= BASE_URL ?>/?page=nutrition" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour au suivi
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
      <i data-lucide="utensils-crossed" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Ajouter un repas</h1>
      <p class="text-sm" style="color:var(--text-muted)">Enregistrez votre repas et ses aliments</p>
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
        <label class="form-label" for="nom"><i data-lucide="type" style="width:0.75rem;height:0.75rem"></i> Nom du repas</label>
        <input type="text" name="nom" id="nom" class="form-input" placeholder="Ex: Toast avocat et oeuf" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="date_repas"><i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i> Date</label>
          <input type="date" name="date_repas" id="date_repas" class="form-input" value="<?= htmlspecialchars($_POST['date_repas'] ?? date('Y-m-d')) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="type_repas"><i data-lucide="clock" style="width:0.75rem;height:0.75rem"></i> Type de repas</label>
          <select name="type_repas" id="type_repas" class="form-input">
            <option value="">-- Choisir --</option>
            <option value="petit_dejeuner" <?= (isset($_POST['type_repas']) && $_POST['type_repas'] === 'petit_dejeuner') ? 'selected' : '' ?>>🌅 Petit-déjeuner</option>
            <option value="dejeuner" <?= (isset($_POST['type_repas']) && $_POST['type_repas'] === 'dejeuner') ? 'selected' : '' ?>>☀️ Déjeuner</option>
            <option value="diner" <?= (isset($_POST['type_repas']) && $_POST['type_repas'] === 'diner') ? 'selected' : '' ?>>🌙 Dîner</option>
            <option value="collation" <?= (isset($_POST['type_repas']) && $_POST['type_repas'] === 'collation') ? 'selected' : '' ?>>🍎 Collation</option>
          </select>
        </div>
      </div>

      <!-- Aliments -->
      <div style="border-top:1px solid var(--border);padding-top:1.5rem;margin-top:0.5rem">
        <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="apple" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Aliments</h2>
        <div id="aliments-container" class="space-y-3">
          <div class="flex gap-3 items-center aliment-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
            <select name="aliment_ids[]" class="form-input flex-1">
              <option value="">-- Choisir un aliment --</option>
              <?php foreach ($aliments as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nom']) ?> (<?= $a['calories'] ?> kcal/100<?= $a['unite'] ?>)</option>
              <?php endforeach; ?>
            </select>
            <input type="number" name="quantites[]" class="form-input" style="width:120px" placeholder="Quantité" step="0.01">
            <button type="button" class="icon-btn" style="color:var(--destructive);flex-shrink:0" onclick="this.closest('.aliment-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
          </div>
        </div>
        <button type="button" id="add-aliment-btn" class="btn btn-outline-primary btn-sm mt-3"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un aliment</button>
      </div>

      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl mt-6">
        <i data-lucide="check" style="width:1.125rem;height:1.125rem"></i> Enregistrer le repas
      </button>
    </form>
  </div>
</div>

<script>
document.getElementById('add-aliment-btn').addEventListener('click', function() {
  const container = document.getElementById('aliments-container');
  const row = container.querySelector('.aliment-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '';
  container.appendChild(row);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});
document.getElementById('repasForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('nom').value.trim() === '') errors.push('Le nom du repas est obligatoire.');
  if (document.getElementById('date_repas').value === '') errors.push('La date est obligatoire.');
  if (document.getElementById('type_repas').value === '') errors.push('Le type de repas est obligatoire.');
  if (errors.length > 0) {
    e.preventDefault();
    errors.forEach(err => showToast('error', err));
  }
});

function showToast(type, msg) {
  let container = document.getElementById('toastContainer');
  if (!container) { container = document.createElement('div'); container.id = 'toastContainer'; document.body.appendChild(container); }
  const t = document.createElement('div');
  t.className = 'toast ' + type;
  t.innerHTML = '<i data-lucide="'+(type==='success'?'check-circle-2':'alert-circle')+'" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i><span style="font-size:0.875rem;font-weight:500">'+msg+'</span>';
  container.appendChild(t);
  if (typeof lucide !== 'undefined') lucide.createIcons();
  setTimeout(()=>{ t.classList.add('hiding'); setTimeout(()=>t.remove(), 300); }, 4000);
}
</script>
