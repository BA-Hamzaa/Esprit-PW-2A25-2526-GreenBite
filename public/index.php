<?php
/**
 * Point d'entrée unique — Routeur
 * Toutes les requêtes passent par ce fichier
 */
session_start();

// Chemin de base du projet
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '');

// Charger la configuration de la base de données
require_once BASE_PATH . '/config/database.php';

// Charger tous les modèles
require_once BASE_PATH . '/app/models/Repas.php';
require_once BASE_PATH . '/app/models/Aliment.php';
require_once BASE_PATH . '/app/models/Produit.php';
require_once BASE_PATH . '/app/models/Commande.php';
require_once BASE_PATH . '/app/models/Recette.php';
require_once BASE_PATH . '/app/models/Ingredient.php';

// Charger tous les contrôleurs
require_once BASE_PATH . '/app/controllers/NutritionController.php';
require_once BASE_PATH . '/app/controllers/MarketplaceController.php';
require_once BASE_PATH . '/app/controllers/RecettesController.php';

// Récupérer la page et l'action depuis l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// =============================================
// ROUTAGE
// =============================================
switch ($page) {

    // ---- PAGE D'ACCUEIL ----
    case 'home':
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/home.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
        break;

    // ---- AUTH (Static) ----
    case 'login':
        require_once BASE_PATH . '/app/views/auth/login.php';
        break;

    case 'signup':
        require_once BASE_PATH . '/app/views/auth/signup.php';
        break;

    // ---- COMMUNAUTÉ & BLOG (Front - Static) ----
    case 'community':
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/community/front_list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
        break;

    // ---- STATISTIQUES (Back) ----
    case 'admin-stats':
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/admin/stats.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
        break;

    // ---- UTILISATEURS (Back - Static) ----
    case 'admin-users':
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/admin/users.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
        break;

    // ---- COMMUNAUTÉ (Back - Static) ----
    case 'admin-community':
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/community/back_list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
        break;

    // ---- MODULE NUTRITION (Front) ----
    case 'nutrition':
        $controller = new NutritionController();
        switch ($action) {
            case 'list':    $controller->listFront(); break;
            case 'add':     $controller->addFront(); break;
            default:        $controller->listFront(); break;
        }
        break;

    // ---- MODULE NUTRITION (Back) ----
    case 'admin-nutrition':
        $controller = new NutritionController();
        switch ($action) {
            case 'list':            $controller->listBack(); break;
            case 'add':             $controller->addBack(); break;
            case 'edit':            $controller->editBack(); break;
            case 'delete':          $controller->deleteBack(); break;
            case 'aliments':        $controller->listAliments(); break;
            case 'add-aliment':     $controller->addAliment(); break;
            case 'edit-aliment':    $controller->editAliment(); break;
            case 'delete-aliment':  $controller->deleteAliment(); break;
            default:                $controller->listBack(); break;
        }
        break;

    // ---- MODULE MARKETPLACE (Front) ----
    case 'marketplace':
        $controller = new MarketplaceController();
        switch ($action) {
            case 'list':    $controller->listFront(); break;
            case 'detail':  $controller->detailFront(); break;
            case 'order':   $controller->orderFront(); break;
            default:        $controller->listFront(); break;
        }
        break;

    // ---- MODULE MARKETPLACE (Back) ----
    case 'admin-marketplace':
        $controller = new MarketplaceController();
        switch ($action) {
            case 'list':               $controller->listBack(); break;
            case 'add':                $controller->addBack(); break;
            case 'edit':               $controller->editBack(); break;
            case 'delete':             $controller->deleteBack(); break;
            case 'commandes':          $controller->listCommandes(); break;
            case 'commande-detail':    $controller->commandeDetail(); break;
            case 'commande-status':    $controller->updateCommandeStatus(); break;
            case 'commande-delete':    $controller->deleteCommande(); break;
            default:                   $controller->listBack(); break;
        }
        break;

    // ---- MODULE RECETTES (Front) ----
    case 'recettes':
        $controller = new RecettesController();
        switch ($action) {
            case 'list':    $controller->listFront(); break;
            case 'detail':  $controller->detailFront(); break;
            default:        $controller->listFront(); break;
        }
        break;

    // ---- MODULE RECETTES (Back) ----
    case 'admin-recettes':
        $controller = new RecettesController();
        switch ($action) {
            case 'list':                $controller->listBack(); break;
            case 'add':                 $controller->addBack(); break;
            case 'edit':                $controller->editBack(); break;
            case 'delete':              $controller->deleteBack(); break;
            case 'ingredients':         $controller->listIngredients(); break;
            case 'add-ingredient':      $controller->addIngredient(); break;
            case 'edit-ingredient':     $controller->editIngredient(); break;
            case 'delete-ingredient':   $controller->deleteIngredient(); break;
            default:                    $controller->listBack(); break;
        }
        break;

    // ---- 404 ----
    default:
        http_response_code(404);
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        echo '<div class="min-h-screen flex items-center justify-center"><div class="text-center">';
        echo '<h1 class="text-9xl font-bold" style="color:var(--primary)">404</h1>';
        echo '<p class="text-xl text-gray-600 mb-8">Page non trouvée</p>';
        echo '<a href="' . BASE_URL . '/" class="btn btn-primary btn-lg">Retour à l\'accueil</a>';
        echo '</div></div>';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
        break;
}
