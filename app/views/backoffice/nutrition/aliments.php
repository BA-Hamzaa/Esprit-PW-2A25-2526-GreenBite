<!-- Vue BackOffice : Liste des aliments -->
<?php
$aliments = isset($aliments) && is_array($aliments) ? $aliments : [];
$stats = ['total'=>0, 'avg_cal'=>0, 'avg_pro'=>0, 'avg_glu'=>0, 'avg_lip'=>0];
$sCal = 0; $sPro = 0; $sGlu = 0; $sLip = 0;
foreach ($aliments as $a) {
    $stats['total']++;
    $sCal += (int)($a['calories'] ?? 0);
    $sPro += (float)($a['proteines'] ?? 0);
    $sGlu += (float)($a['glucides'] ?? 0);
    $sLip += (float)($a['lipides'] ?? 0);
}
if ($stats['total'] > 0) {
    $stats['avg_cal'] = (int)round($sCal / $stats['total']);
    $stats['avg_pro'] = round($sPro / $stats['total'], 1);
    $stats['avg_glu'] = round($sGlu / $stats['total'], 1);
    $stats['avg_lip'] = round($sLip / $stats['total'], 1);
}
?>
<div style="padding:2rem">
  
  <!-- Page Header -->
  <div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:1rem;box-shadow:0 4px 16px rgba(202,138,4,0.18)">
        <i data-lucide="apple" style="width:1.5rem;height:1.5rem;color:#ca8a04"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">Base d'Aliments</h1>
        <p style="font-size:0.85rem;color:var(--text-muted);margin-top:2px"><?= count($aliments) ?> aliment<?= count($aliments) !== 1 ? 's' : '' ?> référencé<?= count($aliments) !== 1 ? 's' : '' ?></p>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <button type="button" id="exportAlimentsPdfBtn" class="btn" style="background:linear-gradient(135deg,#1f7a4f,#2E7D4F);color:#fff;border:1px solid #1f7a4f;box-shadow:0 4px 12px rgba(31,122,79,0.25)">
        <i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF
      </button>
      <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=add-aliment" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Nouvel aliment
      </a>
    </div>
  </div>

  <!-- KPIs -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem">
    <div class="card" style="padding:1rem 1.15rem;border:1px solid var(--border);background:var(--surface)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="apple" style="width:0.75rem;height:0.75rem;color:#ca8a04"></i> Total Aliments
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--text-primary);line-height:1"><?= $stats['total'] ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(234,88,12,0.25);background:linear-gradient(135deg,rgba(234,88,12,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="flame" style="width:0.75rem;height:0.75rem;color:var(--accent-orange)"></i> Moy. Calories
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:var(--accent-orange);line-height:1"><?= number_format($stats['avg_cal'], 0, ',', ' ') ?></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(59,130,246,0.25);background:linear-gradient(135deg,rgba(59,130,246,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="beef" style="width:0.75rem;height:0.75rem;color:#3b82f6"></i> Protéines
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#2563eb;line-height:1"><?= $stats['avg_pro'] ?><span style="font-size:0.75rem;font-weight:600;color:var(--text-muted);margin-left:0.15rem">g</span></div>
    </div>
    <div class="card" style="padding:1rem 1.15rem;border:1px solid rgba(16,185,129,0.25);background:linear-gradient(135deg,rgba(16,185,129,0.06),transparent)">
      <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.35rem;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="wheat" style="width:0.75rem;height:0.75rem;color:#10b981"></i> Glucides
      </div>
      <div style="font-family:var(--font-heading);font-size:1.65rem;font-weight:800;color:#059669;line-height:1"><?= $stats['avg_glu'] ?><span style="font-size:0.75rem;font-weight:600;color:var(--text-muted);margin-left:0.15rem">g</span></div>
    </div>
  </div>

  <!-- Charts -->
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1rem;margin-bottom:1.5rem">
    <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
        <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Répartition des Macros Moyennes</h3>
        <span class="badge badge-gray">Pourcentages</span>
      </div>
      <canvas id="alimentsMacrosChart" style="max-height:240px"></canvas>
    </div>
    <div class="card" style="padding:1rem 1.1rem;border:1px solid var(--border);background:var(--surface)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
        <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:800;color:var(--text-primary)">Calories vs Protéines (Top 5 Aliments)</h3>
        <span class="badge badge-gray">Valeurs</span>
      </div>
      <canvas id="alimentsTopChart" style="max-height:240px"></canvas>
    </div>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <table class="table" style="width:100%;border-collapse:collapse">
      <thead>
        <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
          <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Aliment</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Calories</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Protéines</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Glucides</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Lipides</th>
          <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:140px">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($aliments)): ?>
          <tr>
            <td colspan="6" style="padding:3rem;text-align:center;color:var(--text-muted)">
              <i data-lucide="apple" style="width:2rem;height:2rem;display:block;margin:0 auto 0.5rem;opacity:0.3"></i>
              Aucun aliment référencé.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($aliments as $a): ?>
            <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(82,183,136,0.03)'" onmouseout="this.style.background=''">
              <!-- Nom -->
              <td style="padding:0.75rem 0.875rem">
                <div style="display:flex;align-items:center;gap:0.625rem">
                  <div style="width:2rem;height:2rem;border-radius:0.625rem;background:linear-gradient(135deg,rgba(202,138,4,0.12),rgba(202,138,4,0.06));border:1px solid rgba(202,138,4,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i data-lucide="leaf" style="width:0.75rem;height:0.75rem;color:#ca8a04"></i>
                  </div>
                  <div>
                    <div style="font-weight:700;font-size:0.875rem;color:var(--text-primary)"><?= htmlspecialchars($a['nom']) ?></div>
                    <div style="font-size:0.65rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">#<?= $a['id'] ?></div>
                  </div>
                </div>
              </td>
              <!-- Calories -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--accent-orange)"><?= $a['calories'] ?></span>
                <span style="font-size:0.65rem;color:var(--text-muted);display:block">kcal</span>
              </td>
              <!-- Protéines -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.6rem;border-radius:var(--radius-full);background:rgba(59,130,246,0.1);color:#3b82f6;font-size:0.72rem;font-weight:700;border:1px solid rgba(59,130,246,0.2)">
                  P: <?= $a['proteines'] ?>g
                </span>
              </td>
              <!-- Glucides -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.6rem;border-radius:var(--radius-full);background:rgba(34,197,94,0.1);color:#16a34a;font-size:0.72rem;font-weight:700;border:1px solid rgba(34,197,94,0.2)">
                  G: <?= $a['glucides'] ?>g
                </span>
              </td>
              <!-- Lipides -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.6rem;border-radius:var(--radius-full);background:rgba(245,158,11,0.1);color:#b45309;font-size:0.72rem;font-weight:700;border:1px solid rgba(245,158,11,0.2)">
                  L: <?= $a['lipides'] ?>g
                </span>
              </td>
              <!-- Actions -->
              <td style="padding:0.75rem 0.875rem;text-align:center">
                <div style="display:inline-flex;gap:0.4rem;justify-content:center;align-items:center;flex-wrap:nowrap;white-space:nowrap">
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=edit-aliment&id=<?= $a['id'] ?>"
                     style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:rgba(59,130,246,0.1);color:#3b82f6;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(59,130,246,0.2)"
                     onmouseover="this.style.background='rgba(59,130,246,0.18)';this.style.transform='translateY(-1px)'"
                     onmouseout="this.style.background='rgba(59,130,246,0.1)';this.style.transform='none'">
                    <i data-lucide="edit" style="width:0.75rem;height:0.75rem"></i> Modifier
                  </a>
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=delete-aliment&id=<?= $a['id'] ?>"
                     style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);transition:all 0.2s;text-decoration:none"
                     onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                     onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                     title="Supprimer"
                     data-confirm="Supprimer cet aliment ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer">
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

  // Repartition des Macros Chart (Doughnut)
  const macrosCtx = document.getElementById('alimentsMacrosChart').getContext('2d');
  new Chart(macrosCtx, {
    type: 'doughnut',
    data: {
      labels: ['Protéines', 'Glucides', 'Lipides'],
      datasets: [{
        data: [
          <?= $stats['avg_pro'] ?>,
          <?= $stats['avg_glu'] ?>,
          <?= $stats['avg_lip'] ?>
        ],
        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
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
  // Top 5 highest calorie aliments
  $sortedAliments = $aliments;
  usort($sortedAliments, function($a, $b) {
      return ((int)($b['calories']??0)) <=> ((int)($a['calories']??0));
  });
  $top5 = array_slice($sortedAliments, 0, 5);
  $labelsTop = array_map(function($a) { return substr($a['nom'] ?? 'Inconnu', 0, 15); }, $top5);
  $calTop = array_map(function($a) { return (int)($a['calories'] ?? 0); }, $top5);
  $proTop = array_map(function($a) { return (float)($a['proteines'] ?? 0); }, $top5);
  ?>

  const topCtx = document.getElementById('alimentsTopChart').getContext('2d');
  new Chart(topCtx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($labelsTop) ?>,
      datasets: [
        {
          label: 'Calories (Kcal)',
          data: <?= json_encode($calTop) ?>,
          backgroundColor: 'rgba(245,158,11,0.8)',
          borderRadius: 4,
          maxBarThickness: 30,
          barPercentage: 0.6,
          categoryPercentage: 0.7
        },
        {
          label: 'Protéines (g)',
          data: <?= json_encode($proTop) ?>,
          backgroundColor: 'rgba(59,130,246,0.8)',
          borderRadius: 4,
          maxBarThickness: 30,
          barPercentage: 0.6,
          categoryPercentage: 0.7
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: { size: 10 } } } },
      scales: {
        y: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, border: { display: false } },
        x: { grid: { display: false }, border: { display: false }, ticks: { font: { weight: '600' } } }
      }
    }
  });

  const exportBtn = document.getElementById('exportAlimentsPdfBtn');
  if (exportBtn) {
    const rows = <?= json_encode(array_map(function($a) {
      return [
        (int)($a['id'] ?? 0),
        htmlspecialchars((string)($a['nom'] ?? '')),
        (int)($a['calories'] ?? 0),
        number_format((float)($a['proteines'] ?? 0), 1) . 'g',
        number_format((float)($a['glucides'] ?? 0), 1) . 'g',
        number_format((float)($a['lipides'] ?? 0), 1) . 'g',
      ];
    }, $aliments), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    exportBtn.addEventListener('click', function() {
      exportBtn.disabled = true;
      exportBtn.textContent = 'Génération...';

      var tableRows = rows.map(function(r) {
        return '<tr style="border-bottom:1px solid #f1f5f9">'
          + '<td style="padding:7px 9px;font-weight:800;color:#2D6A4F;width:28px">' + r[0] + '</td>'
          + '<td style="padding:7px 9px;font-weight:700;color:#1a2332">' + r[1] + '</td>'
          + '<td style="padding:7px 9px;font-weight:800;color:#d97706">' + r[2] + '</td>'
          + '<td style="padding:7px 9px;color:#3b82f6;font-weight:700">' + r[3] + '</td>'
          + '<td style="padding:7px 9px;color:#16a34a;font-weight:700">' + r[4] + '</td>'
          + '<td style="padding:7px 9px;color:#b45309;font-weight:700">' + r[5] + '</td>'
          + '</tr>';
      }).join('');

      var total   = <?= count($aliments) ?>;
      var avgCal  = <?= $stats['avg_cal'] ?? 0 ?>;
      var avgPro  = <?= $stats['avg_pro'] ?? 0 ?>;
      var avgGlu  = <?= $stats['avg_glu'] ?? 0 ?>;

      var html = '<!doctype html><html><head><meta charset="utf-8"><title>GreenBite - Aliments</title>'
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
        + '<div class="dm"><div><div class="dt">Rapport - Base de Données Aliments</div><div class="ds">Export officiel · Systeme GreenBite · Confidentiel</div></div>'
        + '<div class="dr"><b>Genere le <?= date('d/m/Y H:i') ?></b>Ref : GB-ALI-<?= date('Ymd-Hi') ?><br>' + total + ' aliments</div></div>'
        + '<div class="sr">'
        + '<div class="sc"><div class="sn" style="color:#2D6A4F">' + total + '</div><div class="sl">Aliments</div></div>'
        + '<div class="sc"><div class="sn" style="color:#d97706">' + avgCal + '</div><div class="sl">Moy. kcal</div></div>'
        + '<div class="sc"><div class="sn" style="color:#3b82f6">' + avgPro + 'g</div><div class="sl">Proteines Moy.</div></div>'
        + '<div class="sc"><div class="sn" style="color:#16a34a">' + avgGlu + 'g</div><div class="sl">Glucides Moy.</div></div>'
        + '</div>'
        + '<div class="tw"><div class="tl">Liste complete des aliments</div>'
        + '<table><thead><tr><th>#</th><th>Nom de l\'Aliment</th><th>Calories (kcal)</th><th>Proteines (g)</th><th>Glucides (g)</th><th>Lipides (g)</th></tr></thead>'
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
        filename: 'GreenBite_Aliments_<?= date('Y-m-d') ?>.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff', logging: false },
        jsPDF: { unit: 'px', format: [794, 1123], orientation: 'portrait' }
      }).from(wrap).save().then(function() {
        document.body.removeChild(ghost);
        exportBtn.disabled = false;
        exportBtn.innerHTML = '<i data-lucide="file-down" style="width:1rem;height:1rem"></i> Export PDF';
        if (typeof lucide !== 'undefined') lucide.createIcons();
      });
    });
  }
});
</script>
