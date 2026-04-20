<!-- Vue BackOffice : Liste des ingrédients -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:var(--radius-xl)">
        <i data-lucide="carrot" style="width:1.5rem;height:1.5rem;color:#ea580c"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Ingrédients</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($ingredients) ?> ingrédients référencés</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=add-ingredient" class="btn btn-primary"><i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter un ingrédient</a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead><tr><th>ID</th><th>Nom</th><th>Unité</th><th>Cal/unité</th><th>Local</th><th>Actions</th></tr></thead>
        <tbody>
          <?php if (empty($ingredients)): ?>
            <tr><td colspan="6" class="text-center py-8" style="color:var(--text-muted)">Aucun ingrédient.</td></tr>
          <?php else: ?>
            <?php foreach ($ingredients as $i): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $i['id'] ?></td>
                <td class="font-semibold" style="color:var(--primary)"><?= htmlspecialchars($i['nom']) ?></td>
                <td style="color:var(--text-secondary)"><?= htmlspecialchars($i['unite']) ?></td>
                <td><span class="font-semibold" style="color:var(--accent-orange)"><?= $i['calories_par_unite'] ?></span></td>
                <td><?= $i['is_local'] ? '<span class="badge badge-success"><i data-lucide="map-pin" style="width:0.7rem;height:0.7rem"></i> Local</span>' : '<span class="badge badge-gray">Importé</span>' ?></td>
                <td>
                  <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=edit-ingredient&id=<?= $i['id'] ?>" class="icon-btn" title="Modifier"><i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i></a>
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=delete-ingredient&id=<?= $i['id'] ?>" class="icon-btn" style="color:var(--destructive)" title="Supprimer" onclick="return confirm('Supprimer?')"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></a>
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
