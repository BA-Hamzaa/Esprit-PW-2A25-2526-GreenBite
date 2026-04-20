<!-- Vue FrontOffice : Formulaire de commande -->
<div style="padding:2rem;max-width:48rem">
  <a href="<?= BASE_URL ?>/?page=marketplace" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux produits
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
      <i data-lucide="shopping-cart" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Passer une commande</h1>
      <p class="text-sm" style="color:var(--text-muted)">Remplissez vos informations et choisissez vos produits</p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5" id="error-box">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:2rem">
    <form novalidate method="POST" id="orderForm">
      <!-- Informations client -->
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="user" style="width:1rem;height:1rem;color:var(--primary)"></i> Vos informations</h2>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="client_nom"><i data-lucide="type" style="width:0.75rem;height:0.75rem"></i> Nom complet</label>
          <input type="text" name="client_nom" id="client_nom" class="form-input" placeholder="Jean Dupont" value="<?= htmlspecialchars($_POST['client_nom'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="client_email"><i data-lucide="mail" style="width:0.75rem;height:0.75rem"></i> Email</label>
          <input type="text" name="client_email" id="client_email" class="form-input" placeholder="jean@email.com" value="<?= htmlspecialchars($_POST['client_email'] ?? '') ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="client_adresse"><i data-lucide="map-pin" style="width:0.75rem;height:0.75rem"></i> Adresse de livraison</label>
        <textarea name="client_adresse" id="client_adresse" class="form-textarea" rows="2" placeholder="12 rue des Lilas, Tunis"><?= htmlspecialchars($_POST['client_adresse'] ?? '') ?></textarea>
      </div>

      <!-- Produits -->
      <div style="border-top:1px solid var(--border);padding-top:1.5rem;margin-top:0.5rem">
        <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="package" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Produits</h2>
        <div id="produits-container" class="space-y-3">
          <div class="flex gap-3 items-center produit-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
            <select name="produit_ids[]" class="form-input flex-1">
              <option value="">-- Choisir un produit --</option>
              <?php foreach ($produits as $p): ?>
                <option value="<?= $p['id'] ?>" data-prix="<?= $p['prix'] ?>"><?= htmlspecialchars($p['nom']) ?> — <?= number_format($p['prix'], 2) ?> DT (Stock: <?= $p['stock'] ?>)</option>
              <?php endforeach; ?>
            </select>
            <input type="number" name="quantites[]" class="form-input" style="width:100px" placeholder="Qté" value="1">
            <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.produit-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
          </div>
        </div>
        <button type="button" id="add-produit-btn" class="btn btn-outline-primary btn-sm mt-3"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un produit</button>
      </div>

      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl mt-6">
        <i data-lucide="check" style="width:1.125rem;height:1.125rem"></i> Confirmer la commande
      </button>
    </form>
  </div>
</div>

<script>
document.getElementById('add-produit-btn').addEventListener('click', function() {
  const c = document.getElementById('produits-container');
  const row = c.querySelector('.produit-row').cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '1';
  c.appendChild(row);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

document.getElementById('orderForm').addEventListener('submit', function(e) {
  let errors = [];
  if (document.getElementById('client_nom').value.trim() === '') errors.push("Le nom est obligatoire.");
  const email = document.getElementById('client_email').value.trim();
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errors.push("Email invalide.");
  if (document.getElementById('client_adresse').value.trim().length < 10) errors.push("Adresse : min 10 caractères.");
  let hasProduct = false;
  document.querySelectorAll('.produit-row').forEach(row => {
    if (row.querySelector('select').value && parseInt(row.querySelector('input[type="number"]').value) > 0) hasProduct = true;
  });
  if (!hasProduct) errors.push("Sélectionnez au moins un produit.");
  if (errors.length > 0) {
    e.preventDefault();
    showToast('error', errors[0]);
  }
});

function showToast(type, msg) {
  let container = document.getElementById('toastContainer');
  if (!container) { container = document.createElement('div'); container.id = 'toastContainer'; document.body.appendChild(container); }
  const t = document.createElement('div');
  t.className = 'toast ' + type;
  t.innerHTML = '<i data-lucide="'+(type==='success'?'check-circle-2':'alert-circle')+'" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i><span style="font-size:0.875rem;font-weight:500">'+msg+'</span>';
  container.appendChild(t);
  if (typeof lucide !== 'undefined') lucide.createIcons();
  setTimeout(()=>{ t.classList.add('hiding'); setTimeout(()=>t.remove(), 300); }, 4000);
}
</script>
