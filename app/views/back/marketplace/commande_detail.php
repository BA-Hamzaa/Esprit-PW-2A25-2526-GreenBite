<!-- Vue BackOffice : Détail d'une commande -->
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commandes" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux commandes
  </a>
  
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="receipt" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Commande #<?= $commande['id'] ?></h1>
      <p class="text-sm" style="color:var(--text-muted)">Passée le <?= $commande['created_at'] ?></p>
    </div>
  </div>

  <!-- Client info & Status -->
  <div class="grid grid-cols-2 gap-6 mb-6">
    <div class="card" style="padding:1.5rem">
      <h3 class="font-semibold mb-3 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="user" style="width:1rem;height:1rem;color:var(--primary)"></i> Client</h3>
      <div class="space-y-2">
        <div class="flex items-center gap-2"><span class="text-sm font-medium" style="color:var(--text-secondary)">Nom:</span><span class="text-sm font-semibold" style="color:var(--text-primary)"><?= htmlspecialchars($commande['client_nom']) ?></span></div>
        <div class="flex items-center gap-2"><span class="text-sm font-medium" style="color:var(--text-secondary)">Email:</span><span class="text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($commande['client_email']) ?></span></div>
        <?php if (!empty($commande['client_adresse'])): ?>
          <div class="flex items-center gap-2"><span class="text-sm font-medium" style="color:var(--text-secondary)">Adresse:</span><span class="text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($commande['client_adresse']) ?></span></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="card" style="padding:1.5rem">
      <h3 class="font-semibold mb-3 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="settings" style="width:1rem;height:1rem;color:var(--primary)"></i> Statut</h3>
      <?php
        $statusBadges = ['en_attente'=>'badge-yellow-light','confirmee'=>'badge-blue-light','livree'=>'badge-success','annulee'=>'badge-red-light'];
        $statusLabels = ['en_attente'=>'En attente','confirmee'=>'Confirmée','livree'=>'Livrée','annulee'=>'Annulée'];
      ?>
      <div class="mb-4"><span class="badge <?= $statusBadges[$commande['statut']] ?? 'badge-gray' ?>" style="font-size:0.85rem;padding:0.4rem 1rem"><?= $statusLabels[$commande['statut']] ?? $commande['statut'] ?></span></div>
      <form novalidate method="POST" action="<?= BASE_URL ?>/?page=admin-marketplace&action=commande-status&id=<?= $commande['id'] ?>" class="flex gap-3">
        <select name="statut" class="form-input flex-1">
          <option value="en_attente" <?= $commande['statut'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
          <option value="confirmee" <?= $commande['statut'] === 'confirmee' ? 'selected' : '' ?>>Confirmée</option>
          <option value="livree" <?= $commande['statut'] === 'livree' ? 'selected' : '' ?>>Livrée</option>
          <option value="annulee" <?= $commande['statut'] === 'annulee' ? 'selected' : '' ?>>Annulée</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="refresh-cw" style="width:0.875rem;height:0.875rem"></i> MAJ</button>
      </form>
    </div>
  </div>

  <!-- Products -->
  <div class="card" style="padding:0;overflow:hidden">
    <div class="p-4" style="border-bottom:1px solid var(--border)">
      <h3 class="font-semibold flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="package" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Produits commandés</h3>
    </div>
    <div class="table-container">
      <table class="table">
        <thead><tr><th>Produit</th><th>Quantité</th><th>Prix Unit.</th><th>Sous-total</th></tr></thead>
        <tbody>
          <?php if (!empty($lignes)): ?>
            <?php foreach ($lignes as $l): ?>
              <tr>
                <td class="font-medium" style="color:var(--primary)"><?= htmlspecialchars($l['nom'] ?? $l['produit_id']) ?></td>
                <td><?= $l['quantite'] ?></td>
                <td style="color:var(--text-secondary)"><?= number_format($l['prix_unitaire'], 2) ?> DT</td>
                <td class="font-semibold" style="color:var(--accent-orange)"><?= number_format($l['quantite'] * $l['prix_unitaire'], 2) ?> DT</td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr style="border-top:2px solid var(--border)">
            <td colspan="3" class="text-right font-bold" style="color:var(--text-primary)">Total :</td>
            <td class="font-bold text-lg" style="color:var(--primary)"><?= number_format($commande['total'], 2) ?> DT</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
