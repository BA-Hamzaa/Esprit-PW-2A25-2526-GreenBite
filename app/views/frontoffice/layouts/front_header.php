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
  <script src="<?= BASE_URL ?>/assets/js/validate.js"></script>
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
          <span style="margin-left:0.75rem;font-family:var(--font-heading);font-size:1.35rem;font-weight:800;color:#ffffff;letter-spacing:-0.02em;text-shadow:0 2px 4px rgba(0,0,0,0.1)">GreenBite</span>
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
              <i data-lucide="utensils-crossed"></i><span>Mes Repas</span>
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
            <a href="<?= BASE_URL ?>/?page=community" class="sidebar-nav-item <?= (isset($_GET['page']) && $_GET['page'] === 'community') ? 'active' : '' ?>">
              <i data-lucide="message-circle"></i><span>Communauté & Blog</span>
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
      <h4>GreenBot <span class="bot-status"></span></h4>
      <p>Assistant IA • GreenBite</p>
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
      <div class="bubble">Bonjour ! 👋 Je suis <strong>GreenBot</strong>, votre assistant nutrition IA.<br><br>Créez des régimes, trouvez des recettes avec vos ingrédients, ou posez-moi n'importe quelle question sur GreenBite !</div>
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

