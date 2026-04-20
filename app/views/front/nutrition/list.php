<!-- Vue FrontOffice : Liste des repas du jour -->
<div style="padding:2rem;position:relative">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.18);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="utensils-crossed" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Mon Suivi Nutritionnel
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i>
          Repas du <?= date('d/m/Y') ?>
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="btn btn-primary" style="border-radius:var(--radius-full)">
      <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Ajouter un repas
    </a>
  </div>

  <?php if (empty($repas)): ?>
    <!-- Empty state -->
    <div class="card" style="padding:5rem 2rem;text-align:center;background:linear-gradient(135deg,rgba(82,183,136,0.04),rgba(45,106,79,0.02))">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5.5rem;height:5.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.5rem;box-shadow:0 8px 24px rgba(45,106,79,0.12);animation:float 3s ease-in-out infinite">
        <i data-lucide="utensils-crossed" style="width:2.75rem;height:2.75rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.375rem;font-weight:800;color:var(--primary);margin-bottom:0.625rem">Aucun repas aujourd'hui</h3>
      <p style="color:var(--text-secondary);margin-bottom:2rem;max-width:22rem;margin-left:auto;margin-right:auto;line-height:1.65">Commencez à suivre votre alimentation pour atteindre vos objectifs nutritionnels ! 🌿</p>
      <a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter mon premier repas
      </a>
    </div>
  <?php else: ?>
    <?php
      $totalCal = 0; $totalP = 0; $totalG = 0; $totalL = 0;
      foreach ($repas as $r) {
        $totalCal += $r['calories_total'];
        if (!empty($r['aliments'])) {
          foreach ($r['aliments'] as $a) {
            $totalP += ($a['proteines'] * $a['quantite']) / 100;
            $totalG += ($a['glucides']  * $a['quantite']) / 100;
            $totalL += ($a['lipides']   * $a['quantite']) / 100;
          }
        }
      }
      $calorieGoal = 2000;
      $pct = min(100, round(($totalCal / $calorieGoal) * 100));
    ?>

    <!-- ===== Macro Summary Cards ===== -->
    <div class="grid grid-cols-4 gap-4 mb-6">

      <!-- Calories -->
      <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#fff7ed,#fff)">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent-orange),#f97316)"></div>
        <div style="position:absolute;bottom:-20px;right:-20px;width:90px;height:90px;background:radial-gradient(circle,rgba(231,111,81,0.08) 0%,transparent 70%);border-radius:50%"></div>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.875rem">
          <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:linear-gradient(135deg,var(--accent-orange),#f97316);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(231,111,81,0.3)">
            <i data-lucide="flame" style="width:1.25rem;height:1.25rem;color:white"></i>
          </div>
          <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Calories</span>
        </div>
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1"><?= $totalCal ?></div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">kcal / <?= $calorieGoal ?> objectif</div>
        <div style="margin-top:0.75rem">
          <div class="progress" style="height:5px">
            <div class="progress-bar" style="width:<?= $pct ?>%;background:linear-gradient(90deg,var(--accent-orange),#f97316)"></div>
          </div>
          <div style="font-size:0.68rem;color:var(--text-muted);margin-top:3px;text-align:right"><?= $pct ?>%</div>
        </div>
      </div>

      <!-- Protéines -->
      <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#fef2f2,#fff)">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#ef4444,#dc2626)"></div>
        <div style="position:absolute;bottom:-20px;right:-20px;width:90px;height:90px;background:radial-gradient(circle,rgba(239,68,68,0.07) 0%,transparent 70%);border-radius:50%"></div>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.875rem">
          <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(239,68,68,0.25);color:#fff;font-weight:900;font-size:1rem">P</div>
          <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Protéines</span>
        </div>
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1"><?= round($totalP, 1) ?>g</div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">Muscle & récupération</div>
      </div>

      <!-- Glucides -->
      <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#f0fdf4,#fff)">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--secondary),#40916C)"></div>
        <div style="position:absolute;bottom:-20px;right:-20px;width:90px;height:90px;background:radial-gradient(circle,rgba(82,183,136,0.08) 0%,transparent 70%);border-radius:50%"></div>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.875rem">
          <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:linear-gradient(135deg,var(--secondary),#40916C);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(82,183,136,0.25);color:#fff;font-weight:900;font-size:1rem">G</div>
          <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Glucides</span>
        </div>
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1"><?= round($totalG, 1) ?>g</div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">Énergie & endurance</div>
      </div>

      <!-- Lipides -->
      <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#f0fdf4,#fff)">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--primary),#1B4332)"></div>
        <div style="position:absolute;bottom:-20px;right:-20px;width:90px;height:90px;background:radial-gradient(circle,rgba(45,106,79,0.08) 0%,transparent 70%);border-radius:50%"></div>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.875rem">
          <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:linear-gradient(135deg,var(--primary),#1B4332);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(45,106,79,0.25);color:#fff;font-weight:900;font-size:1rem">L</div>
          <span style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Lipides</span>
        </div>
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1"><?= round($totalL, 1) ?>g</div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">Santé cellulaire</div>
      </div>
    </div>

    <!-- ===== Meal Cards ===== -->
    <div style="display:flex;flex-direction:column;gap:1rem">
      <?php
        $typeIcons  = ['petit_dejeuner'=>'sunrise','dejeuner'=>'sun','diner'=>'moon','collation'=>'coffee'];
        $typeLabels = ['petit_dejeuner'=>'Petit-déjeuner','dejeuner'=>'Déjeuner','diner'=>'Dîner','collation'=>'Collation'];
        $typeColors = ['petit_dejeuner'=>'#f59e0b','dejeuner'=>'#3b82f6','diner'=>'#8b5cf6','collation'=>'#ec4899'];
        $typeBgs    = ['petit_dejeuner'=>'rgba(245,158,11,0.08)','dejeuner'=>'rgba(59,130,246,0.07)','diner'=>'rgba(139,92,246,0.07)','collation'=>'rgba(236,72,153,0.07)'];
      ?>
      <?php foreach ($repas as $r): ?>
        <?php
          $ico   = $typeIcons[$r['type_repas']]  ?? 'utensils-crossed';
          $lbl   = $typeLabels[$r['type_repas']] ?? $r['type_repas'];
          $col   = $typeColors[$r['type_repas']] ?? 'var(--primary)';
          $bg    = $typeBgs[$r['type_repas']]    ?? 'rgba(45,106,79,0.06)';
        ?>
        <div class="card" style="padding:1.25rem;border:1px solid var(--border);transition:all 0.3s" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='none';this.style.boxShadow=''">

          <!-- Meal header -->
          <div class="flex items-center justify-between" style="margin-bottom:<?= !empty($r['aliments']) ? '1rem' : '0' ?>">
            <div class="flex items-center gap-3">
              <div style="display:flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:<?= $bg ?>;border-radius:0.875rem;border:1px solid <?= $col ?>22;flex-shrink:0">
                <i data-lucide="<?= $ico ?>" style="width:1.25rem;height:1.25rem;color:<?= $col ?>"></i>
              </div>
              <div>
                <h3 style="font-family:var(--font-heading);font-weight:700;color:var(--text-primary);font-size:0.95rem"><?= htmlspecialchars($r['nom']) ?></h3>
                <span style="font-size:0.72rem;color:<?= $col ?>;font-weight:600;background:<?= $bg ?>;padding:0.15rem 0.5rem;border-radius:var(--radius-full)"><?= $lbl ?></span>
              </div>
            </div>
            <div style="text-align:right">
              <div style="font-family:var(--font-heading);font-size:1.5rem;font-weight:900;color:var(--accent-orange);line-height:1"><?= $r['calories_total'] ?></div>
              <div style="font-size:0.7rem;color:var(--text-muted);font-weight:500">kcal</div>
            </div>
          </div>

          <!-- Food items -->
          <?php if (!empty($r['aliments'])): ?>
            <div style="display:flex;flex-direction:column;gap:0.4rem;padding-top:0.75rem;border-top:1px solid var(--border)">
              <?php foreach ($r['aliments'] as $a): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0.875rem;background:var(--muted);border-radius:var(--radius-xl);transition:all 0.2s" onmouseover="this.style.transform='translateX(4px)';this.style.background='rgba(82,183,136,0.06)'" onmouseout="this.style.transform='translateX(0)';this.style.background='var(--muted)'">
                  <div style="display:flex;align-items:center;gap:0.5rem">
                    <div style="width:6px;height:6px;border-radius:50%;background:var(--secondary);flex-shrink:0"></div>
                    <span style="font-size:0.82rem;font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($a['nom']) ?></span>
                    <span style="font-size:0.72rem;color:var(--text-muted)"><?= $a['quantite'] ?> <?= htmlspecialchars($a['unite']) ?></span>
                  </div>
                  <div style="display:flex;gap:0.3rem;align-items:center">
                    <span style="padding:0.15rem 0.5rem;background:rgba(231,111,81,0.1);color:var(--accent-orange);border-radius:var(--radius-full);font-size:0.65rem;font-weight:700">P:<?= round($a['proteines'] * $a['quantite'] / 100, 1) ?>g</span>
                    <span style="padding:0.15rem 0.5rem;background:rgba(82,183,136,0.1);color:var(--secondary);border-radius:var(--radius-full);font-size:0.65rem;font-weight:700">G:<?= round($a['glucides'] * $a['quantite'] / 100, 1) ?>g</span>
                    <span style="padding:0.15rem 0.5rem;background:rgba(45,106,79,0.1);color:var(--primary);border-radius:var(--radius-full);font-size:0.65rem;font-weight:700">L:<?= round($a['lipides'] * $a['quantite'] / 100, 1) ?>g</span>
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
