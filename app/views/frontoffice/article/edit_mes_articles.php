<?php
$articleId = (int)$article['id'];
$pin = htmlspecialchars($_GET['pin'] ?? '');
$auteur = htmlspecialchars($article['auteur'] ?? '');
$valTitre = htmlspecialchars($_POST['titre'] ?? $article['titre'] ?? '');
$valContenu = htmlspecialchars($_POST['contenu'] ?? $article['contenu'] ?? '');
$valRole = htmlspecialchars($_POST['role_utilisateur'] ?? $article['role_utilisateur'] ?? 'Passionné de cuisine');
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
<div style="padding:2rem;max-width:800px;margin:0 auto">
  <div class="flex items-center justify-between mb-6">
    <h1 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:800">✏️ Modifier mon article</h1>
    <a href="<?= BASE_URL ?>/?page=article&action=mes-activites" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour à mes activités
    </a>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-4" style="background:#fef2f2;color:#991b1b;border:1px solid #fca5a5">
      <ul style="margin:0;padding-left:1.2rem">
        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= BASE_URL ?>/?page=article&action=edit-mes-articles&id=<?= $articleId ?>&pin=<?= $pin ?>&auteur=<?= urlencode($auteur) ?>" onsubmit="return validateEditForm();">
    <input type="hidden" name="auteur" value="<?= $auteur ?>" />

    <div class="card" style="padding:1.5rem;border:1px solid var(--border)">
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="label">📝 Titre</label>
          <input type="text" name="titre" id="editTitre" class="input" value="<?= $valTitre ?>" />
          <div id="editTitreErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
        </div>
        <div>
          <label class="label">🏷️ Rôle</label>
          <select name="role_utilisateur" class="input">
            <?php foreach ($roles as $value => $label): ?>
              <option value="<?= htmlspecialchars($value) ?>" <?= $valRole === $value ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="mb-4">
        <label class="label">✍️ Contenu</label>
        <textarea name="contenu" id="editContenu" class="input" rows="12"><?= $valContenu ?></textarea>
        <div id="editContenuErr" style="margin-top:6px;font-size:0.75rem;color:#dc2626;display:none"></div>
      </div>

      <div style="display:flex;justify-content:flex-end">
        <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">💾 Enregistrer</button>
      </div>
    </div>
  </form>
</div>

<script>
function validateEditForm() {
  const titre = document.getElementById('editTitre');
  const contenu = document.getElementById('editContenu');
  const titreErr = document.getElementById('editTitreErr');
  const contenuErr = document.getElementById('editContenuErr');
  let ok = true;
  titreErr.style.display = 'none';
  contenuErr.style.display = 'none';
  if ((titre.value?.trim() || '').length < 3) {
    titreErr.textContent = "Titre obligatoire (min 3 caractères).";
    titreErr.style.display = 'block';
    ok = false;
  }
  if ((contenu.value?.trim() || '').length < 20) {
    contenuErr.textContent = "Contenu obligatoire (min 20 caractères).";
    contenuErr.style.display = 'block';
    ok = false;
  }
  return ok;
}
</script>