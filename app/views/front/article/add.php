<?php
// Creative role options for the user
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

<div style="padding:2rem;max-width:900px;margin:0 auto">

  <!-- HEADER -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:1.1rem;box-shadow:0 8px 24px rgba(234,179,8,0.3)">
        <i data-lucide="pen-line" style="width:1.75rem;height:1.75rem;color:#b45309"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.6rem;background:linear-gradient(180deg,#f59e0b,#d97706);border-radius:2px"></span>
          Soumettre un article
        </h1>
        <p style="font-size:0.85rem;color:var(--text-muted);margin:4px 0 0 0">
          Partagez votre expérience ! Votre article sera examiné puis publié par notre équipe. 🌿
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn btn-outline" style="border-radius:var(--radius-full)">
      <i data-lucide="arrow-left" style="width:1.1rem;height:1.1rem"></i> Retour au blog
    </a>
  </div>

  <!-- ERROR BOX -->
  <?php if (!empty($errors)): ?>
    <div style="padding:1rem 1.2rem;margin-bottom:1.5rem;border-radius:var(--radius);background:linear-gradient(135deg,#fef2f2,#fff5f5);color:#991b1b;border:2px solid #fca5a5;display:flex;align-items:flex-start;gap:0.75rem">
      <i data-lucide="alert-triangle" style="width:1.3rem;height:1.3rem;flex-shrink:0;margin-top:1px"></i>
      <div>
        <div style="font-weight:800;margin-bottom:0.4rem">Oups ! Veuillez corriger :</div>
        <ul style="margin:0;padding-left:1.2rem">
          <?php foreach ($errors as $e): ?>
            <li style="margin-bottom:0.2rem"><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <!-- FORM -->
  <form method="post" action="<?= BASE_URL ?>/?page=article&action=add" onsubmit="return validateVisitorArticleForm();">
    <div class="card" style="padding:2rem;border:2px solid var(--border);border-radius:1rem;">

      <!-- ROW 1: Title + Author -->
      <div class="grid grid-cols-2 gap-5" style="margin-bottom:1.5rem">
        <div>
          <label class="label" style="font-size:0.85rem;font-weight:700;margin-bottom:0.5rem">
            📝 Titre de l'article <span style="color:#ef4444">*</span>
          </label>
          <input type="text" class="input" name="titre" id="vArticleTitre"
                 value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
                 placeholder="Ex: Les bienfaits du jeûne intermittent..."
                 style="font-size:0.95rem;padding:0.75rem 1rem" />
          <div id="vArticleTitreErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>

        <div>
          <label class="label" style="font-size:0.85rem;font-weight:700;margin-bottom:0.5rem">
            👤 Votre nom <span style="color:#ef4444">*</span>
          </label>
          <input type="text" class="input" name="auteur" id="vArticleAuteur"
                 value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>"
                 placeholder="Ex: Amine"
                 style="font-size:0.95rem;padding:0.75rem 1rem" />
          <div id="vArticleAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>
      </div>

      <!-- ROW 2: Role selector (NEW!) -->
      <div style="margin-bottom:1.5rem">
        <label class="label" style="font-size:0.85rem;font-weight:700;margin-bottom:0.5rem">
          🏷️ Vous êtes... <span style="color:#ef4444">*</span>
        </label>
        <select class="input" name="role_utilisateur" id="vArticleRole"
                style="font-size:0.95rem;padding:0.75rem 1rem;cursor:pointer;appearance:none;
                       background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23555b6e%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22/></svg>');
                       background-repeat:no-repeat;background-position:right 1rem center;background-size:1.2rem;
                       padding-right:2.8rem;">
          <option value="" disabled <?= empty($_POST['role_utilisateur']) ? 'selected' : '' ?>>-- Choisissez votre profil --</option>
          <?php foreach ($roles as $value => $label): ?>
            <option value="<?= htmlspecialchars($value) ?>"
                    <?= (($_POST['role_utilisateur'] ?? '') === $value) ? 'selected' : '' ?>>
              <?= $label ?>
            </option>
          <?php endforeach; ?>
        </select>
        <div id="vArticleRoleErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        <p style="font-size:0.72rem;color:var(--text-muted);margin-top:6px">
          Votre rôle aide les lecteurs à mieux comprendre votre point de vue.
        </p>
      </div>

      <!-- ROW 3: Content -->
      <div style="margin-bottom:1.5rem">
        <label class="label" style="font-size:0.85rem;font-weight:700;margin-bottom:0.5rem">
          ✍️ Contenu de l'article <span style="color:#ef4444">*</span>
        </label>
        <textarea class="input" name="contenu" id="vArticleContenu" rows="12"
                  placeholder="Rédigez votre article ici... Parlez-nous de vos expériences, astuces, ou découvertes !
                  
Astuce : Un bon article fait au moins 20 caractères 😄"
                  style="font-size:0.95rem;padding:1rem;line-height:1.7;min-height:250px"><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div id="vArticleContenuErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        <p style="font-size:0.72rem;color:var(--text-muted);margin-top:6px">
          Minimum 20 caractères. Soyez créatif et inspirez la communauté ! 🌍
        </p>
      </div>

      <!-- SUBMIT -->
      <div style="display:flex;justify-content:flex-end;border-top:1px solid var(--border);padding-top:1.5rem">
        <button type="submit" class="btn btn-primary" style="padding:0.8rem 2rem;font-size:0.95rem;border-radius:var(--radius-full)">
          <i data-lucide="send" style="width:1.1rem;height:1.1rem"></i> Soumettre pour validation
        </button>
      </div>

    </div>
  </form>

</div>

<script>
function validateVisitorArticleForm() {
  const titre = document.getElementById('vArticleTitre');
  const auteur = document.getElementById('vArticleAuteur');
  const role = document.getElementById('vArticleRole');
  const contenu = document.getElementById('vArticleContenu');
  const titreErr = document.getElementById('vArticleTitreErr');
  const auteurErr = document.getElementById('vArticleAuteurErr');
  const roleErr = document.getElementById('vArticleRoleErr');
  const contenuErr = document.getElementById('vArticleContenuErr');

  let ok = true;
  titreErr.style.display = 'none';
  auteurErr.style.display = 'none';
  roleErr.style.display = 'none';
  contenuErr.style.display = 'none';

  const t = (titre.value || '').trim();
  const a = (auteur.value || '').trim();
  const r = role.value || '';
  const c = (contenu.value || '').trim();

  if (t.length < 3) {
    titreErr.textContent = "Le titre doit contenir au moins 3 caractères.";
    titreErr.style.display = 'block';
    ok = false;
  }
  if (a.length < 1) {
    auteurErr.textContent = "Veuillez entrer votre nom.";
    auteurErr.style.display = 'block';
    ok = false;
  }
  if (!r) {
    roleErr.textContent = "Veuillez sélectionner votre profil.";
    roleErr.style.display = 'block';
    ok = false;
  }
  if (c.length < 20) {
    contenuErr.textContent = "Le contenu doit contenir au moins 20 caractères.";
    contenuErr.style.display = 'block';
    ok = false;
  }
  return ok;
}
</script>