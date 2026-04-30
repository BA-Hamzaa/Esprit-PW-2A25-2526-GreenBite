<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="messages-square" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Modération des Commentaires
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">
          <?= count($commentaires) ?> commentaire(s)
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-article&action=list" class="btn" style="border-radius:var(--radius-xl);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Articles
    </a>
  </div>

  <div class="card" style="padding:0;overflow:hidden;border:1px solid var(--border)">
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Article</th>
            <th>Auteur</th>
            <th>Commentaire</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($commentaires)): ?>
            <tr>
              <td colspan="7" style="text-align:center;padding:3.5rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:var(--muted);border-radius:var(--radius-full);margin-bottom:1rem">
                  <i data-lucide="inbox" style="width:2rem;height:2rem;color:var(--text-muted)"></i>
                </div>
                <p style="font-weight:600;color:var(--text-secondary);margin-top:0.5rem">Aucun commentaire</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($commentaires as $c): ?>
              <?php
                $statut = $c['statut'] ?? 'en_attente';
                $badgeClass = ($statut === 'valide') ? 'badge-success' : 'badge-warning';
                $excerpt = trim($c['contenu'] ?? '');
                if (mb_strlen($excerpt) > 90) $excerpt = mb_substr($excerpt, 0, 90) . '...';
              ?>
              <tr>
                <td><span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= (int)$c['id'] ?></span></td>
                <td style="max-width:240px">
                  <span style="color:var(--text-primary);font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block">
                    <?= htmlspecialchars($c['article_titre'] ?? '') ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($c['pseudo'] ?? '') ?></td>
                <td style="max-width:360px;color:var(--text-secondary)"><?= htmlspecialchars($excerpt) ?></td>
                <td><span class="badge <?= $badgeClass ?>" style="font-size:0.65rem"><?= htmlspecialchars($statut) ?></span></td>
                <td><?= htmlspecialchars($c['date_commentaire'] ?? '') ?></td>
                <td>
                  <div style="display:flex;gap:0.375rem;align-items:center;flex-wrap:wrap">
                    <?php if (($c['statut'] ?? '') !== 'valide'): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-comment&action=validate&id=<?= (int)$c['id'] ?>" class="icon-btn" title="Valider" style="background:rgba(82,183,136,0.08);border-color:rgba(82,183,136,0.18);color:var(--primary)">
                        <i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem"></i>
                      </a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/?page=admin-comment&action=delete&id=<?= (int)$c['id'] ?>" class="icon-btn" title="Supprimer" style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.15);color:#ef4444" onclick="return confirm('Supprimer ce commentaire ?')">
                      <i data-lucide="trash-2" style="width:0.85rem;height:0.85rem"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= (int)$c['article_id'] ?>" class="icon-btn" title="Voir l'article" style="background:rgba(59,130,246,0.06);border-color:rgba(59,130,246,0.15);color:#3b82f6">
                      <i data-lucide="external-link" style="width:0.85rem;height:0.85rem"></i>
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

