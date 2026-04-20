<?php
/**
 * Vue FrontOffice : Détail d'un Régime Alimentaire
 */

$obj = $regime['objectif'] ?? 'maintien';

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
    'perte_poids'    => ['from'=>'#3b82f6','to'=>'#2563eb','hdr'=>'#1e40af','bg'=>'rgba(59,130,246,0.08)'],
    'maintien'       => ['from'=>'#52B788','to'=>'#2D6A4F','hdr'=>'#1B4332','bg'=>'rgba(82,183,136,0.08)'],
    'prise_masse'    => ['from'=>'#f59e0b','to'=>'#d97706','hdr'=>'#b45309','bg'=>'rgba(245,158,11,0.08)'],
    'sante_generale' => ['from'=>'#ec4899','to'=>'#db2777','hdr'=>'#9d174d','bg'=>'rgba(236,72,153,0.08)'],
];

$lbl = $objectifLabels[$obj] ?? $obj;
$ico = $objectifIcons[$obj] ?? 'target';
$col = $objectifColors[$obj] ?? $objectifColors['maintien'];
?>

<div style="padding:2rem;max-width:64rem;margin:0 auto">
  <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s;display:inline-flex" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='none'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux régimes
  </a>

  <!-- Header du Régime -->
  <div class="card mb-8" style="background:linear-gradient(135deg,<?= $col['from'] ?>,<?= $col['hdr'] ?>);color:white;border:none;padding:3rem 2rem;position:relative;overflow:hidden;box-shadow:0 16px 32px <?= $col['bg'] ?>">
    <div style="position:absolute;top:-50px;right:-50px;width:250px;height:250px;background:rgba(255,255,255,0.08);border-radius:50%;filter:blur(30px);animation:float 6s ease-in-out infinite"></div>
    <div style="position:absolute;bottom:-30px;left:-30px;width:150px;height:150px;background:rgba(0,0,0,0.1);border-radius:50%;filter:blur(20px)"></div>
    
    <div class="flex items-start justify-between relative z-10 w-full gap-4 flex-wrap">
      <div style="flex:1;min-width:300px">
        <div class="flex items-center gap-3 mb-3">
          <span style="padding:0.35rem 0.85rem;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;display:inline-flex;align-items:center;gap:0.35rem">
            <i data-lucide="<?= $ico ?>" style="width:0.875rem;height:0.875rem"></i> <?= $lbl ?>
          </span>
          <?php if ($regime['statut'] !== 'accepte'): ?>
             <span style="padding:0.35rem 0.85rem;background:rgba(245,158,11,0.2);color:#fef08a;backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em">
               <i data-lucide="clock" style="width:0.8rem;height:0.8rem;display:inline"></i> <?= ucfirst(str_replace('_', ' ', $regime['statut'])) ?>
             </span>
          <?php endif; ?>
        </div>
        <h1 class="font-bold mb-4" style="font-family:var(--font-heading);font-size:2.25rem;line-height:1.2;letter-spacing:-0.01em"><?= htmlspecialchars($regime['nom']) ?></h1>
        
        <div style="display:flex;align-items:center;gap:1.25rem;font-size:0.85rem;color:rgba(255,255,255,0.8);font-weight:500">
          <span style="display:inline-flex;align-items:center;gap:0.4rem">
            <i data-lucide="user" style="width:1rem;height:1rem"></i> Proposé par <?= htmlspecialchars($regime['soumis_par']) ?>
          </span>
          <span style="display:inline-flex;align-items:center;gap:0.4rem">
            <i data-lucide="calendar-days" style="width:1rem;height:1rem"></i> Ajouté le <?= date('d/m/Y', strtotime($regime['created_at'])) ?>
          </span>
        </div>
      </div>
      
      <div style="display:flex;gap:1.5rem;text-align:center">
        <!-- Stats widget 1 -->
        <div style="background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.15);border-radius:1.25rem;padding:1.25rem 1.5rem;min-width:120px">
          <div style="font-size:2.5rem;font-weight:800;line-height:1;margin-bottom:0.25rem"><?= (int)$regime['duree_semaines'] ?></div>
          <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:rgba(255,255,255,0.7)">Semaines</div>
        </div>
        <!-- Stats widget 2 -->
        <div style="background:rgba(255,255,255,0.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.15);border-radius:1.25rem;padding:1.25rem 1.5rem;min-width:120px">
          <div style="font-size:2.5rem;font-weight:800;line-height:1;margin-bottom:0.25rem;color:#fcd34d"><?= number_format((int)$regime['calories_jour']) ?></div>
          <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:rgba(255,255,255,0.7)">Kcal / Jour</div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Colonne Principale -->
    <div class="md:col-span-2 space-y-6">
      
      <!-- Description Section -->
      <div class="card" style="padding:2rem">
        <h2 style="font-family:var(--font-heading);font-size:1.25rem;font-weight:800;color:var(--text-primary);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem">
          <i data-lucide="info" style="width:1.25rem;height:1.25rem;color:<?= $col['from'] ?>"></i> Détails et Principes
        </h2>
        <div style="font-size:0.95rem;color:var(--text-secondary);line-height:1.8;white-space:pre-line">
          <?= htmlspecialchars($regime['description']) ?>
        </div>
      </div>

    </div>

    <!-- Colonne Latérale -->
    <div class="space-y-6">
      
      <!-- Restrictions Card -->
      <div class="card" style="padding:1.5rem;background:linear-gradient(135deg,rgba(239,68,68,0.03),rgba(239,68,68,0.05));border:1px solid rgba(239,68,68,0.15)">
        <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:#dc2626;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem">
          <div style="width:2rem;height:2rem;background:rgba(239,68,68,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center">
            <i data-lucide="shield-alert" style="width:1.1rem;height:1.1rem;color:#ef4444"></i>
          </div>
          Restrictions
        </h3>
        <p style="font-size:0.875rem;color:var(--text-secondary);line-height:1.6">
          <?= !empty($regime['restrictions']) ? nl2br(htmlspecialchars($regime['restrictions'])) : '<span style="font-style:italic;color:var(--text-muted)">Aucune restriction particulière précisée.</span>' ?>
        </p>
      </div>

      <!-- Action Box if user is owner and it's rejected/pending -->
      <?php if (($regime['statut'] === 'refuse' || $regime['statut'] === 'en_attente') && ($_SESSION['regime_user'] ?? '') === $regime['soumis_par']): ?>
        <div class="card" style="padding:1.5rem;border:1px dashed var(--border);background:var(--muted)">
          <h3 style="font-size:0.95rem;font-weight:700;color:var(--text-primary);margin-bottom:0.75rem;display:flex;align-items:center;gap:0.4rem">
            <i data-lucide="settings" style="width:1rem;height:1rem"></i> Gérer mon régime
          </h3>
          <?php if ($regime['statut'] === 'refuse' && !empty($regime['commentaire_admin'])): ?>
            <div style="background:#fff;padding:1rem;border-radius:var(--radius-lg);border-left:3px solid #ef4444;margin-bottom:1rem;font-size:0.8rem;color:var(--text-secondary)">
              <strong style="color:#ef4444;display:block;margin-bottom:0.2rem">Motif de refus :</strong>
              <?= htmlspecialchars($regime['commentaire_admin']) ?>
            </div>
          <?php endif; ?>
          <div style="display:flex;flex-direction:column;gap:0.5rem">
            <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-edit&id=<?= $regime['id'] ?>" class="btn btn-primary w-full justify-center" style="border-radius:var(--radius-full)">
              <i data-lucide="edit-3" style="width:0.875rem;height:0.875rem"></i> Modifier la proposition
            </a>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<script>
if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
