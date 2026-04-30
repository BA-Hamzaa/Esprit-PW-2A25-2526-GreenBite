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
    'perte_poids'    => ['from'=>'#38A169','to'=>'#2F855A','bg'=>'rgba(56,161,105,0.08)'],
    'maintien'       => ['from'=>'#2C7A7B','to'=>'#285E61','bg'=>'rgba(44,122,123,0.10)'],
    'prise_masse'    => ['from'=>'#2F855A','to'=>'#276749','bg'=>'rgba(47,133,90,0.09)'],
    'sante_generale' => ['from'=>'#D53F8C','to'=>'#B83280','bg'=>'rgba(213,63,140,0.10)'],
];
?>

<div class="regimes-page-wrap" style="padding:2rem;position:relative;background:#f3f4f6">

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
          4 régimes approuvés
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-add" class="btn btn-primary" style="border-radius:var(--radius-full)">
      <i data-lucide="plus-circle" style="width:1rem;height:1rem"></i> ⊕ Créer un régime
    </a>
  </div>


  <!-- ============================================================
       AI REGIME GENERATOR
       ============================================================ -->
  <div id="ai-generator-section" class="card mb-6" style="padding:0;overflow:hidden;border:1.5px solid rgba(45,106,79,0.18);box-shadow:0 8px 32px rgba(45,106,79,0.08)">
    <!-- Header -->
    <div style="background:linear-gradient(110deg,#1B4332,#2D6A4F,#52B788);padding:1.25rem 1.75rem;display:flex;align-items:center;gap:1rem">
      <div style="display:flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:rgba(255,255,255,0.15);border-radius:0.875rem;flex-shrink:0">
        <span style="font-size:1.35rem;line-height:1">✨</span>
      </div>
      <div style="flex:1">
        <h2 style="color:#fff;font-family:var(--font-heading);font-weight:800;font-size:1.05rem;margin:0">Générateur de Régimes IA</h2>
        <p style="color:rgba(255,255,255,0.8);font-size:0.78rem;margin:0.2rem 0 0">Choisissez votre objectif — l'IA génère 3 régimes personnalisés instantanément</p>
      </div>
      <span style="padding:0.3rem 0.75rem;background:transparent;border:1px solid rgba(255,255,255,0.8);border-radius:999px;color:#fff;font-size:0.7rem;font-weight:700">POWERED BY AI</span>
    </div>

    <!-- Controls -->
    <div style="padding:1.25rem 1.75rem;background:linear-gradient(135deg,rgba(45,106,79,0.03),rgba(82,183,136,0.02));border-bottom:1px solid rgba(82,183,136,0.1)">
      <div style="display:flex;gap:0.875rem;align-items:flex-end;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
          <label style="display:block;font-size:0.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem">
            <i data-lucide="heart" style="width:0.8rem;height:0.8rem;display:inline;vertical-align:middle;margin-right:0.3rem"></i>
            Objectif du régime
          </label>
          <select id="ai-goal-select" style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-xl);font-size:0.875rem;background:var(--surface);color:var(--text-primary);outline:none;cursor:pointer;transition:border-color 0.2s" onfocus="this.style.borderColor='#52B788'" onblur="this.style.borderColor='var(--border)'">
            <option value="perte_poids">Perte de poids</option>
            <option value="prise_masse">Prise de masse</option>
            <option value="maintien">Maintien du poids</option>
            <option value="sante_generale" selected>❤️ Santé générale & bien-être</option>
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
          <span style="font-size:0.95rem;line-height:1">⚡</span>
          Générer
        </button>
      </div>
    </div>

    <!-- Results -->
    <div id="ai-results" style="padding:1.25rem 1.75rem;display:none">
      <div id="ai-loading" style="display:none;padding:0.75rem 0">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1rem">
          <div class="ai-skeleton-card"></div>
          <div class="ai-skeleton-card"></div>
          <div class="ai-skeleton-card"></div>
        </div>
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

  .ai-skeleton-card {
    height: 230px;
    border-radius: 1rem;
    border: 1px solid #e5e7eb;
    background:
      linear-gradient(100deg, rgba(255,255,255,0) 30%, rgba(255,255,255,0.72) 50%, rgba(255,255,255,0) 70%) #f3f4f6;
    background-size: 240% 100%;
    animation: skeletonShimmer 1.2s ease-in-out infinite;
  }
  @keyframes skeletonShimmer { to { background-position: -140% 0; } }

  /* ===== Regime Cards ===== */
  @keyframes regimeCardIn {
    from { opacity:0; transform:translateY(24px) scale(0.97); }
    to   { opacity:1; transform:none; }
  }
  .regime-card {
    position:relative;
    background:var(--card);
    border-radius:1.375rem;
    overflow:hidden;
    border:1px solid #e5e7eb;
    transition:transform 0.32s cubic-bezier(.22,1,.36,1), box-shadow 0.32s ease;
    display:flex;
    flex-direction:column;
    text-decoration:none;
    cursor:pointer;
    animation: regimeCardIn 0.45s ease both;
  }
  .regime-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(0,0,0,0.10);
    border-color: #d1d5db;
  }
  .regime-card:hover .regime-accent-bar::after {
    opacity:1;
  }
  .regime-accent-bar {
    height:5px;
    position:relative;
    overflow:hidden;
  }
  .regime-accent-bar::after {
    content:'';
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.45) 50%,rgba(255,255,255,0) 100%);
    opacity:0;
    transform:translateX(-100%);
    animation:shimmer 1.6s ease infinite;
    transition:opacity 0.3s;
  }
  @keyframes shimmer{to{transform:translateX(200%)}}
  .regime-stat-box {
    background:var(--muted);
    border-radius:0.875rem;
    padding:0.7rem 0.875rem;
    text-align:center;
    transition:background 0.25s;
  }
  .regime-week-value { color:#0f172a; }
  .regime-kcal-value { color:#DD6B20; }
  .regime-card:hover .regime-stat-box {
    background:#f5f5f4;
  }
  .regime-cta-strip {
    border-top:1px solid var(--border);
    padding:0.7rem 1.25rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:#fafaf9;
    transition:background 0.25s;
  }
  .regime-card:hover .regime-cta-strip {
    background:#f5f5f4;
  }
  .regime-arrow {
    width:1.75rem;
    height:1.75rem;
    border-radius:50%;
    background:var(--border);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    transition:all 0.25s;
    flex-shrink:0;
  }
  .regime-card:hover .regime-arrow {
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    transform:translateX(3px);
    box-shadow:0 4px 12px rgba(45,106,79,0.3);
  }
  .regime-card:hover .regime-arrow svg {
    stroke:#fff;
  }
  .regime-filters {
    display:flex;
    align-items:center;
    gap:0.55rem;
    flex-wrap:wrap;
    margin-bottom:1.25rem;
  }
  .regime-filter-btn {
    border:1px solid #d1d5db;
    background:#fff;
    color:#374151;
    border-radius:999px;
    padding:0.4rem 0.85rem;
    font-size:0.72rem;
    font-weight:700;
    cursor:pointer;
    transition:all 0.2s;
  }
  .regime-filter-btn:hover { border-color:#9ca3af; }
  .regime-filter-btn.active {
    background:linear-gradient(135deg,#2D6A4F,#52B788);
    border-color:transparent;
    color:#fff;
    box-shadow:0 5px 14px rgba(45,106,79,0.25);
  }
  .regimes-hero{
    border-radius:8px;
    overflow:hidden;
    border:1px solid rgba(45,106,79,0.25);
    background:
      linear-gradient(105deg,rgba(7,22,14,0.75),rgba(20,54,37,0.55)),
      url('https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
    padding:1.1rem 1.25rem;
    margin:0 0 1rem 0;
  }
  .regimes-hero-chip{
    display:inline-flex;align-items:center;gap:0.35rem;
    border-radius:999px;padding:0.2rem 0.55rem;
    background:rgba(255,255,255,0.14);color:#ecfdf5;font-size:0.68rem;font-weight:700;
  }
  [data-theme='dark'] .regime-stat-box {
    background:#252B3B !important;
    border:1px solid rgba(255,255,255,0.06);
  }
  [data-theme='dark'] .regime-card:hover .regime-stat-box {
    background:#2A3145 !important;
  }
  [data-theme='dark'] .regime-week-value { color:#F0F4FF !important; }
  [data-theme='dark'] .regime-kcal-value { color:#FFB347 !important; }
  [data-theme='dark'] .regimes-page-wrap { background:#0F1117 !important; }
  [data-theme='dark'] .regime-card {
    background:#1A1F2E;
    border-color:rgba(255,255,255,0.08);
  }
  [data-theme='dark'] .regime-card:hover {
    border-color:rgba(61,220,132,0.35);
    box-shadow:none;
  }
  [data-theme='dark'] .regime-cta-strip {
    background:#1A1F2E;
    border-top-color:rgba(255,255,255,0.08);
  }
  [data-theme='dark'] .regime-card:hover .regime-cta-strip { background:#1E2537; }
  [data-theme='dark'] .regime-filter-btn {
    background:transparent;
    color:#8B92A9;
    border-color:rgba(255,255,255,0.12);
  }
  [data-theme='dark'] .regime-filter-btn:hover { border-color:#3DDC84; color:#F0F4FF; }
  [data-theme='dark'] .regime-filter-btn.active {
    background:#3DDC84;
    color:#0f1f17;
    border-color:#3DDC84;
    box-shadow:none;
  }
  </style>

  <div class="regimes-hero">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap">
      <div>
        <h3 style="margin:0;color:#f8fffb;font-family:var(--font-heading);font-size:1.05rem;font-weight:800">
          Inspiration du jour: Assiette saine et colorée
        </h3>
        <p style="margin:0.2rem 0 0;color:rgba(236,253,245,0.88);font-size:0.78rem">
          Trouvez un régime qui correspond à votre objectif, vos goûts et votre rythme.
        </p>
      </div>
      <span class="regimes-hero-chip"><i data-lucide="sparkles" style="width:0.75rem;height:0.75rem"></i> Fresh Balance</span>
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

    <div class="regime-filters">
      <button class="regime-filter-btn active" data-filter="all">Tous</button>
      <button class="regime-filter-btn" data-filter="sante_generale">Santé Générale</button>
      <button class="regime-filter-btn" data-filter="maintien">Maintien du Poids</button>
      <button class="regime-filter-btn" data-filter="perte_poids">Perte de Poids</button>
      <button class="regime-filter-btn" data-filter="prise_masse">Prise de Masse</button>
    </div>

    <!-- Regime Cards Grid -->
    <div id="regime-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(310px,1fr));gap:1.4rem;margin-top:0.5rem">
      <?php foreach ($regimes as $idx => $regime):
        $obj    = $regime['objectif'];
        $lbl    = $objectifLabels[$obj]  ?? $obj;
        $ico    = $objectifIcons[$obj]   ?? 'target';
        $colors = $objectifColors[$obj]  ?? ['from'=>'#52B788','to'=>'#2D6A4F','bg'=>'rgba(82,183,136,0.08)'];
        // Clamp calories for a visual progress bar (500–4000 range)
        $caloriePct = min(100, max(8, round(((int)$regime['calories_jour'] - 500) / 35)));
      ?>
        <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-detail&id=<?= $regime['id'] ?>"
           class="regime-card searchable-regime regime-card-item"
           data-goal="<?= htmlspecialchars($obj) ?>"
           style="animation-delay:<?= $idx * 0.07 ?>s">

          <!-- Accent bar with gradient -->
          <div class="regime-accent-bar"
               style="background:linear-gradient(90deg,<?= $colors['from'] ?>,<?= $colors['to'] ?>)"></div>

          <!-- Card Body -->
          <div style="padding:1.625rem 1.5rem;flex:1;display:flex;flex-direction:column;gap:1.125rem">

            <!-- Header: icon + title + badge -->
            <div style="display:flex;align-items:flex-start;gap:1rem">
              <div style="width:3rem;height:3rem;border-radius:1rem;background:linear-gradient(135deg,<?= $colors['from'] ?>22,<?= $colors['from'] ?>11);border:1.5px solid <?= $colors['from'] ?>33;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px <?= $colors['from'] ?>22">
                <i data-lucide="<?= $ico ?>" style="width:1.375rem;height:1.375rem;color:<?= $colors['from'] ?>"></i>
              </div>
              <div style="flex:1;min-width:0">
                <h3 style="font-family:var(--font-heading);font-weight:800;color:var(--text-primary);font-size:1.05rem;line-height:1.3;margin-bottom:0.35rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($regime['nom']) ?></h3>
                <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.67rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:<?= $colors['from'] ?>;background:<?= $colors['bg'] ?>;padding:0.2rem 0.6rem;border-radius:999px;border:1px solid <?= $colors['from'] ?>33">
                  <i data-lucide="<?= $ico ?>" style="width:0.6rem;height:0.6rem"></i>
                  <?= $lbl ?>
                </span>
              </div>
            </div>

            <!-- Description -->
            <?php if (!empty($regime['description'])): ?>
              <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.65;flex:1;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden"><?= htmlspecialchars(mb_substr($regime['description'], 0, 160)) ?><?= mb_strlen($regime['description']) > 160 ? '…' : '' ?></p>
            <?php else: ?>
              <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.65;font-style:italic">Aucune description disponible.</p>
            <?php endif; ?>

            <!-- Stats Row -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
              <div class="regime-stat-box">
                <div class="regime-week-value" style="font-family:var(--font-heading);font-size:1.5rem;font-weight:900;line-height:1"><?= (int)$regime['duree_semaines'] ?></div>
                <div style="font-size:0.62rem;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-top:0.2rem">Semaines</div>
              </div>
              <div class="regime-stat-box">
                <div class="regime-kcal-value" style="font-family:var(--font-heading);font-size:1.5rem;font-weight:900;line-height:1"><?= number_format((int)$regime['calories_jour']) ?></div>
                <div style="font-size:0.62rem;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-top:0.2rem">kcal / jour</div>
              </div>
            </div>

            <!-- Calorie visual bar -->
            <div style="background:var(--muted);border-radius:999px;height:4px;overflow:hidden">
              <div style="height:100%;width:<?= $caloriePct ?>%;background:linear-gradient(90deg,<?= $colors['from'] ?>,<?= $colors['to'] ?>);border-radius:999px;transition:width 0.6s ease"></div>
            </div>

            <!-- Restrictions -->
            <div style="display:flex;align-items:center;gap:0.45rem;background:<?= $colors['bg'] ?>;border:1px solid <?= $colors['from'] ?>22;border-radius:999px;padding:0.35rem 0.7rem;max-width:max-content">
              <i data-lucide="leaf" style="width:0.8rem;height:0.8rem;color:<?= $colors['from'] ?>"></i>
              <span style="font-size:0.72rem;color:var(--text-secondary);line-height:1.4"><?= htmlspecialchars(mb_substr(($regime['restrictions'] ?? 'fddFAfDDF'), 0, 24)) ?></span>
            </div>

          </div>

          <!-- CTA Footer -->
          <div class="regime-cta-strip">
            <div style="display:flex;align-items:center;gap:0.5rem">
              <div style="width:1.8rem;height:1.8rem;border-radius:50%;background:linear-gradient(135deg,<?= $colors['from'] ?>,<?= $colors['to'] ?>);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:0.72rem;font-weight:800">
                <?= strtoupper(substr(trim((string)($regime['soumis_par'] ?? 'U')), 0, 1)) ?>
              </div>
              <div>
                <div style="font-size:0.72rem;font-weight:600;color:var(--text-primary)">Utilisateur Inconnu</div>
                <div style="font-size:0.62rem;color:var(--text-muted)"><?= date('d/m/Y', strtotime($regime['created_at'])) ?></div>
              </div>
            </div>
            <div class="regime-arrow">
              <svg style="width:0.8rem;height:0.8rem;stroke:var(--text-muted);fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;transition:stroke 0.25s" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
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
  var filterButtons = document.querySelectorAll('.regime-filter-btn');
  var cards = document.querySelectorAll('.regime-card-item');
  var activeFilter = 'all';

  function applyFilters() {
    var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    cards.forEach(function(card) {
      var matchesSearch = card.textContent.toLowerCase().includes(query);
      var matchesFilter = activeFilter === 'all' || card.dataset.goal === activeFilter;
      card.style.display = (matchesSearch && matchesFilter) ? 'flex' : 'none';
    });
  }

  filterButtons.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterButtons.forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      activeFilter = btn.dataset.filter;
      applyFilters();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', function() {
      applyFilters();
    });
    applyFilters();
  } else {
    applyFilters();
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
  btn.innerHTML = '<span style="font-size:0.95rem;line-height:1">⚡</span> G\u00e9n\u00e9rer';
}

function aiEsc(t) {
  if (!t) return '';
  return String(t).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
