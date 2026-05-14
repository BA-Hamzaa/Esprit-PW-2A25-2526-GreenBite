<?php
ob_start(); // buffer ALL output — prevents notices/warnings from corrupting JSON responses
/**
 * Point d'entrée unique — Routeur
 * Toutes les requêtes passent par ce fichier
 */
session_start();

// Force UTF-8 for all HTML pages served by this router
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

// Configuration locale et Fuseau horaire
date_default_timezone_set('Africa/Tunis');
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra', 'french');

// Chemin de base du projet
define('BASE_PATH', dirname(dirname(dirname(__DIR__))));
define('BASE_URL', '');
define('FULL_BASE_URL', 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000'));

// Charger la configuration de la base de données
require_once BASE_PATH . '/config/database.php';
// Charger la configuration des API externes (Stripe, Mapbox)
require_once BASE_PATH . '/config/stripe.php';
// Charger la configuration des APIs Nutrition (USDA, Open Food Facts)
require_once BASE_PATH . '/config/nutrition_apis.php';
// Charger la configuration Google OAuth, Email SMTP, reCAPTCHA
require_once BASE_PATH . '/config/google.php';
require_once BASE_PATH . '/config/email.php';
require_once BASE_PATH . '/config/recaptcha.php';

// Charger tous les modèles
require_once BASE_PATH . '/app/models/MediaHelper.php';
require_once BASE_PATH . '/app/models/Repas.php';
require_once BASE_PATH . '/app/models/Aliment.php';
require_once BASE_PATH . '/app/models/Produit.php';
require_once BASE_PATH . '/app/models/Commande.php';
require_once BASE_PATH . '/app/models/Recette.php';
require_once BASE_PATH . '/app/models/Ingredient.php';
require_once BASE_PATH . '/app/models/CommentaireRecette.php';
require_once BASE_PATH . '/app/models/InstructionRecette.php';
require_once BASE_PATH . '/app/models/Materiel.php';
require_once BASE_PATH . '/app/models/PlanNutritionnel.php';
require_once BASE_PATH . '/app/models/RegimeAlimentaire.php';
require_once BASE_PATH . '/app/models/Article.php';
require_once BASE_PATH . '/app/models/Commentaire.php';
require_once BASE_PATH . '/app/models/UserModel.php';

// Charger tous les contrôleurs
require_once BASE_PATH . '/app/controllers/NutritionController.php';
require_once BASE_PATH . '/app/controllers/MarketplaceController.php';
require_once BASE_PATH . '/app/controllers/RecettesController.php';
require_once BASE_PATH . '/app/controllers/ArticleController.php';
require_once BASE_PATH . '/app/controllers/CommentController.php';
require_once BASE_PATH . '/app/controllers/UserController.php';
require_once BASE_PATH . '/app/controllers/AuthController.php';
require_once BASE_PATH . '/app/controllers/FaceAuthController.php';

// Récupérer la page et l'action depuis l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// =============================================
// PROTECTION VISITEUR — Approche : les visiteurs peuvent naviguer
// librement (voir régimes, produits, recettes, etc.) mais les
// ACTIONS sensibles (suivre, commander, commenter, ajouter) sont
// protégées dans chaque module ci-dessous.
// =============================================

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

    // ---- AUTH ----
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
            $auth   = new AuthController();
            $result = $auth->Login($_POST['email'], $_POST['password'], $_POST['g-recaptcha-response'] ?? null);
            if (isset($result['error'])) {
                $_SESSION['error'] = $result['error'];
                header('Location: ' . BASE_URL . '/?page=login');
                exit();
            }
        }
        require_once BASE_PATH . '/app/views/frontoffice/auth/login.php';
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->Logout();
        break;

    case 'signup':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['password'])) {
            $userCtrl = new UserController();
            $existing = $userCtrl->RecupererUserByEmail($_POST['email']);
            if ($existing) {
                $_SESSION['error'] = 'Cet email est déjà utilisé.';
            } else {
                $user = new User($_POST['username'], $_POST['email'], $_POST['password'], 'USER', null, 1);
                $userCtrl->AjouterUser($user, $_FILES['avatar'] ?? null);
                $newUser = $userCtrl->RecupererUserByEmail($_POST['email']);
                if ($newUser) {
                    $_SESSION['user_id']  = $newUser['id'];
                    $_SESSION['username'] = $newUser['username'];
                    $_SESSION['email']    = $newUser['email'];
                    $_SESSION['role']     = $newUser['role'];
                    $_SESSION['avatar']   = $newUser['avatar'];
                    $_SESSION['loggedin'] = true;
                    $_SESSION['success']  = 'Compte créé avec succès. Bienvenue !';
                    header('Location: ' . BASE_URL . '/');
                    exit();
                }
            }
        }
        require_once BASE_PATH . '/app/views/frontoffice/auth/signup.php';
        break;

    case 'google-auth':
        $auth = new AuthController();
        $auth->RedirectToGoogle();
        break;

    case 'google-callback':
        $auth   = new AuthController();
        $result = $auth->HandleGoogleCallback();
        if (isset($result['error'])) {
            $_SESSION['error'] = $result['error'];
            header('Location: ' . BASE_URL . '/?page=login');
            exit();
        }
        break;

    case 'forgot-password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $auth   = new AuthController();
            $result = $auth->RequestPasswordReset($_POST['email']);
            if (isset($result['success'])) {
                $_SESSION['success'] = $result['success'];
            } else {
                $_SESSION['error'] = $result['error'] ?? 'Une erreur est survenue.';
            }
            header('Location: ' . BASE_URL . '/?page=forgot-password');
            exit();
        }
        require_once BASE_PATH . '/app/views/frontoffice/auth/forgot-password.php';
        break;

    case 'reset-password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['password'])) {
            $auth   = new AuthController();
            $result = $auth->ResetPassword($_POST['token'], $_POST['password']);
            if (isset($result['success'])) {
                $_SESSION['success'] = $result['success'];
                header('Location: ' . BASE_URL . '/?page=login');
                exit();
            } else {
                $_SESSION['error'] = $result['error'] ?? 'Lien invalide ou expiré.';
            }
        }
        require_once BASE_PATH . '/app/views/frontoffice/auth/reset-password.php';
        break;

    // ---- FACE ID API ----
    case 'api-face-register':
        header('Content-Type: application/json');
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            echo json_encode(['error' => 'Non authentifié']); exit();
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['descriptor'])) {
            echo json_encode(['error' => 'Descripteur manquant']); exit();
        }
        $ctrl   = new FaceAuthController();
        $result = $ctrl->registerFace($_SESSION['user_id'], json_encode($data['descriptor']));
        echo json_encode($result);
        exit();

    case 'api-face-login':
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['descriptor'])) {
            echo json_encode(['error' => 'Descripteur manquant']); exit();
        }
        $ctrl   = new FaceAuthController();
        $result = $ctrl->loginFace(json_encode($data['descriptor']));
        echo json_encode($result);
        exit();

    // ---- FACE ID VIEW ----
    case 'face-register':
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ' . BASE_URL . '/?page=login'); exit();
        }
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/auth/face-register.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
        break;

    // ---- DEMANDE COACH ----
    case 'coach-request':
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ' . BASE_URL . '/?page=login'); exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ctrl   = new UserController();
            $result = $ctrl->DemandeCoach($_SESSION['user_id'], $_FILES['certificate'] ?? null);
            if (isset($result['success'])) {
                $_SESSION['coach_request'] = 'pending';
                $_SESSION['success'] = "Demande envoyée ! L'admin va examiner votre dossier.";
            } else {
                $_SESSION['error'] = $result['error'];
            }
        }
        header('Location: ' . BASE_URL . '/');
        exit();

    // ---- MISE À JOUR PROFIL ----
    case 'update-profile':
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ' . BASE_URL . '/?page=login'); exit();
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
        if (!empty($_POST['new_password'])) {
            $ctrl->ModifierPassword($_SESSION['user_id'], $_POST['new_password']);
        }
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['email']    = $_POST['email'];
        $_SESSION['success']  = 'Profil mis à jour avec succès.';
        header('Location: ' . BASE_URL . '/');
        exit();

    // ---- COMMUNAUTÉ & BLOG (Front) — alias → article list ----
    case 'community':
        header('Location: ' . BASE_URL . '/?page=article&action=list');
        exit;

    // ---- MODULE BLOG / ARTICLES (Front) ----
    case 'article':
        // Actions nécessitant connexion
        $actionsSensiblesArticle = ['add','comment','edit-comment','delete-comment','mes-activites','edit-mes-articles','delete-mes-articles','edit-mes-commentaires','delete-mes-commentaires'];
        if (in_array($action, $actionsSensiblesArticle) && (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)) {
            $_SESSION['error'] = '🔒 Vous devez être connecté pour effectuer cette action.';
            header('Location: ' . BASE_URL . '/?page=login');
            exit();
        }
        $controller = new ArticleController();
        switch ($action) {
            case 'list':                    $controller->listFront();                break;
            case 'detail':                  $controller->detailFront();              break;
            case 'add':                     $controller->addFront();                 break;
            case 'comment':                 $controller->addCommentFront();          break;
            case 'edit-comment':            $controller->editCommentFront();         break;
            case 'delete-comment':          $controller->deleteCommentFront();       break;
            case 'report-comment':          $controller->reportCommentFront();       break;
            case 'mes-activites':           $controller->mesActivitesFront();        break;
            case 'edit-mes-articles':       $controller->editMesArticlesFront();     break;
            case 'delete-mes-articles':     $controller->deleteMesArticlesFront();   break;
            case 'edit-mes-commentaires':   $controller->editMesCommentairesFront(); break;
            case 'delete-mes-commentaires': $controller->deleteMesCommentairesFront(); break;
            case 'translate':               $controller->apiTranslateArticle();      break;
            case 'resume':                  $controller->apiResumeArticle();         break;
            default:                        $controller->listFront();                break;
        }
        break;

    // ---- STATISTIQUES (Back) ----
    case 'admin-stats':
        $db = Database::getConnexion();
        // KPIs
        $statsRepas       = (int)$db->query("SELECT COUNT(*) FROM repas")->fetchColumn();
        $statsProduits    = (int)$db->query("SELECT COUNT(*) FROM produit")->fetchColumn();
        $statsCommandes   = (int)$db->query("SELECT COUNT(*) FROM commande")->fetchColumn();
        $statsRecettes    = (int)$db->query("SELECT COUNT(*) FROM recette WHERE statut='acceptee'")->fetchColumn();
        $statsSuggestions = (int)$db->query("SELECT COUNT(*) FROM recette WHERE statut='en_attente'")->fetchColumn();
        $statsIngredients = (int)$db->query("SELECT COUNT(*) FROM ingredient")->fetchColumn();
        $statsMateriels   = (int)$db->query("SELECT COUNT(*) FROM materiel WHERE statut='accepte'")->fetchColumn();
        $statsMatPending  = (int)$db->query("SELECT COUNT(*) FROM materiel WHERE statut='en_attente'")->fetchColumn();
        $statsComments    = (int)$db->query("SELECT COUNT(*) FROM commentaire_recette")->fetchColumn();
        $statsComPending  = (int)$db->query("SELECT COUNT(*) FROM commentaire_recette WHERE statut='en_attente'")->fetchColumn();
        $statsPlans       = (int)$db->query("SELECT COUNT(*) FROM plan_nutritionnel")->fetchColumn();
        $statsRegimes     = (int)$db->query("SELECT COUNT(*) FROM regime_alimentaire WHERE statut='accepte'")->fetchColumn();

        // Revenue total
        $statsRevenue = (float)($db->query("SELECT COALESCE(SUM(total),0) FROM commande WHERE statut!='annulee'")->fetchColumn());
        $statsAvgOrder= (float)($db->query("SELECT COALESCE(AVG(total),0) FROM commande WHERE statut!='annulee'")->fetchColumn());

        // Carbon score distribution
        $carbonRaw = $db->query("SELECT
            SUM(CASE WHEN score_carbone < 0.5 THEN 1 ELSE 0 END) as c1,
            SUM(CASE WHEN score_carbone >= 0.5 AND score_carbone < 1 THEN 1 ELSE 0 END) as c2,
            SUM(CASE WHEN score_carbone >= 1 AND score_carbone < 2 THEN 1 ELSE 0 END) as c3,
            SUM(CASE WHEN score_carbone >= 2 AND score_carbone < 3 THEN 1 ELSE 0 END) as c4,
            SUM(CASE WHEN score_carbone >= 3 THEN 1 ELSE 0 END) as c5
            FROM recette WHERE statut='acceptee'")->fetch();
        $carbonData = [(int)$carbonRaw['c1'],(int)$carbonRaw['c2'],(int)$carbonRaw['c3'],(int)$carbonRaw['c4'],(int)$carbonRaw['c5']];

        // Recipes by difficulty
        $diffRaw  = $db->query("SELECT difficulte, COUNT(*) as c FROM recette WHERE statut='acceptee' GROUP BY difficulte")->fetchAll();
        $diffData = ['facile'=>0,'moyen'=>0,'difficile'=>0];
        foreach($diffRaw as $r) $diffData[$r['difficulte']] = (int)$r['c'];

        // Recipes by category
        $recetteByCatRaw = $db->query("SELECT COALESCE(categorie,'Autre') as cat, COUNT(*) as c FROM recette WHERE statut='acceptee' GROUP BY categorie ORDER BY c DESC LIMIT 7")->fetchAll();
        $recetteCatLabels = array_column($recetteByCatRaw,'cat');
        $recetteCatValues = array_column($recetteByCatRaw,'c');

        // Commandes by status
        $cmdRaw  = $db->query("SELECT statut, COUNT(*) as c FROM commande GROUP BY statut")->fetchAll();
        $cmdData = ['en_attente'=>0,'confirmee'=>0,'livree'=>0,'annulee'=>0];
        foreach($cmdRaw as $r) $cmdData[$r['statut']] = (int)$r['c'];

        // Revenue by month (last 6 months)
        $revenueRaw    = $db->query("SELECT DATE_FORMAT(created_at,'%b %Y') as m, ROUND(SUM(total),2) as t FROM commande WHERE statut!='annulee' AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY DATE_FORMAT(created_at,'%Y-%m') ORDER BY MIN(created_at) ASC")->fetchAll();
        $revenueLabels = array_column($revenueRaw,'m');
        $revenueValues = array_column($revenueRaw,'t');

        // Top 5 produits by quantity sold
        $topProduitsRaw = $db->query("SELECT p.nom, COALESCE(SUM(cp.quantite),0) as qty, COALESCE(SUM(cp.quantite*cp.prix_unitaire),0) as rev FROM produit p LEFT JOIN commande_produit cp ON p.id=cp.produit_id GROUP BY p.id,p.nom ORDER BY qty DESC LIMIT 5")->fetchAll();
        $topProdLabels  = array_column($topProduitsRaw,'nom');
        $topProdQty     = array_map('intval', array_column($topProduitsRaw,'qty'));
        $topProdRev     = array_map('floatval', array_column($topProduitsRaw,'rev'));

        // Stock status
        $stockRaw = $db->query("SELECT SUM(CASE WHEN stock=0 THEN 1 ELSE 0 END) as rupture, SUM(CASE WHEN stock>0 AND stock<=5 THEN 1 ELSE 0 END) as faible, SUM(CASE WHEN stock>5 THEN 1 ELSE 0 END) as ok FROM produit")->fetch();
        $stockData = [(int)$stockRaw['rupture'], (int)$stockRaw['faible'], (int)$stockRaw['ok']];

        // Bio ratio
        $bioRaw  = $db->query("SELECT SUM(is_bio) as bio, SUM(1-is_bio) as non_bio FROM produit")->fetch();
        $bioData = [(int)$bioRaw['bio'], (int)$bioRaw['non_bio']];

        // Comments by status
        $commRaw  = $db->query("SELECT statut, COUNT(*) as c FROM commentaire_recette GROUP BY statut")->fetchAll();
        $commData = ['approuve'=>0,'en_attente'=>0,'refuse'=>0];
        foreach($commRaw as $r) $commData[$r['statut']] = (int)$r['c'];

        // Average rating per recipe (top 6 approved)
        $ratingRaw    = $db->query("SELECT r.titre, ROUND(AVG(cr.note),1) as avg FROM commentaire_recette cr JOIN recette r ON cr.recette_id=r.id WHERE cr.statut='approuve' GROUP BY cr.recette_id,r.titre ORDER BY avg DESC LIMIT 6")->fetchAll();
        $ratingLabels = array_map(fn($x)=>mb_substr($x['titre'],0,18).(mb_strlen($x['titre'])>18?'…':''), $ratingRaw);
        $ratingValues = array_map('floatval', array_column($ratingRaw,'avg'));

        // Calories by meal type
        $calTypRaw    = $db->query("SELECT type_repas, ROUND(AVG(calories_total)) as avg_cal, COUNT(*) as cnt FROM repas GROUP BY type_repas")->fetchAll();
        $calTypLabels = array_map(fn($x)=>ucfirst(str_replace('_',' ',$x['type_repas'])), $calTypRaw);
        $calTypValues = array_map('intval', array_column($calTypRaw,'avg_cal'));

        // Plans by type
        $plansRaw  = $db->query("SELECT type_objectif, COUNT(*) as c FROM plan_nutritionnel GROUP BY type_objectif")->fetchAll();
        $planLabels= array_map(fn($x)=>ucfirst(str_replace('_',' ',$x['type_objectif'])), $plansRaw);
        $planValues= array_map('intval', array_column($plansRaw,'c'));

        // Régimes by objectif (top 5)
        $regimesRaw    = $db->query("SELECT objectif, COUNT(*) as c FROM regime_alimentaire WHERE statut='accepte' GROUP BY objectif ORDER BY c DESC LIMIT 5")->fetchAll();
        $regimesLabels = array_column($regimesRaw,'objectif');
        $regimesValues = array_map('intval', array_column($regimesRaw,'c'));

        // Ingredients: local vs non-local
        $ingLocal = $db->query("SELECT SUM(is_local) as loc, SUM(1-is_local) as nonloc FROM ingredient")->fetch();
        $ingData  = [(int)$ingLocal['loc'], (int)$ingLocal['nonloc']];

        // Recent recipes / commandes / repas
        $recentRecettes  = $db->query("SELECT titre, difficulte, score_carbone, soumis_par, created_at FROM recette WHERE statut='acceptee' ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $recentCommandes = $db->query("SELECT client_nom, total, statut, created_at FROM commande ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $recentRepas     = $db->query("SELECT nom, type_repas, calories_total, date_repas FROM repas ORDER BY created_at DESC LIMIT 5")->fetchAll();

        // ── REPAS STATISTICS (detailed) ──
        $repasStatutData = ['accepte'=>0,'en_attente'=>0,'refuse'=>0];
        $repasTypeLabels = []; $repasTypeValues = [];
        $topAlimLabels = []; $topAlimValues = [];
        $repasDayLabels = ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
        $repasDayValues = [0,0,0,0,0,0,0];
        try {
            // Repas by status
            $repasStatutRaw = $db->query("SELECT statut, COUNT(*) as c FROM repas GROUP BY statut")->fetchAll();
            foreach($repasStatutRaw as $r) $repasStatutData[$r['statut']] = (int)$r['c'];

            // Repas by type (donut)
            $repasTypeRaw = $db->query("SELECT type_repas, COUNT(*) as c FROM repas GROUP BY type_repas ORDER BY c DESC")->fetchAll();
            $repasTypeLabels = array_map(fn($x)=>ucfirst(str_replace('_',' ',$x['type_repas'])), $repasTypeRaw);
            $repasTypeValues = array_map('intval', array_column($repasTypeRaw,'c'));

            // Top 5 aliments in repas (table may not exist)
            try {
                $topAlimentsRaw = $db->query("SELECT a.nom, COUNT(*) as freq FROM repas_aliment ra JOIN aliment a ON a.id=ra.aliment_id GROUP BY a.id, a.nom ORDER BY freq DESC LIMIT 5")->fetchAll();
                $topAlimLabels = array_column($topAlimentsRaw,'nom');
                $topAlimValues = array_map('intval', array_column($topAlimentsRaw,'freq'));
            } catch (Exception $e) {}

            // Repas by day of week
            $repasDayRaw = $db->query("SELECT DAYOFWEEK(date_repas) as dow, COUNT(*) as c FROM repas GROUP BY DAYOFWEEK(date_repas) ORDER BY dow")->fetchAll();
            $repasDayMap = array_fill(1,7,0);
            foreach($repasDayRaw as $r) $repasDayMap[(int)$r['dow']] = (int)$r['c'];
            $repasDayLabels = []; $repasDayValues = [];
            $dayNames = ['','Dim','Lun','Mar','Mer','Jeu','Ven','Sam'];
            for($d=2;$d<=7;$d++){$repasDayLabels[]=$dayNames[$d];$repasDayValues[]=$repasDayMap[$d];}
            $repasDayLabels[]=$dayNames[1]; $repasDayValues[]=$repasDayMap[1];
        } catch (Exception $e) {}

        // Macros average
        $macroRaw  = $db->query("SELECT ROUND(AVG(proteines),1) as p, ROUND(AVG(glucides),1) as g, ROUND(AVG(lipides),1) as l FROM aliment")->fetch();
        $macroData = [(float)$macroRaw['p'], (float)$macroRaw['g'], (float)$macroRaw['l']];

        // Produits by categorie
        $catRaw    = $db->query("SELECT COALESCE(categorie,'Autre') as cat, COUNT(*) as c FROM produit GROUP BY categorie ORDER BY c DESC LIMIT 6")->fetchAll();
        $catLabels = array_column($catRaw,'cat');
        $catValues = array_column($catRaw,'c');

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/admin/stats.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
        break;

    // ---- UTILISATEURS (Back - CRUD complet) ----
    case 'admin-users':
        // Protection ADMIN
        if (!isset($_SESSION['loggedin']) || ($_SESSION['role'] ?? '') !== 'ADMIN') {
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

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/admin/users.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
        break;

    // ---- TRAITER DEMANDE COACH (ADMIN) ----
    case 'coach-decision':
        if (!isset($_SESSION['loggedin']) || ($_SESSION['role'] ?? '') !== 'ADMIN') {
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

    // ---- COMMUNAUTÉ (Back) — alias → admin-article ----
    case 'admin-community':
        header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
        exit;

    // ---- MODULE BLOG / ARTICLES (Back) ----
    case 'admin-article':
        $controller = new ArticleController();
        switch ($action) {
            case 'list':    $controller->listBack();    break;
            case 'add':     $controller->addBack();     break;
            case 'edit':    $controller->editBack();    break;
            case 'delete':  $controller->deleteBack();  break;
            case 'pending': $controller->pendingBack();  break;
            case 'publish': $controller->publishBack();  break;
            case 'stats':   $controller->statsBack();    break;
            default:        $controller->listBack();    break;
        }
        break;

    // ---- MODULE COMMENTAIRES (Back) ----
    case 'admin-comment':
        $controller = new CommentController();
        switch ($action) {
            case 'list':             $controller->listBack();             break;
            case 'delete':           $controller->deleteBack();           break;
            case 'ignorer':          $controller->ignorerBack();          break;
            case 'supprimer-bannir': $controller->supprimerEtBannirBack(); break;
            default:                 $controller->listBack();             break;
        }
        break;

    // ---- MODULE NUTRITION (Front) ----
    case 'nutrition':
        // Suivi & actions sensibles réservées aux utilisateurs connectés
        $actionsSensiblesNutrition = ['plan-follow','plan-unfollow','regime-unfollow','plan-add','plan-edit','plan-delete','regime-add','regime-edit','regime-delete','add'];
        if (in_array($action, $actionsSensiblesNutrition) && (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)) {
            $_SESSION['error'] = '🔒 Vous devez être connecté pour effectuer cette action.';
            header('Location: ' . BASE_URL . '/?page=login');
            exit();
        }
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
            case 'regime-unfollow':$controller->unfollowRegime(); break;
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
            case 'repas-accept':    $controller->acceptRepas(); break;
            case 'repas-refuse':    $controller->refuseRepas(); break;
            case 'repas-export-pdf':$controller->exportRepasPdfBack(); break;
            // Aliments
            case 'aliments':        $controller->listAliments(); break;
            case 'add-aliment':     $controller->addAliment(); break;
            case 'edit-aliment':    $controller->editAliment(); break;
            case 'delete-aliment':  $controller->deleteAliment(); break;
            case 'aliment-export-pdf': $controller->exportAlimentsPdfBack(); break;
            // Plans
            case 'plans':           $controller->listPlansBack(); break;
            case 'plan-add':        $controller->addPlanBack(); break;
            case 'plan-edit':       $controller->editPlanBack(); break;
            case 'plan-delete':     $controller->deletePlanBack(); break;
            case 'plan-accept':     $controller->acceptPlan(); break;
            case 'plan-refuse':     $controller->refusePlan(); break;
            case 'plan-export-pdf': $controller->exportPlansPdfBack(); break;
            // Régimes
            case 'regimes':         $controller->listRegimesBack(); break;
            case 'regime-accept':   $controller->acceptRegime(); break;
            case 'regime-refuse':   $controller->refuseRegime(); break;
            case 'regime-delete':   $controller->deleteRegimeBack(); break;
            case 'regime-add-back': $controller->addRegimeBack(); break;
            case 'regime-edit-back':$controller->editRegimeBack(); break;
            case 'regime-export-pdf': $controller->exportRegimesPdfBack(); break;
            default:                $controller->listBack(); break;
        }
        break;

    // ---- MODULE MARKETPLACE (Front) ----
    case 'marketplace':
        // Commandes et panier réservés aux utilisateurs connectés
        $actionsSensiblesMarket = ['order','order-success','history','track-order','edit-order','update-order','download-receipt'];
        if (in_array($action, $actionsSensiblesMarket) && (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)) {
            $_SESSION['error'] = '🔒 Vous devez être connecté pour passer une commande.';
            header('Location: ' . BASE_URL . '/?page=login');
            exit();
        }
        $controller = new MarketplaceController();
        switch ($action) {
            case 'list':             $controller->listFront(); break;
            case 'detail':           $controller->detailFront(); break;
            case 'order':            $controller->orderFront(); break;
            case 'order-success':    $controller->orderSuccessFront(); break;
            case 'history':          $controller->historyFront(); break;
            case 'track-order':      $controller->trackOrderFront(); break;
            case 'edit-order':       $controller->editCommandeFront(); break;
            case 'update-order':     $controller->updateCommandeFront(); break;
            case 'download-receipt': $controller->downloadReceipt(); break;
            case 'load-order-cart':  $controller->loadOrderCart(); break;
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
        // Actions nécessitant une connexion
        $actionsSensiblesRecettes = ['suggest','my-suggestions','edit-suggestion','delete-suggestion','comment','update-comment','instruction-add','instruction-edit','instruction-delete','propose-materiel','propose-ingredient'];
        if (in_array($action, $actionsSensiblesRecettes) && (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)) {
            $_SESSION['error'] = '🔒 Vous devez être connecté pour effectuer cette action.';
            header('Location: ' . BASE_URL . '/?page=login');
            exit();
        }
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
            // --- AJAX: Instructions ---
            case 'instruction-add':    $controller->instructionAdd();    break;
            case 'instruction-edit':   $controller->instructionEdit();   break;
            case 'instruction-delete': $controller->instructionDelete(); break;
            // --- AJAX: Matériels ---
            case 'propose-materiel':   $controller->proposeMateriel();   break;
            case 'propose-ingredient': $controller->proposeIngredient(); break;
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
            // --- Matériels ---
            case 'materiels':           $controller->listMateriels();      break;
            case 'materiel-add':        $controller->addMaterielBack();    break;
            case 'materiel-accept':     $controller->acceptMateriel();     break;
            case 'materiel-refuse':     $controller->refuseMateriel();     break;
            case 'materiel-delete':     $controller->deleteMateriel();     break;
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
