<?php
/**
 * Vue FrontOffice : Liste des régimes alimentaires acceptés
 */

$objectifLabels = [
    'perte_poids'    => 'Perte de poids',
    'maintien'       => 'Maintien du poids',
    'prise_masse'    => 'Prise de masse',
    'sante_generale' => 'Santé générale',
];
$objectifIcons = [
    'perte_poids'    => 'trending-down',
    'maintien'       => 'target',
    'prise_masse'    => 'dumbbell',
    'sante_generale' => 'heart-pulse',
];
$objectifColors = [
    'perte_poids'    => ['from'=>'#3b82f6','to'=>'#2563eb','bg'=>'rgba(59,130,246,0.08)'],
    'maintien'       => ['from'=>'#52B788','to'=>'#2D6A4F','bg'=>'rgba(82,183,136,0.08)'],
    'prise_masse'    => ['from'=>'#f59e0b','to'=>'#d97706','bg'=>'rgba(245,158,11,0.08)'],
    'sante_generale' => ['from'=>'#ec4899','to'=>'#db2777','bg'=>'rgba(236,72,153,0.08)'],
];
?>

<div style="padding:2rem;position:relative">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.18);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="salad" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Régimes Alimentaires
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="check-circle" style="width:0.75rem;height:0.75rem;color:var(--secondary)"></i>
          <?= count($regimes) ?> régime<?= count($regimes) !== 1 ? 's' : '' ?> approuvé<?= count($regimes) !== 1 ? 's' : '' ?>
        </p>
      </div>
    </div>

  </div>

  <?php if (empty($regimes)): ?>
    <!-- Empty state -->
    <div class="card" style="padding:5rem 2rem;text-align:center;background:linear-gradient(135deg,rgba(82,183,136,0.04),rgba(45,106,79,0.02))">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5.5rem;height:5.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.5rem;box-shadow:0 8px 24px rgba(45,106,79,0.12);animation:float 3s ease-in-out infinite">
        <i data-lucide="salad" style="width:2.75rem;height:2.75rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.375rem;font-weight:800;color:var(--primary);margin-bottom:0.625rem">Aucun régime disponible</h3>
      <p style="color:var(--text-secondary);margin-bottom:2rem;max-width:22rem;margin-left:auto;margin-right:auto;line-height:1.65">Soyez le premier à proposer un régime alimentaire ! Notre équipe l'examinera rapidement. 🌿</p>
      <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-add" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Proposer le premier régime
      </a>
    </div>
  <?php else: ?>

    <!-- Regime Cards Grid -->
    <div class="grid grid-cols-3 gap-5">
      <?php foreach ($regimes as $regime):
        $obj    = $regime['objectif'];
        $lbl    = $objectifLabels[$obj]  ?? $obj;
        $ico    = $objectifIcons[$obj]   ?? 'target';
        $colors = $objectifColors[$obj]  ?? ['from'=>'#52B788','to'=>'#2D6A4F','bg'=>'rgba(82,183,136,0.08)'];
      ?>
        <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-detail&id=<?= $regime['id'] ?>" class="card searchable-regime" style="padding:0;overflow:hidden;border:1px solid var(--border);transition:all 0.3s;display:flex;flex-direction:column;text-decoration:none;cursor:pointer"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.1)'"
             onmouseout="this.style.transform='none';this.style.boxShadow=''">

          <!-- Card Top Accent -->
          <div style="height:4px;background:linear-gradient(90deg,<?= $colors['from'] ?>,<?= $colors['to'] ?>)"></div>

          <!-- Card Body -->
          <div style="padding:1.5rem;flex:1;display:flex;flex-direction:column;gap:1rem">

            <!-- Header -->
            <div class="flex items-start gap-3">
              <div style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:<?= $colors['bg'] ?>;border:1px solid <?= $colors['from'] ?>22;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i data-lucide="<?= $ico ?>" style="width:1.25rem;height:1.25rem;color:<?= $colors['from'] ?>"></i>
              </div>
              <div style="flex:1;min-width:0">
                <h3 style="font-family:var(--font-heading);font-weight:700;color:var(--text-primary);font-size:1rem;line-height:1.3;margin-bottom:0.25rem"><?= htmlspecialchars($regime['nom']) ?></h3>
                <span style="display:inline-block;font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:<?= $colors['from'] ?>;background:<?= $colors['bg'] ?>;padding:0.18rem 0.55rem;border-radius:var(--radius-full)"><?= $lbl ?></span>
              </div>
            </div>

            <!-- Description -->
            <?php if (!empty($regime['description'])): ?>
              <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;flex:1"><?= nl2br(htmlspecialchars(mb_substr($regime['description'], 0, 140))) ?><?= mb_strlen($regime['description']) > 140 ? '…' : '' ?></p>
            <?php endif; ?>

            <!-- Stats Row -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem">
              <div style="background:var(--muted);border-radius:var(--radius-xl);padding:0.6rem 0.75rem;text-align:center">
                <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary)"><?= (int)$regime['duree_semaines'] ?></div>
                <div style="font-size:0.65rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Semaines</div>
              </div>
              <div style="background:var(--muted);border-radius:var(--radius-xl);padding:0.6rem 0.75rem;text-align:center">
                <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--accent-orange)"><?= number_format((int)$regime['calories_jour']) ?></div>
                <div style="font-size:0.65rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">kcal/jour</div>
              </div>
            </div>

            <!-- Restrictions -->
            <?php if (!empty($regime['restrictions'])): ?>
              <div style="background:rgba(82,183,136,0.06);border:1px solid rgba(82,183,136,0.15);border-radius:var(--radius-xl);padding:0.625rem 0.875rem;display:flex;align-items:flex-start;gap:0.5rem">
                <i data-lucide="shield-check" style="width:0.875rem;height:0.875rem;color:var(--secondary);flex-shrink:0;margin-top:2px"></i>
                <span style="font-size:0.75rem;color:var(--text-secondary);line-height:1.5"><?= htmlspecialchars($regime['restrictions']) ?></span>
              </div>
            <?php endif; ?>

            <!-- Footer -->
            <div style="display:flex;align-items:center;justify-content:space-between;padding-top:0.75rem;border-top:1px solid var(--border)">
              <div style="display:flex;align-items:center;gap:0.4rem">
                <div style="width:1.5rem;height:1.5rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center">
                  <i data-lucide="user" style="width:0.7rem;height:0.7rem;color:#fff"></i>
                </div>
                <span style="font-size:0.72rem;color:var(--text-muted)"><?= htmlspecialchars($regime['soumis_par']) ?></span>
              </div>
              <span style="font-size:0.65rem;color:var(--text-muted)"><?= date('d/m/Y', strtotime($regime['created_at'])) ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

  <!-- CTA Banner -->
  <div class="card" style="margin-top:2rem;padding:2rem;background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border:1px dashed rgba(82,183,136,0.3);text-align:center">
    <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:var(--primary);margin-bottom:0.4rem">
      Vous avez un régime à partager ? 🥗
    </div>
    <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.25rem">Proposez votre programme alimentaire. Notre équipe l'examinera et le publiera s'il est validé.</p>
    <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-add" class="btn btn-outline" style="border-radius:var(--radius-full);border-color:var(--secondary);color:var(--secondary)">
      <i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Soumettre mon régime
    </a>
  </div>

  <?php if (!empty($myRegimes)): ?>
    <!-- ===== Mes Propositions ===== -->
    <div style="margin-top:2.5rem">
      <div class="flex items-center gap-3 mb-4">
        <div style="display:inline-flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.08));border-radius:0.75rem">
          <i data-lucide="clock" style="width:1.1rem;height:1.1rem;color:#f59e0b"></i>
        </div>
        <div>
          <h2 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary)">Mes Propositions</h2>
          <p style="font-size:0.75rem;color:var(--text-muted)">Historique de vos propositions (en attente ou refusées)</p>
        </div>
      </div>

      <div style="display:flex;flex-direction:column;gap:0.75rem">
        <?php
        $stConfig = [
            'en_attente' => ['label'=>'En attente', 'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.1)', 'icon'=>'clock'],
            'refuse'     => ['label'=>'Refusé',     'color'=>'#ef4444', 'bg'=>'rgba(239,68,68,0.1)',  'icon'=>'x-circle'],
            'accepte'    => ['label'=>'Accepté',    'color'=>'#10b981', 'bg'=>'rgba(16,185,129,0.1)', 'icon'=>'check-circle'],
        ];
        foreach ($myRegimes as $mr):
          $st     = $stConfig[$mr['statut']] ?? $stConfig['en_attente'];
          $obj    = $objectifLabels[$mr['objectif']] ?? $mr['objectif'];
          $ico    = $objectifIcons[$mr['objectif']]  ?? 'target';
          $colors = $objectifColors[$mr['objectif']] ?? ['from'=>'#52B788','to'=>'#2D6A4F','bg'=>'rgba(82,183,136,0.08)'];
        ?>
          <div class="card searchable-regime" style="padding:1.25rem;border:1px solid var(--border);transition:all 0.25s" onmouseover="this.style.transform='translateX(3px)'" onmouseout="this.style.transform='none'">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">

              <!-- Left: icon + info -->
              <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-detail&id=<?= $mr['id'] ?>" style="display:flex;align-items:center;gap:0.875rem;flex:1;min-width:0;text-decoration:none;transition:opacity 0.2s" onmouseover="this.style.opacity='0.75'" onmouseout="this.style.opacity='1'">
                <div style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:<?= $colors['bg'] ?>;border:1px solid <?= $colors['from'] ?>22;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <i data-lucide="<?= $ico ?>" style="width:1.1rem;height:1.1rem;color:<?= $colors['from'] ?>"></i>
                </div>
                <div style="min-width:0">
                  <div style="font-weight:700;font-size:0.9rem;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($mr['nom']) ?></div>
                  <div style="font-size:0.72rem;color:var(--text-muted)"><?= $obj ?> · <?= (int)$mr['duree_semaines'] ?> semaines · <?= number_format((int)$mr['calories_jour']) ?> kcal/j</div>
                </div>
              </a>

              <!-- Middle: status badge -->
              <div style="display:flex;align-items:center;gap:0.75rem;flex-shrink:0">
                <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;font-size:0.72rem;font-weight:700">
                  <i data-lucide="<?= $st['icon'] ?>" style="width:0.75rem;height:0.75rem"></i>
                  <?= $st['label'] ?>
                </span>

                <?php if ($mr['statut'] === 'refuse' && !empty($mr['commentaire_admin'])): ?>
                  <div style="font-size:0.72rem;color:var(--text-muted);font-style:italic;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="<?= htmlspecialchars($mr['commentaire_admin']) ?>">
                    "<?= htmlspecialchars(mb_substr($mr['commentaire_admin'], 0, 55)) ?>"
                  </div>
                <?php endif; ?>

                <!-- Edit button -->
                <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-edit&id=<?= $mr['id'] ?>"
                   style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.35rem 0.9rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s"
                   onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(45,106,79,0.3)'"
                   onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                  <i data-lucide="edit-3" style="width:0.75rem;height:0.75rem"></i> Modifier
                </a>

                <!-- Delete button (hidden if accepted to prevent errors) -->
                <?php if ($mr['statut'] !== 'accepte'): ?>
                <button type="button"
                   onclick="openDeleteConfirm('<?= BASE_URL ?>/?page=nutrition&action=regime-delete&id=<?= $mr['id'] ?>', '<?= addslashes(htmlspecialchars($mr['nom'])) ?>')"
                   style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);cursor:pointer;transition:all 0.2s;flex-shrink:0"
                   onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                   onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                   title="Supprimer ma proposition">
                  <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                </button>
                <?php else: ?>
                <div style="width:2rem;height:2rem;flex-shrink:0"></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

</div>

<!-- ===== Custom Delete Confirm Modal ===== -->
<div id="deleteConfirmModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <!-- Icon -->
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(239,68,68,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="trash-2" style="width:1.625rem;height:1.625rem;color:#ef4444"></i>
    </div>
    <!-- Title -->
    <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary);margin-bottom:0.4rem">
      Supprimer la proposition ?
    </h3>
    <p id="deleteConfirmMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <!-- Buttons -->
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeDeleteConfirm()"
              style="padding:0.6rem 1.5rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.2s"
              onmouseover="this.style.background='var(--border)'"
              onmouseout="this.style.background='var(--muted)'">
        Annuler
      </button>
      <a id="deleteConfirmLink" href="#"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.5rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.2s"
         onmouseover="this.style.boxShadow='0 4px 16px rgba(239,68,68,0.35)'"
         onmouseout="this.style.boxShadow='none'">
        <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i> Oui, supprimer
      </a>
    </div>
  </div>
</div>

<script>
function openDeleteConfirm(url, nom) {
  document.getElementById('deleteConfirmLink').href = url;
  document.getElementById('deleteConfirmMsg').textContent =
    'Vous êtes sur le point de supprimer "' + nom + '". Cette action est irréversible.';
  const modal = document.getElementById('deleteConfirmModal');
  modal.style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeDeleteConfirm() {
  document.getElementById('deleteConfirmModal').style.display = 'none';
}
// Click backdrop to close
document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteConfirm();
});
// ESC key to close
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeDeleteConfirm();
});

// Dynamic Client-side Search
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('globalSearchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const query = this.value.toLowerCase().trim();
      const cards = document.querySelectorAll('.searchable-regime');
      
      cards.forEach(card => {
        // Retrieve text from within the card to perform lookup
        const title = card.querySelector('h3, div[style*="font-weight:700"]')?.textContent.toLowerCase() || '';
        const badge = card.querySelector('span[style*="text-transform:uppercase"]')?.textContent.toLowerCase() || '';
        const restrictions = card.querySelector('div[style*="align-items:flex-start"] span')?.textContent.toLowerCase() || '';
        const fullText = (title + ' ' + badge + ' ' + restrictions).toLowerCase();

        if (fullText.includes(query)) {
          card.style.display = card.tagName.toLowerCase() === 'div' ? 'flex' : 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
    
    // Trigger once on load in case there is already text (like from PHP redirect)
    if(searchInput.value) {
       searchInput.dispatchEvent(new Event('input'));
    }
  }
});
</script>
