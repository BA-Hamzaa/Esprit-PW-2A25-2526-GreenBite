<div style="padding:2rem">
  <div class="mb-5">
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:0.95rem;height:0.95rem"></i> Retour
    </a>
  </div>

  <div class="card" style="padding:1.75rem;border:1px solid var(--border)">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem">
      <div style="min-width:0">
        <h1 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.02em;line-height:1.15;margin:0">
          <?= htmlspecialchars($article['titre']) ?>
        </h1>
        <div style="margin-top:0.6rem;font-size:0.8rem;color:var(--text-muted);display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
          <span style="display:inline-flex;align-items:center;gap:0.25rem"><i data-lucide="user" style="width:0.75rem;height:0.75rem"></i><?= htmlspecialchars($article['auteur'] ?? 'GreenBite') ?></span>
          <span style="width:4px;height:4px;border-radius:50%;background:var(--border)"></span>
          <span style="display:inline-flex;align-items:center;gap:0.25rem"><i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i><?= htmlspecialchars($article['date_publication'] ?? '') ?></span>
        </div>
      </div>
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;border-radius:1rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);box-shadow:0 8px 22px rgba(45,106,79,0.12);flex-shrink:0">
        <i data-lucide="newspaper" style="width:1.35rem;height:1.35rem;color:var(--primary)"></i>
      </div>
    </div>

    <div style="margin-top:1.35rem;color:var(--text-secondary);font-size:0.92rem;line-height:1.85;white-space:pre-wrap">
      <?= htmlspecialchars($article['contenu']) ?>
    </div>
  </div>

  <!-- Commentaires -->
  <div style="margin-top:1.5rem" class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem">
      <h2 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:900;color:var(--text-primary);margin:0;display:flex;align-items:center;gap:0.5rem">
        <i data-lucide="messages-square" style="width:1.1rem;height:1.1rem;color:var(--primary)"></i>
        Commentaires (<?= count($commentaires) ?>)
      </h2>
      <span class="badge badge-primary" style="font-size:0.7rem">Validés uniquement</span>
    </div>

    <?php if (empty($commentaires)): ?>
      <div style="padding:1.25rem;border:1px dashed var(--border);border-radius:var(--radius-xl);text-align:center;color:var(--text-muted)">
        Aucun commentaire pour l’instant.
      </div>
    <?php else: ?>
      <div style="display:flex;flex-direction:column;gap:0.6rem">
        <?php foreach ($commentaires as $c): ?>
          <div style="padding:0.9rem 1rem;border:1px solid var(--border);border-radius:var(--radius-xl);background:var(--surface)">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem">
              <div style="display:flex;align-items:center;gap:0.5rem;min-width:0">
                <div style="width:2rem;height:2rem;border-radius:0.75rem;background:rgba(82,183,136,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <i data-lucide="user" style="width:0.95rem;height:0.95rem;color:var(--primary)"></i>
                </div>
                <div style="min-width:0">
                  <div style="font-weight:800;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($c['pseudo'] ?? '') ?></div>
                  <div style="font-size:0.72rem;color:var(--text-muted)"><?= htmlspecialchars($c['date_commentaire'] ?? '') ?></div>
                </div>
              </div>
            </div>
            <div style="margin-top:0.55rem;color:var(--text-secondary);line-height:1.7;white-space:pre-wrap"><?= htmlspecialchars($c['contenu']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Formulaire ajout commentaire -->
  <div style="margin-top:1.25rem" class="card">
    <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:900;color:var(--text-primary);margin:0 0 0.9rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="send" style="width:1rem;height:1rem;color:var(--primary)"></i>
      Laisser un commentaire
    </h3>

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

    <form method="post" action="<?= BASE_URL ?>/?page=article&action=comment-add&id=<?= (int)$article['id'] ?>" onsubmit="return validateCommentForm();">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Votre nom</label>
          <input type="text" name="auteur" id="commentAuteur" class="input" value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>" placeholder="Ex: Amine" />
          <div id="commentAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
        </div>
        <div>
          <label class="label">Rappel</label>
          <div style="padding:0.85rem 1rem;border:1px solid var(--border);border-radius:var(--radius-xl);background:rgba(82,183,136,0.04);color:var(--text-secondary);font-size:0.82rem;line-height:1.6">
            Votre commentaire sera <strong>en attente</strong> puis validé par un admin.
          </div>
        </div>
      </div>

      <div style="margin-top:1rem">
        <label class="label">Commentaire</label>
        <textarea name="contenu" id="commentContenu" class="input" rows="5" placeholder="Votre message..."><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div id="commentContenuErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
      </div>

      <div style="margin-top:1rem;display:flex;justify-content:flex-end">
        <button class="btn btn-primary" type="submit" style="border-radius:var(--radius-full)">
          <i data-lucide="send" style="width:1rem;height:1rem"></i> Envoyer
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function validateCommentForm() {
  const auteur = document.getElementById('commentAuteur');
  const contenu = document.getElementById('commentContenu');
  const auteurErr = document.getElementById('commentAuteurErr');
  const contenuErr = document.getElementById('commentContenuErr');

  let ok = true;

  const a = (auteur.value || '').trim();
  const c = (contenu.value || '').trim();

  auteurErr.style.display = 'none';
  contenuErr.style.display = 'none';

  if (a.length < 2) {
    auteurErr.textContent = "Nom obligatoire (min 2 caractères).";
    auteurErr.style.display = 'block';
    ok = false;
  }
  if (c.length < 5) {
    contenuErr.textContent = "Commentaire obligatoire (min 5 caractères).";
    contenuErr.style.display = 'block';
    ok = false;
  }
  return ok;
}
</script>

