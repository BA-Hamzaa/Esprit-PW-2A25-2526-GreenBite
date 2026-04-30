<?php
// Same role options as front add form
$roles = [
    'Passionné de cuisine'     => '🍳 Passionné de cuisine',
    'Chef cuisinier'           => '👨‍🍳 Chef cuisinier',
    'Nutritionniste'           => '🥗 Nutritionniste',
    'Diététicien(ne)'          => '📋 Diététicien(ne)',
    'Étudiant en nutrition'    => '🎓 Étudiant en nutrition',
    'Athlète / Sportif'        => '🏋️ Athlète / Sportif',
    'Parent'                   => '👨‍👩‍👧 Parent',
    'Jardinier urbain'         => '🌻 Jardinier urbain',
    'Food lover'               => '🍕 Food lover',
    'Éco-activiste'            => '🌍 Éco-activiste',
    'Autre'                    => '✨ Autre',
];
?>

<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="edit-3" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Modifier l'article
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">ID #<?= (int)$article['id'] ?></p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
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

  <?php
    $valTitre   = $_POST['titre']   ?? ($article['titre'] ?? '');
    $valAuteur  = $_POST['auteur']  ?? ($article['auteur'] ?? 'Admin');
    $valRole    = $_POST['role_utilisateur'] ?? ($article['role_utilisateur'] ?? 'Passionné de cuisine');
    $valContenu = $_POST['contenu'] ?? ($article['contenu'] ?? '');
    $valStatut  = $_POST['statut']  ?? ($article['statut'] ?? 'brouillon');
  ?>

  <form method="post" action="<?= BASE_URL ?>/?page=admin-article&action=edit&id=<?= (int)$article['id'] ?>" onsubmit="return validateArticleForm();">
    <div class="card" style="padding:1.5rem;border:1px solid var(--border)">

      <!-- ROW 1: Title + Author -->
      <div class="grid grid-cols-2 gap-4" style="margin-bottom:1rem">
        <div>
          <label class="label">📝 Titre</label>
          <input type="text" class="input" name="titre" id="articleTitre" value="<?= htmlspecialchars($valTitre) ?>" />
          <div id="articleTitreErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>
        <div>
          <label class="label">👤 Auteur</label>
          <input type="text" class="input" name="auteur" id="articleAuteur" value="<?= htmlspecialchars($valAuteur) ?>" />
          <div id="articleAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>
      </div>

      <!-- ROW 2: Role + Statut -->
      <div class="grid grid-cols-2 gap-4" style="margin-bottom:1rem">
        <div>
          <label class="label">🏷️ Rôle de l'utilisateur</label>
          <select class="input" name="role_utilisateur" id="articleRole"
                  style="appearance:none;background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23555b6e%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22/></svg>');background-repeat:no-repeat;background-position:right 0.75rem center;background-size:1.1rem;padding-right:2.5rem;">
            <?php foreach ($roles as $value => $label): ?>
              <option value="<?= htmlspecialchars($value) ?>" <?= $valRole === $value ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div id="articleRoleErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>
        <div>
          <label class="label">📌 Statut</label>
          <select class="input" name="statut" id="articleStatut">
            <option value="brouillon" <?= $valStatut === 'brouillon' ? 'selected' : '' ?>>📝 brouillon</option>
            <option value="en_attente" <?= $valStatut === 'en_attente' ? 'selected' : '' ?>>⏳ en_attente</option>
            <option value="publie" <?= $valStatut === 'publie' ? 'selected' : '' ?>>✅ publie</option>
          </select>
        </div>
      </div>

      <!-- ROW 3: Content -->
      <div style="margin-bottom:1rem">
        <label class="label">✍️ Contenu</label>
        <textarea class="input" name="contenu" id="articleContenu" rows="10"><?= htmlspecialchars($valContenu) ?></textarea>
        <div id="articleContenuErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
      </div>

      <!-- BUTTONS -->
      <div style="display:flex;justify-content:flex-end;align-items:center;gap:0.5rem;flex-wrap:wrap;border-top:1px solid var(--border);padding-top:1.2rem">
        <?php if (($article['statut'] ?? '') !== 'publie'): ?>
          <a href="<?= BASE_URL ?>/?page=admin-article&action=publish&id=<?= (int)$article['id'] ?>" class="btn" style="border-radius:var(--radius-full);background:rgba(82,183,136,0.08);border:1px solid rgba(82,183,136,0.18);color:var(--primary)" onclick="return confirm('Publier cet article ?')">
            <i data-lucide="check-circle-2" style="width:1rem;height:1rem"></i> Publier
          </a>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">
          <i data-lucide="save" style="width:1rem;height:1rem"></i> Enregistrer
        </button>
      </div>

    </div>
  </form>
</div>

<script>
function validateArticleForm() {
  const titre   = document.getElementById('articleTitre');
  const auteur  = document.getElementById('articleAuteur');
  const role    = document.getElementById('articleRole');
  const contenu = document.getElementById('articleContenu');
  const statut  = document.getElementById('articleStatut');

  const titreErr   = document.getElementById('articleTitreErr');
  const auteurErr  = document.getElementById('articleAuteurErr');
  const roleErr    = document.getElementById('articleRoleErr');
  const contenuErr = document.getElementById('articleContenuErr');

  let ok = true;

  titreErr.style.display   = 'none';
  auteurErr.style.display  = 'none';
  roleErr.style.display    = 'none';
  contenuErr.style.display = 'none';

  const t = (titre.value || '').trim();
  const a = (auteur.value || '').trim();
  const r = role.value || '';
  const c = (contenu.value || '').trim();

  if (t.length < 3) { titreErr.textContent = "Titre obligatoire (min 3 caractères)."; titreErr.style.display = 'block'; ok = false; }
  if (a.length < 1) { auteurErr.textContent = "Auteur obligatoire."; auteurErr.style.display = 'block'; ok = false; }
  if (!r) { roleErr.textContent = "Veuillez sélectionner un rôle."; roleErr.style.display = 'block'; ok = false; }
  if (c.length < 20) { contenuErr.textContent = "Contenu obligatoire (min 20 caractères)."; contenuErr.style.display = 'block'; ok = false; }

  const allowed = ['brouillon','en_attente','publie'];
  if (allowed.indexOf(statut.value) === -1) ok = false;
  return ok;
}
</script>