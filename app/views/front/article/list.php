<?php $keyword = trim($_GET['q'] ?? ''); ?>

<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.18)">
        <i data-lucide="newspaper" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Blog GreenBite
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">
          <?= count($articles) ?> article(s) <?= $keyword !== '' ? 'trouvé(s) pour "' . htmlspecialchars($keyword) . '"' : 'publié(s)' ?>
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=article&action=add" class="btn btn-primary" style="border-radius:var(--radius-full)">
      <i data-lucide="pen-line" style="width:1rem;height:1rem"></i> Soumettre un article
    </a>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div style="padding:1rem 1.25rem;border-radius:0.75rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#166534;border:1px solid #bbf7d0;margin-bottom:1.25rem;font-weight:600">
      <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['error'])): ?>
    <div style="padding:1rem 1.25rem;border-radius:0.75rem;background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;margin-bottom:1.25rem;font-weight:600">
      <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <!-- BARRE DE RECHERCHE -->
  <form method="get" action="<?= BASE_URL ?>/" style="margin-bottom:1.5rem" onsubmit="return validateSearchForm();">
    <input type="hidden" name="page" value="article">
    <input type="hidden" name="action" value="list">
    <div style="display:flex;gap:0.5rem;max-width:480px">
      <div style="flex:1;position:relative">
        <i data-lucide="search" style="position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);width:1rem;height:1rem;color:var(--text-muted)"></i>
        <input
          type="text"
          name="q"
          id="searchInput"
          value="<?= htmlspecialchars($keyword) ?>"
          placeholder="Rechercher un article..."
          class="input"
          style="padding-left:2.5rem"
        />
        <div id="searchErr" style="margin-top:4px;font-size:0.75rem;color:#b91c1c;display:none"></div>
      </div>
      <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">
        Rechercher
      </button>
      <?php if ($keyword !== ''): ?>
        <a href="<?= BASE_URL ?>/?page=article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
          <i data-lucide="x" style="width:1rem;height:1rem"></i>
        </a>
      <?php endif; ?>
    </div>
  </form>

  <?php if (empty($articles)): ?>
    <div class="card" style="padding:5rem 2rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5.5rem;height:5.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.5rem">
        <i data-lucide="inbox" style="width:2.75rem;height:2.75rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.375rem;font-weight:800;color:var(--primary);margin-bottom:0.625rem">
        <?= $keyword !== '' ? 'Aucun résultat pour "' . htmlspecialchars($keyword) . '"' : 'Aucun article publié' ?>
      </h3>
      <p style="color:var(--text-secondary);max-width:30rem;margin:0 auto">
        <?= $keyword !== '' ? 'Essayez avec un autre mot-clé.' : 'Revenez bientôt pour découvrir nos contenus.' ?>
      </p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-2 gap-4">
      <?php foreach ($articles as $a): ?>
        <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= (int)$a['id'] ?>" class="card"
           style="display:block;padding:1.5rem;border:1px solid var(--border);text-decoration:none;transition:all 0.25s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)'"
           onmouseout="this.style.transform='none';this.style.boxShadow=''">
          <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem">
            <div style="min-width:0">
              <div style="font-family:var(--font-heading);font-size:1.05rem;font-weight:900;color:var(--text-primary);line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                <?= htmlspecialchars($a['titre']) ?>
              </div>
              <div style="margin-top:0.35rem;font-size:0.78rem;color:var(--text-muted);display:flex;align-items:center;gap:0.45rem;flex-wrap:wrap">
                <span style="display:inline-flex;align-items:center;gap:0.25rem">
                  <i data-lucide="user" style="width:0.75rem;height:0.75rem"></i>
                  <?= htmlspecialchars($a['auteur'] ?? 'GreenBite') ?>
                </span>
                <span style="width:4px;height:4px;border-radius:50%;background:var(--border)"></span>
                <span style="display:inline-flex;align-items:center;gap:0.25rem">
                  <i data-lucide="calendar" style="width:0.75rem;height:0.75rem"></i>
                  <?= htmlspecialchars($a['date_publication'] ?? '') ?>
                </span>
              </div>
            </div>
            <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:0.75rem;background:rgba(82,183,136,0.08);flex-shrink:0">
              <i data-lucide="arrow-right" style="width:1rem;height:1rem;color:var(--primary)"></i>
            </div>
          </div>
          <div style="margin-top:1rem;color:var(--text-secondary);font-size:0.86rem;line-height:1.7">
            <?php
              $excerpt = trim(strip_tags($a['contenu'] ?? ''));
              if (mb_strlen($excerpt) > 170) $excerpt = mb_substr($excerpt, 0, 170) . '...';
            ?>
            <?= htmlspecialchars($excerpt) ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<script>
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