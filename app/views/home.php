<!-- ===== Homepage Dashboard ===== -->
<div style="padding:2rem">
  <!-- Welcome Hero -->
  <div class="card" style="padding:2.5rem;background:linear-gradient(135deg, #1B4332 0%, var(--primary) 30%, #245a42 60%, #52B788 100%);color:#fff;border:none;position:relative;overflow:hidden;margin-bottom:2rem">
    <div style="position:absolute;top:-50px;right:-50px;width:250px;height:250px;background:radial-gradient(circle, rgba(167,243,208,0.15) 0%, transparent 70%);border-radius:50%;animation:float 6s ease-in-out infinite"></div>
    <div style="position:absolute;bottom:-30px;left:-30px;width:150px;height:150px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%, transparent 70%);border-radius:50%"></div>
    <div style="position:relative;z-index:1">
      <div class="flex items-center gap-3 mb-4">
        <div style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:rgba(255,255,255,0.12);backdrop-filter:blur(10px);border-radius:1rem;border:1px solid rgba(255,255,255,0.15);animation:float 3s ease-in-out infinite">
          <i data-lucide="leaf" style="width:1.75rem;height:1.75rem;color:#a7f3d0"></i>
        </div>
        <div>
          <h1 style="font-family:var(--font-heading);font-size:1.75rem;font-weight:800;letter-spacing:-0.02em">
            Bienvenue sur <span style="background:linear-gradient(90deg,#a7f3d0,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent">NutriGreen</span>
          </h1>
          <p style="color:rgba(255,255,255,0.6);font-size:0.875rem">Votre compagnon pour une alimentation durable</p>
        </div>
      </div>
      <div class="flex gap-3 mt-4">
        <a href="<?= BASE_URL ?>/?page=nutrition" class="btn btn-sm btn-round" style="background:#fff;color:var(--primary);font-weight:700">
          <i data-lucide="utensils-crossed" style="width:0.875rem;height:0.875rem"></i> Suivi Nutritionnel
        </a>
        <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-sm btn-round" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3)">
          <i data-lucide="shopping-basket" style="width:0.875rem;height:0.875rem"></i> Marketplace
        </a>
        <a href="<?= BASE_URL ?>/?page=recettes" class="btn btn-sm btn-round" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3)">
          <i data-lucide="book-open" style="width:0.875rem;height:0.875rem"></i> Recettes
        </a>
      </div>
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card card-interactive" style="padding:1.25rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:var(--radius-xl);margin-bottom:0.75rem">
        <i data-lucide="apple" style="width:1.25rem;height:1.25rem;color:var(--primary)"></i>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">150+</div>
      <div class="text-xs" style="color:var(--text-muted)">Aliments référencés</div>
    </div>
    <div class="card card-interactive" style="padding:1.25rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:linear-gradient(135deg,#ede9fe,#f5f3ff);border-radius:var(--radius-xl);margin-bottom:0.75rem">
        <i data-lucide="chef-hat" style="width:1.25rem;height:1.25rem;color:#7c3aed"></i>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">50+</div>
      <div class="text-xs" style="color:var(--text-muted)">Recettes durables</div>
    </div>
    <div class="card card-interactive" style="padding:1.25rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:linear-gradient(135deg,#fed7aa,#fff7ed);border-radius:var(--radius-xl);margin-bottom:0.75rem">
        <i data-lucide="store" style="width:1.25rem;height:1.25rem;color:#ea580c"></i>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">30+</div>
      <div class="text-xs" style="color:var(--text-muted)">Producteurs locaux</div>
    </div>
    <div class="card card-interactive" style="padding:1.25rem;text-align:center">
      <div style="display:inline-flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;background:linear-gradient(135deg,#dbeafe,#eff6ff);border-radius:var(--radius-xl);margin-bottom:0.75rem">
        <i data-lucide="leaf" style="width:1.25rem;height:1.25rem;color:#2563eb"></i>
      </div>
      <div class="text-2xl font-bold" style="color:var(--text-primary);font-family:var(--font-heading)">100%</div>
      <div class="text-xs" style="color:var(--text-muted)">Score carbone</div>
    </div>
  </div>

  <!-- Feature Cards -->
  <div class="grid grid-cols-3 gap-6 mb-6">
    <a href="<?= BASE_URL ?>/?page=nutrition" class="card card-interactive card-glow" style="padding:2rem;border:none;text-decoration:none;position:relative;overflow:hidden">
      <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--primary),var(--secondary))"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,#dcfce7,#f0fdf4);border-radius:1rem;margin-bottom:1.25rem">
        <i data-lucide="utensils-crossed" style="width:1.5rem;height:1.5rem;color:var(--primary)"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;color:var(--primary);margin-bottom:0.5rem;font-weight:700">Suivi Nutritionnel</h3>
      <p class="text-sm" style="color:var(--text-secondary);line-height:1.6">Suivez vos repas, analysez vos macros et atteignez vos objectifs.</p>
      <div class="flex items-center gap-1 mt-3" style="color:var(--secondary);font-size:0.8rem;font-weight:600">Explorer <i data-lucide="arrow-right" style="width:0.75rem;height:0.75rem"></i></div>
    </a>

    <a href="<?= BASE_URL ?>/?page=marketplace" class="card card-interactive card-glow" style="padding:2rem;border:none;text-decoration:none;position:relative;overflow:hidden">
      <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--secondary),var(--accent-orange))"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,#fef9c3,#fefce8);border-radius:1rem;margin-bottom:1.25rem">
        <i data-lucide="shopping-basket" style="width:1.5rem;height:1.5rem;color:#ca8a04"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;color:var(--primary);margin-bottom:0.5rem;font-weight:700">Marketplace Bio</h3>
      <p class="text-sm" style="color:var(--text-secondary);line-height:1.6">Produits locaux et bio de producteurs partenaires.</p>
      <div class="flex items-center gap-1 mt-3" style="color:var(--secondary);font-size:0.8rem;font-weight:600">Explorer <i data-lucide="arrow-right" style="width:0.75rem;height:0.75rem"></i></div>
    </a>

    <a href="<?= BASE_URL ?>/?page=recettes" class="card card-interactive card-glow" style="padding:2rem;border:none;text-decoration:none;position:relative;overflow:hidden">
      <div style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--accent-orange),#E76F51)"></div>
      <div style="display:inline-flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;background:linear-gradient(135deg,#fee2e2,#fef2f2);border-radius:1rem;margin-bottom:1.25rem">
        <i data-lucide="book-open" style="width:1.5rem;height:1.5rem;color:#E76F51"></i>
      </div>
      <h3 style="font-family:var(--font-heading);font-size:1.1rem;color:var(--primary);margin-bottom:0.5rem;font-weight:700">Recettes Durables</h3>
      <p class="text-sm" style="color:var(--text-secondary);line-height:1.6">Recettes éco-responsables avec score carbone intégré.</p>
      <div class="flex items-center gap-1 mt-3" style="color:var(--secondary);font-size:0.8rem;font-weight:600">Explorer <i data-lucide="arrow-right" style="width:0.75rem;height:0.75rem"></i></div>
    </a>
  </div>

</div>
