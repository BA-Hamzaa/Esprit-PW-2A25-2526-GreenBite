<?php
$plans = isset($plans) && is_array($plans) ? $plans : [];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Export Plans Nutritionnels</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; color: #111827; }
    h1 { margin: 0 0 6px; font-size: 22px; }
    .meta { margin: 0 0 16px; color: #4b5563; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; vertical-align: top; }
    th { background: #f3f4f6; font-weight: 700; }
  </style>
</head>
<body>
  <h1>Plans Nutritionnels</h1>
  <p class="meta">Export généré le <?= date('d/m/Y H:i') ?></p>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Régime lié</th>
        <th>Objectif</th>
        <th>Durée</th>
        <th>Calories</th>
        <th>Soumis par</th>
        <th>Statut</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($plans)): ?>
        <tr><td colspan="8">Aucun plan trouvé.</td></tr>
      <?php else: ?>
        <?php foreach ($plans as $p): ?>
          <tr>
            <td><?= (int)($p['id'] ?? 0) ?></td>
            <td><?= htmlspecialchars((string)($p['nom'] ?? '')) ?></td>
            <td><?= htmlspecialchars((string)($p['regime_nom'] ?? '—')) ?></td>
            <td><?= htmlspecialchars((string)($p['type_objectif'] ?? '')) ?></td>
            <td><?= (int)($p['duree_jours'] ?? 0) ?> jours</td>
            <td><?= (int)($p['objectif_calories'] ?? 0) ?> kcal</td>
            <td><?= htmlspecialchars((string)($p['soumis_par'] ?? '')) ?></td>
            <td><?= htmlspecialchars((string)($p['statut'] ?? '')) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <script>
    window.addEventListener('load', function () { window.print(); });
  </script>
</body>
</html>
