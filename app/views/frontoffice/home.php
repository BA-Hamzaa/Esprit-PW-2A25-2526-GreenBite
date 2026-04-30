<!-- ===== Homepage Dashboard ===== -->
<div style="padding:2rem;position:relative">

  <!-- Floating bg decorations -->
  <div style="position:fixed;top:20%;right:3%;width:180px;height:180px;background:radial-gradient(circle,rgba(82,183,136,0.07) 0%,transparent 70%);border-radius:50%;pointer-events:none;z-index:0;animation:float 9s ease-in-out infinite"></div>
  <div style="position:fixed;bottom:15%;right:5%;width:120px;height:120px;background:radial-gradient(circle,rgba(45,106,79,0.06) 0%,transparent 70%);border-radius:50%;pointer-events:none;z-index:0;animation:floatReverse 12s ease-in-out infinite"></div>

  <!-- Welcome Hero Banner -->
  <div style="background:linear-gradient(118deg, rgba(4,16,11,0.94) 0%, rgba(13,42,30,0.88) 34%, rgba(24,78,52,0.80) 66%, rgba(38,122,82,0.72) 100%),url('https://images.unsplash.com/photo-1472396961693-142e6e269027?auto=format&fit=crop&w=1800&q=80') center/cover no-repeat;border-radius:1.5rem;padding:3rem 2.5rem;color:#fff;border:none;position:relative;overflow:hidden;margin-bottom:2rem;box-shadow:0 20px 60px rgba(45,106,79,0.35)">
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,0.18) 0%,rgba(0,0,0,0.06) 42%,rgba(0,0,0,0.22) 100%);pointer-events:none"></div>

    <!-- Animated orbs -->
    <div style="position:absolute;top:-80px;right:-80px;width:300px;height:300px;background:radial-gradient(circle,rgba(167,243,208,0.18) 0%,transparent 65%);border-radius:50%;animation:float 7s ease-in-out infinite"></div>
    <div style="position:absolute;bottom:-50px;left:-50px;width:220px;height:220px;background:radial-gradient(circle,rgba(255,255,255,0.07) 0%,transparent 65%);border-radius:50%;animation:floatReverse 9s ease-in-out infinite"></div>
    <div style="position:absolute;top:50%;right:20%;width:100px;height:100px;background:radial-gradient(circle,rgba(167,243,208,0.1) 0%,transparent 70%);border-radius:50%;animation:float 5s ease-in-out 1s infinite"></div>

    <!-- Grid texture overlay -->
    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,0.05) 1px,transparent 1px);background-size:24px 24px;pointer-events:none;border-radius:1.5rem"></div>

    <div style="position:relative;z-index:1">
      <!-- Header row -->
      <div class="flex items-center gap-4 mb-6">
        <div style="display:flex;align-items:center;justify-content:center;width:4.5rem;height:4.5rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border-radius:1.25rem;border:1px solid rgba(255,255,255,0.18);animation:float 3s ease-in-out infinite;box-shadow:0 8px 24px rgba(0,0,0,0.15)">
          <i data-lucide="leaf" style="width:2.25rem;height:2.25rem;color:#a7f3d0"></i>
        </div>
        <div>
          <h1 style="font-family:var(--font-heading);font-size:2.1rem;font-weight:900;letter-spacing:-0.035em;line-height:1.1;text-shadow:0 3px 18px rgba(0,0,0,0.45)">
            Bienvenue sur <span style="background:linear-gradient(90deg,#a7f3d0,#6ee7b7,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">GreenBite</span>
          </h1>
          <p style="color:rgba(236,253,245,0.9);font-size:0.95rem;margin-top:4px;text-shadow:0 2px 12px rgba(0,0,0,0.35)">Votre compagnon pour une alimentation durable & intelligente 🌿</p>
        </div>
      </div>

      <!-- CTA Buttons -->
      <div class="flex gap-3 flex-wrap">
        <a href="<?= BASE_URL ?>/?page=nutrition" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;background:#fff;color:var(--primary);border-radius:var(--radius-full);font-weight:700;font-size:0.9rem;box-shadow:0 6px 20px rgba(0,0,0,0.2);transition:all 0.3s;text-decoration:none" onmouseover="this.style.transform='translateY(-2px) scale(1.03)';this.style.boxShadow='0 10px 30px rgba(0,0,0,0.25)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 6px 20px rgba(0,0,0,0.2)'">
          <i data-lucide="utensils-crossed" style="width:0.9rem;height:0.9rem"></i> Suivi Nutritionnel
        </a>
        <a href="<?= BASE_URL ?>/?page=nutrition&action=regimes" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);color:#fff;border-radius:var(--radius-full);font-weight:600;font-size:0.9rem;border:1px solid rgba(255,255,255,0.25);transition:all 0.3s;text-decoration:none" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.12)';this.style.transform='none'">
          <i data-lucide="leaf" style="width:0.9rem;height:0.9rem"></i> Régimes
        </a>
        <a href="<?= BASE_URL ?>/?page=marketplace" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);color:#fff;border-radius:var(--radius-full);font-weight:600;font-size:0.9rem;border:1px solid rgba(255,255,255,0.25);transition:all 0.3s;text-decoration:none" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.12)';this.style.transform='none'">
          <i data-lucide="shopping-basket" style="width:0.9rem;height:0.9rem"></i> Marketplace
        </a>
        <a href="<?= BASE_URL ?>/?page=recettes" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);color:#fff;border-radius:var(--radius-full);font-weight:600;font-size:0.9rem;border:1px solid rgba(255,255,255,0.25);transition:all 0.3s;text-decoration:none" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.12)';this.style.transform='none'">
          <i data-lucide="book-open" style="width:0.9rem;height:0.9rem"></i> Recettes
        </a>
        <a href="<?= BASE_URL ?>/?page=nutrition&action=plans" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);color:#fff;border-radius:var(--radius-full);font-weight:600;font-size:0.9rem;border:1px solid rgba(255,255,255,0.25);transition:all 0.3s;text-decoration:none" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.12)';this.style.transform='none'">
          <i data-lucide="clipboard-list" style="width:0.9rem;height:0.9rem"></i> Plans
        </a>
      </div>
    </div>
  </div>

  <?php
    // Check for active followed plans
    $followedPlans = $_SESSION['followed_plans'] ?? [];
    if (!empty($followedPlans)):
      if (!class_exists('NutritionController')) {
        require_once BASE_PATH . '/app/controllers/NutritionController.php';
      }
      $nc = new NutritionController();
      $regimeCache = [];
      foreach ($followedPlans as $fpId => $fpData):
        $fp = $nc->RecupererPlan($fpId);
        if (!$fp) continue;
        $associatedRegime = null;
        $associatedRegimeId = (int)($fp['regime_id'] ?? 0);
        if ($associatedRegimeId > 0) {
          if (!array_key_exists($associatedRegimeId, $regimeCache)) {
            $regimeCache[$associatedRegimeId] = $nc->RecupererRegime($associatedRegimeId) ?: null;
          }
          $associatedRegime = $regimeCache[$associatedRegimeId];
        }
        $fpDate = $fpData['date_debut'];
        $today = date('Y-m-d');
        $daysPassed = max(0, (strtotime($today) - strtotime($fpDate)) / 86400);
        $fpProgress = min(100, round(($daysPassed / max(1, $fp['duree_jours'])) * 100));
        $endDate = date('d/m/Y', strtotime($fpDate . ' + ' . ((int)$fp['duree_jours'] - 1) . ' days'));
        $daysLeft = max(0, (int)$fp['duree_jours'] - (int)$daysPassed);
        $objConfig = [
          'maintien' => ['grad'=>'linear-gradient(135deg,var(--secondary),#40916C)','icon'=>'scale','label'=>'Maintien'],
          'perte_poids' => ['grad'=>'linear-gradient(135deg,#ef4444,#dc2626)','icon'=>'trending-down','label'=>'Perte de poids'],
          'prise_masse' => ['grad'=>'linear-gradient(135deg,#3b82f6,#2563eb)','icon'=>'trending-up','label'=>'Prise de masse'],
        ];
        $fpC = $objConfig[$fp['type_objectif']] ?? $objConfig['maintien'];
  ?>
  <?php if (!empty($associatedRegime)): ?>
  <!-- Associated Regime Widget -->
  <div class="card" style="margin-bottom:0.95rem;padding:0;overflow:hidden;border:2px solid rgba(59,130,246,0.28);box-shadow:0 8px 32px rgba(37,99,235,0.10)">
    <div style="height:4px;background:linear-gradient(90deg,#2563eb,#60a5fa)"></div>
    <div style="padding:1.25rem 1.75rem;display:flex;align-items:center;justify-content:space-between;gap:1.25rem;flex-wrap:wrap">
      <div style="display:flex;align-items:center;gap:1rem;min-width:220px">
        <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:1rem;box-shadow:0 4px 14px rgba(37,99,235,0.15);flex-shrink:0">
          <i data-lucide="leaf" style="width:1.4rem;height:1.4rem;color:#2563eb"></i>
        </div>
        <div>
          <div style="display:flex;align-items:center;gap:0.4rem;flex-wrap:wrap">
            <span style="font-family:var(--font-heading);font-size:1rem;font-weight:800;color:var(--text-primary)"><?= htmlspecialchars($associatedRegime['nom'] ?? 'Régime associé') ?></span>
            <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.12rem 0.45rem;background:rgba(37,99,235,0.08);color:#2563eb;border:1px solid rgba(37,99,235,0.2);border-radius:999px;font-size:0.62rem;font-weight:700">
              <i data-lucide="link" style="width:0.55rem;height:0.55rem"></i> Régime lié
            </span>
          </div>
          <div style="margin-top:0.2rem;font-size:0.75rem;color:var(--text-muted)">
            <?= htmlspecialchars(ucfirst(str_replace('_', ' ', (string)($associatedRegime['objectif'] ?? 'maintien')))) ?>
            • <?= (int)($associatedRegime['calories_jour'] ?? 0) ?> kcal/jour
          </div>
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:0.45rem;flex-wrap:wrap">
        <a href="<?= BASE_URL ?>/?page=nutrition&action=regime-detail&id=<?= (int)$associatedRegimeId ?>"
           style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.9rem;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;border-radius:999px;font-size:0.74rem;font-weight:700;text-decoration:none;box-shadow:0 4px 12px rgba(37,99,235,0.26)">
          <i data-lucide="eye" style="width:0.75rem;height:0.75rem"></i> Voir régime
        </a>
        <button data-confirm="Arrêter le suivi de ce régime ? Le plan lié sera aussi arrêté automatiquement." data-confirm-title="Arrêter le suivi" data-confirm-type="warning" data-confirm-url="<?= BASE_URL ?>/?page=nutrition&action=regime-unfollow&id=<?= (int)$associatedRegimeId ?>" data-confirm-btn="Arrêter"
           style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.45rem 0.82rem;background:rgba(239,68,68,0.08);color:#ef4444;border:1px solid rgba(239,68,68,0.25);border-radius:999px;font-size:0.72rem;font-weight:700;cursor:pointer;transition:all 0.3s"
           onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.borderColor='rgba(239,68,68,0.35)'"
           onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.borderColor='rgba(239,68,68,0.25)'">
          <i data-lucide="x-circle" style="width:0.75rem;height:0.75rem"></i> Arrêter régime
        </button>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Active Plan Widget -->
  <div class="card" style="margin-bottom:1.5rem;padding:0;overflow:hidden;border:2px solid var(--secondary);box-shadow:0 8px 32px rgba(82,183,136,0.12)">
    <div style="height:4px;background:<?= $fpC['grad'] ?>"></div>
    <div style="padding:1.25rem 1.75rem;display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap">
      <!-- Icon -->
      <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;box-shadow:0 4px 14px rgba(45,106,79,0.15);flex-shrink:0">
        <i data-lucide="clipboard-check" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>

      <!-- Info -->
      <div style="flex:1;min-width:200px">
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.3rem;flex-wrap:wrap">
          <span style="font-family:var(--font-heading);font-weight:800;font-size:1rem;color:var(--text-primary)"><?= htmlspecialchars($fp['nom']) ?></span>
          <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.15rem 0.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);color:#16a34a;border-radius:var(--radius-full);font-size:0.65rem;font-weight:700;border:1px solid #bbf7d0">
            <i data-lucide="check-circle" style="width:0.55rem;height:0.55rem"></i> Plan actif
          </span>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.75rem;color:var(--text-muted);flex-wrap:wrap">
          <span><i data-lucide="calendar" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i><?= date('d/m/Y', strtotime($fpDate)) ?> → <?= $endDate ?></span>
          <span><i data-lucide="flame" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i><?= $fp['objectif_calories'] ?> kcal/jour</span>
          <span style="color:var(--secondary);font-weight:700"><i data-lucide="clock" style="width:0.7rem;height:0.7rem;display:inline;vertical-align:middle;margin-right:0.2rem"></i><?= $daysLeft ?> jour<?= $daysLeft > 1 ? 's' : '' ?> restant<?= $daysLeft > 1 ? 's' : '' ?></span>
        </div>
        <!-- Progress bar -->
        <div style="margin-top:0.6rem;max-width:500px">
          <div style="display:flex;justify-content:space-between;font-size:0.65rem;font-weight:600;margin-bottom:0.2rem">
            <span style="color:var(--text-muted)">Progression</span>
            <span style="color:var(--secondary)"><?= $fpProgress ?>%</span>
          </div>
          <div style="height:6px;background:var(--border);border-radius:3px;overflow:hidden">
            <div style="height:100%;width:<?= $fpProgress ?>%;background:linear-gradient(90deg,var(--secondary),#40916C);border-radius:3px;transition:width 0.5s ease"></div>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div style="display:flex;gap:0.6rem;align-items:center;flex-shrink:0">
        <a href="<?= BASE_URL ?>/?page=nutrition&action=plan-detail&id=<?= $fp['id'] ?>"
           style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.55rem 1.25rem;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border-radius:var(--radius-full);font-size:0.8rem;font-weight:700;text-decoration:none;transition:all 0.3s;box-shadow:0 4px 12px rgba(45,106,79,0.25)"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(45,106,79,0.35)'"
           onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(45,106,79,0.25)'">
          <i data-lucide="eye" style="width:0.85rem;height:0.85rem"></i> Consulter
        </a>
      </div>
    </div>
  </div>
  <?php endforeach; endif; ?>

  <!-- Quick Stats -->
  <div class="grid grid-cols-4 gap-4 mb-6">
    <!-- Stat 1 -->
    <div class="card card-interactive" style="padding:1.5rem;text-align:center;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary))"></div>
      <div style="position:absolute;bottom:-20px;right:-20px;width:80px;height:80px;background:radial-gradient(circle,rgba(45,106,79,0.08) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:0.875rem;margin-bottom:0.875rem;box-shadow:0 4px 12px rgba(45,106,79,0.15);transition:all 0.3s" class="stat-icon-home">
        <i data-lucide="apple" style="width:1.375rem;height:1.375rem;color:var(--primary)"></i>
      </div>
      <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">150+</div>
      <div style="font-size:0.75rem;color:var(--text-muted);font-weight:500">Aliments référencés</div>
    </div>

    <!-- Stat 2 -->
    <div class="card card-interactive" style="padding:1.5rem;text-align:center;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#7c3aed,#a78bfa)"></div>
      <div style="position:absolute;bottom:-20px;right:-20px;width:80px;height:80px;background:radial-gradient(circle,rgba(124,58,237,0.06) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:0.875rem;margin-bottom:0.875rem;box-shadow:0 4px 12px rgba(124,58,237,0.15)">
        <i data-lucide="chef-hat" style="width:1.375rem;height:1.375rem;color:#7c3aed"></i>
      </div>
      <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">50+</div>
      <div style="font-size:0.75rem;color:var(--text-muted);font-weight:500">Recettes durables</div>
    </div>

    <!-- Stat 3 -->
    <div class="card card-interactive" style="padding:1.5rem;text-align:center;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#ea580c,#fb923c)"></div>
      <div style="position:absolute;bottom:-20px;right:-20px;width:80px;height:80px;background:radial-gradient(circle,rgba(234,88,12,0.06) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:0.875rem;margin-bottom:0.875rem;box-shadow:0 4px 12px rgba(234,88,12,0.15)">
        <i data-lucide="store" style="width:1.375rem;height:1.375rem;color:#ea580c"></i>
      </div>
      <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">30+</div>
      <div style="font-size:0.75rem;color:var(--text-muted);font-weight:500">Producteurs locaux</div>
    </div>

    <!-- Stat 4 -->
    <div class="card card-interactive" style="padding:1.5rem;text-align:center;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#2563eb,#60a5fa)"></div>
      <div style="position:absolute;bottom:-20px;right:-20px;width:80px;height:80px;background:radial-gradient(circle,rgba(37,99,235,0.06) 0%,transparent 70%);border-radius:50%"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:0.875rem;margin-bottom:0.875rem;box-shadow:0 4px 12px rgba(37,99,235,0.15)">
        <i data-lucide="leaf" style="width:1.375rem;height:1.375rem;color:#2563eb"></i>
      </div>
      <div style="font-family:var(--font-heading);font-size:1.75rem;font-weight:900;color:var(--text-primary);line-height:1;margin-bottom:0.25rem">100%</div>
      <div style="font-size:0.75rem;color:var(--text-muted);font-weight:500">Score carbone</div>
    </div>
  </div>

  <!-- Feature Cards -->
  <div class="grid grid-cols-3 gap-5 mb-6">

    <!-- Nutrition Card -->
    <a href="<?= BASE_URL ?>/?page=nutrition" class="card card-interactive card-glow gradient-border" style="padding:2.25rem;text-decoration:none;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:1.5rem 1.5rem 0 0"></div>
      <!-- Background icon -->
      <div style="position:absolute;bottom:-10px;right:-10px;opacity:0.04">
        <i data-lucide="utensils-crossed" style="width:7rem;height:7rem;color:var(--primary)"></i>
      </div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.75rem;height:3.75rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1.1rem;margin-bottom:1.25rem;box-shadow:0 6px 18px rgba(45,106,79,0.18);transition:all 0.3s" class="feature-icon">
        <i data-lucide="utensils-crossed" style="width:1.75rem;height:1.75rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;color:var(--text-primary);margin-bottom:0.5rem;font-weight:700">Suivi Nutritionnel</h3>
      <p style="font-size:0.85rem;color:var(--text-secondary);line-height:1.65;margin-bottom:1rem">Suivez vos repas, analysez vos macros et atteignez vos objectifs santé.</p>
      <div style="display:inline-flex;align-items:center;gap:0.4rem;color:var(--secondary);font-size:0.82rem;font-weight:700;padding:0.4rem 1rem;background:linear-gradient(135deg,rgba(82,183,136,0.1),rgba(45,106,79,0.08));border-radius:var(--radius-full);border:1px solid rgba(82,183,136,0.2)">
        Explorer <i data-lucide="arrow-right" style="width:0.8rem;height:0.8rem"></i>
      </div>
    </a>

    <!-- Marketplace Card -->
    <a href="<?= BASE_URL ?>/?page=marketplace" class="card card-interactive card-glow gradient-border" style="padding:2.25rem;text-decoration:none;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#ca8a04,var(--accent-orange));border-radius:1.5rem 1.5rem 0 0"></div>
      <div style="position:absolute;bottom:-10px;right:-10px;opacity:0.04">
        <i data-lucide="shopping-basket" style="width:7rem;height:7rem;color:#ca8a04"></i>
      </div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.75rem;height:3.75rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:1.1rem;margin-bottom:1.25rem;box-shadow:0 6px 18px rgba(202,138,4,0.18);transition:all 0.3s" class="feature-icon">
        <i data-lucide="shopping-basket" style="width:1.75rem;height:1.75rem;color:#ca8a04"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;color:var(--text-primary);margin-bottom:0.5rem;font-weight:700">Marketplace Bio</h3>
      <p style="font-size:0.85rem;color:var(--text-secondary);line-height:1.65;margin-bottom:1rem">Produits locaux et bio directement de nos producteurs partenaires.</p>
      <div style="display:inline-flex;align-items:center;gap:0.4rem;color:#ca8a04;font-size:0.82rem;font-weight:700;padding:0.4rem 1rem;background:linear-gradient(135deg,rgba(202,138,4,0.1),rgba(202,138,4,0.06));border-radius:var(--radius-full);border:1px solid rgba(202,138,4,0.2)">
        Explorer <i data-lucide="arrow-right" style="width:0.8rem;height:0.8rem"></i>
      </div>
    </a>

    <!-- Recettes Card -->
    <a href="<?= BASE_URL ?>/?page=recettes" class="card card-interactive card-glow gradient-border" style="padding:2.25rem;text-decoration:none;position:relative;overflow:hidden;border:none">
      <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--accent-orange),#f97316);border-radius:1.5rem 1.5rem 0 0"></div>
      <div style="position:absolute;bottom:-10px;right:-10px;opacity:0.04">
        <i data-lucide="book-open" style="width:7rem;height:7rem;color:var(--accent-orange)"></i>
      </div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.75rem;height:3.75rem;background:linear-gradient(135deg,#fee2e2,#fef2f2);border-radius:1.1rem;margin-bottom:1.25rem;box-shadow:0 6px 18px rgba(231,111,81,0.18);transition:all 0.3s" class="feature-icon">
        <i data-lucide="book-open" style="width:1.75rem;height:1.75rem;color:var(--accent-orange)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;color:var(--text-primary);margin-bottom:0.5rem;font-weight:700">Recettes Durables</h3>
      <p style="font-size:0.85rem;color:var(--text-secondary);line-height:1.65;margin-bottom:1rem">Recettes éco-responsables avec score carbone et valeurs nutritionnelles.</p>
      <div style="display:inline-flex;align-items:center;gap:0.4rem;color:var(--accent-orange);font-size:0.82rem;font-weight:700;padding:0.4rem 1rem;background:linear-gradient(135deg,rgba(231,111,81,0.1),rgba(231,111,81,0.06));border-radius:var(--radius-full);border:1px solid rgba(231,111,81,0.2)">
        Explorer <i data-lucide="arrow-right" style="width:0.8rem;height:0.8rem"></i>
      </div>
    </a>
  </div>

  <!-- Community Card -->
  <div class="card" style="padding:1.75rem;background:linear-gradient(135deg,rgba(45,106,79,0.04),rgba(82,183,136,0.03));border:1px solid rgba(82,183,136,0.15)">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4">
        <div style="display:flex;align-items:center;justify-content:center;width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:1rem;box-shadow:0 4px 14px rgba(37,99,235,0.14)">
          <i data-lucide="message-circle" style="width:1.5rem;height:1.5rem;color:#2563eb"></i>
        </div>
        <div>
          <h4 style="font-family:var(--font-heading);font-weight:700;color:var(--text-primary);font-size:1rem">Communauté & Blog</h4>
          <p style="font-size:0.82rem;color:var(--text-muted);margin-top:2px">Partagez, échangez et inspirez-vous avec la communauté GreenBite.</p>
        </div>
      </div>
      <a href="<?= BASE_URL ?>/?page=community" class="btn btn-sm btn-outline-primary" style="border-radius:var(--radius-full);white-space:nowrap">
        <i data-lucide="users" style="width:0.8rem;height:0.8rem"></i> Rejoindre
      </a>
    </div>
  </div>

</div>
