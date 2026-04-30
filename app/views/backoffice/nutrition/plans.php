<!-- Vue BackOffice : Liste des Plans Nutritionnels -->
<?php
$plans = isset($plans) && is_array($plans) ? $plans : [];
$statsPlans = ['total'=>0,'en_attente'=>0,'accepte'=>0,'refuse'=>0,'avg_duree'=>0,'avg_cal'=>0];
$sDur = 0;
$sCal = 0;
$normalizePlanStatus = static function ($value) {
    $raw = strtolower(trim((string)$value));
    $key = str_replace([' ', '-', '.'], '_', $raw);
    $aliases = [
      'en_attente' => 'en_attente',
      'enattente' => 'en_attente',
      'attente' => 'en_attente',
      'pending' => 'en_attente',
      'accepte' => 'accepte',
      'accepted' => 'accepte',
      'valide' => 'accepte',
      'approve' => 'accepte',
      'approuve' => 'accepte',
      'refuse' => 'refuse',
      'rejected' => 'refuse',
      'reject' => 'refuse',
      'rejete' => 'refuse',
    ];
    return $aliases[$key] ?? $key;
};
foreach ($plans as $__p) {
    $statsPlans['total']++;
    $st = $normalizePlanStatus($__p['statut'] ?? 'accepte');
    if ($st === 'en_attente') { $statsPlans['en_attente']++; }
    elseif ($st === 'accepte') { $statsPlans['accepte']++; }
    elseif ($st === 'refuse') { $statsPlans['refuse']++; }
    $sDur += (int)($__p['duree_jours'] ?? 0);
    $sCal += (int)($__p['objectif_calories'] ?? 0);
}
if ($statsPlans['total'] > 0) {
    $statsPlans['avg_duree'] = (int)round($sDur / $statsPlans['total']);
    $statsPlans['avg_cal'] = (int)round($sCal / $statsPlans['total']);
}

$planStatusChart = [
  (int)$statsPlans['en_attente'],
  (int)$statsPlans['accepte'],
  (int)$statsPlans['refuse'],
];
$planObjectives = ['perte_poids' => 0, 'maintien' => 0, 'prise_masse' => 0];
$planCaloriesByObjective = ['perte_poids' => 0, 'maintien' => 0, 'prise_masse' => 0];
$planCountByObjective = ['perte_poids' => 0, 'maintien' => 0, 'prise_masse' => 0];
foreach ($plans as $__p) {
    $typeObj = $__p['type_objectif'] ?? 'maintien';
    if (array_key_exists($typeObj, $planObjectives)) {
        $planObjectives[$typeObj]++;
        $planCaloriesByObjective[$typeObj] += (int)($__p['objectif_calories'] ?? 0);
        $planCountByObjective[$typeObj]++;
    }
}
$planCaloriesAvgByObjective = [];
foreach ($planCaloriesByObjective as $key => $sumCal) {
    $planCaloriesAvgByObjective[$key] = $planCountByObjective[$key] > 0
      ? (int)round($sumCal / $planCountByObjective[$key])
      : 0;
}
?>
<div class="flex items-center justify-between mb-8">
  <div>
    <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Plans Nutritionnels</h1>
    <p class="text-sm" style="color:var(--text-muted)">Gérez les programmes alimentaires des utilisateurs</p>
  </div>
  <div class="flex items-center gap-2">
    <button type="button" id="exportPlansPdfBtn" class="btn" style="background:linear-gradient(135deg,#1f7a4f,#2E7D4F);color:#fff;border:1px solid #1f7a4f;box-shadow:0 4px 12px rgba(31,122,79,0.25)">
      <i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF
    </button>
    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plan-add" class="btn btn-primary btn-round">
      <i data-lucide="plus" style="width:1rem;height:1rem"></i> Nouveau Plan
    </a>
  </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:0.875rem;margin-bottom:1.5rem">
  <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
      <i data-lucide="clipboard-list" style="width:0.75rem;height:0.75rem;color:var(--primary)"></i> Total
    </div>
    <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--text-primary);line-height:1"><?= (int)$statsPlans['total'] ?></div>
  </div>
  <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(245,158,11,0.35);background:linear-gradient(135deg,rgba(245,158,11,0.06),transparent)">
    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#b45309;margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
      <i data-lucide="clock" style="width:0.75rem;height:0.75rem"></i> En attente
    </div>
    <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#d97706;line-height:1"><?= (int)$statsPlans['en_attente'] ?></div>
  </div>
  <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(34,197,94,0.25);background:linear-gradient(135deg,rgba(34,197,94,0.06),transparent)">
    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
      <i data-lucide="check-circle-2" style="width:0.75rem;height:0.75rem;color:#22c55e"></i> Acceptés
    </div>
    <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#15803d;line-height:1"><?= (int)$statsPlans['accepte'] ?></div>
  </div>
  <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(239,68,68,0.22);background:linear-gradient(135deg,rgba(239,68,68,0.05),transparent)">
    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
      <i data-lucide="x-circle" style="width:0.75rem;height:0.75rem;color:#ef4444"></i> Refusés
    </div>
    <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#b91c1c;line-height:1"><?= (int)$statsPlans['refuse'] ?></div>
  </div>
  <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
      <i data-lucide="calendar" style="width:0.75rem;height:0.75rem;color:var(--secondary)"></i> Moy. durée
    </div>
    <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--text-primary);line-height:1"><?php if ($statsPlans['total'] > 0): ?><?= (int)$statsPlans['avg_duree'] ?><span style="font-size:0.75rem;font-weight:600;color:var(--text-muted);margin-left:0.15rem">j</span><?php else: ?>—<?php endif; ?></div>
  </div>
  <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
      <i data-lucide="flame" style="width:0.75rem;height:0.75rem;color:var(--accent-orange)"></i> Moy. calories
    </div>
    <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--accent-orange);line-height:1"><?= $statsPlans['total'] > 0 ? number_format($statsPlans['avg_cal'], 0, ',', ' ') : '—' ?></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1rem;margin-bottom:1.5rem">
  <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
      <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Validation des plans</h3>
      <span class="badge badge-gray">Statuts</span>
    </div>
    <canvas id="plansStatusChart" style="max-height:240px"></canvas>
  </div>
  <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
      <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Calories moyennes par objectif</h3>
      <span class="badge badge-gray">kcal</span>
    </div>
    <canvas id="plansCaloriesObjectiveChart" style="max-height:240px"></canvas>
  </div>
</div>

<div class="card" style="padding:0;overflow:hidden">
  <div style="overflow-x:auto">
    <table style="width:100%;border-collapse:collapse;text-align:left">
      <thead>
        <tr style="border-bottom:2px solid var(--border);background:var(--muted)">
          <th style="padding:1rem">ID</th>
          <th style="padding:1rem">Nom</th>
          <th style="padding:1rem">Régime lié</th>
          <th style="padding:1rem">Objectif</th>
          <th style="padding:1rem">Durée</th>
          <th style="padding:1rem">Calories Cibles</th>
          <th style="padding:1rem">Soumis par</th>
          <th style="padding:1rem">Statut</th>
          <th style="padding:1rem;text-align:right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($plans)): ?>
          <tr>
            <td colspan="9" style="padding:2rem;text-align:center;color:var(--text-muted)">Aucun plan trouvé.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($plans as $p): ?>
            <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='transparent'">
              <td style="padding:1rem;color:var(--text-muted)">#<?= $p['id'] ?></td>
              <td style="padding:1rem;font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($p['nom']) ?></td>
              <td style="padding:1rem;color:var(--text-secondary)"><?= !empty($p['regime_nom']) ? htmlspecialchars($p['regime_nom']) : '<span style="color:var(--text-muted)">—</span>' ?></td>
              <td style="padding:1rem">
                <?php
                  $typeStr = 'Maintien';
                  $badgeCls = 'badge-success';
                  if ($p['type_objectif'] === 'perte_poids') {
                    $typeStr = 'Perte de poids';
                    $badgeCls = 'badge-danger';
                  } elseif ($p['type_objectif'] === 'prise_masse') {
                    $typeStr = 'Prise de masse';
                    $badgeCls = 'badge-primary';
                  }
                ?>
                <span class="badge <?= $badgeCls ?>"><?= $typeStr ?></span>
              </td>
              <td style="padding:1rem;color:var(--text-secondary)"><?= $p['duree_jours'] ?> jours</td>
              <td style="padding:1rem;font-weight:600;color:var(--accent-orange)"><?= $p['objectif_calories'] ?> kcal</td>
              <td style="padding:1rem;color:var(--text-secondary)">
                <div style="font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($p['soumis_par'] ?? 'Inconnu') ?></div>
                <div style="font-size:0.75rem"><?= date('d/m/Y', strtotime($p['date_debut'])) ?></div>
              </td>
              <td style="padding:1rem;color:var(--text-secondary)">
                <?php
                  $st = $normalizePlanStatus($p['statut'] ?? 'accepte');
                  $conf = [
                    'en_attente' => ['label'=>'En attente', 'cls'=>'badge-warning'],
                    'accepte'    => ['label'=>'Accepté',    'cls'=>'badge-success'],
                    'refuse'     => ['label'=>'Refusé',     'cls'=>'badge-danger'],
                  ];
                  $c = $conf[$st] ?? $conf['en_attente'];
                ?>
                <span class="badge <?= $c['cls'] ?>"><?= $c['label'] ?></span>
              </td>
              <td style="padding:1rem;text-align:right">
                <div class="flex items-center justify-end gap-2">
                  <?php if ($st === 'accepte'): ?>
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plan-edit&id=<?= $p['id'] ?>" class="btn-ghost" title="Modifier" style="padding:0.5rem;border-radius:var(--radius-full);color:#3b82f6"><i data-lucide="edit" style="width:1.1rem;height:1.1rem"></i></a>
                  <?php endif; ?>
                  
                  <?php if ($st === 'en_attente' || $st === 'refuse'): ?>
                    <button type="button" class="btn-ghost" title="Accepter" onclick="openAcceptConfirm('<?= BASE_URL ?>/?page=admin-nutrition&action=plan-accept&id=<?= $p['id'] ?>', '<?= addslashes(htmlspecialchars($p['nom'])) ?>')" style="padding:0.5rem;border-radius:var(--radius-full);color:#22c55e">
                      <i data-lucide="check" style="width:1.1rem;height:1.1rem"></i>
                    </button>
                  <?php endif; ?>

                  <?php if ($st === 'en_attente' || $st === 'accepte'): ?>
                    <button type="button" class="btn-ghost" title="Refuser" onclick="openRefuseModal(<?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['nom'])) ?>')" style="padding:0.5rem;border-radius:var(--radius-full);color:#f97316">
                      <i data-lucide="x" style="width:1.1rem;height:1.1rem"></i>
                    </button>
                  <?php endif; ?>

                  <button type="button" class="btn-ghost" title="Supprimer" onclick="openDeleteConfirmBack('<?= BASE_URL ?>/?page=admin-nutrition&action=plan-delete&id=<?= $p['id'] ?>', '<?= addslashes(htmlspecialchars($p['nom'])) ?>')" style="padding:0.5rem;border-radius:var(--radius-full);color:var(--destructive)">
                    <i data-lucide="trash-2" style="width:1.1rem;height:1.1rem"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>
<script>
(function () {
  if (typeof Chart === 'undefined') return;

  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  const textColor = isDark ? '#cbd5e1' : '#6b7280';
  const baseOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        labels: {
          color: textColor,
          usePointStyle: true,
          pointStyle: 'circle',
          font: { size: 11 }
        }
      }
    },
    scales: {
      x: { ticks: { color: textColor, font: { size: 11 } }, grid: { color: gridColor } },
      y: { ticks: { color: textColor, font: { size: 11 }, precision: 0 }, grid: { color: gridColor } }
    }
  };

  const plansStatusCtx = document.getElementById('plansStatusChart');
  if (plansStatusCtx) {
    new Chart(plansStatusCtx, {
      type: 'doughnut',
      data: {
        labels: ['En attente', 'Acceptés', 'Refusés'],
        datasets: [{
          data: <?= json_encode($planStatusChart, JSON_UNESCAPED_UNICODE) ?>,
          backgroundColor: ['#f59e0b', '#22c55e', '#ef4444'],
          borderWidth: 0,
          spacing: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '62%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: textColor, usePointStyle: true, padding: 14, font: { size: 11 } }
          }
        }
      }
    });
  }

  const caloriesCtx = document.getElementById('plansCaloriesObjectiveChart');
  if (caloriesCtx) {
    new Chart(caloriesCtx, {
      type: 'bar',
      data: {
        labels: ['Perte de poids', 'Maintien', 'Prise de masse'],
        datasets: [{
          label: 'kcal moyennes',
          data: <?= json_encode([
              $planCaloriesAvgByObjective['perte_poids'],
              $planCaloriesAvgByObjective['maintien'],
              $planCaloriesAvgByObjective['prise_masse'],
            ], JSON_UNESCAPED_UNICODE) ?>,
          backgroundColor: ['rgba(239,68,68,0.75)', 'rgba(59,130,246,0.75)', 'rgba(139,92,246,0.75)'],
          borderRadius: 10,
          borderSkipped: false,
          maxBarThickness: 48
        }]
      },
      options: {
        ...baseOptions,
        plugins: {
          ...baseOptions.plugins,
          tooltip: {
            callbacks: {
              label: function (ctx) { return (ctx.parsed.y || 0) + ' kcal'; }
            }
          }
        }
      }
    });
  }
})();

(function () {
  const btn = document.getElementById('exportPlansPdfBtn');
  if (!btn) return;

  btn.addEventListener('click', function () {
    if (!window.jspdf || !window.jspdf.jsPDF) {
      alert('Bibliothèque PDF indisponible.');
      return;
    }
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });

    doc.setFontSize(16);
    doc.text('Plans Nutritionnels', 40, 36);
    doc.setFontSize(10);
    doc.text('Export généré le <?= date('d/m/Y H:i') ?>', 40, 54);

    const rows = <?= json_encode(array_map(function ($p) {
      return [
        (int)($p['id'] ?? 0),
        (string)($p['nom'] ?? ''),
        (string)($p['regime_nom'] ?? '—'),
        (string)($p['type_objectif'] ?? ''),
        (string)((int)($p['duree_jours'] ?? 0) . ' jours'),
        (string)((int)($p['objectif_calories'] ?? 0) . ' kcal'),
        (string)($p['soumis_par'] ?? ''),
        (string)($p['statut'] ?? ''),
      ];
    }, $plans), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    doc.autoTable({
      startY: 68,
      head: [['ID', 'Nom', 'Régime lié', 'Objectif', 'Durée', 'Calories', 'Soumis par', 'Statut']],
      body: rows,
      styles: { fontSize: 8, cellPadding: 4 },
      headStyles: { fillColor: [31, 122, 79] },
      theme: 'grid'
    });

    doc.save('plans_nutritionnels.pdf');
  });
})();
</script>

<!-- Modals for Validation -->
<!-- ===== REFUSE MODAL ===== -->
<div id="refuseModal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:440px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.2);animation:fadeUp 0.25s ease">
    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
      <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:rgba(239,68,68,0.1);display:flex;align-items:center;justify-content:center">
        <i data-lucide="x-circle" style="width:1.25rem;height:1.25rem;color:#ef4444"></i>
      </div>
      <div>
        <div style="font-family:var(--font-heading);font-weight:700;font-size:1rem;color:var(--text-primary)">Refuser le plan</div>
        <div id="refusePlanNomLabel" style="font-size:0.78rem;color:var(--text-muted)"></div>
      </div>
    </div>

    <form method="POST" id="refuseForm" action="">
      <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        Motif du refus (optionnel)
      </label>
      <textarea name="commentaire" rows="3"
                placeholder="Ex: Contenu insuffisant, objectif non réaliste…"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.82rem;background:var(--surface);color:var(--foreground);resize:vertical;outline:none;transition:all 0.3s"
                onfocus="this.style.borderColor='#ef4444';this.style.boxShadow='0 0 0 3px rgba(239,68,68,0.1)'"
                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"></textarea>

      <div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-top:1rem">
        <button type="button" onclick="closeRefuseModal()" class="btn btn-outline" style="border-radius:var(--radius-full)">Annuler</button>
        <button type="submit" style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.25rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;cursor:pointer;transition:all 0.2s">
          <i data-lucide="x-circle" style="width:0.875rem;height:0.875rem"></i> Confirmer le refus
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openRefuseModal(id, nom) {
  document.getElementById('refusePlanNomLabel').textContent = nom;
  document.getElementById('refuseForm').action = '<?= BASE_URL ?>/?page=admin-nutrition&action=plan-refuse&id=' + id;
  document.getElementById('refuseModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeRefuseModal() {
  document.getElementById('refuseModal').style.display = 'none';
}

// ---- Accept Confirm Modal ----
function openAcceptConfirm(url, nom) {
  document.getElementById('acceptConfirmLink').href = url;
  document.getElementById('acceptConfirmMsg').textContent = 'Accepter et publier "' + nom + '" ?';
  document.getElementById('acceptConfirmModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeAcceptConfirm() {
  document.getElementById('acceptConfirmModal').style.display = 'none';
}

// ---- Delete Confirm Modal ----
function openDeleteConfirmBack(url, nom) {
  document.getElementById('deleteConfirmBackLink').href = url;
  document.getElementById('deleteConfirmBackMsg').textContent =
    'Supprimer définitivement "' + nom + '" ? Cette action est irréversible.';
  document.getElementById('deleteConfirmBackModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeDeleteConfirmBack() {
  document.getElementById('deleteConfirmBackModal').style.display = 'none';
}
</script>

<!-- ===== ACCEPT CONFIRM MODAL ===== -->
<div id="acceptConfirmModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:380px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(34,197,94,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="check-circle-2" style="width:1.625rem;height:1.625rem;color:#22c55e"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Accepter ce plan ?</h3>
    <p id="acceptConfirmMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeAcceptConfirm()" class="btn btn-outline">Annuler</button>
      <a id="acceptConfirmLink" href="#" class="btn btn-primary">
        <i data-lucide="check" style="width:0.875rem;height:0.875rem"></i> Oui, accepter
      </a>
    </div>
  </div>
</div>

<!-- ===== DELETE CONFIRM MODAL (BACK) ===== -->
<div id="deleteConfirmBackModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:380px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(239,68,68,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="trash-2" style="width:1.625rem;height:1.625rem;color:#ef4444"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Supprimer ce plan ?</h3>
    <p id="deleteConfirmBackMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeDeleteConfirmBack()" class="btn btn-outline">Annuler</button>
      <a id="deleteConfirmBackLink" href="#" class="btn" style="background:#ef4444;color:#fff;">
        <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i> Oui, supprimer
      </a>
    </div>
  </div>
</div>
