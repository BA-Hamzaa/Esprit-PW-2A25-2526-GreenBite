<?php
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
$st = $_POST['statut'] ?? 'brouillon';
?>

<div style="padding:2rem;max-width:860px;margin:0 auto">

  <!-- HEADER -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem">
    <div style="display:flex;align-items:center;gap:1rem">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:0.875rem;box-shadow:0 4px 14px rgba(45,106,79,0.18)">
        <i data-lucide="file-plus" style="width:1.4rem;height:1.4rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.35rem;font-weight:800;color:var(--text-primary);margin:0;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:3px;height:1.35rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Nouvel article
        </h1>
        <p style="font-size:0.78rem;color:var(--text-muted);margin:3px 0 0 0">Remplissez les champs puis enregistrez</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-article&action=list"
       style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.55rem 1.1rem;border-radius:var(--radius-full);border:1.5px solid var(--border);background:var(--surface);color:var(--text-secondary);font-size:0.82rem;font-weight:600;text-decoration:none;transition:all 0.2s"
       onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'"
       onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
      <i data-lucide="arrow-left" style="width:0.9rem;height:0.9rem"></i> Retour
    </a>
  </div>

  <!-- ERRORS -->
  <?php if (!empty($errors)): ?>
    <div style="padding:1rem 1.25rem;border-radius:0.75rem;background:#fef2f2;color:#991b1b;border:1.5px solid #fca5a5;margin-bottom:1.5rem">
      <div style="font-weight:800;margin-bottom:0.4rem;display:flex;align-items:center;gap:0.4rem">
        <i data-lucide="alert-circle" style="width:1rem;height:1rem"></i> Veuillez corriger :
      </div>
      <ul style="margin:0;padding-left:1.25rem;font-size:0.85rem">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>/?page=admin-article&action=add" onsubmit="return validateArticleForm();">
    <div style="display:flex;flex-direction:column;gap:1.25rem">

      <!-- TITRE -->
      <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.5rem">
        <label style="display:block;font-size:0.78rem;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.6rem">
          Titre <span style="color:#ef4444">*</span>
        </label>
        <input type="text" class="input" name="titre" id="articleTitre"
               value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
               placeholder="Donnez un titre accrocheur à votre article..."
               style="font-size:1rem;font-weight:600;padding:0.85rem 1rem;border-radius:0.75rem" />
        <div id="articleTitreErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
      </div>

      <!-- AUTEUR + ROLE + STATUT -->
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">

        <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.25rem">
          <label style="display:block;font-size:0.78rem;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.6rem">
            Auteur <span style="color:#ef4444">*</span>
          </label>
          <input type="text" class="input" name="auteur" id="articleAuteur"
                 value="<?= htmlspecialchars($_POST['auteur'] ?? 'Admin') ?>"
                 placeholder="Nom de l'auteur"
                 style="font-size:0.9rem;padding:0.75rem 1rem;border-radius:0.75rem" />
          <div id="articleAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>

        <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.25rem">
          <label style="display:block;font-size:0.78rem;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.6rem">
            Rôle <span style="color:#ef4444">*</span>
          </label>
          <select class="input" name="role_utilisateur" id="articleRole"
                  style="font-size:0.9rem;padding:0.75rem 1rem;border-radius:0.75rem;cursor:pointer">
            <?php foreach ($roles as $value => $label): ?>
              <option value="<?= htmlspecialchars($value) ?>" <?= (($_POST['role_utilisateur'] ?? '') === $value) ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div id="articleRoleErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>

        <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.25rem">
          <label style="display:block;font-size:0.78rem;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.6rem">
            Statut
          </label>
          <select class="input" name="statut" id="articleStatut"
                  style="font-size:0.9rem;padding:0.75rem 1rem;border-radius:0.75rem;cursor:pointer">
            <option value="brouillon"  <?= $st === 'brouillon'  ? 'selected' : '' ?>>📝 Brouillon</option>
            <option value="en_attente" <?= $st === 'en_attente' ? 'selected' : '' ?>>⏳ En attente</option>
            <option value="publie"     <?= $st === 'publie'     ? 'selected' : '' ?>>✅ Publié</option>
          </select>
        </div>

      </div>

      <!-- CONTENU -->
      <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.5rem">
        <label style="display:block;font-size:0.78rem;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.6rem">
          Contenu <span style="color:#ef4444">*</span>
        </label>
        <textarea class="input" name="contenu" id="articleContenu" rows="12"
                  placeholder="Rédigez votre article ici..."
                  style="font-size:0.9rem;padding:0.85rem 1rem;line-height:1.75;border-radius:0.75rem;min-height:280px;resize:vertical"><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div id="articleContenuErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        <div style="margin-top:0.5rem;font-size:0.72rem;color:var(--text-muted);text-align:right" id="contenuCount">0 caractère(s)</div>
      </div>

      <!-- ACTIONS -->
      <div style="display:flex;justify-content:flex-end;align-items:center;gap:0.75rem;padding-top:0.25rem">
        <a href="<?= BASE_URL ?>/?page=admin-article&action=list"
           style="padding:0.7rem 1.4rem;border-radius:var(--radius-full);border:1.5px solid var(--border);background:transparent;color:var(--text-secondary);font-size:0.88rem;font-weight:600;text-decoration:none;cursor:pointer;transition:all 0.2s">
          Annuler
        </a>
        <button type="submit" class="btn btn-primary"
                style="border-radius:var(--radius-full);padding:0.75rem 2rem;font-size:0.9rem;font-weight:700">
          <i data-lucide="save" style="width:1rem;height:1rem"></i> Enregistrer l'article
        </button>
      </div>

    </div>
  </form>
</div>

<script>
// Character counter
const contenuField = document.getElementById('articleContenu');
const contenuCount = document.getElementById('contenuCount');
function updateCount() {
  const n = (contenuField.value || '').trim().length;
  contenuCount.textContent = n + ' caractère(s)';
  contenuCount.style.color = n < 20 ? '#dc2626' : 'var(--text-muted)';
}
contenuField.addEventListener('input', updateCount);
updateCount();

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

  titreErr.style.display = auteurErr.style.display = roleErr.style.display = contenuErr.style.display = 'none';
  let ok = true;

  if ((titre.value||'').trim().length < 3)  { titreErr.textContent  = "Titre obligatoire (min 3 caractères).";   titreErr.style.display  = 'block'; ok = false; }
  if ((auteur.value||'').trim().length < 1) { auteurErr.textContent = "Auteur obligatoire.";                     auteurErr.style.display = 'block'; ok = false; }
  if (!role.value)                          { roleErr.textContent   = "Veuillez sélectionner un rôle.";          roleErr.style.display   = 'block'; ok = false; }
  if ((contenu.value||'').trim().length<20) { contenuErr.textContent= "Contenu obligatoire (min 20 caractères).";contenuErr.style.display = 'block'; ok = false; }
  if (!['brouillon','en_attente','publie'].includes(statut.value)) ok = false;
  return ok;
}
</script>