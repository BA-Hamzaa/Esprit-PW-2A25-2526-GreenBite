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
  <style>
    /* ===== CSS VARIABLES — Fresh GreenBite Palette ===== */
    :root {
      --primary: #2d6a4f;
      --primary-light: #40916c;
      --secondary: #52b788;
      --secondary-light: #95d5b2;
      --accent: #d8f3dc;
      --accent-warm: #fefae0;
      --accent-coral: #e76f51;
      --accent-orange: #f4a261;
      --accent-yellow: #e9c46a;
      --surface: #ffffff;
      --surface-alt: #f0fdf4;
      --text-primary: #1b4332;
      --text-secondary: #555b6e;
      --text-muted: #89b0ae;
      --border: #dce8e3;
      --card: #ffffff;
      --card-hover: #f8fdf9;
      --radius: 0.75rem;
      --radius-full: 999px;
      --font-body: 'Inter', system-ui, sans-serif;
      --font-heading: 'Poppins', 'Inter', system-ui, sans-serif;
      --shadow-sm: 0 1px 3px rgba(27,67,50,0.06);
      --shadow-md: 0 4px 16px rgba(27,67,50,0.08);
      --shadow-lg: 0 12px 32px rgba(27,67,50,0.12);
    }

    [data-theme="dark"] {
      --surface: #1a2e24;
      --surface-alt: #15261d;
      --text-primary: #e0f2e9;
      --text-secondary: #b7d7c5;
      --text-muted: #6b9080;
      --border: #2d4a3b;
      --card: #1f3529;
      --card-hover: #253d30;
    }

    /* ===== RESET & GLOBAL ===== */
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: var(--font-body);
      background: linear-gradient(180deg, #f0fdf4 0%, #f8fafc 40%, #ffffff 100%);
      color: var(--text-primary);
      min-height: 100vh;
    }

    /* ===== LAYOUT ===== */
    .page-with-sidebar {
      display: flex;
      min-height: 100vh;
    }

    .page-content-admin {
      flex: 1;
      margin-left: 260px;
      background: var(--surface-alt);
      min-height: 100vh;
      padding-bottom: 3rem;
    }

    /* ===== SIDEBAR ===== */
    .admin-sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100vh;
      background: linear-gradient(180deg, #1b4332 0%, #2d6a4f 40%, #40916c 100%);
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      z-index: 100;
      box-shadow: 4px 0 24px rgba(27,67,50,0.15);
    }

    .sidebar-section-label {
      color: rgba(255,255,255,0.4);
      text-transform: uppercase;
      letter-spacing: 0.12em;
      font-size: 0.625rem;
      font-weight: 700;
      padding: 0.5rem 1rem 0.35rem;
    }

    .sidebar-nav-item {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      padding: 0.55rem 1rem;
      border-radius: 0.6rem;
      color: rgba(255,255,255,0.72);
      text-decoration: none;
      font-size: 0.825rem;
      font-weight: 500;
      transition: all 0.2s ease;
      margin: 0 0.25rem;
    }
    .sidebar-nav-item:hover {
      background: rgba(255,255,255,0.1);
      color: #fff;
    }
    .sidebar-nav-item.active {
      background: rgba(255,255,255,0.16);
      color: #fff;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* ===== TOPBAR ===== */
    .front-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 2rem;
      background: rgba(255,255,255,0.7);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 50;
    }

    /* ===== CARDS ===== */
    .card {
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
      transition: all 0.3s ease;
      border: 1px solid transparent;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lg);
      border-color: var(--secondary-light);
      background: var(--card-hover);
    }

    /* ===== BUTTONS ===== */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.5rem 1.1rem;
      border-radius: var(--radius-full);
      font-weight: 600;
      font-size: 0.825rem;
      cursor: pointer;
      border: 1.5px solid transparent;
      text-decoration: none;
      transition: all 0.25s ease;
      font-family: var(--font-body);
    }
    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-light));
      color: #fff;
      border: none;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #1b4332, var(--primary));
      box-shadow: 0 6px 20px rgba(45,106,79,0.3);
      transform: translateY(-1px);
    }
    .btn-outline {
      background: transparent;
      border-color: var(--border);
      color: var(--text-secondary);
    }
    .btn-outline:hover {
      border-color: var(--secondary);
      color: var(--primary);
      background: var(--accent);
    }

    /* ===== INPUTS ===== */
    .input {
      width: 100%;
      padding: 0.65rem 1rem;
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      font-size: 0.875rem;
      font-family: var(--font-body);
      background: var(--surface);
      color: var(--text-primary);
      transition: all 0.3s ease;
      outline: none;
    }
    .input:focus {
      border-color: var(--secondary);
      box-shadow: 0 0 0 3px rgba(82,183,136,0.12);
    }
    textarea.input {
      resize: vertical;
      min-height: 120px;
    }
    .label {
      display: block;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--text-secondary);
      margin-bottom: 0.35rem;
    }

    /* ===== BADGES ===== */
    .badge {
      display: inline-flex;
      align-items: center;
      padding: 0.2rem 0.7rem;
      border-radius: var(--radius-full);
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.02em;
    }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-info    { background: #dbeafe; color: #1e40af; }
    .badge-coral   { background: #fce4db; color: #9b2c2c; }

    /* ===== GRID ===== */
    .grid { display: grid; gap: 1.25rem; }
    .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
    .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }

    /* ===== UTILITIES ===== */
    .flex { display: flex; }
    .items-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .justify-center { justify-content: center; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 0.75rem; }
    .gap-4 { gap: 1rem; }
    .gap-5 { gap: 1.25rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mt-4 { margin-top: 1rem; }
    .text-center { text-align: center; }
    .w-full { width: 100%; }
    .p-4 { padding: 1rem; }

    /* ===== ANIMATIONS ===== */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }
    @keyframes floatReverse {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(10px); }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(12px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up { animation: fadeUp 0.4s ease-out; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .admin-sidebar { display: none; }
      .page-content-admin { margin-left: 0; }
      .grid-cols-2, .grid-cols-3 { grid-template-columns: 1fr; }
    }

    /* ===== TOAST ===== */
    .toast {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.85rem 1.2rem;
      border-radius: var(--radius);
      background: #fff;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      animation: fadeUp 0.35s ease-out;
      pointer-events: auto;
      font-family: var(--font-body);
    }
    .toast.success { border-left: 4px solid #22c55e; }
    .toast.error   { border-left: 4px solid #ef4444; }
    .toast.hiding   { opacity: 0; transform: translateX(30px); transition: all 0.35s ease; }
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
          <div style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border-radius:0.75rem;border:1px solid rgba(255,255,255,0.18);box-shadow:0 4px 12px rgba(0,0,0,0.15);flex-shrink:0">
            <i data-lucide="leaf" style="width:1.35rem;height:1.35rem;color:#a7f3d0"></i>
          </div>
          <span style="margin-left:0.75rem;font-family:var(--font-heading);font-size:1.35rem;font-weight:800;color:#fff;letter-spacing:-0.02em;text-shadow:0 2px 4px rgba(0,0,0,0.1)">GreenBite</span>
        </a>
        <span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.58rem;font-weight:700">Espace Utilisateur</span>
      </div>

      <!-- Navigation -->
      <div class="sidebar-nav" style="padding:1rem 0.75rem;position:relative;z-index:1">

        <!-- Section: Navigation -->
        <div class="sidebar-section-label" style="padding-top:0.25rem">Navigation</div>
        <ul style="list-style:none;padding:0;margin:0">
          <li>
            <a href="<?= BASE_URL ?>/" class="sidebar-nav-item <?= (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : '' ?>">
              <i data-lucide="home" style="width:1.1rem;height:1.1rem"></i><span>Accueil</span>
            </a>
          </li>
        </ul>

        <!-- Section: Nutrition -->
        <div class="sidebar-section-label">Suivi Nutritionnel</div>
        <ul style="list-style:none;padding:0;margin:0">
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="utensils-crossed" style="width:1.1rem;height:1.1rem"></i><span>Repas</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'plan') !== false) ? 'active' : '' ?>">
              <i data-lucide="clipboard-list" style="width:1.1rem;height:1.1rem"></i><span>Mes Plans</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && $_GET['action'] === 'add') ? 'active' : '' ?>">
              <i data-lucide="plus-circle" style="width:1.1rem;height:1.1rem"></i><span>Ajouter Repas</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && strpos($_GET['action'], 'regime') !== false) ? 'active' : '' ?>">
              <i data-lucide="salad" style="width:1.1rem;height:1.1rem"></i><span>Régimes</span>
            </a>
          </li>
        </ul>

        <!-- Section: Marketplace -->
        <div class="sidebar-section-label">Marketplace</div>
        <ul style="list-style:none;padding:0;margin:0">
          <li>
            <a href="<?= BASE_URL ?>/?page=marketplace" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="shopping-basket" style="width:1.1rem;height:1.1rem"></i><span>Produits</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && isset($_GET['action']) && $_GET['action'] === 'order') ? 'active' : '' ?>">
              <i data-lucide="shopping-cart" style="width:1.1rem;height:1.1rem"></i><span>Commander</span>
            </a>
          </li>
        </ul>

        <!-- Section: Recettes -->
        <div class="sidebar-section-label">Recettes Durables</div>
        <ul style="list-style:none;padding:0;margin:0">
          <li>
            <a href="<?= BASE_URL ?>/?page=recettes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>">
              <i data-lucide="book-open" style="width:1.1rem;height:1.1rem"></i><span>Explorer</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=recettes&action=my-suggestions" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes' && isset($_GET['action']) && ($_GET['action'] === 'my-suggestions' || $_GET['action'] === 'edit-suggestion')) ? 'active' : '' ?>">
              <i data-lucide="lightbulb" style="width:1.1rem;height:1.1rem"></i><span>Mes Suggestions</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=recettes&action=suggest" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes' && isset($_GET['action']) && $_GET['action'] === 'suggest') ? 'active' : '' ?>">
              <i data-lucide="plus-circle" style="width:1.1rem;height:1.1rem"></i><span>Proposer</span>
            </a>
          </li>
        </ul>

        <!-- Section: Social -->
        <div class="sidebar-section-label">Social</div>
        <ul style="list-style:none;padding:0;margin:0">
          <li>
            <a href="<?= BASE_URL ?>/?page=article&action=list" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'article' && ($_GET['action'] ?? '') !== 'mes-activites') ? 'active' : '' ?>">
              <i data-lucide="newspaper" style="width:1.1rem;height:1.1rem"></i><span>Communauté & Blog</span>
            </a>
          </li>
          <li>
            <a href="<?= BASE_URL ?>/?page=article&action=mes-activites" class="sidebar-nav-item <?= (isset($_GET['action']) && $_GET['action'] === 'mes-activites') ? 'active' : '' ?>">
              <i data-lucide="folder-open" style="width:1.1rem;height:1.1rem"></i><span>Mes activités</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Footer -->
      <div style="border-top:1px solid rgba(255,255,255,0.06);padding:0.875rem;position:relative;z-index:1">
        <button class="admin-dark-toggle" onclick="toggleDarkMode()" id="frontDarkBtn" style="display:flex;align-items:center;gap:0.5rem;width:100%;padding:0.5rem 0.75rem;border-radius:0.6rem;border:none;background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.7);cursor:pointer;font-size:0.8rem;transition:all 0.2s">
          <i data-lucide="moon" id="frontDarkLucide" style="width:1rem;height:1rem"></i>
          <span id="frontDarkLabel">Mode sombre</span>
        </button>
        <a href="<?= BASE_URL ?>/?page=admin-stats" class="sidebar-nav-item" style="margin-top:4px">
          <i data-lucide="settings" style="width:1.1rem;height:1.1rem"></i><span>Administration</span>
        </a>
        <a href="<?= BASE_URL ?>/?page=login" class="sidebar-nav-item" style="margin-top:4px">
          <i data-lucide="log-in" style="width:1.1rem;height:1.1rem"></i><span>Se connecter</span>
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
          <div style="position:relative;">
            <i data-lucide="search" style="width:0.875rem;height:0.875rem;color:var(--text-muted);position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);pointer-events:none;z-index:2;"></i>
            <input type="text" id="globalSearchInput" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher..." style="width:13rem;padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1.5px solid var(--border);border-radius:var(--radius-full);font-size:0.8rem;background:var(--surface);color:var(--text-primary);transition:all 0.3s;outline:none" onfocus="this.style.borderColor='var(--secondary)';this.style.boxShadow='0 0 0 3px rgba(82,183,136,0.12)';this.style.width='17rem'" onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';this.style.width='13rem'">
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