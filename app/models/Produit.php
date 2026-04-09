<?php
/**
 * Modèle Produit — Gestion des produits du marketplace
 */
class Produit {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer tous les produits */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM produit ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer un produit par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produit WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Recherche et filtrage de produits */
    public function search($search = '', $categorie = '', $bio = '') {
        $sql = "SELECT * FROM produit WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (nom LIKE ? OR producteur LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        if (!empty($categorie)) {
            $sql .= " AND categorie = ?";
            $params[] = $categorie;
        }
        if ($bio !== '') {
            $sql .= " AND is_bio = ?";
            $params[] = (int)$bio;
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Récupérer les catégories distinctes */
    public function getCategories() {
        $stmt = $this->pdo->query("SELECT DISTINCT categorie FROM produit WHERE categorie IS NOT NULL ORDER BY categorie");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /** Créer un produit */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO produit (nom, description, prix, stock, categorie, image, producteur, is_bio) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['stock'],
            $data['categorie'],
            $data['image'],
            $data['producteur'],
            $data['is_bio']
        ]);
    }

    /** Mettre à jour un produit */
    public function update($id, $data) {
        $sql = "UPDATE produit SET nom=?, description=?, prix=?, stock=?, categorie=?, producteur=?, is_bio=?";
        $params = [
            $data['nom'], $data['description'], $data['prix'],
            $data['stock'], $data['categorie'], $data['producteur'], $data['is_bio']
        ];

        // Mettre à jour l'image seulement si une nouvelle est fournie
        if (!empty($data['image'])) {
            $sql .= ", image=?";
            $params[] = $data['image'];
        }

        $sql .= " WHERE id=?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /** Supprimer un produit */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM produit WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
