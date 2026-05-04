<!-- Vue FrontOffice : Détail d'une recette + Commentaires -->
<?php $heroRecipeImg = MediaHelper::url($recette['image'] ?? '', MediaHelper::fallbackRecette($recette['categorie'] ?? '')); ?>
<div style="padding:2rem;max-width:56rem">
  <a href="<?= BASE_URL ?>/?page=recettes" class="flex items-center gap-2 text-sm mb-6" style="color:var(--secondary);font-weight:500;transition:all 0.3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform='translateX(0)'">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux recettes
  </a>

  <!-- En-tête -->
  <div class="card mb-6" style="overflow:hidden;padding:0">
    <div style="height:16rem;overflow:hidden;background:var(--muted)">
      <img src="<?= htmlspecialchars($heroRecipeImg) ?>" alt="<?= htmlspecialchars($recette['titre']) ?>" loading="lazy" decoding="async" style="width:100%;height:100%;object-fit:cover">
    </div>

    <div style="padding:2rem">
      <?php
        $diffBadges = ['facile'=>'badge-green-light','moyen'=>'badge-yellow-light','difficile'=>'badge-red-light'];
        $diffLabels = ['facile'=>'Facile','moyen'=>'Moyen','difficile'=>'Difficile'];
      ?>
      <div class="flex flex-wrap gap-2 mb-3">
        <span class="badge <?= $diffBadges[$recette['difficulte']] ?? 'badge-gray' ?>"><?= $diffLabels[$recette['difficulte']] ?? $recette['difficulte'] ?></span>
        <?php if (!empty($recette['categorie'])): ?><span class="badge badge-gray"><?= htmlspecialchars($recette['categorie']) ?></span><?php endif; ?>
        <?php if ($recette['score_carbone'] <= 1): ?><span class="badge badge-success"><i data-lucide="globe" style="width:0.6rem;height:0.6rem"></i> Low CO₂</span><?php endif; ?>
      </div>

      <h1 class="text-2xl font-bold mb-2" style="color:var(--text-primary);font-family:var(--font-heading)"><?= htmlspecialchars($recette['titre']) ?></h1>
      <p class="text-sm mb-4" style="color:var(--text-secondary);line-height:1.7"><?= htmlspecialchars($recette['description']) ?></p>

      <div class="flex flex-wrap gap-4 p-3 rounded-xl" style="background:var(--muted)">
        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary)"><i data-lucide="clock" style="width:0.875rem;height:0.875rem;color:var(--primary)"></i><span class="font-medium"><?= $recette['temps_preparation'] ?> min</span></div>
        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary)"><i data-lucide="flame" style="width:0.875rem;height:0.875rem;color:var(--accent-orange)"></i><span class="font-medium"><?= $recette['calories_total'] ?> kcal</span></div>
        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary)"><i data-lucide="leaf" style="width:0.875rem;height:0.875rem;color:var(--secondary)"></i><span class="font-medium">Score: <?= $recette['score_carbone'] ?></span></div>
        <?php if (!empty($noteInfo['nb_commentaires'])): ?>
          <div class="flex items-center gap-1 text-sm" style="color:var(--accent-orange)">
            <?php for ($s = 1; $s <= 5; $s++): ?>
              <i data-lucide="<?= $s <= round($noteInfo['note_moyenne']) ? 'star' : 'star' ?>"
                 style="width:0.875rem;height:0.875rem;fill:<?= $s <= round($noteInfo['note_moyenne']) ? 'currentColor' : 'none' ?>"></i>
            <?php endfor; ?>
            <span class="font-medium ml-1"><?= $noteInfo['note_moyenne'] ?>/5</span>
            <span style="color:var(--text-muted)">(<?= $noteInfo['nb_commentaires'] ?> avis)</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="grid gap-6" style="grid-template-columns:1fr 1.5fr;margin-bottom:2rem">
    <!-- Ingrédients -->
    <div class="card">
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="carrot" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Ingrédients</h2>

      <div class="space-y-2">
        <?php foreach ($ingredients as $i): ?>
          <div class="flex items-center justify-between p-2 rounded-xl" style="background:var(--muted);transition:all 0.2s" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
            <div>
              <span class="font-medium text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($i['nom']) ?></span>
              <?php if ($i['is_local']): ?><span class="text-xs ml-1" style="color:var(--secondary)"><i data-lucide="map-pin" style="width:0.6rem;height:0.6rem;display:inline"></i> Local</span><?php endif; ?>
            </div>
            <span class="text-sm" style="color:var(--text-muted)"><?= $i['quantite'] ?> <?= htmlspecialchars($i['unite']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Instructions -->
    <div class="card">
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="chef-hat" style="width:1rem;height:1rem;color:var(--primary)"></i> Instructions</h2>
      <div style="color:var(--text-secondary);line-height:1.8;white-space:pre-line;font-size:0.9rem"><?= htmlspecialchars($recette['instructions']) ?></div>
    </div>
  </div>

  <!-- ═══ API 3: Spoonacular — Analyse Nutritionnelle ═══ -->
  <div id="spoonacular-card" class="card mb-6" style="padding:0;overflow:hidden;border:2px solid rgba(249,115,22,0.15);background:linear-gradient(135deg,rgba(249,115,22,0.03),transparent)">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid rgba(249,115,22,0.1);background:linear-gradient(135deg,rgba(249,115,22,0.06),transparent)">
      <div class="flex items-center gap-3">
        <div style="width:2.25rem;height:2.25rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#ffedd5,#fff7ed);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 10px rgba(249,115,22,0.2)">
          <i data-lucide="brain-circuit" style="width:1.1rem;height:1.1rem;color:#f97316"></i>
        </div>
        <div>
          <h2 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:700;color:var(--text-primary)">🔬 Analyse Nutritionnelle IA</h2>
          <p style="font-size:0.7rem;color:var(--text-muted)">Via Spoonacular · Estimation basée sur le titre de la recette</p>
        </div>
      </div>
      <span id="spoon-status" style="font-size:0.7rem;color:var(--text-muted)"></span>
    </div>
    <div id="spoon-body" style="padding:1.25rem">
      <div id="spoon-loading" style="display:flex;align-items:center;gap:0.75rem;color:var(--text-muted);font-size:0.82rem">
        <div style="width:1.25rem;height:1.25rem;border:2px solid var(--border);border-top-color:#f97316;border-radius:50%;animation:spin 0.7s linear infinite;flex-shrink:0"></div>
        Analyse en cours...
      </div>
      <div id="spoon-content" style="display:none"></div>
    </div>
  </div>

  <!-- ===== SECTION COMMENTAIRES ===== -->

  <div id="commentaires">

    <!-- Flash messages -->
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="flex items-center gap-3 p-4 rounded-xl mb-4"
           style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);border:1px solid #86efac;color:#166534">
        <i data-lucide="check-circle" style="width:1.25rem;height:1.25rem"></i>
        <?= htmlspecialchars($_SESSION['success']) ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
      <div class="flex items-center gap-3 p-4 rounded-xl mb-4"
           style="background:linear-gradient(135deg,#fee2e2,#fef2f2);border:1px solid #fca5a5;color:#991b1b">
        <i data-lucide="x-circle" style="width:1.25rem;height:1.25rem"></i>
        <?= htmlspecialchars($_SESSION['error']) ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Header commentaires -->
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;
                    background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl)">
          <i data-lucide="message-circle" style="width:1.25rem;height:1.25rem;color:#7c3aed"></i>
        </div>
        <div>
          <h2 class="font-bold text-lg" style="color:var(--text-primary);font-family:var(--font-heading)">
            Avis & Commentaires
          </h2>
          <p class="text-xs" style="color:var(--text-muted)">
            <?= count($commentaires) ?> commentaire<?= count($commentaires) > 1 ? 's' : '' ?> approuvé<?= count($commentaires) > 1 ? 's' : '' ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Liste des commentaires -->
    <?php if (empty($commentaires)): ?>
      <div class="card text-center mb-6" style="padding:2.5rem;background:var(--muted)">
        <i data-lucide="message-square" style="width:2.5rem;height:2.5rem;color:var(--text-muted);margin-bottom:0.75rem"></i>
        <p style="color:var(--text-muted);font-size:0.9rem">Aucun avis pour cette recette. Soyez le premier à commenter !</p>
      </div>
    <?php else: ?>
      <div class="space-y-4 mb-6">
        <?php foreach ($commentaires as $com): ?>
          <div class="card" style="padding:1.25rem;border-left:4px solid var(--primary);transition:all 0.2s"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='var(--shadow-md)'"
               onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='var(--shadow-sm)'">

            <!-- Top row: avatar + name + stars -->
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-center gap-3">
                <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;
                            border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));
                            color:#fff;font-weight:700;font-size:1rem;flex-shrink:0">
                  <?= strtoupper(substr($com['auteur'], 0, 1)) ?>
                </div>
                <div>
                  <div class="font-semibold text-sm" style="color:var(--text-primary)"><?= htmlspecialchars($com['auteur']) ?></div>
                  <div class="text-xs" style="color:var(--text-muted)">
                    <?= date('d/m/Y à H\hi', strtotime($com['created_at'])) ?>
                  </div>
                </div>
              </div>
              <!-- Stars -->
              <div class="flex items-center gap-1 flex-shrink-0" style="color:#f59e0b">
                <?php for ($s = 1; $s <= 5; $s++): ?>
                  <i data-lucide="star"
                     style="width:0.875rem;height:0.875rem;fill:<?= $s <= $com['note'] ? 'currentColor' : 'none' ?>;color:<?= $s <= $com['note'] ? '#f59e0b' : 'var(--border)' ?>"></i>
                <?php endfor; ?>
                <span class="font-bold text-xs ml-1" style="color:var(--text-secondary)"><?= $com['note'] ?>/5</span>
              </div>
            </div>

            <!-- Comment text -->
            <p class="mt-3 text-sm" style="color:var(--text-secondary);line-height:1.7">
              <?= htmlspecialchars($com['commentaire']) ?>
            </p>

            <!-- Edit button -->
            <button type="button" onclick="toggleEdit(<?= $com['id'] ?>)"
                    style="margin-top:0.75rem;font-size:0.72rem;color:var(--text-muted);background:none;border:none;
                           cursor:pointer;display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.5rem;
                           border-radius:var(--radius);transition:all 0.2s"
                    onmouseover="this.style.background='var(--muted)';this.style.color='var(--primary)'"
                    onmouseout="this.style.background='none';this.style.color='var(--text-muted)'">
              <i data-lucide="edit-3" style="width:0.7rem;height:0.7rem"></i> Modifier mon avis
            </button>

            <!-- Inline edit form (hidden by default) -->
            <div id="edit-form-<?= $com['id'] ?>" style="display:none;margin-top:1rem;border-top:1px dashed var(--border);padding-top:1rem">
              <form method="POST" action="<?= BASE_URL ?>/?page=recettes&action=update-comment&id=<?= $com['id'] ?>&recette_id=<?= $recette['id'] ?>" class="edit-comment-form" data-auteur="<?= htmlspecialchars(mb_strtolower($com['auteur'])) ?>">

                <!-- Confirm name -->
                <div style="margin-bottom:0.75rem">
                  <label style="font-size:0.75rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:0.25rem">
                    Confirmez votre nom <span style="color:var(--destructive)">*</span>
                    <span style="font-weight:400"> (même nom que lors de la soumission)</span>
                  </label>
                  <input type="text" name="auteur" placeholder="Votre nom exact" class="input"
                         style="width:100%;font-size:0.85rem">
                </div>

                <!-- New star rating -->
                <div style="margin-bottom:0.75rem">
                  <label style="font-size:0.75rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:0.25rem">
                    Nouvelle note <span style="color:var(--destructive)">*</span>
                  </label>
                  <div id="edit-stars-<?= $com['id'] ?>" style="display:flex;gap:0.25rem">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                      <label for="edit-star-<?= $com['id'] ?>-<?= $s ?>"
                             style="cursor:pointer;font-size:1.75rem;color:<?= $s <= $com['note'] ? '#f59e0b' : 'var(--border)' ?>;transition:color 0.15s;line-height:1"
                             onmouseover="hoverEditStars(<?= $com['id'] ?>, <?= $s ?>)"
                             onmouseout="restoreEditStars(<?= $com['id'] ?>)">★</label>
                      <input type="radio" name="note" id="edit-star-<?= $com['id'] ?>-<?= $s ?>"
                             value="<?= $s ?>" <?= $s == $com['note'] ? 'checked' : '' ?>
                             style="display:none" onchange="setEditStars(<?= $com['id'] ?>, <?= $s ?>)">
                    <?php endfor; ?>
                  </div>
                </div>

                <!-- New comment text -->
                <div style="margin-bottom:0.75rem">
                  <label style="font-size:0.75rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:0.25rem">
                    Commentaire <span style="color:var(--destructive)">*</span>
                  </label>
                  <textarea name="commentaire" rows="3" maxlength="1000" class="input"
                            style="width:100%;font-size:0.85rem;resize:vertical"><?= htmlspecialchars($com['commentaire']) ?></textarea>
                </div>

                <div style="display:flex;gap:0.5rem">
                  <button type="submit" class="btn btn-primary" style="font-size:0.8rem;padding:0.45rem 1rem">
                    <i data-lucide="save" style="width:0.75rem;height:0.75rem"></i> Sauvegarder
                  </button>
                  <button type="button" onclick="toggleEdit(<?= $com['id'] ?>)"
                          class="btn btn-outline" style="font-size:0.8rem;padding:0.45rem 1rem">
                    Annuler
                  </button>
                </div>
              </form>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout de commentaire -->
    <div class="card" style="border:2px dashed var(--border)">
      <div class="flex items-center gap-3 mb-5">
        <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;
                    background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl)">
          <i data-lucide="pen-line" style="width:1.25rem;height:1.25rem;color:var(--primary)"></i>
        </div>
        <div>
          <h3 class="font-bold" style="color:var(--text-primary)">Laisser un avis</h3>
          <p class="text-xs" style="color:var(--text-muted)">Votre commentaire sera soumis à validation avant publication.</p>
        </div>
      </div>

      <form id="newCommentForm" method="POST" action="<?= BASE_URL ?>/?page=recettes&action=comment&id=<?= $recette['id'] ?>" novalidate>

        <!-- Nom + Email -->
        <div class="grid gap-4 mb-4" style="grid-template-columns:1fr 1fr">
          <div>
            <label class="text-sm font-semibold mb-1 block" style="color:var(--text-primary)">
              Votre nom <span style="color:var(--destructive)">*</span>
            </label>
            <input type="text" name="auteur" id="auteur" maxlength="150"
                   placeholder="Ex: Marie Dupont"
                   class="input" style="width:100%">
          </div>
          <div>
            <label class="text-sm font-semibold mb-1 block" style="color:var(--text-primary)">
              Email <span style="color:var(--text-muted);font-weight:400">(optionnel)</span>
            </label>
            <input type="email" name="email" id="email" maxlength="150"
                   placeholder="votre@email.com"
                   class="input" style="width:100%">
          </div>
        </div>

        <!-- Note étoiles -->
        <div class="mb-4">
          <label class="text-sm font-semibold mb-2 block" style="color:var(--text-primary)">
            Votre note <span style="color:var(--destructive)">*</span>
          </label>
          <div class="star-rating flex gap-1" id="starRating">
            <?php for ($s = 1; $s <= 5; $s++): ?>
              <label for="star<?= $s ?>" title="<?= $s ?> étoile<?= $s > 1 ? 's' : '' ?>"
                     style="cursor:pointer;font-size:2rem;color:var(--border);transition:color 0.15s"
                     onmouseover="highlightStars(<?= $s ?>)"
                     onmouseout="restoreStars()">
                ★
              </label>
              <input type="radio" name="note" id="star<?= $s ?>" value="<?= $s ?>"
                     style="display:none" onchange="setStarValue(<?= $s ?>)">
            <?php endfor; ?>
          </div>
          <p class="text-xs mt-1" style="color:var(--text-muted)" id="starLabel">Cliquez pour noter</p>
        </div>

        <!-- Commentaire -->
        <div class="mb-5">
          <label for="commentaire" class="text-sm font-semibold mb-1 block" style="color:var(--text-primary)">
            Commentaire <span style="color:var(--destructive)">*</span>
          </label>
          <textarea name="commentaire" id="commentaire" rows="4" maxlength="1000"
                    placeholder="Partagez votre expérience avec cette recette... (min. 10 caractères)"
                    class="input" style="width:100%;resize:vertical;min-height:100px"
                    oninput="updateCharCount(this)"></textarea>
          <p class="text-xs mt-1" style="color:var(--text-muted)">
            <span id="charCount">0</span>/1000 caractères
          </p>
        </div>

        <button type="submit" id="submitComment" class="btn btn-primary"
                style="display:flex;align-items:center;gap:0.5rem">
          <i data-lucide="send" style="width:1rem;height:1rem"></i>
          Soumettre mon avis
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  // ===== Validation helpers =====
  function setInvalid(el, msg) {
    el.style.borderColor = '#ef4444';
    el.style.boxShadow  = '0 0 0 3px rgba(239,68,68,0.15)';
    el.style.animation  = 'shake 0.4s ease';
    setTimeout(() => { el.style.animation = ''; }, 400);
    // Show error label below
    let err = el.parentElement.querySelector('.field-error');
    if (!err) {
      err = document.createElement('p');
      err.className = 'field-error';
      err.style.cssText = 'color:#ef4444;font-size:0.72rem;margin-top:0.25rem';
      el.parentElement.appendChild(err);
    }
    err.textContent = msg;
  }
  function clearInvalid(el) {
    el.style.borderColor = '';
    el.style.boxShadow  = '';
    const err = el.parentElement?.querySelector('.field-error');
    if (err) err.remove();
  }
  function clearAllInvalid(form) {
    form.querySelectorAll('.field-error').forEach(e => e.remove());
    form.querySelectorAll('input,textarea,select').forEach(el => {
      el.style.borderColor = '';
      el.style.boxShadow  = '';
    });
  }

  // Inject shake keyframe
  const _style = document.createElement('style');
  _style.textContent = '@keyframes shake{0%,100%{transform:translateX(0)}20%,60%{transform:translateX(-6px)}40%,80%{transform:translateX(6px)}}';
  document.head.appendChild(_style);

  // ===== New comment star rating =====
  let selectedNote = 0;
  const starLabels = ['Très mauvais','Mauvais','Correct','Bien','Excellent'];
  const labelEls = document.querySelectorAll('#starRating label');

  function highlightStars(n) {
    labelEls.forEach((el, i) => { el.style.color = i < n ? '#f59e0b' : 'var(--border)'; });
  }
  function restoreStars() {
    labelEls.forEach((el, i) => { el.style.color = i < selectedNote ? '#f59e0b' : 'var(--border)'; });
  }
  function setStarValue(n) {
    selectedNote = n;
    document.getElementById('starLabel').textContent = starLabels[n - 1] + ' (' + n + '/5)';
    restoreStars();
    // Clear star error
    const starWrap = document.getElementById('starRating');
    if (starWrap) { starWrap.style.outline = ''; const e = starWrap.parentElement?.querySelector('.field-error'); if(e) e.remove(); }
  }
  function updateCharCount(el) {
    document.getElementById('charCount').textContent = el.value.length;
  }

  // ===== New comment form validation =====
  const newCommentForm = document.getElementById('newCommentForm');
  if (newCommentForm) {
    newCommentForm.addEventListener('submit', function(e) {
      clearAllInvalid(this);
      let valid = true;

      const auteur = this.querySelector('#auteur');
      if (!auteur.value.trim()) {
        setInvalid(auteur, 'Votre nom est obligatoire.');
        if (typeof showToast === 'function') showToast('error', 'Votre nom est obligatoire.');
        valid = false;
      }

      const email = this.querySelector('#email');
      if (email && email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        setInvalid(email, "L'email n'est pas valide.");
        if (valid && typeof showToast === 'function') showToast('error', "L'email n'est pas valide.");
        valid = false;
      }

      if (selectedNote < 1) {
        const starWrap = document.getElementById('starRating');
        starWrap.style.outline = '2px solid #ef4444';
        starWrap.style.borderRadius = '6px';
        let err = starWrap.parentElement.querySelector('.field-error');
        if (!err) { err = document.createElement('p'); err.className='field-error'; err.style.cssText='color:#ef4444;font-size:0.72rem;margin-top:0.25rem'; starWrap.parentElement.appendChild(err); }
        err.textContent = 'Veuillez sélectionner une note.';
        if (valid && typeof showToast === 'function') showToast('error', 'Veuillez sélectionner une note (1 à 5 étoiles).');
        valid = false;
      }

      const commentaire = this.querySelector('#commentaire');
      if (commentaire.value.trim().length < 10) {
        setInvalid(commentaire, 'Le commentaire doit contenir au moins 10 caractères.');
        if (valid && typeof showToast === 'function') showToast('error', 'Le commentaire doit contenir au moins 10 caractères.');
        valid = false;
      } else if (commentaire.value.trim().length > 1000) {
        setInvalid(commentaire, 'Maximum 1000 caractères.');
        if (valid && typeof showToast === 'function') showToast('error', 'Le commentaire ne peut pas dépasser 1000 caractères.');
        valid = false;
      }

      if (!valid) e.preventDefault();
    });

    // Live clear on input
    newCommentForm.querySelectorAll('input,textarea').forEach(el => {
      el.addEventListener('input', () => clearInvalid(el));
    });
  }

  // ===== Inline edit forms validation =====
  document.querySelectorAll('.edit-comment-form').forEach(function(form) {
    const expectedAuteur = form.dataset.auteur || ''; // lowercase expected name

    // Live name check — red border as user types wrong name
    const auteurInput = form.querySelector('input[name="auteur"]');
    if (auteurInput) {
      auteurInput.addEventListener('input', function() {
        clearInvalid(this);
        if (this.value.trim() && this.value.trim().toLowerCase() !== expectedAuteur) {
          this.style.borderColor = '#ef4444';
          this.style.boxShadow  = '0 0 0 3px rgba(239,68,68,0.15)';
          let err = this.parentElement.querySelector('.field-error');
          if (!err) {
            err = document.createElement('p');
            err.className = 'field-error';
            err.style.cssText = 'color:#ef4444;font-size:0.72rem;margin-top:0.25rem';
            this.parentElement.appendChild(err);
          }
          err.textContent = '❌ Nom incorrect. Saisissez : « ' + form.dataset.auteur + ' »';
        }
      });
    }

    form.addEventListener('submit', function(e) {
      clearAllInvalid(this);
      let valid = true;

      // — Name match check (most important)
      if (auteurInput) {
        const entered = auteurInput.value.trim().toLowerCase();
        if (!entered) {
          setInvalid(auteurInput, 'Confirmez votre nom.');
          if (typeof showToast === 'function') showToast('error', 'Vous devez confirmer votre nom.');
          valid = false;
        } else if (entered !== expectedAuteur) {
          setInvalid(auteurInput, '❌ Nom incorrect. Saisissez exactement : « ' + form.dataset.auteur + ' »');
          if (typeof showToast === 'function') showToast('error', 'Nom incorrect — vous ne pouvez modifier que vos propres commentaires.');
          auteurInput.style.animation = 'shake 0.4s ease';
          setTimeout(() => { auteurInput.style.animation = ''; }, 400);
          valid = false;
        }
      }

      // — Star rating check
      const noteChecked = this.querySelector('input[name="note"]:checked');
      if (!noteChecked) {
        const starWrap = this.querySelector('[id^="edit-stars-"]');
        if (starWrap) {
          starWrap.style.outline = '2px solid #ef4444';
          starWrap.style.borderRadius = '6px';
          let err = starWrap.parentElement.querySelector('.field-error');
          if (!err) { err = document.createElement('p'); err.className='field-error'; err.style.cssText='color:#ef4444;font-size:0.72rem;margin-top:0.25rem'; starWrap.parentElement.appendChild(err); }
          err.textContent = 'Veuillez choisir une note.';
        }
        if (valid && typeof showToast === 'function') showToast('error', 'Veuillez choisir une note.');
        valid = false;
      }

      // — Comment text check
      const commentaire = this.querySelector('textarea[name="commentaire"]');
      if (commentaire && commentaire.value.trim().length < 10) {
        setInvalid(commentaire, 'Au moins 10 caractères requis.');
        if (valid && typeof showToast === 'function') showToast('error', 'Le commentaire doit contenir au moins 10 caractères.');
        valid = false;
      } else if (commentaire && commentaire.value.trim().length > 1000) {
        setInvalid(commentaire, 'Maximum 1000 caractères.');
        if (valid && typeof showToast === 'function') showToast('error', 'Maximum 1000 caractères.');
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  });

  // ===== Inline edit forms toggle + star logic =====
  const editSelected = {};

  function toggleEdit(id) {
    const form = document.getElementById('edit-form-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
  }
  function hoverEditStars(id, n) {
    const labels = document.querySelectorAll('#edit-stars-' + id + ' label');
    labels.forEach((el, i) => { el.style.color = i < n ? '#f59e0b' : 'var(--border)'; });
  }
  function restoreEditStars(id) {
    const val = editSelected[id] || 0;
    const labels = document.querySelectorAll('#edit-stars-' + id + ' label');
    labels.forEach((el, i) => { el.style.color = i < val ? '#f59e0b' : 'var(--border)'; });
  }
  function setEditStars(id, n) {
    editSelected[id] = n;
    restoreEditStars(id);
    // Clear star error
    const starWrap = document.getElementById('edit-stars-' + id);
    if (starWrap) { starWrap.style.outline = ''; const e = starWrap.parentElement?.querySelector('.field-error'); if(e) e.remove(); }
  }

  // Init each edit form star state from the pre-checked radio
  document.querySelectorAll('[id^="edit-stars-"]').forEach(container => {
    const id = container.id.replace('edit-stars-', '');
    const checked = container.closest('.card').querySelector('input[name="note"]:checked');
    if (checked) {
      editSelected[id] = parseInt(checked.value);
      restoreEditStars(id);
    }
  });
</script>

<script>
// ═══ API 3: Spoonacular — Nutrition Analysis ═══
(async function() {
  const title  = <?= json_encode($recette['titre']) ?>;
  const storedCal = <?= (int)($recette['calories_total'] ?? 0) ?>;
  const apiKey = 'b3fc0d49128842d891296aa0bd1b0053';
  const loading = document.getElementById('spoon-loading');
  const content = document.getElementById('spoon-content');
  const status  = document.getElementById('spoon-status');

  const bar = (val, color, label, unit, total) => `
    <div style="margin-bottom:0.875rem">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.3rem">
        <span style="font-size:0.75rem;font-weight:600;color:var(--text-secondary)">${label}</span>
        <span style="font-size:0.75rem;font-weight:700;color:${color}">${val}${unit}</span>
      </div>
      <div style="height:8px;background:var(--muted);border-radius:99px;overflow:hidden">
        <div style="height:100%;width:${Math.min(100,Math.round(val/(total||1)*100))}%;background:${color};border-radius:99px;transition:width 1s ease-out"></div>
      </div>
    </div>`;

  function renderCard(cal, prot, carb, fat, source) {
    const total = prot + carb + fat || 1;
    content.innerHTML = `
      <div style="display:grid;grid-template-columns:auto 1fr;gap:1.25rem 2rem;align-items:start">
        <div style="text-align:center;padding:1rem 1.5rem;background:linear-gradient(135deg,#ffedd5,#fff7ed);border-radius:var(--radius-xl);border:2px solid rgba(249,115,22,0.2)">
          <div style="font-size:2rem;font-weight:900;color:#f97316;line-height:1">${cal}</div>
          <div style="font-size:0.7rem;font-weight:600;color:var(--text-muted);margin-top:0.25rem">kcal</div>
          <div style="font-size:0.62rem;color:var(--text-muted);margin-top:0.15rem">estimées</div>
        </div>
        <div style="flex:1">
          ${bar(prot,'#2563eb','🥩 Protéines','g', total)}
          ${bar(carb,'#16a34a','🌾 Glucides','g', total)}
          ${bar(fat,'#f97316','🧈 Lipides','g', total)}
        </div>
      </div>
      <p style="font-size:0.65rem;color:var(--text-muted);margin-top:0.75rem;display:flex;align-items:center;gap:0.3rem">
        <i data-lucide="info" style="width:0.65rem;height:0.65rem"></i>
        ${source}
      </p>`;
    loading.style.display = 'none';
    content.style.display = 'block';
    status.textContent = '✅ Analyse complète';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  }

  function localFallback() {
    // Use stored calories or estimate; split into typical macro ratios
    var cal = storedCal > 0 ? storedCal : 400;
    var titleLow = title.toLowerCase();
    var prot, carb, fat;
    // Adjust ratios by recipe type
    if (/salade|salad|veggie|vegan|légume|vegetable/.test(titleLow)) {
      prot = Math.round(cal * 0.15 / 4);
      fat  = Math.round(cal * 0.25 / 9);
      carb = Math.round(cal * 0.60 / 4);
    } else if (/poulet|chicken|dinde|turkey|viande|beef|lamb/.test(titleLow)) {
      prot = Math.round(cal * 0.35 / 4);
      fat  = Math.round(cal * 0.30 / 9);
      carb = Math.round(cal * 0.35 / 4);
    } else if (/pâtes|pasta|riz|rice|bowl|couscous/.test(titleLow)) {
      prot = Math.round(cal * 0.15 / 4);
      fat  = Math.round(cal * 0.20 / 9);
      carb = Math.round(cal * 0.65 / 4);
    } else {
      prot = Math.round(cal * 0.20 / 4);
      fat  = Math.round(cal * 0.30 / 9);
      carb = Math.round(cal * 0.50 / 4);
    }
    renderCard(cal, prot, carb, fat, 'Estimation locale basée sur le profil de la recette · Les valeurs réelles peuvent varier');
  }

  try {
    // Translate French food words → English so Spoonacular understands the recipe
    const frToEn = {
      'poulet':'chicken','boeuf':'beef','veau':'veal','porc':'pork','agneau':'lamb',
      'saumon':'salmon','thon':'tuna','crevettes':'shrimp','moules':'mussels',
      'salade':'salad','soupe':'soup','velouté':'cream soup','gratin':'gratin',
      'pâtes':'pasta','riz':'rice','couscous':'couscous','quiche':'quiche',
      'tarte':'tart','pizza':'pizza','burger':'burger','sandwich':'sandwich',
      'curry':'curry','rôti':'roast','ragoût':'stew','mijoté':'braised',
      'tomate':'tomato','carotte':'carrot','courgette':'zucchini','champignon':'mushroom',
      'épinard':'spinach','avocat':'avocado','brocoli':'broccoli','aubergine':'eggplant',
      'poivron':'pepper','oignon':'onion','ail':'garlic','pomme de terre':'potato',
      'lentilles':'lentils','pois chiches':'chickpeas','haricots':'beans',
      'fromage':'cheese','oeuf':'egg','crème':'cream','beurre':'butter',
      'bio':'organic','maison':'homemade','au four':'baked','grillé':'grilled',
      'césar':'caesar','méditerranéen':'mediterranean','asiatique':'asian',
      'thaï':'thai','indien':'indian','libanais':'lebanese','mexicain':'mexican'
    };
    var translatedTitle = title.toLowerCase();
    Object.keys(frToEn).forEach(function(fr) {
      translatedTitle = translatedTitle.replace(new RegExp(fr, 'gi'), frToEn[fr]);
    });
    const res = await fetch(`https://api.spoonacular.com/recipes/guessNutrition?title=${encodeURIComponent(translatedTitle)}&apiKey=${apiKey}`);
    if (res.status === 402 || res.status === 429) { localFallback(); return; }
    if (!res.ok) { localFallback(); return; }
    const d = await res.json();
    // Check for quota error embedded in 200 response
    if (d.code === 402 || d.status === 'failure') { localFallback(); return; }
    const cal  = Math.round(d.calories?.value  || 0);
    const prot = Math.round(d.protein?.value   || 0);
    const carb = Math.round(d.carbs?.value     || 0);
    const fat  = Math.round(d.fat?.value       || 0);
    // If all zeros, use fallback
    if (cal === 0 && prot === 0 && carb === 0 && fat === 0) { localFallback(); return; }
    renderCard(cal, prot, carb, fat, 'Via Spoonacular · Estimation basée sur le titre de la recette · Les valeurs réelles peuvent varier selon les quantités');
  } catch(err) {
    localFallback();
  }
})();
</script>

