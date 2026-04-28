<!-- BackOffice : Gestion Communauté & Blog -->
<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl)">
        <i data-lucide="users" style="width:1.5rem;height:1.5rem;color:#7c3aed"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Gestion Communauté & Blog</h1>
        <p class="text-sm" style="color:var(--text-muted)">12 posts • 5 signalements</p>
      </div>
    </div>
  </div>

  <!-- Stats -->
  <div class="grid grid-cols-4 gap-4 mb-6">
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4)"><i data-lucide="file-text" style="width:1.25rem;height:1.25rem;color:var(--primary)"></i></div><div class="stat-info"><span class="stat-value">127</span><span class="stat-label">Total Posts</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#ede9fe,#f5f3ff)"><i data-lucide="users" style="width:1.25rem;height:1.25rem;color:#7c3aed"></i></div><div class="stat-info"><span class="stat-value">1,240</span><span class="stat-label">Membres actifs</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#fed7aa,#fff7ed)"><i data-lucide="message-circle" style="width:1.25rem;height:1.25rem;color:#ea580c"></i></div><div class="stat-info"><span class="stat-value">3,892</span><span class="stat-label">Commentaires</span></div></div>
    <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#fee2e2,#fef2f2)"><i data-lucide="flag" style="width:1.25rem;height:1.25rem;color:#ef4444"></i></div><div class="stat-info"><span class="stat-value">5</span><span class="stat-label">Signalements</span></div></div>
  </div>

  <!-- Posts Table -->
  <div class="card" style="padding:0;overflow:hidden">
    <div class="flex items-center justify-between" style="padding:1.25rem">
      <h3 class="font-semibold flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="newspaper" style="width:1rem;height:1rem;color:var(--primary)"></i> Publications récentes</h3>
    </div>
    <table class="table">
      <thead><tr><th>Auteur</th><th>Titre</th><th>Type</th><th>Likes</th><th>Statut</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        <?php
        $postList = [
          ['user'=>'Dr. Sarah B.Y.','title'=>'10 aliments locaux pour l\'immunité','type'=>'Blog','typeBadge'=>'badge-blue-light','likes'=>128,'status'=>'Publié','statusBadge'=>'badge-green-light','date'=>'09/04/2026'],
          ['user'=>'Amine K.','title'=>'Ma recette de salade tunisienne','type'=>'Recette','typeBadge'=>'badge-green-light','likes'=>87,'status'=>'Publié','statusBadge'=>'badge-green-light','date'=>'09/04/2026'],
          ['user'=>'Fatma M.','title'=>'Challenge 30 jours sans sucre','type'=>'Défi','typeBadge'=>'badge-yellow-light','likes'=>203,'status'=>'Publié','statusBadge'=>'badge-green-light','date'=>'08/04/2026'],
          ['user'=>'User123','title'=>'Spam publicitaire','type'=>'Forum','typeBadge'=>'badge-gray','likes'=>2,'status'=>'Signalé','statusBadge'=>'badge-red-light','date'=>'08/04/2026'],
          ['user'=>'Youssef B.','title'=>'Huile d\'olive tunisienne','type'=>'Blog','typeBadge'=>'badge-blue-light','likes'=>156,'status'=>'En attente','statusBadge'=>'badge-yellow-light','date'=>'07/04/2026'],
        ];
        foreach ($postList as $p): ?>
        <tr>
          <td class="font-medium" style="color:var(--text-primary)"><?= $p['user'] ?></td>
          <td style="max-width:15rem"><span class="truncate" style="display:block;color:var(--text-secondary)"><?= $p['title'] ?></span></td>
          <td><span class="badge <?= $p['typeBadge'] ?>"><?= $p['type'] ?></span></td>
          <td><span class="flex items-center gap-1 text-sm" style="color:var(--text-muted)"><i data-lucide="heart" style="width:0.7rem;height:0.7rem;color:#ef4444"></i> <?= $p['likes'] ?></span></td>
          <td><span class="badge <?= $p['statusBadge'] ?>"><?= $p['status'] ?></span></td>
          <td style="color:var(--text-muted)"><?= $p['date'] ?></td>
          <td>
            <div class="flex gap-2">
              <button class="icon-btn" title="Voir"><i data-lucide="eye" style="width:0.875rem;height:0.875rem"></i></button>
              <button class="icon-btn" title="Supprimer" style="color:var(--destructive)"><i data-lucide="trash-2" style="width:0.875rem;height:0.875rem"></i></button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
