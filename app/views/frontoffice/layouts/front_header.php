<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="GreenBite — Alimentation Durable & Nutrition Intelligente">
  <title>GreenBite</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <script src="<?= BASE_URL ?>/assets/js/validate.js"></script>
  <style>
    /* Fix for blurry text in dark mode */
    [data-theme='dark'] body, 
    [data-theme='dark'] .page-content * {
      -webkit-font-smoothing: subpixel-antialiased !important;
      -moz-osx-font-smoothing: auto !important;
      text-shadow: none !important;
    }
    
    [data-theme='dark'] .front-sidebar {
      /* Disable backdrop-filter in dark mode to prevent webkit blur bug on text */
      backdrop-filter: none !important;
      -webkit-backdrop-filter: none !important;
    }

    /* ===== FRONT SIDEBAR — same font & colors as admin sidebar ===== */
    .front-sidebar .front-sidebar-zone-label,
    .front-sidebar .sidebar-section-label {
      color: rgba(255, 255, 255, 0.65) !important;
      font-size: 0.68rem !important;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      margin-bottom: 0.5rem;
      padding-left: 0.5rem;
      font-family: 'DM Sans', 'Poppins', sans-serif;
    }
    .front-sidebar .sidebar-nav-item {
      color: #ffffff !important;
      border-radius: 0.75rem !important;
      margin-bottom: 0.25rem !important;
      padding: 0.65rem 1rem !important;
      transition: all 0.3s ease !important;
      font-family: 'DM Sans', 'Inter', sans-serif;
      font-size: 0.9rem;
      font-weight: 500;
      letter-spacing: 0.01em;
    }
    .front-sidebar .sidebar-nav-item:hover {
      background: rgba(255, 255, 255, 0.07) !important;
      color: #fff !important;
      transform: translateX(3px);
    }
    .front-sidebar .sidebar-nav-item.active {
      background: linear-gradient(135deg, rgba(82,183,136,0.25), rgba(45,106,79,0.15)) !important;
      color: #a7f3d0 !important;
      border-left: 3px solid #52B788 !important;
      box-shadow: inset 0 0 20px rgba(82,183,136,0.05);
      font-weight: 600;
    }
    .front-sidebar .sidebar-nav-item i {
      color: inherit !important;
    }
    .front-logo-text {
      margin-left: 0.75rem;
      font-family: 'Poppins', sans-serif;
      font-size: 1.45rem;
      font-weight: 800;
      letter-spacing: -0.01em;
    }
    .front-logo-text .logo-green {
      color: #52B788;
    }
    .front-logo-text .logo-bite {
      color: #ffffff;
      -webkit-text-fill-color: #ffffff;
    }
  </style>
</head>
<body>
<script>if (localStorage.getItem('theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');</script>

  <div class="page-with-sidebar">
    <!-- ===== SIDEBAR FRONTOFFICE ===== -->
    <nav class="admin-sidebar front-sidebar">

      <!-- Animated particles inside sidebar -->
      <div style="position:absolute;top:30%;right:10%;width:60px;height:60px;background:radial-gradient(circle,rgba(82,183,136,0.12) 0%,transparent 70%);border-radius:50%;pointer-events:none;animation:float 6s ease-in-out infinite;z-index:0"></div>
      <div style="position:absolute;top:60%;left:5%;width:45px;height:45px;background:radial-gradient(circle,rgba(167,243,208,0.08) 0%,transparent 70%);border-radius:50%;pointer-events:none;animation:floatReverse 8s ease-in-out infinite;z-index:0"></div>

      <!-- Logo -->
      <div style="border-bottom:1px solid rgba(255,255,255,0.06);padding:1.5rem 1.5rem 1.25rem;position:relative;z-index:1">
        <a href="<?= BASE_URL ?>/" style="display:flex;align-items:center;text-decoration:none;margin-bottom:0.4rem">
          <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border-radius:0.875rem;border:1px solid rgba(255,255,255,0.18);box-shadow:0 4px 12px rgba(0,0,0,0.15);flex-shrink:0">
            <i data-lucide="leaf" style="width:1.5rem;height:1.5rem;color:#a7f3d0"></i>
          </div>
          <span class="front-logo-text"><span class="logo-green">Green</span><span class="logo-bite">Bite</span></span>
        </a>

        <span class="front-sidebar-zone-label">Espace Utilisateur</span>
      </div>

      <!-- Navigation -->
      <div class="sidebar-nav" style="padding:1rem 0.75rem;position:relative;z-index:1">

        <!-- Section: Navigation -->
        <div class="sidebar-section-label" style="padding-top:0.25rem">Navigation</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/" class="sidebar-nav-item <?= (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : '' ?>">
              <i data-lucide="home"></i><span>Accueil</span>
            </a>
          </li>
        </ul>

        <!-- Section: Nutrition -->
        <div class="sidebar-section-label">Suivi Nutritionnel</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'regime') !== false) ? 'active' : '' ?>">
              <i data-lucide="salad"></i><span>Régimes</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'plan') !== false) ? 'active' : '' ?>">
              <i data-lucide="clipboard-list"></i><span>Plans</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="utensils-crossed"></i><span>Repas</span>
            </a>
          </li>
        </ul>

        <!-- Section: Marketplace -->
        <div class="sidebar-section-label">Marketplace</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=marketplace" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="shopping-basket"></i><span>Produits</span>
            </a>
          </li>
          <li>
            <?php $cartCount = isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0; ?>
            <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && isset($_GET['action']) && $_GET['action'] === 'order') ? 'active' : '' ?>" style="position:relative">
              <i data-lucide="shopping-cart"></i>
              <span>Commander</span>
              <?php if ($cartCount > 0): ?>
                <span style="margin-left:auto;min-width:1.25rem;height:1.25rem;background:linear-gradient(135deg,#f97316,#ef4444);color:#fff;border-radius:999px;font-size:0.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 0.3rem;flex-shrink:0">
                  <?= $cartCount ?>
                </span>
              <?php endif; ?>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=marketplace&action=history" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && isset($_GET['action']) && in_array($_GET['action'], ['history', 'track-order'])) ? 'active' : '' ?>">
              <i data-lucide="package"></i><span>Mes Commandes</span>
            </a>
          </li>
        </ul>

        <!-- Section: Recettes -->
        <div class="sidebar-section-label">Recettes Durables</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=recettes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="book-open"></i><span>Explorer</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=recettes&action=my-suggestions" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes' && isset($_GET['action']) && ($_GET['action'] === 'my-suggestions' || $_GET['action'] === 'edit-suggestion')) ? 'active' : '' ?>">
              <i data-lucide="lightbulb"></i><span>Mes Suggestions</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=recettes&action=suggest" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes' && isset($_GET['action']) && $_GET['action'] === 'suggest') ? 'active' : '' ?>">
              <i data-lucide="plus-circle"></i><span>Proposer</span>
            </a>
          </li>
        </ul>

        <!-- Section: Social -->
        <div class="sidebar-section-label">Social</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=article&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && in_array($_GET['page'], ['article','community'])) ? 'active' : '' ?>">
              <i data-lucide="message-circle"></i><span>Communauté &amp; Blog</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Footer -->
      <div style="border-top:1px solid rgba(255,255,255,0.06);padding:0.875rem;position:relative;z-index:1">
        <button class="admin-dark-toggle" onclick="toggleDarkMode()" id="frontDarkBtn">
          <i data-lucide="moon" id="frontDarkLucide"></i>
          <span id="frontDarkLabel">Mode sombre</span>
        </button>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN'): ?>
          <a href="<?= BASE_URL ?>/?page=admin-users" class="sidebar-nav-item" style="margin-top:4px">
            <i data-lucide="shield-check"></i><span>Administration</span>
          </a>
        <?php endif; ?>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
          <a href="<?= BASE_URL ?>/?page=logout" class="sidebar-nav-item" style="margin-top:4px">
            <i data-lucide="log-out"></i><span>Se déconnecter</span>
          </a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/?page=login" class="sidebar-nav-item" style="margin-top:4px">
            <i data-lucide="log-in"></i><span>Se connecter</span>
          </a>
        <?php endif; ?>
      </div>
    </nav>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <div class="page-content-admin">
      <!-- Top Navbar -->
      <div class="front-topbar">
        <div class="flex items-center gap-3">
          <div>
            <h2 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--text-primary);line-height:1.2">
              <?php
                $hour = (int)date('H');
                if ($hour < 12) echo 'Bonjour ☀️';
                elseif ($hour < 18) echo 'Bon après-midi 🌤️';
                else echo 'Bonsoir 🌙';
              ?>
            </h2>
            <p style="font-size:0.75rem;color:var(--text-muted);margin-top:1px">
              <?php
                $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[(int)date('n')-1] . ' ' . date('Y');
              ?>
            </p>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <!-- Search -->
          <div class="front-topbar-search" style="position:relative;" id="frontSearchWrap">
            <i data-lucide="search" style="width:0.875rem;height:0.875rem;color:var(--text-muted);position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);pointer-events:none;z-index:2;"></i>
            <input type="text" id="frontSearchInput" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher..." autocomplete="new-password"
                   style="width:13rem;padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1.5px solid var(--border);border-radius:var(--radius-full);font-size:0.8rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none"
                   onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)';this.style.width='17rem'"
                   onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';this.style.width='13rem'">
            <div id="frontSearchDrop" style="position:absolute;top:calc(100% + 6px);left:0;right:0;background:var(--card);border:1.5px solid var(--border);border-radius:0.875rem;box-shadow:0 12px 40px rgba(0,0,0,0.1);display:none;z-index:9999;max-height:260px;overflow-y:auto;padding:0.3rem"></div>
          </div>
          <style>
          #frontSearchDrop.fsd-open{display:block;animation:fsdUp 0.15s ease}
          @keyframes fsdUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
          .fsd-item{display:flex;align-items:center;gap:0.55rem;padding:0.48rem 0.8rem;border-radius:0.6rem;font-size:0.81rem;color:var(--text-primary);cursor:pointer;text-decoration:none;transition:background 0.12s}
          .fsd-item:hover{background:var(--muted)}
          .fsd-icon{width:1.4rem;height:1.4rem;border-radius:0.35rem;display:flex;align-items:center;justify-content:center;flex-shrink:0}
          </style>
          <script>
          (function(){
            const _FP=[
              {label:'Accueil',           icon:'home',            bg:'#dcfce7',color:'#2D6A4F',url:'<?= BASE_URL ?>/'},
              {label:'Régimes',           icon:'salad',           bg:'#dcfce7',color:'#2D6A4F',url:'<?= BASE_URL ?>/?page=nutrition&action=regimes'},
              {label:'Plans',             icon:'clipboard-list',  bg:'#ede9fe',color:'#7c3aed',url:'<?= BASE_URL ?>/?page=nutrition&action=plans'},
              {label:'Repas',             icon:'utensils-crossed',bg:'#fef3c7',color:'#d97706',url:'<?= BASE_URL ?>/?page=nutrition'},
              {label:'Produits',          icon:'shopping-basket', bg:'#cffafe',color:'#0891b2',url:'<?= BASE_URL ?>/?page=marketplace'},
              {label:'Commander',         icon:'shopping-cart',   bg:'#fef3c7',color:'#d97706',url:'<?= BASE_URL ?>/?page=marketplace&action=order'},
              {label:'Mes Commandes',     icon:'package',         bg:'#fee2e2',color:'#dc2626',url:'<?= BASE_URL ?>/?page=marketplace&action=history'},
              {label:'Explorer',          icon:'book-open',       bg:'#dcfce7',color:'#2D6A4F',url:'<?= BASE_URL ?>/?page=recettes'},
              {label:'Mes Suggestions',   icon:'lightbulb',       bg:'#fef3c7',color:'#d97706',url:'<?= BASE_URL ?>/?page=recettes&action=my-suggestions'},
              {label:'Proposer',          icon:'plus-circle',     bg:'#ede9fe',color:'#7c3aed',url:'<?= BASE_URL ?>/?page=recettes&action=suggest'},
              {label:'Communauté & Blog', icon:'message-circle',  bg:'#dcfce7',color:'#2D6A4F',url:'<?= BASE_URL ?>/?page=article&action=list'},
            ];
            const si=document.getElementById('frontSearchInput');
            const sd=document.getElementById('frontSearchDrop');
            if(!si || !sd) return;
            function doS(q){
              q=q.trim().toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
              let res;
              if(!q){
                res=_FP; // Show all sidebar options when empty
              } else {
                res=_FP.filter(p=>p.label.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(q));
              }
              sd.innerHTML=res.length
                ?res.map(p=>`<a href="${p.url}" class="fsd-item"><div class="fsd-icon" style="background:${p.bg}"><i data-lucide="${p.icon}" style="width:0.75rem;height:0.75rem;color:${p.color}"></i></div>${p.label}</a>`).join('')
                :`<div style="padding:0.65rem 0.8rem;font-size:0.8rem;color:var(--text-muted)">Aucun résultat pour « ${q} »</div>`;
              sd.classList.add('fsd-open');
              if(typeof lucide!=='undefined')lucide.createIcons();
            }
            si.addEventListener('click',function(e){ e.stopPropagation(); doS(this.value); });
            si.addEventListener('focus',function(){doS(this.value);});
            si.addEventListener('input',function(){doS(this.value);});
            si.addEventListener('keydown',function(e){
              if(e.key==='Enter'){const f=sd.querySelector('.fsd-item');if(f)window.location.href=f.href;}
              if(e.key==='Escape'){sd.classList.remove('fsd-open');this.blur();}
            });
            document.addEventListener('click',function(e){if(!document.getElementById('frontSearchWrap').contains(e.target))sd.classList.remove('fsd-open');});
          })();
          </script>

          <!-- Divider -->
          <div style="width:1px;height:1.5rem;background:var(--border)"></div>

          <?php
          // ── User notifications: ALL submission types ──
          $_uNotifs = [];
          $_uUnread = 0;
          $isAdmin  = isset($_SESSION['role']) && $_SESSION['role'] === 'ADMIN';

          if (!$isAdmin && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
            $_uDb    = Database::getConnexion();
            $_uNom   = $_SESSION['username'];
            $_uEmail = $_SESSION['email'] ?? '';

            try {
              // 1. Régimes soumis → accepté / refusé
              $st = $_uDb->prepare("SELECT nom, statut, commentaire_admin, created_at FROM regime_alimentaire WHERE soumis_par = ? AND statut IN ('accepte','refuse','en_attente') ORDER BY created_at DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $_uNotifs[] = [
                  'type'=>'regime','icon'=>'salad','bg_ok'=>'#dcfce7','bg_ko'=>'#fee2e2','color_ok'=>'#16a34a','color_ko'=>'#dc2626',
                  'label'=> 'Régime : '.$r['nom'], 'statut'=>$r['statut'], 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre régime a été accepté !', 'msg_ko'=>null, 'admin_comment'=>$r['commentaire_admin'],
                  'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=nutrition&action=regimes'
                ];
                $_uUnread++;
              }

              // 2. Plans soumis → accepté / refusé
              $st = $_uDb->prepare("SELECT nom, statut, commentaire_admin, created_at FROM plan_nutritionnel WHERE soumis_par = ? AND statut IN ('accepte','refuse') ORDER BY created_at DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $_uNotifs[] = [
                  'type'=>'plan','icon'=>'clipboard-list','bg_ok'=>'#ede9fe','bg_ko'=>'#fee2e2','color_ok'=>'#7c3aed','color_ko'=>'#dc2626',
                  'label'=>'Plan : '.$r['nom'], 'statut'=>$r['statut'], 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre plan a été accepté !', 'msg_ko'=>null, 'admin_comment'=>$r['commentaire_admin'],
                  'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=nutrition&action=plans'
                ];
                $_uUnread++;
              }

              // 3. Recettes soumises → acceptée / refusée
              $st = $_uDb->prepare("SELECT titre, statut, created_at FROM recette WHERE soumis_par = ? AND statut IN ('acceptee','refusee','en_attente') ORDER BY created_at DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $ok = ($r['statut'] === 'acceptee');
                $_uNotifs[] = [
                  'type'=>'recette','icon'=>'chef-hat','bg_ok'=>'#dcfce7','bg_ko'=>'#fee2e2','color_ok'=>'#16a34a','color_ko'=>'#dc2626',
                  'label'=>'Recette : '.$r['titre'], 'statut'=>$ok?'accepte':'refuse', 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre recette a été acceptée !', 'msg_ko'=>null, 'admin_comment'=>null,
                  'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=recettes'
                ];
                $_uUnread++;
              }

              
              // 3b. Repas soumis
              $st = $_uDb->prepare("SELECT nom, statut, admin_comment, date_repas as created_at FROM repas WHERE soumis_par = ? AND statut IN ('accepte','refuse') ORDER BY created_at DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $_uNotifs[] = [
                  'type'=>'repas','icon'=>'utensils-crossed','bg_ok'=>'#fef3c7','bg_ko'=>'#fee2e2','color_ok'=>'#d97706','color_ko'=>'#dc2626',
                  'label'=> 'Repas : '.$r['nom'], 'statut'=>$r['statut'], 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre repas a été accepté !', 'msg_ko'=>null, 'admin_comment'=>$r['admin_comment'],
                  'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=nutrition'
                ];
                $_uUnread++;
              }

              // 4. Commentaires article → validé / signalé
              $st = $_uDb->prepare("SELECT c.contenu, c.statut, c.date_commentaire, a.titre FROM commentaire c LEFT JOIN article a ON a.id = c.article_id WHERE c.pseudo = ? AND c.statut IN ('valide','signale') ORDER BY c.date_commentaire DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $ok = ($r['statut'] === 'valide');
                $_uNotifs[] = [
                  'type'=>'commentaire','icon'=>'message-circle','bg_ok'=>'#dcfce7','bg_ko'=>'#fef3c7','color_ok'=>'#16a34a','color_ko'=>'#d97706',
                  'label'=>'Commentaire sur « '.mb_substr($r['titre'] ?? 'article', 0, 25).'... »',
                  'statut'=>$ok?'accepte':'refuse', 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre commentaire a été validé et publié !',
                  'msg_ko'=>'Votre commentaire a été signalé et masqué.',
                  'admin_comment'=>null,
                  'created_at'=>$r['date_commentaire'], 'url'=>BASE_URL.'/?page=article&action=list'
                ];
                $_uUnread++;
              }

              // 5. Commentaires recette → approuvé / refusé
              $st = $_uDb->prepare("SELECT cr.commentaire, cr.statut, cr.created_at, r.titre FROM commentaire_recette cr LEFT JOIN recette r ON r.id = cr.recette_id WHERE cr.auteur = ? AND cr.statut IN ('approuve','refuse') ORDER BY cr.created_at DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $ok = ($r['statut'] === 'approuve');
                $_uNotifs[] = [
                  'type'=>'commentaire_recette','icon'=>'star','bg_ok'=>'#fef3c7','bg_ko'=>'#fee2e2','color_ok'=>'#d97706','color_ko'=>'#dc2626',
                  'label'=>'Avis sur « '.mb_substr($r['titre'] ?? 'recette', 0, 25).'... »',
                  'statut'=>$ok?'accepte':'refuse', 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre avis a été approuvé et publié !',
                  'msg_ko'=>'Votre avis a été refusé.',
                  'admin_comment'=>null,
                  'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=recettes'
                ];
                $_uUnread++;
              }

              // 6. Commandes — changements de statut (pas en_attente)
              if ($_uEmail) {
                $st = $_uDb->prepare("SELECT id, total, statut, created_at FROM commande WHERE client_email = ? AND statut IN ('en_attente','confirmee','livree','annulee') ORDER BY created_at DESC LIMIT 8");
                $st->execute([$_uEmail]);
                foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                  $statMap = ['en_attente'=>['label'=>'⏳ En attente','bg'=>'#fef3c7','color'=>'#d97706','icon'=>'clock','msg'=>'Votre commande est en attente.'],
                              'confirmee'=>['label'=>'✓ Confirmée','bg'=>'#dcfce7','color'=>'#16a34a','icon'=>'check-circle-2','msg'=>'Votre commande a été confirmée !'],
                              'livree'   =>['label'=>'📦 Livrée',  'bg'=>'#cffafe','color'=>'#0891b2','icon'=>'package','msg'=>'Votre commande a été livrée !'],
                              'annulee'  =>['label'=>'✗ Annulée', 'bg'=>'#fee2e2','color'=>'#dc2626','icon'=>'x-circle','msg'=>'Votre commande a été annulée.']];
                  $s = $statMap[$r['statut']];
                  $_uNotifs[] = [
                    'type'=>'commande','icon'=>$s['icon'],'bg_ok'=>$s['bg'],'bg_ko'=>$s['bg'],'color_ok'=>$s['color'],'color_ko'=>$s['color'],
                    'label'=>'Commande #'.$r['id'].' — '.number_format((float)$r['total'],2,',','.').' DT',
                    'statut'=>($r['statut']==='annulee'?'refuse':'accepte'), 'ok_val'=>'accepte',
                    'msg_ok'=>$s['msg'], 'msg_ko'=>$s['msg'], 'admin_comment'=>null,
                    'badge_override'=>$s['label'],
                    'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=marketplace&action=history'
                  ];
                  $_uUnread++;
                }
              }

              // 7. Matériels proposés → accepté / refusé
              $st = $_uDb->prepare("SELECT nom, statut, motif_refus, created_at FROM materiel WHERE propose_par = ? AND statut IN ('accepte','refuse') ORDER BY created_at DESC LIMIT 8");
              $st->execute([$_uNom]);
              foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $_uNotifs[] = [
                  'type'=>'materiel','icon'=>'wrench','bg_ok'=>'#dcfce7','bg_ko'=>'#fee2e2','color_ok'=>'#16a34a','color_ko'=>'#dc2626',
                  'label'=>'Matériel : '.$r['nom'], 'statut'=>$r['statut'], 'ok_val'=>'accepte',
                  'msg_ok'=>'Votre matériel a été accepté !', 'msg_ko'=>null, 'admin_comment'=>$r['motif_refus'],
                  'created_at'=>$r['created_at'], 'url'=>BASE_URL.'/?page=recettes'
                ];
                $_uUnread++;
              }

              // Sort newest first
              usort($_uNotifs, fn($a,$b) => strtotime($b['created_at']) - strtotime($a['created_at']));
            } catch (Exception $_ue) {}
          }
          ?>

          <!-- Notification Bell (all users) -->
          <div style="position:relative" id="frontNotifBtn">
            <button onclick="toggleFrontNotif(event)"
                    style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:var(--radius-full);border:1.5px solid var(--border);background:var(--surface);cursor:pointer;transition:all 0.3s;color:var(--text-secondary);position:relative"
                    onmouseover="this.style.borderColor='var(--secondary)';this.style.background='rgba(82,183,136,0.06)';this.style.color='var(--secondary)'"
                    onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface)';this.style.color='var(--text-secondary)'"
                    title="Notifications">
              <i data-lucide="bell" style="width:0.95rem;height:0.95rem"></i>
              <?php if ($isAdmin): // Admin badge — links to backoffice notif count ?>
              <span style="position:absolute;top:-3px;right:-3px;width:8px;height:8px;background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:50%;border:2px solid var(--card);animation:bellPulse 2s infinite"></span>
              <?php elseif ($_uUnread > 0): ?>
              <span style="position:absolute;top:-4px;right:-4px;min-width:1rem;height:1rem;padding:0 0.2rem;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:0.55rem;font-weight:700;border-radius:999px;border:2px solid var(--card);display:flex;align-items:center;justify-content:center;animation:bellPulse 2s infinite"><?= $_uUnread > 9 ? '9+' : $_uUnread ?></span>
              <?php endif; ?>
            </button>

            <!-- Notification Panel -->
            <div id="frontNotifPanel" style="position:absolute;top:calc(100% + 10px);right:0;width:330px;max-height:440px;overflow-y:auto;background:var(--card);border:1.5px solid var(--border);border-radius:1rem;box-shadow:0 20px 60px rgba(0,0,0,0.16);display:none;z-index:9999;padding:0">

              <!-- Header -->
              <div style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 1.1rem;border-bottom:1px solid var(--border);position:sticky;top:0;background:var(--card);z-index:1">
                <div style="display:flex;align-items:center;gap:0.5rem">
                  <i data-lucide="bell" style="width:0.875rem;height:0.875rem;color:var(--secondary)"></i>
                  <span style="font-size:0.85rem;font-weight:700;color:var(--text-primary)">Notifications</span>
                  <?php if ($isAdmin || $_uUnread > 0): ?>
                  <span style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:0.58rem;font-weight:700;padding:0.12rem 0.4rem;border-radius:999px"><?= $isAdmin ? '!' : $_uUnread ?></span>
                  <?php endif; ?>
                </div>
                <button onclick="closeFrontNotif()" style="background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0.2rem;border-radius:0.35rem">
                  <i data-lucide="x" style="width:0.85rem;height:0.85rem"></i>
                </button>
              </div>

              <?php if ($isAdmin): ?>
              <!-- Admin: redirect to admin panel -->
              <a href="<?= BASE_URL ?>/?page=admin-stats" style="display:flex;align-items:center;gap:0.75rem;padding:1rem 1.1rem;text-decoration:none;transition:background 0.15s" onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='transparent'">
                <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:linear-gradient(135deg,#dcfce7,#f0fdf4);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                  <i data-lucide="shield-check" style="width:1.1rem;height:1.1rem;color:var(--primary)"></i>
                </div>
                <div>
                  <div style="font-size:0.82rem;font-weight:700;color:var(--text-primary)">Panneau administrateur</div>
                  <div style="font-size:0.72rem;color:var(--text-muted)">Voir les éléments en attente de validation →</div>
                </div>
              </a>

              <?php elseif (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
              <!-- Guest -->
              <div style="padding:1.75rem 1rem;text-align:center;color:var(--text-muted);font-size:0.82rem">
                <i data-lucide="lock" style="width:2rem;height:2rem;color:var(--text-muted);display:block;margin:0 auto 0.5rem"></i>
                <div style="font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">Connectez-vous</div>
                pour voir vos notifications.
                <div style="margin-top:0.75rem"><a href="<?= BASE_URL ?>/?page=login" style="font-size:0.78rem;font-weight:600;color:var(--secondary);text-decoration:none">Se connecter →</a></div>
              </div>

              <?php elseif (empty($_uNotifs)): ?>
              <!-- No notifications yet -->
              <div style="padding:1.75rem 1rem;text-align:center;color:var(--text-muted);font-size:0.82rem">
                <i data-lucide="bell-off" style="width:2rem;height:2rem;display:block;margin:0 auto 0.5rem;opacity:0.4"></i>
                <div style="font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">Aucune notification</div>
                Vos soumissions et commandes apparaîtront ici une fois traitées.
              </div>

              <?php else: ?>
              <!-- User notifications list -->
              <?php foreach ($_uNotifs as $_n):
                $isPending  = ($_n['statut'] === 'en_attente');
                $isAccepted = (!$isPending && $_n['statut'] === $_n['ok_val']);
                $isRefused  = (!$isPending && !$isAccepted);
                // Icon colours
                if ($isPending) {
                  $iconBg    = '#fef3c7';
                  $iconColor = '#d97706';
                } else {
                  $iconBg    = $isAccepted ? $_n['bg_ok']    : $_n['bg_ko'];
                  $iconColor = $isAccepted ? $_n['color_ok'] : $_n['color_ko'];
                }
                // Badge label + background
                if (isset($_n['badge_override'])) {
                  $badgeBg    = 'linear-gradient(135deg,'.$iconColor.','.$iconColor.')';
                  $badgeLabel = $_n['badge_override'];
                } elseif ($isPending) {
                  $badgeBg    = 'linear-gradient(135deg,#f59e0b,#d97706)';
                  $badgeLabel = '⏳ En attente';
                } elseif ($isAccepted) {
                  $badgeBg    = 'linear-gradient(135deg,#22c55e,#16a34a)';
                  $badgeLabel = '✓ Accepté';
                } else {
                  $badgeBg    = 'linear-gradient(135deg,#ef4444,#dc2626)';
                  $badgeLabel = '✗ Refusé';
                }
                // Sub-message
                if ($isPending) {
                  $subMsg = 'En attente de validation par un administrateur.';
                } elseif ($isAccepted) {
                  $subMsg = $_n['msg_ok'] ?? '';
                } else {
                  $subMsg = $_n['msg_ko'] ?? 'Refusé';
                }
                // for commandes: badge bg matches the item color
                if ($_n['type'] === 'commande') {
                  $badgeBg = 'linear-gradient(135deg,'.$iconColor.','.$iconColor.')';
                }
              ?>
              <a href="<?= htmlspecialchars($_n['url']) ?>"
                 style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.85rem 1.1rem;border-bottom:1px solid var(--border);text-decoration:none;transition:background 0.15s"
                 onmouseover="this.style.background='var(--muted)'" onmouseout="this.style.background='transparent'">

                <div style="width:2.25rem;height:2.25rem;border-radius:50%;background:<?= $iconBg ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px">
                  <i data-lucide="<?= $_n['icon'] ?>" style="width:0.9rem;height:0.9rem;color:<?= $iconColor ?>"></i>
                </div>

                <div style="flex:1;min-width:0">
                  <!-- Title + badge -->
                  <div style="display:flex;align-items:center;justify-content:space-between;gap:0.4rem;margin-bottom:0.25rem">
                    <div style="font-size:0.8rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px"><?= htmlspecialchars($_n['label']) ?></div>
                    <span style="font-size:0.58rem;font-weight:700;color:#fff;background:<?= $badgeBg ?>;padding:0.1rem 0.45rem;border-radius:999px;flex-shrink:0;white-space:nowrap"><?= $badgeLabel ?></span>
                  </div>

                  <!-- Sub-message or refusal reason -->
                  <?php if ($isRefused && !empty($_n['admin_comment'])): ?>
                  <div style="font-size:0.71rem;color:#dc2626;background:#fef2f2;border-radius:0.375rem;padding:0.3rem 0.5rem;border-left:2px solid #ef4444;line-height:1.45">
                    <strong>Motif :</strong> <?= htmlspecialchars($_n['admin_comment']) ?>
                  </div>
                  <?php elseif (!empty($subMsg)): ?>
                  <div style="font-size:0.71rem;color:<?= $isPending ? '#d97706' : ($isAccepted ? $iconColor : '#6b7280') ?>"><?= htmlspecialchars($subMsg) ?></div>
                  <?php endif; ?>

                  <!-- Date -->
                  <div style="font-size:0.65rem;color:var(--text-muted);margin-top:0.2rem"><?= date('d M Y', strtotime($_n['created_at'])) ?></div>
                </div>
              </a>
              <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <style>
          @keyframes bellPulse { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,0.4);}50%{box-shadow:0 0 0 5px rgba(239,68,68,0);} }
          #frontNotifPanel { animation:notifSlideIn 0.2s ease; }
          @keyframes notifSlideIn { from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);} }
          </style>
          <script>
          function toggleFrontNotif(e) {
            e.stopPropagation();
            const p = document.getElementById('frontNotifPanel');
            const isOpen = p.style.display === 'block';
            p.style.display = isOpen ? 'none' : 'block';
            if (!isOpen && typeof lucide !== 'undefined') lucide.createIcons();
          }
          function closeFrontNotif() { document.getElementById('frontNotifPanel').style.display = 'none'; }
          document.addEventListener('click', function(e) {
            const btn = document.getElementById('frontNotifBtn');
            if (btn && !btn.contains(e.target)) closeFrontNotif();
          });
          </script>

          <!-- User -->
          <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.35rem">

            <!-- Badge profil -->
            <div onclick="openProfileModal()"
                 style="display:flex;align-items:center;gap:0.5rem;padding:0.35rem 0.75rem 0.35rem 0.35rem;border-radius:var(--radius-full);background:var(--surface);border:1px solid var(--border);cursor:pointer;transition:all 0.3s"
                 onmouseover="this.style.borderColor='var(--secondary)'"
                 onmouseout="this.style.borderColor='var(--border)'"
                 title="Modifier le profil">

              <!-- Avatar -->
              <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;overflow:hidden">
                <?php if (!empty($_SESSION['avatar'])): ?>
                  <img src="<?= BASE_URL ?>/assets/images/avatars/<?= htmlspecialchars($_SESSION['avatar']) ?>"
                       style="width:100%;height:100%;object-fit:cover">
                <?php else: ?>
                  <i data-lucide="user" style="width:0.875rem;height:0.875rem;color:#fff"></i>
                <?php endif; ?>
              </div>

              <!-- Nom + rôle -->
              <div style="display:flex;flex-direction:column;align-items:flex-start">
                <span style="font-size:0.8rem;font-weight:600;color:var(--text-primary)">
                  <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Utilisateur' ?>
                </span>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                  <?php if ($_SESSION['role'] === 'ADMIN'): ?>
                    <span style="font-size:0.65rem;color:var(--primary);font-weight:700;display:flex;align-items:center;gap:0.2rem">
                      <i data-lucide="shield-check" style="width:0.65rem;height:0.65rem"></i> Admin
                    </span>
                  <?php elseif ($_SESSION['role'] === 'COACH'): ?>
                    <span style="font-size:0.65rem;color:#7c3aed;font-weight:700;display:flex;align-items:center;gap:0.2rem">
                      <i data-lucide="award" style="width:0.65rem;height:0.65rem"></i> Coach
                    </span>
                  <?php else: ?>
                    <span style="font-size:0.65rem;color:var(--text-muted);font-weight:600">USER</span>
                  <?php endif; ?>
                <?php else: ?>
                  <span style="font-size:0.65rem;color:var(--text-muted);font-weight:600">VISITEUR</span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Bouton Coach — en dessous, uniquement pour USER -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['role'] === 'USER'): ?>
              <?php if (isset($_SESSION['coach_request']) && $_SESSION['coach_request'] === 'pending'): ?>
                <span style="font-size:0.7rem;color:#d97706;font-weight:700;display:flex;align-items:center;gap:0.3rem;padding:0.25rem 0.75rem;background:#fef3c7;border-radius:var(--radius-full);border:1px solid #fde68a">
                  <i data-lucide="clock" style="width:0.65rem;height:0.65rem"></i> Demande en attente
                </span>
              <?php elseif (isset($_SESSION['coach_request']) && $_SESSION['coach_request'] === 'refused'): ?>
                <span style="font-size:0.7rem;color:#dc2626;font-weight:700;display:flex;align-items:center;gap:0.3rem;padding:0.25rem 0.75rem;background:#fee2e2;border-radius:var(--radius-full);border:1px solid #fca5a5">
                  <i data-lucide="x-circle" style="width:0.65rem;height:0.65rem"></i> Demande refusée
                </span>
              <?php else: ?>
                <button onclick="openCoachModal()"
                        style="font-size:0.7rem;color:#7c3aed;font-weight:700;display:flex;align-items:center;gap:0.3rem;padding:0.25rem 0.75rem;background:linear-gradient(135deg,#ede9fe,#ddd6fe);border:1px solid #c4b5fd;border-radius:var(--radius-full);cursor:pointer;transition:all 0.2s"
                        onmouseover="this.style.background='linear-gradient(135deg,#ddd6fe,#c4b5fd)'"
                        onmouseout="this.style.background='linear-gradient(135deg,#ede9fe,#ddd6fe)'">
                  <i data-lucide="award" style="width:0.65rem;height:0.65rem"></i> Devenir Coach
                </button>
              <?php endif; ?>
            <?php endif; ?>

          </div>
        </div>
      </div>

      <!-- Flash Messages -->
      <div style="padding:0 2rem">
        <?php if (!empty($_SESSION['success'])): ?>
          <div class="p-4 rounded-xl mb-4 animate-fade-up flex items-center gap-3" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#166534;border:1px solid #bbf7d0;box-shadow:0 4px 20px rgba(22,101,52,0.1)">
            <i data-lucide="check-circle-2" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
          <div class="p-4 rounded-xl mb-4 animate-fade-up flex items-center gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5;box-shadow:0 4px 20px rgba(153,27,27,0.1)">
            <i data-lucide="alert-circle" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
      </div>

<!-- ================================================
     MODAL DEMANDE COACH
================================================ -->
<div id="modalCoach" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9999;align-items:center;justify-content:center">
  <div style="background:var(--background);border-radius:1.25rem;padding:2rem;width:100%;max-width:22rem;box-shadow:0 30px 60px rgba(0,0,0,0.2);position:relative;animation:fadeUp 0.25s ease">

    <button onclick="closeCoachModal()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;cursor:pointer;color:var(--text-muted);width:1.75rem;height:1.75rem;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s"
            onmouseover="this.style.background='var(--surface)'"
            onmouseout="this.style.background='none'">
      <i data-lucide="x" style="width:1rem;height:1rem"></i>
    </button>

    <!-- Header -->
    <div style="text-align:center;margin-bottom:1.5rem">
      <div style="width:3.5rem;height:3.5rem;border-radius:50%;background:linear-gradient(135deg,#ede9fe,#ddd6fe);display:flex;align-items:center;justify-content:center;margin:0 auto 0.875rem">
        <i data-lucide="award" style="width:1.5rem;height:1.5rem;color:#7c3aed"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.125rem;font-weight:700;color:var(--text-primary);margin:0">Devenir Coach</h3>
      <p style="color:var(--text-muted);font-size:0.8rem;margin:0.35rem 0 0;line-height:1.5">Déposez votre certificat pour soumettre votre demande à l'administrateur</p>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/?page=coach-request" enctype="multipart/form-data" id="formCoach" novalidate style="display:flex;flex-direction:column;gap:1rem">

      <!-- Zone drag & drop -->
      <div id="uploadZone"
           onclick="document.getElementById('coach-certificate').click()"
           style="border:2px dashed var(--border);border-radius:0.875rem;padding:1.5rem;text-align:center;cursor:pointer;transition:all 0.2s"
           onmouseover="this.style.borderColor='#7c3aed';this.style.background='rgba(124,58,237,0.03)'"
           onmouseout="if(!window._certSelected){this.style.borderColor='var(--border)';this.style.background='transparent'}">
        <i data-lucide="upload-cloud" id="uploadIcon" style="width:2rem;height:2rem;color:var(--text-muted);display:block;margin:0 auto 0.5rem"></i>
        <p id="uploadLabel" style="font-size:0.825rem;font-weight:600;color:var(--text-primary);margin:0">Cliquez pour uploader</p>
        <p id="uploadSub" style="font-size:0.72rem;color:var(--text-muted);margin:0.25rem 0 0">PDF, JPG, PNG — Max 5MB</p>
        <input type="file" name="certificate" id="coach-certificate" accept=".pdf,image/*"
               style="display:none"
               onchange="handleFileSelect(this)">
      </div>
      <span id="err-coach-cert" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:-8px"></span>

      <!-- Info -->
      <div style="background:var(--surface);border:1px solid var(--border);border-radius:0.75rem;padding:0.75rem;font-size:0.78rem;color:var(--text-secondary);display:flex;align-items:flex-start;gap:0.5rem">
        <i data-lucide="info" style="width:0.875rem;height:0.875rem;flex-shrink:0;margin-top:1px;color:#d97706"></i>
        Votre demande sera examinée par un administrateur. Vous serez notifié une fois la décision prise.
      </div>

      <div style="display:flex;gap:0.75rem;margin-top:0.25rem">
        <button type="button" onclick="closeCoachModal()" class="btn btn-outline" style="flex:1;border-radius:0.875rem;padding:0.75rem">Annuler</button>
        <button type="submit" class="btn" style="flex:1;border-radius:0.875rem;padding:0.75rem;background:linear-gradient(135deg,#7c3aed,#6d28d9);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;font-weight:600">
          <i data-lucide="send" style="width:0.875rem;height:0.875rem"></i> Envoyer
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ================================================
     MODAL MODIFIER PROFIL
================================================ -->
<div id="modalProfile" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:9999;align-items:center;justify-content:center">
  <div style="background:var(--background);border-radius:1.25rem;padding:2rem;width:100%;max-width:24rem;box-shadow:0 30px 60px rgba(0,0,0,0.2);position:relative">

    <button onclick="closeProfileModal()" style="position:absolute;top:1rem;right:1rem;background:none;border:none;cursor:pointer;color:var(--text-muted);width:1.75rem;height:1.75rem;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s"
            onmouseover="this.style.background='var(--surface)'"
            onmouseout="this.style.background='none'">
      <i data-lucide="x" style="width:1rem;height:1rem"></i>
    </button>

    <h3 style="font-family:var(--font-heading);font-size:1.125rem;font-weight:700;color:var(--text-primary);margin:0 0 1.5rem">Modifier le profil</h3>

    <form method="POST" action="<?= BASE_URL ?>/?page=update-profile" enctype="multipart/form-data" id="formProfile" novalidate style="display:flex;flex-direction:column;gap:1rem">

      <!-- Avatar -->
      <div style="display:flex;align-items:center;gap:1rem;padding-bottom:1rem;border-bottom:1px solid var(--border)">
        <div style="position:relative">
          <div id="profileAvatarPreview"
               style="width:3.5rem;height:3.5rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;overflow:hidden;border:2px solid var(--border)">
            <?php if (!empty($_SESSION['avatar'])): ?>
              <img src="<?= BASE_URL ?>/assets/images/avatars/<?= htmlspecialchars($_SESSION['avatar']) ?>"
                   style="width:100%;height:100%;object-fit:cover">
            <?php else: ?>
              <span style="color:#fff;font-weight:700;font-size:1.125rem">
                <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
              </span>
            <?php endif; ?>
          </div>
          <!-- Bouton éditer avatar -->
          <button type="button" onclick="document.getElementById('profile-avatar').click()"
                  style="position:absolute;bottom:-2px;right:-2px;width:1.25rem;height:1.25rem;border-radius:50%;background:#7c3aed;border:2px solid var(--background);display:flex;align-items:center;justify-content:center;cursor:pointer">
            <i data-lucide="pencil" style="width:0.55rem;height:0.55rem;color:#fff"></i>
          </button>
          <input type="file" name="avatar" id="profile-avatar" accept="image/*"
                 style="display:none" onchange="previewAvatar(this)">
        </div>
        <div>
          <p style="font-size:0.875rem;font-weight:600;color:var(--text-primary);margin:0">
            <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
          </p>
          <button type="button" onclick="document.getElementById('profile-avatar').click()"
                  style="font-size:0.72rem;color:#7c3aed;background:none;border:none;cursor:pointer;padding:0;margin-top:2px;font-weight:600">
            Changer la photo
          </button>
          <span id="err-profile-avatar" style="color:#dc2626;font-size:0.72rem;display:none;margin-left:4px"></span>
        </div>
      </div>

      <!-- Username -->
      <div>
        <label style="font-size:0.78rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.35rem">Nom d'utilisateur</label>
        <input type="text" name="username" id="profile-username" class="form-input"
               value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>"
               style="width:100%;padding:0.75rem 1rem;border-radius:0.875rem">
        <span id="err-profile-username" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>

      <!-- Email -->
      <div>
        <label style="font-size:0.78rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.35rem">Adresse email</label>
        <input type="email" name="email" id="profile-email" class="form-input"
               value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>"
               style="width:100%;padding:0.75rem 1rem;border-radius:0.875rem">
        <span id="err-profile-email" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>

      <!-- Nouveau mot de passe -->
      <div>
        <label style="font-size:0.78rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.35rem">
          Nouveau mot de passe
          <span style="color:var(--text-muted);font-weight:400">(optionnel)</span>
        </label>
        <div style="position:relative">
          <input type="password" name="new_password" id="profile-password" class="form-input"
                 placeholder="Laisser vide pour ne pas changer"
                 style="width:100%;padding:0.75rem 3rem 0.75rem 1rem;border-radius:0.875rem">
          <button type="button" onclick="toggleProfilePwd()"
                  style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted)">
            <i data-lucide="eye" id="profilePwdIcon" style="width:1rem;height:1rem"></i>
          </button>
        </div>
        <span id="err-profile-password" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>

      <!-- Face ID Setup -->
      <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem;border-radius:0.875rem;background:var(--surface);border:1px solid var(--border);margin-top:0.5rem">
        <div style="display:flex;align-items:center;gap:0.75rem">
          <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:linear-gradient(135deg,#dcfce7,#f0fdf4);display:flex;align-items:center;justify-content:center;color:var(--primary)">
            <i data-lucide="scan-face" style="width:1.25rem;height:1.25rem"></i>
          </div>
          <div>
            <h4 style="font-size:0.875rem;font-weight:600;color:var(--text-primary);margin:0">Face ID</h4>
            <p style="font-size:0.75rem;color:var(--text-muted);margin:0">Connexion biométrique</p>
          </div>
        </div>
        <a href="<?= BASE_URL ?>/?page=face-register" class="btn btn-outline" style="padding:0.4rem 0.8rem;font-size:0.75rem;border-radius:var(--radius-full);text-decoration:none">Configurer</a>
      </div>

      <!-- Confirm mot de passe -->
      <div id="confirmPwdWrap" style="display:none">
        <label style="font-size:0.78rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:0.35rem">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" id="profile-confirm" class="form-input"
               placeholder="Retapez le nouveau mot de passe"
               style="width:100%;padding:0.75rem 1rem;border-radius:0.875rem">
        <span id="err-profile-confirm" style="color:#dc2626;font-size:0.75rem;display:none;margin-top:4px"></span>
      </div>

      <div style="display:flex;gap:0.75rem;margin-top:0.25rem">
        <button type="button" onclick="closeProfileModal()" class="btn btn-outline" style="flex:1;border-radius:0.875rem;padding:0.75rem">Annuler</button>
        <button type="submit" class="btn btn-primary" style="flex:1;border-radius:0.875rem;padding:0.75rem;display:flex;align-items:center;justify-content:center;gap:0.5rem">
          <i data-lucide="save" style="width:0.875rem;height:0.875rem"></i> Enregistrer
        </button>
      </div>
    </form>
  </div>
</div>

<style>
@keyframes fadeUp {
  from { opacity:0; transform:translateY(16px); }
  to   { opacity:1; transform:translateY(0); }
}
</style>

<script>
  // ==================== MODAL COACH ====================
  function openCoachModal() {
    document.getElementById('modalCoach').style.display = 'flex';
    if(typeof lucide !== 'undefined') lucide.createIcons();
  }
  function closeCoachModal() {
    document.getElementById('modalCoach').style.display = 'none';
    window._certSelected = false;
    document.getElementById('uploadZone').style.borderColor   = 'var(--border)';
    document.getElementById('uploadZone').style.background    = 'transparent';
    document.getElementById('uploadLabel').textContent        = 'Cliquez pour uploader';
    document.getElementById('uploadSub').textContent          = 'PDF, JPG, PNG — Max 5MB';
    document.getElementById('err-coach-cert').style.display  = 'none';
    document.getElementById('formCoach').reset();
  }
  document.getElementById('modalCoach')?.addEventListener('click', function(e) {
    if (e.target === this) closeCoachModal();
  });

  function handleFileSelect(input) {
    const file = input.files[0];
    const err  = document.getElementById('err-coach-cert');
    err.style.display = 'none';

    if (!file) return;
    const allowed = ['application/pdf','image/jpeg','image/png','image/webp'];
    if (!allowed.includes(file.type)) {
      err.textContent = 'Format non supporté (PDF, JPG, PNG).';
      err.style.display = 'block';
      input.value = '';
      window._certSelected = false;
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      err.textContent = 'Fichier trop lourd (max 5MB).';
      err.style.display = 'block';
      input.value = '';
      window._certSelected = false;
      return;
    }
    window._certSelected = true;
    document.getElementById('uploadLabel').textContent = '✓ ' + file.name;
    document.getElementById('uploadSub').textContent   = (file.size / 1024).toFixed(0) + ' KB';
    document.getElementById('uploadZone').style.borderColor = '#7c3aed';
    document.getElementById('uploadZone').style.background  = 'rgba(124,58,237,0.05)';
  }

  document.getElementById('formCoach')?.addEventListener('submit', function(e) {
    const cert = document.getElementById('coach-certificate').files[0];
    const err  = document.getElementById('err-coach-cert');
    err.style.display = 'none';
    if (!cert) {
      err.textContent = 'Le certificat est obligatoire.';
      err.style.display = 'block';
      e.preventDefault();
    }
  });

  // ==================== MODAL PROFIL ====================
  function openProfileModal() {
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
    document.getElementById('modalProfile').style.display = 'flex';
    if(typeof lucide !== 'undefined') lucide.createIcons();
    <?php endif; ?>
  }
  function closeProfileModal() {
    document.getElementById('modalProfile').style.display = 'none';
    document.getElementById('err-profile-username').style.display = 'none';
    document.getElementById('err-profile-email').style.display    = 'none';
    document.getElementById('err-profile-password').style.display = 'none';
    document.getElementById('err-profile-confirm').style.display  = 'none';
    document.getElementById('confirmPwdWrap').style.display        = 'none';
    document.getElementById('profile-password').value             = '';
    document.getElementById('profile-confirm').value              = '';
  }
  document.getElementById('modalProfile')?.addEventListener('click', function(e) {
    if (e.target === this) closeProfileModal();
  });

  document.getElementById('profile-password')?.addEventListener('input', function() {
    document.getElementById('confirmPwdWrap').style.display = this.value ? 'block' : 'none';
    if (!this.value) {
      document.getElementById('err-profile-confirm').style.display = 'none';
    }
  });

  function toggleProfilePwd() {
    const inp  = document.getElementById('profile-password');
    const icon = document.getElementById('profilePwdIcon');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.setAttribute('data-lucide', inp.type === 'password' ? 'eye' : 'eye-off');
    if(typeof lucide !== 'undefined') lucide.createIcons();
  }

  function previewAvatar(input) {
    const file = input.files[0];
    const err  = document.getElementById('err-profile-avatar');
    err.style.display = 'none';
    if (!file) return;
    const allowed = ['image/jpeg','image/png','image/webp','image/gif'];
    if (!allowed.includes(file.type)) {
      err.textContent = 'Format non supporté.'; err.style.display = 'inline'; return;
    }
    if (file.size > 2 * 1024 * 1024) {
      err.textContent = 'Max 2MB.'; err.style.display = 'inline'; return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview = document.getElementById('profileAvatarPreview');
      preview.innerHTML = '<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
    };
    reader.readAsDataURL(file);
  }

  document.getElementById('formProfile')?.addEventListener('submit', function(e) {
    let valid = true;
    ['profile-username','profile-email','profile-password','profile-confirm'].forEach(id => {
      const el = document.getElementById('err-' + id);
      if (el) { el.textContent = ''; el.style.display = 'none'; }
      const inp = document.getElementById(id);
      if (inp) inp.style.borderColor = 'var(--border)';
    });

    const username = document.getElementById('profile-username').value.trim();
    const email    = document.getElementById('profile-email').value.trim();
    const password = document.getElementById('profile-password').value;
    const confirm  = document.getElementById('profile-confirm').value;

    if (!username) { showPErr('profile-username', "Le nom est obligatoire."); valid = false; }
    else if (username.length < 3) { showPErr('profile-username', "Minimum 3 caractères."); valid = false; }
    if (!email) { showPErr('profile-email', "L'email est obligatoire."); valid = false; }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showPErr('profile-email', "Email invalide."); valid = false; }
    if (password) {
      if (password.length < 8) { showPErr('profile-password', "Minimum 8 caractères."); valid = false; }
      else if (password !== confirm) { showPErr('profile-confirm', "Les mots de passe ne correspondent pas."); valid = false; }
    }
    if (!valid) e.preventDefault();
  });

  function showPErr(inputId, msg) {
    const err = document.getElementById('err-' + inputId);
    if (err) { err.textContent = msg; err.style.display = 'block'; }
    const inp = document.getElementById(inputId);
    if (inp) inp.style.borderColor = '#dc2626';
  }
</script>

<!-- ============================================================
     GREENBOT — Floating AI Chatbot
     ============================================================ -->
<style>
#greenbot-fab{position:fixed;bottom:2rem;right:2rem;z-index:9999;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,#2D6A4F,#52B788);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 8px 32px rgba(45,106,79,0.45);transition:all 0.3s;border:none}
#greenbot-fab:hover{transform:scale(1.1) rotate(-8deg);box-shadow:0 12px 40px rgba(45,106,79,0.55)}
#greenbot-panel{position:fixed;bottom:6.5rem;right:2rem;z-index:9998;width:380px;max-width:calc(100vw - 2rem);background:var(--card,#fff);border-radius:1.5rem;box-shadow:0 20px 60px rgba(0,0,0,0.18),0 0 0 1px rgba(45,106,79,0.08);display:none;flex-direction:column;overflow:hidden}
#greenbot-panel.open{display:flex;animation:botSlideIn 0.3s cubic-bezier(0.34,1.56,0.64,1)}
@keyframes botSlideIn{from{opacity:0;transform:translateY(20px) scale(0.95)}to{opacity:1;transform:none}}
#bot-header{background:linear-gradient(135deg,#2D6A4F,#52B788);padding:1rem 1.25rem;display:flex;align-items:center;gap:0.75rem;color:#fff}
#bot-header .bot-avatar{width:2.5rem;height:2.5rem;background:rgba(255,255,255,0.18);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
#bot-header .bot-info h4{font-weight:700;font-size:0.95rem;margin:0}
#bot-header .bot-info p{font-size:0.72rem;opacity:0.85;margin:0}
.bot-status{width:0.55rem;height:0.55rem;background:#4ade80;border-radius:50%;display:inline-block;margin-left:0.35rem;box-shadow:0 0 6px #4ade80}
#bot-close{margin-left:auto;background:rgba(255,255,255,0.15);border:none;color:#fff;width:2rem;height:2rem;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;font-size:0.9rem}
#bot-close:hover{background:rgba(255,255,255,0.25)}
#bot-messages{flex:1;overflow-y:auto;padding:1rem;display:flex;flex-direction:column;gap:0.625rem;max-height:340px;min-height:200px;background:var(--muted,#f8faf8)}
.bot-msg{display:flex;gap:0.5rem;align-items:flex-end}
.bot-msg.user{flex-direction:row-reverse;align-self:flex-end;max-width:90%}
.bot-msg.bot{max-width:92%}
.bot-msg .bubble{padding:0.625rem 0.875rem;border-radius:1rem;font-size:0.82rem;line-height:1.55}
.bot-msg.bot .bubble{background:#fff;color:#1a1a1a;border-bottom-left-radius:0.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.06);border:1px solid #e5e7eb;max-width:280px}
.bot-msg.user .bubble{background:linear-gradient(135deg,#2D6A4F,#52B788);color:#fff;border-bottom-right-radius:0.25rem;max-width:240px}
.bot-msg .bot-avatar-sm{width:1.75rem;height:1.75rem;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.8rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4)}
.bot-typing{display:flex;gap:0.3rem;align-items:center;padding:0.25rem 0}
.bot-typing span{width:0.4rem;height:0.4rem;background:#52B788;border-radius:50%;animation:botBounce 1.2s infinite}
.bot-typing span:nth-child(2){animation-delay:0.2s}.bot-typing span:nth-child(3){animation-delay:0.4s}
@keyframes botBounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
#bot-input-area{padding:0.75rem;border-top:1px solid #e5e7eb;display:flex;gap:0.5rem;align-items:flex-end;background:#fff}
#bot-input{flex:1;border:1.5px solid #e5e7eb;border-radius:0.875rem;padding:0.5rem 0.875rem;font-size:0.82rem;outline:none;resize:none;font-family:inherit;max-height:80px;transition:border-color 0.2s;background:#f9fafb}
#bot-input:focus{border-color:#52B788}
#bot-send{width:2.25rem;height:2.25rem;background:linear-gradient(135deg,#2D6A4F,#52B788);color:#fff;border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all 0.2s}
#bot-send:hover{transform:scale(1.1);box-shadow:0 4px 12px rgba(45,106,79,0.35)}
#bot-send:disabled{opacity:0.5;cursor:not-allowed;transform:none}
.bot-quick-actions{display:flex;gap:0.35rem;flex-wrap:wrap;padding:0.5rem 0.875rem;background:#fff;border-bottom:1px solid #f0f0f0}
.bot-quick-btn{padding:0.22rem 0.6rem;background:rgba(82,183,136,0.1);border:1px solid rgba(82,183,136,0.25);border-radius:999px;font-size:0.7rem;color:#2D6A4F;cursor:pointer;white-space:nowrap;transition:all 0.2s}
.bot-quick-btn:hover{background:rgba(82,183,136,0.22)}
.bubble strong{font-weight:700}.bubble em{font-style:italic}.bubble ul{margin:0.25rem 0 0 1rem;padding:0}.bubble li{margin-bottom:0.15rem}
@keyframes botFabPulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.4);opacity:0.6}}

/* Dark Mode Overrides for GreenBot */
[data-theme="dark"] #greenbot-panel { background: #1e293b; box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.1); }
[data-theme="dark"] #bot-messages { background: #0f172a; }
[data-theme="dark"] .bot-msg.bot .bubble { background: #1e293b; color: #f8fafc; border-color: rgba(255,255,255,0.1); box-shadow: 0 2px 8px rgba(0,0,0,0.3); }
[data-theme="dark"] .bot-quick-actions { background: #1e293b; border-bottom-color: rgba(255,255,255,0.05); }
[data-theme="dark"] .bot-quick-btn { background: rgba(82,183,136,0.15); color: #a7f3d0; border-color: rgba(82,183,136,0.3); }
[data-theme="dark"] .bot-quick-btn:hover { background: rgba(82,183,136,0.25); }
[data-theme="dark"] #bot-input-area { background: #1e293b; border-top-color: rgba(255,255,255,0.05); }
[data-theme="dark"] #bot-input { background: #0f172a; border-color: rgba(255,255,255,0.1); color: #f8fafc; }
[data-theme="dark"] #bot-input:focus { border-color: #52B788; }
</style>

<!-- FAB -->
<button id="greenbot-fab" onclick="toggleGreenBot()">
  <svg id="fab-chat-icon" style="width:1.5rem;height:1.5rem;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
  <svg id="fab-close-icon" style="width:1.5rem;height:1.5rem;fill:none;stroke:#fff;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;display:none" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  <span style="position:absolute;top:-3px;right:-3px;width:0.9rem;height:0.9rem;background:#22c55e;border-radius:50%;border:2px solid #fff;animation:botFabPulse 2s infinite"></span>
</button>

<!-- Panel -->
<div id="greenbot-panel">
  <div id="bot-header">
    <div class="bot-avatar">🌿</div>
    <div class="bot-info">
      <h4><span style="color:#52B788;font-weight:800">Green</span><span style="font-weight:800;color:inherit">Bot</span> <span class="bot-status"></span></h4>
      <p>Assistant IA • <span style="color:#52B788;font-weight:bold">Green</span><span style="font-weight:bold;color:inherit">Bite</span></p>
    </div>
    <button id="bot-close" onclick="toggleGreenBot()">✕</button>
  </div>

  <div class="bot-quick-actions">
    <span class="bot-quick-btn" onclick="gbSendQuick('Crée un régime perte de poids 7 jours')">🔥 Régime -poids</span>
    <span class="bot-quick-btn" onclick="gbSendQuick('J\'ai des œufs et du riz à la maison, fais-moi un repas')">🍳 Repas maison</span>
    <span class="bot-quick-btn" onclick="gbSendQuick('Combien de calories par jour pour maigrir ?')">📊 Calories</span>
    <span class="bot-quick-btn" onclick="gbSendQuick('Programme sportif pour compléter un régime')">💪 Sport</span>
  </div>

  <div id="bot-messages">
    <div class="bot-msg bot">
      <div class="bot-avatar-sm">🌿</div>
      <div class="bubble">Bonjour ! 👋 Je suis <strong><span style="color:#52B788">Green</span>Bot</strong>, votre assistant nutrition IA.<br><br>Créez des régimes, trouvez des recettes avec vos ingrédients, ou posez-moi n'importe quelle question sur <strong><span style="color:#52B788">Green</span>Bite</strong> !</div>
    </div>
  </div>

  <div id="bot-input-area">
    <textarea id="bot-input" placeholder="Posez votre question..." rows="1" onkeydown="gbKeydown(event)" oninput="gbResize(this)"></textarea>
    <button id="bot-send" onclick="gbSend()">
      <svg style="width:1rem;height:1rem;fill:none;stroke:#fff;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
    </button>
  </div>
</div>

<script>
const GB_PROXY = '<?= BASE_URL ?>/ai-proxy.php';
let gbOpen = false, gbHistory = [], gbBusy = false;

function toggleGreenBot() {
  gbOpen = !gbOpen;
  document.getElementById('greenbot-panel').classList.toggle('open', gbOpen);
  document.getElementById('fab-chat-icon').style.display = gbOpen ? 'none' : 'block';
  document.getElementById('fab-close-icon').style.display = gbOpen ? 'block' : 'none';
  if (gbOpen) { gbScrollBottom(); document.getElementById('bot-input').focus(); }
}

function gbScrollBottom() { const m = document.getElementById('bot-messages'); setTimeout(() => m.scrollTop = m.scrollHeight, 60); }
function gbResize(el) { el.style.height='auto'; el.style.height=Math.min(el.scrollHeight,80)+'px'; }
function gbKeydown(e) { if(e.key==='Enter'&&!e.shiftKey){e.preventDefault();gbSend();} }
function gbSendQuick(msg) { document.getElementById('bot-input').value=msg; gbSend(); if(!gbOpen) toggleGreenBot(); }

function gbAddMsg(role, text) {
  const msgs = document.getElementById('bot-messages');
  const d = document.createElement('div');
  d.className = 'bot-msg '+role;
  const av = role==='bot'?'🌿':'👤';
  const html = role==='bot' ? gbMarkdown(text) : gbEscape(text);
  d.innerHTML = `<div class="bot-avatar-sm">${av}</div><div class="bubble">${html}</div>`;
  msgs.appendChild(d);
  gbScrollBottom();
}

function gbShowTyping() {
  const msgs = document.getElementById('bot-messages');
  const d = document.createElement('div');
  d.id='gb-typing'; d.className='bot-msg bot';
  d.innerHTML='<div class="bot-avatar-sm">🌿</div><div class="bubble"><div class="bot-typing"><span></span><span></span><span></span></div></div>';
  msgs.appendChild(d); gbScrollBottom();
}

function gbMarkdown(t) {
  return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
    .replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>').replace(/\*(.+?)\*/g,'<em>$1</em>')
    .replace(/^#{1,3} (.+)$/gm,'<strong>$1</strong>')
    .replace(/^[-•] (.+)$/gm,'<li>$1</li>').replace(/((<li>.*?<\/li>\s*)+)/gs,'<ul>$1</ul>')
    .replace(/\n/g,'<br>');
}
function gbEscape(t){return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}

async function gbSend() {
  const inp = document.getElementById('bot-input');
  const txt = inp.value.trim();
  if(!txt || gbBusy) return;
  inp.value=''; inp.style.height='auto';
  gbAddMsg('user', txt);
  gbHistory.push({role:'user',content:txt});
  gbBusy=true; document.getElementById('bot-send').disabled=true;
  gbShowTyping();
  try {
    const r = await fetch(GB_PROXY,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({type:'chat',messages:gbHistory})});
    const d = await r.json();
    document.getElementById('gb-typing')?.remove();
    if (d.error) {
      if (d.details) console.warn('GreenBot errors:', d.details);
      if (d.rate_limit) {
        // Show countdown + retry button
        const msgEl = gbAddMsg('bot', '⏳ ' + d.error);
        let secs = 30;
        const retryBtn = document.createElement('button');
        retryBtn.textContent = `Réessayer (${secs}s)`;
        retryBtn.style.cssText = 'margin-top:0.5rem;padding:0.3rem 0.8rem;background:linear-gradient(135deg,#52B788,#2D6A4F);color:#fff;border:none;border-radius:999px;font-size:0.75rem;font-weight:700;cursor:pointer;display:block';
        retryBtn.disabled = true;
        msgEl.appendChild(retryBtn);
        const cd = setInterval(() => {
          secs--;
          retryBtn.textContent = secs > 0 ? `Réessayer (${secs}s)` : 'Réessayer maintenant';
          if (secs <= 0) { retryBtn.disabled = false; clearInterval(cd); }
        }, 1000);
        retryBtn.onclick = () => { retryBtn.remove(); gbSend(); };
      } else {
        gbAddMsg('bot', '❌ ' + d.error);
      }
    } else {
      gbAddMsg('bot', d.reply);
      gbHistory.push({role:'assistant',content:d.reply});
      if(gbHistory.length>20) gbHistory=gbHistory.slice(-20);
    }
  } catch(e) {
    document.getElementById('gb-typing')?.remove();
    gbAddMsg('bot','❌ Problème de connexion. Réessayez.');
  }
  gbBusy=false; document.getElementById('bot-send').disabled=false;
  document.getElementById('bot-input').focus();
}
</script>

