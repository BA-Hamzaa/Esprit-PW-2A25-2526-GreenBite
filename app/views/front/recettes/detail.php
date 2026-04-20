<!-- Vue FrontOffice : Détail d'une recette -->
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=recettes" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux recettes
  </a>

  <!-- En-tête -->
  <div class="card mb-6" style="overflow:hidden;padding:0">
    <?php if (!empty($recette['image'])): ?>
      <div style="height:16rem;overflow:hidden">
        <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($recette['image']) ?>" alt="<?= htmlspecialchars($recette['titre']) ?>" style="width:100%;height:100%;object-fit:cover">
      </div>
    <?php endif; ?>

    <div style="padding:2rem">
      <?php
        $diffBadges = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light'];
        $diffLabels = ['facile'=>'Facile','moyen'=>'Moyen','difficile'=>'Difficile'];
      ?>
      <div class="flex flex-wrap gap-2 mb-3">
        <span class="badge <?= $diffBadges[$recette['difficulte']] ?? 'badge-gray' ?>"><?= $diffLabels[$recette['difficulte']] ?? $recette['difficulte'] ?></span>
        <?php if (!empty($recette['categorie'])): ?><span class="badge badge-gray"><?= htmlspecialchars($recette['categorie']) ?></span><?php endif; ?>
        <?php if ($recette['score_carbone'] <= 1): ?><span class="badge badge-success"><i data-lucide="globe" style="width:0.6rem;height:0.6rem"></i> Low CO₂</span><?php endif; ?>
      </div>

      <h1 class="text-2xl font-bold mb-2" style="color:var(--text-primary);font-family:var(--font-heading)"><?= htmlspecialchars($recette['titre']) ?></h1>
      <p class="text-sm mb-4" style="color:var(--text-secondary);line-height:1.7"><?= htmlspecialchars($recette['description']) ?></p>

      <div class="flex flex-wrap gap-4 p-3 rounded-xl" style="background:var(--muted)">
        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary)"><i data-lucide="clock" style="width:0.875rem;height:0.875rem;color:var(--primary)"></i><span class="font-medium"><?= $recette['temps_preparation'] ?> min</span></div>
        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary)"><i data-lucide="flame" style="width:0.875rem;height:0.875rem;color:var(--accent-orange)"></i><span class="font-medium"><?= $recette['calories_total'] ?> kcal</span></div>
        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary)"><i data-lucide="leaf" style="width:0.875rem;height:0.875rem;color:var(--secondary)"></i><span class="font-medium">Score: <?= $recette['score_carbone'] ?></span></div>
      </div>
    </div>
  </div>

  <div class="grid gap-6" style="grid-template-columns:1fr 1.5fr">
    <!-- Ingrédients -->
    <div class="card">
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="carrot" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Ingrédients</h2>
      <div class="space-y-2">
        <?php foreach ($ingredients as $i): ?>
          <div class="flex items-center justify-between p-2 rounded-xl" style="background:var(--muted);transition:all 0.2s" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
            <div>
              <span class="font-medium text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($i['nom']) ?></span>
              <?php if ($i['is_local']): ?><span class="text-xs ml-1" style="color:var(--secondary)"><i data-lucide="map-pin" style="width:0.6rem;height:0.6rem;display:inline"></i> Local</span><?php endif; ?>
            </div>
            <span class="text-sm" style="color:var(--text-muted)"><?= $i['quantite'] ?> <?= htmlspecialchars($i['unite']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Instructions -->
    <div class="card">
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="chef-hat" style="width:1rem;height:1rem;color:var(--primary)"></i> Instructions</h2>
      <div style="color:var(--text-secondary);line-height:1.8;white-space:pre-line;font-size:0.9rem"><?= htmlspecialchars($recette['instructions']) ?></div>
    </div>
  </div>
</div>
