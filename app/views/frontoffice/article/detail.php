<?php
$articleId = (int)$article['id'];
$articleLength = mb_strlen($article['contenu'] ?? '');
$showResumeBtn = true;
?>

<div style="padding:2rem">
  <div class="mb-5" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem">
    <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:0.95rem;height:0.95rem"></i> Retour
    </a>

    <!-- ⭐ FAVORIS + 📤 PARTAGE -->
    <div style="display:flex;gap:0.5rem;align-items:center">
      <button onclick="toggleFavori(<?= $articleId ?>)" id="favori-btn-<?= $articleId ?>" style="display:flex;align-items:center;gap:0.3rem;padding:0.5rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-full);background:var(--surface);cursor:pointer;font-size:1.3rem;color:var(--text-muted);transition:all 0.2s" title="Ajouter aux favoris">☆</button>

      <button onclick="shareArticle(<?= $articleId ?>, '<?= addslashes(htmlspecialchars($article['titre'] ?? '')) ?>')" style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border:1.5px solid var(--border);border-radius:50%;background:var(--surface);cursor:pointer;color:var(--text-muted);transition:all 0.2s" title="Partager">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
      </button>
    </div>
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

    <!-- 🌐 TRANSLATION + 📝 RESUME -->
    <div style="margin-top:1.5rem;display:flex;align-items:center;gap:0.75rem;border-top:1px solid var(--border);padding-top:1rem;flex-wrap:wrap">
      <span style="font-size:0.82rem;font-weight:700;color:var(--text-muted)">🌐 Traduire :</span>
      <select id="translateLang" onchange="translateArticle()" style="padding:0.4rem 0.8rem;border:1.5px solid var(--border);border-radius:var(--radius-full);background:var(--surface);color:var(--text-primary);font-size:0.82rem;cursor:pointer">
        <option value="">-- Langue --</option>
        <option value="en">🇬🇧 English</option>
        <option value="ar">🇸🇦 العربية</option>
        <option value="fr">🇫🇷 Français</option>
      </select>
      <span id="translateStatus" style="font-size:0.75rem;color:var(--text-muted);display:none">Traduction en cours...</span>

      <?php if ($showResumeBtn): ?>
      <button onclick="showResumePopup()" style="margin-left:auto;padding:0.4rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius-full);background:var(--surface);cursor:pointer;font-size:0.82rem;font-weight:700;color:var(--text-secondary);transition:all 0.2s" title="Résumé IA">
        📝 Résumer
      </button>
      <?php endif; ?>
    </div>

    <!-- Traduction display area -->
    <div id="translationResult" style="display:none;margin-top:0.8rem;padding:1rem;background:rgba(82,183,136,0.06);border:2px solid #a7f3d0;border-radius:1rem">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem">
        <span style="font-size:0.78rem;font-weight:700;color:var(--primary)">🌐 Traduction</span>
        <button onclick="hideTranslation()" style="background:transparent;border:none;cursor:pointer;font-size:0.9rem;color:var(--text-muted)">✕</button>
      </div>
      <div id="translationText" style="color:var(--text-primary);font-size:0.92rem;line-height:1.85;white-space:pre-wrap"></div>
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
  <style>
  /* ─── Dynamic validation styles (from add.php) ─── */
  .art-field-error {
    display: none;
    align-items: center;
    gap: 0.35rem;
    margin-top: 0.35rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #ef4444;
    animation: artFadeUp 0.2s ease;
  }
  .art-field-error.visible { display: flex; }
  .art-input-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important;
  }
  .art-input-valid {
    border-color: #22c55e !important;
    box-shadow: 0 0 0 3px rgba(34,197,94,0.10) !important;
  }
  @keyframes artFadeUp {
    from { opacity:0; transform:translateY(4px); }
    to   { opacity:1; transform:translateY(0); }
  }

  .art-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 0.875rem;
    font-size: 0.9rem;
    background: var(--surface);
    color: var(--foreground);
    transition: all 0.25s;
    outline: none;
    font-family: inherit;
  }
  .art-input:focus {
    border-color: var(--secondary);
    box-shadow: 0 0 0 3px rgba(82,183,136,0.12);
  }
  .art-label {
    display: block;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 0.45rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }
  .art-char-count {
    font-size: 0.7rem;
    color: var(--text-muted);
    text-align: right;
    margin-top: 0.3rem;
    transition: color 0.2s;
  }

  .art-submit-btn {
    position: relative;
    overflow: hidden;
  }
  .art-submit-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
    pointer-events: none;
  }
  .art-submit-btn:disabled {
    opacity: 0.55;
    cursor: not-allowed;
  }

  .pin-dots {
    display: flex;
    gap: 0.4rem;
    margin-top: 0.5rem;
  }
  .pin-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: var(--border);
    transition: all 0.2s;
  }
  .pin-dot.filled {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 0 6px rgba(245,158,11,0.5);
  }
  </style>

  <div style="margin-top:2.5rem;margin-bottom:2rem">
    <div class="card" style="padding:2.25rem;border:1.5px solid var(--border);border-radius:1.25rem;display:flex;flex-direction:column;gap:1.6rem">
      
      <!-- HEADER -->
      <div style="display:flex;align-items:center;gap:1rem;margin-bottom:0.5rem">
        <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;
                    background:linear-gradient(135deg,#e0e7ff,#c7d2fe);border-radius:1rem;
                    box-shadow:0 8px 24px rgba(99,102,241,0.25)">
          <i data-lucide="message-square-plus" style="width:1.5rem;height:1.5rem;color:#4f46e5"></i>
        </div>
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:900;
                     color:var(--text-primary);letter-spacing:-0.02em;margin:0">
            Laisser un commentaire
          </h3>
          <p style="font-size:0.82rem;color:var(--text-muted);margin:4px 0 0 0">
            Participez à la discussion et donnez votre avis ! 💬
          </p>
        </div>
      </div>

      <?php if (!empty($errors)): ?>
        <div style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1.5px solid #fca5a5;
                    border-radius:var(--radius-xl);padding:1rem 1.25rem">
          <?php foreach ($errors as $e): ?>
            <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:#dc2626;padding:0.2rem 0">
              <i data-lucide="alert-circle" style="width:0.875rem;height:0.875rem;flex-shrink:0"></i>
              <?= htmlspecialchars($e) ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= BASE_URL ?>/?page=article&action=comment&id=<?= $articleId ?>" id="commentAddForm" novalidate style="display:flex;flex-direction:column;gap:1.6rem">
        
        <!-- ROW 1: Auteur + PIN -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
          <!-- Auteur -->
          <div>
            <label for="commentAuteur" class="art-label">
              <i data-lucide="user" style="width:0.85rem;height:0.85rem;color:#3b82f6"></i>
              Votre nom <span style="color:#ef4444">*</span>
            </label>
            <input type="text" name="auteur" id="commentAuteur" class="art-input"
                   value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>"
                   placeholder="Ex: Amine Khoury" maxlength="120" autocomplete="name">
            <div class="art-field-error" id="err-commentAuteur">
              <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
              <span></span>
            </div>
          </div>

          <!-- PIN -->
          <div>
            <label for="commentPin" class="art-label">
              <i data-lucide="key-round" style="width:0.85rem;height:0.85rem;color:#f59e0b"></i>
              Code PIN (4 chiffres) <span style="color:#ef4444">*</span>
            </label>
            <input type="text" name="pin" id="commentPin" class="art-input"
                   value="<?= htmlspecialchars($_POST['pin'] ?? '') ?>"
                   placeholder="Ex: 1234"
                   maxlength="4" inputmode="numeric" pattern="\d{4}"
                   style="letter-spacing:0.4em;font-size:1.2rem;font-weight:700;max-width:160px">
            <div class="pin-dots" id="commentPinDots">
              <div class="pin-dot" id="cpd0"></div>
              <div class="pin-dot" id="cpd1"></div>
              <div class="pin-dot" id="cpd2"></div>
              <div class="pin-dot" id="cpd3"></div>
            </div>
            <p style="font-size:0.7rem;color:var(--text-muted);margin:0.3rem 0 0">
              Même PIN que pour vos articles. <a href="<?= BASE_URL ?>/?page=article&action=add" style="color:var(--primary)">Pas encore d'article ?</a>
            </p>
            <div class="art-field-error" id="err-commentPin">
              <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
              <span></span>
            </div>
          </div>
        </div>

        <!-- ROW 2: Contenu -->
        <div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.45rem">
            <label for="commentContenu" class="art-label" style="margin-bottom:0">
              <i data-lucide="message-square-dashed" style="width:0.85rem;height:0.85rem;color:#10b981"></i>
              Votre commentaire <span style="color:#ef4444">*</span>
            </label>
            <span style="font-size:0.7rem;color:var(--text-muted)">min 5 caractères</span>
          </div>
          <textarea name="contenu" id="commentContenu" class="art-input" rows="4"
                    placeholder="Qu'avez-vous pensé de cet article ?..."
                    style="line-height:1.6;resize:vertical;min-height:100px"><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
          <div style="display:flex;align-items:center;justify-content:space-between">
            <div class="art-field-error" id="err-commentContenu" style="margin-top:0.35rem">
              <i data-lucide="alert-circle" style="width:0.75rem;height:0.75rem;flex-shrink:0"></i>
              <span></span>
            </div>
            <div class="art-char-count" id="commentContenuCount" style="margin-left:auto">0 caractères</div>
          </div>
        </div>

        <!-- SUBMIT -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:1rem;border-top:1.5px solid var(--border);flex-wrap:wrap;gap:1rem">
          <div style="padding:0.7rem 1rem;border:1px solid #fef3c7;border-radius:0.75rem;background:#fffbeb;color:#92400e;font-size:0.78rem;line-height:1.5;flex:1;min-width:250px">
            🙏 <strong>Soyez respectueux</strong> — Les commentaires inappropriés peuvent être signalés.
          </div>
          <button type="submit" id="commentSubmitBtn" class="btn btn-primary art-submit-btn"
                  style="padding:0.8rem 2.2rem;font-size:0.95rem;border-radius:var(--radius-full);gap:0.5rem">
            <i data-lucide="send-horizontal" style="width:1.1rem;height:1.1rem"></i>
            Publier le commentaire
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- RÉSUMÉ POPUP -->
<div id="resumePopup" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:10002;align-items:center;justify-content:center;backdrop-filter:blur(4px)">
  <div style="background:var(--card);border-radius:1.5rem;padding:2rem;max-width:500px;width:92%;text-align:center;position:relative;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:hippoPopIn 0.3s ease">
    <button onclick="closeResumePopup()" style="position:absolute;top:1rem;right:1rem;background:rgba(0,0,0,0.06);border:none;width:2rem;height:2rem;border-radius:50%;font-size:1rem;cursor:pointer;color:var(--text-muted)">✕</button>
    <div style="font-size:1.5rem;margin-bottom:0.5rem">🤖</div>
    <div style="font-weight:800;font-size:1rem;color:var(--text-primary);margin-bottom:1rem">Résumé automatique</div>
    <div id="resumeLoading" style="color:var(--text-muted);font-size:0.9rem;padding:1rem">
      Génération du résumé<span class="dots"></span>
    </div>
    <div id="resumeText" style="display:none;color:var(--text-primary);font-size:0.9rem;line-height:1.7;padding:1rem;background:rgba(82,183,136,0.05);border-radius:1rem;text-align:left"></div>
    <div id="resumeError" style="display:none;color:#dc2626;font-size:0.85rem;padding:1rem"></div>
    <div style="display:flex;gap:0.5rem;justify-content:center;margin-top:1rem">
      <button id="resumeCopyBtn" onclick="copyResume()" style="display:none;padding:0.5rem 1.2rem;border:1px solid var(--border);border-radius:var(--radius-full);background:transparent;cursor:pointer;font-size:0.8rem;color:var(--text-primary)">📋 Copier</button>
      <button onclick="closeResumePopup()" style="padding:0.5rem 1.2rem;border:none;border-radius:var(--radius-full);background:rgba(0,0,0,0.05);cursor:pointer;font-size:0.8rem;color:var(--text-muted)">Fermer</button>
    </div>
  </div>
</div>

<style>
@keyframes dots {
  0%, 20% { content: ''; }
  40% { content: '.'; }
  60% { content: '..'; }
  80%, 100% { content: '...'; }
}
.dots::after {
  content: '';
  animation: dots 1.5s infinite;
}
</style>

<script>
// ==================== RÉSUMÉ AI ====================
let cachedResume = null;

function showResumePopup() {
  document.getElementById('resumePopup').style.display = 'flex';
  
  const contenu = <?= json_encode($article['contenu']) ?>;

  // Check minimum length
  if (contenu.length < 500) {
    document.getElementById('resumeLoading').style.display = 'none';
    document.getElementById('resumeText').style.display = 'none';
    document.getElementById('resumeError').textContent = '⚠️ Cet article est trop court pour être résumé (minimum 500 caractères).';
    document.getElementById('resumeError').style.display = 'block';
    document.getElementById('resumeCopyBtn').style.display = 'none';
    return;
  }
  
  if (cachedResume) {
    document.getElementById('resumeLoading').style.display = 'none';
    document.getElementById('resumeError').style.display = 'none';
    document.getElementById('resumeText').textContent = cachedResume;
    document.getElementById('resumeText').style.display = 'block';
    document.getElementById('resumeCopyBtn').style.display = 'inline-flex';
    return;
  }

  document.getElementById('resumeLoading').style.display = 'block';
  document.getElementById('resumeText').style.display = 'none';
  document.getElementById('resumeError').style.display = 'none';
  document.getElementById('resumeCopyBtn').style.display = 'none';

  fetch('<?= BASE_URL ?>/?page=article&action=resume', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'contenu=' + encodeURIComponent(contenu)
  })
  .then(r => r.json())
  .then(data => {
    document.getElementById('resumeLoading').style.display = 'none';
    if (data.success) {
      cachedResume = data.resume;
      document.getElementById('resumeText').textContent = data.resume;
      document.getElementById('resumeText').style.display = 'block';
      document.getElementById('resumeCopyBtn').style.display = 'inline-flex';
    } else {
      document.getElementById('resumeError').textContent = data.error || 'Erreur lors de la génération.';
      document.getElementById('resumeError').style.display = 'block';
    }
  })
  .catch(() => {
    document.getElementById('resumeLoading').style.display = 'none';
    document.getElementById('resumeError').textContent = 'Erreur réseau.';
    document.getElementById('resumeError').style.display = 'block';
  });
}

function closeResumePopup() {
  document.getElementById('resumePopup').style.display = 'none';
}

function copyResume() {
  navigator.clipboard.writeText(cachedResume || '').then(() => {
    alert('Résumé copié !');
  });
}

// ==================== FAVORIS ====================
function getFavorisKey(name, pin) {
  return 'greenbite_favoris_' + name.toLowerCase().trim() + '_' + pin;
}

function getFavoris(name, pin) {
  try { return JSON.parse(localStorage.getItem(getFavorisKey(name, pin)) || '[]'); } catch(e) { return []; }
}

function saveFavoris(name, pin, ids) {
  localStorage.setItem(getFavorisKey(name, pin), JSON.stringify(ids));
}

function toggleFavori(id) { showFavoriPopup(id); }

function showFavoriPopup(id) {
  const existing = document.getElementById('favori-popup');
  if (existing) existing.remove();
  const btn = document.getElementById('favori-btn-' + id);
  const rect = btn.getBoundingClientRect();
  const popup = document.createElement('div');
  popup.id = 'favori-popup';
  popup.style.cssText = `position:fixed;top:${Math.min(rect.top-10,window.innerHeight-250)}px;left:${Math.max(10,rect.left-150)}px;background:var(--card);border:2px solid var(--border);border-radius:1rem;padding:1rem;z-index:10000;box-shadow:0 12px 40px rgba(0,0,0,0.2);min-width:230px;`;
  popup.innerHTML = `<div style="margin-bottom:0.5rem;font-weight:700;font-size:0.85rem;color:var(--text-primary)">⭐ Sauvegarder ce favori</div>
    <input type="text" id="fav-name-${id}" placeholder="Votre nom" style="width:100%;padding:0.4rem 0.6rem;border:1px solid var(--border);border-radius:0.5rem;font-size:0.8rem;margin-bottom:0.4rem" />
    <input type="password" id="fav-pin-${id}" placeholder="Votre PIN (4 chiffres)" maxlength="4" style="width:100%;padding:0.4rem 0.6rem;border:1px solid var(--border);border-radius:0.5rem;font-size:0.8rem;margin-bottom:0.5rem" />
    <div style="display:flex;gap:0.4rem"><button onclick="saveFavoriWithPin(${id})" style="flex:1;padding:0.4rem;border:none;border-radius:0.5rem;background:var(--primary);color:#fff;cursor:pointer;font-size:0.75rem;font-weight:700">Sauvegarder</button><button onclick="document.getElementById('favori-popup').remove()" style="padding:0.4rem 0.8rem;border:1px solid var(--border);border-radius:0.5rem;background:transparent;cursor:pointer;font-size:0.75rem">✕</button></div>
    <div id="fav-error-${id}" style="font-size:0.7rem;color:#dc2626;margin-top:0.3rem;display:none"></div>`;
  document.body.appendChild(popup);
  setTimeout(function() { const nameInput = document.getElementById('fav-name-' + id); if (nameInput) nameInput.focus(); }, 100);
  setTimeout(function() { document.addEventListener('click', function closePopup(e) { if (!popup.contains(e.target) && e.target !== btn) { popup.remove(); document.removeEventListener('click', closePopup); } }); }, 200);
}

function saveFavoriWithPin(id) {
  const name = (document.getElementById('fav-name-' + id)?.value || '').trim();
  const pin = (document.getElementById('fav-pin-' + id)?.value || '').trim();
  const err = document.getElementById('fav-error-' + id);
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
  popup.innerHTML = `<div style="background:var(--card);border-radius:1.5rem;padding:2rem;max-width:340px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3)"><div style="font-weight:800;margin-bottom:1rem;color:var(--text-primary)">📤 Partager cet article</div><div style="display:flex;flex-direction:column;gap:0.5rem"><button id="copy-link-btn" style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.7rem 1rem;border:1px solid var(--border);border-radius:0.75rem;background:transparent;cursor:pointer;font-size:0.85rem;color:var(--text-primary)">📋 Copier le lien</button><button id="wa-btn" style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.7rem 1rem;border:1px solid var(--border);border-radius:0.75rem;background:transparent;cursor:pointer;font-size:0.85rem;color:var(--text-primary)">💬 WhatsApp</button><button id="fb-btn" style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.7rem 1rem;border:1px solid var(--border);border-radius:0.75rem;background:transparent;cursor:pointer;font-size:0.85rem;color:var(--text-primary)">📘 Facebook</button><button id="close-share-btn" style="width:100%;padding:0.7rem;border:none;border-radius:0.75rem;background:rgba(0,0,0,0.05);cursor:pointer;font-size:0.85rem;color:var(--text-muted);margin-top:0.5rem">Fermer</button></div></div>`;
  document.body.appendChild(popup);
  popup.querySelector('#copy-link-btn').onclick = function() { navigator.clipboard.writeText(url).then(function() { alert('Lien copié !'); popup.remove(); }); };
  popup.querySelector('#wa-btn').onclick = function() { window.open('https://wa.me/?text=' + encodeURIComponent(titre + ' ' + url), '_blank'); popup.remove(); };
  popup.querySelector('#fb-btn').onclick = function() { window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank'); popup.remove(); };
  popup.querySelector('#close-share-btn').onclick = function() { popup.remove(); };
  popup.addEventListener('click', function(e) { if (e.target === popup) popup.remove(); });
}

// ==================== REACTIONS ====================
function toggleReaction(type, id, reaction) {
  const key = 'reaction_' + type + '_' + id;
  const current = localStorage.getItem(key);
  const likeBtn = document.getElementById(type + '-like-btn-' + id);
  const dislikeBtn = document.getElementById(type + '-dislike-btn-' + id);
  const likeCount = document.getElementById(type + '-like-count-' + id);
  const dislikeCount = document.getElementById(type + '-dislike-count-' + id);
  likeBtn.style.background = 'var(--surface)'; likeBtn.style.color = 'var(--text-secondary)';
  dislikeBtn.style.background = 'var(--surface)'; dislikeBtn.style.color = 'var(--text-secondary)';
  let likes = parseInt(localStorage.getItem(key + '_likes') || '0');
  let dislikes = parseInt(localStorage.getItem(key + '_dislikes') || '0');
  if (current === reaction) { localStorage.removeItem(key); if (reaction === 'like') likes--; else dislikes--; likeCount.textContent = likes; dislikeCount.textContent = dislikes; }
  else { if (current === 'like') likes--; if (current === 'dislike') dislikes--; localStorage.setItem(key, reaction); if (reaction === 'like') { likes++; likeBtn.style.background = 'rgba(34,197,94,0.12)'; likeBtn.style.color = '#16a34a'; likeBtn.style.borderColor = '#86efac'; } else { dislikes++; dislikeBtn.style.background = 'rgba(239,68,68,0.1)'; dislikeBtn.style.color = '#dc2626'; dislikeBtn.style.borderColor = '#fca5a5'; } likeCount.textContent = likes; dislikeCount.textContent = dislikes; }
  localStorage.setItem(key + '_likes', likes); localStorage.setItem(key + '_dislikes', dislikes);
}

function loadReactions() {
  loadSingleReaction('article', <?= $articleId ?>);
  <?php foreach ($commentaires as $c): ?> loadSingleReaction('comment', <?= (int)$c['id'] ?>); <?php endforeach; ?>
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
  if (current === 'like' && likeBtn) { likeBtn.style.background = 'rgba(34,197,94,0.12)'; likeBtn.style.color = '#16a34a'; likeBtn.style.borderColor = '#86efac'; }
  else if (current === 'dislike' && dislikeBtn) { dislikeBtn.style.background = 'rgba(239,68,68,0.1)'; dislikeBtn.style.color = '#dc2626'; dislikeBtn.style.borderColor = '#fca5a5'; }
}

function reportComment(id) {
  if (!confirm('Signaler ce commentaire comme inapproprié ?')) return;
  fetch('<?= BASE_URL ?>/?page=article&action=report-comment&id=' + id, { method: 'POST' }).then(r => r.json()).then(data => { if (data.success) { alert('Commentaire signalé.'); location.reload(); } else { alert(data.error || 'Erreur'); } });
}

// ==================== TRADUCTION ====================
function translateArticle() {
  const langue = document.getElementById('translateLang').value;
  if (!langue) { hideTranslation(); return; }
  document.getElementById('translateStatus').style.display = 'inline';
  document.getElementById('translationResult').style.display = 'none';
  const contenu = <?= json_encode($article['contenu']) ?>;
  fetch('<?= BASE_URL ?>/?page=article&action=translate', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: 'contenu=' + encodeURIComponent(contenu) + '&langue=' + encodeURIComponent(langue) })
  .then(r => r.json()).then(data => { document.getElementById('translateStatus').style.display = 'none'; if (data.success) { document.getElementById('translationText').textContent = data.traduction; document.getElementById('translationResult').style.display = 'block'; } else { alert('Erreur de traduction : ' + (data.error || 'inconnue')); } })
  .catch(() => { document.getElementById('translateStatus').style.display = 'none'; alert('Erreur réseau.'); });
}

function hideTranslation() { document.getElementById('translationResult').style.display = 'none'; document.getElementById('translateLang').value = ''; }

// ==================== FORM VALIDATION ====================
function artShowError(fieldId, message) {
  const field  = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return false;
  field.classList.remove('art-input-valid');
  field.classList.add('art-input-invalid');
  errBox.querySelector('span').textContent = message;
  errBox.classList.add('visible');
  if (typeof lucide !== 'undefined') lucide.createIcons();
  return false;
}

function artClearError(fieldId) {
  const field  = document.getElementById(fieldId);
  const errBox = document.getElementById('err-' + fieldId);
  if (!field || !errBox) return true;
  field.classList.remove('art-input-invalid');
  errBox.classList.remove('visible');
  return true;
}

function artMarkValid(fieldId) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  artClearError(fieldId);
  field.classList.add('art-input-valid');
}

function updateCommentPinDots(val) {
  for (let i = 0; i < 4; i++) {
    const dot = document.getElementById('cpd' + i);
    if (dot) dot.classList.toggle('filled', i < val.length);
  }
}

function updateCommentCharCount() {
  const el = document.getElementById('commentContenu');
  const cnt = document.getElementById('commentContenuCount');
  if (!el || !cnt) return;
  cnt.textContent = el.value.length + ' caractères';
}

function validateCommentAuteur() {
  artClearError('commentAuteur');
  const val = document.getElementById('commentAuteur').value.trim();
  if (!val) return artShowError('commentAuteur', 'Votre nom est obligatoire.');
  if (val.length < 2) return artShowError('commentAuteur', 'Le nom doit contenir au moins 2 caractères.');
  artMarkValid('commentAuteur');
  return true;
}

function validateCommentPin() {
  artClearError('commentPin');
  const val = document.getElementById('commentPin').value.trim();
  if (!val) return artShowError('commentPin', 'Le code PIN est obligatoire.');
  if (!/^\d{4}$/.test(val)) return artShowError('commentPin', 'Le PIN doit contenir exactement 4 chiffres.');
  artMarkValid('commentPin');
  return true;
}

function validateCommentContenu() {
  artClearError('commentContenu');
  const val = document.getElementById('commentContenu').value.trim();
  if (!val) return artShowError('commentContenu', 'Le commentaire est obligatoire.');
  if (val.length < 5) return artShowError('commentContenu', 'Le commentaire doit contenir au moins 5 caractères.');
  artMarkValid('commentContenu');
  return true;
}

document.addEventListener('DOMContentLoaded', function() {
  loadReactions();

  const cAuteur = document.getElementById('commentAuteur');
  if(cAuteur) cAuteur.addEventListener('input', validateCommentAuteur);

  const cPin = document.getElementById('commentPin');
  if(cPin) {
    cPin.addEventListener('input', function() {
      this.value = this.value.replace(/\D/g, '').slice(0, 4);
      updateCommentPinDots(this.value);
      validateCommentPin();
    });
    updateCommentPinDots(cPin.value);
  }

  const cContenu = document.getElementById('commentContenu');
  if(cContenu) {
    cContenu.addEventListener('input', function() {
      validateCommentContenu();
      updateCommentCharCount();
    });
    updateCommentCharCount();
  }

  const cForm = document.getElementById('commentAddForm');
  if(cForm) {
    cForm.addEventListener('submit', function(e) {
      let valid = true;
      if (!validateCommentAuteur()) valid = false;
      if (!validateCommentPin()) valid = false;
      if (!validateCommentContenu()) valid = false;

      if (!valid) {
        e.preventDefault();
        const firstInvalid = document.querySelector('.art-input-invalid');
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior:'smooth', block:'center' });
          firstInvalid.focus();
        }
      }
    });
  }
});
</script>