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
          Mes Plans Nutritionnels
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
        ?>
        <div class="card card-interactive" style="position:relative;overflow:hidden;display:flex;flex-direction:column;padding:0;border:1px solid var(--border)">

          <!-- Colored top strip -->
          <div style="height:4px;background:<?= $c['grad'] ?>"></div>

          <!-- Header section -->
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
                <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-edit&id=<?= $p['id'] ?>" title="Modifier" style="display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(255,255,255,0.7);border-radius:0.5rem;color:var(--text-secondary);transition:all 0.2s;border:1px solid var(--border)" onmouseover="this.style.color='var(--primary)';this.style.background='#fff'" onmouseout="this.style.color='var(--text-secondary)';this.style.background='rgba(255,255,255,0.7)'">
                  <i data-lucide="edit-3" style="width:0.85rem;height:0.85rem"></i>
                </a>
                <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-delete&id=<?= $p['id'] ?>" title="Supprimer" style="display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(255,255,255,0.7);border-radius:0.5rem;color:var(--destructive);transition:all 0.2s;border:1px solid var(--border)" onclick="return confirm('Confirmer la suppression de ce plan ?')" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='rgba(255,255,255,0.7)'">
                  <i data-lucide="trash-2" style="width:0.85rem;height:0.85rem"></i>
                </a>
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
</div>
