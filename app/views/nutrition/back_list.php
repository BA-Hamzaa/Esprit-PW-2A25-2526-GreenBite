<!-- Vue BackOffice : Liste des repas -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
        <i data-lucide="utensils-crossed" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Repas</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($repas) ?> repas enregistrés</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=add" class="btn btn-primary"><i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter un repas</a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead><tr><th>ID</th><th>Nom</th><th>Type</th><th>Date</th><th>Calories</th><th>Actions</th></tr></thead>
        <tbody>
          <?php if (empty($repas)): ?>
            <tr><td colspan="6" class="text-center py-8" style="color:var(--text-muted)"><i data-lucide="inbox" style="width:2rem;height:2rem;display:inline-block;margin-bottom:0.5rem;opacity:0.5"></i><br>Aucun repas enregistré.</td></tr>
          <?php else: ?>
            <?php foreach ($repas as $r): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $r['id'] ?></td>
                <td class="font-semibold" style="color:var(--primary)"><?= htmlspecialchars($r['nom']) ?></td>
                <td><span class="badge badge-gray"><?= htmlspecialchars($r['type_repas']) ?></span></td>
                <td style="color:var(--text-secondary)"><?= $r['date_repas'] ?></td>
                <td><span class="font-semibold" style="color:var(--accent-orange)"><?= $r['calories_total'] ?? '-' ?> kcal</span></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=edit&id=<?= $r['id'] ?>" class="icon-btn" title="Modifier"><i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=delete&id=<?= $r['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" onclick="return confirm('Supprimer ce repas ?')"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
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
