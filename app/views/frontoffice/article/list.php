<?php $keyword = trim($_GET['q'] ?? ''); ?>

<div style="padding:2rem 2.5rem 3rem">

  <!-- ===== HEADER ===== -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem">

    <div style="display:flex;align-items:center;gap:1rem">
      <div style="width:3.5rem;height:3.5rem;border-radius:1.1rem;
                  background:linear-gradient(135deg,#fef3c7,#fde68a);
                  display:flex;align-items:center;justify-content:center;
                  box-shadow:0 6px 20px rgba(234,179,8,0.22);flex-shrink:0">
        <i data-lucide="newspaper" style="width:1.8rem;height:1.8rem;color:#b45309"></i>
      </div>
      <div>
        <h1 style="font-size:1.65rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.02em;margin:0;line-height:1.15">
          Blog GreenBite 🌿
        </h1>
        <p style="font-size:0.82rem;color:var(--text-muted);margin:3px 0 0 0">
          <?= count($articles) ?> article(s)
          <?= $keyword
            ? ' • Résultat pour "<strong>' . htmlspecialchars($keyword) . '</strong>"'
            : ' • Découvrez, partagez, inspirez !' ?>
        </p>
      </div>
    </div>

    <!-- Buttons -->
    <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap">
      <a href="<?= BASE_URL ?>/?page=article&action=add"
         class="btn btn-primary"
         style="padding:0.65rem 1.3rem;font-size:0.85rem;display:flex;align-items:center;gap:0.4rem;border-radius:var(--radius-full)">
        <i data-lucide="pen-line" style="width:0.95rem;height:0.95rem"></i>
        Écrire un article
      </a>
    </div>
  </div>

  <!-- ===== SEARCH BAR ===== -->
  <form method="get" action="<?= BASE_URL ?>/" onsubmit="return validateSearchForm();" style="margin-bottom:2rem">
    <input type="hidden" name="page" value="article">
    <input type="hidden" name="action" value="list">

    <div style="display:flex;gap:0.5rem;max-width:620px;align-items:center">

      <div style="flex:1;position:relative">
        <i data-lucide="search"
           style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);
                  color:var(--text-muted);width:1rem;height:1rem;pointer-events:none;z-index:1"></i>
        <input
          type="text"
          name="q"
          id="searchInput"
          value="<?= htmlspecialchars($keyword) ?>"
          placeholder="Rechercher par titre, contenu ou auteur..."
          style="
            width:100%;
            padding:0.7rem 1rem 0.7rem 2.7rem;
            border:2px solid var(--border);
            border-radius:var(--radius-full);
            font-size:0.875rem;
            font-family:var(--font-body);
            background:var(--surface);
            color:var(--text-primary);
            outline:none;
            transition:border-color 0.2s, box-shadow 0.2s;
          "
          onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.15)'"
          onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'"
        >
        <div id="searchErr" style="font-size:0.73rem;color:#dc2626;display:none;margin-top:5px;padding-left:0.5rem"></div>
      </div>

      <button type="submit" class="btn btn-primary"
              style="border-radius:var(--radius-full);padding:0.7rem 1.4rem;font-size:0.875rem;white-space:nowrap;display:flex;align-items:center;gap:0.35rem">
        <i data-lucide="search" style="width:0.9rem;height:0.9rem"></i>
        Rechercher
      </button>

      <?php if ($keyword): ?>
        <a href="<?= BASE_URL ?>/?page=article&action=list"
           class="btn btn-outline"
           style="border-radius:var(--radius-full);padding:0.7rem 1rem;font-size:0.875rem;white-space:nowrap;display:flex;align-items:center;gap:0.3rem">
          <i data-lucide="x" style="width:0.85rem;height:0.85rem"></i>
          Effacer
        </a>
      <?php endif; ?>

    </div>
  </form>

  <!-- ===== ARTICLES ===== -->
  <?php if (empty($articles)): ?>
    <div class="card" style="padding:5rem 3rem;text-align:center;border:2px dashed var(--border);">
      <div style="font-size:4rem;margin-bottom:1rem">📭</div>
      <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-primary);margin:0 0 0.5rem 0">Aucun article trouvé</h3>
      <p style="color:var(--text-muted);margin:0 0 1.5rem 0">
        <?= $keyword
          ? 'Aucun résultat pour "' . htmlspecialchars($keyword) . '". Essayez un autre mot-clé !'
          : 'Soyez le premier à partager votre expérience !' ?>
      </p>
      <?php if (!$keyword): ?>
        <a href="<?= BASE_URL ?>/?page=article&action=add" class="btn btn-primary">
          ✍️ Écrire le premier article
        </a>
      <?php endif; ?>
    </div>

  <?php else: ?>

    <div style="display:flex;flex-direction:column;gap:1.25rem">

      <?php foreach ($articles as $index => $a):
        $articleId = (int)$a['id'];
        $accents = [
            ['bg' => '#ecfdf5', 'border' => '#a7f3d0', 'icon' => '🌱', 'iconBg' => '#d1fae5'],
            ['bg' => '#fef9ec', 'border' => '#fde68a', 'icon' => '🍋', 'iconBg' => '#fef3c7'],
            ['bg' => '#fff5f2', 'border' => '#f8b4a1', 'icon' => '🥕', 'iconBg' => '#fce4db'],
            ['bg' => '#eff6ff', 'border' => '#93c5fd', 'icon' => '🫐', 'iconBg' => '#dbeafe'],
            ['bg' => '#faf5ff', 'border' => '#c4b5fd', 'icon' => '🍇', 'iconBg' => '#f3e8ff'],
            ['bg' => '#fff0f7', 'border' => '#f9a8d4', 'icon' => '🍓', 'iconBg' => '#fce7f3'],
        ];
        $accent = $accents[$index % count($accents)];

        $role = $a['role_utilisateur'] ?? '';
        $roleColor = '#6b7280';
        if (strpos($role, 'Chef') !== false)                                             $roleColor = '#e76f51';
        elseif (strpos($role, 'Nutritionniste') !== false || strpos($role, 'Diété') !== false) $roleColor = '#059669';
        elseif (strpos($role, 'Étudiant') !== false)                                     $roleColor = '#3b82f6';
        elseif (strpos($role, 'Athlète') !== false || strpos($role, 'Sportif') !== false) $roleColor = '#f59e0b';
        elseif (strpos($role, 'Parent') !== false)                                       $roleColor = '#8b5cf6';
        elseif (strpos($role, 'Jardinier') !== false)                                    $roleColor = '#22c55e';
        elseif (strpos($role, 'Food') !== false)                                         $roleColor = '#ec4899';
        elseif (strpos($role, 'Éco') !== false)                                          $roleColor = '#14b8a6';
        elseif (strpos($role, 'Passionné') !== false)                                    $roleColor = '#f97316';

        $excerpt = trim(strip_tags($a['contenu']));
        if (mb_strlen($excerpt) > 220) $excerpt = mb_substr($excerpt, 0, 220) . '...';
      ?>

        <div class="card" style="
          padding:0;
          border-left:5px solid <?= $accent['border'] ?>;
          background:linear-gradient(135deg, var(--card) 0%, <?= $accent['bg'] ?> 100%);
          overflow:hidden;
          transition:transform 0.2s ease, box-shadow 0.2s ease;
          position:relative;
        "
        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(27,67,50,0.1)'"
        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">

          <!-- Top action buttons -->
          <div style="position:absolute;top:1rem;right:1rem;display:flex;gap:0.4rem;z-index:5">
            <button onclick="event.stopPropagation(); toggleFavori(<?= $articleId ?>)"
                    id="favori-btn-<?= $articleId ?>"
                    title="Ajouter aux favoris"
                    style="width:2.1rem;height:2.1rem;border-radius:50%;border:1.5px solid var(--border);background:var(--surface);cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:all 0.2s;color:var(--text-muted)">☆</button>
            <button onclick="event.stopPropagation(); shareArticle(<?= $articleId ?>, '<?= addslashes(htmlspecialchars($a['titre'] ?? '')) ?>')"
                    title="Partager"
                    style="width:2.1rem;height:2.1rem;border-radius:50%;border:1.5px solid var(--border);background:var(--surface);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;color:var(--text-muted)">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            </button>
          </div>

          <!-- Main card content -->
          <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= $articleId ?>"
             style="text-decoration:none;display:flex;gap:1.25rem;padding:1.5rem 5rem 1.5rem 1.5rem;align-items:flex-start">

            <!-- Icon -->
            <div style="
              width:3.2rem;height:3.2rem;flex-shrink:0;
              background:<?= $accent['iconBg'] ?>;
              border-radius:1rem;
              display:flex;align-items:center;justify-content:center;
              font-size:1.6rem;
              border:1.5px solid <?= $accent['border'] ?>;
            "><?= $accent['icon'] ?></div>

            <!-- Text -->
            <div style="flex:1;min-width:0">
              <h3 style="font-size:1.1rem;font-weight:800;color:var(--text-primary);margin:0 0 0.4rem;line-height:1.35">
                <?= htmlspecialchars($a['titre']) ?>
              </h3>

              <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;margin-bottom:0.6rem">
                <span style="font-size:0.77rem;color:var(--text-muted);display:flex;align-items:center;gap:0.25rem">
                  <i data-lucide="user" style="width:0.75rem;height:0.75rem"></i>
                  <?= htmlspecialchars($a['auteur']) ?>
                </span>
                <span style="width:3px;height:3px;border-radius:50%;background:var(--border)"></span>
                <span style="font-size:0.77rem;color:var(--text-muted);display:flex;align-items:center;gap:0.25rem">
                  <i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i>
                  <?= date('d M Y', strtotime($a['date_publication'])) ?>
                </span>
                <?php if (!empty($role)): ?>
                  <span style="width:3px;height:3px;border-radius:50%;background:var(--border)"></span>
                  <span style="font-size:0.7rem;font-weight:600;color:<?= $roleColor ?>;background:<?= $roleColor ?>15;padding:0.15rem 0.55rem;border-radius:var(--radius-full);border:1px solid <?= $roleColor ?>30">
                    <?= htmlspecialchars($role) ?>
                  </span>
                <?php endif; ?>
              </div>

              <p style="font-size:0.875rem;color:var(--text-secondary);line-height:1.65;margin:0">
                <?= htmlspecialchars($excerpt) ?>
              </p>

              <div style="margin-top:0.9rem;display:flex;align-items:center;gap:0.5rem">
                <span style="font-size:0.82rem;color:var(--primary);font-weight:700;display:flex;align-items:center;gap:0.3rem">
                  Lire l'article <i data-lucide="arrow-right" style="width:0.85rem;height:0.85rem"></i>
                </span>
                <span class="badge badge-success" style="font-size:0.65rem;margin-left:0.5rem">Publié</span>
              </div>
            </div>
          </a>

          <!-- Reactions bar -->
          <div style="
            display:flex;align-items:center;gap:0.5rem;
            padding:0.6rem 1.5rem;
            border-top:1px solid <?= $accent['border'] ?>40;
            background:<?= $accent['bg'] ?>80;
          ">
            <button onclick="toggleReaction('article', <?= $articleId ?>, 'like')"
                    id="article-like-btn-<?= $articleId ?>"
                    style="display:flex;align-items:center;gap:0.3rem;padding:0.25rem 0.75rem;border:1px solid var(--border);border-radius:var(--radius-full);background:var(--surface);cursor:pointer;font-size:0.73rem;color:var(--text-muted);transition:all 0.2s">
              👍 <span id="article-like-count-<?= $articleId ?>">0</span>
            </button>
            <button onclick="toggleReaction('article', <?= $articleId ?>, 'dislike')"
                    id="article-dislike-btn-<?= $articleId ?>"
                    style="display:flex;align-items:center;gap:0.3rem;padding:0.25rem 0.75rem;border:1px solid var(--border);border-radius:var(--radius-full);background:var(--surface);cursor:pointer;font-size:0.73rem;color:var(--text-muted);transition:all 0.2s">
              👎 <span id="article-dislike-count-<?= $articleId ?>">0</span>
            </button>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

</div>

<!-- ===== PAGINATION ===== -->
<?php if ($totalPages > 1): ?>
<div style="display:flex;justify-content:center;align-items:center;gap:0.4rem;margin-top:2rem;padding-bottom:2rem;flex-wrap:wrap">
  <?php if ($page > 1): ?>
    <a href="<?= BASE_URL ?>/?page=article&action=list&p=<?= $page - 1 ?><?= $keyword ? '&q=' . urlencode($keyword) : '' ?>"
       class="btn"
       style="border-radius:var(--radius-full);padding:0.4rem 0.9rem;font-size:0.8rem;background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary);text-decoration:none;display:flex;align-items:center;gap:0.3rem">
      <i data-lucide="chevron-left" style="width:0.85rem;height:0.85rem"></i> Précédent
    </a>
  <?php endif; ?>
  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="<?= BASE_URL ?>/?page=article&action=list&p=<?= $i ?><?= $keyword ? '&q=' . urlencode($keyword) : '' ?>"
       class="btn"
       style="border-radius:var(--radius-full);padding:0.4rem 0.75rem;font-size:0.8rem;text-decoration:none;<?= $i === $page ? 'background:var(--primary);color:#fff;border:none;font-weight:700;' : 'background:rgba(45,106,79,0.04);border:1px solid var(--border);color:var(--text-muted);' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>
  <?php if ($page < $totalPages): ?>
    <a href="<?= BASE_URL ?>/?page=article&action=list&p=<?= $page + 1 ?><?= $keyword ? '&q=' . urlencode($keyword) : '' ?>"
       class="btn"
       style="border-radius:var(--radius-full);padding:0.4rem 0.9rem;font-size:0.8rem;background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary);text-decoration:none;display:flex;align-items:center;gap:0.3rem">
      Suivant <i data-lucide="chevron-right" style="width:0.85rem;height:0.85rem"></i>
    </a>
  <?php endif; ?>
</div>
<?php endif; ?>

<script>
// ==================== FAVORIS ====================
function getFavorisKey(name, pin) { return 'greenbite_favoris_' + name.toLowerCase().trim() + '_' + pin; }
function getFavoris(name, pin) { try { return JSON.parse(localStorage.getItem(getFavorisKey(name, pin)) || '[]'); } catch(e) { return []; } }
function saveFavoris(name, pin, ids) { localStorage.setItem(getFavorisKey(name, pin), JSON.stringify(ids)); }
function toggleFavori(id) { showFavoriPopup(id); }

function showFavoriPopup(id) {
  const existing = document.getElementById('favori-popup');
  if (existing) existing.remove();
  const btn = document.getElementById('favori-btn-' + id);
  const rect = btn.getBoundingClientRect();
  const popup = document.createElement('div');
  popup.id = 'favori-popup';
  popup.style.cssText = `position:fixed;top:${Math.min(rect.bottom + 8, window.innerHeight - 210)}px;left:${Math.max(10, rect.left - 120)}px;background:var(--card);border:2px solid var(--border);border-radius:1rem;padding:1rem;z-index:10000;box-shadow:0 12px 40px rgba(0,0,0,0.2);min-width:230px;`;
  popup.innerHTML = `
    <div style="margin-bottom:0.5rem;font-weight:700;font-size:0.85rem;color:var(--text-primary)">⭐ Sauvegarder ce favori</div>
    <input type="text" id="fav-name-${id}" placeholder="Votre nom" style="width:100%;padding:0.4rem 0.6rem;border:1px solid var(--border);border-radius:0.5rem;font-size:0.8rem;margin-bottom:0.4rem;box-sizing:border-box" />
    <input type="password" id="fav-pin-${id}" placeholder="Votre PIN (4 chiffres)" maxlength="4" style="width:100%;padding:0.4rem 0.6rem;border:1px solid var(--border);border-radius:0.5rem;font-size:0.8rem;margin-bottom:0.5rem;box-sizing:border-box" />
    <div style="display:flex;gap:0.4rem">
      <button onclick="saveFavoriWithPin(${id})" style="flex:1;padding:0.4rem;border:none;border-radius:0.5rem;background:var(--primary);color:#fff;cursor:pointer;font-size:0.75rem;font-weight:700">Sauvegarder</button>
      <button onclick="document.getElementById('favori-popup').remove()" style="padding:0.4rem 0.8rem;border:1px solid var(--border);border-radius:0.5rem;background:transparent;cursor:pointer;font-size:0.75rem">✕</button>
    </div>
    <div id="fav-error-${id}" style="font-size:0.7rem;color:#dc2626;margin-top:0.3rem;display:none"></div>
  `;
  document.body.appendChild(popup);
  setTimeout(() => { const n = document.getElementById('fav-name-' + id); if (n) n.focus(); }, 100);
  setTimeout(() => {
    document.addEventListener('click', function closePopup(e) {
      if (!popup.contains(e.target) && e.target !== btn) { popup.remove(); document.removeEventListener('click', closePopup); }
    });
  }, 200);
}

function saveFavoriWithPin(id) {
  const name = (document.getElementById('fav-name-' + id)?.value || '').trim();
  const pin  = (document.getElementById('fav-pin-' + id)?.value || '').trim();
  const err  = document.getElementById('fav-error-' + id);
  if (name.length < 2) { if (err) { err.textContent = 'Nom requis (min 2 caractères)'; err.style.display = 'block'; } return; }
  if (!/^\d{4}$/.test(pin)) { if (err) { err.textContent = 'PIN requis (4 chiffres)'; err.style.display = 'block'; } return; }
  const favoris = getFavoris(name, pin);
  const idx = favoris.indexOf(id);
  const btn = document.getElementById('favori-btn-' + id);
  if (idx === -1) { favoris.push(id); if (btn) { btn.innerHTML = '⭐'; btn.style.color = '#f59e0b'; } }
  else { favoris.splice(idx, 1); if (btn) { btn.innerHTML = '☆'; btn.style.color = 'var(--text-muted)'; } }
  saveFavoris(name, pin, favoris);
  const popup = document.getElementById('favori-popup');
  if (popup) popup.remove();
}

// ==================== PARTAGE ====================
function shareArticle(id, titre) {
  const url = '<?= BASE_URL ?>/?page=article&action=detail&id=' + id;
  const popup = document.createElement('div');
  popup.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:10001;display:flex;align-items:center;justify-content:center;';
  popup.innerHTML = `
    <div style="background:var(--card);border-radius:1.5rem;padding:2rem;max-width:320px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3)">
      <div style="font-weight:800;margin-bottom:1rem;color:var(--text-primary)">📤 Partager</div>
      <div style="display:flex;flex-direction:column;gap:0.5rem">
        <button id="copy-link-btn" style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.7rem 1rem;border:1px solid var(--border);border-radius:0.75rem;background:transparent;cursor:pointer;font-size:0.85rem;color:var(--text-primary)">📋 Copier le lien</button>
        <button id="wa-btn"        style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.7rem 1rem;border:1px solid var(--border);border-radius:0.75rem;background:transparent;cursor:pointer;font-size:0.85rem;color:var(--text-primary)">💬 WhatsApp</button>
        <button id="fb-btn"        style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.7rem 1rem;border:1px solid var(--border);border-radius:0.75rem;background:transparent;cursor:pointer;font-size:0.85rem;color:var(--text-primary)">📘 Facebook</button>
        <button id="close-share-btn" style="width:100%;padding:0.7rem;border:none;border-radius:0.75rem;background:rgba(0,0,0,0.05);cursor:pointer;font-size:0.85rem;color:var(--text-muted);margin-top:0.25rem">Fermer</button>
      </div>
    </div>`;
  document.body.appendChild(popup);
  popup.querySelector('#copy-link-btn').onclick = () => { navigator.clipboard.writeText(url).then(() => { alert('Lien copié !'); popup.remove(); }); };
  popup.querySelector('#wa-btn').onclick = () => { window.open('https://wa.me/?text=' + encodeURIComponent(titre + ' ' + url), '_blank'); popup.remove(); };
  popup.querySelector('#fb-btn').onclick = () => { window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank'); popup.remove(); };
  popup.querySelector('#close-share-btn').onclick = () => popup.remove();
  popup.addEventListener('click', e => { if (e.target === popup) popup.remove(); });
}

// ==================== REACTIONS ====================
function toggleReaction(type, id, reaction) {
  const key = 'reaction_' + type + '_' + id;
  const current = localStorage.getItem(key);
  const likeBtn    = document.getElementById(type + '-like-btn-' + id);
  const dislikeBtn = document.getElementById(type + '-dislike-btn-' + id);
  const likeCount    = document.getElementById(type + '-like-count-' + id);
  const dislikeCount = document.getElementById(type + '-dislike-count-' + id);
  if (!likeBtn || !dislikeBtn) return;
  likeBtn.style.background    = 'var(--surface)'; likeBtn.style.color    = 'var(--text-muted)'; likeBtn.style.borderColor    = 'var(--border)';
  dislikeBtn.style.background = 'var(--surface)'; dislikeBtn.style.color = 'var(--text-muted)'; dislikeBtn.style.borderColor = 'var(--border)';
  let likes    = parseInt(localStorage.getItem(key + '_likes')    || '0');
  let dislikes = parseInt(localStorage.getItem(key + '_dislikes') || '0');
  if (current === reaction) {
    localStorage.removeItem(key);
    if (reaction === 'like') likes--; else dislikes--;
  } else {
    if (current === 'like') likes--; if (current === 'dislike') dislikes--;
    localStorage.setItem(key, reaction);
    if (reaction === 'like')    { likes++;    likeBtn.style.background    = 'rgba(34,197,94,0.12)'; likeBtn.style.color    = '#16a34a'; likeBtn.style.borderColor    = '#86efac'; }
    else                        { dislikes++; dislikeBtn.style.background = 'rgba(239,68,68,0.1)';  dislikeBtn.style.color = '#dc2626'; dislikeBtn.style.borderColor = '#fca5a5'; }
  }
  likeCount.textContent    = Math.max(0, likes);
  dislikeCount.textContent = Math.max(0, dislikes);
  localStorage.setItem(key + '_likes',    Math.max(0, likes));
  localStorage.setItem(key + '_dislikes', Math.max(0, dislikes));
}

function loadReactions() {
  <?php foreach ($articles as $a): ?>
  (function(){
    var id = <?= (int)$a['id'] ?>;
    var key = 'reaction_article_' + id;
    var current = localStorage.getItem(key);
    var lc = document.getElementById('article-like-count-'    + id);
    var dc = document.getElementById('article-dislike-count-' + id);
    var lb = document.getElementById('article-like-btn-'      + id);
    var db = document.getElementById('article-dislike-btn-'   + id);
    if (lc) lc.textContent = localStorage.getItem(key + '_likes')    || '0';
    if (dc) dc.textContent = localStorage.getItem(key + '_dislikes') || '0';
    if (current === 'like'    && lb) { lb.style.background = 'rgba(34,197,94,0.12)'; lb.style.color = '#16a34a'; lb.style.borderColor = '#86efac'; }
    if (current === 'dislike' && db) { db.style.background = 'rgba(239,68,68,0.1)';  db.style.color = '#dc2626'; db.style.borderColor = '#fca5a5'; }
  })();
  <?php endforeach; ?>
}

document.addEventListener('DOMContentLoaded', function() {
  loadReactions();
  // init favori stars
  document.querySelectorAll('[id^="favori-btn-"]').forEach(btn => { btn.innerHTML = '☆'; btn.style.color = 'var(--text-muted)'; });
  // lucide icons
  if (typeof lucide !== 'undefined') lucide.createIcons();
});

function validateSearchForm() {
  const input = document.getElementById('searchInput');
  const err   = document.getElementById('searchErr');
  const val   = (input?.value || '').trim();
  err.style.display = 'none';
  if (val.length === 1) { err.textContent = 'Veuillez saisir au moins 2 caractères.'; err.style.display = 'block'; return false; }
  return true;
}
</script>

<?php
$citations = [];
$citationsFile = BASE_PATH . '/config/citations.php';
if (file_exists($citationsFile)) require_once $citationsFile;
$citation = !empty($citations) ? $citations[array_rand($citations)] : null;
?>

<?php if ($citation): ?>
<!-- HIPPO MASCOT -->
<div id="hippoBtn" style="position:fixed;z-index:9999;font-size:5rem;cursor:pointer;user-select:none;filter:drop-shadow(0 8px 24px rgba(0,0,0,0.25));transition:transform 0.15s;">🦛</div>
<div id="sparkleTrail" style="position:fixed;inset:0;pointer-events:none;z-index:9998;"></div>
<div id="explosionBurst" style="position:fixed;inset:0;pointer-events:none;z-index:9997;"></div>

<div id="memeModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:10000;align-items:center;justify-content:center;backdrop-filter:blur(5px);">
  <div style="background:var(--card);border:2px solid var(--border);border-radius:2rem;padding:2.5rem 2rem 2rem;max-width:550px;width:92%;text-align:center;position:relative;box-shadow:0 30px 80px rgba(0,0,0,0.35);animation:hippoPopIn 0.5s cubic-bezier(0.34,1.56,0.64,1);">
    <button onclick="closeModal()" style="position:absolute;top:1rem;right:1rem;background:rgba(0,0,0,0.06);border:none;width:2.2rem;height:2.2rem;border-radius:50%;font-size:1.1rem;cursor:pointer;color:var(--text-muted);display:flex;align-items:center;justify-content:center;">✕</button>
    <div style="position:absolute;top:1rem;left:1.2rem;font-size:0.75rem;font-weight:700;color:var(--text-muted)" id="countdown">30s</div>
    <p style="font-family:var(--font-heading);font-size:1.15rem;font-weight:800;color:var(--text-primary);line-height:1.5;margin:0 0 1.5rem;padding:0 0.5rem">"<?= htmlspecialchars($citation['texte']) ?>"</p>
    <img src="<?= BASE_URL ?>/assets/images/memes/<?= htmlspecialchars($citation['image']) ?>" alt="meme" style="width:100%;max-width:340px;height:auto;max-height:340px;object-fit:contain;border-radius:1.5rem;margin-bottom:1.5rem;background:rgba(0,0,0,0.02)" />
    <button id="likeBtn" onclick="toggleLike()" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.6rem;border-radius:var(--radius-full);border:2px solid var(--border);background:transparent;font-size:0.95rem;font-weight:700;cursor:pointer;color:var(--text-secondary);transition:all 0.2s;">👍 <span id="likeCount">0</span></button>
  </div>
</div>

<style>
@keyframes hippoPopIn { from{transform:scale(0.3);opacity:0} to{transform:scale(1);opacity:1} }
@keyframes screenShake { 0%,100%{transform:translate(0,0)} 10%{transform:translate(-6px,3px)} 20%{transform:translate(6px,-3px)} 30%{transform:translate(-5px,-2px)} 40%{transform:translate(5px,2px)} 50%{transform:translate(-3px,-1px)} 60%{transform:translate(3px,1px)} 70%{transform:translate(-1px,0)} 80%{transform:translate(1px,0)} }
.shake-active{animation:screenShake 0.5s ease-in-out}
@keyframes sparkleFade { 0%{opacity:1;transform:translate(0,0) scale(1)} 100%{opacity:0;transform:translate(var(--sx),var(--sy)) scale(0)} }
.sparkle{position:fixed;width:6px;height:6px;background:#52b788;border-radius:50%;pointer-events:none;z-index:9997;animation:sparkleFade 0.7s ease-out forwards;box-shadow:0 0 8px 2px rgba(82,183,136,0.6)}
@keyframes exploseParticle { 0%{opacity:1;transform:translate(0,0) scale(1.5)} 100%{opacity:0;transform:translate(var(--ex),var(--ey)) scale(0)} }
.explosion-particle{position:fixed;width:10px;height:10px;border-radius:50%;pointer-events:none;z-index:10001;animation:exploseParticle 0.6s ease-out forwards;background:var(--color,#52b788);box-shadow:0 0 12px 4px var(--color,rgba(82,183,136,0.7))}
#hippoBtn:hover{transform:scale(1.2)}
</style>

<script>
(function(){
  const btn=document.getElementById('hippoBtn'),trail=document.getElementById('sparkleTrail'),burst=document.getElementById('explosionBurst'),modal=document.getElementById('memeModal');
  let x=Math.random()*(window.innerWidth-100),y=Math.random()*(window.innerHeight-100);
  let vx=(Math.random()>0.5?1:-1)*(0.35+Math.random()*0.3),vy=(Math.random()>0.5?1:-1)*(0.35+Math.random()*0.3);
  let moving=true,captured=false,rafId=null,countdown=30,countdownInterval=null;
  btn.style.left=x+'px';btn.style.top=y+'px';
  let sparkleTick=0;
  function spawnSparkle(cx,cy){sparkleTick++;if(sparkleTick%3!==0)return;const s=document.createElement('div');s.className='sparkle';s.style.left=(cx+(Math.random()-0.5)*40)+'px';s.style.top=(cy+(Math.random()-0.5)*40)+'px';const size=3+Math.random()*5;s.style.width=size+'px';s.style.height=size+'px';trail.appendChild(s);setTimeout(()=>s.remove(),700);}
  function animate(){if(!moving)return;x+=vx;y+=vy;const maxX=window.innerWidth-90,maxY=window.innerHeight-90;if(x<=0){x=0;vx=Math.abs(vx);}if(x>=maxX){x=maxX;vx=-Math.abs(vx);}if(y<=0){y=0;vy=Math.abs(vy);}if(y>=maxY){y=maxY;vy=-Math.abs(vy);}btn.style.left=x+'px';btn.style.top=y+'px';spawnSparkle(x+40,y+40);rafId=requestAnimationFrame(animate);}
  rafId=requestAnimationFrame(animate);
  btn.addEventListener('click',function(){
    if(captured)return;captured=true;moving=false;cancelAnimationFrame(rafId);
    const rect=btn.getBoundingClientRect(),cx=rect.left+rect.width/2,cy=rect.top+rect.height/2;
    const colors=['#52b788','#95d5b2','#f4a261','#e9c46a','#e76f51','#f9c74f','#a7f3d0'];
    for(let i=0;i<40;i++){const p=document.createElement('div');p.className='explosion-particle';p.style.left=cx+'px';p.style.top=cy+'px';const angle=Math.random()*Math.PI*2,dist=60+Math.random()*120;p.style.setProperty('--ex',Math.cos(angle)*dist+'px');p.style.setProperty('--ey',Math.sin(angle)*dist+'px');p.style.setProperty('--color',colors[Math.floor(Math.random()*colors.length)]);burst.appendChild(p);setTimeout(()=>p.remove(),600);}
    btn.style.opacity='0';btn.style.transform='scale(0)';btn.style.transition='opacity 0.2s,transform 0.2s';
    document.body.classList.add('shake-active');setTimeout(()=>document.body.classList.remove('shake-active'),500);
    setTimeout(()=>{openModal();btn.style.transition='left 0.8s ease,top 0.8s ease,opacity 0.3s,transform 0.3s';btn.style.opacity='1';btn.style.transform='scale(0.7)';btn.style.fontSize='3rem';btn.style.left=(window.innerWidth-90)+'px';btn.style.top=(window.innerHeight-90)+'px';},300);
  });
  function openModal(){modal.style.display='flex';loadLike();countdown=30;document.getElementById('countdown').textContent=countdown+'s';countdownInterval=setInterval(()=>{countdown--;const el=document.getElementById('countdown');if(el)el.textContent=countdown+'s';if(countdown<=0)closeModal();},1000);}
  window.closeModal=function(){clearInterval(countdownInterval);modal.style.display='none';};
  modal.addEventListener('click',e=>{if(e.target===modal)closeModal();});
  const LIKE_KEY='greenbite_meme_like_<?= md5($citation['image']) ?>';
  function loadLike(){const count=parseInt(localStorage.getItem(LIKE_KEY)||'0');document.getElementById('likeCount').textContent=count;const liked=localStorage.getItem(LIKE_KEY+'_liked')==='1';const likeBtn=document.getElementById('likeBtn');if(liked){likeBtn.style.background='rgba(22,163,74,0.12)';likeBtn.style.borderColor='#86efac';likeBtn.style.color='#16a34a';}}
  window.toggleLike=function(){const liked=localStorage.getItem(LIKE_KEY+'_liked')==='1';const likeBtn=document.getElementById('likeBtn');const countEl=document.getElementById('likeCount');let count=parseInt(localStorage.getItem(LIKE_KEY)||'0');if(liked){count=Math.max(0,count-1);localStorage.setItem(LIKE_KEY,count);localStorage.removeItem(LIKE_KEY+'_liked');likeBtn.style.background='transparent';likeBtn.style.borderColor='var(--border)';likeBtn.style.color='var(--text-secondary)';}else{count++;localStorage.setItem(LIKE_KEY,count);localStorage.setItem(LIKE_KEY+'_liked','1');likeBtn.style.background='rgba(22,163,74,0.12)';likeBtn.style.borderColor='#86efac';likeBtn.style.color='#16a34a';}countEl.textContent=count;};
})();
</script>
<?php endif; ?>