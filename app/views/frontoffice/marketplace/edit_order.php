<?php /* edit_order.php — Modifier une commande (paiement livraison, statut en_attente seulement) */ ?>
<style>
.edit-order-wrap{padding:2rem;max-width:48rem;margin:0 auto}
.edit-info-banner{display:flex;align-items:flex-start;gap:.875rem;padding:1rem 1.25rem;border-radius:.875rem;margin-bottom:2rem;
  background:linear-gradient(135deg,rgba(249,115,22,.08),rgba(251,191,36,.06));
  border:1px solid rgba(249,115,22,.25)}
.edit-info-banner svg{flex-shrink:0;margin-top:.1rem}
.edit-locked-banner{display:flex;align-items:flex-start;gap:.875rem;padding:1rem 1.25rem;border-radius:.875rem;margin-bottom:2rem;
  background:linear-gradient(135deg,rgba(239,68,68,.08),rgba(220,38,38,.05));
  border:1px solid rgba(239,68,68,.25)}
.field-group{margin-bottom:1.5rem}
.field-group label{display:block;font-size:.875rem;font-weight:600;color:var(--text-secondary);margin-bottom:.5rem}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
@media(max-width:640px){.form-row{grid-template-columns:1fr}}
.product-row{display:flex;align-items:center;justify-content:space-between;padding:.875rem 1rem;border-radius:.75rem;border:1px solid var(--border);margin-bottom:.625rem;background:var(--surface);gap:1rem;transition:all .3s ease}
.product-row.removed{opacity:.3;transform:scale(.97);pointer-events:none;max-height:0;padding:0;margin:0;overflow:hidden;border:none}
.product-row .prod-name{font-weight:600;color:var(--text-primary);font-size:.9rem}
.product-row .prod-price{font-size:.8rem;color:var(--text-muted)}
.qty-input{width:5rem;text-align:center;padding:.4rem .5rem;border-radius:.5rem;border:1px solid var(--border);background:var(--muted);font-size:.9rem;color:var(--text-primary)}
.qty-input:focus{outline:none;border-color:var(--primary)}
.remove-btn{display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:.5rem;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.08);color:#dc2626;cursor:pointer;transition:all .2s;flex-shrink:0}
.remove-btn:hover{background:#dc2626;color:#fff;border-color:#dc2626;transform:scale(1.1)}
.save-btn{display:flex;align-items:center;gap:.5rem;padding:.875rem 2rem;border-radius:.875rem;font-weight:700;font-size:.95rem;background:linear-gradient(135deg,#2D6A4F,#52B788);color:#fff;border:none;cursor:pointer;transition:all .2s}
.save-btn:hover{transform:translateY(-1px);box-shadow:0 8px 24px rgba(45,106,79,.3)}
.cancel-btn{display:flex;align-items:center;gap:.5rem;padding:.875rem 1.5rem;border-radius:.875rem;font-weight:600;font-size:.95rem;background:var(--surface);color:var(--text-secondary);border:1px solid var(--border);cursor:pointer;text-decoration:none;transition:all .2s}
.cancel-btn:hover{border-color:var(--text-muted)}
.marketplace-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;border-radius:.75rem;font-weight:700;font-size:.9rem;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;text-decoration:none;transition:all .2s;border:none;cursor:pointer}
.marketplace-btn:hover{transform:translateY(-1px);box-shadow:0 8px 20px rgba(37,99,235,.3)}
.section-title{font-size:1rem;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:.5rem;margin-bottom:1rem}
.empty-cart-msg{display:none;text-align:center;padding:2rem 1rem;color:var(--text-muted)}
.empty-cart-msg.visible{display:block}
</style>

<div class="edit-order-wrap">

  <!-- Header -->
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold flex items-center gap-2" style="color:var(--text-primary)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      Modifier la commande #<?= str_pad($commande['id'], 5, '0', STR_PAD_LEFT) ?>
    </h1>
    <a href="<?= BASE_URL ?>/?page=marketplace&action=track-order&id=<?= $commande['id'] ?>" class="cancel-btn">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour
    </a>
  </div>

  <?php if (!$canEdit): ?>
    <!-- Locked: admin already confirmed -->
    <div class="edit-locked-banner">
      <i data-lucide="lock" style="width:1.25rem;height:1.25rem;color:#dc2626"></i>
      <div>
        <div style="font-weight:700;color:#dc2626;margin-bottom:.25rem">Commande verrouillée</div>
        <div style="font-size:.875rem;color:#7f1d1d">
          L'administrateur a confirmé votre commande. La modification n'est plus possible.
          Contactez-nous si vous avez un problème.
        </div>
      </div>
    </div>
    <div class="text-center mt-6">
      <a href="<?= BASE_URL ?>/?page=marketplace&action=track-order&id=<?= $commande['id'] ?>"
         class="btn btn-primary" style="display:inline-flex;align-items:center;gap:.5rem">
        <i data-lucide="map" style="width:1rem;height:1rem"></i> Suivre ma commande
      </a>
    </div>

  <?php else: ?>

    <!-- Info banner -->
    <div class="edit-info-banner">
      <i data-lucide="info" style="width:1.25rem;height:1.25rem;color:#f97316"></i>
      <div>
        <div style="font-weight:700;color:#ea580c;margin-bottom:.25rem">Modification autorisée</div>
        <div style="font-size:.875rem;color:#9a3412">
          Votre commande est encore <strong>en attente</strong> de confirmation.
          Vous pouvez modifier vos informations, retirer des produits, ou aller au marketplace pour ajouter d'autres produits.
        </div>
      </div>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="card mb-4" style="padding:1rem;background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.3)">
        <ul style="list-style:none;margin:0;padding:0">
          <?php foreach ($errors as $e): ?>
            <li style="color:#dc2626;font-size:.875rem;display:flex;align-items:center;gap:.5rem;padding:.25rem 0">
              <i data-lucide="alert-circle" style="width:.875rem;height:.875rem;flex-shrink:0"></i> <?= htmlspecialchars($e) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" id="editOrderForm"
          action="<?= BASE_URL ?>/?page=marketplace&action=update-order&id=<?= $commande['id'] ?>">

      <!-- Client info -->
      <div class="card mb-6" style="padding:1.5rem">
        <div class="section-title">
          <i data-lucide="user" style="width:1rem;height:1rem;color:var(--primary)"></i>
          Informations personnelles
        </div>

        <div class="form-row">
          <div class="field-group">
            <label for="client_nom">Nom complet <span style="color:#ef4444">*</span></label>
            <input id="client_nom" type="text" name="client_nom" class="form-input"
                   value="<?= htmlspecialchars($commande['client_nom']) ?>"
                   placeholder="Jean Dupont" required>
          </div>
          <div class="field-group">
            <label for="client_telephone">Téléphone <span style="color:#ef4444">*</span></label>
            <input id="client_telephone" type="tel" name="client_telephone" class="form-input"
                   value="<?= htmlspecialchars($commande['client_telephone'] ?? '') ?>"
                   placeholder="+216 12 345 678" required>
          </div>
        </div>

        <div class="field-group">
          <label for="client_email">Email <span style="color:#ef4444">*</span></label>
          <input id="client_email" type="email" name="client_email" class="form-input"
                 value="<?= htmlspecialchars($commande['client_email']) ?>"
                 placeholder="votre@email.com" required>
        </div>

        <div class="field-group" style="margin-bottom:0">
          <label for="client_adresse">Adresse de livraison <span style="color:#ef4444">*</span></label>
          <textarea id="client_adresse" name="client_adresse" class="form-input" rows="3"
                    placeholder="Numéro, rue, ville, code postal" required
                    style="resize:vertical"><?= htmlspecialchars($commande['client_adresse']) ?></textarea>
        </div>
      </div>

      <!-- Products -->
      <div class="card mb-6" style="padding:1.5rem">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem">
          <div class="section-title" style="margin-bottom:0">
            <i data-lucide="package" style="width:1rem;height:1rem;color:var(--accent-orange)"></i>
            Produits commandés
          </div>
          <!-- Go to Marketplace button -->
          <a href="<?= BASE_URL ?>/?page=marketplace"
             class="marketplace-btn" onclick="saveQuantitiesToSession(event)">
            <i data-lucide="shopping-basket" style="width:.9rem;height:.9rem"></i>
            Ajouter / modifier des produits
          </a>
        </div>

        <div id="products-container">
          <?php foreach ($lignes as $ligne): ?>
            <div class="product-row" data-product-id="<?= (int)$ligne['produit_id'] ?>">
              <div style="flex:1;min-width:0">
                <div class="prod-name"><?= htmlspecialchars($ligne['nom']) ?></div>
                <div class="prod-price"><?= number_format($ligne['prix_unitaire'], 2) ?> DT / unité</div>
              </div>
              <div style="display:flex;align-items:center;gap:.75rem;flex-shrink:0">
                <span style="font-size:.8rem;color:var(--text-muted)">Qté :</span>
                <input type="hidden" name="produit_ids[]" value="<?= (int)$ligne['produit_id'] ?>">
                <input type="hidden" name="prix_unitaires[]" value="<?= number_format($ligne['prix_unitaire'], 2, '.', '') ?>">
                <input type="number" name="quantites[]" class="qty-input"
                       value="<?= (int)$ligne['quantite'] ?>"
                       min="1" max="99" step="1">
                <span class="subtotal-display" style="font-size:.85rem;font-weight:700;color:var(--primary);min-width:4.5rem;text-align:right">
                  <?= number_format($ligne['quantite'] * $ligne['prix_unitaire'], 2) ?> DT
                </span>
                <!-- Remove button -->
                <button type="button" class="remove-btn" title="Retirer ce produit" onclick="removeProduct(this)">
                  <i data-lucide="x" style="width:.9rem;height:.9rem"></i>
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Empty message (hidden by default) -->
        <div id="empty-cart-msg" class="empty-cart-msg">
          <i data-lucide="package-x" style="width:2.5rem;height:2.5rem;color:var(--text-muted);margin:0 auto .75rem;display:block"></i>
          <p style="font-weight:600;margin-bottom:.25rem">Aucun produit dans la commande</p>
          <p style="font-size:.85rem">Allez au marketplace pour ajouter des produits à votre commande.</p>
          <a href="<?= BASE_URL ?>/?page=marketplace"
             class="marketplace-btn" style="margin-top:1rem" onclick="saveQuantitiesToSession(event)">
            <i data-lucide="shopping-basket" style="width:.9rem;height:.9rem"></i>
            Aller au Marketplace
          </a>
        </div>

        <div id="total-row" style="text-align:right;padding-top:.75rem;border-top:1px solid var(--border);margin-top:.5rem">
          <span style="font-size:.875rem;color:var(--text-muted)">Total estimé :</span>
          <span id="total-display" style="font-size:1.25rem;font-weight:800;color:var(--primary);margin-left:.5rem">
            <?= number_format($commande['total'], 2) ?> DT
          </span>
        </div>
      </div>

      <!-- Submit -->
      <div style="display:flex;gap:1rem;justify-content:flex-end;flex-wrap:wrap">
        <a href="<?= BASE_URL ?>/?page=marketplace&action=track-order&id=<?= $commande['id'] ?>"
           class="cancel-btn">
          <i data-lucide="x" style="width:1rem;height:1rem"></i> Annuler
        </a>
        <button type="submit" id="submitBtn" class="save-btn">
          <i data-lucide="save" style="width:1rem;height:1rem"></i> Enregistrer les modifications
        </button>
      </div>
    </form>

  <?php endif; ?>
</div>

<script>
// Remove a product row
function removeProduct(btn) {
  const row = btn.closest('.product-row');
  if (!row) return;

  // Animate removal
  row.style.transition = 'all .3s ease';
  row.style.opacity = '0';
  row.style.transform = 'translateX(30px)';
  setTimeout(() => {
    row.remove();
    recalc();
    checkEmpty();
    // Re-init lucide icons for the empty state
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }, 300);
}

// Check if there are no products left
function checkEmpty() {
  const rows = document.querySelectorAll('#products-container .product-row');
  const emptyMsg  = document.getElementById('empty-cart-msg');
  const totalRow  = document.getElementById('total-row');
  const submitBtn = document.getElementById('submitBtn');

  if (rows.length === 0) {
    emptyMsg.classList.add('visible');
    totalRow.style.display = 'none';
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.5';
    submitBtn.style.cursor = 'not-allowed';
  } else {
    emptyMsg.classList.remove('visible');
    totalRow.style.display = '';
    submitBtn.disabled = false;
    submitBtn.style.opacity = '1';
    submitBtn.style.cursor = 'pointer';
  }
}

// Live total recalculation
function recalc() {
  const rows = document.querySelectorAll('#products-container .product-row');
  let total = 0;
  rows.forEach(row => {
    const qtyInput   = row.querySelector('input[name="quantites[]"]');
    const priceInput = row.querySelector('input[name="prix_unitaires[]"]');
    if (!qtyInput || !priceInput) return;
    const qty   = Math.max(1, parseInt(qtyInput.value) || 1);
    const price = parseFloat(priceInput.value) || 0;
    const subtotal = qty * price;
    total += subtotal;
    const display = row.querySelector('.subtotal-display');
    if (display) display.textContent = subtotal.toFixed(2) + ' DT';
  });
  const disp = document.getElementById('total-display');
  if (disp) disp.textContent = total.toFixed(2) + ' DT';
}

document.querySelectorAll('input[name="quantites[]"]').forEach(inp => {
  inp.addEventListener('input', recalc);
});
</script>
