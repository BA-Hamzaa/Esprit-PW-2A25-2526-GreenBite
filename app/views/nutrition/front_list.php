<!-- Vue FrontOffice : Liste des repas du jour -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
        <i data-lucide="utensils-crossed" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Mon Suivi Nutritionnel</h1>
        <p class="text-sm" style="color:var(--text-muted)">Repas du <?= date('d/m/Y') ?></p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="btn btn-primary btn-round">
      <i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter un repas
    </a>
  </div>

  <?php if (empty($repas)): ?>
    <div class="card text-center" style="padding:4rem 2rem">
      <i data-lucide="utensils-crossed" style="width:3rem;height:3rem;color:var(--text-muted);display:inline-block;margin-bottom:1rem"></i>
      <h3 class="text-xl font-semibold mb-2" style="color:var(--primary)">Aucun repas aujourd'hui</h3>
      <p style="color:var(--text-secondary);margin-bottom:1.5rem">Commencez à suivre votre alimentation !</p>
      <a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="btn btn-primary btn-round"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter mon premier repas</a>
    </div>
  <?php else: ?>
    <?php
      $totalCal = 0; $totalP = 0; $totalG = 0; $totalL = 0;
      foreach ($repas as $r) {
        $totalCal += $r['calories_total'];
        if (!empty($r['aliments'])) {
          foreach ($r['aliments'] as $a) {
            $totalP += ($a['proteines'] * $a['quantite']) / 100;
            $totalG += ($a['glucides'] * $a['quantite']) / 100;
            $totalL += ($a['lipides'] * $a['quantite']) / 100;
          }
        }
      }
    ?>

    <!-- Résumé du jour -->
    <div class="grid grid-cols-4 gap-4 mb-6">
      <div class="card flex items-center gap-3" style="padding:1.25rem">
        <div style="width:2.75rem;height:2.75rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,var(--accent-orange),#F4845F);display:flex;align-items:center;justify-content:center">
          <i data-lucide="flame" style="width:1.25rem;height:1.25rem;color:white"></i>
        </div>
        <div><div class="text-xs" style="color:var(--text-muted)">Calories</div><div class="text-xl font-bold" style="color:var(--text-primary)"><?= $totalCal ?> kcal</div></div>
      </div>
      <div class="card flex items-center gap-3" style="padding:1.25rem">
        <div style="width:2.75rem;height:2.75rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center"><span style="color:white;font-weight:800;font-size:0.85rem">P</span></div>
        <div><div class="text-xs" style="color:var(--text-muted)">Protéines</div><div class="text-xl font-bold" style="color:var(--text-primary)"><?= round($totalP, 1) ?>g</div></div>
      </div>
      <div class="card flex items-center gap-3" style="padding:1.25rem">
        <div style="width:2.75rem;height:2.75rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,var(--secondary),#40916C);display:flex;align-items:center;justify-content:center"><span style="color:white;font-weight:800;font-size:0.85rem">G</span></div>
        <div><div class="text-xs" style="color:var(--text-muted)">Glucides</div><div class="text-xl font-bold" style="color:var(--text-primary)"><?= round($totalG, 1) ?>g</div></div>
      </div>
      <div class="card flex items-center gap-3" style="padding:1.25rem">
        <div style="width:2.75rem;height:2.75rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,var(--primary),#1B4332);display:flex;align-items:center;justify-content:center"><span style="color:white;font-weight:800;font-size:0.85rem">L</span></div>
        <div><div class="text-xs" style="color:var(--text-muted)">Lipides</div><div class="text-xl font-bold" style="color:var(--text-primary)"><?= round($totalL, 1) ?>g</div></div>
      </div>
    </div>

    <!-- Liste des repas -->
    <div class="space-y-4">
      <?php
        $typeIcons = ['petit_dejeuner' => 'sunrise', 'dejeuner' => 'sun', 'diner' => 'moon', 'collation' => 'coffee'];
        $typeLabels = ['petit_dejeuner' => 'Petit-déjeuner', 'dejeuner' => 'Déjeuner', 'diner' => 'Dîner', 'collation' => 'Collation'];
      ?>
      <?php foreach ($repas as $r): ?>
        <div class="card hover-shadow">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
              <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-lg)">
                <i data-lucide="<?= $typeIcons[$r['type_repas']] ?? 'utensils-crossed' ?>" style="width:1.125rem;height:1.125rem;color:var(--primary)"></i>
              </div>
              <div>
                <h3 class="font-semibold" style="color:var(--text-primary)"><?= htmlspecialchars($r['nom']) ?></h3>
                <span class="text-xs" style="color:var(--text-muted)"><?= $typeLabels[$r['type_repas']] ?? $r['type_repas'] ?></span>
              </div>
            </div>
            <div class="text-right">
              <div class="text-xl font-bold" style="color:var(--accent-orange)"><?= $r['calories_total'] ?></div>
              <div class="text-xs" style="color:var(--text-muted)">kcal</div>
            </div>
          </div>
          <?php if (!empty($r['aliments'])): ?>
            <div class="space-y-2">
              <?php foreach ($r['aliments'] as $a): ?>
                <div class="flex items-center justify-between p-3 rounded-xl" style="background:var(--muted);transition:all 0.2s" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
                  <div>
                    <span class="font-medium text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($a['nom']) ?></span>
                    <span class="text-xs ml-2" style="color:var(--text-muted)"><?= $a['quantite'] ?> <?= htmlspecialchars($a['unite']) ?></span>
                  </div>
                  <div class="flex gap-2">
                    <span class="badge badge-accent">P: <?= round($a['proteines'] * $a['quantite'] / 100, 1) ?>g</span>
                    <span class="badge badge-secondary">G: <?= round($a['glucides'] * $a['quantite'] / 100, 1) ?>g</span>
                    <span class="badge badge-primary">L: <?= round($a['lipides'] * $a['quantite'] / 100, 1) ?>g</span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
