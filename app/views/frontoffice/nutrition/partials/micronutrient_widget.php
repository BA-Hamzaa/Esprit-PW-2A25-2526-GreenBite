<!-- USDA FoodData Central — Micronutrient Explorer Widget -->
<style>
.usda-widget{border-radius:20px;padding:28px 32px;margin-top:24px;background:linear-gradient(145deg,rgba(211,233,219,0.76),rgba(190,217,201,0.66));backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.82);box-shadow:0 10px 30px rgba(20,54,34,.13)}
.usda-head{display:flex;align-items:center;gap:12px;margin-bottom:20px}
.usda-icon{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#1E5C38,#3DDC84);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(61,220,132,.35);flex-shrink:0}
.usda-title{font-size:18px;font-weight:700;color:#1A2E20}
.usda-sub{font-size:12px;color:#6f7f74;margin-top:2px}
.usda-row{display:flex;gap:8px;margin-bottom:16px}
.usda-input{flex:1;padding:10px 16px;border-radius:50px;border:1.5px solid rgba(61,220,132,.3);background:rgba(255,255,255,.8);font-size:14px;color:#1A2E20;outline:none;transition:all .2s}
.usda-input:focus{border-color:#3DDC84;box-shadow:0 0 0 3px rgba(61,220,132,.12)}
.usda-btn{padding:10px 20px;border-radius:50px;background:linear-gradient(135deg,#1E5C38,#3DDC84);color:#fff;border:none;font-weight:700;font-size:13px;cursor:pointer;transition:all .2s;white-space:nowrap}
.usda-btn:hover:not(:disabled){transform:translateY(-1px);box-shadow:0 6px 18px rgba(30,92,56,.3)}
.usda-btn:disabled{opacity:.6;cursor:not-allowed}
.usda-card{background:rgba(255,255,255,.85);border-radius:14px;padding:16px 20px;border:1px solid rgba(255,255,255,.9);box-shadow:0 4px 12px rgba(20,54,34,.08);margin-bottom:10px}
.usda-card-name{font-weight:700;font-size:14px;color:#1A2E20;margin-bottom:2px}
.usda-card-cat{font-size:11px;color:#6f7f74;margin-bottom:12px}
.usda-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(145px,1fr));gap:8px}
.usda-nutrient-label{font-size:10px;color:#6f7f74;font-weight:600;text-transform:uppercase;letter-spacing:.05em}
.usda-bar-wrap{height:5px;background:rgba(0,0,0,.06);border-radius:3px;overflow:hidden;margin:3px 0}
.usda-bar{height:100%;border-radius:3px;transition:width .7s ease}
.usda-val{font-size:12px;font-weight:700;color:#1A2E20}
.usda-vnr{color:#9ca3af;font-weight:400;font-size:11px}
.usda-sect-label{font-size:11px;font-weight:700;color:#6f7f74;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px}
.usda-divider{border:none;border-top:1px dashed rgba(0,0,0,.08);margin:12px 0}
.usda-empty{text-align:center;padding:20px;color:#6f7f74;font-size:13px}
.usda-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 9px;border-radius:50px;font-size:10px;font-weight:700;background:rgba(61,220,132,.12);color:#1E5C38;border:1px solid rgba(61,220,132,.2)}
[data-theme='dark'] .usda-widget{background:linear-gradient(145deg,rgba(30,41,59,.78),rgba(15,23,42,.72));border-color:rgba(148,163,184,.25)}
[data-theme='dark'] .usda-title{color:#e5e7eb}
[data-theme='dark'] .usda-sub{color:#94a3b8}
[data-theme='dark'] .usda-input{background:rgba(30,41,59,.9);border-color:rgba(148,163,184,.3);color:#e5e7eb}
[data-theme='dark'] .usda-card{background:rgba(30,41,59,.8);border-color:rgba(148,163,184,.2)}
[data-theme='dark'] .usda-card-name,[data-theme='dark'] .usda-val{color:#e5e7eb}
[data-theme='dark'] .usda-bar-wrap{background:rgba(255,255,255,.08)}
</style>

<div class="usda-widget" id="usdaWidget">
  <div class="usda-head">
    <div class="usda-icon">
      <i data-lucide="microscope" style="width:18px;height:18px;color:#fff"></i>
    </div>
    <div>
      <div class="usda-title">🔬 Explorateur de Micronutriments</div>
      <div class="usda-sub">Powered by USDA FoodData Central · 600 000+ aliments · Vitamines &amp; Minéraux</div>
    </div>
  </div>

  <div class="usda-row">
    <input id="usdaInput" class="usda-input" type="text"
           placeholder="Ex: poulet, banane, lait, thon… (en français ou anglais)" autocomplete="off">
    <button id="usdaBtn" class="usda-btn" onclick="usdaSearch()">
      <i data-lucide="search" style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:4px"></i>Analyser
    </button>
  </div>

  <div id="usdaResults"></div>
</div>

<script>
const USDA_API = '<?= BASE_URL ?>/nutrition-api.php';

// Nutrient config: [display color, daily reference value]
const MACROS = {
  'Calories'  : ['#fcd34d', 2000],
  'Protéines' : ['#22c55e',   50],
  'Glucides'  : ['#3b82f6',  275],
  'Lipides'   : ['#f97316',   78],
  'Fibres'    : ['#10b981',   28],
};
const MICROS = {
  'Vit. C'    : ['#f97316',  90],
  'Vit. A'    : ['#eab308', 900],
  'Vit. D'    : ['#f59e0b',  20],
  'Vit. B12'  : ['#8b5cf6',  2.4],
  'Vit. B6'   : ['#a78bfa',  1.7],
  'Calcium'   : ['#3b82f6',1000],
  'Fer'       : ['#ef4444',  18],
  'Magnésium' : ['#22c55e', 400],
  'Potassium' : ['#06b6d4',4700],
  'Zinc'      : ['#ec4899',  11],
};

document.getElementById('usdaInput').addEventListener('keydown', e => {
  if (e.key === 'Enter') usdaSearch();
});

async function usdaSearch() {
  const q = document.getElementById('usdaInput').value.trim();
  if (!q) return;
  const btn = document.getElementById('usdaBtn');
  const out = document.getElementById('usdaResults');
  btn.disabled = true;
  btn.innerHTML = '⏳ Recherche…';
  out.innerHTML = '<div style="text-align:center;padding:16px;color:#6f7f74;font-size:13px">🔍 Interrogation USDA…</div>';
  try {
    const r = await fetch(`${USDA_API}?action=usda_search&q=${encodeURIComponent(q)}`);
    const data = await r.json();
    if (data.error || !data.results?.length) {
      out.innerHTML = '<div class="usda-empty">😕 Aucun résultat. Essayez en anglais (ex: "chicken", "banana")</div>';
    } else {
      out.innerHTML = data.results.slice(0, 5).map(renderCard).join('');
      if (typeof lucide !== 'undefined') lucide.createIcons();
    }
  } catch {
    out.innerHTML = '<div class="usda-empty">⚠️ Erreur réseau. Réessayez.</div>';
  }
  btn.disabled = false;
  btn.innerHTML = '<i data-lucide="search" style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:4px"></i>Analyser';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

function nutriRow(label, v, unit, color, ref) {
  if (!v && v !== 0) return '';
  const pct = Math.min(100, Math.round((v / ref) * 100));
  return `<div>
    <div class="usda-nutrient-label">${label}</div>
    <div class="usda-bar-wrap"><div class="usda-bar" style="width:${pct}%;background:${color}"></div></div>
    <div class="usda-val">${v} <span style="font-weight:400;color:#9ca3af;font-size:11px">${unit}</span>
      ${ref ? `<span class="usda-vnr">(${pct}% VNR)</span>` : ''}
    </div>
  </div>`;
}

function renderCard(food) {
  const n = food.nutrients;
  const macroHtml = Object.entries(MACROS).map(([k,[c,r]]) =>
    nutriRow(k, n[k]?.value ?? null, n[k]?.unit ?? '', c, r)
  ).filter(Boolean).join('');

  const microHtml = Object.entries(MICROS).map(([k,[c,r]]) => {
    const v = n[k]?.value;
    if (!v) return '';
    return nutriRow(k, v, n[k]?.unit ?? '', c, r);
  }).filter(Boolean).join('');

  return `<div class="usda-card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:6px;margin-bottom:4px">
      <div>
        <div class="usda-card-name">🥗 ${food.name}</div>
        <div class="usda-card-cat">${food.category || food.dataType} · valeurs pour 100g</div>
      </div>
      <span class="usda-badge">USDA</span>
    </div>
    ${macroHtml ? `<div class="usda-sect-label">Macronutriments</div><div class="usda-grid">${macroHtml}</div>` : ''}
    ${microHtml ? `<hr class="usda-divider"><div class="usda-sect-label">🔬 Micronutriments (% Valeur Nutritionnelle Recommandée)</div><div class="usda-grid">${microHtml}</div>` : '<div style="font-size:12px;color:#9ca3af;margin-top:8px;font-style:italic">Pas de données micronutriments pour cet aliment.</div>'}
  </div>`;
}
</script>
