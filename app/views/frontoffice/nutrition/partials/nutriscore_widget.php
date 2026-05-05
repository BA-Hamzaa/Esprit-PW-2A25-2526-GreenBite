<!-- Open Food Facts: Nutri-Score & Eco-Score Widget -->
<style>
.off-widget{border-radius:20px;padding:28px 32px;margin-top:20px;background:linear-gradient(145deg,rgba(211,233,219,0.76),rgba(190,217,201,0.66));backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.82);box-shadow:0 10px 30px rgba(20,54,34,.13)}
.off-head{display:flex;align-items:center;gap:12px;margin-bottom:20px}
.off-icon{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#C0392B,#E74C3C);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(231,76,60,.3);flex-shrink:0}
.ns{display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:8px;font-size:18px;font-weight:900;color:#fff;flex-shrink:0}
.ns-a{background:#1a9e3f}.ns-b{background:#72c33d}.ns-c{background:#f9c428}.ns-d{background:#f07e22}.ns-e{background:#e73d1c}
.ns-na{background:#64748b;font-size:11px;width:32px;height:32px}
.eco-na{background:#64748b;font-size:10px;width:28px;height:28px}
.nova-badge{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;font-size:12px;font-weight:800;color:#fff}
.nova-1{background:#1a9e3f}.nova-2{background:#72c33d}.nova-3{background:#f07e22}.nova-4{background:#e73d1c}
.eco-badge{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;font-size:12px;font-weight:800;color:#fff}
.eco-a{background:#1a9e3f}.eco-b{background:#72c33d}.eco-c{background:#f9c428;color:#1A2E20}.eco-d{background:#f07e22}.eco-e{background:#e73d1c}
.off-card{background:rgba(255,255,255,.85);border-radius:14px;padding:16px 20px;border:1px solid rgba(255,255,255,.9);box-shadow:0 4px 12px rgba(20,54,34,.08);margin-bottom:10px}
.off-card-name{font-weight:700;font-size:14px;color:#1A2E20;margin-bottom:2px}
.off-card-brand{font-size:11px;color:#6f7f74;margin-bottom:12px}
.off-scores{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:10px}
.off-score-item{display:flex;align-items:center;gap:6px;font-size:12px;color:#3A4A40}
.off-score-label{font-weight:600;font-size:11px;color:#6f7f74;text-transform:uppercase;letter-spacing:.04em}
.allergen-tag{display:inline-block;padding:2px 8px;border-radius:50px;background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.2);color:#C0392B;font-size:11px;font-weight:600;margin:2px}
.off-search-wrap{display:flex;gap:8px;margin-bottom:16px}
.off-input{flex:1;padding:10px 16px;border-radius:50px;border:1.5px solid rgba(231,76,60,.25);background:rgba(255,255,255,.8);font-size:14px;color:#1A2E20;outline:none;transition:all .2s}
.off-input:focus{border-color:#E74C3C;box-shadow:0 0 0 3px rgba(231,76,60,.1)}
.off-btn{padding:10px 20px;border-radius:50px;background:linear-gradient(135deg,#C0392B,#E74C3C);color:#fff;border:none;font-weight:700;font-size:13px;cursor:pointer;transition:all .2s}
.off-btn:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(192,57,43,.35)}
.off-btn:disabled{opacity:.6;cursor:not-allowed;transform:none}
.off-empty{text-align:center;padding:20px;color:#6f7f74;font-size:13px}
.off-legend{display:flex;gap:20px;flex-wrap:wrap;margin-bottom:16px;padding:12px 16px;background:rgba(255,255,255,.5);border-radius:12px;border:1px solid transparent}
.off-legend-label{font-size:11px;font-weight:700;color:#6f7f74;text-transform:uppercase;align-self:center}
.off-legend-desc{font-size:11px;color:#6f7f74;align-self:center}
[data-theme='dark'] .off-widget{background:linear-gradient(145deg,rgba(30,41,59,.78),rgba(15,23,42,.72));border-color:rgba(148,163,184,.25)}
[data-theme='dark'] .off-card{background:rgba(30,41,59,.8);border-color:rgba(148,163,184,.2)}
[data-theme='dark'] .off-card-name{color:#e5e7eb}
[data-theme='dark'] .off-card-brand{color:#94a3b8}
[data-theme='dark'] .off-input{background:rgba(30,41,59,.9);border-color:rgba(148,163,184,.3);color:#e5e7eb}
[data-theme='dark'] .off-score-item{color:#cbd5e1}
[data-theme='dark'] .off-score-label{color:#94a3b8}
[data-theme='dark'] .off-title{color:#e5e7eb !important}
[data-theme='dark'] .off-head div:last-child > div:last-child{color:#94a3b8 !important}
[data-theme='dark'] .off-legend{background:rgba(30,41,59,.8);border:1px solid rgba(148,163,184,.15)}
[data-theme='dark'] .off-legend-label, [data-theme='dark'] .off-legend-desc{color:#cbd5e1}
[data-theme='dark'] .off-empty{color:#94a3b8}
[data-theme='dark'] .allergen-tag{background:rgba(231,76,60,.15);border-color:rgba(231,76,60,.3);color:#fca5a5}
</style>

<div class="off-widget" id="offWidget">
  <div class="off-head">
    <div class="off-icon"><i data-lucide="scan-barcode" style="width:18px;height:18px;color:#fff"></i></div>
    <div>
      <div style="font-size:18px;font-weight:700;color:#1A2E20" class="off-title">🏷️ Nutri-Score &amp; Éco-Score</div>
      <div style="font-size:12px;color:#6f7f74">Powered by Open Food Facts · Qualité &amp; Impact environnemental</div>
    </div>
  </div>

  <!-- Legend -->
  <div class="off-legend">
    <div class="off-legend-label">Nutri-Score :</div>
    <div style="display:flex;gap:6px">
      <?php foreach(['A','B','C','D','E'] as $g): ?>
      <span class="ns ns-<?= strtolower($g) ?>" style="width:28px;height:28px;font-size:14px"><?= $g ?></span>
      <?php endforeach; ?>
    </div>
    <div class="off-legend-desc">A = Meilleur · E = Moins bon</div>
  </div>

  <div class="off-search-wrap">
    <input id="offInput" class="off-input" type="text" placeholder="Ex: Activia, Danino, Kiri, Nestlé…" autocomplete="off">
    <button id="offBtn" class="off-btn" onclick="offSearch()">
      <i data-lucide="search" style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:4px"></i>Scanner
    </button>
  </div>

  <div id="offResults"></div>
</div>

<script>
const OFF_PROXY = '<?= BASE_URL ?>/nutrition-api.php';

document.getElementById('offInput').addEventListener('keydown', e => {
  if (e.key === 'Enter') offSearch();
});

async function offSearch() {
  const q = document.getElementById('offInput').value.trim();
  if (!q) return;
  const btn = document.getElementById('offBtn');
  const res = document.getElementById('offResults');
  btn.disabled = true;
  btn.textContent = 'Scan…';
  res.innerHTML = '<div style="text-align:center;padding:16px;color:#6f7f74;font-size:13px">🔍 Recherche en cours…</div>';
  try {
    const r = await fetch(`${OFF_PROXY}?action=off_search&q=${encodeURIComponent(q)}`);
    const data = await r.json();
    if (data.error || !data.results?.length) {
      res.innerHTML = '<div class="off-empty">😕 Produit non trouvé. Essayez un autre nom de marque.</div>';
    } else {
      res.innerHTML = data.results.map(renderOFFCard).join('');
      if (typeof lucide !== 'undefined') lucide.createIcons();
    }
  } catch(e) {
    res.innerHTML = '<div class="off-empty">⚠️ Erreur réseau. Réessayez.</div>';
  }
  btn.disabled = false;
  btn.innerHTML = '<i data-lucide="search" style="width:13px;height:13px;display:inline;vertical-align:middle;margin-right:4px"></i>Scanner';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}

function nsClass(g) {
  const m = {'A':'a','B':'b','C':'c','D':'d','E':'e'};
  return 'ns ns-' + (m[g] || 'na');
}
function ecoClass(g) {
  const m = {'A':'a','B':'b','C':'c','D':'d','E':'e'};
  return 'eco-badge eco-' + (m[g] || 'na ns-na');
}
function novaLabel(n) {
  const labels = {1:'Non transformé',2:'Peu transformé',3:'Transformé',4:'Ultra-transformé'};
  return labels[n] || '?';
}
function novaColor(n) {
  return ['','#1a9e3f','#72c33d','#f07e22','#e73d1c'][n] || '#9ca3af';
}
function additivesColor(n) {
  if (n === 0) return '#1a9e3f';
  if (n <= 2) return '#f07e22';
  return '#e73d1c';
}

function renderOFFCard(p) {
  const allergenHtml = p.allergens.length
    ? p.allergens.slice(0,6).map(a => `<span class="allergen-tag">⚠ ${a}</span>`).join('')
    : '<span style="font-size:12px;color:#1a9e3f">✓ Aucun allergène signalé</span>';

  const nsGrade = (p.nutriscore && p.nutriscore !== '?' && p.nutriscore !== 'UNKNOWN') ? p.nutriscore : null;
  const ecoGrade = (p.ecoscore && p.ecoscore !== '?' && p.ecoscore !== 'UNKNOWN') ? p.ecoscore : null;

  return `<div class="off-card">
    <div style="display:flex;align-items:flex-start;gap:12px">
      <div class="${nsGrade ? nsClass(nsGrade) : 'ns ns-na'}" style="${nsGrade ? '' : 'width:32px;height:32px;font-size:11px'}">${nsGrade || 'N/A'}</div>
      <div style="flex:1;min-width:0">
        <div class="off-card-name">${p.name}</div>
        <div class="off-card-brand">${[p.brand,p.quantity].filter(Boolean).join(' · ')}</div>
        <div class="off-scores">
          <div class="off-score-item">
            <span class="off-score-label">Nutri-Score</span>
            ${nsGrade
              ? `<span class="${nsClass(nsGrade)}" style="width:24px;height:24px;font-size:12px">${nsGrade}</span>`
              : `<span style="font-size:11px;color:#94a3b8;font-weight:600">Non noté</span>`}
          </div>
          ${p.nova ? `<div class="off-score-item">
            <span class="off-score-label">NOVA</span>
            <span class="nova-badge nova-${p.nova}">${p.nova}</span>
            <span style="font-size:11px" class="off-card-brand">${novaLabel(p.nova)}</span>
          </div>` : ''}
          <div class="off-score-item">
            <span class="off-score-label">Éco-Score</span>
            ${ecoGrade
              ? `<span class="eco-badge eco-${ecoGrade.toLowerCase()}">${ecoGrade}</span>`
              : `<span style="font-size:11px;color:#94a3b8;font-weight:600">Non noté</span>`}
          </div>
          ${p.kcal ? `<div class="off-score-item">
            <span class="off-score-label">Énergie</span>
            <span style="font-weight:700;color:#f59e0b">${p.kcal} kcal/100g</span>
          </div>` : ''}
          <div class="off-score-item">
            <span class="off-score-label">Additifs</span>
            <span style="font-weight:700;color:${additivesColor(p.additives)}">${p.additives === 0 ? '✓ Aucun' : p.additives + ' additifs'}</span>
          </div>
        </div>
        <div style="margin-top:8px"><div class="off-score-label" style="margin-bottom:4px">Allergènes</div>${allergenHtml}</div>
      </div>
    </div>
  </div>`;
}
</script>
