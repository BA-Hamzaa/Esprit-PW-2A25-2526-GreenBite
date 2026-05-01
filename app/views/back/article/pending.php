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
      <a href="<?= BASE_URL ?>/?page=admin-article&action=add" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Ajouter
      </a>
    </div>
  </div>

  <!-- TAB NAVIGATION -->
  <div style="display:flex;gap:0;border-bottom:2px solid var(--border);margin-bottom:1.25rem">
    <a href="<?= BASE_URL ?>/?page=admin-article&action=list"
       style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.7rem 1.25rem;font-size:0.85rem;font-weight:600;text-decoration:none;border-bottom:2.5px solid transparent;margin-bottom:-2px;color:var(--text-muted)">
      <i data-lucide="newspaper" style="width:0.9rem;height:0.9rem"></i> Articles
    </a>
    <a href="<?= BASE_URL ?>/?page=admin-article&action=pending"
       style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.7rem 1.25rem;font-size:0.85rem;font-weight:700;text-decoration:none;border-bottom:2.5px solid #d97706;margin-bottom:-2px;color:#d97706">
      <i data-lucide="clock" style="width:0.9rem;height:0.9rem"></i> En attente
      <span style="font-size:0.7rem;padding:0.1rem 0.45rem;border-radius:9999px;background:rgba(217,119,6,0.12);color:#d97706;font-weight:700"><?= count($articles) ?></span>
    </a>
    <a href="<?= BASE_URL ?>/?page=admin-comment&action=list"
       style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.7rem 1.25rem;font-size:0.85rem;font-weight:600;text-decoration:none;border-bottom:2.5px solid transparent;margin-bottom:-2px;color:var(--text-muted)">
      <i data-lucide="messages-square" style="width:0.9rem;height:0.9rem"></i> Commentaires
    </a>
  </div>

  <div class="card" style="padding:0;overflow:hidden;border:1px solid var(--border)">
    <div style="overflow-x:auto;">
      <table class="table" style="width:100%;border-collapse:collapse;">
        <thead>
          <tr>
            <th>#</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Rôle</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($articles)): ?>
            <tr>
              <td colspan="6" style="text-align:center;padding:3.5rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:var(--muted);border-radius:var(--radius-full);margin-bottom:1rem">
                  <i data-lucide="inbox" style="width:2rem;height:2rem;color:var(--text-muted)"></i>
                </div>
                <p style="font-weight:600;color:var(--text-secondary);margin-top:0.5rem">Aucun article en attente</p>
                <p style="font-size:0.8rem;margin-top:0.25rem">Tous les articles ont été traités ! 🎉</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($articles as $a):
              $role = $a['role_utilisateur'] ?? '—';
              $roleColor = '#6b7280';
              if (strpos($role, 'Chef') !== false) $roleColor = '#e76f51';
              elseif (strpos($role, 'Nutritionniste') !== false || strpos($role, 'Diété') !== false) $roleColor = '#059669';
              elseif (strpos($role, 'Étudiant') !== false) $roleColor = '#3b82f6';
              elseif (strpos($role, 'Athlète') !== false || strpos($role, 'Sportif') !== false) $roleColor = '#f59e0b';
              elseif (strpos($role, 'Parent') !== false) $roleColor = '#8b5cf6';
              elseif (strpos($role, 'Jardinier') !== false) $roleColor = '#22c55e';
              elseif (strpos($role, 'Food') !== false) $roleColor = '#ec4899';
              elseif (strpos($role, 'Éco') !== false) $roleColor = '#14b8a6';
              elseif (strpos($role, 'Passionné') !== false) $roleColor = '#f97316';
            ?>
              <tr>
                <td><span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= (int)$a['id'] ?></span></td>
                <td style="max-width:320px">
                  <span style="color:var(--text-primary);font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block">
                    <?= htmlspecialchars($a['titre'] ?? '') ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($a['auteur'] ?? '') ?></td>
                <td>
                  <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.75rem;font-weight:600;color:<?= $roleColor ?>;background:<?= $roleColor ?>10;padding:0.2rem 0.6rem;border-radius:var(--radius-full);border:1px solid <?= $roleColor ?>30">
                    <?= htmlspecialchars($role) ?>
                  </span>
                </td>
                <td style="font-size:0.78rem;color:var(--text-muted);white-space:nowrap"><?= htmlspecialchars($a['date_publication'] ?? '') ?></td>
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