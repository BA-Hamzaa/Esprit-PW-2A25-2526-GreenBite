<!-- Vue FrontOffice : Proposer une recette (client) -->
<div style="padding:2rem;max-width:52rem;margin:0 auto">

  <!-- Back link -->
  <a href="<?= BASE_URL ?>/?page=recettes" class="flex items-center gap-2 text-sm mb-6"
     style="color:var(--secondary);font-weight:500;transition:all 0.3s"
     onmouseover="this.style.transform='translateX(-4px)'"
     onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux recettes
  </a>

  <!-- Header -->
  <div class="flex items-center gap-4 mb-8">
    <div style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;
                background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:var(--radius-xl);
                box-shadow:0 4px 12px rgba(234,179,8,0.2)">
      <i data-lucide="lightbulb" style="width:1.75rem;height:1.75rem;color:#d97706"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">
        Proposer une Recette
      </h1>
      <p class="text-sm" style="color:var(--text-muted)">
        Votre recette sera examinée par notre équipe avant d'être publiée ✨
      </p>
    </div>
  </div>

  <!-- Info banner -->
  <div class="flex items-start gap-3 mb-6 p-4 rounded-xl"
       style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #93c5fd;color:#1e40af">
    <i data-lucide="info" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
    <p class="text-sm">
      Après soumission, votre recette est <strong>en attente de validation</strong> par un administrateur.
      Une fois approuvée, elle apparaîtra automatiquement dans la section recettes du site.
    </p>
  </div>

  <!-- Success / Error -->
  <?php if (!empty($_SESSION['success'])): ?>
    <div class="flex items-center gap-3 p-4 rounded-xl mb-6"
         style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);border:1px solid #86efac;color:#166534">
      <i data-lucide="check-circle" style="width:1.25rem;height:1.25rem"></i>
      <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

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
  <div class="card" style="padding:2rem;border-top:4px solid #d97706">
    <form novalidate method="POST" enctype="multipart/form-data" id="suggestForm">

      <!-- Nom du proposant -->
      <div class="form-group">
        <label class="form-label" for="soumis_par">
          <i data-lucide="user" style="width:0.875rem;height:0.875rem"></i> Votre nom <span style="color:var(--destructive)">*</span>
        </label>
        <input type="text" name="soumis_par" id="soumis_par" class="form-input"
               placeholder="Ex: Marie Dupont"
               value="<?= htmlspecialchars($_POST['soumis_par'] ?? $_SESSION['username'] ?? '') ?>">
      </div>

      <!-- Titre -->
      <div class="form-group">
        <label class="form-label" for="titre">
          <i data-lucide="type" style="width:0.875rem;height:0.875rem"></i> Titre de la recette <span style="color:var(--destructive)">*</span>
        </label>
        <input type="text" name="titre" id="titre" class="form-input"
               placeholder="Ex: Curry de lentilles au lait de coco"
               value="<?= htmlspecialchars($_POST['titre'] ?? $_GET['titre'] ?? '') ?>">
      </div>

      <!-- Description -->
      <div class="form-group">
        <label class="form-label" for="description">
          <i data-lucide="align-left" style="width:0.875rem;height:0.875rem"></i> Description courte
        </label>
        <textarea name="description" id="description" class="form-textarea" rows="2"
                  placeholder="Brève présentation de votre recette..."><?= htmlspecialchars($_POST['description'] ?? $_GET['description'] ?? '') ?></textarea>
      </div>

      <!-- Instructions (hidden legacy field) -->
      <input type="hidden" name="instructions" id="instructions" value="<?= htmlspecialchars($_POST['instructions'] ?? 'Instructions structurées') ?>">

      <!-- ═══ ÉTAPES DE PRÉPARATION ═══ -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <div class="flex items-center justify-between mb-4">
          <label class="form-label mb-0">
            <i data-lucide="list-ordered" style="width:0.875rem;height:0.875rem"></i>
            Étapes de préparation <span style="color:var(--destructive)">*</span>
          </label>
          <button type="button" id="btn-add-step" class="btn btn-outline-primary btn-sm" style="border-radius:var(--radius-xl)">
            <i data-lucide="plus" style="width:.875rem;height:.875rem"></i> Ajouter une étape
          </button>
        </div>

        <div id="steps-list" class="space-y-3"></div>

        <!-- Mini-panel overlay -->
        <div id="step-modal" style="display:none;position:fixed;inset:0;z-index:2147483647;background:rgba(0,0,0,.55);align-items:center;justify-content:center" onclick="if(event.target===this)gbCloseModal(this)">
          <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:1.75rem;width:95%;max-width:520px;box-shadow:0 25px 60px rgba(0,0,0,.35);border:1px solid var(--border);max-height:90vh;overflow-y:auto;overscroll-behavior:contain" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-5">
              <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#dbeafe,#eff6ff);display:flex;align-items:center;justify-content:center">
                <i data-lucide="list-ordered" style="width:1.25rem;height:1.25rem;color:#2563eb"></i>
              </div>
              <h3 id="step-modal-title" class="text-lg font-bold" style="color:var(--text-primary)">Ajouter une étape</h3>
            </div>
            <input type="hidden" id="step-edit-index" value="-1">
            <div class="form-group">
              <label class="form-label">Titre de l'étape <span style="color:var(--destructive)">*</span></label>
              <input type="text" id="step-titre" class="form-input" placeholder="Ex: Préparer les légumes">
            </div>
            <div class="form-group">
              <label class="form-label">Description détaillée <span style="color:var(--destructive)">*</span></label>
              <textarea id="step-desc" class="form-textarea" rows="3" placeholder="Décrivez cette étape en détail..."></textarea>
            </div>
            <div class="flex gap-3 mt-4">
              <button type="button" id="step-save" class="btn btn-primary flex-1" style="border-radius:var(--radius-xl)">
                <i data-lucide="check" style="width:.875rem;height:.875rem"></i> Enregistrer
              </button>
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
                 value="<?= htmlspecialchars($_POST['temps_preparation'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="difficulte">
            <i data-lucide="signal" style="width:0.875rem;height:0.875rem"></i> Difficulté <span style="color:var(--destructive)">*</span>
          </label>
          <select name="difficulte" id="difficulte" class="form-input">
            <option value="">-- Choisir --</option>
            <option value="facile"   <?= (($_POST['difficulte'] ?? '') === 'facile')   ? 'selected' : '' ?>>🟢 Facile</option>
            <option value="moyen"    <?= (($_POST['difficulte'] ?? '') === 'moyen')    ? 'selected' : '' ?>>🟡 Moyen</option>
            <option value="difficile"<?= (($_POST['difficulte'] ?? '') === 'difficile')? 'selected' : '' ?>>🔴 Difficile</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="categorie">
            <i data-lucide="tag" style="width:0.875rem;height:0.875rem"></i> Catégorie
          </label>
          <input type="text" name="categorie" id="categorie" class="form-input"
                 placeholder="Salade, Bowl, Soupe..."
                 value="<?= htmlspecialchars($_POST['categorie'] ?? '') ?>">
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
                 value="<?= htmlspecialchars($_POST['calories_total'] ?? '0') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="score_carbone">
            <i data-lucide="leaf" style="width:0.875rem;height:0.875rem"></i> Score CO₂
          </label>
          <input type="number" name="score_carbone" id="score_carbone" class="form-input"
                 placeholder="1.20" 
                 value="<?= htmlspecialchars($_POST['score_carbone'] ?? '0') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="image">
            <i data-lucide="image" style="width:0.875rem;height:0.875rem"></i> Photo (optionnel)
          </label>
          <!-- Hidden field for TheMealDB image URL -->
          <input type="hidden" name="image_url" id="image_url" value="<?= htmlspecialchars($_GET['image_url'] ?? '') ?>">
          <!-- Preview if coming from TheMealDB -->
          <?php if (!empty($_GET['image_url'])): ?>
          <div id="meal-img-preview" style="margin-bottom:0.6rem;display:flex;align-items:center;gap:0.75rem;padding:0.6rem 0.75rem;background:var(--muted);border-radius:var(--radius-xl);border:1px solid var(--border)">
            <img src="<?= htmlspecialchars($_GET['image_url']) ?>" alt="Aperçu" style="width:3.5rem;height:3.5rem;object-fit:cover;border-radius:var(--radius-lg)">
            <div>
              <p style="font-size:0.75rem;font-weight:600;color:var(--text-primary)">Image importée depuis TheMealDB</p>
              <p style="font-size:0.68rem;color:var(--text-muted)">Elle sera sauvegardée automatiquement. Vous pouvez aussi en uploader une autre.</p>
            </div>
          </div>
          <?php endif; ?>
          <input type="file" name="image" id="image" class="form-input" accept="image/*">
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
        </div>
        <div class="flex gap-2 mt-3">
          <button type="button" id="add-ingredient-btn" class="btn btn-outline-primary btn-sm">
            <i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un ingrédient
          </button>
          <button type="button" id="btn-propose-ingredient" class="btn btn-sm" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border:none;border-radius:var(--radius-xl)">
            <i data-lucide="sparkles" style="width:0.875rem;height:0.875rem"></i> Créer un ingrédient
          </button>
        </div>

        <!-- Propose ingredient modal -->
        <div id="ing-modal" style="display:none;position:fixed;inset:0;z-index:2147483647;background:rgba(0,0,0,.55);align-items:center;justify-content:center" onclick="if(event.target===this)gbCloseModal(this)">
          <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:1.75rem;width:95%;max-width:460px;box-shadow:0 25px 60px rgba(0,0,0,.35);border:1px solid var(--border);max-height:90vh;overflow-y:auto;overscroll-behavior:contain" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-5">
              <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#dcfce7,#f0fdf4);display:flex;align-items:center;justify-content:center">
                <i data-lucide="carrot" style="width:1.25rem;height:1.25rem;color:#16a34a"></i>
              </div>
              <h3 class="text-lg font-bold" style="color:var(--text-primary)">Créer un ingrédient</h3>
            </div>
            <div class="form-group">
              <label class="form-label">Nom de l'ingrédient <span style="color:var(--destructive)">*</span></label>
              <input type="text" id="ing-nom" class="form-input" placeholder="Ex: Quinoa, Tofu, Curcuma...">
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div class="form-group">
                <label class="form-label">Unité</label>
                <select id="ing-unite" class="form-input">
                  <option value="g">Grammes (g)</option>
                  <option value="ml">Millilitres (ml)</option>
                  <option value="pcs">Pièce(s)</option>
                  <option value="cuillère">Cuillère</option>
                  <option value="tasse">Tasse</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Calories/unité</label>
                <input type="number" id="ing-cal" class="form-input" placeholder="0" min="0">
              </div>
            </div>
            <p class="text-xs mb-3" style="color:var(--text-muted)"><i data-lucide="info" style="width:.7rem;height:.7rem;display:inline"></i> L'ingrédient sera ajouté immédiatement à votre liste.</p>
            <div class="flex gap-3">
              <button type="button" id="ing-save" class="btn btn-primary flex-1" style="border-radius:var(--radius-xl);background:linear-gradient(135deg,#16a34a,#22c55e);border:none">
                <i data-lucide="check" style="width:.875rem;height:.875rem"></i> Créer et ajouter
              </button>
              <button type="button" id="ing-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══ MATÉRIELS NÉCESSAIRES ═══ -->
      <div class="mb-6" style="border-top:1px solid var(--border);padding-top:1.5rem">
        <div class="flex items-center justify-between mb-4">
          <label class="form-label mb-0">
            <i data-lucide="wrench" style="width:0.875rem;height:0.875rem"></i> Matériels nécessaires
          </label>
          <button type="button" id="btn-propose-materiel" class="btn btn-outline-primary btn-sm" style="border-radius:var(--radius-xl)">
            <i data-lucide="plus" style="width:.875rem;height:.875rem"></i> Proposer un matériel
          </button>
        </div>
        <div id="materiels-chips" style="display:flex;flex-wrap:wrap;gap:0.5rem">
          <?php foreach ($materielsListe as $mat): ?>
            <label class="materiel-chip" style="display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .85rem;border-radius:999px;border:1.5px solid var(--border);cursor:pointer;transition:all .2s;font-size:.85rem;color:var(--text-secondary);background:var(--muted);user-select:none">
              <input type="checkbox" name="materiel_ids[]" value="<?= $mat['id'] ?>" style="display:none" class="mat-cb">
              <i data-lucide="wrench" style="width:.75rem;height:.75rem;opacity:.6"></i>
              <span><?= htmlspecialchars($mat['nom']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>

        <!-- Propose materiel modal -->
        <div id="mat-modal" style="display:none;position:fixed;inset:0;z-index:2147483647;background:rgba(0,0,0,.55);align-items:center;justify-content:center" onclick="if(event.target===this)gbCloseModal(this)">
          <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:1.75rem;width:95%;max-width:460px;box-shadow:0 25px 60px rgba(0,0,0,.35);border:1px solid var(--border);max-height:90vh;overflow-y:auto;overscroll-behavior:contain" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-5">
              <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#fef9c3,#fefce8);display:flex;align-items:center;justify-content:center">
                <i data-lucide="wrench" style="width:1.25rem;height:1.25rem;color:#d97706"></i>
              </div>
              <h3 class="text-lg font-bold" style="color:var(--text-primary)">Proposer un matériel</h3>
            </div>
            <div class="form-group">
              <label class="form-label">Nom du matériel <span style="color:var(--destructive)">*</span></label>
              <input type="text" id="mat-nom" class="form-input" placeholder="Ex: Mandoline">
            </div>
            <div class="form-group">
              <label class="form-label">Description (optionnel)</label>
              <textarea id="mat-desc" class="form-textarea" rows="2" placeholder="Décrivez brièvement ce matériel..."></textarea>
            </div>
            <p class="text-xs mb-3" style="color:var(--text-muted)"><i data-lucide="info" style="width:.7rem;height:.7rem;display:inline"></i> Le matériel sera disponible après validation par l'admin.</p>
            <div class="flex gap-3">
              <button type="button" id="mat-save" class="btn btn-primary flex-1" style="border-radius:var(--radius-xl);background:linear-gradient(135deg,#d97706,#f59e0b);border:none">
                <i data-lucide="send" style="width:.875rem;height:.875rem"></i> Proposer
              </button>
              <button type="button" id="mat-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl"
              style="background:linear-gradient(135deg,#d97706,#f59e0b);border:none">
        <i data-lucide="send" style="width:1.125rem;height:1.125rem"></i>
        Soumettre ma recette
      </button>
      <p class="text-center text-xs mt-3" style="color:var(--text-muted)">
        Votre recette sera visible après validation de l'équipe GreenBite 🌿
      </p>
    </form>
  </div>
</div>

<script>
// ── Modal helpers ──────────────────────────────────────────────────────────
// Portal pattern: move modals to <body> so they are never inside a scrolling
// container. Combined with saving/restoring scrollY, this eliminates all jumps.
var _gbScrollY   = 0;
var _gbOpenCount = 0;

// Move all modals to <body> immediately so DOM reflows inside the form
// never affect the viewport scroll position.
document.addEventListener('DOMContentLoaded', function() {
  ['ing-modal','mat-modal','step-modal'].forEach(function(id) {
    var m = document.getElementById(id);
    if (m && m.parentElement !== document.body) {
      document.body.appendChild(m);
    }
  });
});

function gbOpenModal(el) {
  if (_gbOpenCount === 0) {
    _gbScrollY = window.pageYOffset || document.documentElement.scrollTop;
  }
  el.style.display = 'flex';
  _gbOpenCount++;
}

function gbCloseModal(el) {
  el.style.display = 'none';
  // Clear inline validation errors
  el.querySelectorAll('.gb-field-err').forEach(function(e){ e.textContent=''; });
  el.querySelectorAll('input,textarea,select').forEach(function(f){ f.style.borderColor=''; });
  _gbOpenCount = Math.max(0, _gbOpenCount - 1);
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    ['ing-modal','mat-modal','step-modal'].forEach(function(id) {
      var m = document.getElementById(id);
      if (m && m.style.display === 'flex') gbCloseModal(m);
    });
  }
});

// ── Inline field validation helpers ──
function gbShowErr(field, msg) {
  field.style.borderColor = '#ef4444';
  var wrap = field.closest('.form-group') || field.parentElement;
  var err = wrap.querySelector('.gb-field-err');
  if (!err) {
    err = document.createElement('div');
    err.className = 'gb-field-err';
    err.style.cssText = 'color:#ef4444;font-size:12px;margin-top:4px;font-weight:500';
    wrap.appendChild(err);
  }
  err.textContent = '\u26a0 ' + msg;
}
function gbClearErr(field) {
  field.style.borderColor = '';
  var wrap = field.closest('.form-group') || field.parentElement;
  var err = wrap.querySelector('.gb-field-err');
  if (err) err.textContent = '';
}

// ── Ingredient rows ──
document.getElementById('add-ingredient-btn').addEventListener('click', function() {
  const c = document.getElementById('ingredients-container');
  const row = c.querySelector('.ingredient-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '';
  // Remove any existing eco badge
  const old = row.querySelector('.eco-score-badge'); if(old) old.remove();
  c.appendChild(row);
  attachEcoScore(row.querySelector('select'));
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

// ═══ API 1: Open Food Facts — Eco-Score per Ingredient ═══
const ECO_LABELS = {a:'🟢 Eco A',b:'🟡 Eco B',c:'🟠 Eco C',d:'🔴 Eco D',e:'⛔ Eco E'};
const ECO_CLASSES = {a:'eco-a',b:'eco-b',c:'eco-c',d:'eco-d',e:'eco-e'};
const _ecoCache = {};

// Local estimator — Open Food Facts only has eco-scores for packaged products,
// not raw ingredients (garlic, flour, etc.), so we estimate by ingredient type.
function estimateEcoGrade(name) {
  const n = name.toLowerCase();
  if (/beef|boeuf|veal|veau|lamb|agneau|mutton|mouton|bison|venison/.test(n)) return 'e';
  if (/chicken|poulet|pork|porc|turkey|dinde|duck|canard|bacon|sausage|saucisse|ham|jambon|tuna|thon|salmon|saumon|shrimp|crevette|prawn/.test(n)) return 'd';
  if (/milk|lait|butter|beurre|cream|cr.me|cheese|fromage|egg|oeuf|flour|farine|sugar|sucre|oil|huile|pasta|p.tes|bread|pain|rice|riz/.test(n)) return 'c';
  if (/apple|pomme|banana|banane|orange|lemon|citron|berry|grain|cereal|nut|noix|seed|graine|oat|avoine|quinoa|almond|amande|walnut|cashew|fruit/.test(n)) return 'b';
  // vegetables, herbs, legumes, spices default to A
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

async function fetchEcoScore(ingredientName) {
  if (_ecoCache[ingredientName] !== undefined) return _ecoCache[ingredientName];
  let grade = null;
  try {
    const q = encodeURIComponent(ingredientName);
    const res = await fetch(
      `<?= OFF_BASE_URL ?>/cgi/search.pl?search_terms=${q}&json=1&page_size=3&fields=ecoscore_grade,product_name`,
      { signal: AbortSignal.timeout(4000) }
    );
    const data = await res.json();
    const valid = ['a','b','c','d','e'];
    for (const p of (data?.products || [])) {
      const g = (p.ecoscore_grade || '').toLowerCase();
      if (valid.includes(g)) { grade = g; break; }
    }
  } catch { /* network error — will use local estimator */ }
  // Fall back to local estimation when API has no valid grade
  if (!grade) grade = estimateEcoGrade(ingredientName);
  _ecoCache[ingredientName] = grade;
  return grade;
}

function attachEcoScore(select) {
  select.addEventListener('change', async function() {
    const row = this.closest('.ingredient-row');
    let badge = row.querySelector('.eco-score-badge');
    if (badge) badge.remove();
    const selectedText = this.options[this.selectedIndex]?.text;
    if (!this.value || !selectedText) return;
    const name = selectedText.split('(')[0].trim();
    badge = document.createElement('span');
    badge.className = 'eco-score-badge eco-badge';
    badge.style.cssText = 'background:var(--muted);color:var(--text-muted);margin-left:.35rem;font-size:.65rem;padding:.15rem .4rem;border-radius:999px;border:1px solid var(--border);vertical-align:middle';
    badge.textContent = '⏳';
    this.parentElement.style.position = 'relative';
    this.insertAdjacentElement('afterend', badge);
    const grade = await fetchEcoScore(name);
    badge.textContent = ECO_LABELS[grade] || '🔵 Eco ?';
    badge.className = `eco-score-badge eco-badge ${ECO_CLASSES[grade] || ''}`;
    if (!ECO_CLASSES[grade]) badge.style.cssText += ';background:rgba(59,130,246,0.08);color:#2563eb;border-color:#93c5fd';
    updateScoreCarbone();
  });
}

// Attach to initial ingredient rows
document.querySelectorAll('#ingredients-container .ingredient-row select').forEach(attachEcoScore);


// ── Steps management ──
const steps = [];
function renderSteps() {
  const list = document.getElementById('steps-list');
  list.innerHTML = '';
  steps.forEach((s, i) => {
    const card = document.createElement('div');
    card.style.cssText = 'display:flex;align-items:flex-start;gap:.75rem;padding:.85rem 1rem;border-radius:var(--radius-xl);background:var(--muted);border:1px solid var(--border);transition:all .2s';
    card.innerHTML = `
      <div style="min-width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem">${i+1}</div>
      <div style="flex:1;min-width:0">
        <div style="font-weight:600;color:var(--text-primary);font-size:.9rem">${s.titre}</div>
        <div style="font-size:.8rem;color:var(--text-muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${s.desc}</div>
      </div>
      <button type="button" onclick="editStep(${i})" class="icon-btn" style="color:#2563eb;width:1.75rem;height:1.75rem;flex-shrink:0"><i data-lucide="pencil" style="width:.8rem;height:.8rem"></i></button>
      <button type="button" onclick="removeStep(${i})" class="icon-btn" style="color:var(--destructive);width:1.75rem;height:1.75rem;flex-shrink:0"><i data-lucide="trash-2" style="width:.8rem;height:.8rem"></i></button>
      <input type="hidden" name="inst_titre[]" value="${s.titre.replace(/"/g,'&quot;')}">
      <input type="hidden" name="inst_description[]" value="${s.desc.replace(/"/g,'&quot;')}">
      <input type="hidden" name="inst_ordre[]" value="${i+1}">`;
    list.appendChild(card);
  });
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function openStepModal(idx) {
  const m = document.getElementById('step-modal');
  document.getElementById('step-edit-index').value = idx;
  if (idx >= 0) {
    document.getElementById('step-modal-title').textContent = 'Modifier l\'étape';
    document.getElementById('step-titre').value = steps[idx].titre;
    document.getElementById('step-desc').value = steps[idx].desc;
  } else {
    document.getElementById('step-modal-title').textContent = 'Ajouter une étape';
    document.getElementById('step-titre').value = '';
    document.getElementById('step-desc').value = '';
  }
  gbOpenModal(m);
}
function editStep(i) { openStepModal(i); }
function removeStep(i) { steps.splice(i, 1); renderSteps(); }
document.getElementById('btn-add-step').addEventListener('click', () => openStepModal(-1));
document.getElementById('step-cancel').addEventListener('click', () => { gbCloseModal(document.getElementById('step-modal')); });
document.getElementById('step-save').addEventListener('click', () => {
  const t = document.getElementById('step-titre').value.trim();
  const d = document.getElementById('step-desc').value.trim();
  let stepOk = true;
  if (!t) { gbShowErr(document.getElementById('step-titre'), 'Le titre est requis'); stepOk=false; }
  else gbClearErr(document.getElementById('step-titre'));
  if (!d) { gbShowErr(document.getElementById('step-desc'), 'La description est requise'); stepOk=false; }
  else gbClearErr(document.getElementById('step-desc'));
  if (!stepOk) return;
  const idx = parseInt(document.getElementById('step-edit-index').value);
  if (idx >= 0) { steps[idx] = {titre:t, desc:d}; } else { steps.push({titre:t, desc:d}); }
  gbCloseModal(document.getElementById('step-modal'));
  renderSteps();
});

// ── Materiel chips ──
document.querySelectorAll('.materiel-chip').forEach(chip => {
  chip.addEventListener('click', () => {
    const cb = chip.querySelector('.mat-cb');
    cb.checked = !cb.checked;
    chip.style.background = cb.checked ? 'linear-gradient(135deg,#dcfce7,#f0fdf4)' : 'var(--muted)';
    chip.style.borderColor = cb.checked ? '#22c55e' : 'var(--border)';
    chip.style.color = cb.checked ? '#166534' : 'var(--text-secondary)';
  });
});

// ── Propose materiel modal ──
document.getElementById('btn-propose-materiel').addEventListener('click', () => {
  document.getElementById('mat-nom').value = '';
  document.getElementById('mat-desc').value = '';
  gbOpenModal(document.getElementById('mat-modal'));
});
document.getElementById('mat-cancel').addEventListener('click', () => { gbCloseModal(document.getElementById('mat-modal')); });
document.getElementById('mat-save').addEventListener('click', () => {
  const nom = document.getElementById('mat-nom').value.trim();
  if (!nom) { gbShowErr(document.getElementById('mat-nom'), 'Le nom du matériel est obligatoire'); return; }
  gbClearErr(document.getElementById('mat-nom'));
  const fd = new FormData();
  fd.append('nom', nom);
  fd.append('description', document.getElementById('mat-desc').value.trim());
  fd.append('propose_par', document.getElementById('soumis_par')?.value?.trim() || 'Anonyme');
  fetch('<?= BASE_URL ?>/?page=recettes&action=propose-materiel', {method:'POST', body:fd})
    .then(r => r.json()).then(d => {
      if (d.success) {
        const chip = document.createElement('label');
        chip.className = 'materiel-chip';
        chip.style.cssText = 'display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .85rem;border-radius:999px;border:1.5px dashed #f59e0b;cursor:default;font-size:.85rem;color:#92400e;background:#fef9c3;user-select:none;opacity:.8';
        chip.innerHTML = `<i data-lucide="clock" style="width:.75rem;height:.75rem"></i><span>${d.nom} (en attente)</span>`;
        document.getElementById('materiels-chips').appendChild(chip);
        if (typeof lucide !== 'undefined') lucide.createIcons();
        gbCloseModal(document.getElementById('mat-modal'));
        if(typeof showToast==='function') showToast('success','Matériel proposé — en attente de validation');
      }
    });
});

// ── Propose ingredient modal ──
document.getElementById('btn-propose-ingredient').addEventListener('click', () => {
  document.getElementById('ing-nom').value = '';
  document.getElementById('ing-cal').value = '';
  document.getElementById('ing-unite').value = 'g';
  gbOpenModal(document.getElementById('ing-modal'));
});
document.getElementById('ing-cancel').addEventListener('click', () => {
  gbCloseModal(document.getElementById('ing-modal'));
});
document.getElementById('ing-save').addEventListener('click', () => {
  const nom = document.getElementById('ing-nom').value.trim();
  if (!nom) { gbShowErr(document.getElementById('ing-nom'), 'Le nom de l\'ingrédient est obligatoire'); return; }
  gbClearErr(document.getElementById('ing-nom'));
  const fd = new FormData();
  fd.append('nom', nom);
  fd.append('unite', document.getElementById('ing-unite').value);
  fd.append('calories', document.getElementById('ing-cal').value || '0');
  fetch('<?= BASE_URL ?>/?page=recettes&action=propose-ingredient', {method:'POST', body:fd})
    .then(r => r.json()).then(d => {
      if (d.success) {
        // Add the new ingredient to ALL select dropdowns
        const optionText = d.nom + ' (' + d.unite + ')';
        document.querySelectorAll('#ingredients-container select[name="ingredient_ids[]"]').forEach(sel => {
          const opt = document.createElement('option');
          opt.value = d.id;
          opt.textContent = optionText;
          sel.appendChild(opt);
        });
        // Add a new ingredient row with this ingredient pre-selected
        const c = document.getElementById('ingredients-container');
        const row = c.querySelector('.ingredient-row').cloneNode(true);
        const sel = row.querySelector('select');
        // Also add to cloned row's select if not there
        let found = false;
        sel.querySelectorAll('option').forEach(o => { if(o.value == d.id) found = true; });
        if (!found) {
          const opt = document.createElement('option');
          opt.value = d.id; opt.textContent = optionText; sel.appendChild(opt);
        }
        sel.value = d.id;
        row.querySelector('input[type="number"]').value = '';
        const oldBadge = row.querySelector('.eco-score-badge');
        if (oldBadge) oldBadge.remove();
        c.appendChild(row);
        attachEcoScore(sel);
        if (typeof lucide !== 'undefined') lucide.createIcons();
        gbCloseModal(document.getElementById('ing-modal'));
        if(typeof showToast==='function') showToast('success', d.nom + ' créé et ajouté !');  
      } else {
        if(typeof showToast==='function') showToast('error', d.error || 'Erreur');
      }
    }).catch(() => {
      if(typeof showToast==='function') showToast('error', 'Erreur réseau');
    });
});

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
function showSectionError(sectionId, msg) {
  let el = document.getElementById(sectionId + '-error');
  if (!el) { el = document.createElement('div'); el.id = sectionId + '-error'; el.className = 'field-error'; document.getElementById(sectionId).after(el); }
  el.innerHTML = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> ` + msg;
  el.classList.add('show');
}
function clearSectionError(sectionId) {
  const el = document.getElementById(sectionId + '-error');
  if (el) el.classList.remove('show');
}

// Live blur validation
const spEl = document.getElementById('soumis_par');
const titreEl = document.getElementById('titre');
const tempsEl = document.getElementById('temps_preparation');
const diffEl  = document.getElementById('difficulte');

spEl?.addEventListener('blur', () => { const v=spEl.value.trim(); if(!v) showFE(spEl,"Votre nom est obligatoire."); else if(v.length<3) showFE(spEl,"Min. 3 caractères."); else clearFE(spEl); });
spEl?.addEventListener('input', () => { if(spEl.classList.contains('is-invalid') && spEl.value.trim().length>=3) clearFE(spEl); });

titreEl?.addEventListener('blur', () => { if(!titreEl.value.trim()) showFE(titreEl,"Le titre est obligatoire."); else clearFE(titreEl); });
titreEl?.addEventListener('input', () => { if(titreEl.classList.contains('is-invalid') && titreEl.value.trim()) clearFE(titreEl); });

tempsEl?.addEventListener('blur', () => { if(!tempsEl.value || parseInt(tempsEl.value)<=0) showFE(tempsEl,"Temps doit être > 0."); else clearFE(tempsEl); });
diffEl?.addEventListener('change', () => { if(!diffEl.value) showFE(diffEl,"Choisissez une difficulté."); else clearFE(diffEl); });

// ── Validation ──
document.getElementById('suggestForm').addEventListener('submit', function(e) {
  let valid = true;

  const sp = spEl?.value.trim() ?? '';
  if (!sp) { showFE(spEl,"Votre nom est obligatoire."); valid=false; }
  else if (sp.length<3) { showFE(spEl,"Min. 3 caractères."); valid=false; }
  else if(spEl) clearFE(spEl);

  const t = titreEl?.value.trim() ?? '';
  if (!t) { showFE(titreEl,"Le titre est obligatoire."); valid=false; }
  else if(titreEl) clearFE(titreEl);

  if (steps.length === 0) { showSectionError('steps-list',"Ajoutez au moins une étape de préparation."); valid=false; }
  else clearSectionError('steps-list');

  const temps = tempsEl?.value ?? '';
  if (!temps || parseInt(temps)<=0) { showFE(tempsEl,"Le temps de préparation doit être > 0."); valid=false; }
  else if(tempsEl) clearFE(tempsEl);

  if (!diffEl?.value) { showFE(diffEl,"La difficulté est obligatoire."); valid=false; }
  else if(diffEl) clearFE(diffEl);

  let hasIng = false;
  document.querySelectorAll('#ingredients-container .ingredient-row').forEach(row => {
    if (row.querySelector('select').value && parseFloat(row.querySelector('input[type="number"]').value) > 0) hasIng = true;
  });
  if (!hasIng) { showSectionError('ingredients-container',"Ajoutez au moins un ingrédient."); valid=false; }
  else clearSectionError('ingredients-container');

  if (!valid) e.preventDefault();
});
</script>


<script>
// ═══ TheMealDB Auto-fill: ings, steps, categorie, calories, co2, temps ═══
(async function() {
  const params = new URLSearchParams(window.location.search);
  const ingsRaw    = params.get('ings');
  const instrRaw   = params.get('instructions_full');
  const categorie  = params.get('categorie');
  const titre      = params.get('titre');

  // ── 1. Pre-fill simple text fields ──
  if (categorie) { var catEl = document.getElementById('categorie'); if(catEl && !catEl.value) catEl.value = categorie; }
  var tempsEl = document.getElementById('temps_preparation');
  if (tempsEl && !tempsEl.value) tempsEl.value = '30';
  var diffEl = document.getElementById('difficulte');
  if (diffEl && !diffEl.value) diffEl.value = 'moyen';

  // ── 2. Parse TheMealDB instructions → steps ──
  if (instrRaw && instrRaw.length > 10) {
    try {
      var instrText = decodeURIComponent(instrRaw);
      var parsedSteps = [];

      // Try splitting by numbered patterns: "1.", "Step 1", "\r\n1 "
      var numbered = instrText.split(/\r?\n(?=\s*(?:step\s*)?\d+[\.\)]\s)/i).filter(s => s.trim().length > 5);
      if (numbered.length >= 2) {
        numbered.forEach(function(chunk, idx) {
          var clean = chunk.replace(/^\s*(?:step\s*)?\d+[\.\)]\s*/i, '').trim();
          if (clean.length > 3) {
            parsedSteps.push({ titre: 'Étape ' + (idx+1), desc: clean.substring(0, 200) });
          }
        });
      } else {
        // Split by newlines or sentences
        var lines = instrText.split(/\r?\n/).filter(s => s.trim().length > 10);
        if (lines.length >= 2) {
          lines.slice(0, 8).forEach(function(line, idx) {
            parsedSteps.push({ titre: 'Étape ' + (idx+1), desc: line.trim().substring(0, 200) });
          });
        } else {
          // Split long text into 3-5 chunks by sentence
          var sentences = instrText.match(/[^.!?]+[.!?]+/g) || [];
          var chunkSize = Math.max(1, Math.ceil(sentences.length / 4));
          for (var s = 0; s < sentences.length; s += chunkSize) {
            var chunk = sentences.slice(s, s + chunkSize).join(' ').trim();
            if (chunk.length > 5) parsedSteps.push({ titre: 'Étape ' + (parsedSteps.length+1), desc: chunk.substring(0, 200) });
          }
        }
      }

      // Push into the steps array and render
      if (parsedSteps.length > 0 && steps.length === 0) {
        parsedSteps.slice(0, 8).forEach(function(s) { steps.push(s); });
        renderSteps();
      }
    } catch(e) { console.log('Steps parse error:', e); }
  }

  // ── 3. Auto-fill ingredients ──
  if (ingsRaw) {
    try {
      var ings = JSON.parse(ingsRaw);
      if (Array.isArray(ings) && ings.length > 0) {
        var container = document.getElementById('ingredients-container');
        var ingNames = []; // track for CO2 estimation

        for (var i = 0; i < ings.length; i++) {
          var ing = ings[i];
          if (!ing.nom) continue;
          ingNames.push(ing.nom.toLowerCase());

          // Try to find match in existing selects
          var firstRow = container.querySelector('.ingredient-row');
          var existingOptions = firstRow.querySelectorAll('select option');
          var matchId = null;
          existingOptions.forEach(function(opt) {
            if (opt.textContent.toLowerCase().includes(ing.nom.toLowerCase())) matchId = opt.value;
          });

          // Create if not found
          if (!matchId) {
            try {
              var fd = new FormData();
              fd.append('nom', ing.nom); fd.append('unite', 'g'); fd.append('calories', '0');
              var res = await fetch('<?= BASE_URL ?>/?page=recettes&action=propose-ingredient', {method:'POST', body:fd});
              var d = await res.json();
              if (d.success) {
                matchId = d.id;
                container.querySelectorAll('select[name="ingredient_ids[]"]').forEach(function(sel) {
                  var opt = document.createElement('option');
                  opt.value = d.id; opt.textContent = d.nom + ' (' + d.unite + ')'; sel.appendChild(opt);
                });
              }
            } catch(e) { /* skip */ }
          }
          if (!matchId) continue;

          // Parse qty
          var qty = 1, qm = (ing.qty || '').match(/[\d.]+/);
          if (qm) qty = parseFloat(qm[0]);
          if (qty <= 0) qty = 1;

          // Fill row
          var row;
          if (i === 0) { row = container.querySelector('.ingredient-row'); }
          else {
            row = container.querySelector('.ingredient-row').cloneNode(true);
            var ob = row.querySelector('.eco-score-badge'); if(ob) ob.remove();
            container.appendChild(row);
          }
          row.querySelector('select').value = matchId;
          row.querySelector('input[type="number"]').value = qty;
          if (typeof attachEcoScore === 'function') attachEcoScore(row.querySelector('select'));
        }
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // ── 4. Estimate CO2 from ingredient types ──
        var highCo2 = ['beef','lamb','pork','veal','duck','goose','bison','venison','mutton'];
        var medCo2  = ['chicken','turkey','fish','salmon','tuna','shrimp','prawn','egg','cheese','butter','cream','milk'];
        var score = 0.8; // base plant-based default
        ingNames.forEach(function(n) {
          highCo2.forEach(function(h) { if(n.includes(h)) score += 0.6; });
          medCo2.forEach(function(m) { if(n.includes(m)) score += 0.25; });
        });
        score = Math.min(8.0, parseFloat(score.toFixed(2)));
        var co2El = document.getElementById('score_carbone');
        if (co2El && (!co2El.value || co2El.value === '0')) co2El.value = score;
      }
    } catch(e) { console.log('Ingredient autofill error:', e); }
  }

  // ── 5. Auto-fill calories from Spoonacular, with fallback estimate ──
  if (titre) {
    try {
      var apiKey = '<?= SPOONACULAR_API_KEY ?>';
      var spRes = await fetch('<?= SPOONACULAR_BASE_URL ?>/recipes/guessNutrition?title=' + encodeURIComponent(titre) + '&apiKey=' + apiKey);
      if (spRes.ok) {
        var spData = await spRes.json();
        var cal = Math.round(spData.calories && spData.calories.value ? spData.calories.value : 0);
        if (cal > 0) {
          var calEl = document.getElementById('calories_total');
          if (calEl && (!calEl.value || calEl.value === '0')) calEl.value = cal;
        } else { estimateCalories(); }
      } else { estimateCalories(); }
    } catch(e) { estimateCalories(); }
  }

  // Fallback calorie estimator based on ingredient count & type
  function estimateCalories() {
    var calEl = document.getElementById('calories_total');
    if (!calEl || (calEl.value && calEl.value !== '0')) return;
    if (!ingsRaw) { calEl.value = 400; return; }
    try {
      var iList = JSON.parse(ingsRaw);
      var base = 150; // base kcal
      var highCal = ['beef','lamb','pork','butter','cream','cheese','bacon','oil'];
      var medCal  = ['chicken','fish','egg','rice','pasta','bread','potato'];
      iList.forEach(function(ing) {
        var n = (ing.nom||'').toLowerCase();
        highCal.forEach(function(h){ if(n.includes(h)) base += 80; });
        medCal.forEach(function(m){ if(n.includes(m)) base += 40; });
        base += 15; // base per ingredient
      });
      calEl.value = Math.min(base, 1200);
    } catch(e) { calEl.value = 400; }
  }
})();
</script>
