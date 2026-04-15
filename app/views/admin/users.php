<!-- BackOffice : Gestion Utilisateurs -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl)">
        <i data-lucide="users" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion des Utilisateurs</h1>
        <p class="text-sm" style="color:var(--text-muted)">8 utilisateurs inscrits</p>
      </div>
    </div>
    <button class="btn btn-primary btn-round"><i data-lucide="user-plus" style="width:1rem;height:1rem"></i> Ajouter</button>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-4 gap-4 mb-6">
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#dbeafe,#eff6ff)"><i data-lucide="users" style="width:1.25rem;height:1.25rem;color:#2563eb"></i></div><div class="stat-info"><span class="stat-value">1,248</span><span class="stat-label">Total utilisateurs</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4)"><i data-lucide="user-check" style="width:1.25rem;height:1.25rem;color:#16a34a"></i></div><div class="stat-info"><span class="stat-value">1,180</span><span class="stat-label">Actifs</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#fee2e2,#fef2f2)"><i data-lucide="user-x" style="width:1.25rem;height:1.25rem;color:#ef4444"></i></div><div class="stat-info"><span class="stat-value">68</span><span class="stat-label">Suspendus</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#fed7aa,#fff7ed)"><i data-lucide="crown" style="width:1.25rem;height:1.25rem;color:#ea580c"></i></div><div class="stat-info"><span class="stat-value">3</span><span class="stat-label">Admins</span></div></div>
  </div>

  <!-- Users Table -->
  <div class="card" style="padding:0;overflow:hidden">
    <div class="flex items-center justify-between" style="padding:1.25rem">
      <h3 class="font-semibold flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="list" style="width:1rem;height:1rem;color:var(--primary)"></i> Liste des utilisateurs</h3>
      <div style="display:flex;align-items:center;gap:0.5rem;position:relative">
        <i data-lucide="search" style="width:0.875rem;height:0.875rem;color:var(--text-muted);position:absolute;left:0.75rem"></i>
        <input type="text" class="form-input" placeholder="Rechercher..." style="padding-left:2.25rem;width:14rem;font-size:0.8rem;border-radius:var(--radius-full)">
      </div>
    </div>
    <table class="table">
      <thead><tr><th></th><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Inscrit le</th><th>Actions</th></tr></thead>
      <tbody>
        <?php
        $users = [
          ['name'=>'Ahmed Ben Ali','email'=>'ahmed@email.com','role'=>'Admin','roleBadge'=>'badge-primary','status'=>'Actif','statusBadge'=>'badge-green-light','date'=>'15/01/2026','avatar'=>'A'],
          ['name'=>'Sarah Trabelsi','email'=>'sarah.t@email.com','role'=>'Nutritionniste','roleBadge'=>'badge-blue-light','status'=>'Actif','statusBadge'=>'badge-green-light','date'=>'20/01/2026','avatar'=>'S'],
          ['name'=>'Youssef Karray','email'=>'youssef.k@email.com','role'=>'Utilisateur','roleBadge'=>'badge-gray','status'=>'Actif','statusBadge'=>'badge-green-light','date'=>'02/02/2026','avatar'=>'Y'],
          ['name'=>'Fatma Mejri','email'=>'fatma.m@email.com','role'=>'Utilisateur','roleBadge'=>'badge-gray','status'=>'Actif','statusBadge'=>'badge-green-light','date'=>'10/02/2026','avatar'=>'F'],
          ['name'=>'Amine Gharbi','email'=>'amine.g@email.com','role'=>'Modérateur','roleBadge'=>'badge-yellow-light','status'=>'Actif','statusBadge'=>'badge-green-light','date'=>'15/02/2026','avatar'=>'A'],
          ['name'=>'Nour Hamdi','email'=>'nour.h@email.com','role'=>'Utilisateur','roleBadge'=>'badge-gray','status'=>'Suspendu','statusBadge'=>'badge-red-light','date'=>'01/03/2026','avatar'=>'N'],
          ['name'=>'Mohamed Souissi','email'=>'med.s@email.com','role'=>'Utilisateur','roleBadge'=>'badge-gray','status'=>'Actif','statusBadge'=>'badge-green-light','date'=>'05/03/2026','avatar'=>'M'],
          ['name'=>'Hana Bouzid','email'=>'hana.b@email.com','role'=>'Utilisateur','roleBadge'=>'badge-gray','status'=>'En attente','statusBadge'=>'badge-yellow-light','date'=>'08/04/2026','avatar'=>'H'],
        ];
        foreach ($users as $u): ?>
        <tr>
          <td>
            <div style="width:2.25rem;height:2.25rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem"><?= $u['avatar'] ?></div>
          </td>
          <td class="font-semibold" style="color:var(--text-primary)"><?= $u['name'] ?></td>
          <td style="color:var(--text-secondary)"><?= $u['email'] ?></td>
          <td><span class="badge <?= $u['roleBadge'] ?>"><?= $u['role'] ?></span></td>
          <td><span class="badge <?= $u['statusBadge'] ?>"><?= $u['status'] ?></span></td>
          <td style="color:var(--text-muted)"><?= $u['date'] ?></td>
          <td>
            <div class="flex gap-2">
              <button class="icon-btn" title="Modifier"><i data-lucide="pencil" style="width:0.875rem;height:0.875rem"></i></button>
              <button class="icon-btn" title="Supprimer" style="color:var(--destructive)"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
