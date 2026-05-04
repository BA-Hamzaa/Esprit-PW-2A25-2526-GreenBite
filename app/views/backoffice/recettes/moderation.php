<!-- Vue BackOffice : Modération des recettes en attente -->
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
          Modération — Recettes en attente
        </h1>
        <p class="text-sm" style="color:var(--text-muted)">
          <?= count($recettes) ?> recette<?= count($recettes) > 1 ? 's' : '' ?> en attente de validation
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=list" class="btn btn-outline btn-sm">
      <i data-lucide="list" style="width:0.875rem;height:0.875rem"></i> Toutes les recettes
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

  <?php if (empty($recettes)): ?>
    <!-- Empty state -->
    <div class="card text-center" style="padding:4rem 2rem">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5rem;height:5rem;
                  background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.5rem">
        <i data-lucide="check-circle-2" style="width:2.5rem;height:2.5rem;color:var(--primary)"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2" style="color:var(--primary)">Tout est à jour !</h3>
      <p style="color:var(--text-secondary)">Aucune recette en attente de validation. 🎉</p>
    </div>

  <?php else: ?>
    <!-- Cards grid -->
    <div class="grid grid-cols-2 gap-6">
      <?php foreach ($recettes as $r): ?>
        <div class="card" style="padding:0;overflow:hidden;border:2px solid #fde68a;position:relative">

          <!-- Badge statut -->
          <div style="position:absolute;top:1rem;right:1rem;z-index:2">
            <span class="badge badge-yellow-light" style="font-size:0.7rem;font-weight:600">
              <i data-lucide="clock" style="width:0.6rem;height:0.6rem"></i> En attente
            </span>
          </div>

          <!-- Image -->
          <?php $modImg = gb_media_url($r['image'] ?? '', gb_fallback_recette($r['categorie'] ?? '')); ?>
          <div style="height:9rem;background:var(--muted);position:relative;overflow:hidden">
            <img src="<?= htmlspecialchars($modImg) ?>"
                 alt="<?= htmlspecialchars($r['titre']) ?>"
                 loading="lazy" style="width:100%;height:100%;object-fit:cover">
          </div>

          <!-- Content -->
          <div style="padding:1.25rem">
            <h3 class="font-bold mb-1" style="color:var(--text-primary);font-family:var(--font-heading);font-size:1.05rem">
              <?= htmlspecialchars($r['titre']) ?>
            </h3>

            <!-- Proposé par -->
            <?php if (!empty($r['soumis_par'])): ?>
              <div class="flex items-center gap-1 mb-2 text-xs" style="color:var(--text-muted)">
                <i data-lucide="user" style="width:0.75rem;height:0.75rem"></i>
                Proposé par <strong style="color:var(--secondary)"><?= htmlspecialchars($r['soumis_par']) ?></strong>
              </div>
            <?php endif; ?>

            <!-- Description -->
            <?php if (!empty($r['description'])): ?>
              <p class="text-sm mb-3" style="color:var(--text-secondary);
                 display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                <?= htmlspecialchars($r['description']) ?>
              </p>
            <?php endif; ?>

            <!-- Méta info -->
            <div class="flex flex-wrap gap-3 text-xs mb-4" style="color:var(--text-muted)">
              <?php $diffBadges = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light']; ?>
              <span class="badge <?= $diffBadges[$r['difficulte']] ?? 'badge-gray' ?>">
                <?= ucfirst($r['difficulte']) ?>
              </span>
              <span class="flex items-center gap-1">
                <i data-lucide="clock" style="width:0.7rem;height:0.7rem"></i>
                <?= $r['temps_preparation'] ?> min
              </span>
              <span class="flex items-center gap-1" style="color:var(--accent-orange)">
                <i data-lucide="flame" style="width:0.7rem;height:0.7rem"></i>
                <?= $r['calories_total'] ?> kcal
              </span>
              <?php if (!empty($r['categorie'])): ?>
                <span class="badge badge-gray"><?= htmlspecialchars($r['categorie']) ?></span>
              <?php endif; ?>
              <span class="flex items-center gap-1" style="color:var(--text-muted)">
                <i data-lucide="calendar" style="width:0.7rem;height:0.7rem"></i>
                <?= date('d/m/Y', strtotime($r['created_at'])) ?>
              </span>
            </div>

            <!-- Instructions preview -->
            <details class="mb-4">
              <summary class="text-xs font-semibold cursor-pointer" style="color:var(--primary)">
                <i data-lucide="list-ordered" style="width:0.75rem;height:0.75rem;display:inline"></i>
                Voir les instructions
              </summary>
              <div class="mt-2 p-3 rounded-lg text-xs" style="background:var(--muted);color:var(--text-secondary);line-height:1.6;white-space:pre-wrap">
                <?= htmlspecialchars($r['instructions']) ?>
              </div>
            </details>

            <!-- Action buttons -->
            <div class="flex gap-3">
              <a href="<?= BASE_URL ?>/?page=admin-recettes&action=accept&id=<?= $r['id'] ?>"
                 class="btn btn-primary flex-1"
                 style="background:linear-gradient(135deg,#16a34a,#22c55e);border:none;font-size:0.85rem"
                 data-confirm="Accepter et publier cette recette ?" data-confirm-title="Accepter la recette" data-confirm-type="success" data-confirm-btn="Accepter">
                <i data-lucide="check-circle" style="width:1rem;height:1rem"></i>
                Accepter
              </a>
              <a href="<?= BASE_URL ?>/?page=admin-recettes&action=refuse&id=<?= $r['id'] ?>"
                 class="btn flex-1"
                 style="background:linear-gradient(135deg,#dc2626,#ef4444);border:none;color:#fff;font-size:0.85rem;border-radius:var(--radius-xl);padding:0.625rem 1rem;display:flex;align-items:center;justify-content:center;gap:0.5rem;font-weight:600;cursor:pointer"
                 data-confirm="Refuser cette recette ?" data-confirm-title="Refuser la recette" data-confirm-type="danger" data-confirm-btn="Refuser">
                <i data-lucide="x-circle" style="width:1rem;height:1rem"></i>
                Refuser
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
