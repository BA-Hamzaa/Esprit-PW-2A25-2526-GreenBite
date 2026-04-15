<!-- Vue FrontOffice : Modifier un Plan Nutritionnel -->
<div style="padding:2rem;max-width:56rem;margin:0 auto">
  <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux plans
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:#3b82f6"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier le Plan</h1>
      <p class="text-sm" style="color:var(--text-muted)"><?= htmlspecialchars($plan['nom']) ?></p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:2.5rem">
    <form novalidate method="POST" id="planForm">
      <!-- Section Informations de Base -->
      <h2 class="font-bold text-lg mb-4" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem">Informations Générales</h2>
      
      <div class="form-group">
        <label class="form-label" for="nom"><i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Nom du programme</label>
        <input type="text" name="nom" id="nom" class="form-input" placeholder="Ex: Plan Minceur 14 Jours" value="<?= htmlspecialchars($_POST['nom'] ?? $plan['nom']) ?>">
      </div>

      <div class="form-group mb-6">
        <label class="form-label" for="description"><i data-lucide="align-left" style="width:0.875rem;height:0.875rem"></i> Description</label>
        <textarea name="description" id="description" class="form-textarea" placeholder="Décrivez votre objectif..."><?= htmlspecialchars($_POST['description'] ?? $plan['description']) ?></textarea>
      </div>

      <!-- Section Objectifs -->
      <h2 class="font-bold text-lg mb-4 mt-8" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem">Objectifs & Paramètres</h2>

      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="type_objectif"><i data-lucide="target" style="width:0.875rem;height:0.875rem"></i> Type d'objectif</label>
          <select name="type_objectif" id="type_objectif" class="form-input">
            <option value="">-- Choisir --</option>
            <?php $selType = $_POST['type_objectif'] ?? $plan['type_objectif']; ?>
            <option value="perte_poids" <?= ($selType === 'perte_poids') ? 'selected' : '' ?>>🔴 Perte de poids</option>
            <option value="maintien" <?= ($selType === 'maintien') ? 'selected' : '' ?>>🟢 Maintien</option>
            <option value="prise_masse" <?= ($selType === 'prise_masse') ? 'selected' : '' ?>>🔵 Prise de masse</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="objectif_calories"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories visées (par jour)</label>
          <input type="number" name="objectif_calories" id="objectif_calories" class="form-input" placeholder="Ex: 2000" value="<?= htmlspecialchars($_POST['objectif_calories'] ?? $plan['objectif_calories']) ?>">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="duree_jours"><i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i> Durée (en jours)</label>
          <input type="number" name="duree_jours" id="duree_jours" class="form-input" value="<?= htmlspecialchars($_POST['duree_jours'] ?? $plan['duree_jours']) ?>" min="1">
        </div>
        <div class="form-group">
          <label class="form-label" for="date_debut"><i data-lucide="calendar" style="width:0.875rem;height:0.875rem"></i> Date de début</label>
          <input type="date" name="date_debut" id="date_debut" class="form-input" value="<?= htmlspecialchars($_POST['date_debut'] ?? $plan['date_debut']) ?>">
        </div>
      </div>

      <!-- Section Repas par Jour -->
      <h2 class="font-bold text-lg mb-4 mt-8" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem">Programmations des Repas</h2>
      
      <div id="repas-container" class="space-y-4 mb-4">
        <?php if (empty($planRepas)): ?>
          <!-- Ligne vide par défaut -->
          <div class="flex gap-3 items-center repas-row" style="background:var(--muted);padding:1rem;border-radius:var(--radius-xl);border:1px solid var(--border)">
            <div style="flex:1">
              <label class="text-xs font-semibold uppercase mb-1 block" style="color:var(--text-muted)">Repas enregistré</label>
              <select name="repas_ids[]" class="form-input" style="font-size:0.875rem">
                <option value="">-- Choisir un repas --</option>
                <?php foreach ($repas as $r): ?>
                  <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nom']) ?> (<?= $r['calories_total'] ?> kcal - <?= $r['type_repas'] ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
            <div style="width:100px">
              <label class="text-xs font-semibold uppercase mb-1 block" style="color:var(--text-muted)">Jour n°</label>
              <input type="number" name="jours[]" class="form-input" placeholder="Ex: 1" min="1" value="1">
            </div>
            <div style="padding-top:1.5rem">
              <button type="button" class="icon-btn" style="width:2.5rem;height:2.5rem;color:var(--destructive)" onclick="this.closest('.repas-row').remove()"><i data-lucide="trash-2" style="width:1rem;height:1rem"></i></button>
            </div>
          </div>
        <?php else: ?>
          <!-- Lignes pré-remplies existantes -->
          <?php foreach ($planRepas as $pr): ?>
            <div class="flex gap-3 items-center repas-row" style="background:var(--muted);padding:1rem;border-radius:var(--radius-xl);border:1px solid var(--border)">
              <div style="flex:1">
                <label class="text-xs font-semibold uppercase mb-1 block" style="color:var(--text-muted)">Repas enregistré</label>
                <select name="repas_ids[]" class="form-input" style="font-size:0.875rem">
                  <option value="">-- Choisir un repas --</option>
                  <?php foreach ($repas as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= $r['id'] == $pr['id'] ? 'selected' : '' ?>><?= htmlspecialchars($r['nom']) ?> (<?= $r['calories_total'] ?> kcal - <?= $r['type_repas'] ?>)</option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div style="width:100px">
                <label class="text-xs font-semibold uppercase mb-1 block" style="color:var(--text-muted)">Jour n°</label>
                <input type="number" name="jours[]" class="form-input" min="1" value="<?= $pr['jour'] ?>">
              </div>
              <div style="padding-top:1.5rem">
                <button type="button" class="icon-btn" style="width:2.5rem;height:2.5rem;color:var(--destructive)" onclick="this.closest('.repas-row').remove()"><i data-lucide="trash-2" style="width:1rem;height:1rem"></i></button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      
      <button type="button" id="add-repas-btn" class="btn btn-outline-secondary btn-sm mb-8"><i data-lucide="plus"></i> Programmer un autre repas</button>

      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl">
        <i data-lucide="save" style="width:1.25rem;height:1.25rem"></i> Mettre à jour le Plan
      </button>
    </form>
  </div>
</div>

<script>
document.getElementById('add-repas-btn').addEventListener('click', function() {
  const container = document.getElementById('repas-container');
  let templateRow = container.querySelector('.repas-row');
  let newRow;
  
  if (templateRow) {
    newRow = templateRow.cloneNode(true);
    newRow.querySelector('select').value = '';
    let currentJour = parseInt(templateRow.querySelector('input[type="number"]').value) || 1;
    newRow.querySelector('input[type="number"]').value = currentJour;
  } else {
    newRow = document.createElement('div');
    newRow.className = 'flex gap-3 items-center repas-row';
    newRow.style.cssText = 'background:var(--muted);padding:1rem;border-radius:var(--radius-xl);border:1px solid var(--border)';
    newRow.innerHTML = `
      <div style="flex:1">
        <label class="text-xs font-semibold uppercase mb-1 block" style="color:var(--text-muted)">Repas enregistré</label>
        <select name="repas_ids[]" class="form-input" style="font-size:0.875rem">
          <option value="">-- Choisir un repas --</option>
          <?php foreach ($repas as $r): ?><option value="<?= $r['id'] ?>"><?= htmlspecialchars(addslashes($r['nom'])) ?> (<?= $r['calories_total'] ?> kcal)</option><?php endforeach; ?>
        </select>
      </div>
      <div style="width:100px">
        <label class="text-xs font-semibold uppercase mb-1 block" style="color:var(--text-muted)">Jour n°</label>
        <input type="number" name="jours[]" class="form-input" placeholder="Ex: 1" min="1" value="1">
      </div>
      <div style="padding-top:1.5rem">
        <button type="button" class="icon-btn" style="width:2.5rem;height:2.5rem;color:var(--destructive)" onclick="this.closest('.repas-row').remove()"><i data-lucide="trash-2" style="width:1rem;height:1rem"></i></button>
      </div>
    `;
  }
  
  container.appendChild(newRow);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

document.getElementById('planForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('nom').value.trim() === '') errors.push('Le nom du plan est obligatoire.');
  if (document.getElementById('type_objectif').value === '') errors.push('Le type d\'objectif est obligatoire.');
  if (!document.getElementById('objectif_calories').value) errors.push('L\'objectif calorique est obligatoire.');
  if (!document.getElementById('duree_jours').value) errors.push('La durée en jours est obligatoire.');
  if (!document.getElementById('date_debut').value) errors.push('La date de début est obligatoire.');
  
  if (errors.length > 0) {
    e.preventDefault();
    showToast('error', errors[0]);
  });
  }
});
</script>
