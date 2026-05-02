<?php
/**
 * Point d'entrée unique — Routeur
 * Toutes les requêtes passent par ce fichier
 */
session_start();

// Chemin de base du projet
define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/GREENBITE/public');
// Charger la configuration de la base de données
require_once BASE_PATH . '/config/database.php';

// Charger tous les modèles
require_once BASE_PATH . '/app/models/Repas.php';
require_once BASE_PATH . '/app/models/Aliment.php';
require_once BASE_PATH . '/app/models/Produit.php';
require_once BASE_PATH . '/app/models/Commande.php';
require_once BASE_PATH . '/app/models/Recette.php';
require_once BASE_PATH . '/app/models/Ingredient.php';
require_once BASE_PATH . '/app/models/UserModel.php';


// Charger tous les contrôleurs
require_once BASE_PATH . '/app/controllers/NutritionController.php';
require_once BASE_PATH . '/app/controllers/MarketplaceController.php';
require_once BASE_PATH . '/app/controllers/RecettesController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';
require_once BASE_PATH . '/app/controllers/UserController.php';
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

// ---- AUTH ----
case 'login':
    require_once BASE_PATH . '/app/views/auth/login.php';
    break;

case 'google-auth':
    $auth = new AuthController();
    $auth->RedirectToGoogle();
    break;

case 'google-callback':
    $auth = new AuthController();
    $result = $auth->HandleGoogleCallback();
    if (isset($result['error'])) {
        $_SESSION['error'] = $result['error'];
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }
    break;

case 'logout':
    $auth = new AuthController();
    $auth->Logout();
    break;

case 'signup':
    require_once BASE_PATH . '/app/views/auth/signup.php';
    break;

// ---- UTILISATEURS (Back) ----
case 'admin-users':
    // Protection
    if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'ADMIN') {
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }

    $ctrl = new UserController();

    // Supprimer
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $ctrl->SupprimerUser((int)$_GET['id']);
        $_SESSION['success'] = "Utilisateur supprimé avec succès.";
        header('Location: ' . BASE_URL . '/?page=admin-users');
        exit();
    }

    // Toggle actif/suspendu
    if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'], $_GET['status'])) {
        $ctrl->ToggleActive((int)$_GET['id'], (int)$_GET['status']);
        $_SESSION['success'] = "Statut mis à jour.";
        header('Location: ' . BASE_URL . '/?page=admin-users');
        exit();
    }

    // Ajouter / Modifier
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $user = new User($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], null, 1);
            $ctrl->AjouterUser($user, $_FILES['avatar'] ?? null);
            $_SESSION['success'] = "Utilisateur ajouté avec succès.";
            header('Location: ' . BASE_URL . '/?page=admin-users');
            exit();
        }
        if ($_POST['action'] === 'edit') {
            $user = new User($_POST['username'], $_POST['email'], '', $_POST['role'], null, (int)$_POST['is_active']);
            $ctrl->ModifierUser($user, (int)$_POST['id'], $_FILES['avatar'] ?? null);
            $_SESSION['success'] = "Utilisateur modifié avec succès.";
            header('Location: ' . BASE_URL . '/?page=admin-users');
            exit();
        }
    }

    // ✅ Output seulement ici après toutes les redirections
    require_once BASE_PATH . '/app/views/layouts/back_header.php';
    require_once BASE_PATH . '/app/views/admin/users.php';
    require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    break;

// ---- STATS (Back) ----
case 'admin-stats':
    // Protection ADMIN
    if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'ADMIN') {
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }
    require_once BASE_PATH . '/app/views/layouts/back_header.php';
    require_once BASE_PATH . '/app/views/admin/stats.php';
    require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    break;

    // ---- COMMUNAUTÉ & BLOG (Front - Static) ----
    case 'community':
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/community/front_list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
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


// ---- DEMANDE COACH ----
case 'coach-request':
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ctrl   = new UserController();
        $result = $ctrl->DemandeCoach($_SESSION['user_id'], $_FILES['certificate'] ?? null);

        if (isset($result['success'])) {
            // Mettre à jour la session
            $_SESSION['coach_request'] = 'pending';
            $_SESSION['success'] = "Demande envoyée ! L'admin va examiner votre dossier.";
        } else {
            $_SESSION['error'] = $result['error'];
        }
    }
    header('Location: ' . BASE_URL . '/');
    exit();

// ---- TRAITER DEMANDE COACH (ADMIN) ----
case 'coach-decision':
    if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'ADMIN') {
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }
    if (isset($_GET['id']) && isset($_GET['decision'])) {
        $ctrl = new UserController();
        $ctrl->TraiterDemandeCoach((int)$_GET['id'], $_GET['decision']);
        $_SESSION['success'] = $_GET['decision'] === 'accepted'
            ? "Demande acceptée — utilisateur promu Coach ✅"
            : "Demande refusée ❌";
    }
    header('Location: ' . BASE_URL . '/?page=admin-users');
    exit();





    case 'update-profile':
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }
    $ctrl = new UserController();
    $user = new User(
        $_POST['username'],
        $_POST['email'],
        '',
        $_SESSION['role'],
        $_SESSION['avatar'] ?? null,
        1
    );
    $ctrl->ModifierUser($user, $_SESSION['user_id'], $_FILES['avatar'] ?? null);

    // Changer le password si fourni
    if (!empty($_POST['new_password'])) {
        $ctrl->ModifierPassword($_SESSION['user_id'], $_POST['new_password']);
    }

    // Mettre à jour la session
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email']    = $_POST['email'];
    $_SESSION['success']  = "Profil mis à jour avec succès.";
    header('Location: ' . BASE_URL . '/');
    exit();



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
