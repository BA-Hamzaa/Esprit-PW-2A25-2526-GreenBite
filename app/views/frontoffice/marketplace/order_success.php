<?php /* order_success.php — Post-payment success screen */ ?>
<style>
@keyframes successPop{0%{transform:scale(0) rotate(-10deg);opacity:0}60%{transform:scale(1.15) rotate(3deg)}100%{transform:scale(1) rotate(0);opacity:1}}
@keyframes confettiFall{0%{transform:translateY(-20px) rotate(0deg);opacity:1}100%{transform:translateY(120px) rotate(360deg);opacity:0}}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.success-wrap{padding:2rem;max-width:42rem}
.success-check{width:5rem;height:5rem;background:linear-gradient(135deg,#2D6A4F,#52B788);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;animation:successPop .6s cubic-bezier(.34,1.56,.64,1) both;box-shadow:0 12px 40px rgba(45,106,79,.35)}
.success-card{text-align:center;padding:3rem 2.5rem;position:relative;overflow:hidden}
.confetti-piece{position:absolute;width:8px;height:8px;border-radius:2px;animation:confettiFall 1.5s ease-in forwards}
.order-details{background:var(--muted);border-radius:1rem;padding:1.25rem;margin-top:1.75rem;text-align:left}
.detail-row{display:flex;justify-content:space-between;align-items:center;padding:.5rem 0;border-bottom:1px solid var(--border);font-size:.875rem}
.detail-row:last-child{border:none;padding-top:.75rem;font-size:1rem}
.detail-row .label{color:var(--text-muted)}
.detail-row .value{font-weight:700;color:var(--text-primary)}
.pi-badge{font-size:.68rem;font-family:monospace;background:var(--surface);padding:.2rem .5rem;border-radius:.3rem;border:1px solid var(--border);color:var(--text-muted);word-break:break-all;margin-top:.15rem;display:block}
.action-btns{display:flex;gap:.875rem;margin-top:1.75rem;animation:fadeUp .5s .6s both}
</style>

<?php
$id      = $orderData['commande_id'] ?? '—';
$nom     = htmlspecialchars($orderData['client_nom']   ?? '');
$email   = htmlspecialchars($orderData['client_email'] ?? '');
$total   = number_format($orderData['total'] ?? 0, 2);
$pi      = htmlspecialchars($orderData['payment_intent'] ?? '');
$items   = (int)($orderData['items_count'] ?? 0);
$mode    = $orderData['mode_paiement'] ?? 'carte';
$colors  = ['#2D6A4F','#52B788','#95d5b2','#f97316','#fbbf24','#60a5fa','#c084fc'];
?>

<!-- Confetti -->
<script>
window.addEventListener('load', () => {
  const wrap = document.querySelector('.success-card');
  for (let i = 0; i < 22; i++) {
    const d = document.createElement('div');
    d.className = 'confetti-piece';
    d.style.cssText = `left:${Math.random()*100}%;top:${Math.random()*20}%;background:${['#2D6A4F','#52B788','#f97316','#fbbf24','#60a5fa'][Math.floor(Math.random()*5)]};animation-delay:${Math.random()*.8}s;animation-duration:${1+Math.random()}s;transform:rotate(${Math.random()*360}deg)`;
    wrap.appendChild(d);
  }
});
</script>

<div class="success-wrap">
  <div class="card success-card">
    <!-- Check icon -->
    <div class="success-check">
      <svg style="width:2.5rem;height:2.5rem;fill:none;stroke:#fff;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
    </div>

    <h1 style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:.5rem;animation:fadeUp .4s .1s both">
      Commande confirmée ! 🎉
    </h1>
    <p style="color:var(--text-muted);font-size:.95rem;animation:fadeUp .4s .2s both">
      Merci <strong><?= $nom ?></strong>, votre commande a bien été enregistrée.<br>
      <?php if ($mode === 'carte'): ?>
        Votre paiement a été accepté par Stripe.
      <?php else: ?>
        Vous avez choisi le paiement à la livraison (en espèces).
      <?php endif; ?><br>
      Un email de confirmation sera envoyé à <strong><?= $email ?></strong>.
    </p>

    <!-- Order details -->
    <div class="order-details" style="animation:fadeUp .4s .3s both">
      <div class="detail-row">
        <span class="label">N° de commande</span>
        <span class="value" style="color:var(--primary)">#<?= str_pad($id, 5, '0', STR_PAD_LEFT) ?></span>
      </div>
      <div class="detail-row">
        <span class="label">Articles</span>
        <span class="value"><?= $items ?> produit<?= $items > 1 ? 's' : '' ?></span>
      </div>
      <div class="detail-row">
        <span class="label">Statut paiement</span>
        <?php if ($mode === 'carte'): ?>
          <span class="value" style="color:#16a34a;display:flex;align-items:center;gap:.35rem">
            <span style="width:.55rem;height:.55rem;background:#22c55e;border-radius:50%;display:inline-block;box-shadow:0 0 6px #22c55e"></span>
            Paiement réussi (Stripe)
          </span>
        <?php else: ?>
          <span class="value" style="color:#f97316;display:flex;align-items:center;gap:.35rem">
            <span style="width:.55rem;height:.55rem;background:#fbbf24;border-radius:50%;display:inline-block;box-shadow:0 0 6px #fbbf24"></span>
            À régler à la livraison
          </span>
        <?php endif; ?>
      </div>
      <?php if ($mode === 'carte'): ?>
      <div class="detail-row">
        <span class="label">Référence Stripe</span>
        <span class="value" style="text-align:right"><code class="pi-badge"><?= $pi ?></code></span>
      </div>
      <?php endif; ?>
      <div class="detail-row">
        <span class="label" style="font-weight:700">Total <?= $mode === 'carte' ? 'payé' : 'à payer' ?></span>
        <span class="value" style="color:var(--primary);font-size:1.25rem"><?= $total ?> DT</span>
      </div>
    </div>

    <!-- Steps timeline -->
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-top:1.75rem;padding:0 .5rem;animation:fadeUp .4s .45s both">
      <?php
      $steps = [
        ['🛒', 'Commande', 'Passée'],
        ['💳', 'Paiement', 'Confirmé'],
        ['📦', 'Préparation', 'En cours'],
        ['🚚', 'Livraison', 'À venir'],
      ];
      foreach ($steps as $i => $s): ?>
      <div style="text-align:center;flex:1;position:relative">
        <?php if ($i < count($steps)-1): ?>
        <div style="position:absolute;top:.9rem;left:55%;width:90%;height:2px;background:<?= $i < 2 ? 'linear-gradient(90deg,#52B788,#95d5b2)' : 'var(--border)' ?>"></div>
        <?php endif; ?>
        <div style="width:1.85rem;height:1.85rem;border-radius:50%;background:<?= $i < 2 ? 'linear-gradient(135deg,#2D6A4F,#52B788)' : 'var(--muted)' ?>;border:2px solid <?= $i < 2 ? '#52B788' : 'var(--border)' ?>;display:flex;align-items:center;justify-content:center;margin:0 auto .5rem;font-size:.75rem;position:relative;z-index:1">
          <?php if ($i < 2): ?>
          <svg style="width:.9rem;height:.9rem;fill:none;stroke:#fff;stroke-width:2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          <?php else: ?>
          <span style="color:var(--text-muted);font-size:.6rem">·</span>
          <?php endif; ?>
        </div>
        <div style="font-size:.72rem;font-weight:600;color:<?= $i < 2 && ($mode === 'carte' || $i !== 1) ? 'var(--primary)' : 'var(--text-muted)' ?>"><?= $s[1] ?></div>
        <div style="font-size:.65rem;color:<?= $i < 2 && ($mode === 'carte' || $i !== 1) ? 'var(--secondary)' : 'var(--text-muted)' ?>"><?= $mode === 'livraison' && $i === 1 ? 'À la livraison' : $s[2] ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Actions -->
    <div class="action-btns">
      <a href="<?= BASE_URL ?>/?page=marketplace&action=track-order&id=<?= $id ?>" class="btn flex-1" style="background:var(--surface);border:1.5px solid var(--border);color:var(--text-primary);border-radius:.875rem;padding:.875rem;display:flex;align-items:center;justify-content:center;gap:.5rem">
        <i data-lucide="map" style="width:1rem;height:1rem"></i> Suivre ma commande
      </a>
      <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-primary flex-1" style="background:linear-gradient(135deg,#2D6A4F,#52B788);border:none;border-radius:.875rem;padding:.875rem;display:flex;align-items:center;justify-content:center;gap:.5rem">
        <i data-lucide="shopping-basket" style="width:1rem;height:1rem"></i> Continuer mes achats
      </a>
    </div>

    <!-- GreenBite message -->
    <div style="margin-top:1.5rem;padding:1rem;background:linear-gradient(135deg,rgba(45,106,79,.06),transparent);border-radius:.875rem;border:1px dashed rgba(82,183,136,.25);animation:fadeUp .4s .7s both">
      <p style="font-size:.8rem;color:var(--text-muted);margin:0">🌿 <strong style="color:var(--primary)">GreenBite</strong> vous remercie de soutenir une alimentation locale et durable. Votre commande sera préparée avec soin.</p>
    </div>
  </div>
</div>
