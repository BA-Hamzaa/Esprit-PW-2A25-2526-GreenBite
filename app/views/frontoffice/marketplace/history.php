<?php /* history.php — Historique des commandes (Front) */ ?>
<div style="padding:2rem;max-width:56rem;margin:0 auto">
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold flex items-center gap-2" style="color:var(--text-primary)">
      <i data-lucide="shopping-bag" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i> Mes Commandes
    </h1>
    <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-sm" style="background:var(--surface);border:1px solid var(--border)">
      Retour
    </a>
  </div>

  <div class="card mb-8" style="padding:2rem">
    <h2 style="font-weight:700;margin-bottom:1rem">Rechercher votre historique</h2>
    <p style="color:var(--text-muted);margin-bottom:1.5rem">Saisissez l'adresse email utilisée lors de vos commandes pour retrouver votre historique.</p>
    <form method="GET" action="<?= BASE_URL ?>/" class="flex gap-3 max-w-lg">
      <input type="hidden" name="page" value="marketplace">
      <input type="hidden" name="action" value="history">
      <input type="email" name="email" class="form-input flex-1" placeholder="Votre adresse email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required>
      <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
  </div>

  <?php if (isset($_GET['email'])): ?>
    <?php if (empty($commandes)): ?>
      <div class="card text-center" style="padding:3rem">
        <i data-lucide="inbox" style="width:3rem;height:3rem;color:var(--text-muted);margin:0 auto 1rem"></i>
        <h3 style="color:var(--text-primary);font-weight:600;margin-bottom:0.5rem">Aucune commande trouvée</h3>
        <p style="color:var(--text-muted)">Aucune commande n'est associée à l'adresse <strong><?= htmlspecialchars($_GET['email']) ?></strong>.</p>
      </div>
    <?php else: ?>
      <div class="card" style="padding:0;overflow:hidden">
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>N° Commande</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $statusBadges = ['en_attente'=>'badge-yellow-light','confirmee'=>'badge-blue-light','en_preparation'=>'badge-purple-light','expediee'=>'badge-orange-light','livree'=>'badge-success','annulee'=>'badge-red-light'];
                $statusLabels = ['en_attente'=>'En attente','confirmee'=>'Confirmée','en_preparation'=>'En préparation','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'];
              ?>
              <?php foreach ($commandes as $c): ?>
                <tr>
                  <td class="font-medium" style="color:var(--text-primary)">#<?= str_pad($c['id'], 5, '0', STR_PAD_LEFT) ?></td>
                  <td style="color:var(--text-secondary)"><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                  <td class="font-bold" style="color:var(--primary)"><?= number_format($c['total'], 2) ?> DT</td>
                  <td>
                    <span class="badge <?= $statusBadges[$c['statut']] ?? 'badge-gray' ?>">
                      <?= $statusLabels[$c['statut']] ?? $c['statut'] ?>
                    </span>
                  </td>
                  <td>
                    <a href="<?= BASE_URL ?>/?page=marketplace&action=track-order&id=<?= $c['id'] ?>" class="btn btn-sm" style="background:var(--primary);color:#fff;font-size:0.75rem;padding:0.4rem 0.8rem">
                      Suivre <i data-lucide="arrow-right" style="width:0.8rem;height:0.8rem;margin-left:0.25rem"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
