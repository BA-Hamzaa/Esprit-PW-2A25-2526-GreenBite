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
$objectifAccent = [
    'perte_poids'    => '#1E5C38',
    'maintien'       => '#0A8C78',
    'prise_masse'    => '#143CB4',
    'sante_generale' => '#B41464',
];
$objectifOverlayRight = [
    'perte_poids'    => 'rgba(30,92,56,0.40)',
    'maintien'       => 'rgba(0,140,120,0.40)',
    'prise_masse'    => 'rgba(20,60,180,0.40)',
    'sante_generale' => 'rgba(180,20,100,0.40)',
];
$objectifWatermark = [
    'perte_poids'    => '🔥',
    'maintien'       => '⚖️',
    'prise_masse'    => '💪',
    'sante_generale' => '🫀',
];
$heroImages = [
    'sante_generale' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=1200&q=80',
    'maintien'       => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=1200&q=80',
    'perte_poids'    => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=1200&q=80',
    'prise_masse'    => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=1200&q=80',
];
$fallbackHero = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200&q=80';

$lbl = $objectifLabels[$obj] ?? ucfirst(str_replace('_', ' ', $obj));
$ico = $objectifIcons[$obj] ?? 'target';
$accent = $objectifAccent[$obj] ?? '#1E5C38';
$overlayRight = $objectifOverlayRight[$obj] ?? 'rgba(30,92,56,0.40)';
$watermark = $objectifWatermark[$obj] ?? '🥗';
$heroImage = $heroImages[$obj] ?? $fallbackHero;

$weeks = (int)($regime['duree_semaines'] ?? $regime['duree'] ?? 0);
$calories = (int)($regime['calories_jour'] ?? 0);
$description = trim((string)($regime['description'] ?? ''));
$descIsLong = mb_strlen($description) > 200;
$descShort = $descIsLong ? mb_substr($description, 0, 200) : $description;

$rawRestrictions = trim((string)($regime['restrictions'] ?? ''));
$restrictionsList = [];
if ($rawRestrictions !== '') {
    $normalized = preg_replace("/\r\n|\r/", "\n", $rawRestrictions);
    $parts = preg_split("/\n|;|•|- /", $normalized);
    foreach ($parts as $part) {
        $item = trim($part);
        if ($item !== '') {
            $restrictionsList[] = $item;
        }
    }
}
$followRegimeUrl = BASE_URL . '/?page=nutrition&action=plans&regime_id=' . (int)$regime['id'] . '&follow=1';
?>

<style>
  body {
    background: linear-gradient(160deg, #EEF3EE 0%, #F6F9F6 60%, #EDF2F0 100%);
  }
  .regime-blob {
    position: fixed;
    z-index: 0;
    pointer-events: none;
  }
  .regime-blob.a {
    width: 500px;
    height: 500px;
    top: -120px;
    right: -100px;
    background: radial-gradient(ellipse, rgba(61,220,132,0.10), transparent 70%);
  }
  .regime-blob.b {
    width: 400px;
    height: 400px;
    bottom: -80px;
    left: 50px;
    background: radial-gradient(ellipse, rgba(180,20,100,0.06), transparent 70%);
  }

  .regime-page {
    position: relative;
    z-index: 1;
    max-width: 1150px;
    margin: 0 auto;
    padding: 2rem 2rem 110px;
  }
  .regime-page * { position: relative; z-index: 1; }

  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    color: #3DDC84;
    text-decoration: none;
    font-size: 13px;
    margin-bottom: 0.95rem;
    opacity: 0;
    transform: translateY(8px);
    animation: fadeInUp 500ms ease 200ms forwards;
  }
  .back-link:hover { text-decoration: underline; transform: translateX(-4px); }

  .hero {
    border-radius: 28px;
    min-height: 320px;
    padding: 48px 52px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,0.22), 0 4px 16px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.1);
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1.2rem;
    background-image: url('<?= htmlspecialchars($heroImage, ENT_QUOTES) ?>');
    background-size: cover;
    background-position: center;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 500ms ease-out forwards;
  }
  .hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 0;
    background: linear-gradient(
      135deg,
      rgba(10, 20, 15, 0.82) 0%,
      rgba(20, 50, 30, 0.70) 50%,
      <?= $overlayRight ?> 100%
    );
  }
  .hero-c1,.hero-c2,.hero-c3 {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 1;
  }
  .hero-c1 { width: 500px; height: 500px; border: 1px solid rgba(255,255,255,0.06); top: -150px; right: -120px; }
  .hero-c2 { width: 320px; height: 320px; border: 1px solid rgba(255,255,255,0.07); top: -60px; right: -30px; }
  .hero-c3 { width: 180px; height: 180px; border: 1px solid rgba(255,255,255,0.09); top: 20px; right: 50px; }
  .hero-dots {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
  }
  .hero-watermark {
    position: absolute;
    bottom: 16px;
    right: 48px;
    font-size: 96px;
    opacity: 0.08;
    user-select: none;
    z-index: 1;
    pointer-events: none;
  }
  .hero-left, .hero-right {
    z-index: 2;
  }
  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.28);
    backdrop-filter: blur(12px);
    border-radius: 50px;
    padding: 6px 16px;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 16px;
  }
  .hero-badge-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: <?= $accent ?>;
    box-shadow: 0 0 10px <?= $accent ?>;
  }
  .hero-name {
    color: #fff;
    font-size: clamp(2.1rem, 5.2vw, 3rem);
    font-weight: 900;
    letter-spacing: -1.5px;
    line-height: 1.05;
    margin: 0 0 16px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
  }
  .hero-meta {
    display: flex;
    gap: 20px;
    align-items: center;
    color: rgba(255,255,255,0.65);
    font-size: 13px;
    flex-wrap: wrap;
  }
  .hero-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .hero-actions {
    margin-top: 24px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  .btn-main {
    background: linear-gradient(135deg, #F5A623, #E8930A);
    border: none;
    border-radius: 50px;
    padding: 14px 28px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    box-shadow: 0 8px 24px rgba(245,166,35,0.5);
    transition: transform 200ms, box-shadow 200ms;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
  }
  .btn-main:hover { transform: scale(1.04); box-shadow: 0 12px 30px rgba(245,166,35,0.62); }
  .btn-ghost {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 14px 24px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    transition: transform 180ms ease, box-shadow 180ms ease;
    cursor: pointer;
  }
  .btn-ghost:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.22); }

  .hero-right {
    display: flex;
    gap: 10px;
  }
  .metric-chip {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.22);
    backdrop-filter: blur(16px);
    border-radius: 20px;
    padding: 20px 28px;
    text-align: center;
    min-width: 120px;
  }
  .metric-value {
    color: #fff;
    font-size: 40px;
    font-weight: 900;
    line-height: 1;
    font-variant-numeric: tabular-nums;
  }
  .metric-value.gold {
    color: #F5A623;
    text-shadow: 0 0 30px rgba(245,166,35,0.5);
  }
  .metric-label {
    color: rgba(255,255,255,0.55);
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-top: 6px;
    font-weight: 700;
  }

  .quick-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin: 24px 0;
  }
  .quick-card {
    background: linear-gradient(145deg, rgba(211,233,219,0.76), rgba(190,217,201,0.66));
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.82);
    border-radius: 20px;
    padding: 20px 24px;
    box-shadow: 0 10px 30px rgba(20,54,34,0.13), 0 1px 3px rgba(0,0,0,0.05);
    opacity: 0;
    transform: translateY(18px);
    transition: opacity 460ms ease, transform 460ms ease, box-shadow 180ms ease;
  }
  .quick-card.show { opacity: 1; transform: translateY(0); }
  .quick-card:hover { box-shadow: 0 12px 30px rgba(20,54,34,0.18), 0 2px 8px rgba(0,0,0,0.06); transform: translateY(-2px); }
  .quick-label {
    color: #6f7f74;
    font-size: 12px;
    margin-bottom: 10px;
  }
  .quick-value {
    font-size: 24px;
    font-weight: 700;
    color: #1E5C38;
  }

  .glass-section {
    background: linear-gradient(145deg, rgba(211,233,219,0.76), rgba(190,217,201,0.66));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.82);
    border-radius: 24px;
    padding: 32px 36px;
    box-shadow: 0 10px 30px rgba(20,54,34,0.13), 0 1px 3px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 500ms ease, transform 500ms ease, box-shadow 180ms ease;
  }
  .glass-section.show { opacity: 1; transform: translateY(0); }
  .glass-section:hover { box-shadow: 0 12px 30px rgba(20,54,34,0.18), 0 2px 8px rgba(0,0,0,0.06); transform: translateY(-2px); }
  .section-head {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
  }
  .head-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(61,220,132,0.35);
    color: #fff;
    font-size: 18px;
    background: linear-gradient(135deg, #1E5C38, #3DDC84);
  }
  .head-title {
    font-size: 20px;
    font-weight: 700;
    color: #1A2E20;
  }
  .head-line {
    flex: 1;
    margin-left: 16px;
    height: 1px;
    background: linear-gradient(90deg, rgba(61,220,132,0.3), transparent);
  }
  .section-text {
    font-size: 15px;
    line-height: 1.8;
    color: #3A4A40;
    white-space: pre-line;
    overflow-wrap: anywhere;
    word-break: break-word;
    overflow: hidden;
    max-height: 1000px;
    transition: max-height 350ms ease;
  }
  .section-text.collapsed { max-height: 170px; }
  .read-more-btn {
    margin-top: 8px;
    border: none;
    background: transparent;
    color: #3DDC84;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    font-size: 14px;
  }

  .restrictions-icon { background: linear-gradient(135deg, #C0392B, #E74C3C); box-shadow: 0 4px 12px rgba(231,76,60,0.35); }
  .restrictions-title { color: #C0392B; }
  .restrictions-line { background: linear-gradient(90deg, rgba(231,76,60,0.3), transparent); }
  .restrictions-box {
    background: linear-gradient(135deg, rgba(248,235,236,0.65), rgba(241,220,222,0.6));
    border: 1px solid rgba(231,76,60,0.18);
    border-radius: 14px;
    padding: 16px 20px;
    margin-top: 16px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.35);
  }
  .restriction-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 8px 0;
    border-bottom: 1px solid rgba(231,76,60,0.08);
    color: #4A2020;
    font-size: 14px;
    overflow-wrap: anywhere;
    word-break: break-word;
  }
  .restriction-item span:last-child {
    flex: 1;
    min-width: 0;
  }
  .restriction-item:last-child { border-bottom: none; }
  .ok-text {
    color: #3DDC84;
    font-style: italic;
    font-size: 14px;
  }

  .tips-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
  }
  .tip-card {
    background: linear-gradient(135deg, #F0FAF5, #E8F5ED);
    border-radius: 16px;
    padding: 18px;
    border: 1px solid rgba(61,220,132,0.2);
    opacity: 0;
    transform: translateY(18px);
    transition: opacity 420ms ease, transform 420ms ease, box-shadow 180ms ease;
  }
  .tip-card.show { opacity: 1; transform: translateY(0); }
  .tip-card:hover { box-shadow: 0 10px 24px rgba(30,92,56,0.14); transform: translateY(-2px); }
  .tip-title {
    color: #1E5C38;
    font-size: 13px;
    font-weight: 700;
    margin: 0 0 6px;
  }
  .tip-text {
    color: #3A4A40;
    font-size: 12px;
    line-height: 1.5;
    margin: 0;
  }

  .floating-follow {
    position: fixed;
    right: 132px;
    bottom: 20px;
    z-index: 101;
    opacity: 0;
    transform: translateY(16px) scale(0.98);
    pointer-events: none;
    transition: opacity 320ms ease, transform 320ms ease;
  }
  .floating-follow.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
  }
  .floating-follow .sticky-btn {
    background: linear-gradient(135deg, #F5A623, #E8930A);
    border: none;
    border-radius: 50px;
    padding: 13px 20px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 22px rgba(245,166,35,0.45);
    transition: transform 200ms, box-shadow 200ms;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
  }
  .floating-follow .sticky-btn:hover { transform: scale(1.04); box-shadow: 0 12px 28px rgba(245,166,35,0.58); }

  @supports not (backdrop-filter: blur(1px)) {
    .hero-badge,
    .btn-ghost,
    .metric-chip,
    .quick-card,
    .glass-section,
    .sticky-pill {
      background: rgba(255,255,255,0.92);
    }
    .btn-ghost, .hero-badge, .sticky-pill { color: #1A2E20; }
  }

  @media (max-width: 1100px) {
    .hero { padding: 28px 22px; min-height: 280px; }
    .hero-right { width: 100%; }
    .metric-chip { flex: 1; }
    .quick-stats { grid-template-columns: 1fr; }
    .tips-grid { grid-template-columns: 1fr; }
    .floating-follow { right: 106px; bottom: 16px; }
  }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @media (prefers-reduced-motion: reduce) {
    * { transition: none !important; animation: none !important; }
    .hero, .back-link, .quick-card, .glass-section, .tip-card { opacity: 1 !important; transform: none !important; }
    .floating-follow { transition: none !important; }
  }

  [data-theme='dark'] body {
    background: linear-gradient(160deg, #0b1220 0%, #0f172a 55%, #111827 100%);
  }
  [data-theme='dark'] .regime-page {
    color: #e5e7eb;
  }
  [data-theme='dark'] .quick-card,
  [data-theme='dark'] .glass-section,
  [data-theme='dark'] .tip-card {
    background: linear-gradient(145deg, rgba(30,41,59,0.75), rgba(15,23,42,0.7)) !important;
    border-color: rgba(148,163,184,0.25) !important;
    box-shadow: 0 12px 28px rgba(0,0,0,0.30), 0 1px 2px rgba(0,0,0,0.25) !important;
  }
  [data-theme='dark'] .quick-label,
  [data-theme='dark'] .section-text,
  [data-theme='dark'] .tip-card p,
  [data-theme='dark'] .restriction-item span:last-child {
    color: #cbd5e1 !important;
  }
  [data-theme='dark'] .quick-value,
  [data-theme='dark'] .head-title,
  [data-theme='dark'] .tip-card h4 {
    color: #e5e7eb !important;
  }
  [data-theme='dark'] .restrictions-box {
    background: linear-gradient(135deg, rgba(127,29,29,0.24), rgba(69,10,10,0.22)) !important;
    border-color: rgba(248,113,113,0.25) !important;
  }
  [data-theme='dark'] .restriction-item {
    border-bottom-color: rgba(248,113,113,0.24) !important;
  }
  [data-theme='dark'] .restrictions-title {
    color: #f87171 !important;
  }
  [data-theme='dark'] .section-text [style*="color:#ef4444"] {
    color: #fca5a5 !important;
  }
</style>

<div class="regime-blob a"></div>
<div class="regime-blob b"></div>

<div class="regime-page">
  <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="back-link">
    <i data-lucide="arrow-left" style="width:14px;height:14px"></i> Retour aux régimes
  </a>

  <section class="hero" id="heroCard">
    <div class="hero-overlay"></div>
    <div class="hero-c1"></div>
    <div class="hero-c2"></div>
    <div class="hero-c3"></div>
    <div class="hero-dots">
      <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <pattern id="d" width="22" height="22" patternUnits="userSpaceOnUse">
            <circle cx="1.5" cy="1.5" r="1" fill="rgba(255,255,255,0.05)"/>
          </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#d)"/>
      </svg>
    </div>
    <div class="hero-watermark"><?= $watermark ?></div>

    <div class="hero-left">
      <div class="hero-badge">
        <span class="hero-badge-dot"></span>
        <?= strtoupper($lbl) ?>
      </div>
      <h1 class="hero-name"><?= htmlspecialchars($regime['nom']) ?></h1>

      <div class="hero-meta">
        <span><i data-lucide="user" style="width:14px;height:14px"></i> Proposé par <?= htmlspecialchars($regime['soumis_par']) ?></span>
        <span><i data-lucide="calendar-days" style="width:14px;height:14px"></i> Ajouté le <?= date('d/m/Y', strtotime($regime['created_at'])) ?></span>
      </div>

      <div class="hero-actions">
        <a href="<?= htmlspecialchars($followRegimeUrl) ?>" class="btn-main js-main-follow-trigger">⊕ Suivre ce régime</a>
        <button type="button" class="btn-ghost js-share-btn" data-share-title="<?= htmlspecialchars($regime['nom']) ?>" data-share-text="Découvrez ce régime GreenBite">↗ Partager</button>
      </div>
    </div>

    <div class="hero-right">
      <div class="metric-chip">
        <div class="metric-value" id="weeksCounter" data-target="<?= $weeks ?>">0</div>
        <div class="metric-label">Semaines</div>
      </div>
      <div class="metric-chip">
        <div class="metric-value gold" id="kcalCounter" data-target="<?= $calories ?>">0</div>
        <div class="metric-label">Kcal / Jour</div>
      </div>
    </div>
  </section>

  <section class="quick-stats">
    <div class="quick-card js-stat">
      <div class="quick-label">📅 Durée totale</div>
      <div class="quick-value"><?= $weeks ?> semaines</div>
    </div>
    <div class="quick-card js-stat">
      <div class="quick-label">🔥 Calories journalières</div>
      <div class="quick-value" style="color:#F5A623"><?= number_format($calories) ?> kcal/j</div>
    </div>
    <div class="quick-card js-stat">
      <div class="quick-label">🎯 Objectif</div>
      <div class="quick-value" style="color:<?= $accent ?>;font-size:20px;"><?= $lbl ?></div>
    </div>
  </section>

  <section class="glass-section js-reveal" id="detailsSection">
    <div class="section-head">
      <div class="head-icon">ℹ</div>
      <div class="head-title">Détails et Principes</div>
      <div class="head-line"></div>
    </div>
    <?php if ($descIsLong): ?>
      <div id="descText" class="section-text collapsed"><?= htmlspecialchars($description) ?></div>
      <button class="read-more-btn" id="toggleDescBtn">... Lire la suite</button>
    <?php else: ?>
      <div class="section-text"><?= htmlspecialchars($description !== '' ? $description : 'Aucune description fournie.') ?></div>
    <?php endif; ?>
  </section>

  <section class="glass-section js-reveal" id="restrictionsSection">
    <div class="section-head">
      <div class="head-icon restrictions-icon">🛡</div>
      <div class="head-title restrictions-title">Restrictions</div>
      <div class="head-line restrictions-line"></div>
    </div>
    <div class="restrictions-box">
      <?php if (!empty($restrictionsList)): ?>
        <?php foreach ($restrictionsList as $restriction): ?>
          <div class="restriction-item"><span style="color:#E74C3C;font-size:14px;">✗</span><span><?= htmlspecialchars($restriction) ?></span></div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="ok-text">✓ Aucune restriction particulière</div>
      <?php endif; ?>
    </div>
  </section>

  <section class="glass-section js-reveal" id="tipsSection">
    <div class="section-head">
      <div class="head-icon">💡</div>
      <div class="head-title">Conseils pour réussir</div>
      <div class="head-line"></div>
    </div>
    <div class="tips-grid">
      <article class="tip-card js-tip">
        <h4 class="tip-title">💧 Hydratation</h4>
        <p class="tip-text">Buvez 2L d'eau par jour pour optimiser les résultats</p>
      </article>
      <article class="tip-card js-tip">
        <h4 class="tip-title">😴 Sommeil</h4>
        <p class="tip-text">Dormez 8h par nuit pour stabiliser l'énergie et améliorer la récupération.</p>
      </article>
      <article class="tip-card js-tip">
        <h4 class="tip-title">🥗 Régularité</h4>
        <p class="tip-text">Maintenez des horaires de repas constants pour mieux gérer l'appétit.</p>
      </article>
    </div>
  </section>

  <?php if (($regime['statut'] === 'refuse' || $regime['statut'] === 'en_attente') && ($_SESSION['regime_user'] ?? '') === $regime['soumis_par']): ?>
    <section class="glass-section js-reveal">
      <div class="section-head" style="margin-bottom:14px">
        <div class="head-icon" style="background:linear-gradient(135deg,#64748b,#334155);box-shadow:0 4px 12px rgba(51,65,85,0.3)">⚙</div>
        <div class="head-title">Gérer mon régime</div>
        <div class="head-line"></div>
      </div>
      <?php if ($regime['statut'] === 'refuse' && !empty($regime['commentaire_admin'])): ?>
        <div style="background:rgba(255,255,255,0.72);padding:1rem;border-radius:12px;border-left:3px solid #ef4444;margin-bottom:1rem;font-size:13px;color:#4b5563">
          <strong style="color:#ef4444;display:block;margin-bottom:0.2rem">Motif de refus :</strong>
          <?= htmlspecialchars($regime['commentaire_admin']) ?>
        </div>
      <?php endif; ?>
      <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-edit&id=<?= $regime['id'] ?>" class="btn btn-primary" style="border-radius:999px;display:inline-flex;align-items:center;gap:6px;">
        <i data-lucide="edit-3" style="width:14px;height:14px"></i> Modifier la proposition
      </a>
    </section>
  <?php endif; ?>
</div>

<div class="floating-follow" id="floatingFollowRegime">
  <a href="<?= htmlspecialchars($followRegimeUrl) ?>" class="sticky-btn">Suivre ce régime</a>
</div>

<script>
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function animateNumber(element, target, duration) {
    if (!element) return;
    if (reduceMotion) {
      element.textContent = Number(target).toLocaleString('fr-FR');
      return;
    }
    const start = performance.now();
    const easeOutExpo = (x) => (x === 1 ? 1 : 1 - Math.pow(2, -10 * x));
    const tick = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = easeOutExpo(progress);
      element.textContent = Math.round(target * eased).toLocaleString('fr-FR');
      if (progress < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  }

  const weeksCounter = document.getElementById('weeksCounter');
  const kcalCounter = document.getElementById('kcalCounter');
  animateNumber(weeksCounter, Number(weeksCounter?.dataset.target || 0), 1000);
  animateNumber(kcalCounter, Number(kcalCounter?.dataset.target || 0), 1400);

  const statCards = document.querySelectorAll('.js-stat');
  if (reduceMotion) {
    statCards.forEach((card) => card.classList.add('show'));
  } else {
    statCards.forEach((card, index) => {
      setTimeout(() => card.classList.add('show'), index * 80);
    });
  }

  const revealSections = document.querySelectorAll('.js-reveal');
  const tipCards = document.querySelectorAll('.js-tip');
  if (reduceMotion) {
    revealSections.forEach((el) => el.classList.add('show'));
    tipCards.forEach((el) => el.classList.add('show'));
  } else {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        if (el.id === 'detailsSection') {
          el.classList.add('show');
        } else if (el.id === 'restrictionsSection') {
          setTimeout(() => el.classList.add('show'), 100);
        } else if (el.id === 'tipsSection') {
          el.classList.add('show');
          tipCards.forEach((tip, idx) => setTimeout(() => tip.classList.add('show'), idx * 60));
        } else {
          el.classList.add('show');
        }
        observer.unobserve(el);
      });
    }, { threshold: 0.2 });
    revealSections.forEach((el) => observer.observe(el));
  }

  const floatingFollowRegime = document.getElementById('floatingFollowRegime');
  const mainRegimeFollowTrigger = document.querySelector('.js-main-follow-trigger');
  const setRegimeFloatingVisibility = (visible) => {
    floatingFollowRegime.classList.toggle('show', visible);
  };
  if (mainRegimeFollowTrigger && 'IntersectionObserver' in window) {
    const regimeFollowObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => setRegimeFloatingVisibility(!entry.isIntersecting));
    }, { threshold: 0.15 });
    regimeFollowObserver.observe(mainRegimeFollowTrigger);
  } else {
    const toggleFloatingFollowFallback = () => {
      setRegimeFloatingVisibility(window.scrollY > 80);
    };
    window.addEventListener('scroll', toggleFloatingFollowFallback);
    toggleFloatingFollowFallback();
  }

  const descText = document.getElementById('descText');
  const toggleDescBtn = document.getElementById('toggleDescBtn');
  if (descText && toggleDescBtn) {
    toggleDescBtn.addEventListener('click', () => {
      const collapsed = descText.classList.toggle('collapsed');
      toggleDescBtn.textContent = collapsed ? '... Lire la suite' : 'Réduire';
    });
  }

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

  if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
