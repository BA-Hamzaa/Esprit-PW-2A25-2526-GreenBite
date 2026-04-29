<!-- Vue BackOffice : Modération des commentaires en attente -->
<div style="padding:2rem">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;
                  background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:var(--radius-xl)">
        <i data-lucide="clock" style="width:1.5rem;height:1.5rem;color:#d97706"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">
          Modération — Commentaires en attente
        </h1>
        <p class="text-sm" style="color:var(--text-muted)">
          <?= count($commentaires) ?> commentaire<?= count($commentaires) > 1 ? 's' : '' ?> en attente de validation
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=comments" class="btn btn-outline btn-sm">
      <i data-lucide="list" style="width:0.875rem;height:0.875rem"></i> Tous les commentaires
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

  <?php if (empty($commentaires)): ?>
    <!-- Empty state -->
    <div class="card text-center" style="padding:4rem 2rem">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5rem;height:5rem;
                  background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.5rem">
        <i data-lucide="check-circle-2" style="width:2.5rem;height:2.5rem;color:var(--primary)"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2" style="color:var(--primary)">Tout est à jour !</h3>
      <p style="color:var(--text-secondary)">Aucun commentaire en attente de validation. 🎉</p>
    </div>

  <?php else: ?>
    <!-- Cards grid -->
    <div class="grid grid-cols-2 gap-6">
      <?php foreach ($commentaires as $c): ?>
        <div class="card" style="padding:0;overflow:hidden;border:2px solid #fde68a;position:relative">

          <!-- Badge statut -->
          <div style="position:absolute;top:1rem;right:1rem;z-index:2">
            <span class="badge badge-yellow-light" style="font-size:0.7rem;font-weight:600">
              <i data-lucide="clock" style="width:0.6rem;height:0.6rem"></i> En attente
            </span>
          </div>

          <!-- Content -->
          <div style="padding:1.5rem">

            <!-- Recette liée (JOIN) -->
            <div class="flex items-center gap-2 mb-3 p-2 rounded-xl" style="background:var(--muted)">
              <i data-lucide="chef-hat" style="width:0.875rem;height:0.875rem;color:var(--primary);flex-shrink:0"></i>
              <div class="text-xs" style="color:var(--text-muted)">Recette :</div>
              <a href="<?= BASE_URL ?>/?page=recettes&action=detail&id=<?= $c['recette_id'] ?>"
                 class="text-xs font-semibold" style="color:var(--primary);text-decoration:none" target="_blank">
                <?= htmlspecialchars($c['recette_titre']) ?>
                <i data-lucide="external-link" style="width:0.5rem;height:0.5rem;display:inline"></i>
              </a>
            </div>

            <!-- Auteur + avatar -->
            <div class="flex items-center gap-3 mb-3">
              <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;
                          border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));
                          color:#fff;font-weight:700;font-size:1rem;flex-shrink:0">
                <?= strtoupper(substr($c['auteur'], 0, 1)) ?>
              </div>
              <div>
                <div class="font-bold text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($c['auteur']) ?></div>
                <?php if (!empty($c['email'])): ?>
                  <div class="text-xs" style="color:var(--text-muted)"><?= htmlspecialchars($c['email']) ?></div>
                <?php endif; ?>
                <div class="text-xs" style="color:var(--text-muted)">
                  <i data-lucide="calendar" style="width:0.6rem;height:0.6rem;display:inline"></i>
                  <?= date('d/m/Y à H\hi', strtotime($c['created_at'])) ?>
                </div>
              </div>
            </div>

            <!-- Étoiles -->
            <div class="flex items-center gap-1 mb-3" style="color:#f59e0b">
              <?php for ($s = 1; $s <= 5; $s++): ?>
                <i data-lucide="star"
                   style="width:1.1rem;height:1.1rem;fill:<?= $s <= $c['note'] ? 'currentColor' : 'none' ?>;color:<?= $s <= $c['note'] ? '#f59e0b' : 'var(--border)' ?>"></i>
              <?php endfor; ?>
              <span class="font-bold text-sm ml-2" style="color:var(--text-secondary)"><?= $c['note'] ?>/5</span>
            </div>

            <!-- Texte du commentaire -->
            <div class="p-3 rounded-xl mb-4" style="background:var(--muted)">
              <p class="text-sm" style="color:var(--text-secondary);line-height:1.7;white-space:pre-wrap">
                <?= htmlspecialchars($c['commentaire']) ?>
              </p>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-3">
              <a href="<?= BASE_URL ?>/?page=admin-recettes&action=comment-approve&id=<?= $c['id'] ?>"
                 class="btn btn-primary flex-1"
                 style="background:linear-gradient(135deg,#16a34a,#22c55e);border:none;font-size:0.85rem"
                 data-confirm="Approuver et publier ce commentaire ?" data-confirm-title="Approuver le commentaire" data-confirm-type="success" data-confirm-btn="Approuver">
                <i data-lucide="check-circle" style="width:1rem;height:1rem"></i>
                Approuver
              </a>
              <a href="<?= BASE_URL ?>/?page=admin-recettes&action=comment-refuse&id=<?= $c['id'] ?>"
                 class="btn flex-1"
                 style="background:linear-gradient(135deg,#dc2626,#ef4444);border:none;color:#fff;font-size:0.85rem;border-radius:var(--radius-xl);padding:0.625rem 1rem;display:flex;align-items:center;justify-content:center;gap:0.5rem;font-weight:600;cursor:pointer"
                 data-confirm="Refuser ce commentaire ?" data-confirm-title="Refuser le commentaire" data-confirm-type="danger" data-confirm-btn="Refuser">
                <i data-lucide="x-circle" style="width:1rem;height:1rem"></i>
                Refuser
              </a>
              <a href="<?= BASE_URL ?>/?page=admin-recettes&action=comment-delete&id=<?= $c['id'] ?>"
                 class="icon-btn" title="Supprimer définitivement" style="color:var(--destructive);flex-shrink:0;align-self:center"
                 data-confirm="Supprimer définitivement ce commentaire ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer">
                <i data-lucide="trash-2" style="width:1rem;height:1rem"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
