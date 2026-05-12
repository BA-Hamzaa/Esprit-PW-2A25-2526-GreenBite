<?php
$comment = $comment ?? null; // passed from controller
$id = (int)($comment['id'] ?? 0);
$pseudo = htmlspecialchars($_GET['pseudo'] ?? '');
$pin = htmlspecialchars($_GET['pin'] ?? '');
$articleTitre = htmlspecialchars($comment['article_titre'] ?? '');
$contenu = htmlspecialchars($_POST['contenu'] ?? $comment['contenu'] ?? '');
$errors = $errors ?? [];
?>

<div style="padding:2rem;max-width:700px;margin:0 auto">
  <div class="flex items-center justify-between mb-6">
    <h1 style="font-family:var(--font-heading);font-size:1.6rem;font-weight:800">✏️ Modifier mon commentaire</h1>
    <a href="<?= BASE_URL ?>/?page=article&action=mes-activites" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour à mes activités
    </a>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="p-4 rounded-xl mb-4" style="background:#fef2f2;color:#991b1b;border:1px solid #fca5a5">
      <?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="card" style="padding:1.5rem;border:1px solid var(--border)">
    <p style="margin-bottom:1rem;font-size:0.85rem;color:var(--text-muted)">
      Article : <strong><?= $articleTitre ?></strong>
    </p>

    <form method="post" action="<?= BASE_URL ?>/?page=article&action=edit-mes-commentaires&id=<?= $id ?>&pseudo=<?= urlencode($pseudo) ?>&pin=<?= urlencode($pin) ?>">
      <div style="margin-bottom:1rem">
        <label class="label">💬 Votre commentaire</label>
        <textarea name="contenu" class="input" rows="6" required minlength="5"><?= $contenu ?></textarea>
        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px">Minimum 5 caractères.</div>
      </div>

      <div style="display:flex;justify-content:flex-end">
        <button type="submit" class="btn btn-primary" style="border-radius:var(--radius-full)">💾 Enregistrer</button>
      </div>
    </form>
  </div>
</div>