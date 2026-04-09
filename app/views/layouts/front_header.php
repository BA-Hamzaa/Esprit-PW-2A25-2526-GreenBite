<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NutriGreen — Alimentation Durable & Nutrition Intelligente">
  <title>NutriGreen</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
<script>if (localStorage.getItem('theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark');</script>

  <div id="app-loader" class="app-loader">
    <div class="app-loader-card">
      <div class="app-loader-icon"><span>🌱</span></div>
      <div class="app-loader-title">NutriGreen</div>
      <div class="app-loader-subtitle">Préparation de votre espace sain et durable…</div>
      <div class="app-loader-ring"></div>
    </div>
  </div>

  <div class="page-with-sidebar">
    <!-- ===== SIDEBAR FRONTOFFICE ===== -->
    <nav class="admin-sidebar front-sidebar">
      <div class="sidebar-logo" style="border-bottom:1px solid rgba(255,255,255,0.06);padding:1.25rem 1.5rem">
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 text-white mb-2">
          <span style="font-size:1.4rem;filter:drop-shadow(0 2px 6px rgba(82,183,136,0.4))">🌱</span>
          <span class="logo-text" style="background:linear-gradient(90deg,#ffffff,#a7f3d0);-webkit-background-clip:text;-webkit-text-fill-color:transparent">NutriGreen</span>
        </a>
        <span class="text-xs" style="color:rgba(255,255,255,0.25);letter-spacing:0.15em;text-transform:uppercase;font-weight:600;font-size:0.6rem">Espace Utilisateur</span>
      </div>

      <div class="sidebar-nav" style="padding:1rem 0.75rem">
        <!-- Accueil -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Navigation</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/" class="sidebar-nav-item <?= (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : '' ?>"><i data-lucide="home"></i><span>Accueil</span></a></li>
        </ul>

        <!-- Nutrition -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Suivi Nutritionnel</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=nutrition" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>"><i data-lucide="utensils-crossed"></i><span>Mes Repas</span></a></li>
          <li><a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && $_GET['action'] === 'add') ? 'active' : '' ?>"><i data-lucide="plus-circle"></i><span>Ajouter Repas</span></a></li>
        </ul>

        <!-- Marketplace -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Marketplace</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=marketplace" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>"><i data-lucide="shopping-basket"></i><span>Produits</span></a></li>
          <li><a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && isset($_GET['action']) && $_GET['action'] === 'order') ? 'active' : '' ?>"><i data-lucide="shopping-cart"></i><span>Commander</span></a></li>
        </ul>

        <!-- Recettes -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Recettes Durables</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=recettes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes') ? 'active' : '' ?>"><i data-lucide="book-open"></i><span>Explorer</span></a></li>
        </ul>

        <!-- Communauté -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Social</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=community" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'community') ? 'active' : '' ?>"><i data-lucide="message-circle"></i><span>Communauté & Blog</span></a></li>
        </ul>
      </div>

      <div class="sidebar-footer" style="border-top:1px solid rgba(255,255,255,0.06);padding:0.75rem">
        <button class="admin-dark-toggle" onclick="toggleDarkMode()" id="frontDarkBtn">
          <i data-lucide="moon" id="frontDarkLucide"></i>
          <span id="frontDarkLabel">Mode sombre</span>
        </button>
        <a href="<?= BASE_URL ?>/?page=admin-stats" class="sidebar-nav-item" style="margin-top:4px"><i data-lucide="settings"></i><span>Administration</span></a>
        <a href="<?= BASE_URL ?>/?page=login" class="sidebar-nav-item" style="margin-top:4px"><i data-lucide="log-in"></i><span>Se connecter</span></a>
      </div>
    </nav>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <div class="page-content-admin">
      <!-- Top Navbar -->
      <div class="front-topbar">
        <div class="flex items-center gap-3">
          <div class="front-topbar-greeting">
            <h2 style="font-family:var(--font-heading);font-size:1.125rem;font-weight:700;color:var(--text-primary);line-height:1.2">
              <?php
                $hour = (int)date('H');
                if ($hour < 12) echo 'Bonjour ☀️';
                elseif ($hour < 18) echo 'Bon après-midi 🌤️';
                else echo 'Bonsoir 🌙';
              ?>
            </h2>
            <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px"><?= date('l d F Y') ?></p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="front-topbar-search">
            <i data-lucide="search" style="width:1rem;height:1rem;color:var(--text-muted);position:absolute;left:0.75rem;top:50%;transform:translateY(-50%)"></i>
            <input type="text" placeholder="Rechercher..." style="width:14rem;padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.8rem;background:var(--surface);color:var(--foreground);transition:all 0.3s" onfocus="this.style.borderColor='var(--secondary)';this.style.width='18rem'" onblur="this.style.borderColor='var(--border)';this.style.width='14rem'">
          </div>
          <div style="width:1px;height:1.5rem;background:var(--border)"></div>
          <button style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:var(--radius-full);border:1px solid var(--border);background:var(--surface);cursor:pointer;transition:all 0.3s;color:var(--text-secondary)" onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'" title="Notifications">
            <i data-lucide="bell" style="width:1rem;height:1rem"></i>
          </button>
          <div style="display:flex;align-items:center;gap:0.5rem;padding:0.35rem 0.75rem 0.35rem 0.35rem;border-radius:var(--radius-full);background:var(--surface);border:1px solid var(--border);cursor:pointer;transition:all 0.3s" onmouseover="this.style.borderColor='var(--secondary)'" onmouseout="this.style.borderColor='var(--border)'">
            <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center">
              <i data-lucide="user" style="width:0.875rem;height:0.875rem;color:#fff"></i>
            </div>
            <span style="font-size:0.8rem;font-weight:600;color:var(--text-primary)">Utilisateur</span>
          </div>
        </div>
      </div>

      <!-- Flash Messages -->
      <div style="padding:0 2rem">
        <?php if (!empty($_SESSION['success'])): ?>
          <div class="p-4 rounded-xl mb-4 animate-fade-up flex items-center gap-3" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#166534;border:1px solid #bbf7d0;box-shadow:0 4px 15px rgba(22,101,52,0.08)">
            <i data-lucide="check-circle-2" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
          <div class="p-4 rounded-xl mb-4 animate-fade-up flex items-center gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5;box-shadow:0 4px 15px rgba(153,27,27,0.08)">
            <i data-lucide="alert-circle" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
      </div>
