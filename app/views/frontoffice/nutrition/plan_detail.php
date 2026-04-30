<!-- Vue FrontOffice : Détail d'un Plan Nutritionnel -->
<?php
  // Check if the user is following this plan
  $followedPlans = $_SESSION['followed_plans'] ?? [];
  $isFollowing = isset($followedPlans[$plan['id']]);
  $followDate = $isFollowing ? $followedPlans[$plan['id']]['date_debut'] : null;
  $displayDate = $followDate ?? $plan['date_debut'] ?? date('Y-m-d');
?>
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
          <?php if (!empty($plan['regime_nom'])): ?>
            <span style="padding:0.25rem 0.75rem;background:rgba(255,255,255,0.18);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:600">
              Régime: <?= htmlspecialchars($plan['regime_nom']) ?>
            </span>
          <?php endif; ?>
          <?php if ($isFollowing): ?>
            <span style="padding:0.25rem 0.75rem;background:rgba(16,185,129,0.3);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;gap:0.3rem">
              <i data-lucide="check-circle" style="width:0.75rem;height:0.75rem"></i> Suivi actif
            </span>
          <?php endif; ?>
        </div>
        <h1 class="text-4xl font-bold mb-3" style="font-family:var(--font-heading)"><?= htmlspecialchars($plan['nom']) ?></h1>
        <p style="color:rgba(255,255,255,0.8);max-width:80%"><?= nl2br(htmlspecialchars($plan['description'] ?? 'Aucune description fournie.')) ?></p>

        <?php if ($isFollowing): ?>
          <div style="margin-top:1rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
            <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.9rem;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600">
              <i data-lucide="calendar" style="width:0.85rem;height:0.85rem"></i>
              Début : <?= date('d/m/Y', strtotime($followDate)) ?>
            </span>
            <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.9rem;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600">
              <i data-lucide="clock" style="width:0.85rem;height:0.85rem"></i>
              <?= $plan['duree_jours'] ?> jours
            </span>
            <?php
              $endDate = date('d/m/Y', strtotime($followDate . ' + ' . ((int)$plan['duree_jours'] - 1) . ' days'));
              $today = date('Y-m-d');
              $daysPassed = max(0, (strtotime($today) - strtotime($followDate)) / 86400);
              $progress = min(100, round(($daysPassed / max(1, $plan['duree_jours'])) * 100));
            ?>
            <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.9rem;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600">
              <i data-lucide="flag" style="width:0.85rem;height:0.85rem"></i>
              Fin : <?= $endDate ?>
            </span>
          </div>
          <!-- Progress bar -->
          <div style="margin-top:0.75rem;max-width:400px">
            <div style="display:flex;justify-content:space-between;font-size:0.7rem;font-weight:600;margin-bottom:0.3rem;color:rgba(255,255,255,0.7)">
              <span>Progression</span>
              <span><?= $progress ?>%</span>
            </div>
            <div style="height:6px;background:rgba(255,255,255,0.15);border-radius:3px;overflow:hidden">
              <div style="height:100%;width:<?= $progress ?>%;background:linear-gradient(90deg,#fcd34d,#f59e0b);border-radius:3px;transition:width 0.5s ease"></div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div style="text-align:right;flex-shrink:0">
        <div style="font-size:3rem;font-weight:800;line-height:1;color:#fcd34d"><?= $plan['objectif_calories'] ?></div>
        <div style="font-size:0.875rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:rgba(255,255,255,0.7)">Calories / Jour</div>

        <!-- Follow / Unfollow button -->
        <?php if (!$isFollowing): ?>
          <button onclick="document.getElementById('followModal').style.display='flex'" style="margin-top:1.25rem;display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.5rem;background:linear-gradient(135deg,#fcd34d,#f59e0b);color:#1B4332;border:none;border-radius:var(--radius-full);font-size:0.85rem;font-weight:700;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 16px rgba(252,211,77,0.35)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(252,211,77,0.45)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(252,211,77,0.35)'">
            <i data-lucide="play-circle" style="width:1rem;height:1rem"></i> Suivre ce plan
          </button>
        <?php else: ?>
          <div style="display:flex;flex-direction:column;gap:0.5rem;align-items:flex-end;margin-top:1.25rem">
            <button onclick="document.getElementById('followModal').style.display='flex'" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.5rem;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:var(--radius-full);font-size:0.85rem;font-weight:700;cursor:pointer;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
              <i data-lucide="calendar-check" style="width:1rem;height:1rem"></i> Modifier la date
            </button>
            <button data-confirm="Êtes-vous sûr de vouloir arrêter le suivi de ce plan ?" data-confirm-title="Arrêter le suivi" data-confirm-type="warning" data-confirm-url="<?= BASE_URL ?>/?page=nutrition&action=plan-unfollow&id=<?= $plan['id'] ?>" data-confirm-btn="Arrêter" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.55rem 1.25rem;background:rgba(239,68,68,0.2);backdrop-filter:blur(10px);color:#fca5a5;border:1px solid rgba(239,68,68,0.35);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600;cursor:pointer;transition:all 0.3s" onmouseover="this.style.background='rgba(239,68,68,0.35)';this.style.color='#fff'" onmouseout="this.style.background='rgba(239,68,68,0.2)';this.style.color='#fca5a5'">
              <i data-lucide="x-circle" style="width:0.9rem;height:0.9rem"></i> Arrêter le suivi
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Timeline des repas -->
  <div class="mb-4">
    <h2 class="text-xl font-bold" style="color:var(--text-primary)"><i data-lucide="calendar-days" style="width:1.25rem;height:1.25rem;display:inline-block;color:var(--primary)"></i> Programme Journalier</h2>
  </div>

  <?php
    $allActivites = [];
    if (!empty($plan['programme_activites'])) {
      $allActivites = json_decode($plan['programme_activites'], true) ?? [];
    }

    $daysWithData = [];
    foreach ($repasByDay as $jourKey => $list) {
      if (!empty($list)) $daysWithData[(int)$jourKey] = true;
    }
    foreach ($allActivites as $jourKey => $actTxt) {
      if (!empty(trim((string)$actTxt))) $daysWithData[(int)$jourKey] = true;
    }
    $daysToRender = array_keys($daysWithData);
    sort($daysToRender);
  ?>

  <?php if (empty($daysToRender)): ?>
    <div class="card text-center py-8">
      <p style="color:var(--text-muted)">Aucun contenu journalier (repas/activité) n'a été défini pour ce plan.</p>
    </div>
  <?php else: ?>
    <div class="space-y-6">
      <?php foreach ($daysToRender as $jour): ?>
        <div class="card" style="padding:1.5rem">
          <div class="flex items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:var(--primary);color:white;border-radius:50%;font-weight:bold">J<?= $jour ?></div>
            <h3 class="font-semibold text-lg" style="color:var(--text-primary)">Jour <?= $jour ?></h3>
            <?php if ($isFollowing || !empty($displayDate)):
              $t = strtotime($displayDate . ' + ' . ($jour - 1) . ' days');
              $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
            ?>
              <span class="text-xs" style="color:var(--text-muted);margin-left:auto"><?= date('d', $t) . ' ' . $mois[(int)date('n', $t)-1] . ' ' . date('Y', $t) ?></span>
            <?php endif; ?>
          </div>

          <?php
            // Show activity for this day if it exists
            $activitesDuJour = [];
            $activitesDuJour = $allActivites[$jour] ?? ($allActivites[(string)$jour] ?? '');
          ?>
          <?php if (!empty($activitesDuJour)): ?>
            <div style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.875rem 1rem;background:linear-gradient(135deg,rgba(245,158,11,0.07),rgba(252,211,77,0.04));border:1px solid rgba(245,158,11,0.18);border-radius:var(--radius-xl);margin-bottom:1rem">
              <div style="display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:linear-gradient(135deg,#fef3c7,#fffbeb);border-radius:0.5rem;flex-shrink:0;box-shadow:0 2px 8px rgba(245,158,11,0.15)">
                <i data-lucide="activity" style="width:0.9rem;height:0.9rem;color:#f59e0b"></i>
              </div>
              <div>
                <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#b45309;margin-bottom:0.2rem">Activité du jour</div>
                <div style="font-size:0.85rem;color:var(--text-primary);line-height:1.5"><?= nl2br(htmlspecialchars($activitesDuJour)) ?></div>
              </div>
            </div>
          <?php endif; ?>

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
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="card mt-6" style="padding:1.1rem 1.25rem;border:1px solid var(--border);background:linear-gradient(135deg,rgba(82,183,136,0.04),rgba(45,106,79,0.03))">
    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;font-weight:700;color:var(--text-primary);margin-bottom:0.45rem">
      <i data-lucide="file-text" style="width:0.9rem;height:0.9rem;color:var(--secondary)"></i>
      Description générale du plan
    </div>
    <p style="margin:0;font-size:0.85rem;color:var(--text-secondary);line-height:1.6">
      <?= nl2br(htmlspecialchars($plan['description'] ?? 'Aucune description fournie.')) ?>
    </p>
  </div>
</div>

<!-- ===== Follow Plan Modal ===== -->
<div id="followModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <!-- Icon -->
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,rgba(252,211,77,0.15),rgba(245,158,11,0.1));border-radius:50%;margin-bottom:1rem">
      <i data-lucide="calendar-check" style="width:1.625rem;height:1.625rem;color:#f59e0b"></i>
    </div>
    <!-- Title -->
    <h3 style="font-family:var(--font-heading);font-size:1.15rem;font-weight:800;color:var(--text-primary);margin-bottom:0.4rem">
      <?= $isFollowing ? 'Modifier la date de début' : 'Suivre ce plan' ?>
    </h3>
    <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6">
      <?= $isFollowing ? 'Choisissez une nouvelle date de début pour votre plan.' : 'Choisissez la date à laquelle vous souhaitez commencer ce plan nutritionnel.' ?>
    </p>

    <form method="POST" action="<?= BASE_URL ?>/?page=nutrition&action=plan-follow&id=<?= $plan['id'] ?>">
      <!-- Date Input -->
      <div style="text-align:left;margin-bottom:1.5rem">
        <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="calendar" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
          Date de début
        </label>
        <input type="date" name="date_debut" id="followDateInput"
               value="<?= htmlspecialchars($followDate ?? date('Y-m-d')) ?>"
               style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none"
               onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
        <div id="followDateError" style="color:#ef4444;font-size:0.75rem;margin-top:0.35rem;display:none">
          <i data-lucide="alert-circle" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i>
          Veuillez choisir une date valide.
        </div>

        <!-- Quick date chips -->
        <div style="display:flex;gap:0.5rem;margin-top:0.75rem;flex-wrap:wrap">
          <button type="button" class="follow-date-chip" onclick="setFollowDate(0)" style="padding:0.3rem 0.75rem;background:var(--muted);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.72rem;font-weight:600;color:var(--text-secondary);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
            Aujourd'hui
          </button>
          <button type="button" class="follow-date-chip" onclick="setFollowDate(1)" style="padding:0.3rem 0.75rem;background:var(--muted);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.72rem;font-weight:600;color:var(--text-secondary);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
            Demain
          </button>
          <button type="button" class="follow-date-chip" onclick="setFollowDate(getNextMonday())" style="padding:0.3rem 0.75rem;background:var(--muted);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.72rem;font-weight:600;color:var(--text-secondary);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
            Lundi prochain
          </button>
        </div>
      </div>

      <!-- Buttons -->
      <div style="display:flex;gap:0.75rem;justify-content:center">
        <button type="button" onclick="document.getElementById('followModal').style.display='none'"
                style="padding:0.6rem 1.5rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.2s"
                onmouseover="this.style.background='var(--border)'"
                onmouseout="this.style.background='var(--muted)'">
          Annuler
        </button>
        <button type="submit"
                style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.5rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border:none;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 12px rgba(45,106,79,0.3)"
                onmouseover="this.style.boxShadow='0 6px 20px rgba(45,106,79,0.4)';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.boxShadow='0 4px 12px rgba(45,106,79,0.3)';this.style.transform='none'">
          <i data-lucide="check" style="width:0.875rem;height:0.875rem"></i>
          <?= $isFollowing ? 'Mettre à jour' : 'Commencer le plan' ?>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Close modal on backdrop click
document.getElementById('followModal').addEventListener('click', function(e) {
  if (e.target === this) this.style.display = 'none';
});
// ESC key to close
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') document.getElementById('followModal').style.display = 'none';
});

// Quick date helpers
function setFollowDate(daysOrDate) {
  const input = document.getElementById('followDateInput');
  let date;
  if (typeof daysOrDate === 'number') {
    date = new Date();
    date.setDate(date.getDate() + daysOrDate);
  } else {
    date = daysOrDate;
  }
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  input.value = y + '-' + m + '-' + d;
}

function getNextMonday() {
  const today = new Date();
  const day = today.getDay();
  const diff = day === 0 ? 1 : 8 - day; // If Sunday, next day. Otherwise, days until Monday.
  const monday = new Date(today);
  monday.setDate(today.getDate() + diff);
  return monday;
}

// Validate date before submit
document.querySelector('#followModal form').addEventListener('submit', function(e) {
  const val = document.getElementById('followDateInput').value;
  const errEl = document.getElementById('followDateError');
  if (!val || !/^\d{4}-\d{2}-\d{2}$/.test(val)) {
    e.preventDefault();
    errEl.style.display = 'block';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  } else {
    errEl.style.display = 'none';
  }
});
</script>
