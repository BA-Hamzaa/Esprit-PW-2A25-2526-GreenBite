# 🌱 GreenBite — Application Web PHP MVC

> Plateforme de nutrition durable développée en PHP MVC pur (sans framework) dans le cadre du module **Programmation Web 2A** à l'ESPRIT.

---

## 📦 Modules du Projet

| # | Module | Description |
|---|--------|-------------|
| 1 | **Blog & Articles** | Publication, modération et commentaires d'articles |
| 2 | **Suivi Nutritionnel** | Gestion des repas, aliments, plans et régimes alimentaires |
| 3 | **Marketplace** | Boutique de produits bio avec commandes et paiement Stripe |
| 4 | **Recettes Durables** | Création, recherche et notation de recettes éco-responsables |
| 5 | **Communauté** | Espace communautaire et échanges entre utilisateurs |

---

## 🚀 Installation & Lancement

### Prérequis

- **PHP 7.4+** (ou PHP 8.x recommandé)
- **MySQL 5.7+** ou MariaDB
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
3. Les paramètres par défaut sont :
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
│   │   ├── ArticleController.php       ← Blog : articles + modération
│   │   ├── CommentController.php       ← Blog : commentaires
│   │   ├── MarketplaceController.php   ← Boutique, commandes, Stripe
│   │   ├── NutritionController.php     ← Repas, aliments, plans, régimes
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
│       │   ├── admin/
│       │   ├── article/
│       │   ├── comment/
│       │   ├── community/
│       │   ├── marketplace/
│       │   ├── nutrition/
│       │   ├── recettes/
│       │   └── layouts/
│       │
│       ├── frontoffice/                ← Interface utilisateur
│       │   ├── article/
│       │   ├── auth/
│       │   ├── community/
│       │   ├── marketplace/
│       │   ├── nutrition/
│       │   ├── recettes/
│       │   ├── layouts/
│       │   └── home.php
│       │
│       └── public/                     ← Point d'entrée web
│           ├── index.php               ← Front controller (routeur)
│           ├── home.php                ← Page d'accueil publique
│           ├── ai-proxy.php            ← Proxy IA (OpenRouter multi-modèle)
│           ├── nutrition-api.php       ← API nutrition externe
│           ├── stripe-intent.php       ← Paiement Stripe (PaymentIntent)
│           ├── .htaccess               ← Réécriture d'URL Apache
│           ├── assets/                 ← CSS, JS, images
│           ├── auth/
│           ├── community/
│           └── layouts/
│
├── config/
│   ├── database.php                    ← Singleton PDO
│   ├── citations.php                   ← Citations motivationnelles
│   ├── nutrition_apis.php              ← Clés API nutrition
│   ├── stripe.php                      ← Clé secrète Stripe
│   └── bannis.json                     ← Mots bannis (modération)
│
├── database.sql                        ← Script SQL complet (toutes les tables)
├── start.bat                           ← Lanceur Windows (serveur + navigateur)
└── README.md
```

---

## 🗄️ Base de Données

Le fichier `database.sql` contient la totalité du schéma et des données d'exemple.

### Tables principales

| Module | Tables |
|--------|--------|
| **Blog** | `article`, `commentaire` |
| **Nutrition** | `repas`, `aliment`, `repas_aliment`, `plan_nutritionnel`, `plan_repas` |
| **Régimes** | `regime_alimentaire` |
| **Marketplace** | `produit`, `commande`, `commande_produit` |
| **Recettes** | `recette`, `ingredient`, `recette_ingredient`, `commentaire_recette`, `instruction_recette`, `materiel`, `recette_materiel` |

> Toutes les connexions utilisent **PDO** (singleton `Database::getConnexion()`). Aucune utilisation de `mysqli` ou `mysql_connect`.

---

## 🤖 Assistant IA — GreenBot

L'application intègre **GreenBot**, un assistant IA spécialisé en nutrition durable, via `ai-proxy.php`.

- **Provider** : [OpenRouter](https://openrouter.ai) (accès multi-modèle)
- **Fallback** : 8 modèles gratuits en cascade (Llama, GPT, Gemma, Qwen…)
- **Fonctionnalités** :
  - Chat nutritionnel en français
  - Génération automatique de régimes alimentaires personnalisés
  - Suggestions de recettes

**Configuration** : Définissez la variable d'environnement `OPENROUTER_API_KEY` sur votre serveur.  
Aucune clé n'est codée en dur dans le projet.

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

- **Titres** : Poppins (600–700)
- **Corps** : Inter (300–600)
- Chargées via **Google Fonts CDN**

---

## 🔗 Routes Principales

| Route | Contrôleur | Description |
|-------|-----------|-------------|
| `/` | — | Page d'accueil publique |
| `/?page=blog` | `ArticleController` | Liste des articles |
| `/?page=blog&action=show&id=X` | `ArticleController` | Détail d'un article |
| `/?page=nutrition` | `NutritionController` | Suivi nutritionnel |
| `/?page=marketplace` | `MarketplaceController` | Boutique produits |
| `/?page=recettes` | `RecettesController` | Catalogue recettes |
| `/?page=admin` | — | Tableau de bord admin |
| `/?page=admin&module=articles` | `ArticleController` | Modération articles |
| `/?page=admin&module=nutrition` | `NutritionController` | Gestion nutrition (admin) |
| `/?page=admin&module=marketplace` | `MarketplaceController` | Gestion commandes |
| `/?page=admin&module=recettes` | `RecettesController` | Gestion recettes |

---

## ✅ Stack Technique

| Technologie | Rôle |
|-------------|------|
| PHP 7.4+ | Backend MVC (aucun framework) |
| MySQL / PDO | Base de données |
| HTML5 / CSS3 | Structure et styles (Vanilla) |
| JavaScript (ES6) | Interactivité côté client |
| Chart.js | Graphiques nutritionnels |
| Stripe.js | Paiement en ligne |
| OpenRouter API | Assistant IA multi-modèle |
| Google Fonts | Typographie (Inter + Poppins) |

> **Aucun outil de build requis.** Pas de npm, pas de Composer, pas de framework.

---

## 🛡️ Workflow de Modération

Pour garantir la qualité et la sécurité du contenu communautaire, l'application intègre un système de modération multi-niveaux :

1. **Soumission** : Lorsqu'un utilisateur propose une Recette, un Plan Nutritionnel ou un Régime, celui-ci est créé avec le statut `en_attente`.
2. **Visibilité Restreinte** : L'élément en attente n'est visible que par son auteur (dans son espace "Mes Suggestions") et par les administrateurs.
3. **Validation Admin** : Les administrateurs peuvent approuver (statut `accepte`) ou refuser (statut `refuse`) les propositions depuis le Back-Office.
4. **Commentaire de Refus** : En cas de refus, l'administrateur peut laisser un motif explicatif visible par l'utilisateur.

## 🔔 Système de Notifications

Les utilisateurs reçoivent des notifications en temps réel dans la barre de navigation :

- **Suivi des soumissions** : Alertes lorsqu'une proposition passe au statut `en_attente`, `accepte` ou `refuse`.
- **Commandes** : Notifications lors du changement de statut d'une commande (Confirmée, En cours, Livrée).
- **Interactions** : Validation ou signalement de commentaires sur le blog ou les recettes.

---

## 👥 Équipe

Projet réalisé dans le cadre du module **Programmation Web — 2ème année** à **ESPRIT School of Engineering**, année académique 2025–2026.

**Groupe** : GreenBite — 2A25-2526

---

## 📄 Licence

Projet académique — usage interne ESPRIT uniquement.