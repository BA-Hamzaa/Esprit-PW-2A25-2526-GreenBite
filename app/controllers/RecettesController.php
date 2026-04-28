<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/Recette.php';
require_once BASE_PATH . '/app/models/Ingredient.php';

class RecettesController {

    /////..............................Afficher Recettes (Front — acceptées)............................../////
    function AfficherRecettesFront($difficulte = '', $categorie = '') {
        $sql    = "SELECT * FROM recette WHERE statut = 'acceptee'";
        $params = [];
        if (!empty($difficulte)) {
            $sql .= " AND difficulte = :difficulte";
            $params['difficulte'] = $difficulte;
        }
        if (!empty($categorie)) {
            $sql .= " AND (categorie = :cat1 OR categorie LIKE :cat2)";
            $params['cat1'] = $categorie;
            $params['cat2'] = '%' . $categorie . '%';
        }
        $sql .= " ORDER BY created_at DESC";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute($params);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher Catégories de Recettes............................../////
    function AfficherCategoriesRecettes() {
        $sql = "SELECT DISTINCT categorie FROM recette WHERE categorie IS NOT NULL AND statut='acceptee' ORDER BY categorie";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer une Recette par ID............................../////
    function RecupererRecette($id) {
        $sql = "SELECT * FROM recette WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer les Ingrédients d'une Recette............................../////
    function RecupererIngredientsRecette($recette_id) {
        $sql = "SELECT ri.quantite, i.nom, i.unite, i.calories_par_unite, i.is_local
                FROM recette_ingredient ri
                JOIN ingredient i ON ri.ingredient_id = i.id
                WHERE ri.recette_id = :recette_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher toutes les Recettes (Back)............................../////
    function AfficherRecettesBack() {
        $sql = "SELECT * FROM recette ORDER BY created_at DESC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher Recettes en attente (Modération)............................../////
    function AfficherRecettesEnAttente() {
        $sql = "SELECT * FROM recette WHERE statut = 'en_attente' ORDER BY created_at DESC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Recette............................../////
    function AjouterRecette(Recette $recette, $imageFile = null) {
        if ($imageFile && $imageFile['error'] === 0) {
            $imageName = $this->uploadImage($imageFile);
            $recette->setImage($imageName);
        }

        $sql = "INSERT INTO recette (titre, description, instructions, temps_preparation, difficulte,
                    categorie, image, calories_total, score_carbone, soumis_par, statut)
                VALUES (:titre, :description, :instructions, :temps_preparation, :difficulte,
                    :categorie, :image, :calories_total, :score_carbone, :soumis_par, :statut)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'titre'             => $recette->getTitre(),
                'description'       => $recette->getDescription(),
                'instructions'      => $recette->getInstructions(),
                'temps_preparation' => $recette->getTempsPreparation(),
                'difficulte'        => $recette->getDifficulte(),
                'categorie'         => $recette->getCategorie(),
                'image'             => $recette->getImage(),
                'calories_total'    => $recette->getCaloriesTotal(),
                'score_carbone'     => $recette->getScoreCarbone(),
                'soumis_par'        => $recette->getSoumisPar(),
                'statut'            => $recette->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Lien Recette-Ingrédient............................../////
    function AjouterIngredientRecette($recette_id, $ingredient_id, $quantite) {
        $sql = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite)
                VALUES (:recette_id, :ingredient_id, :quantite)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'recette_id'    => $recette_id,
                'ingredient_id' => $ingredient_id,
                'quantite'      => $quantite,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Liens Ingrédients d'une Recette............................../////
    function SupprimerIngredientsRecette($recette_id) {
        $sql = "DELETE FROM recette_ingredient WHERE recette_id = :recette_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Recette............................../////
    function ModifierRecette(Recette $recette, $id, $imageFile = null) {
        $imageName = $recette->getImage();
        if ($imageFile && $imageFile['error'] === 0) {
            $imageName = $this->uploadImage($imageFile);
        }

        $sql = "UPDATE recette SET
                    titre             = :titre,
                    description       = :description,
                    instructions      = :instructions,
                    temps_preparation = :temps_preparation,
                    difficulte        = :difficulte,
                    categorie         = :categorie,
                    image             = :image,
                    calories_total    = :calories_total,
                    score_carbone     = :score_carbone
                WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'titre'             => $recette->getTitre(),
                'description'       => $recette->getDescription(),
                'instructions'      => $recette->getInstructions(),
                'temps_preparation' => $recette->getTempsPreparation(),
                'difficulte'        => $recette->getDifficulte(),
                'categorie'         => $recette->getCategorie(),
                'image'             => $imageName,
                'calories_total'    => $recette->getCaloriesTotal(),
                'score_carbone'     => $recette->getScoreCarbone(),
                'id'                => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Statut Recette............................../////
    function ModifierStatutRecette($id, $statut) {
        $sql = "UPDATE recette SET statut = :statut WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['statut' => $statut, 'id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Recette............................../////
    function SupprimerRecette($id) {
        $sql = "DELETE FROM recette WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer Suggestions d'un Client............................../////
    function AfficherSuggestionsClient($soumis_par) {
        $sql = "SELECT * FROM recette WHERE soumis_par = :soumis_par ORDER BY created_at DESC";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':soumis_par', $soumis_par);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher tous les Ingrédients............................../////
    function AfficherIngredients() {
        $sql = "SELECT * FROM ingredient ORDER BY nom ASC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer un Ingrédient par ID............................../////
    function RecupererIngredient($id) {
        $sql = "SELECT * FROM ingredient WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Ingrédient............................../////
    function AjouterIngredient(Ingredient $ingredient) {
        $sql = "INSERT INTO ingredient (nom, unite, calories_par_unite, is_local)
                VALUES (:nom, :unite, :calories_par_unite, :is_local)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom'                => $ingredient->getNom(),
                'unite'              => $ingredient->getUnite(),
                'calories_par_unite' => $ingredient->getCaloriesParUnite(),
                'is_local'           => $ingredient->getIsLocal(),
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Ingrédient............................../////
    function ModifierIngredient(Ingredient $ingredient, $id) {
        $sql = "UPDATE ingredient SET
                    nom                = :nom,
                    unite              = :unite,
                    calories_par_unite = :calories_par_unite,
                    is_local           = :is_local
                WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom'                => $ingredient->getNom(),
                'unite'              => $ingredient->getUnite(),
                'calories_par_unite' => $ingredient->getCaloriesParUnite(),
                'is_local'           => $ingredient->getIsLocal(),
                'id'                 => $id,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /////..............................Supprimer Ingrédient............................../////
    function SupprimerIngredient($id) {
        $sql = "DELETE FROM ingredient WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Validation Suggestion............................../////
    function ValiderSuggestion($post, $files) {
        $errors = [];
        if (empty(trim($post['soumis_par'] ?? ''))) { $errors[] = "Votre nom est obligatoire."; }
        if (empty(trim($post['titre'] ?? '')))       { $errors[] = "Le titre est obligatoire."; }
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
        $hasIngredient = false;
        if (!empty($post['ingredient_ids'])) {
            foreach ($post['ingredient_ids'] as $i => $iid) {
                if (!empty($iid) && isset($post['quantites'][$i]) && (float)$post['quantites'][$i] > 0) {
                    $hasIngredient = true; break;
                }
            }
        }
        if (!$hasIngredient) { $errors[] = "Vous devez ajouter au moins un ingrédient."; }
        if (!empty($files['image']['name'])) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext     = strtolower(pathinfo($files['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) { $errors[] = "L'image doit être au format JPG, PNG ou GIF."; }
            if ($files['image']['size'] > 2 * 1024 * 1024) { $errors[] = "L'image ne doit pas dépasser 2 Mo."; }
        }
        return $errors;
    }

    /////..............................Validation Recette (Back)............................../////
    function ValiderRecette($post, $files, $isEdit = false) {
        $errors = [];
        if (empty(trim($post['titre'] ?? ''))) { $errors[] = "Le titre est obligatoire."; }
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
        $hasIngredient = false;
        if (!empty($post['ingredient_ids'])) {
            foreach ($post['ingredient_ids'] as $i => $iid) {
                if (!empty($iid) && isset($post['quantites'][$i]) && (float)$post['quantites'][$i] > 0) {
                    $hasIngredient = true; break;
                }
            }
        }
        if (!$hasIngredient) { $errors[] = "Vous devez ajouter au moins un ingrédient."; }
        if (!empty($files['image']['name'])) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext     = strtolower(pathinfo($files['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) { $errors[] = "L'image doit être au format JPG, PNG ou GIF."; }
            if ($files['image']['size'] > 2 * 1024 * 1024) { $errors[] = "L'image ne doit pas dépasser 2 Mo."; }
        }
        return $errors;
    }

    /////..............................Validation Ingrédient............................../////
    function ValiderIngredient($post) {
        $errors = [];
        if (empty(trim($post['nom'] ?? '')))   { $errors[] = "Le nom de l'ingrédient est obligatoire."; }
        if (empty(trim($post['unite'] ?? ''))) { $errors[] = "L'unité est obligatoire."; }
        if (!isset($post['calories_par_unite']) || !is_numeric($post['calories_par_unite']) || (int)$post['calories_par_unite'] < 0) {
            $errors[] = "Les calories par unité doivent être un nombre positif.";
        }
        return $errors;
    }

    /////..............................Upload Image (méthode privée)............................../////
    private function uploadImage($imageFile) {
        $uploadDir    = BASE_PATH . '/app/models/public/assets/images/uploads/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize      = 2 * 1024 * 1024;

        if (!in_array($imageFile['type'], $allowedTypes)) {
            die('Erreur: Format image non supporté');
        }
        if ($imageFile['size'] > $maxSize) {
            die('Erreur: Image trop lourde (max 2Mo)');
        }
        $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $imageName = uniqid('rec_', true) . '.' . $extension;
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
        if (!move_uploaded_file($imageFile['tmp_name'], $uploadDir . $imageName)) {
            die("Erreur: Échec de l'upload de l'image");
        }
        return $imageName;
    }

    /////..............................FRONTOFFICE — Liste Recettes............................../////
    function listFront() {
        $difficulte = isset($_GET['difficulte']) ? trim($_GET['difficulte']) : '';
        $categorie  = isset($_GET['categorie'])  ? trim($_GET['categorie'])  : '';
        $recettes   = $this->AfficherRecettesFront($difficulte, $categorie);
        $categories = $this->AfficherCategoriesRecettes();

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/recettes/list.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Détail Recette............................../////
    function detailFront() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->RecupererRecette($id);
        if (!$recette) {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=recettes'); exit;
        }
        $ingredients = $this->RecupererIngredientsRecette($id);

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/recettes/detail.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Suggérer une Recette............................../////
    function suggestFront() {
        $errors          = [];
        $ingredientsList = $this->AfficherIngredients();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderSuggestion($_POST, $_FILES);
            if (empty($errors)) {
                $recette = new Recette(
                    trim($_POST['titre']),
                    trim($_POST['description']),
                    trim($_POST['instructions']),
                    (int)$_POST['temps_preparation'],
                    $_POST['difficulte'],
                    'en_attente',
                    trim($_POST['categorie'] ?? ''),
                    '',
                    (int)($_POST['calories_total'] ?? 0),
                    (float)($_POST['score_carbone'] ?? 0),
                    trim($_POST['soumis_par'] ?? '')
                );
                $recetteId = $this->AjouterRecette($recette, $_FILES['image'] ?? null);

                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i] ?? 0;
                        if (!empty($ingredientId) && (float)$quantite > 0) {
                            $this->AjouterIngredientRecette($recetteId, $ingredientId, $quantite);
                        }
                    }
                }
                $_SESSION['recette_user'] = $recette->getSoumisPar();
                $_SESSION['success']      = "Votre recette a été soumise et est en attente de validation.";
                header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
            }
        }

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/recettes/suggest.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Mes Suggestions............................../////
    function mySuggestions() {
        $myName     = $_SESSION['recette_user'] ?? '';
        $myRecettes = [];
        if (!empty($myName)) { $myRecettes = $this->AfficherSuggestionsClient($myName); }

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/recettes/my_suggestions.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Modifier une Suggestion............................../////
    function editSuggestionFront() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->RecupererRecette($id);
        if (!$recette) {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
        }
        $myName = $_SESSION['recette_user'] ?? '';
        if (empty($myName) || $recette['soumis_par'] !== $myName) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier cette recette.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
        }
        if ($recette['statut'] === 'acceptee') {
            $_SESSION['error'] = "Vous ne pouvez pas modifier une recette déjà acceptée.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
        }

        $errors             = [];
        $ingredientsList    = $this->AfficherIngredients();
        $recetteIngredients = $this->RecupererLiensIngredients($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderSuggestion($_POST, $_FILES);
            if (empty($errors)) {
                $r = new Recette(
                    trim($_POST['titre']), trim($_POST['description']), trim($_POST['instructions']),
                    (int)$_POST['temps_preparation'], $_POST['difficulte'], 'en_attente',
                    trim($_POST['categorie'] ?? ''), $recette['image'],
                    (int)($_POST['calories_total'] ?? 0), (float)($_POST['score_carbone'] ?? 0)
                );
                $this->ModifierRecette($r, $id, $_FILES['image'] ?? null);
                $this->SupprimerIngredientsRecette($id);
                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i] ?? 0;
                        if (!empty($ingredientId) && (float)$quantite > 0) {
                            $this->AjouterIngredientRecette($id, $ingredientId, $quantite);
                        }
                    }
                }
                $this->ModifierStatutRecette($id, 'en_attente');
                $_SESSION['success'] = "Votre recette a été mise à jour et resoumise pour validation.";
                header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
            }
        }

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/recettes/edit_suggestion.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Supprimer Suggestion............................../////
    function deleteSuggestionFront() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->RecupererRecette($id);
        if (!$recette) {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
        }
        $myName = $_SESSION['recette_user'] ?? '';
        if (empty($myName) || $recette['soumis_par'] !== $myName) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à supprimer cette recette.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
        }
        if ($recette['statut'] === 'acceptee') {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer une recette déjà acceptée.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
        }
        $this->SupprimerRecette($id);
        $_SESSION['success'] = "Votre proposition de recette a été supprimée.";
        header('Location: ' . BASE_URL . '/?page=recettes&action=my-suggestions'); exit;
    }

    /////..............................BACKOFFICE — Liste Recettes............................../////
    function listBack() {
        $recettes = $this->AfficherRecettesBack();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/list.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Ajouter Recette............................../////
    function addBack() {
        $errors          = [];
        $ingredientsList = $this->AfficherIngredients();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRecette($_POST, $_FILES);
            if (empty($errors)) {
                $recette = new Recette(
                    trim($_POST['titre']), trim($_POST['description']), trim($_POST['instructions']),
                    (int)$_POST['temps_preparation'], $_POST['difficulte'], 'acceptee',
                    trim($_POST['categorie']), '',
                    (int)($_POST['calories_total'] ?? 0), (float)($_POST['score_carbone'] ?? 0)
                );
                $recetteId = $this->AjouterRecette($recette, $_FILES['image'] ?? null);
                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($ingredientId) && $quantite > 0) {
                            $this->AjouterIngredientRecette($recetteId, $ingredientId, $quantite);
                        }
                    }
                }
                $_SESSION['success'] = "Recette ajoutée avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list'); exit;
            }
        }

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/add.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Modifier Recette............................../////
    function editBack() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->RecupererRecette($id);
        if (!$recette) {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list'); exit;
        }

        $errors             = [];
        $ingredientsList    = $this->AfficherIngredients();
        $recetteIngredients = $this->RecupererLiensIngredients($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRecette($_POST, $_FILES, true);
            if (empty($errors)) {
                $r = new Recette(
                    trim($_POST['titre']), trim($_POST['description']), trim($_POST['instructions']),
                    (int)$_POST['temps_preparation'], $_POST['difficulte'], $recette['statut'],
                    trim($_POST['categorie']), $recette['image'],
                    (int)($_POST['calories_total'] ?? 0), (float)($_POST['score_carbone'] ?? 0)
                );
                $this->ModifierRecette($r, $id, $_FILES['image'] ?? null);
                $this->SupprimerIngredientsRecette($id);
                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($ingredientId) && $quantite > 0) {
                            $this->AjouterIngredientRecette($id, $ingredientId, $quantite);
                        }
                    }
                }
                $_SESSION['success'] = "Recette modifiée avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list'); exit;
            }
        }

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/edit.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Supprimer Recette............................../////
    function deleteBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->SupprimerRecette($id);
        $_SESSION['success'] = "Recette supprimée avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=list'); exit;
    }

    /////..............................BACKOFFICE — Modération............................../////
    function moderationList() {
        $recettes = $this->AfficherRecettesEnAttente();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/moderation.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Accepter Recette............................../////
    function acceptBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->ModifierStatutRecette($id, 'acceptee');
            $_SESSION['success'] = "Recette acceptée et publiée avec succès !";
        } else {
            $_SESSION['error'] = "Recette introuvable.";
        }
        $ref = $_SERVER['HTTP_REFERER'] ?? '';
        header('Location: ' . BASE_URL . (strpos($ref, 'moderate') !== false ? '/?page=admin-recettes&action=moderate' : '/?page=admin-recettes&action=list'));
        exit;
    }

    /////..............................BACKOFFICE — Refuser Recette............................../////
    function refuseBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->ModifierStatutRecette($id, 'refusee');
            $_SESSION['success'] = "Recette refusée.";
        } else {
            $_SESSION['error'] = "Recette introuvable.";
        }
        $ref = $_SERVER['HTTP_REFERER'] ?? '';
        header('Location: ' . BASE_URL . (strpos($ref, 'moderate') !== false ? '/?page=admin-recettes&action=moderate' : '/?page=admin-recettes&action=list'));
        exit;
    }

    /////..............................BACKOFFICE — Liste Ingrédients............................../////
    function listIngredients() {
        $ingredients = $this->AfficherIngredients();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/ingredients.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Ajouter Ingrédient............................../////
    function addIngredient() {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderIngredient($_POST);
            if (empty($errors)) {
                $i = new Ingredient(
                    trim($_POST['nom']),
                    trim($_POST['unite']),
                    (int)$_POST['calories_par_unite'],
                    isset($_POST['is_local']) ? 1 : 0
                );
                $this->AjouterIngredient($i);
                $_SESSION['success'] = "Ingrédient ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients'); exit;
            }
        }
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/ingredient_add.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Modifier Ingrédient............................../////
    function editIngredient() {
        $id         = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $ingredient = $this->RecupererIngredient($id);
        if (!$ingredient) {
            $_SESSION['error'] = "Ingrédient introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients'); exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderIngredient($_POST);
            if (empty($errors)) {
                $i = new Ingredient(
                    trim($_POST['nom']),
                    trim($_POST['unite']),
                    (int)$_POST['calories_par_unite'],
                    isset($_POST['is_local']) ? 1 : 0
                );
                $this->ModifierIngredient($i, $id);
                $_SESSION['success'] = "Ingrédient modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients'); exit;
            }
        }
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/ingredient_edit.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Supprimer Ingrédient............................../////
    function deleteIngredient() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->SupprimerIngredient($id);
        $_SESSION['success'] = "Ingrédient supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=ingredients'); exit;
    }

    /////..............................Récupérer liens recette_ingredient............................../////
    private function RecupererLiensIngredients($recette_id) {
        $sql = "SELECT * FROM recette_ingredient WHERE recette_id = :recette_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
