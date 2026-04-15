<?php
/**
 * Contrôleur Nutrition — Gestion du suivi nutritionnel
 * Gère les CRUD pour Repas et Aliments (Front + Back)
 */
class NutritionController {
    private $repasModel;
    private $alimentModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->repasModel = new Repas($pdo);
        $this->alimentModel = new Aliment($pdo);
    }

    // =============================================
    // FRONTOFFICE
    // =============================================

    /** Liste des repas du jour (Front) */
    public function listFront() {
        $repas = $this->repasModel->getToday();
        // Ajouter les aliments pour chaque repas
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
                // Calculer calories total
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

                // Ajouter les aliments
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

                // Recréer les liaisons aliments
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
}
