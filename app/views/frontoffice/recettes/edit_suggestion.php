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

      <!-- Instructions (hidden legacy) -->
      <input type="hidden" name="instructions" value="<?= htmlspecialchars($recette['instructions'] ?? '') ?>">

      <!-- ═══ ÉTAPES DE PRÉPARATION ═══ -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <div class="flex items-center justify-between mb-4">
          <label class="form-label mb-0"><i data-lucide="list-ordered" style="width:0.875rem;height:0.875rem"></i> Étapes de préparation <span style="color:var(--destructive)">*</span></label>
          <button type="button" id="btn-add-step" class="btn btn-outline-primary btn-sm" style="border-radius:var(--radius-xl)"><i data-lucide="plus" style="width:.875rem;height:.875rem"></i> Ajouter une étape</button>
        </div>
        <div id="steps-list" class="space-y-3"></div>
        <div id="step-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(4px);align-items:center;justify-content:center">
          <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:1.75rem;width:95%;max-width:520px;box-shadow:0 25px 60px rgba(0,0,0,.25);border:1px solid var(--border)">
            <div class="flex items-center gap-3 mb-5">
              <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#dbeafe,#eff6ff);display:flex;align-items:center;justify-content:center"><i data-lucide="list-ordered" style="width:1.25rem;height:1.25rem;color:#2563eb"></i></div>
              <h3 id="step-modal-title" class="text-lg font-bold" style="color:var(--text-primary)">Ajouter une étape</h3>
            </div>
            <input type="hidden" id="step-edit-index" value="-1">
            <div class="form-group"><label class="form-label">Titre <span style="color:var(--destructive)">*</span></label><input type="text" id="step-titre" class="form-input" placeholder="Ex: Préparer les légumes"></div>
            <div class="form-group"><label class="form-label">Description <span style="color:var(--destructive)">*</span></label><textarea id="step-desc" class="form-textarea" rows="3" placeholder="Détails..."></textarea></div>
            <div class="flex gap-3 mt-4">
              <button type="button" id="step-save" class="btn btn-primary flex-1" style="border-radius:var(--radius-xl)"><i data-lucide="check" style="width:.875rem;height:.875rem"></i> Enregistrer</button>
              <button type="button" id="step-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
            </div>
          </div>
        </div>
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
                        onclick="this.closest('.ingredient-row').remove(); if(typeof updateScoreCarbone==='function') updateScoreCarbone();">
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
                      onclick="this.closest('.ingredient-row').remove(); if(typeof updateScoreCarbone==='function') updateScoreCarbone();">
                <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i>
              </button>
            </div>
          <?php endif; ?>
        </div>
        <button type="button" id="add-ingredient-btn" class="btn btn-outline-primary btn-sm mt-3">
          <i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un ingrédient
        </button>
      <!-- ═══ MATÉRIELS NÉCESSAIRES ═══ -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <div class="flex items-center justify-between mb-4">
          <label class="form-label mb-0"><i data-lucide="wrench" style="width:0.875rem;height:0.875rem"></i> Matériels nécessaires</label>
          <button type="button" id="btn-propose-materiel" class="btn btn-outline-primary btn-sm" style="border-radius:var(--radius-xl)"><i data-lucide="plus" style="width:.875rem;height:.875rem"></i> Proposer</button>
        </div>
        <div id="materiels-chips" style="display:flex;flex-wrap:wrap;gap:0.5rem">
          <?php foreach ($materielsListe as $mat): ?>
            <?php $sel = in_array($mat['id'], $selectedMaterielIds); ?>
            <label class="materiel-chip" style="display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .85rem;border-radius:999px;border:1.5px solid <?= $sel?'#22c55e':'var(--border)' ?>;cursor:pointer;transition:all .2s;font-size:.85rem;color:<?= $sel?'#166534':'var(--text-secondary)' ?>;background:<?= $sel?'linear-gradient(135deg,#dcfce7,#f0fdf4)':'var(--muted)' ?>;user-select:none">
              <input type="checkbox" name="materiel_ids[]" value="<?= $mat['id'] ?>" <?= $sel?'checked':'' ?> style="display:none" class="mat-cb">
              <i data-lucide="wrench" style="width:.75rem;height:.75rem;opacity:.6"></i>
              <span><?= htmlspecialchars($mat['nom']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <div id="mat-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(4px);align-items:center;justify-content:center">
          <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:1.75rem;width:95%;max-width:460px;box-shadow:0 25px 60px rgba(0,0,0,.25);border:1px solid var(--border)">
            <h3 class="text-lg font-bold mb-4" style="color:var(--text-primary)">Proposer un matériel</h3>
            <div class="form-group"><label class="form-label">Nom <span style="color:var(--destructive)">*</span></label><input type="text" id="mat-nom" class="form-input"></div>
            <div class="form-group"><label class="form-label">Description</label><textarea id="mat-desc" class="form-textarea" rows="2"></textarea></div>
            <div class="flex gap-3 mt-3">
              <button type="button" id="mat-save" class="btn btn-primary flex-1" style="border-radius:var(--radius-xl);background:linear-gradient(135deg,#d97706,#f59e0b);border:none">Proposer</button>
              <button type="button" id="mat-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
            </div>
          </div>
        </div>
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
// ── Ingredients ──
document.getElementById('add-ingredient-btn').addEventListener('click', function() {
  const c = document.getElementById('ingredients-container');
  const row = c.querySelector('.ingredient-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '';
  const old = row.querySelector('.eco-score-badge'); if(old) old.remove();
  c.appendChild(row);
  attachEcoScore(row.querySelector('select'));
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

// ═══ API 1: Open Food Facts — Eco-Score per Ingredient ═══
const ECO_LABELS = {a:'🟢 Eco A',b:'🟡 Eco B',c:'🟠 Eco C',d:'🔴 Eco D',e:'⛔ Eco E'};
const ECO_CLASSES = {a:'eco-a',b:'eco-b',c:'eco-c',d:'eco-d',e:'eco-e'};
const _ecoCache = {};

function estimateEcoGrade(name) {
  const n = name.toLowerCase();
  if (/beef|boeuf|veal|veau|lamb|agneau|mutton|mouton|bison|venison/.test(n)) return 'e';
  if (/chicken|poulet|pork|porc|turkey|dinde|duck|canard|bacon|sausage|saucisse|ham|jambon|tuna|thon|salmon|saumon|shrimp|crevette|prawn/.test(n)) return 'd';
  if (/milk|lait|butter|beurre|cream|cr.me|cheese|fromage|egg|oeuf|flour|farine|sugar|sucre|oil|huile|pasta|p.tes|bread|pain|rice|riz/.test(n)) return 'c';
  if (/apple|pomme|banana|banane|orange|lemon|citron|berry|grain|cereal|nut|noix|seed|graine|oat|avoine|quinoa|almond|amande|walnut|cashew|fruit/.test(n)) return 'b';
  return 'a';
}

function updateScoreCarbone() {
  const co2El = document.getElementById('score_carbone');
  if (!co2El) return;
  const ecoPoints = { a: 0.2, b: 0.6, c: 1.2, d: 2.5, e: 4.5 };
  let total = 0, count = 0;
  document.querySelectorAll('#ingredients-container .ingredient-row select').forEach(sel => {
    const txt = sel.options[sel.selectedIndex]?.text;
    if (sel.value && txt) {
      const grade = _ecoCache[txt.split('(')[0].trim()];
      if (grade) { total += ecoPoints[grade] || 1.0; count++; }
    }
  });
  if (count > 0) {
    co2El.value = ((total / count) + 0.3).toFixed(2);
  }
}

async function fetchEcoScore(name) {
  if (_ecoCache[name] !== undefined) return _ecoCache[name];
  let grade = null;
  try {
    const res = await fetch(`<?= OFF_BASE_URL ?>/cgi/search.pl?search_terms=${encodeURIComponent(name)}&json=1&page_size=1&fields=ecoscore_grade`);
    const d = await res.json();
    const g = d?.products?.[0]?.ecoscore_grade?.toLowerCase() || null;
    const valid = ['a','b','c','d','e'];
    if (valid.includes(g)) grade = g;
  } catch {}
  if (!grade) grade = estimateEcoGrade(name);
  _ecoCache[name] = grade;
  return grade;
}
function attachEcoScore(select) {
  select.addEventListener('change', async function() {
    const row = this.closest('.ingredient-row');
    let badge = row.querySelector('.eco-score-badge'); if(badge) badge.remove();
    const txt = this.options[this.selectedIndex]?.text;
    if (!this.value || !txt) return;
    const name = txt.split('(')[0].trim();
    badge = document.createElement('span');
    badge.className = 'eco-score-badge eco-badge';
    badge.style.cssText = 'background:var(--muted);color:var(--text-muted);margin-left:.35rem;font-size:.65rem;padding:.15rem .4rem;border-radius:999px;border:1px solid var(--border);vertical-align:middle';
    badge.textContent = '⏳';
    this.insertAdjacentElement('afterend', badge);
    const grade = await fetchEcoScore(name);
    if (grade && ECO_LABELS[grade]) {
      badge.textContent = ECO_LABELS[grade];
      badge.className = `eco-score-badge eco-badge ${ECO_CLASSES[grade]}`;
    } else {
      badge.textContent = '🔵 Eco ?';
      badge.className = 'eco-score-badge eco-badge';
      badge.style.background = 'rgba(59,130,246,0.08)'; badge.style.color = '#2563eb'; badge.style.borderColor = '#93c5fd';
    }
    updateScoreCarbone();
  });
}
document.querySelectorAll('#ingredients-container .ingredient-row select').forEach(attachEcoScore);


// ── Steps ──
const steps = <?= json_encode(array_map(function($inst) {
  return ['titre' => $inst['titre'], 'desc' => $inst['description']];
}, $recetteInstructions ?? [])) ?>;

function renderSteps() {
  const list = document.getElementById('steps-list');
  list.innerHTML = '';
  steps.forEach((s, i) => {
    const card = document.createElement('div');
    card.style.cssText = 'display:flex;align-items:flex-start;gap:.75rem;padding:.85rem 1rem;border-radius:var(--radius-xl);background:var(--muted);border:1px solid var(--border)';
    card.innerHTML = `
      <div style="min-width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem">${i+1}</div>
      <div style="flex:1;min-width:0"><div style="font-weight:600;color:var(--text-primary);font-size:.9rem">${s.titre}</div><div style="font-size:.8rem;color:var(--text-muted);margin-top:2px">${s.desc}</div></div>
      <button type="button" onclick="editStep(${i})" class="icon-btn" style="color:#2563eb;width:1.75rem;height:1.75rem"><i data-lucide="pencil" style="width:.8rem;height:.8rem"></i></button>
      <button type="button" onclick="removeStep(${i})" class="icon-btn" style="color:var(--destructive);width:1.75rem;height:1.75rem"><i data-lucide="trash-2" style="width:.8rem;height:.8rem"></i></button>
      <input type="hidden" name="inst_titre[]" value="${s.titre.replace(/"/g,'&quot;')}">
      <input type="hidden" name="inst_description[]" value="${s.desc.replace(/"/g,'&quot;')}">
      <input type="hidden" name="inst_ordre[]" value="${i+1}">`;
    list.appendChild(card);
  });
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function openStepModal(idx) {
  document.getElementById('step-edit-index').value = idx;
  document.getElementById('step-modal-title').textContent = idx >= 0 ? 'Modifier l\'étape' : 'Ajouter une étape';
  document.getElementById('step-titre').value = idx >= 0 ? steps[idx].titre : '';
  document.getElementById('step-desc').value = idx >= 0 ? steps[idx].desc : '';
  document.getElementById('step-modal').style.display = 'flex';
}
function editStep(i) { openStepModal(i); }
function removeStep(i) { steps.splice(i, 1); renderSteps(); }
document.getElementById('btn-add-step').addEventListener('click', () => openStepModal(-1));
document.getElementById('step-cancel').addEventListener('click', () => document.getElementById('step-modal').style.display = 'none');
document.getElementById('step-save').addEventListener('click', () => {
  const t = document.getElementById('step-titre').value.trim(), d = document.getElementById('step-desc').value.trim();
  if (!t || !d) return;
  const idx = parseInt(document.getElementById('step-edit-index').value);
  if (idx >= 0) steps[idx] = {titre:t, desc:d}; else steps.push({titre:t, desc:d});
  document.getElementById('step-modal').style.display = 'none';
  renderSteps();
});
renderSteps();

// ── Materiel chips ──
document.querySelectorAll('.materiel-chip').forEach(chip => {
  chip.addEventListener('click', () => {
    const cb = chip.querySelector('.mat-cb'); cb.checked = !cb.checked;
    chip.style.background = cb.checked ? 'linear-gradient(135deg,#dcfce7,#f0fdf4)' : 'var(--muted)';
    chip.style.borderColor = cb.checked ? '#22c55e' : 'var(--border)';
    chip.style.color = cb.checked ? '#166534' : 'var(--text-secondary)';
  });
});
document.getElementById('btn-propose-materiel').addEventListener('click', () => { document.getElementById('mat-nom').value=''; document.getElementById('mat-desc').value=''; document.getElementById('mat-modal').style.display='flex'; });
document.getElementById('mat-cancel').addEventListener('click', () => document.getElementById('mat-modal').style.display='none');
document.getElementById('mat-save').addEventListener('click', () => {
  const nom = document.getElementById('mat-nom').value.trim();
  if (!nom) return;
  const fd = new FormData(); fd.append('nom',nom); fd.append('description',document.getElementById('mat-desc').value.trim()); fd.append('propose_par','<?= htmlspecialchars($recette['soumis_par'] ?? '') ?>');
  fetch('<?= BASE_URL ?>/?page=recettes&action=propose-materiel',{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
    if(d.success){const c=document.createElement('label');c.className='materiel-chip';c.style.cssText='display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .85rem;border-radius:999px;border:1.5px dashed #f59e0b;font-size:.85rem;color:#92400e;background:#fef9c3;opacity:.8';c.innerHTML='<span>'+d.nom+' (en attente)</span>';document.getElementById('materiels-chips').appendChild(c);document.getElementById('mat-modal').style.display='none';if(typeof showToast==='function')showToast('success','Matériel proposé');}
  });
});

// ── Inline validation ──
function showFE(f,m){f.classList.add('is-invalid');let w=f.closest('.form-group')||f.parentElement;let e=w.querySelector('.field-error');if(!e){e=document.createElement('div');e.className='field-error';w.appendChild(e);}e.innerHTML='<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> '+m;e.classList.add('show');}
function clearFE(f){f.classList.remove('is-invalid');f.classList.add('is-valid');let w=f.closest('.form-group')||f.parentElement;let e=w.querySelector('.field-error');if(e)e.classList.remove('show');}
function showSE(id,m){let e=document.getElementById(id+'-err');if(!e){e=document.createElement('div');e.id=id+'-err';e.className='field-error';document.getElementById(id).after(e);}e.innerHTML='<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> '+m;e.classList.add('show');}
function clearSE(id){let e=document.getElementById(id+'-err');if(e)e.classList.remove('show');}

const tEl=document.getElementById('titre'), tmEl=document.getElementById('temps_preparation'), dEl=document.getElementById('difficulte');
tEl?.addEventListener('blur',()=>{if(!tEl.value.trim())showFE(tEl,'Titre obligatoire.');else clearFE(tEl);});
tEl?.addEventListener('input',()=>{if(tEl.classList.contains('is-invalid')&&tEl.value.trim())clearFE(tEl);});
tmEl?.addEventListener('blur',()=>{if(!tmEl.value||parseInt(tmEl.value)<=0)showFE(tmEl,'Temps > 0.');else clearFE(tmEl);});
dEl?.addEventListener('change',()=>{if(!dEl.value)showFE(dEl,'Difficulté obligatoire.');else clearFE(dEl);});

document.getElementById('editSuggestionForm').addEventListener('submit', function(e) {
  let v=true;
  if(!tEl.value.trim()){showFE(tEl,'Titre obligatoire.');v=false;}else clearFE(tEl);
  if(steps.length===0){showSE('steps-list','Ajoutez au moins une étape.');v=false;}else clearSE('steps-list');
  if(!tmEl.value||parseInt(tmEl.value)<=0){showFE(tmEl,'Temps > 0.');v=false;}else clearFE(tmEl);
  if(!dEl.value){showFE(dEl,'Difficulté obligatoire.');v=false;}else clearFE(dEl);
  let h=false;document.querySelectorAll('#ingredients-container .ingredient-row').forEach(r=>{if(r.querySelector('select').value&&parseFloat(r.querySelector('input[type="number"]').value)>0)h=true;});
  if(!h){showSE('ingredients-container','Ajoutez au moins un ingrédient.');v=false;}else clearSE('ingredients-container');
  if(!v)e.preventDefault();
});
</script>

