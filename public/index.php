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
define('BASE_PATH', dirname(__DIR__));
// BASE_URL: nécessaire quand le projet est dans un sous-dossier (XAMPP /htdocs/...)
$baseUrl = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
if ($baseUrl === '/' || $baseUrl === '.') {
    $baseUrl = '';
}
define('BASE_URL', rtrim($baseUrl, '/'));

// Charger la configuration de la base de données
require_once BASE_PATH . '/config/database.php';

// Charger tous les modèles
require_once BASE_PATH . '/app/models/Repas.php';
require_once BASE_PATH . '/app/models/Aliment.php';
require_once BASE_PATH . '/app/models/Produit.php';
require_once BASE_PATH . '/app/models/Commande.php';
require_once BASE_PATH . '/app/models/Recette.php';
require_once BASE_PATH . '/app/models/Ingredient.php';
require_once BASE_PATH . '/app/models/PlanNutritionnel.php';
require_once BASE_PATH . '/app/models/RegimeAlimentaire.php';
require_once BASE_PATH . '/app/models/Article.php';
require_once BASE_PATH . '/app/models/Commentaire.php';

// Charger tous les contrôleurs
require_once BASE_PATH . '/app/controllers/NutritionController.php';
require_once BASE_PATH . '/app/controllers/MarketplaceController.php';
require_once BASE_PATH . '/app/controllers/RecettesController.php';
require_once BASE_PATH . '/app/controllers/ArticleController.php';
require_once BASE_PATH . '/app/controllers/CommentController.php';

// Récupérer la page et l'action depuis l'URL
$page   = isset($_GET['page'])   ? $_GET['page']   : 'home';
$action = isset($_GET['action']) ? $_GET['action']  : 'list';

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

    // ---- AUTH ----
    case 'login':
        require_once BASE_PATH . '/app/views/auth/login.php';
        break;

    case 'signup':
        require_once BASE_PATH . '/app/views/auth/signup.php';
        break;

    // ---- COMMUNAUTÉ & BLOG → redirige vers le vrai module article ----
    case 'community':
        header('Location: ' . BASE_URL . '/?page=article&action=list');
        exit;

    // ---- STATISTIQUES (Back) ----
    case 'admin-stats':
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/admin/stats.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
        break;

    // ---- UTILISATEURS (Back) ----
    case 'admin-users':
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/admin/users.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
        break;

    // ---- COMMUNAUTÉ BACK → redirige vers admin-article ----
    case 'admin-community':
        header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
        exit;

    // ---- MODULE NUTRITION (Front) ----
    case 'nutrition':
        $controller = new NutritionController();
        switch ($action) {
            case 'list':            $controller->listFront();         break;
            case 'add':             $controller->addFront();          break;
            case 'plans':           $controller->listPlans();         break;
            case 'plan-detail':     $controller->detailPlan();        break;
            case 'plan-add':        $controller->addPlan();           break;
            case 'plan-edit':       $controller->editPlan();          break;
            case 'plan-delete':     $controller->deletePlan();        break;
            case 'regimes':         $controller->listRegimes();       break;
            case 'regime-add':      $controller->addRegime();         break;
            case 'regime-edit':     $controller->editRegime();        break;
            case 'regime-delete':   $controller->deleteRegimeFront(); break;
            case 'regime-detail':   $controller->detailRegimeFront(); break;
            default:                $controller->listFront();         break;
        }
        break;

    // ---- MODULE NUTRITION (Back) ----
    case 'admin-nutrition':
        $controller = new NutritionController();
        switch ($action) {
            case 'list':             $controller->listBack();        break;
            case 'add':              $controller->addBack();         break;
            case 'edit':             $controller->editBack();        break;
            case 'delete':           $controller->deleteBack();      break;
            case 'aliments':         $controller->listAliments();    break;
            case 'add-aliment':      $controller->addAliment();      break;
            case 'edit-aliment':     $controller->editAliment();     break;
            case 'delete-aliment':   $controller->deleteAliment();   break;
            case 'plans':            $controller->listPlansBack();   break;
            case 'plan-add':         $controller->addPlanBack();     break;
            case 'plan-edit':        $controller->editPlanBack();    break;
            case 'plan-delete':      $controller->deletePlanBack();  break;
            case 'regimes':          $controller->listRegimesBack(); break;
            case 'regime-accept':    $controller->acceptRegime();    break;
            case 'regime-refuse':    $controller->refuseRegime();    break;
            case 'regime-delete':    $controller->deleteRegimeBack();break;
            case 'regime-add-back':  $controller->addRegimeBack();   break;
            case 'regime-edit-back': $controller->editRegimeBack();  break;
            default:                 $controller->listBack();        break;
        }
        break;

    // ---- MODULE MARKETPLACE (Front) ----
    case 'marketplace':
        $controller = new MarketplaceController();
        switch ($action) {
            case 'list':   $controller->listFront();   break;
            case 'detail': $controller->detailFront(); break;
            case 'order':  $controller->orderFront();  break;
            default:       $controller->listFront();   break;
        }
        break;

    // ---- MODULE MARKETPLACE (Back) ----
    case 'admin-marketplace':
        $controller = new MarketplaceController();
        switch ($action) {
            case 'list':            $controller->listBack();              break;
            case 'add':             $controller->addBack();               break;
            case 'edit':            $controller->editBack();              break;
            case 'delete':          $controller->deleteBack();            break;
            case 'commandes':       $controller->listCommandes();         break;
            case 'commande-detail': $controller->commandeDetail();        break;
            case 'commande-status': $controller->updateCommandeStatus();  break;
            case 'commande-delete': $controller->deleteCommande();        break;
            default:                $controller->listBack();              break;
        }
        break;

    // ---- MODULE RECETTES (Front) ----
    case 'recettes':
        $controller = new RecettesController();
        switch ($action) {
            case 'list':              $controller->listFront();             break;
            case 'detail':            $controller->detailFront();           break;
            case 'suggest':           $controller->suggestFront();          break;
            case 'my-suggestions':    $controller->mySuggestions();         break;
            case 'edit-suggestion':   $controller->editSuggestionFront();   break;
            case 'delete-suggestion': $controller->deleteSuggestionFront(); break;
            default:                  $controller->listFront();             break;
        }
        break;

    // ---- MODULE RECETTES (Back) ----
    case 'admin-recettes':
        $controller = new RecettesController();
        switch ($action) {
            case 'list':              $controller->listBack();        break;
            case 'add':               $controller->addBack();         break;
            case 'edit':              $controller->editBack();        break;
            case 'delete':            $controller->deleteBack();      break;
            case 'moderate':          $controller->moderationList();  break;
            case 'accept':            $controller->acceptBack();      break;
            case 'refuse':            $controller->refuseBack();      break;
            case 'ingredients':       $controller->listIngredients(); break;
            case 'add-ingredient':    $controller->addIngredient();   break;
            case 'edit-ingredient':   $controller->editIngredient();  break;
            case 'delete-ingredient': $controller->deleteIngredient();break;
            default:                  $controller->listBack();        break;
        }
        break;

       // ---- MODULE BLOG / ARTICLES (Front) ----
    case 'article':
        $controller = new ArticleController();
        switch ($action) {
            case 'list':                $controller->listFront();              break;
            case 'add':                 $controller->addFront();               break;
            case 'detail':              $controller->detailFront();            break;
            case 'comment-add':         $controller->addCommentFront();        break;
            case 'comment-edit':        $controller->editCommentFront();       break;  // ✅ NOUVEAU
            case 'comment-delete':      $controller->deleteCommentFront();     break;  // ✅ NOUVEAU
            case 'comment-report':      $controller->reportCommentFront();     break;  // ✅ NOUVEAU
            case 'mes-activites':       $controller->mesActivitesFront();      break;
            case 'mes-activites':       $controller->mesActivitesFront();      break;
            case 'edit-mes-commentaires':      $controller->editMesCommentairesFront();      break;
            case 'delete-mes-commentaires':    $controller->deleteMesCommentairesFront();    break;
            case 'edit-mes-articles':   $controller->editMesArticlesFront();   break;
            case 'delete-mes-articles': $controller->deleteMesArticlesFront(); break;
            default:                    $controller->listFront();              break;
        }
        break;
    // ---- MODULE BLOG / ARTICLES (Back) ----
    case 'admin-article':
        $controller = new ArticleController();
        switch ($action) {
            case 'list':    $controller->listBack();    break;
            case 'pending': $controller->pendingBack(); break;
            case 'add':     $controller->addBack();     break;
            case 'edit':    $controller->editBack();    break;
            case 'delete':  $controller->deleteBack();  break;
            case 'publish': $controller->publishBack(); break;
            default:        $controller->listBack();    break;
        }
        break;

    // ---- MODULE BLOG / COMMENTAIRES (Back) ----
    case 'admin-comment':
        $controller = new CommentController();
        switch ($action) {
            case 'list':              $controller->listBack();                break;
            case 'delete':            $controller->deleteBack();              break;
            case 'ignorer':           $controller->ignorerBack();             break;
            case 'supprimer-bannir':  $controller->supprimerEtBannirBack();  break;
            default:                  $controller->listBack();                break;
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