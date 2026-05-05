<?php
/**
 * Vue BackOffice : Gestion des régimes alimentaires — Modération + CRUD
 */

$objectifLabels = [
    'perte_poids'    => 'Perte de poids',
    'maintien'       => 'Maintien',
    'prise_masse'    => 'Prise de masse',
    'sante_generale' => 'Santé générale',
];

$statutConfig = [
    'en_attente' => ['label'=>'En attente', 'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.1)', 'icon'=>'clock'],
    'accepte'    => ['label'=>'Accepté',    'color'=>'#22c55e', 'bg'=>'rgba(34,197,94,0.1)',  'icon'=>'check-circle-2'],
    'refuse'     => ['label'=>'Refusé',     'color'=>'#ef4444', 'bg'=>'rgba(239,68,68,0.1)',  'icon'=>'x-circle'],
];

$regimes = isset($regimes) && is_array($regimes) ? $regimes : [];
$statsRegimes = ['total'=>0,'en_attente'=>0,'accepte'=>0,'refuse'=>0,'avg_kcal'=>0];
$sKcal = 0;
foreach ($regimes as $__r) {
    $statsRegimes['total']++;
    $sRaw = strtolower(trim((string)($__r['statut'] ?? 'en_attente')));
    $s = str_replace([' ', '-'], '_', $sRaw);
    if ($s === 'en_attente') { $statsRegimes['en_attente']++; }
    elseif ($s === 'accepte') { $statsRegimes['accepte']++; }
    elseif ($s === 'refuse') { $statsRegimes['refuse']++; }
    $sKcal += (int)($__r['calories_jour'] ?? 0);
}
if ($statsRegimes['total'] > 0) {
    $statsRegimes['avg_kcal'] = (int)round($sKcal / $statsRegimes['total']);
}

$regimeStatusChart = [
    (int)$statsRegimes['en_attente'],
    (int)$statsRegimes['accepte'],
    (int)$statsRegimes['refuse'],
];
$rawObjectiveCounts = [];
foreach ($regimes as $__r) {
    $obj = trim($__r['objectif'] ?? 'Autre');
    if ($obj === '') $obj = 'Autre';

    if (!isset($rawObjectiveCounts[$obj])) {
        $rawObjectiveCounts[$obj] = 0;
    }
    $rawObjectiveCounts[$obj]++;
}
arsort($rawObjectiveCounts);
$topObjectives = array_slice($rawObjectiveCounts, 0, 4, true);
$otherCount = 0;
$allObjKeys = array_keys($rawObjectiveCounts);
for ($i = 4; $i < count($allObjKeys); $i++) {
    $otherCount += $rawObjectiveCounts[$allObjKeys[$i]];
}
if ($otherCount > 0) {
    $topObjectives['Autres'] = $otherCount;
}
$regimeObjectiveLabels = array_keys($topObjectives);
$regimeObjectiveCounts = array_values($topObjectives);
?>

<div style="padding:2rem">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 4px 16px rgba(45,106,79,0.18)">
        <i data-lucide="salad" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">
          Régimes Alimentaires
          <?php if ($pendingCount > 0): ?>
            <span style="display:inline-flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border-radius:var(--radius-full);min-width:1.35rem;height:1.35rem;font-size:0.65rem;font-weight:800;padding:0 0.35rem;margin-left:0.5rem;vertical-align:middle"><?= $pendingCount ?></span>
          <?php endif; ?>
        </h1>
        <p style="font-size:0.78rem;color:var(--text-muted);margin-top:2px"><?= count($regimes) ?> régime<?= count($regimes) !== 1 ? 's' : '' ?> au total</p>
      </div>
    </div>
    <button type="button" id="exportRegimesPdfBtn" class="btn" style="background:linear-gradient(135deg,#1f7a4f,#2E7D4F);color:#fff;border:1px solid #1f7a4f;box-shadow:0 4px 12px rgba(31,122,79,0.25)">
      <i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF
    </button>
  </div>

  <!-- Statistiques -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:0.875rem;margin-bottom:1.5rem">
    <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="layers" style="width:0.75rem;height:0.75rem;color:var(--primary)"></i> Total
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--text-primary);line-height:1"><?= (int)$statsRegimes['total'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(245,158,11,0.35);background:linear-gradient(135deg,rgba(245,158,11,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#b45309;margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="clock" style="width:0.75rem;height:0.75rem"></i> À modérer
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#d97706;line-height:1"><?= (int)$statsRegimes['en_attente'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(34,197,94,0.25);background:linear-gradient(135deg,rgba(34,197,94,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="check-circle-2" style="width:0.75rem;height:0.75rem;color:#22c55e"></i> Acceptés
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#15803d;line-height:1"><?= (int)$statsRegimes['accepte'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(239,68,68,0.22);background:linear-gradient(135deg,rgba(239,68,68,0.05),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="x-circle" style="width:0.75rem;height:0.75rem;color:#ef4444"></i> Refusés
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#b91c1c;line-height:1"><?= (int)$statsRegimes['refuse'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="flame" style="width:0.75rem;height:0.75rem;color:var(--accent-orange)"></i> Moy. kcal/j
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--accent-orange);line-height:1"><?= $statsRegimes['total'] > 0 ? number_format($statsRegimes['avg_kcal'], 0, ',', ' ') : '—' ?></div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1rem;margin-bottom:1.5rem">
    <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
        <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Répartition des statuts</h3>
        <span class="badge badge-gray">Régimes</span>
      </div>
      <canvas id="regimesStatusChart" style="max-height:240px"></canvas>
    </div>
    <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
        <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Objectifs nutritionnels</h3>
        <span class="badge badge-gray">Distribution</span>
      </div>
      <canvas id="regimesObjectiveChart" style="max-height:240px"></canvas>
    </div>
  </div>

  <?php if (empty($regimes)): ?>
    <div class="card" style="padding:4rem 2rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.25rem">
        <i data-lucide="salad" style="width:2.25rem;height:2.25rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:var(--primary);margin-bottom:0.5rem">Aucun régime soumis</h3>
      <p style="color:var(--text-muted);font-size:0.82rem">Les propositions des utilisateurs apparaîtront ici pour modération.</p>
    </div>
  <?php else: ?>

    <div class="card" style="padding:0;overflow:hidden">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Régime</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Objectif</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Durée</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">kcal/j</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Soumis par</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Statut</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:180px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($regimes as $r):
            $stRaw = strtolower(trim((string)($r['statut'] ?? 'en_attente')));
            $stKey = str_replace([' ', '-'], '_', $stRaw);
            $st = $statutConfig[$stKey] ?? $statutConfig['en_attente'];
            $objLabel = $objectifLabels[$r['objectif']] ?? $r['objectif'];
          ?>
          <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(82,183,136,0.03)'" onmouseout="this.style.background=''">
            <!-- Nom + Description -->
            <td style="padding:0.75rem 0.875rem;max-width:220px">
              <div style="font-weight:700;font-size:0.875rem;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($r['nom']) ?></div>
              <?php if (!empty($r['description'])): ?>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px"><?= htmlspecialchars(mb_substr($r['description'], 0, 80)) ?>…</div>
              <?php endif; ?>
              <?php if (!empty($r['restrictions'])): ?>
                <div style="margin-top:4px;display:flex;align-items:center;gap:0.3rem">
                  <i data-lucide="shield-check" style="width:0.6rem;height:0.6rem;color:var(--secondary)"></i>
                  <span style="font-size:0.65rem;color:var(--secondary)"><?= htmlspecialchars(mb_substr($r['restrictions'], 0, 40)) ?></span>
                </div>
              <?php endif; ?>
            </td>
            <!-- Objectif -->
            <td style="padding:0.75rem 0.875rem;font-size:0.82rem;color:var(--text-secondary)"><?= htmlspecialchars($objLabel) ?></td>
            <!-- Durée -->
            <td style="padding:0.75rem 0.875rem;text-align:center">
              <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--text-primary)"><?= (int)$r['duree_semaines'] ?></span>
              <span style="font-size:0.68rem;color:var(--text-muted);display:block">sem.</span>
            </td>
            <!-- Calories -->
            <td style="padding:0.75rem 0.875rem;text-align:center">
              <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--accent-orange)"><?= number_format((int)$r['calories_jour']) ?></span>
            </td>
            <!-- Soumis par -->
            <td style="padding:0.75rem 0.875rem">
              <div style="display:flex;align-items:center;gap:0.5rem">
                <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <i data-lucide="user" style="width:0.75rem;height:0.75rem;color:#fff"></i>
                </div>
                <div>
                  <div style="font-size:0.82rem;font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($r['soumis_par']) ?></div>
                  <div style="font-size:0.68rem;color:var(--text-muted)"><?= date('d/m/Y', strtotime($r['created_at'])) ?></div>
                </div>
              </div>
            </td>
            <!-- Statut -->
            <td style="padding:0.75rem 0.875rem;text-align:center">
              <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;font-size:0.72rem;font-weight:700">
                <i data-lucide="<?= $st['icon'] ?>" style="width:0.75rem;height:0.75rem"></i>
                <?= $st['label'] ?>
              </span>
              <?php if ($stKey === 'refuse' && !empty($r['commentaire_admin'])): ?>
                <div style="margin-top:4px;font-size:0.65rem;color:var(--text-muted);font-style:italic;max-width:130px;margin-left:auto;margin-right:auto">"<?= htmlspecialchars(mb_substr($r['commentaire_admin'], 0, 50)) ?>"</div>
              <?php endif; ?>
            </td>
            <!-- Actions -->
            <td style="padding:0.75rem 0.875rem;text-align:center">
              <div style="display:inline-flex;gap:0.4rem;justify-content:center;align-items:center;flex-wrap:nowrap;white-space:nowrap">
                <?php if ($stKey === 'accepte'): ?>
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=regime-edit-back&id=<?= $r['id'] ?>"
                     style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:rgba(59,130,246,0.1);color:#3b82f6;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(59,130,246,0.2)"
                     onmouseover="this.style.background='rgba(59,130,246,0.18)';this.style.transform='translateY(-1px)'"
                     onmouseout="this.style.background='rgba(59,130,246,0.1)';this.style.transform='none'">
                    <i data-lucide="edit" style="width:0.75rem;height:0.75rem"></i> Modifier
                  </a>
                <?php endif; ?>
                 <?php if ($stKey === 'en_attente' || $stKey === 'refuse'): ?>
                   <button type="button"
                      onclick="openAcceptConfirm('<?= BASE_URL ?>/?page=admin-nutrition&action=regime-accept&id=<?= $r['id'] ?>', '<?= addslashes(htmlspecialchars($r['nom'])) ?>')"
                      style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.2s;white-space:nowrap"
                      onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(34,197,94,0.3)'"
                      onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                     <i data-lucide="check" style="width:0.75rem;height:0.75rem"></i> Accepter
                   </button>
                 <?php endif; ?>

                <?php if ($stKey === 'en_attente' || $stKey === 'accepte'): ?>
                  <button onclick="openRefuseModal(<?= $r['id'] ?>, '<?= addslashes(htmlspecialchars($r['nom'])) ?>')"
                          style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:linear-gradient(135deg,#f87171,#ef4444);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.2s;white-space:nowrap"
                          onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(239,68,68,0.3)'"
                          onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                    <i data-lucide="x" style="width:0.75rem;height:0.75rem"></i> Refuser
                  </button>
                <?php endif; ?>

                <button type="button"
                   onclick="openDeleteConfirmBack('<?= BASE_URL ?>/?page=admin-nutrition&action=regime-delete&id=<?= $r['id'] ?>', '<?= addslashes(htmlspecialchars($r['nom'])) ?>')"
                   style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);cursor:pointer;transition:all 0.2s"
                   onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                   onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'">
                  <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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

  const statusCtx = document.getElementById('regimesStatusChart');
  if (statusCtx) {
    new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: ['En attente', 'Acceptés', 'Refusés'],
        datasets: [{
          data: <?= json_encode($regimeStatusChart, JSON_UNESCAPED_UNICODE) ?>,
          backgroundColor: ['#f59e0b', '#22c55e', '#ef4444'],
          borderWidth: 0,
          spacing: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'right',
            labels: { color: textColor, usePointStyle: true, padding: 16, font: { size: 11 } }
          }
        }
      }
    });
  }

  const objectiveCtx = document.getElementById('regimesObjectiveChart');
  if (objectiveCtx) {
    new Chart(objectiveCtx, {
      type: 'doughnut',
      data: {
        labels: <?= json_encode($regimeObjectiveLabels, JSON_UNESCAPED_UNICODE) ?>,
        datasets: [{
          data: <?= json_encode($regimeObjectiveCounts, JSON_UNESCAPED_UNICODE) ?>,
          backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
          borderWidth: 0,
          spacing: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'right',
            labels: { color: textColor, usePointStyle: true, padding: 16, font: { size: 11 } }
          }
        }
      }
    });
  }
})();

(function () {
  const btn = document.getElementById('exportRegimesPdfBtn');
  if (!btn) return;

  const rows = <?= json_encode(array_map(function ($r) {
    $statut = $r['statut'] ?? 'en_attente';
    $badgeStyle = $statut === 'accepte'
      ? 'background:#dcfce7;color:#166534;border:1px solid #86efac'
      : ($statut === 'refuse' ? 'background:#fee2e2;color:#991b1b;border:1px solid #fca5a5' : 'background:#fef9c3;color:#854d0e;border:1px solid #fde047');
    $statutLabel = $statut === 'accepte' ? 'Accepte' : ($statut === 'refuse' ? 'Refuse' : 'En attente');
    return [
      (int)($r['id'] ?? 0),
      htmlspecialchars((string)($r['nom'] ?? '')),
      htmlspecialchars((string)($r['objectif'] ?? '')),
      (int)($r['duree_semaines'] ?? 0) . ' sem.',
      number_format((int)($r['calories_jour'] ?? 0)) . ' kcal',
      htmlspecialchars((string)($r['soumis_par'] ?? '')),
      $statutLabel,
      $badgeStyle,
    ];
  }, $regimes), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

  btn.addEventListener('click', function () {
    btn.disabled = true;
    btn.textContent = 'Generation...';
    var total = <?= count($regimes) ?>;
    var acceptes = <?= count(array_filter($regimes, fn($r) => ($r['statut']??'') === 'accepte')) ?>;
    var attente  = <?= count(array_filter($regimes, fn($r) => ($r['statut']??'') === 'en_attente')) ?>;
    var refuses  = total - acceptes - attente;
    var avgKcal = <?= $statsRegimes['avg_kcal'] ?? 0 ?>;
    // Capture charts as images
    var chart1Img = '', chart2Img = '';
    var c1 = document.getElementById('regimesStatusChart');
    var c2 = document.getElementById('regimesObjectiveChart');
    if (c1) chart1Img = c1.toDataURL('image/png');
    if (c2) chart2Img = c2.toDataURL('image/png');
    var chartsHtml = '';
    if (chart1Img || chart2Img) {
      chartsHtml = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:0 30px 20px">';
      if (chart1Img) chartsHtml += '<div style="border:1px solid #e2e8f0;border-radius:10px;padding:12px"><div style="font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin-bottom:8px">Repartition des statuts</div><img src="' + chart1Img + '" style="width:100%;height:160px;object-fit:contain"></div>';
      if (chart2Img) chartsHtml += '<div style="border:1px solid #e2e8f0;border-radius:10px;padding:12px"><div style="font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin-bottom:8px">Objectifs nutritionnels</div><img src="' + chart2Img + '" style="width:100%;height:160px;object-fit:contain"></div>';
      chartsHtml += '</div>';
    }

    var tableRows = rows.map(function(r) {
      return '<tr style="border-bottom:1px solid #f1f5f9">'
        + '<td style="padding:8px 10px;font-weight:800;color:#2D6A4F;width:30px">' + r[0] + '</td>'
        + '<td style="padding:8px 10px;font-weight:700;color:#1a2332">' + r[1] + '</td>'
        + '<td style="padding:8px 10px;color:#475569">' + r[2] + '</td>'
        + '<td style="padding:8px 10px;font-weight:600">' + r[3] + '</td>'
        + '<td style="padding:8px 10px;font-weight:800;color:#d97706">' + r[4] + '</td>'
        + '<td style="padding:8px 10px;color:#2D6A4F;font-weight:600">' + r[5] + '</td>'
        + '<td style="padding:8px 10px"><span style="display:inline-block;padding:3px 9px;border-radius:99px;font-size:8px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;' + r[7] + '">' + r[6] + '</span></td>'
        + '</tr>';
    }).join('');

    var html = '<!doctype html><html><head><meta charset="utf-8"><title>GreenBite - Regimes</title>'
      + '<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"><\/script>'
      + '<style>*{margin:0;padding:0;box-sizing:border-box}body{font-family:Arial,sans-serif;color:#1a2332;background:#fff}'
      + '#wrap{width:794px;margin:0 auto}'
      + '.hdr{background:linear-gradient(135deg,#1B4332,#2D6A4F,#40916C);padding:24px 30px;display:flex;align-items:center;justify-content:space-between}'
      + '.lw{display:flex;align-items:center;gap:12px}'
      + '.lb{width:48px;height:48px;background:#1a2332;border-radius:12px;border:2px solid rgba(82,183,136,0.5);display:flex;align-items:center;justify-content:center}'
      + '.bn{font-size:20px;font-weight:900;color:#fff;display:block}'
      + '.bt{font-size:8px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1.2px;display:block;margin-top:2px}'
      + '.cr{text-align:right;color:rgba(255,255,255,0.85);font-size:9.5px;line-height:1.9}'
      + '.gb{height:3px;background:linear-gradient(90deg,#1B4332,#52B788,#95D5B2,#52B788,#1B4332)}'
      + '.dm{background:#f8fafc;border-bottom:2px solid #e2e8f0;padding:12px 30px;display:flex;align-items:center;justify-content:space-between}'
      + '.dt{font-size:15px;font-weight:800;color:#1a2332}.ds{font-size:9px;color:#64748b;margin-top:2px}'
      + '.dr{text-align:right;font-size:9px;color:#94a3b8;line-height:1.8}.dr b{color:#334155;font-size:10px;display:block}'
      + '.sr{display:grid;grid-template-columns:repeat(4,1fr);background:#e2e8f0;gap:1px;border-bottom:2px solid #d1d9e0}'
      + '.sc{background:#fff;padding:12px 8px;text-align:center}'
      + '.sn{font-size:24px;font-weight:900;line-height:1;margin-bottom:3px}.sl{font-size:8px;text-transform:uppercase;letter-spacing:1px;color:#64748b;font-weight:700}'
      + '.tw{padding:20px 30px 24px}'
      + '.tl{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin-bottom:8px}'
      + 'table{width:100%;border-collapse:collapse;font-size:10px}'
      + 'thead tr{background:linear-gradient(90deg,#1B4332,#2D6A4F)}'
      + 'thead th{color:#fff;padding:9px 10px;text-align:left;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:0.6px}'
      + 'tbody tr:nth-child(even){background:#f8fafc}'
      + '.ft{background:#1a2332;padding:12px 30px;display:flex;align-items:center;justify-content:space-between}'
      + '.fb{font-size:11px;font-weight:800;color:#a7f3d0;display:flex;align-items:center;gap:8px}'
      + '.fm{font-size:8.5px;color:#475569;text-align:center}.fc{font-size:8.5px;color:#64748b;text-align:right;line-height:1.7}'
      + '</style></head><body>'
      + '<div id="wrap">'
      + '<div class="hdr">'
      + '<div class="lw"><div class="lb"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg></div>'
      + '<div><span class="bn">GreenBite</span><span class="bt">Alimentation Durable &amp; Nutrition</span></div></div>'
      + '<div class="cr"><div>&#9679; Elghazela, Arianna, Tunisie</div><div>&#9679; +216 70875569</div><div>&#9679; www.greenbite.tn</div></div>'
      + '</div><div class="gb"></div>'
      + '<div class="dm"><div><div class="dt">Rapport - Regimes Alimentaires</div><div class="ds">Export officiel · Systeme GreenBite · Confidentiel</div></div>'
      + '<div class="dr"><b>Genere le <?= date('d/m/Y H:i') ?></b>Ref : GB-REG-<?= date('Ymd-Hi') ?><br>' + total + ' regime(s)</div></div>'
      + '<div class="sr">'
      + '<div class="sc"><div class="sn" style="color:#2D6A4F">' + total + '</div><div class="sl">Total</div></div>'
      + '<div class="sc"><div class="sn" style="color:#16a34a">' + acceptes + '</div><div class="sl">Acceptes</div></div>'
      + '<div class="sc"><div class="sn" style="color:#d97706">' + attente + '</div><div class="sl">En Attente</div></div>'
      + '<div class="sc"><div class="sn" style="color:#dc2626">' + refuses + '</div><div class="sl">Refuses</div></div>'
      + '<div class="sc"><div class="sn" style="color:#b45309">' + avgKcal.toLocaleString() + '</div><div class="sl">Moy. kcal/j</div></div>'
      + '</div>'
      + chartsHtml
      + '<div class="tw"><div class="tl">Liste complete des regimes alimentaires</div>'
      + '<table><thead><tr><th>#</th><th>Nom du Regime</th><th>Objectif</th><th>Duree</th><th>Calories/Jour</th><th>Soumis par</th><th>Statut</th></tr></thead>'
      + '<tbody>' + tableRows + '</tbody></table></div>'
      + '<div class="gb"></div>'
      + '<div class="ft">'
      + '<div class="fb"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>GreenBite</div>'
      + '<div class="fm">Document genere automatiquement · Reproduction interdite</div>'
      + '<div class="fc">Elghazela, Arianna, Tunisie<br>+216 70875569</div>'
      + '</div></div>'
      + '</body></html>';

    // Render in hidden off-screen div — no popup
    var ghost = document.createElement('div');
    ghost.style.cssText = 'position:fixed;left:-9999px;top:0;width:794px;background:#fff;z-index:-1';
    ghost.innerHTML = html;
    document.body.appendChild(ghost);
    var wrap = ghost.querySelector('#wrap') || ghost;
    html2pdf().set({
      margin: 0,
      filename: 'GreenBite_Regimes_<?= date('Y-m-d') ?>.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff', logging: false },
      jsPDF: { unit: 'px', format: [794, 1123], orientation: 'portrait' }
    }).from(wrap).save().then(function() {
      document.body.removeChild(ghost);
      btn.disabled = false;
      btn.innerHTML = '<i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF';
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  });
})();
</script>

<!-- ===== REFUSE MODAL ===== -->
<div id="refuseModal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:440px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.2);animation:fadeUp 0.25s ease">
    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
      <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:rgba(239,68,68,0.1);display:flex;align-items:center;justify-content:center">
        <i data-lucide="x-circle" style="width:1.25rem;height:1.25rem;color:#ef4444"></i>
      </div>
      <div>
        <div style="font-family:var(--font-heading);font-weight:700;font-size:1rem;color:var(--text-primary)">Refuser le régime</div>
        <div id="refuseRegimeNomLabel" style="font-size:0.78rem;color:var(--text-muted)"></div>
      </div>
    </div>

    <form method="POST" id="refuseForm" action="">
      <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        Motif du refus (optionnel)
      </label>
      <textarea name="commentaire" rows="3"
                placeholder="Ex: Contenu insuffisant, restrictions non précisées…"
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
  document.getElementById('refuseRegimeNomLabel').textContent = nom;
  document.getElementById('refuseForm').action = '<?= BASE_URL ?>/?page=admin-nutrition&action=regime-refuse&id=' + id;
  document.getElementById('refuseModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeRefuseModal() {
  document.getElementById('refuseModal').style.display = 'none';
}
document.getElementById('refuseModal').addEventListener('click', function(e) {
  if (e.target === this) closeRefuseModal();
});

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
document.getElementById('acceptConfirmModal').addEventListener('click', function(e) {
  if (e.target === this) closeAcceptConfirm();
});

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
document.getElementById('deleteConfirmBackModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteConfirmBack();
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeRefuseModal();
    closeAcceptConfirm();
    closeDeleteConfirmBack();
  }
});
</script>

<!-- ===== ACCEPT CONFIRM MODAL ===== -->
<div id="acceptConfirmModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:380px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(34,197,94,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="check-circle-2" style="width:1.625rem;height:1.625rem;color:#22c55e"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Accepter ce régime ?</h3>
    <p id="acceptConfirmMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeAcceptConfirm()"
              style="padding:0.6rem 1.25rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:background 0.2s"
              onmouseover="this.style.background='var(--border)'"
              onmouseout="this.style.background='var(--muted)'">Annuler</button>
      <a id="acceptConfirmLink" href="#"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.25rem;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.2s"
         onmouseover="this.style.boxShadow='0 4px 16px rgba(34,197,94,0.35)'"
         onmouseout="this.style.boxShadow='none'">
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
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Supprimer ce régime ?</h3>
    <p id="deleteConfirmBackMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeDeleteConfirmBack()"
              style="padding:0.6rem 1.25rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:background 0.2s"
              onmouseover="this.style.background='var(--border)'"
              onmouseout="this.style.background='var(--muted)'">Annuler</button>
      <a id="deleteConfirmBackLink" href="#"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.25rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.2s"
         onmouseover="this.style.boxShadow='0 4px 16px rgba(239,68,68,0.35)'"
         onmouseout="this.style.boxShadow='none'">
        <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i> Oui, supprimer
      </a>
    </div>
  </div>
</div>
