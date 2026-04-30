<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="pen-line" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Soumettre un article
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">Il sera en attente puis validé par un admin.</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
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

  <form method="post" action="<?= BASE_URL ?>/?page=article&action=add" onsubmit="return validateVisitorArticleForm();">
    <div class="card" style="padding:1.5rem;border:1px solid var(--border)">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Titre</label>
          <input type="text" class="input" name="titre" id="vArticleTitre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" placeholder="Titre de l'article" />
          <div id="vArticleTitreErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
        </div>
        <div>
          <label class="label">Votre nom</label>
          <input type="text" class="input" name="auteur" id="vArticleAuteur" value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>" placeholder="Ex: Amine" />
          <div id="vArticleAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
        </div>
      </div>

      <div style="margin-top:1rem">
        <label class="label">Contenu</label>
        <textarea class="input" name="contenu" id="vArticleContenu" rows="10" placeholder="Votre article..."><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div id="vArticleContenuErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
      </div>

      <div style="margin-top:1rem;display:flex;justify-content:flex-end">
        <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">
          <i data-lucide="send" style="width:1rem;height:1rem"></i> Soumettre
        </button>
      </div>
    </div>
  </form>
</div>

<script>
function validateVisitorArticleForm() {
  const titre = document.getElementById('vArticleTitre');
  const auteur = document.getElementById('vArticleAuteur');
  const contenu = document.getElementById('vArticleContenu');
  const titreErr = document.getElementById('vArticleTitreErr');
  const auteurErr = document.getElementById('vArticleAuteurErr');
  const contenuErr = document.getElementById('vArticleContenuErr');

  let ok = true;
  titreErr.style.display = 'none';
  auteurErr.style.display = 'none';
  contenuErr.style.display = 'none';

  const t = (titre.value || '').trim();
  const a = (auteur.value || '').trim();
  const c = (contenu.value || '').trim();

  if (t.length < 3) { titreErr.textContent = "Titre obligatoire (min 3 caractères)."; titreErr.style.display = 'block'; ok = false; }
  if (a.length < 1) { auteurErr.textContent = "Nom obligatoire."; auteurErr.style.display = 'block'; ok = false; }
  if (c.length < 20) { contenuErr.textContent = "Contenu obligatoire (min 20 caractères)."; contenuErr.style.display = 'block'; ok = false; }
  return ok;
}
</script>

