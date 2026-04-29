<!-- Vue BackOffice : Gestion de tous les commentaires recettes -->
<div style="padding:2rem">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;
                  background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl)">
        <i data-lucide="message-circle" style="width:1.5rem;height:1.5rem;color:#7c3aed"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Commentaires Recettes</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($commentaires) ?> commentaire<?= count($commentaires) > 1 ? 's' : '' ?> au total</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=list" class="btn btn-outline btn-sm">
      <i data-lucide="chef-hat" style="width:0.875rem;height:0.875rem"></i> Recettes
    </a>
  </div>

  <!-- Flash messages -->
  <?php if (!empty($_SESSION['success'])): ?>
    <div class="flex items-center gap-3 p-4 rounded-xl mb-6"
         style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);border:1px solid #86efac;color:#166534">
      <i data-lucide="check-circle" style="width:1.25rem;height:1.25rem"></i>
      <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="flex items-center gap-3 p-4 rounded-xl mb-6"
         style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1px solid #fca5a5;color:#991b1b">
      <i data-lucide="x-circle" style="width:1.25rem;height:1.25rem"></i>
      <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <!-- Table -->
  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Recette</th>
            <th>Auteur</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($commentaires)): ?>
            <tr>
              <td colspan="7" class="text-center py-8" style="color:var(--text-muted)">
                Aucun commentaire.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($commentaires as $c): ?>
              <tr>
                <td style="color:var(--text-muted)">#<?= $c['id'] ?></td>
                <td>
                  <a href="<?= BASE_URL ?>/?page=recettes&action=detail&id=<?= $c['recette_id'] ?>"
                     class="font-semibold text-sm" style="color:var(--primary);text-decoration:none"
                     target="_blank">
                    <?= htmlspecialchars($c['recette_titre']) ?>
                    <i data-lucide="external-link" style="width:0.6rem;height:0.6rem;display:inline;margin-left:2px"></i>
                  </a>
                </td>
                <td>
                  <div class="flex items-center gap-2">
                    <div style="display:flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;
                                border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));
                                color:#fff;font-weight:700;font-size:0.7rem;flex-shrink:0">
                      <?= strtoupper(substr($c['auteur'], 0, 1)) ?>
                    </div>
                    <div>
                      <div class="text-sm font-medium" style="color:var(--text-primary)"><?= htmlspecialchars($c['auteur']) ?></div>
                      <?php if (!empty($c['email'])): ?>
                        <div class="text-xs" style="color:var(--text-muted)"><?= htmlspecialchars($c['email']) ?></div>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="flex items-center gap-1" style="color:#f59e0b">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                      <i data-lucide="star"
                         style="width:0.75rem;height:0.75rem;fill:<?= $s <= $c['note'] ? 'currentColor' : 'none' ?>;color:<?= $s <= $c['note'] ? '#f59e0b' : 'var(--border)' ?>"></i>
                    <?php endfor; ?>
                    <span class="font-bold text-xs ml-1" style="color:var(--text-secondary)"><?= $c['note'] ?>/5</span>
                  </div>
                </td>
                <td style="max-width:20rem">
                  <p class="text-sm" style="color:var(--text-secondary);
                     display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                    <?= htmlspecialchars($c['commentaire']) ?>
                  </p>
                </td>
                <td style="color:var(--text-muted);font-size:0.8rem;white-space:nowrap">
                  <?= date('d/m/Y', strtotime($c['created_at'])) ?>
                </td>
                <td>
                  <a href="<?= BASE_URL ?>/?page=admin-recettes&action=comment-delete&id=<?= $c['id'] ?>"
                     class="icon-btn" title="Supprimer" style="color:var(--destructive)"
                     data-confirm="Supprimer définitivement ce commentaire ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer">
                    <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
