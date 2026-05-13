<?php /* stats.php — Full Analytics Dashboard */ ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap');
.db-wrap{padding:2rem}
.section-title{display:flex;align-items:center;gap:.6rem;margin-bottom:1.25rem;margin-top:1.75rem}
.section-title span{display:block;width:4px;height:1.25rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px}
.section-title h2{font-family:var(--font-heading);font-size:1.05rem;font-weight:800;color:var(--text-primary);margin:0}
/* ===== STUNNING VERCEL/LINEAR KPI CARDS ===== */
.kpi-card {
  position: relative;
  background: rgba(255, 255, 255, 0.65);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border-radius: 1rem;
  padding: 0.85rem 1rem;
  border: 1px solid rgba(255, 255, 255, 0.8);
  box-shadow: 0 4px 16px -4px rgba(0,0,0,0.04), inset 0 0 0 1px rgba(255,255,255,0.5);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  z-index: 1;
}

.kpi-card::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, var(--k-bg), transparent 70%);
  opacity: 0.6;
  z-index: -1;
  transition: opacity 0.3s ease;
}

.kpi-card:hover {
  transform: translateY(-4px) scale(1.01);
  box-shadow: 0 16px 32px -8px var(--k-glow), inset 0 0 0 1px rgba(255,255,255,0.9);
  border-color: rgba(255,255,255,1);
}

.kpi-card:hover::before {
  opacity: 1;
}

.kpi-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.5rem;
}

.kpi-icon {
  width: 2.5rem; height: 2.5rem;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  background: rgba(255, 255, 255, 0.9);
  color: var(--k-color);
  box-shadow: 0 0 12px var(--k-glow), inset 0 0 0 1px rgba(255,255,255,1);
  position: relative;
}

.kpi-icon::after {
  content: '';
  position: absolute;
  inset: -2px;
  border-radius: 50%;
  background: var(--k-color);
  opacity: 0.2;
  filter: blur(6px);
  z-index: -1;
}

.kpi-icon i { width: 1.15rem; height: 1.15rem; stroke-width: 2.25; }

.kpi-link {
  font-family: 'Outfit', sans-serif;
  font-size: 0.7rem; font-weight: 700; color: var(--k-color); text-decoration: none;
  background: rgba(255,255,255,0.9); padding: 0.3rem 0.75rem; border-radius: 999px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05);
  opacity: 0; transform: translateY(-6px);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  backdrop-filter: blur(8px);
}

.kpi-card:hover .kpi-link {
  opacity: 1; transform: translateY(0);
}

.kpi-link:hover {
  background: var(--k-color); color: #fff;
}

.kpi-val {
  font-family: 'Outfit', sans-serif;
  font-size: 1.55rem; font-weight: 800; color: #0f172a; line-height: 1; letter-spacing: -0.02em;
  margin-bottom: 0.15rem;
}

.kpi-label { font-family: 'Outfit', sans-serif; font-size: 0.75rem; font-weight: 600; color: #475569; }

.kpi-sub { 
  font-family: 'Outfit', sans-serif;
  font-size: 0.65rem; font-weight: 700; color: var(--k-color); margin-top: 0.45rem; 
  display: inline-flex; align-items: center; gap: 0.25rem; 
  background: var(--k-bg); padding: 0.2rem 0.5rem; border-radius: 0.35rem; 
  box-shadow: 0 2px 6px var(--k-glow);
  align-self: flex-start;
}

/* Dark mode */
[data-theme="dark"] .kpi-card { 
  background: rgba(15, 23, 42, 0.6); 
  border-color: rgba(255,255,255,0.08); 
  box-shadow: 0 8px 32px -8px rgba(0,0,0,0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
}
[data-theme="dark"] .kpi-card::before {
  background: linear-gradient(135deg, var(--k-glow), transparent 60%);
  opacity: 0.15;
}
[data-theme="dark"] .kpi-card:hover::before {
  opacity: 0.35;
}
[data-theme="dark"] .kpi-card:hover { 
  border-color: rgba(255,255,255,0.25); 
  box-shadow: 0 24px 48px -12px var(--k-glow), inset 0 0 0 1px rgba(255,255,255,0.15);
}
[data-theme="dark"] .kpi-icon { 
  background: rgba(30, 41, 59, 0.9); 
  box-shadow: 0 0 24px var(--k-glow), inset 0 0 0 1px rgba(255,255,255,0.1);
}
[data-theme="dark"] .kpi-val { color: #f8fafc; }
[data-theme="dark"] .kpi-label { color: #cbd5e1; }
[data-theme="dark"] .kpi-sub { background: rgba(0,0,0,0.4); box-shadow: none; }
[data-theme="dark"] .kpi-link { background: rgba(30, 41, 59, 0.9); color: #f8fafc; box-shadow: 0 4px 12px rgba(0,0,0,0.4); }
[data-theme="dark"] .kpi-link:hover { background: var(--k-color); color: #fff; }
/* Charts & recent */
.chart-card{
  background:#fff;
  border-radius:14px;
  padding:1.25rem 1.35rem;
  border:1px solid #e2e8f0;
  box-shadow:0 1px 8px rgba(0,0,0,.06);
}
[data-theme="dark"] .chart-card{
  background:#1e293b;
  border-color:rgba(255,255,255,.07);
  box-shadow:0 4px 20px rgba(0,0,0,.3);
}
.chart-title{
  font-weight:700;
  font-size:.875rem;
  color:#0f172a;
  display:flex;
  align-items:center;
  gap:.5rem;
  margin-bottom:1rem;
}
[data-theme="dark"] .chart-title{color:#f1f5f9;}
.recent-row{display:flex;align-items:center;justify-content:space-between;padding:.55rem .75rem;border-radius:.625rem;transition:background .2s}
.recent-row:hover{background:rgba(0,0,0,.04)}
[data-theme="dark"] .recent-row:hover{background:rgba(255,255,255,.05)}
.badge-sm{padding:.18rem .55rem;border-radius:999px;font-size:.67rem;font-weight:700}
/* --- Analytics hero : mesh visible (no blend-mode tricks — works everywhere) --- */
.db-hero{
  position:relative;
  overflow:hidden;
  border-radius:1.25rem;
  margin-bottom:1.75rem;
  padding:1.65rem 2rem;
  color:#fff;
  /* Base + 3 “spotlights” baked in — always visible */
  background-color:#0d2818;
  background-image:
    radial-gradient(ellipse 120% 90% at 100% 0%,rgba(134,239,172,.55) 0%,transparent 52%),
    radial-gradient(ellipse 100% 80% at 0% 100%,rgba(45,212,191,.38) 0%,transparent 55%),
    radial-gradient(ellipse 60% 70% at 55% 35%,rgba(255,255,255,.14) 0%,transparent 48%),
    linear-gradient(145deg,#0a1f14 0%,#143828 22%,#1a4a2e 48%,#1f6b48 78%,#267a52 100%);
  border:1px solid rgba(255,255,255,.2);
  box-shadow:
    0 0 0 1px rgba(0,0,0,.2) inset,
    0 2px 0 rgba(255,255,255,.18) inset,
    0 -2px 12px rgba(0,0,0,.25) inset,
    0 24px 56px -14px rgba(8,40,25,.55),
    0 12px 32px rgba(26,90,60,.35),
    0 0 80px -20px rgba(52,211,153,.35);
}
.db-hero::before{
  content:"";
  position:absolute;
  inset:0;
  background-image:radial-gradient(rgba(255,255,255,.075) 1px,transparent 1px);
  background-size:24px 24px;
  opacity:.7;
  pointer-events:none;
  z-index:1;
  mask-image:linear-gradient(180deg,rgba(0,0,0,.95) 0%,transparent 75%);
}
.db-hero__glow{
  position:absolute;
  border-radius:50%;
  pointer-events:none;
  z-index:0;
  /* Normal blend + strong colours — actually shows on screen */
  opacity:1;
  filter:blur(40px);
  will-change:transform;
}
.db-hero__glow--a{
  width:280px;height:280px;
  top:-100px;right:-80px;
  background:rgba(110,231,183,.5);
  animation:db-hero-drift 12s ease-in-out infinite;
}
.db-hero__glow--b{
  width:240px;height:240px;
  bottom:-90px;left:-30px;
  background:rgba(45,212,191,.38);
  animation:db-hero-drift 16s ease-in-out infinite reverse;
}
.db-hero__glow--c{
  width:200px;height:200px;
  top:12%;right:14%;
  background:rgba(167,243,208,.34);
  filter:blur(52px);
  animation:db-hero-drift 20s ease-in-out infinite;
}
.db-hero__shine{
  position:absolute;
  top:0;left:0;right:0;height:52%;
  background:linear-gradient(185deg,rgba(255,255,255,.14) 0%,rgba(255,255,255,.04) 38%,transparent 72%);
  pointer-events:none;
  z-index:1;
  border-radius:1.25rem 1.25rem 0 0;
}
.db-hero__inner{
  position:relative;
  z-index:3;
  display:flex;
  flex-wrap:wrap;
  align-items:center;
  justify-content:space-between;
  gap:1.25rem 1.5rem;
}
.db-hero__left{
  display:flex;
  align-items:center;
  gap:1rem;
  min-width:0;
}
.db-hero__icon{
  flex-shrink:0;
  width:3.25rem;height:3.25rem;
  border-radius:1.05rem;
  display:flex;
  align-items:center;
  justify-content:center;
  background:linear-gradient(160deg,rgba(255,255,255,.38),rgba(255,255,255,.08));
  border:1px solid rgba(255,255,255,.45);
  box-shadow:
    inset 0 1px 0 rgba(255,255,255,.65),
    0 0 0 1px rgba(0,0,0,.12),
    0 12px 32px rgba(0,0,0,.25),
    0 0 28px rgba(110,231,183,.35);
  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);
}
.db-hero__icon i{color:#f0fdf4;filter:drop-shadow(0 2px 4px rgba(0,0,0,.35))}
.db-hero__title{
  font-family:var(--font-heading);
  font-size:1.4rem;
  font-weight:800;
  letter-spacing:-.035em;
  line-height:1.12;
  margin:0;
  text-shadow:0 2px 8px rgba(0,0,0,.2),0 1px 0 rgba(255,255,255,.08);
}
.db-hero__sub{
  margin:.35rem 0 0;
  font-size:.8125rem;
  font-weight:500;
  letter-spacing:.01em;
  color:rgba(255,255,255,.62);
  max-width:26rem;
}
.db-hero__right{
  display:flex;
  flex-wrap:wrap;
  align-items:center;
  justify-content:flex-end;
  gap:.65rem 1rem;
}
.db-hero__badge{
  display:inline-flex;
  align-items:center;
  gap:.45rem;
  padding:.45rem 1rem;
  font-size:.78rem;
  font-weight:600;
  letter-spacing:.02em;
  color:#fff;
  background:linear-gradient(180deg,rgba(255,255,255,.22),rgba(255,255,255,.08));
  border:1px solid rgba(255,255,255,.38);
  border-radius:999px;
  backdrop-filter:blur(14px);
  -webkit-backdrop-filter:blur(14px);
  box-shadow:
    0 6px 20px rgba(0,0,0,.18),
    inset 0 1px 0 rgba(255,255,255,.35),
    0 0 24px rgba(74,222,128,.15);
}
.db-hero__dot{
  width:8px;height:8px;
  border-radius:50%;
  background:#4ade80;
  box-shadow:0 0 0 0 rgba(74,222,128,.55),0 0 12px rgba(74,222,128,.65);
  animation:db-hero-pulse 2.2s ease-in-out infinite;
}
.db-hero__time{
  font-family:'DM Sans', var(--font-body);
  font-size:.88rem;
  font-weight:600;
  font-variant-numeric:tabular-nums;
  letter-spacing:.02em;
  color:rgba(255,255,255,.95);
  white-space:nowrap;
  text-shadow:0 1px 2px rgba(0,0,0,.25);
}
@keyframes db-hero-drift{
  0%,100%{transform:translate(0,0) scale(1);}
  50%{transform:translate(14px,-10px) scale(1.08);}
}
@keyframes db-hero-pulse{
  0%,100%{transform:scale(1);box-shadow:0 0 0 0 rgba(74,222,128,.45),0 0 10px rgba(74,222,128,.55);}
  50%{transform:scale(1.12);box-shadow:0 0 0 7px rgba(74,222,128,0),0 0 16px rgba(74,222,128,.45);}
}
@media (max-width:768px){
  .db-hero{padding:1.35rem 1.35rem;border-radius:1rem}
  .db-hero__title{font-size:1.2rem}
  .db-hero__inner{flex-direction:column;align-items:stretch}
  .db-hero__right{justify-content:space-between}
}
@media (max-width:900px){
  .kpi{grid-template-columns:1fr;grid-template-rows:minmax(6.5rem,22vw) auto}
  .kpi-media{min-height:6.5rem}
  .kpi-media::after{background:linear-gradient(180deg,rgba(0,0,0,.1) 0%,transparent 50%,rgba(255,255,255,.06) 100%)}
}
</style>


<div class="db-wrap">
<!-- ===== HERO ===== -->
<div class="db-hero" role="region" aria-label="En-tête du tableau de bord analytique">
  <span class="db-hero__shine" aria-hidden="true"></span>
  <span class="db-hero__glow db-hero__glow--a" aria-hidden="true"></span>
  <span class="db-hero__glow db-hero__glow--b" aria-hidden="true"></span>
  <span class="db-hero__glow db-hero__glow--c" aria-hidden="true"></span>
  <div class="db-hero__inner">
    <div class="db-hero__left">
      <div class="db-hero__icon" aria-hidden="true"><i data-lucide="bar-chart-3" style="width:1.45rem;height:1.45rem"></i></div>
      <div>
        <h1 class="db-hero__title">Tableau de bord analytique</h1>
        <p class="db-hero__sub">Toutes les métriques GreenBite · Temps réel</p>
      </div>
    </div>
    <div class="db-hero__right">
      <span class="db-hero__badge"><span class="db-hero__dot" aria-hidden="true"></span>En ligne</span>
      <span class="db-hero__time"><?php $m=['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc']; echo date('d ').$m[(int)date('n')-1].' '.date('Y').' – '.date('H:i'); ?></span>
    </div>
  </div>
</div>

<!-- ===== STUNNING KPI GRID ===== -->
<div class="grid grid-cols-4 gap-4 mb-6">
  <?php
  $kpis = [
    // Row 1
    ['icon'=>'utensils-crossed','val'=>$statsRepas,'label'=>'Repas enregistrés','color'=>'#10b981','bg'=>'#d1fae5','glow'=>'rgba(16, 185, 129, 0.4)','link'=>'admin-nutrition'],
    ['icon'=>'package','val'=>$statsProduits,'label'=>'Produits actifs','color'=>'#f97316','bg'=>'#ffedd5','glow'=>'rgba(249, 115, 22, 0.4)','link'=>'admin-marketplace'],
    ['icon'=>'shopping-bag','val'=>$statsCommandes,'label'=>'Commandes totales','color'=>'#3b82f6','bg'=>'#dbeafe','glow'=>'rgba(59, 130, 246, 0.4)','link'=>'admin-marketplace&action=commandes'],
    ['icon'=>'chef-hat','val'=>$statsRecettes,'label'=>'Recettes publiées','color'=>'#8b5cf6','bg'=>'#ede9fe','glow'=>'rgba(139, 92, 246, 0.4)','link'=>'admin-recettes'],
    
    // Row 2
    ['icon'=>'message-square','val'=>$statsComments,'label'=>'Avis & Commentaires','sub'=>$statsComPending.' en attente','color'=>'#14b8a6','bg'=>'#ccfbf1','glow'=>'rgba(20, 184, 166, 0.4)'],
    ['icon'=>'clipboard-list','val'=>$statsPlans,'label'=>'Plans nutritionnels','sub'=>'Nutrition','color'=>'#f59e0b','bg'=>'#fef3c7','glow'=>'rgba(245, 158, 11, 0.4)'],
    ['icon'=>'salad','val'=>$statsRegimes,'label'=>'Régimes alimentaires','sub'=>'Suivis','color'=>'#ec4899','bg'=>'#fce7f3','glow'=>'rgba(236, 72, 153, 0.4)'],
    ['icon'=>'banknote','val'=>number_format($statsRevenue,2).' DT','label'=>'Chiffre d\'affaires','sub'=>'Moy. '.number_format($statsAvgOrder,2).' DT/cmd','color'=>'#6366f1','bg'=>'#e0e7ff','glow'=>'rgba(99, 102, 241, 0.4)'],
  ];

  foreach($kpis as $k): ?>
  <div class="kpi-card" style="--k-color: <?= $k['color'] ?>; --k-bg: <?= $k['bg'] ?>; --k-glow: <?= $k['glow'] ?>;">
    <div class="kpi-top">
      <div class="kpi-icon"><i data-lucide="<?= $k['icon'] ?>"></i></div>
      <?php if(isset($k['link'])): ?>
        <a href="<?= BASE_URL ?>/?page=<?= $k['link'] ?>" class="kpi-link">Voir →</a>
      <?php endif; ?>
    </div>
    
    <div class="kpi-val"><?= is_numeric($k['val']) ? number_format($k['val']) : $k['val'] ?></div>
    <div class="kpi-label"><?= $k['label'] ?></div>
    
    <?php if(isset($k['sub'])): ?>
      <div class="kpi-sub"><i data-lucide="activity" style="width:12px;height:12px"></i> <?= $k['sub'] ?></div>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>

<!-- ===== SECTION 1: MARKETPLACE ===== -->
<div class="section-title"><span></span><h2>📦 Marketplace — Ventes & Commandes</h2></div>
<div class="grid grid-cols-3 gap-5 mb-6">
  <!-- Revenue line -->
  <div class="chart-card" style="grid-column:span 2">
    <div class="chart-title"><i data-lucide="trending-up" style="width:.95rem;height:.95rem;color:#2563eb"></i> Chiffre d'affaires — 6 derniers mois</div>
    <canvas id="revenueChart" style="max-height:200px"></canvas>
  </div>
  <!-- Order status donut -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="shopping-bag" style="width:.95rem;height:.95rem;color:#3b82f6"></i> Statut commandes</div>
    <canvas id="commandesChart"></canvas>
  </div>
</div>
<div class="grid grid-cols-3 gap-5 mb-6">
  <!-- Top produits bar -->
  <div class="chart-card" style="grid-column:span 2">
    <div class="chart-title"><i data-lucide="award" style="width:.95rem;height:.95rem;color:#f97316"></i> Top 5 produits — quantités vendues</div>
    <canvas id="topProduitsChart" style="max-height:200px"></canvas>
  </div>
  <!-- Stock donut -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="archive" style="width:.95rem;height:.95rem;color:#ea580c"></i> État du stock</div>
    <canvas id="stockChart"></canvas>
  </div>
</div>
<div class="grid grid-cols-2 gap-5 mb-6">
  <!-- Produits by categorie -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="tag" style="width:.95rem;height:.95rem;color:#f97316"></i> Produits par catégorie</div>
    <canvas id="categoriesChart"></canvas>
  </div>
  <!-- Bio ratio -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="leaf" style="width:.95rem;height:.95rem;color:#16a34a"></i> Produits Bio vs Conventionnel</div>
    <canvas id="bioChart"></canvas>
  </div>
</div>

<!-- ===== SECTION 2: RECETTES ===== -->
<div class="section-title"><span></span><h2>🍽️ Recettes Durables — Analyse</h2></div>
<div class="grid grid-cols-3 gap-5 mb-6">
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="signal" style="width:.95rem;height:.95rem;color:#8b5cf6"></i> Par difficulté</div>
    <canvas id="difficulteChart"></canvas>
  </div>
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="layers" style="width:.95rem;height:.95rem;color:#ec4899"></i> Par catégorie</div>
    <canvas id="recetteCatChart"></canvas>
  </div>
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="leaf" style="width:.95rem;height:.95rem;color:#16a34a"></i> Score Carbone CO₂</div>
    <canvas id="carbonChart"></canvas>
  </div>
</div>
<div class="grid grid-cols-2 gap-5 mb-6">
  <!-- Comments by status -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="message-circle" style="width:.95rem;height:.95rem;color:#0891b2"></i> Commentaires par statut</div>
    <canvas id="commentsChart"></canvas>
  </div>
  <!-- Rating bar -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="star" style="width:.95rem;height:.95rem;color:#f59e0b"></i> Note moyenne par recette (top 6)</div>
    <canvas id="ratingChart" style="max-height:200px"></canvas>
  </div>
</div>

<!-- ===== SECTION 3: NUTRITION ===== -->
<div class="section-title"><span></span><h2>🥗 Nutrition & Plans Alimentaires</h2></div>
<div class="grid grid-cols-3 gap-5 mb-6">
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="flame" style="width:.95rem;height:.95rem;color:#f97316"></i> Calories moy. par type de repas</div>
    <canvas id="caloriesChart"></canvas>
  </div>
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="pie-chart" style="width:.95rem;height:.95rem;color:var(--primary)"></i> Macronutriments moyens</div>
    <canvas id="macrosChart"></canvas>
  </div>
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="clipboard-list" style="width:.95rem;height:.95rem;color:#059669"></i> Plans par objectif</div>
    <canvas id="plansChart"></canvas>
  </div>
</div>
<div class="grid grid-cols-2 gap-5 mb-6">
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="salad" style="width:.95rem;height:.95rem;color:#d97706"></i> Régimes par objectif</div>
    <canvas id="regimesChart" style="max-height:200px"></canvas>
  </div>
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="map-pin" style="width:.95rem;height:.95rem;color:#0891b2"></i> Ingrédients — Locaux vs Importés</div>
    <canvas id="ingredientsChart"></canvas>
  </div>
</div>

<!-- ===== SECTION 4: REPAS ===== -->
<div class="section-title"><span></span><h2>🍽️ Repas — Analyse Détaillée</h2></div>
<div class="grid grid-cols-2 gap-5 mb-6">
  <!-- Repas by status donut -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="check-circle" style="width:.95rem;height:.95rem;color:#10b981"></i> Repas par statut</div>
    <canvas id="repasStatutChart"></canvas>
  </div>
  <!-- Repas by type donut -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="utensils-crossed" style="width:.95rem;height:.95rem;color:#f97316"></i> Distribution par type de repas</div>
    <canvas id="repasTypeChart"></canvas>
  </div>
</div>
<div class="grid grid-cols-2 gap-5 mb-6">
  <!-- Top 5 aliments -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="apple" style="width:.95rem;height:.95rem;color:#ef4444"></i> Top 5 aliments les plus utilisés</div>
    <canvas id="topAlimChart" style="max-height:200px"></canvas>
  </div>
  <!-- Repas by day of week -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="calendar-days" style="width:.95rem;height:.95rem;color:#3b82f6"></i> Repas par jour de la semaine</div>
    <canvas id="repasDayChart" style="max-height:200px"></canvas>
  </div>
</div>

<!-- ===== RECENT ACTIVITY ===== -->
<div class="section-title"><span></span><h2>🕐 Activité Récente</h2></div>
<div class="grid grid-cols-3 gap-5 mb-2">
  <!-- Recent recipes -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="chef-hat" style="width:.95rem;height:.95rem;color:#8b5cf6"></i> Recettes récentes <a href="<?= BASE_URL ?>/?page=admin-recettes&action=list" style="margin-left:auto;font-size:.7rem;color:var(--secondary);font-weight:600;text-decoration:none">Voir →</a></div>
    <?php if(empty($recentRecettes)): ?><p style="color:var(--text-muted);font-size:.82rem;text-align:center;padding:.5rem">Aucune.</p><?php else: foreach($recentRecettes as $r): ?>
    <div class="recent-row"><div style="display:flex;align-items:center;gap:.6rem"><div style="width:1.85rem;height:1.85rem;border-radius:.5rem;background:linear-gradient(135deg,#ede9fe,#faf5ff);display:flex;align-items:center;justify-content:center;font-size:.75rem;flex-shrink:0">🍽</div><div style="min-width:0"><div style="font-size:.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:12rem"><?= htmlspecialchars($r['titre']) ?></div><div style="font-size:.68rem;color:var(--text-muted)"><?= ucfirst($r['difficulte']) ?></div></div></div><span style="font-size:.68rem;color:var(--text-muted);flex-shrink:0"><?= date('d/m',strtotime($r['created_at'])) ?></span></div>
    <?php endforeach; endif; ?>
  </div>
  <!-- Recent commandes -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="receipt" style="width:.95rem;height:.95rem;color:#3b82f6"></i> Commandes récentes <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commandes" style="margin-left:auto;font-size:.7rem;color:var(--secondary);font-weight:600;text-decoration:none">Voir →</a></div>
    <?php
    $sb=['en_attente'=>['#fef9c3','#92400e','En attente'],'confirmee'=>['#dbeafe','#1e40af','Confirmée'],'livree'=>['#dcfce7','#166534','Livrée'],'annulee'=>['#fee2e2','#991b1b','Annulée']];
    if(empty($recentCommandes)): ?><p style="color:var(--text-muted);font-size:.82rem;text-align:center;padding:.5rem">Aucune.</p><?php else: foreach($recentCommandes as $o): $b=$sb[$o['statut']]??['#f3f4f6','#374151','?']; ?>
    <div class="recent-row"><div style="display:flex;align-items:center;gap:.6rem"><div style="width:1.85rem;height:1.85rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;font-size:.65rem;color:#fff;font-weight:700;flex-shrink:0"><?= strtoupper(substr($o['client_nom'],0,2)) ?></div><div><div style="font-size:.8rem;font-weight:600"><?= htmlspecialchars($o['client_nom']) ?></div><div style="font-size:.68rem;color:var(--text-muted)"><?= number_format($o['total'],2) ?> DT</div></div></div><span class="badge-sm" style="background:<?= $b[0] ?>;color:<?= $b[1] ?>"><?= $b[2] ?></span></div>
    <?php endforeach; endif; ?>
  </div>
  <!-- Recent repas -->
  <div class="chart-card">
    <div class="chart-title"><i data-lucide="utensils-crossed" style="width:.95rem;height:.95rem;color:#16a34a"></i> Repas récents <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=list" style="margin-left:auto;font-size:.7rem;color:var(--secondary);font-weight:600;text-decoration:none">Voir →</a></div>
    <?php if(empty($recentRepas)): ?><p style="color:var(--text-muted);font-size:.82rem;text-align:center;padding:.5rem">Aucun.</p><?php else: foreach($recentRepas as $rp): ?>
    <div class="recent-row"><div style="display:flex;align-items:center;gap:.6rem"><div style="width:1.85rem;height:1.85rem;border-radius:.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);display:flex;align-items:center;justify-content:center;font-size:.75rem;flex-shrink:0">🥗</div><div><div style="font-size:.8rem;font-weight:600"><?= htmlspecialchars($rp['nom']) ?></div><div style="font-size:.68rem;color:var(--text-muted)"><?= $rp['calories_total'] ?> kcal</div></div></div><span style="font-size:.68rem;color:var(--text-muted);flex-shrink:0"><?= date('d/m',strtotime($rp['date_repas'])) ?></span></div>
    <?php endforeach; endif; ?>
  </div>
</div>
</div>

<!-- ===== CHARTS JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const isDark = document.documentElement.getAttribute('data-theme')==='dark';
const grid   = isDark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.09)';
const txt    = isDark ? '#94a3b8' : '#374151';
const cardBg = isDark ? '#1e293b' : '#ffffff';
const leg    = {labels:{color:txt,font:{family:'Inter',size:11},usePointStyle:true,pointStyle:'circle',padding:14}};
const sc     = {
  x:{ticks:{color:txt,font:{size:11}},grid:{color:grid}},
  y:{ticks:{color:txt,font:{size:11}},grid:{color:grid}}
};
Chart.defaults.color = txt;
Chart.defaults.borderColor = grid;
const donut = (id,labs,vals,colors) => new Chart(document.getElementById(id),{
  type:'doughnut',
  data:{labels:labs,datasets:[{data:vals,backgroundColor:colors,borderWidth:2,borderColor:cardBg,spacing:2}]},
  options:{responsive:true,cutout:'65%',plugins:{legend:{position:'bottom',...leg}}}
});
const barH = (id,labs,vals,color,label) => new Chart(document.getElementById(id),{
  type:'bar',
  data:{labels:labs,datasets:[{label:label,data:vals,backgroundColor:color,borderRadius:5,borderSkipped:false,maxBarThickness:22}]},
  options:{responsive:true,indexAxis:'y',plugins:{legend:{display:false}},scales:{x:{...sc.x,beginAtZero:true},y:{...sc.y}}}
});

// Revenue line
new Chart(document.getElementById('revenueChart'),{type:'line',data:{labels:<?= json_encode($revenueLabels ?: ['—']) ?>,datasets:[{label:'Revenu (DT)',data:<?= json_encode($revenueValues ?: [0]) ?>,borderColor:'#3b82f6',backgroundColor:'rgba(59,130,246,.12)',fill:true,tension:.4,pointBackgroundColor:'#3b82f6',pointRadius:5,borderWidth:2.5}]},options:{responsive:true,plugins:{legend:{display:false}},scales:sc}});

// Commandes donut
donut('commandesChart',['En attente','Confirmée','Livrée','Annulée'],[<?= $cmdData['en_attente']?>,<?= $cmdData['confirmee']?>,<?= $cmdData['livree']?>,<?= $cmdData['annulee']?>],['#fbbf24','#3b82f6','#22c55e','#ef4444']);

// Top produits
barH('topProduitsChart',<?= json_encode($topProdLabels ?: ['—']) ?>,<?= json_encode($topProdQty ?: [0]) ?>,'rgba(249,115,22,.75)','Qté vendue');

// Stock donut
donut('stockChart',['Rupture','Stock faible','OK'],[<?= implode(',',$stockData) ?>],['#ef4444','#f59e0b','#22c55e']);

// Catégories produits
donut('categoriesChart',<?= json_encode($catLabels ?: ['—']) ?>,<?= json_encode($catValues ?: [0]) ?>,['#2D6A4F','#52B788','#E76F51','#3b82f6','#8b5cf6','#ec4899']);

// Bio donut
donut('bioChart',['Bio 🌿','Conventionnel'],[<?= implode(',',$bioData) ?>],['#22c55e','#94a3b8']);

// Difficulté donut
donut('difficulteChart',['Facile','Moyen','Difficile'],[<?= $diffData['facile']?>,<?= $diffData['moyen']?>,<?= $diffData['difficile']?>],['#22c55e','#f59e0b','#ef4444']);

// Recettes par catégorie — barres fines (proChart.js)
new Chart(document.getElementById('recetteCatChart'),{type:'bar',data:{labels:<?= json_encode($recetteCatLabels ?: ['—']) ?>,datasets:[{data:<?= json_encode($recetteCatValues ?: [0]) ?>,backgroundColor:['#2D6A4F','#52B788','#95d5b2','#ec4899','#8b5cf6','#3b82f6','#f97316'],borderRadius:{topLeft:6,topRight:6},borderSkipped:false,categoryPercentage:.58,barPercentage:.42,maxBarThickness:44}]},options:{responsive:true,maintainAspectRatio:true,plugins:{legend:{display:false},tooltip:{cornerRadius:8}},scales:{x:{...sc.x,ticks:{maxRotation:38,minRotation:0,autoSkip:false}},y:{...sc.y,beginAtZero:true,grace:'8%'}}}});

// Carbon horizontal bar
barH('carbonChart',['<0.5','0.5–1','1–2','2–3','>3'],[<?= implode(',',$carbonData) ?>],['#16a34a','#52B788','#eab308','#E76F51','#ef4444'],'Recettes');

// Comments donut
donut('commentsChart',['Approuvés','En attente','Refusés'],[<?= $commData['approuve']?>,<?= $commData['en_attente']?>,<?= $commData['refuse']?>],['#22c55e','#f59e0b','#ef4444']);

// Ratings bar
new Chart(document.getElementById('ratingChart'),{type:'bar',data:{labels:<?= json_encode($ratingLabels ?: ['—']) ?>,datasets:[{label:'Note /5',data:<?= json_encode($ratingValues ?: [0]) ?>,backgroundColor:'rgba(245,158,11,.82)',borderRadius:{topLeft:5,topRight:5},borderSkipped:false,categoryPercentage:.58,barPercentage:.45,maxBarThickness:40}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{...sc,y:{...sc.y,min:0,max:5,beginAtZero:true}}}});

// Calories by meal type
new Chart(document.getElementById('caloriesChart'),{type:'bar',data:{labels:<?= json_encode($calTypLabels ?: ['—']) ?>,datasets:[{label:'Kcal moy.',data:<?= json_encode($calTypValues ?: [0]) ?>,backgroundColor:['#f97316','#3b82f6','#8b5cf6','#22c55e'],borderRadius:{topLeft:6,topRight:6},borderSkipped:false,categoryPercentage:.62,barPercentage:.48,maxBarThickness:42}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{...sc,y:{...sc.y,beginAtZero:true,grace:'6%'}}}});

// Macros donut
donut('macrosChart',['Protéines','Glucides','Lipides'],[<?= implode(',',$macroData) ?>],['#2D6A4F','#52B788','#E76F51']);

// Plans donut
donut('plansChart',<?= json_encode($planLabels ?: ['—']) ?>,<?= json_encode($planValues ?: [0]) ?>,['#059669','#3b82f6','#f97316']);

// Régimes horizontal bar
barH('regimesChart',<?= json_encode($regimesLabels ?: ['—']) ?>,<?= json_encode($regimesValues ?: [0]) ?>,'rgba(217,119,6,.7)','Régimes');

// Ingrédients local donut
donut('ingredientsChart',['Locaux 🌍','Importés'],[<?= implode(',',$ingData) ?>],['#2D6A4F','#94a3b8']);

// ── REPAS CHARTS ──
// Repas by status donut
donut('repasStatutChart',['Accepté','En attente','Refusé'],[<?= $repasStatutData['accepte'] ?>,<?= $repasStatutData['en_attente'] ?>,<?= $repasStatutData['refuse'] ?>],['#22c55e','#f59e0b','#ef4444']);

// Repas by type donut
donut('repasTypeChart',<?= json_encode($repasTypeLabels ?: ['—']) ?>,<?= json_encode($repasTypeValues ?: [0]) ?>,['#f97316','#3b82f6','#8b5cf6','#22c55e','#ec4899']);

// Top 5 aliments (horizontal bar)
barH('topAlimChart',<?= json_encode($topAlimLabels ?: ['—']) ?>,<?= json_encode($topAlimValues ?: [0]) ?>,'rgba(239,68,68,.7)','Fréquence');

// Repas by day of week (vertical bar)
new Chart(document.getElementById('repasDayChart'),{type:'bar',data:{labels:<?= json_encode($repasDayLabels ?: ['—']) ?>,datasets:[{label:'Repas',data:<?= json_encode($repasDayValues ?: [0]) ?>,backgroundColor:['#3b82f6','#8b5cf6','#ec4899','#f97316','#22c55e','#14b8a6','#6366f1'],borderRadius:{topLeft:6,topRight:6},borderSkipped:false,categoryPercentage:.62,barPercentage:.48,maxBarThickness:42}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{...sc,y:{...sc.y,beginAtZero:true,grace:'6%'}}}});
</script>
