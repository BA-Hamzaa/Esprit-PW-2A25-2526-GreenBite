<?php
/**
 * Contrôleur Nutrition — Gestion du suivi nutritionnel
 * Gère les CRUD pour Repas, Aliments et Plans (Front + Back)
 */
class NutritionController {
    private $repasModel;
    private $alimentModel;
    private $planModel;
    private $regimeModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->repasModel  = new Repas($pdo);
        $this->alimentModel = new Aliment($pdo);
        $this->planModel   = new PlanNutritionnel($pdo);
        $this->regimeModel = new RegimeAlimentaire($pdo);
    }

    // =============================================
    // FRONTOFFICE
    // =============================================

    /** Liste des repas du jour (Front) */
    public function listFront() {
        $repas = $this->repasModel->getToday();
        foreach ($repas as &$r) {
            $r['aliments'] = $this->repasModel->getAliments($r['id']);
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Formulaire d'ajout de repas (Front) */
    public function addFront() {
        $errors = [];
        $aliments = $this->alimentModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRepas($_POST);

            if (empty($errors)) {
                $calTotal = 0;
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        $aliment = $this->alimentModel->getById($alimentId);
                        if ($aliment) {
                            $calTotal += ($aliment['calories'] * $quantite) / 100;
                        }
                    }
                }

                $data = [
                    'nom' => trim($_POST['nom']),
                    'date_repas' => $_POST['date_repas'],
                    'type_repas' => $_POST['type_repas'],
                    'calories_total' => round($calTotal)
                ];

                $repasId = $this->repasModel->create($data);

                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($alimentId) && $quantite > 0) {
                            $this->repasModel->addAliment($repasId, $alimentId, $quantite);
                        }
                    }
                }

                $_SESSION['success'] = "Repas ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=nutrition');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    // =============================================
    // FRONTOFFICE — PLANS NUTRITIONNELS
    // =============================================

    /** Liste des plans (Front) */
    public function listPlans() {
        $plans = $this->planModel->getAll();
        foreach ($plans as &$p) {
            $p['repas'] = $this->planModel->getRepas($p['id']);
            $p['nb_repas'] = count($p['repas']);
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_plans.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Détail d'un plan (Front) */
    public function detailPlan() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $plan = $this->planModel->getById($id);
        if (!$plan) {
            $_SESSION['error'] = "Plan introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
            exit;
        }

        $planRepas = $this->planModel->getRepas($id);
        $repasByDay = [];
        foreach ($planRepas as $pr) {
            $jour = $pr['jour'];
            if (!isset($repasByDay[$jour])) {
                $repasByDay[$jour] = [];
            }
            $pr['aliments'] = $this->repasModel->getAliments($pr['id']);
            $repasByDay[$jour][] = $pr;
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_plan_detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Formulaire d'ajout de plan (Front) */
    public function addPlan() {
        $errors = [];
        $repas = $this->repasModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validatePlan($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'description' => trim($_POST['description'] ?? ''),
                    'objectif_calories' => (int)$_POST['objectif_calories'],
                    'duree_jours' => (int)$_POST['duree_jours'],
                    'type_objectif' => $_POST['type_objectif'],
                    'date_debut' => $_POST['date_debut']
                ];

                $planId = $this->planModel->create($data);

                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->planModel->addRepas($planId, $repasId, $jour);
                        }
                    }
                }

                $_SESSION['success'] = "Plan nutritionnel créé avec succès !";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_plan_add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Édition d'un plan (Front) */
    public function editPlan() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $plan = $this->planModel->getById($id);
        if (!$plan) {
            $_SESSION['error'] = "Plan introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
            exit;
        }

        $errors = [];
        $repas = $this->repasModel->getAll();
        $planRepas = $this->planModel->getRepas($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validatePlan($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'description' => trim($_POST['description'] ?? ''),
                    'objectif_calories' => (int)$_POST['objectif_calories'],
                    'duree_jours' => (int)$_POST['duree_jours'],
                    'type_objectif' => $_POST['type_objectif'],
                    'date_debut' => $_POST['date_debut']
                ];
                $this->planModel->update($id, $data);

                $this->planModel->removeRepas($id);
                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->planModel->addRepas($id, $repasId, $jour);
                        }
                    }
                }

                $_SESSION['success'] = "Plan modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_plan_edit.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Suppression d'un plan (Front) */
    public function deletePlan() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->planModel->delete($id);
        $_SESSION['success'] = "Plan supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
        exit;
    }

    // =============================================
    // BACKOFFICE — REPAS
    // =============================================

    /** Liste de tous les repas (Back) */
    public function listBack() {
        $repas = $this->repasModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Ajout d'un repas (Back) */
    public function addBack() {
        $errors = [];
        $aliments = $this->alimentModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRepas($_POST);

            if (empty($errors)) {
                $calTotal = 0;
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        $aliment = $this->alimentModel->getById($alimentId);
                        if ($aliment) {
                            $calTotal += ($aliment['calories'] * $quantite) / 100;
                        }
                    }
                }

                $data = [
                    'nom' => trim($_POST['nom']),
                    'date_repas' => $_POST['date_repas'],
                    'type_repas' => $_POST['type_repas'],
                    'calories_total' => round($calTotal)
                ];
                $repasId = $this->repasModel->create($data);

                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($alimentId) && $quantite > 0) {
                            $this->repasModel->addAliment($repasId, $alimentId, $quantite);
                        }
                    }
                }

                $_SESSION['success'] = "Repas ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Édition d'un repas (Back) */
    public function editBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $repas = $this->repasModel->getById($id);
        if (!$repas) {
            $_SESSION['error'] = "Repas introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
            exit;
        }

        $errors = [];
        $aliments = $this->alimentModel->getAll();
        $repasAliments = $this->repasModel->getAliments($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRepas($_POST);

            if (empty($errors)) {
                $calTotal = 0;
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        $aliment = $this->alimentModel->getById($alimentId);
                        if ($aliment) {
                            $calTotal += ($aliment['calories'] * $quantite) / 100;
                        }
                    }
                }

                $data = [
                    'nom' => trim($_POST['nom']),
                    'date_repas' => $_POST['date_repas'],
                    'type_repas' => $_POST['type_repas'],
                    'calories_total' => round($calTotal)
                ];
                $this->repasModel->update($id, $data);

                $this->repasModel->removeAliments($id);
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($alimentId) && $quantite > 0) {
                            $this->repasModel->addAliment($id, $alimentId, $quantite);
                        }
                    }
                }

                $_SESSION['success'] = "Repas modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Suppression d'un repas (Back) */
    public function deleteBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->repasModel->delete($id);
        $_SESSION['success'] = "Repas supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
        exit;
    }

    // =============================================
    // BACKOFFICE — ALIMENTS
    // =============================================

    /** Liste des aliments (Back) */
    public function listAliments() {
        $aliments = $this->alimentModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_aliments.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Ajout d'un aliment (Back) */
    public function addAliment() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateAliment($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'calories' => (int)$_POST['calories'],
                    'proteines' => (float)$_POST['proteines'],
                    'glucides' => (float)$_POST['glucides'],
                    'lipides' => (float)$_POST['lipides'],
                    'unite' => trim($_POST['unite'])
                ];
                $this->alimentModel->create($data);
                $_SESSION['success'] = "Aliment ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_aliment_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Édition d'un aliment (Back) */
    public function editAliment() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $aliment = $this->alimentModel->getById($id);
        if (!$aliment) {
            $_SESSION['error'] = "Aliment introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateAliment($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'calories' => (int)$_POST['calories'],
                    'proteines' => (float)$_POST['proteines'],
                    'glucides' => (float)$_POST['glucides'],
                    'lipides' => (float)$_POST['lipides'],
                    'unite' => trim($_POST['unite'])
                ];
                $this->alimentModel->update($id, $data);
                $_SESSION['success'] = "Aliment modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_aliment_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Suppression d'un aliment (Back) */
    public function deleteAliment() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->alimentModel->delete($id);
        $_SESSION['success'] = "Aliment supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
        exit;
    }

    // =============================================
    // BACKOFFICE — PLANS NUTRITIONNELS
    // =============================================

    /** Liste des plans (Back) */
    public function listPlansBack() {
        $plans = $this->planModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_plans.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Ajout d'un plan (Back) */
    public function addPlanBack() {
        $errors = [];
        $repas = $this->repasModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validatePlan($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'description' => trim($_POST['description'] ?? ''),
                    'objectif_calories' => (int)$_POST['objectif_calories'],
                    'duree_jours' => (int)$_POST['duree_jours'],
                    'type_objectif' => $_POST['type_objectif'],
                    'date_debut' => $_POST['date_debut']
                ];

                $planId = $this->planModel->create($data);

                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->planModel->addRepas($planId, $repasId, $jour);
                        }
                    }
                }

                $_SESSION['success'] = "Plan créé avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_plan_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Édition d'un plan (Back) */
    public function editPlanBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $plan = $this->planModel->getById($id);
        if (!$plan) {
            $_SESSION['error'] = "Plan introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
            exit;
        }

        $errors = [];
        $repas = $this->repasModel->getAll();
        $planRepas = $this->planModel->getRepas($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validatePlan($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'description' => trim($_POST['description'] ?? ''),
                    'objectif_calories' => (int)$_POST['objectif_calories'],
                    'duree_jours' => (int)$_POST['duree_jours'],
                    'type_objectif' => $_POST['type_objectif'],
                    'date_debut' => $_POST['date_debut']
                ];
                $this->planModel->update($id, $data);

                $this->planModel->removeRepas($id);
                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->planModel->addRepas($id, $repasId, $jour);
                        }
                    }
                }

                $_SESSION['success'] = "Plan modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_plan_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Suppression d'un plan (Back) */
    public function deletePlanBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->planModel->delete($id);
        $_SESSION['success'] = "Plan supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
        exit;
    }

    // =============================================
    // FRONTOFFICE — RÉGIMES ALIMENTAIRES
    // =============================================

    /** Liste des régimes acceptés + régimes du client (Front) */
    public function listRegimes() {
        $regimes    = $this->regimeModel->getAccepted();
        $myRegimes  = [];
        $myName     = $_SESSION['regime_user'] ?? '';
        if (!empty($myName)) {
            // Inclure ses propres régimes même non acceptés
            $allMine = $this->regimeModel->getByUser($myName);
            // Filtrer: ceux non acceptés vont dans "mes propositions"
            foreach ($allMine as $r) {
                if ($r['statut'] !== 'accepte') {
                    $myRegimes[] = $r;
                }
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_regimes.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Formulaire de proposition de régime (Front) */
    public function addRegime() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRegime($_POST);

            if (empty($errors)) {
                $soumis_par = trim($_POST['soumis_par']);
                $data = [
                    'nom'            => trim($_POST['nom']),
                    'objectif'       => $_POST['objectif'],
                    'description'    => trim($_POST['description'] ?? ''),
                    'duree_semaines' => (int)$_POST['duree_semaines'],
                    'calories_jour'  => (int)$_POST['calories_jour'],
                    'restrictions'   => trim($_POST['restrictions'] ?? ''),
                    'soumis_par'     => $soumis_par
                ];
                $this->regimeModel->create($data);
                // Mémoriser le nom en session pour afficher ses propositions
                $_SESSION['regime_user'] = $soumis_par;
                $_SESSION['success'] = "Votre régime a été soumis\u00a0! Il sera examiné par notre équipe.";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_regime_add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Modification d'un régime par le client (Front) — remet en attente */
    public function editRegime() {
        $id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $regime = $this->regimeModel->getById($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRegime($_POST);

            if (empty($errors)) {
                $data = [
                    'nom'            => trim($_POST['nom']),
                    'objectif'       => $_POST['objectif'],
                    'description'    => trim($_POST['description'] ?? ''),
                    'duree_semaines' => (int)$_POST['duree_semaines'],
                    'calories_jour'  => (int)$_POST['calories_jour'],
                    'restrictions'   => trim($_POST['restrictions'] ?? ''),
                    'statut'         => 'en_attente'  // Repasse en attente de validation
                ];
                $this->regimeModel->update($id, $data);
                // Effacer le commentaire admin puisque c'est une nouvelle soumission
                $this->regimeModel->updateStatut($id, 'en_attente', null);
                $_SESSION['success'] = "Votre régime a été mis à jour et resoumis pour validation.";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/nutrition/front_regime_edit.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    // =============================================
    // FRONTOFFICE — SUPPRESSION DE RÉGIME (CLIENT)
    // =============================================

    /** Supprimer son propre régime (Front) — uniquement en_attente ou refusé */
    public function deleteRegimeFront() {
        $id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $regime = $this->regimeModel->getById($id);

        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }

        // Vérification simple : le régime doit appartenir au nom en session
        $myName = $_SESSION['regime_user'] ?? '';
        if (empty($myName) || $regime['soumis_par'] !== $myName) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à supprimer ce régime.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }

        // Sécurité supplémentaire : ne pas supprimer un régime déjà accepté
        if ($regime['statut'] === 'accepte') {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer un régime déjà accepté.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }

        $this->regimeModel->delete($id);
        $_SESSION['success'] = "Votre proposition a été supprimée.";
        header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
        exit;
    }

    // =============================================
    // BACKOFFICE — RÉGIMES ALIMENTAIRES
    // =============================================

    /** Liste de tous les régimes (Back) */
    public function listRegimesBack() {
        $regimes = $this->regimeModel->getAll();
        $pendingCount = $this->regimeModel->countPending();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_regimes.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Accepter un régime (Back) */
    public function acceptRegime() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $regime = $this->regimeModel->getById($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
            exit;
        }
        $this->regimeModel->updateStatut($id, 'accepte', null);
        $_SESSION['success'] = "Régime \"" . htmlspecialchars($regime['nom']) . "\" accepté avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
        exit;
    }

    /** Refuser un régime (Back) */
    public function refuseRegime() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $regime = $this->regimeModel->getById($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
            exit;
        }
        $commentaire = trim($_POST['commentaire'] ?? '');
        $this->regimeModel->updateStatut($id, 'refuse', $commentaire ?: null);
        $_SESSION['success'] = "Régime \"" . htmlspecialchars($regime['nom']) . "\" refusé.";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
        exit;
    }

    /** Supprimer un régime (Back) */
    public function deleteRegimeBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->regimeModel->delete($id);
        $_SESSION['success'] = "Régime supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
        exit;
    }

    /** Ajouter un régime depuis le backoffice (directement accepté) */
    public function addRegimeBack() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRegime($_POST);

            if (empty($errors)) {
                $data = [
                    'nom'            => trim($_POST['nom']),
                    'objectif'       => $_POST['objectif'],
                    'description'    => trim($_POST['description'] ?? ''),
                    'duree_semaines' => (int)$_POST['duree_semaines'],
                    'calories_jour'  => (int)$_POST['calories_jour'],
                    'restrictions'   => trim($_POST['restrictions'] ?? ''),
                    'soumis_par'     => trim($_POST['soumis_par'] ?? 'Admin'),
                    'statut'         => 'accepte'  // Créé directement validé
                ];
                $this->regimeModel->create($data);
                $_SESSION['success'] = "Régime ajouté et publié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_regime_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Modifier un régime depuis le backoffice (conserve le statut existant) */
    public function editRegimeBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $regime = $this->regimeModel->getById($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
            exit;
        }

        // L'admin ne peut modifier que les régimes acceptés
        if ($regime['statut'] !== 'accepte') {
            $_SESSION['error'] = "Vous ne pouvez modifier que les régimes acceptés. Acceptez-le d\'abord.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRegime($_POST);

            if (empty($errors)) {
                $data = [
                    'nom'            => trim($_POST['nom']),
                    'objectif'       => $_POST['objectif'],
                    'description'    => trim($_POST['description'] ?? ''),
                    'duree_semaines' => (int)$_POST['duree_semaines'],
                    'calories_jour'  => (int)$_POST['calories_jour'],
                    'restrictions'   => trim($_POST['restrictions'] ?? ''),
                    'statut'         => 'accepte'  // L'admin conserve le statut accepté
                ];
                $this->regimeModel->update($id, $data);
                $_SESSION['success'] = "Régime modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/nutrition/back_regime_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    // =============================================
    // VALIDATION
    // =============================================

    /** Validation du formulaire repas */
    private function validateRepas($post) {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du repas est obligatoire.";
        }
        if (empty($post['date_repas'] ?? '')) {
            $errors[] = "La date est obligatoire.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $post['date_repas'])) {
            $errors[] = "La date doit être au format AAAA-MM-JJ.";
        }
        $typesValides = ['petit_dejeuner', 'dejeuner', 'diner', 'collation'];
        if (empty($post['type_repas'] ?? '') || !in_array($post['type_repas'], $typesValides)) {
            $errors[] = "Le type de repas est invalide.";
        }
        return $errors;
    }

    /** Validation du formulaire aliment */
    private function validateAliment($post) {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom de l'aliment est obligatoire.";
        }
        if (!isset($post['calories']) || !is_numeric($post['calories']) || (int)$post['calories'] < 0) {
            $errors[] = "Les calories doivent être un nombre positif.";
        }
        if (isset($post['proteines']) && (!is_numeric($post['proteines']) || (float)$post['proteines'] < 0)) {
            $errors[] = "Les protéines doivent être un nombre positif.";
        }
        if (isset($post['glucides']) && (!is_numeric($post['glucides']) || (float)$post['glucides'] < 0)) {
            $errors[] = "Les glucides doivent être un nombre positif.";
        }
        if (isset($post['lipides']) && (!is_numeric($post['lipides']) || (float)$post['lipides'] < 0)) {
            $errors[] = "Les lipides doivent être un nombre positif.";
        }
        if (empty(trim($post['unite'] ?? ''))) {
            $errors[] = "L'unité est obligatoire.";
        }
        return $errors;
    }

    /** Validation du formulaire plan nutritionnel */
    private function validatePlan($post) {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du plan est obligatoire.";
        }
        if (!isset($post['objectif_calories']) || !is_numeric($post['objectif_calories']) || (int)$post['objectif_calories'] <= 0) {
            $errors[] = "L'objectif calorique doit être un nombre positif.";
        }
        if (!isset($post['duree_jours']) || !is_numeric($post['duree_jours']) || (int)$post['duree_jours'] <= 0) {
            $errors[] = "La durée doit être d'au moins 1 jour.";
        }
        $typesValides = ['perte_poids', 'maintien', 'prise_masse'];
        if (empty($post['type_objectif'] ?? '') || !in_array($post['type_objectif'], $typesValides)) {
            $errors[] = "Le type d'objectif est invalide.";
        }
        if (empty($post['date_debut'] ?? '')) {
            $errors[] = "La date de début est obligatoire.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $post['date_debut'])) {
            $errors[] = "La date doit être au format AAAA-MM-JJ.";
        }
        return $errors;
    }

    /** Validation du formulaire régime alimentaire */
    private function validateRegime($post) {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du régime est obligatoire.";
        }
        $objectives = ['perte_poids', 'maintien', 'prise_masse', 'sante_generale'];
        if (empty($post['objectif'] ?? '') || !in_array($post['objectif'], $objectives)) {
            $errors[] = "L'objectif est invalide.";
        }
        if (!isset($post['duree_semaines']) || !is_numeric($post['duree_semaines']) || (int)$post['duree_semaines'] <= 0) {
            $errors[] = "La durée doit être d'au moins 1 semaine.";
        }
        if (!isset($post['calories_jour']) || !is_numeric($post['calories_jour']) || (int)$post['calories_jour'] <= 0) {
            $errors[] = "L'apport calorique journalier doit être un nombre positif.";
        }
        if (empty(trim($post['soumis_par'] ?? ''))) {
            $errors[] = "Votre nom est obligatoire.";
        }
        return $errors;
    }
}
