<?php
/**
 * Vue BackOffice : Gestion des régimes alimentaires — Modération + CRUD
 */

$objectifLabels = [
    'perte_poids'    => 'Perte de poids',
    'maintien'       => 'Maintien',
    'prise_masse'    => 'Prise de masse',
    'sante_generale' => 'Santé générale',
];

$statutConfig = [
    'en_attente' => ['label'=>'En attente', 'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.1)', 'icon'=>'clock'],
    'accepte'    => ['label'=>'Accepté',    'color'=>'#22c55e', 'bg'=>'rgba(34,197,94,0.1)',  'icon'=>'check-circle-2'],
    'refuse'     => ['label'=>'Refusé',     'color'=>'#ef4444', 'bg'=>'rgba(239,68,68,0.1)',  'icon'=>'x-circle'],
];
?>

<div style="padding:2rem">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 4px 16px rgba(45,106,79,0.18)">
        <i data-lucide="salad" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">
          Régimes Alimentaires
          <?php if ($pendingCount > 0): ?>
            <span style="display:inline-flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border-radius:var(--radius-full);min-width:1.35rem;height:1.35rem;font-size:0.65rem;font-weight:800;padding:0 0.35rem;margin-left:0.5rem;vertical-align:middle"><?= $pendingCount ?></span>
          <?php endif; ?>
        </h1>
        <p style="font-size:0.78rem;color:var(--text-muted);margin-top:2px"><?= count($regimes) ?> régime<?= count($regimes) !== 1 ? 's' : '' ?> au total</p>
      </div>
    </div>
  </div>

  <?php if (empty($regimes)): ?>
    <div class="card" style="padding:4rem 2rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.25rem">
        <i data-lucide="salad" style="width:2.25rem;height:2.25rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:var(--primary);margin-bottom:0.5rem">Aucun régime soumis</h3>
      <p style="color:var(--text-muted);font-size:0.82rem">Les propositions des utilisateurs apparaîtront ici pour modération.</p>
    </div>
  <?php else: ?>

    <div class="card" style="padding:0;overflow:hidden">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Régime</th>
            <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Objectif</th>
            <th style="padding:1rem 1.25rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Durée</th>
            <th style="padding:1rem 1.25rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">kcal/j</th>
            <th style="padding:1rem 1.25rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Soumis par</th>
            <th style="padding:1rem 1.25rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Statut</th>
            <th style="padding:1rem 1.25rem;text-align:right;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($regimes as $r):
            $st = $statutConfig[$r['statut']] ?? $statutConfig['en_attente'];
            $objLabel = $objectifLabels[$r['objectif']] ?? $r['objectif'];
          ?>
          <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(82,183,136,0.03)'" onmouseout="this.style.background=''">
            <!-- Nom + Description -->
            <td style="padding:1rem 1.25rem;max-width:260px">
              <div style="font-weight:700;font-size:0.875rem;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($r['nom']) ?></div>
              <?php if (!empty($r['description'])): ?>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px"><?= htmlspecialchars(mb_substr($r['description'], 0, 80)) ?>…</div>
              <?php endif; ?>
              <?php if (!empty($r['restrictions'])): ?>
                <div style="margin-top:4px;display:flex;align-items:center;gap:0.3rem">
                  <i data-lucide="shield-check" style="width:0.6rem;height:0.6rem;color:var(--secondary)"></i>
                  <span style="font-size:0.65rem;color:var(--secondary)"><?= htmlspecialchars(mb_substr($r['restrictions'], 0, 40)) ?></span>
                </div>
              <?php endif; ?>
            </td>
            <!-- Objectif -->
            <td style="padding:1rem 1.25rem;font-size:0.82rem;color:var(--text-secondary)"><?= htmlspecialchars($objLabel) ?></td>
            <!-- Durée -->
            <td style="padding:1rem 1.25rem;text-align:center">
              <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--text-primary)"><?= (int)$r['duree_semaines'] ?></span>
              <span style="font-size:0.68rem;color:var(--text-muted);display:block">sem.</span>
            </td>
            <!-- Calories -->
            <td style="padding:1rem 1.25rem;text-align:center">
              <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--accent-orange)"><?= number_format((int)$r['calories_jour']) ?></span>
            </td>
            <!-- Soumis par -->
            <td style="padding:1rem 1.25rem">
              <div style="display:flex;align-items:center;gap:0.5rem">
                <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <i data-lucide="user" style="width:0.75rem;height:0.75rem;color:#fff"></i>
                </div>
                <div>
                  <div style="font-size:0.82rem;font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($r['soumis_par']) ?></div>
                  <div style="font-size:0.68rem;color:var(--text-muted)"><?= date('d/m/Y', strtotime($r['created_at'])) ?></div>
                </div>
              </div>
            </td>
            <!-- Statut -->
            <td style="padding:1rem 1.25rem;text-align:center">
              <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;font-size:0.72rem;font-weight:700">
                <i data-lucide="<?= $st['icon'] ?>" style="width:0.75rem;height:0.75rem"></i>
                <?= $st['label'] ?>
              </span>
              <?php if ($r['statut'] === 'refuse' && !empty($r['commentaire_admin'])): ?>
                <div style="margin-top:4px;font-size:0.65rem;color:var(--text-muted);font-style:italic;max-width:130px;margin-left:auto;margin-right:auto">"<?= htmlspecialchars(mb_substr($r['commentaire_admin'], 0, 50)) ?>"</div>
              <?php endif; ?>
            </td>
            <!-- Actions -->
            <td style="padding:1rem 1.25rem;text-align:right">
              <div style="display:flex;gap:0.4rem;justify-content:flex-end;align-items:center;flex-wrap:wrap">
                <?php if ($r['statut'] === 'accepte'): ?>
                  <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=regime-edit-back&id=<?= $r['id'] ?>"
                     style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:rgba(59,130,246,0.1);color:#3b82f6;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(59,130,246,0.2)"
                     onmouseover="this.style.background='rgba(59,130,246,0.18)';this.style.transform='translateY(-1px)'"
                     onmouseout="this.style.background='rgba(59,130,246,0.1)';this.style.transform='none'">
                    <i data-lucide="edit" style="width:0.75rem;height:0.75rem"></i> Modifier
                  </a>
                <?php endif; ?>
                 <?php if ($r['statut'] === 'en_attente' || $r['statut'] === 'refuse'): ?>
                   <button type="button"
                      onclick="openAcceptConfirm('<?= BASE_URL ?>/?page=admin-nutrition&action=regime-accept&id=<?= $r['id'] ?>', '<?= addslashes(htmlspecialchars($r['nom'])) ?>')"
                      style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.2s;white-space:nowrap"
                      onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(34,197,94,0.3)'"
                      onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                     <i data-lucide="check" style="width:0.75rem;height:0.75rem"></i> Accepter
                   </button>
                 <?php endif; ?>

                <?php if ($r['statut'] === 'en_attente' || $r['statut'] === 'accepte'): ?>
                  <button onclick="openRefuseModal(<?= $r['id'] ?>, '<?= addslashes(htmlspecialchars($r['nom'])) ?>')"
                          style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:linear-gradient(135deg,#f87171,#ef4444);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.2s;white-space:nowrap"
                          onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(239,68,68,0.3)'"
                          onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                    <i data-lucide="x" style="width:0.75rem;height:0.75rem"></i> Refuser
                  </button>
                <?php endif; ?>

                <button type="button"
                   onclick="openDeleteConfirmBack('<?= BASE_URL ?>/?page=admin-nutrition&action=regime-delete&id=<?= $r['id'] ?>', '<?= addslashes(htmlspecialchars($r['nom'])) ?>')"
                   style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);cursor:pointer;transition:all 0.2s"
                   onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                   onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'">
                  <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>
</div>

<!-- ===== REFUSE MODAL ===== -->
<div id="refuseModal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:440px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.2);animation:fadeUp 0.25s ease">
    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
      <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:rgba(239,68,68,0.1);display:flex;align-items:center;justify-content:center">
        <i data-lucide="x-circle" style="width:1.25rem;height:1.25rem;color:#ef4444"></i>
      </div>
      <div>
        <div style="font-family:var(--font-heading);font-weight:700;font-size:1rem;color:var(--text-primary)">Refuser le régime</div>
        <div id="refuseRegimeNomLabel" style="font-size:0.78rem;color:var(--text-muted)"></div>
      </div>
    </div>

    <form method="POST" id="refuseForm" action="">
      <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
        Motif du refus (optionnel)
      </label>
      <textarea name="commentaire" rows="3"
                placeholder="Ex: Contenu insuffisant, restrictions non précisées…"
                style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.82rem;background:var(--surface);color:var(--foreground);resize:vertical;outline:none;transition:all 0.3s"
                onfocus="this.style.borderColor='#ef4444';this.style.boxShadow='0 0 0 3px rgba(239,68,68,0.1)'"
                onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"></textarea>

      <div style="display:flex;gap:0.75rem;justify-content:flex-end;margin-top:1rem">
        <button type="button" onclick="closeRefuseModal()" class="btn btn-outline" style="border-radius:var(--radius-full)">Annuler</button>
        <button type="submit" style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.25rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;cursor:pointer;transition:all 0.2s">
          <i data-lucide="x-circle" style="width:0.875rem;height:0.875rem"></i> Confirmer le refus
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openRefuseModal(id, nom) {
  document.getElementById('refuseRegimeNomLabel').textContent = nom;
  document.getElementById('refuseForm').action = '<?= BASE_URL ?>/?page=admin-nutrition&action=regime-refuse&id=' + id;
  document.getElementById('refuseModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeRefuseModal() {
  document.getElementById('refuseModal').style.display = 'none';
}
document.getElementById('refuseModal').addEventListener('click', function(e) {
  if (e.target === this) closeRefuseModal();
});

// ---- Accept Confirm Modal ----
function openAcceptConfirm(url, nom) {
  document.getElementById('acceptConfirmLink').href = url;
  document.getElementById('acceptConfirmMsg').textContent = 'Accepter et publier "' + nom + '" ?';
  document.getElementById('acceptConfirmModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeAcceptConfirm() {
  document.getElementById('acceptConfirmModal').style.display = 'none';
}
document.getElementById('acceptConfirmModal').addEventListener('click', function(e) {
  if (e.target === this) closeAcceptConfirm();
});

// ---- Delete Confirm Modal ----
function openDeleteConfirmBack(url, nom) {
  document.getElementById('deleteConfirmBackLink').href = url;
  document.getElementById('deleteConfirmBackMsg').textContent =
    'Supprimer définitivement "' + nom + '" ? Cette action est irréversible.';
  document.getElementById('deleteConfirmBackModal').style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeDeleteConfirmBack() {
  document.getElementById('deleteConfirmBackModal').style.display = 'none';
}
document.getElementById('deleteConfirmBackModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteConfirmBack();
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeRefuseModal();
    closeAcceptConfirm();
    closeDeleteConfirmBack();
  }
});
</script>

<!-- ===== ACCEPT CONFIRM MODAL ===== -->
<div id="acceptConfirmModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:380px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(34,197,94,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="check-circle-2" style="width:1.625rem;height:1.625rem;color:#22c55e"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Accepter ce régime ?</h3>
    <p id="acceptConfirmMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeAcceptConfirm()"
              style="padding:0.6rem 1.25rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:background 0.2s"
              onmouseover="this.style.background='var(--border)'"
              onmouseout="this.style.background='var(--muted)'">Annuler</button>
      <a id="acceptConfirmLink" href="#"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.25rem;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.2s"
         onmouseover="this.style.boxShadow='0 4px 16px rgba(34,197,94,0.35)'"
         onmouseout="this.style.boxShadow='none'">
        <i data-lucide="check" style="width:0.875rem;height:0.875rem"></i> Oui, accepter
      </a>
    </div>
  </div>
</div>

<!-- ===== DELETE CONFIRM MODAL (BACK) ===== -->
<div id="deleteConfirmBackModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:380px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(239,68,68,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="trash-2" style="width:1.625rem;height:1.625rem;color:#ef4444"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Supprimer ce régime ?</h3>
    <p id="deleteConfirmBackMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeDeleteConfirmBack()"
              style="padding:0.6rem 1.25rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:background 0.2s"
              onmouseover="this.style.background='var(--border)'"
              onmouseout="this.style.background='var(--muted)'">Annuler</button>
      <a id="deleteConfirmBackLink" href="#"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.25rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.2s"
         onmouseover="this.style.boxShadow='0 4px 16px rgba(239,68,68,0.35)'"
         onmouseout="this.style.boxShadow='none'">
        <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i> Oui, supprimer
      </a>
    </div>
  </div>
</div>
