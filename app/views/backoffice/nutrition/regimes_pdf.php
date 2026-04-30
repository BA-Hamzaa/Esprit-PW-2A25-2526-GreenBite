<?php
$regimes = isset($regimes) && is_array($regimes) ? $regimes : [];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Export Régimes Alimentaires</title>
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
  <h1>Régimes Alimentaires</h1>
  <p class="meta">Export généré le <?= date('d/m/Y H:i') ?></p>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Objectif</th>
        <th>Durée</th>
        <th>Calories / jour</th>
        <th>Soumis par</th>
        <th>Statut</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($regimes)): ?>
        <tr><td colspan="7">Aucun régime trouvé.</td></tr>
      <?php else: ?>
        <?php foreach ($regimes as $r): ?>
          <tr>
            <td><?= (int)($r['id'] ?? 0) ?></td>
            <td><?= htmlspecialchars((string)($r['nom'] ?? '')) ?></td>
            <td><?= htmlspecialchars((string)($r['objectif'] ?? '')) ?></td>
            <td><?= (int)($r['duree_semaines'] ?? 0) ?> semaines</td>
            <td><?= number_format((int)($r['calories_jour'] ?? 0)) ?> kcal</td>
            <td><?= htmlspecialchars((string)($r['soumis_par'] ?? '')) ?></td>
            <td><?= htmlspecialchars((string)($r['statut'] ?? '')) ?></td>
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
