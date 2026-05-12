<?php
$currentStatut  = $_GET['statut'] ?? '';
$currentSort    = $_GET['sort']   ?? 'date_desc';
$currentKeyword = $_GET['q']      ?? '';

// Counts from ALL articles (not filtered) so tabs always show correct numbers
$counts = ['all' => 0, 'publie' => 0, 'en_attente' => 0, 'brouillon' => 0];
foreach (($allForCounts ?? $articles) as $a) {
    $counts['all']++;
    $s = $a['statut'] ?? 'brouillon';
    if (isset($counts[$s])) $counts[$s]++;
}
?>

<div style="padding:2rem">

  <!-- HEADER -->
  <div class="flex items-center justify-between mb-5">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="newspaper" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Gestion des Articles
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px"><?= $counts['all'] ?> article(s) au total</p>
      </div>
    </div>
    <div style="display:flex;gap:0.5rem;align-items:center">
      <a href="<?= BASE_URL ?>/?page=admin-comment&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
        <i data-lucide="messages-square" style="width:1rem;height:1rem"></i> Commentaires
      </a>
      <a href="<?= BASE_URL ?>/?page=admin-article&action=add" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Ajouter
      </a>
    </div>
  </div>

  <!-- TAB FILTERS -->
  <div style="display:flex;gap:0;border-bottom:2px solid var(--border);margin-bottom:1.25rem">
    <?php
      $tabs = [
        ''           => ['label' => 'Tous',       'count' => $counts['all'],        'color' => 'var(--primary)', 'activeBorder' => 'var(--primary)'],
        'publie'     => ['label' => 'Publiés',    'count' => $counts['publie'],     'color' => '#059669',        'activeBorder' => '#059669'],
        'en_attente' => ['label' => 'En attente', 'count' => $counts['en_attente'], 'color' => '#d97706',        'activeBorder' => '#d97706'],
        'brouillon'  => ['label' => 'Brouillons', 'count' => $counts['brouillon'],  'color' => '#6b7280',        'activeBorder' => '#6b7280'],
      ];
      foreach ($tabs as $val => $tab):
        $isActive = $currentStatut === $val;
        $url = BASE_URL . '/?page=admin-article&action=list&statut=' . urlencode($val) . '&sort=' . urlencode($currentSort) . '&q=' . urlencode($currentKeyword);
    ?>
      <a href="<?= $url ?>"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.7rem 1.25rem;font-size:0.85rem;font-weight:<?= $isActive ? '700' : '600' ?>;text-decoration:none;
                border-bottom:2.5px solid <?= $isActive ? $tab['activeBorder'] : 'transparent' ?>;
                margin-bottom:-2px;
                color:<?= $isActive ? $tab['color'] : 'var(--text-muted)' ?>;
                transition:color 0.2s">
        <?= $tab['label'] ?>
        <span style="font-size:0.7rem;padding:0.1rem 0.45rem;border-radius:9999px;
                     background:<?= $isActive ? $tab['color'] . '15' : 'var(--muted)' ?>;
                     color:<?= $isActive ? $tab['color'] : 'var(--text-muted)' ?>;font-weight:700">
          <?= $tab['count'] ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div style="padding:0.9rem 1.2rem;border-radius:0.75rem;background:#dcfce7;color:#166534;border:1px solid #bbf7d0;margin-bottom:1.25rem;font-weight:600"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div style="padding:0.9rem 1.2rem;border-radius:0.75rem;background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;margin-bottom:1.25rem;font-weight:600"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <!-- SEARCH + SORT -->
  <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem;margin-bottom:1.25rem;flex-wrap:wrap">
      <form method="get" action="<?= BASE_URL ?>/" style="display:flex;gap:0.4rem;align-items:center">
        <input type="hidden" name="page" value="admin-article">
        <input type="hidden" name="action" value="list">
        <input type="hidden" name="statut" value="<?= htmlspecialchars($currentStatut) ?>">
        <input type="hidden" name="sort" value="<?= htmlspecialchars($currentSort) ?>">
        <div style="position:relative">
          <i data-lucide="search" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);width:0.85rem;height:0.85rem;color:var(--text-muted)"></i>
          <input type="text" name="q" value="<?= htmlspecialchars($currentKeyword) ?>"
                 placeholder="Titre ou auteur..."
                 class="input" style="padding-left:2.2rem;padding-top:0.45rem;padding-bottom:0.45rem;font-size:0.82rem;width:220px;border-radius:var(--radius-full)" />
        </div>
        <?php if ($currentKeyword): ?>
          <a href="<?= BASE_URL ?>/?page=admin-article&action=list&statut=<?= urlencode($currentStatut) ?>&sort=<?= urlencode($currentSort) ?>"
             class="btn" style="border-radius:var(--radius-full);padding:0.45rem 0.75rem;font-size:0.8rem">✕</a>
        <?php endif; ?>
      </form>

      <select onchange="window.location.href='<?= BASE_URL ?>/?page=admin-article&action=list&statut=<?= urlencode($currentStatut) ?>&q=<?= urlencode($currentKeyword) ?>&sort='+this.value"
              class="input" style="padding:0.45rem 0.75rem;font-size:0.8rem;border-radius:var(--radius-full);cursor:pointer">
        <option value="date_desc"         <?= $currentSort==='date_desc'         ? 'selected':'' ?>>📅 Plus récents</option>
        <option value="date_asc"          <?= $currentSort==='date_asc'          ? 'selected':'' ?>>📅 Plus anciens</option>
        <option value="commentaires_desc" <?= $currentSort==='commentaires_desc' ? 'selected':'' ?>>💬 + Commentaires</option>
        <option value="commentaires_asc"  <?= $currentSort==='commentaires_asc'  ? 'selected':'' ?>>💬 - Commentaires</option>
      </select>
    </div>

  <!-- TABLE -->
  <div class="card" style="padding:0;overflow:hidden;border:1px solid var(--border)">
    <div style="overflow-x:auto">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr>
            <th>#</th><th>Titre</th><th>Auteur</th><th>Rôle</th><th>Statut</th><th>Commentaires</th><th>Date</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($articles)): ?>
            <tr>
              <td colspan="8" style="text-align:center;padding:3.5rem 2rem;color:var(--text-muted)">
                <div style="font-size:3rem;margin-bottom:0.75rem">🔍</div>
                <p style="font-weight:600;color:var(--text-secondary)">Aucun article trouvé</p>
                <p style="font-size:0.8rem;margin-top:0.25rem">Essayez d'autres filtres ou un autre mot-clé.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($articles as $a):
              $statut = $a['statut'] ?? 'brouillon';
              $badgeClass = $statut === 'publie' ? 'badge-success' : ($statut === 'en_attente' ? 'badge-warning' : 'badge-info');
              $role = $a['role_utilisateur'] ?? '—';
              $roleColor = '#6b7280';
              if (strpos($role,'Chef')!==false) $roleColor='#e76f51';
              elseif (strpos($role,'Nutritionniste')!==false||strpos($role,'Diété')!==false) $roleColor='#059669';
              elseif (strpos($role,'Étudiant')!==false) $roleColor='#3b82f6';
              elseif (strpos($role,'Athlète')!==false||strpos($role,'Sportif')!==false) $roleColor='#f59e0b';
              elseif (strpos($role,'Parent')!==false) $roleColor='#8b5cf6';
              elseif (strpos($role,'Jardinier')!==false) $roleColor='#22c55e';
              elseif (strpos($role,'Food')!==false) $roleColor='#ec4899';
              elseif (strpos($role,'Éco')!==false) $roleColor='#14b8a6';
              elseif (strpos($role,'Passionné')!==false) $roleColor='#f97316';
            ?>
              <tr>
                <td><span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= (int)$a['id'] ?></span></td>
                <td style="max-width:260px">
                  <div style="display:flex;align-items:center;gap:0.625rem">
                    <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,rgba(45,106,79,0.08),rgba(82,183,136,0.06));border-radius:0.625rem;flex-shrink:0">
                      <i data-lucide="file-text" style="width:0.875rem;height:0.875rem;color:var(--primary)"></i>
                    </div>
                    <span style="font-weight:700;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;max-width:200px"><?= htmlspecialchars($a['titre']) ?></span>
                  </div>
                </td>
                <td><?= htmlspecialchars($a['auteur'] ?? 'Admin') ?></td>
                <td><span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.75rem;font-weight:600;color:<?= $roleColor ?>;background:<?= $roleColor ?>10;padding:0.2rem 0.6rem;border-radius:var(--radius-full);border:1px solid <?= $roleColor ?>30"><?= htmlspecialchars($role) ?></span></td>
                <td><span class="badge <?= $badgeClass ?>" style="font-size:0.65rem"><?= htmlspecialchars($statut) ?></span></td>
                <td style="text-align:center"><?= (int)($a['nb_commentaires'] ?? 0) ?></td>
                <td style="font-size:0.78rem;color:var(--text-muted);white-space:nowrap"><?= htmlspecialchars($a['date_publication'] ?? '') ?></td>
                <td>
                  <div style="display:flex;gap:0.375rem;align-items:center">
                    <a href="<?= BASE_URL ?>/?page=admin-article&action=edit&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Modifier" style="background:rgba(45,106,79,0.06);border-color:rgba(45,106,79,0.15)">
                      <i data-lucide="edit-3" style="width:0.85rem;height:0.85rem"></i>
                    </a>
                    <?php if ($statut !== 'publie'): ?>
                      <form method="post" action="<?= BASE_URL ?>/?page=admin-article&action=publish&id=<?= (int)$a['id'] ?>" style="display:inline"
                            onsubmit="return confirm('Publier cet article ?')">
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="icon-btn" title="Publier"
                                style="background:rgba(82,183,136,0.08);border-color:rgba(82,183,136,0.18);color:var(--primary);cursor:pointer">
                          <i data-lucide="check-circle-2" style="width:0.85rem;height:0.85rem"></i>
                        </button>
                      </form>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/?page=admin-article&action=delete&id=<?= (int)$a['id'] ?>" class="icon-btn" title="Supprimer" style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.15);color:#ef4444" onclick="return confirm('Supprimer cet article ?')">
                      <i data-lucide="trash-2" style="width:0.85rem;height:0.85rem"></i>
                    </a>
                    <?php if ($statut === 'publie'): ?>
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