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

<div class="page-with-sidebar">
  <!-- ===== SIDEBAR ===== -->
  <nav class="admin-sidebar front-sidebar">
    <div class="sidebar-logo" style="border-bottom:1px solid rgba(255,255,255,0.06);padding:1.25rem 1.5rem">
      <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 text-white mb-2">
        <span style="font-size:1.4rem;filter:drop-shadow(0 2px 6px rgba(82,183,136,0.4))">🌱</span>
        <span class="logo-text" style="background:linear-gradient(90deg,#ffffff,#a7f3d0);-webkit-background-clip:text;-webkit-text-fill-color:transparent">NutriGreen</span>
      </a>
      <span class="text-xs" style="color:rgba(255,255,255,0.25);letter-spacing:0.15em;text-transform:uppercase;font-weight:600;font-size:0.6rem">Espace Utilisateur</span>
    </div>

    <div class="sidebar-nav" style="padding:1rem 0.75rem">
      <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Navigation</span></div>
      <ul class="space-y-1 mb-6">
        <li><a href="<?= BASE_URL ?>/" class="sidebar-nav-item <?= (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : '' ?>"><i data-lucide="home"></i><span>Accueil</span></a></li>
      </ul>

      <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Suivi Nutritionnel</span></div>
      <ul class="space-y-1 mb-6">
        <li><a href="<?= BASE_URL ?>/?page=nutrition" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>"><i data-lucide="utensils-crossed"></i><span>Mes Repas</span></a></li>
        <li><a href="<?= BASE_URL ?>/?page=nutrition&action=add" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'nutrition' && isset($_GET['action']) && $_GET['action'] === 'add') ? 'active' : '' ?>"><i data-lucide="plus-circle"></i><span>Ajouter Repas</span></a></li>
      </ul>

      <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Marketplace</span></div>
      <ul class="space-y-1 mb-6">
        <li><a href="<?= BASE_URL ?>/?page=marketplace" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && (!isset($_GET['action']) || $_GET['action'] === 'list')) ? 'active' : '' ?>"><i data-lucide="shopping-basket"></i><span>Produits</span></a></li>
        <li><a href="<?= BASE_URL ?>/?page=marketplace&action=order" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'marketplace' && isset($_GET['action']) && $_GET['action'] === 'order') ? 'active' : '' ?>"><i data-lucide="shopping-cart"></i><span>Commander</span></a></li>
      </ul>

      <div style="padding:0 0.75rem;margin-bottom:0.5rem"><span style="color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.15em;font-size:0.6rem;font-weight:700">Recettes Durables</span></div>
      <ul class="space-y-1 mb-6">
        <li><a href="<?= BASE_URL ?>/?page=recettes" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'recettes') ? 'active' : '' ?>"><i data-lucide="book-open"></i><span>Explorer</span></a></li>
      </ul>

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

  <!-- ===== MAIN CONTENT ===== -->
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
        <!-- Search -->
        <div class="front-topbar-search">
          <i data-lucide="search" style="width:1rem;height:1rem;color:var(--text-muted);position:absolute;left:0.75rem;top:50%;transform:translateY(-50%)"></i>
          <input type="text" placeholder="Rechercher..."
                 style="width:14rem;padding:0.5rem 0.75rem 0.5rem 2.25rem;border:1px solid var(--border);border-radius:var(--radius-full);font-size:0.8rem;background:var(--surface);color:var(--foreground);transition:all 0.3s"
                 onfocus="this.style.borderColor='var(--secondary)';this.style.width='18rem'"
                 onblur="this.style.borderColor='var(--border)';this.style.width='14rem'">
        </div>

        <div style="width:1px;height:1.5rem;background:var(--border)"></div>

        <!-- Notifications -->
        <button style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;border-radius:var(--radius-full);border:1px solid var(--border);background:var(--surface);cursor:pointer;transition:all 0.3s;color:var(--text-secondary)"
                onmouseover="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'"
                onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'"
                title="Notifications">
          <i data-lucide="bell" style="width:1rem;height:1rem"></i>
        </button>

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
        <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Invité' ?>
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
        <div class="p-4 rounded-xl mb-4 animate-fade-up flex items-center gap-3"
             style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#166534;border:1px solid #bbf7d0;box-shadow:0 4px 15px rgba(22,101,52,0.08)">
          <i data-lucide="check-circle-2" style="width:1.25rem;height:1.25rem;flex-shrink:0"></i>
          <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="p-4 rounded-xl mb-4 animate-fade-up flex items-center gap-3"
             style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5;box-shadow:0 4px 15px rgba(153,27,27,0.08)">
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
  if (typeof lucide !== 'undefined') lucide.createIcons();

  // ==================== MODAL COACH ====================
  function openCoachModal() {
    document.getElementById('modalCoach').style.display = 'flex';
    lucide.createIcons();
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
  document.getElementById('modalCoach').addEventListener('click', function(e) {
    if (e.target === this) closeCoachModal();
  });

  // Afficher le nom du fichier sélectionné
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

  // Validation Coach
  document.getElementById('formCoach').addEventListener('submit', function(e) {
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
    lucide.createIcons();
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
  document.getElementById('modalProfile').addEventListener('click', function(e) {
    if (e.target === this) closeProfileModal();
  });

  // Afficher confirm pwd si password rempli
  document.getElementById('profile-password').addEventListener('input', function() {
    document.getElementById('confirmPwdWrap').style.display = this.value ? 'block' : 'none';
    if (!this.value) {
      document.getElementById('err-profile-confirm').style.display = 'none';
    }
  });

  // Toggle password visibility
  function toggleProfilePwd() {
    const inp  = document.getElementById('profile-password');
    const icon = document.getElementById('profilePwdIcon');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.setAttribute('data-lucide', inp.type === 'password' ? 'eye' : 'eye-off');
    lucide.createIcons();
  }

  // Preview avatar
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

  // Validation formulaire profil
  document.getElementById('formProfile').addEventListener('submit', function(e) {
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

    if (!username) {
      showPErr('profile-username', "Le nom est obligatoire."); valid = false;
    } else if (username.length < 3) {
      showPErr('profile-username', "Minimum 3 caractères."); valid = false;
    }
    if (!email) {
      showPErr('profile-email', "L'email est obligatoire."); valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showPErr('profile-email', "Email invalide."); valid = false;
    }
    if (password) {
      if (password.length < 8) {
        showPErr('profile-password', "Minimum 8 caractères."); valid = false;
      } else if (password !== confirm) {
        showPErr('profile-confirm', "Les mots de passe ne correspondent pas."); valid = false;
      }
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