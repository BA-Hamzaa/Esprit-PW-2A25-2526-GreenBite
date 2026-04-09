<!-- ===== STATISTICS DASHBOARD ===== -->
<div style="padding:2rem">
  <!-- Page Header -->
  <div class="flex items-center justify-between mb-8 animate-fade-up">
    <div>
      <h1 class="text-3xl font-bold" style="color:var(--primary);font-family:var(--font-heading)">Tableau de Bord</h1>
      <p class="text-sm" style="color:var(--text-secondary);margin-top:0.25rem">Vue d'ensemble de votre plateforme NutriGreen</p>
    </div>
    <div class="flex items-center gap-3">
      <span class="badge badge-success" style="padding:0.4rem 0.8rem"><i data-lucide="activity" style="width:0.8rem;height:0.8rem"></i> En ligne</span>
      <span class="text-sm" style="color:var(--text-muted)"><?= date('d/m/Y H:i') ?></span>
    </div>
  </div>

  <!-- Stat Cards Row -->
  <div class="grid grid-cols-4 gap-6 mb-8">
    <div class="stat-card green">
      <div class="flex items-center justify-between mb-3">
        <div class="stat-icon" style="background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#16a34a"><i data-lucide="utensils-crossed"></i></div>
        <span class="badge badge-green-light"><i data-lucide="trending-up" style="width:0.7rem;height:0.7rem"></i> +12%</span>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary)">1,284</div>
      <div class="text-sm" style="color:var(--text-muted);margin-top:0.25rem">Repas enregistrés</div>
      <div class="progress mt-3" style="height:4px"><div class="progress-bar" style="width:78%"></div></div>
    </div>

    <div class="stat-card orange">
      <div class="flex items-center justify-between mb-3">
        <div class="stat-icon" style="background:linear-gradient(135deg,#fed7aa,#fff7ed);color:#ea580c"><i data-lucide="package"></i></div>
        <span class="badge badge-yellow-light"><i data-lucide="trending-up" style="width:0.7rem;height:0.7rem"></i> +8%</span>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary)">356</div>
      <div class="text-sm" style="color:var(--text-muted);margin-top:0.25rem">Produits actifs</div>
      <div class="progress mt-3" style="height:4px"><div class="progress-bar" style="width:62%;background:linear-gradient(90deg,var(--accent-orange),#F4845F)"></div></div>
    </div>

    <div class="stat-card blue">
      <div class="flex items-center justify-between mb-3">
        <div class="stat-icon" style="background:linear-gradient(135deg,#dbeafe,#eff6ff);color:#2563eb"><i data-lucide="shopping-bag"></i></div>
        <span class="badge badge-blue-light"><i data-lucide="trending-up" style="width:0.7rem;height:0.7rem"></i> +23%</span>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary)">891</div>
      <div class="text-sm" style="color:var(--text-muted);margin-top:0.25rem">Commandes totales</div>
      <div class="progress mt-3" style="height:4px"><div class="progress-bar" style="width:85%;background:linear-gradient(90deg,#3b82f6,#60a5fa)"></div></div>
    </div>

    <div class="stat-card purple">
      <div class="flex items-center justify-between mb-3">
        <div class="stat-icon" style="background:linear-gradient(135deg,#ede9fe,#f5f3ff);color:#7c3aed"><i data-lucide="chef-hat"></i></div>
        <span class="badge" style="background:#ede9fe;color:#7c3aed;border:1px solid #c4b5fd"><i data-lucide="trending-up" style="width:0.7rem;height:0.7rem"></i> +5%</span>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary)">127</div>
      <div class="text-sm" style="color:var(--text-muted);margin-top:0.25rem">Recettes publiées</div>
      <div class="progress mt-3" style="height:4px"><div class="progress-bar" style="width:45%;background:linear-gradient(90deg,#8b5cf6,#a78bfa)"></div></div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="grid grid-cols-2 gap-6 mb-8">
    <!-- Calories Chart -->
    <div class="chart-card">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold" style="color:var(--text-primary)"><i data-lucide="flame" style="width:1rem;height:1rem;display:inline;vertical-align:middle;color:var(--accent-orange)"></i> Calories — 7 derniers jours</h3>
        <span class="badge badge-gray">Moyenne: 1,850 kcal</span>
      </div>
      <canvas id="caloriesChart"></canvas>
    </div>

    <!-- Orders Chart -->
    <div class="chart-card">
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
