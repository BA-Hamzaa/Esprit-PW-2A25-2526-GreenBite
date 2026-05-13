<div style="padding:2rem">
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 6px 18px rgba(45,106,79,0.15)">
        <i data-lucide="messages-square" style="width:1.625rem;height:1.625rem;color:var(--primary)"></i>
      </div>
      <div>
        <h1 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em;display:flex;align-items:center;gap:0.5rem;margin:0">
          <span style="display:block;width:4px;height:1.5rem;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></span>
          Modération des Commentaires
        </h1>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px">
          <?= count($commentaires) ?> commentaire(s)
        </p>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/?page=admin-article&action=list" class="btn" style="border-radius:var(--radius-full);background:rgba(45,106,79,0.06);border:1px solid rgba(45,106,79,0.15);color:var(--primary)">
      <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Articles
    </a>
  </div>

  <div class="card" style="padding:0;overflow:hidden">
    <div style="overflow-x:auto">
      <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
          <tr style="background:linear-gradient(135deg,rgba(45,106,79,0.06),rgba(82,183,136,0.04));border-bottom:2px solid var(--border)">
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">#</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Article</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Auteur</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Commentaire</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Statut</th>
            <th style="padding:0.75rem 0.875rem;text-align:left;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted)">Date</th>
            <th style="padding:0.75rem 0.875rem;text-align:center;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);min-width:160px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($commentaires)): ?>
            <tr>
              <td colspan="7" style="text-align:center;padding:4rem 2rem;color:var(--text-muted)">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:50%;margin-bottom:1.25rem">
                  <i data-lucide="inbox" style="width:2.25rem;height:2.25rem;color:var(--primary)"></i>
                </div>
                <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:var(--primary);margin-bottom:0.5rem">Aucun commentaire</h3>
                <p style="color:var(--text-muted);font-size:0.82rem">Les commentaires apparaîtront ici.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($commentaires as $c): ?>
              <?php
                $statut = $c['statut'] ?? 'valide';
                $isSignale = ($statut === 'signale');
                $sColor = $isSignale ? '#ef4444' : '#22c55e';
                $sBg    = $isSignale ? 'rgba(239,68,68,0.1)' : 'rgba(34,197,94,0.1)';
                $sIcon  = $isSignale ? 'flag' : 'check-circle-2';
                $sLabel = $isSignale ? 'Signalé' : 'Validé';
                $excerpt = trim($c['contenu'] ?? '');
                if (mb_strlen($excerpt) > 90) $excerpt = mb_substr($excerpt, 0, 90) . '...';
                $commentId = (int)$c['id'];
                $articleId = (int)$c['article_id'];
              ?>
              <tr style="border-bottom:1px solid var(--border);transition:background 0.2s<?= $isSignale ? ';background:rgba(239,68,68,0.02)' : '' ?>" onmouseover="this.style.background='<?= $isSignale ? 'rgba(239,68,68,0.06)' : 'rgba(82,183,136,0.03)' ?>'" onmouseout="this.style.background='<?= $isSignale ? 'rgba(239,68,68,0.02)' : '' ?>'">
                <td style="padding:0.75rem 0.875rem"><span style="display:inline-flex;align-items:center;justify-content:center;width:1.75rem;height:1.75rem;background:var(--muted);border-radius:0.5rem;font-size:0.7rem;font-weight:700;color:var(--text-muted)"><?= $commentId ?></span></td>
                <td style="padding:0.75rem 0.875rem;max-width:200px">
                  <span style="font-weight:700;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block"><?= htmlspecialchars($c['article_titre'] ?? '') ?></span>
                </td>
                <td style="padding:0.75rem 0.875rem">
                  <div style="display:flex;align-items:center;gap:0.5rem">
                    <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                      <i data-lucide="user" style="width:0.75rem;height:0.75rem;color:#fff"></i>
                    </div>
                    <span style="font-size:0.82rem;font-weight:600;color:var(--text-primary)"><?= htmlspecialchars($c['pseudo'] ?? '') ?></span>
                  </div>
                </td>
                <td style="padding:0.75rem 0.875rem;max-width:320px;color:var(--text-secondary);font-size:0.82rem"><?= htmlspecialchars($excerpt) ?></td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <span style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.3rem 0.75rem;border-radius:var(--radius-full);background:<?= $sBg ?>;color:<?= $sColor ?>;font-size:0.72rem;font-weight:700">
                    <i data-lucide="<?= $sIcon ?>" style="width:0.75rem;height:0.75rem"></i><?= $sLabel ?>
                  </span>
                </td>
                <td style="padding:0.75rem 0.875rem;font-size:0.78rem;color:var(--text-muted);white-space:nowrap"><?= htmlspecialchars($c['date_commentaire'] ?? '') ?></td>
                <td style="padding:0.75rem 0.875rem;text-align:center">
                  <div style="display:inline-flex;gap:0.4rem;justify-content:center;align-items:center;flex-wrap:nowrap;white-space:nowrap">
                    <a href="<?= BASE_URL ?>/?page=article&action=detail&id=<?= $articleId ?>#comment-<?= $commentId ?>"
                       style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(59,130,246,0.08);color:#3b82f6;border-radius:var(--radius-full);border:1px solid rgba(59,130,246,0.2);transition:all 0.2s;text-decoration:none"
                       onmouseover="this.style.background='rgba(59,130,246,0.15)';this.style.transform='translateY(-1px)'"
                       onmouseout="this.style.background='rgba(59,130,246,0.08)';this.style.transform='none'" title="Voir">
                      <i data-lucide="eye" style="width:0.75rem;height:0.75rem"></i>
                    </a>
                    <?php if ($isSignale): ?>
                      <a href="<?= BASE_URL ?>/?page=admin-comment&action=ignorer&id=<?= $commentId ?>"
                         style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;text-decoration:none;transition:all 0.2s;white-space:nowrap"
                         onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(34,197,94,0.3)'"
                         onmouseout="this.style.transform='none';this.style.boxShadow='none'"
                         onclick="return confirm('Ignorer le signalement ? Le commentaire redeviendra normal.')">
                        <i data-lucide="check" style="width:0.75rem;height:0.75rem"></i> Ignorer
                      </a>
                      <button onclick="confirmBan(<?= $commentId ?>)"
                              style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.75rem;background:linear-gradient(135deg,#f87171,#ef4444);color:#fff;border:none;border-radius:var(--radius-full);font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.2s;white-space:nowrap"
                              onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(239,68,68,0.3)'"
                              onmouseout="this.style.transform='none';this.style.boxShadow='none'" title="Supprimer & Bannir">
                        <i data-lucide="ban" style="width:0.75rem;height:0.75rem"></i> Bannir
                      </button>
                    <?php else: ?>
                      <a href="<?= BASE_URL ?>/?page=admin-comment&action=delete&id=<?= $commentId ?>"
                         style="display:inline-flex;align-items:center;justify-content:center;width:2rem;height:2rem;background:rgba(239,68,68,0.08);color:#ef4444;border-radius:var(--radius-full);border:1px solid rgba(239,68,68,0.2);transition:all 0.2s;text-decoration:none"
                         onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.transform='translateY(-1px)'"
                         onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.transform='none'"
                         title="Supprimer" onclick="return confirm('Supprimer ce commentaire ?')">
                        <i data-lucide="trash-2" style="width:0.75rem;height:0.75rem"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function confirmBan(id) {
    if (confirm("ATTENTION : Supprimer ce commentaire et BANNIR cet utilisateur ?")) {
        window.location.href = "<?= BASE_URL ?>/?page=admin-comment&action=supprimer-bannir&id=" + id;
    }
}
</script>