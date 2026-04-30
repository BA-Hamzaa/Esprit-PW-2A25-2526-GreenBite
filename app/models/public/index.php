<?php
/**
 * Point d'entrée unique — Routeur
 * Toutes les requêtes passent par ce fichier
 */
session_start();

// Configuration locale et Fuseau horaire
date_default_timezone_set('Africa/Tunis');
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra', 'french');

// Chemin de base du projet
define('BASE_PATH', dirname(dirname(dirname(__DIR__))));
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
require_once BASE_PATH . '/app/models/CommentaireRecette.php';
require_once BASE_PATH . '/app/models/PlanNutritionnel.php';
require_once BASE_PATH . '/app/models/RegimeAlimentaire.php';

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
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/home.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
        break;

    // ---- AUTH (Static) ----
    case 'login':
        require_once BASE_PATH . '/app/views/frontoffice/auth/login.php';
        break;

    case 'signup':
        require_once BASE_PATH . '/app/views/frontoffice/auth/signup.php';
        break;

    // ---- COMMUNAUTÉ & BLOG (Front - Static) ----
    case 'community':
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/community/front_list.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
        break;

    // ---- STATISTIQUES (Back) ----
    case 'admin-stats':
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/admin/stats.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
        break;

    // ---- UTILISATEURS (Back - Static) ----
    case 'admin-users':
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/admin/users.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
        break;

    // ---- COMMUNAUTÉ (Back - Static) ----
    case 'admin-community':
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/community/back_list.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
        break;

    // ---- MODULE NUTRITION (Front) ----
    case 'nutrition':
        $controller = new NutritionController();
        switch ($action) {
            case 'list':           $controller->listFront(); break;
            case 'add':            $controller->addFront(); break;
            // Plans front
            case 'plans':          $controller->listPlans(); break;
            case 'plan-detail':    $controller->detailPlan(); break;
            case 'plan-add':       $controller->addPlan(); break;
            case 'plan-edit':      $controller->editPlan(); break;
            case 'plan-follow':    $controller->followPlan(); break;
            case 'plan-unfollow':  $controller->unfollowPlan(); break;
            case 'plan-delete':    $controller->deletePlan(); break;
            // Régimes front
            case 'regimes':         $controller->listRegimes(); break;
            case 'regime-add':      $controller->addRegime(); break;
            case 'regime-edit':     $controller->editRegime(); break;
            case 'regime-delete':   $controller->deleteRegimeFront(); break;
            case 'regime-detail':   $controller->detailRegimeFront(); break;
            default:                $controller->listFront(); break;
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
            // Aliments
            case 'aliments':        $controller->listAliments(); break;
            case 'add-aliment':     $controller->addAliment(); break;
            case 'edit-aliment':    $controller->editAliment(); break;
            case 'delete-aliment':  $controller->deleteAliment(); break;
            // Plans
            case 'plans':           $controller->listPlansBack(); break;
            case 'plan-add':        $controller->addPlanBack(); break;
            case 'plan-edit':       $controller->editPlanBack(); break;
            case 'plan-delete':     $controller->deletePlanBack(); break;
            case 'plan-accept':     $controller->acceptPlan(); break;
            case 'plan-refuse':     $controller->refusePlan(); break;
            // Régimes
            case 'regimes':         $controller->listRegimesBack(); break;
            case 'regime-accept':   $controller->acceptRegime(); break;
            case 'regime-refuse':   $controller->refuseRegime(); break;
            case 'regime-delete':   $controller->deleteRegimeBack(); break;
            case 'regime-add-back': $controller->addRegimeBack(); break;
            case 'regime-edit-back':$controller->editRegimeBack(); break;
            default:                $controller->listBack(); break;
        }
        break;

    // ---- MODULE MARKETPLACE (Front) ----
    case 'marketplace':
        $controller = new MarketplaceController();
        switch ($action) {
            case 'list':             $controller->listFront(); break;
            case 'detail':           $controller->detailFront(); break;
            case 'order':            $controller->orderFront(); break;
            case 'add-to-cart':      $controller->addToCart(); break;
            case 'remove-from-cart': $controller->removeFromCart(); break;
            case 'update-cart':      $controller->updateCart(); break;
            case 'clear-cart':       $controller->clearCart(); break;
            default:                 $controller->listFront(); break;
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
            case 'list':              $controller->listFront();            break;
            case 'detail':            $controller->detailFront();          break;
            case 'suggest':           $controller->suggestFront();         break;
            case 'my-suggestions':    $controller->mySuggestions();        break;
            case 'edit-suggestion':   $controller->editSuggestionFront();  break;
            case 'delete-suggestion': $controller->deleteSuggestionFront();break;
            case 'comment':           $controller->commentFront();          break;
            case 'update-comment':    $controller->updateCommentFront();   break;
            default:                  $controller->listFront();            break;
        }
        break;

    // ---- MODULE RECETTES (Back) ----
    case 'admin-recettes':
        $controller = new RecettesController();
        switch ($action) {
            case 'list':                $controller->listBack();           break;
            case 'add':                 $controller->addBack();            break;
            case 'edit':                $controller->editBack();           break;
            case 'delete':              $controller->deleteBack();         break;
            case 'moderate':            $controller->moderationList();     break;
            case 'accept':              $controller->acceptBack();         break;
            case 'refuse':              $controller->refuseBack();         break;
            case 'ingredients':         $controller->listIngredients();    break;
            case 'add-ingredient':      $controller->addIngredient();      break;
            case 'edit-ingredient':     $controller->editIngredient();     break;
            case 'delete-ingredient':   $controller->deleteIngredient();   break;
            // --- Commentaires ---
            case 'comments':            $controller->commentListBack();    break;
            case 'comments-moderate':   $controller->commentModerateBack();break;
            case 'comment-approve':     $controller->commentApproveBack(); break;
            case 'comment-refuse':      $controller->commentRefuseBack();  break;
            case 'comment-delete':      $controller->commentDeleteBack();  break;
            default:                    $controller->listBack();           break;
        }
        break;

    // ---- 404 ----
    default:
        http_response_code(404);
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        echo '<div class="min-h-screen flex items-center justify-center"><div class="text-center">';
        echo '<h1 class="text-9xl font-bold" style="color:var(--primary)">404</h1>';
        echo '<p class="text-xl text-gray-600 mb-8">Page non trouvée</p>';
        echo '<a href="' . BASE_URL . '/" class="btn btn-primary btn-lg">Retour à l\'accueil</a>';
        echo '</div></div>';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
        break;
}
