<!-- Vue FrontOffice : Plans Nutritionnels -->
<div style="padding:2rem;position:relative">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.18);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="clipboard-list" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Plans Nutritionnels
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="target" style="width:0.75rem;height:0.75rem"></i>
          Gérez vos programmes alimentaires personnalisés
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-add" class="btn btn-primary" style="border-radius:var(--radius-full)">
      <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Créer un plan
    </a>
  </div>

  <?php if (empty($plans)): ?>
    <!-- Empty State -->
    <div class="card" style="padding:5rem 2rem;text-align:center;background:linear-gradient(135deg,rgba(82,183,136,0.04),rgba(45,106,79,0.02))">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5.5rem;height:5.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.5rem;box-shadow:0 8px 24px rgba(45,106,79,0.12);animation:float 3s ease-in-out infinite">
        <i data-lucide="clipboard" style="width:2.75rem;height:2.75rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.375rem;font-weight:800;color:var(--primary);margin-bottom:0.625rem">Aucun plan nutritionnel</h3>
      <p style="color:var(--text-secondary);margin-bottom:2rem;max-width:24rem;margin-left:auto;margin-right:auto;line-height:1.65">Créez votre premier programme alimentaire pour mieux suivre et atteindre vos objectifs santé ! 🎯</p>
      <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-add" class="btn btn-primary" style="border-radius:var(--radius-full)">
        <i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Créer mon premier plan
      </a>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-6">
      <?php foreach ($plans as $p): ?>
        <?php
          // Objective styling
          $config = [
            'maintien'     => ['grad'=>'linear-gradient(135deg,var(--secondary),#40916C)',    'light'=>'rgba(82,183,136,0.08)', 'txt'=>'#16a34a', 'icon'=>'scale',        'label'=>'Maintien',      'bar'=>'var(--secondary)'],
            'perte_poids'  => ['grad'=>'linear-gradient(135deg,#ef4444,#dc2626)',             'light'=>'rgba(239,68,68,0.07)',  'txt'=>'#dc2626', 'icon'=>'trending-down', 'label'=>'Perte de poids','bar'=>'#ef4444'],
            'prise_masse'  => ['grad'=>'linear-gradient(135deg,#3b82f6,#2563eb)',             'light'=>'rgba(59,130,246,0.07)', 'txt'=>'#2563eb', 'icon'=>'trending-up',   'label'=>'Prise de masse','bar'=>'#3b82f6'],
          ];
          $c = $config[$p['type_objectif']] ?? $config['maintien'];
          // Check if following this plan
          $followedPlans = $_SESSION['followed_plans'] ?? [];
          $isFollowing = isset($followedPlans[$p['id']]);
          $followDate = $isFollowing ? $followedPlans[$p['id']]['date_debut'] : null;
        ?>
        <div class="card card-interactive" style="position:relative;overflow:hidden;display:flex;flex-direction:column;padding:0;border:<?= $isFollowing ? '2px solid var(--secondary)' : '1px solid var(--border)' ?>">

          <!-- Colored top strip -->
          <div style="height:4px;background:<?= $c['grad'] ?>"></div>

          <!-- Header section -->
          <div style="padding:1.25rem 1.5rem 0.875rem;background:<?= $c['light'] ?>;border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.5rem">
              <div style="flex:1;min-width:0">
                <h3 style="font-family:var(--font-heading);font-weight:800;color:var(--text-primary);font-size:1.05rem;line-height:1.25;overflow:hidden;white-space:nowrap;text-overflow:ellipsis"><?= htmlspecialchars($p['nom']) ?></h3>
                <div style="display:flex;align-items:center;gap:0.35rem;margin-top:0.35rem;flex-wrap:wrap">
                  <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.2rem 0.6rem;background:<?= $c['grad'] ?>;color:#fff;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700">
                    <i data-lucide="<?= $c['icon'] ?>" style="width:0.6rem;height:0.6rem"></i>
                    <?= $c['label'] ?>
                  </span>
                  <?php if ($isFollowing): ?>
                    <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.2rem 0.6rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#16a34a;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700;border:1px solid #bbf7d0">
                      <i data-lucide="check-circle" style="width:0.6rem;height:0.6rem"></i> Suivi actif
                    </span>
                  <?php endif; ?>
                </div>
              </div>
              <div style="display:flex;gap:0.25rem;flex-shrink:0">
                <?php if (isset($p['statut']) && $p['statut'] === 'en_attente'): ?>
                  <span style="font-size:0.65rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:1rem;background:#fef3c7;color:#b45309;border:1px solid #fde68a">
                    <i data-lucide="clock" style="width:0.6rem;height:0.6rem;display:inline-block;margin-right:2px"></i> En attente
                  </span>
                <?php elseif (isset($p['statut']) && $p['statut'] === 'refuse'): ?>
                  <span style="font-size:0.65rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:1rem;background:#fee2e2;color:#b91c1c;border:1px solid #fecaca">
                    <i data-lucide="x-circle" style="width:0.6rem;height:0.6rem;display:inline-block;margin-right:2px"></i> Refusé
                  </span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Body section -->
          <div style="padding:1.25rem 1.5rem;flex:1">
            <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1.25rem;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical"><?= htmlspecialchars(substr($p['description'] ?? 'Aucune description disponible.', 0, 100)) ?>...</p>

            <!-- Stats grid -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
              <div style="padding:0.75rem;background:var(--muted);border-radius:0.875rem;border:1px solid var(--border)">
                <div style="font-size:0.68rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.2rem;display:flex;align-items:center;gap:0.3rem">
                  <i data-lucide="calendar" style="width:0.65rem;height:0.65rem"></i> Durée
                </div>
                <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary)"><?= $p['duree_jours'] ?> <span style="font-size:0.72rem;font-weight:500;color:var(--text-muted)">jours</span></div>
              </div>
              <div style="padding:0.75rem;background:var(--muted);border-radius:0.875rem;border:1px solid var(--border)">
                <div style="font-size:0.68rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.2rem;display:flex;align-items:center;gap:0.3rem">
                  <i data-lucide="flame" style="width:0.65rem;height:0.65rem"></i> Objectif
                </div>
                <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--accent-orange)"><?= $p['objectif_calories'] ?> <span style="font-size:0.72rem;font-weight:500;color:var(--text-muted)">kcal/j</span></div>
              </div>
            </div>

            <?php if ($isFollowing):
              $today = date('Y-m-d');
              $daysPassed = max(0, (strtotime($today) - strtotime($followDate)) / 86400);
              $progress = min(100, round(($daysPassed / max(1, $p['duree_jours'])) * 100));
            ?>
              <!-- Progress bar for followed plans -->
              <div style="margin-top:0.875rem;padding:0.6rem 0.75rem;background:linear-gradient(135deg,rgba(82,183,136,0.06),rgba(45,106,79,0.04));border:1px solid rgba(82,183,136,0.15);border-radius:0.75rem">
                <div style="display:flex;justify-content:space-between;font-size:0.68rem;font-weight:600;margin-bottom:0.3rem">
                  <span style="color:var(--text-secondary)"><i data-lucide="calendar" style="width:0.6rem;height:0.6rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i>Depuis le <?= date('d/m/Y', strtotime($followDate)) ?></span>
                  <span style="color:var(--secondary);font-weight:700"><?= $progress ?>%</span>
                </div>
                <div style="height:5px;background:var(--border);border-radius:3px;overflow:hidden">
                  <div style="height:100%;width:<?= $progress ?>%;background:linear-gradient(90deg,var(--secondary),#40916C);border-radius:3px;transition:width 0.5s ease"></div>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Footer -->
          <div style="padding:1rem 1.5rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--surface-hover)">
            <div style="display:flex;align-items:center;gap:0.5rem;color:var(--text-secondary);font-size:0.8rem">
              <i data-lucide="utensils" style="width:0.875rem;height:0.875rem;color:var(--primary)"></i>
              <span><strong style="color:var(--text-primary)"><?= $p['nb_repas'] ?></strong> repas associés</span>
            </div>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-detail&id=<?= $p['id'] ?>"
               class="btn btn-sm"
               style="background:<?= $c['grad'] ?>;color:#fff;border:none;border-radius:var(--radius-full);padding:0.35rem 0.9rem;font-size:0.75rem;font-weight:700;box-shadow:0 3px 10px rgba(0,0,0,0.12)">
              Voir le détail <i data-lucide="chevron-right" style="width:0.8rem;height:0.8rem"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($myPlans)): ?>
    <!-- ===== Mes Propositions ===== -->
    <div style="margin-top:2.5rem">
      <div class="flex items-center gap-3 mb-4">
        <div style="display:inline-flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.08));border-radius:0.75rem">
          <i data-lucide="clock" style="width:1.1rem;height:1.1rem;color:#f59e0b"></i>
        </div>
        <div>
          <h2 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary)">Mes Propositions</h2>
          <p style="font-size:0.75rem;color:var(--text-muted)">Historique de vos plans (en attente ou refusés)</p>
        </div>
      </div>

      <div class="grid grid-cols-3 gap-6">
      <?php foreach ($myPlans as $p): ?>
        <?php
          $config = [
            'maintien'     => ['grad'=>'linear-gradient(135deg,var(--secondary),#40916C)',    'light'=>'rgba(82,183,136,0.08)', 'txt'=>'#16a34a', 'icon'=>'scale',        'label'=>'Maintien'],
            'perte_poids'  => ['grad'=>'linear-gradient(135deg,#ef4444,#dc2626)',             'light'=>'rgba(239,68,68,0.07)',  'txt'=>'#dc2626', 'icon'=>'trending-down', 'label'=>'Perte de poids'],
            'prise_masse'  => ['grad'=>'linear-gradient(135deg,#3b82f6,#2563eb)',             'light'=>'rgba(59,130,246,0.07)', 'txt'=>'#2563eb', 'icon'=>'trending-up',   'label'=>'Prise de masse'],
          ];
          $c = $config[$p['type_objectif']] ?? $config['maintien'];
        ?>
        <div class="card card-interactive" style="position:relative;overflow:hidden;display:flex;flex-direction:column;padding:0;border:1px solid var(--border)">
          <div style="height:4px;background:<?= $c['grad'] ?>"></div>
          <div style="padding:1.25rem 1.5rem 0.875rem;background:<?= $c['light'] ?>;border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.5rem">
              <div style="flex:1;min-width:0">
                <h3 style="font-family:var(--font-heading);font-weight:800;color:var(--text-primary);font-size:1.05rem;line-height:1.25;overflow:hidden;white-space:nowrap;text-overflow:ellipsis"><?= htmlspecialchars($p['nom']) ?></h3>
                <span style="display:inline-flex;align-items:center;gap:0.3rem;margin-top:0.35rem;padding:0.2rem 0.6rem;background:<?= $c['grad'] ?>;color:#fff;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700">
                  <i data-lucide="<?= $c['icon'] ?>" style="width:0.6rem;height:0.6rem"></i>
                  <?= $c['label'] ?>
                </span>
              </div>
              <div style="display:flex;gap:0.25rem;flex-shrink:0">
                <?php if ($p['statut'] === 'en_attente'): ?>
                  <span style="font-size:0.65rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:1rem;background:#fef3c7;color:#b45309;border:1px solid #fde68a">
                    <i data-lucide="clock" style="width:0.6rem;height:0.6rem;display:inline-block;margin-right:2px"></i> En attente
                  </span>
                <?php elseif ($p['statut'] === 'refuse'): ?>
                  <span style="font-size:0.65rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:1rem;background:#fee2e2;color:#b91c1c;border:1px solid #fecaca" title="<?= htmlspecialchars($p['commentaire_admin'] ?? '') ?>">
                    <i data-lucide="x-circle" style="width:0.6rem;height:0.6rem;display:inline-block;margin-right:2px"></i> Refusé
                  </span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div style="padding:1rem 1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;flex:1">
             <div style="padding:0.75rem;background:var(--muted);border-radius:0.875rem;border:1px solid var(--border)">
               <div style="font-size:0.68rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.2rem;display:flex;align-items:center;gap:0.3rem">
                 <i data-lucide="calendar" style="width:0.65rem;height:0.65rem"></i> Durée
               </div>
               <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary)"><?= $p['duree_jours'] ?> <span style="font-size:0.72rem;font-weight:500;color:var(--text-muted)">jours</span></div>
             </div>
             <div style="padding:0.75rem;background:var(--muted);border-radius:0.875rem;border:1px solid var(--border)">
               <div style="font-size:0.68rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.2rem;display:flex;align-items:center;gap:0.3rem">
                 <i data-lucide="flame" style="width:0.65rem;height:0.65rem"></i> Objectif
               </div>
               <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--accent-orange)"><?= $p['objectif_calories'] ?> <span style="font-size:0.72rem;font-weight:500;color:var(--text-muted)">kcal/j</span></div>
             </div>
          </div>
          <div style="padding:1rem 1.5rem;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--surface-hover);gap:0.5rem">
            <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-detail&id=<?= $p['id'] ?>" class="btn btn-sm" style="flex:1;background:<?= $c['grad'] ?>;color:#fff;border:none;border-radius:var(--radius-full);padding:0.35rem 0.9rem;font-size:0.75rem;font-weight:700;box-shadow:0 3px 10px rgba(0,0,0,0.12);text-align:center;">
              Voir le détail <i data-lucide="chevron-right" style="width:0.8rem;height:0.8rem"></i>
            </a>
            <?php if ($p['statut'] === 'en_attente'): ?>
              <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-edit&id=<?= $p['id'] ?>" class="btn btn-outline-primary btn-sm" style="border-radius:var(--radius-full);padding:0.35rem;width:2.2rem;height:2.2rem;display:flex;align-items:center;justify-content:center" title="Modifier"><i data-lucide="edit-3" style="width:1rem;height:1rem"></i></a>
              <button type="button" onclick="openDeleteConfirmFront('<?= BASE_URL ?>/?page=nutrition&action=plan-delete&id=<?= $p['id'] ?>', '<?= addslashes(htmlspecialchars($p['nom'])) ?>')" class="btn btn-sm" style="border:1px solid #fecaca;color:#dc2626;background:#fef2f2;border-radius:var(--radius-full);padding:0.35rem;width:2.2rem;height:2.2rem;display:flex;align-items:center;justify-content:center" title="Supprimer"><i data-lucide="trash-2" style="width:1rem;height:1rem"></i></button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- Scripts pour la Recherche Dynamique -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('globalSearchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      const term = e.target.value.toLowerCase().trim();
      const planCards = document.querySelectorAll('.card');
      
      planCards.forEach(card => {
        // Find the title h3
        const titleEl = card.querySelector('h3');
        if (titleEl) {
          const title = titleEl.innerText.toLowerCase();
          if (title.includes(term)) {
            card.style.display = 'flex'; // our cards are display:flex
          } else {
            card.style.display = 'none';
          }
        }
      });
    });
  }
});

// Delete Confirm Modal
function openDeleteConfirmFront(url, nom) {
  const modal = document.getElementById('deleteConfirmFrontModal');
  if (!modal) return;
  document.getElementById('deleteConfirmFrontLink').href = url;
  document.getElementById('deleteConfirmFrontMsg').textContent = 'Souhaitez-vous vraiment supprimer la proposition "' + nom + '" ?';
  modal.style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closeDeleteConfirmFront() {
  const modal = document.getElementById('deleteConfirmFrontModal');
  if (modal) modal.style.display = 'none';
}
</script>

<!-- ===== DELETE CONFIRM MODAL (FRONT) ===== -->
<div id="deleteConfirmFrontModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:380px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(239,68,68,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="trash-2" style="width:1.625rem;height:1.625rem;color:#ef4444"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem">Supprimer cette proposition ?</h3>
    <p id="deleteConfirmFrontMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeDeleteConfirmFront()" class="btn btn-outline">Annuler</button>
      <a id="deleteConfirmFrontLink" href="#" class="btn" style="background:#ef4444;color:#fff;border:none;">
        <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i> Oui, supprimer
      </a>
    </div>
  </div>
</div>
