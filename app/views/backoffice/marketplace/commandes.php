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
    <div style="overflow-x:auto">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">#</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Client</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Email</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Total</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Paiement</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:11rem">Statut</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Date</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:110px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($commandes)): ?>
            <tr>
              <td colspan="8" style="text-align:center;padding:4rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:50%;margin-bottom:1.25rem">
                  <i data-lucide="shopping-bag" style="width:2.25rem;height:2.25rem;color:#2563eb"></i>
                </div>
                <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:#2563eb;margin-bottom:0.5rem">Aucune commande</h3>
                <p style="color:var(--text-muted);font-size:0.82rem">Aucune commande pour le moment.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php
              $statusBadges = ['en_attente'=>'badge-yellow-light','confirmee'=>'badge-blue-light','en_preparation'=>'badge-purple-light','expediee'=>'badge-orange-light','livree'=>'badge-success','annulee'=>'badge-red-light'];
              $statusLabels = ['en_attente'=>'En attente','confirmee'=>'Confirmée','en_preparation'=>'En préparation','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'];
              $statusColors = ['en_attente'=>'#b45309','confirmee'=>'#1d4ed8','en_preparation'=>'#7c3aed','expediee'=>'#c2410c','livree'=>'#166534','annulee'=>'#b91c1c'];
            ?>
            <?php foreach ($commandes as $c): ?>
              <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(82,183,136,0.03)'" onmouseout="this.style.background=''">
                <td style="color:var(--text-muted)">#<?= $c['id'] ?></td>
                <td class="font-medium" style="color:var(--text-primary)"><?= htmlspecialchars($c['client_nom']) ?></td>
                <td style="color:var(--text-secondary)"><?= htmlspecialchars($c['client_email']) ?></td>
                <td class="font-semibold" style="color:var(--accent-orange)"><?= number_format($c['total'], 2) ?> DT</td>
                <td>
                  <?php if(($c['mode_paiement'] ?? 'carte') === 'livraison'): ?>
                    <span class="badge" style="background:rgba(249,115,22,0.1);color:#f97316"><i data-lucide="truck" style="width:0.75rem;height:0.75rem;margin-right:0.25rem"></i> Livraison</span>
                  <?php else: ?>
                    <span class="badge" style="background:rgba(45,106,79,0.1);color:#2D6A4F"><i data-lucide="credit-card" style="width:0.75rem;height:0.75rem;margin-right:0.25rem"></i> Carte</span>
                  <?php endif; ?>
                </td>
                <td>
                  <!-- ✅ Inline quick-status: select & auto-submit on change -->
                  <form method="POST" action="<?= BASE_URL ?>/?page=admin-marketplace&action=commande-status&id=<?= $c['id'] ?>" style="margin:0">
                    <select name="statut"
                            onchange="this.form.submit()"
                            title="Changer le statut"
                            style="padding:0.28rem 0.5rem;font-size:0.78rem;border-radius:var(--radius-md);border:1.5px solid var(--border);background:var(--surface);color:<?= $statusColors[$c['statut']] ?? 'var(--text-primary)' ?>;font-weight:600;cursor:pointer;outline:none;width:100%;transition:border-color 0.2s">
                      <?php foreach ($statusLabels as $val => $lbl): ?>
                        <option value="<?= $val ?>" <?= $c['statut'] === $val ? 'selected' : '' ?>
                          style="color:<?= $statusColors[$val] ?? '#000' ?>;font-weight:600"><?= $lbl ?></option>
                      <?php endforeach; ?>
                    </select>
                  </form>
                </td>
                <td style="color:var(--text-secondary)"><?= $c['created_at'] ?></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commande-detail&id=<?= $c['id'] ?>" class="icon-btn" title="Détail"><i data-lucide="eye" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commande-delete&id=<?= $c['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" data-confirm="Supprimer cette commande ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
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
