<!-- Vue BackOffice : Modifier un produit -->
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=list" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux produits
  </a>
  <div class="flex items-center gap-3 mb-6">
    <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
      <i data-lucide="edit-3" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Modifier : <?= htmlspecialchars($produit['nom']) ?></h1>
      <p class="text-sm" style="color:var(--text-muted)">Produit #<?= $produit['id'] ?> • Mis à jour</p>
    </div>
  </div>

  <div id="toastContainer"></div>

  <div class="card" style="padding:0;overflow:hidden">
    <div style="display:flex;border-bottom:1px solid var(--border)">
      <div style="flex:1;padding:1rem;text-align:center;border-bottom:3px solid var(--primary);color:var(--primary);font-weight:600;font-size:0.85rem">
        <i data-lucide="package" style="width:1rem;height:1rem;display:inline;vertical-align:middle"></i> Informations
      </div>
      <div style="flex:1;padding:1rem;text-align:center;border-bottom:3px solid transparent;color:var(--text-muted);font-weight:500;font-size:0.85rem">
        <i data-lucide="settings-2" style="width:1rem;height:1rem;display:inline;vertical-align:middle"></i> Détails
      </div>
      <div style="flex:1;padding:1rem;text-align:center;border-bottom:3px solid transparent;color:var(--text-muted);font-weight:500;font-size:0.85rem">
        <i data-lucide="image" style="width:1rem;height:1rem;display:inline;vertical-align:middle"></i> Média
      </div>
    </div>

    <form novalidate method="POST" enctype="multipart/form-data" id="produitForm" style="padding:2rem">
      <h3 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)">
        <i data-lucide="package" style="width:1rem;height:1rem;color:var(--primary)"></i> Informations générales
      </h3>
      <div class="form-group">
        <label class="form-label" for="nom"><i data-lucide="type" style="width:0.75rem;height:0.75rem"></i> Nom du produit <span style="color:var(--destructive)">*</span></label>
        <input type="text" name="nom" id="nom" class="form-input" value="<?= htmlspecialchars($_POST['nom'] ?? $produit['nom']) ?>" style="padding:0.85rem 1rem;border-radius:var(--radius-xl)">
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="categorie"><i data-lucide="tag" style="width:0.75rem;height:0.75rem"></i> Catégorie</label>
          <select name="categorie" id="categorie" class="form-input" style="padding:0.85rem 1rem;border-radius:var(--radius-xl)">
            <option value="">-- Choisir --</option>
            <?php $cats = ['fruit','légume','céréale','protéine','laitier','boisson','épice','autre'];
            foreach ($cats as $c): ?>
              <option value="<?= $c ?>" <?= (($_POST['categorie'] ?? $produit['categorie']) === $c) ? 'selected' : '' ?>><?= ucfirst($c) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" for="producteur"><i data-lucide="store" style="width:0.75rem;height:0.75rem"></i> Producteur</label>
          <input type="text" name="producteur" id="producteur" class="form-input" value="<?= htmlspecialchars($_POST['producteur'] ?? $produit['producteur'] ?? '') ?>" style="padding:0.85rem 1rem;border-radius:var(--radius-xl)">
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="description"><i data-lucide="align-left" style="width:0.75rem;height:0.75rem"></i> Description</label>
        <textarea name="description" id="description" class="form-textarea" rows="3" style="border-radius:var(--radius-xl)"><?= htmlspecialchars($_POST['description'] ?? $produit['description']) ?></textarea>
      </div>

      <div style="border-top:1px solid var(--border);padding-top:1.5rem;margin-top:0.5rem">
        <h3 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)">
          <i data-lucide="settings-2" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Prix & Stock
        </h3>
        <div class="grid grid-cols-3 gap-4">
          <div class="form-group">
            <label class="form-label" for="prix"><i data-lucide="banknote" style="width:0.75rem;height:0.75rem"></i> Prix (DT) <span style="color:var(--destructive)">*</span></label>
            <div style="position:relative">
              <input type="number" name="prix" id="prix" class="form-input" step="0.01" value="<?= htmlspecialchars($_POST['prix'] ?? $produit['prix']) ?>" style="padding:0.85rem 1rem;border-radius:var(--radius-xl);padding-right:3rem">
              <span style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:0.8rem;font-weight:600">DT</span>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="stock"><i data-lucide="warehouse" style="width:0.75rem;height:0.75rem"></i> Stock</label>
            <input type="number" name="stock" id="stock" class="form-input" value="<?= htmlspecialchars($_POST['stock'] ?? $produit['stock']) ?>" style="padding:0.85rem 1rem;border-radius:var(--radius-xl)">
          </div>
          <div class="form-group">
            <label class="form-label"><i data-lucide="leaf" style="width:0.75rem;height:0.75rem"></i> Bio ?</label>
            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem 1rem;background:var(--muted);border-radius:var(--radius-xl);border:1px solid var(--border)">
              <label class="flex items-center gap-2" style="cursor:pointer;font-size:0.875rem;color:var(--text-primary)">
                <input type="radio" name="is_bio" value="1" <?= (($_POST['is_bio'] ?? $produit['is_bio'] ?? '0') == '1') ? 'checked' : '' ?> style="accent-color:var(--primary)"> 🌱 Oui
              </label>
              <label class="flex items-center gap-2" style="cursor:pointer;font-size:0.875rem;color:var(--text-primary)">
                <input type="radio" name="is_bio" value="0" <?= (($_POST['is_bio'] ?? $produit['is_bio'] ?? '0') == '0') ? 'checked' : '' ?> style="accent-color:var(--primary)"> Non
              </label>
            </div>
          </div>
        </div>
      </div>

      <div style="border-top:1px solid var(--border);padding-top:1.5rem;margin-top:0.5rem">
        <h3 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)">
          <i data-lucide="image" style="width:1rem;height:1rem;color:#7c3aed"></i> Image
        </h3>
        <?php if (!empty($produit['image'])): ?>
        <div class="flex items-center gap-4 p-3 rounded-xl mb-4" style="background:var(--muted);border:1px solid var(--border)">
          <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($produit['image']) ?>" alt="" style="width:4rem;height:4rem;object-fit:cover;border-radius:var(--radius-lg)">
          <div>
            <div class="text-sm font-medium" style="color:var(--text-primary)"><?= htmlspecialchars($produit['image']) ?></div>
            <div class="text-xs" style="color:var(--text-muted)">Image actuelle</div>
          </div>
        </div>
        <?php endif; ?>
        <div id="dropzone" style="border:2px dashed var(--border);border-radius:var(--radius-xl);padding:2rem;text-align:center;cursor:pointer;transition:all 0.3s;background:var(--muted)" onmouseover="this.style.borderColor='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)'" onclick="document.getElementById('image').click()">
          <i data-lucide="cloud-upload" style="width:2rem;height:2rem;color:var(--text-muted);display:inline-block;margin-bottom:0.5rem"></i>
          <p class="text-sm" style="color:var(--text-muted)">Changer l'image • JPG, PNG</p>
          <div id="preview" style="margin-top:1rem;display:none"><img id="previewImg" style="max-height:6rem;border-radius:var(--radius-lg);margin:0 auto"></div>
          <input type="file" name="image" id="image" accept="image/*" style="display:none">
        </div>
      </div>

      <div style="display:flex;gap:0.75rem;margin-top:2rem">
        <button type="submit" class="btn btn-primary btn-lg flex-1" style="border-radius:var(--radius-xl);padding:0.9rem">
          <i data-lucide="save" style="width:1.125rem;height:1.125rem"></i> Mettre à jour
        </button>
        <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=list" class="btn btn-outline btn-lg" style="border-radius:var(--radius-xl);padding:0.9rem">
          <i data-lucide="x" style="width:1.125rem;height:1.125rem"></i> Annuler
        </a>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(ev) {
      document.getElementById('previewImg').src = ev.target.result;
      document.getElementById('preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
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
document.getElementById('produitForm').addEventListener('submit', function(e) {
  let errors = [];
  const nom = document.getElementById('nom').value.trim();
  if (nom === '') errors.push('Le nom du produit est obligatoire.');
  else if (nom.length < 3) errors.push('Le nom doit contenir au moins 3 caractères.');
  const prix = document.getElementById('prix').value;
  if (prix === '' || parseFloat(prix) <= 0) errors.push('Le prix doit être un nombre positif.');
  if (errors.length > 0) { e.preventDefault(); errors.forEach(err => showToast('error', err)); }
});
</script>
