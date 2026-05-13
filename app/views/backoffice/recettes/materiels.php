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
  <div class="card" style="padding:0;overflow:hidden">
    <div style="overflow-x:auto">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Nom</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Description</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Proposé par</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Statut</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Date</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);width:180px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($materiels)): ?>
            <tr>
              <td colspan="6" style="text-align:center;padding:4rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:50%;margin-bottom:1.25rem">
                  <i data-lucide="inbox" style="width:2.25rem;height:2.25rem;color:#d97706"></i>
                </div>
                <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:#d97706;margin-bottom:0.5rem">Aucun matériel</h3>
                <p style="color:var(--text-muted);font-size:0.82rem">Aucun matériel enregistré.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($materiels as $mat): ?>
              <tr style="border-bottom:1px solid var(--border);transition:background 0.2s<?= $mat['statut']==='en_attente'?';background:rgba(251,191,36,0.03)':'' ?>"
                  onmouseover="this.style.background='<?= $mat['statut']==='en_attente' ? 'rgba(251,191,36,0.07)' : 'rgba(82,183,136,0.03)' ?>'"
                  onmouseout="this.style.background='<?= $mat['statut']==='en_attente' ? 'rgba(251,191,36,0.03)' : '' ?>'">
                <td style="padding:0.75rem 0.875rem">
                  <div style="font-weight:700;font-size:0.875rem;color:var(--text-primary)"><?= htmlspecialchars($mat['nom']) ?></div>
                  <div style="font-size:0.65rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">#<?= $mat['id'] ?></div>
                </td>
                <td style="padding:0.75rem 0.875rem;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.82rem;color:var(--text-muted)"><?= htmlspecialchars($mat['description'] ?? '—') ?></td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <?php if ($mat['propose_par']): ?>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;background:#ede9fe;color:#6d28d9;font-size:.72rem;font-weight:700">
                      <i data-lucide="user" style="width:.65rem;height:.65rem"></i><?= htmlspecialchars($mat['propose_par']) ?>
                    </span>
                  <?php else: ?>
                    <span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;background:var(--muted);color:var(--text-muted);font-size:.72rem;font-weight:700">
                      <i data-lucide="shield" style="width:.65rem;height:.65rem"></i>Admin
                    </span>
                  <?php endif; ?>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <?php
                    $statColors = ['accepte'=>['#22c55e','rgba(34,197,94,0.1)'],'en_attente'=>['#f59e0b','rgba(245,158,11,0.1)'],'refuse'=>['#ef4444','rgba(239,68,68,0.1)']];
                    $statIcons  = ['accepte'=>'check-circle','en_attente'=>'clock','refuse'=>'x-circle'];
                    $statLabels = ['accepte'=>'Accepté','en_attente'=>'En attente','refuse'=>'Refusé'];
                    $sc = $statColors[$mat['statut']] ?? ['#6b7280','rgba(107,114,128,0.1)'];
                    $si = $statIcons[$mat['statut']] ?? 'help-circle';
                    $sl = $statLabels[$mat['statut']] ?? $mat['statut'];
                  ?>
                  <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.3rem .7rem;border-radius:var(--radius-full);background:<?= $sc[1] ?>;color:<?= $sc[0] ?>;font-size:.72rem;font-weight:700">
                    <i data-lucide="<?= $si ?>" style="width:.65rem;height:.65rem"></i><?= $sl ?>
                  </span>
                  <?php if ($mat['statut']==='refuse' && !empty($mat['motif_refus'])): ?>
                    <div style="font-size:.7rem;color:#991b1b;margin-top:3px;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="<?= htmlspecialchars($mat['motif_refus']) ?>">
                      <i data-lucide="message-square" style="width:.55rem;height:.55rem;display:inline"></i><?= htmlspecialchars($mat['motif_refus']) ?>
                    </div>
                  <?php endif; ?>
                </td>
                <td style="padding:0.75rem 0.875rem;font-size:.8rem;color:var(--text-muted)"><?= date('d/m/Y', strtotime($mat['created_at'])) ?></td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <div style="display:inline-flex;gap:.4rem;flex-wrap:wrap;justify-content:center">
                    <?php if ($mat['statut'] !== 'accepte'): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-recettes&action=materiel-accept&id=<?= $mat['id'] ?>"
                         style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.3rem 0.7rem;background:rgba(34,197,94,0.1);color:#16a34a;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(34,197,94,0.2)"
                         onmouseover="this.style.background='rgba(34,197,94,0.2)';this.style.transform='translateY(-1px)'"
                         onmouseout="this.style.background='rgba(34,197,94,0.1)';this.style.transform='none'" title="Approuver">
                        <i data-lucide="check" style="width:.72rem;height:.72rem"></i> OK
                      </a>
                    <?php endif; ?>
                    <?php if ($mat['statut'] !== 'refuse'): ?>
                      <button type="button" class="btn-refuse-materiel" data-id="<?= $mat['id'] ?>" data-nom="<?= htmlspecialchars($mat['nom']) ?>"
                              style="display:inline-flex;align-items:center;justify-content:center;width:1.9rem;height:1.9rem;background:rgba(245,158,11,0.1);color:#d97706;border:1px solid rgba(245,158,11,0.2);border-radius:var(--radius-full);cursor:pointer;transition:all 0.2s"
                              onmouseover="this.style.background='rgba(245,158,11,0.2)';this.style.transform='translateY(-1px)'"
                              onmouseout="this.style.background='rgba(245,158,11,0.1)';this.style.transform='none'" title="Refuser">
                        <i data-lucide="x" style="width:.7rem;height:.7rem"></i>
                      </button>
                    <?php endif; ?>
                    <button type="button" class="btn-delete-materiel" data-id="<?= $mat['id'] ?>" data-nom="<?= htmlspecialchars($mat['nom']) ?>"
                            style="display:inline-flex;align-items:center;justify-content:center;width:1.9rem;height:1.9rem;background:rgba(239,68,68,0.08);color:#ef4444;border:1px solid rgba(239,68,68,0.2);border-radius:var(--radius-full);cursor:pointer;transition:all 0.2s"
                            onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'" title="Supprimer">
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
