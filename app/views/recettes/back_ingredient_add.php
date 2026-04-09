<!-- Vue BackOffice : Ajouter un ingrédient -->
<div style="padding:2rem;max-width:48rem">
  <a href="<?= BASE_URL ?>/?page=admin-recettes&action=ingredients" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux ingrédients
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
      <i data-lucide="plus-circle" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Ajouter un Ingrédient</h1>
      <p class="text-sm" style="color:var(--text-muted)">Référencez un nouvel ingrédient pour vos recettes</p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:2rem">
    <form novalidate method="POST" id="ingredientForm">
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="nom"><i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Nom</label>
          <input type="text" name="nom" id="nom" class="form-input" placeholder="Ex: Tomate" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="unite"><i data-lucide="ruler" style="width:0.875rem;height:0.875rem"></i> Unité</label>
          <input type="text" name="unite" id="unite" class="form-input" placeholder="g, ml, pièce..." value="<?= htmlspecialchars($_POST['unite'] ?? 'g') ?>">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="calories_par_unite"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories / unité</label>
          <input type="number" name="calories_par_unite" id="calories_par_unite" class="form-input" placeholder="18" value="<?= htmlspecialchars($_POST['calories_par_unite'] ?? '0') ?>">
        </div>
        <div class="form-group">
          <label class="form-label"><i data-lucide="map-pin" style="width:0.875rem;height:0.875rem"></i> Production locale ?</label>
          <div class="flex items-center gap-4 mt-2">
            <label class="flex items-center gap-2 cursor-pointer" style="color:var(--text-secondary)">
              <input type="radio" name="is_local" value="1" <?= (($_POST['is_local'] ?? '1') == '1') ? 'checked' : '' ?> class="form-checkbox"> Oui 🌿
            </label>
            <label class="flex items-center gap-2 cursor-pointer" style="color:var(--text-secondary)">
              <input type="radio" name="is_local" value="0" <?= (($_POST['is_local'] ?? '1') == '0') ? 'checked' : '' ?> class="form-checkbox"> Non
            </label>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"><i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Enregistrer</button>
    </form>
  </div>
</div>
<script>
document.getElementById('ingredientForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('nom').value.trim() === '') errors.push("Le nom est obligatoire.");
  if (document.getElementById('unite').value.trim() === '') errors.push("L'unité est obligatoire.");
  if (errors.length > 0) { e.preventDefault(); let box = document.getElementById('error-box'); if (!box) { box = document.createElement('div'); box.id='error-box'; box.className='p-4 rounded-xl mb-6'; box.style.cssText='background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5'; document.querySelector('.card').before(box); } box.innerHTML = errors.map(e=>'<div class="mb-1">⚠️ '+e+'</div>').join(''); }
});
</script>
