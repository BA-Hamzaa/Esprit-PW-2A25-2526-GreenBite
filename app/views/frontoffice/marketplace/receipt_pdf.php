<?php
$commande = isset($commande) && is_array($commande) ? $commande : [];
$lignes = isset($lignes) && is_array($lignes) ? $lignes : [];

$id = $commande['id'] ?? 0;
$nom = $commande['client_nom'] ?? 'Client';
$email = $commande['client_email'] ?? '';
$phone = $commande['client_telephone'] ?? '';
$adresse = $commande['client_adresse'] ?? '';
$total = $commande['total'] ?? 0;
$date = $commande['created_at'] ?? date('Y-m-d H:i:s');
$dateStr = date('d/m/Y H:i', strtotime($date));
$mode_paiement = $commande['mode_paiement'] ?? '';
$refNum = 'GB-REC-' . str_pad($id, 5, '0', STR_PAD_LEFT);

$paymentLabel = ($mode_paiement === 'carte') ? 'Paiement par Carte (Stripe)' : 'Paiement à la Livraison';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Reçu - Commande #<?= str_pad($id, 5, '0', STR_PAD_LEFT) ?></title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; color: #1a2332; background: #f0f4f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
.download-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,25,20,0.85); display: flex; align-items: center; justify-content: center; z-index: 9999; flex-direction: column; gap: 16px; }
.download-overlay .spin-icon { width: 56px; height: 56px; border: 3px solid rgba(82,183,136,0.3); border-top-color: #52B788; border-radius: 50%; animation: spin 0.8s linear infinite; }
.download-overlay p { color: #a7f3d0; font-size: 14px; font-weight: 600; letter-spacing: 0.5px; }
@keyframes spin { to { transform: rotate(360deg); } }
#pdf-content { width: 794px; background: #fff; margin: 0 auto; box-shadow: 0 8px 40px rgba(0,0,0,0.18); position: relative; }
.pdf-header { background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 60%, #40916C 100%); padding: 36px 40px; display: flex; align-items: flex-start; justify-content: space-between; color: white; }
.logo-wrap { display: flex; align-items: center; gap: 16px; }
.logo-box { width: 64px; height: 64px; background: #1a2332; border-radius: 16px; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(82,183,136,0.5); flex-shrink: 0; }
.brand-name { font-size: 28px; font-weight: 900; letter-spacing: -0.5px; display: block; line-height: 1.1; }
.brand-tag { font-size: 11px; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-top: 5px; }
.receipt-title { text-align: right; }
.receipt-title h1 { font-size: 32px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; color: #a7f3d0; }
.receipt-title p { font-size: 13px; color: rgba(255,255,255,0.85); }
.green-bar { height: 4px; background: linear-gradient(90deg, #1B4332, #52B788, #95D5B2, #52B788, #1B4332); }
.details-section { display: flex; padding: 40px; gap: 40px; border-bottom: 2px solid #f1f5f9; }
.details-box { flex: 1; }
.details-box h3 { font-size: 12px; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 1px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.details-box p { font-size: 14px; line-height: 1.6; color: #334155; }
.details-box strong { color: #1a2332; font-weight: 700; }
.table-wrap { padding: 40px; }
table { width: 100%; border-collapse: collapse; }
thead th { background: #f8fafc; color: #64748b; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #e2e8f0; }
tbody td { padding: 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 13px; }
tbody tr:last-child td { border-bottom: none; }
.c-item { font-weight: 700; color: #1a2332; font-size: 14px; }
.c-cat { font-size: 11px; color: #64748b; text-transform: uppercase; margin-top: 4px; display: block; }
.c-qty { font-weight: 600; color: #475569; text-align: center; }
.c-price { color: #475569; text-align: right; }
.c-total { font-weight: 800; color: #2D6A4F; text-align: right; }
.summary-box { width: 320px; margin-left: auto; background: #f8fafc; border-radius: 12px; padding: 24px; margin-top: 20px; border: 1px solid #e2e8f0; }
.summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 14px; color: #475569; }
.summary-row.total { margin-top: 16px; padding-top: 16px; border-top: 2px dashed #cbd5e1; font-size: 20px; font-weight: 900; color: #1B4332; }
.paid-stamp { position: absolute; top: 180px; right: 40px; border: 4px solid #16a34a; color: #16a34a; font-size: 24px; font-weight: 900; text-transform: uppercase; padding: 12px 24px; border-radius: 8px; transform: rotate(15deg); opacity: 0.15; letter-spacing: 4px; pointer-events: none; }
.pdf-footer { background: #1a2332; padding: 24px 40px; display: flex; align-items: center; justify-content: space-between; margin-top: 40px; }
.f-brand { font-size: 14px; font-weight: 800; color: #a7f3d0; display: flex; align-items: center; gap: 10px; }
.f-meta { font-size: 11px; color: #64748b; text-align: center; line-height: 1.5; }
.f-contact { font-size: 11px; color: #94a3b8; text-align: right; line-height: 1.6; }
</style>
</head>
<body>
<div class="download-overlay" id="overlay">
  <div class="spin-icon"></div>
  <p>Génération de votre reçu...</p>
</div>
<div id="pdf-content">
  <?php if($mode_paiement === 'carte'): ?>
  <div class="paid-stamp">Payé</div>
  <?php endif; ?>
  
  <div class="pdf-header">
    <div class="logo-wrap">
      <div class="logo-box">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
          <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
        </svg>
      </div>
      <div>
        <span class="brand-name"><span style="color:#52B788">Green</span><span style="color:#ffffff">Bite</span></span>
        <span class="brand-tag">Alimentation Durable & Nutrition</span>
      </div>
    </div>
    <div class="receipt-title">
      <h1>Reçu</h1>
      <p>N° <?= htmlspecialchars($refNum) ?></p>
      <p>Date : <?= $dateStr ?></p>
    </div>
  </div>
  <div class="green-bar"></div>
  
  <div class="details-section">
    <div class="details-box">
      <h3>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Facturé à
      </h3>
      <p>
        <strong><?= htmlspecialchars($nom) ?></strong><br>
        <?= htmlspecialchars($email) ?><br>
        <?= htmlspecialchars($phone) ?><br>
        <?= nl2br(htmlspecialchars($adresse)) ?>
      </p>
    </div>
    <div class="details-box">
      <h3>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        Détails de paiement
      </h3>
      <p>
        <strong>Méthode:</strong> <?= htmlspecialchars($paymentLabel) ?><br>
        <strong>Statut:</strong> <?= ($mode_paiement === 'carte') ? 'Payé et vérifié' : 'À payer à la livraison' ?><br>
        <strong>Identifiant:</strong> <?= htmlspecialchars($refNum) ?>
      </p>
    </div>
  </div>
  
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Article</th>
          <th style="text-align: center;">Quantité</th>
          <th style="text-align: right;">Prix Unitaire</th>
          <th style="text-align: right;">Montant</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($lignes as $l): ?>
        <tr>
          <td>
            <span class="c-item"><?= htmlspecialchars($l['nom']) ?></span>
            <span class="c-cat"><?= htmlspecialchars($l['categorie']) ?></span>
          </td>
          <td class="c-qty"><?= (int)$l['quantite'] ?></td>
          <td class="c-price"><?= number_format((float)$l['prix_unitaire'], 2) ?> DT</td>
          <td class="c-total"><?= number_format((float)$l['prix_unitaire'] * (int)$l['quantite'], 2) ?> DT</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <div class="summary-box">
      <div class="summary-row">
        <span>Sous-total</span>
        <span><?= number_format($total, 2) ?> DT</span>
      </div>
      <div class="summary-row">
        <span>Livraison</span>
        <span>Gratuite</span>
      </div>
      <div class="summary-row total">
        <span>Total TTC</span>
        <span><?= number_format($total, 2) ?> DT</span>
      </div>
    </div>
  </div>
  
  <div class="pdf-footer">
    <div class="f-brand">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#52B788" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/>
        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
      </svg>
      <span>GreenBite</span>
    </div>
    <div class="f-meta">
      Merci pour votre commande !<br>
      Ce reçu électronique sert de preuve d'achat.
    </div>
    <div class="f-contact">
      contact@greenbite.tn<br>
      www.greenbite.tn
    </div>
  </div>
</div>

<script>
window.addEventListener('load', function() {
  var element = document.getElementById('pdf-content');
  var filename = 'Recu_GreenBite_<?= str_pad($id, 5, '0', STR_PAD_LEFT) ?>.pdf';
  var opt = {
    margin:       0,
    filename:     filename,
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2, useCORS: true, logging: false, backgroundColor: '#ffffff' },
    jsPDF:        { unit: 'px', format: [794, 1123], orientation: 'portrait' },
    pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
  };
  
  // Hide overlay and close tab after download
  html2pdf().set(opt).from(element).save().then(function() {
    document.getElementById('overlay').style.display = 'none';
    setTimeout(() => {
        window.close(); // Attempt to close if opened in new tab
        // Fallback: redirect to history
        window.location.href = '<?= BASE_URL ?>/?page=marketplace&action=history';
    }, 1500);
  });
});
</script>
</body>
</html>
