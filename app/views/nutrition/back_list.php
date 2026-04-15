<!-- Vue BackOffice : Liste des repas -->
<div style="padding:2rem">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="utensils-crossed" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Gestion des Repas
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="database" style="width:0.75rem;height:0.75rem"></i>
          <?= count($repas) ?> repas enregistrés
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=add" class="btn btn-primary" style="border-radius:var(--radius-xl)">
      <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Ajouter un repas
    </a>
  </div>

  <!-- Table Card -->
  <div class="card" style="padding:0;overflow:hidden;border:1px solid var(--border)">
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nom du repas</th>
            <th>Type</th>
            <th>Date</th>
            <th>Calories</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($repas)): ?>
            <tr>
              <td colspan="6" style="text-align:center;padding:3.5rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:var(--muted);border-radius:var(--radius-full);margin-bottom:1rem">
                  <i data-lucide="inbox" style="width:2rem;height:2rem;color:var(--text-muted)"></i>
                </div>
                <p style="font-weight:600;color:var(--text-secondary);margin-top:0.5rem">Aucun repas enregistré</p>
                <p style="font-size:0.8rem;margin-top:0.25rem">Commencez par ajouter un repas.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($repas as $r): ?>
              <tr>
                <td>
                  <span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= $r['id'] ?></span>
                </td>
                <td>
                  <div style="display:flex;align-items:center;gap:0.625rem">
                    <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,rgba(45,106,79,0.08),rgba(82,183,136,0.06));border-radius:0.625rem;flex-shrink:0">
                      <i data-lucide="utensils" style="width:0.875rem;height:0.875rem;color:var(--primary)"></i>
                    </div>
                    <span class="font-semibold" style="color:var(--text-primary)"><?= htmlspecialchars($r['nom']) ?></span>
                  </div>
                </td>
                <td><span class="badge badge-primary" style="font-size:0.65rem"><?= htmlspecialchars($r['type_repas']) ?></span></td>
                <td>
                  <span style="display:flex;align-items:center;gap:0.375rem;color:var(--text-secondary);font-size:0.82rem">
                    <i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i>
                    <?= $r['date_repas'] ?>
                  </span>
                </td>
                <td>
                  <span style="display:inline-flex;align-items:center;gap:0.3rem;font-weight:700;color:var(--accent-orange);background:linear-gradient(135deg,rgba(231,111,81,0.08),rgba(231,111,81,0.04));padding:0.25rem 0.6rem;border-radius:var(--radius-full);font-size:0.8rem">
                    <i data-lucide="flame" style="width:0.7rem;height:0.7rem"></i>
                    <?= $r['calories_total'] ?? '-' ?> kcal
                  </span>
                </td>
                <td>
                  <div style="display:flex;gap:0.375rem;align-items:center">
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=edit&id=<?= $r['id'] ?>" class="icon-btn" title="Modifier" style="background:rgba(45,106,79,0.06);border-color:rgba(45,106,79,0.15)">
                      <i data-lucide="edit-3" style="width:0.85rem;height:0.85rem"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=delete&id=<?= $r['id'] ?>" class="icon-btn" style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.15);color:#ef4444" title="Supprimer" onclick="return confirm('Supprimer ce repas ?')">
                      <i data-lucide="trash-2" style="width:0.85rem;height:0.85rem"></i>
                    </a>
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
