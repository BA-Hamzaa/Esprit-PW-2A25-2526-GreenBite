<!-- Vue FrontOffice : Liste des recettes -->
<div style="padding:2rem;position:relative">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#fee2e2,#fef2f2);border-radius:1rem;box-shadow:0 6px 18px rgba(231,111,81,0.2);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="book-open" style="width:1.625rem;height:1.625rem;color:var(--accent-orange)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--accent-orange),#f97316);border-radius:2px"></span>
          Recettes Durables
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="leaf" style="width:0.75rem;height:0.75rem;color:var(--secondary)"></i>
          Recettes saines & écoresponsables
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=recettes&action=suggest"
       class="btn btn-sm"
       style="background:linear-gradient(135deg,#d97706,#f59e0b);border:none;color:#fff;font-weight:700;border-radius:var(--radius-full);box-shadow:0 4px 16px rgba(217,119,6,0.35);transition:all 0.3s"
       onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(217,119,6,0.45)'"
       onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(217,119,6,0.35)'">
      <i data-lucide="lightbulb" style="width:0.875rem;height:0.875rem"></i>
      Proposer une recette
    </a>
  </div>

  <!-- Filter Card -->
  <div class="card mb-6" style="padding:1.25rem;border:1px solid rgba(231,111,81,0.12);background:linear-gradient(135deg,rgba(254,226,226,0.3),rgba(255,255,255,0))">
    <form novalidate method="GET" style="display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-end">
      <input type="hidden" name="page" value="recettes">

      <div style="flex:1;min-width:140px">
        <label class="form-label" style="color:var(--accent-orange)">
          <i data-lucide="gauge" style="width:0.75rem;height:0.75rem"></i> Difficulté
        </label>
        <select name="difficulte" class="form-select" style="width:100%;border-radius:var(--radius-xl)">
          <option value="">Toutes les niveaux</option>
          <option value="facile" <?= $difficulte === 'facile' ? 'selected' : '' ?>>🟢 Facile</option>
          <option value="moyen" <?= $difficulte === 'moyen' ? 'selected' : '' ?>>🟡 Moyen</option>
          <option value="difficile" <?= $difficulte === 'difficile' ? 'selected' : '' ?>>🔴 Difficile</option>
        </select>
      </div>

      <div style="flex:1;min-width:140px">
        <label class="form-label" style="color:var(--accent-orange)">
          <i data-lucide="tag" style="width:0.75rem;height:0.75rem"></i> Catégorie
        </label>
        <select name="categorie" class="form-select" style="width:100%;border-radius:var(--radius-xl)">
          <option value="">Toutes les catégories</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="display:flex;gap:0.5rem;align-items:flex-end">
        <button type="submit" class="btn btn-sm" style="background:linear-gradient(135deg,var(--accent-orange),#f97316);color:#fff;border:none;border-radius:var(--radius-full);box-shadow:0 4px 12px rgba(231,111,81,0.25)">
          <i data-lucide="filter" style="width:0.75rem;height:0.75rem"></i> Filtrer
        </button>
        <a href="<?= BASE_URL ?>/?page=recettes" class="btn btn-outline btn-sm" style="border-radius:var(--radius-full)" title="Réinitialiser">
          <i data-lucide="x" style="width:0.75rem;height:0.75rem"></i>
        </a>
      </div>
    </form>
  </div>

  <!-- Recettes Grid -->
  <?php if (empty($recettes)): ?>
    <div class="card" style="padding:4rem 2rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5rem;height:5rem;background:linear-gradient(135deg,#fee2e2,#fef2f2);border-radius:50%;margin-bottom:1.25rem">
        <i data-lucide="book-x" style="width:2.5rem;height:2.5rem;color:var(--accent-orange)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.25rem;font-weight:700;color:var(--primary);margin-bottom:0.5rem">Aucune recette trouvée</h3>
      <p style="color:var(--text-secondary)">Essayez de modifier vos filtres ou proposez une nouvelle recette.</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-6">
      <?php
        $diffBadges = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light'];
        $diffLabels = ['facile'=>'Facile','moyen'=>'Moyen','difficile'=>'Difficile'];
        $diffColors = ['facile'=>'#16a34a','moyen'=>'#d97706','difficile'=>'#dc2626'];
      ?>
      <?php foreach ($recettes as $r): ?>
        <?php $recipePhoto = MediaHelper::url($r['image'] ?? '', MediaHelper::fallbackRecette($r['categorie'] ?? '')); ?>
        <div class="card card-interactive card-glow" style="padding:0;overflow:hidden;border:1px solid var(--border)">

          <!-- Image area (upload local ou photo de repli si fichier seed absent) -->
          <div style="height:11rem;background:linear-gradient(135deg,var(--muted),var(--border));position:relative;overflow:hidden">
            <img src="<?= htmlspecialchars($recipePhoto) ?>"
                 alt="<?= htmlspecialchars($r['titre']) ?>"
                 loading="lazy" decoding="async"
                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s cubic-bezier(0.4,0,0.2,1)"
                 onmouseover="this.style.transform='scale(1.06)'"
                 onmouseout="this.style.transform='scale(1)'">

            <!-- Overlay gradient -->
            <div style="position:absolute;bottom:0;left:0;right:0;height:3.5rem;background:linear-gradient(transparent,rgba(0,0,0,0.4))"></div>

            <!-- Badges -->
            <div style="position:absolute;top:0.625rem;left:0.625rem;display:flex;gap:0.35rem">
              <span class="badge <?= $diffBadges[$r['difficulte']] ?? 'badge-gray' ?>" style="backdrop-filter:blur(6px);font-size:0.6rem">
                <?= $diffLabels[$r['difficulte']] ?? $r['difficulte'] ?>
              </span>
            </div>
            <?php if ($r['score_carbone'] <= 1): ?>
              <div style="position:absolute;top:0.625rem;right:0.625rem">
                <span class="badge badge-success" style="backdrop-filter:blur(6px);font-size:0.6rem">
                  <i data-lucide="globe" style="width:0.55rem;height:0.55rem"></i> Eco
                </span>
              </div>
            <?php endif; ?>

            <!-- Time on image -->
            <div style="position:absolute;bottom:0.5rem;right:0.625rem;display:flex;align-items:center;gap:0.25rem;color:rgba(255,255,255,0.9);font-size:0.72rem;font-weight:600">
              <i data-lucide="clock" style="width:0.7rem;height:0.7rem"></i>
              <?= $r['temps_preparation'] ?>min
            </div>
          </div>

          <!-- Card body -->
          <div style="padding:1rem">
            <h3 style="font-family:var(--font-heading);font-weight:700;color:var(--text-primary);margin-bottom:0.3rem;font-size:0.95rem;line-height:1.3"><?= htmlspecialchars($r['titre']) ?></h3>
            <p style="font-size:0.78rem;color:var(--text-muted);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;margin-bottom:0.75rem"><?= htmlspecialchars($r['description']) ?></p>

            <!-- Nutrition pills -->
            <div style="display:flex;align-items:center;gap:0.4rem;margin-bottom:0.875rem;flex-wrap:wrap">
              <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.5rem;background:rgba(231,111,81,0.08);color:var(--accent-orange);border-radius:var(--radius-full);font-size:0.7rem;font-weight:600;border:1px solid rgba(231,111,81,0.15)">
                <i data-lucide="flame" style="width:0.6rem;height:0.6rem"></i> <?= $r['calories_total'] ?> kcal
              </span>
              <?php if (!empty($r['categorie'])): ?>
                <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.5rem;background:rgba(82,183,136,0.08);color:var(--secondary);border-radius:var(--radius-full);font-size:0.7rem;font-weight:600;border:1px solid rgba(82,183,136,0.15)">
                  <i data-lucide="tag" style="width:0.6rem;height:0.6rem"></i> <?= htmlspecialchars($r['categorie']) ?>
                </span>
              <?php endif; ?>
            </div>

            <!-- Action footer -->
            <div style="display:flex;align-items:center;justify-content:space-between;padding-top:0.75rem;border-top:1px solid var(--border)">
              <div style="display:flex;align-items:center;gap:0.35rem">
                <div style="width:6px;height:6px;border-radius:50%;background:<?= $diffColors[$r['difficulte']] ?? 'var(--primary)' ?>"></div>
                <span style="font-size:0.72rem;color:var(--text-muted);font-weight:500"><?= $diffLabels[$r['difficulte']] ?? $r['difficulte'] ?></span>
              </div>
              <a href="<?= BASE_URL ?>/?page=recettes&action=detail&id=<?= $r['id'] ?>"
                 class="btn btn-sm"
                 style="background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border:none;border-radius:var(--radius-full);padding:0.3rem 0.875rem;font-size:0.75rem;box-shadow:0 3px 10px rgba(45,106,79,0.25)">
                <i data-lucide="eye" style="width:0.7rem;height:0.7rem"></i> Voir
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- --- API 2: TheMealDB — Inspiration du Jour --- -->
  <div id="inspiration-widget" class="card mt-8" style="padding:0;overflow:hidden;border:2px solid rgba(82,183,136,0.2);background:linear-gradient(135deg,rgba(82,183,136,0.04),rgba(45,106,79,0.02))">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;border-bottom:1px solid rgba(82,183,136,0.12);background:linear-gradient(135deg,rgba(82,183,136,0.08),transparent)">
      <div class="flex items-center gap-3">
        <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#dcfce7,#f0fdf4);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(34,197,94,0.2)">
          <i data-lucide="sparkles" style="width:1.25rem;height:1.25rem;color:#16a34a"></i>
        </div>
        <div>
          <h2 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--text-primary)">💡 Inspiration du Jour</h2>
          <p style="font-size:0.72rem;color:var(--text-muted)">Via TheMealDB · Recette internationale du moment</p>
        </div>
      </div>
      <button id="refresh-inspiration" onclick="loadInspiration()" style="display:flex;align-items:center;gap:0.4rem;padding:0.45rem 0.9rem;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.75rem;font-weight:600;cursor:pointer;box-shadow:0 3px 10px rgba(22,163,74,0.3);transition:all 0.2s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='none'">
        <i data-lucide="refresh-cw" style="width:0.75rem;height:0.75rem"></i> Nouvelle recette
      </button>
    </div>
    <div id="inspiration-body" style="padding:1.5rem">
      <div id="inspiration-loading" style="text-align:center;padding:2rem;color:var(--text-muted)">
        <div style="width:2rem;height:2rem;border:3px solid var(--border);border-top-color:#16a34a;border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 0.75rem"></div>
        <p style="font-size:0.85rem">Chargement de l'inspiration...</p>
      </div>
      <div id="inspiration-content" style="display:none"></div>
    </div>
  </div>

</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
.eco-badge { display:inline-flex;align-items:center;gap:0.25rem;padding:0.15rem 0.45rem;border-radius:var(--radius-full);font-size:0.65rem;font-weight:700;letter-spacing:0.03em;margin-left:0.4rem;vertical-align:middle }
.eco-a { background:#dcfce7;color:#15803d;border:1px solid #86efac }
.eco-b { background:#d1fae5;color:#065f46;border:1px solid #6ee7b7 }
.eco-c { background:#fef9c3;color:#854d0e;border:1px solid #fde047 }
.eco-d { background:#ffedd5;color:#9a3412;border:1px solid #fdba74 }
.eco-e { background:#fee2e2;color:#991b1b;border:1px solid #fca5a5 }
</style>

<script>
// === API 2: TheMealDB - Inspiration du Jour ===
async function loadInspiration() {
  var loading = document.getElementById('inspiration-loading');
  var content = document.getElementById('inspiration-content');
  var btn = document.getElementById('refresh-inspiration');
  loading.style.display = 'block'; content.style.display = 'none';
  btn.disabled = true; btn.style.opacity = '0.7';
  var controller = new AbortController();
  var timer = setTimeout(function(){ controller.abort(); }, 8000);
  try {
    var res = await fetch('https://www.themealdb.com/api/json/v1/1/random.php', { signal: controller.signal });
    clearTimeout(timer);
    if (!res.ok) throw new Error('HTTP ' + res.status);
    var data = await res.json();
    var m = data.meals[0];
    var ings = [];
    for (var i = 1; i <= 20; i++) {
      if (m['strIngredient'+i] && m['strIngredient'+i].trim()) ings.push(m['strIngredient'+i]);
    }
    var ingHtml = ings.slice(0,8).map(function(x){ return '<span style="padding:0.2rem 0.55rem;background:var(--muted);color:var(--text-secondary);border-radius:var(--radius-full);font-size:0.7rem;border:1px solid var(--border)">'+x+'</span>'; }).join('');
    if (ings.length > 8) ingHtml += '<span style="padding:0.2rem 0.55rem;color:var(--text-muted);font-size:0.7rem">+' + (ings.length-8) + ' autres</span>';
    var instr = (m.strInstructions || '').substring(0,200);
    content.innerHTML =
      '<div style="display:grid;grid-template-columns:200px 1fr;gap:1.5rem;align-items:start">' +
        '<div style="position:relative">' +
          '<img src="' + m.strMealThumb + '" alt="' + m.strMeal + '" style="width:100%;border-radius:var(--radius-xl);object-fit:cover;aspect-ratio:1;box-shadow:0 8px 24px rgba(0,0,0,0.12)" onerror="this.style.background=\'var(--muted)\'">' +
          '<span style="position:absolute;top:0.5rem;left:0.5rem;background:rgba(0,0,0,0.6);color:#fff;font-size:0.65rem;font-weight:600;padding:0.2rem 0.5rem;border-radius:999px">' + (m.strArea||'') + '</span>' +
        '</div>' +
        '<div>' +
          '<div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;flex-wrap:wrap">' +
            '<h3 style="font-family:var(--font-heading);font-weight:800;font-size:1.1rem;color:var(--text-primary)">' + m.strMeal + '</h3>' +
            '<span style="background:rgba(82,183,136,0.12);color:var(--secondary);font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:999px;border:1px solid rgba(82,183,136,0.2)">' + m.strCategory + '</span>' +
          '</div>' +
          '<p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;margin-bottom:0.875rem">' + instr + '...</p>' +
          '<div style="margin-bottom:1rem">' +
            '<p style="font-size:0.72rem;font-weight:600;color:var(--text-muted);margin-bottom:0.4rem">Ingredients cles</p>' +
            '<div style="display:flex;flex-wrap:wrap;gap:0.35rem">' + ingHtml + '</div>' +
          '</div>' +
          (function(){var ingData=[];for(var j=1;j<=20;j++){if(m['strIngredient'+j]&&m['strIngredient'+j].trim())ingData.push({nom:m['strIngredient'+j].trim(),qty:(m['strMeasure'+j]||'').trim()});}var propUrl='<?= BASE_URL ?>/?page=recettes&action=suggest'+'&titre='+encodeURIComponent(m.strMeal)+'&description='+encodeURIComponent((m.strInstructions||'').substring(0,150))+'&categorie='+encodeURIComponent(m.strCategory||'')+'&ings='+encodeURIComponent(JSON.stringify(ingData))+'&instructions_full='+encodeURIComponent(m.strInstructions||'')+'&image_url='+encodeURIComponent(m.strMealThumb||'');return '<a href="'+propUrl+'" style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 1.1rem;background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;border-radius:999px;font-size:0.78rem;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(217,119,6,0.3)">Proposer cette recette</a>';}()) +
        '</div>' +
      '</div>';
    loading.style.display = 'none'; content.style.display = 'block';
  } catch(err) {
    clearTimeout(timer);
    loading.style.display = 'block';
    loading.innerHTML = '<p style="color:var(--text-muted);font-size:0.85rem">Erreur de chargement - <button onclick="loadInspiration()" style="color:var(--secondary);font-weight:600;background:none;border:none;cursor:pointer;text-decoration:underline">Reessayer</button></p>';
    content.style.display = 'none';
  }
  btn.disabled = false; btn.style.opacity = '1';
}
loadInspiration();
</script>