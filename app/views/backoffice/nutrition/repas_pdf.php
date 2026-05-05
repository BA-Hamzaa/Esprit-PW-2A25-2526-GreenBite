<?php
$repas = isset($repas) && is_array($repas) ? $repas : [];
$total     = count($repas);
$calMoy    = $total > 0 ? array_sum(array_column($repas, 'calories_total')) / $total : 0;
// types distribution
$types = ['petit_dejeuner' => 0, 'dejeuner' => 0, 'diner' => 0, 'collation' => 0];
foreach ($repas as $r) {
    $t = $r['type_repas'] ?? 'autre';
    if (isset($types[$t])) {
        $types[$t]++;
    }
}
$dateStr   = date('d/m/Y H:i');
$refNum    = 'GB-REP-' . date('Ymd-Hi');
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>GreenBite - Repas</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,Helvetica,sans-serif;color:#1a2332;background:#f0f4f0;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px}
.download-overlay{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(15,25,20,0.85);display:flex;align-items:center;justify-content:center;z-index:9999;flex-direction:column;gap:16px}
.download-overlay .spin-icon{width:56px;height:56px;border:3px solid rgba(82,183,136,0.3);border-top-color:#52B788;border-radius:50%;animation:spin 0.8s linear infinite}
.download-overlay p{color:#a7f3d0;font-size:14px;font-weight:600;letter-spacing:0.5px}
@keyframes spin{to{transform:rotate(360deg)}}
#pdf-content{width:794px;background:#fff;margin:0 auto;box-shadow:0 8px 40px rgba(0,0,0,0.18);position:absolute;left:-9999px;top:-9999px;visibility:hidden}
.pdf-header{background:linear-gradient(135deg,#1B4332 0%,#2D6A4F 60%,#40916C 100%);padding:26px 32px;display:flex;align-items:center;justify-content:space-between}
.logo-wrap{display:flex;align-items:center;gap:14px}
.logo-box{width:52px;height:52px;background:#1a2332;border-radius:13px;display:flex;align-items:center;justify-content:center;border:2px solid rgba(82,183,136,0.5);flex-shrink:0}
.brand-name{font-size:22px;font-weight:900;color:#fff;letter-spacing:-0.5px;display:block;line-height:1.1}
.brand-tag{font-size:8.5px;color:rgba(255,255,255,0.65);text-transform:uppercase;letter-spacing:1.5px;display:block;margin-top:3px}
.contact-right{text-align:right;color:rgba(255,255,255,0.88);font-size:10px;line-height:2}
.green-bar{height:3px;background:linear-gradient(90deg,#1B4332,#52B788,#95D5B2,#52B788,#1B4332)}
.doc-meta{background:#f8fafc;border-bottom:2px solid #e2e8f0;padding:14px 32px;display:flex;align-items:center;justify-content:space-between}
.doc-title{font-size:16px;font-weight:800;color:#1a2332;letter-spacing:-0.3px}
.doc-sub{font-size:9px;color:#64748b;margin-top:2px}
.doc-ref{text-align:right;font-size:9px;color:#94a3b8;line-height:1.8}
.doc-ref b{color:#334155;font-size:10px;display:block}
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);background:#e2e8f0;gap:1px;border-bottom:2px solid #d1d9e0}
.stat-cell{background:#fff;padding:14px 8px;text-align:center}
.stat-num{font-size:26px;font-weight:900;line-height:1;margin-bottom:4px}
.stat-lbl{font-size:8px;text-transform:uppercase;letter-spacing:1px;color:#64748b;font-weight:700}
.table-wrap{padding:22px 32px 28px}
.sec-lbl{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:#94a3b8;margin-bottom:10px;display:flex;align-items:center;gap:8px}
.sec-lbl::after{content:'';flex:1;height:1px;background:#e2e8f0}
table{width:100%;border-collapse:collapse;font-size:10px}
thead tr{background:linear-gradient(90deg,#1B4332,#2D6A4F)}
thead th{color:#fff;padding:9px 9px;text-align:left;font-weight:700;font-size:8px;text-transform:uppercase;letter-spacing:0.7px;white-space:nowrap;border:none}
tbody tr:nth-child(odd){background:#fff}
tbody tr:nth-child(even){background:#f8fafc}
tbody td{padding:8px 9px;vertical-align:middle;border-bottom:1px solid #f1f5f9}
.c-id{font-weight:800;color:#2D6A4F;width:30px}
.c-nom{font-weight:700;color:#1a2332}
.c-typ{color:#2D6A4F;font-weight:600;text-transform:capitalize}
.c-dat{color:#475569}
.c-cal{font-weight:800;color:#d97706;white-space:nowrap}
.pdf-footer{background:#1a2332;padding:13px 32px;display:flex;align-items:center;justify-content:space-between}
.f-brand{font-size:12px;font-weight:800;color:#a7f3d0;display:flex;align-items:center;gap:8px}
.f-meta{font-size:8.5px;color:#475569;text-align:center}
.f-contact{font-size:8.5px;color:#64748b;text-align:right;line-height:1.7}
</style>
</head>
<body>
<div class="download-overlay" id="overlay">
  <div class="spin-icon"></div>
  <p>Génération du PDF GreenBite...</p>
</div>
<div id="pdf-content">
  <div class="pdf-header">
    <div class="logo-wrap">
      <div class="logo-box">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
          <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
        </svg>
      </div>
      <div>
        <span class="brand-name"><span style="color:#52B788">Green</span><span style="color:#ffffff">Bite</span></span>
        <span class="brand-tag">Alimentation Durable &amp; Nutrition Intelligente</span>
      </div>
    </div>
    <div class="contact-right">
      <div>&#9679; Elghazela, Arianna, Tunisie</div>
      <div>&#9679; +216 70 875 569</div>
      <div>&#9679; www.greenbite.tn</div>
    </div>
  </div>
  <div class="green-bar"></div>
  <div class="doc-meta">
    <div>
      <div class="doc-title">Rapport — Base de Données Repas</div>
      <div class="doc-sub">Export officiel · Système GreenBite · Document Confidentiel</div>
    </div>
    <div class="doc-ref">
      <b>Généré le <?= $dateStr ?></b>
      Réf : <?= $refNum ?><br>
      <?= $total ?> repas au total
    </div>
  </div>
  <div class="stats-row">
    <div class="stat-cell"><div class="stat-num" style="color:#2D6A4F"><?= $total ?></div><div class="stat-lbl">Repas</div></div>
    <div class="stat-cell"><div class="stat-num" style="color:#d97706"><?= number_format($calMoy, 0) ?></div><div class="stat-lbl">Moyenne (Kcal)</div></div>
    <div class="stat-cell"><div class="stat-num" style="color:#0ea5e9"><?= $types['dejeuner'] + $types['diner'] ?></div><div class="stat-lbl">Principaux</div></div>
    <div class="stat-cell"><div class="stat-num" style="color:#10b981"><?= $types['petit_dejeuner'] + $types['collation'] ?></div><div class="stat-lbl">Secondaires</div></div>
  </div>
  <div class="table-wrap">
    <div class="sec-lbl">Liste complète des repas</div>
    <table>
      <thead><tr>
        <th>#</th><th>Nom du Repas</th><th>Type</th>
        <th>Date</th><th>Calories Totales</th>
      </tr></thead>
      <tbody>
      <?php if (empty($repas)): ?>
        <tr><td colspan="5" style="text-align:center;padding:24px;color:#94a3b8;font-style:italic">Aucun repas trouvé.</td></tr>
      <?php else: ?>
        <?php foreach ($repas as $r): ?>
        <tr>
          <td class="c-id"><?= (int)($r['id']??0) ?></td>
          <td class="c-nom"><?= htmlspecialchars((string)($r['nom']??'')) ?></td>
          <td class="c-typ"><?= htmlspecialchars(str_replace('_', ' ', $r['type_repas']??'')) ?></td>
          <td class="c-dat"><?= htmlspecialchars((string)($r['date_repas']??'—')) ?></td>
          <td class="c-cal"><?= number_format((int)($r['calories_total']??0)) ?> kcal</td>
        </tr>
        <?php endforeach; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div class="green-bar"></div>
  <div class="pdf-footer">
    <div class="f-brand">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
      </svg>
      <span style="color:#52B788">Green</span><span style="color:#a7f3d0">Bite</span>
    </div>
    <div class="f-meta">
      Document généré automatiquement par le système GreenBite<br>
      Toute reproduction non autorisée est strictement interdite.
    </div>
    <div class="f-contact">
      Elghazela, Arianna, Tunisie<br>
      +216 70 875 569
    </div>
  </div>
</div>
<script>
window.addEventListener('load', function() {
  var element = document.getElementById('pdf-content');
  element.style.visibility = 'visible';
  var filename = 'GreenBite_Repas_<?= date('Y-m-d') ?>.pdf';
  var opt = {
    margin:       0,
    filename:     filename,
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' },
    jsPDF:        { unit: 'px', format: [794, 1123], orientation: 'portrait' },
    pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
  };
  html2pdf().set(opt).from(element).save();
});
</script>
</body>
</html>
