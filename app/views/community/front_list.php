<!-- Vue FrontOffice : Communauté & Blog -->
<div style="padding:2rem">
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl)">
        <i data-lucide="users" style="width:1.5rem;height:1.5rem;color:#7c3aed"></i>
      </div>
      <div>
        <h1 class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">Communauté & Blog</h1>
        <p class="text-sm" style="color:var(--text-muted)">Partagez, échangez et inspirez-vous</p>
      </div>
    </div>
    <button class="btn btn-primary btn-round" onclick="document.getElementById('newPostModal').classList.add('active')">
      <i data-lucide="plus" style="width:1rem;height:1rem"></i> Nouveau Post
    </button>
  </div>

  <!-- Tabs -->
  <div class="flex gap-2 mb-6">
    <button class="btn btn-sm" style="background:var(--primary);color:#fff;border-radius:var(--radius-full)"><i data-lucide="newspaper" style="width:0.75rem;height:0.75rem"></i> Blog</button>
    <button class="btn btn-outline btn-sm" style="border-radius:var(--radius-full)" onclick="this.style.background='var(--primary)';this.style.color='#fff'"><i data-lucide="message-circle" style="width:0.75rem;height:0.75rem"></i> Forum</button>
    <button class="btn btn-outline btn-sm" style="border-radius:var(--radius-full)"><i data-lucide="trophy" style="width:0.75rem;height:0.75rem"></i> Défis</button>
  </div>

  <div class="grid gap-6" style="grid-template-columns:2fr 1fr">
    <!-- Posts Feed -->
    <div class="space-y-4">
      <!-- Featured Post -->
      <div class="card hover-shadow card-interactive" style="padding:0;overflow:hidden;border:none">
        <div style="height:12rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);display:flex;align-items:center;justify-content:center;position:relative">
          <i data-lucide="salad" style="width:4rem;height:4rem;color:var(--primary);opacity:0.3"></i>
          <div class="absolute" style="top:0.75rem;left:0.75rem"><span class="badge badge-success"><i data-lucide="star" style="width:0.6rem;height:0.6rem"></i> À la une</span></div>
        </div>
        <div style="padding:1.5rem">
          <div class="flex items-center gap-2 mb-3">
            <div style="width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center"><i data-lucide="user" style="width:0.875rem;height:0.875rem;color:#fff"></i></div>
            <span class="text-sm font-medium" style="color:var(--text-primary)">Dr. Sarah Ben Youssef</span>
            <span class="text-xs" style="color:var(--text-muted)">• il y a 2h</span>
          </div>
          <h3 class="font-bold text-lg mb-2" style="color:var(--text-primary)">10 aliments locaux pour booster votre immunité en hiver 🌿</h3>
          <p class="text-sm mb-4" style="color:var(--text-secondary);line-height:1.6">Découvrez comment les produits de saison tunisiens peuvent renforcer votre système immunitaire naturellement...</p>
          <div class="flex items-center gap-4 text-xs" style="color:var(--text-muted)">
            <span class="flex items-center gap-1"><i data-lucide="heart" style="width:0.75rem;height:0.75rem;color:#ef4444"></i> 128</span>
            <span class="flex items-center gap-1"><i data-lucide="message-circle" style="width:0.75rem;height:0.75rem"></i> 34</span>
            <span class="flex items-center gap-1"><i data-lucide="share-2" style="width:0.75rem;height:0.75rem"></i> 12</span>
            <span class="flex items-center gap-1"><i data-lucide="bookmark" style="width:0.75rem;height:0.75rem"></i></span>
          </div>
        </div>
      </div>

      <!-- Regular Posts -->
      <?php
      $posts = [
        ['user'=>'Amine K.','time'=>'5h','title'=>'Ma recette de salade tunisienne revisitée 🥗','desc'=>'Une version healthy avec quinoa et graines de chia. Le résultat est incroyable !','likes'=>87,'comments'=>21,'tag'=>'Recette','tagColor'=>'badge-green-light'],
        ['user'=>'Fatma M.','time'=>'1j','title'=>'Challenge : 30 jours sans sucre ajouté ','desc'=>'Je partage mon expérience après un mois complet. Les résultats sont surprenants...','likes'=>203,'comments'=>56,'tag'=>'Défi','tagColor'=>'badge-yellow-light'],
        ['user'=>'Youssef B.','time'=>'2j','title'=>'Les bienfaits de l\'huile d\'olive tunisienne 🫒','desc'=>'Pourquoi notre huile d\'olive est considérée parmi les meilleures au monde.','likes'=>156,'comments'=>42,'tag'=>'Nutrition','tagColor'=>'badge-blue-light'],
      ];
      foreach ($posts as $p): ?>
      <div class="card hover-shadow" style="transition:all 0.3s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="flex items-center gap-2 mb-3">
          <div style="width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,var(--secondary),#40916C);display:flex;align-items:center;justify-content:center"><i data-lucide="user" style="width:0.875rem;height:0.875rem;color:#fff"></i></div>
          <span class="text-sm font-medium" style="color:var(--text-primary)"><?= $p['user'] ?></span>
          <span class="text-xs" style="color:var(--text-muted)">• <?= $p['time'] ?></span>
          <span class="badge <?= $p['tagColor'] ?>" style="margin-left:auto;font-size:0.65rem"><?= $p['tag'] ?></span>
        </div>
        <h3 class="font-semibold mb-2" style="color:var(--text-primary)"><?= $p['title'] ?></h3>
        <p class="text-sm mb-3" style="color:var(--text-secondary);line-height:1.6"><?= $p['desc'] ?></p>
        <div class="flex items-center gap-4 text-xs" style="color:var(--text-muted);padding-top:0.75rem;border-top:1px solid var(--border)">
          <span class="flex items-center gap-1 cursor-pointer" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color=''"><i data-lucide="heart" style="width:0.75rem;height:0.75rem"></i> <?= $p['likes'] ?></span>
          <span class="flex items-center gap-1"><i data-lucide="message-circle" style="width:0.75rem;height:0.75rem"></i> <?= $p['comments'] ?></span>
          <span class="flex items-center gap-1"><i data-lucide="share-2" style="width:0.75rem;height:0.75rem"></i></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
      <!-- Top Members -->
      <div class="card">
        <h3 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="trophy" style="width:1rem;height:1rem;color:#eab308"></i> Top Contributeurs</h3>
        <?php
        $members = [
          ['name'=>'Dr. Sarah B.Y.','xp'=>'2,450 pts','badge'=>'🥇'],
          ['name'=>'Amine K.','xp'=>'1,890 pts','badge'=>'🥈'],
          ['name'=>'Fatma M.','xp'=>'1,620 pts','badge'=>'🥉'],
          ['name'=>'Youssef B.','xp'=>'1,340 pts','badge'=>'4'],
          ['name'=>'Nour H.','xp'=>'980 pts','badge'=>'5'],
        ];
        foreach ($members as $i => $m): ?>
        <div class="flex items-center gap-3 p-2 rounded-xl" style="transition:all 0.2s;<?= $i > 0 ? 'margin-top:0.25rem' : '' ?>" onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='transparent'">
          <span style="width:1.5rem;text-align:center;font-size:0.8rem"><?= $m['badge'] ?></span>
          <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center"><i data-lucide="user" style="width:0.75rem;height:0.75rem;color:#fff"></i></div>
          <div class="flex-1"><span class="text-sm font-medium" style="color:var(--text-primary)"><?= $m['name'] ?></span></div>
          <span class="text-xs font-semibold" style="color:var(--secondary)"><?= $m['xp'] ?></span>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Trending Tags -->
      <div class="card">
        <h3 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)"><i data-lucide="trending-up" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Tendances</h3>
        <div class="flex flex-wrap gap-2">
          <?php foreach (['#NutriGreen','#Healthy','#BioTunisie','#MealPrep','#ZeroWaste','#LocalFood','#Recettes','#Détox'] as $tag): ?>
          <span class="badge badge-gray" style="cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='var(--primary)';this.style.color='#fff'" onmouseout="this.style.background='';this.style.color=''"><?= $tag ?></span>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Active Challenges -->
      <div class="card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #bbf7d0">
        <h3 class="font-semibold mb-3 flex items-center gap-2" style="color:var(--primary)"><i data-lucide="flame" style="width:1rem;height:1rem;color:var(--accent-orange)"></i> Défi en cours</h3>
        <h4 class="font-bold mb-1" style="color:var(--primary)">7 jours Bio 🌱</h4>
        <p class="text-xs mb-3" style="color:var(--text-secondary)">Mangez 100% bio pendant une semaine</p>
        <div style="background:#bbf7d0;border-radius:var(--radius-full);height:6px;margin-bottom:0.5rem"><div style="background:var(--primary);height:100%;border-radius:var(--radius-full);width:68%"></div></div>
        <div class="flex items-center justify-between text-xs" style="color:var(--text-muted)">
          <span>234 participants</span><span>68% complété</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- New Post Modal -->
<div class="modal-overlay" id="newPostModal">
  <div class="modal-box" style="max-width:32rem;text-align:left">
    <div class="flex items-center justify-between mb-4">
      <h3 class="modal-title" style="margin-bottom:0">Nouveau Post</h3>
      <button onclick="document.getElementById('newPostModal').classList.remove('active')" style="background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0.25rem"><i data-lucide="x" style="width:1.25rem;height:1.25rem"></i></button>
    </div>
    <div class="form-group">
      <input type="text" class="form-input" placeholder="Titre de votre post..." style="font-weight:600;font-size:1rem">
    </div>
    <div class="form-group">
      <textarea class="form-textarea" rows="4" placeholder="Partagez votre expérience, vos conseils ou vos recettes..."></textarea>
    </div>
    <div class="flex gap-2 mb-4">
      <button class="btn btn-outline btn-sm"><i data-lucide="image" style="width:0.75rem;height:0.75rem"></i> Photo</button>
      <button class="btn btn-outline btn-sm"><i data-lucide="tag" style="width:0.75rem;height:0.75rem"></i> Tags</button>
    </div>
    <button class="btn btn-primary btn-block" onclick="document.getElementById('newPostModal').classList.remove('active')"><i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Publier</button>
  </div>
</div>
