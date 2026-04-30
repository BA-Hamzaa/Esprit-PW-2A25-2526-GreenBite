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
        <div id="err_nom" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
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
          <div id="err_type_objectif" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
        </div>
        <div class="form-group">
          <label class="form-label" for="objectif_calories"><i data-lucide="flame" style="width:0.875rem;height:0.875rem"></i> Calories visées (par jour)</label>
          <input type="number" name="objectif_calories" id="objectif_calories" class="form-input" placeholder="Ex: 2000" value="<?= htmlspecialchars($_POST['objectif_calories'] ?? $plan['objectif_calories']) ?>">
          <div id="err_objectif_calories" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
        </div>
      </div>
      <div class="form-group mb-4">
        <?php $selRegimeId = $_POST['regime_id'] ?? ($plan['regime_id'] ?? ''); ?>
        <label class="form-label" for="regime_id"><i data-lucide="link" style="width:0.875rem;height:0.875rem"></i> Régime associé (optionnel)</label>
        <select name="regime_id" id="regime_id" class="form-input">
          <option value="">-- Aucun régime --</option>
          <?php foreach (($regimes ?? []) as $rg): ?>
            <option value="<?= (int)$rg['id'] ?>" <?= (string)($rg['id']) === (string)$selRegimeId ? 'selected' : '' ?>>
              <?= htmlspecialchars($rg['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group mb-6">
        <label class="form-label" for="duree_jours"><i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i> Durée (en jours)</label>
        <input type="number" name="duree_jours" id="duree_jours" class="form-input" value="<?= htmlspecialchars($_POST['duree_jours'] ?? $plan['duree_jours']) ?>" style="max-width:200px">
        <div id="err_duree_jours" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
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

      <div class="form-group mb-6">
        <label class="form-label" for="description"><i data-lucide="align-left" style="width:0.875rem;height:0.875rem"></i> Description</label>
        <textarea name="description" id="description" class="form-textarea" placeholder="Décrivez votre objectif..."><?= htmlspecialchars($_POST['description'] ?? $plan['description']) ?></textarea>
        <div id="err_description" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
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

const sportOptions = [
  { value: '', label: '-- Choisir une activité --' },
  { value: 'marche', label: 'Marche' },
  { value: 'course', label: 'Course à pied' },
  { value: 'velo', label: 'Vélo' },
  { value: 'musculation', label: 'Musculation' },
  { value: 'natation', label: 'Natation' },
  { value: 'yoga', label: 'Yoga / Mobilité' },
  { value: 'autre', label: 'Autre' }
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

function sportRowHtml(jour, selected = '', details = '') {
  const opts = sportOptions.map(opt =>
    `<option value="${opt.value}" ${selected === opt.value ? 'selected' : ''}>${opt.label}</option>`
  ).join('');
  const escapedDetails = String(details || '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');

  return `<div class="sport-row" style="display:grid;grid-template-columns:170px 1fr auto;gap:0.5rem;margin-bottom:0.45rem;align-items:center">
    <select class="form-input sport-type" style="font-size:0.8rem" onchange="syncActivityField(${jour});validateSportsDay(${jour})">
      ${opts}
    </select>
    <input type="text" class="form-input sport-details" value="${escapedDetails}" placeholder="Ex: 30 min + intensité modérée + étirements 10 min" style="font-size:0.8rem" oninput="syncActivityField(${jour});validateSportsDay(${jour})" />
    <button type="button" onclick="this.closest('.sport-row').remove();syncActivityField(${jour});validateSportsDay(${jour})" title="Supprimer" style="flex-shrink:0;display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:0.5rem;color:#ef4444;cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='rgba(239,68,68,0.16)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
      <i data-lucide="x" style="width:0.8rem;height:0.8rem"></i>
    </button>
  </div>`;
}

function buildDayCard(jour, duree) {
  const placeholder = activityPlaceholders[(jour - 1) % activityPlaceholders.length];
  
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
          Activités sportives du jour
          <span class="act-required-star" style="color:#ef4444;margin-left:2px;display:none">*</span>
          <span class="act-optional-hint" style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);font-weight:400">Optionnel si aucun repas sélectionné</span>
        </label>
        <div id="sports-day-${jour}"></div>
        <button type="button"
          onclick="addSportToDay(${jour})"
          style="margin-top:0.35rem;display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;background:rgba(245,158,11,0.08);border:1px dashed rgba(245,158,11,0.4);border-radius:0.5rem;color:#b45309;font-size:0.75rem;font-weight:600;cursor:pointer;transition:all 0.2s"
          onmouseover="this.style.background='rgba(245,158,11,0.16)'"
          onmouseout="this.style.background='rgba(245,158,11,0.08)'">
          <i data-lucide="plus" style="width:0.75rem;height:0.75rem"></i> Ajouter une activité sportive
        </button>
        <textarea name="activite_jour_${jour}" id="activite_jour_${jour}" style="display:none"></textarea>
        <div style="margin-top:0.25rem;font-size:0.7rem;color:var(--text-muted)">${placeholder}</div>
        <div class="act-error" style="color:#ef4444;font-size:0.72rem;margin-top:0.2rem;display:none">
          <i data-lucide="alert-circle" style="width:0.65rem;height:0.65rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i>
          Ajoutez au moins une activité valide (type + détails min. 5 caractères).
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

function addSportToDay(jour, selected = '', details = '') {
  const list = document.getElementById('sports-day-' + jour);
  if (!list) return;
  const div = document.createElement('div');
  div.innerHTML = sportRowHtml(jour, selected, details);
  list.appendChild(div.firstElementChild);
  syncActivityField(jour);
  validateSportsDay(jour);
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
      hydrateSportsFromText(j, existingActivities[j] || existingActivities[String(j)] || '');
      syncActivityField(j);
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

function dayHasValidSport(jour) {
  const list = document.getElementById('sports-day-' + jour);
  if (!list) return false;
  const rows = list.querySelectorAll('.sport-row');
  for (let row of rows) {
    const type = row.querySelector('.sport-type');
    const details = row.querySelector('.sport-details');
    if (type && details && type.value && details.value.trim().length >= 5) return true;
  }
  return false;
}

function syncActivityField(jour) {
  const hidden = document.getElementById('activite_jour_' + jour);
  const list = document.getElementById('sports-day-' + jour);
  if (!hidden || !list) return;
  const rows = list.querySelectorAll('.sport-row');
  const lines = [];
  rows.forEach(row => {
    const typeSel = row.querySelector('.sport-type');
    const detailInput = row.querySelector('.sport-details');
    const typeLabel = typeSel && typeSel.value ? (typeSel.options[typeSel.selectedIndex]?.text || typeSel.value) : '';
    const detail = detailInput ? detailInput.value.trim() : '';
    if (typeLabel || detail) lines.push([typeLabel, detail].filter(Boolean).join(': '));
  });
  hidden.value = lines.join(' | ');
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
  validateSportsDay(jour);
}

function validateSportsDay(jour) {
  const wrapper = document.getElementById('sports-day-' + jour);
  if (!wrapper) return true;
  const parent = wrapper.parentElement;
  const errEl = parent ? parent.querySelector('.act-error') : null;
  if (!dayHasMeal(jour)) {
    if (errEl) errEl.style.display = 'none';
    return true;
  }
  const ok = dayHasValidSport(jour);
  if (errEl) errEl.style.display = ok ? 'none' : 'block';
  if (!ok && typeof lucide !== 'undefined') lucide.createIcons();
  return ok;
}

function hydrateSportsFromText(jour, text) {
  if (!text || !String(text).trim()) return;
  const chunks = String(text).split('|').map(s => s.trim()).filter(Boolean);
  if (!chunks.length) {
    addSportToDay(jour, 'autre', String(text).trim());
    return;
  }
  chunks.forEach(chunk => {
    const sepIdx = chunk.indexOf(':');
    let typeCandidate = '';
    let details = chunk;
    if (sepIdx !== -1) {
      typeCandidate = chunk.slice(0, sepIdx).trim().toLowerCase();
      details = chunk.slice(sepIdx + 1).trim();
    }
    const matched = sportOptions.find(opt => opt.value && opt.label.toLowerCase() === typeCandidate);
    addSportToDay(jour, matched ? matched.value : 'autre', details);
  });
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

function checkLengthRealTime(inputEl, errorId, errorMsg) {
  const val = inputEl.value.trim();
  const errEl = document.getElementById(errorId);
  if (!errEl) return;
  if (val.length > 0 && val.length < 3) {
    errEl.innerText = errorMsg;
    errEl.style.display = 'block';
  } else {
    errEl.style.display = 'none';
  }
}

function toggleFieldError(errorId, message, shouldShow) {
  const err = document.getElementById(errorId);
  if (!err) return;
  if (shouldShow) {
    err.innerText = message;
    err.style.display = 'block';
  } else {
    err.style.display = 'none';
  }
}

function validateTypeObjectifRealtime() {
  const val = document.getElementById('type_objectif').value;
  toggleFieldError('err_type_objectif', 'Veuillez choisir un type d\'objectif.', !val);
}

function validateCaloriesRealtime() {
  const raw = document.getElementById('objectif_calories').value.trim();
  const n = parseInt(raw, 10);
  toggleFieldError('err_objectif_calories', 'L\'objectif calorique doit être un nombre positif.', !raw || Number.isNaN(n) || n <= 0);
}

function validateDureeRealtime() {
  const raw = document.getElementById('duree_jours').value.trim();
  const n = parseInt(raw, 10);
  toggleFieldError('err_duree_jours', 'La durée doit être d\'au moins 1 jour.', !raw || Number.isNaN(n) || n <= 0);
}

function forcePositiveNumber(el) {
  if (!el) return;
  el.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
}

document.getElementById('nom').addEventListener('input', function() {
  checkLengthRealTime(this, 'err_nom', 'Le nom doit faire au moins 3 caractères.');
});
document.getElementById('description').addEventListener('input', function() {
  checkLengthRealTime(this, 'err_description', 'La description doit faire au moins 3 caractères.');
});
document.getElementById('type_objectif').addEventListener('change', validateTypeObjectifRealtime);
document.getElementById('type_objectif').addEventListener('input', validateTypeObjectifRealtime);
document.getElementById('objectif_calories').addEventListener('input', validateCaloriesRealtime);
document.getElementById('objectif_calories').addEventListener('blur', validateCaloriesRealtime);
document.getElementById('duree_jours').addEventListener('input', validateDureeRealtime);
document.getElementById('duree_jours').addEventListener('blur', validateDureeRealtime);
forcePositiveNumber(document.getElementById('objectif_calories'));
forcePositiveNumber(document.getElementById('duree_jours'));

document.getElementById('planForm').addEventListener('submit', function(e) {
  let hasError = false;
  function showError(id, message) {
    const el = document.getElementById(id);
    if (!el) return;
    el.innerText = message;
    el.style.display = 'block';
    hasError = true;
  }
  function hideError(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
  }

  hideError('err_nom');
  hideError('err_description');
  hideError('err_type_objectif');
  hideError('err_objectif_calories');
  hideError('err_duree_jours');

  const nom = document.getElementById('nom').value.trim();
  if (!nom) showError('err_nom', 'Le nom du plan est obligatoire.');
  else if (nom.length < 3) showError('err_nom', 'Le nom doit faire au moins 3 caractères.');

  const description = document.getElementById('description').value.trim();
  if (!description) showError('err_description', 'Veuillez décrire votre objectif.');
  else if (description.length < 3) showError('err_description', 'La description doit faire au moins 3 caractères.');

  if (!document.getElementById('type_objectif').value) showError('err_type_objectif', 'Veuillez choisir un type d\'objectif.');

  const calories = document.getElementById('objectif_calories').value;
  if (!calories || parseInt(calories, 10) <= 0) showError('err_objectif_calories', 'L\'objectif calorique doit être un nombre positif.');

  const duree = parseInt(document.getElementById('duree_jours').value, 10) || 0;
  if (duree <= 0) showError('err_duree_jours', 'La durée doit être d\'au moins 1 jour.');

  for (let j = 1; j <= Math.max(0, duree); j++) {
    syncActivityField(j);
    if (!validateSportsDay(j)) hasError = true;
  }

  if (hasError) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
});
</script>
