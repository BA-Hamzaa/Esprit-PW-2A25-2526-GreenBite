<!-- Vue BackOffice : Liste des produits -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:var(--radius-xl)">
        <i data-lucide="package" style="width:1.5rem;height:1.5rem;color:#ea580c"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Produits</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($produits) ?> produits en catalogue</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=add" class="btn btn-primary"><i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter un produit</a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead><tr><th>ID</th><th>Image</th><th>Nom</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Actions</th></tr></thead>
        <tbody>
          <?php if (empty($produits)): ?>
            <tr><td colspan="7" class="text-center py-8" style="color:var(--text-muted)"><i data-lucide="inbox" style="width:2rem;height:2rem;display:inline-block;opacity:0.5"></i><br>Aucun produit.</td></tr>
          <?php else: ?>
            <?php foreach ($produits as $p): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $p['id'] ?></td>
                <td><div style="width:3rem;height:3rem;border-radius:var(--radius-lg);overflow:hidden;background:var(--muted)"><?php if (!empty($p['image'])): ?><img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($p['image']) ?>" style="width:100%;height:100%;object-fit:cover"><?php else: ?><div class="flex items-center justify-center" style="height:100%;font-size:1.25rem">📦</div><?php endif; ?></div></td>
                <td class="font-semibold" style="color:var(--primary)"><?= htmlspecialchars($p['nom']) ?></td>
                <td><span class="badge badge-gray"><?= htmlspecialchars($p['categorie'] ?? '-') ?></span></td>
                <td class="font-semibold" style="color:var(--accent-orange)"><?= number_format($p['prix'], 2) ?> DT</td>
                <td><?= $p['stock'] > 0 ? '<span class="badge badge-green-light">' . $p['stock'] . '</span>' : '<span class="badge badge-red-light">Rupture</span>' ?></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=edit&id=<?= $p['id'] ?>" class="icon-btn" title="Modifier"><i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=delete&id=<?= $p['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" onclick="return confirm('Supprimer?')"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
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
