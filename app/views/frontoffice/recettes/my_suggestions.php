<?php
/**
 * Vue FrontOffice : Mes suggestions de recettes (Client)
 * Le client peut voir, modifier et supprimer ses suggestions
 * tant qu'elles ne sont pas acceptées par l'admin.
 */
$stConfig = [
    'en_attente' => ['label'=>'En attente',  'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,0.1)',  'icon'=>'clock'],
    'refusee'    => ['label'=>'Refusée',     'color'=>'#ef4444', 'bg'=>'rgba(239,68,68,0.1)',   'icon'=>'x-circle'],
    'acceptee'   => ['label'=>'Acceptée',    'color'=>'#16a34a', 'bg'=>'rgba(22,163,74,0.1)',   'icon'=>'check-circle'],
];
$diffLabels = ['facile'=>'Facile','moyen'=>'Moyen','difficile'=>'Difficile'];
?>

<div style="padding:2rem;position:relative">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:1rem;box-shadow:0 6px 18px rgba(234,179,8,0.2);transition:all 0.3s" onmouseover="this.style.transform='rotate(-5deg) scale(1.1)'" onmouseout="this.style.transform='none'">
        <i data-lucide="lightbulb" style="width:1.625rem;height:1.625rem;color:#d97706"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,#d97706,#f59e0b);border-radius:2px"></span>
          Mes Suggestions de Recettes
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;display:flex;align-items:center;gap:0.35rem">
          <i data-lucide="chef-hat" style="width:0.75rem;height:0.75rem;color:var(--text-muted)"></i>
          Gérez vos propositions de recettes
        </p>
      </div>
    </div>
    <div style="display:flex;gap:0.5rem">
      <a href="<?= BASE_URL ?>/?page=recettes&action=suggest"
         class="btn btn-sm"
         style="background:linear-gradient(135deg,#d97706,#f59e0b);border:none;color:#fff;font-weight:700;border-radius:var(--radius-full);box-shadow:0 4px 16px rgba(217,119,6,0.35);transition:all 0.3s"
         onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(217,119,6,0.45)'"
         onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(217,119,6,0.35)'">
        <i data-lucide="plus-circle" style="width:0.875rem;height:0.875rem"></i>
        Nouvelle suggestion
      </a>
      <a href="<?= BASE_URL ?>/?page=recettes"
         class="btn btn-outline btn-sm"
         style="border-radius:var(--radius-full)">
        <i data-lucide="book-open" style="width:0.875rem;height:0.875rem"></i>
        Toutes les recettes
      </a>
    </div>
  </div>

  <!-- Info banner -->
  <div class="flex items-start gap-3 mb-6 p-4 rounded-xl"
       style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #93c5fd;color:#1e40af">
    <i data-lucide="info" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
    <p class="text-sm" style="line-height:1.6">
      Vous pouvez <strong>modifier</strong> ou <strong>supprimer</strong> vos recettes tant qu'elles n'ont pas été acceptées par l'équipe GreenBite.
      Une fois acceptée, la recette est publiée et ne peut plus être modifiée.
    </p>
  </div>

  <?php if (empty($myRecettes)): ?>
    <!-- Empty state -->
    <div class="card" style="padding:5rem 2rem;text-align:center;background:linear-gradient(135deg,rgba(234,179,8,0.04),rgba(217,119,6,0.02))">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:5.5rem;height:5.5rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:50%;margin-bottom:1.5rem;box-shadow:0 8px 24px rgba(234,179,8,0.15);animation:float 3s ease-in-out infinite">
        <i data-lucide="lightbulb" style="width:2.75rem;height:2.75rem;color:#d97706"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.375rem;font-weight:800;color:var(--primary);margin-bottom:0.625rem">Aucune suggestion pour le moment</h3>
      <p style="color:var(--text-secondary);margin-bottom:2rem;max-width:22rem;margin-left:auto;margin-right:auto;line-height:1.65">
        Vous n'avez pas encore proposé de recette.
        <?php if (empty($_SESSION['recette_user'])): ?>
          Soumettez votre première recette pour commencer à suivre vos propositions !
        <?php else: ?>
          Proposez une nouvelle recette écoresponsable ! 🌿
        <?php endif; ?>
      </p>
      <a href="<?= BASE_URL ?>/?page=recettes&action=suggest" class="btn btn-sm" style="background:linear-gradient(135deg,#d97706,#f59e0b);border:none;color:#fff;font-weight:700;border-radius:var(--radius-full);box-shadow:0 4px 16px rgba(217,119,6,0.35)">
        <i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Proposer une recette
      </a>
    </div>
  <?php else: ?>

    <!-- Stats cards -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem">
      <?php
        $countWaiting = 0; $countRefused = 0; $countAccepted = 0;
        foreach ($myRecettes as $mr) {
            if ($mr['statut'] === 'en_attente') $countWaiting++;
            elseif ($mr['statut'] === 'refusee') $countRefused++;
            elseif ($mr['statut'] === 'acceptee') $countAccepted++;
        }
      ?>
      <div class="card" style="padding:1rem;text-align:center;border-top:3px solid #f59e0b">
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:#f59e0b"><?= $countWaiting ?></div>
        <div style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">En attente</div>
      </div>
      <div class="card" style="padding:1rem;text-align:center;border-top:3px solid #16a34a">
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:#16a34a"><?= $countAccepted ?></div>
        <div style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Acceptées</div>
      </div>
      <div class="card" style="padding:1rem;text-align:center;border-top:3px solid #ef4444">
        <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;color:#ef4444"><?= $countRefused ?></div>
        <div style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">Refusées</div>
      </div>
    </div>

    <!-- Suggestions List -->
    <div style="display:flex;flex-direction:column;gap:0.75rem">
      <?php foreach ($myRecettes as $mr):
        $st = $stConfig[$mr['statut']] ?? $stConfig['en_attente'];
        $isAccepted = ($mr['statut'] === 'acceptee');
      ?>
        <div class="card" style="padding:0;overflow:hidden;border:1px solid var(--border);transition:all 0.25s"
             onmouseover="this.style.transform='translateX(3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'"
             onmouseout="this.style.transform='none';this.style.boxShadow=''">

          <!-- Top accent bar -->
          <div style="height:3px;background:<?= $st['color'] ?>"></div>

          <div style="padding:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">

            <!-- Left: image + info -->
            <div style="display:flex;align-items:center;gap:1rem;flex:1;min-width:0">
              <!-- Thumbnail -->
              <div style="width:3.5rem;height:3.5rem;border-radius:0.875rem;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,var(--muted),var(--border))">
                <?php if (!empty($mr['image'])): ?>
                  <img src="<?= BASE_URL ?>/assets/images/uploads/<?= htmlspecialchars($mr['image']) ?>"
                       alt="" style="width:100%;height:100%;object-fit:cover">
                <?php else: ?>
                  <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
                    <i data-lucide="chef-hat" style="width:1.25rem;height:1.25rem;color:var(--text-muted)"></i>
                  </div>
                <?php endif; ?>
              </div>

              <div style="min-width:0;flex:1">
                <div style="font-weight:700;font-size:0.95rem;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($mr['titre']) ?></div>
                <div style="font-size:0.72rem;color:var(--text-muted);display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-top:0.2rem">
                  <span style="display:inline-flex;align-items:center;gap:0.2rem">
                    <i data-lucide="clock" style="width:0.65rem;height:0.65rem"></i>
                    <?= $mr['temps_preparation'] ?>min
                  </span>
                  <span>·</span>
                  <span><?= $diffLabels[$mr['difficulte']] ?? $mr['difficulte'] ?></span>
                  <?php if (!empty($mr['categorie'])): ?>
                    <span>·</span>
                    <span><?= htmlspecialchars($mr['categorie']) ?></span>
                  <?php endif; ?>
                  <span>·</span>
                  <span style="display:inline-flex;align-items:center;gap:0.2rem">
                    <i data-lucide="flame" style="width:0.65rem;height:0.65rem"></i>
                    <?= $mr['calories_total'] ?> kcal
                  </span>
                </div>
              </div>
            </div>

            <!-- Right: status + actions -->
            <div style="display:flex;align-items:center;gap:0.75rem;flex-shrink:0">
              <!-- Status badge -->
              <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:<?= $st['bg'] ?>;color:<?= $st['color'] ?>;font-size:0.72rem;font-weight:700">
                <i data-lucide="<?= $st['icon'] ?>" style="width:0.75rem;height:0.75rem"></i>
                <?= $st['label'] ?>
              </span>

              <?php if (!$isAccepted): ?>
                <!-- Edit button -->
                <a href="<?= BASE_URL ?>/?page=recettes&action=edit-suggestion&id=<?= $mr['id'] ?>"
                   style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.35rem 0.9rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s"
                   onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(45,106,79,0.3)'"
                   onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                  <i data-lucide="edit-3" style="width:0.75rem;height:0.75rem"></i> Modifier
                </a>

                <!-- Delete button -->
                <button type="button"
                   onclick="openDeleteConfirm('<?= BASE_URL ?>/?page=recettes&action=delete-suggestion&id=<?= $mr['id'] ?>', '<?= addslashes(htmlspecialchars($mr['titre'])) ?>')"
                   style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);cursor:pointer;transition:all 0.2s;flex-shrink:0"
                   onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                   onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                   title="Supprimer ma suggestion">
                  <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                </button>
              <?php else: ?>
                <!-- Accepted: locked indicator -->
                <div style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.35rem 0.75rem;background:rgba(22,163,74,0.06);border:1px solid rgba(22,163,74,0.15);border-radius:var(--radius-full);font-size:0.68rem;font-weight:600;color:#16a34a">
                  <i data-lucide="lock" style="width:0.65rem;height:0.65rem"></i> Publiée
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

  <!-- CTA Banner -->
  <div class="card" style="margin-top:2rem;padding:2rem;background:linear-gradient(135deg,rgba(217,119,6,0.06),rgba(245,158,11,0.04));border:1px dashed rgba(217,119,6,0.3);text-align:center">
    <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:#d97706;margin-bottom:0.4rem">
      Vous avez une recette à partager ? 🍳
    </div>
    <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.25rem">Proposez votre recette écoresponsable. Notre équipe l'examinera et la publiera si elle est validée.</p>
    <a href="<?= BASE_URL ?>/?page=recettes&action=suggest" class="btn btn-outline" style="border-radius:var(--radius-full);border-color:#d97706;color:#d97706">
      <i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Soumettre une recette
    </a>
  </div>

</div>

<!-- ===== Custom Delete Confirm Modal ===== -->
<div id="deleteConfirmModal"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);align-items:center;justify-content:center">
  <div style="background:var(--card);border-radius:1.25rem;padding:2rem;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeUp 0.25s ease;text-align:center">
    <!-- Icon -->
    <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(239,68,68,0.1);border-radius:50%;margin-bottom:1rem">
      <i data-lucide="trash-2" style="width:1.625rem;height:1.625rem;color:#ef4444"></i>
    </div>
    <!-- Title -->
    <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary);margin-bottom:0.4rem">
      Supprimer la suggestion ?
    </h3>
    <p id="deleteConfirmMsg" style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.6"></p>
    <!-- Buttons -->
    <div style="display:flex;gap:0.75rem;justify-content:center">
      <button onclick="closeDeleteConfirm()"
              style="padding:0.6rem 1.5rem;background:var(--muted);color:var(--text-secondary);border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.82rem;font-weight:600;cursor:pointer;transition:all 0.2s"
              onmouseover="this.style.background='var(--border)'"
              onmouseout="this.style.background='var(--muted)'">
        Annuler
      </button>
      <a id="deleteConfirmLink" href="#"
         style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.6rem 1.5rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border-radius:var(--radius-full);font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.2s"
         onmouseover="this.style.boxShadow='0 4px 16px rgba(239,68,68,0.35)'"
         onmouseout="this.style.boxShadow='none'">
        <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i> Oui, supprimer
      </a>
    </div>
  </div>
</div>

<script>
function openDeleteConfirm(url, nom) {
  document.getElementById('deleteConfirmLink').href = url;
  document.getElementById('deleteConfirmMsg').textContent =
    'Vous êtes sur le point de supprimer "' + nom + '". Cette action est irréversible.';
  const modal = document.getElementById('deleteConfirmModal');
  modal.style.display = 'flex';
  if (typeof lucide !== 'undefined') lucide.createIcons();
}
function closeDeleteConfirm() {
  document.getElementById('deleteConfirmModal').style.display = 'none';
}
// Click backdrop to close
document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteConfirm();
});
// ESC key to close
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeDeleteConfirm();
});
</script>
