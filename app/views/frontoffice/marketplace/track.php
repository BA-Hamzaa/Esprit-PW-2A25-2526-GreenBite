<?php /* track.php — Suivi de commande */ ?>
<style>
.track-wrap{padding:2rem;max-width:48rem;margin:0 auto}
.status-timeline{position:relative;margin:3rem 0;padding-left:1.5rem}
.status-timeline::before{content:'';position:absolute;top:0;left:0;bottom:0;width:2px;background:var(--border)}
.status-item{position:relative;margin-bottom:2rem;padding-left:1.5rem}
.status-item:last-child{margin-bottom:0}
.status-dot{position:absolute;left:-2.05rem;top:0;width:1.25rem;height:1.25rem;border-radius:50%;background:var(--surface);border:2px solid var(--border);z-index:1;display:flex;align-items:center;justify-content:center}
.status-item.active .status-dot{border-color:var(--primary);background:var(--primary);color:#fff}
.status-item.done .status-dot{border-color:#52B788;background:#52B788;color:#fff}
.status-title{font-weight:700;color:var(--text-primary);margin-bottom:.25rem}
.status-desc{font-size:.875rem;color:var(--text-muted)}
.detail-box{background:var(--surface);border:1px solid var(--border);border-radius:1rem;padding:1.5rem;margin-bottom:1.5rem}
.d-row{display:flex;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--border);font-size:.875rem}
.d-row:last-child{border:none;padding-bottom:0}
.d-row .label{color:var(--text-muted)}
.d-row .val{font-weight:600;color:var(--text-primary)}
</style>

<div class="track-wrap">
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold flex items-center gap-2" style="color:var(--text-primary)">
      <i data-lucide="map" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i> Suivi de commande
    </h1>
    <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-sm" style="background:var(--surface);border:1px solid var(--border)">
      Retour
    </a>
  </div>

  <?php if (!$commande): ?>
    <div class="card text-center" style="padding:3rem">
      <i data-lucide="search" style="width:3rem;height:3rem;color:var(--text-muted);margin:0 auto 1rem"></i>
      <h2 style="color:var(--text-primary);margin-bottom:.5rem">Commande introuvable</h2>
      <p style="color:var(--text-muted);margin-bottom:1.5rem">Vérifiez le numéro de commande fourni ou connectez-vous.</p>
      
      <form method="GET" action="<?= BASE_URL ?>/" class="flex gap-2 max-w-sm mx-auto">
        <input type="hidden" name="page" value="marketplace">
        <input type="hidden" name="action" value="track-order">
        <input type="number" name="id" class="form-input flex-1" placeholder="N° de commande" required>
        <button type="submit" class="btn btn-primary">Chercher</button>
      </form>
    </div>
  <?php else: ?>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="md:col-span-2">
        <div class="card" style="padding:2rem">
          <div class="flex justify-between items-end mb-4 pb-4" style="border-bottom:1px solid var(--border)">
            <div>
              <div style="font-size:.875rem;color:var(--text-muted)">Commande <strong style="color:var(--primary)">#<?= str_pad($commande['id'], 5, '0', STR_PAD_LEFT) ?></strong></div>
              <div style="font-size:.75rem;color:var(--text-muted)"><?= date('d M Y - H:i', strtotime($commande['created_at'])) ?></div>
            </div>
            <div style="font-weight:800;font-size:1.5rem;color:var(--text-primary)"><?= number_format($commande['total'], 2) ?> DT</div>
          </div>

          <?php
          $statut = $commande['statut'];
          
          $steps = [
            'en_attente'     => ['title' => 'Commande en attente', 'desc' => 'Votre commande est en attente de confirmation par notre équipe.', 'icon' => 'clock'],
            'confirmee'      => ['title' => 'Commande confirmée', 'desc' => 'Votre commande a été validée.', 'icon' => 'check-circle'],
            'en_preparation' => ['title' => 'En préparation', 'desc' => 'Vos produits sont en cours de préparation.', 'icon' => 'package'],
            'expediee'       => ['title' => 'Expédiée', 'desc' => 'Votre colis a été remis au livreur.', 'icon' => 'truck'],
            'livree'         => ['title' => 'Livrée', 'desc' => 'Commande réceptionnée avec succès.', 'icon' => 'home']
          ];
          
          $order = ['en_attente', 'confirmee', 'en_preparation', 'expediee', 'livree'];
          $currentIndex = array_search($statut, $order);
          $isAnnulee = ($statut === 'annulee');
          ?>

          <?php if ($isAnnulee): ?>
            <div class="p-4 rounded-xl flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5">
              <i data-lucide="x-circle" style="width:1.5rem;height:1.5rem;flex-shrink:0"></i>
              <div>
                <h3 style="font-weight:700">Commande Annulée</h3>
                <p style="font-size:.875rem;margin-top:.25rem">Cette commande a été annulée. Aucun prélèvement ne sera effectué.</p>
              </div>
            </div>
          <?php else: ?>
            <div class="status-timeline">
              <?php foreach ($order as $idx => $sKey): ?>
                <?php 
                  $isDone = ($idx < $currentIndex);
                  $isActive = ($idx === $currentIndex);
                  $sData = $steps[$sKey];
                ?>
                <div class="status-item <?= $isDone ? 'done' : ($isActive ? 'active' : '') ?>">
                  <div class="status-dot">
                    <?php if ($isDone): ?>
                      <i data-lucide="check" style="width:.75rem;height:.75rem"></i>
                    <?php elseif ($isActive): ?>
                      <div style="width:.5rem;height:.5rem;background:#fff;border-radius:50%"></div>
                    <?php endif; ?>
                  </div>
                  <div class="status-title"><?= $sData['title'] ?></div>
                  <div class="status-desc"><?= $sData['desc'] ?></div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="md:col-span-1">
        <div class="detail-box">
          <h3 style="font-weight:700;font-size:1rem;color:var(--text-primary);margin-bottom:1rem;display:flex;align-items:center;gap:.5rem">
            <i data-lucide="user" style="width:1rem;height:1rem;color:var(--primary)"></i> Client
          </h3>
          <div class="d-row"><span class="label">Nom</span><span class="val"><?= htmlspecialchars($commande['client_nom']) ?></span></div>
          <div class="d-row"><span class="label">Téléphone</span><span class="val"><?= htmlspecialchars($commande['client_telephone'] ?? '—') ?></span></div>
          <div class="d-row" style="flex-direction:column;align-items:flex-start">
            <span class="label mb-1">Adresse</span>
            <span class="val" style="font-size:.8rem"><?= htmlspecialchars($commande['client_adresse']) ?></span>
          </div>
        </div>

        <div class="detail-box">
          <h3 style="font-weight:700;font-size:1rem;color:var(--text-primary);margin-bottom:1rem;display:flex;align-items:center;gap:.5rem">
            <i data-lucide="credit-card" style="width:1rem;height:1rem;color:var(--primary)"></i> Paiement
          </h3>
          <div class="d-row">
            <span class="label">Mode</span>
            <span class="val">
              <?php if (($commande['mode_paiement'] ?? 'carte') === 'livraison'): ?>
                <span style="color:#f97316;display:flex;align-items:center;gap:.35rem"><i data-lucide="truck" style="width:.875rem;height:.875rem"></i> À la livraison</span>
              <?php else: ?>
                <span style="color:#2D6A4F;display:flex;align-items:center;gap:.35rem"><i data-lucide="credit-card" style="width:.875rem;height:.875rem"></i> Carte Bancaire</span>
              <?php endif; ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
