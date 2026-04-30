<!-- Vue FrontOffice : Détail d'un Plan Nutritionnel -->
<?php
  // Check if the user is following this plan
  $followedPlans = $_SESSION['followed_plans'] ?? [];
  $isFollowing = isset($followedPlans[$plan['id']]);
  $followDate = $isFollowing ? $followedPlans[$plan['id']]['date_debut'] : null;
  $displayDate = $followDate ?? $plan['date_debut'] ?? date('Y-m-d');

  $planType = strtolower((string)($plan['type_objectif'] ?? 'maintien'));
  $heroImage = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200&q=80';
  $heroTint = 'rgba(30,92,56,0.44)';
  if (strpos($planType, 'perte') !== false) {
    $heroImage = 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=1200&q=80';
    $heroTint = 'rgba(30,92,56,0.44)';
  } elseif (strpos($planType, 'maintien') !== false) {
    $heroImage = 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=1200&q=80';
    $heroTint = 'rgba(0,140,120,0.4)';
  } elseif (strpos($planType, 'masse') !== false || strpos($planType, 'prise') !== false) {
    $heroImage = 'https://images.unsplash.com/photo-1547592180-85f173990554?w=1200&q=80';
    $heroTint = 'rgba(20,60,180,0.4)';
  }
?>
<style>
  .plan-bg {
    position: relative;
    z-index: 1;
    padding: 2rem;
    max-width: 64rem;
    margin: 0 auto;
    background: linear-gradient(135deg, #edf5ef 0%, #f4faf6 50%, #edf3ef 100%);
    border-radius: 24px;
  }
  .plan-bg::before,
  .plan-bg::after {
    content: "";
    position: absolute;
    pointer-events: none;
    z-index: 0;
  }
  .plan-bg::before {
    width: 420px;
    height: 300px;
    top: -60px;
    right: -80px;
    background: radial-gradient(circle, rgba(61,220,132,0.14) 0%, transparent 70%);
  }
  .plan-bg::after {
    width: 320px;
    height: 240px;
    bottom: -60px;
    left: -40px;
    background: radial-gradient(circle, rgba(30,92,56,0.12) 0%, transparent 70%);
  }
  .plan-bg > * { position: relative; z-index: 1; }
  .program-shell {
    border-radius: 24px;
    padding: 1rem;
    background: linear-gradient(145deg, rgba(194,224,206,0.35), rgba(172,206,187,0.24));
    border: 1px solid rgba(255,255,255,0.45);
    box-shadow: 0 14px 36px rgba(26,70,45,0.14);
    margin-top: 0.8rem;
  }
  .hero-refined {
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 22px 62px rgba(18,63,40,0.34), 0 8px 24px rgba(0,0,0,0.12) !important;
  }
  .plan-hero {
    min-height: 280px;
    border-radius: 24px;
    padding: 2.6rem 2rem !important;
    background-image: url('<?= htmlspecialchars($heroImage, ENT_QUOTES) ?>') !important;
    background-size: cover !important;
    background-position: center !important;
    position: relative;
    overflow: hidden;
  }
  .plan-hero .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,20,15,0.82) 0%, rgba(20,50,30,0.70) 50%, <?= $heroTint ?> 100%);
    z-index: 0;
  }
  .plan-hero .hero-dot-grid {
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
  }
  .plan-hero .hero-c1,
  .plan-hero .hero-c2,
  .plan-hero .hero-c3 {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
  }
  .plan-hero .hero-c1 { width: 420px; height: 420px; border: 1px solid rgba(255,255,255,0.08); top: -110px; right: -90px; }
  .plan-hero .hero-c2 { width: 260px; height: 260px; border: 1px solid rgba(255,255,255,0.09); top: -28px; right: 8px; }
  .plan-hero .hero-c3 { width: 140px; height: 140px; border: 1px solid rgba(255,255,255,0.12); top: 38px; right: 72px; }
  .plan-hero .hero-watermark {
    position: absolute;
    right: 34px;
    bottom: 10px;
    font-size: 88px;
    opacity: 0.08;
    z-index: 0;
    user-select: none;
  }
  .plan-hero .hero-content {
    position: relative;
    z-index: 2;
  }
  .plan-hero h1 {
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
    letter-spacing: -1px;
  }
  .plan-hero .hero-kcal-big {
    font-size: 3.2rem !important;
    text-shadow: 0 0 34px rgba(252,211,77,0.45);
  }
  .program-title-wrap {
    margin-top: 0.45rem;
    margin-bottom: 0.75rem;
    padding-bottom: 0.55rem;
    border-bottom: 1px solid rgba(30,92,56,0.14);
  }
  .plan-share-btn {
    margin-top: 0.55rem;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.58rem 1.05rem;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.14);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 160ms ease, background 160ms ease;
  }
  .plan-share-btn:hover {
    transform: translateY(-2px);
    background: rgba(255,255,255,0.2);
  }
  .floating-follow-plan {
    position: fixed;
    right: 132px;
    bottom: 20px;
    z-index: 101;
    opacity: 0;
    transform: translateY(16px) scale(0.98);
    pointer-events: none;
    transition: opacity 320ms ease, transform 320ms ease;
  }
  .floating-follow-plan.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
  }
  .floating-follow-plan button {
    background: linear-gradient(135deg,#fcd34d,#f59e0b);
    color: #1B4332;
    border: none;
    border-radius: 999px;
    font-size: 0.9rem;
    font-weight: 700;
    padding: 0.78rem 1.35rem;
    box-shadow: 0 8px 24px rgba(252,211,77,0.45);
    cursor: pointer;
    transition: transform 160ms ease, box-shadow 160ms ease;
  }
  .floating-follow-plan button:hover {
    transform: scale(1.04);
    box-shadow: 0 12px 28px rgba(252,211,77,0.58);
  }
  .tips-card {
    margin-top: 1rem;
    padding: 1.1rem 1.2rem;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.7);
    background: linear-gradient(135deg, rgba(219,238,227,0.75), rgba(202,227,212,0.66));
    box-shadow: 0 8px 22px rgba(20,52,33,0.1);
  }
  .tips-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
    margin-top: 0.65rem;
  }
  .tip-item {
    border-radius: 12px;
    padding: 0.75rem 0.8rem;
    border: 1px solid rgba(61,220,132,0.22);
    background: linear-gradient(135deg, #f0faf5, #e8f5ed);
  }
  .tip-item h4 {
    margin: 0 0 0.25rem;
    color: #1E5C38;
    font-size: 0.8rem;
    font-weight: 700;
  }
  .tip-item p {
    margin: 0;
    color: #3A4A40;
    font-size: 0.74rem;
    line-height: 1.45;
  }
  @media (max-width: 900px) {
    .tips-grid { grid-template-columns: 1fr; }
    .floating-follow-plan { right: 106px; bottom: 16px; }
  }

  [data-theme='dark'] .plan-bg {
    background: linear-gradient(135deg, #0f172a 0%, #0b1220 55%, #111827 100%);
  }
  [data-theme='dark'] .plan-bg::before {
    background: radial-gradient(circle, rgba(61,220,132,0.10) 0%, transparent 70%);
  }
  [data-theme='dark'] .plan-bg::after {
    background: radial-gradient(circle, rgba(59,130,246,0.10) 0%, transparent 70%);
  }
  [data-theme='dark'] .program-shell {
    background: linear-gradient(145deg, rgba(30,41,59,0.7), rgba(15,23,42,0.68));
    border-color: rgba(148,163,184,0.22);
    box-shadow: 0 16px 36px rgba(0,0,0,0.35);
  }
  [data-theme='dark'] .plan-bg .card:not(.plan-hero) {
    background: linear-gradient(145deg, rgba(30,41,59,0.72), rgba(15,23,42,0.68)) !important;
    border-color: rgba(148,163,184,0.24) !important;
    box-shadow: 0 10px 26px rgba(0,0,0,0.28) !important;
  }
  [data-theme='dark'] .plan-bg .hover-shadow {
    background: linear-gradient(135deg, rgba(30,41,59,0.78), rgba(17,24,39,0.72)) !important;
    border-color: rgba(148,163,184,0.22) !important;
  }
  [data-theme='dark'] .plan-bg .progress {
    background: rgba(148,163,184,0.2) !important;
  }
  [data-theme='dark'] .plan-bg [style*="color:var(--text-primary)"] { color: #e5e7eb !important; }
  [data-theme='dark'] .plan-bg [style*="color:var(--text-secondary)"] { color: #cbd5e1 !important; }
  [data-theme='dark'] .plan-bg [style*="color:var(--text-muted)"] { color: #94a3b8 !important; }
  [data-theme='dark'] .plan-bg [style*="background:rgba(0,0,0,0.05)"] {
    background: rgba(148,163,184,0.16) !important;
    color: #e2e8f0 !important;
  }
  [data-theme='dark'] .plan-bg .badge-gray {
    background: rgba(51,65,85,0.95) !important;
    color: #e2e8f0 !important;
    border: 1px solid rgba(148,163,184,0.35) !important;
  }
</style>
<div class="plan-bg">
  <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux plans
  </a>

  <!-- Header du Plan -->
  <div class="card mb-8 hero-refined plan-hero" style="color:white;border:none;position:relative;overflow:hidden">
    <div class="hero-overlay"></div>
    <div class="hero-c1"></div>
    <div class="hero-c2"></div>
    <div class="hero-c3"></div>
    <div class="hero-dot-grid">
      <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id="planDots" width="22" height="22" patternUnits="userSpaceOnUse">
            <circle cx="1.5" cy="1.5" r="1" fill="rgba(255,255,255,0.05)"/>
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#planDots)"/>
      </svg>
    </div>
    <div class="hero-watermark">🥗</div>
    <div class="flex items-start justify-between hero-content">
      <div>
        <div class="flex items-center gap-3 mb-2">
          <span style="padding:0.25rem 0.75rem;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em"><?= str_replace('_', ' ', $plan['type_objectif']) ?></span>
          <?php if (!empty($plan['regime_nom'])): ?>
            <span style="padding:0.25rem 0.75rem;background:rgba(255,255,255,0.18);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:600">
              Régime: <?= htmlspecialchars($plan['regime_nom']) ?>
            </span>
          <?php endif; ?>
          <?php if ($isFollowing): ?>
            <span style="padding:0.25rem 0.75rem;background:rgba(16,185,129,0.3);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;gap:0.3rem">
              <i data-lucide="check-circle" style="width:0.75rem;height:0.75rem"></i> Suivi actif
            </span>
          <?php endif; ?>
        </div>
        <h1 class="text-4xl font-bold mb-3" style="font-family:var(--font-heading)"><?= htmlspecialchars($plan['nom']) ?></h1>
        <p style="color:rgba(255,255,255,0.8);max-width:80%"><?= nl2br(htmlspecialchars($plan['description'] ?? 'Aucune description fournie.')) ?></p>

        <?php if ($isFollowing): ?>
          <div style="margin-top:1rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
            <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.9rem;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600">
              <i data-lucide="calendar" style="width:0.85rem;height:0.85rem"></i>
              Début : <?= date('d/m/Y', strtotime($followDate)) ?>
            </span>
            <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.9rem;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600">
              <i data-lucide="clock" style="width:0.85rem;height:0.85rem"></i>
              <?= $plan['duree_jours'] ?> jours
            </span>
            <?php
              $endDate = date('d/m/Y', strtotime($followDate . ' + ' . ((int)$plan['duree_jours'] - 1) . ' days'));
              $today = date('Y-m-d');
              $daysPassed = max(0, (strtotime($today) - strtotime($followDate)) / 86400);
              $progress = min(100, round(($daysPassed / max(1, $plan['duree_jours'])) * 100));
            ?>
            <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.9rem;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600">
              <i data-lucide="flag" style="width:0.85rem;height:0.85rem"></i>
              Fin : <?= $endDate ?>
            </span>
          </div>
          <!-- Progress bar -->
          <div style="margin-top:0.75rem;max-width:400px">
            <div style="display:flex;justify-content:space-between;font-size:0.7rem;font-weight:600;margin-bottom:0.3rem;color:rgba(255,255,255,0.7)">
              <span>Progression</span>
              <span><?= $progress ?>%</span>
            </div>
            <div style="height:6px;background:rgba(255,255,255,0.15);border-radius:3px;overflow:hidden">
              <div style="height:100%;width:<?= $progress ?>%;background:linear-gradient(90deg,#fcd34d,#f59e0b);border-radius:3px;transition:width 0.5s ease"></div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div style="text-align:right;flex-shrink:0">
        <div class="hero-kcal-big" style="font-weight:800;line-height:1;color:#fcd34d"><?= $plan['objectif_calories'] ?></div>
        <div style="font-size:0.875rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:rgba(255,255,255,0.7)">Calories / Jour</div>

        <!-- Follow / Unfollow button -->
        <?php if (!$isFollowing): ?>
          <button class="js-main-follow-trigger" onclick="document.getElementById('followModal').style.display='flex'" style="margin-top:1.25rem;display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.5rem;background:linear-gradient(135deg,#fcd34d,#f59e0b);color:#1B4332;border:none;border-radius:var(--radius-full);font-size:0.85rem;font-weight:700;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 16px rgba(252,211,77,0.35)" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(252,211,77,0.45)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(252,211,77,0.35)'">
            <i data-lucide="play-circle" style="width:1rem;height:1rem"></i> Suivre ce plan
          </button>
          <button type="button" class="plan-share-btn js-share-btn" data-share-title="<?= htmlspecialchars($plan['nom']) ?>" data-share-text="Découvrez ce plan nutritionnel GreenBite">
            <i data-lucide="share-2" style="width:0.9rem;height:0.9rem"></i> Partager
          </button>
        <?php else: ?>
          <div style="display:flex;flex-direction:column;gap:0.5rem;align-items:flex-end;margin-top:1.25rem">
            <button class="js-main-follow-trigger" onclick="document.getElementById('followModal').style.display='flex'" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.65rem 1.5rem;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:var(--radius-full);font-size:0.85rem;font-weight:700;cursor:pointer;transition:all 0.3s" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
              <i data-lucide="calendar-check" style="width:1rem;height:1rem"></i> Modifier la date
            </button>
            <button type="button" class="plan-share-btn js-share-btn" data-share-title="<?= htmlspecialchars($plan['nom']) ?>" data-share-text="Découvrez ce plan nutritionnel GreenBite">
              <i data-lucide="share-2" style="width:0.9rem;height:0.9rem"></i> Partager
            </button>
            <button data-confirm="Êtes-vous sûr de vouloir arrêter le suivi de ce plan ?" data-confirm-title="Arrêter le suivi" data-confirm-type="warning" data-confirm-url="<?= BASE_URL ?>/?page=nutrition&action=plan-unfollow&id=<?= $plan['id'] ?>" data-confirm-btn="Arrêter" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.55rem 1.25rem;background:rgba(239,68,68,0.2);backdrop-filter:blur(10px);color:#fca5a5;border:1px solid rgba(239,68,68,0.35);border-radius:var(--radius-full);font-size:0.8rem;font-weight:600;cursor:pointer;transition:all 0.3s" onmouseover="this.style.background='rgba(239,68,68,0.35)';this.style.color='#fff'" onmouseout="this.style.background='rgba(239,68,68,0.2)';this.style.color='#fca5a5'">
              <i data-lucide="x-circle" style="width:0.9rem;height:0.9rem"></i> Arrêter le suivi
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Timeline des repas -->
  <div class="mb-4 program-title-wrap">
    <h2 class="text-xl font-bold" style="color:var(--text-primary)"><i data-lucide="calendar-days" style="width:1.25rem;height:1.25rem;display:inline-block;color:var(--primary)"></i> Programme Journalier</h2>
  </div>

  <?php
    $allActivites = [];
    if (!empty($plan['programme_activites'])) {
      $allActivites = json_decode($plan['programme_activites'], true) ?? [];
    }

    $daysWithData = [];
    foreach ($repasByDay as $jourKey => $list) {
      if (!empty($list)) $daysWithData[(int)$jourKey] = true;
    }
    foreach ($allActivites as $jourKey => $actTxt) {
      if (!empty(trim((string)$actTxt))) $daysWithData[(int)$jourKey] = true;
    }
    $daysToRender = array_keys($daysWithData);
    sort($daysToRender);
  ?>

  <?php if (empty($daysToRender)): ?>
    <div class="card text-center py-8">
      <p style="color:var(--text-muted)">Aucun contenu journalier (repas/activité) n'a été défini pour ce plan.</p>
    </div>
  <?php else: ?>
    <div class="space-y-6 program-shell">
      <?php foreach ($daysToRender as $jour): ?>
        <div class="card" style="padding:1.5rem;background:linear-gradient(145deg,rgba(211,233,219,0.76),rgba(190,217,201,0.66));backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.82);border-radius:20px;box-shadow:0 10px 30px rgba(20,54,34,0.13),0 1px 3px rgba(0,0,0,0.05)">
          <div class="flex items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:var(--primary);color:white;border-radius:50%;font-weight:bold">J<?= $jour ?></div>
            <h3 class="font-semibold text-lg" style="color:var(--text-primary)">Jour <?= $jour ?></h3>
            <?php if ($isFollowing || !empty($displayDate)):
              $t = strtotime($displayDate . ' + ' . ($jour - 1) . ' days');
              $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
            ?>
              <span class="text-xs" style="color:var(--text-muted);margin-left:auto"><?= date('d', $t) . ' ' . $mois[(int)date('n', $t)-1] . ' ' . date('Y', $t) ?></span>
            <?php endif; ?>
          </div>

          <?php
            // Show activity for this day if it exists
            $activitesDuJour = [];
            $activitesDuJour = $allActivites[$jour] ?? ($allActivites[(string)$jour] ?? '');
          ?>
          <?php if (!empty($activitesDuJour)): ?>
            <div style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.875rem 1rem;background:linear-gradient(135deg,rgba(245,158,11,0.07),rgba(252,211,77,0.04));border:1px solid rgba(245,158,11,0.18);border-radius:var(--radius-xl);margin-bottom:1rem">
              <div style="display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:linear-gradient(135deg,#fef3c7,#fffbeb);border-radius:0.5rem;flex-shrink:0;box-shadow:0 2px 8px rgba(245,158,11,0.15)">
                <i data-lucide="activity" style="width:0.9rem;height:0.9rem;color:#f59e0b"></i>
              </div>
              <div>
                <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#b45309;margin-bottom:0.2rem">Activité du jour</div>
                <div style="font-size:0.85rem;color:var(--text-primary);line-height:1.5"><?= nl2br(htmlspecialchars($activitesDuJour)) ?></div>
              </div>
            </div>
          <?php endif; ?>

          <?php if (!isset($repasByDay[$jour]) || empty($repasByDay[$jour])): ?>
            <p class="text-sm italic" style="color:var(--text-muted);padding:1rem 0">Journée libre ou repas non définis.</p>
          <?php else: ?>
            <div class="space-y-3">
              <?php foreach ($repasByDay[$jour] as $r): ?>
                <div style="display:flex;align-items:center;gap:1rem;padding:1rem;background:linear-gradient(135deg,rgba(229,243,235,0.78),rgba(211,231,220,0.7));border-radius:var(--radius-xl);border:1px solid rgba(255,255,255,0.72);transition:all 0.2s;box-shadow:inset 0 1px 0 rgba(255,255,255,0.3)" class="hover-shadow">
                  <div style="width:3px;height:30px;background:var(--secondary);border-radius:2px"></div>
                  <div style="flex-grow:1">
                    <div class="flex items-center justify-between mb-1">
                      <h4 class="font-bold text-base" style="color:var(--text-primary)"><?= htmlspecialchars($r['nom']) ?> <span class="badge badge-gray ml-2"><?= htmlspecialchars($r['type_repas']) ?></span></h4>
                      <span class="font-bold" style="color:var(--accent-orange)"><?= $r['calories_total'] ?> kcal</span>
                    </div>
                    <?php if (!empty($r['aliments'])): ?>
                      <div class="text-xs flex gap-2 flex-wrap mt-2" style="color:var(--text-secondary)">
                        <?php foreach ($r['aliments'] as $a): ?>
                          <span style="background:rgba(0,0,0,0.05);padding:0.15rem 0.5rem;border-radius:var(--radius-full)">• <?= htmlspecialchars($a['nom']) ?> (<?= $a['quantite']?><?= $a['unite']?>)</span>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            
            <?php // Calcul des totaux du jour
              $calJour = 0;
              foreach ($repasByDay[$jour] as $r) $calJour += $r['calories_total'];
              $pctCal = min(100, round(($calJour / $plan['objectif_calories']) * 100));
              $colorBar = $pctCal > 100 ? '#ef4444' : 'var(--primary)';
            ?>
            <div class="mt-4 pt-3" style="border-top:1px dashed var(--border)">
              <div class="flex items-center justify-between text-sm mb-1">
                <span class="font-semibold" style="color:var(--text-primary)">Total Journalier</span>
                <span class="font-bold <?= $calJour > $plan['objectif_calories'] ? 'text-red-500' : 'text-green-600' ?>"><?= $calJour ?> / <?= $plan['objectif_calories'] ?> kcal</span>
              </div>
              <div class="progress" style="background:rgba(17,44,30,0.16)"><div class="progress-bar" style="width:<?= $pctCal ?>%;background:<?= $colorBar ?>"></div></div>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="card mt-6" style="padding:1.1rem 1.25rem;border:1px solid rgba(255,255,255,0.62);background:linear-gradient(135deg,rgba(206,229,215,0.7),rgba(192,219,202,0.62));box-shadow:0 8px 24px rgba(20,52,33,0.11)">
    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;font-weight:700;color:var(--text-primary);margin-bottom:0.45rem">
      <i data-lucide="file-text" style="width:0.9rem;height:0.9rem;color:var(--secondary)"></i>
      Description générale du plan
    </div>
    <p style="margin:0;font-size:0.85rem;color:var(--text-secondary);line-height:1.6">
      <?= nl2br(htmlspecialchars($plan['description'] ?? 'Aucune description fournie.')) ?>
    </p>
  </div>

</div>

<div class="floating-follow-plan" id="floatingFollowPlan">
  <button type="button" onclick="document.getElementById('followModal').style.display='flex'">Suivre ce plan</button>
</div>

<!-- ===== Follow Plan Modal ===== -->
<div id="followModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <!-- Icon -->
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,rgba(252,211,77,0.15),rgba(245,158,11,0.1));border-radius:50%;margin-bottom:1rem">
      <i data-lucide="calendar-check" style="width:1.625rem;height:1.625rem;color:#f59e0b"></i>
    </div>
    <!-- Title -->
    <h3 style="font-family:var(--font-heading);font-size:1.15rem;font-weight:800;color:var(--text-primary);margin-bottom:0.4rem">
      <?= $isFollowing ? 'Modifier la date de début' : 'Suivre ce plan' ?>
    </h3>
    <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6">
      <?= $isFollowing ? 'Choisissez une nouvelle date de début pour votre plan.' : 'Choisissez la date à laquelle vous souhaitez commencer ce plan nutritionnel.' ?>
    </p>

    <form method="POST" action="<?= BASE_URL ?>/?page=nutrition&action=plan-follow&id=<?= $plan['id'] ?>">
      <!-- Date Input -->
      <div style="text-align:left;margin-bottom:1.5rem">
        <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
          <i data-lucide="calendar" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.35rem"></i>
          Date de début
        </label>
        <input type="date" name="date_debut" id="followDateInput"
               value="<?= htmlspecialchars($followDate ?? date('Y-m-d')) ?>"
               style="width:100%;padding:0.7rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none"
               onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)'"
               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
        <div id="followDateError" style="color:#ef4444;font-size:0.75rem;margin-top:0.35rem;display:none">
          <i data-lucide="alert-circle" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i>
          Veuillez choisir une date valide.
        </div>

        <!-- Quick date chips -->
        <div style="display:flex;gap:0.5rem;margin-top:0.75rem;flex-wrap:wrap">
          <button type="button" class="follow-date-chip" onclick="setFollowDate(0)" style="padding:0.3rem 0.75rem;background:var(--muted);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.72rem;font-weight:600;color:var(--text-secondary);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
            Aujourd'hui
          </button>
          <button type="button" class="follow-date-chip" onclick="setFollowDate(1)" style="padding:0.3rem 0.75rem;background:var(--muted);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.72rem;font-weight:600;color:var(--text-secondary);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
            Demain
          </button>
          <button type="button" class="follow-date-chip" onclick="setFollowDate(getNextMonday())" style="padding:0.3rem 0.75rem;background:var(--muted);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.72rem;font-weight:600;color:var(--text-secondary);cursor:pointer;transition:all 0.2s" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
            Lundi prochain
          </button>
        </div>
      </div>

      <!-- Buttons -->
      <div style="display:flex;gap:0.75rem;justify-content:center">
        <button type="button" onclick="document.getElementById('followModal').style.display='none'"
                style="padding:0.6rem 1.5rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.2s"
                onmouseover="this.style.background='var(--border)'"
                onmouseout="this.style.background='var(--muted)'">
          Annuler
        </button>
        <button type="submit"
                style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.5rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border:none;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 12px rgba(45,106,79,0.3)"
                onmouseover="this.style.boxShadow='0 6px 20px rgba(45,106,79,0.4)';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.boxShadow='0 4px 12px rgba(45,106,79,0.3)';this.style.transform='none'">
          <i data-lucide="check" style="width:0.875rem;height:0.875rem"></i>
          <?= $isFollowing ? 'Mettre à jour' : 'Commencer le plan' ?>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Close modal on backdrop click
document.getElementById('followModal').addEventListener('click', function(e) {
  if (e.target === this) this.style.display = 'none';
});
// ESC key to close
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') document.getElementById('followModal').style.display = 'none';
});

// Quick date helpers
function setFollowDate(daysOrDate) {
  const input = document.getElementById('followDateInput');
  let date;
  if (typeof daysOrDate === 'number') {
    date = new Date();
    date.setDate(date.getDate() + daysOrDate);
  } else {
    date = daysOrDate;
  }
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  input.value = y + '-' + m + '-' + d;
}

function getNextMonday() {
  const today = new Date();
  const day = today.getDay();
  const diff = day === 0 ? 1 : 8 - day; // If Sunday, next day. Otherwise, days until Monday.
  const monday = new Date(today);
  monday.setDate(today.getDate() + diff);
  return monday;
}

// Validate date before submit
document.querySelector('#followModal form').addEventListener('submit', function(e) {
  const val = document.getElementById('followDateInput').value;
  const errEl = document.getElementById('followDateError');
  if (!val || !/^\d{4}-\d{2}-\d{2}$/.test(val)) {
    e.preventDefault();
    errEl.style.display = 'block';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  } else {
    errEl.style.display = 'none';
  }
});

async function shareCurrentPage(title, text) {
  const shareData = { title, text, url: window.location.href };
  try {
    if (navigator.share) {
      await navigator.share(shareData);
      return;
    }
  } catch (err) {
    if (err && err.name === 'AbortError') return;
  }
  const fallbackText = `${title}\n${text}\n${window.location.href}`;
  try {
    await navigator.clipboard.writeText(fallbackText);
    alert('Lien copié dans le presse-papiers.');
  } catch (err) {
    prompt('Copiez ce lien :', window.location.href);
  }
}

document.querySelectorAll('.js-share-btn').forEach((btn) => {
  btn.addEventListener('click', () => {
    const title = btn.getAttribute('data-share-title') || document.title;
    const text = btn.getAttribute('data-share-text') || 'Découvrez ce contenu GreenBite';
    shareCurrentPage(title, text);
  });
});

const floatingFollowPlan = document.getElementById('floatingFollowPlan');
const mainPlanFollowTrigger = document.querySelector('.js-main-follow-trigger');
function setPlanFloatingVisibility(visible) {
  floatingFollowPlan.classList.toggle('show', visible);
}
if (mainPlanFollowTrigger && 'IntersectionObserver' in window) {
  const followObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => setPlanFloatingVisibility(!entry.isIntersecting));
  }, { threshold: 0.15 });
  followObserver.observe(mainPlanFollowTrigger);
} else {
  function toggleFloatingPlanButtonFallback() {
    setPlanFloatingVisibility(window.scrollY > 80);
  }
  window.addEventListener('scroll', toggleFloatingPlanButtonFallback);
  toggleFloatingPlanButtonFallback();
}

if (typeof lucide !== 'undefined') lucide.createIcons();

<?php if (isset($_GET['follow']) && $_GET['follow'] === '1'): ?>
setTimeout(() => {
  const modal = document.getElementById('followModal');
  if (modal) modal.style.display = 'flex';
}, 120);
<?php endif; ?>
</script>
