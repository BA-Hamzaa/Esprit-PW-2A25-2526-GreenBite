<!-- Vue FrontOffice : Marketplace -->
<div style="padding:2rem;position:relative">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:1rem;box-shadow:0 6px 18px rgba(202,138,4,0.18);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="shopping-basket" style="width:1.625rem;height:1.625rem;color:#ca8a04"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,#ca8a04,var(--accent-orange));border-radius:2px"></span>
          Marketplace Bio
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="map-pin" style="width:0.75rem;height:0.75rem;color:#ca8a04"></i>
          Produits locaux et durables
        </p>
      </div>
    </div>
    <?php $cartCount = isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0; ?>
    <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="btn btn-secondary" style="border-radius:var(--radius-full);position:relative">
      <i data-lucide="shopping-cart" style="width:1rem;height:1rem"></i> Mon Panier
      <?php if ($cartCount > 0): ?>
        <span style="position:absolute;top:-6px;right:-6px;min-width:1.25rem;height:1.25rem;background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border-radius:999px;font-size:0.65rem;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 0.3rem;border:2px solid var(--card)">
          <?= $cartCount ?>
        </span>
      <?php endif; ?>
    </a>
  </div>

  <!-- Cart mini-banner -->
  <?php if ($cartCount > 0): ?>
    <div style="background:linear-gradient(135deg,rgba(249,115,22,0.08),rgba(239,68,68,0.04));border:1px solid rgba(249,115,22,0.25);border-radius:var(--radius-xl);padding:0.875rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem">
      <div style="display:flex;align-items:center;gap:0.625rem">
        <i data-lucide="shopping-cart" style="width:1.1rem;height:1.1rem;color:#f97316"></i>
        <span style="font-size:0.875rem;font-weight:600;color:var(--text-primary)">
          Vous avez <strong style="color:#f97316"><?= $cartCount ?> article<?= $cartCount > 1 ? 's' : '' ?></strong> dans votre panier
        </span>
      </div>
      <div style="display:flex;gap:0.5rem">
        <?php if (isset($_SESSION['editing_order_id'])): ?>
            <a href="<?= BASE_URL ?>/?page=marketplace&action=edit-order&id=<?= $_SESSION['editing_order_id'] ?>" class="btn btn-sm" style="background:linear-gradient(135deg,#ca8a04,#d97706);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.75rem">
              <i data-lucide="edit-3" style="width:0.7rem;height:0.7rem"></i> Retour à la modification
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="btn btn-sm" style="background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.75rem">
              <i data-lucide="credit-card" style="width:0.7rem;height:0.7rem"></i> Commander
            </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/?page=marketplace&action=clear-cart" class="btn btn-outline btn-sm" style="border-radius:var(--radius-full);font-size:0.75rem;color:var(--destructive);border-color:var(--destructive)"
           data-confirm="Vider votre panier ?" data-confirm-title="Vider le panier" data-confirm-type="warning" data-confirm-btn="Vider">
          <i data-lucide="trash-2" style="width:0.7rem;height:0.7rem"></i> Vider
        </a>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['editing_order_id']) && $cartCount === 0): ?>
    <div style="background:linear-gradient(135deg,rgba(202,138,4,0.08),rgba(217,119,6,0.04));border:1px solid rgba(202,138,4,0.25);border-radius:var(--radius-xl);padding:0.875rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem">
      <div style="display:flex;align-items:center;gap:0.625rem">
        <i data-lucide="edit-3" style="width:1.1rem;height:1.1rem;color:#ca8a04"></i>
        <span style="font-size:0.875rem;font-weight:600;color:var(--text-primary)">
          Vous modifiez la commande <strong style="color:#ca8a04">#<?= str_pad($_SESSION['editing_order_id'], 5, '0', STR_PAD_LEFT) ?></strong>. Ajoutez des produits pour continuer.
        </span>
      </div>
      <a href="<?= BASE_URL ?>/?page=marketplace&action=edit-order&id=<?= $_SESSION['editing_order_id'] ?>" class="btn btn-sm" style="background:linear-gradient(135deg,#ca8a04,#d97706);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.75rem">
        <i data-lucide="edit-3" style="width:0.7rem;height:0.7rem"></i> Voir la commande
      </a>
    </div>
  <?php endif; ?>

  <!-- Filter Card -->
  <div class="card mb-6" style="padding:1.25rem;border:1px solid rgba(202,138,4,0.12);background:linear-gradient(135deg,rgba(254,249,195,0.4),rgba(255,255,255,0))">
    <form novalidate method="GET" style="display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-end">
      <input type="hidden" name="page" value="marketplace">

      <div style="flex:1;min-width:180px">
        <label class="form-label" style="color:#ca8a04">
          <i data-lucide="search" style="width:0.75rem;height:0.75rem"></i> Rechercher
        </label>
        <div style="position:relative">
          <i data-lucide="search" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);width:0.875rem;height:0.875rem;color:var(--text-muted);pointer-events:none"></i>
          <input type="text" name="search" class="form-input" placeholder="Nom du produit..." value="<?= htmlspecialchars($search) ?>" style="padding-left:2.25rem;border-radius:var(--radius-xl)">
        </div>
      </div>

      <div style="min-width:140px">
        <label class="form-label" style="color:#ca8a04">
          <i data-lucide="tag" style="width:0.75rem;height:0.75rem"></i> Catégorie
        </label>
        <select name="categorie" class="form-select" style="width:100%;border-radius:var(--radius-xl)">
          <option value="">Toutes les catégories</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="min-width:120px">
        <label class="form-label" style="color:#ca8a04">
          <i data-lucide="leaf" style="width:0.75rem;height:0.75rem"></i> Type
        </label>
        <select name="bio" class="form-select" style="width:100%;border-radius:var(--radius-xl)">
          <option value="">Tous</option>
          <option value="1" <?= $bio === '1' ? 'selected' : '' ?>>🌱 Bio</option>
          <option value="0" <?= $bio === '0' ? 'selected' : '' ?>>Non bio</option>
        </select>
      </div>

      <div style="display:flex;gap:0.5rem;align-items:flex-end">
        <button type="submit" class="btn btn-sm" style="background:linear-gradient(135deg,#ca8a04,#d97706);color:#fff;border:none;border-radius:var(--radius-full);box-shadow:0 4px 12px rgba(202,138,4,0.25)">
          <i data-lucide="filter" style="width:0.75rem;height:0.75rem"></i> Filtrer
        </button>
        <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-outline btn-sm" style="border-radius:var(--radius-full)" title="Réinitialiser">
          <i data-lucide="x" style="width:0.75rem;height:0.75rem"></i>
        </a>
      </div>
    </form>
  </div>

  <!-- Products Grid -->
  <?php if (empty($produits)): ?>
    <div class="card" style="padding:4rem 2rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5rem;height:5rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:50%;margin-bottom:1.25rem">
        <i data-lucide="search-x" style="width:2.5rem;height:2.5rem;color:#ca8a04"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.25rem;font-weight:700;color:var(--primary);margin-bottom:0.5rem">Aucun produit trouvé</h3>
      <p style="color:var(--text-secondary)">Essayez d'autres critères de recherche.</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-6">
      <?php foreach ($produits as $p):
        $inCart = isset($_SESSION['panier'][$p['id']]) ? $_SESSION['panier'][$p['id']] : 0;
        $productPhoto = MediaHelper::url($p['image'] ?? '', MediaHelper::fallbackProduit($p['categorie'] ?? ''));
      ?>
        <div class="card card-interactive card-glow" style="padding:0;overflow:hidden;border:1px solid var(--border)<?= $inCart > 0 ? ';outline:2px solid rgba(249,115,22,0.35)' : '' ?>">

          <!-- Product image -->
          <div style="height:11rem;background:linear-gradient(135deg,var(--muted),var(--border));position:relative;overflow:hidden">
            <img src="<?= htmlspecialchars($productPhoto) ?>"
                 alt="<?= htmlspecialchars($p['nom']) ?>"
                 loading="lazy" decoding="async"
                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s cubic-bezier(0.4,0,0.2,1)"
                 onmouseover="this.style.transform='scale(1.06)'"
                 onmouseout="this.style.transform='scale(1)'">

            <!-- Overlay gradient -->
            <div style="position:absolute;bottom:0;left:0;right:0;height:3.5rem;background:linear-gradient(transparent,rgba(0,0,0,0.35))"></div>

            <!-- Badges -->
            <div style="position:absolute;top:0.625rem;left:0.625rem;display:flex;gap:0.35rem;flex-wrap:wrap">
              <?php if ($p['is_bio']): ?>
                <span class="badge badge-success" style="backdrop-filter:blur(6px);font-size:0.6rem">
                  <i data-lucide="leaf" style="width:0.55rem;height:0.55rem"></i> Bio
                </span>
              <?php endif; ?>
              <?php if (!empty($p['categorie'])): ?>
                <span class="badge badge-gray" style="backdrop-filter:blur(6px);font-size:0.6rem"><?= htmlspecialchars($p['categorie']) ?></span>
              <?php endif; ?>
              <?php if ($inCart > 0): ?>
                <span style="backdrop-filter:blur(6px);background:rgba(249,115,22,0.85);color:#fff;border-radius:999px;font-size:0.6rem;font-weight:700;padding:0.15rem 0.5rem">
                  🛒 ×<?= $inCart ?>
                </span>
              <?php endif; ?>
            </div>

            <!-- Price on image -->
            <div style="position:absolute;bottom:0.5rem;right:0.625rem;background:rgba(255,255,255,0.92);backdrop-filter:blur(8px);color:#ca8a04;font-family:var(--font-heading);font-weight:900;font-size:0.9rem;padding:0.2rem 0.6rem;border-radius:var(--radius-full);box-shadow:0 2px 8px rgba(0,0,0,0.12)">
              <?= number_format($p['prix'], 2) ?> DT
            </div>
          </div>

          <!-- Card body -->
          <div style="padding:1rem">
            <h3 style="font-family:var(--font-heading);font-weight:700;color:var(--text-primary);margin-bottom:0.25rem;font-size:0.95rem"><?= htmlspecialchars($p['nom']) ?></h3>
            <div style="display:flex;align-items:center;gap:0.35rem;font-size:0.76rem;color:var(--text-muted);margin-bottom:0.875rem">
              <i data-lucide="store" style="width:0.65rem;height:0.65rem;color:#ca8a04"></i>
              <span><?= htmlspecialchars($p['producteur']) ?></span>
              <span style="margin-left:auto;font-size:0.7rem;color:<?= $p['stock'] > 0 ? 'var(--secondary)' : 'var(--destructive)' ?>;font-weight:600">
                <?= $p['stock'] > 0 ? 'Stock: ' . $p['stock'] : 'Rupture' ?>
              </span>
            </div>

            <!-- Action footer -->
            <div style="padding-top:0.75rem;border-top:1px solid var(--border)">
              <?php if ($p['stock'] > 0): ?>
                <form method="POST" action="<?= BASE_URL ?>/?page=marketplace&action=add-to-cart">
                  <input type="hidden" name="produit_id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="redirect" value="<?= BASE_URL ?>/?page=marketplace<?= !empty($search) || !empty($categorie) || $bio !== '' ? '&search='.urlencode($search).'&categorie='.urlencode($categorie).'&bio='.urlencode($bio) : '' ?>">
                  <div style="display:flex;align-items:center;gap:0.4rem">
                    <!-- Quantity stepper -->
                    <div style="display:flex;align-items:center;border:1.5px solid var(--border);border-radius:var(--radius-full);overflow:hidden;background:var(--surface);flex-shrink:0">
                      <button type="button"
                              onclick="let i=this.nextElementSibling;i.value=Math.max(1,parseInt(i.value||1)-1)"
                              style="width:1.75rem;height:1.75rem;background:none;border:none;cursor:pointer;font-size:1rem;font-weight:700;color:var(--text-secondary);display:flex;align-items:center;justify-content:center;transition:all 0.15s"
                              onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='none'">−</button>
                      <input type="number" name="quantite" value="1" min="1" max="<?= $p['stock'] ?>"
                             style="width:2rem;text-align:center;border:none;outline:none;font-size:0.8rem;font-weight:700;color:var(--text-primary);background:transparent;-moz-appearance:textfield"
                             oninput="this.value=Math.max(1,Math.min(<?= $p['stock'] ?>,parseInt(this.value)||1))">
                      <button type="button"
                              onclick="let i=this.previousElementSibling;i.value=Math.min(<?= $p['stock'] ?>,parseInt(i.value||1)+1)"
                              style="width:1.75rem;height:1.75rem;background:none;border:none;cursor:pointer;font-size:1rem;font-weight:700;color:var(--text-secondary);display:flex;align-items:center;justify-content:center;transition:all 0.15s"
                              onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='none'">+</button>
                    </div>
                    <!-- Submit -->
                    <button type="submit" style="flex:1;background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.75rem;font-weight:600;padding:0.4rem 0.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.3rem;transition:all 0.2s;box-shadow:0 3px 10px rgba(249,115,22,0.3)"
                            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 5px 15px rgba(249,115,22,0.4)'"
                            onmouseout="this.style.transform='none';this.style.boxShadow='0 3px 10px rgba(249,115,22,0.3)'">
                      <i data-lucide="shopping-cart" style="width:0.7rem;height:0.7rem"></i>
                      <?= $inCart > 0 ? 'Ajouter encore' : 'Ajouter au panier' ?>
                    </button>
                    <!-- Detail link -->
                    <a href="<?= BASE_URL ?>/?page=marketplace&action=detail&id=<?= $p['id'] ?>"
                       style="width:1.9rem;height:1.9rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#fff;border-radius:var(--radius-full);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.2s"
                       title="Voir le détail"
                       onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                      <i data-lucide="eye" style="width:0.75rem;height:0.75rem"></i>
                    </a>
                  </div>
                </form>
              <?php else: ?>
                <div style="display:flex;align-items:center;gap:0.4rem">
                  <span style="flex:1;text-align:center;font-size:0.75rem;color:var(--text-muted);background:var(--muted);border-radius:var(--radius-full);padding:0.4rem;font-weight:500">Rupture de stock</span>
                  <a href="<?= BASE_URL ?>/?page=marketplace&action=detail&id=<?= $p['id'] ?>"
                     style="width:1.9rem;height:1.9rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#fff;border-radius:var(--radius-full);display:flex;align-items:center;justify-content:center;flex-shrink:0"
                     title="Voir le détail">
                    <i data-lucide="eye" style="width:0.75rem;height:0.75rem"></i>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<style>
/* Hide number input spinner arrows */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button { -webkit-appearance:none; margin:0; }
input[type=number] { -moz-appearance:textfield; }
</style>
