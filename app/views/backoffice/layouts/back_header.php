<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="GreenBite — Administration">
  <title>GreenBite Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <script src="<?= BASE_URL ?>/assets/js/validate.js"></script>
</head>
<body>
<script>
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
  }
</script>
<style>
/* Special Floating Sidebar UI */
body {
  background-color: #f8fafc;
}
[data-theme='dark'] body {
  background-color: #0f172a;
}
.admin-sidebar {
  position: fixed;
  top: 1.5rem;
  left: 1.5rem;
  bottom: 1.5rem;
  width: 260px;
  background: rgba(15, 23, 42, 0.95) !important;
  backdrop-filter: blur(16px);
  border-radius: 1.5rem;
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  z-index: 100;
}
[data-theme='dark'] .admin-sidebar {
  background: rgba(30, 41, 59, 0.85) !important;
  border-color: rgba(255, 255, 255, 0.05);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
}
.page-content-admin {
  margin-left: calc(260px + 3rem) !important;
  padding-top: 1.5rem;
  min-height: 100vh;
}
.sidebar-nav {
  flex: 1;
  overflow-y: auto;
}
.sidebar-nav::-webkit-scrollbar {
  width: 4px;
}
.sidebar-nav::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,0.1);
  border-radius: 10px;
}
.sidebar-section-label {
  color: rgba(255, 255, 255, 0.4) !important;
  font-size: 0.7rem !important;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 0.5rem;
  padding-left: 0.5rem;
}
.sidebar-nav-item {
  color: rgba(255, 255, 255, 0.7) !important;
  border-radius: 0.75rem !important;
  margin-bottom: 0.25rem !important;
  padding: 0.65rem 1rem !important;
  transition: all 0.3s ease !important;
}
.sidebar-nav-item:hover {
  background: rgba(255, 255, 255, 0.05) !important;
  color: #fff !important;
  transform: translateX(3px);
}
.sidebar-nav-item.active {
  background: linear-gradient(135deg, rgba(82,183,136,0.25), rgba(45,106,79,0.15)) !important;
  color: #a7f3d0 !important;
  border-left: 3px solid #52B788 !important;
  box-shadow: inset 0 0 20px rgba(82,183,136,0.05);
}
.sidebar-nav-item i {
  color: inherit !important;
}
.admin-logo-text {
  margin-left: 0.75rem;
  font-family: 'Poppins', sans-serif;
  font-size: 1.45rem;
  font-weight: 800;
  background: linear-gradient(135deg, #a7f3d0, #52B788);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: -0.01em;
}
</style>

  <div class="page-with-sidebar">
    <!-- ===== SIDEBAR ADMIN ===== -->
    <nav class="admin-sidebar">

      <!-- Logo -->
      <div style="border-bottom:1px solid rgba(255,255,255,0.06);padding:1.5rem 1.5rem 1.25rem;position:relative;z-index:1">
        <a href="<?= BASE_URL ?>/" style="display:flex;align-items:center;text-decoration:none;margin-bottom:0.4rem">
          <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.18);box-shadow:0 4px 12px rgba(0,0,0,0.15);flex-shrink:0">
            <i data-lucide="leaf" style="width:1.35rem;height:1.35rem;color:#a7f3d0"></i>
          </div>
          <span class="admin-logo-text">GreenBite</span>
        </a>

        <div style="display:flex;align-items:center;gap:0.4rem">
          <span style="display:inline-flex;align-items:center;justify-content:center;width:1.25rem;height:1.25rem;background:linear-gradient(135deg,var(--secondary),var(--primary));border-radius:4px">
            <i data-lucide="shield" style="width:0.65rem;height:0.65rem;color:#fff"></i>
          </span>
          <span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.58rem;font-weight:700">Panneau Admin</span>
        </div>
      </div>

      <!-- Navigation -->
      <div class="sidebar-nav" style="padding:1rem 0.75rem;position:relative;z-index:1">

        <!-- Dashboard -->
        <div class="sidebar-section-label" style="padding-top:0.25rem">Vue d'ensemble</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-stats" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-stats') ? 'active' : '' ?>">
              <i data-lucide="bar-chart-3"></i><span>Statistiques</span>
            </a>
          </li>
        </ul>

        <!-- Nutrition -->
        <div class="sidebar-section-label">Suivi Nutritionnel</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=regimes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'regime') !== false) ? 'active' : '' ?>">
              <i data-lucide="salad"></i><span>Régimes</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=plans" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'plan') !== false) ? 'active' : '' ?>">
              <i data-lucide="clipboard-list"></i><span>Plans</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-nutrition' && (!isset($_GET['action']) || in_array($_GET['action'], ['list','add','edit','delete']))) ? 'active' : '' ?>">
              <i data-lucide="utensils-crossed"></i><span>Repas</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=aliments" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'aliment') !== false) ? 'active' : '' ?>">
              <i data-lucide="apple"></i><span>Aliments</span>
            </a>
          </li>
        </ul>

        <!-- Marketplace -->
        <div class="sidebar-section-label">Marketplace</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-marketplace' && (!isset($_GET['action']) || in_array($_GET['action'], ['list','add','edit','delete']))) ? 'active' : '' ?>">
              <i data-lucide="package"></i><span>Produits</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commandes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-marketplace' && isset($_GET['action']) && strpos($_GET['action'], 'commande') !== false) ? 'active' : '' ?>">
              <i data-lucide="shopping-bag"></i><span>Commandes</span>
            </a>
          </li>
        </ul>

        <!-- Recettes -->
        <div class="sidebar-section-label">Recettes Durables</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-recettes&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-recettes' && (!isset($_GET['action']) || in_array($_GET['action'], ['list','add','edit','delete']))) ? 'active' : '' ?>">
              <i data-lucide="chef-hat"></i><span>Recettes</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-recettes&action=ingredients" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-recettes' && isset($_GET['action']) && strpos($_GET['action'], 'ingredient') !== false) ? 'active' : '' ?>">
              <i data-lucide="carrot"></i><span>Ingrédients</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-recettes&action=comments" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-recettes' && isset($_GET['action']) && strpos($_GET['action'], 'comment') !== false) ? 'active' : '' ?>">
              <i data-lucide="message-circle"></i><span>Commentaires</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-recettes&action=materiels" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-recettes' && isset($_GET['action']) && strpos($_GET['action'], 'materiel') !== false) ? 'active' : '' ?>">
              <i data-lucide="wrench"></i><span>Matériels</span>
            </a>
          </li>
        </ul>

        <!-- Communauté -->
        <div class="sidebar-section-label">Social</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-community" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-community') ? 'active' : '' ?>">
              <i data-lucide="message-circle"></i><span>Communauté & Blog</span>
            </a>
          </li>
        </ul>

        <!-- Gestion -->
        <div class="sidebar-section-label">Gestion</div>
        <ul class="space-y-1 mb-5">
          <li>
            <a href="<?= BASE_URL ?>/?page=admin-users" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'admin-users') ? 'active' : '' ?>">
              <i data-lucide="users"></i><span>Utilisateurs</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Footer -->
      <div style="border-top:1px solid rgba(255,255,255,0.06);padding:0.875rem;position:relative;z-index:1">
        <button class="admin-dark-toggle" onclick="toggleDarkMode()" id="darkModeBtn">
          <i data-lucide="moon" id="darkIcon"></i>
          <span id="darkLabel">Mode sombre</span>
        </button>
        <a href="<?= BASE_URL ?>/" class="sidebar-nav-item" style="margin-top:4px">
          <i data-lucide="arrow-left"></i><span>Retour au site</span>
        </a>
      </div>
    </nav>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <div class="page-content-admin">
      <!-- Messages flash -->
      <div style="padding:1.5rem 2rem 0">
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

