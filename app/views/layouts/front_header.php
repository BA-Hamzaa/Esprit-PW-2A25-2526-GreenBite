<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="GreenBite — Alimentation Durable & Nutrition Intelligente">
  <title>GreenBite</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
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
          <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.18);box-shadow:0 4px 12px rgba(0,0,0,0.15);flex-shrink:0">
            <i data-lucide="leaf" style="width:1.35rem;height:1.35rem;color:#a7f3d0"></i>
          </div>
          <span style="margin-left:0.75rem;font-family:var(--font-heading);font-size:1.35rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;text-shadow:0 2px 4px rgba(0,0,0,0.1)">GreenBite</span>
        </a>

        <span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.58rem;font-weight:700">Espace Utilisateur</span>
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
            <a href="<?= BASE_URL ?>/?page=nutrition" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="utensils-crossed"></i><span>Mes Repas</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'plan') !== false) ? 'active' : '' ?>">
              <i data-lucide="clipboard-list"></i><span>Mes Plans</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && $_GET['action'] === 'add') ? 'active' : '' ?>">
              <i data-lucide="plus-circle"></i><span>Ajouter Repas</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'regime') !== false) ? 'active' : '' ?>">
              <i data-lucide="salad"></i><span>Régimes</span>
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
            <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && isset($_GET['action']) && $_GET['action'] === 'order') ? 'active' : '' ?>">
              <i data-lucide="shopping-cart"></i><span>Commander</span>
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
            <a href="<?= BASE_URL ?>/?page=article&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'article') ? 'active' : '' ?>">
              <i data-lucide="newspaper"></i><span>Communauté & Blog</span>
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
        <a href="<?= BASE_URL ?>/?page=admin-stats" class="sidebar-nav-item" style="margin-top:4px">
          <i data-lucide="settings"></i><span>Administration</span>
        </a>
        <a href="<?= BASE_URL ?>/?page=login" class="sidebar-nav-item" style="margin-top:4px">
          <i data-lucide="log-in"></i><span>Se connecter</span>
        </a>
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
          <div class="front-topbar-search" style="position:relative;">
            <i data-lucide="search" style="width:0.875rem;height:0.875rem;color:var(--text-muted);position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);pointer-events:none;z-index:2;"></i>
            <input type="text" id="globalSearchInput" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher..." style="width:13rem;padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1.5px solid var(--border);border-radius:var(--radius-full);font-size:0.8rem;background:var(--surface);color:var(--foreground);transition:all 0.3s;outline:none" onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)';this.style.width='17rem'" onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';this.style.width='13rem'">
          </div>

          <!-- Divider -->
          <div style="width:1px;height:1.5rem;background:var(--border)"></div>

          <!-- Notifications -->
          <button style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:var(--radius-full);border:1.5px solid var(--border);background:var(--surface);cursor:pointer;transition:all 0.3s;color:var(--text-secondary);position:relative" onmouseover="this.style.borderColor='var(--secondary)';this.style.background='rgba(82,183,136,0.06)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface)';this.style.color='var(--text-secondary)'" title="Notifications">
            <i data-lucide="bell" style="width:0.95rem;height:0.95rem"></i>
            <span style="position:absolute;top:0;right:0;width:8px;height:8px;background:linear-gradient(135deg,var(--accent-orange),#f97316);border-radius:50%;border:2px solid var(--card)"></span>
          </button>

          <!-- User -->
          <div style="display:flex;align-items:center;gap:0.5rem;padding:0.3rem 0.75rem 0.3rem 0.3rem;border-radius:var(--radius-full);background:var(--surface);border:1.5px solid var(--border);cursor:pointer;transition:all 0.3s" onmouseover="this.style.borderColor='var(--secondary)';this.style.background='rgba(82,183,136,0.04)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface)'">
            <div style="width:1.85rem;height:1.85rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(45,106,79,0.25)">
              <i data-lucide="user" style="width:0.9rem;height:0.9rem;color:#fff"></i>
            </div>
            <span style="font-size:0.8rem;font-weight:600;color:var(--text-primary)">Utilisateur</span>
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