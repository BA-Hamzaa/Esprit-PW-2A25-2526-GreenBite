<!-- Vue BackOffice : Liste des ingrédients -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:var(--radius-xl)">
        <i data-lucide="carrot" style="width:1.5rem;height:1.5rem;color:#ea580c"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Ingrédients</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= count($ingredients) ?> ingrédients référencés</p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=add-ingredient" class="btn btn-primary"><i data-lucide="plus" style="width:1rem;height:1rem"></i> Ajouter un ingrédient</a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div style="overflow-x:auto">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Nom</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Unité</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Cal/unité</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Local</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:130px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($ingredients)): ?>
            <tr>
              <td colspan="5" style="text-align:center;padding:4rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:50%;margin-bottom:1.25rem">
                  <i data-lucide="carrot" style="width:2.25rem;height:2.25rem;color:#ea580c"></i>
                </div>
                <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:#ea580c;margin-bottom:0.5rem">Aucun ingrédient</h3>
                <p style="color:var(--text-muted);font-size:0.82rem">Ajoutez vos premiers ingrédients.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($ingredients as $i): ?>
              <tr style="border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(82,183,136,0.03)'" onmouseout="this.style.background=''">
                <td style="padding:0.75rem 0.875rem">
                  <div style="display:flex;align-items:center;gap:0.625rem">
                    <div style="width:2rem;height:2rem;border-radius:0.5rem;background:linear-gradient(135deg,rgba(234,88,12,0.1),rgba(249,115,22,0.06));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                      <i data-lucide="carrot" style="width:0.75rem;height:0.75rem;color:#ea580c"></i>
                    </div>
                    <div>
                      <div style="font-weight:700;font-size:0.875rem;color:var(--text-primary)"><?= htmlspecialchars($i['nom']) ?></div>
                      <div style="font-size:0.65rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.05em">#<?= $i['id'] ?></div>
                    </div>
                  </div>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center;font-size:0.82rem;color:var(--text-secondary)"><?= htmlspecialchars($i['unite']) ?></td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <span style="font-family:var(--font-heading);font-weight:700;font-size:0.9rem;color:var(--accent-orange)"><?= $i['calories_par_unite'] ?></span>
                  <span style="font-size:0.65rem;color:var(--text-muted);display:block">kcal</span>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <?php if ($i['is_local']): ?>
                    <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:rgba(34,197,94,0.1);color:#16a34a;font-size:0.72rem;font-weight:700">
                      <i data-lucide="map-pin" style="width:0.65rem;height:0.65rem"></i>Local
                    </span>
                  <?php else: ?>
                    <span style="display:inline-flex;align-items:center;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:var(--muted);color:var(--text-muted);font-size:0.72rem;font-weight:700">Importé</span>
                  <?php endif; ?>
                </td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <div style="display:inline-flex;gap:0.4rem;justify-content:center;align-items:center">
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=edit-ingredient&id=<?= $i['id'] ?>"
                       style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:rgba(59,130,246,0.1);color:#3b82f6;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;border:1px solid rgba(59,130,246,0.2)"
                       onmouseover="this.style.background='rgba(59,130,246,0.18)';this.style.transform='translateY(-1px)'"
                       onmouseout="this.style.background='rgba(59,130,246,0.1)';this.style.transform='none'">
                      <i data-lucide="edit" style="width:0.75rem;height:0.75rem"></i> Modifier
                    </a>
                    <a href="<?= BASE_URL ?>/?page=admin-recettes&action=delete-ingredient&id=<?= $i['id'] ?>"
                       style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);transition:all 0.2s;text-decoration:none"
                       onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                       onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                       title="Supprimer" data-confirm="Supprimer cet ingrédient ?" data-confirm-title="Supprimer" data-confirm-type="danger" data-confirm-btn="Supprimer">
                      <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                    </a>
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

