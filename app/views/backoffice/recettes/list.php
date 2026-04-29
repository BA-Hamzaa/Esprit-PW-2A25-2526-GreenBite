<!-- Vue BackOffice : Liste des recettes (avec modération) -->
<div style="padding:2rem">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;
                  background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl)">
        <i data-lucide="chef-hat" style="width:1.5rem;height:1.5rem;color:#7c3aed"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Recettes</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($recettes) ?> recettes au total</p>
      </div>
    </div>
    <div class="flex gap-3 items-center">
      <!-- Badge pending -->
      <?php
        $pending = array_filter($recettes, fn($r) => $r['statut'] === 'en_attente');
        $pendingCount = count($pending);
      ?>
      <?php if ($pendingCount > 0): ?>
        <a href="<?= BASE_URL ?>/?page=admin-recettes&action=moderate"
           class="btn btn-sm"
           style="background:linear-gradient(135deg,#fef9c3,#fefce8);border:1px solid #fde68a;color:#92400e;font-weight:600;position:relative">
          <i data-lucide="clock" style="width:0.875rem;height:0.875rem"></i>
          Modérer
          <span style="display:inline-flex;align-items:center;justify-content:center;width:1.25rem;height:1.25rem;
                       background:#d97706;color:#fff;border-radius:50%;font-size:0.65rem;font-weight:700;margin-left:4px">
            <?= $pendingCount ?>
          </span>
        </a>
      <?php endif; ?>
      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=add" class="btn btn-primary">
        <i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter une recette
      </a>
    </div>
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

  <!-- Filter tabs -->
  <?php
    $filterStatut = $_GET['filter'] ?? 'all';
    $tabs = [
      'all'        => ['label' => 'Toutes',     'icon' => 'list',         'color' => '#6366f1'],
      'acceptee'   => ['label' => 'Acceptées',  'icon' => 'check-circle', 'color' => '#16a34a'],
      'en_attente' => ['label' => 'En attente', 'icon' => 'clock',        'color' => '#d97706'],
      'refusee'    => ['label' => 'Refusées',   'icon' => 'x-circle',     'color' => '#dc2626'],
    ];
    $counts = ['all' => count($recettes), 'acceptee' => 0, 'en_attente' => 0, 'refusee' => 0];
    foreach ($recettes as $r) { if (isset($counts[$r['statut']])) $counts[$r['statut']]++; }
    $displayed = $filterStatut === 'all' ? $recettes
               : array_values(array_filter($recettes, fn($r) => $r['statut'] === $filterStatut));
  ?>
  <div class="flex gap-2 mb-4" style="flex-wrap:wrap">
    <?php foreach ($tabs as $key => $tab): ?>
      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=list&filter=<?= $key ?>"
         class="btn btn-sm"
         style="<?= $filterStatut === $key
           ? "background:{$tab['color']};color:#fff;border-color:{$tab['color']}"
           : 'background:var(--muted);color:var(--text-secondary);border-color:var(--border)' ?>">
        <i data-lucide="<?= $tab['icon'] ?>" style="width:0.8rem;height:0.8rem"></i>
        <?= $tab['label'] ?>
        <span style="display:inline-flex;align-items:center;justify-content:center;
                     width:1.1rem;height:1.1rem;border-radius:50%;font-size:0.65rem;font-weight:700;
                     background:<?= $filterStatut === $key ? 'rgba(255,255,255,0.3)' : 'var(--border)' ?>;
                     color:<?= $filterStatut === $key ? '#fff' : 'var(--text-muted)' ?>;margin-left:2px">
          <?= $counts[$key] ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Table -->
  <div class="card" style="padding:0;overflow:hidden">
    <div class="table-container">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Titre</th>
            <th>Proposé par</th>
            <th>Statut</th>
            <th>Difficulté</th>
            <th>Catégorie</th>
            <th>Temps</th>
            <th>Calories</th>
            <th>CO₂</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($displayed)): ?>
            <tr>
              <td colspan="11" class="text-center py-8" style="color:var(--text-muted)">
                Aucune recette pour ce filtre.
              </td>
            </tr>
          <?php else: ?>
            <?php
              $diffBadges  = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light'];
              $statutBadges = [
                'acceptee'   => ['class'=>'badge-success',     'label'=>'Acceptée',   'icon'=>'check-circle'],
                'en_attente' => ['class'=>'badge-yellow-light','label'=>'En attente', 'icon'=>'clock'],
                'refusee'    => ['class'=>'badge-red-light',   'label'=>'Refusée',    'icon'=>'x-circle'],
              ];
            ?>
            <?php foreach ($displayed as $r): ?>
              <tr style="<?= $r['statut'] === 'en_attente' ? 'background:rgba(253,230,138,0.08)' : '' ?>">
                <td style="color:var(--text-muted)">#<?= $r['id'] ?></td>
                <td>
                  <div style="width:3rem;height:3rem;border-radius:var(--radius-lg);overflow:hidden;background:var(--muted)">
                    <?php if (!empty($r['image'])): ?>
                      <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($r['image']) ?>"
                           style="width:100%;height:100%;object-fit:cover">
                    <?php else: ?>
                      <div class="flex items-center justify-center" style="height:100%;font-size:1.25rem">🍽️</div>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="font-semibold" style="color:var(--primary)"><?= htmlspecialchars($r['titre']) ?></td>
                <td style="color:var(--text-secondary)">
                  <?php if (!empty($r['soumis_par'])): ?>
                    <span class="flex items-center gap-1 text-xs">
                      <i data-lucide="user" style="width:0.7rem;height:0.7rem"></i>
                      <?= htmlspecialchars($r['soumis_par']) ?>
                    </span>
                  <?php else: ?>
                    <span style="color:var(--text-muted)">—</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php $sb = $statutBadges[$r['statut']] ?? ['class'=>'badge-gray','label'=>$r['statut'],'icon'=>'help-circle']; ?>
                  <span class="badge <?= $sb['class'] ?>">
                    <i data-lucide="<?= $sb['icon'] ?>" style="width:0.6rem;height:0.6rem"></i>
                    <?= $sb['label'] ?>
                  </span>
                </td>
                <td>
                  <span class="badge <?= $diffBadges[$r['difficulte']] ?? 'badge-gray' ?>">
                    <?= ucfirst($r['difficulte']) ?>
                  </span>
                </td>
                <td style="color:var(--text-secondary)"><?= htmlspecialchars($r['categorie'] ?? '-') ?></td>
                <td style="color:var(--text-secondary)">
                  <i data-lucide="clock" style="width:0.75rem;height:0.75rem;display:inline;vertical-align:middle"></i>
                  <?= $r['temps_preparation'] ?>min
                </td>
                <td><span class="font-semibold" style="color:var(--accent-orange)"><?= $r['calories_total'] ?> kcal</span></td>
                <td>
                  <?= $r['score_carbone'] <= 1
                    ? '<span class="badge badge-success"><i data-lucide="leaf" style="width:0.7rem;height:0.7rem"></i> Low</span>'
                    : '<span class="badge badge-gray">' . $r['score_carbone'] . '</span>' ?>
                </td>
                <td>
                  <div class="flex gap-1">
                    <!-- Moderation: Accept/Refuse only for pending -->
                    <?php if ($r['statut'] === 'en_attente'): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=accept&id=<?= $r['id'] ?>"
                         class="icon-btn" title="Accepter"
                         style="color:#16a34a;background:rgba(22,163,74,0.1)"
                         data-confirm="Accepter cette recette ?" data-confirm-title="Accepter" data-confirm-type="success" data-confirm-btn="Accepter">
                        <i data-lucide="check-circle" style="width:0.875rem;height:0.875rem"></i>
                      </a>
                      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=refuse&id=<?= $r['id'] ?>"
                         class="icon-btn" title="Refuser"
                         style="color:#dc2626;background:rgba(220,38,38,0.1)"
                         data-confirm="Refuser cette recette ?" data-confirm-title="Refuser" data-confirm-type="danger" data-confirm-btn="Refuser">
                        <i data-lucide="x-circle" style="width:0.875rem;height:0.875rem"></i>
                      </a>
                    <?php endif; ?>
                    <!-- Standard edit/delete -->
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=edit&id=<?= $r['id'] ?>"
                       class="icon-btn" title="Modifier">
                      <i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=delete&id=<?= $r['id'] ?>"
                       class="icon-btn" title="Supprimer" style="color:var(--destructive)"
                       data-confirm="Supprimer cette recette ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer">
                      <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i>
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
