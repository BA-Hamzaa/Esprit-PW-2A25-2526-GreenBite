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
        <div class="card card-interactive card-glow" style="padding:0;overflow:hidden;border:1px solid var(--border)">

          <!-- Image area -->
          <div style="height:11rem;background:linear-gradient(135deg,var(--muted),var(--border));position:relative;overflow:hidden">
            <?php if (!empty($r['image'])): ?>
              <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($r['image']) ?>"
                   alt="<?= htmlspecialchars($r['titre']) ?>"
                   style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s cubic-bezier(0.4,0,0.2,1)"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
            <?php else: ?>
              <div style="height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,rgba(82,183,136,0.08),rgba(45,106,79,0.06))">
                <i data-lucide="chef-hat" style="width:3rem;height:3rem;color:var(--text-muted)"></i>
              </div>
            <?php endif; ?>

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
</div>
