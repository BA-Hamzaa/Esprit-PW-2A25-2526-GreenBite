<!-- Vue BackOffice : Modifier une recette -->
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=admin-recettes&action=list" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux recettes
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier la Recette #<?= $recette['id'] ?></h1>
      <p class="text-sm" style="color:var(--text-muted)">Mettez à jour les détails de la recette</p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:2rem">
    <form novalidate method="POST" enctype="multipart/form-data" id="recetteForm">
      <div class="form-group">
        <label class="form-label" for="titre"><i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Titre</label>
        <input type="text" name="titre" id="titre" class="form-input" value="<?= htmlspecialchars($_POST['titre'] ?? $recette['titre']) ?>">
      </div>
      <div class="form-group">
        <label class="form-label" for="description"><i data-lucide="align-left" style="width:0.875rem;height:0.875rem"></i> Description</label>
        <textarea name="description" id="description" class="form-textarea" rows="2"><?= htmlspecialchars($_POST['description'] ?? $recette['description']) ?></textarea>
      </div>
      <div class="form-group">
        <label class="form-label" for="instructions"><i data-lucide="list-ordered" style="width:0.875rem;height:0.875rem"></i> Instructions</label>
        <textarea name="instructions" id="instructions" class="form-textarea" rows="5"><?= htmlspecialchars($_POST['instructions'] ?? $recette['instructions']) ?></textarea>
      </div>
      <div class="grid grid-cols-3 gap-4">
        <div class="form-group">
          <label class="form-label" for="temps_preparation"><i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i> Temps (min)</label>
          <input type="number" name="temps_preparation" id="temps_preparation" class="form-input" value="<?= htmlspecialchars($_POST['temps_preparation'] ?? $recette['temps_preparation']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="difficulte"><i data-lucide="signal" style="width:0.875rem;height:0.875rem"></i> Difficulté</label>
          <?php $diff = $_POST['difficulte'] ?? $recette['difficulte']; ?>
          <select name="difficulte" id="difficulte" class="form-input">
            <option value="">-- Choisir --</option>
            <option value="facile" <?= $diff === 'facile' ? 'selected' : '' ?>>Facile</option>
            <option value="moyen" <?= $diff === 'moyen' ? 'selected' : '' ?>>Moyen</option>
            <option value="difficile" <?= $diff === 'difficile' ? 'selected' : '' ?>>Difficile</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="categorie"><i data-lucide="tag" style="width:0.875rem;height:0.875rem"></i> Catégorie</label>
          <input type="text" name="categorie" id="categorie" class="form-input" value="<?= htmlspecialchars($_POST['categorie'] ?? $recette['categorie']) ?>">
        </div>
      </div>
      <div class="grid grid-cols-3 gap-4">
        <div class="form-group">
          <label class="form-label" for="calories_total"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories</label>
          <input type="number" name="calories_total" id="calories_total" class="form-input" value="<?= htmlspecialchars($_POST['calories_total'] ?? $recette['calories_total']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="score_carbone"><i data-lucide="leaf" style="width:0.875rem;height:0.875rem"></i> Score CO₂</label>
          <input type="number" name="score_carbone" id="score_carbone" class="form-input" step="0.01" value="<?= htmlspecialchars($_POST['score_carbone'] ?? $recette['score_carbone']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="image"><i data-lucide="image" style="width:0.875rem;height:0.875rem"></i> Nouvelle image</label>
          <input type="file" name="image" id="image" class="form-input" accept="image/*">
          <?php if (!empty($recette['image'])): ?><div class="text-xs mt-1" style="color:var(--text-muted)">Actuelle: <?= htmlspecialchars($recette['image']) ?></div><?php endif; ?>
        </div>
      </div>

      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <label class="form-label"><i data-lucide="carrot" style="width:0.875rem;height:0.875rem"></i> Ingrédients</label>
        <div id="ingredients-container" class="space-y-3">
          <?php if (!empty($recetteIngredients)): ?>
            <?php foreach ($recetteIngredients as $ri): ?>
              <div class="flex gap-3 items-center ingredient-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
                <select name="ingredient_ids[]" class="form-input flex-1"><?php foreach ($ingredients as $i): ?><option value="<?= $i['id'] ?>" <?= $i['id'] == $ri['ingredient_id'] ? 'selected' : '' ?>><?= htmlspecialchars($i['nom']) ?></option><?php endforeach; ?></select>
                <input type="number" name="quantites[]" class="form-input" style="width:120px" value="<?= $ri['quantite'] ?>" step="0.01">
                <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.ingredient-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="flex gap-3 items-center ingredient-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
              <select name="ingredient_ids[]" class="form-input flex-1"><option value="">-- Choisir --</option><?php foreach ($ingredients as $i): ?><option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['nom']) ?></option><?php endforeach; ?></select>
              <input type="number" name="quantites[]" class="form-input" style="width:120px" placeholder="Qté" step="0.01">
              <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.ingredient-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
            </div>
          <?php endif; ?>
        </div>
        <button type="button" id="add-ingredient-btn" class="btn btn-outline-primary btn-sm mt-3"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un ingrédient</button>
      </div>

      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"><i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Mettre à jour</button>
    </form>
  </div>
</div>
<script>
document.getElementById('add-ingredient-btn').addEventListener('click', function() {
  const c = document.getElementById('ingredients-container');
  const row = c.querySelector('.ingredient-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '';
  c.appendChild(row);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});
document.getElementById('recetteForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('titre').value.trim() === '') errors.push("Le titre est obligatoire.");
  if (document.getElementById('instructions').value.trim().length < 20) errors.push("Instructions : min 20 caractères.");
  if (errors.length > 0) {
    e.preventDefault();
    showToast('error', errors[0]);
  }
});
</script>
