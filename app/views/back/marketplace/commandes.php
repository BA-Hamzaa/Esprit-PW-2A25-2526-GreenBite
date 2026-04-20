<!-- Vue BackOffice : Liste des commandes -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
        <i data-lucide="shopping-bag" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Commandes</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($commandes) ?> commandes</p>
      </div>
    </div>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead><tr><th>ID</th><th>Client</th><th>Email</th><th>Total</th><th>Statut</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
          <?php if (empty($commandes)): ?>
            <tr><td colspan="7" class="text-center py-8" style="color:var(--text-muted)">Aucune commande.</td></tr>
          <?php else: ?>
            <?php
              $statusBadges = ['en_attente'=>'badge-yellow-light','confirmee'=>'badge-blue-light','livree'=>'badge-success','annulee'=>'badge-red-light'];
              $statusLabels = ['en_attente'=>'En attente','confirmee'=>'Confirmée','livree'=>'Livrée','annulee'=>'Annulée'];
            ?>
            <?php foreach ($commandes as $c): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $c['id'] ?></td>
                <td class="font-medium" style="color:var(--text-primary)"><?= htmlspecialchars($c['client_nom']) ?></td>
                <td style="color:var(--text-secondary)"><?= htmlspecialchars($c['client_email']) ?></td>
                <td class="font-semibold" style="color:var(--accent-orange)"><?= number_format($c['total'], 2) ?> DT</td>
                <td><span class="badge <?= $statusBadges[$c['statut']] ?? 'badge-gray' ?>"><?= $statusLabels[$c['statut']] ?? $c['statut'] ?></span></td>
                <td style="color:var(--text-secondary)"><?= $c['created_at'] ?></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commande-detail&id=<?= $c['id'] ?>" class="icon-btn" title="Détail"><i data-lucide="eye" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commande-delete&id=<?= $c['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" onclick="return confirm('Supprimer?')"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
