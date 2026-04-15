<!-- Vue BackOffice : Liste des aliments -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:var(--radius-xl)">
        <i data-lucide="apple" style="width:1.5rem;height:1.5rem;color:#ca8a04"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Aliments</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($aliments) ?> aliments référencés</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=add-aliment" class="btn btn-primary"><i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter un aliment</a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead><tr><th>ID</th><th>Nom</th><th>Calories</th><th>Protéines</th><th>Glucides</th><th>Lipides</th><th>Actions</th></tr></thead>
        <tbody>
          <?php if (empty($aliments)): ?>
            <tr><td colspan="7" class="text-center py-8" style="color:var(--text-muted)">Aucun aliment.</td></tr>
          <?php else: ?>
            <?php foreach ($aliments as $a): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $a['id'] ?></td>
                <td class="font-semibold" style="color:var(--primary)"><?= htmlspecialchars($a['nom']) ?></td>
                <td><span class="badge badge-accent"><?= $a['calories'] ?> kcal</span></td>
                <td><span class="badge badge-primary">P: <?= $a['proteines'] ?>g</span></td>
                <td><span class="badge badge-secondary">G: <?= $a['glucides'] ?>g</span></td>
                <td><span class="badge" style="background:#fef9c3;color:#854d0e;border:1px solid #fde68a">L: <?= $a['lipides'] ?>g</span></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=edit-aliment&id=<?= $a['id'] ?>" class="icon-btn" title="Modifier"><i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=delete-aliment&id=<?= $a['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" onclick="return confirm('Supprimer cet aliment ?')"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
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
