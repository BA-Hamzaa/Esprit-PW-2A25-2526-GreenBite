<!-- Vue BackOffice : Liste des repas -->
<?php
$repas = isset($repas) && is_array($repas) ? $repas : [];
$stats = ['total'=>0, 'avg_cal'=>0];
$sCal = 0;
$typesCount = ['petit_dejeuner'=>0, 'dejeuner'=>0, 'diner'=>0, 'collation'=>0];
foreach ($repas as $r) {
    $stats['total']++;
    $sCal += (int)($r['calories_total'] ?? 0);
    $t = $r['type_repas'] ?? 'autre';
    if (isset($typesCount[$t])) {
        $typesCount[$t]++;
    }
}
if ($stats['total'] > 0) {
    $stats['avg_cal'] = (int)round($sCal / $stats['total']);
}
?>
<div style="padding:2rem">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 4px 16px rgba(45,106,79,0.18)">
        <i data-lucide="utensils-crossed" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">Gestion des Repas</h1>
        <p style="font-size:0.85rem;color:var(--text-muted);margin-top:2px"><?= count($repas) ?> repas enregistré<?= count($repas) !== 1 ? 's' : '' ?></p>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <button type="button" id="exportRepasPdfBtn" class="btn" style="background:linear-gradient(135deg,#1f7a4f,#2E7D4F);color:#fff;border:1px solid #1f7a4f;box-shadow:0 4px 12px rgba(31,122,79,0.25)">
        <i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF
      </button>
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=add" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Ajouter un repas
      </a>
    </div>
  </div>

  <!-- KPIs -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem">
    <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="utensils-crossed" style="width:0.75rem;height:0.75rem;color:var(--primary)"></i> Total Repas
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--text-primary);line-height:1"><?= $stats['total'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(234,88,12,0.25);background:linear-gradient(135deg,rgba(234,88,12,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="flame" style="width:0.75rem;height:0.75rem;color:var(--accent-orange)"></i> Moy. Calories
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--accent-orange);line-height:1"><?= number_format($stats['avg_cal'], 0, ',', ' ') ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(14,165,233,0.25);background:linear-gradient(135deg,rgba(14,165,233,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="sun" style="width:0.75rem;height:0.75rem;color:#0ea5e9"></i> Déjeuners
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#0284c7;line-height:1"><?= $typesCount['dejeuner'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(139,92,246,0.25);background:linear-gradient(135deg,rgba(139,92,246,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="moon" style="width:0.75rem;height:0.75rem;color:#8b5cf6"></i> Dîners
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#6d28d9;line-height:1"><?= $typesCount['diner'] ?></div>
    </div>
  </div>

  <!-- Charts -->
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1rem;margin-bottom:1.5rem">
    <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
        <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Types de Repas</h3>
        <span class="badge badge-gray">Distribution</span>
      </div>
      <canvas id="repasTypesChart" style="max-height:240px"></canvas>
    </div>
    <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
        <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Calories par Type</h3>
        <span class="badge badge-gray">Kcal</span>
      </div>
      <canvas id="repasCaloriesChart" style="max-height:240px"></canvas>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card" style="padding:0;overflow:hidden">
    <table class="table" style="width:100%;border-collapse:collapse">
      <thead>
        <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
          <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Repas</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Type</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Date</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Calories</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Statut</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:140px">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($repas)): ?>
          <tr>
            <td colspan="6" style="padding:3.5rem 2rem;text-align:center;color:var(--text-muted)">
              <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:var(--muted);border-radius:var(--radius-full);margin-bottom:1rem">
                <i data-lucide="inbox" style="width:2rem;height:2rem;color:var(--text-muted)"></i>
              </div>
              <p style="font-weight:600;color:var(--text-secondary);margin-top:0.5rem">Aucun repas enregistré</p>
              <p style="font-size:0.8rem;margin-top:0.25rem">Commencez par ajouter un repas.</p>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($repas as $r): ?>
            <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(82,183,136,0.03)'" onmouseout="this.style.background=''">
              <!-- Nom -->
              <td style="padding:0.75rem 0.875rem">
                <div style="display:flex;align-items:center;gap:0.625rem">
                  <div style="width:2rem;height:2rem;border-radius:0.625rem;background:linear-gradient(135deg,rgba(45,106,79,0.1),rgba(82,183,136,0.07));border:1px solid rgba(45,106,79,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i data-lucide="utensils" style="width:0.75rem;height:0.75rem;color:var(--primary)"></i>
                  </div>
                  <div>
                    <div style="font-weight:700;font-size:0.875rem;color:var(--text-primary)"><?= htmlspecialchars($r['nom']) ?></div>
                    <div style="font-size:0.65rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">#<?= $r['id'] ?> <?= isset($r['soumis_par']) ? ' - Par: ' . htmlspecialchars($r['soumis_par']) : '' ?></div>
                  </div>
                </div>
              </td>
              <!-- Type -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.7rem;border-radius:var(--radius-full);background:rgba(45,106,79,0.08);color:var(--primary);font-size:0.72rem;font-weight:700;border:1px solid rgba(45,106,79,0.18)">
                  <?= htmlspecialchars($r['type_repas']) ?>
                </span>
              </td>
              <!-- Date -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="display:inline-flex;align-items:center;gap:0.35rem;color:var(--text-secondary);font-size:0.82rem">
                  <i data-lucide="calendar" style="width:0.72rem;height:0.72rem"></i>
                  <?= $r['date_repas'] ?>
                </span>
              </td>
              <!-- Calories -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--accent-orange)"><?= $r['calories_total'] ?? '—' ?></span>
                <span style="font-size:0.65rem;color:var(--text-muted);display:block">kcal</span>
              </td>
              <!-- Statut -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <?php
                  $st = $r['statut'] ?? 'accepte'; // Par défaut si la colonne est ancienne
                  if ($st === 'en_attente') {
                      echo '<span class="badge" style="background:#fef3c7;color:#d97706;border:1px solid #fde68a"><i data-lucide="clock" style="width:0.75rem;height:0.75rem"></i> En attente</span>';
                  } elseif ($st === 'accepte') {
                      echo '<span class="badge" style="background:#dcfce7;color:#16a34a;border:1px solid #bbf7d0"><i data-lucide="check-circle" style="width:0.75rem;height:0.75rem"></i> Accepté</span>';
                  } else {
                      echo '<span class="badge" style="background:#fee2e2;color:#ef4444;border:1px solid #fca5a5"><i data-lucide="x-circle" style="width:0.75rem;height:0.75rem"></i> Refusé</span>';
                  }
                ?>
              </td>
              <!-- Actions -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <div style="display:inline-flex;gap:0.4rem;justify-content:center;align-items:center;flex-wrap:nowrap;white-space:nowrap">
                  <?php if (($r['statut'] ?? '') === 'en_attente'): ?>
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=repas-accept&id=<?= $r['id'] ?>" class="btn" style="padding:0.35rem 0.75rem;background:#dcfce7;color:#16a34a;border:1px solid #bbf7d0;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none" title="Accepter">
                      <i data-lucide="check" style="width:0.75rem;height:0.75rem"></i>
                    </a>
                    <button type="button" onclick="openRefuseModal(<?= $r['id'] ?>)" class="btn" style="padding:0.35rem 0.75rem;background:#fee2e2;color:#ef4444;border:1px solid #fca5a5;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;cursor:pointer" title="Refuser">
                      <i data-lucide="x" style="width:0.75rem;height:0.75rem"></i>
                    </button>
                  <?php else: ?>
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=edit&id=<?= $r['id'] ?>"
                       style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:rgba(59,130,246,0.1);color:#3b82f6;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(59,130,246,0.2)"
                       onmouseover="this.style.background='rgba(59,130,246,0.18)';this.style.transform='translateY(-1px)'"
                       onmouseout="this.style.background='rgba(59,130,246,0.1)';this.style.transform='none'">
                      <i data-lucide="edit" style="width:0.75rem;height:0.75rem"></i> Modifier
                    </a>
                  <?php endif; ?>
                  
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=delete&id=<?= $r['id'] ?>"
                     style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);transition:all 0.2s;text-decoration:none"
                     onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                     onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                     title="Supprimer"
                     data-confirm="Supprimer ce repas ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer">
                    <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                  </a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const isDark = document.documentElement.classList.contains('dark-theme');
  const textColor = isDark ? '#f8fafc' : '#1e293b';
  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  
  Chart.defaults.color = textColor;
  Chart.defaults.font.family = "'Inter', sans-serif";

  const typesCtx = document.getElementById('repasTypesChart').getContext('2d');
  new Chart(typesCtx, {
    type: 'doughnut',
    data: {
      labels: ['Petit déjeuner', 'Déjeuner', 'Dîner', 'Collation'],
      datasets: [{
        data: [
          <?= $typesCount['petit_dejeuner'] ?>,
          <?= $typesCount['dejeuner'] ?>,
          <?= $typesCount['diner'] ?>,
          <?= $typesCount['collation'] ?>
        ],
        backgroundColor: ['#f59e0b', '#0ea5e9', '#8b5cf6', '#10b981'],
        borderWidth: 2,
        borderColor: isDark ? '#1e293b' : '#ffffff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: { position: 'right', labels: { boxWidth: 12, padding: 15, font: { size: 11, weight: '600' } } }
      }
    }
  });

  <?php
  $calByType = ['petit_dejeuner'=>0, 'dejeuner'=>0, 'diner'=>0, 'collation'=>0];
  foreach ($repas as $r) {
      $t = $r['type_repas'] ?? 'autre';
      if (isset($calByType[$t])) {
          $calByType[$t] += (int)($r['calories_total'] ?? 0);
      }
  }
  $avgCalByType = [];
  foreach ($calByType as $k => $sum) {
      $avgCalByType[$k] = $typesCount[$k] > 0 ? round($sum / $typesCount[$k]) : 0;
  }
  ?>

  const calCtx = document.getElementById('repasCaloriesChart').getContext('2d');
  new Chart(calCtx, {
    type: 'bar',
    data: {
      labels: ['P.D.', 'Déj.', 'Dîn.', 'Coll.'],
      datasets: [{
        label: 'Kcal moyennes',
        data: [
          <?= $avgCalByType['petit_dejeuner'] ?>,
          <?= $avgCalByType['dejeuner'] ?>,
          <?= $avgCalByType['diner'] ?>,
          <?= $avgCalByType['collation'] ?>
        ],
        backgroundColor: ['rgba(245,158,11,0.8)', 'rgba(14,165,233,0.8)', 'rgba(139,92,246,0.8)', 'rgba(16,185,129,0.8)'],
        borderRadius: 4,
        maxBarThickness: 30,
        barPercentage: 0.6,
        categoryPercentage: 0.7
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, border: { display: false } },
        x: { grid: { display: false }, border: { display: false }, ticks: { font: { weight: '600' } } }
      }
    }
  });

  const exportBtn = document.getElementById('exportRepasPdfBtn');
  if (exportBtn) {
    const rows = <?= json_encode(array_map(function($r) {
      $typeLabel = str_replace('_', ' ', $r['type_repas'] ?? '');
      return [
        (int)($r['id'] ?? 0),
        htmlspecialchars((string)($r['nom'] ?? '')),
        ucfirst($typeLabel),
        htmlspecialchars((string)($r['date_repas'] ?? '—')),
        number_format((int)($r['calories_total'] ?? 0)) . ' kcal',
      ];
    }, $repas), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    exportBtn.addEventListener('click', function() {
      exportBtn.disabled = true;
      exportBtn.textContent = 'Génération...';

      var tableRows = rows.map(function(r) {
        return '<tr style="border-bottom:1px solid #f1f5f9">'
          + '<td style="padding:7px 9px;font-weight:800;color:#2D6A4F;width:28px">' + r[0] + '</td>'
          + '<td style="padding:7px 9px;font-weight:700;color:#1a2332">' + r[1] + '</td>'
          + '<td style="padding:7px 9px;color:#2D6A4F;font-weight:600">' + r[2] + '</td>'
          + '<td style="padding:7px 9px;color:#475569">' + r[3] + '</td>'
          + '<td style="padding:7px 9px;font-weight:800;color:#d97706">' + r[4] + '</td>'
          + '</tr>';
      }).join('');

      var total   = <?= count($repas) ?>;
      var avgCal  = <?= $stats['avg_cal'] ?? 0 ?>;
      var dejCount = <?= $typesCount['dejeuner'] ?? 0 ?>;
      var dinCount  = <?= $typesCount['diner'] ?? 0 ?>;

      var html = '<!doctype html><html><head><meta charset="utf-8"><title>GreenBite - Repas</title>'
        + '<style>*{margin:0;padding:0;box-sizing:border-box}body{font-family:Arial,sans-serif;color:#1a2332;background:#fff}'
        + '#wrap{width:794px;margin:0 auto}'
        + '.hdr{background:linear-gradient(135deg,#1B4332,#2D6A4F,#40916C);padding:24px 30px;display:flex;align-items:center;justify-content:space-between}'
        + '.lw{display:flex;align-items:center;gap:12px}'
        + '.lb{width:48px;height:48px;background:#1a2332;border-radius:12px;border:2px solid rgba(82,183,136,0.5);display:flex;align-items:center;justify-content:center}'
        + '.bn{font-size:20px;font-weight:900;color:#fff;display:block}.bt{font-size:8px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1.2px;display:block;margin-top:2px}'
        + '.cr{text-align:right;color:rgba(255,255,255,0.85);font-size:9.5px;line-height:1.9}'
        + '.gb{height:3px;background:linear-gradient(90deg,#1B4332,#52B788,#95D5B2,#52B788,#1B4332)}'
        + '.dm{background:#f8fafc;border-bottom:2px solid #e2e8f0;padding:12px 30px;display:flex;align-items:center;justify-content:space-between}'
        + '.dt{font-size:15px;font-weight:800;color:#1a2332}.ds{font-size:9px;color:#64748b;margin-top:2px}'
        + '.dr{text-align:right;font-size:9px;color:#94a3b8;line-height:1.8}.dr b{color:#334155;font-size:10px;display:block}'
        + '.sr{display:grid;grid-template-columns:repeat(4,1fr);background:#e2e8f0;gap:1px;border-bottom:2px solid #d1d9e0}'
        + '.sc{background:#fff;padding:12px 8px;text-align:center}'
        + '.sn{font-size:24px;font-weight:900;line-height:1;margin-bottom:3px}.sl{font-size:8px;text-transform:uppercase;letter-spacing:1px;color:#64748b;font-weight:700}'
        + '.tw{padding:20px 30px 24px}.tl{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#94a3b8;margin-bottom:8px}'
        + 'table{width:100%;border-collapse:collapse;font-size:9.5px}'
        + 'thead tr{background:linear-gradient(90deg,#1B4332,#2D6A4F)}'
        + 'thead th{color:#fff;padding:9px 9px;text-align:left;font-size:7.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.6px}'
        + 'tbody tr:nth-child(even){background:#f8fafc}'
        + '.ft{background:#1a2332;padding:12px 30px;display:flex;align-items:center;justify-content:space-between}'
        + '.fb{font-size:11px;font-weight:800;color:#a7f3d0;display:flex;align-items:center;gap:8px}'
        + '.fm{font-size:8.5px;color:#475569;text-align:center}.fc{font-size:8.5px;color:#64748b;text-align:right;line-height:1.7}'
        + '</style></head><body>'
        + '<div id="wrap">'
        + '<div class="hdr"><div class="lw"><div class="lb"><svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg></div>'
        + '<div><span class="bn">GreenBite</span><span class="bt">Alimentation Durable &amp; Nutrition</span></div></div>'
        + '<div class="cr"><div>&#9679; Elghazela, Arianna, Tunisie</div><div>&#9679; +216 70 875 569</div><div>&#9679; www.greenbite.tn</div></div></div>'
        + '<div class="gb"></div>'
        + '<div class="dm"><div><div class="dt">Rapport - Base de Données Repas</div><div class="ds">Export officiel · Systeme GreenBite · Confidentiel</div></div>'
        + '<div class="dr"><b>Genere le <?= date('d/m/Y H:i') ?></b>Ref : GB-REP-<?= date('Ymd-Hi') ?><br>' + total + ' repas</div></div>'
        + '<div class="sr">'
        + '<div class="sc"><div class="sn" style="color:#2D6A4F">' + total + '</div><div class="sl">Repas</div></div>'
        + '<div class="sc"><div class="sn" style="color:#d97706">' + avgCal + '</div><div class="sl">Moy. kcal</div></div>'
        + '<div class="sc"><div class="sn" style="color:#0ea5e9">' + dejCount + '</div><div class="sl">Dejeuners</div></div>'
        + '<div class="sc"><div class="sn" style="color:#8b5cf6">' + dinCount + '</div><div class="sl">Diners</div></div>'
        + '</div>'
        + '<div class="tw"><div class="tl">Liste complete des repas</div>'
        + '<table><thead><tr><th>#</th><th>Nom du Repas</th><th>Type</th><th>Date</th><th>Calories Totales</th></tr></thead>'
        + '<tbody>' + tableRows + '</tbody></table></div>'
        + '<div class="gb"></div>'
        + '<div class="ft">'
        + '<div class="fb"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>GreenBite</div>'
        + '<div class="fm">Document genere automatiquement · Reproduction interdite</div>'
        + '<div class="fc">Elghazela, Arianna, Tunisie<br>+216 70 875 569</div>'
        + '</div></div></body></html>';

      var ghost = document.createElement('div');
      ghost.style.cssText = 'position:fixed;left:-9999px;top:0;width:794px;background:#fff;z-index:-1';
      ghost.innerHTML = html;
      document.body.appendChild(ghost);
      var wrap = ghost.querySelector('#wrap') || ghost;
      html2pdf().set({
        margin: 0,
        filename: 'GreenBite_Repas_<?= date('Y-m-d') ?>.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff', logging: false },
        jsPDF: { unit: 'px', format: [794, 1123], orientation: 'portrait' }
      }).from(wrap).save().then(function() {
        document.body.removeChild(ghost);
        exportBtn.disabled = false;
        exportBtn.innerHTML = '<i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF';
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  }
});

// Modal Refus
function openRefuseModal(id) {
  const modal = document.getElementById('refuseModal');
  if(modal) {
    modal.style.display = 'flex';
    document.getElementById('refuseForm').action = '<?= BASE_URL ?>/?page=admin-nutrition&action=repas-refuse&id=' + id;
  }
}
function closeRefuseModal() {
  const modal = document.getElementById('refuseModal');
  if(modal) modal.style.display = 'none';
}
</script>

<!-- Modal de Refus -->
<div id="refuseModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center">
  <div class="card" style="width:100%;max-width:400px;padding:2rem;position:relative">
    <button type="button" onclick="closeRefuseModal()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;cursor:pointer"><i data-lucide="x" style="width:1.25rem;height:1.25rem;color:var(--text-muted)"></i></button>
    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;color:#ef4444">
      <i data-lucide="alert-triangle" style="width:1.5rem;height:1.5rem"></i>
      <h3 style="font-size:1.25rem;font-weight:700;margin:0">Refuser le repas</h3>
    </div>
    <form id="refuseForm" method="POST">
      <div class="form-group mb-4">
        <label class="form-label" style="font-size:0.875rem">Raison du refus (optionnel)</label>
        <textarea name="admin_comment" class="form-textarea" rows="3" placeholder="Ex: Informations nutritionnelles incohérentes..."></textarea>
      </div>
      <div style="display:flex;gap:1rem">
        <button type="button" onclick="closeRefuseModal()" class="btn btn-outline" style="flex:1">Annuler</button>
        <button type="submit" class="btn" style="flex:1;background:#ef4444;color:#fff;border:none">Confirmer</button>
      </div>
    </form>
  </div>
</div>
