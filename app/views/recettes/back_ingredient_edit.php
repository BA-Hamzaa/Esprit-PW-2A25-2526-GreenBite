<!-- Vue BackOffice : Modifier un ingrédient -->
<div style="padding:2rem;max-width:48rem">
  <a href="<?= BASE_URL ?>/?page=admin-recettes&action=ingredients" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux ingrédients
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
    </div>
    <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier l'Ingrédient #<?= $ingredient['id'] ?></h1>
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
          <input type="text" name="nom" id="nom" class="form-input" value="<?= htmlspecialchars($_POST['nom'] ?? $ingredient['nom']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="unite"><i data-lucide="ruler" style="width:0.875rem;height:0.875rem"></i> Unité</label>
          <input type="text" name="unite" id="unite" class="form-input" value="<?= htmlspecialchars($_POST['unite'] ?? $ingredient['unite']) ?>">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="calories_par_unite"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories / unité</label>
          <input type="number" name="calories_par_unite" id="calories_par_unite" class="form-input" value="<?= htmlspecialchars($_POST['calories_par_unite'] ?? $ingredient['calories_par_unite']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label"><i data-lucide="map-pin" style="width:0.875rem;height:0.875rem"></i> Production locale ?</label>
          <?php $isLocal = $_POST['is_local'] ?? $ingredient['is_local']; ?>
          <div class="flex items-center gap-4 mt-2">
            <label class="flex items-center gap-2 cursor-pointer" style="color:var(--text-secondary)">
              <input type="radio" name="is_local" value="1" <?= $isLocal == '1' ? 'checked' : '' ?> class="form-checkbox"> Oui 🌿
            </label>
            <label class="flex items-center gap-2 cursor-pointer" style="color:var(--text-secondary)">
              <input type="radio" name="is_local" value="0" <?= $isLocal == '0' ? 'checked' : '' ?> class="form-checkbox"> Non
            </label>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"><i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Mettre à jour</button>
    </form>
  </div>
</div>
<script>
document.getElementById('ingredientForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('nom').value.trim() === '') errors.push("Le nom est obligatoire.");
  if (document.getElementById('unite').value.trim() === '') errors.push("L'unité est obligatoire.");
  if (errors.length > 0) {
    e.preventDefault();
    showToast('error', errors[0]);
  }
});
</script>
