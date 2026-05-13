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
    <div style="overflow-x:auto">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">#</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Image</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Titre</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Proposé par</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Statut</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Difficulté</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Catégorie</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Temps</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Calories</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">CO₂</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:150px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($displayed)): ?>
            <tr>
              <td colspan="11" style="text-align:center;padding:4rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:50%;margin-bottom:1.25rem">
                  <i data-lucide="chef-hat" style="width:2.25rem;height:2.25rem;color:#7c3aed"></i>
                </div>
                <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:#7c3aed;margin-bottom:0.5rem">Aucune recette</h3>
                <p style="color:var(--text-muted);font-size:0.82rem">Aucune recette pour ce filtre.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php
              $diffColors  = ['facile'=>['#22c55e','rgba(34,197,94,0.1)'],'moyen'=>['#f59e0b','rgba(245,158,11,0.1)'],'difficile'=>['#ef4444','rgba(239,68,68,0.1)']];
              $statutData = [
                'acceptee'   => ['color'=>'#22c55e','bg'=>'rgba(34,197,94,0.1)',  'icon'=>'check-circle','label'=>'Acceptée'],
                'en_attente' => ['color'=>'#f59e0b','bg'=>'rgba(245,158,11,0.1)','icon'=>'clock',        'label'=>'En attente'],
                'refusee'    => ['color'=>'#ef4444','bg'=>'rgba(239,68,68,0.1)', 'icon'=>'x-circle',    'label'=>'Refusée'],
              ];
            ?>
            <?php foreach ($displayed as $r): ?>
              <?php
                $sd = $statutData[$r['statut']] ?? ['color'=>'#6b7280','bg'=>'rgba(107,114,128,0.1)','icon'=>'help-circle','label'=>$r['statut']];
                $dd = $diffColors[$r['difficulte']] ?? ['#6b7280','rgba(107,114,128,0.1)'];
                $admRimg = MediaHelper::url($r['image'] ?? '', MediaHelper::fallbackRecette($r['categorie'] ?? ''));
              ?>
              <tr style="border-bottom:1px solid var(--border);transition:background 0.2s<?= $r['statut'] === 'en_attente' ? ';background:rgba(245,158,11,0.03)' : '' ?>"
                  onmouseover="this.style.background='<?= $r['statut'] === 'en_attente' ? 'rgba(245,158,11,0.07)' : 'rgba(82,183,136,0.03)' ?>'"
                  onmouseout="this.style.background='<?= $r['statut'] === 'en_attente' ? 'rgba(245,158,11,0.03)' : '' ?>'">
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= (int)$r['id'] ?></span>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <div style="width:3rem;height:3rem;border-radius:0.75rem;overflow:hidden;background:var(--muted);margin:0 auto">
                    <img src="<?= htmlspecialchars($admRimg) ?>" alt="" loading="lazy" style="width:100%;height:100%;object-fit:cover">
                  </div>
                </td>
                <td style="padding:0.75rem 0.875rem">
                  <div style="font-weight:700;font-size:0.875rem;color:var(--primary)"><?= htmlspecialchars($r['titre']) ?></div>
                </td>
                <td style="padding:0.75rem 0.875rem">
                  <?php if (!empty($r['soumis_par'])): ?>
                    <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:var(--text-secondary)">
                      <i data-lucide="user" style="width:0.7rem;height:0.7rem"></i><?= htmlspecialchars($r['soumis_par']) ?>
                    </span>
                  <?php else: ?>
                    <span style="color:var(--text-muted)">—</span>
                  <?php endif; ?>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.65rem;border-radius:var(--radius-full);background:<?= $sd['bg'] ?>;color:<?= $sd['color'] ?>;font-size:0.72rem;font-weight:700">
                    <i data-lucide="<?= $sd['icon'] ?>" style="width:0.65rem;height:0.65rem"></i><?= $sd['label'] ?>
                  </span>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <span style="display:inline-flex;align-items:center;padding:0.25rem 0.65rem;border-radius:var(--radius-full);background:<?= $dd[1] ?>;color:<?= $dd[0] ?>;font-size:0.72rem;font-weight:700;border:1px solid <?= $dd[0] ?>30"><?= ucfirst($r['difficulte']) ?></span>
                </td>
                <td style="padding:0.75rem 0.875rem;font-size:0.82rem;color:var(--text-secondary)"><?= htmlspecialchars($r['categorie'] ?? '-') ?></td>
                <td style="padding:0.75rem 0.875rem;text-align:center;font-size:0.82rem;color:var(--text-secondary)">
                  <i data-lucide="clock" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle"></i>
                  <?= $r['temps_preparation'] ?>min
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--accent-orange)"><?= $r['calories_total'] ?></span>
                  <span style="font-size:0.65rem;color:var(--text-muted);display:block">kcal</span>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <?= $r['score_carbone'] <= 1
                    ? '<span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.6rem;border-radius:var(--radius-full);background:rgba(34,197,94,0.1);color:#16a34a;font-size:0.72rem;font-weight:700"><i data-lucide=\'leaf\' style=\'width:0.65rem;height:0.65rem\'></i>Low</span>'
                    : '<span style="display:inline-flex;align-items:center;padding:0.25rem 0.6rem;border-radius:var(--radius-full);background:var(--muted);color:var(--text-muted);font-size:0.72rem;font-weight:700">' . $r['score_carbone'] . '</span>' ?>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <div style="display:inline-flex;gap:0.4rem;justify-content:center;align-items:center;flex-wrap:nowrap;white-space:nowrap">
                    <?php if ($r['statut'] === 'en_attente'): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=accept&id=<?= $r['id'] ?>"
                         style="display:inline-flex;align-items:center;justify-content:center;width:1.9rem;height:1.9rem;background:rgba(34,197,94,0.1);color:#16a34a;border-radius:var(--radius-full);border:1px solid rgba(34,197,94,0.25);transition:all 0.2s;text-decoration:none"
                         onmouseover="this.style.background='rgba(34,197,94,0.2)';this.style.transform='translateY(-1px)'"
                         onmouseout="this.style.background='rgba(34,197,94,0.1)';this.style.transform='none'"
                         title="Accepter" data-confirm="Accepter cette recette ?" data-confirm-type="success" data-confirm-btn="Accepter">
                        <i data-lucide="check-circle" style="width:0.8rem;height:0.8rem"></i>
                      </a>
                      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=refuse&id=<?= $r['id'] ?>"
                         style="display:inline-flex;align-items:center;justify-content:center;width:1.9rem;height:1.9rem;background:rgba(239,68,68,0.1);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.25);transition:all 0.2s;text-decoration:none"
                         onmouseover="this.style.background='rgba(239,68,68,0.2)';this.style.transform='translateY(-1px)'"
                         onmouseout="this.style.background='rgba(239,68,68,0.1)';this.style.transform='none'"
                         title="Refuser" data-confirm="Refuser cette recette ?" data-confirm-type="danger" data-confirm-btn="Refuser">
                        <i data-lucide="x-circle" style="width:0.8rem;height:0.8rem"></i>
                      </a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=edit&id=<?= $r['id'] ?>"
                       style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.7rem;background:rgba(59,130,246,0.1);color:#3b82f6;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(59,130,246,0.2)"
                       onmouseover="this.style.background='rgba(59,130,246,0.18)';this.style.transform='translateY(-1px)'"
                       onmouseout="this.style.background='rgba(59,130,246,0.1)';this.style.transform='none'">
                      <i data-lucide="edit" style="width:0.72rem;height:0.72rem"></i> Modifier
                    </a>
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=delete&id=<?= $r['id'] ?>"
                       style="display:inline-flex;align-items:center;justify-content:center;width:1.9rem;height:1.9rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);transition:all 0.2s;text-decoration:none"
                       onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                       onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                       title="Supprimer" data-confirm="Supprimer cette recette ?" data-confirm-type="danger" data-confirm-btn="Supprimer">
                      <i data-lucide="trash-2" style="width:0.72rem;height:0.72rem"></i>
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

