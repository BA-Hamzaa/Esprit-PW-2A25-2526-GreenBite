<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/Produit.php';
require_once BASE_PATH . '/app/models/Commande.php';

class MarketplaceController {

    /////..............................Afficher Produits (Front)............................../////
    function AfficherProduitsFront($search = '', $categorie = '', $bio = '') {
        $sql    = "SELECT * FROM produit WHERE 1=1";
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (nom LIKE :search1 OR description LIKE :search2)";
            $params['search1'] = '%' . $search . '%';
            $params['search2'] = '%' . $search . '%';
        }
        if (!empty($categorie)) {
            $sql .= " AND categorie = :categorie";
            $params['categorie'] = $categorie;
        }
        if ($bio === '1' || $bio === '0') {
            $sql .= " AND is_bio = :bio";
            $params['bio'] = $bio;
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

    /////..............................Afficher Catégories............................../////
    function AfficherCategories() {
        $sql = "SELECT DISTINCT categorie FROM produit WHERE categorie IS NOT NULL ORDER BY categorie";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher Produit par ID............................../////
    function RecupererProduit($id) {
        $sql = "SELECT * FROM produit WHERE id = :id";
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

    /////..............................Afficher tous les Produits (Back)............................../////
    function AfficherProduitsBack() {
        $sql = "SELECT * FROM produit ORDER BY created_at DESC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Produit............................../////
    function AjouterProduit(Produit $produit, $imageFile = null) {
        $imageName = '';
        if ($imageFile && $imageFile['error'] === 0) {
            $imageName = $this->uploadImage($imageFile);
            $produit->setImage($imageName);
        }

        $sql = "INSERT INTO produit (nom, description, prix, stock, categorie, image, producteur, is_bio)
                VALUES (:nom, :description, :prix, :stock, :categorie, :image, :producteur, :is_bio)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom'         => $produit->getNom(),
                'description' => $produit->getDescription(),
                'prix'        => $produit->getPrix(),
                'stock'       => $produit->getStock(),
                'categorie'   => $produit->getCategorie(),
                'image'       => $produit->getImage(),
                'producteur'  => $produit->getProducteur(),
                'is_bio'      => $produit->getIsBio(),
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Produit............................../////
    function ModifierProduit(Produit $produit, $id, $imageFile = null) {
        $imageName = $produit->getImage();
        if ($imageFile && $imageFile['error'] === 0) {
            $imageName = $this->uploadImage($imageFile);
        }

        $sql = "UPDATE produit SET
                    nom         = :nom,
                    description = :description,
                    prix        = :prix,
                    stock       = :stock,
                    categorie   = :categorie,
                    image       = :image,
                    producteur  = :producteur,
                    is_bio      = :is_bio
                WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom'         => $produit->getNom(),
                'description' => $produit->getDescription(),
                'prix'        => $produit->getPrix(),
                'stock'       => $produit->getStock(),
                'categorie'   => $produit->getCategorie(),
                'image'       => $imageName,
                'producteur'  => $produit->getProducteur(),
                'is_bio'      => $produit->getIsBio(),
                'id'          => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Produit............................../////
    function SupprimerProduit($id) {
        $sql = "DELETE FROM produit WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher toutes les Commandes (Back)............................../////
    function AfficherCommandes() {
        $sql = "SELECT * FROM commande ORDER BY created_at DESC";
        $db  = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer une Commande par ID............................../////
    function RecupererCommande($id) {
        $sql = "SELECT * FROM commande WHERE id = :id";
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

    /////..............................Récupérer Produits d'une Commande............................../////
    function RecupererProduitsCommande($commande_id) {
        $sql = "SELECT cp.quantite, cp.prix_unitaire, p.nom, p.categorie, p.image
                FROM commande_produit cp
                JOIN produit p ON cp.produit_id = p.id
                WHERE cp.commande_id = :commande_id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':commande_id', $commande_id);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Commande (avec coordonnées GPS)............................../////
    function AjouterCommande(Commande $commande) {
        $sql = "INSERT INTO commande (client_nom, client_email, client_adresse, latitude, longitude, total, statut)
                VALUES (:client_nom, :client_email, :client_adresse, :latitude, :longitude, :total, :statut)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'client_nom'     => $commande->getClientNom(),
                'client_email'   => $commande->getClientEmail(),
                'client_adresse' => $commande->getClientAdresse(),
                'latitude'       => $commande->getLatitude(),
                'longitude'      => $commande->getLongitude(),
                'total'          => $commande->getTotal(),
                'statut'         => $commande->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Ligne de Commande............................../////
    function AjouterLigneCommande($commande_id, $produit_id, $quantite, $prix_unitaire) {
        $sql = "INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_unitaire)
                VALUES (:commande_id, :produit_id, :quantite, :prix_unitaire)";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'commande_id'   => $commande_id,
                'produit_id'    => $produit_id,
                'quantite'      => $quantite,
                'prix_unitaire' => $prix_unitaire,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Mettre à jour Statut Commande............................../////
    function ModifierStatutCommande($id, $statut) {
        $sql = "UPDATE commande SET statut = :statut WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'statut' => $statut,
                'id'     => $id,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /////..............................Supprimer Commande............................../////
    function SupprimerCommande($id) {
        $sql = "DELETE FROM commande WHERE id = :id";
        $db  = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Validation Produit............................../////
    function ValiderProduit($post, $files, $isEdit = false) {
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
        if (!empty($files['image']['name'])) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext     = strtolower(pathinfo($files['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                $errors[] = "L'image doit être au format JPG, PNG ou GIF.";
            }
            if ($files['image']['size'] > 2 * 1024 * 1024) {
                $errors[] = "L'image ne doit pas dépasser 2 Mo.";
            }
        }
        return $errors;
    }

    /////..............................Validation Commande............................../////
    function ValiderCommande($post) {
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

    /////..............................Upload Image (méthode privée)............................../////
    private function uploadImage($imageFile) {
        $uploadDir    = BASE_PATH . '/app/views/public/assets/images/uploads/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize      = 2 * 1024 * 1024;

        if (!in_array($imageFile['type'], $allowedTypes)) {
            die('Erreur: Format image non supporté (jpg, png, gif, webp uniquement)');
        }
        if ($imageFile['size'] > $maxSize) {
            die('Erreur: Image trop lourde (max 2Mo)');
        }

        $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $imageName = uniqid('prod_', true) . '.' . $extension;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        if (!move_uploaded_file($imageFile['tmp_name'], $uploadDir . $imageName)) {
            die("Erreur: Échec de l'upload de l'image");
        }
        return $imageName;
    }

    /////..............................FRONTOFFICE — Afficher............................../////
    function listFront() {
        $search    = isset($_GET['search'])    ? trim($_GET['search'])    : '';
        $categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : '';
        $bio       = isset($_GET['bio'])       ? $_GET['bio']             : '';

        $produits   = $this->AfficherProduitsFront($search, $categorie, $bio);
        $categories = $this->AfficherCategories();

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/marketplace/list.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Détail Produit............................../////
    function detailFront() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $produit = $this->RecupererProduit($id);

        if (!$produit) {
            $_SESSION['error'] = "Produit introuvable.";
            header('Location: ' . BASE_URL . '/?page=marketplace');
            exit;
        }

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/marketplace/detail.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Ajouter au Panier............................../////
    function addToCart() {
        $id  = isset($_POST['produit_id']) ? (int)$_POST['produit_id'] : 0;
        $qty = isset($_POST['quantite'])   ? max(1, (int)$_POST['quantite']) : 1;
        if ($id > 0) {
            if (!isset($_SESSION['panier'])) $_SESSION['panier'] = [];
            if (isset($_SESSION['panier'][$id])) {
                $_SESSION['panier'][$id] += $qty;
            } else {
                $_SESSION['panier'][$id] = $qty;
            }
            $_SESSION['success'] = "Produit ajouté au panier !";
        }
        $redirect = $_POST['redirect'] ?? (BASE_URL . '/?page=marketplace');
        header('Location: ' . $redirect); exit;
    }

    /////..............................FRONTOFFICE — Retirer du Panier............................../////
    function removeFromCart() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (isset($_SESSION['panier'][$id])) {
            unset($_SESSION['panier'][$id]);
            $_SESSION['success'] = "Produit retiré du panier.";
        }
        header('Location: ' . BASE_URL . '/?page=marketplace&action=order'); exit;
    }

    /////..............................FRONTOFFICE — Mettre à jour quantité Panier............................../////
    function updateCart() {
        $id  = isset($_POST['produit_id']) ? (int)$_POST['produit_id'] : 0;
        $qty = isset($_POST['quantite'])   ? (int)$_POST['quantite']   : 0;
        if ($id > 0) {
            if ($qty <= 0) {
                unset($_SESSION['panier'][$id]);
                $_SESSION['success'] = "Produit retiré du panier.";
            } else {
                $_SESSION['panier'][$id] = $qty;
                $_SESSION['success'] = "Quantité mise à jour.";
            }
        }
        header('Location: ' . BASE_URL . '/?page=marketplace&action=order'); exit;
    }

    /////..............................FRONTOFFICE — Vider le Panier............................../////
    function clearCart() {
        unset($_SESSION['panier']);
        $_SESSION['success'] = "Panier vidé.";
        header('Location: ' . BASE_URL . '/?page=marketplace'); exit;
    }

    /////..............................FRONTOFFICE — Passer Commande (Stripe)............................../////
    function orderFront() {
        $errors     = [];
        $db         = Database::getConnexion();
        $produits   = $db->query("SELECT * FROM produit ORDER BY nom ASC")->fetchAll();

        // Build cart
        $panier    = $_SESSION['panier'] ?? [];
        $cartItems = [];
        $cartTotal = 0;
        foreach ($panier as $pid => $qty) {
            $p = $this->RecupererProduit($pid);
            if ($p) {
                $p['cart_qty'] = $qty;
                $p['subtotal'] = $p['prix'] * $qty;
                $cartTotal    += $p['subtotal'];
                $cartItems[]   = $p;
            }
        }
        $cartCount = array_sum($panier);

        // ---- Stripe payment confirmation (POST from JS) ----
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['stripe_payment_intent_id'])) {
            $piId = trim($_POST['stripe_payment_intent_id']);

            // Verify PaymentIntent status with Stripe
            $ch = curl_init('https://api.stripe.com/v1/payment_intents/' . urlencode($piId));
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . STRIPE_SECRET_KEY],
            ]);
            $stripeResp = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if (isset($stripeResp['status']) && $stripeResp['status'] === 'succeeded') {
                // Basic field validation
                $nom     = trim($_POST['client_nom']     ?? '');
                $email   = trim($_POST['client_email']   ?? '');
                $adresse = trim($_POST['client_adresse'] ?? '');
                $lat     = !empty($_POST['client_lat'])  ? (float)$_POST['client_lat']  : null;
                $lng     = !empty($_POST['client_lng'])  ? (float)$_POST['client_lng']  : null;
                if (empty($nom))                            $errors[] = 'Nom obligatoire.';
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
                if (strlen($adresse) < 5)                   $errors[] = 'Adresse invalide.';
                if (empty($cartItems))                      $errors[] = 'Panier vide.';

                if (empty($errors)) {
                    $lignes   = [];
                    $totalVal = 0;
                    foreach ($panier as $pid => $qty) {
                        $p = $this->RecupererProduit($pid);
                        if ($p && $qty > 0) {
                            $totalVal += $p['prix'] * $qty;
                            $lignes[] = ['produit_id' => $pid, 'quantite' => $qty, 'prix_unit' => $p['prix']];
                        }
                    }

                    $commande   = new Commande($nom, $email, $adresse, $totalVal, 'confirmee', $lat, $lng);
                    $commandeId = $this->AjouterCommande($commande);
                    foreach ($lignes as $l) {
                        $this->AjouterLigneCommande($commandeId, $l['produit_id'], $l['quantite'], $l['prix_unit']);
                    }

                    unset($_SESSION['panier']);
                    $_SESSION['order_success'] = [
                        'commande_id'      => $commandeId,
                        'total'            => $totalVal,
                        'client_nom'       => $nom,
                        'client_email'     => $email,
                        'payment_intent'   => $piId,
                        'items_count'      => count($lignes),
                    ];

                    header('Location: ' . BASE_URL . '/?page=marketplace&action=order-success');
                    exit;
                }
            } else {
                $errors[] = 'Paiement non vérifié. Veuillez réessayer.';
            }
        }

        $stripePublishableKey = STRIPE_PUBLISHABLE_KEY;
        $mapboxToken          = MAPBOX_TOKEN;

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/marketplace/order.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Confirmation Commande............................../////
    function orderSuccess() {
        if (empty($_SESSION['order_success'])) {
            header('Location: ' . BASE_URL . '/?page=marketplace');
            exit;
        }
        $orderData = $_SESSION['order_success'];
        unset($_SESSION['order_success']);

        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/frontoffice/marketplace/order_success.php';
        require_once BASE_PATH . '/app/views/frontoffice/layouts/front_footer.php';
    }

    /////..............................BACKOFFICE — Liste Produits............................../////
    function listBack() {
        $produits = $this->AfficherProduitsBack();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/marketplace/list.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Ajouter Produit............................../////
    function addBack() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderProduit($_POST, $_FILES);

            if (empty($errors)) {
                $produit = new Produit(
                    trim($_POST['nom']),
                    trim($_POST['description']),
                    (float)$_POST['prix'],
                    (int)$_POST['stock'],
                    trim($_POST['categorie']),
                    '',
                    trim($_POST['producteur']),
                    isset($_POST['is_bio']) ? 1 : 0
                );
                $this->AjouterProduit($produit, $_FILES['image'] ?? null);
                $_SESSION['success'] = "Produit ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/marketplace/add.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Modifier Produit............................../////
    function editBack() {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $produit = $this->RecupererProduit($id);

        if (!$produit) {
            $_SESSION['error'] = "Produit introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderProduit($_POST, $_FILES, true);

            if (empty($errors)) {
                $p = new Produit(
                    trim($_POST['nom']),
                    trim($_POST['description']),
                    (float)$_POST['prix'],
                    (int)$_POST['stock'],
                    trim($_POST['categorie']),
                    $produit['image'],
                    trim($_POST['producteur']),
                    isset($_POST['is_bio']) ? 1 : 0
                );
                $this->ModifierProduit($p, $id, $_FILES['image'] ?? null);
                $_SESSION['success'] = "Produit modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/marketplace/edit.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Supprimer Produit............................../////
    function deleteBack() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->SupprimerProduit($id);
        $_SESSION['success'] = "Produit supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=list');
        exit;
    }

    /////..............................BACKOFFICE — Liste Commandes............................../////
    function listCommandes() {
        $commandes = $this->AfficherCommandes();
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/marketplace/commandes.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Détail Commande............................../////
    function commandeDetail() {
        $id       = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $commande = $this->RecupererCommande($id);

        if (!$commande) {
            $_SESSION['error'] = "Commande introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=commandes');
            exit;
        }

        $produits = $this->RecupererProduitsCommande($id);

        require_once BASE_PATH . '/app/views/backoffice/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/backoffice/marketplace/commande_detail.php';
        require_once BASE_PATH . '/app/views/backoffice/layouts/back_footer.php';
    }

    /////..............................BACKOFFICE — Modifier Statut Commande............................../////
    function updateCommandeStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id             = (int)$_POST['id'];
            $statut         = $_POST['statut'];
            $statutsValides = ['en_attente', 'confirmee', 'livree', 'annulee'];
            if (in_array($statut, $statutsValides)) {
                $this->ModifierStatutCommande($id, $statut);
                $_SESSION['success'] = "Statut de la commande mis à jour !";
            }
        }
        header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=commandes');
        exit;
    }

    /////..............................BACKOFFICE — Supprimer Commande............................../////
    function deleteCommande() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->SupprimerCommande($id);
        $_SESSION['success'] = "Commande supprimée avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-marketplace&action=commandes');
        exit;
    }
}
?>
