<!-- ===== STATISTICS DASHBOARD ===== -->
<div style="padding:2rem;position:relative">

  <!-- Hero Header -->
  <div style="background:linear-gradient(135deg,#0d2e1f 0%,#1B4332 30%,#2D6A4F 65%,#40916C 100%);border-radius:1.5rem;padding:2rem 2.5rem;color:#fff;margin-bottom:2rem;position:relative;overflow:hidden;box-shadow:0 16px 50px rgba(45,106,79,0.3)">
    <div style="position:absolute;top:-60px;right:-60px;width:240px;height:240px;background:radial-gradient(circle,rgba(167,243,208,0.18) 0%,transparent 65%);border-radius:50%;animation:float 7s ease-in-out infinite"></div>
    <div style="position:absolute;bottom:-40px;left:-40px;width:180px;height:180px;background:radial-gradient(circle,rgba(255,255,255,0.05) 0%,transparent 65%);border-radius:50%"></div>
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);background-size:28px 28px;border-radius:1.5rem"></div>
    <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between">
      <div>
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem">
          <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border-radius:0.875rem;border:1px solid rgba(255,255,255,0.15)">
            <i data-lucide="bar-chart-3" style="width:1.5rem;height:1.5rem;color:#a7f3d0"></i>
          </div>
          <div>
            <h1 style="font-family:var(--font-heading);font-size:1.625rem;font-weight:900;letter-spacing:-0.03em;line-height:1">Tableau de Bord</h1>
            <p style="color:rgba(255,255,255,0.55);font-size:0.82rem;margin-top:2px">Vue d'ensemble · GreenBite Admin</p>
          </div>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:0.75rem">
        <span style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.4rem 0.875rem;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:var(--radius-full);font-size:0.78rem;font-weight:600;backdrop-filter:blur(8px)">
          <span style="width:7px;height:7px;background:#4ade80;border-radius:50%;animation:pulse 2s infinite"></span>
          En ligne
        </span>
        <span style="color:rgba(255,255,255,0.5);font-size:0.8rem">
          <?php
            $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            echo date('d') . ' ' . $mois[(int)date('n')-1] . ' ' . date('Y - H:i');
          ?>
        </span>
      </div>
    </div>
  </div>

  <!-- Stat Cards Row -->
  <div class="grid grid-cols-4 gap-5 mb-8">

    <!-- Repas -->
    <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#f0fdf4,#fff);box-shadow:0 4px 20px rgba(22,163,74,0.08),0 1px 3px rgba(0,0,0,0.04)">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary))"></div>
      <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:radial-gradient(circle,rgba(45,106,79,0.08) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
        <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:0.875rem;box-shadow:0 4px 12px rgba(22,163,74,0.18)">
          <i data-lucide="utensils-crossed" style="width:1.375rem;height:1.375rem;color:#16a34a"></i>
        </div>
        <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.55rem;background:#dcfce7;color:#16a34a;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700;border:1px solid #bbf7d0">
          <i data-lucide="trending-up" style="width:0.6rem;height:0.6rem"></i> +12%
        </span>
      </div>
      <div style="font-family:var(--font-heading);font-size:2rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">1,284</div>
      <div style="font-size:0.78rem;color:var(--text-muted);font-weight:500">Repas enregistrés</div>
      <div class="progress" style="height:4px;margin-top:0.875rem"><div class="progress-bar" style="width:78%"></div></div>
    </div>

    <!-- Produits -->
    <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#fff7ed,#fff);box-shadow:0 4px 20px rgba(234,88,12,0.08),0 1px 3px rgba(0,0,0,0.04)">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--accent-orange),#f97316)"></div>
      <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:radial-gradient(circle,rgba(234,88,12,0.07) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
        <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:0.875rem;box-shadow:0 4px 12px rgba(234,88,12,0.18)">
          <i data-lucide="package" style="width:1.375rem;height:1.375rem;color:#ea580c"></i>
        </div>
        <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.55rem;background:#fef3c7;color:#d97706;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700;border:1px solid #fde68a">
          <i data-lucide="trending-up" style="width:0.6rem;height:0.6rem"></i> +8%
        </span>
      </div>
      <div style="font-family:var(--font-heading);font-size:2rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">356</div>
      <div style="font-size:0.78rem;color:var(--text-muted);font-weight:500">Produits actifs</div>
      <div class="progress" style="height:4px;margin-top:0.875rem"><div class="progress-bar" style="width:62%;background:linear-gradient(90deg,var(--accent-orange),#f97316)"></div></div>
    </div>

    <!-- Commandes -->
    <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#eff6ff,#fff);box-shadow:0 4px 20px rgba(37,99,235,0.08),0 1px 3px rgba(0,0,0,0.04)">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#3b82f6,#60a5fa)"></div>
      <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:radial-gradient(circle,rgba(59,130,246,0.07) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
        <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:0.875rem;box-shadow:0 4px 12px rgba(59,130,246,0.18)">
          <i data-lucide="shopping-bag" style="width:1.375rem;height:1.375rem;color:#2563eb"></i>
        </div>
        <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.55rem;background:#dbeafe;color:#1d4ed8;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700;border:1px solid #93c5fd">
          <i data-lucide="trending-up" style="width:0.6rem;height:0.6rem"></i> +23%
        </span>
      </div>
      <div style="font-family:var(--font-heading);font-size:2rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">891</div>
      <div style="font-size:0.78rem;color:var(--text-muted);font-weight:500">Commandes totales</div>
      <div class="progress" style="height:4px;margin-top:0.875rem"><div class="progress-bar" style="width:85%;background:linear-gradient(90deg,#3b82f6,#60a5fa)"></div></div>
    </div>

    <!-- Recettes -->
    <div class="card" style="padding:1.5rem;position:relative;overflow:hidden;border:none;background:linear-gradient(135deg,#faf5ff,#fff);box-shadow:0 4px 20px rgba(124,58,237,0.08),0 1px 3px rgba(0,0,0,0.04)">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div>
      <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:radial-gradient(circle,rgba(124,58,237,0.07) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
        <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:0.875rem;box-shadow:0 4px 12px rgba(124,58,237,0.18)">
          <i data-lucide="chef-hat" style="width:1.375rem;height:1.375rem;color:#7c3aed"></i>
        </div>
        <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.2rem 0.55rem;background:#ede9fe;color:#7c3aed;border-radius:var(--radius-full);font-size:0.68rem;font-weight:700;border:1px solid #c4b5fd">
          <i data-lucide="trending-up" style="width:0.6rem;height:0.6rem"></i> +5%
        </span>
      </div>
      <div style="font-family:var(--font-heading);font-size:2rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">127</div>
      <div style="font-size:0.78rem;color:var(--text-muted);font-weight:500">Recettes publiées</div>
      <div class="progress" style="height:4px;margin-top:0.875rem"><div class="progress-bar" style="width:45%;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div></div>
    </div>
  </div>

  <!-- Section: Analyses -->
  <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1.25rem">
    <span style="display:block;width:4px;height:1.25rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
    <h2 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em">Analyses & Graphiques</h2>
  </div>

  <!-- Charts Row -->
  <div class="grid grid-cols-2 gap-6 mb-8">
    <!-- Calories Chart -->
    <div class="chart-card" style="border:1px solid var(--border)">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem">
        <div style="display:flex;align-items:center;gap:0.625rem">
          <div style="display:flex;align-items:center;justify-content:center;width:2.25rem;height:2.25rem;background:linear-gradient(135deg,rgba(231,111,81,0.12),rgba(231,111,81,0.06));border-radius:0.625rem;border:1px solid rgba(231,111,81,0.15)">
            <i data-lucide="flame" style="width:1rem;height:1rem;color:var(--accent-orange)"></i>
          </div>
          <div>
            <h3 style="font-family:var(--font-heading);font-size:0.9rem;font-weight:700;color:var(--text-primary);line-height:1.2">Calories</h3>
            <p style="font-size:0.72rem;color:var(--text-muted)">7 derniers jours</p>
          </div>
        </div>
        <span class="badge badge-gray">Moy: 1,850 kcal</span>
      </div>
      <canvas id="caloriesChart"></canvas>
    </div>

    <!-- Orders Chart -->
    <div class="chart-card" style="border:1px solid var(--border)">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="shopping-bag" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:#3b82f6"></i> Commandes — 6 derniers mois</h3>
        <span class="badge badge-gray">Total: 891</span>
      </div>
      <canvas id="ordersChart"></canvas>
    </div>
  </div>

  <div class="grid grid-cols-3 gap-6 mb-8">
    <!-- Macros Donut -->
    <div class="chart-card">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="pie-chart" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:var(--primary)"></i> Répartition Macros</h3>
      </div>
      <canvas id="macrosChart"></canvas>
    </div>

    <!-- Categories Donut -->
    <div class="chart-card">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="tag" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:var(--accent-orange)"></i> Catégories Produits</h3>
      </div>
      <canvas id="categoriesChart"></canvas>
    </div>

    <!-- Carbon Score -->
    <div class="chart-card">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="leaf" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:var(--success-green)"></i> Score Carbone Recettes</h3>
      </div>
      <canvas id="carbonChart"></canvas>
    </div>
  </div>

  <!-- Recent Activity -->
  <div class="grid grid-cols-2 gap-6">
    <!-- Recent Meals -->
    <div class="chart-card">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="clock" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:var(--primary)"></i> Repas récents</h3>
        <a href="<?= BASE_URL ?>/?page=admin-nutrition&action=list" class="text-sm font-medium" style="color:var(--secondary)">Voir tout →</a>
      </div>
      <div class="space-y-3">
        <?php
        $recentMeals = [
          ['nom' => 'Toast avocat et oeuf', 'type' => 'Petit-déjeuner', 'cal' => 420, 'icon' => '🍳'],
          ['nom' => 'Saumon grillé légumes', 'type' => 'Déjeuner', 'cal' => 650, 'icon' => '🐟'],
          ['nom' => 'Salade quinoa tofu', 'type' => 'Déjeuner', 'cal' => 480, 'icon' => '🥗'],
          ['nom' => 'Smoothie vert protéiné', 'type' => 'Collation', 'cal' => 220, 'icon' => '🥤'],
        ];
        foreach ($recentMeals as $m): ?>
        <div class="flex items-center justify-between p-3 rounded-xl" style="background:var(--muted);transition:all 0.2s" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
          <div class="flex items-center gap-3">
            <span style="font-size:1.25rem"><?= $m['icon'] ?></span>
            <div>
              <div class="font-medium text-sm" style="color:var(--text-primary)"><?= $m['nom'] ?></div>
              <div class="text-xs" style="color:var(--text-muted)"><?= $m['type'] ?></div>
            </div>
          </div>
          <span class="font-semibold text-sm" style="color:var(--accent-orange)"><?= $m['cal'] ?> kcal</span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="chart-card">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="receipt" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:#3b82f6"></i> Commandes récentes</h3>
        <a href="<?= BASE_URL ?>/?page=admin-marketplace&action=commandes" class="text-sm font-medium" style="color:var(--secondary)">Voir tout →</a>
      </div>
      <div class="space-y-3">
        <?php
        $recentOrders = [
          ['client' => 'Sophie Martin', 'total' => '45.90 DT', 'status' => 'Livrée', 'color' => 'badge-success'],
          ['client' => 'Lucas Dubois', 'total' => '89.00 DT', 'status' => 'En cours', 'color' => 'badge-blue-light'],
          ['client' => 'Emma Bernard', 'total' => '32.50 DT', 'status' => 'En attente', 'color' => 'badge-yellow-light'],
          ['client' => 'Hugo Thomas', 'total' => '126.80 DT', 'status' => 'Livrée', 'color' => 'badge-success'],
        ];
        foreach ($recentOrders as $o): ?>
        <div class="flex items-center justify-between p-3 rounded-xl" style="background:var(--muted);transition:all 0.2s" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">
          <div class="flex items-center gap-3">
            <div class="avatar avatar-sm" style="font-size:0.7rem"><?= strtoupper(substr($o['client'], 0, 2)) ?></div>
            <div>
              <div class="font-medium text-sm" style="color:var(--text-primary)"><?= $o['client'] ?></div>
              <div class="text-xs" style="color:var(--text-muted)"><?= $o['total'] ?></div>
            </div>
          </div>
          <span class="badge <?= $o['color'] ?>"><?= $o['status'] ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
const textColor = isDark ? '#9ca3af' : '#6b7280';

const defaultOpts = {
  responsive: true,
  maintainAspectRatio: true,
  plugins: { legend: { labels: { color: textColor, font: { family: 'Inter', size: 12 }, usePointStyle: true, pointStyle: 'circle' } } },
  scales: { x: { ticks: { color: textColor, font: { size: 11 } }, grid: { color: gridColor } }, y: { ticks: { color: textColor, font: { size: 11 } }, grid: { color: gridColor } } }
};

// === Calories Line Chart ===
new Chart(document.getElementById('caloriesChart'), {
  type: 'line',
  data: {
    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
    datasets: [{
      label: 'Calories (kcal)',
      data: [1720, 1950, 1680, 2100, 1850, 2200, 1900],
      borderColor: '#2D6A4F',
      backgroundColor: 'rgba(45,106,79,0.1)',
      fill: true,
      tension: 0.4,
      pointBackgroundColor: '#2D6A4F',
      pointBorderColor: '#fff',
      pointBorderWidth: 2,
      pointRadius: 5,
      pointHoverRadius: 8
    }, {
      label: 'Objectif',
      data: [2000, 2000, 2000, 2000, 2000, 2000, 2000],
      borderColor: '#E76F51',
      borderDash: [8, 4],
      pointRadius: 0,
      fill: false
    }]
  },
  options: defaultOpts
});

// === Orders Bar Chart ===
new Chart(document.getElementById('ordersChart'), {
  type: 'bar',
  data: {
    labels: ['Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr'],
    datasets: [{
      label: 'Commandes',
      data: [120, 145, 132, 168, 185, 141],
      backgroundColor: ['rgba(45,106,79,0.7)', 'rgba(82,183,136,0.7)', 'rgba(45,106,79,0.7)', 'rgba(82,183,136,0.7)', 'rgba(45,106,79,0.7)', 'rgba(82,183,136,0.7)'],
      borderRadius: 10,
      borderSkipped: false,
      barThickness: 36
    }]
  },
  options: { ...defaultOpts, plugins: { ...defaultOpts.plugins, legend: { display: false } } }
});

// === Macros Donut ===
new Chart(document.getElementById('macrosChart'), {
  type: 'doughnut',
  data: {
    labels: ['Protéines', 'Glucides', 'Lipides'],
    datasets: [{ data: [94, 38, 70], backgroundColor: ['#2D6A4F', '#52B788', '#E76F51'], borderWidth: 0, spacing: 4 }]
  },
  options: { responsive: true, cutout: '65%', plugins: { legend: { position: 'bottom', labels: { color: textColor, font: { family: 'Inter', size: 12 }, usePointStyle: true, padding: 16 } } } }
});

// === Categories Donut ===
new Chart(document.getElementById('categoriesChart'), {
  type: 'doughnut',
  data: {
    labels: ['Fruits & Légumes', 'Céréales', 'Protéines', 'Boissons', 'Snacks'],
    datasets: [{ data: [35, 20, 25, 10, 10], backgroundColor: ['#2D6A4F', '#52B788', '#E76F51', '#3b82f6', '#8b5cf6'], borderWidth: 0, spacing: 3 }]
  },
  options: { responsive: true, cutout: '60%', plugins: { legend: { position: 'bottom', labels: { color: textColor, font: { family: 'Inter', size: 11 }, usePointStyle: true, padding: 12 } } } }
});

// === Carbon Score Bar ===
new Chart(document.getElementById('carbonChart'), {
  type: 'bar',
  data: {
    labels: ['< 0.5', '0.5-1', '1-2', '2-3', '> 3'],
    datasets: [{
      label: 'Recettes',
      data: [28, 45, 32, 15, 7],
      backgroundColor: ['#16a34a', '#52B788', '#eab308', '#E76F51', '#ef4444'],
      borderRadius: 8,
      borderSkipped: false
    }]
  },
  options: {
    ...defaultOpts,
    indexAxis: 'y',
    plugins: { ...defaultOpts.plugins, legend: { display: false } },
    scales: { x: { ...defaultOpts.scales.x, title: { display: true, text: 'Nombre de recettes', color: textColor } }, y: { ...defaultOpts.scales.y, title: { display: true, text: 'Score CO₂', color: textColor } } }
  }
});
</script>
