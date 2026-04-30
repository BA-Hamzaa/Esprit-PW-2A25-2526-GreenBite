<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="plus-circle" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Ajouter un article
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">Brouillon / En attente / Publié</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-article&action=list" class="btn" style="border-radius:var(--radius-xl);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour
    </a>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-4" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5">
      <div style="font-weight:800;margin-bottom:0.3rem">Veuillez corriger :</div>
      <ul style="margin:0;padding-left:1.2rem">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>/?page=admin-article&action=add" onsubmit="return validateArticleForm();">
    <div class="card" style="padding:1.5rem;border:1px solid var(--border)">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Titre</label>
          <input type="text" class="input" name="titre" id="articleTitre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" placeholder="Titre de l'article" />
          <div id="articleTitreErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
        </div>
        <div>
          <label class="label">Auteur</label>
          <input type="text" class="input" name="auteur" id="articleAuteur" value="<?= htmlspecialchars($_POST['auteur'] ?? 'Admin') ?>" placeholder="Nom de l'auteur" />
          <div id="articleAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
        </div>
      </div>

      <div style="margin-top:1rem">
        <label class="label">Contenu</label>
        <textarea class="input" name="contenu" id="articleContenu" rows="10" placeholder="Contenu de l'article..."><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div id="articleContenuErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
      </div>

      <div style="margin-top:1rem" class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Statut</label>
          <?php $st = $_POST['statut'] ?? 'brouillon'; ?>
          <select class="input" name="statut" id="articleStatut">
            <option value="brouillon" <?= $st === 'brouillon' ? 'selected' : '' ?>>brouillon</option>
            <option value="en_attente" <?= $st === 'en_attente' ? 'selected' : '' ?>>en_attente</option>
            <option value="publie" <?= $st === 'publie' ? 'selected' : '' ?>>publie</option>
          </select>
        </div>
        <div style="display:flex;align-items:flex-end;justify-content:flex-end;gap:0.5rem">
          <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-xl)">
            <i data-lucide="save" style="width:1rem;height:1rem"></i> Enregistrer
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
function validateArticleForm() {
  const titre = document.getElementById('articleTitre');
  const auteur = document.getElementById('articleAuteur');
  const contenu = document.getElementById('articleContenu');
  const statut = document.getElementById('articleStatut');

  const titreErr = document.getElementById('articleTitreErr');
  const auteurErr = document.getElementById('articleAuteurErr');
  const contenuErr = document.getElementById('articleContenuErr');

  let ok = true;

  titreErr.style.display = 'none';
  auteurErr.style.display = 'none';
  contenuErr.style.display = 'none';

  const t = (titre.value || '').trim();
  const a = (auteur.value || '').trim();
  const c = (contenu.value || '').trim();

  if (t.length < 3) { titreErr.textContent = "Titre obligatoire (min 3 caractères)."; titreErr.style.display = 'block'; ok = false; }
  if (a.length < 1) { auteurErr.textContent = "Auteur obligatoire."; auteurErr.style.display = 'block'; ok = false; }
  if (c.length < 20) { contenuErr.textContent = "Contenu obligatoire (min 20 caractères)."; contenuErr.style.display = 'block'; ok = false; }

  const allowed = ['brouillon','en_attente','publie'];
  if (allowed.indexOf(statut.value) === -1) ok = false;
  return ok;
}
</script>

