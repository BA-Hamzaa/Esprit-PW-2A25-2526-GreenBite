<!-- Vue BackOffice : Liste des Plans Nutritionnels -->
<div class="flex items-center justify-between mb-8">
  <div>
    <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Plans Nutritionnels</h1>
    <p class="text-sm" style="color:var(--text-muted)">Gérez les programmes alimentaires des utilisateurs</p>
  </div>
  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plan-add" class="btn btn-primary btn-round">
    <i data-lucide="plus" style="width:1rem;height:1rem"></i> Nouveau Plan
  </a>
</div>

<div class="card" style="padding:0;overflow:hidden">
  <div style="overflow-x:auto">
    <table style="width:100%;border-collapse:collapse;text-align:left">
      <thead>
        <tr style="border-bottom:2px solid var(--border);background:var(--muted)">
          <th style="padding:1rem">ID</th>
          <th style="padding:1rem">Nom</th>
          <th style="padding:1rem">Objectif</th>
          <th style="padding:1rem">Durée</th>
          <th style="padding:1rem">Calories Cibles</th>
          <th style="padding:1rem">Date Début</th>
          <th style="padding:1rem;text-align:right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($plans)): ?>
          <tr>
            <td colspan="7" style="padding:2rem;text-align:center;color:var(--text-muted)">Aucun plan trouvé.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($plans as $p): ?>
            <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='transparent'">
              <td style="padding:1rem;color:var(--text-muted)">#<?= $p['id'] ?></td>
              <td style="padding:1rem;font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($p['nom']) ?></td>
              <td style="padding:1rem">
                <?php
                  $typeStr = 'Maintien';
                  $badgeCls = 'badge-success';
                  if ($p['type_objectif'] === 'perte_poids') {
                    $typeStr = 'Perte de poids';
                    $badgeCls = 'badge-danger';
                  } elseif ($p['type_objectif'] === 'prise_masse') {
                    $typeStr = 'Prise de masse';
                    $badgeCls = 'badge-primary';
                  }
                ?>
                <span class="badge <?= $badgeCls ?>"><?= $typeStr ?></span>
              </td>
              <td style="padding:1rem;color:var(--text-secondary)"><?= $p['duree_jours'] ?> jours</td>
              <td style="padding:1rem;font-weight:600;color:var(--accent-orange)"><?= $p['objectif_calories'] ?> kcal</td>
              <td style="padding:1rem;color:var(--text-secondary)"><?= date('d/m/Y', strtotime($p['date_debut'])) ?></td>
              <td style="padding:1rem;text-align:right">
                <div class="flex items-center justify-end gap-2">
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plan-edit&id=<?= $p['id'] ?>" class="btn-ghost" title="Modifier" style="padding:0.5rem;border-radius:var(--radius-full)"><i data-lucide="edit" style="width:1rem;height:1rem"></i></a>
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plan-delete&id=<?= $p['id'] ?>" class="btn-ghost" title="Supprimer" style="padding:0.5rem;border-radius:var(--radius-full);color:var(--destructive)" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce plan ? Cette action supprimera également les repas qui lui sont associés.')"><i data-lucide="trash-2" style="width:1rem;height:1rem"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
