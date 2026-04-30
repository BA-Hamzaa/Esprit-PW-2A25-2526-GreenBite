<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="newspaper" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Gestion des Articles
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="database" style="width:0.75rem;height:0.75rem"></i>
          <?= count($articles) ?> article(s)
        </p>
      </div>
    </div>
    <div style="display:flex;gap:0.5rem;align-items:center">
      <a href="<?= BASE_URL ?>/?page=admin-article&action=pending" class="btn" style="border-radius:var(--radius-xl);background:rgba(245,158,11,0.10);border:1px solid rgba(245,158,11,0.22);color:#b45309">
        <i data-lucide="clock" style="width:1rem;height:1rem"></i> En attente
      </a>
      <a href="<?= BASE_URL ?>/?page=admin-comment&action=list" class="btn" style="border-radius:var(--radius-xl);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
        <i data-lucide="messages-square" style="width:1rem;height:1rem"></i> Commentaires
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
            <th>Statut</th>
            <th>Commentaires</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($articles)): ?>
            <tr>
              <td colspan="7" style="text-align:center;padding:3.5rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:var(--muted);border-radius:var(--radius-full);margin-bottom:1rem">
                  <i data-lucide="inbox" style="width:2rem;height:2rem;color:var(--text-muted)"></i>
                </div>
                <p style="font-weight:600;color:var(--text-secondary);margin-top:0.5rem">Aucun article</p>
                <p style="font-size:0.8rem;margin-top:0.25rem">Commencez par ajouter un article.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($articles as $a): ?>
              <?php
                $statut = $a['statut'] ?? 'brouillon';
                $badgeClass = 'badge-primary';
                if ($statut === 'publie') $badgeClass = 'badge-success';
                elseif ($statut === 'en_attente') $badgeClass = 'badge-warning';
              ?>
              <tr>
                <td><span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= (int)$a['id'] ?></span></td>
                <td style="max-width:320px">
                  <div style="display:flex;align-items:center;gap:0.625rem">
                    <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,rgba(45,106,79,0.08),rgba(82,183,136,0.06));border-radius:0.625rem;flex-shrink:0">
                      <i data-lucide="file-text" style="width:0.875rem;height:0.875rem;color:var(--primary)"></i>
                    </div>
                    <span class="font-semibold" style="color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($a['titre']) ?></span>
                  </div>
                </td>
                <td><?= htmlspecialchars($a['auteur'] ?? 'Admin') ?></td>
                <td><span class="badge <?= $badgeClass ?>" style="font-size:0.65rem"><?= htmlspecialchars($statut) ?></span></td>
                <td><?= (int)($a['nb_commentaires'] ?? 0) ?></td>
                <td><?= htmlspecialchars($a['date_publication'] ?? '') ?></td>
                <td>
                  <div style="display:flex;gap:0.375rem;align-items:center;flex-wrap:wrap">
                    <a href="<?= BASE_URL ?>/?page=admin-article&action=edit&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Modifier" style="background:rgba(45,106,79,0.06);border-color:rgba(45,106,79,0.15)">
                      <i data-lucide="edit-3" style="width:0.85rem;height:0.85rem"></i>
                    </a>

                    <?php if (($a['statut'] ?? '') !== 'publie'): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-article&action=publish&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Publier" style="background:rgba(82,183,136,0.08);border-color:rgba(82,183,136,0.18);color:var(--primary)" onclick="return confirm('Publier cet article ?')">
                        <i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem"></i>
                      </a>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>/?page=admin-article&action=delete&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Supprimer" style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.15);color:#ef4444" onclick="return confirm('Supprimer cet article ?')">
                      <i data-lucide="trash-2" style="width:0.85rem;height:0.85rem"></i>
                    </a>

                    <?php if (($a['statut'] ?? '') === 'publie'): ?>
                      <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Voir sur le site" style="background:rgba(59,130,246,0.06);border-color:rgba(59,130,246,0.15);color:#3b82f6">
                        <i data-lucide="external-link" style="width:0.85rem;height:0.85rem"></i>
                      </a>
                    <?php endif; ?>
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

