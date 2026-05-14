<?php
$articles      = $mesArticles ?? [];
$commentaires  = $mesCommentaires ?? [];
$auteur        = htmlspecialchars($auteurSaisi ?? '');
$pin           = htmlspecialchars($pinSaisi ?? '');
$estConnecte   = !empty($sessionConnecte);   // set by controller when session loggedin
$dejaConnecte  = $estConnecte
    || (!empty($mesArticles) || !empty($mesCommentaires))
    || (!empty($_SESSION['mes_activites_auteur']));
?>

<div style="padding:2rem;max-width:1000px;margin:0 auto">
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="activity" style="width:1.625rem;height:1.625rem;color:#2D6A4F"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);margin:0">
          📂 Mes activités
          <?php if ($estConnecte): ?>
            <span style="font-size:0.85rem;font-weight:600;color:var(--primary);margin-left:0.5rem">
              — <?= htmlspecialchars($_SESSION['username']) ?>
            </span>
          <?php endif; ?>
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin:3px 0 0 0">
          <?php if ($estConnecte): ?>
            Vos articles, commentaires et favoris liés à votre compte
          <?php else: ?>
            Retrouvez vos articles, commentaires et favoris
          <?php endif; ?>
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour au blog
    </a>
  </div>

  <!-- Errors -->
  <?php if (!empty($errors)): ?>
    <div style="padding:1rem;margin-bottom:1.5rem;border-radius:var(--radius);background:#fef2f2;color:#991b1b;border:2px solid #fca5a5">
      <?php foreach ($errors as $e): ?><div>⚠️ <?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!$dejaConnecte): ?>
    <!-- ======================== GUEST PIN FORM ======================== -->
    <?php if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <!-- Logged-in but somehow dejaConnecte is false — just redirect -->
      <div class="card" style="padding:2rem;text-align:center;color:var(--text-muted)">
        <i data-lucide="loader-2" style="width:2rem;height:2rem;margin:0 auto 0.5rem;display:block;animation:spin 1s linear infinite"></i>
        Chargement de vos activités...
      </div>
      <style>@keyframes spin{to{transform:rotate(360deg)}}</style>
    <?php else: ?>
      <form method="post" style="margin-bottom:2rem">
        <div class="card" style="padding:1.75rem;border:1px solid var(--border)">
          <p style="font-size:0.82rem;color:var(--text-muted);margin-bottom:1.25rem">
            Vous n'êtes pas connecté(e). Entrez votre nom et le PIN que vous avez utilisé lors de votre première participation pour retrouver vos activités.
          </p>
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label class="label">👤 Votre nom</label>
              <input type="text" name="auteur" class="input" value="<?= $auteur ?>" placeholder="Ex: Amine" required />
            </div>
            <div>
              <label class="label">🔢 Votre PIN (4 chiffres)</label>
              <input type="password" name="pin" class="input" value="<?= $pin ?>" placeholder="Ex: 1234" maxlength="4" required />
            </div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem">
            <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">🔍 Voir mes activités</button>
            <a href="<?= BASE_URL ?>/?page=login" style="font-size:0.8rem;color:var(--primary);font-weight:600;text-decoration:none">
              → Se connecter pour y accéder automatiquement
            </a>
          </div>
        </div>
      </form>
    <?php endif; ?>

  <?php else: ?>
    <!-- ======================== DASHBOARD ======================== -->

    <!-- Connected badge -->
    <?php if ($estConnecte): ?>
    <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.4rem 1rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border:1px solid #bbf7d0;border-radius:999px;font-size:0.78rem;font-weight:700;color:#166534;margin-bottom:1.25rem">
      <i data-lucide="shield-check" style="width:0.85rem;height:0.85rem"></i>
      Connecté en tant que <?= htmlspecialchars($_SESSION['username']) ?>
    </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div style="display:flex;gap:0.5rem;margin-bottom:1.5rem;flex-wrap:wrap">
      <button onclick="switchTab('articles')" id="tab-btn-articles" class="btn" style="border-radius:var(--radius-full);background:var(--primary);color:#fff;border:none;font-weight:700">📝 Mes articles (<?= count($articles) ?>)</button>
      <button onclick="switchTab('commentaires')" id="tab-btn-commentaires" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);color:var(--text-secondary);border:1px solid var(--border);font-weight:600">💬 Mes commentaires (<?= count($commentaires) ?>)</button>
      <button onclick="switchTab('favoris')" id="tab-btn-favoris" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);color:var(--text-secondary);border:1px solid var(--border);font-weight:600">⭐ Mes favoris</button>
    </div>

    <!-- ===== Tab: Articles ===== -->
    <div id="tab-articles">
      <?php if (empty($articles)): ?>
        <div class="card" style="padding:3rem;text-align:center;color:var(--text-muted)">
          <i data-lucide="file-x" style="width:2.5rem;height:2.5rem;display:block;margin:0 auto 0.75rem;opacity:0.4"></i>
          Aucun article trouvé.
          <div style="margin-top:0.75rem">
            <a href="<?= BASE_URL ?>/?page=article&action=write" class="btn btn-primary" style="border-radius:var(--radius-full);font-size:0.8rem">✏️ Écrire mon premier article</a>
          </div>
        </div>
      <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:0.75rem">
          <?php foreach ($articles as $a):
            $statut = $a['statut'] ?? 'brouillon';
            $badge = ($statut === 'publie') ? 'badge-success' : (($statut === 'en_attente') ? 'badge-warning' : 'badge-info');
          ?>
            <div class="card" style="padding:1rem 1.25rem;border:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
              <div style="min-width:0;flex:1">
                <div style="font-weight:800;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($a['titre']) ?></div>
                <div style="display:flex;align-items:center;gap:0.75rem;margin-top:0.3rem">
                  <span class="badge <?= $badge ?>" style="font-size:0.65rem;text-transform:capitalize"><?= htmlspecialchars($statut) ?></span>
                  <span style="font-size:0.72rem;color:var(--text-muted)"><?= $a['date_publication'] ?></span>
                </div>
              </div>
              <div style="display:flex;gap:0.4rem;flex-shrink:0;margin-left:1rem">
                <?php if ($statut === 'publie'): ?>
                  <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= (int)$a['id'] ?>" class="btn" style="border-radius:var(--radius-full);padding:0.35rem 0.8rem;font-size:0.75rem;background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.2);color:#3b82f6" title="Voir l'article">👁️</a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/?page=article&action=edit-mes-articles&id=<?= (int)$a['id'] ?>&auteur=<?= urlencode($auteur ?: ($_SESSION['username'] ?? '')) ?>&pin=<?= urlencode($pin) ?>" class="btn" style="border-radius:var(--radius-full);padding:0.35rem 0.8rem;font-size:0.75rem;background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.2);color:#3b82f6" title="Modifier">✏️</a>
                <a href="<?= BASE_URL ?>/?page=article&action=delete-mes-articles&id=<?= (int)$a['id'] ?>&auteur=<?= urlencode($auteur ?: ($_SESSION['username'] ?? '')) ?>&pin=<?= urlencode($pin) ?>" class="btn" style="border-radius:var(--radius-full);padding:0.35rem 0.8rem;font-size:0.75rem;background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);color:#ef4444" title="Supprimer"
                  onclick="event.preventDefault(); var href=this.href; gbConfirm('Supprimer cet article définitivement ?','Supprimer l\'article','🗑️').then(function(ok){if(ok)window.location.href=href;});">🗑️</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- ===== Tab: Commentaires ===== -->
    <div id="tab-commentaires" style="display:none">
      <?php if (empty($commentaires)): ?>
        <div class="card" style="padding:3rem;text-align:center;color:var(--text-muted)">
          <i data-lucide="message-x" style="width:2.5rem;height:2.5rem;display:block;margin:0 auto 0.75rem;opacity:0.4"></i>
          Aucun commentaire trouvé.
        </div>
      <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:0.75rem">
          <?php foreach ($commentaires as $c):
            $cStatut = $c['statut'] ?? 'valide';
            $cBadge = ($cStatut === 'valide') ? 'badge-success' : (($cStatut === 'signale') ? 'badge-coral' : 'badge-warning');
          ?>
            <div class="card" style="padding:1rem 1.25rem;border:1px solid var(--border)">
              <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.4rem">
                <div style="display:flex;align-items:center;gap:0.5rem">
                  <span style="font-size:0.75rem;font-weight:700;color:var(--primary)">📄 <?= htmlspecialchars($c['article_titre'] ?? '') ?></span>
                  <span class="badge <?= $cBadge ?>" style="font-size:0.6rem"><?= $cStatut === 'signale' ? '🚩 Signalé' : htmlspecialchars($cStatut) ?></span>
                </div>
                <span style="font-size:0.7rem;color:var(--text-muted)"><?= $c['date_commentaire'] ?></span>
              </div>
              <div style="color:var(--text-secondary);font-size:0.85rem;line-height:1.6"><?= htmlspecialchars($c['contenu']) ?></div>
              <div style="display:flex;gap:0.4rem;margin-top:0.5rem">
                <a href="<?= BASE_URL ?>/?page=article&action=edit-mes-commentaires&id=<?= (int)$c['id'] ?>&pseudo=<?= urlencode($auteur ?: ($_SESSION['username'] ?? '')) ?>&pin=<?= urlencode($pin) ?>" class="btn" style="border-radius:var(--radius-full);padding:0.3rem 0.7rem;font-size:0.7rem;background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.2);color:#3b82f6">✏️ Modifier</a>
                <a href="<?= BASE_URL ?>/?page=article&action=delete-mes-commentaires&id=<?= (int)$c['id'] ?>&pseudo=<?= urlencode($auteur ?: ($_SESSION['username'] ?? '')) ?>&pin=<?= urlencode($pin) ?>" class="btn" style="border-radius:var(--radius-full);padding:0.3rem 0.7rem;font-size:0.7rem;background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);color:#ef4444"
                  onclick="event.preventDefault(); var href=this.href; gbConfirm('Supprimer ce commentaire définitivement ?','Supprimer le commentaire','🗑️').then(function(ok){if(ok)window.location.href=href;});">🗑️ Supprimer</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- ===== Tab: Favoris ===== -->
    <div id="tab-favoris" style="display:none">
      <div id="favoris-container" style="display:flex;flex-direction:column;gap:0.75rem">
        <div class="card" style="padding:3rem;text-align:center;color:var(--text-muted)" id="favoris-empty">Chargement de vos favoris...</div>
      </div>
    </div>

  <?php endif; ?>
</div>

<script>
// ==================== SWITCH TABS ====================
function switchTab(tab) {
  document.getElementById('tab-articles').style.display    = (tab === 'articles')    ? 'block' : 'none';
  document.getElementById('tab-commentaires').style.display= (tab === 'commentaires')? 'block' : 'none';
  document.getElementById('tab-favoris').style.display     = (tab === 'favoris')     ? 'block' : 'none';

  ['articles','commentaires','favoris'].forEach(function(t) {
    var btn = document.getElementById('tab-btn-' + t);
    if (!btn) return;
    if (t === tab) {
      btn.style.background  = 'var(--primary)';
      btn.style.color       = '#fff';
      btn.style.border      = 'none';
      btn.style.fontWeight  = '700';
    } else {
      btn.style.background  = 'rgba(45,106,79,0.06)';
      btn.style.color       = 'var(--text-secondary)';
      btn.style.border      = '1px solid var(--border)';
      btn.style.fontWeight  = '600';
    }
  });
  if (tab === 'favoris') loadFavorisTab();
}

// ==================== FAVORIS ====================
// For logged-in users, key is based on username. For guests, key is name+PIN.
var FAVORIS_NAME = '<?= addslashes($auteur ?: ($_SESSION['username'] ?? '')) ?>';
var FAVORIS_PIN  = '<?= addslashes($pin) ?>';

function getFavorisKey(name, pin) {
  return 'greenbite_favoris_' + name.toLowerCase().trim() + (pin ? '_' + pin : '');
}
function getFavoris(name, pin) {
  try { return JSON.parse(localStorage.getItem(getFavorisKey(name, pin)) || '[]'); } catch(e) { return []; }
}

function loadFavorisTab() {
  var container = document.getElementById('favoris-container');
  var favoris = getFavoris(FAVORIS_NAME, FAVORIS_PIN);

  if (favoris.length === 0) {
    container.innerHTML = '<div class="card" style="padding:3rem;text-align:center;color:var(--text-muted)"><i data-lucide="star-off" style="width:2.5rem;height:2.5rem;display:block;margin:0 auto 0.75rem;opacity:0.4"></i>Aucun favori pour le moment. Cliquez sur ⭐ depuis un article pour en ajouter.</div>';
    if (typeof lucide !== 'undefined') lucide.createIcons();
    return;
  }

  var html = '';
  favoris.forEach(function(id) {
    html += '<div class="card" style="padding:1rem 1.25rem;border:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">'
      + '<div style="min-width:0;flex:1"><div style="font-weight:800;color:var(--text-primary)">Article #' + id + '</div>'
      + '<div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.2rem">Ajouté aux favoris</div></div>'
      + '<div style="display:flex;gap:0.4rem;flex-shrink:0;margin-left:1rem">'
      + '<a href="<?= BASE_URL ?>/?page=article&action=detail&id=' + id + '" class="btn" style="border-radius:var(--radius-full);padding:0.35rem 0.8rem;font-size:0.75rem;background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.2);color:#3b82f6">👁️ Voir</a>'
      + '<button onclick="removeFavori(' + id + ')" class="btn" style="border-radius:var(--radius-full);padding:0.35rem 0.8rem;font-size:0.75rem;background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);color:#ef4444;cursor:pointer">🗑️ Retirer</button>'
      + '</div></div>';
  });
  container.innerHTML = html;
}

function removeFavori(id) {
  var key    = getFavorisKey(FAVORIS_NAME, FAVORIS_PIN);
  var favoris = getFavoris(FAVORIS_NAME, FAVORIS_PIN);
  var idx = favoris.indexOf(id);
  if (idx !== -1) {
    favoris.splice(idx, 1);
    localStorage.setItem(key, JSON.stringify(favoris));
    loadFavorisTab();
  }
}
</script>