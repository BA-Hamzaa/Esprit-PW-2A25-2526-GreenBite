<!-- Vue FrontOffice : Liste des recettes -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fee2e2,#fef2f2);border-radius:var(--radius-xl)">
        <i data-lucide="book-open" style="width:1.5rem;height:1.5rem;color:#E76F51"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Recettes Durables</h1>
        <p class="text-sm" style="color:var(--text-muted)">Recettes saines et écoresponsables</p>
      </div>
    </div>
  </div>

  <!-- Filtres -->
  <div class="card mb-6" style="padding:1.25rem">
    <form novalidate method="GET" class="flex flex-wrap gap-4 items-end">
      <input type="hidden" name="page" value="recettes">
      <div>
        <label class="form-label"><i data-lucide="gauge" style="width:0.75rem;height:0.75rem"></i> Difficulté</label>
        <select name="difficulte" class="form-input">
          <option value="">Toutes</option>
          <option value="facile" <?= $difficulte === 'facile' ? 'selected' : '' ?>>🟢 Facile</option>
          <option value="moyen" <?= $difficulte === 'moyen' ? 'selected' : '' ?>>🟡 Moyen</option>
          <option value="difficile" <?= $difficulte === 'difficile' ? 'selected' : '' ?>>🔴 Difficile</option>
        </select>
      </div>
      <div>
        <label class="form-label"><i data-lucide="tag" style="width:0.75rem;height:0.75rem"></i> Catégorie</label>
        <select name="categorie" class="form-input">
          <option value="">Toutes</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="filter" style="width:0.75rem;height:0.75rem"></i> Filtrer</button>
      <a href="<?= BASE_URL ?>/?page=recettes" class="btn btn-outline btn-sm"><i data-lucide="x" style="width:0.75rem;height:0.75rem"></i></a>
    </form>
  </div>

  <!-- Grille recettes -->
  <?php if (empty($recettes)): ?>
    <div class="card text-center" style="padding:4rem 2rem">
      <i data-lucide="book-x" style="width:3rem;height:3rem;color:var(--text-muted);display:inline-block;margin-bottom:1rem"></i>
      <h3 class="text-xl font-semibold mb-2" style="color:var(--primary)">Aucune recette trouvée</h3>
      <p style="color:var(--text-secondary)">Modifiez vos filtres.</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-6">
      <?php
        $diffBadges = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light'];
        $diffLabels = ['facile'=>'Facile','moyen'=>'Moyen','difficile'=>'Difficile'];
      ?>
      <?php foreach ($recettes as $r): ?>
        <div class="card hover-shadow card-interactive" style="padding:0;overflow:hidden;border:none">
          <div style="height:10rem;background:var(--muted);position:relative;overflow:hidden">
            <?php if (!empty($r['image'])): ?>
              <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($r['image']) ?>" alt="<?= htmlspecialchars($r['titre']) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            <?php else: ?>
              <div class="flex items-center justify-center" style="height:100%"><i data-lucide="chef-hat" style="width:2.5rem;height:2.5rem;color:var(--text-muted)"></i></div>
            <?php endif; ?>
            <div class="absolute flex gap-1" style="top:0.5rem;left:0.5rem">
              <span class="badge <?= $diffBadges[$r['difficulte']] ?? 'badge-gray' ?>"><?= $diffLabels[$r['difficulte']] ?? $r['difficulte'] ?></span>
            </div>
            <?php if ($r['score_carbone'] <= 1): ?>
              <div class="absolute" style="top:0.5rem;right:0.5rem"><span class="badge badge-success"><i data-lucide="globe" style="width:0.6rem;height:0.6rem"></i> Low CO₂</span></div>
            <?php endif; ?>
          </div>
          <div style="padding:1rem">
            <h3 class="font-semibold mb-1" style="color:var(--primary);font-family:var(--font-heading)"><?= htmlspecialchars($r['titre']) ?></h3>
            <p class="text-xs mb-3 truncate" style="color:var(--text-muted)"><?= htmlspecialchars($r['description']) ?></p>
            <div class="flex items-center gap-3 text-xs mb-3" style="color:var(--text-secondary)">
              <span class="flex items-center gap-1"><i data-lucide="clock" style="width:0.7rem;height:0.7rem"></i> <?= $r['temps_preparation'] ?> min</span>
              <span class="flex items-center gap-1"><i data-lucide="flame" style="width:0.7rem;height:0.7rem"></i> <?= $r['calories_total'] ?> kcal</span>
            </div>
            <div class="flex items-center justify-between pt-3" style="border-top:1px solid var(--border)">
              <?php if (!empty($r['categorie'])): ?><span class="badge badge-gray"><?= htmlspecialchars($r['categorie']) ?></span><?php else: ?><span></span><?php endif; ?>
              <a href="<?= BASE_URL ?>/?page=recettes&action=detail&id=<?= $r['id'] ?>" class="btn btn-secondary btn-sm" style="padding:0.35rem 0.75rem;font-size:0.75rem"><i data-lucide="eye" style="width:0.75rem;height:0.75rem"></i> Voir</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
