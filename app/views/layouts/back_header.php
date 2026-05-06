<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NutriGreen — Administration">
  <title>NutriGreen Admin</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
<script>
  // Load dark mode from localStorage
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
  }
</script>

  <div class="page-with-sidebar">
    <!-- ===== SIDEBAR ADMIN ===== -->
    <nav class="admin-sidebar">
      <div class="sidebar-logo" style="border-bottom:1px solid rgba(255,255,255,0.06);padding:1.25rem 1.5rem">
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 text-white mb-2">
          <span style="font-size:1.4rem;filter:drop-shadow(0 2px 6px rgba(82,183,136,0.4))">🌱</span>
          <span class="logo-text" style="background:linear-gradient(90deg,#ffffff,#a7f3d0);-webkit-background-clip:text;-webkit-text-fill-color:transparent">NutriGreen</span>
        </a>
        <span class="text-xs" style="color:rgba(255,255,255,0.25);letter-spacing:0.15em;text-transform:uppercase;font-weight:600;font-size:0.6rem">Panneau Admin</span>
      </div>

      <div class="sidebar-nav" style="padding:1rem 0.75rem">
        <!-- Dashboard -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Vue d'ensemble</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=admin-stats" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-stats') ? 'active' : '' ?>"><i data-lucide="bar-chart-3"></i><span>Statistiques</span></a></li>
        </ul>

        <!-- Module Nutrition -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Suivi Nutritionnel</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=admin-nutrition&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-nutrition' && (!isset($_GET['action']) || in_array($_GET['action'], ['list','add','edit','delete']))) ? 'active' : '' ?>"><i data-lucide="utensils-crossed"></i><span>Repas</span></a></li>
          <li><a href="<?= BASE_URL ?>/?page=admin-nutrition&action=aliments" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'aliment') !== false) ? 'active' : '' ?>"><i data-lucide="apple"></i><span>Aliments</span></a></li>
        </ul>

        <!-- Module Marketplace -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Marketplace</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=admin-marketplace&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-marketplace' && (!isset($_GET['action']) || in_array($_GET['action'], ['list','add','edit','delete']))) ? 'active' : '' ?>"><i data-lucide="package"></i><span>Produits</span></a></li>
          <li><a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commandes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-marketplace' && isset($_GET['action']) && strpos($_GET['action'], 'commande') !== false) ? 'active' : '' ?>"><i data-lucide="shopping-bag"></i><span>Commandes</span></a></li>
        </ul>

        <!-- Module Recettes -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Recettes Durables</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=admin-recettes&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-recettes' && (!isset($_GET['action']) || in_array($_GET['action'], ['list','add','edit','delete']))) ? 'active' : '' ?>"><i data-lucide="chef-hat"></i><span>Recettes</span></a></li>
          <li><a href="<?= BASE_URL ?>/?page=admin-recettes&action=ingredients" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-recettes' && isset($_GET['action']) && strpos($_GET['action'], 'ingredient') !== false) ? 'active' : '' ?>"><i data-lucide="carrot"></i><span>Ingrédients</span></a></li>
        </ul>

        <!-- Module Communauté -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Social</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=admin-community" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-community') ? 'active' : '' ?>"><i data-lucide="message-circle"></i><span>Communauté & Blog</span></a></li>
        </ul>

        <!-- Gestion -->
        <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Gestion</span></div>
        <ul class="space-y-1 mb-6">
          <li><a href="<?= BASE_URL ?>/?page=admin-users" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-users') ? 'active' : '' ?>"><i data-lucide="users"></i><span>Utilisateurs</span></a></li>
        </ul>
      </div>

      <div class="sidebar-footer" style="border-top:1px solid rgba(255,255,255,0.06);padding:0.75rem">
        <button class="admin-dark-toggle" onclick="toggleDarkMode()" id="darkModeBtn">
          <i data-lucide="moon" id="darkIcon"></i>
          <span id="darkLabel">Mode sombre</span>
        </button>
        <a href="<?= BASE_URL ?>/?page=face-register" class="sidebar-nav-item" style="margin-top:4px">
          <i data-lucide="scan-face"></i><span>Face ID</span>
        </a>
        <a href="<?= BASE_URL ?>/" class="sidebar-nav-item" style="margin-top:4px"><i data-lucide="arrow-left"></i><span>Retour au site</span></a>
      </div>
    </nav>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <div class="page-content-admin">
      <!-- Messages flash -->
      <div style="padding:1.5rem 2rem 0">
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
