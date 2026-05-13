# 🌱 GreenBite — Application Web PHP MVC

> Plateforme de nutrition durable développée en **PHP MVC pur** (sans framework) dans le cadre du module **Programmation Web 2A** à l'**ESPRIT School of Engineering** — Année 2025–2026.

[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)](https://mysql.com)
[![Stripe](https://img.shields.io/badge/Stripe-Payments-blueviolet?logo=stripe)](https://stripe.com)
[![License](https://img.shields.io/badge/Licence-Académique-green)](./README.md)

---

## 📦 Modules du Projet

| # | Module | Responsable | Description |
|---|--------|-------------|-------------|
| 1 | **Authentification & Utilisateurs** | — | Inscription, connexion, Google OAuth, Face ID, récupération mot de passe |
| 2 | **Blog & Articles** | — | Publication, modération et commentaires d'articles |
| 3 | **Suivi Nutritionnel** | — | Gestion des repas, aliments, plans et régimes alimentaires |
| 4 | **Marketplace** | — | Boutique de produits bio avec commandes et paiement Stripe |
| 5 | **Recettes Durables** | — | Création, recherche, notation et modération de recettes |
| 6 | **Communauté** | — | Espace social et échanges entre utilisateurs |

---

## 🚀 Installation & Lancement

### Prérequis

- **PHP 8.x** (minimum 7.4)
- **MySQL 8.0+** ou MariaDB
- Un serveur local : **XAMPP**, **WAMP**, ou **MAMP**

---

### 1. Cloner le dépôt

```bash
git clone https://github.com/BA-Hamzaa/Esprit-PW-2A25-2526-GreenBite.git
cd Esprit-PW-2A25-2526-GreenBite
```

---

### 2. Configurer la base de données

1. Ouvrez **phpMyAdmin** et créez une base nommée `greenbite`
2. Importez le fichier `database.sql` situé à la **racine du projet**
3. Paramètres par défaut :
   - **Host** : `localhost`
   - **DB** : `greenbite`
   - **User** : `root`
   - **Password** : *(vide)*

> Si vos identifiants diffèrent, modifiez `config/database.php`.

---

### 3. Démarrer le serveur

**▶️ Option A — Windows (le plus rapide)**

Double-cliquez sur **`start.bat`** à la racine du projet.  
Le serveur démarre et ouvre automatiquement `http://localhost:8000`.

**▶️ Option B — Ligne de commande**

```bash
php -S localhost:8000 -t app/views/public
```

Puis ouvrez : `http://localhost:8000`

**▶️ Option C — Apache (XAMPP / WAMP)**

Placez le dossier dans `htdocs/` (XAMPP) ou `www/` (WAMP) et accédez via :  
`http://localhost/Esprit-PW-2A25-2526-GreenBite/app/views/public/`

---

## 📁 Structure du Projet

```
Esprit-PW-2A25-2526-GreenBite/
│
├── app/
│   ├── controllers/
│   │   ├── AuthController.php          ← Inscription, connexion, Google OAuth, récupération MDP
│   │   ├── FaceAuthController.php      ← Authentification biométrique (Face ID)
│   │   ├── UserController.php          ← Gestion des profils et rôles (ADMIN / COACH / USER)
│   │   ├── ArticleController.php       ← Blog : articles + modération
│   │   ├── CommentController.php       ← Blog : commentaires
│   │   ├── NutritionController.php     ← Repas, aliments, plans, régimes
│   │   ├── MarketplaceController.php   ← Boutique, commandes, Stripe
│   │   └── RecettesController.php      ← Recettes, ingrédients, matériels
│   │
│   ├── models/
│   │   ├── Article.php
│   │   ├── Commentaire.php
│   │   ├── CommentaireRecette.php
│   │   ├── Aliment.php
│   │   ├── Repas.php
│   │   ├── PlanNutritionnel.php
│   │   ├── RegimeAlimentaire.php
│   │   ├── Produit.php
│   │   ├── Commande.php
│   │   ├── Recette.php
│   │   ├── Ingredient.php
│   │   ├── InstructionRecette.php
│   │   ├── Materiel.php
│   │   └── MediaHelper.php
│   │
│   └── views/
│       ├── backoffice/                 ← Interface d'administration
│       │   ├── admin/                  ← Tableau de bord, stats, gestion utilisateurs
│       │   ├── article/
│       │   ├── comment/
│       │   ├── marketplace/
│       │   ├── nutrition/
│       │   ├── recettes/
│       │   └── layouts/
│       │
│       ├── frontoffice/                ← Interface utilisateur
│       │   ├── auth/                   ← Login, signup, Face ID, forgot/reset password
│       │   ├── article/
│       │   ├── community/
│       │   ├── marketplace/
│       │   ├── nutrition/
│       │   ├── recettes/
│       │   ├── layouts/
│       │   │   ├── front_header.php    ← Topbar, sidebar, notifications
│       │   │   └── front_footer.php
│       │   └── home.php
│       │
│       └── public/                     ← Point d'entrée web
│           ├── index.php               ← Front controller (routeur)
│           ├── stripe-intent.php       ← Paiement Stripe (PaymentIntent)
│           ├── nutrition-api.php       ← API nutrition externe
│           ├── .htaccess               ← Réécriture d'URL Apache
│           └── assets/                 ← CSS, JS, images, avatars
│
├── config/
│   ├── database.php                    ← Singleton PDO
│   ├── citations.php                   ← Citations motivationnelles
│   ├── nutrition_apis.php              ← Clés API nutrition
│   ├── stripe.php                      ← Clé secrète Stripe
│   └── bannis.json                     ← Mots bannis (modération)
│
├── vendor/
│   └── PHPMailer-master/               ← Envoi d'emails (récupération MDP, notifications)
│
├── database.sql                        ← Script SQL complet (toutes les tables + données)
├── start.bat                           ← Lanceur Windows (serveur + navigateur)
└── README.md
```

---

## 🗄️ Base de Données

Le fichier `database.sql` contient la totalité du schéma et des données d'exemple.

### Tables principales

| Module | Tables |
|--------|--------|
| **Utilisateurs** | `user`, `coach_request` |
| **Blog** | `article`, `commentaire` |
| **Nutrition** | `repas`, `aliment`, `repas_aliment`, `plan_nutritionnel`, `plan_repas` |
| **Régimes** | `regime_alimentaire` |
| **Marketplace** | `produit`, `commande`, `commande_produit` |
| **Recettes** | `recette`, `ingredient`, `recette_ingredient`, `commentaire_recette`, `instruction_recette`, `materiel`, `recette_materiel` |

> Toutes les connexions utilisent **PDO** (singleton `Database::getConnexion()`). Aucune utilisation de `mysqli` ou `mysql_connect`.

---

## 🔐 Authentification & Sécurité

L'application propose plusieurs méthodes d'authentification :

| Méthode | Détail |
|---------|--------|
| **Email / Mot de passe** | Connexion classique avec hachage `password_hash()` |
| **Google OAuth 2.0** | Connexion via compte Google (redirection OAuth) |
| **Face ID** | Authentification biométrique par reconnaissance faciale (via caméra + API) |
| **Récupération MDP** | Lien sécurisé par email via **PHPMailer** + token temporaire |

### Rôles utilisateurs

| Rôle | Accès |
|------|-------|
| `VISITEUR` | Lecture seule (articles, recettes, produits) |
| `USER` | Toutes les fonctionnalités front + soumissions |
| `COACH` | Accès coach (régimes, plans conseillés) |
| `ADMIN` | Back-office complet — validation, modération, gestion |

---

## 🔔 Système de Notifications

Les utilisateurs connectés reçoivent des notifications en temps réel dans la barre de navigation.

### Badges d'état

| Statut | Couleur | Badge |
|--------|---------|-------|
| `en_attente` | 🟡 Orange | ⏳ En attente |
| `accepte` | 🟢 Vert | ✓ Accepté |
| `refuse` | 🔴 Rouge | ✗ Refusé |

### Types de notifications

| Type | Déclencheur |
|------|-------------|
| **Régime** | Soumission → en attente / accepté / refusé |
| **Plan nutritionnel** | Soumission → accepté / refusé |
| **Repas** | Soumission → accepté / refusé |
| **Recette** | Soumission → acceptée / refusée |
| **Matériel** | Proposition → acceptée / refusée |
| **Commentaire article** | Validé ou signalé par un admin |
| **Avis recette** | Approuvé ou refusé |
| **Commande** | Changement de statut (confirmée / livrée / annulée) |

---

## 🛡️ Workflow de Modération

Pour garantir la qualité et la sécurité du contenu communautaire :

1. **Soumission** : L'utilisateur propose une Recette, un Plan, un Régime ou un Matériel → statut `en_attente`
2. **Visibilité restreinte** : L'élément n'est visible que par son auteur et les administrateurs
3. **Validation Admin** : L'admin approuve (`accepte`) ou refuse (`refuse`) depuis le Back-Office
4. **Motif de refus** : En cas de refus, un commentaire explicatif est affiché à l'utilisateur dans ses notifications

---

## 💳 Paiement — Stripe

Le module Marketplace intègre **Stripe** pour les paiements sécurisés.

- `stripe-intent.php` crée un `PaymentIntent` côté serveur
- La clé secrète Stripe est dans `config/stripe.php`
- Le paiement côté client utilise **Stripe.js**

---

## 🎨 Design System

### Palette de couleurs (variables CSS)

| Variable | Valeur | Usage |
|----------|--------|-------|
| `--primary` | `#2D6A4F` | Vert foncé — couleur principale |
| `--secondary` | `#52B788` | Vert clair — accents |
| `--muted` | `#F4F1DE` | Beige — arrière-plans |
| `--accent-orange` | `#E76F51` | Orange — alertes |
| `--success-green` | `#40C057` | Vert — succès |
| `--charcoal` | `#2D2D2D` | Gris foncé — texte |

### Typographie

- **Titres** : Poppins (600–800)
- **Corps** : Inter (300–600), DM Sans
- Chargées via **Google Fonts CDN**

### Composants

- Dark mode complet (toggle dans la sidebar)
- Glassmorphism sur les cards
- Micro-animations (fade-up, slide-in, bell pulse)
- Notifications panel responsive
- Modal Coach / Modifier profil

---

## 🔗 Routes Principales

| Route | Contrôleur | Description |
|-------|-----------|-------------|
| `/` | — | Page d'accueil publique |
| `/?page=login` | `AuthController` | Connexion |
| `/?page=signup` | `AuthController` | Inscription |
| `/?page=face-login` | `FaceAuthController` | Connexion Face ID |
| `/?page=forgot-password` | `AuthController` | Récupération mot de passe |
| `/?page=article&action=list` | `ArticleController` | Blog & communauté |
| `/?page=nutrition` | `NutritionController` | Suivi nutritionnel (repas) |
| `/?page=nutrition&action=regimes` | `NutritionController` | Régimes alimentaires |
| `/?page=nutrition&action=plans` | `NutritionController` | Plans nutritionnels |
| `/?page=marketplace` | `MarketplaceController` | Boutique produits |
| `/?page=marketplace&action=order` | `MarketplaceController` | Commander |
| `/?page=marketplace&action=history` | `MarketplaceController` | Mes commandes |
| `/?page=recettes` | `RecettesController` | Catalogue recettes |
| `/?page=recettes&action=suggest` | `RecettesController` | Proposer une recette |
| `/?page=admin-stats` | `UserController` | Tableau de bord admin |
| `/?page=admin-users` | `UserController` | Gestion utilisateurs |

---

## ✅ Stack Technique

| Technologie | Rôle |
|-------------|------|
| PHP 8.x | Backend MVC (aucun framework) |
| MySQL / PDO | Base de données |
| HTML5 / CSS3 | Structure et styles (Vanilla CSS) |
| JavaScript ES6 | Interactivité côté client |
| Lucide Icons | Icônes SVG |
| Chart.js | Graphiques nutritionnels |
| Stripe.js | Paiement en ligne |
| PHPMailer | Envoi d'emails transactionnels |
| Google Fonts | Typographie (Inter + Poppins + DM Sans) |
| Face API | Authentification biométrique |

> **Aucun outil de build requis.** Pas de npm, pas de Composer (hors PHPMailer), pas de framework.

---

## 🌿 Branches Git

| Branche | Description |
|---------|-------------|
| `main` | Branche principale — code stable |
| `user-final` | Dernière version utilisateur — fix notifications 3 états |

---

## 👥 Équipe

Projet réalisé dans le cadre du module **Programmation Web — 2ème année** à **ESPRIT School of Engineering**, année académique **2025–2026**.

**Groupe** : GreenBite — 2A25-2526

---

## 📄 Licence

Projet académique — usage interne ESPRIT uniquement.