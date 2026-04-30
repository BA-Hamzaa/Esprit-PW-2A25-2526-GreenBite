<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#fef3c7,#fff7ed);border-radius:1rem;box-shadow:0 6px 18px rgba(245,158,11,0.18)">
        <i data-lucide="clock" style="width:1.625rem;height:1.625rem;color:#d97706"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,#f59e0b,#d97706);border-radius:2px"></span>
          Articles en attente
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">
          <?= count($articles) ?> en attente de validation
        </p>
      </div>
    </div>
    <div style="display:flex;gap:0.5rem;align-items:center">
      <a href="<?= BASE_URL ?>/?page=admin-article&action=list" class="btn" style="border-radius:var(--radius-xl);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
        <i data-lucide="list" style="width:1rem;height:1rem"></i> Tous
      </a>
      <a href="<?= BASE_URL ?>/?page=admin-article&action=add" class="btn btn-primary" style="border-radius:var(--radius-xl)">
        <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Ajouter
      </a>
    </div>
  </div>

  <div class="card" style="padding:0;overflow:hidden;border:1px solid var(--border)">
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($articles)): ?>
            <tr>
              <td colspan="5" style="text-align:center;padding:3.5rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:var(--muted);border-radius:var(--radius-full);margin-bottom:1rem">
                  <i data-lucide="inbox" style="width:2rem;height:2rem;color:var(--text-muted)"></i>
                </div>
                <p style="font-weight:600;color:var(--text-secondary);margin-top:0.5rem">Aucun article en attente</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($articles as $a): ?>
              <tr>
                <td><span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= (int)$a['id'] ?></span></td>
                <td style="max-width:360px">
                  <span style="color:var(--text-primary);font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block">
                    <?= htmlspecialchars($a['titre'] ?? '') ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($a['auteur'] ?? '') ?></td>
                <td><?= htmlspecialchars($a['date_publication'] ?? '') ?></td>
                <td>
                  <div style="display:flex;gap:0.375rem;align-items:center;flex-wrap:wrap">
                    <a href="<?= BASE_URL ?>/?page=admin-article&action=publish&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Valider & publier" style="background:rgba(82,183,136,0.08);border-color:rgba(82,183,136,0.18);color:var(--primary)" onclick="return confirm('Valider et publier cet article ?')">
                      <i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/?page=admin-article&action=edit&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Modifier" style="background:rgba(45,106,79,0.06);border-color:rgba(45,106,79,0.15)">
                      <i data-lucide="edit-3" style="width:0.85rem;height:0.85rem"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/?page=admin-article&action=delete&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Supprimer" style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.15);color:#ef4444" onclick="return confirm('Supprimer cet article ?')">
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

