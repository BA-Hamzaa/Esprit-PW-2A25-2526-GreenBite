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

      <div class="form-group mb-6">
        <label class="form-label" for="duree_jours"><i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i> Durée (en jours)</label>
        <input type="number" name="duree_jours" id="duree_jours" class="form-input" value="<?= htmlspecialchars($_POST['duree_jours'] ?? $plan['duree_jours']) ?>" style="max-width:200px">
      </div>

      <!-- ===== Section Programme Journalier (dynamique) ===== -->
      <h2 class="font-bold text-lg mb-2 mt-8" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem;display:flex;align-items:center;gap:0.5rem">
        <i data-lucide="calendar-days" style="width:1rem;height:1rem;color:var(--secondary)"></i> Programme Journalier
        <span id="duree-badge" style="margin-left:auto;font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:var(--primary);border-radius:var(--radius-full);border:1px solid rgba(45,106,79,0.15)"><?= htmlspecialchars($_POST['duree_jours'] ?? $plan['duree_jours']) ?> jour(s)</span>
      </h2>
      <p class="text-sm mb-4" style="color:var(--text-muted)">Pour chaque jour, choisissez un repas si nécessaire. Si un repas est sélectionné, l'activité du jour devient obligatoire.</p>

      <div id="days-container" class="space-y-4 mb-6">
        <div style="padding:1.25rem;background:var(--muted);border:1px dashed var(--border);border-radius:var(--radius-xl);text-align:center;color:var(--text-muted);font-size:0.85rem">
          <i data-lucide="calendar" style="width:1.5rem;height:1.5rem;display:block;margin:0 auto 0.5rem;opacity:0.4"></i>
          Génération du programme en cours...
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl">
        <i data-lucide="save" style="width:1.25rem;height:1.25rem"></i> Mettre à jour le Plan
      </button>
    </form>
  </div>
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
const repasOptions = `<option value="">-- Choisir un repas --</option><?php foreach ($repas as $r): ?><option value="<?= $r['id'] ?>"><?= htmlspecialchars(addslashes($r['nom'])) ?> (<?= $r['calories_total'] ?> kcal - <?= $r['type_repas'] ?>)</option><?php endforeach; ?>`;

const activityPlaceholders = [
  'Ex: Marche 30 min, boire 2L d\'eau, éviter le sucre',
  'Ex: Cardio 20 min, stretching 10 min',
  'Ex: Repos actif, promenade légère 15 min',
  'Ex: Musculation 45 min, protéines en priorité',
  'Ex: Yoga 30 min, méditation 10 min',
  'Ex: Vélo 40 min ou natation 30 min',
  'Ex: Journée libre — respecter les repas du plan',
];

function mealRowHtml(jour, selectedMealId = '') {
  let options = repasOptions;
  if (selectedMealId) {
      // Find the specific option and add 'selected'
      const regex = new RegExp('value="' + selectedMealId + '"');
      options = options.replace(regex, 'value="' + selectedMealId + '" selected');
  }
  return `<div class="meal-row" style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.4rem">
    <select name="repas_ids[]" class="form-input" style="font-size:0.82rem;flex:1" onchange="updateActivityRequired(${jour})">
      ${options}
    </select>
    <input type="hidden" name="jours[]" value="${jour}">
    <button type="button" onclick="this.closest('.meal-row').remove();updateActivityRequired(${jour})" title="Supprimer" style="flex-shrink:0;display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:0.5rem;color:#ef4444;cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='rgba(239,68,68,0.16)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
      <i data-lucide="x" style="width:0.8rem;height:0.8rem"></i>
    </button>
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
          <span style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);font-weight:500">Ajoutez autant de repas que nécessaire</span>
        </label>
        <div class="meals-list" id="meals-day-${jour}">
          ${mealsHtml}
        </div>
        <button type="button"
          onclick="addMealToDay(${jour})"
          style="margin-top:0.4rem;display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;background:rgba(82,183,136,0.08);border:1px dashed rgba(82,183,136,0.35);border-radius:0.5rem;color:var(--secondary);font-size:0.75rem;font-weight:600;cursor:pointer;transition:all 0.2s"
          onmouseover="this.style.background='rgba(82,183,136,0.15)'"
          onmouseout="this.style.background='rgba(82,183,136,0.08)'">
          <i data-lucide="plus" style="width:0.75rem;height:0.75rem"></i> Ajouter un repas
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
          style="width:100%;padding:0.65rem 0.875rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.82rem;background:var(--surface);color:var(--foreground);resize:vertical;outline:none;transition:all 0.3s;font-family:inherit"
          onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
          onblur="validateActivity(this)"
          oninput="clearActivityError(this)"
        >${actVal}</textarea>
        <div class="act-error" style="color:#ef4444;font-size:0.72rem;margin-top:0.2rem;display:none">
          <i data-lucide="alert-circle" style="width:0.65rem;height:0.65rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i>
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
  const badge = document.getElementById('duree-badge');
  if (!duree || duree < 1) {
    container.innerHTML = `<div style="padding:1.25rem;background:var(--muted);border:1px dashed var(--border);border-radius:var(--radius-xl);text-align:center;color:var(--text-muted);font-size:0.85rem">
      <i data-lucide="calendar" style="width:1.5rem;height:1.5rem;display:block;margin:0 auto 0.5rem;opacity:0.4"></i>
      Entrez la durée du plan ci-dessus pour générer le programme jour par jour.
    </div>`;
    badge.style.display = 'none';
    if (typeof lucide !== 'undefined') lucide.createIcons();
    return;
  }
  
  // We should preserve existing values when generating days
  // Normally existing values are drawn from existingActivities/existingRepas initially
  // If the user changes duree, we should ideally keep the UI state, but for simplicity we re-render
  // This is acceptable as editing duree is rare and usually means re-planning.
  
  let html = '';
  for (let j = 1; j <= Math.min(duree, 365); j++) {
    html += buildDayCard(j, Math.min(duree, 365));
  }
  container.innerHTML = html;
  badge.textContent = duree + ' jour' + (duree > 1 ? 's' : '');
  badge.style.display = 'inline-flex';
  
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
    card.style.boxShadow = 'none';
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
  el.style.borderColor = 'var(--secondary)';
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

document.getElementById('planForm').addEventListener('submit', function(e) {
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
    if(typeof showToast !== 'undefined') {
      showToast('error', errors[0]);
    } else {
      alert(errors[0]);
    }
  }
});
</script>
