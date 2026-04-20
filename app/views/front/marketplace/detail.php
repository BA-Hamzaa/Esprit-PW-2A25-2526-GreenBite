<!-- Vue FrontOffice : Détail d'un produit -->
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=marketplace" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux produits
  </a>

  <div class="card" style="padding:0;overflow:hidden">
    <div class="grid grid-cols-2 gap-0">
      <!-- Image -->
      <div style="height:22rem;background:var(--muted);overflow:hidden">
        <?php if (!empty($produit['image'])): ?>
          <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" style="width:100%;height:100%;object-fit:cover">
        <?php else: ?>
          <div class="flex items-center justify-center" style="height:100%"><i data-lucide="package" style="width:4rem;height:4rem;color:var(--text-muted)"></i></div>
        <?php endif; ?>
      </div>

      <!-- Infos -->
      <div style="padding:2rem">
        <div class="flex flex-wrap gap-2 mb-3">
          <?php if ($produit['is_bio']): ?><span class="badge badge-success"><i data-lucide="leaf" style="width:0.65rem;height:0.65rem"></i> Bio</span><?php endif; ?>
          <?php if (!empty($produit['categorie'])): ?><span class="badge badge-gray"><?= htmlspecialchars($produit['categorie']) ?></span><?php endif; ?>
          <?php if ($produit['stock'] > 0): ?><span class="badge badge-green-light">En stock</span><?php else: ?><span class="badge badge-red-light">Rupture</span><?php endif; ?>
        </div>

        <h1 class="text-2xl font-bold mb-1" style="color:var(--text-primary);font-family:var(--font-heading)"><?= htmlspecialchars($produit['nom']) ?></h1>
        <div class="flex items-center gap-2 mb-4 text-sm" style="color:var(--text-muted)">
          <i data-lucide="store" style="width:0.875rem;height:0.875rem"></i>
          <span><?= htmlspecialchars($produit['producteur']) ?></span>
        </div>

        <div class="text-3xl font-bold mb-4" style="color:var(--primary)"><?= number_format($produit['prix'], 2) ?> DT</div>

        <p style="color:var(--text-secondary);line-height:1.7;margin-bottom:1.5rem;font-size:0.9rem"><?= nl2br(htmlspecialchars($produit['description'])) ?></p>

        <div class="flex gap-3 mb-6" style="border-top:1px solid var(--border);padding-top:1.25rem">
          <div class="p-3 rounded-xl text-center flex-1" style="background:var(--muted)">
            <div class="text-xs" style="color:var(--text-muted)"><i data-lucide="warehouse" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle"></i> Stock</div>
            <div class="font-bold" style="color:var(--text-primary)"><?= $produit['stock'] ?></div>
          </div>
          <div class="p-3 rounded-xl text-center flex-1" style="background:var(--muted)">
            <div class="text-xs" style="color:var(--text-muted)"><i data-lucide="calendar" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle"></i> Ajouté le</div>
            <div class="font-bold" style="color:var(--text-primary)"><?= date('d/m/Y', strtotime($produit['created_at'])) ?></div>
          </div>
        </div>

        <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="btn btn-primary btn-block btn-lg rounded-xl">
          <i data-lucide="shopping-cart" style="width:1.125rem;height:1.125rem"></i> Commander ce produit
        </a>
      </div>
    </div>
  </div>
</div>
