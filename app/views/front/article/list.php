<?php $keyword = trim($_GET['q'] ?? ''); ?>

<div style="padding:2.5rem">

  <!-- HEADER -->
  <div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-4">
      <div style="width:3.8rem;height:3.8rem;border-radius:1.2rem;
                  background:linear-gradient(135deg,#fef3c7,#fef9c3,#fde68a);
                  display:flex;align-items:center;justify-content:center;
                  box-shadow:0 8px 24px rgba(234,179,8,0.25);">
        <i data-lucide="newspaper" style="width:2rem;height:2rem;color:#b45309"></i>
      </div>

      <div>
        <h1 style="font-size:1.8rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.02em;margin:0">
          Blog GreenBite 🌿
        </h1>
        <p style="font-size:0.85rem;color:var(--text-muted);margin:4px 0 0 0">
          <?= count($articles) ?> article(s)
          <?= $keyword ? ' • Résultat pour "<strong>' . htmlspecialchars($keyword) . '</strong>"' : ' • Découvrez, partagez, inspirez !' ?>
        </p>
      </div>
    </div>

    <div style="display:flex;gap:0.5rem;align-items:center">
      <a href="<?= BASE_URL ?>/?page=article&action=mes-activites"
         class="btn"
         style="padding:0.7rem 1.4rem;font-size:0.9rem;border-radius:var(--radius-full);background:rgba(45,106,79,0.07);border:1px solid rgba(45,106,79,0.18);color:var(--primary)">
         📂 Mes activités
      </a>
      <a href="<?= BASE_URL ?>/?page=article&action=add"
         class="btn btn-primary"
         style="padding:0.7rem 1.6rem;font-size:0.9rem;">
         ✍️ Écrire un article
      </a>
    </div>
  </div>

  <!-- SEARCH -->
  <form method="get" action="<?= BASE_URL ?>/" onsubmit="return validateSearchForm();" style="margin-bottom:2.5rem">
    <input type="hidden" name="page" value="article">
    <input type="hidden" name="action" value="list">

    <div style="display:flex;gap:0.6rem;max-width:560px">

      <div style="flex:1;position:relative">
        <i data-lucide="search"
           style="position:absolute;left:1.1rem;top:50%;transform:translateY(-50%);
                  color:var(--text-muted);width:1.1rem"></i>

        <input
          type="text"
          name="q"
          id="searchInput"
          value="<?= htmlspecialchars($keyword) ?>"
          placeholder="Rechercher un article par titre ou auteur..."
          class="input"
          style="padding-left:2.8rem;border-radius:var(--radius-full);background:var(--surface);"
        >

        <div id="searchErr" style="font-size:0.75rem;color:#dc2626;display:none;margin-top:6px;padding-left:0.5rem"></div>
      </div>

      <button class="btn btn-primary" style="border-radius:var(--radius-full);padding:0 1.4rem;font-size:0.9rem">
        🔍 Rechercher
      </button>

      <?php if ($keyword): ?>
        <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn btn-outline" style="border-radius:var(--radius-full)">
          ✕ Effacer
        </a>
      <?php endif; ?>

    </div>
  </form>

  <!-- ARTICLES -->
  <?php if (empty($articles)): ?>
    <div class="card" style="padding:5rem 3rem;text-align:center;border:2px dashed var(--border);">
      <div style="font-size:4rem;margin-bottom:1rem">📭</div>
      <h3 style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0 0 0.5rem 0">Aucun article trouvé</h3>
      <p style="color:var(--text-muted);margin:0 0 1.5rem 0">
        <?= $keyword ? 'Aucun résultat pour "' . htmlspecialchars($keyword) . '". Essayez un autre mot-clé !' : 'Soyez le premier à partager votre expérience !' ?>
      </p>
      <?php if (!$keyword): ?>
        <a href="<?= BASE_URL ?>/?page=article&action=add" class="btn btn-primary">
          ✍️ Écrire le premier article
        </a>
      <?php endif; ?>
    </div>
  <?php else: ?>

    <div class="grid grid-cols-2 gap-5">

      <?php foreach ($articles as $index => $a):
        $articleId = (int)$a['id'];
        $accents = [
            ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'icon' => '🌱'],
            ['bg' => '#fef3c7', 'border' => '#fde68a', 'icon' => '🍋'],
            ['bg' => '#fce4db', 'border' => '#f8b4a1', 'icon' => '🥕'],
            ['bg' => '#dbeafe', 'border' => '#93c5fd', 'icon' => '🫐'],
            ['bg' => '#f3e8ff', 'border' => '#c4b5fd', 'icon' => '🍇'],
            ['bg' => '#fce7f3', 'border' => '#f9a8d4', 'icon' => '🍓'],
        ];
        $accent = $accents[$index % count($accents)];

        $role = $a['role_utilisateur'] ?? '';
        $roleColor = '#6b7280';
        if (strpos($role, 'Chef') !== false) $roleColor = '#e76f51';
        elseif (strpos($role, 'Nutritionniste') !== false || strpos($role, 'Diété') !== false) $roleColor = '#059669';
        elseif (strpos($role, 'Étudiant') !== false) $roleColor = '#3b82f6';
        elseif (strpos($role, 'Athlète') !== false || strpos($role, 'Sportif') !== false) $roleColor = '#f59e0b';
        elseif (strpos($role, 'Parent') !== false) $roleColor = '#8b5cf6';
        elseif (strpos($role, 'Jardinier') !== false) $roleColor = '#22c55e';
        elseif (strpos($role, 'Food') !== false) $roleColor = '#ec4899';
        elseif (strpos($role, 'Éco') !== false) $roleColor = '#14b8a6';
        elseif (strpos($role, 'Passionné') !== false) $roleColor = '#f97316';
      ?>
        <div class="card"
           style="padding:1.8rem;display:block;
                  border-left:5px solid <?= $accent['border'] ?>;
                  background:linear-gradient(135deg, var(--card) 0%, <?= $accent['bg'] ?> 100%);">

          <!-- CLICKABLE ZONE -->
          <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= $articleId ?>"
             style="text-decoration:none;display:block;">

            <!-- ICON + TITLE -->
            <div style="display:flex;align-items:flex-start;gap:1rem;">
              <span style="font-size:2rem;flex-shrink:0;line-height:1"><?= $accent['icon'] ?></span>
              <div style="flex:1">
                <h3 style="font-size:1.15rem;font-weight:800;color:var(--text-primary);margin:0;line-height:1.3">
                  <?= htmlspecialchars($a['titre']) ?>
                </h3>

                <div style="margin-top:0.5rem;display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
                  <span style="font-size:0.78rem;color:var(--text-muted);display:flex;align-items:center;gap:0.3rem">
                    <i data-lucide="user" style="width:0.8rem;height:0.8rem"></i>
                    <?= htmlspecialchars($a['auteur']) ?>
                  </span>
                  <span style="font-size:0.78rem;color:var(--text-muted);display:flex;align-items:center;gap:0.3rem">
                    <i data-lucide="calendar" style="width:0.8rem;height:0.8rem"></i>
                    <?= date('d M Y', strtotime($a['date_publication'])) ?>
                  </span>
                </div>

                <?php if (!empty($role)): ?>
                  <div style="margin-top:0.4rem">
                    <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.7rem;font-weight:600;color:<?= $roleColor ?>;background:<?= $roleColor ?>10;padding:0.2rem 0.6rem;border-radius:var(--radius-full);border:1px solid <?= $roleColor ?>30">
                      🏷️ <?= htmlspecialchars($role) ?>
                    </span>
                  </div>
                <?php endif; ?>
              </div>
            </div>

            <!-- CONTENT PREVIEW -->
            <p style="margin-top:1.2rem;font-size:0.9rem;color:var(--text-secondary);line-height:1.7">
              <?php
                $excerpt = trim(strip_tags($a['contenu']));
                if (mb_strlen($excerpt) > 160) $excerpt = mb_substr($excerpt, 0, 160) . '...';
                echo htmlspecialchars($excerpt);
              ?>
            </p>

            <!-- READ MORE -->
            <div style="margin-top:1.2rem;display:flex;align-items:center;justify-content:space-between">
              <span style="font-size:0.82rem;color:var(--primary);font-weight:700;display:flex;align-items:center;gap:0.3rem">
                Lire l'article <i data-lucide="arrow-right" style="width:0.9rem;height:0.9rem"></i>
              </span>
              <span class="badge badge-success" style="font-size:0.68rem">Publié</span>
            </div>
          </a>

          <!-- 👍👎 LIKE/DISLIKE OUTSIDE THE LINK -->
          <div style="margin-top:0.6rem;display:flex;align-items:center;gap:0.5rem;border-top:1px solid var(--border);padding-top:0.6rem">
            <button onclick="event.preventDefault(); toggleReaction('article', <?= $articleId ?>, 'like')" id="article-like-btn-<?= $articleId ?>" style="display:flex;align-items:center;gap:0.2rem;padding:0.25rem 0.6rem;border:1px solid var(--border);border-radius:var(--radius-full);background:transparent;cursor:pointer;font-size:0.72rem;color:var(--text-muted);transition:all 0.2s">
              👍 <span id="article-like-count-<?= $articleId ?>">0</span>
            </button>
            <button onclick="event.preventDefault(); toggleReaction('article', <?= $articleId ?>, 'dislike')" id="article-dislike-btn-<?= $articleId ?>" style="display:flex;align-items:center;gap:0.2rem;padding:0.25rem 0.6rem;border:1px solid var(--border);border-radius:var(--radius-full);background:transparent;cursor:pointer;font-size:0.72rem;color:var(--text-muted);transition:all 0.2s">
              👎 <span id="article-dislike-count-<?= $articleId ?>">0</span>
            </button>
          </div>
        </div>
      <?php endforeach; ?>

    </div>

  <?php endif; ?>

</div>

<script>
// ==================== REACTIONS ====================
function toggleReaction(type, id, reaction) {
  const key = 'reaction_' + type + '_' + id;
  const current = localStorage.getItem(key);
  const likeBtn = document.getElementById(type + '-like-btn-' + id);
  const dislikeBtn = document.getElementById(type + '-dislike-btn-' + id);
  const likeCount = document.getElementById(type + '-like-count-' + id);
  const dislikeCount = document.getElementById(type + '-dislike-count-' + id);

  if (!likeBtn || !dislikeBtn) return;

  likeBtn.style.background = 'transparent';
  likeBtn.style.color = 'var(--text-muted)';
  likeBtn.style.borderColor = 'var(--border)';
  dislikeBtn.style.background = 'transparent';
  dislikeBtn.style.color = 'var(--text-muted)';
  dislikeBtn.style.borderColor = 'var(--border)';

  let likes = parseInt(localStorage.getItem(key + '_likes') || '0');
  let dislikes = parseInt(localStorage.getItem(key + '_dislikes') || '0');

  if (current === reaction) {
    localStorage.removeItem(key);
    if (reaction === 'like') likes--;
    else dislikes--;
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
  }

  likeCount.textContent = likes;
  dislikeCount.textContent = dislikes;
  localStorage.setItem(key + '_likes', likes);
  localStorage.setItem(key + '_dislikes', dislikes);
}

function loadReactions() {
  <?php foreach ($articles as $a): ?>
  (function(){
    var id = <?= (int)$a['id'] ?>;
    var key = 'reaction_article_' + id;
    var current = localStorage.getItem(key);
    var likeBtn = document.getElementById('article-like-btn-' + id);
    var dislikeBtn = document.getElementById('article-dislike-btn-' + id);
    var likeCount = document.getElementById('article-like-count-' + id);
    var dislikeCount = document.getElementById('article-dislike-count-' + id);
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
  })();
  <?php endforeach; ?>
}

document.addEventListener('DOMContentLoaded', loadReactions);

// ==================== SEARCH ====================
function validateSearchForm() {
  const input = document.getElementById('searchInput');
  const err   = document.getElementById('searchErr');
  const val   = (input.value || '').trim();

  err.style.display = 'none';

  if (val.length === 1) {
    err.textContent = 'Veuillez saisir au moins 2 caractères.';
    err.style.display = 'block';
    return false;
  }

  return true;
}
</script>