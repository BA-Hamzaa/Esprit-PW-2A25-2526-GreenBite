<!-- Vue BackOffice : Ajouter un Plan Nutritionnel -->
<div class="flex items-center justify-between mb-8">
  <div class="flex items-center gap-4">
    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plans" class="btn-ghost" style="padding:0.5rem;border-radius:var(--radius-full)"><i data-lucide="arrow-left"></i></a>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Ajouter un Plan</h1>
      <p class="text-sm" style="color:var(--text-muted)">Créer un nouveau programme dans le système</p>
    </div>
  </div>
</div>

<?php if (!empty($errors)): ?>
  <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5">
    <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
    <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
  </div>
<?php endif; ?>

<div class="card" style="padding:2.5rem;max-width:56rem">
  <form method="POST" id="adminPlanForm" novalidate>
    <div class="grid grid-cols-2 gap-6 mb-6">
      <div class="form-group col-span-2">
        <label class="form-label" for="nom">Nom du plan</label>
        <input type="text" name="nom" id="nom" class="form-input" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
      </div>

      <div class="form-group col-span-2">
        <label class="form-label" for="description">Description (Visible par les utilisateurs)</label>
        <textarea name="description" id="description" class="form-textarea"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="type_objectif">Type d'objectif</label>
        <select name="type_objectif" id="type_objectif" class="form-input">
          <option value="">-- Choisir --</option>
          <option value="perte_poids" <?= (($_POST['type_objectif'] ?? '') === 'perte_poids') ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien" <?= (($_POST['type_objectif'] ?? '') === 'maintien') ? 'selected' : '' ?>>Maintien</option>
          <option value="prise_masse" <?= (($_POST['type_objectif'] ?? '') === 'prise_masse') ? 'selected' : '' ?>>Prise de masse</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label" for="objectif_calories">Objectif Calorique Journalier</label>
        <input type="number" name="objectif_calories" id="objectif_calories" class="form-input" value="<?= htmlspecialchars($_POST['objectif_calories'] ?? '2000') ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="duree_jours">Durée (Jours)</label>
        <input type="number" name="duree_jours" id="duree_jours" class="form-input" value="<?= htmlspecialchars($_POST['duree_jours'] ?? '7') ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="date_debut">Date de début par défaut</label>
        <input type="date" name="date_debut" id="date_debut" class="form-input" value="<?= htmlspecialchars($_POST['date_debut'] ?? date('Y-m-d')) ?>">
      </div>
    </div>

    <h2 class="font-bold text-lg mb-4 mt-8" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem">Structure des Repas</h2>
    
    <div id="repas-container" class="space-y-4 mb-4">
      <div class="flex gap-3 items-center flex-wrap repas-row" style="background:var(--muted);padding:1rem;border-radius:var(--radius-xl)">
        <div style="flex:1;min-width:250px">
          <select name="repas_ids[]" class="form-input">
            <option value="">Sélectionnez un repas existant</option>
            <?php foreach ($repas as $r): ?>
              <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nom']) ?> (<?= $r['calories_total'] ?> kcal)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div style="width:150px">
          <input type="number" name="jours[]" class="form-input" placeholder="Jour (ex: 1)" value="1">
        </div>
        <button type="button" class="btn btn-outline-danger btn-round" style="padding:0.75rem" onclick="this.closest('.repas-row').remove()"><i data-lucide="trash-2"></i></button>
      </div>
    </div>
    
    <button type="button" id="add-repas-btn" class="btn btn-outline-secondary mb-8"><i data-lucide="plus"></i> Ajouter un créneau repas</button>

    <div class="flex justify-end gap-4 mt-6 pt-6" style="border-top:1px solid var(--border)">
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plans" class="btn btn-outline-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary">Créer le Plan Nutritionnel</button>
    </div>
  </form>
</div>

<script>
document.getElementById('add-repas-btn').addEventListener('click', function() {
  const container = document.getElementById('repas-container');
  let newRow = document.createElement('div');
  newRow.className = 'flex gap-3 items-center flex-wrap repas-row';
  newRow.style.cssText = 'background:var(--muted);padding:1rem;border-radius:var(--radius-xl)';
  
  let currentJour = 1;
  const rows = container.querySelectorAll('input[type="number"]');
  if (rows.length > 0) currentJour = parseInt(rows[rows.length-1].value) || 1;

  newRow.innerHTML = `
    <div style="flex:1;min-width:250px">
      <select name="repas_ids[]" class="form-input">
        <option value="">Sélectionnez un repas existant</option>
        <?php foreach ($repas as $r): ?><option value="<?= $r['id'] ?>"><?= htmlspecialchars(addslashes($r['nom'])) ?> (<?= $r['calories_total'] ?> kcal)</option><?php endforeach; ?>
      </select>
    </div>
    <div style="width:150px">
      <input type="number" name="jours[]" class="form-input" placeholder="Jour (ex: 1)" value="${currentJour}">
    </div>
    <button type="button" class="btn btn-outline-danger btn-round" style="padding:0.75rem" onclick="this.closest('.repas-row').remove()"><i data-lucide="trash-2"></i></button>
  `;
  container.appendChild(newRow);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

document.getElementById('adminPlanForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('nom').value.trim() === '') errors.push('Le nom du plan est obligatoire.');
  if (document.getElementById('type_objectif').value === '') errors.push('Le type d\'objectif est obligatoire.');
  if (!document.getElementById('objectif_calories').value) errors.push('L\'objectif calorique est obligatoire.');
  const dureeVal = document.getElementById('duree_jours').value;
  if (!dureeVal || parseInt(dureeVal) <= 0) errors.push('La durée en jours doit être supérieure à 0.');
  if (!document.getElementById('date_debut').value) errors.push('La date de début est obligatoire.');
  
  if (errors.length > 0) {
    e.preventDefault();
    alert(errors[0]);
  }
});
</script>
