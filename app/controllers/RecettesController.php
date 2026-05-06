<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/Recette.php';
require_once BASE_PATH . '/app/models/Ingredient.php';
require_once BASE_PATH . '/app/models/CommentaireRecette.php';
require_once BASE_PATH . '/app/models/InstructionRecette.php';
require_once BASE_PATH . '/app/models/Materiel.php';

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

    /////..............................Ajouter Recette avec nom image déjà connu (download URL)............................../////
    function AjouterRecetteAvecNomImage(Recette $recette, $imageName = null) {
        if ($imageName) { $recette->setImage($imageName); }
        return $this->AjouterRecette($recette, null);
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
        // Check for structured steps first (inst_titre[]), fallback to legacy textarea
        $hasStructuredSteps = false;
        if (!empty($post['inst_titre'])) {
            foreach ($post['inst_titre'] as $t) {
                if (!empty(trim($t))) { $hasStructuredSteps = true; break; }
            }
        }
        if (!$hasStructuredSteps) {
            $instructions = trim($post['instructions'] ?? '');
            if (empty($instructions) || strlen($instructions) < 20) {
                $errors[] = "Ajoutez au moins une étape de préparation.";
            }
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
        // Check for structured steps first (inst_titre[]), fallback to legacy textarea
        $hasStructuredSteps = false;
        if (!empty($post['inst_titre'])) {
            foreach ($post['inst_titre'] as $t) {
                if (!empty(trim($t))) { $hasStructuredSteps = true; break; }
            }
        }
        if (!$hasStructuredSteps) {
            $instructions = trim($post['instructions'] ?? '');
            if (empty($instructions) || strlen($instructions) < 20) {
                $errors[] = "Ajoutez au moins une étape de préparation.";
            }
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
        $uploadDir    = BASE_PATH . '/app/views/public/assets/images/uploads/';
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

    /////..............................Download Image from URL (TheMealDB)............................../////
    private function downloadImageFromUrl($url) {
        if (empty($url)) return null;
        $uploadDir = BASE_PATH . '/app/views/public/assets/images/uploads/';
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
        $ctx = stream_context_create(['http' => ['timeout' => 8, 'user_agent' => 'GreenBite/1.0']]);
        $data = @file_get_contents($url, false, $ctx);
        if (!$data) return null;
        // Detect extension from URL
        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) $ext = 'jpg';
        $imageName = uniqid('meal_', true) . '.' . $ext;
        file_put_contents($uploadDir . $imageName, $data);
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
        $ingredients  = $this->RecupererIngredientsRecette($id);
        $commentaires = $this->AfficherCommentairesRecette($id);
        $notes        = $this->NotesMoyennesRecettes();
        $noteInfo     = $notes[$id] ?? ['note_moyenne' => 0, 'nb_commentaires' => 0];

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/recettes/detail.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Suggérer une Recette............................../////
    function suggestFront() {
        $errors          = [];
        $ingredientsList = $this->AfficherIngredients();
        $materielsListe  = $this->AfficherMaterielsAcceptes();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderSuggestion($_POST, $_FILES);
            if (empty($errors)) {
                // Build legacy instructions text from structured steps
                $instrText = '';
                if (!empty($_POST['inst_titre'])) {
                    foreach ($_POST['inst_titre'] as $i => $t) {
                        if (trim($t) !== '') {
                            $instrText .= 'Étape ' . ($i + 1) . ' — ' . trim($t) . "\n" . trim($_POST['inst_description'][$i] ?? '') . "\n\n";
                        }
                    }
                }
                if (empty(trim($instrText))) { $instrText = trim($_POST['instructions'] ?? '...'); }

                $recette = new Recette(
                    trim($_POST['titre']),
                    trim($_POST['description']),
                    trim($instrText),
                    (int)$_POST['temps_preparation'],
                    $_POST['difficulte'],
                    'en_attente',
                    trim($_POST['categorie'] ?? ''),
                    '',
                    (int)($_POST['calories_total'] ?? 0),
                    (float)($_POST['score_carbone'] ?? 0),
                    trim($_POST['soumis_par'] ?? '')
                );
                // Handle image: prefer uploaded file, fallback to TheMealDB URL download
                $imageFile = $_FILES['image'] ?? null;
                $imageUrl  = trim($_POST['image_url'] ?? '');
                if (!empty($imageFile['tmp_name'])) {
                    $recetteId = $this->AjouterRecette($recette, $imageFile);
                } elseif (!empty($imageUrl)) {
                    $downloadedName = $this->downloadImageFromUrl($imageUrl);
                    $recetteId = $this->AjouterRecetteAvecNomImage($recette, $downloadedName);
                } else {
                    $recetteId = $this->AjouterRecette($recette, null);
                }

                if (!empty($_POST['ingredient_ids'])) {
                    foreach ($_POST['ingredient_ids'] as $i => $ingredientId) {
                        $quantite = $_POST['quantites'][$i] ?? 0;
                        if (!empty($ingredientId) && (float)$quantite > 0) {
                            $this->AjouterIngredientRecette($recetteId, $ingredientId, $quantite);
                        }
                    }
                }

                // Save structured instructions
                $this->SauvegarderInstructionsPost($recetteId, $_POST);

                // Save materiels
                if (!empty($_POST['materiel_ids'])) {
                    $this->LierMaterielsRecette($recetteId, $_POST['materiel_ids']);
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

        $errors               = [];
        $ingredientsList      = $this->AfficherIngredients();
        $recetteIngredients   = $this->RecupererLiensIngredients($id);
        $materielsListe       = $this->AfficherMaterielsAcceptes();
        $recetteInstructions  = $this->RecupererInstructionsRecette($id);
        $recetteMateriels     = $this->RecupererMaterielsRecette($id);
        $selectedMaterielIds  = array_column($recetteMateriels, 'id');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderSuggestion($_POST, $_FILES);
            if (empty($errors)) {
                $instrText = '';
                if (!empty($_POST['inst_titre'])) {
                    foreach ($_POST['inst_titre'] as $i => $t) {
                        if (trim($t) !== '') {
                            $instrText .= 'Étape ' . ($i + 1) . ' — ' . trim($t) . "\n" . trim($_POST['inst_description'][$i] ?? '') . "\n\n";
                        }
                    }
                }
                if (empty(trim($instrText))) { $instrText = trim($_POST['instructions'] ?? '...'); }

                $r = new Recette(
                    trim($_POST['titre']), trim($_POST['description']), trim($instrText),
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
                // Save structured instructions
                $this->SauvegarderInstructionsPost($id, $_POST);
                // Save materiels
                $this->LierMaterielsRecette($id, $_POST['materiel_ids'] ?? []);

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
        $materielsListe  = $this->AfficherMaterielsAcceptes();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRecette($_POST, $_FILES);
            if (empty($errors)) {
                $instrText = '';
                if (!empty($_POST['inst_titre'])) {
                    foreach ($_POST['inst_titre'] as $i => $t) {
                        if (trim($t) !== '') {
                            $instrText .= 'Étape ' . ($i + 1) . ' — ' . trim($t) . "\n" . trim($_POST['inst_description'][$i] ?? '') . "\n\n";
                        }
                    }
                }
                if (empty(trim($instrText))) { $instrText = trim($_POST['instructions'] ?? '...'); }

                $recette = new Recette(
                    trim($_POST['titre']), trim($_POST['description']), trim($instrText),
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
                $this->SauvegarderInstructionsPost($recetteId, $_POST);
                $this->LierMaterielsRecette($recetteId, $_POST['materiel_ids'] ?? []);

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

        $errors               = [];
        $ingredientsList      = $this->AfficherIngredients();
        $recetteIngredients   = $this->RecupererLiensIngredients($id);
        $materielsListe       = $this->AfficherMaterielsAcceptes();
        $recetteInstructions  = $this->RecupererInstructionsRecette($id);
        $recetteMateriels     = $this->RecupererMaterielsRecette($id);
        $selectedMaterielIds  = array_column($recetteMateriels, 'id');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRecette($_POST, $_FILES, true);
            if (empty($errors)) {
                $instrText = '';
                if (!empty($_POST['inst_titre'])) {
                    foreach ($_POST['inst_titre'] as $i => $t) {
                        if (trim($t) !== '') {
                            $instrText .= 'Étape ' . ($i + 1) . ' — ' . trim($t) . "\n" . trim($_POST['inst_description'][$i] ?? '') . "\n\n";
                        }
                    }
                }
                if (empty(trim($instrText))) { $instrText = trim($_POST['instructions'] ?? '...'); }

                $r = new Recette(
                    trim($_POST['titre']), trim($_POST['description']), trim($instrText),
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
                $this->SauvegarderInstructionsPost($id, $_POST);
                $this->LierMaterielsRecette($id, $_POST['materiel_ids'] ?? []);

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

    // ============================================================
    // COMMENTAIRES RECETTES
    // ============================================================

    /////..............................Récupérer Commentaires Approuvés d'une Recette (JOIN)............................../////
    function AfficherCommentairesRecette($recette_id) {
        $sql = "SELECT c.*, r.titre AS recette_titre
                FROM commentaire_recette c
                INNER JOIN recette r ON r.id = c.recette_id
                WHERE c.recette_id = :recette_id AND c.statut = 'approuve'
                ORDER BY c.created_at DESC";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer Tous les Commentaires (Back — JOIN)............................../////
    function AfficherTousCommentaires() {
        $sql = "SELECT c.*, r.titre AS recette_titre
                FROM commentaire_recette c
                INNER JOIN recette r ON r.id = c.recette_id
                ORDER BY c.created_at DESC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer Commentaires En Attente (Back — JOIN)............................../////
    function AfficherCommentairesEnAttente() {
        $sql = "SELECT c.*, r.titre AS recette_titre
                FROM commentaire_recette c
                INNER JOIN recette r ON r.id = c.recette_id
                WHERE c.statut = 'en_attente'
                ORDER BY c.created_at DESC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Notes Moyennes par Recette (LEFT JOIN)............................../////
    function NotesMoyennesRecettes() {
        $sql = "SELECT r.id,
                       COALESCE(AVG(c.note), 0)  AS note_moyenne,
                       COUNT(c.id)               AS nb_commentaires
                FROM recette r
                LEFT JOIN commentaire_recette c
                       ON c.recette_id = r.id AND c.statut = 'approuve'
                GROUP BY r.id";
        $db  = Database::getConnexion();
        try {
            $rows   = $db->query($sql)->fetchAll();
            $result = [];
            foreach ($rows as $row) {
                $result[$row['id']] = [
                    'note_moyenne'    => round((float)$row['note_moyenne'], 1),
                    'nb_commentaires' => (int)$row['nb_commentaires'],
                ];
            }
            return $result;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Commentaire............................../////
    function AjouterCommentaire(CommentaireRecette $c) {
        $sql = "INSERT INTO commentaire_recette
                    (recette_id, auteur, email, note, commentaire, statut)
                VALUES
                    (:recette_id, :auteur, :email, :note, :commentaire, :statut)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'recette_id'  => $c->getRecetteId(),
                'auteur'      => $c->getAuteur(),
                'email'       => $c->getEmail(),
                'note'        => $c->getNote(),
                'commentaire' => $c->getCommentaire(),
                'statut'      => $c->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Statut Commentaire............................../////
    function ModifierStatutCommentaire($id, $statut) {
        $sql = "UPDATE commentaire_recette SET statut = :statut WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['statut' => $statut, 'id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Commentaire............................../////
    function SupprimerCommentaire($id) {
        $sql = "DELETE FROM commentaire_recette WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Validation Commentaire............................../////
    function ValiderCommentaire($post) {
        $errors = [];
        if (empty(trim($post['auteur'] ?? ''))) {
            $errors[] = "Votre nom est obligatoire.";
        }
        if (!empty($post['email']) && !filter_var(trim($post['email']), FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }
        $note = (int)($post['note'] ?? 0);
        if ($note < 1 || $note > 5) {
            $errors[] = "La note doit être comprise entre 1 et 5 étoiles.";
        }
        $commentaire = trim($post['commentaire'] ?? '');
        if (empty($commentaire) || strlen($commentaire) < 10) {
            $errors[] = "Le commentaire doit contenir au moins 10 caractères.";
        }
        if (strlen($commentaire) > 1000) {
            $errors[] = "Le commentaire ne peut pas dépasser 1000 caractères.";
        }
        return $errors;
    }

    /////..............................FRONTOFFICE — Soumettre un Commentaire............................../////
    function commentFront() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recette = $this->RecupererRecette($id);
        if (!$recette || $recette['statut'] !== 'acceptee') {
            $_SESSION['error'] = "Recette introuvable.";
            header('Location: ' . BASE_URL . '/?page=recettes'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/?page=recettes&action=detail&id=' . $id); exit;
        }

        $errors = $this->ValiderCommentaire($_POST);
        if (empty($errors)) {
            $c = new CommentaireRecette(
                $id,
                trim($_POST['auteur']),
                (int)$_POST['note'],
                trim($_POST['commentaire']),
                !empty(trim($_POST['email'] ?? '')) ? trim($_POST['email']) : null,
                'approuve'          // Auto-approuvé : visible immédiatement
            );
            $this->AjouterCommentaire($c);
            $_SESSION['success'] = "Votre commentaire a été publié. Merci !";
        } else {
            $_SESSION['error'] = implode(' ', $errors);
        }
        header('Location: ' . BASE_URL . '/?page=recettes&action=detail&id=' . $id . '#commentaires'); exit;
    }

    /////..............................BACKOFFICE — Liste Tous les Commentaires............................../////
    function commentListBack() {
        $commentaires = $this->AfficherTousCommentaires();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/comments.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Modération Commentaires............................../////
    function commentModerateBack() {
        $commentaires = $this->AfficherCommentairesEnAttente();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/comments_moderate.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Approuver Commentaire............................../////
    function commentApproveBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->ModifierStatutCommentaire($id, 'approuve');
            $_SESSION['success'] = "Commentaire approuvé et publié.";
        } else {
            $_SESSION['error'] = "Commentaire introuvable.";
        }
        $ref = $_SERVER['HTTP_REFERER'] ?? '';
        header('Location: ' . BASE_URL . (strpos($ref, 'comments-moderate') !== false
            ? '/?page=admin-recettes&action=comments-moderate'
            : '/?page=admin-recettes&action=comments'));
        exit;
    }

    /////..............................BACKOFFICE — Refuser Commentaire............................../////
    function commentRefuseBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->ModifierStatutCommentaire($id, 'refuse');
            $_SESSION['success'] = "Commentaire refusé.";
        } else {
            $_SESSION['error'] = "Commentaire introuvable.";
        }
        $ref = $_SERVER['HTTP_REFERER'] ?? '';
        header('Location: ' . BASE_URL . (strpos($ref, 'comments-moderate') !== false
            ? '/?page=admin-recettes&action=comments-moderate'
            : '/?page=admin-recettes&action=comments'));
        exit;
    }

    /////..............................BACKOFFICE — Supprimer Commentaire............................../////
    function commentDeleteBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->SupprimerCommentaire($id);
            $_SESSION['success'] = "Commentaire supprimé.";
        } else {
            $_SESSION['error'] = "Commentaire introuvable.";
        }
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=comments'); exit;
    }

    /////..............................Récupérer un Commentaire par ID............................../////
    private function RecupererCommentaireById($id) {
        $sql = "SELECT * FROM commentaire_recette WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Note + Texte d'un Commentaire............................../////
    private function ModifierCommentaireTexte($id, $note, $commentaire) {
        $sql = "UPDATE commentaire_recette SET note = :note, commentaire = :commentaire WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['note' => $note, 'commentaire' => $commentaire, 'id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................FRONTOFFICE — Modifier un Commentaire............................../////
    function updateCommentFront() {
        $id         = isset($_GET['id'])         ? (int)$_GET['id']         : 0;
        $recette_id = isset($_GET['recette_id']) ? (int)$_GET['recette_id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/?page=recettes&action=detail&id=' . $recette_id . '#commentaires'); exit;
        }

        $com = $this->RecupererCommentaireById($id);
        if (!$com) {
            $_SESSION['error'] = "Commentaire introuvable.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=detail&id=' . $recette_id . '#commentaires'); exit;
        }

        // Verify the author name matches (case-insensitive)
        $auteur = trim($_POST['auteur'] ?? '');
        if (mb_strtolower($auteur) !== mb_strtolower($com['auteur'])) {
            $_SESSION['error'] = "Nom incorrect. Saisissez exactement le nom utilisé lors de votre commentaire original.";
            header('Location: ' . BASE_URL . '/?page=recettes&action=detail&id=' . $recette_id . '#commentaires'); exit;
        }

        $errors = [];
        $note   = (int)($_POST['note'] ?? 0);
        if ($note < 1 || $note > 5) { $errors[] = "La note doit être entre 1 et 5 étoiles."; }
        $texte = trim($_POST['commentaire'] ?? '');
        if (empty($texte) || strlen($texte) < 10) { $errors[] = "Le commentaire doit contenir au moins 10 caractères."; }
        if (strlen($texte) > 1000) { $errors[] = "Le commentaire ne peut pas dépasser 1000 caractères."; }

        if (empty($errors)) {
            $this->ModifierCommentaireTexte($id, $note, $texte);
            $_SESSION['success'] = "Votre commentaire a été modifié avec succès !";
        } else {
            $_SESSION['error'] = implode(' ', $errors);
        }
        header('Location: ' . BASE_URL . '/?page=recettes&action=detail&id=' . $recette_id . '#commentaires'); exit;
    }

    // ============================================================
    // INSTRUCTIONS PAR ÉTAPES (instruction_recette)
    // ============================================================

    /////..............................Récupérer Instructions d'une Recette............................../////
    function RecupererInstructionsRecette($recette_id) {
        $sql = "SELECT * FROM instruction_recette WHERE recette_id = :recette_id ORDER BY ordre ASC";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Ajouter une Instruction............................../////
    function AjouterInstruction($recette_id, $ordre, $titre, $description) {
        $sql = "INSERT INTO instruction_recette (recette_id, ordre, titre, description)
                VALUES (:recette_id, :ordre, :titre, :description)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'recette_id'  => $recette_id,
                'ordre'       => $ordre,
                'titre'       => $titre,
                'description' => $description,
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Modifier une Instruction............................../////
    function ModifierInstruction($id, $ordre, $titre, $description) {
        $sql = "UPDATE instruction_recette SET ordre=:ordre, titre=:titre, description=:description WHERE id=:id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['ordre'=>$ordre,'titre'=>$titre,'description'=>$description,'id'=>$id]);
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Supprimer une Instruction............................../////
    function SupprimerInstruction($id) {
        $sql = "DELETE FROM instruction_recette WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Supprimer toutes les Instructions d'une Recette............................../////
    function SupprimerInstructionsRecette($recette_id) {
        $sql = "DELETE FROM instruction_recette WHERE recette_id = :recette_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Sauvegarder les Instructions depuis POST............................../////
    function SauvegarderInstructionsPost($recette_id, $post) {
        $this->SupprimerInstructionsRecette($recette_id);
        if (!empty($post['inst_titre'])) {
            foreach ($post['inst_titre'] as $i => $titre) {
                $titre = trim($titre);
                $desc  = trim($post['inst_description'][$i] ?? '');
                $ordre = (int)($post['inst_ordre'][$i] ?? ($i + 1));
                if ($titre !== '' && $desc !== '') {
                    $this->AjouterInstruction($recette_id, $ordre, $titre, $desc);
                }
            }
        }
    }

    // ============================================================
    // MATÉRIELS (materiel + recette_materiel)
    // ============================================================

    /////..............................Afficher Matériels Acceptés............................../////
    function AfficherMaterielsAcceptes() {
        $sql = "SELECT * FROM materiel WHERE statut = 'accepte' ORDER BY nom ASC";
        $db  = Database::getConnexion();
        try { return $db->query($sql)->fetchAll(); }
        catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Afficher Tous les Matériels (Back)............................../////
    function AfficherTousMateriels() {
        $sql = "SELECT * FROM materiel ORDER BY created_at DESC";
        $db  = Database::getConnexion();
        try { return $db->query($sql)->fetchAll(); }
        catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Récupérer Matériels d'une Recette............................../////
    function RecupererMaterielsRecette($recette_id) {
        $sql = "SELECT m.* FROM materiel m
                INNER JOIN recette_materiel rm ON rm.materiel_id = m.id
                WHERE rm.recette_id = :recette_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Ajouter Matériel............................../////
    function AjouterMateriel(Materiel $m) {
        $sql = "INSERT INTO materiel (nom, description, propose_par, statut)
                VALUES (:nom, :description, :propose_par, :statut)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom'         => $m->getNom(),
                'description' => $m->getDescription(),
                'propose_par' => $m->getProposePar(),
                'statut'      => $m->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Modifier Statut Matériel............................../////
    function ModifierStatutMateriel($id, $statut, $motif_refus = null) {
        $sql = "UPDATE materiel SET statut = :statut, motif_refus = :motif WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['statut' => $statut, 'motif' => $motif_refus, 'id' => $id]);
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Supprimer Matériel............................../////
    function SupprimerMateriel($id) {
        $sql = "DELETE FROM materiel WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Supprimer Liens Matériels d'une Recette............................../////
    function SupprimerMaterielsRecette($recette_id) {
        $sql = "DELETE FROM recette_materiel WHERE recette_id = :recette_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':recette_id', $recette_id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    /////..............................Lier Matériels à une Recette (ids[])............................../////
    function LierMaterielsRecette($recette_id, array $materiel_ids) {
        $this->SupprimerMaterielsRecette($recette_id);
        if (empty($materiel_ids)) return;
        $sql = "INSERT IGNORE INTO recette_materiel (recette_id, materiel_id) VALUES (:recette_id, :materiel_id)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            foreach ($materiel_ids as $mid) {
                $mid = (int)$mid;
                if ($mid > 0) {
                    $query->execute(['recette_id' => $recette_id, 'materiel_id' => $mid]);
                }
            }
        } catch (Exception $e) { die('Erreur: ' . $e->getMessage()); }
    }

    // ============================================================
    // AJAX ENDPOINTS — Instructions
    // ============================================================

    /////..............................AJAX — Ajouter Instruction............................../////
    function instructionAdd() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Méthode invalide']); exit;
        }
        $recette_id = (int)($_POST['recette_id'] ?? 0);
        $titre      = trim($_POST['titre'] ?? '');
        $desc       = trim($_POST['description'] ?? '');
        $ordre      = (int)($_POST['ordre'] ?? 1);
        if (!$recette_id || empty($titre) || empty($desc)) {
            echo json_encode(['success' => false, 'error' => 'Champs manquants']); exit;
        }
        $id = $this->AjouterInstruction($recette_id, $ordre, $titre, $desc);
        echo json_encode(['success' => true, 'id' => $id]);
        exit;
    }

    /////..............................AJAX — Modifier Instruction............................../////
    function instructionEdit() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Méthode invalide']); exit;
        }
        $id    = (int)($_POST['id'] ?? 0);
        $titre = trim($_POST['titre'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        $ordre = (int)($_POST['ordre'] ?? 1);
        if (!$id || empty($titre) || empty($desc)) {
            echo json_encode(['success' => false, 'error' => 'Champs manquants']); exit;
        }
        $this->ModifierInstruction($id, $ordre, $titre, $desc);
        echo json_encode(['success' => true]);
        exit;
    }

    /////..............................AJAX — Supprimer Instruction............................../////
    function instructionDelete() {
        header('Content-Type: application/json');
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) { echo json_encode(['success' => false, 'error' => 'ID manquant']); exit; }
        $this->SupprimerInstruction($id);
        echo json_encode(['success' => true]);
        exit;
    }

    // ============================================================
    // AJAX ENDPOINTS — Matériels
    // ============================================================

    /////..............................AJAX — Proposer un Matériel (client)............................../////
    function proposeMateriel() {
        while (ob_get_level() > 0) ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Méthode invalide']); exit;
        }
        $nom        = trim($_POST['nom'] ?? '');
        $desc       = trim($_POST['description'] ?? '');
        $propose_par= trim($_POST['propose_par'] ?? 'Anonyme');
        if (empty($nom)) {
            echo json_encode(['success' => false, 'error' => 'Le nom est obligatoire']); exit;
        }
        try {
            $m  = new Materiel($nom, $desc, $propose_par, 'en_attente');
            $id = $this->AjouterMateriel($m);
            echo json_encode(['success' => true, 'id' => $id, 'nom' => $nom]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    /////..............................AJAX — Proposer un ingrédient (client)............................../////
    function proposeIngredient() {
        // Clear ALL output buffer levels (including the global one in index.php)
        // so any PHP notices/warnings won't corrupt the JSON response
        while (ob_get_level() > 0) ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Méthode invalide']); exit;
        }

        $nom   = trim($_POST['nom']         ?? '');
        $unite = trim($_POST['unite']        ?? 'g');
        $cal   = (float)($_POST['calories']  ?? 0);

        if (empty($nom)) {
            echo json_encode(['success' => false, 'error' => 'Le nom est obligatoire']); exit;
        }

        $db = Database::getConnexion();
        try {
            // Return existing ingredient instead of failing on duplicate
            $chk = $db->prepare("SELECT id, nom, unite FROM ingredient WHERE LOWER(TRIM(nom)) = LOWER(TRIM(:nom)) LIMIT 1");
            $chk->execute(['nom' => $nom]);
            $existing = $chk->fetch(PDO::FETCH_ASSOC);
            if ($existing) {
                echo json_encode(['success' => true, 'id' => (int)$existing['id'], 'nom' => $existing['nom'], 'unite' => $existing['unite']]);
                exit;
            }

            $stmt = $db->prepare(
                "INSERT INTO ingredient (nom, unite, calories_par_unite, is_local) VALUES (:nom, :unite, :cal, 0)"
            );
            $stmt->execute(['nom' => $nom, 'unite' => $unite, 'cal' => $cal]);
            $newId = (int)$db->lastInsertId();

            echo json_encode(['success' => true, 'id' => $newId, 'nom' => $nom, 'unite' => $unite]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    // ============================================================
    // BACKOFFICE — Matériels
    // ============================================================

    /////..............................BACKOFFICE — Liste Matériels............................../////
    function listMateriels() {
        $materiels = $this->AfficherTousMateriels();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/recettes/materiels.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Ajouter Matériel (admin)............................../////
    function addMaterielBack() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom  = trim($_POST['nom'] ?? '');
            $desc = trim($_POST['description'] ?? '');
            $errors = [];
            if (empty($nom))  { $errors[] = "Le nom du matériel est obligatoire."; }
            if (empty($desc)) { $errors[] = "La description du matériel est obligatoire."; }
            if (empty($errors)) {
                $m = new Materiel($nom, $desc, null, 'accepte');
                $this->AjouterMateriel($m);
                $_SESSION['success'] = "Matériel ajouté avec succès !";
            } else {
                $_SESSION['error'] = implode(' ', $errors);
            }
        }
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=materiels'); exit;
    }

    /////..............................BACKOFFICE — Accepter Matériel............................../////
    function acceptMateriel() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->ModifierStatutMateriel($id, 'accepte');
            $_SESSION['success'] = "Matériel approuvé et disponible pour sélection.";
        } else {
            $_SESSION['error'] = "Matériel introuvable.";
        }
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=materiels'); exit;
    }

    /////..............................BACKOFFICE — Refuser Matériel............................../////
    function refuseMateriel() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
        $motif = trim($_POST['motif_refus'] ?? '');
        if ($id > 0) {
            $this->ModifierStatutMateriel($id, 'refuse', $motif ?: null);
            $_SESSION['success'] = "Matériel refusé.";
        } else {
            $_SESSION['error'] = "Matériel introuvable.";
        }
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=materiels'); exit;
    }

    /////..............................BACKOFFICE — Supprimer Matériel............................../////
    function deleteMateriel() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $this->SupprimerMateriel($id);
            $_SESSION['success'] = "Matériel supprimé.";
        } else {
            $_SESSION['error'] = "Matériel introuvable.";
        }
        header('Location: ' . BASE_URL . '/?page=admin-recettes&action=materiels'); exit;
    }
}
?>
