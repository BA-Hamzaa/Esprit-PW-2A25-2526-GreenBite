<!-- Vue FrontOffice : Formulaire de commande -->
<div style="padding:2rem;max-width:52rem">
  <a href="<?= BASE_URL ?>/?page=marketplace" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux produits
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#ffedd5,#fff7ed);border-radius:var(--radius-xl)">
      <i data-lucide="shopping-cart" style="width:1.5rem;height:1.5rem;color:#f97316"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Mon Panier</h1>
      <p class="text-sm" style="color:var(--text-muted)"><?= $cartCount ?> article<?= $cartCount > 1 ? 's' : '' ?> • Confirmez votre commande</p>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-6 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5">
      <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
      <div><?php foreach ($errors as $e): ?><div class="mb-1"><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
    </div>
  <?php endif; ?>

  <?php if (!empty($cartItems)): ?>
  <!-- Cart Summary -->
  <div class="card mb-5" style="padding:0;overflow:hidden;border:1px solid rgba(249,115,22,0.2)">
    <div style="padding:1rem 1.25rem;background:linear-gradient(135deg,rgba(249,115,22,0.06),transparent);border-bottom:1px solid rgba(249,115,22,0.1);display:flex;align-items:center;justify-content:space-between">
      <h2 style="font-weight:700;color:var(--text-primary);font-size:0.9rem;display:flex;align-items:center;gap:0.5rem">
        <i data-lucide="package" style="width:0.9rem;height:0.9rem;color:#f97316"></i> Résumé du panier
      </h2>
      <a href="<?= BASE_URL ?>/?page=marketplace&action=clear-cart" style="font-size:0.72rem;color:var(--destructive);font-weight:500;text-decoration:none"
         data-confirm="Vider le panier ?" data-confirm-title="Vider le panier" data-confirm-type="warning" data-confirm-btn="Vider">
        <i data-lucide="trash-2" style="width:0.7rem;height:0.7rem"></i> Vider le panier
      </a>
    </div>
    <?php foreach ($cartItems as $ci): ?>
    <div style="display:flex;align-items:center;gap:1rem;padding:0.875rem 1.25rem;border-bottom:1px solid var(--border)">
      <!-- Thumbnail -->
      <div style="width:2.75rem;height:2.75rem;border-radius:var(--radius);background:var(--muted);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
        <?php if (!empty($ci['image'])): ?>
          <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($ci['image']) ?>" alt="" style="width:100%;height:100%;object-fit:cover">
        <?php else: ?>
          <i data-lucide="package" style="width:1rem;height:1rem;color:var(--text-muted)"></i>
        <?php endif; ?>
      </div>
      <!-- Name + unit price -->
      <div style="flex:1;min-width:0">
        <div style="font-weight:600;font-size:0.875rem;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($ci['nom']) ?></div>
        <div style="font-size:0.72rem;color:var(--text-muted)"><?= number_format($ci['prix'], 2) ?> DT / unité</div>
      </div>
      <!-- Inline qty stepper form -->
      <form method="POST" action="<?= BASE_URL ?>/?page=marketplace&action=update-cart" style="display:flex;align-items:center;gap:0.35rem">
        <input type="hidden" name="produit_id" value="<?= $ci['id'] ?>">
        <div style="display:flex;align-items:center;border:1.5px solid var(--border);border-radius:var(--radius-full);overflow:hidden;background:var(--surface)">
          <button type="button"
                  onclick="let i=this.nextElementSibling;i.value=Math.max(0,parseInt(i.value||1)-1)"
                  style="width:1.65rem;height:1.65rem;background:none;border:none;cursor:pointer;font-size:0.95rem;font-weight:700;color:var(--text-secondary);display:flex;align-items:center;justify-content:center"
                  onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='none'">−</button>
          <input type="number" name="quantite" value="<?= $ci['cart_qty'] ?>" min="0"
                 style="width:2rem;text-align:center;border:none;outline:none;font-size:0.8rem;font-weight:700;color:var(--text-primary);background:transparent;-moz-appearance:textfield">
          <button type="button"
                  onclick="let i=this.previousElementSibling;i.value=parseInt(i.value||0)+1"
                  style="width:1.65rem;height:1.65rem;background:none;border:none;cursor:pointer;font-size:0.95rem;font-weight:700;color:var(--text-secondary);display:flex;align-items:center;justify-content:center"
                  onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='none'">+</button>
        </div>
        <button type="submit" title="Mettre à jour"
                style="width:1.65rem;height:1.65rem;background:var(--secondary);color:#fff;border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.2s"
                onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
          <i data-lucide="check" style="width:0.7rem;height:0.7rem"></i>
        </button>
      </form>
      <!-- Subtotal -->
      <div style="font-weight:700;color:#f97316;font-size:0.9rem;min-width:4.5rem;text-align:right"><?= number_format($ci['subtotal'], 2) ?> DT</div>
      <!-- Remove -->
      <a href="<?= BASE_URL ?>/?page=marketplace&action=remove-from-cart&id=<?= $ci['id'] ?>"
         style="color:var(--destructive);opacity:0.55;transition:opacity 0.2s;flex-shrink:0"
         onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.55'"
         title="Supprimer">
        <i data-lucide="x" style="width:0.9rem;height:0.9rem"></i>
      </a>
    </div>
    <?php endforeach; ?>
    <div style="padding:0.875rem 1.25rem;display:flex;justify-content:space-between;align-items:center">
      <span style="font-size:0.875rem;color:var(--text-muted)"><?= $cartCount ?> article<?= $cartCount > 1 ? 's' : '' ?></span>
      <span style="font-weight:800;font-size:1rem;color:var(--text-primary)">Total estimé : <span style="color:#f97316"><?= number_format($cartTotal, 2) ?> DT</span></span>
    </div>
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
        <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)">
          <i data-lucide="package" style="width:1rem;height:1rem;color:#f97316"></i> Produits commandés
          <span style="font-size:0.75rem;font-weight:400;color:var(--text-muted);margin-left:0.25rem">— ajoutez ou modifiez</span>
        </h2>
        <div id="produits-container" class="space-y-3">
          <?php if (!empty($cartItems)):
            foreach ($cartItems as $ci): ?>
            <div class="flex gap-3 items-center produit-row" style="background:var(--muted);padding:0.75rem;border-radius:var(--radius-xl)">
              <select name="produit_ids[]" class="form-input flex-1">
                <option value="">-- Choisir un produit --</option>
                <?php foreach ($produits as $p): ?>
                  <option value="<?= $p['id'] ?>" data-prix="<?= $p['prix'] ?>" <?= $p['id'] == $ci['id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['nom']) ?> — <?= number_format($p['prix'], 2) ?> DT (Stock: <?= $p['stock'] ?>)</option>
                <?php endforeach; ?>
              </select>
              <input type="number" name="quantites[]" class="form-input" style="width:100px" placeholder="Qté" value="<?= $ci['cart_qty'] ?>" min="1">
              <button type="button" class="icon-btn" style="width:2rem;height:2rem;color:var(--destructive);flex-shrink:0" onclick="this.closest('.produit-row').remove()"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
            </div>
          <?php endforeach; else: ?>
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
          <?php endif; ?>
        </div>
        <button type="button" id="add-produit-btn" class="btn btn-outline-primary btn-sm mt-3"><i data-lucide="plus" style="width:0.875rem;height:0.875rem"></i> Ajouter un produit</button>
      </div>

      <button type="submit" class="btn btn-primary btn-block btn-lg rounded-xl mt-6" style="background:linear-gradient(135deg,#f97316,#ea580c);border:none">
        <i data-lucide="check" style="width:1.125rem;height:1.125rem"></i> Confirmer la commande
      </button>
    </form>
  </div>
</div>

<script>
// Template row for cloning
const _firstRow = document.querySelector('.produit-row');

document.getElementById('add-produit-btn').addEventListener('click', function() {
  const c = document.getElementById('produits-container');
  const row = _firstRow.cloneNode(true);
  row.querySelector('select').value = '';
  row.querySelector('input[type="number"]').value = '1';
  c.appendChild(row);
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

document.getElementById('orderForm').addEventListener('submit', function(e) {
  let errors = [];
  const nom = document.getElementById('client_nom').value.trim();
  const email = document.getElementById('client_email').value.trim();
  const adresse = document.getElementById('client_adresse').value.trim();

  if (!nom) { errors.push("Le nom est obligatoire."); document.getElementById('client_nom').style.borderColor='#ef4444'; }
  else document.getElementById('client_nom').style.borderColor='';
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { errors.push("Email invalide."); document.getElementById('client_email').style.borderColor='#ef4444'; }
  else document.getElementById('client_email').style.borderColor='';
  if (adresse.length < 10) { errors.push("Adresse : min 10 caractères."); document.getElementById('client_adresse').style.borderColor='#ef4444'; }
  else document.getElementById('client_adresse').style.borderColor='';

  let hasProduct = false;
  document.querySelectorAll('.produit-row').forEach(row => {
    if (row.querySelector('select').value && parseInt(row.querySelector('input[type="number"]').value) > 0) hasProduct = true;
  });
  if (!hasProduct) errors.push("Sélectionnez au moins un produit.");

  if (errors.length > 0) {
    e.preventDefault();
    if (typeof showToast === 'function') showToast('error', errors[0]);
  }
});
</script>
<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button { -webkit-appearance:none; margin:0; }
input[type=number] { -moz-appearance:textfield; }
</style>
