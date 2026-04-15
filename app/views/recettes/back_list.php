<!-- Vue BackOffice : Liste des recettes -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl)">
        <i data-lucide="chef-hat" style="width:1.5rem;height:1.5rem;color:#7c3aed"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Recettes</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($recettes) ?> recettes publiées</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=add" class="btn btn-primary"><i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter une recette</a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead><tr><th>ID</th><th>Image</th><th>Titre</th><th>Difficulté</th><th>Catégorie</th><th>Temps</th><th>Calories</th><th>CO₂</th><th>Actions</th></tr></thead>
        <tbody>
          <?php if (empty($recettes)): ?>
            <tr><td colspan="9" class="text-center py-8" style="color:var(--text-muted)">Aucune recette.</td></tr>
          <?php else: ?>
            <?php $diffBadges = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light']; ?>
            <?php foreach ($recettes as $r): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $r['id'] ?></td>
                <td><div style="width:3rem;height:3rem;border-radius:var(--radius-lg);overflow:hidden;background:var(--muted)"><?php if (!empty($r['image'])): ?><img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($r['image']) ?>" style="width:100%;height:100%;object-fit:cover"><?php else: ?><div class="flex items-center justify-center" style="height:100%;font-size:1.25rem">🍽️</div><?php endif; ?></div></td>
                <td class="font-semibold" style="color:var(--primary)"><?= htmlspecialchars($r['titre']) ?></td>
                <td><span class="badge <?= $diffBadges[$r['difficulte']] ?? 'badge-gray' ?>"><?= ucfirst($r['difficulte']) ?></span></td>
                <td style="color:var(--text-secondary)"><?= htmlspecialchars($r['categorie'] ?? '-') ?></td>
                <td style="color:var(--text-secondary)"><i data-lucide="clock" style="width:0.75rem;height:0.75rem;display:inline;vertical-align:middle"></i> <?= $r['temps_preparation'] ?>min</td>
                <td><span class="font-semibold" style="color:var(--accent-orange)"><?= $r['calories_total'] ?> kcal</span></td>
                <td><?= $r['score_carbone'] <= 1 ? '<span class="badge badge-success"><i data-lucide="leaf" style="width:0.7rem;height:0.7rem"></i> Low</span>' : '<span class="badge badge-gray">' . $r['score_carbone'] . '</span>' ?></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=edit&id=<?= $r['id'] ?>" class="icon-btn" title="Modifier"><i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=delete&id=<?= $r['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" onclick="return confirm('Supprimer?')"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
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
