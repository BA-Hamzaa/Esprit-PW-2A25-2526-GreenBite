<!-- Vue FrontOffice : Plans Nutritionnels -->
<div class="plans-page-wrap" style="padding:2rem;position:relative;background:#f5f6f8">

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
    <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-add" class="btn btn-primary" style="border-radius:8px;background:#2E7D4F;border-color:#2E7D4F">
      <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> ⊕ Créer un plan
    </a>
  </div>


<style>
@keyframes planCardIn {
  from { opacity:0; transform:translateY(22px) scale(0.97); }
  to   { opacity:1; transform:none; }
}
.plan-card {
  position:relative; background:#fff; border-radius:8px;
  overflow:hidden; border:1.5px solid var(--border);
  transition:transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  display:flex; flex-direction:column; animation:planCardIn 0.45s ease both;
}
.plan-card:hover { transform:translateY(-3px); box-shadow:0 10px 24px rgba(15,23,42,0.08); border-color:#d5d9e2; }
.plan-accent-bar { height:5px; position:relative; overflow:hidden; }
.plan-accent-bar::after {
  content:''; position:absolute; inset:0;
  background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.45) 50%,rgba(255,255,255,0) 100%);
  opacity:0; transform:translateX(-100%); animation:planShimmer 1.6s ease infinite; transition:opacity 0.3s;
}
.plan-card:hover .plan-accent-bar::after { opacity:1; }
@keyframes planShimmer { to { transform:translateX(200%); } }
.plan-stat-box { background:#f4efe6; border-radius:8px; padding:0.65rem 0.8rem; text-align:center; border:1px solid #eee6d8; }
.plan-cta-strip {
  border-top:1px solid #eceff3; padding:0.75rem 1.25rem;
  display:flex; align-items:center; justify-content:space-between;
  background:#fcfcfd; transition:background 0.2s;
}
.plan-card:hover .plan-cta-strip { background:#f7f9fc; }
.plan-arrow {
  width:2.1rem; height:2.1rem; border-radius:var(--radius-full);
  display:inline-flex; align-items:center; justify-content:center;
  color:#fff; border:none; cursor:pointer; transition:all 0.25s; flex-shrink:0;
  box-shadow:0 3px 10px rgba(0,0,0,0.12);
}
.plan-card:hover .plan-arrow { transform:translateX(3px); box-shadow:0 6px 16px rgba(0,0,0,0.2); }
.plan-filters{display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin:0 0 1rem 0}
.plan-filter-btn{border:1px solid #d6dbe3;background:#fff;color:#4b5563;border-radius:8px;padding:0.35rem 0.75rem;font-size:0.72rem;font-weight:700;cursor:pointer;transition:all .2s}
.plan-filter-btn:hover{border-color:#9ca3af}
.plan-filter-btn.active{background:#2E7D4F;color:#fff;border-color:#2E7D4F}
.plans-hero{
  border-radius:8px;
  overflow:hidden;
  border:1px solid rgba(46,125,79,0.25);
  background:
    linear-gradient(105deg,rgba(7,22,14,0.76),rgba(20,54,37,0.55)),
    url('https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
  padding:1.1rem 1.25rem;
  margin-bottom:1rem;
}
.plans-hero-chip{
  display:inline-flex;align-items:center;gap:0.35rem;
  border-radius:999px;padding:0.2rem 0.55rem;
  background:rgba(255,255,255,0.14);color:#ecfdf5;font-size:0.68rem;font-weight:700;
}
[data-theme='dark'] .plans-page-wrap{background:#0F1117 !important;}
[data-theme='dark'] .plan-card{background:#1A1F2E;border-color:rgba(255,255,255,0.08);}
[data-theme='dark'] .plan-card:hover{border-color:rgba(61,220,132,0.35);box-shadow:none;}
[data-theme='dark'] .plan-stat-box{background:#252B3B;border-color:rgba(255,255,255,0.08);}
[data-theme='dark'] .plan-cta-strip{background:#1A1F2E;border-top-color:rgba(255,255,255,0.08);}
[data-theme='dark'] .plan-card:hover .plan-cta-strip{background:#1E2537;}
[data-theme='dark'] .plan-filter-btn{background:transparent;color:#8B92A9;border-color:rgba(255,255,255,0.12);}
[data-theme='dark'] .plan-filter-btn:hover{border-color:#3DDC84;color:#F0F4FF;}
[data-theme='dark'] .plan-filter-btn.active{background:#3DDC84;color:#0f1f17;border-color:#3DDC84;}
</style>

  <div class="plans-hero">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap">
      <div>
        <h3 style="margin:0;color:#f8fffb;font-family:var(--font-heading);font-size:1.05rem;font-weight:800">
          Inspiration du jour: Manger mieux, vivre mieux
        </h3>
        <p style="margin:0.2rem 0 0;color:rgba(236,253,245,0.88);font-size:0.78rem">
          Découvrez des plans équilibrés inspirés d'aliments frais pour booster votre énergie.
        </p>
      </div>
      <span class="plans-hero-chip"><i data-lucide="sparkles" style="width:0.75rem;height:0.75rem"></i> Healthy Choice</span>
    </div>
  </div>

  <?php if (!empty($regimeFilterActive)): ?>
    <div style="margin-bottom:1rem;padding:0.8rem 1rem;border-radius:10px;border:1px solid rgba(46,125,79,0.25);background:linear-gradient(135deg,rgba(46,125,79,0.12),rgba(46,125,79,0.05));display:flex;align-items:center;justify-content:space-between;gap:0.8rem;flex-wrap:wrap">
      <div style="display:flex;align-items:center;gap:0.45rem;color:#1f5135;font-size:0.82rem;font-weight:700">
        <i data-lucide="filter" style="width:0.85rem;height:0.85rem"></i>
        <?php if (!empty($selectedRegime['nom'])): ?>
          Plans associés au régime : <span style="font-weight:800"><?= htmlspecialchars($selectedRegime['nom']) ?></span>
        <?php else: ?>
          Plans associés au régime sélectionné
        <?php endif; ?>
      </div>
      <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes"
         style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.75rem;font-weight:700;color:#2E7D4F;text-decoration:none;border:1px solid rgba(46,125,79,0.3);padding:0.3rem 0.65rem;border-radius:999px;background:#fff">
        <i data-lucide="arrow-left" style="width:0.75rem;height:0.75rem"></i> Retour aux régimes
      </a>
    </div>
  <?php endif; ?>

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
    <div class="plan-filters">
      <button class="plan-filter-btn active" data-type="all">Tous</button>
      <button class="plan-filter-btn" data-type="perte_poids">Perte de Poids</button>
      <button class="plan-filter-btn" data-type="prise_masse">Prise de Masse</button>
      <button class="plan-filter-btn" data-type="maintien">Maintien</button>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(310px,1fr));gap:2rem;margin-top:0.5rem">
      <?php foreach ($plans as $idx => $p): ?>
        <?php
          $config = [
            'maintien'    => ['from'=>'#2E7D4F','to'=>'#2E7D4F','bg'=>'rgba(46,125,79,0.10)','icon'=>'scale',        'label'=>'Maintien'],
            'perte_poids' => ['from'=>'#E53E3E','to'=>'#E53E3E','bg'=>'rgba(229,62,62,0.10)',  'icon'=>'trending-down','label'=>'Perte de poids'],
            'prise_masse' => ['from'=>'#3182CE','to'=>'#3182CE','bg'=>'rgba(49,130,206,0.10)', 'icon'=>'trending-up',  'label'=>'Prise de masse'],
          ];
          $c = $config[$p['type_objectif']] ?? $config['maintien'];
          $followedPlans = $_SESSION['followed_plans'] ?? [];
          $isFollowing   = isset($followedPlans[$p['id']]);
          $followDate    = $isFollowing ? $followedPlans[$p['id']]['date_debut'] : null;
          $calPct = min(100, max(8, round(((int)$p['objectif_calories'] - 500) / 35)));
        ?>
        <div class="plan-card searchable-plan" data-type="<?= htmlspecialchars($p['type_objectif']) ?>" style="animation-delay:<?= $idx * 0.07 ?>s;border-color:<?= $isFollowing ? 'var(--secondary)' : '#e2e8f0' ?>">

          <!-- Accent bar -->
          <div class="plan-accent-bar" style="background:linear-gradient(90deg,<?= $c['from'] ?>,<?= $c['to'] ?>)"></div>

          <!-- Body -->
          <div style="padding:1rem;flex:1;display:flex;flex-direction:column;gap:0.85rem">

            <!-- Header: icon + title + badge -->
            <div style="display:flex;align-items:flex-start;gap:1rem">
              <div style="width:3rem;height:3rem;border-radius:1rem;background:linear-gradient(135deg,<?= $c['from'] ?>22,<?= $c['from'] ?>11);border:1.5px solid <?= $c['from'] ?>33;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px <?= $c['from'] ?>22">
                <i data-lucide="<?= $c['icon'] ?>" style="width:1.375rem;height:1.375rem;color:<?= $c['from'] ?>"></i>
              </div>
              <div style="flex:1;min-width:0">
                <h3 style="font-family:var(--font-heading);font-weight:600;color:var(--text-primary);font-size:1.02rem;line-height:1.3;margin-bottom:0.35rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($p['nom']) ?></h3>
                <?php if (!empty($p['regime_nom'])): ?>
                  <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:0.25rem">Régime: <?= htmlspecialchars($p['regime_nom']) ?></div>
                <?php endif; ?>
                <div style="display:flex;align-items:center;gap:0.4rem;flex-wrap:wrap">
                  <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.67rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:<?= $c['from'] ?>;background:<?= $c['bg'] ?>;padding:0.2rem 0.6rem;border-radius:8px;border:1px solid <?= $c['from'] ?>33">
                    <i data-lucide="<?= $c['icon'] ?>" style="width:0.6rem;height:0.6rem"></i><?= $c['label'] ?>
                  </span>
                  <?php if ($isFollowing): ?>
                    <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.67rem;font-weight:700;color:#16a34a;background:rgba(22,163,74,0.08);padding:0.2rem 0.6rem;border-radius:999px;border:1px solid #bbf7d0">
                      <i data-lucide="check-circle" style="width:0.6rem;height:0.6rem"></i> Suivi actif
                    </span>
                  <?php endif; ?>
                  <?php if (isset($p['statut']) && $p['statut'] === 'en_attente'): ?>
                    <span style="font-size:0.65rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:999px;background:#fef3c7;color:#b45309;border:1px solid #fde68a">⏳ En attente</span>
                  <?php elseif (isset($p['statut']) && $p['statut'] === 'refuse'): ?>
                    <span style="font-size:0.65rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:999px;background:#fee2e2;color:#b91c1c;border:1px solid #fecaca">✕ Refusé</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Description -->
            <p style="font-size:0.82rem;font-weight:400;color:var(--text-secondary);line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden"><?= htmlspecialchars(substr($p['description'] ?? 'Aucune description disponible.', 0, 120)) ?>…</p>

            <!-- Stats -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
              <div class="plan-stat-box">
                <div style="font-size:0.62rem;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:0.06em;display:flex;align-items:center;justify-content:center;gap:0.3rem;margin-bottom:0.25rem">
                  <i data-lucide="calendar" style="width:0.65rem;height:0.65rem"></i> Durée
                </div>
                <div style="font-family:var(--font-heading);font-size:1.3rem;font-weight:500;color:<?= $c['from'] ?>;line-height:1"><?= $p['duree_jours'] ?></div>
                <div style="font-size:0.62rem;color:var(--text-muted);font-weight:600;margin-top:0.15rem">jours</div>
              </div>
              <div class="plan-stat-box">
                <div style="font-size:0.62rem;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:0.06em;display:flex;align-items:center;justify-content:center;gap:0.3rem;margin-bottom:0.25rem">
                  <i data-lucide="flame" style="width:0.65rem;height:0.65rem"></i> Objectif
                </div>
                <div style="font-family:var(--font-heading);font-size:1.3rem;font-weight:500;color:#d69e2e;line-height:1"><?= number_format((int)$p['objectif_calories']) ?></div>
                <div style="font-size:0.62rem;color:var(--text-muted);font-weight:600;margin-top:0.15rem">kcal/j</div>
              </div>
            </div>

            <!-- Calorie progress bar -->
            <div style="background:#e8edf2;border-radius:8px;height:4px;overflow:hidden">
              <div style="height:100%;width:<?= $calPct ?>%;background:linear-gradient(90deg,<?= $c['from'] ?>,<?= $c['to'] ?>);border-radius:999px"></div>
            </div>

            <!-- Follow progress -->
            <?php if ($isFollowing):
              $today = date('Y-m-d');
              $daysPassed = max(0, (strtotime($today) - strtotime($followDate)) / 86400);
              $progress = min(100, round(($daysPassed / max(1, $p['duree_jours'])) * 100));
            ?>
              <div style="padding:0.65rem 0.875rem;background:<?= $c['bg'] ?>;border:1px solid <?= $c['from'] ?>22;border-radius:0.875rem">
                <div style="display:flex;justify-content:space-between;font-size:0.68rem;font-weight:600;margin-bottom:0.35rem">
                  <span style="color:var(--text-secondary)">📅 Depuis le <?= date('d/m/Y', strtotime($followDate)) ?></span>
                  <span style="color:<?= $c['from'] ?>;font-weight:800"><?= $progress ?>%</span>
                </div>
                <div style="height:5px;background:var(--border);border-radius:3px;overflow:hidden">
                  <div style="height:100%;width:<?= $progress ?>%;background:linear-gradient(90deg,<?= $c['from'] ?>,<?= $c['to'] ?>);border-radius:3px;transition:width 0.6s ease"></div>
                </div>
              </div>
            <?php endif; ?>

          </div>

          <!-- CTA Footer -->
          <div class="plan-cta-strip">
            <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.78rem;color:var(--text-secondary)">
              <i data-lucide="utensils" style="width:0.875rem;height:0.875rem;color:<?= $c['from'] ?>"></i>
              <span><strong style="color:var(--text-primary)"><?= $p['nb_repas'] ?></strong> repas associés</span>
            </div>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-detail&id=<?= $p['id'] ?>"
               class="plan-arrow"
               style="background:linear-gradient(135deg,<?= $c['from'] ?>,<?= $c['to'] ?>)">
              <i data-lucide="chevron-right" style="width:0.9rem;height:0.9rem"></i>
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
                <?php if (!empty($p['regime_nom'])): ?>
                  <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.2rem">Régime: <?= htmlspecialchars($p['regime_nom']) ?></div>
                <?php endif; ?>
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
  const filterButtons = document.querySelectorAll('.plan-filter-btn');
  const planCards = document.querySelectorAll('.searchable-plan');
  let activeType = 'all';

  function applyPlanFilters() {
    const term = searchInput ? searchInput.value.toLowerCase().trim() : '';
    planCards.forEach(card => {
      const titleEl = card.querySelector('h3');
      const title = titleEl ? titleEl.innerText.toLowerCase() : '';
      const matchesSearch = title.includes(term);
      const matchesType = activeType === 'all' || card.dataset.type === activeType;
      card.style.display = (matchesSearch && matchesType) ? 'flex' : 'none';
    });
  }

  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      filterButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeType = btn.dataset.type || 'all';
      applyPlanFilters();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      applyPlanFilters();
    });
    applyPlanFilters();
  } else {
    applyPlanFilters();
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
