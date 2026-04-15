<!-- Vue FrontOffice : Détail d'un Plan Nutritionnel -->
<div style="padding:2rem;max-width:64rem;margin:0 auto">
  <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux plans
  </a>

  <!-- Header du Plan -->
  <div class="card mb-8" style="background:linear-gradient(135deg,var(--primary),#1B4332);color:white;border:none;padding:3rem 2rem;position:relative;overflow:hidden">
    <div style="position:absolute;top:-50px;right:-50px;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%;filter:blur(30px)"></div>
    <div class="flex items-start justify-between relative z-10">
      <div>
        <div class="flex items-center gap-3 mb-2">
          <span style="padding:0.25rem 0.75rem;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em"><?= str_replace('_', ' ', $plan['type_objectif']) ?></span>
          <span style="font-size:0.875rem;color:rgba(255,255,255,0.7)"><i data-lucide="calendar" style="width:1rem;height:1rem;display:inline;margin-bottom:-2px"></i> Du <?= date('d/m/Y', strtotime($plan['date_debut'])) ?> (<?= $plan['duree_jours'] ?> jours)</span>
        </div>
        <h1 class="text-4xl font-bold mb-3" style="font-family:var(--font-heading)"><?= htmlspecialchars($plan['nom']) ?></h1>
        <p style="color:rgba(255,255,255,0.8);max-width:80%"><?= nl2br(htmlspecialchars($plan['description'] ?? 'Aucune description fournie.')) ?></p>
      </div>
      <div style="text-align:right">
        <div style="font-size:3rem;font-weight:800;line-height:1;color:#fcd34d"><?= $plan['objectif_calories'] ?></div>
        <div style="font-size:0.875rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:rgba(255,255,255,0.7)">Calories / Jour</div>
      </div>
    </div>
  </div>

  <!-- Timeline des repas -->
  <div class="mb-4 flex items-center justify-between">
    <h2 class="text-xl font-bold" style="color:var(--text-primary)"><i data-lucide="calendar-days" style="width:1.25rem;height:1.25rem;display:inline-block;color:var(--primary)"></i> Programme Journalier</h2>
    <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-edit&id=<?= $plan['id'] ?>" class="btn btn-outline-primary btn-sm btn-round"><i data-lucide="edit-3"></i> Modifier les repas</a>
  </div>

  <?php if (empty($repasByDay)): ?>
    <div class="card text-center py-8">
      <p style="color:var(--text-muted)">Aucun repas n'a été associé à ce plan pour le moment.</p>
    </div>
  <?php else: ?>
    <div class="space-y-6">
      <?php for ($jour = 1; $jour <= $plan['duree_jours']; $jour++): ?>
        <div class="card" style="padding:1.5rem">
          <div class="flex items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:var(--primary);color:white;border-radius:50%;font-weight:bold">J<?= $jour ?></div>
            <h3 class="font-semibold text-lg" style="color:var(--text-primary)">Jour <?= $jour ?></h3>
            <span class="text-xs" style="color:var(--text-muted);margin-left:auto"><?= date('d M Y', strtotime($plan['date_debut'] . ' + ' . ($jour - 1) . ' days')) ?></span>
          </div>

          <?php if (!isset($repasByDay[$jour]) || empty($repasByDay[$jour])): ?>
            <p class="text-sm italic" style="color:var(--text-muted);padding:1rem 0">Journée libre ou repas non définis.</p>
          <?php else: ?>
            <div class="space-y-3">
              <?php foreach ($repasByDay[$jour] as $r): ?>
                <div style="display:flex;align-items:center;gap:1rem;padding:1rem;background:var(--muted);border-radius:var(--radius-xl);border:1px solid var(--border);transition:all 0.2s" class="hover-shadow">
                  <div style="width:3px;height:30px;background:var(--secondary);border-radius:2px"></div>
                  <div style="flex-grow:1">
                    <div class="flex items-center justify-between mb-1">
                      <h4 class="font-bold text-base" style="color:var(--text-primary)"><?= htmlspecialchars($r['nom']) ?> <span class="badge badge-gray ml-2"><?= htmlspecialchars($r['type_repas']) ?></span></h4>
                      <span class="font-bold" style="color:var(--accent-orange)"><?= $r['calories_total'] ?> kcal</span>
                    </div>
                    <?php if (!empty($r['aliments'])): ?>
                      <div class="text-xs flex gap-2 flex-wrap mt-2" style="color:var(--text-secondary)">
                        <?php foreach ($r['aliments'] as $a): ?>
                          <span style="background:rgba(0,0,0,0.05);padding:0.15rem 0.5rem;border-radius:var(--radius-full)">• <?= htmlspecialchars($a['nom']) ?> (<?= $a['quantite']?><?= $a['unite']?>)</span>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            
            <?php // Calcul des totaux du jour
              $calJour = 0;
              foreach ($repasByDay[$jour] as $r) $calJour += $r['calories_total'];
              $pctCal = min(100, round(($calJour / $plan['objectif_calories']) * 100));
              $colorBar = $pctCal > 100 ? '#ef4444' : 'var(--primary)';
            ?>
            <div class="mt-4 pt-3" style="border-top:1px dashed var(--border)">
              <div class="flex items-center justify-between text-sm mb-1">
                <span class="font-semibold" style="color:var(--text-primary)">Total Journalier</span>
                <span class="font-bold <?= $calJour > $plan['objectif_calories'] ? 'text-red-500' : 'text-green-600' ?>"><?= $calJour ?> / <?= $plan['objectif_calories'] ?> kcal</span>
              </div>
              <div class="progress"><div class="progress-bar" style="width:<?= $pctCal ?>%;background:<?= $colorBar ?>"></div></div>
            </div>
          <?php endif; ?>
        </div>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>
