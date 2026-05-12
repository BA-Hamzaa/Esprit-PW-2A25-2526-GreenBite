<div style="padding:2rem;max-width:900px;margin:0 auto">

  <!-- HEADER -->
  <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
    <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
      <i data-lucide="bar-chart-2" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
    </div>
    <div>
      <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
        <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
        Statistiques — 7 derniers jours
      </h1>
      <p style="font-size:0.8rem;color:var(--text-muted);margin:3px 0 0 0">
        Activité du blog du <?= date('d/m/Y', strtotime('-6 days')) ?> au <?= date('d/m/Y') ?>
      </p>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:2rem">

    <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.5rem;display:flex;align-items:center;gap:1rem">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:rgba(45,106,79,0.1);border-radius:0.875rem;flex-shrink:0">
        <i data-lucide="newspaper" style="width:1.4rem;height:1.4rem;color:var(--primary)"></i>
      </div>
      <div>
        <div style="font-size:2rem;font-weight:800;color:var(--primary);line-height:1;font-family:var(--font-heading)">
          <?= array_sum($stats['articles']) ?>
        </div>
        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:4px">Articles publiés cette semaine</div>
      </div>
    </div>

    <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:1.5rem;display:flex;align-items:center;gap:1rem">
      <div style="display:flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:rgba(231,111,81,0.1);border-radius:0.875rem;flex-shrink:0">
        <i data-lucide="message-circle" style="width:1.4rem;height:1.4rem;color:#e76f51"></i>
      </div>
      <div>
        <div style="font-size:2rem;font-weight:800;color:#e76f51;line-height:1;font-family:var(--font-heading)">
          <?= array_sum($stats['commentaires']) ?>
        </div>
        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:4px">Commentaires postés cette semaine</div>
      </div>
    </div>

  </div>

  <!-- CHART -->
  <div style="background:var(--card);border:1.5px solid var(--border);border-radius:1rem;padding:2rem">
    <canvas id="activityChart" style="width:100%;max-height:380px"></canvas>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const labels = <?= json_encode($stats['days']) ?>;
const articlesData = <?= json_encode($stats['articles']) ?>;
const commentairesData = <?= json_encode($stats['commentaires']) ?>;

const isDark = document.documentElement.classList.contains('dark') ||
               document.body.classList.contains('dark-mode') ||
               getComputedStyle(document.documentElement).getPropertyValue('--bg').trim().includes('1a');

const gridColor  = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
const labelColor = isDark ? 'rgba(255,255,255,0.5)'  : 'rgba(0,0,0,0.45)';

const ctx = document.getElementById('activityChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [
      {
        label: '📝 Articles publiés',
        data: articlesData,
        borderColor: '#2D6A4F',
        backgroundColor: 'rgba(45,106,79,0.08)',
        borderWidth: 2.5,
        pointBackgroundColor: '#2D6A4F',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 5,
        pointHoverRadius: 7,
        fill: true,
        tension: 0.4,
      },
      {
        label: '💬 Commentaires postés',
        data: commentairesData,
        borderColor: '#e76f51',
        backgroundColor: 'rgba(231,111,81,0.08)',
        borderWidth: 2.5,
        pointBackgroundColor: '#e76f51',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 5,
        pointHoverRadius: 7,
        fill: true,
        tension: 0.4,
      }
    ]
  },
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: {
        position: 'top',
        labels: {
          color: labelColor,
          font: { size: 13, weight: '600' },
          padding: 20,
          usePointStyle: true,
          pointStyleWidth: 10,
        }
      },
      tooltip: {
        backgroundColor: isDark ? '#1e2a1e' : '#fff',
        titleColor: isDark ? '#fff' : '#111',
        bodyColor: isDark ? 'rgba(255,255,255,0.7)' : 'rgba(0,0,0,0.6)',
        borderColor: isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.08)',
        borderWidth: 1,
        padding: 12,
        cornerRadius: 10,
        callbacks: {
          label: ctx => ` ${ctx.dataset.label.split(' ').slice(1).join(' ')}: ${ctx.parsed.y}`
        }
      }
    },
    scales: {
      x: {
        grid: { color: gridColor },
        ticks: { color: labelColor, font: { size: 12 } },
        border: { display: false }
      },
      y: {
        beginAtZero: true,
        ticks: {
          color: labelColor,
          font: { size: 12 },
          stepSize: 1,
          precision: 0
        },
        grid: { color: gridColor },
        border: { display: false }
      }
    }
  }
});
</script>