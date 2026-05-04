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
      <!-- Hidden legacy instructions -->
      <input type="hidden" name="instructions" value="<?= htmlspecialchars($recette['instructions'] ?? '') ?>">

      <?php $diff = $_POST['difficulte'] ?? $recette['difficulte']; ?>
      <div class="grid grid-cols-3 gap-4">
        <div class="form-group">
          <label class="form-label" for="temps_preparation"><i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i> Temps (min)</label>
          <input type="number" name="temps_preparation" id="temps_preparation" class="form-input" value="<?= htmlspecialchars($_POST['temps_preparation'] ?? $recette['temps_preparation']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="difficulte"><i data-lucide="signal" style="width:0.875rem;height:0.875rem"></i> Difficulté</label>
          <select name="difficulte" id="difficulte" class="form-input">
            <option value="">-- Choisir --</option>
            <option value="facile" <?= $diff==='facile'?'selected':'' ?>>Facile</option>
            <option value="moyen" <?= $diff==='moyen'?'selected':'' ?>>Moyen</option>
            <option value="difficile" <?= $diff==='difficile'?'selected':'' ?>>Difficile</option>
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

      <!-- ═══ ÉTAPES ═══ -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <div class="flex items-center justify-between mb-4">
          <label class="form-label mb-0"><i data-lucide="list-ordered" style="width:0.875rem;height:0.875rem"></i> Étapes de préparation</label>
          <button type="button" id="btn-add-step" class="btn btn-outline-primary btn-sm" style="border-radius:var(--radius-xl)"><i data-lucide="plus" style="width:.875rem;height:.875rem"></i> Ajouter</button>
        </div>
        <div id="steps-list" class="space-y-3"></div>
        <div id="step-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.45);backdrop-filter:blur(4px);align-items:center;justify-content:center">
          <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:1.75rem;width:95%;max-width:520px;box-shadow:0 25px 60px rgba(0,0,0,.25);border:1px solid var(--border)">
            <h3 id="step-modal-title" class="text-lg font-bold mb-4" style="color:var(--text-primary)">Étape</h3>
            <input type="hidden" id="step-edit-index" value="-1">
            <div class="form-group"><label class="form-label">Titre *</label><input type="text" id="step-titre" class="form-input"></div>
            <div class="form-group"><label class="form-label">Description *</label><textarea id="step-desc" class="form-textarea" rows="3"></textarea></div>
            <div class="flex gap-3 mt-4">
              <button type="button" id="step-save" class="btn btn-primary flex-1" style="border-radius:var(--radius-xl)">Enregistrer</button>
              <button type="button" id="step-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <label class="form-label"><i data-lucide="carrot" style="width:0.875rem;height:0.875rem"></i> Ingrédients</label>
        <div id="ingredients-container" class="space-y-3">
          <?php if (!empty($recetteIngredients)): ?>
            <?php foreach ($recetteIngredients as $ri): ?>
              <div class="flex gap-3 items-center ingredient-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
                <select name="ingredient_ids[]" class="form-input flex-1"><?php foreach ($ingredientsList as $i): ?><option value="<?= $i['id'] ?>" <?= $i['id'] == $ri['ingredient_id'] ? 'selected' : '' ?>><?= htmlspecialchars($i['nom']) ?></option><?php endforeach; ?></select>
                <input type="number" name="quantites[]" class="form-input" style="width:120px" value="<?= $ri['quantite'] ?>" step="0.01">
                <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.ingredient-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="flex gap-3 items-center ingredient-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
              <select name="ingredient_ids[]" class="form-input flex-1"><option value="">-- Choisir --</option><?php foreach ($ingredientsList as $i): ?><option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['nom']) ?></option><?php endforeach; ?></select>
              <input type="number" name="quantites[]" class="form-input" style="width:120px" placeholder="Qté" step="0.01">
              <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.ingredient-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
            </div>
          <?php endif; ?>
        </div>
        <button type="button" id="add-ingredient-btn" class="btn btn-outline-primary btn-sm mt-3"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un ingrédient</button>
      </div>

      <!-- ═══ MATÉRIELS ═══ -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <label class="form-label"><i data-lucide="wrench" style="width:0.875rem;height:0.875rem"></i> Matériels nécessaires</label>
        <div id="materiels-chips" style="display:flex;flex-wrap:wrap;gap:0.5rem">
          <?php foreach ($materielsListe as $mat): ?>
            <?php $sel = in_array($mat['id'], $selectedMaterielIds ?? []); ?>
            <label class="materiel-chip" style="display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .85rem;border-radius:999px;border:1.5px solid <?= $sel?'#22c55e':'var(--border)' ?>;cursor:pointer;transition:all .2s;font-size:.85rem;color:<?= $sel?'#166534':'var(--text-secondary)' ?>;background:<?= $sel?'linear-gradient(135deg,#dcfce7,#f0fdf4)':'var(--muted)' ?>;user-select:none">
              <input type="checkbox" name="materiel_ids[]" value="<?= $mat['id'] ?>" <?= $sel?'checked':'' ?> style="display:none" class="mat-cb">
              <i data-lucide="wrench" style="width:.75rem;height:.75rem;opacity:.6"></i>
              <span><?= htmlspecialchars($mat['nom']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
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

const steps = <?= json_encode(array_map(function($inst) {
  return ['titre' => $inst['titre'], 'desc' => $inst['description']];
}, $recetteInstructions ?? [])) ?>;

function renderSteps() {
  const list = document.getElementById('steps-list'); list.innerHTML = '';
  steps.forEach((s, i) => {
    const c = document.createElement('div');
    c.style.cssText = 'display:flex;align-items:flex-start;gap:.75rem;padding:.85rem 1rem;border-radius:var(--radius-xl);background:var(--muted);border:1px solid var(--border)';
    c.innerHTML = `<div style="min-width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem">${i+1}</div><div style="flex:1"><div style="font-weight:600;font-size:.9rem">${s.titre}</div><div style="font-size:.8rem;color:var(--text-muted)">${s.desc}</div></div><button type="button" onclick="editStep(${i})" class="icon-btn" style="color:#2563eb;width:1.75rem;height:1.75rem"><i data-lucide="pencil" style="width:.8rem;height:.8rem"></i></button><button type="button" onclick="removeStep(${i})" class="icon-btn" style="color:var(--destructive);width:1.75rem;height:1.75rem"><i data-lucide="trash-2" style="width:.8rem;height:.8rem"></i></button><input type="hidden" name="inst_titre[]" value="${s.titre.replace(/"/g,'&quot;')}"><input type="hidden" name="inst_description[]" value="${s.desc.replace(/"/g,'&quot;')}"><input type="hidden" name="inst_ordre[]" value="${i+1}">`;
    list.appendChild(c);
  });
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function openStepModal(idx) { document.getElementById('step-edit-index').value=idx; document.getElementById('step-modal-title').textContent=idx>=0?'Modifier':'Ajouter une étape'; document.getElementById('step-titre').value=idx>=0?steps[idx].titre:''; document.getElementById('step-desc').value=idx>=0?steps[idx].desc:''; document.getElementById('step-modal').style.display='flex'; }
function editStep(i){openStepModal(i)} function removeStep(i){steps.splice(i,1);renderSteps()}
document.getElementById('btn-add-step').addEventListener('click',()=>openStepModal(-1));
document.getElementById('step-cancel').addEventListener('click',()=>document.getElementById('step-modal').style.display='none');
document.getElementById('step-save').addEventListener('click',()=>{const t=document.getElementById('step-titre').value.trim(),d=document.getElementById('step-desc').value.trim();if(!t||!d)return;const idx=parseInt(document.getElementById('step-edit-index').value);if(idx>=0)steps[idx]={titre:t,desc:d};else steps.push({titre:t,desc:d});document.getElementById('step-modal').style.display='none';renderSteps();});
renderSteps();

document.querySelectorAll('.materiel-chip').forEach(chip=>{chip.addEventListener('click',()=>{const cb=chip.querySelector('.mat-cb');cb.checked=!cb.checked;chip.style.background=cb.checked?'linear-gradient(135deg,#dcfce7,#f0fdf4)':'var(--muted)';chip.style.borderColor=cb.checked?'#22c55e':'var(--border)';chip.style.color=cb.checked?'#166534':'var(--text-secondary)';});});

// ── Inline validation helpers ──
function showFE(field, msg) {
  field.classList.add('is-invalid'); field.classList.remove('is-valid');
  let wrap = field.closest('.form-group') || field.parentElement;
  let el = wrap.querySelector('.field-error');
  if (!el) { el = document.createElement('div'); el.className = 'field-error'; wrap.appendChild(el); }
  el.innerHTML = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> ` + msg;
  el.classList.add('show');
}
function clearFE(field) {
  field.classList.remove('is-invalid'); field.classList.add('is-valid');
  const wrap = field.closest('.form-group') || field.parentElement;
  const el = wrap.querySelector('.field-error');
  if (el) el.classList.remove('show');
}
function showSectionErr(id, msg) {
  let el = document.getElementById(id+'-err');
  if (!el) { el = document.createElement('div'); el.id = id+'-err'; el.className = 'field-error'; document.getElementById(id).after(el); }
  el.innerHTML = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> ` + msg;
  el.classList.add('show');
}
function clearSectionErr(id) { const el=document.getElementById(id+'-err'); if(el) el.classList.remove('show'); }

const editTitre = document.getElementById('titre');
const editDiff  = document.getElementById('difficulte');
editTitre?.addEventListener('blur', () => { if(!editTitre.value.trim()) showFE(editTitre,'Le titre est obligatoire.'); else clearFE(editTitre); });
editTitre?.addEventListener('input', () => { if(editTitre.classList.contains('is-invalid') && editTitre.value.trim()) clearFE(editTitre); });
editDiff?.addEventListener('change', () => { if(!editDiff.value) showFE(editDiff,'Choisissez une difficulté.'); else clearFE(editDiff); });

document.getElementById('recetteForm').addEventListener('submit', function(e) {
  let valid = true;
  if (!editTitre?.value.trim()) { showFE(editTitre,'Le titre est obligatoire.'); valid=false; } else if(editTitre) clearFE(editTitre);
  if (steps.length === 0) { showSectionErr('steps-list','Ajoutez au moins une étape.'); valid=false; } else clearSectionErr('steps-list');
  if (!valid) e.preventDefault();
});
</script>

