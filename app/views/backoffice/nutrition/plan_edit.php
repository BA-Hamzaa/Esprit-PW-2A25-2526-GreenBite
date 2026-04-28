<!-- Vue BackOffice : Modifier un Plan Nutritionnel -->
<div class="flex items-center justify-between mb-8">
  <div class="flex items-center gap-4">
    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plans" class="btn-ghost" style="padding:0.5rem;border-radius:var(--radius-full)"><i data-lucide="arrow-left"></i></a>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier Plan #<?= $plan['id'] ?></h1>
      <p class="text-sm" style="color:var(--text-muted)"><?= htmlspecialchars($plan['nom']) ?></p>
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
        <input type="text" name="nom" id="nom" class="form-input" value="<?= htmlspecialchars($_POST['nom'] ?? $plan['nom']) ?>">
      </div>

      <div class="form-group col-span-2">
        <label class="form-label" for="description">Description</label>
        <textarea name="description" id="description" class="form-textarea"><?= htmlspecialchars($_POST['description'] ?? $plan['description']) ?></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="type_objectif">Type d'objectif</label>
        <select name="type_objectif" id="type_objectif" class="form-input">
          <option value="">-- Choisir --</option>
          <?php $selType = $_POST['type_objectif'] ?? $plan['type_objectif']; ?>
          <option value="perte_poids" <?= ($selType === 'perte_poids') ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien" <?= ($selType === 'maintien') ? 'selected' : '' ?>>Maintien</option>
          <option value="prise_masse" <?= ($selType === 'prise_masse') ? 'selected' : '' ?>>Prise de masse</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label" for="objectif_calories">Objectif Calorique</label>
        <input type="number" name="objectif_calories" id="objectif_calories" class="form-input" value="<?= htmlspecialchars($_POST['objectif_calories'] ?? $plan['objectif_calories']) ?>">
      </div>

      <div class="form-group col-span-2">
        <label class="form-label" for="duree_jours">Durée (Jours)</label>
        <input type="number" name="duree_jours" id="duree_jours" class="form-input" value="<?= htmlspecialchars($_POST['duree_jours'] ?? $plan['duree_jours']) ?>" style="max-width:200px">
      </div>
    </div>

    <h2 class="font-bold text-lg mb-4 mt-8" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem">Programme Journalier</h2>
    
    <div id="days-container" class="space-y-4 mb-6">
      <div style="padding:1.25rem;background:var(--muted);border:1px dashed var(--border);border-radius:var(--radius-xl);text-align:center;color:var(--text-muted);font-size:0.85rem">
        <i data-lucide="calendar" style="width:1.5rem;height:1.5rem;display:block;margin:0 auto 0.5rem;opacity:0.4"></i>
        Génération du programme en cours...
      </div>
    </div>

    <div class="flex justify-end gap-4 mt-6 pt-6" style="border-top:1px solid var(--border)">
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plans" class="btn btn-outline-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
    </div>
  </form>
</div>

<?php
$activites = json_decode($plan['programme_activites'] ?? '[]', true) ?: [];
$repasByDay = [];
if (!empty($planRepas)) {
  foreach ($planRepas as $pr) {
     $repasByDay[$pr['jour']][] = $pr['id'];
  }
}
?>

<script>
// Data from PHP
const existingActivities = <?= json_encode($activites, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const existingRepas = <?= json_encode($repasByDay, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

// Build repas options HTML from PHP
const repasOptions = `<option value="">-- Choisir un repas --</option><?php foreach ($repas as $r): ?><option value="<?= $r['id'] ?>"><?= htmlspecialchars(addslashes($r['nom'])) ?> (<?= $r['calories_total'] ?> kcal)</option><?php endforeach; ?>`;

const activityPlaceholders = [
  'Ex: Marche 30 min, boire 2L d\'eau, éviter le sucre',
  'Ex: Cardio 20 min, stretching 10 min',
  'Ex: Repos actif, promenade légère 15 min',
  'Ex: Musculation 45 min, protéines en priorité',
];

function mealRowHtml(jour, selectedMealId = '') {
  let options = repasOptions;
  if (selectedMealId) {
      const regex = new RegExp('value="' + selectedMealId + '"');
      options = options.replace(regex, 'value="' + selectedMealId + '" selected');
  }
  return `<div class="meal-row flex gap-3 items-center flex-wrap" style="background:var(--muted);padding:1rem;border-radius:var(--radius-xl);margin-bottom:0.5rem">
    <div style="flex:1;min-width:250px">
      <select name="repas_ids[]" class="form-input" onchange="updateActivityRequired(${jour})">
        ${options}
      </select>
    </div>
    <input type="hidden" name="jours[]" value="${jour}">
    <button type="button" class="btn btn-outline-danger btn-round" style="padding:0.75rem" onclick="this.closest('.meal-row').remove();updateActivityRequired(${jour})"><i data-lucide="trash-2"></i></button>
  </div>`;
}

function buildDayCard(jour, duree) {
  const placeholder = activityPlaceholders[(jour - 1) % activityPlaceholders.length];
  const actVal = existingActivities[jour] ? existingActivities[jour].replace(/"/g, '&quot;') : '';
  
  let mealsHtml = '';
  if (existingRepas[jour] && existingRepas[jour].length > 0) {
      existingRepas[jour].forEach(mealId => {
          mealsHtml += mealRowHtml(jour, mealId);
      });
  }

  return `
  <div class="day-card" style="background:var(--card);border:1.5px solid var(--border);border-radius:var(--radius-xl);overflow:hidden;transition:all 0.2s">
    <div style="display:flex;align-items:center;gap:0.75rem;padding:0.875rem 1.25rem;background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:1px solid var(--border)">
      <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border-radius:50%;font-weight:800;font-size:0.85rem;flex-shrink:0;font-family:var(--font-heading)">J${jour}</div>
      <span style="font-weight:700;color:var(--text-primary);font-family:var(--font-heading)">Jour ${jour}</span>
      <span style="margin-left:auto;font-size:0.7rem;color:var(--text-muted)">${jour} / ${duree}</span>
    </div>
    <div style="padding:1.25rem;display:grid;grid-template-columns:1fr;gap:1rem">
      <div>
        <label style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.5rem">
          <i data-lucide="utensils" style="width:0.75rem;height:0.75rem"></i> Repas du jour
        </label>
        <div class="meals-list" id="meals-day-${jour}">
          ${mealsHtml}
        </div>
        <button type="button"
          onclick="addMealToDay(${jour})"
          class="btn btn-outline-secondary btn-sm mt-2">
          <i data-lucide="plus"></i> Ajouter un repas
        </button>
      </div>
      <div>
        <label style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="activity" style="width:0.75rem;height:0.75rem;color:#f59e0b"></i>
          Activité / Instructions du jour
          <span class="act-required-star" style="color:#ef4444;margin-left:2px;display:none">*</span>
          <span class="act-optional-hint" style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);font-weight:400">Optionnel si aucun repas sélectionné</span>
        </label>
        <textarea
          name="activite_jour_${jour}"
          id="activite_jour_${jour}"
          rows="2"
          placeholder="${placeholder}"
          class="form-textarea"
          onblur="validateActivity(this)"
          oninput="clearActivityError(this)"
        >${actVal}</textarea>
        <div class="act-error" style="color:#ef4444;font-size:0.72rem;margin-top:0.2rem;display:none">
          Ce champ est obligatoire (minimum 5 caractères).
        </div>
      </div>
    </div>
  </div>`;
}

function addMealToDay(jour) {
  const list = document.getElementById('meals-day-' + jour);
  if (!list) return;
  const div = document.createElement('div');
  div.innerHTML = mealRowHtml(jour);
  list.appendChild(div.firstElementChild);
  updateActivityRequired(jour);
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

function generateDays(duree) {
  const container = document.getElementById('days-container');
  if (!duree || duree < 1) {
    container.innerHTML = `<div style="padding:1.25rem;background:var(--muted);border:1px dashed var(--border);border-radius:var(--radius-xl);text-align:center;color:var(--text-muted);font-size:0.85rem">
      <i data-lucide="calendar" style="width:1.5rem;height:1.5rem;display:block;margin:0 auto 0.5rem;opacity:0.4"></i>
      Entrez la durée du plan ci-dessus pour générer le programme jour par jour.
    </div>`;
    if (typeof lucide !== 'undefined') lucide.createIcons();
    return;
  }
  
  let html = '';
  for (let j = 1; j <= Math.min(duree, 365); j++) {
    html += buildDayCard(j, Math.min(duree, 365));
  }
  container.innerHTML = html;
  
  for (let j = 1; j <= Math.min(duree, 365); j++) {
      updateActivityRequired(j);
  }

  if (typeof lucide !== 'undefined') lucide.createIcons();
}

function dayHasMeal(jour) {
  const list = document.getElementById('meals-day-' + jour);
  if (!list) return false;
  const selects = list.querySelectorAll('select');
  for (let s of selects) {
    if (s.value && s.value !== '') return true;
  }
  return false;
}

function updateActivityRequired(jour) {
  const hasMeal = dayHasMeal(jour);
  const card = document.getElementById('activite_jour_' + jour);
  if (!card) return;
  const label = card.closest('div');
  const star = label ? label.querySelector('.act-required-star') : null;
  const hint = label ? label.querySelector('.act-optional-hint') : null;
  if (star) star.style.display = hasMeal ? 'inline' : 'none';
  if (hint) hint.style.display = hasMeal ? 'none' : 'inline';
  if (!hasMeal) {
    card.style.borderColor = 'var(--border)';
    const errEl = card.nextElementSibling;
    if (errEl) errEl.style.display = 'none';
  }
}

function validateActivity(el) {
  const errEl = el.nextElementSibling;
  const jour = el.id.split('_').pop();
  if (dayHasMeal(jour) && el.value.trim().length < 5) {
    el.style.borderColor = '#ef4444';
    if (errEl) errEl.style.display = 'block';
    return false;
  }
  el.style.borderColor = 'var(--border)';
  if (errEl) errEl.style.display = 'none';
  return true;
}

function clearActivityError(el) {
  const errEl = el.nextElementSibling;
  el.style.borderColor = 'var(--border)';
  if (errEl) errEl.style.display = 'none';
}

document.getElementById('duree_jours').addEventListener('input', function(e) {
  generateDays(parseInt(e.target.value));
});

window.addEventListener('DOMContentLoaded', () => {
  const duree = parseInt(document.getElementById('duree_jours').value);
  if (duree > 0) {
    generateDays(duree);
  }
});

document.getElementById('adminPlanForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('nom').value.trim() === '') errors.push('Le nom du plan est obligatoire.');
  if (document.getElementById('type_objectif').value === '') errors.push('Le type d\'objectif est obligatoire.');
  if (!document.getElementById('objectif_calories').value) errors.push('L\'objectif calorique est obligatoire.');
  
  const dureeVal = document.getElementById('duree_jours').value;
  const duree = parseInt(dureeVal);
  if (!dureeVal || duree <= 0) {
      errors.push('La durée en jours doit être supérieure à 0.');
  } else {
      for (let j = 1; j <= duree; j++) {
          const actEl = document.getElementById('activite_jour_' + j);
          if (actEl && !validateActivity(actEl)) {
              errors.push('Veuillez remplir l\'activité pour le Jour ' + j + ' (minimum 5 caractères).');
              break;
          }
      }
  }
  
  if (errors.length > 0) {
    e.preventDefault();
    alert(errors[0]);
  }
});
</script>
