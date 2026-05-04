<?php /* order.php — Stripe + Mapbox Checkout */ ?>
<style>
.checkout-wrap{padding:2rem;max-width:56rem}
.step-bar{display:flex;align-items:center;margin-bottom:2rem}
.step-item{display:flex;align-items:center;gap:.6rem;font-size:.82rem;font-weight:600;color:var(--text-muted)}
.step-item.active{color:var(--primary)}
.step-dot{width:2rem;height:2rem;border-radius:50%;background:var(--muted);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;transition:all .3s;flex-shrink:0}
.step-item.active .step-dot{background:linear-gradient(135deg,#2D6A4F,#52B788);border-color:#2D6A4F;color:#fff;box-shadow:0 4px 12px rgba(45,106,79,.35)}
.step-item.done .step-dot{background:linear-gradient(135deg,#52B788,#95d5b2);border-color:#52B788;color:#fff}
.step-line{flex:1;height:2px;background:var(--border);margin:0 .75rem;border-radius:2px;transition:background .3s}
.step-line.active{background:linear-gradient(90deg,#52B788,var(--border))}
/* Map */
#map-container{border-radius:.875rem;overflow:hidden;border:1.5px solid var(--border);margin-top:.75rem;position:relative}
#delivery-map{height:240px;width:100%}
.mapboxgl-ctrl-geocoder{font-family:inherit!important;width:100%!important;max-width:100%!important;border-radius:.625rem!important;box-shadow:none!important;border:1.5px solid var(--border)!important}
.mapboxgl-ctrl-geocoder input{font-size:.875rem!important;padding:.6rem .6rem .6rem 2.5rem!important}
.mapboxgl-ctrl-geocoder--icon-search{top:10px!important}
/* Stripe */
#stripe-card-wrap{background:linear-gradient(135deg,rgba(45,106,79,.06),rgba(82,183,136,.04));border:1.5px solid rgba(82,183,136,.25);border-radius:1rem;padding:1.25rem}
#card-element{padding:.75rem;background:var(--surface);border:1.5px solid var(--border);border-radius:.625rem;transition:border-color .2s,background .2s}
#card-element.StripeElement--focus{border-color:var(--secondary);box-shadow:0 0 0 3px rgba(82,183,136,.12)}
#card-errors{color:#f87171;font-size:.8rem;margin-top:.5rem;min-height:1.2rem;display:flex;align-items:center;gap:.35rem}
.pay-btn{width:100%;padding:1rem;background:linear-gradient(135deg,#2D6A4F,#52B788);color:#fff;border:none;border-radius:.875rem;font-size:1rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.6rem;transition:all .3s;margin-top:1.25rem;letter-spacing:.01em}
.pay-btn:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 24px rgba(45,106,79,.35)}
.pay-btn:disabled{opacity:.65;cursor:not-allowed;transform:none}
.pay-btn .spinner{width:1.1rem;height:1.1rem;border:2.5px solid rgba(255,255,255,.35);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none}
@keyframes spin{to{transform:rotate(360deg)}}
.test-cards{background:rgba(82,183,136,.06);border:1px dashed rgba(82,183,136,.3);border-radius:.625rem;padding:.75rem 1rem;margin-top:.875rem}
.test-cards h4{font-size:.72rem;font-weight:700;color:var(--secondary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.4rem}
.test-cards code{font-size:.78rem;background:var(--muted);color:var(--text-primary);padding:.15rem .5rem;border-radius:.3rem;border:1px solid var(--border);display:inline-block;margin:.1rem .2rem .1rem 0;font-family:monospace}
.cart-mini-item{display:flex;align-items:center;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--border)}
.cart-mini-item:last-child{border:none}
.secure-badge{display:flex;align-items:center;justify-content:center;gap:.4rem;font-size:.72rem;color:var(--text-muted);margin-top:.875rem}
[data-theme="dark"] #stripe-card-wrap{background:rgba(255,255,255,.04)!important;border-color:rgba(255,255,255,.12)!important}
[data-theme="dark"] #card-element{background:rgba(255,255,255,.06)!important;border-color:rgba(255,255,255,.12)!important}
[data-theme="dark"] .test-cards{background:rgba(82,183,136,.1);border-color:rgba(82,183,136,.25)}
[data-theme="dark"] .cart-mini-item .label{color:var(--text-muted)}
</style>

<?php if (empty($cartItems)): ?>
<div class="checkout-wrap">
  <div class="card" style="padding:3rem;text-align:center">
    <i data-lucide="shopping-cart" style="width:3rem;height:3rem;color:var(--text-muted);margin:0 auto 1rem;display:block"></i>
    <h2 style="color:var(--text-primary);margin-bottom:.5rem">Votre panier est vide</h2>
    <p style="color:var(--text-muted);margin-bottom:1.5rem">Ajoutez des produits avant de passer commande.</p>
    <a href="<?= BASE_URL ?>/?page=marketplace" class="btn btn-primary">Explorer les produits</a>
  </div>
</div>
<?php return; endif; ?>

<div class="checkout-wrap">
  <!-- Back -->
  <a href="<?= BASE_URL ?>/?page=marketplace" class="flex items-center gap-2 text-sm mb-5" style="color:var(--secondary);font-weight:500;transition:all .3s" onmouseover="this.style.transform='translateX(-4px)'" onmouseout="this.style.transform=''">
    <i data-lucide="arrow-left" style="width:1rem;height:1rem"></i> Retour aux produits
  </a>

  <!-- Step bar -->
  <div class="step-bar" id="stepBar">
    <div class="step-item active" id="si1"><div class="step-dot">1</div><span>Informations</span></div>
    <div class="step-line" id="sl1"></div>
    <div class="step-item" id="si2"><div class="step-dot">2</div><span>Paiement</span></div>
  </div>

  <?php if (!empty($errors)): ?>
  <div class="p-4 rounded-xl mb-5 flex items-start gap-3" style="background:linear-gradient(135deg,#fee2e2,#fef2f2);color:#991b1b;border:1px solid #fca5a5">
    <i data-lucide="alert-triangle" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px"></i>
    <div><?php foreach ($errors as $e): ?><div><?= htmlspecialchars($e) ?></div><?php endforeach; ?></div>
  </div>
  <?php endif; ?>

  <!-- ======= STEP 1: Info + Mapbox ======= -->
  <div id="step1">
    <div class="card" style="padding:1.75rem;margin-bottom:1.25rem">
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)">
        <i data-lucide="user" style="width:1rem;height:1rem;color:var(--primary)"></i> Vos informations
      </h2>
      <div class="grid grid-cols-2 gap-4">
        <div class="form-group">
          <label class="form-label" for="f_nom"><i data-lucide="type" style="width:.75rem;height:.75rem"></i> Nom complet</label>
          <input type="text" id="f_nom" class="form-input" placeholder="Ahmed Ben Ali" value="<?= htmlspecialchars($_POST['client_nom'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label class="form-label" for="f_email"><i data-lucide="mail" style="width:.75rem;height:.75rem"></i> Email</label>
          <input type="email" id="f_email" class="form-input" placeholder="ahmed@email.com" value="<?= htmlspecialchars($_POST['client_email'] ?? '') ?>">
        </div>
      </div>

      <!-- Mapbox Address -->
      <div class="form-group mt-2">
        <label class="form-label"><i data-lucide="map-pin" style="width:.75rem;height:.75rem"></i> Adresse de livraison</label>
        <div id="geocoder-container"></div>
        <div id="map-container">
          <div id="delivery-map"></div>
          <div id="map-overlay" style="position:absolute;bottom:.5rem;left:.5rem;background:rgba(255,255,255,.9);backdrop-filter:blur(8px);padding:.3rem .7rem;border-radius:999px;font-size:.72rem;color:#374151;border:1px solid rgba(0,0,0,.1)">
            <i data-lucide="navigation" style="width:.65rem;height:.65rem;display:inline-block;margin-right:.2rem"></i> Déplacez le marqueur pour affiner
          </div>
        </div>
        <input type="hidden" id="h_adresse" placeholder="">
        <input type="hidden" id="h_lat" value="">
        <input type="hidden" id="h_lng" value="">
        <div id="addr-error" style="color:#dc2626;font-size:.78rem;margin-top:.35rem;display:none">⚠ Veuillez sélectionner une adresse.</div>
      </div>

      <!-- Cart mini-summary -->
      <div style="border-top:1px solid var(--border);margin-top:1.25rem;padding-top:1.25rem">
        <h3 class="font-semibold mb-3 text-sm" style="color:var(--text-primary)">🛒 Récapitulatif</h3>
        <?php foreach ($cartItems as $ci): ?>
        <div class="cart-mini-item">
          <span style="font-size:.875rem;color:var(--text-primary)"><?= htmlspecialchars($ci['nom']) ?> <span style="color:var(--text-muted)">× <?= $ci['cart_qty'] ?></span></span>
          <span style="font-weight:700;color:#f97316"><?= number_format($ci['subtotal'], 2) ?> DT</span>
        </div>
        <?php endforeach; ?>
        <div style="display:flex;justify-content:space-between;padding-top:.875rem;font-size:1rem">
          <span style="font-weight:600;color:var(--text-primary)">Total</span>
          <span style="font-weight:800;color:var(--primary);font-size:1.15rem"><?= number_format($cartTotal, 2) ?> DT</span>
        </div>
      </div>
    </div>

    <button onclick="goToStep2()" class="pay-btn" id="continueBtn">
      <i data-lucide="credit-card" style="width:1.1rem;height:1.1rem"></i> Continuer vers le paiement
      <i data-lucide="arrow-right" style="width:1.1rem;height:1.1rem;margin-left:.25rem"></i>
    </button>
  </div>

  <!-- ======= STEP 2: Stripe Payment ======= -->
  <div id="step2" style="display:none">
    <!-- Back to step 1 -->
    <button onclick="goToStep1()" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:.4rem;color:var(--secondary);font-size:.85rem;font-weight:600;margin-bottom:1.25rem;padding:0" onmouseover="this.style.transform='translateX(-3px)'" onmouseout="this.style.transform=''">
      <i data-lucide="arrow-left" style="width:.9rem;height:.9rem"></i> Modifier mes informations
    </button>

    <!-- Info summary -->
    <div class="card mb-4" style="padding:1rem 1.25rem;background:linear-gradient(135deg,rgba(45,106,79,.04),transparent);border:1px solid rgba(82,183,136,.2)">
      <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap">
        <span style="font-size:.82rem;color:var(--text-muted)">👤</span>
        <span id="s2-nom" style="font-weight:600;font-size:.875rem;color:var(--text-primary)"></span>
        <span style="color:var(--border)">•</span>
        <span id="s2-email" style="font-size:.82rem;color:var(--text-muted)"></span>
        <span style="color:var(--border)">•</span>
        <span id="s2-addr" style="font-size:.82rem;color:var(--text-muted);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:24rem"></span>
      </div>
    </div>

    <!-- Stripe card -->
    <div class="card" style="padding:1.75rem">
      <h2 class="font-semibold mb-4 flex items-center gap-2" style="color:var(--text-primary)">
        <i data-lucide="lock" style="width:1rem;height:1rem;color:var(--secondary)"></i> Paiement sécurisé
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" style="height:1.1rem;margin-left:auto;opacity:.6">
      </h2>

      <div id="stripe-card-wrap">
        <label style="font-size:.78rem;font-weight:600;color:var(--text-muted);display:flex;align-items:center;gap:.35rem;margin-bottom:.625rem;text-transform:uppercase;letter-spacing:.04em">
          <i data-lucide="credit-card" style="width:.85rem;height:.85rem"></i> Coordonnées de carte
        </label>
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>
      </div>

      <!-- Total -->
      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1.25rem;padding:1rem;background:var(--muted);border-radius:.75rem">
        <div>
          <div style="font-size:.75rem;color:var(--text-muted);margin-bottom:.15rem"><?= $cartCount ?> article<?= $cartCount > 1 ? 's' : '' ?></div>
          <div style="font-weight:800;font-size:1.1rem;color:var(--text-primary)">Total à payer</div>
        </div>
        <div style="font-weight:900;font-size:1.4rem;color:var(--primary)"><?= number_format($cartTotal, 2) ?> DT</div>
      </div>

      <button class="pay-btn" id="payBtn" onclick="handlePayment()">
        <div class="spinner" id="paySpinner"></div>
        <i data-lucide="shield-check" style="width:1.1rem;height:1.1rem" id="payIcon"></i>
        <span id="payBtnText">Payer <?= number_format($cartTotal, 2) ?> DT</span>
      </button>

      <div class="secure-badge">
        <i data-lucide="lock" style="width:.75rem;height:.75rem"></i> Crypté SSL · Sécurisé par Stripe · Aucune donnée stockée
      </div>

      <!-- Test cards hint -->
      <div class="test-cards">
        <h4>🧪 Cartes de test Stripe</h4>
        <code>4242 4242 4242 4242</code> ✅ Succès &nbsp;
        <code>4000 0000 0000 0002</code> ❌ Refusée &nbsp;
        <code>4000 0025 0000 3155</code> 🔒 3D Secure<br>
        <span style="font-size:.72rem;color:var(--text-muted)">Date: toute date future · CVC: 3 chiffres quelconques</span>
      </div>
    </div>
  </div>

  <!-- Hidden form submitted after Stripe confirms -->
  <form id="confirmForm" method="POST" action="" style="display:none">
    <input type="hidden" name="stripe_payment_intent_id" id="h_pi_id">
    <input type="hidden" name="client_nom"     id="h_pi_nom">
    <input type="hidden" name="client_email"   id="h_pi_email">
    <input type="hidden" name="client_adresse" id="h_pi_adresse">
    <input type="hidden" name="client_lat"     id="h_pi_lat">
    <input type="hidden" name="client_lng"     id="h_pi_lng">
    <?php foreach ($cartItems as $ci): ?>
    <input type="hidden" name="produit_ids[]" value="<?= $ci['id'] ?>">
    <input type="hidden" name="quantites[]"   value="<?= $ci['cart_qty'] ?>">
    <?php endforeach; ?>
  </form>
</div>

<!-- Mapbox CDN -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.css">
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.min.js"></script>
<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
// ============ MAPBOX ============
mapboxgl.accessToken = '<?= MAPBOX_TOKEN ?>';

const map = new mapboxgl.Map({
  container: 'delivery-map',
  style: 'mapbox://styles/mapbox/streets-v12',
  center: [10.1815, 36.8065], // Tunis default
  zoom: 11
});

map.addControl(new mapboxgl.NavigationControl(), 'top-right');

const marker = new mapboxgl.Marker({ color: '#2D6A4F', draggable: true })
  .setLngLat([10.1815, 36.8065])
  .addTo(map);

// Geocoder
const geocoder = new MapboxGeocoder({
  accessToken: mapboxgl.accessToken,
  mapboxgl: mapboxgl,
  marker: false,
  placeholder: 'Rechercher une adresse...',
  language: 'fr',
  countries: 'tn,fr,ma,dz,be,ch',
  proximity: { longitude: 10.1815, latitude: 36.8065 }
});

document.getElementById('geocoder-container').appendChild(geocoder.onAdd(map));

geocoder.on('result', function(e) {
  const coords = e.result.center;
  const place  = e.result.place_name;
  marker.setLngLat(coords);
  map.flyTo({ center: coords, zoom: 14, speed: 1.4 });
  document.getElementById('h_adresse').value = place;
  document.getElementById('h_lat').value = coords[1];
  document.getElementById('h_lng').value = coords[0];
  document.getElementById('addr-error').style.display = 'none';
});

marker.on('dragend', function() {
  const lngLat = marker.getLngLat();
  document.getElementById('h_lat').value = lngLat.lat;
  document.getElementById('h_lng').value = lngLat.lng;
  // Reverse geocode
  fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lngLat.lng},${lngLat.lat}.json?access_token=${mapboxgl.accessToken}&language=fr`)
    .then(r => r.json())
    .then(d => {
      if (d.features && d.features[0]) {
        const addr = d.features[0].place_name;
        document.getElementById('h_adresse').value = addr;
        geocoder.setInput(addr);
      }
    });
});

// ============ STEPS ============
function goToStep2() {
  const nom     = document.getElementById('f_nom').value.trim();
  const email   = document.getElementById('f_email').value.trim();
  const adresse = document.getElementById('h_adresse').value.trim();

  let ok = true;
  const setErr = (id, msg) => { const el = document.getElementById(id); if (el) { el.textContent = msg; el.style.display = msg ? 'block' : 'none'; } };

  if (!nom)   { setErr('nom-err', 'Nom obligatoire.'); ok = false; }   else setErr('nom-err', '');
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { setErr('email-err', 'Email invalide.'); ok = false; } else setErr('email-err', '');
  if (!adresse || adresse.length < 5) { document.getElementById('addr-error').style.display = 'block'; ok = false; }

  if (!ok) return;

  document.getElementById('s2-nom').textContent   = nom;
  document.getElementById('s2-email').textContent = email;
  document.getElementById('s2-addr').textContent  = adresse;

  document.getElementById('step1').style.display = 'none';
  document.getElementById('step2').style.display = 'block';
  document.getElementById('si1').classList.remove('active'); document.getElementById('si1').classList.add('done');
  document.getElementById('si2').classList.add('active');
  document.getElementById('sl1').classList.add('active');
  window.scrollTo({top: 0, behavior: 'smooth'});

  if (!stripe) initStripe();
}

function goToStep1() {
  document.getElementById('step2').style.display = 'none';
  document.getElementById('step1').style.display = 'block';
  document.getElementById('si2').classList.remove('active');
  document.getElementById('si1').classList.remove('done'); document.getElementById('si1').classList.add('active');
  document.getElementById('sl1').classList.remove('active');
}

// ============ STRIPE ============
let stripe = null, cardElement = null, paymentInProgress = false;

function initStripe() {
  const dark = document.documentElement.getAttribute('data-theme') === 'dark';
  stripe = Stripe('<?= STRIPE_PUBLISHABLE_KEY ?>');
  const elements = stripe.elements({
    fonts: [{ cssSrc: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap' }]
  });
  cardElement = elements.create('card', {
    style: {
      base: {
        fontFamily: "'Inter', sans-serif",
        fontSize: '15px',
        color: dark ? '#f1f5f9' : '#1a1a2e',
        '::placeholder': { color: dark ? '#64748b' : '#9ca3af' },
        iconColor: dark ? '#4ade80' : '#2D6A4F',
        backgroundColor: 'transparent',
      },
      invalid: { color: '#f87171', iconColor: '#f87171' }
    },
    hidePostalCode: true
  });
  cardElement.mount('#card-element');

  // Fix card element background for dark mode
  if (dark) {
    document.getElementById('card-element').style.background = 'rgba(255,255,255,0.06)';
    document.getElementById('card-element').style.border = '1.5px solid rgba(255,255,255,0.12)';
    document.getElementById('stripe-card-wrap').style.background = 'rgba(255,255,255,0.04)';
    document.getElementById('stripe-card-wrap').style.border = '1.5px solid rgba(255,255,255,0.1)';
  }

  cardElement.on('change', e => {
    const el = document.getElementById('card-errors');
    if (e.error) { el.innerHTML = '⚠ ' + e.error.message; }
    else { el.innerHTML = ''; }
  });
}

async function handlePayment() {
  if (paymentInProgress) return;
  paymentInProgress = true;

  const btn     = document.getElementById('payBtn');
  const spinner = document.getElementById('paySpinner');
  const icon    = document.getElementById('payIcon');
  const errEl   = document.getElementById('card-errors');

  btn.disabled = true;
  spinner.style.display = 'block';
  icon.style.display = 'none';
  errEl.innerHTML = '';

  try {
    // 1. Create PaymentIntent on server
    const intentResp = await fetch('stripe-intent.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ amount: <?= $cartTotal ?> })
    });
    const intentData = await intentResp.json();

    if (intentData.error) throw new Error(intentData.error);

    // 2. Confirm payment with Stripe.js
    const { error, paymentIntent } = await stripe.confirmCardPayment(intentData.client_secret, {
      payment_method: {
        card: cardElement,
        billing_details: {
          name:  document.getElementById('f_nom').value.trim(),
          email: document.getElementById('f_email').value.trim(),
        }
      }
    });

    if (error) throw new Error(error.message);

    if (paymentIntent.status === 'succeeded') {
      // 3. Submit hidden form to save order in DB
      document.getElementById('h_pi_id').value      = paymentIntent.id;
      document.getElementById('h_pi_nom').value     = document.getElementById('f_nom').value.trim();
      document.getElementById('h_pi_email').value   = document.getElementById('f_email').value.trim();
      document.getElementById('h_pi_adresse').value = document.getElementById('h_adresse').value.trim();
      document.getElementById('h_pi_lat').value     = document.getElementById('h_lat').value;
      document.getElementById('h_pi_lng').value     = document.getElementById('h_lng').value;

      document.getElementById('payBtnText').textContent = '✅ Paiement réussi ! Redirection...';
      document.getElementById('confirmForm').submit();
    }

  } catch(err) {
    errEl.innerHTML = '⚠ ' + err.message;
    btn.disabled = false;
    spinner.style.display = 'none';
    icon.style.display = 'block';
    paymentInProgress = false;
  }
}

// inline error spans
document.getElementById('f_nom').insertAdjacentHTML('afterend','<div id="nom-err" style="color:#dc2626;font-size:.78rem;margin-top:.25rem;display:none"></div>');
document.getElementById('f_email').insertAdjacentHTML('afterend','<div id="email-err" style="color:#dc2626;font-size:.78rem;margin-top:.25rem;display:none"></div>');

document.getElementById('f_nom').addEventListener('input', () => { document.getElementById('nom-err').style.display='none'; });
document.getElementById('f_email').addEventListener('input', () => { document.getElementById('email-err').style.display='none'; });
</script>
