<!-- Vue FrontOffice : Liste des produits marketplace -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
        <i data-lucide="shopping-basket" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Marketplace</h1>
        <p class="text-sm" style="color:var(--text-muted)">Produits locaux et durables</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="btn btn-secondary btn-round"><i data-lucide="shopping-cart" style="width:1rem;height:1rem"></i> Commander</a>
  </div>

  <!-- Filtres -->
  <div class="card mb-6" style="padding:1.25rem">
    <form novalidate method="GET" class="flex flex-wrap gap-4 items-end">
      <input type="hidden" name="page" value="marketplace">
      <div class="flex-1" style="min-width:180px">
        <label class="form-label"><i data-lucide="search" style="width:0.75rem;height:0.75rem"></i> Rechercher</label>
        <input type="text" name="search" class="form-input" placeholder="Nom du produit..." value="<?= htmlspecialchars($search) ?>">
      </div>
      <div>
        <label class="form-label"><i data-lucide="tag" style="width:0.75rem;height:0.75rem"></i> Catégorie</label>
        <select name="categorie" class="form-input">
          <option value="">Toutes</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="form-label"><i data-lucide="leaf" style="width:0.75rem;height:0.75rem"></i> Bio</label>
        <select name="bio" class="form-input">
          <option value="">Tous</option>
          <option value="1" <?= $bio === '1' ? 'selected' : '' ?>>🌱 Bio</option>
          <option value="0" <?= $bio === '0' ? 'selected' : '' ?>>Non bio</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm"><i data-lucide="filter" style="width:0.75rem;height:0.75rem"></i> Filtrer</button>
      <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-outline btn-sm"><i data-lucide="x" style="width:0.75rem;height:0.75rem"></i></a>
    </form>
  </div>

  <!-- Grille produits -->
  <?php if (empty($produits)): ?>
    <div class="card text-center" style="padding:4rem 2rem">
      <i data-lucide="search-x" style="width:3rem;height:3rem;color:var(--text-muted);display:inline-block;margin-bottom:1rem"></i>
      <h3 class="text-xl font-semibold mb-2" style="color:var(--primary)">Aucun produit trouvé</h3>
      <p style="color:var(--text-secondary)">Essayez d'autres critères.</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-3 gap-6">
      <?php foreach ($produits as $p): ?>
        <div class="card hover-shadow card-interactive" style="padding:0;overflow:hidden;border:none">
          <div style="height:10rem;background:var(--muted);position:relative;overflow:hidden">
            <?php if (!empty($p['image'])): ?>
              <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            <?php else: ?>
              <div class="flex items-center justify-center" style="height:100%"><i data-lucide="package" style="width:2.5rem;height:2.5rem;color:var(--text-muted)"></i></div>
            <?php endif; ?>
            <div class="absolute flex gap-1" style="top:0.5rem;left:0.5rem">
              <?php if ($p['is_bio']): ?><span class="badge badge-success"><i data-lucide="leaf" style="width:0.6rem;height:0.6rem"></i> Bio</span><?php endif; ?>
              <?php if (!empty($p['categorie'])): ?><span class="badge badge-gray"><?= htmlspecialchars($p['categorie']) ?></span><?php endif; ?>
            </div>
          </div>
          <div style="padding:1rem">
            <h3 class="font-semibold mb-1" style="color:var(--primary)"><?= htmlspecialchars($p['nom']) ?></h3>
            <div class="text-xs mb-2 flex items-center gap-1" style="color:var(--text-muted)"><i data-lucide="store" style="width:0.65rem;height:0.65rem"></i> <?= htmlspecialchars($p['producteur']) ?></div>
            <div class="flex items-center justify-between mt-3">
              <span class="text-lg font-bold" style="color:var(--primary)"><?= number_format($p['prix'], 2) ?> DT</span>
              <a href="<?= BASE_URL ?>/?page=marketplace&action=detail&id=<?= $p['id'] ?>" class="btn btn-secondary btn-sm" style="padding:0.35rem 0.75rem;font-size:0.75rem"><i data-lucide="eye" style="width:0.75rem;height:0.75rem"></i> Voir</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
