# 🌱 GreenBite - Application PHP MVC

Application web complète développée en PHP MVC (Modèle-Vue-Contrôleur).

---

## 🚀 Installation & Lancement (Comment exécuter le projet sur un autre environnement)

Pour exécuter ce projet localement ou le partager avec une autre équipe, suivez ces étapes :

### 1. Prérequis
Vous aurez besoin d'un environnement serveur avec **PHP 7.4+** et **MySQL** (par exemple : **XAMPP**, **WAMP**, **MAMP**, ou simplement PHP CLI).

### 2. Configuration de la Base de données
1. Ouvrez phpMyAdmin (ou votre client MySQL) et créez une nouvelle base de données nommée `nutrigreen`.
2. Importez le script SQL `database.sql` (situé à la racine du projet) dans cette base de données pour créer les tables et les données par défaut.
3. Le projet est préconfiguré pour fonctionner avec l'utilisateur `root` sans mot de passe. Si vos identifiants locaux sont différents, modifiez-les dans le fichier `config/database.php`.

### 3. Démarrer le serveur local

**▶️ Option A : Sous Windows (Le plus rapide)**
Double-cliquez simplement sur le fichier `start.bat` situé à la racine du projet. Le serveur se lancera et votre application sera disponible sur `http://localhost:8000`.

**▶️ Option B : En ligne de commande (Mac / Linux / Windows)**
Ouvrez un terminal à la racine du projet et tapez la commande suivante :
```bash
php -S localhost:8000 -t public
```
Rendez-vous ensuite sur `http://localhost:8000` via votre navigateur.

**▶️ Option C : Serveur Apache (XAMPP / WAMP)**
Placez le dossier du projet dans votre répertoire `htdocs` (XAMPP) ou `www` (WAMP). Accédez-y ensuite via `http://localhost/CheminVersLeDossier/public/`.

---

## 📁 Project Structure

```
PHP Greenbite/
├── assets/
│   ├── css/
│   │   ├── fonts.css        ← Google Fonts (Inter + Poppins)
│   │   ├── variables.css    ← CSS custom properties (design tokens)
│   │   └── style.css        ← Main stylesheet (imports fonts + variables)
│   └── js/
│       └── main.js          ← Icons, password toggles, filters, sidebar
├── pages/                   ← HTML templates (→ become PHP views)
│   ├── landing.html         ← Home / Landing page
│   ├── login.html           ← Login form
│   ├── signup.html          ← Registration form
│   ├── dashboard.html       ← User dashboard (with sidebar)
│   ├── nutrition.html       ← Nutrition tracking page
│   ├── marketplace.html     ← Product marketplace
│   ├── recipes.html         ← Recipe browser
│   ├── community.html       ← Community forum
│   ├── admin-dashboard.html ← Admin overview
│   ├── admin-users.html     ← Admin user management
│   ├── admin-stats.html     ← Admin statistics
│   └── 404.html             ← Not found page
└── README.md
```

---

## 🚀 How to Use with PHP MVC

### 1. Copy assets into your PHP project

```
your-php-project/
├── public/
│   ├── assets/
│   │   ├── css/     ← Copy css/ folder here
│   │   └── js/      ← Copy js/ folder here
│   └── index.php    ← Front controller
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/       ← Convert HTML pages to PHP views here
└── ...
```

### 2. Convert HTML pages to PHP views

Each HTML file in `pages/` maps to a PHP view file. Example for `dashboard.html`:

```php
<!-- views/dashboard/index.php -->
<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>

<div class="page-content">
  <div class="topbar">
    <h1 class="text-3xl font-bold" style="color:var(--primary)">
      Bonjour, <?= htmlspecialchars($user->name) ?> 👋
    </h1>
  </div>
  <!-- ... rest of page content ... -->
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
```

### 3. Extract reusable partials

The sidebar is repeated across pages. Extract it into a partial:

```php
<!-- views/partials/sidebar.php -->
<nav class="sidebar">
  <div class="sidebar-logo">
    <a href="<?= BASE_URL ?>/">
      <span data-icon="leaf"></span>
      <span class="logo-text">GreenBite</span>
    </a>
  </div>
  <!-- ... -->
  <div class="sidebar-nav">
    <ul class="space-y-1">
      <li>
        <a href="<?= BASE_URL ?>/dashboard"
           class="sidebar-nav-item <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
          <span data-icon="home"></span>
          <span>Tableau de bord</span>
        </a>
      </li>
      <!-- more items... -->
    </ul>
  </div>
</nav>
```

### 4. Replace static data with PHP variables

Throughout the templates you'll find comments like:
```html
<!-- PHP: foreach($meals as $meal): -->
<!-- PHP: <?= $user->name ?> -->
```

These mark where to replace static HTML with dynamic PHP data.

### 5. Update asset paths

In your PHP layout/header partial, update CSS/JS paths:

```php
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
```

---

## 🎨 Design System

### Color Palette (CSS Variables)

| Variable | Color | Usage |
|----------|-------|-------|
| `--primary` | `#2D6A4F` | Dark green, primary brand |
| `--secondary` | `#52B788` | Light green, accents |
| `--muted` | `#F4F1DE` | Beige backgrounds |
| `--accent-orange` | `#E76F51` | Orange accent / alerts |
| `--success-green` | `#40C057` | Success states |
| `--charcoal` | `#2D2D2D` | Dark text / footer |

### Typography

- **Headings**: Poppins (600-700 weight)
- **Body**: Inter (300-600 weight)
- Loaded via Google Fonts CDN

### Component Classes

| Class | Description |
|-------|-------------|
| `.btn .btn-primary` | Primary green button |
| `.btn .btn-secondary` | Light green button |
| `.btn .btn-outline` | Border-only button |
| `.btn .btn-lg` / `.btn-sm` | Size variants |
| `.card` | White card with shadow |
| `.badge .badge-*` | Status/tag badges |
| `.form-input` | Styled input field |
| `.form-input-icon` | Input with left icon |
| `.progress` + `.progress-bar` | Progress bars |
| `.filter-pill` | Filterable pill buttons |
| `.sidebar` | Dashboard sidebar |
| `.admin-sidebar` | Admin sidebar (dark) |
| `.avatar .avatar-sm/md/lg` | User avatar circles |

### Icons

Icons are rendered via inline SVGs defined in `main.js`. Use them with:

```html
<span data-icon="leaf"></span>
<span data-icon="home"></span>
<span data-icon="users"></span>
```

Available icons: `leaf`, `home`, `utensils`, `shopping-basket`, `book-open`, `message-circle`, `settings`, `log-out`, `mail`, `lock`, `user`, `users`, `eye`, `eye-off`, `check`, `flame`, `droplets`, `globe`, `target`, `plus`, `map-pin`, `search`, `filter`, `clock`, `heart`, `share`, `thumbs-up`, `edit`, `trash`, `bar-chart`, `shopping-cart`, `dollar-sign`, `trending-up`

---

## 📄 Page → Route Mapping

| HTML Template | Suggested PHP Route | Controller |
|--------------|-------------------|------------|
| `landing.html` | `/` | `HomeController@index` |
| `login.html` | `/login` | `AuthController@login` |
| `signup.html` | `/signup` | `AuthController@register` |
| `dashboard.html` | `/dashboard` | `DashboardController@index` |
| `nutrition.html` | `/nutrition` | `NutritionController@index` |
| `marketplace.html` | `/marketplace` | `MarketplaceController@index` |
| `recipes.html` | `/recipes` | `RecipeController@index` |
| `community.html` | `/community` | `CommunityController@index` |
| `admin-dashboard.html` | `/admin` | `AdminController@dashboard` |
| `admin-users.html` | `/admin/users` | `AdminController@users` |
| `admin-stats.html` | `/admin/stats` | `AdminController@stats` |
| `404.html` | `*` (fallback) | `ErrorController@notFound` |

---

## 📊 Charts

The admin pages have placeholder areas for charts. For your PHP project, integrate **Chart.js**:

```html
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```

Then replace the placeholder divs with `<canvas>` elements and initialize charts with your PHP-rendered data.

---

## ✅ No Build Tools Required

This template uses:
- ✅ Plain HTML
- ✅ Vanilla CSS (no Tailwind, no SASS)
- ✅ Vanilla JavaScript (no React, no npm)
- ✅ Google Fonts CDN
- ✅ No build step needed

Just copy the files and start coding your PHP backend!