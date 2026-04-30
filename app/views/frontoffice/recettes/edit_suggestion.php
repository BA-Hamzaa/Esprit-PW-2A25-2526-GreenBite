<!-- Vue FrontOffice : Modifier ma suggestion de recette (client) -->
<div style="padding:2rem;max-width:52rem;margin:0 auto">

  <!-- Back link -->
  <a href="<?= BASE_URL ?>/?page=recettes&action=my-suggestions" class="flex items-center gap-2 text-sm mb-6"
     style="color:var(--secondary);font-weight:500;transition:all 0.3s"
     onmouseover="this.style.transform='translateX(-4px)'"
     onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour à mes suggestions
  </a>

  <!-- Header -->
  <div class="flex items-center gap-4 mb-8">
    <div style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;
                background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl);
                box-shadow:0 4px 12px rgba(37,99,235,0.2)">
      <i data-lucide="edit-3" style="width:1.75rem;height:1.75rem;color:#2563eb"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">
        Modifier ma Suggestion
      </h1>
      <p class="text-sm" style="color:var(--text-muted)">
        Mise à jour de « <?= htmlspecialchars($recette['titre']) ?> »
      </p>
    </div>
  </div>

  <!-- Re-validation warning -->
  <div class="flex items-start gap-3 mb-6 p-4 rounded-xl"
       style="background:linear-gradient(135deg,#fef9c3,#fefce8);border:1px solid #fde047;color:#854d0e">
    <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
    <p class="text-sm">
      <strong>Attention :</strong> En modifiant votre recette, elle repassera automatiquement <strong>en attente de validation</strong>.
      L'équipe GreenBite devra l'approuver à nouveau.
    </p>
  </div>

  <!-- Info: soumis par -->
  <div class="flex items-center gap-3 mb-4 p-3 rounded-xl"
       style="background:rgba(82,183,136,0.06);border:1px solid rgba(82,183,136,0.15)">
    <i data-lucide="user" style="width:1rem;height:1rem;color:var(--secondary)"></i>
    <span class="text-sm" style="color:var(--text-secondary)">
      Recette soumise par : <strong><?= htmlspecialchars($recette['soumis_par']) ?></strong>
    </span>
  </div>
  <!-- Hidden: soumis_par -->

  <?php if (!empty($errors)): ?>
    <div class="flex items-start gap-3 p-4 rounded-xl mb-6" id="error-box"
         style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1px solid #fca5a5;color:#991b1b">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div>
        <?php foreach ($errors as $e): ?>
          <div class="mb-1"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Form card -->
  <div class="card" style="padding:2rem;border-top:4px solid #2563eb">
    <form novalidate method="POST" enctype="multipart/form-data" id="editSuggestionForm">

      <!-- Hidden soumis_par -->
      <input type="hidden" name="soumis_par" value="<?= htmlspecialchars($recette['soumis_par']) ?>">

      <!-- Titre -->
      <div class="form-group">
        <label class="form-label" for="titre">
          <i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Titre de la recette <span style="color:var(--destructive)">*</span>
        </label>
        <input type="text" name="titre" id="titre" class="form-input"
               placeholder="Ex: Curry de lentilles au lait de coco"
               value="<?= htmlspecialchars($_POST['titre'] ?? $recette['titre']) ?>">
      </div>

      <!-- Description -->
      <div class="form-group">
        <label class="form-label" for="description">
          <i data-lucide="align-left" style="width:0.875rem;height:0.875rem"></i> Description courte
        </label>
        <textarea name="description" id="description" class="form-textarea" rows="2"
                  placeholder="Brève présentation de votre recette..."><?= htmlspecialchars($_POST['description'] ?? $recette['description']) ?></textarea>
      </div>

      <!-- Instructions -->
      <div class="form-group">
        <label class="form-label" for="instructions">
          <i data-lucide="list-ordered" style="width:0.875rem;height:0.875rem"></i>
          Instructions détaillées <span style="color:var(--destructive)">*</span> <small style="color:var(--text-muted)">(min 20 caractères)</small>
        </label>
        <textarea name="instructions" id="instructions" class="form-textarea" rows="6"
                  placeholder="Étape 1 : ...&#10;Étape 2 : ...&#10;Étape 3 : ..."><?= htmlspecialchars($_POST['instructions'] ?? $recette['instructions']) ?></textarea>
      </div>

      <!-- Row : temps / difficulté / catégorie -->
      <div class="grid grid-cols-3 gap-4">
        <div class="form-group">
          <label class="form-label" for="temps_preparation">
            <i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i> Temps (min) <span style="color:var(--destructive)">*</span>
          </label>
          <input type="number" name="temps_preparation" id="temps_preparation" class="form-input"
                 placeholder="30" 
                 value="<?= htmlspecialchars($_POST['temps_preparation'] ?? $recette['temps_preparation']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="difficulte">
            <i data-lucide="signal" style="width:0.875rem;height:0.875rem"></i> Difficulté <span style="color:var(--destructive)">*</span>
          </label>
          <?php $diff = $_POST['difficulte'] ?? $recette['difficulte']; ?>
          <select name="difficulte" id="difficulte" class="form-input">
            <option value="">-- Choisir --</option>
            <option value="facile"   <?= $diff === 'facile'   ? 'selected' : '' ?>>🟢 Facile</option>
            <option value="moyen"    <?= $diff === 'moyen'    ? 'selected' : '' ?>>🟡 Moyen</option>
            <option value="difficile"<?= $diff === 'difficile'? 'selected' : '' ?>>🔴 Difficile</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="categorie">
            <i data-lucide="tag" style="width:0.875rem;height:0.875rem"></i> Catégorie
          </label>
          <input type="text" name="categorie" id="categorie" class="form-input"
                 placeholder="Salade, Bowl, Soupe..."
                 value="<?= htmlspecialchars($_POST['categorie'] ?? $recette['categorie']) ?>">
        </div>
      </div>

      <!-- Row : calories / CO2 / image -->
      <div class="grid grid-cols-3 gap-4">
        <div class="form-group">
          <label class="form-label" for="calories_total">
            <i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories (kcal)
          </label>
          <input type="number" name="calories_total" id="calories_total" class="form-input"
                 placeholder="450" 
                 value="<?= htmlspecialchars($_POST['calories_total'] ?? $recette['calories_total']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="score_carbone">
            <i data-lucide="leaf" style="width:0.875rem;height:0.875rem"></i> Score CO₂
          </label>
          <input type="number" name="score_carbone" id="score_carbone" class="form-input"
                 placeholder="1.20" 
                 value="<?= htmlspecialchars($_POST['score_carbone'] ?? $recette['score_carbone']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="image">
            <i data-lucide="image" style="width:0.875rem;height:0.875rem"></i> Photo (optionnel)
          </label>
          <input type="file" name="image" id="image" class="form-input" accept="image/*">
          <?php if (!empty($recette['image'])): ?>
            <div class="text-xs mt-1" style="color:var(--text-muted)">Actuelle: <?= htmlspecialchars($recette['image']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Ingrédients -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <label class="form-label">
          <i data-lucide="carrot" style="width:0.875rem;height:0.875rem"></i>
          Ingrédients <span style="color:var(--destructive)">*</span>
          <small style="color:var(--text-muted)">(au moins 1)</small>
        </label>
        <div id="ingredients-container" class="space-y-3">
          <?php if (!empty($recetteIngredients)): ?>
            <?php foreach ($recetteIngredients as $ri): ?>
              <div class="flex gap-3 items-center ingredient-row"
                   style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
                <select name="ingredient_ids[]" class="form-input flex-1">
                  <option value="">-- Choisir --</option>
                  <?php foreach ($ingredientsList as $ing): ?>
                    <option value="<?= $ing['id'] ?>" <?= $ing['id'] == $ri['ingredient_id'] ? 'selected' : '' ?>><?= htmlspecialchars($ing['nom']) ?> (<?= $ing['unite'] ?>)</option>
                  <?php endforeach; ?>
                </select>
                <input type="number" name="quantites[]" class="form-input"
                       style="width:120px" placeholder="Quantité"
                       value="<?= $ri['quantite'] ?>">
                <button type="button" class="icon-btn"
                        style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0"
                        onclick="this.closest('.ingredient-row').remove()">
                  <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i>
                </button>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="flex gap-3 items-center ingredient-row"
                 style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
              <select name="ingredient_ids[]" class="form-input flex-1">
                <option value="">-- Choisir un ingrédient --</option>
                <?php foreach ($ingredientsList as $ing): ?>
                  <option value="<?= $ing['id'] ?>"><?= htmlspecialchars($ing['nom']) ?> (<?= $ing['unite'] ?>)</option>
                <?php endforeach; ?>
              </select>
              <input type="number" name="quantites[]" class="form-input"
                     style="width:120px" placeholder="Quantité" >
              <button type="button" class="icon-btn"
                      style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0"
                      onclick="this.closest('.ingredient-row').remove()">
                <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i>
              </button>
            </div>
          <?php endif; ?>
        </div>
        <button type="button" id="add-ingredient-btn" class="btn btn-outline-primary btn-sm mt-3">
          <i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un ingrédient
        </button>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"
              style="background:linear-gradient(135deg,#2563eb,#3b82f6);border:none">
        <i data-lucide="save" style="width:1.125rem;height:1.125rem"></i>
        Mettre à jour et resoumettre
      </button>
      <p class="text-center text-xs mt-3" style="color:var(--text-muted)">
        Votre recette repassera en attente de validation après modification 🌿
      </p>
    </form>
  </div>
</div>

<script>
// Clone ingredient row
document.getElementById('add-ingredient-btn').addEventListener('click', function() {
  const c = document.getElementById('ingredients-container');
  const row = c.querySelector('.ingredient-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '';
  c.appendChild(row);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

// Client-side validation with toast
document.getElementById('editSuggestionForm').addEventListener('submit', function(e) {
  const errors = [];
  if (!document.getElementById('titre').value.trim())
    errors.push("Le titre est obligatoire.");
  if (document.getElementById('instructions').value.trim().length < 20)
    errors.push("Les instructions doivent contenir au moins 20 caractères.");
  const temps = document.getElementById('temps_preparation').value;
  if (!temps || parseInt(temps) <= 0)
    errors.push("Le temps de préparation doit être un nombre positif.");
  if (!document.getElementById('difficulte').value)
    errors.push("La difficulté est obligatoire.");

  // Check at least one ingredient filled
  let hasIngredient = false;
  document.querySelectorAll('#ingredients-container .ingredient-row').forEach(row => {
    const sel = row.querySelector('select').value;
    const qty = parseFloat(row.querySelector('input[type="number"]').value);
    if (sel && qty > 0) hasIngredient = true;
  });
  if (!hasIngredient) errors.push("Ajoutez au moins un ingrédient avec une quantité.");

  if (errors.length > 0) {
    e.preventDefault();
    showToast('error', errors[0]);
  }
});
</script>
