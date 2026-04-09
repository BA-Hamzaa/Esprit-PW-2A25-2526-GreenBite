<?php
/**
 * Contrôleur Marketplace — Gestion des produits et commandes
 */
class MarketplaceController {
    private $produitModel;
    private $commandeModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->produitModel = new Produit($pdo);
        $this->commandeModel = new Commande($pdo);
    }

    // =============================================
    // FRONTOFFICE
    // =============================================

    /** Liste des produits avec recherche/filtre (Front) */
    public function listFront() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : '';
        $bio = isset($_GET['bio']) ? $_GET['bio'] : '';

        $produits = $this->produitModel->search($search, $categorie, $bio);
        $categories = $this->produitModel->getCategories();

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/marketplace/front_list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Détail d'un produit (Front) */
    public function detailFront() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $produit = $this->produitModel->getById($id);
        if (!$produit) {
            $_SESSION['error'] = "Produit introuvable.";
            header('Location: ' . BASE_URL . '/?page=marketplace');
            exit;
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/marketplace/front_detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /** Formulaire de commande (Front) */
    public function orderFront() {
        $errors = [];
        $produits = $this->produitModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateCommande($_POST);

            if (empty($errors)) {
                // Calculer le total
                $total = 0;
                $lignes = [];
                if (!empty($_POST['produit_ids'])) {
                    foreach ($_POST['produit_ids'] as $i => $produitId) {
                        $quantite = (int)$_POST['quantites'][$i];
                        if (!empty($produitId) && $quantite > 0) {
                            $produit = $this->produitModel->getById($produitId);
                            if ($produit) {
                                $total += $produit['prix'] * $quantite;
                                $lignes[] = [
                                    'produit_id' => $produitId,
                                    'quantite' => $quantite,
                                    'prix_unitaire' => $produit['prix']
                                ];
                            }
                        }
                    }
                }

                $data = [
                    'client_nom' => trim($_POST['client_nom']),
                    'client_email' => trim($_POST['client_email']),
                    'client_adresse' => trim($_POST['client_adresse']),
                    'total' => $total
                ];

                $commandeId = $this->commandeModel->create($data);

                // Ajouter les produits à la commande
                foreach ($lignes as $ligne) {
                    $this->commandeModel->addProduit(
                        $commandeId,
                        $ligne['produit_id'],
                        $ligne['quantite'],
                        $ligne['prix_unitaire']
                    );
                }

                $_SESSION['success'] = "Commande passée avec succès ! Numéro : #" . $commandeId;
                header('Location: ' . BASE_URL . '/?page=marketplace');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/marketplace/front_order.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    // =============================================
    // BACKOFFICE — PRODUITS
    // =============================================

    /** Liste de tous les produits (Back) */
    public function listBack() {
        $produits = $this->produitModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/marketplace/back_list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Ajout d'un produit (Back) */
    public function addBack() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateProduit($_POST, $_FILES);

            if (empty($errors)) {
                // Upload image
                $imageName = '';
                if (!empty($_FILES['image']['name'])) {
                    $imageName = $this->uploadImage($_FILES['image']);
                }

                $data = [
                    'nom' => trim($_POST['nom']),
                    'description' => trim($_POST['description']),
                    'prix' => (float)$_POST['prix'],
                    'stock' => (int)$_POST['stock'],
                    'categorie' => trim($_POST['categorie']),
                    'image' => $imageName,
                    'producteur' => trim($_POST['producteur']),
                    'is_bio' => isset($_POST['is_bio']) ? 1 : 0
                ];

                $this->produitModel->create($data);
                $_SESSION['success'] = "Produit ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/marketplace/back_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Édition d'un produit (Back) */
    public function editBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $produit = $this->produitModel->getById($id);
        if (!$produit) {
            $_SESSION['error'] = "Produit introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateProduit($_POST, $_FILES, true);

            if (empty($errors)) {
                $imageName = '';
                if (!empty($_FILES['image']['name'])) {
                    $imageName = $this->uploadImage($_FILES['image']);
                }

                $data = [
                    'nom' => trim($_POST['nom']),
                    'description' => trim($_POST['description']),
                    'prix' => (float)$_POST['prix'],
                    'stock' => (int)$_POST['stock'],
                    'categorie' => trim($_POST['categorie']),
                    'image' => $imageName,
                    'producteur' => trim($_POST['producteur']),
                    'is_bio' => isset($_POST['is_bio']) ? 1 : 0
                ];

                $this->produitModel->update($id, $data);
                $_SESSION['success'] = "Produit modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/marketplace/back_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Suppression d'un produit (Back) */
    public function deleteBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->produitModel->delete($id);
        $_SESSION['success'] = "Produit supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
        exit;
    }

    // =============================================
    // BACKOFFICE — COMMANDES
    // =============================================

    /** Liste des commandes (Back) */
    public function listCommandes() {
        $commandes = $this->commandeModel->getAll();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/marketplace/back_commandes.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Détail d'une commande (Back) */
    public function commandeDetail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $commande = $this->commandeModel->getById($id);
        if (!$commande) {
            $_SESSION['error'] = "Commande introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=commandes');
            exit;
        }
        $produits = $this->commandeModel->getProduits($id);
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/marketplace/back_commande_detail.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    /** Mise à jour du statut d'une commande (Back) */
    public function updateCommandeStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $statut = $_POST['statut'];
            $statutsValides = ['en_attente', 'confirmee', 'livree', 'annulee'];
            if (in_array($statut, $statutsValides)) {
                $this->commandeModel->updateStatut($id, $statut);
                $_SESSION['success'] = "Statut de la commande mis à jour !";
            }
        }
        header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=commandes');
        exit;
    }

    /** Suppression d'une commande (Back) */
    public function deleteCommande() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->commandeModel->delete($id);
        $_SESSION['success'] = "Commande supprimée avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=commandes');
        exit;
    }

    // =============================================
    // VALIDATION
    // =============================================

    /** Validation du formulaire produit */
    private function validateProduit($post, $files, $isEdit = false) {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du produit est obligatoire.";
        }
        if (!isset($post['prix']) || !is_numeric($post['prix']) || (float)$post['prix'] <= 0) {
            $errors[] = "Le prix doit être un nombre positif.";
        }
        if (!isset($post['stock']) || !is_numeric($post['stock']) || (int)$post['stock'] < 0) {
            $errors[] = "Le stock doit être un nombre positif ou zéro.";
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

    /** Validation du formulaire commande */
    private function validateCommande($post) {
        $errors = [];
        if (empty(trim($post['client_nom'] ?? ''))) {
            $errors[] = "Le nom du client est obligatoire.";
        }
        $email = trim($post['client_email'] ?? '');
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'email est invalide.";
        }
        $adresse = trim($post['client_adresse'] ?? '');
        if (empty($adresse) || strlen($adresse) < 10) {
            $errors[] = "L'adresse doit contenir au moins 10 caractères.";
        }
        // Vérifier qu'au moins un produit est sélectionné
        $hasProduct = false;
        if (!empty($post['produit_ids'])) {
            foreach ($post['produit_ids'] as $i => $pid) {
                if (!empty($pid) && isset($post['quantites'][$i]) && (int)$post['quantites'][$i] > 0) {
                    $hasProduct = true;
                    break;
                }
            }
        }
        if (!$hasProduct) {
            $errors[] = "Vous devez sélectionner au moins un produit avec une quantité.";
        }
        return $errors;
    }

    /** Upload d'image vers public/assets/images/uploads/ */
    private function uploadImage($file) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid('prod_') . '.' . $ext;
        $dest = BASE_PATH . '/public/assets/images/uploads/' . $filename;
        move_uploaded_file($file['tmp_name'], $dest);
        return $filename;
    }
}
