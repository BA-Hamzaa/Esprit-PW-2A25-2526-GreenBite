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
  <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
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
        <div id="err_nom" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
      </div>

      <div class="form-group col-span-2">
        <label class="form-label" for="description">Description (Visible par les utilisateurs)</label>
        <textarea name="description" id="description" class="form-textarea"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        <div id="err_description" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
      </div>

      <div class="form-group">
        <label class="form-label" for="type_objectif">Type d'objectif</label>
        <select name="type_objectif" id="type_objectif" class="form-input">
          <option value="">-- Choisir --</option>
          <option value="perte_poids" <?= (($_POST['type_objectif'] ?? '') === 'perte_poids') ? 'selected' : '' ?>>Perte de poids</option>
          <option value="maintien" <?= (($_POST['type_objectif'] ?? '') === 'maintien') ? 'selected' : '' ?>>Maintien</option>
          <option value="prise_masse" <?= (($_POST['type_objectif'] ?? '') === 'prise_masse') ? 'selected' : '' ?>>Prise de masse</option>
        </select>
        <div id="err_type_objectif" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
      </div>

      <div class="form-group">
        <label class="form-label" for="objectif_calories">Objectif Calorique Journalier</label>
        <input type="number" name="objectif_calories" id="objectif_calories" class="form-input" value="<?= htmlspecialchars($_POST['objectif_calories'] ?? '2000') ?>">
        <div id="err_objectif_calories" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
      </div>

      <div class="form-group col-span-2">
        <label class="form-label" for="duree_jours">Durée (Jours)</label>
        <input type="number" name="duree_jours" id="duree_jours" class="form-input" value="<?= htmlspecialchars($_POST['duree_jours'] ?? '7') ?>" min="1" max="365" style="max-width:200px">
        <div id="err_duree_jours" style="color:var(--destructive);font-size:0.75rem;margin-top:0.25rem;display:none;"></div>
        <p class="text-xs mt-1" style="color:var(--text-muted)"><i data-lucide="info" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle"></i> Entrez la durée pour générer automatiquement le programme journalier ci-dessous.</p>
      </div>
      <div class="form-group col-span-2">
        <label class="form-label" for="regime_id">Régime associé (optionnel)</label>
        <select name="regime_id" id="regime_id" class="form-input">
          <option value="">-- Aucun régime --</option>
          <?php foreach (($regimes ?? []) as $rg): ?>
            <option value="<?= (int)$rg['id'] ?>" <?= (string)($rg['id']) === (string)($_POST['regime_id'] ?? '') ? 'selected' : '' ?>>
              <?= htmlspecialchars($rg['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <!-- ===== Section Programme Journalier (dynamique) ===== -->
    <h2 class="font-bold text-lg mb-2 mt-8" style="color:var(--text-primary);border-bottom:2px solid var(--border);padding-bottom:0.5rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="calendar-days" style="width:1rem;height:1rem;color:var(--secondary)"></i> Programme Journalier
      <span id="duree-badge" style="display:none;margin-left:auto;font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:var(--primary);border-radius:var(--radius-full);border:1px solid rgba(45,106,79,0.15)"></span>
    </h2>
    <p class="text-sm mb-4" style="color:var(--text-muted)">Pour chaque jour, choisissez un repas si nécessaire. Si un repas est sélectionné, l'activité du jour devient obligatoire.</p>

    <div id="days-container" class="space-y-4 mb-6">
      <div style="padding:1.25rem;background:var(--muted);border:1px dashed var(--border);border-radius:var(--radius-xl);text-align:center;color:var(--text-muted);font-size:0.85rem">
        <i data-lucide="calendar" style="width:1.5rem;height:1.5rem;display:block;margin:0 auto 0.5rem;opacity:0.4"></i>
        Entrez la durée du plan ci-dessus pour générer le programme jour par jour.
      </div>
    </div>

    <div class="flex justify-end gap-4 mt-6 pt-6" style="border-top:1px solid var(--border)">
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plans" class="btn btn-outline-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary">Créer le Plan Nutritionnel</button>
    </div>
  </form>
</div>

<script>
// Build repas options HTML from PHP
const repasOptions = `<option value="">-- Choisir un repas --</option><?php foreach ($repas as $r): ?><option value="<?= $r['id'] ?>"><?= htmlspecialchars(addslashes($r['nom'])) ?> (<?= $r['calories_total'] ?> kcal – <?= $r['type_repas'] ?>)</option><?php endforeach; ?>`;

const activityPlaceholders = [
  'Ex: Marche 30 min, boire 2L d\'eau, éviter le sucre',
  'Ex: Cardio 20 min, stretching 10 min',
  'Ex: Repos actif, promenade légère 15 min',
  'Ex: Musculation 45 min, protéines en priorité',
  'Ex: Yoga 30 min, méditation 10 min',
  'Ex: Vélo 40 min ou natation 30 min',
  'Ex: Journée libre — respecter les repas du plan',
];

function mealRowHtml(jour) {
  return `<div class="meal-row" style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.4rem">
    <select name="repas_ids[]" class="form-input" style="font-size:0.82rem;flex:1" onchange="updateActivityRequired(${jour})">
      ${repasOptions}
    </select>
    <input type="hidden" name="jours[]" value="${jour}">
    <button type="button" onclick="this.closest('.meal-row').remove();updateActivityRequired(${jour})" title="Supprimer" style="flex-shrink:0;display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:0.5rem;color:#ef4444;cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='rgba(239,68,68,0.16)'" onmouseout="this.style.background='rgba(239,68,68,0.08)'">
      <i data-lucide="x" style="width:0.8rem;height:0.8rem"></i>
    </button>
  </div>`;
}

function buildDayCard(jour, duree) {
  const placeholder = activityPlaceholders[(jour - 1) % activityPlaceholders.length];
  return `
  <div class="day-card" style="background:var(--card);border:1.5px solid var(--border);border-radius:var(--radius-xl);overflow:hidden;transition:all 0.2s">
    <!-- Day header -->
    <div style="display:flex;align-items:center;gap:0.75rem;padding:0.875rem 1.25rem;background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:1px solid var(--border)">
      <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border-radius:50%;font-weight:800;font-size:0.85rem;flex-shrink:0;font-family:var(--font-heading)">J${jour}</div>
      <span style="font-weight:700;color:var(--text-primary);font-family:var(--font-heading)">Jour ${jour}</span>
      <span style="margin-left:auto;font-size:0.7rem;color:var(--text-muted)">${jour} / ${duree}</span>
    </div>

    <!-- Day body -->
    <div style="padding:1.25rem;display:grid;grid-template-columns:1fr;gap:1rem">

      <!-- Repas (multiple) -->
      <div>
        <label style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.5rem">
          <i data-lucide="utensils" style="width:0.75rem;height:0.75rem"></i> Repas du jour
          <span style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);font-weight:500">Ajoutez autant de repas que nécessaire</span>
        </label>
        <div class="meals-list" id="meals-day-${jour}">
        </div>
        <button type="button"
          onclick="addMealToDay(${jour})"
          style="margin-top:0.4rem;display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;background:rgba(82,183,136,0.08);border:1px dashed rgba(82,183,136,0.35);border-radius:0.5rem;color:var(--secondary);font-size:0.75rem;font-weight:600;cursor:pointer;transition:all 0.2s"
          onmouseover="this.style.background='rgba(82,183,136,0.15)'"
          onmouseout="this.style.background='rgba(82,183,136,0.08)'">
          <i data-lucide="plus" style="width:0.75rem;height:0.75rem"></i> Ajouter un repas
        </button>
      </div>

      <!-- Activity -->
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
        ></textarea>
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
  let html = '';
  for (let j = 1; j <= Math.min(duree, 365); j++) {
    html += buildDayCard(j, Math.min(duree, 365));
  }
  container.innerHTML = html;
  badge.textContent = duree + ' jour' + (duree > 1 ? 's' : '');
  badge.style.display = 'inline-flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

// Check if a day has at least one meal selected
function dayHasMeal(jour) {
  const list = document.getElementById('meals-day-' + jour);
  if (!list) return false;
  const selects = list.querySelectorAll('select');
  for (let s of selects) {
    if (s.value && s.value !== '') return true;
  }
  return false;
}

// Update activity field required state based on meal selection
function updateActivityRequired(jour) {
  const hasMeal = dayHasMeal(jour);
  const card = document.getElementById('activite_jour_' + jour);
  if (!card) return;
  const label = card.closest('div');
  const star = label ? label.querySelector('.act-required-star') : null;
  const hint = label ? label.querySelector('.act-optional-hint') : null;
  if (star) star.style.display = hasMeal ? 'inline' : 'none';
  if (hint) hint.style.display = hasMeal ? 'none' : 'inline';
  // Clear error if no meal
  if (!hasMeal) {
    card.style.borderColor = 'var(--border)';
    card.style.boxShadow = 'none';
    const errEl = card.nextElementSibling;
    if (errEl) errEl.style.display = 'none';
  }
}

function validateActivity(el) {
  const errEl = el.nextElementSibling;
  // Extract jour from field name: activite_jour_N
  const match = el.name.match(/(\d+)$/);
  if (!match) return true;
  const jour = parseInt(match[1]);
  // Only required if a meal is selected
  if (!dayHasMeal(jour)) {
    el.style.borderColor = 'var(--border)';
    el.style.boxShadow = 'none';
    if (errEl) errEl.style.display = 'none';
    return true;
  }
  if (el.value.trim().length < 5) {
    el.style.borderColor = '#ef4444';
    el.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.10)';
    if (errEl) { errEl.style.display = 'block'; if (typeof lucide !== 'undefined') lucide.createIcons(); }
    return false;
  }
  el.style.borderColor = 'var(--secondary)';
  el.style.boxShadow = '0 0 0 3px rgba(82,183,136,0.12)';
  if (errEl) errEl.style.display = 'none';
  return true;
}

function clearActivityError(el) {
  const errEl = el.nextElementSibling;
  const match = el.name ? el.name.match(/(\d+)$/) : null;
  const jour = match ? parseInt(match[1]) : null;
  if (jour && !dayHasMeal(jour)) {
    el.style.borderColor = 'var(--border)';
    el.style.boxShadow = 'none';
    if (errEl) errEl.style.display = 'none';
    return;
  }
  if (el.value.trim().length >= 5) {
    el.style.borderColor = 'var(--secondary)';
    el.style.boxShadow = '0 0 0 3px rgba(82,183,136,0.12)';
    if (errEl) errEl.style.display = 'none';
  }
}

// Trigger day generation on duration change
let debounceTimer;
document.getElementById('duree_jours').addEventListener('input', function() {
  clearTimeout(debounceTimer);
  const val = parseInt(this.value) || 0;
  debounceTimer = setTimeout(() => generateDays(val), 350);
});

// Generate initial days (important for backoffice view if setting default duration)
window.addEventListener('DOMContentLoaded', function() {
  const dureeInit = parseInt(document.getElementById('duree_jours').value) || 0;
  if (dureeInit > 0) {
    generateDays(dureeInit);
  }
  
  // Restore activity values if POST had errors
  <?php if (!empty($_POST['duree_jours'])): ?>
  <?php
    $dureePost = (int)($_POST['duree_jours'] ?? 0);
    for ($j = 1; $j <= $dureePost; $j++):
      $val = addslashes(htmlspecialchars($_POST['activite_jour_' . $j] ?? ''));
  ?>
    (function() {
      var el = document.getElementById('activite_jour_<?= $j ?>');
      if (el) el.value = '<?= $val ?>';
    })();
  <?php endfor; ?>
  <?php endif; ?>
});

// Real-time text validation
function checkLengthRealTime(inputEl, errorId, errorMsg) {
  const val = inputEl.value.trim();
  const errEl = document.getElementById(errorId);
  if (val.length > 0 && val.length < 3) {
    errEl.innerText = errorMsg;
    errEl.style.display = 'block';
  } else {
    errEl.style.display = 'none';
  }
}

document.getElementById('nom').addEventListener('input', function() {
  checkLengthRealTime(this, 'err_nom', 'Le nom doit faire au moins 3 caractères.');
});
document.getElementById('description').addEventListener('input', function() {
  checkLengthRealTime(this, 'err_description', 'La description doit faire au moins 3 caractères.');
});

function forcePositiveNumber(el) {
  el.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
}
forcePositiveNumber(document.getElementById('objectif_calories'));
forcePositiveNumber(document.getElementById('duree_jours'));

// Form submit validation
document.getElementById('adminPlanForm').addEventListener('submit', function(e) {
  let hasError = false;

  function showError(id, message) {
    const el = document.getElementById(id);
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
  if (!nom) showError('err_nom', 'Le nom du programme est obligatoire.');
  else if (nom.length < 3) showError('err_nom', 'Le nom doit faire au moins 3 caractères.');

  const description = document.getElementById('description').value.trim();
  if (!description) showError('err_description', 'Veuillez décrire votre objectif.');
  else if (description.length < 3) showError('err_description', 'La description doit faire au moins 3 caractères.');

  if (!document.getElementById('type_objectif').value) showError('err_type_objectif', 'Veuillez choisir un type d\'objectif.');

  const calories = document.getElementById('objectif_calories').value;
  if (!calories || parseInt(calories) <= 0) showError('err_objectif_calories', 'L\'objectif calorique doit être un nombre positif.');

  const duree = parseInt(document.getElementById('duree_jours').value) || 0;
  if (duree <= 0) { showError('err_duree_jours', 'La durée doit être d\'au moins 1 jour.'); }

  // Validate activity textareas — only required if that day has a meal selected
  document.querySelectorAll('textarea[name^="activite_jour_"]').forEach(function(ta) {
    if (!validateActivity(ta)) hasError = true;
  });

  if (hasError) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
});
</script>
