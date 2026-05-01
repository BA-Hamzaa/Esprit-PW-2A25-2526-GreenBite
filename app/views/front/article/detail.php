<?php
$articleId = (int)$article['id'];
?>

<div style="padding:2rem">
  <div class="mb-5">
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:0.95rem;height:0.95rem"></i> Retour
    </a>
  </div>

  <!-- ARTICLE -->
  <div class="card" style="padding:1.75rem;border:1px solid var(--border);position:relative">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem">
      <div style="min-width:0">
        <h1 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.02em;line-height:1.15;margin:0">
          <?= htmlspecialchars($article['titre']) ?>
        </h1>
        <div style="margin-top:0.6rem;font-size:0.8rem;color:var(--text-muted);display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
          <span style="display:inline-flex;align-items:center;gap:0.25rem"><i data-lucide="user" style="width:0.75rem;height:0.75rem"></i><?= htmlspecialchars($article['auteur'] ?? 'GreenBite') ?></span>
          <span style="width:4px;height:4px;border-radius:50%;background:var(--border)"></span>
          <span style="display:inline-flex;align-items:center;gap:0.25rem"><i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i><?= htmlspecialchars($article['date_publication'] ?? '') ?></span>
          <?php if (!empty($article['role_utilisateur'])): ?>
            <span style="width:4px;height:4px;border-radius:50%;background:var(--border)"></span>
            <span style="display:inline-flex;align-items:center;gap:0.25rem;font-weight:600">🏷️ <?= htmlspecialchars($article['role_utilisateur']) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;border-radius:1rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);box-shadow:0 8px 22px rgba(45,106,79,0.12);flex-shrink:0">
        <i data-lucide="newspaper" style="width:1.35rem;height:1.35rem;color:var(--primary)"></i>
      </div>
    </div>

    <div style="margin-top:1.35rem;color:var(--text-secondary);font-size:0.92rem;line-height:1.85;white-space:pre-wrap">
      <?= htmlspecialchars($article['contenu']) ?>
    </div>

    <!-- 👍👎 Like/Dislike Article -->
    <div style="margin-top:1.5rem;display:flex;align-items:center;gap:0.75rem;border-top:1px solid var(--border);padding-top:1rem">
      <button onclick="toggleReaction('article', <?= $articleId ?>, 'like')" id="article-like-btn-<?= $articleId ?>" style="display:flex;align-items:center;gap:0.3rem;padding:0.4rem 0.9rem;border:1.5px solid var(--border);border-radius:var(--radius-full);background:var(--surface);cursor:pointer;font-size:0.82rem;color:var(--text-secondary);transition:all 0.2s">
        👍 <span id="article-like-count-<?= $articleId ?>">0</span>
      </button>
      <button onclick="toggleReaction('article', <?= $articleId ?>, 'dislike')" id="article-dislike-btn-<?= $articleId ?>" style="display:flex;align-items:center;gap:0.3rem;padding:0.4rem 0.9rem;border:1.5px solid var(--border);border-radius:var(--radius-full);background:var(--surface);cursor:pointer;font-size:0.82rem;color:var(--text-secondary);transition:all 0.2s">
        👎 <span id="article-dislike-count-<?= $articleId ?>">0</span>
      </button>
    </div>
  </div>

  <!-- COMMENTAIRES -->
  <div style="margin-top:1.5rem" class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem">
      <h2 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:900;color:var(--text-primary);margin:0;display:flex;align-items:center;gap:0.5rem">
        <i data-lucide="messages-square" style="width:1.1rem;height:1.1rem;color:var(--primary)"></i>
        Commentaires (<?= count($commentaires) ?>)
      </h2>
    </div>

    <?php if (empty($commentaires)): ?>
      <div style="padding:1.25rem;border:1px dashed var(--border);border-radius:var(--radius);text-align:center;color:var(--text-muted)">
        Aucun commentaire pour l'instant. Soyez le premier !
      </div>
    <?php else: ?>
      <div style="display:flex;flex-direction:column;gap:0.6rem">
        <?php foreach ($commentaires as $c): 
          $commentId = (int)$c['id'];
          $isReported = ($c['statut'] ?? '') === 'signale';
        ?>
          <div style="padding:0.9rem 1rem;border:1px solid var(--border);border-radius:var(--radius);background:<?= $isReported ? '#fef2f2' : 'var(--surface)' ?>;<?= $isReported ? 'border-color:#fca5a5;' : '' ?>">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem">
              <div style="display:flex;align-items:center;gap:0.5rem;min-width:0">
                <div style="width:2rem;height:2rem;border-radius:0.75rem;background:rgba(82,183,136,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <i data-lucide="user" style="width:0.95rem;height:0.95rem;color:var(--primary)"></i>
                </div>
                <div style="min-width:0">
                  <div style="font-weight:800;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    <?= htmlspecialchars($c['pseudo'] ?? '') ?>
                    <?php if ($isReported): ?>
                      <span style="font-size:0.65rem;color:#dc2626;font-weight:600;margin-left:0.4rem">🚩 Signalé</span>
                    <?php endif; ?>
                  </div>
                  <div style="font-size:0.72rem;color:var(--text-muted)"><?= htmlspecialchars($c['date_commentaire'] ?? '') ?></div>
                </div>
              </div>
            </div>
            <div style="margin-top:0.55rem;color:var(--text-secondary);line-height:1.7;white-space:pre-wrap"><?= htmlspecialchars($c['contenu']) ?></div>

            <!-- 👍👎 + Report -->
            <div style="margin-top:0.6rem;display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
              <button onclick="toggleReaction('comment', <?= $commentId ?>, 'like')" id="comment-like-btn-<?= $commentId ?>" style="display:flex;align-items:center;gap:0.2rem;padding:0.25rem 0.6rem;border:1px solid var(--border);border-radius:var(--radius-full);background:transparent;cursor:pointer;font-size:0.7rem;color:var(--text-muted);transition:all 0.2s">
                👍 <span id="comment-like-count-<?= $commentId ?>">0</span>
              </button>
              <button onclick="toggleReaction('comment', <?= $commentId ?>, 'dislike')" id="comment-dislike-btn-<?= $commentId ?>" style="display:flex;align-items:center;gap:0.2rem;padding:0.25rem 0.6rem;border:1px solid var(--border);border-radius:var(--radius-full);background:transparent;cursor:pointer;font-size:0.7rem;color:var(--text-muted);transition:all 0.2s">
                👎 <span id="comment-dislike-count-<?= $commentId ?>">0</span>
              </button>

              <button onclick="reportComment(<?= $commentId ?>)" style="margin-left:auto;padding:0.25rem 0.6rem;border:1px solid #f59e0b;border-radius:var(--radius-full);background:rgba(245,158,11,0.05);cursor:pointer;font-size:0.7rem;color:#d97706;transition:all 0.2s" title="Signaler ce commentaire">
                🚩 Signaler
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- FORMULAIRE AJOUT COMMENTAIRE -->
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

    <form method="post" action="<?= BASE_URL ?>/?page=article&action=comment-add&id=<?= $articleId ?>" onsubmit="return validateCommentForm();">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Votre nom</label>
          <input type="text" name="auteur" id="commentAuteur" class="input" value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>" placeholder="Ex: Amine" />
          <div id="commentAuteurErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
        </div>
        <div>
          <label class="label">🔢 Votre PIN (4 chiffres)</label>
          <input type="password" name="pin" id="commentPin" class="input" value="<?= htmlspecialchars($_POST['pin'] ?? '') ?>" placeholder="Ex: 1234" maxlength="4" />
          <div id="commentPinErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
          <p style="font-size:0.68rem;color:var(--text-muted);margin-top:4px">Même PIN que pour vos articles. <a href="<?= BASE_URL ?>/?page=article&action=add" style="color:var(--primary)">Pas encore d'article ?</a></p>
        </div>
      </div>

      <div style="margin-top:1rem">
        <label class="label">Commentaire</label>
        <textarea name="contenu" id="commentContenu" class="input" rows="5" placeholder="Votre message..."><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        <div id="commentContenuErr" style="margin-top:6px;font-size:0.75rem;color:#b91c1c;display:none"></div>
      </div>

      <div style="margin-top:1rem;display:flex;justify-content:space-between;align-items:center">
        <div style="padding:0.7rem 1rem;border:1px solid #fef3c7;border-radius:var(--radius);background:#fffbeb;color:#92400e;font-size:0.78rem;line-height:1.5">
          🙏 Soyez respectueux — Les commentaires inappropriés peuvent être signalés.
        </div>
        <button class="btn btn-primary" type="submit" style="border-radius:var(--radius-full)">
          <i data-lucide="send" style="width:1rem;height:1rem"></i> Envoyer
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// ==================== REACTIONS ====================
function toggleReaction(type, id, reaction) {
  // [same code as before, no changes]
  const key = 'reaction_' + type + '_' + id;
  const current = localStorage.getItem(key);
  const likeBtn = document.getElementById(type + '-like-btn-' + id);
  const dislikeBtn = document.getElementById(type + '-dislike-btn-' + id);
  const likeCount = document.getElementById(type + '-like-count-' + id);
  const dislikeCount = document.getElementById(type + '-dislike-count-' + id);

  likeBtn.style.background = 'var(--surface)';
  likeBtn.style.color = 'var(--text-secondary)';
  dislikeBtn.style.background = 'var(--surface)';
  dislikeBtn.style.color = 'var(--text-secondary)';

  let likes = parseInt(localStorage.getItem(key + '_likes') || '0');
  let dislikes = parseInt(localStorage.getItem(key + '_dislikes') || '0');

  if (current === reaction) {
    localStorage.removeItem(key);
    if (reaction === 'like') likes--;
    else dislikes--;
    likeCount.textContent = likes;
    dislikeCount.textContent = dislikes;
  } else {
    if (current === 'like') likes--;
    if (current === 'dislike') dislikes--;
    localStorage.setItem(key, reaction);
    if (reaction === 'like') {
      likes++;
      likeBtn.style.background = 'rgba(34,197,94,0.12)';
      likeBtn.style.color = '#16a34a';
      likeBtn.style.borderColor = '#86efac';
    } else {
      dislikes++;
      dislikeBtn.style.background = 'rgba(239,68,68,0.1)';
      dislikeBtn.style.color = '#dc2626';
      dislikeBtn.style.borderColor = '#fca5a5';
    }
    likeCount.textContent = likes;
    dislikeCount.textContent = dislikes;
  }

  localStorage.setItem(key + '_likes', likes);
  localStorage.setItem(key + '_dislikes', dislikes);
}

function loadReactions() {
  loadSingleReaction('article', <?= $articleId ?>);
  <?php foreach ($commentaires as $c): ?>
    loadSingleReaction('comment', <?= (int)$c['id'] ?>);
  <?php endforeach; ?>
}

function loadSingleReaction(type, id) {
  const key = 'reaction_' + type + '_' + id;
  const current = localStorage.getItem(key);
  const likeCount = document.getElementById(type + '-like-count-' + id);
  const dislikeCount = document.getElementById(type + '-dislike-count-' + id);
  const likeBtn = document.getElementById(type + '-like-btn-' + id);
  const dislikeBtn = document.getElementById(type + '-dislike-btn-' + id);

  if (likeCount) likeCount.textContent = localStorage.getItem(key + '_likes') || '0';
  if (dislikeCount) dislikeCount.textContent = localStorage.getItem(key + '_dislikes') || '0';

  if (current === 'like' && likeBtn) {
    likeBtn.style.background = 'rgba(34,197,94,0.12)';
    likeBtn.style.color = '#16a34a';
    likeBtn.style.borderColor = '#86efac';
  } else if (current === 'dislike' && dislikeBtn) {
    dislikeBtn.style.background = 'rgba(239,68,68,0.1)';
    dislikeBtn.style.color = '#dc2626';
    dislikeBtn.style.borderColor = '#fca5a5';
  }
}

function reportComment(id) {
  if (!confirm('Signaler ce commentaire comme inapproprié ?')) return;
  fetch('<?= BASE_URL ?>/?page=article&action=comment-report&id=' + id, {
    method: 'POST'
  }).then(r => r.json()).then(data => {
    if (data.success) {
      alert('Commentaire signalé. Un administrateur va le vérifier.');
      location.reload();
    } else {
      alert(data.error || 'Erreur lors du signalement.');
    }
  });
}

// ==================== FORM VALIDATION ====================
function validateCommentForm() {
  const auteur = document.getElementById('commentAuteur');
  const pin = document.getElementById('commentPin');
  const contenu = document.getElementById('commentContenu');
  const auteurErr = document.getElementById('commentAuteurErr');
  const pinErr = document.getElementById('commentPinErr');
  const contenuErr = document.getElementById('commentContenuErr');

  let ok = true;
  const a = (auteur.value || '').trim();
  const p = (pin.value || '').trim();
  const c = (contenu.value || '').trim();

  auteurErr.style.display = 'none';
  pinErr.style.display = 'none';
  contenuErr.style.display = 'none';

  if (a.length < 2) {
    auteurErr.textContent = "Nom obligatoire (min 2 caractères).";
    auteurErr.style.display = 'block';
    ok = false;
  }
  if (!/^\d{4}$/.test(p)) {
    pinErr.textContent = "Le PIN doit contenir exactement 4 chiffres.";
    pinErr.style.display = 'block';
    ok = false;
  }
  if (c.length < 5) {
    contenuErr.textContent = "Commentaire obligatoire (min 5 caractères).";
    contenuErr.style.display = 'block';
    ok = false;
  }
  return ok;
}

document.addEventListener('DOMContentLoaded', function() {
  loadReactions();
});
</script>