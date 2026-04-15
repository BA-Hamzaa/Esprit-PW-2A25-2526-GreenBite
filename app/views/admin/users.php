<?php
// ---- Récupérer stats + liste ----
$users     = $ctrl->AfficherUsers()->fetchAll();
$total     = count($users);
$actifs    = count(array_filter($users, fn($u) => $u['is_active'] == 1));
$suspendus = $total - $actifs;
$admins    = count(array_filter($users, fn($u) => $u['role'] === 'ADMIN'));
$coachs    = count(array_filter($users, fn($u) => $u['role'] === 'COACH'));

// ---- Demandes COACH en attente ----
$pending = $ctrl->GetDemandesPending();
?>

<div style="padding:2rem">

  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
        <i data-lucide="users" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Utilisateurs</h1>
        <p class="text-sm" style="color:var(--text-muted)"><?= $total ?> utilisateurs inscrits</p>
      </div>
    </div>
    <button onclick="openAddModal()" class="btn btn-primary btn-round">
      <i data-lucide="user-plus" style="width:1rem;height:1rem"></i> Ajouter
    </button>
  </div>

  <!-- Flash Messages -->
  <?php if (!empty($_SESSION['success'])): ?>
    <div style="background:#dcfce7;color:#166534;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="check-circle-2" style="width:1rem;height:1rem"></i>
      <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div style="background:#fee2e2;color:#dc2626;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="alert-circle" style="width:1rem;height:1rem"></i>
      <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <!-- Stats -->
  <div class="grid grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
      <div class="stat-icon" style="background:linear-gradient(135deg,#dbeafe,#eff6ff)">
        <i data-lucide="users" style="width:1.25rem;height:1.25rem;color:#2563eb"></i>
      </div>
      <div class="stat-info"><span class="stat-value"><?= $total ?></span><span class="stat-label">Total utilisateurs</span></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4)">
        <i data-lucide="user-check" style="width:1.25rem;height:1.25rem;color:#16a34a"></i>
      </div>
      <div class="stat-info"><span class="stat-value"><?= $actifs ?></span><span class="stat-label">Actifs</span></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon" style="background:linear-gradient(135deg,#fee2e2,#fef2f2)">
        <i data-lucide="user-x" style="width:1.25rem;height:1.25rem;color:#ef4444"></i>
      </div>
      <div class="stat-info"><span class="stat-value"><?= $suspendus ?></span><span class="stat-label">Suspendus</span></div>
    </div>
<div class="stat-card">
  <div class="stat-icon" style="background:linear-gradient(135deg,#fed7aa,#fff7ed)">
    <i data-lucide="crown" style="width:1.25rem;height:1.25rem;color:#ea580c"></i>
  </div>
  <div class="stat-info"><span class="stat-value"><?= $admins ?></span><span class="stat-label">Admins</span></div>
</div>

<div class="stat-card">
  <div class="stat-icon" style="background:linear-gradient(135deg,#ede9fe,#f5f3ff)">
    <i data-lucide="award" style="width:1.25rem;height:1.25rem;color:#7c3aed"></i>
  </div>
  <div class="stat-info">
    <span class="stat-value"><?= $coachs ?></span>
    <span class="stat-label">Coachs</span>
  </div>
</div>

<?php if (!empty($pending)): ?>
<div class="stat-card" style="border:2px solid #fde68a;background:linear-gradient(135deg,#fffbeb,#fefce8)">
  <div class="stat-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a)">
    <i data-lucide="clock" style="width:1.25rem;height:1.25rem;color:#d97706"></i>
  </div>
  <div class="stat-info">
    <span class="stat-value" style="color:#d97706"><?= count($pending) ?></span>
    <span class="stat-label">En attente</span>
  </div>
</div>
<?php endif; ?>
  </div>



  <!-- demandes en attente -->










<?php if (!empty($pending)): ?>
<div class="card" style="padding:1.5rem;margin-bottom:1.5rem;border:2px solid #fde68a;background:linear-gradient(135deg,#fffbeb,#fefce8)">
  <h3 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:#92400e;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem">
    <i data-lucide="clock" style="width:1rem;height:1rem"></i>
    Demandes Coach en attente (<?= count($pending) ?>)
  </h3>
  <div style="display:flex;flex-direction:column;gap:0.75rem">
    <?php foreach ($pending as $p): ?>
    <div style="background:#fff;border-radius:0.75rem;padding:1rem;display:flex;align-items:center;justify-content:space-between;border:1px solid #fde68a">
      <div style="display:flex;align-items:center;gap:0.75rem">
        <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#6d28d9);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700">
          <?= strtoupper(substr($p['username'], 0, 1)) ?>
        </div>
        <div>
          <div style="font-weight:700;color:var(--text-primary);font-size:0.875rem"><?= htmlspecialchars($p['username']) ?></div>
          <div style="font-size:0.75rem;color:var(--text-muted)"><?= htmlspecialchars($p['email']) ?></div>
          <div style="font-size:0.72rem;color:#d97706;margin-top:2px">
            Demande le <?= date('d/m/Y', strtotime($p['coach_request_date'])) ?>
          </div>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:0.75rem">
        <?php if ($p['certificate']): ?>
          <a href="<?= BASE_URL ?>/assets/images/certificates/<?= htmlspecialchars($p['certificate']) ?>"
             target="_blank"
             style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:#2563eb;font-weight:600;text-decoration:none;padding:0.4rem 0.75rem;border:1px solid #bfdbfe;border-radius:0.5rem;background:#eff6ff">
            <i data-lucide="file-text" style="width:0.875rem;height:0.875rem"></i> Voir certificat
          </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/?page=coach-decision&id=<?= $p['id'] ?>&decision=accepted"
           style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:#fff;font-weight:600;text-decoration:none;padding:0.4rem 0.75rem;border-radius:0.5rem;background:#16a34a">
          <i data-lucide="check" style="width:0.875rem;height:0.875rem"></i> Accepter
        </a>
        <a href="<?= BASE_URL ?>/?page=coach-decision&id=<?= $p['id'] ?>&decision=refused"
           style="display:flex;align-items:center;gap:0.35rem;font-size:0.78rem;color:#fff;font-weight:600;text-decoration:none;padding:0.4rem 0.75rem;border-radius:0.5rem;background:#dc2626">
          <i data-lucide="x" style="width:0.875rem;height:0.875rem"></i> Refuser
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>














  

  <!-- Table -->
  <div class="card" style="padding:0;overflow:hidden">
    <div class="flex items-center justify-between" style="padding:1.25rem">
      <h3 class="font-semibold flex items-center gap-2" style="color:var(--text-primary)">
        <i data-lucide="list" style="width:1rem;height:1rem;color:var(--primary)"></i> Liste des utilisateurs
      </h3>
      <div style="display:flex;align-items:center;gap:0.5rem;position:relative">
        <i data-lucide="search" style="width:0.875rem;height:0.875rem;color:var(--text-muted);position:absolute;left:0.75rem"></i>
        <input type="text" id="searchInput" oninput="filterTable()" placeholder="Rechercher..."
               style="padding:0.5rem 0.75rem 0.5rem 2.25rem;width:14rem;font-size:0.8rem;border-radius:var(--radius-full);border:1px solid var(--border);background:var(--surface);color:var(--foreground)">
      </div>
    </div>

    <table class="table" id="usersTable">
      <thead>
        <tr>
          <th></th>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Statut</th>
          <th>Inscrit le</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <!-- Avatar -->
          <td>
            <?php if ($u['avatar']): ?>
              <img src="<?= BASE_URL ?>/assets/images/avatars/<?= htmlspecialchars($u['avatar']) ?>"
                   style="width:2.25rem;height:2.25rem;border-radius:50%;object-fit:cover;border:2px solid var(--border)">
            <?php else: ?>
              <div style="width:2.25rem;height:2.25rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem">
                <?= strtoupper(substr($u['username'], 0, 1)) ?>
              </div>
            <?php endif; ?>
          </td>
          <!-- Username -->
          <td class="font-semibold" style="color:var(--text-primary)"><?= htmlspecialchars($u['username']) ?></td>
          <!-- Email -->
          <td style="color:var(--text-secondary)"><?= htmlspecialchars($u['email']) ?></td>
          <!-- Role -->
<td>
  <?php if ($u['role'] === 'ADMIN'): ?>
    <span style="background:#fef3c7;color:#92400e;padding:0.2rem 0.65rem;border-radius:999px;font-size:0.72rem;font-weight:700;display:inline-flex;align-items:center;gap:0.25rem">
      <i data-lucide="shield-check" style="width:0.7rem;height:0.7rem"></i> ADMIN
    </span>
  <?php elseif ($u['role'] === 'COACH'): ?>
    <span style="background:#ede9fe;color:#6d28d9;padding:0.2rem 0.65rem;border-radius:999px;font-size:0.72rem;font-weight:700;display:inline-flex;align-items:center;gap:0.25rem">
      <i data-lucide="award" style="width:0.7rem;height:0.7rem"></i> COACH
    </span>
  <?php else: ?>
    <span style="background:#dbeafe;color:#1e40af;padding:0.2rem 0.65rem;border-radius:999px;font-size:0.72rem;font-weight:700;display:inline-flex;align-items:center;gap:0.25rem">
      <i data-lucide="user" style="width:0.7rem;height:0.7rem"></i> USER
    </span>
  <?php endif; ?>
</td>
          <!-- Statut -->
          <td>
            <?php if ($u['is_active'] == 1): ?>
              <span style="background:#dcfce7;color:#166534;padding:0.2rem 0.65rem;border-radius:999px;font-size:0.72rem;font-weight:700">● Actif</span>
            <?php else: ?>
              <span style="background:#fee2e2;color:#dc2626;padding:0.2rem 0.65rem;border-radius:999px;font-size:0.72rem;font-weight:700">● Suspendu</span>
            <?php endif; ?>
          </td>
          <!-- Date -->
          <td style="color:var(--text-muted);font-size:0.8rem"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
          <!-- Actions -->
          <td>
            <div class="flex gap-2">
              <!-- Modifier -->
              <button onclick='openEditModal(<?= json_encode($u) ?>)'
                      style="width:2rem;height:2rem;border-radius:var(--radius-lg);background:#dbeafe;color:#1d4ed8;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s"
                      onmouseover="this.style.background='#1d4ed8';this.style.color='#fff'"
                      onmouseout="this.style.background='#dbeafe';this.style.color='#1d4ed8'"
                      title="Modifier">
                <i data-lucide="pencil" style="width:0.875rem;height:0.875rem"></i>
              </button>
              <!-- Bloquer / Débloquer -->
              <?php if ($u['is_active'] == 1): ?>
                <button onclick="openToggleModal(<?= $u['id'] ?>, 0, '<?= htmlspecialchars($u['username']) ?>')"
                        style="width:2rem;height:2rem;border-radius:var(--radius-lg);background:#fef3c7;color:#d97706;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s"
                        onmouseover="this.style.background='#d97706';this.style.color='#fff'"
                        onmouseout="this.style.background='#fef3c7';this.style.color='#d97706'"
                        title="Bloquer">
                  <i data-lucide="ban" style="width:0.875rem;height:0.875rem"></i>
                </button>
              <?php else: ?>
                <button onclick="openToggleModal(<?= $u['id'] ?>, 1, '<?= htmlspecialchars($u['username']) ?>')"
                        style="width:2rem;height:2rem;border-radius:var(--radius-lg);background:#dcfce7;color:#16a34a;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s"
                        onmouseover="this.style.background='#16a34a';this.style.color='#fff'"
                        onmouseout="this.style.background='#dcfce7';this.style.color='#16a34a'"
                        title="Débloquer">
                  <i data-lucide="check-circle" style="width:0.875rem;height:0.875rem"></i>
                </button>
              <?php endif; ?>
              <!-- Supprimer -->
              <button onclick="openUserDeleteModal(event, <?= $u['id'] ?>, '<?= htmlspecialchars($u['username']) ?>')"
                      style="width:2rem;height:2rem;border-radius:var(--radius-lg);background:#fee2e2;color:#dc2626;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s"
                      onmouseover="this.style.background='#dc2626';this.style.color='#fff'"
                      onmouseout="this.style.background='#fee2e2';this.style.color='#dc2626'"
                      title="Supprimer">
                <i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i>
              </button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($users)): ?>
          <tr>
            <td colspan="7" style="padding:3rem;text-align:center;color:var(--text-muted)">
              <i data-lucide="users" style="width:2rem;height:2rem;margin:0 auto 0.5rem;display:block;opacity:0.3"></i>
              Aucun utilisateur trouvé
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>


<!-- ==================== MODAL AJOUTER ==================== -->
<div id="modalAdd" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center">
  <div style="background:var(--background);border-radius:1rem;padding:2rem;width:100%;max-width:28rem;box-shadow:0 25px 50px rgba(0,0,0,0.15);position:relative">
    <button onclick="closeModal('modalAdd')" style="position:absolute;top:1rem;right:1rem;background:none;border:none;cursor:pointer;color:var(--text-muted)">
      <i data-lucide="x" style="width:1.25rem;height:1.25rem"></i>
    </button>
    <h3 style="font-family:var(--font-heading);font-size:1.25rem;font-weight:700;color:var(--text-primary);margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="user-plus" style="width:1.25rem;height:1.25rem;color:var(--primary)"></i> Ajouter un utilisateur
    </h3>
    <form method="POST" action="<?= BASE_URL ?>/?page=admin-users" enctype="multipart/form-data" id="formAdd" novalidate style="display:flex;flex-direction:column;gap:1rem">
      <input type="hidden" name="action" value="add">
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Nom d'utilisateur</label>
        <input type="text" name="username" id="add-username" class="form-input" placeholder="john_doe" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-add-username" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Email</label>
        <input type="email" name="email" id="add-email" class="form-input" placeholder="exemple@email.com" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-add-email" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Mot de passe</label>
        <input type="password" name="password" id="add-password" class="form-input" placeholder="Min. 8 caractères" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-add-password" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Rôle</label>
        <select name="role" class="form-input" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
          <option value="USER">USER</option>
          <option value="ADMIN">ADMIN</option>
        </select>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Avatar <span style="color:var(--text-muted);font-weight:400">(optionnel)</span></label>
        <input type="file" name="avatar" id="add-avatar" accept="image/*" class="form-input" style="width:100%;padding:0.6rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-add-avatar" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div style="display:flex;gap:0.75rem;margin-top:0.5rem">
        <button type="button" onclick="closeModal('modalAdd')" class="btn btn-outline" style="flex:1;border-radius:var(--radius-xl)">Annuler</button>
        <button type="submit" class="btn btn-primary" style="flex:1;border-radius:var(--radius-xl)">
          <i data-lucide="user-plus" style="width:1rem;height:1rem"></i> Ajouter
        </button>
      </div>
    </form>
  </div>
</div>


<!-- ==================== MODAL MODIFIER ==================== -->
<div id="modalEdit" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center">
  <div style="background:var(--background);border-radius:1rem;padding:2rem;width:100%;max-width:28rem;box-shadow:0 25px 50px rgba(0,0,0,0.15);position:relative">
    <button onclick="closeModal('modalEdit')" style="position:absolute;top:1rem;right:1rem;background:none;border:none;cursor:pointer;color:var(--text-muted)">
      <i data-lucide="x" style="width:1.25rem;height:1.25rem"></i>
    </button>
    <h3 style="font-family:var(--font-heading);font-size:1.25rem;font-weight:700;color:var(--text-primary);margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem">
      <i data-lucide="pencil" style="width:1.25rem;height:1.25rem;color:#1d4ed8"></i> Modifier l'utilisateur
    </h3>
    <form method="POST" action="<?= BASE_URL ?>/?page=admin-users" enctype="multipart/form-data" id="formEdit" novalidate style="display:flex;flex-direction:column;gap:1rem">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id" id="edit-id">
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Nom d'utilisateur</label>
        <input type="text" name="username" id="edit-username" class="form-input" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-edit-username" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Email</label>
        <input type="email" name="email" id="edit-email" class="form-input" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-edit-email" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Rôle</label>
        <select name="role" id="edit-role" class="form-input" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
          <option value="USER">USER</option>
          <option value="ADMIN">ADMIN</option>
        </select>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Statut</label>
        <select name="is_active" id="edit-status" class="form-input" style="width:100%;padding:0.75rem 1rem;border-radius:var(--radius-xl)">
          <option value="1">Actif</option>
          <option value="0">Suspendu</option>
        </select>
      </div>
      <div>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.4rem">Nouvel avatar <span style="color:var(--text-muted);font-weight:400">(optionnel)</span></label>
        <input type="file" name="avatar" id="edit-avatar" accept="image/*" class="form-input" style="width:100%;padding:0.6rem 1rem;border-radius:var(--radius-xl)">
        <span id="err-edit-avatar" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>
      <div style="display:flex;gap:0.75rem;margin-top:0.5rem">
        <button type="button" onclick="closeModal('modalEdit')" class="btn btn-outline" style="flex:1;border-radius:var(--radius-xl)">Annuler</button>
        <button type="submit" class="btn btn-primary" style="flex:1;border-radius:var(--radius-xl);background:#1d4ed8">
          <i data-lucide="save" style="width:1rem;height:1rem"></i> Enregistrer
        </button>
      </div>
    </form>
  </div>
</div>


<!-- ==================== MODAL SUPPRIMER ==================== -->
<div id="modalDelete" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center">
  <div style="background:var(--background);border-radius:1rem;padding:2rem;width:100%;max-width:24rem;box-shadow:0 25px 50px rgba(0,0,0,0.15);text-align:center">
    <div style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;background:#fee2e2;border-radius:50%;margin-bottom:1rem">
      <i data-lucide="trash-2" style="width:2rem;height:2rem;color:#dc2626"></i>
    </div>
    <h3 style="font-family:var(--font-heading);font-size:1.125rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem">Supprimer l'utilisateur</h3>
    <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:1.5rem">
      Vous allez supprimer <strong id="delete-username" style="color:var(--text-primary)"></strong>. Cette action est irréversible.
    </p>
    <div style="display:flex;gap:0.75rem">
      <button onclick="closeModal('modalDelete')" class="btn btn-outline" style="flex:1;border-radius:var(--radius-xl)">Annuler</button>
      <a id="delete-link" href="#" class="btn" style="flex:1;border-radius:var(--radius-xl);background:#dc2626;color:#fff;display:flex;align-items:center;justify-content:center;gap:0.5rem;text-decoration:none">
        <i data-lucide="trash-2" style="width:1rem;height:1rem"></i> Supprimer
      </a>
    </div>
  </div>
</div>


<!-- ==================== MODAL BLOQUER ==================== -->
<div id="modalToggle" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center">
  <div style="background:var(--background);border-radius:1rem;padding:2rem;width:100%;max-width:24rem;box-shadow:0 25px 50px rgba(0,0,0,0.15);text-align:center">
    <div id="toggle-icon-wrap" style="display:inline-flex;align-items:center;justify-content:center;width:4rem;height:4rem;border-radius:50%;margin-bottom:1rem"></div>
    <h3 id="toggle-title" style="font-family:var(--font-heading);font-size:1.125rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem"></h3>
    <p id="toggle-msg" style="color:var(--text-muted);font-size:0.875rem;margin-bottom:1.5rem"></p>
    <div style="display:flex;gap:0.75rem">
      <button onclick="closeModal('modalToggle')" class="btn btn-outline" style="flex:1;border-radius:var(--radius-xl)">Annuler</button>
      <a id="toggle-link" href="#" class="btn" style="flex:1;border-radius:var(--radius-xl);color:#fff;display:flex;align-items:center;justify-content:center;gap:0.5rem;text-decoration:none">Confirmer</a>
    </div>
  </div>
</div>


<script>
  if (typeof lucide !== 'undefined') lucide.createIcons();

  // ==================== HELPERS ====================
  function showFieldErr(id, msg) {
    const el = document.getElementById(id);
    if (el) { el.textContent = msg; el.style.display = 'block'; }
  }
  function clearFieldErr(id) {
    const el = document.getElementById(id);
    if (el) { el.textContent = ''; el.style.display = 'none'; }
  }
  function setBorder(inputId, hasError) {
    const el = document.getElementById(inputId);
    if (el) el.style.borderColor = hasError ? '#dc2626' : 'var(--border)';
  }

  // ==================== VALIDATION AJOUTER ====================
  document.getElementById('formAdd').addEventListener('submit', function(e) {
    let valid = true;
    ['add-username','add-email','add-password'].forEach(id => {
      clearFieldErr('err-' + id); setBorder(id, false);
    });

    const username = document.getElementById('add-username').value.trim();
    const email    = document.getElementById('add-email').value.trim();
    const password = document.getElementById('add-password').value;
    const avatar   = document.getElementById('add-avatar').files[0];

    if (!username) {
      showFieldErr('err-add-username', "Le nom d'utilisateur est obligatoire.");
      setBorder('add-username', true); valid = false;
    } else if (username.length < 3) {
      showFieldErr('err-add-username', "Minimum 3 caractères.");
      setBorder('add-username', true); valid = false;
    }
    if (!email) {
      showFieldErr('err-add-email', "L'email est obligatoire.");
      setBorder('add-email', true); valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showFieldErr('err-add-email', "Adresse email invalide.");
      setBorder('add-email', true); valid = false;
    }
    if (!password) {
      showFieldErr('err-add-password', "Le mot de passe est obligatoire.");
      setBorder('add-password', true); valid = false;
    } else if (password.length < 8) {
      showFieldErr('err-add-password', "Minimum 8 caractères.");
      setBorder('add-password', true); valid = false;
    }
    if (avatar) {
      const allowed = ['image/jpeg','image/png','image/webp','image/gif'];
      if (!allowed.includes(avatar.type)) {
        showFieldErr('err-add-avatar', "Format non supporté."); valid = false;
      } else if (avatar.size > 2 * 1024 * 1024) {
        showFieldErr('err-add-avatar', "Image trop lourde (max 2MB)."); valid = false;
      }
    }
    if (!valid) e.preventDefault();
  });

  // Live AJOUTER
  document.getElementById('add-username').addEventListener('input', function() {
    const v = this.value.trim();
    if (!v) { showFieldErr('err-add-username',"Obligatoire."); setBorder('add-username',true); }
    else if (v.length<3) { showFieldErr('err-add-username',"Minimum 3 caractères."); setBorder('add-username',true); }
    else { clearFieldErr('err-add-username'); setBorder('add-username',false); }
  });
  document.getElementById('add-email').addEventListener('input', function() {
    const v = this.value.trim();
    if (!v) { showFieldErr('err-add-email',"Obligatoire."); setBorder('add-email',true); }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { showFieldErr('err-add-email',"Email invalide."); setBorder('add-email',true); }
    else { clearFieldErr('err-add-email'); setBorder('add-email',false); }
  });
  document.getElementById('add-password').addEventListener('input', function() {
    const v = this.value;
    if (!v) { showFieldErr('err-add-password',"Obligatoire."); setBorder('add-password',true); }
    else if (v.length<8) { showFieldErr('err-add-password',"Minimum 8 caractères."); setBorder('add-password',true); }
    else { clearFieldErr('err-add-password'); setBorder('add-password',false); }
  });

  // ==================== VALIDATION MODIFIER ====================
  document.getElementById('formEdit').addEventListener('submit', function(e) {
    let valid = true;
    ['edit-username','edit-email'].forEach(id => {
      clearFieldErr('err-' + id); setBorder(id, false);
    });

    const username = document.getElementById('edit-username').value.trim();
    const email    = document.getElementById('edit-email').value.trim();
    const avatar   = document.getElementById('edit-avatar').files[0];

    if (!username) {
      showFieldErr('err-edit-username',"Le nom d'utilisateur est obligatoire.");
      setBorder('edit-username',true); valid = false;
    } else if (username.length < 3) {
      showFieldErr('err-edit-username',"Minimum 3 caractères.");
      setBorder('edit-username',true); valid = false;
    }
    if (!email) {
      showFieldErr('err-edit-email',"L'email est obligatoire.");
      setBorder('edit-email',true); valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showFieldErr('err-edit-email',"Adresse email invalide.");
      setBorder('edit-email',true); valid = false;
    }
    if (avatar) {
      const allowed = ['image/jpeg','image/png','image/webp','image/gif'];
      if (!allowed.includes(avatar.type)) {
        showFieldErr('err-edit-avatar',"Format non supporté."); valid = false;
      } else if (avatar.size > 2 * 1024 * 1024) {
        showFieldErr('err-edit-avatar',"Image trop lourde (max 2MB)."); valid = false;
      }
    }
    if (!valid) e.preventDefault();
  });

  // Live MODIFIER
  document.getElementById('edit-username').addEventListener('input', function() {
    const v = this.value.trim();
    if (!v) { showFieldErr('err-edit-username',"Obligatoire."); setBorder('edit-username',true); }
    else if (v.length<3) { showFieldErr('err-edit-username',"Minimum 3 caractères."); setBorder('edit-username',true); }
    else { clearFieldErr('err-edit-username'); setBorder('edit-username',false); }
  });
  document.getElementById('edit-email').addEventListener('input', function() {
    const v = this.value.trim();
    if (!v) { showFieldErr('err-edit-email',"Obligatoire."); setBorder('edit-email',true); }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { showFieldErr('err-edit-email',"Email invalide."); setBorder('edit-email',true); }
    else { clearFieldErr('err-edit-email'); setBorder('edit-email',false); }
  });

  // ==================== RECHERCHE ====================
  function filterTable() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');
    rows.forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  }

  // ==================== MODALS ====================
  function openModal(id) {
    const m = document.getElementById(id);
    m.style.display = 'flex';
    setTimeout(() => m.querySelector('div').style.transform = 'scale(1)', 10);
  }
  function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.querySelectorAll('[id^="err-add-"],[id^="err-edit-"]').forEach(el => {
      el.textContent = ''; el.style.display = 'none';
    });
    ['add-username','add-email','add-password','edit-username','edit-email'].forEach(id => {
      setBorder(id, false);
    });
  }
  ['modalAdd','modalEdit','modalDelete','modalToggle'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
      if (e.target === this) closeModal(id);
    });
  });

  // ==================== MODAL AJOUTER ====================
  function openAddModal() {
    document.getElementById('formAdd').reset();
    openModal('modalAdd');
    lucide.createIcons();
  }

  // ==================== MODAL MODIFIER ====================
  function openEditModal(user) {
    document.getElementById('edit-id').value       = user.id;
    document.getElementById('edit-username').value = user.username;
    document.getElementById('edit-email').value    = user.email;
    document.getElementById('edit-role').value     = user.role;
    document.getElementById('edit-status').value   = user.is_active;
    openModal('modalEdit');
    lucide.createIcons();
  }

  // ==================== MODAL SUPPRIMER ====================
  function openUserDeleteModal(event, id, username) {
    event.stopPropagation();
    event.preventDefault();
    document.getElementById('delete-username').textContent = username;
    document.getElementById('delete-link').href =
      '<?= BASE_URL ?>/?page=admin-users&action=delete&id=' + id;
    openModal('modalDelete');
    lucide.createIcons();
  }

  // ==================== MODAL BLOQUER / DÉBLOQUER ====================
  function openToggleModal(id, status, username) {
    const isBan    = status === 0;
    const iconWrap = document.getElementById('toggle-icon-wrap');
    iconWrap.style.background = isBan ? '#fef3c7' : '#dcfce7';
    iconWrap.innerHTML = isBan
      ? '<i data-lucide="ban" style="width:2rem;height:2rem;color:#d97706"></i>'
      : '<i data-lucide="check-circle" style="width:2rem;height:2rem;color:#16a34a"></i>';
    document.getElementById('toggle-title').textContent = isBan ? 'Bloquer ' + username : 'Débloquer ' + username;
    document.getElementById('toggle-msg').textContent   = isBan
      ? username + ' ne pourra plus se connecter.'
      : username + ' pourra à nouveau se connecter.';
    const link = document.getElementById('toggle-link');
    link.href             = '<?= BASE_URL ?>/?page=admin-users&action=toggle&id=' + id + '&status=' + status;
    link.style.background = isBan ? '#d97706' : '#16a34a';
    link.textContent      = isBan ? '🚫 Bloquer' : '✅ Débloquer';
    openModal('modalToggle');
    lucide.createIcons();
  }
</script>