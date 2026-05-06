<!-- BackOffice : Gestion des Matériels de cuisine -->
<div class="admin-content" style="padding:2rem;max-width:72rem">
  <div class="flex items-center gap-3 mb-6">
    <div style="width:3rem;height:3rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#fef9c3,#fefce8);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(217,119,6,0.18)">
      <i data-lucide="wrench" style="width:1.5rem;height:1.5rem;color:#d97706"></i>
    </div>
    <div>
      <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);display:flex;align-items:center;gap:.5rem">
        <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,#d97706,#f59e0b);border-radius:2px"></span>
        Matériels de Cuisine
      </h1>
      <p class="text-sm" style="color:var(--text-muted)">Gérez les équipements • approuvez ou refusez les propositions clients</p>
    </div>
  </div>

  <!-- Add new materiel form -->
  <div class="card mb-6" style="padding:1.5rem;border-left:4px solid #d97706">
    <div class="flex items-center gap-2 mb-4">
      <i data-lucide="plus-circle" style="width:1.125rem;height:1.125rem;color:#d97706"></i>
      <h3 class="font-bold" style="color:var(--text-primary)">Ajouter un matériel</h3>
    </div>
    <form method="POST" action="<?= BASE_URL ?>/?page=admin-recettes&action=materiel-add" id="mat-add-form" class="flex gap-3 items-start flex-wrap">
      <div class="form-group mb-0" style="flex:1;min-width:180px">
        <label class="form-label text-xs">Nom <span style="color:var(--destructive)">*</span></label>
        <input type="text" name="nom" id="mat-add-nom" class="form-input" placeholder="Ex: Spatule en silicone">
      </div>
      <div class="form-group mb-0" style="flex:2;min-width:200px">
        <label class="form-label text-xs">Description <span style="color:var(--destructive)">*</span></label>
        <input type="text" name="description" id="mat-add-desc" class="form-input" placeholder="Brève description...">
      </div>
      <button type="submit" class="btn btn-primary" style="height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#d97706,#f59e0b);border:none;margin-top:1.35rem">
        <i data-lucide="plus" style="width:.875rem;height:.875rem"></i> Ajouter
      </button>
    </form>
  </div>

  <!-- Stats badges -->
  <?php
    $total = count($materiels);
    $accepted = count(array_filter($materiels, fn($m) => $m['statut']==='accepte'));
    $pending  = count(array_filter($materiels, fn($m) => $m['statut']==='en_attente'));
    $refused  = count(array_filter($materiels, fn($m) => $m['statut']==='refuse'));
  ?>
  <div class="flex gap-3 mb-5 flex-wrap">
    <div style="padding:.5rem 1rem;border-radius:var(--radius-xl);background:var(--muted);display:flex;align-items:center;gap:.5rem;font-size:.85rem">
      <i data-lucide="box" style="width:.85rem;height:.85rem;color:var(--text-muted)"></i> <strong><?= $total ?></strong> total
    </div>
    <div style="padding:.5rem 1rem;border-radius:var(--radius-xl);background:#dcfce7;display:flex;align-items:center;gap:.5rem;font-size:.85rem;color:#166534">
      <i data-lucide="check-circle" style="width:.85rem;height:.85rem"></i> <strong><?= $accepted ?></strong> acceptés
    </div>
    <?php if ($pending > 0): ?>
    <div style="padding:.5rem 1rem;border-radius:var(--radius-xl);background:#fef9c3;display:flex;align-items:center;gap:.5rem;font-size:.85rem;color:#92400e;animation:pulse 2s infinite">
      <i data-lucide="clock" style="width:.85rem;height:.85rem"></i> <strong><?= $pending ?></strong> en attente
    </div>
    <?php endif; ?>
    <?php if ($refused > 0): ?>
    <div style="padding:.5rem 1rem;border-radius:var(--radius-xl);background:#fee2e2;display:flex;align-items:center;gap:.5rem;font-size:.85rem;color:#991b1b">
      <i data-lucide="x-circle" style="width:.85rem;height:.85rem"></i> <strong><?= $refused ?></strong> refusés
    </div>
    <?php endif; ?>
  </div>

  <!-- Materiels table -->
  <div class="card" style="overflow:hidden;border-radius:var(--radius-xl)">
    <div class="table-responsive">
      <table class="admin-table" style="width:100%">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Proposé par</th>
            <th>Statut</th>
            <th>Date</th>
            <th style="width:180px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($materiels)): ?>
            <tr><td colspan="7" class="text-center" style="padding:3rem;color:var(--text-muted)">
              <i data-lucide="inbox" style="width:2rem;height:2rem;display:block;margin:0 auto .75rem;opacity:.4"></i>
              Aucun matériel enregistré.
            </td></tr>
          <?php else: ?>
            <?php foreach ($materiels as $mat): ?>
              <tr style="<?= $mat['statut']==='en_attente'?'background:rgba(251,191,36,0.06)':'' ?>">
                <td style="font-weight:600;color:var(--text-muted)"><?= $mat['id'] ?></td>
                <td><strong style="color:var(--text-primary)"><?= htmlspecialchars($mat['nom']) ?></strong></td>
                <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.85rem;color:var(--text-muted)"><?= htmlspecialchars($mat['description'] ?? '—') ?></td>
                <td>
                  <?php if ($mat['propose_par']): ?>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;background:#ede9fe;color:#6d28d9;font-size:.75rem;font-weight:600">
                      <i data-lucide="user" style="width:.6rem;height:.6rem"></i> <?= htmlspecialchars($mat['propose_par']) ?>
                    </span>
                  <?php else: ?>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;background:var(--muted);color:var(--text-muted);font-size:.75rem">
                      <i data-lucide="shield" style="width:.6rem;height:.6rem"></i> Admin
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                    $colors = ['accepte'=>['#dcfce7','#166534'],'en_attente'=>['#fef9c3','#92400e'],'refuse'=>['#fee2e2','#991b1b']];
                    $icons  = ['accepte'=>'check-circle','en_attente'=>'clock','refuse'=>'x-circle'];
                    $labels = ['accepte'=>'Accepté','en_attente'=>'En attente','refuse'=>'Refusé'];
                    $c = $colors[$mat['statut']] ?? ['#f3f4f6','#374151'];
                    $ic = $icons[$mat['statut']] ?? 'help-circle';
                    $l = $labels[$mat['statut']] ?? $mat['statut'];
                  ?>
                  <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;background:<?= $c[0] ?>;color:<?= $c[1] ?>;font-size:.75rem;font-weight:600">
                    <i data-lucide="<?= $ic ?>" style="width:.6rem;height:.6rem"></i> <?= $l ?>
                  </span>
                  <?php if ($mat['statut']==='refuse' && !empty($mat['motif_refus'])): ?>
                    <div style="font-size:.7rem;color:#991b1b;margin-top:3px;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="<?= htmlspecialchars($mat['motif_refus']) ?>">
                      <i data-lucide="message-square" style="width:.55rem;height:.55rem;display:inline"></i> <?= htmlspecialchars($mat['motif_refus']) ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td style="font-size:.8rem;color:var(--text-muted)"><?= date('d/m/Y', strtotime($mat['created_at'])) ?></td>
                <td>
                  <div style="display:flex;gap:.35rem;flex-wrap:wrap">
                    <?php if ($mat['statut'] !== 'accepte'): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=materiel-accept&id=<?= $mat['id'] ?>" class="btn btn-sm" style="background:#dcfce7;color:#166534;border:none;border-radius:var(--radius-xl);font-size:.75rem;padding:.35rem .65rem;font-weight:600" title="Approuver">
                        <i data-lucide="check" style="width:.7rem;height:.7rem"></i> Approuver
                      </a>
                    <?php endif; ?>
                    <?php if ($mat['statut'] !== 'refuse'): ?>
                      <button type="button" class="btn btn-sm btn-refuse-materiel" data-id="<?= $mat['id'] ?>" data-nom="<?= htmlspecialchars($mat['nom']) ?>" style="background:#fef9c3;color:#92400e;border:none;border-radius:var(--radius-xl);font-size:.75rem;padding:.35rem .65rem;font-weight:600" title="Refuser">
                        <i data-lucide="x" style="width:.7rem;height:.7rem"></i> Refuser
                      </button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-sm btn-delete-materiel" data-id="<?= $mat['id'] ?>" data-nom="<?= htmlspecialchars($mat['nom']) ?>" style="background:#fee2e2;color:#991b1b;border:none;border-radius:var(--radius-xl);font-size:.75rem;padding:.35rem .65rem" title="Supprimer">
                      <i data-lucide="trash-2" style="width:.7rem;height:.7rem"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Refuse Modal with reason -->
<div id="refuse-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);align-items:center;justify-content:center">
  <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:2rem;width:95%;max-width:480px;box-shadow:0 25px 60px rgba(0,0,0,.3);border:1px solid var(--border)">
    <div class="flex items-center gap-3 mb-5">
      <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#fee2e2,#fef2f2);display:flex;align-items:center;justify-content:center">
        <i data-lucide="x-circle" style="width:1.25rem;height:1.25rem;color:#dc2626"></i>
      </div>
      <div>
        <h3 class="text-lg font-bold" style="color:var(--text-primary)">Refuser le matériel</h3>
        <p id="refuse-mat-name" class="text-sm" style="color:var(--text-muted)"></p>
      </div>
    </div>
    <form method="POST" id="refuse-form" action="">
      <input type="hidden" name="id" id="refuse-mat-id">
      <div class="form-group">
        <label class="form-label">Motif du refus <span style="color:var(--destructive)">*</span></label>
        <textarea name="motif_refus" id="refuse-motif" class="form-textarea" rows="3" placeholder="Expliquez pourquoi ce matériel est refusé..."></textarea>
      </div>
      <div class="flex gap-3 mt-4">
        <button type="submit" class="btn flex-1" style="background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border:none;border-radius:var(--radius-xl)">
          <i data-lucide="x" style="width:.875rem;height:.875rem"></i> Confirmer le refus
        </button>
        <button type="button" id="refuse-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);align-items:center;justify-content:center">
  <div style="background:var(--card-bg,#fff);border-radius:var(--radius-xl);padding:2rem;width:95%;max-width:420px;box-shadow:0 25px 60px rgba(0,0,0,.3);border:1px solid var(--border)">
    <div class="flex items-center gap-3 mb-5">
      <div style="width:2.5rem;height:2.5rem;border-radius:var(--radius-xl);background:linear-gradient(135deg,#fee2e2,#fef2f2);display:flex;align-items:center;justify-content:center">
        <i data-lucide="trash-2" style="width:1.25rem;height:1.25rem;color:#dc2626"></i>
      </div>
      <div>
        <h3 class="text-lg font-bold" style="color:var(--text-primary)">Supprimer le matériel</h3>
        <p id="delete-mat-name" class="text-sm" style="color:var(--text-muted)"></p>
      </div>
    </div>
    <p style="font-size:.9rem;color:var(--text-secondary);margin-bottom:1.5rem;padding:.75rem 1rem;background:#fef2f2;border-radius:var(--radius);border:1px solid #fecaca">
      <i data-lucide="alert-triangle" style="width:.875rem;height:.875rem;display:inline;vertical-align:middle;color:#dc2626"></i>
      Cette action est irréversible. Le matériel sera définitivement supprimé.
    </p>
    <div class="flex gap-3">
      <a href="#" id="delete-confirm-link" class="btn flex-1" style="background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border:none;border-radius:var(--radius-xl);text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem">
        <i data-lucide="trash-2" style="width:.875rem;height:.875rem"></i> Supprimer
      </a>
      <button type="button" id="delete-cancel" class="btn btn-outline-primary" style="border-radius:var(--radius-xl)">Annuler</button>
    </div>
  </div>
</div>

<script>
// ── Shared inline validation helper ──
const _EI = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
function _showFE(field, msg) {
  field.classList.add('is-invalid');
  let wrap = field.closest('.form-group') || field.parentElement;
  let el = wrap.querySelector('.field-error');
  if (!el) { el = document.createElement('div'); el.className = 'field-error'; wrap.appendChild(el); }
  el.innerHTML = _EI + ' ' + msg; el.classList.add('show');
}
function _clearFE(field) {
  field.classList.remove('is-invalid');
  const wrap = field.closest('.form-group') || field.parentElement;
  const el = wrap.querySelector('.field-error');
  if (el) el.classList.remove('show');
}

// ── Refuse modal ──
document.querySelectorAll('.btn-refuse-materiel').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const nom = btn.dataset.nom;
    document.getElementById('refuse-mat-id').value = id;
    document.getElementById('refuse-mat-name').textContent = '« ' + nom + ' »';
    document.getElementById('refuse-motif').value = '';
    // Clear previous errors
    const motifField = document.getElementById('refuse-motif');
    _clearFE(motifField);
    document.getElementById('refuse-form').action = '<?= BASE_URL ?>/?page=admin-recettes&action=materiel-refuse';
    document.getElementById('refuse-modal').style.display = 'flex';
  });
});
document.getElementById('refuse-cancel').addEventListener('click', () => {
  document.getElementById('refuse-modal').style.display = 'none';
});

// ── Refuse modal validation ──
document.getElementById('refuse-form').addEventListener('submit', function(e) {
  const motif = document.getElementById('refuse-motif');
  if (!motif.value.trim()) {
    _showFE(motif, 'Le motif du refus est obligatoire.');
    e.preventDefault();
  }
});
document.getElementById('refuse-motif').addEventListener('input', function() {
  if (this.value.trim()) _clearFE(this);
});

// ── Delete modal ──
document.querySelectorAll('.btn-delete-materiel').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    const nom = btn.dataset.nom;
    document.getElementById('delete-mat-name').textContent = '« ' + nom + ' »';
    document.getElementById('delete-confirm-link').href = '<?= BASE_URL ?>/?page=admin-recettes&action=materiel-delete&id=' + id;
    document.getElementById('delete-modal').style.display = 'flex';
    if (typeof lucide !== 'undefined') lucide.createIcons();
  });
});
document.getElementById('delete-cancel').addEventListener('click', () => {
  document.getElementById('delete-modal').style.display = 'none';
});

// ── Add-materiel form validation (nom + description) ──
const matAddForm = document.getElementById('mat-add-form');
const matNomInput = document.getElementById('mat-add-nom');
const matDescInput = document.getElementById('mat-add-desc');

// Blur validation
matNomInput?.addEventListener('blur', () => {
  if (!matNomInput.value.trim()) _showFE(matNomInput, 'Le nom est obligatoire.');
  else _clearFE(matNomInput);
});
matNomInput?.addEventListener('input', () => {
  if (matNomInput.value.trim()) _clearFE(matNomInput);
});

matDescInput?.addEventListener('blur', () => {
  if (!matDescInput.value.trim()) _showFE(matDescInput, 'La description est obligatoire.');
  else _clearFE(matDescInput);
});
matDescInput?.addEventListener('input', () => {
  if (matDescInput.value.trim()) _clearFE(matDescInput);
});

// Submit validation
matAddForm?.addEventListener('submit', function(e) {
  let valid = true;
  if (!matNomInput || !matNomInput.value.trim()) {
    _showFE(matNomInput, 'Le nom est obligatoire.');
    valid = false;
  } else { _clearFE(matNomInput); }
  
  if (!matDescInput || !matDescInput.value.trim()) {
    _showFE(matDescInput, 'La description est obligatoire.');
    valid = false;
  } else { _clearFE(matDescInput); }
  
  if (!valid) e.preventDefault();
});
</script>
