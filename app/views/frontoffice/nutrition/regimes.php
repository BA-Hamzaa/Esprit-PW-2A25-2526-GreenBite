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
    <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-add" class="btn btn-primary" style="border-radius:var(--radius-full)">
      <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> Créer un régime
    </a>
  </div>


  <!-- ============================================================
       AI REGIME GENERATOR
       ============================================================ -->
  <div id="ai-generator-section" class="card mb-6" style="padding:0;overflow:hidden;border:1.5px solid rgba(82,183,136,0.2);box-shadow:0 8px 32px rgba(45,106,79,0.08)">
    <!-- Header -->
    <div style="background:linear-gradient(135deg,#2D6A4F,#52B788);padding:1.25rem 1.75rem;display:flex;align-items:center;gap:1rem">
      <div style="display:flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:rgba(255,255,255,0.15);border-radius:0.875rem;flex-shrink:0">
        <svg style="width:1.4rem;height:1.4rem;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
      </div>
      <div style="flex:1">
        <h2 style="color:#fff;font-family:var(--font-heading);font-weight:800;font-size:1.05rem;margin:0">✨ Générateur de Régimes IA</h2>
        <p style="color:rgba(255,255,255,0.8);font-size:0.78rem;margin:0.2rem 0 0">Choisissez votre objectif — l'IA génère 3 régimes personnalisés instantanément</p>
      </div>
      <span style="padding:0.3rem 0.75rem;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:999px;color:#fff;font-size:0.7rem;font-weight:700">POWERED BY AI</span>
    </div>

    <!-- Controls -->
    <div style="padding:1.25rem 1.75rem;background:linear-gradient(135deg,rgba(45,106,79,0.03),rgba(82,183,136,0.02));border-bottom:1px solid rgba(82,183,136,0.1)">
      <div style="display:flex;gap:0.875rem;align-items:flex-end;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
          <label style="display:block;font-size:0.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
            <svg style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.3rem;fill:none;stroke:currentColor;stroke-width:2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Objectif du régime
          </label>
          <select id="ai-goal-select" style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--text-primary);outline:none;cursor:pointer;transition:border-color 0.2s" onfocus="this.style.borderColor='#52B788'" onblur="this.style.borderColor='var(--border)'">
            <option value="perte_poids">🔥 Perte de poids</option>
            <option value="maintien">⚖️ Maintien du poids</option>
            <option value="prise_masse">💪 Prise de masse musculaire</option>
            <option value="sante_generale" selected>❤️ Santé générale & bien-être</option>
            <option value="vegetarien">🥗 Régime végétarien</option>
            <option value="vegan">🌱 Régime vegan</option>
            <option value="low_carb">🥩 Low carb / Keto</option>
            <option value="detox">🍃 Détox & légèreté</option>
          </select>
        </div>
        <div style="flex:2;min-width:240px">
          <label style="display:block;font-size:0.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
            <svg style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.3rem;fill:none;stroke:currentColor;stroke-width:2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Précisions (allergies, préférences…) <span style="font-weight:400;color:var(--text-muted)">optionnel</span>
          </label>
          <input type="text" id="ai-details-input" placeholder="Ex: sans gluten, végétarien, intolérant lactose…" style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--text-primary);outline:none;transition:border-color 0.2s" onfocus="this.style.borderColor='#52B788'" onblur="this.style.borderColor='var(--border)'" onkeydown="if(event.key==='Enter') generateAIRegimes()">
        </div>
        <button onclick="generateAIRegimes()" id="ai-gen-btn" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.5rem;background:linear-gradient(135deg,#2D6A4F,#52B788);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.875rem;font-weight:700;cursor:pointer;white-space:nowrap;transition:all 0.3s;box-shadow:0 4px 14px rgba(45,106,79,0.3)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(45,106,79,0.4)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 14px rgba(45,106,79,0.3)'">
          <svg style="width:1rem;height:1rem;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
          Générer
        </button>
      </div>
    </div>

    <!-- Results -->
    <div id="ai-results" style="padding:1.25rem 1.75rem;display:none">
      <div id="ai-loading" style="display:none;text-align:center;padding:2.5rem">
        <div style="display:inline-flex;gap:0.4rem;align-items:center;justify-content:center;margin-bottom:0.75rem">
          <span style="width:0.5rem;height:0.5rem;background:var(--secondary);border-radius:50%;animation:aiDot 1.2s infinite"></span>
          <span style="width:0.5rem;height:0.5rem;background:var(--secondary);border-radius:50%;animation:aiDot 1.2s infinite 0.2s"></span>
          <span style="width:0.5rem;height:0.5rem;background:var(--secondary);border-radius:50%;animation:aiDot 1.2s infinite 0.4s"></span>
        </div>
        <p style="color:var(--text-muted);font-size:0.85rem">L'IA génère vos régimes personnalisés…</p>
      </div>
      <div id="ai-cards" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1rem"></div>
    </div>
  </div>

  <style>
  @keyframes aiDot{0%,100%{transform:translateY(0);opacity:1}50%{transform:translateY(-8px);opacity:0.5}}
  .ai-regime-card{background:var(--card);border:1.5px solid var(--border);border-radius:1.25rem;overflow:hidden;transition:all 0.3s;animation:aiCardIn 0.4s ease both}
  .ai-regime-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,0.1)}
  @keyframes aiCardIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
  .ai-card-day{background:var(--muted);border-radius:0.75rem;padding:0.75rem;margin-top:0.5rem;font-size:0.78rem;border:1px solid var(--border)}
  .ai-day-meal{display:flex;gap:0.5rem;margin-bottom:0.3rem;align-items:flex-start}
  .ai-day-meal:last-child{margin-bottom:0}
  .ai-meal-label{font-weight:700;color:var(--text-muted);font-size:0.68rem;text-transform:uppercase;letter-spacing:0.06em;flex-shrink:0;width:75px}
  .ai-meal-value{color:var(--text-primary);line-height:1.4}
  .ai-avantage{display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.25rem}
  </style>

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
  var searchInput = document.getElementById('globalSearchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      var query = this.value.toLowerCase().trim();
      document.querySelectorAll('.searchable-regime').forEach(function(card) {
        card.style.display = card.textContent.toLowerCase().includes(query) ? 'flex' : 'none';
      });
    });
    if (searchInput.value) searchInput.dispatchEvent(new Event('input'));
  }
});
</script>

<script>
var AI_PROXY_URL = '<?= BASE_URL ?>/ai-proxy.php';
var goalColors = {
  perte_poids:    {from:'#ef4444',to:'#dc2626',bg:'rgba(239,68,68,0.06)',  text:'#b91c1c',emoji:'🔥'},
  maintien:       {from:'#52B788',to:'#2D6A4F',bg:'rgba(82,183,136,0.06)', text:'#2D6A4F',emoji:'⚖️'},
  prise_masse:    {from:'#f59e0b',to:'#d97706',bg:'rgba(245,158,11,0.06)', text:'#92400e',emoji:'💪'},
  sante_generale: {from:'#ec4899',to:'#db2777',bg:'rgba(236,72,153,0.06)',text:'#9d174d',emoji:'❤️'},
  vegetarien:     {from:'#84cc16',to:'#65a30d',bg:'rgba(132,204,22,0.06)',text:'#3f6212',emoji:'🥗'},
  vegan:          {from:'#22c55e',to:'#16a34a',bg:'rgba(34,197,94,0.06)',  text:'#14532d',emoji:'🌱'},
  low_carb:       {from:'#8b5cf6',to:'#7c3aed',bg:'rgba(139,92,246,0.06)',text:'#4c1d95',emoji:'🥩'},
  detox:          {from:'#06b6d4',to:'#0891b2',bg:'rgba(6,182,212,0.06)',  text:'#164e63',emoji:'🍃'}
};

async function generateAIRegimes() {
  var goal    = document.getElementById('ai-goal-select').value;
  var details = document.getElementById('ai-details-input').value.trim();
  var btn     = document.getElementById('ai-gen-btn');
  var results = document.getElementById('ai-results');
  var loading = document.getElementById('ai-loading');
  var cardsEl = document.getElementById('ai-cards');
  btn.disabled = true;
  btn.textContent = 'G\u00e9n\u00e9ration...';
  results.style.display = 'block';
  loading.style.display = 'block';
  cardsEl.innerHTML = '';
  try {
    var res = await fetch(AI_PROXY_URL, {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({type: 'generate_regimes', goal: goal, details: details})
    });
    var data = await res.json();
    loading.style.display = 'none';
    if (data.error || !data.regimes) {
      cardsEl.innerHTML = '<div style="padding:1.5rem;background:#fef2f2;border:1px solid #fca5a5;border-radius:1rem;color:#b91c1c">Erreur de g\u00e9n\u00e9ration. R\u00e9essayez.</div>';
    } else {
      var c = goalColors[goal] || goalColors.sante_generale;
      data.regimes.forEach(function(r, i) {
        var avantages = (r.avantages || []).map(function(a) {
          return '<div class="ai-avantage"><span style="color:' + c.text + ';margin-right:0.35rem">✓</span>' + aiEsc(a) + '</div>';
        }).join('');
        var jour = r.jours_exemple && r.jours_exemple[0];
        var dayHtml = '';
        if (jour) {
          dayHtml = '<div class="ai-card-day">'
            + '<div style="font-size:0.7rem;font-weight:700;color:' + c.text + ';text-transform:uppercase;margin-bottom:0.5rem">📅 ' + aiEsc(jour.jour) + '</div>'
            + (jour.petit_dejeuner ? '<div class="ai-day-meal"><span class="ai-meal-label">🌅 Matin</span><span class="ai-meal-value">' + aiEsc(jour.petit_dejeuner) + '</span></div>' : '')
            + (jour.dejeuner       ? '<div class="ai-day-meal"><span class="ai-meal-label">☀️ Midi</span><span class="ai-meal-value">' + aiEsc(jour.dejeuner) + '</span></div>' : '')
            + (jour.collation      ? '<div class="ai-day-meal"><span class="ai-meal-label">🍎 Collation</span><span class="ai-meal-value">' + aiEsc(jour.collation) + '</span></div>' : '')
            + (jour.diner          ? '<div class="ai-day-meal"><span class="ai-meal-label">🌙 Soir</span><span class="ai-meal-value">' + aiEsc(jour.diner) + '</span></div>' : '')
            + '</div>';
        }
        var card = document.createElement('div');
        card.className = 'ai-regime-card';
        card.style.animationDelay = (i * 0.12) + 's';
        card.innerHTML =
          '<div style="height:4px;background:linear-gradient(90deg,' + c.from + ',' + c.to + ')"></div>'
          + '<div style="padding:1.25rem;background:' + c.bg + '">'
          + '<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.5rem;margin-bottom:0.75rem">'
          + '<div>'
          + '<span style="font-size:0.65rem;font-weight:700;text-transform:uppercase;color:' + c.text + ';display:block;margin-bottom:0.3rem">' + c.emoji + ' R\u00e9gime ' + (i + 1) + '</span>'
          + '<h3 style="font-family:var(--font-heading);font-weight:800;color:var(--text-primary);font-size:1rem;line-height:1.25;margin:0">' + aiEsc(r.nom) + '</h3>'
          + '</div>'
          + '<div style="text-align:right;flex-shrink:0">'
          + '<div style="font-weight:800;color:' + c.text + ';font-size:1.1rem">' + (r.calories_jour || '?') + '</div>'
          + '<div style="font-size:0.65rem;color:var(--text-muted)">kcal/jour</div>'
          + '</div></div>'
          + '<div style="margin-bottom:0.875rem"><span style="padding:0.2rem 0.6rem;background:rgba(255,255,255,0.6);border:1px solid rgba(0,0,0,0.07);border-radius:999px;font-size:0.7rem;font-weight:600">' + aiEsc(r.duree || '?') + '</span></div>'
          + '<p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.55;margin-bottom:0.875rem">' + aiEsc(r.description || '') + '</p>'
          + '<div style="margin-bottom:0.5rem">' + avantages + '</div>'
          + dayHtml
          + '</div>'
          + '<div style="padding:0.75rem 1.25rem;border-top:1px solid var(--border);display:flex;justify-content:flex-end">'
          + '<button onclick="if(typeof gbSendQuick===\'function\'){gbSendQuick(\'D\u00e9taille le r\u00e9gime : ' + aiEsc(r.nom).replace(/'/g, '') + '\');if(typeof gbOpen!==\'undefined\'&&!gbOpen)toggleGreenBot();}" style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.35rem 0.875rem;background:linear-gradient(135deg,' + c.from + ',' + c.to + ');color:#fff;border:none;border-radius:999px;font-size:0.75rem;font-weight:700;cursor:pointer">🤖 En savoir plus</button>'
          + '</div>';
        cardsEl.appendChild(card);
      });
    }
  } catch(err) {
    loading.style.display = 'none';
    cardsEl.innerHTML = '<div style="padding:1.5rem;background:#fef2f2;border:1px solid #fca5a5;border-radius:1rem;color:#b91c1c">Probl\u00e8me de connexion. V\u00e9rifiez votre r\u00e9seau.</div>';
  }
  btn.disabled = false;
  btn.innerHTML = 'G\u00e9n\u00e9rer';
}

function aiEsc(t) {
  if (!t) return '';
  return String(t).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
