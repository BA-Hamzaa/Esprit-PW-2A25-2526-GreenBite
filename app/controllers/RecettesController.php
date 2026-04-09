<?php
/**
 * Contrôleur Recettes — Gestion des recettes durables et ingrédients
 */
class RecettesController {
    private $recetteModel;
    private $ingredientModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->recetteModel = new Recette($pdo);
        $this->ingredientModel = new Ingredient($pdo);
    }

    // =============================================
    // FRONTOFFICE
    // =============================================

    /** Liste des recettes avec filtres (Front) */
    public function listFront() {
        $difficulte = isset($_GET['difficulte']) ? trim($_GET['difficulte']) : '';
        $categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : '';

        $recettes = $this->recetteModel->search($difficulte, $categorie);
        $categories = $this->recetteModel->getCategories();

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/recettes/front_list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Détail d'une recette (Front) */
    public function detailFront() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->recetteModel->getById($id);
        if (!$recette) {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=recettes');
            exit;
        }
        $ingredients = $this->recetteModel->getIngredients($id);

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/recettes/front_detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    // =============================================
    // BACKOFFICE — RECETTES
    // =============================================

    /** Liste de toutes les recettes (Back) */
    public function listBack() {
        $recettes = $this->recetteModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/recettes/back_list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Ajout d'une recette (Back) */
    public function addBack() {
        $errors = [];
        $ingredients = $this->ingredientModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRecette($_POST, $_FILES);

            if (empty($errors)) {
                $imageName = '';
                if (!empty($_FILES['image']['name'])) {
                    $imageName = $this->uploadImage($_FILES['image']);
                }

                $data = [
                    'titre' => trim($_POST['titre']),
                    'description' => trim($_POST['description']),
                    'instructions' => trim($_POST['instructions']),
                    'temps_preparation' => (int)$_POST['temps_preparation'],
                    'difficulte' => $_POST['difficulte'],
                    'categorie' => trim($_POST['categorie']),
                    'image' => $imageName,
                    'calories_total' => (int)($_POST['calories_total'] ?? 0),
                    'score_carbone' => (float)($_POST['score_carbone'] ?? 0)
                ];

                $recetteId = $this->recetteModel->create($data);

                // Ajouter les ingrédients
                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($ingredientId) && $quantite > 0) {
                            $this->recetteModel->addIngredient($recetteId, $ingredientId, $quantite);
                        }
                    }
                }

                $_SESSION['success'] = "Recette ajoutée avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/recettes/back_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Édition d'une recette (Back) */
    public function editBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->recetteModel->getById($id);
        if (!$recette) {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list');
            exit;
        }

        $errors = [];
        $ingredients = $this->ingredientModel->getAll();
        $recetteIngredients = $this->recetteModel->getIngredients($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRecette($_POST, $_FILES, true);

            if (empty($errors)) {
                $imageName = '';
                if (!empty($_FILES['image']['name'])) {
                    $imageName = $this->uploadImage($_FILES['image']);
                }

                $data = [
                    'titre' => trim($_POST['titre']),
                    'description' => trim($_POST['description']),
                    'instructions' => trim($_POST['instructions']),
                    'temps_preparation' => (int)$_POST['temps_preparation'],
                    'difficulte' => $_POST['difficulte'],
                    'categorie' => trim($_POST['categorie']),
                    'image' => $imageName,
                    'calories_total' => (int)($_POST['calories_total'] ?? 0),
                    'score_carbone' => (float)($_POST['score_carbone'] ?? 0)
                ];

                $this->recetteModel->update($id, $data);

                // Recréer les liaisons ingrédients
                $this->recetteModel->removeIngredients($id);
                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($ingredientId) && $quantite > 0) {
                            $this->recetteModel->addIngredient($id, $ingredientId, $quantite);
                        }
                    }
                }

                $_SESSION['success'] = "Recette modifiée avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/recettes/back_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Suppression d'une recette (Back) */
    public function deleteBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->recetteModel->delete($id);
        $_SESSION['success'] = "Recette supprimée avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list');
        exit;
    }

    // =============================================
    // BACKOFFICE — INGRÉDIENTS
    // =============================================

    /** Liste des ingrédients (Back) */
    public function listIngredients() {
        $ingredients = $this->ingredientModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/recettes/back_ingredients.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Ajout d'un ingrédient (Back) */
    public function addIngredient() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateIngredient($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'unite' => trim($_POST['unite']),
                    'calories_par_unite' => (int)$_POST['calories_par_unite'],
                    'is_local' => isset($_POST['is_local']) ? 1 : 0
                ];
                $this->ingredientModel->create($data);
                $_SESSION['success'] = "Ingrédient ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/recettes/back_ingredient_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Édition d'un ingrédient (Back) */
    public function editIngredient() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $ingredient = $this->ingredientModel->getById($id);
        if (!$ingredient) {
            $_SESSION['error'] = "Ingrédient introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateIngredient($_POST);

            if (empty($errors)) {
                $data = [
                    'nom' => trim($_POST['nom']),
                    'unite' => trim($_POST['unite']),
                    'calories_par_unite' => (int)$_POST['calories_par_unite'],
                    'is_local' => isset($_POST['is_local']) ? 1 : 0
                ];
                $this->ingredientModel->update($id, $data);
                $_SESSION['success'] = "Ingrédient modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/recettes/back_ingredient_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Suppression d'un ingrédient (Back) */
    public function deleteIngredient() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->ingredientModel->delete($id);
        $_SESSION['success'] = "Ingrédient supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients');
        exit;
    }

    // =============================================
    // VALIDATION
    // =============================================

    /** Validation du formulaire recette */
    private function validateRecette($post, $files, $isEdit = false) {
        $errors = [];
        if (empty(trim($post['titre'] ?? ''))) {
            $errors[] = "Le titre est obligatoire.";
        }
        $instructions = trim($post['instructions'] ?? '');
        if (empty($instructions) || strlen($instructions) < 20) {
            $errors[] = "Les instructions doivent contenir au moins 20 caractères.";
        }
        if (!isset($post['temps_preparation']) || !is_numeric($post['temps_preparation']) || (int)$post['temps_preparation'] <= 0) {
            $errors[] = "Le temps de préparation doit être un nombre positif.";
        }
        $difficultesValides = ['facile', 'moyen', 'difficile'];
        if (empty($post['difficulte'] ?? '') || !in_array($post['difficulte'], $difficultesValides)) {
            $errors[] = "La difficulté sélectionnée est invalide.";
        }
        // Vérifier au moins un ingrédient
        $hasIngredient = false;
        if (!empty($post['ingredient_ids'])) {
            foreach ($post['ingredient_ids'] as $i => $iid) {
                if (!empty($iid) && isset($post['quantites'][$i]) && (float)$post['quantites'][$i] > 0) {
                    $hasIngredient = true;
                    break;
                }
            }
        }
        if (!$hasIngredient) {
            $errors[] = "Vous devez ajouter au moins un ingrédient.";
        }
        // Validation image
        if (!empty($files['image']['name'])) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($files['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                $errors[] = "L'image doit être au format JPG, PNG ou GIF.";
            }
            if ($files['image']['size'] > 2 * 1024 * 1024) {
                $errors[] = "L'image ne doit pas dépasser 2 Mo.";
            }
        }
        return $errors;
    }

    /** Validation du formulaire ingrédient */
    private function validateIngredient($post) {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom de l'ingrédient est obligatoire.";
        }
        if (empty(trim($post['unite'] ?? ''))) {
            $errors[] = "L'unité est obligatoire.";
        }
        if (!isset($post['calories_par_unite']) || !is_numeric($post['calories_par_unite']) || (int)$post['calories_par_unite'] < 0) {
            $errors[] = "Les calories par unité doivent être un nombre positif.";
        }
        return $errors;
    }

    /** Upload d'image */
    private function uploadImage($file) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid('rec_') . '.' . $ext;
        $dest = BASE_PATH . '/public/assets/images/uploads/' . $filename;
        move_uploaded_file($file['tmp_name'], $dest);
        return $filename;
    }
}
